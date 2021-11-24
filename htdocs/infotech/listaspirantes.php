<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1017);

$sql1="SELECT * FROM personalactivo WHERE personalactivo.sucursal LIKE '$_SESSION[sucur]' AND personalactivo.activo=2 ORDER BY $_SESSION[ord]";
$result=mysql_query($sql1);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=mysql_query($sql2);
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
$texto="      LISTADO DE ASPIRANTES";
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

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=80;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CARNET";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=180;
$y=60;
$pdf->Text($x,$y,$texto);
$reg=0;

$ini=0;
$lim=@mysql_num_rows($result);
//while($vector=mysql_fetch_array($result)){
for($ini=0;$lim>$ini;$ini++){

$nombre=decod(mysql_result($result,$ini,nombre));
$apellido=decod(mysql_result($result,$ini,apellidos));
$cedula=mysql_result($result,$ini,cedula);
$direccion=decod(mysql_result($result,$ini,direccion));
$fechaing=mysql_result($result,$ini,fechaingreso);
$carnet=mysql_result($result,$ini,carnetinterno);
$codbusca=decod(mysql_result($result,$ini,codigo));

if($y==280){$pdf->AddPage();
$y=25;
$texto="CODIGO";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=20;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=80;
$pdf->Text($x,$y,$texto);

$texto="CARNET";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=180;
$pdf->Text($x,$y,$texto);
$reg=0;

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

}

$texto1=$codbusca;
$pdf->SetFont('Arial','',6);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$cedula;
$pdf->SetFont('Arial','',10);   
$x=50;
$pdf->Text($x,$y,$texto2);

$texto3=$apellido ." " . $nombre;
$pdf->SetFont('Arial','',10);  
$x=80; 
$pdf->Text($x,$y,$texto3);

$texto4=$carnet;
$pdf->SetFont('Arial','',10);  
$x=180; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>
