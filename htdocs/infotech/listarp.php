<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1016);

$sql1="SELECT * FROM `personalactivo`, `clientes` WHERE `personalactivo`.`codigo`=`clientes`.`codigo` AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]' AND `personalactivo`.`activo`='1' AND `personalactivo`.`codigo` LIKE '$_SESSION[clielis]' AND `clientes`.`duenopuesto` LIKE '$_SESSION[sociolis]' ORDER BY $_SESSION[ord]";
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
$texto="LISTADO DE ARP";
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

$texto="CEDULA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ARP";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ESTADO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=144;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="No AFILIACION";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=175;
$y=60;
$pdf->Text($x,$y,$texto);


$reg=0;

while($vector=mysql_fetch_array($result)){

$nombre=decod(mysql_result($result,$reg,nombre));
$apellido=decod(mysql_result($result,$reg,apellidos));
$cedula=mysql_result($result,$reg,cedula);
$arp=mysql_result($result,$reg,arp);
$checkarp=mysql_result($result,$reg,arpcheck);
$fechaarp=mysql_result($result,$reg,arpfecha);
$noafilia=mysql_result($result,$reg,noafarp);

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CEDULA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ARP";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ESTADO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=144;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="FECHA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="No AFILIACION";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=175;
$y=20;
$pdf->Text($x,$y,$texto);
}

$texto1=$cedula;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$apellido. " " . $nombre;
$pdf->SetFont('Arial','',8);   
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
$x=120; 
$pdf->Text($x,$y,$texto4);


switch($checkarp):
			case 1: 	$texto4="correcto"; break;
	 		case "": 	$texto4="sin afiliacion"; break;
	 		
endswitch;
$pdf->SetFont('Arial','',7);  
$x=144; 
$pdf->Text($x,$y,$texto4);

		 	
$texto2=$fechaarp;
$pdf->SetFont('Arial','',7);  
$x=160; 
$pdf->Text($x,$y,$texto2);

$texto2=$noafilia;
$pdf->SetFont('Arial','',7);  
$x=180; 
$pdf->Text($x,$y,$texto2);

$reg++;
}

$pdf->Output();
?>