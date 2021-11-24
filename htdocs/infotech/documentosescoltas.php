<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 44);

		$sqcl= "SELECT * FROM `personalactivo` LEFT JOIN clientes ON personalactivo.codigo = clientes.codigo WHERE clientescolta = 1 AND personalactivo.activo ='1' ORDER BY apellidos";
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

		while ($reg < $lim){
	
		switch ($_SESSION[cedulamod]):
	 
                case "";
                $cadena=$cadena."<option>"." ". mysql_result($resultadota,$reg,cedula)." ". mysql_result($resultadota,$reg,apellidos)." ".mysql_result($resultadota,$reg,nombre). "</option>";
		$reg++;
		break;
			default:
		if (@mysql_result($resultadota,$reg,"cedula")==$_SESSION[cedulamod]){
		$cadena = $cadena . '<option selected="">'. " " . mysql_result($resultadota,$reg,cedula)." ". mysql_result($resultadota,$reg,apellidos)." " . mysql_result($resultadota,$reg,nombre) . "</option>";
		}else{
		$cadena=$cadena."<option>"." ". mysql_result($resultadota,$reg,cedula)." ". mysql_result($resultadota,$reg,apellidos)." ".mysql_result($resultadota,$reg,nombre). "</option>";
		}$reg++;
		break;
		endswitch;}

			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="cedula";}
			if($_SESSION[cedulamod]==""){$_SESSION[cedulamod]=@mysql_result($resultadota,0,cedula);}

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
	  	<br>
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
  	 		<option value="codigo" <?php  if ($_SESSION['ord']=="codigo") {echo ('selected=""');}?>>Codigo cliente</option>
	 		<option value="cedula" <?php if ($_SESSION['ord']=="cedula") {echo ('selected=""');}?>>Cedula</option>
	 		<option value="apellidos" <?php if ($_SESSION['ord']=="apellidos") {echo ('selected=""');}?>>Apellidos</option>
	 		<option value="fechainicio" <?php if ($_SESSION['ord']=="fechainicio") {echo ('selected=""');}?>>Fecha de inicio</option>
	 		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedula");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected=""');}?>>Reporte de servicios del mes actual</option>
	 		<option value="2" <?php if ($_SESSION['lis']==2) {echo ('selected=""');}?>>Reporte de servicios del mes anterior</option>
	 		<option value="3" <?php if ($_SESSION['lis']==3) {echo ('selected=""');}?>>Reporte de servicios general</option>
	 		<option value="4" <?php if ($_SESSION['lis']==4) {echo ('selected=""');}?>>Reporte de servicios del mes actual excel</option>
	 		<option value="5" <?php if ($_SESSION['lis']==5) {echo ('selected=""');}?>>Reporte de servicios del mes anterior excel</option>
	 		</select>Listado
	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  			switch ($_SESSION['lis']){
  			case 1:
  			$nj='repescoltas1.php';
  			break;
  			case 2:
  			$nj='repescoltas2.php';
  			break;
  			case 3:
  			$nj='repescoltas3.php';
  			break;
  			case 4:
  			$nj='repescoltas4.php';
  			break;
   			case 5:
  			$nj='repescoltas5.php';
  			break;
  			default:
  			$nj='repescoltas1.php';
  			}
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	
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
	 		<td>
			<select name="cedpersona" style="WIDTH:70%" tabindex="1">
  	 		<?php echo $cadena;?></select>Persona
			</td>
		</tr>
		
		<tr>
			<td>
			<select name="docum" style="WIDTH: 70%" tabindex="39">
  	 		<option value="1" <?php  if ($_SESSION['cont']==1) {echo ('selected=""');}?>>Relacion de servicios del mes actual</option>
	 		<option value="2" <?php if ($_SESSION['cont']==2) {echo ('selected=""');}?>>Relacion de servicios del mes anterior</option>
	 		<option value="3" <?php if ($_SESSION['cont']==3) {echo ('selected=""');}?>>Relacion de servicios general</option>
	 		</select>Reporte
  			</td>
		</tr>
		
		<tr>
	 		<td>
			<a href="<?php 
  			switch ($_SESSION['cont']){
  			case 1:
  			$nj='turescoltas1.php';
  			break;
  			case 2:
  			$nj='turescoltas2.php';
  			break;
  			case 3:
  			$nj='turescoltas3.php';
  			break;
 			default:
  			$nj='turescoltas1.php';
  			}
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="escoltas, personalactivo";
		$parametros[campos]="id, personalactivo.cedula, mesreporte, fechainicio, fechafinal, tiempototal, escoltas.codigo";
		$parametros[condiciones]="escoltas.cedula = personalactivo.cedula AND personalactivo.activo=1 AND personalactivo.sucursal LIKE '$_SESSION[sucur]'";
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