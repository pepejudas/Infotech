<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 62);

	formularioactual();
	
	switch($_POST[ejecut]){
	case "ingresar":
	if($_POST['cantidadservicios']!="" && ($_POST['personal']!="" || $_POST['personalnocturno']!="") && $_POST['valorservicio']!="" && $_SESSION['clientemod']!=""){
	$sql="INSERT INTO `servicios` (`idoferta`,`cantidadservicios`,`modalidadservicio`, `turno`, `personal`, `personalnocturno`, `diastrabajo`, `valorservicio`, `descripcion`) VALUES ('$_SESSION[clientemod]', '$_POST[cantidadservicios]','$_POST[modalidadservicio]', '$_POST[turno]', '$_POST[personal]', '$_POST[personalnocturno]', '$_POST[diastrabajo]', '$_POST[valorservicio]', '$_POST[descripcion]')";
	@mysql_query($sql);
	}
	break;
	}
	?>
<html>
<head>
<link	rel="stylesheet" href="estilo2.css" type="text/css">
<link	rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->
<script language="JavaScript" type="text/JavaScript">
<!--
function cerrarventana(){
var ventana = window.close();
}
//-->
</script>
</head>
<body>
<form method="post" action="agregaserv.php" name="agregaserv" onsubmit="return validagregaserv(boolvalidar);">
<table class="tablaprincpq">
			<tr>
  			<td align="right"><b>*Cantidad de Servicios:</b></td>
			<td align="left">
			<input class="corto" name="cantidadservicios" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cantidadservicios");}  ?>">
      		</td>
     		</tr>
			
			<tr>
  			<td align="right">
  			<b>*Modalidad del servicio:</b>
  			</td>
		    <td align="left">
		    <select name="modalidadservicio" class="largo1">
  	 		<option value="1" <?php $z="modalidadservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['svyspa']==1) {echo ('selected=""');}?>>Fijo sin arma</option>
  	 		<option value="2" <?php $z="modalidadservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['svyspa']==2) {echo ('selected=""');}?>>Fijo con arma Letal</option>
  	 		<option value="5" <?php $z="modalidadservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['svyspa']==5) {echo ('selected=""');}?>>Fijo con arma No Letal</option>
  	 		<option value="4" <?php $z="modalidadservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['svyspa']==4) {echo ('selected=""');}?>>Movil sin arma</option>
  	 		<option value="3" <?php $z="modalidadservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['svyspa']==3) {echo ('selected=""');}?>>Movil con arma Letal</option>
  	 		<option value="6" <?php $z="modalidadservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['svyspa']==6) {echo ('selected=""');}?>>Movil con arma No Letal</option>
  	 		</select>
  	 		</td>
  			</tr>
  			
		  	<tr>
  			<td align="right">
  			<b>*Dias de trabajo:</b>
  			</td>
		    <td align="left">
		    <select name="diastrabajo" class="largo1">
  	 		<option value="1" <?php $z="diastrabajo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['svyspa']==1) {echo ('selected=""');}?>>Lunes a Domingo</option>
  	 		<option value="2" <?php $z="diastrabajo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['svyspa']==2) {echo ('selected=""');}?>>Sabado y Domingo</option>
  	 		<option value="3" <?php $z="diastrabajo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['svyspa']==3) {echo ('selected=""');}?>>Lunes a Viernes</option>
  	 		<option value="5" <?php $z="diastrabajo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['svyspa']==5) {echo ('selected=""');}?>>Lunes a Domingo con refuerzo fin de Semana y Festivo</option>
  	 		<option value="4" <?php $z="diastrabajo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['svyspa']==4) {echo ('selected=""');}?>>Otro</option>
  	 		</select>
  	 		</td>
  			</tr>
  			
		  	<tr>
  			<td align="right">
  			<b>*Horas al D&iacute;a Requeridas:</b>
  			</td>
		    <td align="left">
		    <select name="turno" class="largo1">
  	 		<option value="1" <?php $z="turno"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['svyspa']==1) {echo ('selected=""');}?>>24 Horas</option>
  	 		<option value="2" <?php $z="turno"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['svyspa']==2) {echo ('selected=""');}?>>12 Horas diurnas</option>
  	 		<option value="3" <?php $z="turno"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['svyspa']==3) {echo ('selected=""');}?>>12 Horas mixtas</option>
  	 		<option value="4" <?php $z="turno"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['svyspa']==4) {echo ('selected=""');}?>>8 Horas diurnas</option>
  	 		<option value="5" <?php $z="turno"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['svyspa']==5) {echo ('selected=""');}?>>8 Horas nocturnas</option>
  	 		</select>
  	 		</td>
  			</tr>
  			
                <tr>
  			<td align="right"><b>*Numero de guardas Diurnos:</b></td>
			<td align="left">
			<input class="corto" name="personal" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"personalreq");} ?>">
      		</td>
     		</tr>

                <tr>
  			<td align="right"><b>*Numero de guardas Nocturnos:</b></td>
			<td align="left">
			<input class="corto" name="personalnocturno" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"personalreq");} ?>">
      		</td>
     		</tr>
     		
  			<tr>
  			<td align="right"><b>*Valor Total:</b></td>
			<td align="left">
			<input class="largo" name="valorservicio" value="<?php if (!$result){echo "";}else{$numl="$ ".number_format(@mysql_result($result,$_SESSION['i'],"valor")); echo $numl;} ?>">
			</td>
     		</tr> 
  			
			<tr>
  			<td align="right"><b>Descripci&oacute;n:</b></td>
     		<td align="left" valign="top">
	 		<textarea name="descripcion" id="sqlquery" cols="20" rows="7" dir="ltr"><?php if ($result){echo @mysql_result($result,$_SESSION['i'],"observacionesnec");}?></textarea>
      		</td>
			</tr>
			
			<tr>
  			<td align="right"><b>Agregar:</b></td>
     		<td align="left" valign="top">
	 		<input type="submit" class="botoing" value="ingresar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
      		</td>
			</tr>
			</table>
			</form>
			<center><input type="submit" class="botcerrar" value="Cerrar" name="ejecut" onclick="cerrarventana();"/></center>
			</body>
			</html>	
<?php 
/*
while (list($name, $value) = each($HTTP_POST_VARS)) { echo " POST $name = $value<br>\n";
}
while (list($name, $value) = each($HTTP_SESSION_VARS)) { echo "<p align='center'>SESSION $name = $value<br>\n</p>";
} */
?>			