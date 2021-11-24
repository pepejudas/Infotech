<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 15);

		switch ($_POST[ejecut]):
		case "cargar":
			//$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			
			
			$_SESSION[lis2]=$_POST[li2];
			$_SESSION['ord2']=$_POST[orden2];
			
			$_SESSION[idprodmod]=$_POST[idprod];
			
			break;
		endswitch;

			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="nombreprod";}

//cargar listado de productos almacenados

$sql1="SELECT * FROM productos";
$cons=@mysql_query($sql1);
$ini=0;
$lim=@mysql_num_rows($cons);
while($ini<$lim){
	if($_SESSION[idprodmod]==@mysql_result($cons,$ini,id)."$1"){
	$cadena.="<option value=\"".@mysql_result($cons,$ini,id)."$1"."\" selected>N ". @mysql_result($cons,$ini,nombreprod). " ".@mysql_result($cons,$ini,referencia)."</option>";
	$cadena.="<option value=\"".@mysql_result($cons,$ini,id)."$2"."\">U ". @mysql_result($cons,$ini,nombreprod). " ".@mysql_result($cons,$ini,referencia)."</option>";
	}elseif($_SESSION[idprodmod]==@mysql_result($cons,$ini,id)."$2"){
	$cadena.="<option value=\"".@mysql_result($cons,$ini,id)."$1"."\" >N ". @mysql_result($cons,$ini,nombreprod). " ".@mysql_result($cons,$ini,referencia)."</option>";
	$cadena.="<option value=\"".@mysql_result($cons,$ini,id)."$2"."\" selected>U ". @mysql_result($cons,$ini,nombreprod). " ".@mysql_result($cons,$ini,referencia)."</option>";
	}else{
	$cadena.="<option value=\"".@mysql_result($cons,$ini,id)."$1"."\">N ". @mysql_result($cons,$ini,nombreprod)." ".@mysql_result($cons,$ini,referencia). "</option>";	
	$cadena.="<option value=\"".@mysql_result($cons,$ini,id)."$2"."\">U ". @mysql_result($cons,$ini,nombreprod)." ".@mysql_result($cons,$ini,referencia). "</option>";
}
$ini++;
}
$coltabla="#67d111"
?>

<html>
		<head>
		<title>Documentos Existencias</title>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function cerrarventana(){
		var ventana = window.close();
		}
		//-->
		</script>
		</head>
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
		<body bgcolor="<?php echo $colcuerpo;?>">
		
<form method="post" action="<?php echo $PHP_SELF?>">
<center>
	  		</center><br>
		
 		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
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
	  		</td>
		</tr>
				
		<tr>
	  		<td align="left">
	  		<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="nombreprod");}?>
	  		<select name="orden" style="WIDTH: 70%" tabindex="39">
  	 		<option value="nombreprod" <?php  if ($_SESSION['ord']=="nombreprod") {echo ('selected=""');}?>>Nombre Producto</option>
  	 		<option value="referencia" <?php  if ($_SESSION['ord']=="referencia") {echo ('selected');}?>>Referencia</option>
  	 		<option value="modelo" <?php  if ($_SESSION['ord']=="modelo") {echo ('selected');}?>>Modelo</option>
  	 		<option value="marca" <?php  if ($_SESSION['ord']=="marca") {echo ('selected');}?>>Marca</option>
  	 		<option value="precio" <?php  if ($_SESSION['ord']=="precio") {echo ('selected');}?>>Precio</option>
  	 		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Reporte Total de Inventarios</option>
  	 		</select>Listado
  	  		</td>
		</tr>

		<tr>
	  		<td align="left">
	  		<a href="<?php 
  switch ($_SESSION['lis']):
  case 1:
  $nj='listaexistencias.php';
  break;
  default:
  $nj='listaexistencias.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	<tr>
	  		<td align="left">
	  		<input type="submit" style="WIDTH:30%;" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
		</tr>
	  	<tr>
	  		<td align="left" width="50%">
	  		Documentos Particulares
			</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<select name="idprod" style="WIDTH: 70%" tabindex="39">
	  		<?php echo $cadena;?>
  	 		</select>Producto
			</td>
		</tr>
		<tr>
			<td align="left">
			<select name="li2" style="WIDTH: 70%" tabindex="39">
  	 		<option value="1" <?php  if ($_SESSION['lis2']==1) {echo ('selected=""');}?>>Formato de control de existencias</option>
  	 		</select>Formato
  	  		</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  switch ($_SESSION['lis2']):
  case 1:
  $nj='formatocontrolex.php';
  break;
  default:
  $nj='formatocontrolex.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
		
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="movproductos, productos";
		$parametros[campos]="nombreprod, productos.id, idprod, fecha, cantidad, facturaoreq, remisionocom, eos, observacionesreg, sucursal";
		$parametros[condiciones]="movproductos.idprod = productos.id AND movproductos.sucursal LIKE '$_SESSION[sucur]'";
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