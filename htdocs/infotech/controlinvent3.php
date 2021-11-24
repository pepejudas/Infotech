<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 14);
formularioactual();
switch($_POST[ejecut]):
case "Buscar":
	
		$_SESSION['i']=0;
		
		if($_POST[cedpersona]!=""){$_SESSION['prodmod']=$_POST[cedpersona];}
		
		$datos[campobusqueda]="idprod";
		$datos[crito]=$_POST[cedpersona];
		$datos[claveprinc]="id";
		$datos[otraconsulta]="";
			
		$result2=operaciones("movproductos","buscar",$datos);
		$result=$result2[datos];	
break;
case ">>":
	if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
	
		$result2=operaciones("movproductos","buscar",$_SESSION[datos]);
		$result=$result2[datos];	
	
break;
case "<<":
	if($_SESSION[i]>0){$_SESSION[i]--;}
	
		$result2=operaciones("movproductos","buscar",$_SESSION[datos]);
		$result=$result2[datos];	
	
break;
case ">||":
	
	$_SESSION[i]=$_SESSION[numreg]-1;
	
		$result2=operaciones("movproductos","buscar",$_SESSION[datos]);
		$result=$result2[datos];	
break;
case "||<":
	$_SESSION[i]=0;
	
		$result2=operaciones("movproductos","buscar",$_SESSION[datos]);
		$result=$result2[datos];
break;
case "Nuevo":
$sql1="SELECT * FROM movproductos WHERE movproductos.idprod=$_SESSION[prodmod]";
$cons=@mysql_query($sql1);
$limi=@mysql_num_rows($cons);
$_SESSION[i]=$limi;
$_SESSION[idreg]=@mysql_result($result,$_SESSION[i],id);
$boton=1;
break;
case "Ingresar":
if($_POST[cantidad]!="" && $_POST[eos]!="" && $_POST[nou]!=""){

if($_POST[eos]==2){
//consulta de saldo de inventarios
$disponible=saldoinv($_SESSION[prodmod], $_POST[nou]);

if($disponible>=$_POST[cantidad]){
	
$sql1="INSERT INTO movproductos (idprod, fecha, cantidad, nou, precio, facturaoreq, remisionocom, eos, observacionesreg, proveedor, sucursal) VALUES ('$_SESSION[prodmod]', NOW(), '$_POST[cantidad]', '$_POST[nou]', '$_POST[precio]', '$_POST[facturaoreq]', '$_POST[remisionocom]', '$_POST[eos]', '$_POST[observacionesreg]', '$_POST[proveedor]', '$_SESSION[sucur]')";
$sql2="INSERT INTO registrodemodificaciones (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal) VALUES (NOW(), 'Ingreso de articulos dotacion', '$_SESSION[persona]','$_SESSION[prodmod]','5', $_SESSION[sucur])";
$cons1=@mysql_query($sql1);
$cons2=@mysql_query($sql2);

}else{$mens.= 'No hay suficientes existencias del articulo';}
}else{
$sql1="INSERT INTO movproductos (idprod, fecha, cantidad, nou, precio, facturaoreq, remisionocom, eos, observacionesreg, proveedor, sucursal) VALUES ('$_SESSION[prodmod]', NOW(), '$_POST[cantidad]', '$_POST[nou]', '$_POST[precio]', '$_POST[facturaoreq]', '$_POST[remisionocom]', '$_POST[eos]', '$_POST[observacionesreg]','$_POST[proveedor]', '$_SESSION[sucur]')";
$sql2="INSERT INTO registrodemodificaciones (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal) VALUES (NOW(), 'Ingreso de articulos dotacion', '$_SESSION[persona]','$_SESSION[prodmod]','5', $_SESSION[sucur])";
$cons1=@mysql_query($sql1);
$cons2=@mysql_query($sql2);
}

}else{$mens.= 'Debe Diligenciar los campos requeridos';}

break;
case "Eliminar":
$sql1="DELETE  FROM movproductos WHERE movproductos.id=$_SESSION[clientemod]";
$resu=@mysql_query($sql1);
$_SESSION[i]="";
break;
endswitch;

$mostrar[1]="nombreprod";
$mostrar[2]="referencia";
$mostrar[3]="modelo";
$mostrar[4]="marca";

$cadena=selection("productos","id","%",$mostrar,$_SESSION[prodmod],4,"nombreprod",$otra);
$resultdartosprod=@mysql_query("select * from productos where id='$_SESSION[prodmod]'");
$cadenaprod=@mysql_result($resultdartosprod, 0, "nombreprod")." ".@mysql_result($resultdartosprod, 0, "referencia")." ".@mysql_result($resultdartosprod, 0, "modelo")." ".@mysql_result($resultdartosprod, 0, "marca");

$mostrar[1]="nombreprov";
$otras=" AND sucursal='$_SESSION[sucur]'";
$selec=@mysql_result($result,$_SESSION['i'],"proveedor");
$cadenaprovee=selection("proveedores","id","%",$mostrar,$selec,1,"nombreprov",$otras);

