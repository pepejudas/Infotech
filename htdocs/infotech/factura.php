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
	
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	
if($_SESSION[factmod]!=""){
$sql1="SELECT * FROM facturas WHERE `facturas`.`numfactura`= $_SESSION[factmod]";
//echo $sql1;
$result=mysql_query($sql1);
$cod=@mysql_result($result,0,codigo);
$sql2="SELECT nombrecliente, nit, direccion, telefono FROM clientes WHERE `clientes`.`codigo` LIKE '$cod'";
$res=mysql_query($sql2);
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$fecha=getdate(time());

$texto=$fecha[mday]."  -  ".$fecha[mon]."  -".$fecha[year];
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=28;
$y=60;
$pdf->Text($x,$y,$texto);

/*
echo "<pre>";
print_r(getdate(time()));
echo "</pre>";*/

/*
if($_sESSION[factmod]==""){
echo "<h1>error debe seleccionar la factura a mostrar</h1>";
}
*/

$fecha1=getdate(time()+3600*24*10);
$texto=$fecha1[mday]."  -  ".$fecha1[mon]."  -".$fecha1[year];
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=98;
$y=60;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$texto=@mysql_result($result,0,numfactura);
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=170;
$y=72;
$pdf->Text($x,$y,$texto);

$texto=decod(@mysql_result($res,0,nombrecliente));
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=13;
$y=72;
$pdf->Text($x,$y,$texto);

$texto=@mysql_result($res,0,nit);
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=72;
$pdf->Text($x,$y,$texto);

$texto=@mysql_result($res,0,telefono);
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=150;
$y=80;
$pdf->Text($x,$y,$texto);

$texto=decod(@mysql_result($res,0,direccion));
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=13;
$y=80;
$pdf->Text($x,$y,$texto);
$reg=0;

$texto=decod(@mysql_result($result,0,concepto));
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=120;
$h=5;
$x=13;
$y=150;
$pdf->setxy($x,$y);
$pdf->multicell($w,$h,$texto);

$texto=decod(@mysql_result($result,0,valorenletras));
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=100;
$h=5;
$x=23;
$y=217;
$pdf->setxy($x,$y);
$pdf->multicell($w,$h,$texto);

$texto=@mysql_result($result,0,subtotal);
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=215;
$pdf->setxy($x,$y);
$pdf->Cell(0,0,$texto,0,1,'R');

$texto=@mysql_result($result,0,retefuente); 
$pdf->Ln();
$x=180;
$y=222;
$pdf->setxy($x,$y);
$pdf->Cell(0,0,$texto,0,1,'R');

$texto=@mysql_result($result,0,iva);
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=229;
$pdf->setxy($x,$y);
$pdf->Cell(0,0,$texto,0,1,'R');

$texto=@mysql_result($result,0,subtotal)-@mysql_result($result,0,retefuente)+@mysql_result($result,0,iva);
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=236;
$pdf->setxy($x,$y);
$pdf->Cell(0,0,$texto,0,1,'R');

while($vector=@mysql_fetch_array($result)){

$codigo=decod(mysql_result($result,$reg,codigo));
$nit=mysql_result($result,$reg,nit);
$nombre=decod(mysql_result($result,$reg,nombrecliente));
$telefono=decod(mysql_result($result,$reg,telefono));
$administrador=decod(mysql_result($result,$reg,nombreadministrador));

if($y==280){$pdf->AddPage();

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=53;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ADMINISTRADOR";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=120;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="TELEFONO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=170;
$y=20;
$pdf->Text($x,$y,$texto);

$y=25;}

$texto1=$codigo;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nombre;
$pdf->SetFont('Arial','',8);   
$x=53;
$pdf->Text($x,$y,$texto2);

$texto3=$administrador;
$pdf->SetFont('Arial','',8);  
$x=120; 
$pdf->Text($x,$y,$texto3);

$texto4=$telefono;
$pdf->SetFont('Arial','',8);  
$x=170; 
$pdf->Text($x,$y,$texto4);

$reg++;
}

$pdf->Output();
}else{echo "<h2>Debe cargar una factura para realizar el documento</h2>".'<h3><div align=left><A HREF="documentosfacturacion.php">Atras</A></div><h3>';exit();}
?>