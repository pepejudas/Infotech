<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1049);

$sql1="SELECT * FROM `personalactivo`, `clientes` WHERE `personalactivo`.`codigo`=`clientes`.`codigo` AND `personalactivo`.`oficiotramitecred` IS NOT NULL AND `personalactivo`.`oficiotramitecred` NOT LIKE '0' AND (`personalactivo`.`credsuperintendencia` LIKE 'inserte' OR `personalactivo`.`credsuperintendencia` IS NULL OR `personalactivo`.`credsuperintendencia`='') AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'  AND `personalactivo`.`codigo` LIKE '$_SESSION[clielis]' AND `clientes`.`duenopuesto` LIKE '$_SESSION[sociolis]' ORDER BY $_SESSION[ord]";
$result=mysql_query($sql1);

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
$texto="LISTADO DE PERSONAL CON";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=54;
$y=32;
$pdf->Text($x,$y,$texto);

$texto="CREDENCIAL SVySP EN TRAMITE";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=54;
$y=40;
$pdf->Text($x,$y,$texto);

$texto="";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=54;
$y=48;
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
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=80;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="OFICIO TRAMITE SVySP";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=140;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=288;
$pdf->Text($x,$y,$texto);

$reg=0;
$y=60;
while($vector=mysql_fetch_array($result)){

	$nombre=decod(mysql_result($result,$reg,nombre));
	$apellido=decod(mysql_result($result,$reg,apellidos));
	$cedula=mysql_result($result,$reg,cedula);
	$pasado=mysql_result($result,$reg,oficiotramitecred);
	$codbusca=decod(mysql_result($result,$reg,codigo));
	
	if($y==280){$pdf->AddPage();
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln();
	$x11=20;
	$y11=285;
	require('saludoslis.php');
	
	$texto="CODIGO";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=20;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="CEDULA";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=50;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="APELLIDOS Y NOMBRES";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=80;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="OFICIO TRAMITE SVySP";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=140;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
$texto="";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=288;
$pdf->Text($x,$y,$texto);

	$y=25;

	}
	
	$texto1=$codbusca;
	$pdf->SetFont('Arial','',8);  
	$x=20; 
	$y=$y+5;
	$pdf->Text($x,$y,$texto1);
	
	$texto2=$cedula;
	$pdf->SetFont('Arial','',8);   
	$x=50;
	$pdf->Text($x,$y,$texto2);
	
	$texto3=$apellido ." " . $nombre;
	$pdf->SetFont('Arial','',8);  
	$x=80; 
	$pdf->Text($x,$y,$texto3);
	
	$texto4=$pasado;
	$pdf->SetFont('Arial','',10);  
	$x=140; 
	$pdf->Text($x,$y,$texto4);
	
	$texto4=$v;
	$pdf->SetFont('Arial','',10);  
	$x=175; 
	//$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>

