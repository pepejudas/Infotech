<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1042);

$sql1="SELECT * FROM personalactivo WHERE personalactivo.activo = 0 AND (personalactivo.afpcheck LIKE 0 OR personalactivo.afpcheck IS NULL) AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
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

$texto="LISTADO DE PERSONAL POR RETIRAR DE AFP";
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

$texto="AFP";
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
$afp=mysql_result($result,$reg,afp);
$checkafp=mysql_result($result,$reg,afpcheck);
$noaf=mysql_result($result,$reg,noafafp);
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

$texto="AFP";
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

			
switch($afp):
			case 309: $texto5="Askandia"; break;
	 		case 508: $texto5="Cajanal"; break;
	 		case 318: $texto5="Caldas"; break;
	 		case 307: $texto5="Cesantias de Colombia"; break;
	 		case 310: $texto5="Colfondos"; break;
	 		case 304: $texto5="Colmena"; break;
	 		case 301: $texto5="Colpatria"; break;
	 		case 308: $texto5="Davivir"; break;
	 		case 306: $texto5="Ganadera"; break;
	 		case 305: $texto5="Horizonte"; break;
	 		case 314: $texto5="Invertirmañana"; break;
	 		case 311: $texto5="Invertir"; break;
	 		case 319: $texto5="Pensionar"; break;
	 		case 303: $texto5="Porvenir"; break;
	 		case 302: $texto5="Proteccion"; break;
	 		case 509: $texto5="ING"; break;
	 		case 312: $texto5="Santander"; break;
	 		case 501: $texto5="Seguro Social"; break;
	 		case 316: $texto5="Solidez"; break;		


endswitch;
$pdf->SetFont('Arial','',7);  
$x=136; 
$pdf->Text($x,$y,$texto5);



if($checkafp==0){
$texto4="afiliado aun";}elseif($checkafp==1){$texto4="correcto";}
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