<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 35);

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
  	 		<option value="cedulacontrol" <?php  if ($_SESSION['ord']=="cedulacontrol") {echo ('selected=""');}?>>Cedula</option>
  	 		<option value="fecharegistro" <?php  if ($_SESSION['ord']=="fecharegistro") {echo ('selected=""');}?>>Fecha de registro</option>
  	 		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedulacontrol");}?>
			<option value="0" <?php  if ($_SESSION['lis']==0) {echo ('selected=""');}?>>Soporte de Radioperacion Diario Diurno</option>
			<option value="5" <?php  if ($_SESSION['lis']==5) {echo ('selected=""');}?>>Soporte de Radioperacion Diario Nocturno</option>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Listado de turnos del mes</option>
  	 		<option value="2" <?php  if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Listado de turnos del mes anterior</option>
  	 		<option value="3" <?php  if ($_SESSION['lis']==3) {echo ('selected=""');}?>>Listado de reportes nocturnos mes actual</option>
  	 		<option value="4" <?php  if ($_SESSION['lis']==4) {echo ('selected=""');}?>>Listado de reportes nocturnos mes anterior</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  			switch ($_SESSION['lis']):
  			case 0:
  			$nj='listsoporteradiod.php';
  			break;
  			case 1:
  			$nj='listturnos.php';
  			break;
    		case 2:
  			$nj='listturnosant.php';
  			break;
    		case 3:
  			$nj='listrep.php';
  			break;
    		case 4:
  			$nj='listrepant.php';
  			break;
  			case 5:
  			$nj='listsoporteradion.php';
  			break;
  			default:
  			$nj='listsoporteradiod.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="personalactivo, controlturnos";
		$parametros[campos]="id, nombre, apellidos, fecharegistro, cedulacontrol, mescontrol, d1,	d2,	d3,	d4,	d5,	d6,	d7,	d8,	d9,	d10, d11, d12, d13, d14, d15, d16, d17, d18, d19, d20, d21, d22, d23, d24, d25, d26, d27, d28, d29, d30, d31, n1, n2, n3, n4, n5, n6, n7, n8, n9, n10, n11, n12, n13, n14, n15, n16, n17, n18, n19, n20, n21, n22, n23, n24, n25, n26, n27, n28, n29, n30, n31, cod1, cod2, cod3, cod4, cod5, cod6, cod7, cod8, cod9, cod10, cod11, cod12, cod13, cod14, cod15, cod16, cod17, cod18, cod19, cod20, cod21, cod22, cod23, cod24, cod25, cod26, cod27, cod28, cod29, cod30, cod31, reg1, reg2, reg3, reg4, reg5, reg6, reg7, reg8, reg9, reg10, reg11, reg12, reg13, reg14, reg15, reg16, reg17, reg18, reg19, reg20, reg21, reg22, reg23, reg24, reg25, reg26, reg27, reg28, reg29, reg30, reg31";
		$parametros[condiciones]="personalactivo.cedula = controlturnos.cedulacontrol AND personalactivo.activo=1 AND personalactivo.sucursal LIKE '$_SESSION[sucur]'";
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