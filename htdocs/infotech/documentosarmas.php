<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 23);

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
			if($_SESSION['ord']==""){$_SESSION['ord']="serial";}

	
//echo  "cedula rimera".@mysql_result($resultadota,0,"cedula");

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
		<body>

		<form method="post" action="<?php echo $PHP_SELF?>"><br/>
 		<table cellpadding="0" class="tabladocs" width="55%" align="center">
	  	
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="width:150px" size="2" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
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
  	 		<option value="serial" <?php  if ($_SESSION['ord']=="serial") {echo ('selected=""');}?>>Serial</option>
  	 		<option value="tipoarma" <?php  if ($_SESSION['ord']=="tipoarma") {echo ('selected=""');}?>>Tipo de arma</option>
  	 		<option value="calibre" <?php  if ($_SESSION['ord']=="calibre") {echo ('selected=""');}?>>Calibre</option>
  	 		<option value="vencesalvoconducto" <?php  if ($_SESSION['ord']=="vencesalvoconducto") {echo ('selected=""');}?>>Fecha de vencimiento salvoconducto</option>
  	 		<option value="codigo" <?php  if ($_SESSION['ord']=="codigo") {echo ('selected=""');}?>>Codigo cliente</option>
	  		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="serial");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de armas asignadas</option>
  	 		<option value="2" <?php  if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Listado de vencimiento salvoconductos</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  			switch ($_SESSION['lis']):
  			case 1:
  			$nj='listarmas.php';
  			break;
   			case 2:
		  	$nj='listvencesalvoc.php';
  			break;
  			default:
  			$nj='listarmas.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><input type="button" style="width:150px;" size="2" value="Generar" name="ejecut" src="imagenes/aa_19.gif"></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="armas, clientes";
		$parametros[campos]="id, serial, tipoarma, marca, calibre, clasepermiso, armas.codigo, salvoconducto, vencesalvoconducto, observacionarma, nombrecliente";
		$parametros[condiciones]="armas.codigo LIKE clientes.codigo AND clientes.activo = 1 AND clientes.sucursal LIKE '$_SESSION[sucur]'";
		echo exportartodo($parametros);
		?>
	 	
	 	<div id="controlex">
     		<table  class="control">
     		<tr height="150px"><td colspan="2" class="arriba" align="center">
                Documentos
     		</td>
     		</tr>
     		</table>
                <div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
                </div>