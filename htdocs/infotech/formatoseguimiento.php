<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1009);

	if($_SESSION[cedulamod]==""){
	$sql122="SELECT * FROM necesidadescliente ORDER BY numerooferta DESC";
	$cons=@mysql_query($sql122);
	$_SESSION[cedulamod]=@mysql_result($cons,0,"numerooferta");
	}
	
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	
$sql1="SELECT * FROM necesidadescliente ORDER BY numerooferta";
$consul=@mysql_query($sql1);
$r=0;
$lim=@mysql_num_rows($consul);

require('fpdf/fpdf.php');

function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

$pdf=new FPDF('L','mm', 'legal');
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=32;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=315;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=70;
$y1=25;
$x2=70;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=25;
$x2=240;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
//$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=33;
$x2=335;
$y2=33;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=41;
$x2=335;
$y2=41;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=48;
$x2=335;
$y2=48;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=48;
$x2=335;
$y2=48;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=270;
$y1=33;
$x2=270;
$y2=41;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=270;
$y1=48;
$x2=270;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="SEGUIMIENTO OFERTAS COMERCIALES";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=166;
$h=6;
$y=36;
$x=67;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','',10);
$pdf->Text(280,30,"FORMATO");
$pdf->Text(250,38,"CODIGO:");
$pdf->Text(276,45,"FGV000");
$pdf->Text(290,53,"REVISION:01");
$pdf->Text(248,53,"PAG 1 DE 1");


$es=55;
$iniy=4;

$texto="";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=315;
$h=130;
$y=$iniy+$es;
$x=20;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=1,$align='C',$fill=0);

$x1=70;
$y1=59;
$x2=70;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=30;
$y1=59;
$x2=30;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=46;
$y1=59;
$x2=46;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=110;
$y1=59;
$x2=110;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=150;
$y1=59;
$x2=150;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=180;
$y1=59;
$x2=180;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=210;
$y1=59;
$x2=210;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=240;
$y1=59;
$x2=240;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=270;
$y1=59;
$x2=270;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=68;
$x2=335;
$y2=68;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

//llenar el formulario

$pdf->Text(22,65,"Item");
$pdf->Text(36,63,"No");
$pdf->Text(33,66.2,"Oferta");
$pdf->Text(50,63,"Fecha de");
$pdf->Text(52,66.2,"Envio");
$pdf->Text(73,65,"Empresa o Conjunto");
$pdf->Text(122,65,"Contacto");
$pdf->Text(158,65,"Telefono");
$pdf->Text(181,63,"Nombre persona");
$pdf->Text(185,66.2,"que entrega");
$pdf->Text(220,66.2,"Firma");
$pdf->Text(246,63,"Fecha de ");
$pdf->Text(244,66.2,"seguimiento");
$pdf->Text(290,66.2,"Observaciones");
$y=$y+14;

for($r=0;$r<$lim;$r++){
$item=$r+1;
$numerooferta=@mysql_result($consul,$r,"numerooferta");
$fechaenvio=explode(" ",@mysql_result($consul,$r,"fechaentrega"));
$empresa=decod(@mysql_result($consul,$r,"empresa"));
$contacto=decod(@mysql_result($consul,$r,"contacto"));
$telefono=@mysql_result($consul,$r,"telefono");	
$fechaseguimiento=explode(" ",@mysql_result($consul,$r,"fechaseguimiento"));

$pdf->SetFont('Arial','',12);
$pdf->Text(23,$y,$item);
$pdf->Text(35,$y,$numerooferta);
$pdf->Text(47,$y,$fechaenvio[0]);
$pdf->Text(151,$y,$telefono);
$pdf->Text(242,$y,$fechaseguimiento[0]);

//$texto=$empresa;
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$w=40;
$h=4;
$x=70;
$y=$y-5;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$empresa,$border=0,$align='l',$fill=0);

$x=110;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$contacto,$border=0,$align='l',$fill=0);



if($y>175){
	
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=32;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=315;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=70;
$y1=25;
$x2=70;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=25;
$x2=240;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
//$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=33;
$x2=335;
$y2=33;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=41;
$x2=335;
$y2=41;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=48;
$x2=335;
$y2=48;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=48;
$x2=335;
$y2=48;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=270;
$y1=33;
$x2=270;
$y2=41;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=270;
$y1=48;
$x2=270;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="SEGUIMIENTO OFERTAS COMERCIALES";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=166;
$h=6;
$y=36;
$x=67;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','',10);
$pdf->Text(280,30,"FORMATO");
$pdf->Text(250,38,"CODIGO:");
$pdf->Text(276,45,"F-P-LIC-01-04");
$pdf->Text(290,53,"REVISION:01");
$pdf->Text(248,53,"PAG 1 DE 1");


$es=55;
$iniy=4;

$texto="";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=315;
$h=130;
$y=$iniy+$es;
$x=20;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=1,$align='C',$fill=0);

$x1=70;
$y1=59;
$x2=70;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=30;
$y1=59;
$x2=30;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=46;
$y1=59;
$x2=46;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=110;
$y1=59;
$x2=110;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=150;
$y1=59;
$x2=150;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=180;
$y1=59;
$x2=180;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=210;
$y1=59;
$x2=210;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=240;
$y1=59;
$x2=240;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=270;
$y1=59;
$x2=270;
$y2=189;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=68;
$x2=335;
$y2=68;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=$y1+8;
$x2=335;
$y2=$y2+8;
$pdf->Line($x1,$y1,$x2,$y2);

//llenar el formulario

$pdf->Text(22,65,"Item");
$pdf->Text(36,63,"No");
$pdf->Text(33,66.2,"Oferta");
$pdf->Text(50,63,"Fecha de");
$pdf->Text(52,66.2,"Envio");
$pdf->Text(73,65,"Empresa o Conjunto");
$pdf->Text(122,65,"Contacto");
$pdf->Text(158,65,"Telefono");
$pdf->Text(181,63,"Nombre persona");
$pdf->Text(185,66.2,"que entrega");
$pdf->Text(220,66.2,"Firma");
$pdf->Text(246,63,"Fecha de ");
$pdf->Text(244,66.2,"seguimiento");
$pdf->Text(290,66.2,"Observaciones");
$y=60;	
}
$y=$y+13;
}
$pdf->Output();
?>















