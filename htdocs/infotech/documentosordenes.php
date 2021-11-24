<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 37);

		$sqcl="SELECT * FROM `ordenes` WHERE ordenes.sucursal LIKE '$_SESSION[sucur]' ORDER BY numorden DESC LIMIT 100";
		$resultadota = mysql_query($sqcl);
		$reg=0;
		$ordenescargadas="";
		$lim= mysql_num_rows($resultadota);
				
		switch ($_POST[ejecut]):
		case "cargar":
			$_SESSION['i']=0;
			$vector=explode(" ",$_POST[li]);
			$_SESSION[ordenc]=$vector[0];
			$_SESSION[lis]=$_POST[lis];
			$_SESSION[ord]=$_POST[ord];
			
		$boton=0;
		break;
		endswitch;
		
		if($_SESSION[ordenc]==""){
		$_SESSION[ordenc]=@mysql_result($resultadota,$lim-1,numorden);
		}

		while ($reg < $lim){
	
		switch ($_SESSION[ordenc]):
	 
			case "";
			$ordenescargadas=$ordenescargadas."<option>"." ". mysql_result($resultadota,$reg,numorden)." ". mysql_result($resultadota,$reg,codcliente)." ".mysql_result($resultadota,$reg,cedremplazado)." ".mysql_result($resultadota,$reg,cedremplazo). " ".mysql_result($resultadota,$reg,fecha)."</option>";
		$reg++;
		break;
			default:
		if (@mysql_result($resultadota,$reg,numorden)==$_SESSION[ordenc]){
		$ordenescargadas = $ordenescargadas . '<option selected="">'. " " . mysql_result($resultadota,$reg,numorden)." ". mysql_result($resultadota,$reg,codcliente)." " . mysql_result($resultadota,$reg,cedremplazado) ." ".mysql_result($resultadota,$reg,cedremplazo). " ".mysql_result($resultadota,$reg,fecha)."</option>";
		}else{
		$ordenescargadas=$ordenescargadas."<option>"." ". mysql_result($resultadota,$reg,numorden)." ". mysql_result($resultadota,$reg,codcliente)." ".mysql_result($resultadota,$reg,cedremplazado). " " .mysql_result($resultadota,$reg,cedremplazo). " ".mysql_result($resultadota,$reg,fecha)."</option>";
		}$reg++;
		break;
		endswitch;}

$coltabla="#67d111";



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
		<title>Documentos Ordenes de Servicio</title>
		</head>
		<body bgcolor="<?php echo $colcuerpo;?>">

<form method="post" action="<?php echo $PHP_SELF?>">
<center>
	  		</center><br>
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
	 		<td align=left>
	 		<select name="li" style="WIDTH: 70%" tabindex="39">
			<?php  if ($_SESSION['ord']=="") {echo ($_SESSION['ord']=="cedula");}
                                            echo $ordenescargadas;
                                           ?>
  	 		</select>Orden de Compra
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
	 		<td align=left>
	 		<a href="<?php 
  			switch ($_SESSION['lis']):
  			case 1:
  			$nj='orden.php';
  			break;
  			default:
  			$nj='orden.php';
  			endswitch;
  			echo $nj;?>" target="_blank"><img height="20" alt="" src="imagenes/as01.gif" border=""></a>
			</td>
		</tr>
		</table>
	 	</form>
	 	
	 	<?php 
		$parametros[tabla]="ordenes";
		$parametros[condiciones]="ordenes.sucursal LIKE '$_SESSION[sucur]'";
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