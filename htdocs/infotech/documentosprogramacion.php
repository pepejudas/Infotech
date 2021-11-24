<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 39);

	formularioactual();
	
		$sqcl="SELECT * FROM dotacion, personalactivo WHERE dotacion.ceduladot=personalactivo.cedula ORDER BY apellidos";
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
			$_SESSION[iddota]=$vector[1];
			
			$boton=0;
		break;
		endswitch;


$sql1r="SELECT * FROM dotacion, personalactivo, clientes WHERE dotacion.pazysalvo IS NULL  AND personalactivo.cedula=dotacion.ceduladot AND personalactivo.codigo=clientes.codigo AND personalactivo.sucursal LIKE '$_SESSION[sucur]' AND personalactivo.activo =1 ORDER BY personalactivo.apellidos, dotacion.iddot";
$resultar=@mysql_query($sql1r);
$inir=1;
$limr=@mysql_num_rows($resultar);

while($inir<=$limr){
if(@mysql_result($resultar,$inir,ceduladot)!=@mysql_result($resultar,$inir-1,ceduladot) || @mysql_result($resultar,$inir,iddot)!=@mysql_result($resultar,$inir-1,iddot)){
		if($_SESSION[cedulamod]==@mysql_result($resultar,$inir-1,ceduladot) and $_SESSION[iddota]==@mysql_result($resultar,$inir-1,iddot)){
			$cadena.="<option selected>".@mysql_result($resultar,$inir-1,ceduladot). " ". @mysql_result($resultar,$inir-1,iddot)." ". @mysql_result($resultar,$inir-1,apellidos)." ".@mysql_result($resultar,$inir-1,nombre)."</option>";
		}else{
			$cadena.="<option>".@mysql_result($resultar,$inir-1,ceduladot). " ". @mysql_result($resultar,$inir-1,iddot)." ". @mysql_result($resultar,$inir-1,apellidos)." ".@mysql_result($resultar,$inir-1,nombre)."</option>";
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
		<title>DOCUMENTOS PROVEEDORES</title>
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
  	 		<option value="nombreprov" <?php  if ($_SESSION['ord']=="nombreprov") {echo ('selected=""');}?>>Nombre Proveedor</option>
  	 		<option value="contacto" <?php  if ($_SESSION['ord']=="contacto") {echo ('selected=""');}?>>Contacto</option>
  	 		<option value="nit" <?php  if ($_SESSION['ord']=="nit") {echo ('selected=""');}?>>Nit</option>
	  		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="nombreprov");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado Proveedores</option>
	 		</select>Listado
	  		</td>
		</tr>

		<tr>
	 		<td align="left">
	  		<a href="<?php 
	  		switch ($_SESSION['lis']):
	  		case 1:
  			$nj='listaproveedores.php';
  			break;
 			default:
  			$nj='listaproveedores.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="proveedores";
		$parametros[campos]="";
		$parametros[condiciones]="proveedores.sucursal LIKE '$_SESSION[sucur]'";
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