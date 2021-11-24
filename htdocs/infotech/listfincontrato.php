<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1029);

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
$texto="LISTADO DE PERSONAL CON";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=54;
$y=32;
$pdf->Text($x,$y,$texto);

$texto="CONTRATO PROXIMO A RENOVAR";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=54;
$y=40;
$pdf->Text($x,$y,$texto);

$texto="";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=54;
$y=48;
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
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=70;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA INGRESO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
$y=60;
$pdf->Text($x,$y,$texto);

	$texto="CONTRATO";
	$pdf->SetFont('Arial','B',10);   
	$pdf->Ln();
	$x=173;
	$y=60;
	$pdf->Text($x,$y,$texto);

$texto="* Personal con contrato proximo a renovar hasta 60 dias despues de la fecha actual";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=288;
$pdf->Text($x,$y,$texto);

$reg=0;
$y=60;
while($vector=@mysql_fetch_array($result)){
	
$v=mysql_result($result,$reg,fechaingreso);
$fec=explode("-",$v);
$dia=$fec[2];
$mes=$fec[1];
$ano=$fec[0];
$t=getdate(time());
$num=$ano*365.25+$mes*30.416+$dia;
$nume=$mes*30.416+$dia;

switch(@mysql_result($result,$reg,sueldo)):
case 1:
$com2=$t[year]*365.25+$t[mon]*30.416+$t[mday]-325;
$com3=$t[year]*365.25+$t[mon]*30.416+$t[mday]-365;
$com4=$t[mon]*30.416+$t[mday]+60;
$com5=$t[mon]*30.416+$t[mday]-1;
$contrata=decod("1 año");
break;
case 2:
$com2=$t[year]*365.25+$t[mon]*30.416+$t[mday]-1050;
$com3=$t[year]*365.25+$t[mon]*30.416+$t[mday]-1095;
$com4=$t[mon]*30.416+$t[mday]+60;
$com5=$t[mon]*30.416+$t[mday]-1;

$contrata=decod("3 año");
break;
case 3:
$v=mysql_result($result,$reg,fincontrato);
$fec=explode("-",$v);
$dia=$fec[2];
$mes=$fec[1];
$ano=$fec[0];
$t=getdate(time());
$num=$ano*365.25+$mes*30.416+$dia;
$com2=$t[year]*365.25+$t[mon]*30.416+$t[mday]+45;
$com3=$t[year]*365.25+$t[mon]*30.416+$t[mday];
$com4=$t[mon]*30.416+$t[mday]+60;
$com5=$t[mon]*30.416+$t[mday]-1;
$contrata="labor u obra";
break;
default;
$com4=$t[mon]*30.416+$t[mday]+60;
$com5=$t[mon]*30.416+$t[mday]-1;
$contrata="no definido";
endswitch;

if($nume>$com5 and $nume<$com4 and $t[year]!=$ano){

	$nombre=decod(mysql_result($result,$reg,nombre));
	$apellido=decod(mysql_result($result,$reg,apellidos));
	$cedula=mysql_result($result,$reg,cedula);
	$pasado=mysql_result($result,$reg,fechaingreso);
	$codbusca=decod(mysql_result($result,$reg,codigo));
	
	if($y==280){$pdf->AddPage();
	
$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');
	
	$texto="CODIGO";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=20;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="CEDULA";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=50;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="APELLIDOS Y NOMBRES";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=70;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
$texto="FECHA INGRESO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
$y=20;
$pdf->Text($x,$y,$texto);

	$texto="CONTRATO";
	$pdf->SetFont('Arial','B',10);   
	$pdf->Ln();
	$x=173;
	$y=20;
	$pdf->Text($x,$y,$texto);
	

	
$texto="* Personal con contrato proximo a renovar hasta 60 dias despues de la fecha actual";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=288;
$pdf->Text($x,$y,$texto);

	$y=25;

	}
	
	$texto1=$codbusca;
	$pdf->SetFont('Arial','',6);  
	$x=20; 
	$y=$y+5;
	$pdf->Text($x,$y,$texto1);
	
	$texto2=$cedula;
	$pdf->SetFont('Arial','',8);   
	$x=50;
	$pdf->Text($x,$y,$texto2);
	
	$texto3=$apellido ." " . $nombre;
	$pdf->SetFont('Arial','',8);  
	$x=70; 
	$pdf->Text($x,$y,$texto3);
	
	$texto4=$pasado;
	$pdf->SetFont('Arial','',10);  
	$x=140; 
	$pdf->Text($x,$y,$texto4);
	
	$texto4=$contrata;
	$pdf->SetFont('Arial','',10);  
	$x=175; 
	$pdf->Text($x,$y,$texto4);
}
$reg++;
}

$pdf->Output();
?>
