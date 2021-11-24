<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

$link=validar("","","", 16);

formularioactual();

switch($_POST[ejecut]){
case "Buscar":

$_SESSION['id']="";
$_SESSION['numreg']="";
$_SESSION['cedulamod']=$_POST['cedpersona'];
$_SESSION['i']=0;
$sql1="SELECT iddot, id FROM dotacion WHERE dotacion.ceduladot='$_SESSION[cedulamod]' ORDER BY iddot";
$consq=@mysql_query($sql1) or $error.=" 23 - ".@mysql_error();
$d=2;
$icont=0;
$l=@mysql_num_rows($consq);

	if(@mysql_result($consq,0,"iddot")!=""){$d=1;$_SESSION['id']['1']=@mysql_result($consq,0,"iddot");}
	while($icont<$l){
            if(@mysql_result($consq,$icont,"iddot")==@mysql_result($consq,$icont-1,"iddot")){}else{$_SESSION['id'][$d]=@mysql_result($consq,$icont,"iddot");$d++;
            $_SESSION['numreg']=$d-1;}
            $icont++;
        }

$dp45=1;
$_SESSION[dp]=$dp45;
$sql2="SELECT * FROM dotacion WHERE dotacion.iddot='".$_SESSION['id'][$dp45]."' AND dotacion.ceduladot='$_SESSION[cedulamod]'";
$cons1=@mysql_query($sql2) or $error.=" 38 - ".@mysql_error();
break;
case ">>":
if($_SESSION[i]<$_SESSION[numreg]-1){
$_SESSION[dp]+=1;
$_SESSION[i]++;}
$dp45=$_SESSION[dp];
break;
case "<<":
if($_SESSION[i]>0){
$_SESSION[dp]-=1;
$_SESSION[i]--;}
$dp45=$_SESSION[dp];
break;
case "||<":
$_SESSION[dp]=1;
$dp45=$_SESSION[dp];
$_SESSION[i]=0;
break;
case ">||":
$_SESSION[dp]=$_SESSION[numreg];
$dp45=$_SESSION[dp];
$_SESSION[i]=$_SESSION[numreg]-1;
break;
case "Nuevo":
$_SESSION[cedulamod]=$_POST['cedpersona'];
if($_SESSION[cedulamod]!=""){$boton=1;}
$_SESSION[i]=$_SESSION[numreg];
break;
case "Ingresar":
if($_POST[dotocom]=="comprobante"){
$sq="SELECT compsal FROM dotacion ORDER BY compsal DESC LIMIT 1";
$rs=@mysql_query($sq) or $error.=" 70 - ".@mysql_error();
$do3tar=@mysql_fetch_array($rs);
$ds4=$do3tar[0]+1;
$como=1;
}else{$ds4=0;$como=2;}

$sqlu="SELECT iddot FROM dotacion ORDER BY iddot DESC LIMIT 1";
$res=@mysql_query($sqlu) or $error.=" 77 - ".@mysql_error();
$ds=@mysql_result($res,0,'iddot')+1;

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
    if($entregado<=$saldo && $entregado>0){
        //consultar si el producto es de tipo consumible para ponerle el pazysalvo de una vez
        $sqlconsu="SELECT tipoprod FROM productos WHERE id='$idpro' LIMIT 1";
        $conscon=@mysql_query($sqlconsu, $link);

        if(@mysql_result($conscon, 0, "tipoprod")==2){//es consumible
        $pyzcons=1;
        }else{
        $pyzcons=0;
        }

        $sqlin="INSERT INTO dotacion (iddot, ceduladot, cantidad, nou, idprod, fechaent, usuaent, compsal, comodot, observaciones, pazysalvo) VALUES
        ($ds, '$_SESSION[cedulamod]', '$entregado', '$tiponou', $idpro, NOW(), '$_SESSION[persona]', $ds4, $como, '$_POST[observaciones]', $pyzcons)";

        $sqlin2="INSERT INTO movproductos (idprod, fecha, cantidad, nou, facturaoreq, eos, sucursal) VALUES
        ('$idpro', NOW(), '$entregado', '$tiponou', '$_SESSION[cedulamod]', 2,'$_SESSION[sucur]')";

        //die($sqlin." ".$sqlin2);
        @mysql_query($sqlin) or $error.=" 110 - ".@mysql_error();
        @mysql_query($sqlin2) or $error.=" 111 - ".@mysql_error();

    }else if($entregado>0){//consultar los datos del producto del cual no hay existencia y mostrar el error
        $sqlnpro="SELECT * FROM `productos` WHERE `productos`.`id`='$idpro' LIMIT 1";
        $connpro=@mysql_query($sqlnpro);
        $nombpro="<b>".@mysql_result($connpro,0,"nombreprod")."</b> Ref:".@mysql_result($connpro,0,"referencia")." Mod:".@mysql_result($connpro,0,"modelo")." Marca:".@mysql_result($connpro,0,"marca");
        if($pent=="n"){$errnoup="Nuevo";}else{$errnoup="Usado";}
        $error.= "<div style='line-height:20px'>No hay suficiente inventario de: $nombpro Estado:$errnoup </div>";
    }
}
}
break;
case "Actualizar":

