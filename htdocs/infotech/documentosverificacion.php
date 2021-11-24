<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 8);

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


			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="apellidos";}

	
//echo  "cedula rimera".@mysql_result($resultadota,0,"cedula");

$coltabla="#67d111"
?>

<html>
		<head>
		<title>DOCUMENTOS VERIFICACION HOJA DE VIDA</title>
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
		</head>
		<body bgcolor="<?php echo $colcuerpo;?>">
				
<!--____________________________________________________________________
		nueva tabla encabezado!!
		---------------------------------------------------------------------->
		
<form method="post" action="<?php echo $PHP_SELF?>">
<center>
	  		</center><br>
		
	<!--____________________________________________________________________
		tabla del cuerpo del formulario donde estan todos los datos!  
		---------------------------------------------------------------------->	 
 		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	
	  	<tr>
	  		<td align="left" colspan="2" >
	  		<input type="submit" style="WIDTH:30%;" size="2" value="cargar" name="ejecut"/>
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
  	 		<option value="apellidos" <?php  if ($_SESSION['ord']=="apellidos") {echo ('selected=""');}?>>Apellidos</option>
  	 		<option value="cedula" <?php  if ($_SESSION['ord']=="cedula") {echo ('selected=""');}?>>Cedula</option>
  	 		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="apellidos");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de comprobacion hoja de vida</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<a href="<?php 
			  switch ($_SESSION['lis']):
  				case 1:
  				$nj='listhojadevida.php';
  				break;
  				default:
  				$nj='listhojadevida.php';
  				endswitch;
  				echo $nj;?>" target="blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	
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