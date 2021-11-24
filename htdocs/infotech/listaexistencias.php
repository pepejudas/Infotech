<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1012);

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



$texto="                          REPORTE DE INVENTARIOS";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=40;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);


$texto="INFORMACION";
$pdf->SetFont('Arial','B',10);   
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
$w=52.5;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=165;
$y=80;
$w=25;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x1=20;
$y1=85;
$x2=190;
$y2=85;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$texto="REFERENCIA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=21;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE PRODUCTO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=60;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="MODELO Y MARCA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=120;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="NUEVO";
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=168;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="USADO";
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=179;
$y=84;
$pdf->Text($x,$y,$texto);

//LINEAS horizontales DEL CUERPO DEL FORMATO

$y1=85;
$x1=20;
$x2=190;

for($i=1;$i<40;$i++){

	$y1+=5;
	$pdf->SetLineWidth(0.3);
	$pdf->Line($x1,$y1,$x2,$y1);
	
}

$x=65;
$y=70;
$pdf->SetFont('Arial','B',10); 
$pdf->Text($x,$y," USUARIO: ".$_SESSION[persona]." FECHA Y HORA: ".date("d-F-Y:H:m"));

$sql="SELECT * FROM productos ORDER BY $_SESSION[ord]";
$cons=@mysql_query($sql);

$ini=0;
$lim=@mysql_num_rows($cons);
$y=84;

$_SESSION[salp]=0;
$_SESSION[saln]=0;

while($ini<$lim){
$y+=5;

$referencia=decod(@mysql_result($cons,$ini,referencia));
$nombreprod=decod(@mysql_result($cons,$ini,nombreprod));
$modelomarca=decod(@mysql_result($cons,$ini,modelo). " ".@mysql_result($cons,$ini,marca));
//fechas
$idprod=@mysql_result($cons,$ini,id);

$sqlsaldon="SELECT (SELECT IFNULL(SUM(cantidad),0) FROM movproductos WHERE movproductos.idprod='$idprod' AND movproductos.eos=1 AND movproductos.nou=1 AND movproductos.sucursal='$_SESSION[sucur]') - (SELECT IFNULL(SUM(cantidad),0) FROM movproductos WHERE movproductos.idprod='$idprod' AND movproductos.eos=2 AND movproductos.nou=1 AND movproductos.sucursal='$_SESSION[sucur]') AS sal";
$sqlsaldou="SELECT (SELECT IFNULL(SUM(cantidad),0) FROM movproductos WHERE movproductos.idprod='$idprod' AND movproductos.eos=1 AND movproductos.nou=2 AND movproductos.sucursal='$_SESSION[sucur]') - (SELECT IFNULL(SUM(cantidad),0) FROM movproductos WHERE movproductos.idprod='$idprod' AND movproductos.eos=2 AND movproductos.nou=2 AND movproductos.sucursal='$_SESSION[sucur]') AS sal";

$consaldon=@mysql_query($sqlsaldon);
$consaldou=@mysql_query($sqlsaldou);

$saldon=@mysql_result($consaldon,0, sal);
$saldou=@mysql_result($consaldou,0, sal);

if($saldon<=0){$saldon=0;}
if($saldou<=0){$saldou=0;}

$x=22;
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$pdf->Text($x,$y,recortarcadena($referencia,15));

//cantidad
$pdf->SetFont('Arial','',10);
$pdf->Text($x+30,$y,recortarcadena($nombreprod,25));
$pdf->Text($x+92,$y,recortarcadena($modelomarca,25));

$pdf->SetFont('Arial','',7);
$pdf->Text(168,$y,recortarcadena($saldon, 6));
$pdf->Text(181,$y,recortarcadena($saldou, 6));
	
if($y>=276){
	
	//condicional para poner encabezado////////////////////////////////////////////////////////////////////////////////

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



$texto="                          REPORTE DE INVENTARIOS";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=40;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);


$texto="INFORMACION";
$pdf->SetFont('Arial','B',10);   
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
$w=52.5;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x=165;
$y=80;
$w=25;
$h=205;
$pdf->SetLineWidth(0.5);
$pdf->Rect($x,$y,$w,$h);

$x1=20;
$y1=85;
$x2=190;
$y2=85;
$pdf->SetLineWidth(0.3);
$pdf->Line($x1,$y1,$x2,$y2);

$texto="REFERENCIA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=21;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE PRODUCTO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=60;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="MODELO Y MARCA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=120;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="NUEVO";
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=168;
$y=84;
$pdf->Text($x,$y,$texto);

$texto="USADO";
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=179;
$y=84;
$pdf->Text($x,$y,$texto);

//LINEAS horizontales DEL CUERPO DEL FORMATO

$y1=85;
$x1=20;
$x2=190;

for($i=1;$i<40;$i++){

	$y1+=5;
	$pdf->SetLineWidth(0.3);
	$pdf->Line($x1,$y1,$x2,$y1);
	
}

$x=65;
$y=70;
$pdf->SetFont('Arial','B',10); 
$pdf->Text($x,$y," USUARIO: ".$_SESSION[persona]." FECHA Y HORA: ".date("d-F-Y:H:m"));

	$y=84;
	
	}

$ini++;	
}

$pdf->Output();
?>