while (list($name, $value) = each($_POST)) {

$matidsn=explode("idprodevn-", $name);
$matidsu=explode("idprodevu-", $name);

if($matidsn[1]!=""){//es producto nuevo
$matids[1]=$matidsn[1];
$var="idprodevn-".$matids[1];
$nou=$_POST["noudevn-".$matids[1]];
$varp="checkingn-".$matids[1];
$reingresar=$_POST[$varp];
}else if($matidsu[1]!=""){//es producto usado
$matids[1]=$matidsu[1];
$var="idprodevu-".$matids[1];
$nou=$_POST["noudevu-".$matids[1]];
$varp="checkingu-".$matids[1];
$reingresar=$_POST[$varp];
}else{
$matids[1]="";
}
    if($matids[1]!=""){//solo variables asignadas

    $devuelto=$_POST[$var];

    if($devuelto>0){

    $cons="SELECT * FROM dotacion WHERE id='$matids[1]' LIMIT 1";
    $res=@mysql_query($cons);
    $entregado=@mysql_result($res, 0, "cantidad");
    $devueltoant=@mysql_result($res, 0, "cantidadevuelta");

        if($devuelto <= $entregado && $devuelto >= $devueltoant){   //verificar que el valor este en el rango legal

            if($devuelto==$entregado){                              //verificacion de paz y salvo
            $sqld="UPDATE dotacion SET cantidadevuelta='$devuelto', usuarec='$_SESSION[persona]', pazysalvo=1, fechadev = NOW() WHERE id='$matids[1]'";
            }else{//actualizar unicamente la cantidad de productos
            $sqld="UPDATE dotacion SET cantidadevuelta=$devuelto, fechadev = NOW() WHERE id=$matids[1]";
            }
            //generar registro de reingreso de dotacion con unidades establecidas

            if(($devuelto-$devueltoant) > 0 && $reingresar=="on"){
            $cons2="SELECT * FROM dotacion, productos WHERE dotacion.idprod=productos.id AND dotacion.id='$matids[1]'";
            $rescons2=@mysql_query($cons2) or $error.=@mysql_error();
            $idpro=@mysql_result($rescons2, 0, "idprod");
            $cantidad=$devuelto-$devueltoant;
            $facturaoreq=@mysql_result($rescons2, 0, "ceduladot");

            $sql="INSERT INTO movproductos (idprod, cantidad, fecha, facturaoreq, nou, eos, observacionesreg, sucursal)".
            " VALUES ($idpro, $cantidad, NOW(), '$facturaoreq', $nou, 1,  'dotacion reingresada', $_SESSION[sucur])";
            //
            @mysql_query($sql) or $error.=@mysql_error();
            }
            @mysql_query($sqld) or $error.=@mysql_error();
        }
    }
    }
}
break;
}

if(isset($_SESSION[cedulamod]) && $_SESSION[cedulamod]!=""){
$g=$_SESSION[id][$dp45];
$sqlar="SELECT * FROM dotacion WHERE dotacion.ceduladot='$_SESSION[cedulamod]' AND dotacion.iddot=$g";
$consul=@mysql_query($sqlar, $link) or $error0=" 160 - ".@mysql_error();
if($error0!="" && $_POST[ejecut]=="Buscar"){
    $error.="No hay Registros de dotaciones entregadas";
    $habsinc=false;
    }else{
    $habsinc=true;
    }
}

if($_POST[pactivo]==""){
 $pactivon=1;
}else{
 $pactivon=$_POST[pactivo];
}

$mostra[1]="codigo";
$mostra[2]="nombrecliente";
$otras="AND `clientes`.`activo`='$pactivon' AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("clientes","codigo","%",$mostra,$_SESSION[cedulamod], 3, "codigo",$otras);

