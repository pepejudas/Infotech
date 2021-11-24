<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1068);

	$fecha=getdate(time());
	$mes=$fecha[month].$fecha[year];
		
$sql1="SELECT * FROM escoltas, personalactivo WHERE personalactivo.cedula = $_SESSION[cedulamod] AND escoltas.mesreporte LIKE '$mes' AND escoltas.cedula=$_SESSION[cedulamod] ORDER BY escoltas.codigo";
$result=mysql_query($sql1);
$ini=0;
$lim=@mysql_num_rows($result);
//$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
//$resulta=mysql_query($sql2);
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$file="imagenes/super10.jpg";
$x=10;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=176;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="REPORTE ESCOLTA INDIVIDUAL";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=55;
$y=32;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');


$texto="CODIGO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=79;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=55;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA INICIO SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=55;
$y=79;
$pdf->Text($x,$y,$texto);

$texto="FECHA FINAL SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=110;
$y=79;
$pdf->Text($x,$y,$texto);

$texto="TIEMPO TOTAL";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=165;
$y=79;
$pdf->Text($x,$y,$texto);

$reg=0;

	$nombre=decod(@mysql_result($result,$reg,nombre));
	$apellido=decod(@mysql_result($result,$reg,apellidos));
	$cedula=@mysql_result($result,$reg,cedula);
	
	$texto=$apellido." ".$nombre;
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=55;
	$y=68;
	$pdf->Text($x,$y,$texto);
	
	$texto=$cedula;
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=20;
	$y=68;
	$pdf->Text($x,$y,$texto);
	
	
	$x1=20;
	$y1=70;
	$x2=196;
	$y2=70;
	$pdf->SetLineWidth(0.3);
	$pdf->Line($x1,$y1,$x2,$y2);

$y=80;
while($ini<$lim){
	$texto=@mysql_result($result,$ini,codigo);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=20;
	$y=$y+6;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,fechainicio);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=55;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,fechafinal);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=110;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,tiempototal);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=165;
	$pdf->Text($x,$y,$texto);
	
	if($y==280){
		$pdf->AddPage();
			
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln();
		$x11=20;
		$y11=285;
		require('saludoslis.php');	
		
		$texto="FECHA INICIO SERVICIO";
		$pdf->SetFont('Arial','B',12);   
		$pdf->Ln();
		$x=55;
		$y=20;
		$pdf->Text($x,$y,$texto);

		$texto="FECHA FINAL SERVICIO";
		$pdf->SetFont('Arial','B',12);   
		$pdf->Ln();
		$x=110;
		$y=20;
		$pdf->Text($x,$y,$texto);

		$texto="TIEMPO TOTAL";
		$pdf->SetFont('Arial','B',12);   
		$pdf->Ln();
		$x=165;
		$y=20;
		$pdf->Text($x,$y,$texto);
		
		$y=25;
	}
	
	$ini++;
}

$pdf->Output();
?>
