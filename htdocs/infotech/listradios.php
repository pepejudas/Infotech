<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1039);
	
$sql1="SELECT * FROM radios, clientes WHERE radios.codigo LIKE clientes.codigo AND clientes.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
$result=@mysql_query($sql1);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=@mysql_query($sql2);
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
$texto="LISTADO DE RADIOS ASIGNADOS";
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

$texto="SERIE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=70;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="MARCA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=110;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="MODELO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);
$reg=0;

while($vector=@mysql_fetch_array($result)){

$codigo=decod(@mysql_result($result,$reg,codigo));
$serie=decod(@mysql_result($result,$reg,serie));
$marca=decod(@mysql_result($result,$reg,marca));
$modelo=decod(@mysql_result($result,$reg,modelo));

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

$texto="SERIE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=70;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="MARCA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=110;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="MODELO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=160;
$y=20;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$codigo;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$serie;
$pdf->SetFont('Arial','',10);   
$x=70;
$pdf->Text($x,$y,$texto2);

$texto3=$marca;
$pdf->SetFont('Arial','',10);  
$x=110; 
$pdf->Text($x,$y,$texto3);

$texto4=$modelo;
$pdf->SetFont('Arial','',10);  
$x=160; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>