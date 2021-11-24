<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1024);
	
$sql1="SELECT * FROM correspondencia WHERE correspondencia.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
$result=@mysql_query($sql1);
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
$texto="LISTADO DE CORRESPONDENCIA";
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

$texto="AFECTADO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=45;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="TELEFONO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=84;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="PROBLEMA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=113;
$y=60;
$pdf->Text($x,$y,$texto);


$texto="FECHA Y USUARIO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=60;
$pdf->Text($x,$y,$texto);

$reg=0;

while($vector=@mysql_fetch_array($result)){

$codigo=decod(@mysql_result($result,$reg,codigo));
$afectado=decod(@mysql_result($result,$reg,nombreusuario));
$telefono=@mysql_result($result,$reg,telefonousuario);
$problema=@mysql_result($result,$reg,problema);
$fechayusuario=@mysql_result($result,$reg,fecharegistro)." ".mysql_result($result,$reg,registradopor);

switch($problema):
	case 1:
	$problema="Queja supervision";
	break;
	case 2:
	$problema="Hurto";
	break;
	case 3:
	$problema=decod("Daños en propiedad");
	break;
	case 4:
	$problema="Queja por vigilantes";
	break;
	case 5:
	$problema="Indemnizacion";
	break;
	case 6:
	$problema="Otros";
	break;
endswitch;

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

$texto="AFECTADO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=45;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="TELEFONO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=84;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="PROBLEMA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=113;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="FECHA Y USUARIO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=60;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$codigo;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$afectado;
$pdf->SetFont('Arial','',6);   
$x=45;
$pdf->Text($x,$y,$texto2);

$texto3=$telefono;
$pdf->SetFont('Arial','',10);  
$x=84; 
$pdf->Text($x,$y,$texto3);

$texto4=$problema;
$pdf->SetFont('Arial','',10);  
$x=113; 
$pdf->Text($x,$y,$texto4);

$texto4=$fechayusuario;
$pdf->SetFont('Arial','',8);  
$x=150; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
?>