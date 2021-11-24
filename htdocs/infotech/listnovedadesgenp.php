<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1033);

$sql1="SELECT * FROM personalactivo, ordenes WHERE personalactivo.cedula=ordenes.cedremplazo  AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord] DESC";
//echo $sql1;
$result=mysql_query($sql1);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=mysql_query($sql2);
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage('l');
$pdf->SetFont('Arial','B',18);
$file="imagenes/super10.jpg";
$x=10;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=245;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="LISTADO DE NOVEDADES DE PERSONAL";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=80;
$y=32;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=70;
$y11=200;
require('saludoslis.php');

$texto="DATOS REEMPLAZANTE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=35;
$y=57;
$pdf->Text($x,$y,$texto);

$x1=20;
$y1=59;
$x2=100;
$y2=59;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="APELLIDOS Y NOMBRES REEMPLAZANTE";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$y=57;
//$pdf->Text($x,$y,$texto);

$texto="DATOS REEMPLAZADO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=57;
$pdf->Text($x,$y,$texto);

$x1=110;
$y1=59;
$x2=190;
$y2=59;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="APELLIDOS Y NOMBRES REEMPLAZADO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=130;
$y=57;
//$pdf->Text($x,$y,$texto);

$texto="MOTIVO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=220;
$y=57;
$pdf->Text($x,$y,$texto);

$texto="FECHA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=200;
$y=57;
$pdf->Text($x,$y,$texto);

$texto="No OFICIO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=250;
$y=57;
$pdf->Text($x,$y,$texto);

$y=60;

$reg=0;

while($vector=mysql_fetch_array($result)){

$codigo=mysql_result($result,$reg,cedremplazo);
$serial=decod(mysql_result($result,$reg,apellidos)." ".mysql_result($result,$reg,nombre));
$calibre=mysql_result($result,$reg,cedremplazado);
$sql1r="SELECT * FROM personalactivo WHERE personalactivo.cedula=$calibre";
$cons=@mysql_query($sql1r);
$vencelic=decod(@mysql_result($cons,0,apellidos)." ".@mysql_result($cons,0,nombre));
$mot=decod(verificarNovedadRadiop2(@mysql_result($result,$reg,motivo)));
$fecha=@mysql_result($result,$reg,fecha);
$ofi=@mysql_result($result,$reg,numorden);

if($y>=190){$pdf->AddPage('l');

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=70;
$y11=200;
require('saludoslis.php');

$texto="DATOS REEMPLAZANTE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=35;
$y=20;
$pdf->Text($x,$y,$texto);

$x1=20;
$y1=22;
$x2=100;
$y2=22;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="APELLIDOS Y NOMBRES REEMPLAZANTE";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$y=20;
//$pdf->Text($x,$y,$texto);

$texto="DATOS REEMPLAZADO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=20;
$pdf->Text($x,$y,$texto);

$x1=110;
$y1=22;
$x2=190;
$y2=22;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="APELLIDOS Y NOMBRES REEMPLAZADO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=130;
$y=20;
//$pdf->Text($x,$y,$texto);

$texto="MOTIVO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=220;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="FECHA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=200;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="No OFICIO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=250;
$y=20;
$pdf->Text($x,$y,$texto);

$y=23;}

$texto1=$codigo;
$pdf->SetFont('Arial','',8);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$serial;
$pdf->SetFont('Arial','',7);   
$x=40;
$pdf->Text($x,$y,$texto2);

$texto4=$calibre;
$pdf->SetFont('Arial','',8);  
$x=110; 
$pdf->Text($x,$y,$texto4);

$texto4=$vencelic;
$pdf->SetFont('Arial','',7);  
$x=130; 
$pdf->Text($x,$y,$texto4);

$texto4=$fecha;
$pdf->SetFont('Arial','',8);  
$x=200; 
$pdf->Text($x,$y,$texto4);

$texto4=$mot;
$pdf->SetFont('Arial','',8);  
$x=220; 
$pdf->Text($x,$y,$texto4);

$texto4=$ofi;
$pdf->SetFont('Arial','',8);  
$x=250; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>
