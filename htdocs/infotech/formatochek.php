<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1003);
	
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	

$sql="SELECT * FROM seguridadsuper";
$result=@mysql_query($sql);
$razon=decod(@mysql_result($result,0,"razonsocial"));

@require('fpdf/fpdf.php');
$pdf=new FPDF('P','mm', 'a4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=170;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$y1=25;
$x2=150;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$y1=45;
$x2=190;
$y2=45;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=170;
$y1=45;
$x2=170;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$x2=190;
$y1=32;
$y2=32;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="LISTA DE CHEQUEO DE DOCUMENTOS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=176;
$h=6;
$y=36;
$x=17;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','B',10);
$pdf->Text(157,30,"Procedimiento");
$pdf->Text(152,37,decod("Código:"));
$pdf->Text(158,42,"F-P-LIC-01-03");
$pdf->SetFont('Arial','B',7);
$pdf->Text(152,51,decod("Versión:01"));
$pdf->Text(172,51,"Pagina 1 de 1");


$es=60;
$iniy=3.3;

$texto="DOCUMENTO                          REVISADO                             OBSERVACIONES";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=170;
$h=4;
$x=20;
$y=$iniy+$y+25;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$texto="";
$w=170;
$h=119;
$x=20;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$x=87;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y,$x,$y+119);

$x=122;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y,$x,$y+119);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="PRESENTACION DE $razon";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="OFERTAS COMERCIALES";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="LICENCIA DE FUNCIONAMIENTO";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="LICENCIA DE COMUNICACIONES";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="LICENCIA DE MEDIOS TECNOLOGICOS";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="LICENCIA DE VIGILANCIA MOVIL";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="CERTIFICADO DE CAMARA DE COMERCIO";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="POLIZA DE RESPONSBILIDAD CIVIL EXTRACONTRACTUAL";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="CERTIFICADO DE LA RED DE APOYO  POLICIA NACIONAL";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);


$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="CERTIFICACIONES SUPERINTENDENCIA DE VIGILANCIA";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);


$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="REFERENCIAS DE ALGUNOS DE NUESTROS CLIENTES";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+1.5,$texto);


$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=70;
$h=20;
$x=20;
$y=$iniy+$y+25;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='L',$fill=0);

$texto="REVISADO POR";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=23;
$pdf->Text($x,$y+5,$texto);

$texto="FECHA DE REVISION";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=93;
$pdf->Text($x,$y+5,$texto);

$texto="";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=100;
$h=20;
$x=90;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='L',$fill=0);

$texto="MODIFICACIONES O CAMBIOS AL CONTRATO, Y OTROS CONTRATOS ADICIONALES";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=170;
$h=4;
$x=20;
$y=$iniy+$y+25;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$texto="";
$w=170;
$h=40;
$x=20;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$y=$iniy+$y+4.5;
$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$pdf->Output();
?>

