<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1027);

$sql1="SELECT * FROM  `requisiciones` INNER JOIN productos ON requisiciones.idprod = productos.id
INNER JOIN usuarios on requisiciones.idusuarioreq=usuarios.id WHERE estado = 2 ORDER BY serialrequisicion, $_SESSION[ord]";
$result=mysql_query($sql1);
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
$texto="LISTADO DE REQUISICIONES APROBADAS";
$pdf->SetFont('Arial','B',15);
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

$texto="Requisicion";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="Usuario Solicita";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="Nombre Articulo";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=80;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="Cantidad";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="Tipo";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="Estado";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=175;
$y=60;
$pdf->Text($x,$y,$texto);


$reg=0;

while($vector=mysql_fetch_array($result)){

$serialreq=decod(mysql_result($result,$reg,"serialrequisicion"));
$usuario=decod(mysql_result($result,$reg,"usuario"));
$nombreprod=recortarcadena(mysql_result($result,$reg,"nombreprod").mysql_result($result,$reg,"referencia").mysql_result($result,$reg,"modelo"), 30);
$cantidad=mysql_result($result,$reg, "cantidad");
$tipo=mysql_result($result,$reg,"nou");
$estado=mysql_result($result,$reg,"estado");

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="Requisicion";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=20;
$y=30;
$pdf->Text($x,$y,$texto);

$texto="Usuario Solicita";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=50;
$y=30;
$pdf->Text($x,$y,$texto);

$texto="Nombre Articulo";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=80;
$y=30;
$pdf->Text($x,$y,$texto);

$texto="Cantidad";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=140;
$y=30;
$pdf->Text($x,$y,$texto);

$texto="Tipo";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=160;
$y=30;
$pdf->Text($x,$y,$texto);

$texto="Estado";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=175;
$y=30;
$pdf->Text($x,$y,$texto);
}

$texto1=$serialreq;
$pdf->SetFont('Arial','',10);  
$x=25;
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$usuario;
$pdf->SetFont('Arial','',8);   
$x=50;
$pdf->Text($x,$y,$texto2);

$texto2=$nombreprod;
$pdf->SetFont('Arial','',7);  
$x=80;
$pdf->Text($x,$y,$texto2);

$texto2=$cantidad;
$pdf->SetFont('Arial','',7);
$x=140;
$pdf->Text($x,$y,$texto2);

if($tipo=="1"){
$texto2="Nuevo";
}else{
$texto2="Usado";
}
$pdf->SetFont('Arial','',7);
$x=160;
$pdf->Text($x,$y,$texto2);

if($estado=="1"){
$texto2="No revisada";
}else if($estado=="2"){
$texto2="Aprobada";
}else if($estado=="3"){
$texto2="Rechazada";
}
$pdf->SetFont('Arial','',7);  
$x=175;
$pdf->Text($x,$y,$texto2);

$reg++;
}

$pdf->Output();
?>
