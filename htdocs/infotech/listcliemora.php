<?php
session_start();
@require('funciones2.php');

if($_SESSION['iuj345iuh']!=1){
	validar($_POST[nombre], $_POST[contra], $_POST[nivel]);	
}
conectar2($_SESSION['usua']);

	if ($_SESSION['usua']=="vigilantes" or $_SESSION['usua']=="radiooperadores"){
		echo "<br>\n<h2>No tiene permiso para acceder a esta informacion</h2>";
		echo "<h3><div align=left><A HREF=\"inicio.php\">Inicio</A></div><h3>";
		echo "<h3><div align=left><A HREF=\"index.php\">Salir</A></div><h3>";
	exit();
	}
$sql1="SELECT * FROM facturas, clientes WHERE facturas.codigo =clientes.codigo AND clientes.sucursal LIKE '$_SESSION[sucur]' AND `facturas`.`checkpago`= 0 ORDER BY numfactura";
//echo $sql1;
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
$texto="LISTADO DE CLIENTES EN MORA";
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

$texto="NOMBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FACTURA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=93;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="SUBTOTAL";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ABONOS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="SALDO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=176;
$y=60;
$pdf->Text($x,$y,$texto);
$reg=0;

while($vector=mysql_fetch_array($result)){

$codigobusca=mysql_result($result,$reg,codigo);
$sql10="SELECT nombrecliente FROM clientes WHERE `clientes`.`codigo` LIKE '$codigobusca'";
$con=mysql_query($sql10);
$nombre=decod(@mysql_result($con,0,nombrecliente));
//echo $nombre;
if($nombre!=""){
	$nofact=mysql_result($result,$reg,numfactura);
	$subtotal=mysql_result($result,$reg,subtotal);
	$sql11="SELECT valorabono FROM abonos WHERE `abonos`.`numfactura` LIKE '$nofact'";
	$cons=mysql_query($sql11);
	$r=0;
	$l=mysql_num_rows($cons);
	$sumatoria=0;
	while($r<$l){
	$sumatoria=$sumatoria+mysql_result($cons, $r,valorabono);
	$r++;
	}

	$saldo=mysql_result($result,$reg,subtotal)-$sumatoria;

	if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="NOMBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="FACTURA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=93;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="SUBTOTAL";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ABONOS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="SALDO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=176;
$y=20;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$nombre;
$pdf->SetFont('Arial','',6);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nofact;
$pdf->SetFont('Arial','',10);   
$x=93;
$pdf->Text($x,$y,$texto2);

$texto2=$subtotal;
$pdf->SetFont('Arial','',10);   
$x=120;
$pdf->Text($x,$y,$texto2);

$texto3=$sumatoria;
$pdf->SetFont('Arial','',10);  
$x=150; 
$pdf->Text($x,$y,$texto3);

$texto4=$saldo;
$pdf->SetFont('Arial','',10);  
$x=176; 
$pdf->Text($x,$y,$texto4);

}

$reg++;
}

$pdf->Output();
?>