$resultdartospac=@mysql_query("select codigo, nombrecliente, activo from clientes where codigo='$_SESSION[cedulamod]'");

if(@mysql_result($resultdartospac, 0, activo)=="1"){
$estadopac="clientes3.php";
}else{
$estadopac="clienteret.php";
}

$cadenapaciente="<a href='$estadopac?ejecut=Buscar&amp;criterio=".@mysql_result($resultdartospac, 0, "codigo")."&amp;campobusqueda=codigo&amp;opt=2' target='_blank'>".@mysql_result($resultdartospac, 0, "codigo")." ".@mysql_result($resultdartospac, 0, "nombrecliente")."</a>";

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
<script	language="javascript" type="text/javascript" src="scripts/validacion.js"></script>
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/busquedaAjax.js"></script>
<script type="text/javascript" src="ext/examples/form/funcionesDotacion.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />

<!-- Common Styles for the examples -->
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<style type="text/css">
p { width:300px; }
</style>
<script type="text/javascript">
                var boolvalidar=false;  //validacion de datos
                var mododevolver=true;

</script>
</head>
<body<?php if($error!=""){echo " onload=\"mensajeini('".addslashes($error)."');return false;\"";}?>>
		<form  action="<?php echo $PHP_SELF?>" method="post" id="formdotacion">
                <table class="tablaprinc" ><tr><td>
		<table cellpadding="0" border="0" align="center">
                    <tr><td colspan="4" align="right"><?php echo $cadenapaciente;?></td></tr>
                    <tr><td colspan="4" align="right"><?php if($_POST[ejecut]!="Nuevo" && $habsinc){echo "<br/><div id=\"grid-example\" style=\"z-index:10\"></div><br/>";}?></td></tr>
		<tr>
	  		<td align="center" width="160" valign="top">
	  		Paz y Salvo Dotaci&oacute;n
	  		<input type="checkbox" name="verifica" id="verifica" <?php
	 		if(verificarpys($g, $_SESSION[cedulamod], $link)){echo " checked=\"checked\"";}?> disabled="disabled"/>
	 		<br/><br/><br/>
	 		<select name="dotocom" style="width:150px;height:22px">
    			<option value="dotacion" <?php
	 			if(@mysql_result($consul,0,comodot)==2){echo "selected";}
    			?>>Dotacion personal</option>
    			<option value="comprobante"<?php
	 			if(@mysql_result($consul,0,comodot)==1){echo "selected";}
    			?>>Comprobante salida</option>
    		</select><br/><?php
                if($_POST[ejecut]!="Nuevo" && $habsinc){
                    echo "<a id=\"adevoluciones\" href=\"#\">Habilitar Devoluci&oacute;n</a>";
                }else{
                    echo "<a id=\"adevoluciones\"></a>";
                }
                ?>
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
                        $sqlnuevo="SELECT cantidad, id, pazysalvo, cantidadevuelta FROM dotacion WHERE iddot='$g' AND idprod='$idproduct' AND ceduladot='$_SESSION[cedulamod]' AND nou='1' LIMIT 1";
                        //consulta de cantidad y estado de producto nuevo para esta persona
                        $sqlusado="SELECT cantidad, id, pazysalvo, cantidadevuelta FROM dotacion WHERE iddot='$g' AND idprod='$idproduct' AND ceduladot='$_SESSION[cedulamod]' AND nou='2' LIMIT 1";

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
                            //cantidades de productos entregadas en dotacion
                            echo "Nuevo:<input class=\"ocultar0\" name=\"idprodn-$idproduct\" id=\"idprodn-$idproduct\" value=\"$cantprodnuevo\" onblur=\"verificarEntrega(this);\"/>
                            &nbsp;Usado:<input class=\"ocultar0\" name=\"idprodu-$idproduct\" id=\"idprodu-$idproduct\" value=\"$cantprodusado\" onblur=\"verificarEntrega(this);\"/>\n</div>";
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
                            $js_regtabladotanuevo[$indicematrices]=$id_regtabladotanuevo;       //ids de registros tabla dotacion
                            $js_regtabladotausado[$indicematrices]=$id_regtabladotausado;       //ids de registros tabla dotacion
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
                        <div style=\"width:300px;\">
                            <div class=\"x-box-tl\"><div class=\"x-box-tr\"><div class=\"x-box-tc\"></div></div></div>
                            <div class=\"x-box-ml\"><div class=\"x-box-mr\"><div class=\"x-box-mc\">
                                <h3 style=\"margin-bottom:5px;\">Agregar Productos</h3>
                                <input type=\"text\" name=\"search\" id=\"search\" style=\"width:10px\"  autocomplete=\"off\"/>
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
                        </td><td><textarea cols="16" rows="10" name="observaciones"><?php
			  //$sqlo="SELECT * FROM dotacion WHERE dotacion.iddot=$g and dotacion.ceduladot='$_SESSION[cedulamod]'";
			  //$consul=@mysql_query($sqlo) or $error.=" 227 - ".@mysql_error();
			  $obser=@mysql_result($consul,0,"observaciones");
			  if ($obser!=""){ echo @mysql_result($consul,0,"observaciones");}
			 ?></textarea>
	 		</td>
		</tr>

  		<tr><td></td><td id="filaproductosentregar"></td>
     		<td align="right" colspan="2">
  			<br/>Entrega<input class="largo" style="background-color:#DBDBDB" tabindex="21" readonly size="31"
			  value="<?php
			  //$sqlo="SELECT * FROM dotacion WHERE dotacion.iddot=$g and dotacion.ceduladot='$_SESSION[cedulamod]' ";
			  //$consul=@mysql_query($sqlo) or $error.=" 240 - ".@mysql_error();
			  $fechaent=@mysql_result($consul,0,fechaent);
			  if ($fechaent==""){
			  echo "";}else{ echo @mysql_result($consul,0,"fechaent");}
			 ?>" name="fechaentrega"/>
			 <br/>
			 Entreg&oacute;<input class="largo" style="background-color:#DBDBDB" tabindex="21" readonly size="31"
			  value="<?php
			 //$sqlo="SELECT * FROM dotacion WHERE dotacion.iddot=$g and dotacion.ceduladot='$_SESSION[cedulamod]' ";
			 //$consul=@mysql_query($sqlo) or $error.=" 258 - ".@mysql_error();
			  $usuaent=@mysql_result($consul,0,usuaent);
			  if ($usuaent==""){
			  echo "";}else{ echo @mysql_result($consul,0,"usuaent");}
			 ?>" name="f"/>
			 <br/>
  			</td>
		</tr>
                </table>
 </td></tr></table><br/>

                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Dotaci&oacute;n de Clientes
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="center" colspan="2" width="100" valign="middle"><input type="submit" class="botobusca"  id="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
                </tr>
			<tr><td colspan="2" align="center">
			<select name="cedpersona" class="largo2" id="selectpacientes">
 	 		<?php echo $cadena;?>
 	 		</select><div>Activo:<input name="pactivo" type="radio" value="1" id="pactivon" <?php if($pactivon=="1"){echo " checked=\"checked\"";}?>> Inactivo:<input name="pactivo" type="radio" id="pactivoff" value="0" <?php if($pactivon=="0"){echo "checked=\"checked\"";}?>></div>
			</td></tr>
			<tr><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut"/>
			<input type="submit" class="botoant" value="<<" name="ejecut"/>
			<input type="submit" class="botosig" value=">>" name="ejecut"/>
			<input type="submit" class="botoult" value=">||" name="ejecut"/>
			</td></tr>
			<tr><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" id="btactualizar" name="ejecut" style="display:none"/>
			</td></tr>
			<tr><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut"/>
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled=\"disabled\"";}?> name="ejecut" id="ingresar"/>
			</td></tr>
			<tr style="height:10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Dotaci&oacute;n $p de $_SESSION[numreg]";} ?>
			</td></tr>
			</table>
     			<div id="divMenu" class="divMenu"></div>
                        <?php require('saludos.php');?>
     		</div>
                </form>
		<?php
		echo $mensaje;
		?>
