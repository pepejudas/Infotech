<?php
session_start();
$a = "localhost";
@$link = mysql_connect($a, $_SESSION['usua'],"");
mysql_select_db("empresasvigilancia",$link);

/******************************************************************************
para comprobacion del requerimiento de autentificacion y enlace con bd mysql
******************************************************************************/

	if (!$link){
		echo "<br>\n<h2>primero debe ingresar a la pagina de autentificacion de usuarios!</h2>";
		echo "<h3><div align=left><A HREF=\"index.php\">Inicio</A></div><h3>";
	exit();
	}
	if (! mysql_select_db("empresasvigilancia",$link)){
	exit();
	}
	if ($_SESSION['usua']=="vigilantes" or $_SESSION['usua']=="radiooperadores"){
		echo "<br>\n<h2>No tiene permiso para acceder a esta informacion</h2>";
		echo "<h3><div align=left><A HREF=\"inicio.php\">Inicio</A></div><h3>";
		echo "<h3><div align=left><A HREF=\"index.php\">Salir</A></div><h3>";
	exit();
	}
//consulta de fecha

$fecha=getdate(time());
$cad=$fecha[month].$fecha[year];


//consulta de socios

$p=0;
$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=mysql_query($sql2);
$li=mysql_num_rows($result2);

  include_once "Spreadsheet/Excel/Writer.php";
  $xls =& new Spreadsheet_Excel_Writer();
  $xls->send("reportecontrolturnos.xls");

while($p<$li){
	$nombresocio=mysql_result($result2,$p,nombres);
	//$idsocio=mysql_result($result2,$p,id);	
  	$sheet =& $xls->addWorksheet($nombresocio);
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,'cedula',$format);
	$sheet->write(0,1,'apellidos y nombres',$format);

	//$cont='$fila'.$idsocio;
	
	
	for($i=1;$i<32;$i++){
	$bs='dia'.$i;
	$sheet->write(0,$i+2,$bs,$format);	
	}
	for($i=34;$i<65;$i++){
	$m=$i-33;
	$bus='cod'.$m;
	$sheet->write(0,$i,$bus,$format);	
	}
	
	$fecha=getdate(time());
	$mes=$cad;

switch ($_SESSION[ord]) {
	case "codigo":
		$criterio="personalactivo.codigo";
		break;
	case "cedulacontrol":
		$criterio="controlturnos.cedulacontrol";
		break;
	case "apellidos":
		$criterio="personalactivo.apellidos";
		break;
	default:
	$criterio="personalactivo.codigo";
		break;
	}	
	
	$sql4="SELECT * FROM controlturnos, personalactivo, clientes, socios WHERE controlturnos.mescontrol LIKE '$mes' ORDER BY $criterio";
	echo $sql4;
	
	for($i=1;$i<32;$i++){
		
	
	$c='cod'.$i;
	$sheet->write(2,$i,$c,$format);
	}
	
	
		
		
	
	





	
$p++;
}

  

  $xls->close();
?>  


$sql1="SELECT * FROM controlturnos, personalactivo, clientes WHERE
	personalactivo.cedula LIKE controlturnos.cedulacontrol AND controlturnos.mescontrol LIKE '$mes' 
	AND (controlturnos.cod1 LIKE clientes.codigo OR
		controlturnos.cod1 LIKE clientes.codigo OR
		controlturnos.cod2 LIKE clientes.codigo OR
		controlturnos.cod3 LIKE clientes.codigo OR
		controlturnos.cod4 LIKE clientes.codigo OR
		controlturnos.cod5 LIKE clientes.codigo OR
		controlturnos.cod6 LIKE clientes.codigo OR
		controlturnos.cod7 LIKE clientes.codigo OR
		controlturnos.cod8 LIKE clientes.codigo OR
		controlturnos.cod9 LIKE clientes.codigo OR
		controlturnos.cod10 LIKE clientes.codigo OR
		controlturnos.cod11 LIKE clientes.codigo OR
		controlturnos.cod12 LIKE clientes.codigo OR
		controlturnos.cod13 LIKE clientes.codigo OR
		controlturnos.cod14 LIKE clientes.codigo OR
		controlturnos.cod15 LIKE clientes.codigo OR
		controlturnos.cod16 LIKE clientes.codigo OR
		controlturnos.cod17 LIKE clientes.codigo OR
		controlturnos.cod18 LIKE clientes.codigo OR
		controlturnos.cod19 LIKE clientes.codigo OR
		controlturnos.cod20 LIKE clientes.codigo OR
		controlturnos.cod21 LIKE clientes.codigo OR
		controlturnos.cod22 LIKE clientes.codigo OR
		controlturnos.cod23 LIKE clientes.codigo OR
		controlturnos.cod23 LIKE clientes.codigo OR
		controlturnos.cod25 LIKE clientes.codigo OR
		controlturnos.cod26 LIKE clientes.codigo OR
		controlturnos.cod27 LIKE clientes.codigo OR
		controlturnos.cod28 LIKE clientes.codigo OR
		controlturnos.cod29 LIKE clientes.codigo OR
		controlturnos.cod30 LIKE clientes.codigo OR
		controlturnos.cod31 LIKE clientes.codigo) AND clientes.duenopuesto LIKE '$cedulasocio' ORDER BY $criterio
	";