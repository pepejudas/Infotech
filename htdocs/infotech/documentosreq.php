<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 72);//cambiar 73

	formularioactual();

		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$_SESSION[cedulamod]=$_POST[cedpersona];

			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];

			$boton=0;
		break;
		endswitch;

$sqcl="SELECT nombre, apellidos, cedula, idreq, idusuarioreq, serialrequisicion  FROM requisiciones LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY requisiciones.fechareq DESC, apellidos, idreq LIMIT 200";
$resultar=@mysql_query($sqcl);
$inir=1;
$limr=@mysql_num_rows($resultar);

while($inir<=$limr){
if(@mysql_result($resultar,$inir,cedula)!=@mysql_result($resultar,$inir-1,cedula) || @mysql_result($resultar,$inir,idreq)!=@mysql_result($resultar,$inir-1,idreq)){
		if($_SESSION[cedulamod]==@mysql_result($resultar,$inir-1,serialrequisicion)){
			$cadena.=utf8_decode("<option selected=\"selected\" value=\"".@mysql_result($resultar,$inir-1,serialrequisicion)."\">No ".@mysql_result($resultar,$inir-1,serialrequisicion)." ". @mysql_result($resultar,$inir-1,apellidos)." ".@mysql_result($resultar,$inir-1,nombre)." ".@mysql_result($resultar,$inir-1,cedula). "</option>");
		}else{
			$cadena.=utf8_decode("<option value=\"".@mysql_result($resultar,$inir-1,serialrequisicion)."\">No ".@mysql_result($resultar,$inir-1,serialrequisicion)." ". @mysql_result($resultar,$inir-1,apellidos)." ".@mysql_result($resultar,$inir-1,nombre)." ".@mysql_result($resultar,$inir-1,cedula). "</option>");
		}
}
$inir++;}
			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="cedula";}

$coltabla="#67d111"
?>

<html>
		<head>
		<title>Documentos Requisiciones</title>
		<link rel="stylesheet" href="estilo2.css" type="text/css">
		<link rel="stylesheet" href="botones.css" type="text/css">
		<!-- inicio librerias extjs -->
                <link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
                <!-- GC -->
                <!-- LIBS -->
                <script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
                <!-- ENDLIBS -->
                <script type="text/javascript" src="ext/ext-all.js"></script>
                <script type="text/javascript" src="scripts/menu.js"></script>
                <head>
		<body bgcolor="<?php echo $colcuerpo;?>">
<form method="post" action="<?php echo $PHP_SELF?>">
	  		<br>
 		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="WIDTH:17%;" size="2" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
		</tr>
	  	<tr>
	  		<td align="left" width="50%">
	  		Documentos Generales
			</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<select name="orden" style="WIDTH: 70%" tabindex="39">
                        <option value="usuario" <?php  if ($_SESSION['ord']=="usuario") {echo ('selected=""');}?>>Usuario Solicita</option>
  	 		<option value="fechareq" <?php  if ($_SESSION['ord']=="fechareq") {echo ('selected=""');}?>>Fecha de Requisicion</option>
                        <option value="fechapre" <?php  if ($_SESSION['ord']=="fechapre") {echo ('selected=""');}?>>Fecha de Aprobaci&oacute;n</option>
                        <option value="estado" <?php  if ($_SESSION['ord']=="estado") {echo ('selected=""');}?>>Estado de Requisicion</option>
	  		</select>Orden
			</td>
		</tr>
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="ceduladot");}?>
                        <option value="0" <?php  if ($_SESSION['lis']==0) {echo ('selected=""');}?>>Listado de Requisiciones</option>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de Requisiciones No Revisadas</option>
                        <option value="2" <?php  if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Listado de Requisiciones Aprobadas</option>
                        <option value="3" <?php  if ($_SESSION['lis']==3) {echo ('selected=""');}?>>Listado de Requisiciones Rechazadas</option>
	 		</select>Listado
	  		</td>
		</tr>
		<tr>
	 		<td align="left">
	  		<a href="<?php
	  		switch ($_SESSION['lis']):
	  		case 0:
  			$nj='listreq0.php';
  			break;
                        case 1:
  			$nj='listreq1.php';
  			break;
                        case 2:
  			$nj='listreq2.php';
  			break;
                        case 3:
  			$nj='listreq3.php';
  			break;
 			default:
  			$nj='listreq1.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>

	 	<form method="post" action="<?php echo $PHP_SELF?>">
 		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="WIDTH:17%;" size="2" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
		</tr>

	  	<tr>
			<td>
			Documentos Individuales
			</td>
		</tr>

		<tr>
	 		<td>
			<select name="cedpersona" style="WIDTH:70%" tabindex="1">
  	 		<?php echo $cadena;?></select>Persona
  	 		</td>
		</tr>

		<tr>
			<td>
			<select name="docum" style="WIDTH: 70%" tabindex="39">
                        <?php  if ($_SESSION['cont']=="") {echo ($_SESSION['cont']=="2");}?>
	 		<option value="2" <?php if ($_SESSION['cont']==2) {echo ('selected=""');}?>>Formato de Requisici&oacute;n</option>
	 		</select>Documento
			</td>
		</tr>

		<tr>
	 		<td>
			<a href="<?php
  switch ($_SESSION['cont']):
  case 2:
  $nj='requisicion.php';
  break;
  default:
  $nj='requisicion.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
  		</td>


		</tr>
		</table>
	 	</form>
	 	<?php
		$parametros[tabla]="requisiciones LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno LEFT JOIN productos ON requisiciones.idprod=productos.id";
		$parametros[campos]="nombre, apellidos, requisiciones.id, serialrequisicion, idreq, cantidad, nou, nombreprod, marca, modelo, referencia, fechareq, requisiciones.estado, fechapre, requisiciones.observaciones";
		$parametros[condiciones]="personalactivo.sucursal LIKE '$_SESSION[sucur]'";
		echo exportartodo($parametros);
		?>

	 	<div id="controlex">
     		<table  class="control">
     		<tr height="150px"><td colspan="2" class="arriba">
     		Documentos
     		</td>
     		</tr>
     		</table>
     		<div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
     	</div>
<?php
@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
?>
