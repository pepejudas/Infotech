<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 40);
	
	switch($_SESSION[mes]){
case "January":
	$mesbusc="01";
break;
case "February":
	$mesbusc="02";
break;	
case "March":
	$mesbusc="03";
break;
case "April":
	$mesbusc="04";
break;
case "May":
	$mesbusc="05";
break;
case "June":
	$mesbusc="06";
break;
case "July":
	$mesbusc="07";
break;
case "August":
	$mesbusc="08";
break;
case "September":
	$mesbusc="09";
break;
case "October":
	$mesbusc="10";
break;
case "November":
	$mesbusc="11";
break;
case "December":
	$mesbusc="12";
break;

}
	
	
$sql1 = "SELECT * FROM `ordenes`,`personalactivo` WHERE (`cedremplazado` = '$_SESSION[cedulamod]' OR `cedremplazo`='$_SESSION[cedulamod]') AND `personalactivo`.`cedula` = `ordenes`.`cedremplazado` AND `ordenes`.`fecha` LIKE '$_SESSION[anotriple]-$mesbusc%'";
$sql2 = "SELECT * FROM `ordenes`,`personalactivo` WHERE (`cedremplazado` = '$_SESSION[cedulamod]' OR `cedremplazo`='$_SESSION[cedulamod]') AND `personalactivo`.`cedula` = `ordenes`.`cedremplazo` AND `ordenes`.`fecha` LIKE '$_SESSION[anotriple]-$mesbusc%'";

//echo $sql1."<br/>";
//echo $sql2."<br/>";
$res1 = @mysql_query($sql1);
$res2 = @mysql_query($sql2);
$lim1 = @mysql_num_rows($res1);
$lim2 = @mysql_num_rows($res2);
$ini=0;
//echo $lim1."<br/>";;


while($ini<$lim1){
	
	$orden=@mysql_result($res1,$ini,numorden);
	$remplazado=@mysql_result($res1,$ini,nombre)." ".@mysql_result($res1,$ini,apellidos);
	$remplazo=@mysql_result($res2,$ini,nombre)." ".@mysql_result($res2,$ini,apellidos);
	$cod=@mysql_result($res2,$ini,codcliente);
	$fecha=@mysql_result($res2,$ini,fecha);
	$moti=@mysql_result($res2,$ini,motivo);
	
	switch($ini){
		case 0:
		$cadena="<table class='tablaprinc'><tr><td align='center'><b>Orden No</b></td><td align='center'><b>Reeplazado</b></td><td align='center'><b>Reemplazante</b></td><td align='center'><b>Fecha</b></td><td align='center'><b>Cliente</b></td><td  align='center'><b>Motivo</b></td></tr>";
		$cadena.="<tr><td>&nbsp;$orden&nbsp;</td><td>&nbsp;$remplazo&nbsp;</td><td>&nbsp;$remplazado&nbsp;<td>&nbsp;$fecha&nbsp;</td><td>&nbsp;$cod&nbsp;</td><td>&nbsp;$moti&nbsp;</td></tr>";	
		break;
		//case ($lim1-1):
		//$cadena.="<tr><td>$orden</td><td>$remplazo</td><td>$remplazado<td>$fecha</td><td>$cod</td><td>$moti</td></tr>";
		//break;
		default:
		$cadena.="<tr><td>&nbsp;$orden&nbsp;</td><td>&nbsp;$remplazo&nbsp;</td><td>&nbsp;$remplazado&nbsp;<td>&nbsp;$fecha&nbsp;</td><td>&nbsp;$cod&nbsp;</td><td>&nbsp;$moti&nbsp;</td></tr>";
		break;			
	}
	
	$ini++;
}

	
$r=@require('version.php');
		caracteresiso();	
				
		$colcuerpo="#FAFAFA";
		$coltabla="#DEDEbb";
?>
<link rel="stylesheet" href="estilo2.css" type="text/css">
</head>
<body>
<center><br/><h1>Novedades en Ordenes de Trabajo</h1><br/>
<?php echo $cadena; ?></center>
</body>
</html>
<?php	
//echo $cadena;  
/*
		while (list($name, $value) = each($HTTP_POST_VARS)) { echo " POST $name = $value<br>\n";
		}
		while (list($name, $value) = each($HTTP_SESSION_VARS)) { echo "SESSION $name = $value<br>\n";
		}*/
?>