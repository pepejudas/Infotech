<?php
/*
 *Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1031);

$sql1="SELECT * FROM novedades, personalactivo WHERE personalactivo.cedula = novedades.cedula AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY novedades.$_SESSION[ord]";
$result=@mysql_query($sql1);
$lim=@mysql_num_rows($result);
$reg=0;
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
$texto="LISTADO DE NOVEDADES";
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

$texto="NOVEDAD";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=140;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=175;
$y=60;
$pdf->Text($x,$y,$texto);

$reg=0;

while($reg<$lim){
$ced=@mysql_result($result,$reg,cedula);
$sql2="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula` = $ced";
//echo $sql2;
$resulta=mysql_query($sql2);

	if(@mysql_result($resulta,0,nombre)!=""){
	$nombre=decod(@mysql_result($resulta,0,nombre));
	$apellido=decod(@mysql_result($resulta,0,apellidos));
	$novedad=@mysql_result($result,$reg,novedad);
	$codbusca=decod(@mysql_result($result,$reg,codcliente));
	$v=@mysql_result($result,$reg,fechanov);
	}else{
	$sql3="SELECT * FROM personalretirado WHERE `personalretirado`.`cedula` = $ced";
	$resultaq=mysql_query($sql3);
	$nombre=@mysql_result($resultaq,0,nombre);
	$apellido=@mysql_result($resultaq,0,apellidos);
	$novedad=@mysql_result($result,$reg,novedad);
	$codbusca=@mysql_result($result,$reg,codcliente);
	$v=@mysql_result($result,$reg,fechanov);	
	}

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

	$texto="NOVEDAD";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=140;
	$y=20;
	$pdf->Text($x,$y,$texto);

	$texto="FECHA";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=175;
	$y=20;
	$pdf->Text($x,$y,$texto);

	$y=25;

	}

	$texto1=$codbusca;
	$pdf->SetFont('Arial','',8);  
	$x=20; 
	$y=$y+5;
	$pdf->Text($x,$y,$texto1);

	$texto2=$ced;
	$pdf->SetFont('Arial','',8);   
	$x=50;
	$pdf->Text($x,$y,$texto2);

	$texto3=$apellido ." " . $nombre;
	$pdf->SetFont('Arial','',8);  
	$x=70; 
	$pdf->Text($x,$y,$texto3);

	$texto4=$novedad;
	$pdf->SetFont('Arial','',10);  
	$x=140; 
	$pdf->Text($x,$y,$texto4);

	$texto4=$v;
	$pdf->SetFont('Arial','',10);  
	$x=175; 
	$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>
