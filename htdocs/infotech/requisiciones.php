<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

$link=validar("","","", 71);

formularioactual();

switch($_POST[ejecut]){
case "Nuevo":
$boton=1;
$_SESSION[i]=$_SESSION[numreg];
break;
case "Ingresar":
$ds4=0;$como=2;

$sqlu="SELECT idreq FROM requisiciones WHERE requisiciones.idusuarioreq='$_SESSION[idusuario]' ORDER BY idreq DESC LIMIT 1";
$res=@mysql_query($sqlu) or $error.=" 22 - ".@mysql_error();
$res=@mysql_query($sqlu) or $error.=" 22 - ".@mysql_error();
$ds=@mysql_result($res, 0, "idreq")+1;

$sqlu="SELECT serialrequisicion FROM requisiciones ORDER BY serialrequisicion DESC LIMIT 1";
$res=@mysql_query($sqlu) or $error.=" 22 - ".@mysql_error();
$numnuevareq=@mysql_result($res, 0, "serialrequisicion")+1;


while (list($name, $value) = each($_POST)) {

$matidsn=explode("idprodn-", $name);
$matidsu=explode("idprodu-", $name);

if($matidsn[1]!=""){//id de producto entregado nuevo
//el producto entergado es nuevo
$pent="n";//productos entregados
$tiponou=1;//tipo nuevo o usado
$idpro=$matidsn[1];
}else if($matidsu[1]!=""){
//el producto ingresado es usado
$pent="u";
$tiponou=2;//tipo nuevo o usado
$idpro=$matidsu[1];
}else{
$pent="";
$tiponou=0;//tipo nuevo o usado
$idpro=0;
}

if($pent=="u" || $pent=="n"){
    $var="idprod$pent-".$idpro;
    $entregado=$_POST[$var];

    $vec['idproducto']=$idpro;
    $vec['nuevousado']=$tiponou;

    $saldo=consultarsaldo($vec, $link);
    if($entregado>0){
        //consultar si el producto es de tipo consumible para ponerle el pazysalvo de una vez
        $sqlconsu="SELECT tipoprod FROM productos WHERE id='$idpro' LIMIT 1";
        $conscon=@mysql_query($sqlconsu, $link);

        
        
        if(@mysql_result($conscon, 0, "tipoprod")==2){//es consumible
        $pyzcons=1;
        }else{
        $pyzcons=0;
        }

        $sqlin="INSERT INTO requisiciones (serialrequisicion, idreq, idusuarioreq, cantidad, nou, idprod, fechareq, observaciones) VALUES
        ($numnuevareq, $ds, '$_SESSION[idusuario]', '$entregado', '$tiponou', $idpro, NOW(), '$_POST[observaciones]')";

        @mysql_query($sqlin) or $error.=" 110 - ".@mysql_error();

    }
    
}
}
break;
}

if(isset($_SESSION[cedulamod]) && $_SESSION[cedulamod]!=""){
$g=$_SESSION[id][$dp45];
$sqlar="SELECT * FROM requisiciones WHERE requisiciones.cedulareq='$_SESSION[cedulamod]' AND requisiciones.iddot=$g";
$consul=@mysql_query($sqlar, $link) or $error0=" 160 - ".@mysql_error();
if($error0!="" && $_POST[ejecut]=="buscar"){
    $error.="No hay Requisiciones Generadas";
    $habsinc=false;
    }else{
    $habsinc=true;
    }
}

		$sql1="SELECT * FROM productos ORDER BY nombreprod ";
		$cons=@mysql_query($sql1) or $error.=" 153 - ".@mysql_error();
		$ini=0;
		$limi=@mysql_num_rows($cons);
		$r=@require('version.php');
		caracteresiso();

$coltabla="#67d111"
?>
<link rel="stylesheet" href="estilo2.css" type="text/css"/>
<link rel="stylesheet" href="botones.css" type="text/css"/>
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

<!-- GC -->
<!-- LIBS -->
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->

<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/busquedaAjaxReq.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />

<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<script type="text/javascript">
                var boolvalidar=false;  //validacion de datos
                function cerrarDiv(idiv){
                Ext.get('eliminar-div-'+idiv).remove();
                }
