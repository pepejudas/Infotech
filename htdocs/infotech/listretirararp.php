<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1043);

$sql1="SELECT *FROM personalactivo WHERE personalactivo.activo = 0 AND (personalactivo.arpcheck LIKE 0 OR personalactivo.arpcheck IS NULL) AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
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

$texto="LISTADO DE PERSONAL POR RETIRAR DE ARP";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$h=120;
$w=6;
$y=20;
$x=50;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->multicell($h,$w,$texto);

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

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ARP";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=136;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ESTADO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="No AFILIACION";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=176;
$y=60;
$pdf->Text($x,$y,$texto);


$reg=0;

while($vector=mysql_fetch_array($result)){

$nombre=decod(mysql_result($result,$reg,nombre));
$apellido=decod(mysql_result($result,$reg,apellidos));
$cedula=mysql_result($result,$reg,cedula);
$arp=mysql_result($result,$reg,arp);
$checkarp=mysql_result($result,$reg,arpcheck);
$noaf=mysql_result($result,$reg,noafarp);
$fechaing=mysql_result($result,$reg,fechaingreso);

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ARP";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=136;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ESTADO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="No AFILIACION";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=176;
$y=20;
$pdf->Text($x,$y,$texto);
$y=25;}

$texto1=$cedula;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$apellido. " " . $nombre;
$pdf->SetFont('Arial','',10);   
$x=50;
$pdf->Text($x,$y,$texto2);

			
switch($arp):
			case 200: $texto4="Agricola de Seguros"; break;
	 		case 206: $texto4="Bolivar"; break;
	 		case 203: $texto4="Colmena"; break;
	 		case 202: $texto4="Colpatria"; break;
	 		case 207: $texto4="Colseguros"; break;
	 		case 300: $texto4="Fosyga"; break;
	 		case 201: $texto4="Positiva"; break;
	 		case 208: $texto4="Liberty"; break;
	 		case 299: $texto4="Otras"; break;
	 		case 204: $texto4="Previ-Atep"; break;
	 		case 205: $texto4="Suratep"; break;

endswitch;
$pdf->SetFont('Arial','',7);  
$x=136; 
$pdf->Text($x,$y,$texto4);



if($checkarp==0){
$texto4="afiliado aun";}elseif($checkarp==1){$texto4="correcto";}
$pdf->SetFont('Arial','',7);  
$x=160; 
$pdf->Text($x,$y,$texto4);

$texto5=$noaf;
$pdf->SetFont('Arial','',7);  
$x=176; 
$pdf->Text($x,$y,$texto5);

$reg++;
}

$pdf->Output();
?>