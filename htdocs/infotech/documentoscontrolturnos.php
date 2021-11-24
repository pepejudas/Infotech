<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 42);

		switch ($_POST[ejecut]):
		case "cargar":
			
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			
			$_SESSION[lis2]=$_POST[li2];
			$_SESSION['ord2']=$_POST[orden2];
			
			$_SESSION['mes1']=$_POST['mes1'];
			$_SESSION['ano1']=$_POST['ano1'];
                        $_SESSION['dia1']=$_POST['dia1'];
			$_SESSION['mes2']=$_POST['mes2'];
			$_SESSION['ano2']=$_POST['ano2'];
			
			$_SESSION[clientemod]=$_POST[clie];
			
		$boton=0;
		break;
		endswitch;


			if($_SESSION[cont]==""){$_SESSION[cont]=1;}
			if($_SESSION[lis]==""){$_SESSION[lis]=1;}
			if($_SESSION['ord']==""){$_SESSION['ord']="cedulacontrol";}

		
	$mostra[1]="codigo";
	$mostra[2]="nombrecliente";
	$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
	$cadena=selection("clientes","codigo","%",$mostra,$_SESSION[clientemod],2,"codigo",$otras);
	
	$fecha1=getdate(time());
	
	
$r=@require('version.php');
caracteresiso();	
	
$coltabla="#67d111"
?>

