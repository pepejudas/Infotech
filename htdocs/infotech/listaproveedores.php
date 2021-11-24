<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1014);

$sql1="SELECT * FROM proveedores WHERE proveedores.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
//echo $sql1;
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
$texto="LISTADO DE PROVEEDORES";
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


$texto="NIT";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE PROVEEDOR";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=53;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CONTACTO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="TELEFONO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=170;
$y=60;
$pdf->Text($x,$y,$texto);
$reg=0;

while($vector=@mysql_fetch_array($result)){

$nit=@mysql_result($result,$reg,nit);
$nombreprov=decod(@mysql_result($result,$reg,nombreprov));
$telefono1=@mysql_result($result,$reg,telefono1);
$contacto=decod(@mysql_result($result,$reg,contacto));

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=53;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ADMINISTRADOR";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="TELEFONO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=170;
$y=20;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$nit;
$pdf->SetFont('Arial','',7);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nombreprov;
$pdf->SetFont('Arial','',6);   
$x=53;
$pdf->Text($x,$y,$texto2);

$texto3=$contacto;
$pdf->SetFont('Arial','',8);  
$x=120; 
$pdf->Text($x,$y,$texto3);

$texto4=$telefono1;
$pdf->SetFont('Arial','',8);  
$x=170; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>