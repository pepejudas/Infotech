<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1062);
	
	$fecha=getdate(time());
	$mes=$fecha[month].$fecha[year];
		
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/
$fecha=getdate(time());
	$ano=$fecha[year];
	switch($fecha[month]):
			case "January": $mesbusca="December"; $ano=$fecha[year]-1;break;
			case "February": $mesbusca="January"; break;
			case "March": $mesbusca="February"; break;
			case "April": $mesbusca="March"; break;
			case "May": $mesbusca="April"; break;
			case "June": $mesbusca="May"; break;
			case "July": $mesbusca="June"; break;
			case "August": $mesbusca="July"; break;
			case "September": $mesbusca="August"; break;
			case "October": $mesbusca="September"; break;
			case "November": $mesbusca="October"; break;
			case "December": $mesbusca="November"; break;
endswitch;

switch ($_SESSION[ord]) {
	case "codigo":
		$criterio="escoltas.codigo";
		break;
	case "cedula":
		$criterio="escoltas.cedula";
		break;
	case "apellidos":
		$criterio="personalactivo.apellidos";
		break;
	case "fechainicio":
	$criterio="escoltas.codigo";
		break;
	default:
	$criterio="personalactivo.codigo";
		break;
}	
$sql1="SELECT * FROM  escoltas, personalactivo WHERE  personalactivo.cedula LIKE escoltas.cedula AND escoltas.mesreporte LIKE '$mesbusca$ano' ORDER BY $criterio";
//echo $sql1;
$result=mysql_query($sql1);
$ini=0;
$lim=@mysql_num_rows($result);
//$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
//$resulta=mysql_query($sql2);
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage('l');
$pdf->SetFont('Arial','B',18);
$file="imagenes/super10.jpg";
$x=30;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=246;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="REPORTE ESCOLTA GENERAL MES ANTERIOR";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=95;
$y=32;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=70;
$y11=200;
require('saludoslis.php');

$texto="CEDULA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CODIGO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=45;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=70;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA INICIO SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=130;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA FINAL SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=190;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="TIEMPO TOTAL";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=247;
$y=60;
$pdf->Text($x,$y,$texto);

$x1=20;
	$y1=55;
	$x2=278;
	$y2=55;
	$pdf->SetLineWidth(0.3);
	$pdf->Line($x1,$y1,$x2,$y2);

$reg=0;
$y=60;

while($ini<$lim){
	
	$nombre=decod(@mysql_result($result,$ini,nombre));
	$apellido=decod(@mysql_result($result,$ini,apellidos));
	$cedula=@mysql_result($result,$ini,cedula);
	$codigo=decod(@mysql_result($result,$ini,codigo));
	
	$texto=$apellido." ".$nombre;
	$pdf->SetFont('Arial','',7);   
	$pdf->Ln();
	$x=70;
	$y=$y+6;
	$pdf->Text($x,$y,$texto);
	
	$texto=$cedula;
	$pdf->SetFont('Arial','',8);   
	$pdf->Ln();
	$x=20;
	$pdf->Text($x,$y,$texto);
	
	$texto=$codigo;
	$pdf->SetFont('Arial','',8);   
	$pdf->Ln();
	$x=45;
	$pdf->Text($x,$y,$texto);
	
	
	$texto=@mysql_result($result,$ini,fechainicio);
	$pdf->SetFont('Arial','',10);   
	$pdf->Ln();
	$x=130;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,fechafinal);
	$pdf->SetFont('Arial','',10);   
	$pdf->Ln();
	$x=190;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,tiempototal);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=247;
	$pdf->Text($x,$y,$texto);
	
	if($y>=190){
		$pdf->AddPage('l');
		
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln();
	$x11=20;
	$y11=285;
	require('saludoslis.php');

		$texto="CEDULA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="CODIGO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=45;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=70;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="FECHA INICIO SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=130;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="FECHA FINAL SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=190;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="TIEMPO TOTAL";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=247;
$y=20;
$pdf->Text($x,$y,$texto);
		
		$y=25;
	}
	
	$ini++;
}

$pdf->Output();
?>

