<?php
session_start();

@require('funciones2.php');

validar("","","", 1001);
	
/******************************************************************************
to verificate what button has been pressed
******************************************************************************/	
$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$_SESSION[cedulamod]";
$sql2="SELECT * FROM parametros";
$sql29="SELECT * FROM seguridadsuper";
$consseg=mysql_query($sql29);
$contr=mysql_query($sql2);
$direccions=decod(@mysql_result($consseg,0,direccion)." BARRIO ".@mysql_result($consseg,0,barrio));
$tel=decod(@mysql_result($consseg,0,telefono1)." /".@mysql_result($consseg,0,telefono2)." Fax: ".@mysql_result($consseg,0,telefono3));
$result=mysql_query($sql1);
$nombre=decod(@mysql_result($result,0,nombre));
$apellido=decod(@mysql_result($result,0,apellidos));
$cedula=decod(@mysql_result($result,0,cedula));
$contrata=decod(@mysql_result($contr,0,cartaapertura));
$ciudad=decod(@mysql_result($consseg,0,ciudad));



require('fpdf/fpdf.php');
$pdf=new FPDF();
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
$x1=60;
$y1=45;
$x2=190;
$y2=45;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$x2=190;
$y1=35;
$y2=35;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=20;
$x2=190;
$y1=270;
$y2=270;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="      CARTA DE APERTURA 
		   CUENTA DE NOMINA";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=30;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','B',10);
$pdf->Text(152,30,"FECHA APROBACION");
$pdf->Text(152,33,"17/03/2006");
$pdf->Text(152,41,"CODIGO: F-RH-005");
$pdf->Text(152,51,"VERSION:00");
$y=46;
$pdf->Sety($y);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$fecha1=getdate(time());
$texto=$fecha1[mday]."-".$fecha1[mon]."-".$fecha1[year];
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$x=50;
$y=90;
$pdf->Text($x,$y,$texto);
$texto2="
Bogota D.C. $fecha     
	
	Se".utf8_decode(ñ)."ores:
	BANCO AVVILLAS
	SUCURSAL SALITRE
	CALLE 40 No 68C-92
	Bogota.
		";
$pdf->SetFont('Arial','B',12);
$x=20;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);
$pdf->Ln();
$w=170;
$h=4;
$x=20;
$y=170;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell($w,$h,$contrata,$border=0,$align='J',$fill=0);

$w=150;
$h=4;
$x=20;
$y=150;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell($w,$h,"Apreciados se".utf8_decode(ñ)."ores: 
Estamos solicitando le sea abierta la cuenta de nomina al se".utf8_decode(ñ)."or(a):
		",$border=0,$align='J',$fill=0);

$w=150;
$h=4;
$x=20;
$y=160;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell($w,$h,$apellido. " ". $nombre,$border=0,$align='J',$fill=0);

$w=150;
$h=4;
$x=20;
$y=165;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell($w,$h,"C.C. ".$cedula,$border=0,$align='J',$fill=0);

$w=150;
$h=4;
$x=20;
$y=270.2;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell($w,$h,$direccions." Tel:".$tel,$border=0,$align='C',$fill=0);

$w=150;
$h=4;
$x=20;
$y=272.9;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell($w,$h,$ciudad,$border=0,$align='C',$fill=0);

$pdf->Ln();
$pdf->Ln();
$texto10='Cordialmente
		
		
		
		
		
		
Firma y sello autorizado ___________________________________
Cargo                               ___________________________________
';
$x=20;
$y=200;
$pdf->Setxy($x,$y);
$pdf->SetFont('Arial','B',10);
//$pdf->Text($x,$y,$texto10);
$w=185;
$h=4;
$pdf->MultiCell($w,$h,$texto10,$border=0,$align='J',$fill=0);
//$pdf->Write(5,$texto10);
$pdf->Output();
?>
