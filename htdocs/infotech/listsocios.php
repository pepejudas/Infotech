<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1045);
	
$sql1="SELECT * FROM socios ORDER BY $_SESSION[ord] ";
$result=@mysql_query($sql1);
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
$texto="LISTADO DE SOCIOS";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=58;
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

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="NOMBRES Y APELLIDOS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="No PUESTOS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=60;
$pdf->Text($x,$y,$texto);


while($vector=@mysql_fetch_array($result)){


$cedula=@mysql_result($result,$reg,cedula);
$socbusca=@mysql_result($result,$reg,nombres);
$nombres=decod(@mysql_result($result,$reg,nombres)." ".@mysql_result($result,$reg,apellidos));

$sql2="SELECT * FROM clientes WHERE `clientes`.`duenopuesto` LIKE '$socbusca'";
$resulta=@mysql_query($sql2);
$npuestos=@mysql_num_rows($resulta);

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="NOMBRES Y APELLIDOS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="No PUESTOS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=20;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$cedula;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nombres;
$pdf->SetFont('Arial','',10);   
$x=50;
$pdf->Text($x,$y,$texto2);

$texto3=$npuestos;
$pdf->SetFont('Arial','',10);  
$x=150; 
$pdf->Text($x,$y,$texto3);

$reg++;
}

$pdf->Output();
?>
