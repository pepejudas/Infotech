<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

$idmodulo=2;

validar("","","", $idmodulo);

		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$_SESSION[cedulamod]=$_POST[cedpersona];
			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			$_SESSION['clielis']=$_POST[cliel];
			$_SESSION['sociolis']=$_POST[sociol];
			
		$boton=0;
		break;
		endswitch;

		$campos[1]="apellidos";
		$campos[2]="nombre";
		
		$otrasent="AND personalactivo.sucursal LIKE '$_SESSION[sucur]' AND personalactivo.activo = 1";		
		$cadena0=utf8_decode(@selection("personalactivo","cedula","%",$campos,$_POST[cedpac],2,"apellidos",$otrasent));
                $cadena=utf8_decode(@selection("personalactivo","cedula","%",$campos,$_SESSION[cedulamod],2,"apellidos",$otrasent));

			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="cedula";}
			if($_SESSION[clientemod]==""){$_SESSION[clientemod]=@mysql_result($resultadota,0,cedula);}
	
	$muestr[1]="codigo";
	$otrasent2="AND clientes.activo = 1 AND clientes.sucursal LIKE '$_SESSION[sucur]'";
	$selec0=$_SESSION[clielis];
	$cadena2=selection("clientes","codigo","%",$muestr,$selec0,1,"codigo",$otrasent2);
	
	$mostrar[1]="nombres";
	$otras="";
	$selec1=$_SESSION[sociolis];
	$cadena3=selection("socios","cedula","%",$mostrar,$selec1,1,"nombres",$otras);
	
	$muestr[1]="nombre";
	$otrasent2="AND informes.idmodulo = '$idmodulo'";
	$cadena4="<select name=\"informe\" style=\"WIDTH: 70%\">".utf8_decode(selection("informes","id","%",$muestr,$_POST['informe'],1,"nombre",$otrasent2))."</select>";
			
	$_SESSION['clavepi'] = "personalactivo.cedula";		
	
$coltabla="#67d111"
?>

<html>
		<head>
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
		<title>DOCUMENTOS PERSONAL ACTIVO</title>
		</head>
		<body bgcolor="<?php echo $colcuerpo;?>">
				
<form method="post" action="<?php echo $PHP_SELF?>">
<center>
	  		</center><br>
		
 		<table cellpadding="0" class="tabladocs" width="55%" align="center">
	  	<tr>
	  		<td align="left">
	  		<input type="submit" style="WIDTH:30%;" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
		</tr>
	  	<tr>
	  		<td align="left" width="50%">
	  		Documentos Generales
			</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<select name="orden" style="WIDTH:70%">
  	 		<option value="cedula" <?php  if ($_SESSION['ord']=="cedula") {echo ('selected=""');}?>>Cedula</option>
	 		<option value="apellidos" <?php if ($_SESSION['ord']=="apellidos") {echo ('selected=""');}?>>Apellidos</option>
	 		<option value="nombre" <?php if ($_SESSION['ord']=="nombre") {echo ('selected=""');}?>>Nombres</option>
	 		<option value="carnetinterno" <?php if ($_SESSION['ord']=="carnetinterno") {echo ('selected=""');}?>>Carnet interno</option>
	 		<option value="codigo" <?php if ($_SESSION['ord']=="codigo") {echo ('selected=""');}?>>Cliente asignado</option>
	 		<option value="eps" <?php if ($_SESSION['ord']=="eps") {echo ('selected=""');}?>>Eps</option>
	 		<option value="afp" <?php if ($_SESSION['ord']=="afp") {echo ('selected=""');}?>>Afp</option>
	 		<option value="pasadojudicial" <?php if ($_SESSION['ord']=="pasadojudicial") {echo ('selected=""');}?>>No pasado judicial</option>
	 		</select>Orden
			</td>
		</tr>
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" >
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedula");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado personal activo</option>
	 		<option value="2" <?php if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Listado personal de seguridad social</option>
	 		<option value="3" <?php if ($_SESSION['lis']==3) {echo ('selected=""');}?>>Listado eps</option>
	 		<option value="4" <?php if ($_SESSION['lis']==4) {echo ('selected=""');}?>>Listado arp</option>
	 		<option value="5" <?php if ($_SESSION['lis']==5) {echo ('selected=""');}?>>Listado afp</option>
	 		<option value="6" <?php if ($_SESSION['lis']==6) {echo ('selected=""');}?>>Listado pasado judicial vencido</option>
	 		<option value="7" <?php if ($_SESSION['lis']==7) {echo ('selected=""');}?>>Listado curso vigilancia vencido</option>
	 		<option value="9" <?php if ($_SESSION['lis']==9) {echo ('selected=""');}?>>Listado de finalizacion periodo de prueba</option>
	 		<option value="10" <?php if ($_SESSION['lis']==10) {echo ('selected=""');}?>>Listado de renovaci&oacute;n de contratos</option>
	 		<option value="11" <?php if ($_SESSION['lis']==11) {echo ('selected=""');}?>>Listado de personas por solicitar credencial SVySP</option>
	 		<option value="12" <?php if ($_SESSION['lis']==12) {echo ('selected=""');}?>>Listado de personas con credencial SVySP en tramite</option>
	 		<option value="13" <?php if ($_SESSION['lis']==13) {echo ('selected=""');}?>>Listado de vencimiento cedenciales SVySP</option>
			<option value="15" <?php if ($_SESSION['lis']==15) {echo ('selected=""');}?>>Formato mensual de novedades SVySP</option>
	 		</select>Listado
    		</td>
		</tr>
		<tr>
			<td align="left">
			<select name="cliel" style="WIDTH: 70%">
			<option value="%" <?php  if ($_SESSION['clielis']=="") {echo ('selected=""');}?>>Todos los Clientes</option>
			<?php echo $cadena2;?>
	 		</select>Cliente
    		</td>
		</tr>
		<tr>
			<td align="left">
			<select name="sociol" style="WIDTH: 70%">
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
  $nj='listpersonalactivo.php';
  break;
  case 2:
  $nj='segsoc.php';
  break;
  case 3:
  $nj='listeps.php';
  break;
  case 4:
  $nj='listarp.php';
  break;
  case 5:
  $nj='listafp.php';
  break;
  case 6:
  $nj='listpasado.php';
  break;
  case 7:
  $nj='listcurso.php';
  break;
  case 8:
  $nj='informesvysp.php';
  break;
    case 9:
  $nj='listfinprueba.php';
  break;
  case 10:
  $nj='listfincontrato.php';
  break;
    case 11:
  $nj='listsolcred.php';
  break;
    case 12:
  $nj='listtramcred.php';
  break;
    case 13:
  $nj='listvencecred.php';
  break;
    case 15:
  $nj='formatonovedades.php';
  break;
   default:
   
  $nj='listpersonalactivo.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
