<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1005);

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



$texto="                          CONTROL DE EXISTENCIAS";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=40;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);


$texto="ARTICULO";
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$x=30;
$y=70;
$pdf->Text($x,$y,$texto);

$texto="F-C-001/V.02/18-04-2006";
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=20;
$y=289;
$pdf->Text($x,$y,$texto);

$x=60;
$y=60;
$w=130;
$h=15;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$x=20;
$y=80;
$w=30;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=50;
$y=80;
$w=62.5;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=112.5;
$y=80;
$w=62.5;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=175;
$y=80;
$w=15;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x1=20;
$y1=85;
$x2=175;
$y2=85;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=93;
$x2=190;
$y2=93;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$texto="FECHA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=30;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="ENTRADA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=73;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="SALIDA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=135;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="SALDO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=176;
$y=87;
$pdf->Text($x,$y,$texto);

$texto="D";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=24;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="M";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=34;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="A";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=44;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="CANT";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=51;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="FACTURA No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=63;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="REMISION No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=88;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="CANT";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=114;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="REQUISICION No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=124;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="COMPROBANTE No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=149;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="TOTAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=30;
$y=283;
$pdf->Text($x,$y,$texto);

$texto=" SALDO TOTAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=152;
$y=283;
$pdf->Text($x,$y,$texto);


$x1=30;
$y1=85;
$x2=30;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=40;
$y1=85;
$x2=40;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=60;
$y1=85;
$x2=60;
$y2=285;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=86.2;
$y1=85;
$x2=86.2;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=122.5;
$y1=85;
$x2=122.5;
$y2=285;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=148.5;
$y1=85;
$x2=148.5;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);


//LINEAS VERTICALES DEL CUERPO DEL FORMATO

$x1=20;
$y1=98;
$x2=190;
$y2=98;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=103;
$x2=190;
$y2=103;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=103;
$x2=190;
$y2=103;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=108;
$x2=190;
$y2=108;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=113;
$x2=190;
$y2=113;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=118;
$x2=190;
$y2=118;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=123;
$x2=190;
$y2=123;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);


$x1=20;
$y1=128;
$x2=190;
$y2=128;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=133;
$x2=190;
$y2=133;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=138;
$x2=190;
$y2=138;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=143;
$x2=190;
$y2=143;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=148;
$x2=190;
$y2=148;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=153;
$x2=190;
$y2=153;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=158;
$x2=190;
$y2=158;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=163;
$x2=190;
$y2=163;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=168;
$x2=190;
$y2=168;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=173;
$x2=190;
$y2=173;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=178;
$x2=190;
$y2=178;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=183;
$x2=190;
$y2=183;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=188;
$x2=190;
$y2=188;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=193;
$x2=190;
$y2=193;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=198;
$x2=190;
$y2=198;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=203;
$x2=190;
$y2=203;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=208;
$x2=190;
$y2=208;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=213;
$x2=190;
$y2=213;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=218;
$x2=190;
$y2=218;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=223;
$x2=190;
$y2=223;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=228;
$x2=190;
$y2=228;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=233;
$x2=190;
$y2=233;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=238;
$x2=190;
$y2=238;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=243;
$x2=190;
$y2=243;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=248;
$x2=190;
$y2=248;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=253;
$x2=190;
$y2=253;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=258;
$x2=190;
$y2=258;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=263;
$x2=190;
$y2=263;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=268;
$x2=190;
$y2=268;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=273;
$x2=190;
$y2=273;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=278;
$x2=190;
$y2=278;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=183;
$x2=190;
$y2=183;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=188;
$x2=190;
$y2=188;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=193;
$x2=190;
$y2=193;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$vector=explode("$", $_SESSION[idprodmod]);//para distinguir nuevo o usado

$sql="SELECT * FROM movproductos, productos WHERE movproductos.idprod=$vector[0] AND movproductos.idprod=productos.id AND movproductos.sucursal LIKE '$_SESSION[sucur]' AND movproductos.nou=$vector[1]";

$cons=@mysql_query($sql);
if($vector[1]==1){$nou="NUEVO";}elseif($vector[1]==2){$nou="USADO";}
$articulo=decod(recortarcadena(@mysql_result($cons,$ini,nombreprod). " ". @mysql_result($cons,$ini,referencia)." ".$nou,40));
$x=65;
$y=70;
$pdf->SetFont('Arial','B',13); 
$pdf->Text($x,$y,$articulo);

$ini=0;
$lim=@mysql_num_rows($cons);
$y=92.4;

$_SESSION[salp]=0;
$_SESSION[saln]=0;

