<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 60);

	formularioactual();
	
	switch($_POST[ejecut]){
	case "ingresar":
	if($_POST['marca']!="" && $_POST['cantarma']!="" && $_SESSION['clientemod']!=""){
	$sql="INSERT INTO `armasnecesidades` (`idnecesidad`,`tipoarma`, `marca`, `calibre`, `clasepermiso`, `observacionarma`) VALUES ('$_SESSION[clientemod]', '$_POST[tipoarma]', '$_POST[marca]', '$_POST[calibre]', '$_POST[clasepermiso]', '$_POST[observacionarma]')";
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
<form method="post" action="agregarm.php" name="agregarm" onsubmit="return validagregarm(boolvalidar);">
<table class="tablaprincpq">

			<tr>
  			<td align="right"><b>Cantidad de armas:</b></td>
			<td align="left">
			<input class="corto" name="cantarma" value="">
			</td>
     		</tr>
     		
     		<tr>
 			<td align="right"><b>Tipo de arma:</b>
 			</td>
 			<td align="left">
			<select name="tipoarma" class="largo1" >
  	 		<option value="1">Revolver</option>
  	 		<option value="2">Pistola</option>
  	 		<option value="3">Escopeta</option>
  	 		<option value="4">Fusil</option>
  	 		<option value="5">Ametralladora</option>
  	 		<option value="6">Miniuzi</option>
  	 		<option value="7">No letal</option>
  	 		</select>  
			</td>
  			</tr>

			<tr>
  			<td align="right"><b>Marca:</b></td>
			<td align="left">
			<input class="corto" name="marca" value="">
			</td>
     		</tr>
     		
     		<tr>
  			<td align="right"><b>Calibre:</b></td>
			<td align="left">
			<select name="calibre" class="medio1" tabindex="5">
  	 		<option value="38c">38 corto</option>
  	 		<option value="32l">32 largo</option>
  	 		<option value="32c">32 corto</option>
  	 		<option value="9mm">9 milimetros</option>
  	 		<option value="16m">Escopeta 16</option>
  	 		<option value="12m">Escopeta 12</option>
  	 		<option value="38l">38 largo</option>
  	 		</select>
			</td>
     		</tr>
     					
     		<tr>
 			<td align="right"><b>Clase Permiso:</b>
 			</td>
 			<td align="left">
			<select name="clasepermiso" class="largo1" >
  	 		<option value="1">Tenencia</option>
  	 		<option value="2">Porte</option>
  	 		</select>  
			</td>
  			</tr>

			<tr>
  			<td align="right"><b>Observaciones:</b></td>
			<td align="left">
			<textarea rows="3" cols="18" name="observacionarma"></textarea>
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

	 		<center><input type="submit" class="botcerrar"  value="Cerrar" name="ejecut" onclick="cerrarventana();"/></center>
</body>
</html>
	 		