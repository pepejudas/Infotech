<?php
session_start();

@require('funciones2.php');

$idmodulo=27;

validar("","","", $idmodulo);

		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$vector=explode(" ",$_POST[cedpersona]);
			$wced=$vector[0];
			
			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			$_SESSION['sociolis']=$_POST[sociol];
			$vector=explode(" ", $_POST[cliemod]);
						
		$boton=0;
		break;
		endswitch;

			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="nit";}
	

	$sql1="SELECT * FROM clientes ORDER BY codigo";
	$resultaclie=@mysql_query($sql1);
	$reg=0;
	$lim=@mysql_num_rows($resultaclie);

	$mostrar[1]="nombres";
	$otras="";
	$selec1=$_SESSION[sociolis];
	$cadena3=selection("socios","cedula","%",$mostrar,$selec1,1,"nombres",$otras);

		$campos[1]="nombrecliente";
		$campos[2]="nit";
		
	$otrasent="AND clientes.sucursal LIKE '$_SESSION[sucur]' AND clientes.activo = 1";		
		$cadena0=utf8_decode(@selection("clientes","nit","%",$campos,"",2,"nombrecliente",$otrasent));

	$muestr[1]="nombre";
	$otrasent2="AND informes.idmodulo = '$idmodulo'";
	$cadena4="<select name=\"informe\" style=\"WIDTH: 70%\">".utf8_decode(selection("informes","id","%",$muestr,$_POST['informe'],1,"nombre",$otrasent2))."</select>";
		
	$_SESSION['clavepi'] = "clientes.nit";	
	
$coltabla="#67d111"
?>

<html>
<head>
<title>Documentos Clientes</title>
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
<script language="JavaScript" type="text/JavaScript">
<!--
function cerrarventana(){
var ventana = window.close();
}
//-->
</script>
		</head>
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
  	 		<option value="nombrecliente" <?php  if ($_SESSION['ord']=="nombrecliente") {echo ('selected=""');}?>>Nombre del cliente</option>
  	 		<option value="codigo" <?php  if ($_SESSION['ord']=="codigo") {echo ('selected=""');}?>>Codigo asignado</option>
  	 		<option value="nit" <?php  if ($_SESSION['ord']=="nit") {echo ('selected=""');}?>>Nit</option>
  	 		<option value="fechainiciocontrato" <?php  if ($_SESSION['ord']=="fechainiciocontrato") {echo ('selected=""');}?>>Fecha de inicio de contrato</option>
  	 		<option value="nombreadministrador" <?php  if ($_SESSION['ord']=="nombreadministrador") {echo ('selected=""');}?>>Nombre administrador</option>
	  		</select>Orden
			</td>
		</tr>
		
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="nit");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de clientes</option>
  	 		<option value="3" <?php  if ($_SESSION['lis']==3) {echo ('selected=""');}?>>Listado de clientes y administradores</option>
  	 		</select>Listado
  	  		</td>
		</tr>

		<tr>
			<td align="left">
			<select name="sociol" style="WIDTH: 70%" tabindex="39">
			<option value="%" <?php  if ($_SESSION['sociolis']=="") {echo ('selected=""');}?>>Todos los Socios</option>
			<?php echo $cadena3;?>
	 		</select>Socio
    		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  switch ($_SESSION['lis']):
  case 1:
  $nj='listcliecompleto.php';
  break;
  case 2:
  $nj='listcliereporta.php';
  break;
  case 3:
  $nj='listclieadmin.php';
  break;
  case 5:
  $nj='listclienoreporta.php';
  break;
  default:
  $nj='listcliecompleto.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
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
			<select name="docum" style="WIDTH: 70%" tabindex="39">
  	 		<option value="1" <?php  if ($_SESSION['cont']==1) {echo ('selected=""');}?>>Proforma contrato 1</option>
	 		<option value="3" <?php if ($_SESSION['cont']==3) {echo ('selected=""');}?>>Proforma contrato vehiculos</option>
	 		<option value="4" <?php if ($_SESSION['cont']==4) {echo ('selected=""');}?>>Proforma contrato comodato</option>
	 		</select>Documento
			</td>
		</tr>
		<tr>
	 		<td>
	 		<a href="<?php 
  switch ($_SESSION['cont']):
  case 1:
  $nj='contratocliente1.php';
  break;
  case 2:
  $nj='contratocliente2.php';
  break;
  case 3:
  $nj='contratovehiculo.php';
  break;
  case 4:
  $nj='contratocomodato.php';
  break;
  default:
  $nj='contratocliente1.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
	 		
		</tr>
		</table>
	 	</form>
	 	
		<form method="post" action="informes.php">
		<table cellpadding="0" class="tabladocs" width="55%" align="center">
	  	<tr>
			<td>
			Informes Personalizados
			</td>
		</tr>
		<tr>
	 		<td>
			<select name="cedpac" style="WIDTH:70%" >
  	 		<?php echo $cadena0;?></select>Cliente
			</td>

		</tr>
		<tr>
			<td>
  	 		<?php echo $cadena4;?>
			Informe
  
			</td>
		</tr>
		<tr>
	 		<td>
	 		
			<input type="image" value="Generar" src="imagenes/as01.gif" height="20px"/>
			<?php tamanosInf();?>
			
			</td>
		</tr>
		</table>
		</form>
		
		
	 	<?php 
		$parametros[tabla]="clientes";
		$parametros[campos]="*";
		$parametros[condiciones]="clientes.activo = 1 AND clientes.sucursal LIKE '$_SESSION[sucur]'";
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