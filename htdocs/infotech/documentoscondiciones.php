<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 33);

		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$vector=explode(" ",$_POST[docum]);
			$wced=$vector[0];
			$_SESSION[cedulamod]=$wced;
			
			$_SESSION[cont]=$_POST[formato];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			$vector=explode(" ", $_POST[docum]);
			$_SESSION[ofertamod]=$vector[0];
			
						
		$boton=0;
		break;
		endswitch;

			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="nit";}

	$sql1="SELECT * FROM condicionescliente, clientes WHERE condicionescliente.codigo LIKE clientes.codigo and condicionescliente.sucursal LIKE '$_SESSION[sucur]' ORDER BY numerooferta DESC";
	$resultaclie=@mysql_query($sql1);
	$reg=0;
	$lim=@mysql_num_rows($resultaclie);


	
while ($reg < $lim){
	
	switch ($_SESSION[ofertamod]):
	 
			case "";
			$cadena=$cadena."<option>". mysql_result($resultaclie,$reg,numerooferta)." ".mysql_result($resultaclie,$reg,nombrecliente). "</option>";
		$reg++;
		break;
			default:
		if (@mysql_result($resultaclie,$reg,"numerooferta")==$_SESSION[ofertamod]){
		//echo "garnovironcha";
		$cadena = $cadena . '<option selected="">'. mysql_result($resultaclie,$reg,numerooferta)." " . mysql_result($resultaclie,$reg,nombrecliente) . "</option>";
		}else{
		$cadena=$cadena."<option>". mysql_result($resultaclie,$reg,numerooferta)." ".mysql_result($resultaclie,$reg,nombrecliente). "</option>";
		}$reg++;
		break;
		
		
		endswitch;
		}

$r=@require('version.php');
caracteresiso();
$coltabla="#67d111"
?>
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
		
	<!--____________________________________________________________________
		tabla del cuerpo del formulario donde estan todos los datos!  
		---------------------------------------------------------------------->	 
 		<table cellpadding="0" width="55%" align="center" class="tabladocs">
	  	
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="WIDTH:30%;" size="2" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
			
	 		
		</tr>
	  		  	
	  	<tr>
			<td>
			Documentos Individuales
			</td>
		</tr>
		
		<tr>
	 		<td align=left>
	 		<select name="docum" style="WIDTH: 70%" tabindex="39">
  	 		<?php echo $cadena;?>
	 		</select>Oferta
	 		</td>
		</tr>
		
		
		<tr>
			<td>
			<select name="formato" style="WIDTH:70%" tabindex="39">
  	 		<option value="1" <?php  if ($_SESSION['cont']==1) {echo ('selected=""');}?>>Formato de Instalaci&oacute;n de Servicio</option>
  	 		<option value="2" <?php  if ($_SESSION['cont']==2) {echo ('selected=""');}?>>Formato de condiciones de instalacion</option>
	 		</select>Documento
			</td>
		</tr>
		<tr>
	 		<td>
	 		<a href="<?php 
  switch ($_SESSION['cont']):
  case 1:
  $nj='formatoinstalacion.php';
  break;
  case 2:
  $nj='formatocondiciones.php';
  break;
  default:
  $nj='formatoinstalacion.php';
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
