<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 25);

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
			if($_SESSION['ord']==""){$_SESSION['ord']="serie";}
			if($_SESSION[cedulamod]==""){$_SESSION[cedulamod]=@mysql_result($resultadota,0,cedula);}
	
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
		<body bgcolor="<?php echo $colcuerpo;?>">
		<form method="post" action="<?php echo $PHP_SELF?>"><br>
 		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="WIDTH:30%;" size="2" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
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
  	 		<option value="serie" <?php  if ($_SESSION['ord']=="serie") {echo ('selected=""');}?>>Serie</option>
  	 		<option value="marca" <?php  if ($_SESSION['ord']=="marca") {echo ('selected=""');}?>>Marca</option>
  	 		<option value="codigo" <?php  if ($_SESSION['ord']=="codigo") {echo ('selected=""');}?>>Codigo del cliente</option>
  	 		<option value="modelo" <?php  if ($_SESSION['ord']=="modelo") {echo ('selected=""');}?>>Modelo</option>
	  		</select>Orden
			</td>
		</tr>
		
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedula");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de radios asignados</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  			switch ($_SESSION['lis']):
  			case 1:
  			$nj='listradios.php';
  			break;
  			default:
  			$nj='listradios.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="radios, clientes";
		$parametros[campos]="consecutivo, serie, marca, tipo, radios.codigo, modelo, observacionradio, sucursal";
		$parametros[condiciones]="radios.codigo LIKE clientes.codigo AND clientes.sucursal LIKE '$_SESSION[sucur]'";
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