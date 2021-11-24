<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 21);

		$sqcl="SELECT * FROM dotacion INNER JOIN departamentos ON dotacion.ceduladot=departamentos.codigo ORDER BY codigo";
		$resultadota = mysql_query($sqcl);
		$reg=0;
		$cadena="";
		$lim= mysql_num_rows($resultadota);
		$cad =$_POST[coddepto];
		$array = explode (" ", $cad);
		
		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			$_SESSION[iddota]=$_POST[coddepto];
			
			$boton=0;
		break;
		endswitch;


$sql1r="SELECT * FROM dotacion INNER JOIN departamentos ON departamentos.codigo=dotacion.ceduladot WHERE departamentos.sucursal LIKE '$_SESSION[sucur]' ORDER BY fechaent DESC LIMIT 100";
$resultar=@mysql_query($sql1r);
$inir=1;
$limr=@mysql_num_rows($resultar);

while($inir<=$limr){
if(@mysql_result($resultar,$inir,ceduladot)!=@mysql_result($resultar,$inir-1,ceduladot) || @mysql_result($resultar,$inir,iddot)!=@mysql_result($resultar,$inir-1,iddot)){
		if($_SESSION[cedulamod]==@mysql_result($resultar,$inir-1,ceduladot) and $_SESSION[iddota]==@mysql_result($resultar,$inir-1,iddot)){
			$cadena.="<option value=\"".@mysql_result($resultar,$inir-1,iddot)."\" selected=\"selected\">".@mysql_result($resultar,$inir-1,iddot)." ".@mysql_result($resultar,$inir-1,ceduladot). " ". @mysql_result($resultar,$inir-1,nombrecliente)."</option>";
		}else{
			$cadena.="<option value=\"".@mysql_result($resultar,$inir-1,iddot)."\">".@mysql_result($resultar,$inir-1,iddot)." ".@mysql_result($resultar,$inir-1,ceduladot). " ". @mysql_result($resultar,$inir-1,nombrecliente)."</option>";
		}
}
$inir++;}
			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="ceduladot";}
			if($_SESSION[cedulamod]==""){$_SESSION[cedulamod]=@mysql_result($resultadota,0,cedula);}
	
$coltabla="#67d111"
?>

<html>
		<head>
		<title>Documentos Dotacion Interna</title>
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
  	 		<option value="codigo"      <?php  if ($_SESSION['ord']=="codigo") 	{echo ('selected=""');}?>>Codigo</option>
  	 		<option value="nombredepto" <?php  if ($_SESSION['ord']=="nombredepto") {echo ('selected=""');}?>>Nombre Departarmento</option>
  	 		<option value="responsable" <?php  if ($_SESSION['ord']=="responsable") {echo ('selected=""');}?>>Responsable</option>
	  		</select>Orden
			</td>
		</tr>

		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="codigo");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado Departamentos sin paz y salvo almacen</option>
	 		</select>Listado
	  		</td>
		</tr>

		<tr>
	 		<td align="left">
	  		<a href="<?php
	  		switch ($_SESSION['lis']):
	  		case 1:
  			$nj='pazsalvoalm.php';
  			break;
 			default:
  			$nj='pazsalvoalm.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
                        
	 	</form>
	 	
	 	<form method="post" action="<?php echo $PHP_SELF?>">
	  		<br>
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
			<select name="coddepto" style="WIDTH:70%" tabindex="1">
  	 		<?php echo decod($cadena);?></select>Departamento 
  	 		</td>
		</tr>
		
		<tr>
			<td>
			<select name="docum" style="WIDTH: 70%" tabindex="39">
				<?php  if ($_SESSION['cont']=="") {echo ($_SESSION['cont']=="2");}?>
	 		<option value="2" <?php if ($_SESSION['cont']==2) {echo ('selected=""');}?>>Kardex entrega de dotacion</option>
	 		<option value="3" <?php if ($_SESSION['cont']==3) {echo ('selected=""');}?>>Comprobante de salida</option>
	 		<option value="4" <?php if ($_SESSION['cont']==4) {echo ('selected=""');}?>>Paz y Salvo Almac&eacute;n</option>
	 		</select>Documento
			</td>
		</tr>

		<tr>
	 		<td>
			<a href="<?php 
  switch ($_SESSION['cont']):
  case 2:
  $nj='entregadotacion.php';
  break;
  case 3:
  $nj='comprobantesalida.php';
  break;
  case 4:
  $nj='pazysalvo.php';
  break;
  default:
  $nj='entregadotacion.php';
  endswitch;
  echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
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