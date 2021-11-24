<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 10);

//busqueda de personas
		$sqcl="SELECT * FROM `personalactivo` ORDER BY apellidos";
	//	echo $sqcl;
		$resultadota = mysql_query($sqcl);
		$reg=0;
		$cadena="";
		$lim= mysql_num_rows($resultadota);
		$cad =$_POST[cedpersona];
		$array = explode (" ", $cad);
		
		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$vector=explode(" ",$_POST[cedpersona]);
			$wced=$vector[0];
			$_SESSION[cedulamod]=$wced;
			
			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			
						
		$boton=0;
		break;
		endswitch;


			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="cedula";}
			if($_SESSION[cedulamod]==""){$_SESSION[cedulamod]=@mysql_result($resultadota,0,cedula);}
	
//echo  "cedula rimera".@mysql_result($resultadota,0,"cedula");

$coltabla="#67d111"
?>

<html>
		<head>
		<title>DOCUMENTOS NOVEDADES</title>
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
  	 		<option value="cedula" <?php  if ($_SESSION['ord']=="cedula") {echo ('selected=""');}?>>Cedula</option>
  	 		<option value="fechanov" <?php  if ($_SESSION['ord']=="fechanov") {echo ('selected=""');}?>>Fecha novedad</option>
  	 		<option value="codcliente" <?php  if ($_SESSION['ord']=="codcliente") {echo ('selected=""');}?>>Codigo del cliente</option>
  	 		<option value="ingresadopor" <?php  if ($_SESSION['ord']=="ingresadopor") {echo ('selected=""');}?>>Usuario que ingres&oacute;</option>
	  		</select>Orden
			</td>
		</tr>
		
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedula");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de faltas general</option>
  	 		<option value="2" <?php  if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Listado de faltas del mes</option>
  	 		<option value="3" <?php  if ($_SESSION['lis']==3) {echo ('selected=""');}?>>Listado de faltas del dia</option>
	 		</select>Listado
  
	  		</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  switch ($_SESSION['lis']):
  case 1:
  $nj='listnovedades.php';
  break;
  case 2:
  $nj='listnovedadesmes.php';
  break;
  case 3:
  $nj='listnovedadesdia.php';
  break;
 default:
  $nj='listnovedades.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="personalactivo, novedades";
		$parametros[campos]="novedades.cedula, nombre, apellidos, consecutivo, novedad, fechanov, fechareg, ingresadopor, observacionesfalta, codcliente";
		$parametros[condiciones]="personalactivo.cedula = novedades.cedula AND personalactivo.activo=1 AND personalactivo.sucursal LIKE '$_SESSION[sucur]'";
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