<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 61);

	formularioactual();
	
	
	switch($_POST[ejecut]){
	case "ingresar":
	if($_POST['ano']!="" && $_POST['mes']!="" && $_POST['dia']!="" && $_SESSION['clientemod']!=""){
	
	$sql0="SELECT * FROM usuarios WHERE `usuarios`.`usuario` LIKE '$_SESSION[usuario]'";
	$conspersona=@mysql_query($sql0,$link);
	$datostomadospor=recortarcadena(@mysql_result($conspersona,0,"nombres")." ".@mysql_result($conspersona,0,"apellidos"),100);	
		
	$sql="INSERT INTO `seguimiento` (`idoferta`,`fecha`, `encargado`, `comentarios`) VALUES ('$_SESSION[clientemod]', '$_POST[ano]-$_POST[mes]-$_POST[dia]', '$datostomadospor', '$_POST[comentarios]')";
	@mysql_query($sql);
	}
	break;
	}
	
	$fecha1=getdate(time());
	
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
<br>

<form method="post" action="agregaseg.php" name="agregaseg" onsubmit="return validagregaseg(boolvalidar);">
<table class="tablaprincpq">
			<tr>
  			<td align="right">
  			<b>*Fecha de Seguimiento:</b>
  			</td>
		    <td align="left">
			<select name="ano" class="corto1">
			<option></option>
			<option <?php if ($ano==$fecha1[year]+1){echo 'selected=""';}?>><?php $e=$fecha1[year]+1; echo $e;?></option>
			<option <?php if ($ano==$fecha1[year]){echo 'selected=""';}?>><?php $e=$fecha1[year]; echo $e;?></option>
			<option <?php if ($ano==$fecha1[year]-1){echo 'selected=""';}?>><?php $e=$fecha1[year]-1; echo $e;?></option>
			</select>		    
			<select name="mes" class="medio1">
			<option></option>
			<option value="1"<?php if ($mes==1){echo 'selected=""';}?>>Enero</option>
			<option value="2" <?php if ($mes==2){echo 'selected=""';}?>>Febrero</option>
			<option value="3" <?php if ($mes==3){echo 'selected=""';}?>>Marzo</option>
			<option value="4" <?php if ($mes==4){echo 'selected=""';}?>>Abril</option>
			<option value="5" <?php if ($mes==5){echo 'selected=""';}?>>Mayo</option>
			<option value="6" <?php if ($mes==6){echo 'selected=""';}?>>Junio</option>
			<option value="7" <?php if ($mes==7){echo 'selected=""';}?>>Julio</option>
			<option value="8" <?php if ($mes==8){echo 'selected=""';}?>>Agosto</option>
			<option value="9" <?php if ($mes==9){echo 'selected=""';}?>>Septiembre</option>
			<option value="10" <?php if ($mes==10){echo 'selected=""';}?>>Octubre</option>
			<option value="11" <?php if ($mes==11){echo 'selected=""';}?>>Noviembre</option>
			<option value="12" <?php if ($mes==12){echo 'selected=""';}?>>Diciembre</option>
			</select>
			<select name="dia" class="corto3">
			<option></option>
			<option <?php if ($dia==1){echo 'selected=""';}?>>1</option>
			<option <?php if ($dia==2){echo 'selected=""';}?>>2</option>
			<option <?php if ($dia==3){echo 'selected=""';}?>>3</option>
			<option <?php if ($dia==4){echo 'selected=""';}?>>4</option>
			<option <?php if ($dia==5){echo 'selected=""';}?>>5</option>
			<option <?php if ($dia==6){echo 'selected=""';}?>>6</option>
			<option <?php if ($dia==7){echo 'selected=""';}?>>7</option>
			<option <?php if ($dia==8){echo 'selected=""';}?>>8</option>
			<option <?php if ($dia==9){echo 'selected=""';}?>>9</option>
			<option <?php if ($dia==10){echo 'selected=""';}?>>10</option>
			<option <?php if ($dia==11){echo 'selected=""';}?>>11</option>
			<option <?php if ($dia==12){echo 'selected=""';}?>>12</option>
			<option <?php if ($dia==13){echo 'selected=""';}?>>13</option>
			<option <?php if ($dia==14){echo 'selected=""';}?>>14</option>
			<option <?php if ($dia==15){echo 'selected=""';}?>>15</option>
			<option <?php if ($dia==16){echo 'selected=""';}?>>16</option>
			<option <?php if ($dia==17){echo 'selected=""';}?>>17</option>
			<option <?php if ($dia==18){echo 'selected=""';}?>>18</option>
			<option <?php if ($dia==19){echo 'selected=""';}?>>19</option>
			<option <?php if ($dia==20){echo 'selected=""';}?>>20</option>
			<option <?php if ($dia==21){echo 'selected=""';}?>>21</option>
			<option <?php if ($dia==22){echo 'selected=""';}?>>22</option>
			<option <?php if ($dia==23){echo 'selected=""';}?>>23</option>
			<option <?php if ($dia==24){echo 'selected=""';}?>>24</option>
			<option <?php if ($dia==25){echo 'selected=""';}?>>25</option>
			<option <?php if ($dia==26){echo 'selected=""';}?>>26</option>
			<option <?php if ($dia==27){echo 'selected=""';}?>>27</option>
			<option <?php if ($dia==28){echo 'selected=""';}?>>28</option>
			<option <?php if ($dia==29){echo 'selected=""';}?>>29</option>
			<option <?php if ($dia==30){echo 'selected=""';}?>>30</option>
			<option <?php if ($dia==31){echo 'selected=""';}?>>31</option>
			</select>
  	 		</td>
  			</tr>
  			
		  	<tr>
  			<td align="right">
  			<b>Comentarios:</b>
  			</td>
		    <td align="left">
		    <textarea rows="4" cols="30" name="comentarios"></textarea>
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
			<center><input type="submit"  value="Cerrar" class="botcerrar" name="ejecut" onclick="cerrarventana();"/></center>
			</body>
			</html>	
<?php 
/*
while (list($name, $value) = each($HTTP_POST_VARS)) { echo " POST $name = $value<br>\n";
}
while (list($name, $value) = each($HTTP_SESSION_VARS)) { echo "<p align='center'>SESSION $name = $value<br>\n</p>";
} */
?>			