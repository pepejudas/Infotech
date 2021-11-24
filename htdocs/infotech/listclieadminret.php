<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1019);

$sql1="SELECT * FROM clientes WHERE clientes.activo=0 AND clientes.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
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
$texto="LISTADO DE ADMINISTRADORES";
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


$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=53;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ADMINISTRADOR";
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

$codigo=decod(@mysql_result($result,$reg,codigo));
$nit=@mysql_result($result,$reg,nit);
$nombre=decod(@mysql_result($result,$reg,nombrecliente));
$telefono=@mysql_result($result,$reg,telefono);
$administrador=decod(@mysql_result($result,$reg,nombreadministrador));

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

$texto1=$codigo;
$pdf->SetFont('Arial','',7);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nombre;
$pdf->SetFont('Arial','',6);   
$x=53;
$pdf->Text($x,$y,$texto2);

$texto3=$administrador;
$pdf->SetFont('Arial','',8);  
$x=120; 
$pdf->Text($x,$y,$texto3);

$texto4=$telefono;
$pdf->SetFont('Arial','',8);  
$x=170; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>