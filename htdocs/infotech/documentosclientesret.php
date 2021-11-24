<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 29);

		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$vector=explode(" ",$_POST[cedpersona]);
			$wced=$vector[0];
			$_SESSION[cedulamod]=$wced;
			
			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			$vector=explode(" ", $_POST[cliemod]);
			$_SESSION[clientemod]=$vector[0];
			
						
		$boton=0;
		break;
		endswitch;


			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="nit";}
			if($_SESSION[clientemod]==""){}
	

	$sql1="SELECT * FROM clientes ORDER BY codigo";
	$resultaclie=@mysql_query($sql1);
	$reg=0;
	$lim=@mysql_num_rows($resultaclie);


	
while ($reg < $lim){
	
	switch ($_SESSION[clientemod]):
	 
			case "";
			$cadena=$cadena."<option>". mysql_result($resultaclie,$reg,codigo)." ".mysql_result($resultaclie,$reg,nombrecliente). "</option>";
		$reg++;
		break;
			default:
		if (@mysql_result($resultaclie,$reg,"codigo")==$_SESSION[clientemod]){
		$cadena = $cadena . '<option selected="">'. mysql_result($resultaclie,$reg,codigo)." " . mysql_result($resultaclie,$reg,nombrecliente) . "</option>";
		}else{
		$cadena=$cadena."<option>". mysql_result($resultaclie,$reg,codigo)." ".mysql_result($resultaclie,$reg,nombrecliente). "</option>";
		}$reg++;
		break;
		endswitch;
		}


$coltabla="#67d111"
?>

<html>
<head>
<title>DOCUMENTOS CLIENTES INACTIVOS</title>
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
<center>
	  		</center><br>
		
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
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de clientes Inactivos</option>
  	 		<option value="2" <?php  if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Listado de clientes Inactivos Con administradores</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  switch ($_SESSION['lis']):
  case 1:
  $nj='listcliecompletoret.php';
  break;
  case 2:
  $nj='listclieadminret.php';
  break;
  default:
  $nj='listcliecompletoret.php';
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