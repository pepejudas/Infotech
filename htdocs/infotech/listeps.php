<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1027);

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
$texto="LISTADO DE EPS";
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

$texto="EPS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ESTADO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
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
$eps=mysql_result($result,$reg,eps);
$checkeps=mysql_result($result,$reg,epscheck);
$fechaeps=mysql_result($result,$reg,epsfecha);
$noafilia=mysql_result($result,$reg,noafeps);

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

$texto="EPS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ESTADO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
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

			
switch($eps):
			case 27:           $texto3="Barranquilla sana"; break;
	 		case 4:            $texto3="Bonsalud"; break;
	 		case 3:            $texto3="Cafesalud"; break;
	 		case 24:           $texto3="Cajanal"; break;
	 		case 28:           $texto3="Calisalud"; break;
	 		case 20:           $texto3="Caprecom"; break;
	 		case 25:           $texto3="Capresoca"; break;
	 		case 34:           $texto3="Casur"; break;
	 		case 15:           $texto3="Colpatria"; break;
	 		case 11:           $texto3=" Colseguros"; break;
	 		case 9:            $texto3="Comfenalco Antioquia"; break;
	 		case 12:           $texto3="Comfenalco Valle"; break;
	 		case 8:            $texto3="Compensar"; break;
	 		case 22:           $texto3="Convida"; break;
	 		case 16:           $texto3="Coomeva"; break;
	 		case 21:           $texto3="Corporanominas"; break;
	 		case 23:           $texto3="Cruz Blanca"; break;
	 		case 30:           $texto3="Eps Condor"; break;
	 		case 29:           $texto3="Eps de Caldas"; break;
	 		case 19:           $texto3="Eps de Risaralda"; break;
	 		case 17:           $texto3="Famisanar"; break;
	 		case 14:           $texto3="Humana"; break;
	 		case 1:            $texto3="Salud Colmena"; break;
	 		case 2:            $texto3="Salud Total"; break;
	 		case 33:           $texto3="Salud Vida"; break;
	 		case 13:           $texto3="Saludcoop"; break;
	 		case 5:            $texto3="Sanitas"; break;
	 		case 6:            $texto3="Seguro Social"; break;
	 		case 31:           $texto3="Selva Salud"; break;
	 		case 26:           $texto3="Solsalud"; break;
	 		case 18:           $texto3="Sos Servicio Occ Salud"; break;
	 		case 10:           $texto3="Sura"; break;
	 		case 7:            $texto3="Unimec"; break;
			case 52:           $texto3="Nueva EPS"; break;
endswitch;
$pdf->SetFont('Arial','',7);  
$x=120; 
$pdf->Text($x,$y,$texto3);


switch($checkeps):
			case 1: 	$texto4="correcto"; break;
	 		case "": 	$texto4="sin afiliacion"; break;
	 		
endswitch;
$pdf->SetFont('Arial','',7);  
$x=140; 
$pdf->Text($x,$y,$texto4);

		 	
$texto2=$fechaeps;
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