while($ini<$lim){
$y+=5;

$entosal=@mysql_result($cons,$ini,eos);
$fecha=@mysql_result($cons,$ini,fecha);
$cantidad=@mysql_result($cons,$ini,cantidad);
$facturaoreq=@mysql_result($cons,$ini,facturaoreq);
$remisionocom=@mysql_result($cons,$ini,remisionocom);

//fechas


$x=22;
$fecha1=explode("-", $fecha);
$fecha3=explode(" ", $fecha1[2]);
$fecha2=$fecha3[0]."      ".$fecha1[1]."   ".$fecha1[0];
$pdf->SetFont('Arial','',11);   
$pdf->Ln();
$pdf->Text($x,$y,$fecha2);
//cantidad
if($entosal==1){$x=52;}else{$x=114;}
$pdf->Text($x,$y,$cantidad);
$pdf->Text($x+9,$y,$facturaoreq);
$pdf->SetFont('Arial','',8);
$pdf->Text($x+36,$y,$remisionocom);
$pdf->SetFont('Arial','',11);
//saldo
if($entosal==1){
	
	$_SESSION[salp]+=@mysql_result($cons,$ini,cantidad);
	$saldo+=@mysql_result($cons,$ini,cantidad);
}else{
	$_SESSION[saln]+=@mysql_result($cons,$ini,cantidad);
	$saldo-=@mysql_result($cons,$ini,cantidad);}
$pdf->SetFont('Arial','',9);  	
$pdf->Text(176,$y,$saldo);
	

if($y>=276){
	
	$pdf->Text(52,283,$_SESSION[salp]);
	$pdf->Text(115,283,$_SESSION[saln]);
		$pdf->Text(176,283,$saldo);
	
	$pdf->AddPage();
	
	$_SESSION[salp]=0;
	$_SESSION[saln]=0;
	
	//condicional para poner encabezado////////////////////////////////////////////////////////////////////////////////
	
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



$texto="                          CONTROL DE EXISTENCIAS";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=40;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$x=65;
$y=70;
$pdf->SetFont('Arial','B',15); 
$pdf->Text($x,$y,$articulo);

$texto="ARTICULO";
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$x=30;
$y=70;
$pdf->Text($x,$y,$texto);

$texto="F-C-001/V.02/18-04-2006";
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=20;
$y=289;
$pdf->Text($x,$y,$texto);

$x=60;
$y=60;
$w=130;
$h=15;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$x=20;
$y=80;
$w=30;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=50;
$y=80;
$w=62.5;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=112.5;
$y=80;
$w=62.5;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=175;
$y=80;
$w=15;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x1=20;
$y1=85;
$x2=175;
$y2=85;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=93;
$x2=190;
$y2=93;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$texto="FECHA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=30;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="ENTRADA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=73;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="SALIDA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=135;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="SALDO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=176;
$y=87;
$pdf->Text($x,$y,$texto);

$texto="D";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=24;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="M";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=34;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="A";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=44;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="CANT";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=51;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="FACTURA No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=63;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="REMISION No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=88;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="CANT";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=114;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="REQUISICION No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=124;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="COMPROBANTE No";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=149;
$y=90;
$pdf->Text($x,$y,$texto);

$texto="TOTAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=30;
$y=283;
$pdf->Text($x,$y,$texto);

$texto=" SALDO TOTAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=152;
$y=283;
$pdf->Text($x,$y,$texto);


$x1=30;
$y1=85;
$x2=30;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=40;
$y1=85;
$x2=40;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=60;
$y1=85;
$x2=60;
$y2=285;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=86.2;
$y1=85;
$x2=86.2;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=122.5;
$y1=85;
$x2=122.5;
$y2=285;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=148.5;
$y1=85;
$x2=148.5;
$y2=277.8;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

//LINEAS VERTICALES DEL CUERPO DEL FORMATO

$x1=20;
$y1=98;
$x2=190;
$y2=98;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=103;
$x2=190;
$y2=103;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=103;
$x2=190;
$y2=103;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=108;
$x2=190;
$y2=108;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=113;
$x2=190;
$y2=113;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=118;
$x2=190;
$y2=118;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=123;
$x2=190;
$y2=123;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);


$x1=20;
$y1=128;
$x2=190;
$y2=128;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=133;
$x2=190;
$y2=133;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=138;
$x2=190;
$y2=138;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=143;
$x2=190;
$y2=143;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=148;
$x2=190;
$y2=148;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=153;
$x2=190;
$y2=153;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=158;
$x2=190;
$y2=158;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=163;
$x2=190;
$y2=163;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=168;
$x2=190;
$y2=168;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=173;
$x2=190;
$y2=173;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=178;
$x2=190;
$y2=178;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=183;
$x2=190;
$y2=183;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=188;
$x2=190;
$y2=188;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=193;
$x2=190;
$y2=193;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=198;
$x2=190;
$y2=198;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=203;
$x2=190;
$y2=203;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=208;
$x2=190;
$y2=208;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=213;
$x2=190;
$y2=213;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=218;
$x2=190;
$y2=218;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=223;
$x2=190;
$y2=223;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=228;
$x2=190;
$y2=228;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=233;
$x2=190;
$y2=233;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=238;
$x2=190;
$y2=238;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=243;
$x2=190;
$y2=243;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=248;
$x2=190;
$y2=248;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=253;
$x2=190;
$y2=253;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=258;
$x2=190;
$y2=258;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=263;
$x2=190;
$y2=263;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=268;
$x2=190;
$y2=268;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=273;
$x2=190;
$y2=273;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=278;
$x2=190;
$y2=278;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=183;
$x2=190;
$y2=183;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=188;
$x2=190;
$y2=188;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=193;
$x2=190;
$y2=193;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);
	
		$y=92.4;
	
	
	}

$ini++;	
}

$pdf->Text(52,283,$_SESSION[salp]);
$pdf->Text(115,283,$_SESSION[saln]);
$pdf->Text(176,283,$saldo);

$pdf->Output();
?>