<script type="text/javascript">

<?php
$in=0;
$fi=$indicematrices;
for($in=0;$in<$indicematrices;$in++){
    if($in+1==$indicematrices){
    $agregarcoma="";
    }else{
    $agregarcoma=", ";
    }

    $js_idprods1.=fv($js_idprods[$in]).$agregarcoma;                                //ids del producto correspondiente
    $js_regtabladotanuevo1.=fv($js_regtabladotanuevo[$in]).$agregarcoma;            //ids de registros tabla dotacion
    $js_regtabladotausado1.=fv($js_regtabladotausado[$in]).$agregarcoma;            //ids de registros tabla dotacion
    $js_cantprodnuevo1.=fv($js_cantprodnuevo[$in]).$agregarcoma;                    //
    $js_cantprodusado1.=fv($js_cantprodusado[$in]).$agregarcoma;
    $js_cantprodnuevodevuelto1.=fv($js_cantprodnuevodevuelto[$in]).$agregarcoma;    //
    $js_cantprodusadodevuelto1.=fv($js_cantprodusadodevuelto[$in]).$agregarcoma;
    $js_prodnuevoexis1.=fv($js_prodnuevoexis[$in]).$agregarcoma;
    $js_produsadoexis1.=fv($js_produsadoexis[$in]).$agregarcoma;
}