</script>
</head>
<body<?php if($error!=""){echo " onload=\"mensajeini('".addslashes($error)."');return false;\"";}?>>
		<form  action="requisiciones.php" method="post" id="formrequisiciones">
                <table class="tablaprinc" ><tr><td>
		<table>
                    <tr><td colspan="4" align="right"><?php echo $cadenapaciente;?></td></tr>
                    <tr><td colspan="4" align="right"><?php if($_POST[ejecut]!="Nuevo" && $habsinc){echo "<br/><div id=\"grid-example\" style=\"z-index:10\"></div><br/>";}?></td></tr>
		<tr>
	  		<td align="center" width="160" valign="top">
	  		</td>
	 		<td align="right" width="300" id="filaproductos">
	 		<?php
                        if($_POST[ejecut]!="Nuevo"){

                        $imatrizidpys=0;
	 		$indicematrices=0;//para pasar a js

	 		while($limi>$ini){
	 		if(@mysql_result($cons,$ini,"nombreprod")!=""){
	 		$idproduct=@mysql_result($cons,$ini,"id");
                        $consumibleproduct=@mysql_result($cons,$ini,"tipoprod");

                        $etiqprod=substr("<b>".@mysql_result($cons,$ini,"nombreprod")."</b> ".@mysql_result($cons,$ini,"referencia")." ".@mysql_result($cons,$ini,"modelo")." ".
                        @mysql_result($cons,$ini,"marca"), 0, 45);

                        $vecn['idproducto']=$idproduct;
                        $vecn['nuevousado']=1;

                        $vecu['idproducto']=$idproduct;
                        $vecu['nuevousado']=2;

                        $saldon=consultarsaldo($vecn, $link);//saldo producto nuevo
                        $saldou=consultarsaldo($vecu, $link);//saldo producto nuevo

                        //consulta de cantidad y estado de producto nuevo para esta persona
                        $sqlnuevo="SELECT cantidad, id, pazysalvo, cantidadevuelta FROM requisiciones WHERE iddot='$g' AND idprod='$idproduct' AND cedulareq='$_SESSION[cedulamod]' AND nou='1' LIMIT 1";
                        //consulta de cantidad y estado de producto nuevo para esta persona
                        $sqlusado="SELECT cantidad, id, pazysalvo, cantidadevuelta FROM requisiciones WHERE iddot='$g' AND idprod='$idproduct' AND cedulareq='$_SESSION[cedulamod]' AND nou='2' LIMIT 1";

                        $consultanuevo=@mysql_query($sqlnuevo) or $error.=@mysql_error();
                        $consultausado=@mysql_query($sqlusado) or $error.=@mysql_error();

                        $cantprodnuevo=@mysql_result($consultanuevo, 0, "cantidad");
                        $cantprodnuevodevuelto=@mysql_result($consultanuevo, 0, "cantidadevuelta");

                        $cantprodusado=@mysql_result($consultausado, 0, "cantidad");
                        $cantprodusadodevuelto=@mysql_result($consultausado, 0, "cantidadevuelta");

                        if($cantprodnuevo > 0 || $cantprodusado > 0 || $boton==1){

                            $id_regtabladotanuevo=@mysql_result($consultanuevo, 0, "id");
                            $id_regtabladotausado=@mysql_result($consultausado, 0, "id");

                            $pasyznuevo=@mysql_result($consultanuevo, 0, "pazysalvo");
                            $pasyzusado=@mysql_result($consultausado, 0, "pazysalvo");

                            if($pasyznuevo==1 && $pasyzusado==1){$pys="selected=\"selected\"";}

                            if($consumibleproduct==2){
                            $complecons="";
                            $competi="Consumible";
                            }else{
                                $complecons="Estado:<select disabled=\"disabled\"><option>No Devuelto</option><option $pys>a Paz y Salvo</option></select>";
                                $competi="No Consumible";
                                }
                                //die($complecons);
                            //nombre del producto
                            echo "<div id=\"etiqprod-$idproduct\">".$etiqprod."</div>";
                            echo "<div class=\"ocultar\">Disp. Nuevo:$saldon, Disp. Usado:$saldou, $competi<br/>\n";//saldo nuevo y usado actual
                            //cantidades de productos entregadas en requisiciones
                            echo "Nuevo:<input class=\"ocultar0\" name=\"idprodn-$idproduct\" id=\"idprodn-$idproduct\" value=\"$cantprodnuevo\"/>
                            &nbsp;Usado:<input class=\"ocultar0\" name=\"idprodu-$idproduct\" id=\"idprodu-$idproduct\" value=\"$cantprodusado\"/>\n</div>";
                            //cantidades de productos devueltas o para devolver
                            echo "<div class=\"mostrar\">
                            Devolver Nuevo:
                            <input type=\"text\" class=\"ocultar0\" name=\"idprodevn-$id_regtabladotanuevo\" id=\"idprodevn-$id_regtabladotanuevo\" value=\"$cantprodnuevodevuelto\" onchange=\"validarcontrol(this);\"/>&nbsp;
                            <input type=\"checkbox\" name=\"checkingn-$id_regtabladotanuevo\" onclick=\"deshabnoudev('noudevn-$id_regtabladotanuevo', this);\"/>Reingresar
                            <select disabled=\"disabled\" name=\"noudevn-$id_regtabladotanuevo\" id=\"noudevn-$id_regtabladotanuevo\">
                            <option value=\"2\">Usado</option><option value=\"1\">Nuevo</option></select><br/>
                            Devolver Usado:
                            <input type=\"text\" class=\"ocultar0\" name=\"idprodevu-$id_regtabladotausado\" id=\"idprodevu-$id_regtabladotausado\" value=\"$cantprodusadodevuelto\" onchange=\"validarcontrol(this);\" />&nbsp;
                            <input type=\"checkbox\" name=\"checkingu-$id_regtabladotausado\" onclick=\"deshabnoudev('noudevu-$id_regtabladotausado', this);\" />Reingresar
                            <select disabled=\"disabled\" name=\"noudevu-$id_regtabladotausado\" id=\"noudevu-$id_regtabladotausado\">
                            <option value=\"2\">Usado</option><option value=\"1\">Nuevo</option></select>$complecons</div><hr/>";

                            $js_idprods[$indicematrices]=$idproduct;                            //ids de productos
                            $js_regtabladotanuevo[$indicematrices]=$id_regtabladotanuevo;       //ids de registros tabla requisiciones
                            $js_regtabladotausado[$indicematrices]=$id_regtabladotausado;       //ids de registros tabla requisiciones
                            $js_prodnuevoexis[$indicematrices]=$saldon;                         //unidades de prod nuevo devuelto
                            $js_produsadoexis[$indicematrices]=$saldou;                         //unidades de prod usado devuelto
                            $js_cantprodnuevo[$indicematrices]=$cantprodnuevo;                  //unidades de prod nuevo entregado
                            $js_cantprodusado[$indicematrices]=$cantprodusado;                  //unidades de prod usado entregado
                            $js_cantprodnuevodevuelto[$indicematrices]=$cantprodnuevodevuelto;  //unidades de prod nuevo devuelto
                            $js_cantprodusadodevuelto[$indicematrices]=$cantprodusadodevuelto;  //unidades de prod usado devuelto


                            $indicematrices++;
                            }
                        }

                        $ini++;
                        }
                        }else{
                        echo "
                        <div style=\"width:500px;\">
                            <div class=\"x-box-tl\"><div class=\"x-box-tr\"><div class=\"x-box-tc\"></div></div></div>
                            <div class=\"x-box-ml\"><div class=\"x-box-mr\"><div class=\"x-box-mc\">
                                <h3 style=\"margin-bottom:5px;\">Agregar Productos</h3>
                                <input type=\"text\" name=\"search\" id=\"search\" autocomplete=\"off\"/>
                                <div style=\"padding-top:4px;\">
                                    mínimo 4 caracteres.
                                </div>
                            </div></div></div>
                            <div class=\"x-box-bl\"><div class=\"x-box-br\"><div class=\"x-box-bc\"></div></div></div>
                        </div>
                        ";
                        }
	 		?>
	 		</td>
	 		<td align="right" width="100">
	 		Observaciones
                        </td><td><textarea type="text" name="observaciones" cols="25" rows="10"><?php
			  //$sqlo="SELECT * FROM requisiciones WHERE requisiciones.iddot=$g and requisiciones.cedulareq='$_SESSION[cedulamod]'";
			  //$consul=@mysql_query($sqlo) or $error.=" 227 - ".@mysql_error();
			  $obser=@mysql_result($consul,0,"observaciones");
			  if ($obser!=""){ echo @mysql_result($consul,0,"observaciones");}
			 ?></textarea>
	 		</td>
		</tr>

  		<tr><td></td><td id="filaproductosentregar"></td>
     		<td align="right" colspan="2">
  			</td>
		</tr>
 			</table>
 </td></tr></table><br/>

                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Requisiciones de Compras
     		</td>
     		</tr>
     		<tr valign="top"><td valign="middle">
 			</td></tr>
			<tr><td colspan="2" align="center">
			</td></tr>
			<tr><td colspan="2" align="center">
			</td></tr>
			<tr><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="actualizar" id="btactualizar" name="ejecut" style="display:none"/>
			</td></tr>
			<tr><td colspan="2" align="center" class="arriba">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut"/>
			<input type="submit" class="botoing" value="Ingresar"<?php if($boton==0){echo "disabled";}?> name="ejecut" id="ingresar"/>
			</td></tr>
			<tr style="height:30px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Dotaci&oacute;n $p de $_SESSION[numreg]";} ?>
			</td></tr>
			</table>
     			<div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
     		</div>
                </form>
		<?php
		echo $mensaje;
		?>
<script type="text/javascript">

<?php
        echo "
            var idprods=null;
            var prodnuevoexis=null;
            var produsadoexis=null;
        ";
?>
</script>
</body>
</html>