</td>
			
		</tr>
		</table>
		<table cellpadding="0" class="tabladocs" width="55%" align="center">
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="WIDTH:30%;" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
		</tr>
	  	<tr>
			<td>
			Documentos Individuales
			</td>
		</tr>
		<tr>
	 		<td>
			<select name="cedpersona" style="WIDTH:70%" >
  	 		<?php echo $cadena;?></select>Persona
			</td>
	 		
		</tr>
		<tr>
			<td>
			<select name="docum" style="width: 70%">
  	 		<option value="1" <?php  if ($_SESSION['cont']==1) {echo ('selected=""');}?>>Contrato por labor u obra</option>
	 		<option value="3" <?php if ($_SESSION['cont']==3) {echo ('selected=""');}?>>Contrato a termino fijo inferior a un a&ntilde;o</option>
	 		<option value="6" <?php if ($_SESSION['cont']==6) {echo ('selected=""');}?>>Contrato a termino fijo  de uno a tres a&ntilde;os</option>
	 		<option value="4" <?php if ($_SESSION['cont']==4) {echo ('selected=""');}?>>Carnet Interno</option>
	 		<option value="5" <?php if ($_SESSION['cont']==5) {echo ('selected=""');}?>>Solicitud credencial SVySP</option>
	 		<option value="7" <?php if ($_SESSION['cont']==7) {echo ('selected=""');}?>>Carta apertura de cuenta</option>
	 		<option value="8" <?php if ($_SESSION['cont']==8) {echo ('selected=""');}?>>Formato hoja de chequeo</option>
	 		<option value="9" <?php if ($_SESSION['cont']==9) {echo ('selected=""');}?>>Paz y salvo para liquidacion de personal</option>
	 		</select>Documento
			</td>
			<td>
			</td>
		</tr>
		<tr>
	 		<td>
			<a href="<?php 
  switch ($_SESSION['cont']):
  case 1:
  $nj='contrato.php';
  break;
  case 3:
  $nj='contrato1.php';
  break;
  case 4:
  $nj='carnetinterno.php';
  break;
  case 5:
  $nj='solicitudcred.php';
  break;
  case 6:
  $nj='contrato3.php';
  break;
   case 7:
  $nj='cartaapertura.php';
  break;
    case 8:
  $nj='hojacheck.php';
  break;
   case 9:
  $nj='pazysalvo.php';
  break;
  
   default:
  $nj='contrato.php';
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
  	 		<?php echo $cadena0;?></select>Persona
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
		$parametros[tabla]="personalactivo";
		$parametros[campos]="";
		$parametros[condiciones]="personalactivo.activo=1";
		echo exportartodo($parametros);
		?>
                <div id="controlex">
     		<table  class="control">
                <tr><td colspan="2" class="arriba" align="center">
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