function fv($valor){
if($valor!=""){
return $valor;
}else{
return 0;
}
}
        if($js_idprods1!=""){
	echo "
            var idprods=Array('f',$js_idprods1);
            var regtabladotanuevo=Array('f',$js_regtabladotanuevo1);
            var regtabladotausado=Array('f',$js_regtabladotausado1);
            var cantprodnuevo=Array('f',$js_cantprodnuevo1);
            var cantprodusado=Array('f',$js_cantprodusado1);
            var cantprodnuevodevuelto=Array('f',$js_cantprodnuevodevuelto1);
            var cantprodusadodevuelto=Array('f',$js_cantprodusadodevuelto1);
            var prodnuevoexis=Array('f', $js_prodnuevoexis1);
            var produsadoexis=Array('f', $js_produsadoexis1);
        ";
        }else{
        echo "
            var idprods=null;
            var prodnuevoexis=null;
            var produsadoexis=null;
        ";
        }

//agregar matriz de datos de grid de resumen
        $sqlresumen="SELECT * FROM productos, dotacion WHERE dotacion.idprod=productos.id AND dotacion.ceduladot='$_SESSION[cedulamod]'";
        $resulresumen=@mysql_query($sqlresumen);
        $ini=0;
        $lim=@mysql_num_rows($resulresumen);

        $varesumen="";

        if($lim>0){
        $varesumen="var myData = [";
        }

        for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }

        $varesumen.="['".@mysql_result($resulresumen, $ini, "id")."', '".@mysql_result($resulresumen, $ini, "nombreprod")."',
        '".@mysql_result($resulresumen, $ini, "iddot")."', '".@mysql_result($resulresumen, $ini, "cantidad")."',
        '".@mysql_result($resulresumen, $ini, "tipoprod")."', '".@mysql_result($resulresumen, $ini, "cantidadevuelta")."', '".@mysql_result($resulresumen, $ini, "nou")."',
        '".@mysql_result($resulresumen, $ini, "fechaent")."', '".@mysql_result($resulresumen, $ini, "fechadev")."']$coma";
        }

        if($lim>0){
        $varesumen.="];\n";
        }

        if($varesumen!=""){
        echo $varesumen;
        }

        //envio de datos para cargar personal activo o retirado segun se seleccione
        $JsonPersAct=devolverSentenciaJson("SELECT codigo, nombrecliente FROM clientes WHERE clientes.activo=1 AND sucursal='$_SESSION[sucur]' ORDER BY codigo ASC");
        $JsonPersRet=devolverSentenciaJson("SELECT codigo, nombrecliente FROM clientes WHERE clientes.activo=0 AND sucursal='$_SESSION[sucur]' ORDER BY codigo ASC");

        echo "var arrperacts = ".$JsonPersAct;
        echo "var arrperret = ".$JsonPersRet;
        //echo "}catch(er){Ext.Msg.alert(\"buenas\", er)}"

?>

    Ext.get('pactivon').on('click', function(){cargarPersonal('activo')});
    Ext.get('pactivoff').on('click', function(){cargarPersonal('retirado')});

    function cargarPersonal(tipo){
        switch (tipo){
        case "activo":
        Ext.get('selectpacientes').dom.options.length = 0;

        for(var i=0;i<arrperacts.datos.length;i++){
        var op = document.createElement("OPTION");
        op.value = arrperacts.datos[i].codigo;
        op.text = arrperacts.datos[i].codigo + " "+ arrperacts.datos[i].nombrecliente;
        Ext.get('selectpacientes').dom.options[i] = op;
        }
        break;
        case "retirado":
        Ext.get('selectpacientes').dom.options.length = 0;

        for(var i=0;i<arrperret.datos.length;i++){
        var op = document.createElement("OPTION");
        op.value = arrperret.datos[i].codigo;
        op.text = arrperret.datos[i].codigo + " "+ arrperret.datos[i].nombrecliente;
        Ext.get('selectpacientes').dom.options[i] = op;
        }
        break;
        }
    }
</script>
</body>
</html>