<html>
<head>
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
<title>Documentos Control de Servicios</title>
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
			<td align="left">Mes:
			<select name="mes1" class="medio1">
			<option></option>
			<option value="01"<?php if ($_SESSION['mes1']==1){echo 'selected="selected"';}?>>Enero</option>
			<option value="02" <?php if ($_SESSION['mes1']==2){echo 'selected="selected"';}?>>Febrero</option>
			<option value="03" <?php if ($_SESSION['mes1']==3){echo 'selected="selected"';}?>>Marzo</option>
			<option value="04" <?php if ($_SESSION['mes1']==4){echo 'selected="selected"';}?>>Abril</option>
			<option value="05" <?php if ($_SESSION['mes1']==5){echo 'selected="selected"';}?>>Mayo</option>
			<option value="06" <?php if ($_SESSION['mes1']==6){echo 'selected="selected"';}?>>Junio</option>
			<option value="07" <?php if ($_SESSION['mes1']==7){echo 'selected="selected"';}?>>Julio</option>
			<option value="08" <?php if ($_SESSION['mes1']==8){echo 'selected="selected"';}?>>Agosto</option>
			<option value="09" <?php if ($_SESSION['mes1']==9){echo 'selected="selected"';}?>>Septiembre</option>
			<option value="10" <?php if ($_SESSION['mes1']==10){echo 'selected="selected"';}?>>Octubre</option>
			<option value="11" <?php if ($_SESSION['mes1']==11){echo 'selected="selected"';}?>>Noviembre</option>
			<option value="12" <?php if ($_SESSION['mes1']==12){echo 'selected="selected"';}?>>Diciembre</option>
			</select>A&ntilde;o:
			<select name="ano1" class="corto1">
			<option></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]+1){echo 'selected="selected"';}?>><?php $e=$fecha1[year]+1; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]){echo 'selected="selected"';}?>><?php $e=$fecha1[year]; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]-1){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-1; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]-2){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-2; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]-3){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-3; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]-4){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-4; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]-5){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-5; echo $e;?></option>
			<option <?php if ($_SESSION['ano1']==$fecha1[year]-6){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-6; echo $e;?></option>
			</select>
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<select name="orden" style="WIDTH: 70%" tabindex="39">
  	 		<option value="cedulacontrol" <?php  if ($_SESSION['ord']=="cedulacontrol") {echo ('selected="selected"');}?>>Cedula</option>
  	 		<option value="codigo" <?php  if ($_SESSION['ord']=="codigo") {echo ('selected');}?>>Codigo del cliente</option>
  	 		<option value="apellidos" <?php  if ($_SESSION['ord']=="apellidos") {echo ('selected');}?>>Apellidos</option>
  	 		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedulacontrol");}?>
  	 		<option value="3" <?php  if ($_SESSION['lis']==3) {echo ('selected');}?>>Reporte control de turnos Diario</option>
                        <option value="1" <?php  if ($_SESSION['lis']==1) {echo ('selected');}?>>Reporte control de turnos en excel</option>
  	 		<option value="2" <?php  if ($_SESSION['lis']==2) {echo ('selected');}?>>Reporte control de turnos SVYSP en excel</option>
			<option value="4" <?php  if ($_SESSION['lis']==4) {echo ('selected');}?>>Reporte planillas SVYSP html</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  			switch ($_SESSION['lis']):
  			case 1:
  			$nj='nomina.php';
  			break;
  			case 2:
  			$nj='planillas.php';
  			break;
            case 3:
  			$nj='reportediario.php';
  			break;
 			case 4:
  			$nj='plansvysp.php';
  			break;
   			default:
  			$nj='nomina.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
		<br>
		
		<table cellpadding="0"  class="tabladocs" width="55%" align="center">
	  	
	  	<tr>
	  		<td align="left" colspan="3" >
	  		<input type="submit" style="WIDTH:30%;" size="2" value="cargar" name="ejecut" src="imagenes/aa_19.gif">
			</td>
		</tr>
	  		  	
	  	<tr>
	  		<td align="left" width="50%">
	  		Documentos Individuales
			</td>
		</tr>
		
		<tr>
			<td align="left">Mes:
			<select name="mes2" class="medio1">
			<option></option>
			<option value="01"<?php if ($_SESSION['mes2']==1){echo 'selected="selected"';}?>>Enero</option>
			<option value="02" <?php if ($_SESSION['mes2']==2){echo 'selected="selected"';}?>>Febrero</option>
			<option value="03" <?php if ($_SESSION['mes2']==3){echo 'selected="selected"';}?>>Marzo</option>
			<option value="04" <?php if ($_SESSION['mes2']==4){echo 'selected="selected"';}?>>Abril</option>
			<option value="05" <?php if ($_SESSION['mes2']==5){echo 'selected="selected"';}?>>Mayo</option>
			<option value="06" <?php if ($_SESSION['mes2']==6){echo 'selected="selected"';}?>>Junio</option>
			<option value="07" <?php if ($_SESSION['mes2']==7){echo 'selected="selected"';}?>>Julio</option>
			<option value="08" <?php if ($_SESSION['mes2']==8){echo 'selected="selected"';}?>>Agosto</option>
			<option value="09" <?php if ($_SESSION['mes2']==9){echo 'selected="selected"';}?>>Septiembre</option>
			<option value="10" <?php if ($_SESSION['mes2']==10){echo 'selected="selected"';}?>>Octubre</option>
			<option value="11" <?php if ($_SESSION['mes2']==11){echo 'selected="selected"';}?>>Noviembre</option>
			<option value="12" <?php if ($_SESSION['mes2']==12){echo 'selected="selected"';}?>>Diciembre</option>
			</select>A&ntilde;o:
			<select name="ano2" class="corto1">
			<option></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]+1){echo 'selected="selected"';}?>><?php $e=$fecha1[year]+1; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]){echo 'selected="selected"';}?>><?php $e=$fecha1[year]; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]-1){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-1; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]-2){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-2; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]-3){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-3; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]-4){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-4; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]-5){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-5; echo $e;?></option>
			<option <?php if ($_SESSION['ano2']==$fecha1[year]-6){echo 'selected="selected"';}?>><?php $e=$fecha1[year]-6; echo $e;?></option>
			</select>
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<select name="orden2" style="WIDTH: 70%" tabindex="39">
  	 		<option value="cedulacontrol" <?php  if ($_SESSION['ord2']=="cedulacontrol") {echo ('selected');}?>>Cedula</option>
  	 		<option value="apellidos" <?php  if ($_SESSION['ord2']=="apellidos") {echo ('selected');}?>>Apellidos</option>
  	 		</select>Orden
			</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="li2" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord2']=="") {echo ($_SESSION['ord2']=="cedulacontrol");}?>
  	 		<option value="1" <?php  if ($_SESSION['lis2']==1) {echo ('selected');}?>>Reporte control de turnos en excel</option>
  	 		</select>Listado
  	  		</td>
		</tr>
		
		<tr>
			<td align="left">
			<select name="clie" style="WIDTH: 70%" tabindex="39">
			<?php  echo $cadena;?>
  	 		</select>Cliente
  	  		</td>
		</tr>
		
		<tr>
	  		<td align="left">
	  		<a href="<?php 
  			switch ($_SESSION['lis2']):
  			case 1:
  			$nj='nominaclie.php';
  			break;
  			case 2:
  			$nj='nominaclieant.php';
  			break;
   			default:
  			$nj='nominaclie.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form><br/>
	 	
	 	<?php 
		$parametros[tabla]="controlturnos, personalactivo";
		$parametros[campos]="id, nombre, apellidos, fecharegistro, cedulacontrol, mescontrol, d1,	d2,	d3,	d4,	d5,	d6,	d7,	d8,	d9,	d10, d11, d12, d13, d14, d15, d16, d17, d18, d19, d20, d21, d22, d23, d24, d25, d26, d27, d28, d29, d30, d31, n1, n2, n3, n4, n5, n6, n7, n8, n9, n10, n11, n12, n13, n14, n15, n16, n17, n18, n19, n20, n21, n22, n23, n24, n25, n26, n27, n28, n29, n30, n31, cod1, cod2, cod3, cod4, cod5, cod6, cod7, cod8, cod9, cod10, cod11, cod12, cod13, cod14, cod15, cod16, cod17, cod18, cod19, cod20, cod21, cod22, cod23, cod24, cod25, cod26, cod27, cod28, cod29, cod30, cod31, reg1, reg2, reg3, reg4, reg5, reg6, reg7, reg8, reg9, reg10, reg11, reg12, reg13, reg14, reg15, reg16, reg17, reg18, reg19, reg20, reg21, reg22, reg23, reg24, reg25, reg26, reg27, reg28, reg29, reg30, reg31";
		$parametros[condiciones]="controlturnos.cedulacontrol = personalactivo.cedula AND personalactivo.activo = 1 AND personalactivo.sucursal LIKE '$_SESSION[sucur]'";
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