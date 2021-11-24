<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 59);

$sql1="SELECT * FROM armas, clientes WHERE armas.codigo LIKE clientes.codigo and clientes.sucursal LIKE  '$_SESSION[sucur]'ORDER BY armas.$_SESSION[ord] ASC";
//echo $sql1;
$result=@mysql_query($sql1);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
//echo $sql2;
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
$texto="LISTADO DE ARMAS ASIGNADAS";
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

$texto="SERIAL";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="TIPO ARMA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=90;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CALIBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=130;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="VENCE LIC";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);

$reg=0;

while($vector=@mysql_fetch_array($result)){

$codigo=recortarcadena(decod(@mysql_result($result,$reg,codigo)),20);
$serial=decod(@mysql_result($result,$reg,serial));
$tipoarma=@mysql_result($result,$reg,tipoarma);
$calibre=@mysql_result($result,$reg,calibre);
$vencelic=@mysql_result($result,$reg,vencesalvoconducto);

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="SERIAL";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="TIPO ARMA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=90;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="CALIBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=130;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="VENCE LIC";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=160;
$y=20;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$codigo;
$pdf->SetFont('Arial','',8);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$serial;
$pdf->SetFont('Arial','',10);   
$x=50;
$pdf->Text($x,$y,$texto2);

switch($tipoarma):
case 1:
$texto3="Revolver";
break;
case 2:
$texto3="Pistola";
break;
case 3:
$texto3="Escopeta";
break;
case 4:
$texto3="Fusil";
break;
case 5:
$texto3="Ametralladora";
break;
case 6:
$texto3="Miniuzi";
break;
endswitch;
$pdf->SetFont('Arial','',10);  
$x=90; 
$pdf->Text($x,$y,$texto3);

$texto4=$calibre;
$pdf->SetFont('Arial','',10);  
$x=130; 
$pdf->Text($x,$y,$texto4);

$texto4=$vencelic;
$pdf->SetFont('Arial','',10);  
$x=160; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>