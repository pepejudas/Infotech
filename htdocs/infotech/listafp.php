<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1013);

$sql1="SELECT * FROM `personalactivo`, `clientes` WHERE `personalactivo`.`codigo`=`clientes`.`codigo` AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]' AND `personalactivo`.`activo`='1' AND `personalactivo`.`codigo` LIKE '$_SESSION[clielis]' AND `clientes`.`duenopuesto` LIKE '$_SESSION[sociolis]' ORDER BY $_SESSION[ord]";
$result=@mysql_query($sql1);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=@mysql_query($sql2);
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
$texto="LISTADO DE AFP";
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

$texto="AFP";
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

while($vector=@mysql_fetch_array($result)){

$nombre=decod(@mysql_result($result,$reg,nombre));
$apellido=decod(@mysql_result($result,$reg,apellidos));
$cedula=@mysql_result($result,$reg,cedula);
$afp=@mysql_result($result,$reg,afp);
$checkafp=@mysql_result($result,$reg,afpcheck);
$fechaafp=@mysql_result($result,$reg,afpfecha);
$noafilia=@mysql_result($result,$reg,noafafp);

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

$texto="AFP";
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
$x=120; 
$pdf->Text($x,$y,$texto5);


switch($checkafp):
			case 1: 	$texto4="correcto"; break;
	 		case "": 	$texto4="sin afiliacion"; break;
	 		
endswitch;
$pdf->SetFont('Arial','',7);  
$x=144; 
$pdf->Text($x,$y,$texto4);

		 	
$texto2=$fechaafp;
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