$r=@require('version.php');
caracteresiso();
		
$coltabla="#88sd111"
?>
<link	rel="stylesheet" href="estilo2.css" type="text/css">
<link	rel="stylesheet" href="botones.css" type="text/css">

<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->

</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<form method="post" action="<?php echo $PHP_SELF?>" onsubmit="return validaexistencias(boolvalidar);" name="existencias">
		<table class="tablaprinc"><tr><td>
		<table>
                <tr>
                <td align="center" width="40%" colspan="2">
                <?php
			  	echo "Seleccionado: ". $cadenaprod." Nuevo:".saldoinv($_SESSION[prodmod], 1)." Usado:".saldoinv($_SESSION[prodmod], 2);
                            ?>
                </td>
     		</tr>
		<tr>
	 	<td align="right" width="40%">*Cantidad:<input class="largo"
	 		value="<?php
			 if ($_SESSION['cantidada']!=""){
			  	echo $_SESSION[cantidada];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cantidad");}
			 		?>" name="cantidad"></td>
     		<!-- Col 1 -->
	 		<td width="30%" valign="top" rowspan="10" align="right">
	 		<center>Observacion de Art&iacute;culo<br><textarea name="observacionreg" id="sqlquery" cols="30" rows="12" dir="ltr"><?php if ($_SESSION['observacionrega']!=""){echo $_SESSION[observacionrega];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionesreg");}?></textarea></center>
		  	</td>
     		</tr>
                <tr>
                        <td align="right">*Precio:<input class="largo"
			 value="<?php
			 if ($_SESSION['precioa']!=""){
			  	echo $_SESSION[precioa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"precio");}
			 		?>" name="precio">
                    </td></tr>
                
			<tr>
			<td align="right">Factura o requisicion:<input class="largo" name="facturaoreq"
			 value="<?php
		 if ($_SESSION['facturaoreqa']!=""){
			  	echo $_SESSION[facturaoreqa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"facturaoreq");} ?>"></td>
     		</tr>
     		<tr><!-- Row 3 -->
  			<td align="right">Remision o comprobante:<input class="largo" 
			 value="<?php
			 if ($_SESSION['remisionocoma']!=""){
			  	echo $_SESSION[remisionocoma];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"remisionocom");}
			 		?>" name="remisionocom">
      		</td>
    	 	</tr>
 	 		<tr style="border-width: thin ;"><!-- Row 4 -->
 			<td align="right">
			*Entrada o salida:
			<select name="eos" class="largo1" id="eos">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="eos"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['eosa']==1) {echo ('selected=""');}?>>Entrada de Articulos</option>
  	 		<option value="2" <?php $z="eos"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['eosa']==2) {echo ('selected=""');}?>>Salida de Articulos</option>
  	 		</select> 
			</td>
  			</tr>
  			<tr style="border-width: thin ;"><!-- Row 4 -->
 			<td align="right">
			*Art&iacute;culo Nuevo o Usado:
			<select name="nou" class="largo1">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="nou"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['noua']==1) {echo ('selected=""');}?>>Art&iacute;culo Nuevo</option>
  	 		<option value="2" <?php $z="nou"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['noua']==2) {echo ('selected=""');}?>>Art&iacute;culo Usado</option>
  	 		</select> 
			</td>
  			</tr>
                        <tr><!-- Tipo: <select name=\"tipoprod-$tipoprod\" name=\"tipoprod-$tipoprod\"<option value=\"1\" $selecprod1 >No Consumible</option><option value=\"0\" $selecprod2 >Consumible</option></select> -->
                        <td align="right">Proveedor:
                        <select class="largo1" name="proveedor">
                                <option value=""></option>
                                <?php echo $cadenaprovee;?>
                                </select>
                        </td>
                        </tr>
  			<tr>
  			<td align="right">
  			 Fecha de registro:
			<input style="background-color:#DBDBDB" class="largo" readonly
			 value="<?php
			 if ($_SESSION['fechaa']!=""){
			  	echo $_SESSION[fechaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fecha");}
			 		?>" name="fecha">  		
  			</td>
  			</tr>
  			</table>
  			</td></tr></table>
		<div id="controlex">
     		<table  class="control">
     		<tr height="150px"><td colspan="2" class="arriba">
     		Existencias de Productos
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="center" colspan="2"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
            </tr>
			<tr height="20px"><td colspan="2" align="center">
			<select name="cedpersona" class="extralargo">
 	 		<?php echo $cadena;?>
 	 		</select>
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botoelimina" value="Eliminar" name="ejecut" onmousedown="boolvalidar=false;" onkeydown="boolvalidar=false;"/>
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut" onmousedown="boolvalidar=false;" onkeydown="boolvalidar=false;">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="30px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Registro $p de $_SESSION[numreg]";} ?>
			</td></tr>
			</table>
			<div id="divMenu" class="divMenu"></div>
<?php require('saludos.php');?>

</div>
</form>
<?php
@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
echo $escribir;
?>
</body>
</html>
