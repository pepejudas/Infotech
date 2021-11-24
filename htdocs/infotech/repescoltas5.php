<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1065);
//consulta de fecha

$fecha=getdate(time());
$cad=$fecha[month].$fecha[year];

//consulta de socios

$p=0;
$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=@mysql_query($sql2);
$li=@mysql_num_rows($result2);

  include_once "Spreadsheet/Excel/Writer.php";
  $xls =& new Spreadsheet_Excel_Writer();
  $xls->send("reportecontrolturnos.xls");


	$nombresocio=@mysql_result($result2,$p,nombres);
	//$idsocio=@mysql_result($result2,$p,id);	
  	$sheet =& $xls->addWorksheet("Seguridad San Martin");
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,'CEDULA',$format);
	$sheet->write(0,1,'CODIGO',$format);
	$sheet->write(0,2,'APELLIDOS Y NOMBRES',$format);
	$sheet->write(0,3,'FECHA INICIO SERVICIO',$format);
	$sheet->write(0,4,'FECHA FINAL SERVICIO',$format);
	$sheet->write(0,5,'TIEMPO TOTAL',$format);
	
		$fecha=getdate(time());
		$mes=$fecha[month].$fecha[year];
	
	switch ($_SESSION[ord]) {
	case "codigo":
		$criterio="personalactivo.codigo";
		break;
	case "cedula":
		$criterio="personalactivo.cedula";
		break;
	case "apellidos":
		$criterio="personalactivo.apellidos";
		break;
	default:
	$criterio="personalactivo.codigo";
		break;
	}	
	
	$fecha=getdate(time());
switch($fecha[month]):
			case "January": $cad="December".$fecha[year]-1;break;
			case "February": $cad="January".$fecha[year]; break;
			case "March": $cad="February".$fecha[year]; break;
			case "April": $cad="March".$fecha[year]; break;
			case "May": $cad="April".$fecha[year]; break;
			case "June": $cad="May".$fecha[year]; break;
			case "July": $cad="June".$fecha[year]; break;
			case "August": $cad="July".$fecha[year]; break;
			case "September": $cad="August".$fecha[year]; break;
			case "October": $cad="September".$fecha[year]; break;
			case "November": $cad="October".$fecha[year]; break;
			case "December": $cad="November".$fecha[year]; break;
endswitch;

	$sql1="SELECT * FROM  escoltas, personalactivo WHERE  personalactivo.cedula LIKE escoltas.cedula AND escoltas.mesreporte LIKE '$cad' ORDER BY $criterio";
	$cons=@mysql_query($sql1);
	$ini=0;
	$lim=@mysql_num_rows($cons);
	
	$fila=2;
	while($ini<$lim){
	$fila=$fila+2;
	
	$cedula=@mysql_result($cons,$ini,cedula);
	$codigo=@mysql_result($cons,$ini,codigo);
	$nombres=@mysql_result($cons,$ini,apellidos)." ".@mysql_result($cons,$ini,nombre);
	$fechainicio=@mysql_result($cons,$ini,fechainicio);
	$fechafinal=@mysql_result($cons,$ini,fechafinal);
	$tiempo=@mysql_result($cons,$ini,tiempototal);
	
	$sheet->write($fila,0,$cedula,$format);
	$sheet->write($fila,1,$codigo,$format);	
	$sheet->write($fila,2,$nombres,$format);	
	$sheet->write($fila,3,$fechainicio,$format);	
	$sheet->write($fila,4,$fechafinal,$format);	
	$sheet->write($fila,5,$tiempo,$format);	
		
	$ini++;
	}
	$xls->close();
	?>

