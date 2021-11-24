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

if ($_SESSION['idreg']=="" and $_SESSION['abomod']==""){
		echo "<br>\n<h2>Debe cargar una transaccion para hacer recibo</h2>";
		echo "<h3><div align=left><A HREF=\"documentosingresos.php\">Atras</A></div><h3>";
	exit();
	}
if($_SESSION['idreg']!=""){
$sql1="SELECT * FROM ingresos WHERE `ingresos`.`id`= $_SESSION[idreg]";
//echo $sql1;
$result=mysql_query($sql1);
$fecha=getdate(time());
$fec=$fecha[mday]."-".$fecha[mon]."-".$fecha[year];
$idi=mysql_result($result,0,id);
$perso=decod(mysql_result($result,0,persona));
$vall=decod(mysql_result($result,0,valorletras));
$valn=mysql_result($result,0,valornumero);
$conl=decod(mysql_result($result,0,concepto));
$ch=mysql_result($result,0,efectivocheque);
$bidb=mysql_result($result,0,bancoid);
$sql3="SELECT * FROM bancos WHERE `bancos`.`id` = $bidb";
$res=mysql_query($sql3);
$nombreb=decod(mysql_result($res,0,nombrebanco));
$retenci=mysql_result($result,0,retencion);
}
//echo $_SESSION['abomod'];
if($_SESSION['abomod']!=""){
$sql1="SELECT * FROM abonos WHERE `abonos`.`consecutivo`= $_SESSION[abomod]";
//echo $sql1;
$result=mysql_query($sql1);
$fecha=getdate(time());
$fec=$fecha[mday]."-".$fecha[mon]."-".$fecha[year];
$idi=mysql_result($result,0,consecutivo);
$fact=mysql_result($result, 0, numfactura); 
$sql6="SELECT * FROM facturas WHERE `numfactura` = $fact";
//echo $sql6;
$res=mysql_query($sql6);
$clie=mysql_result($res,0,codigo);
$sql7="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$clie'";
//echo $sql7;
$resc=mysql_query($sql7);
$perso=decod(mysql_result($resc,0,nombrecliente));
//g$vall=mysql_result($result,0,valorletras);
$valn=mysql_result($result,0,valorabono);
$conl=mysql_result($result,0,numfactura);
//$ch=mysql_result($result,0,efectivocheque);
$bidb=decod(mysql_result($result,0,banco));
$sql3="SELECT * FROM bancos WHERE `bancos`.`id` = $bidb";
$res=mysql_query($sql3);
$nombreb=decod(mysql_result($res,0,nombrebanco));
$retenci="FECHA DE ABONO: ". mysql_result($result,0,fechaabono);
}



require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',23);
$pdf->Ln();
$fecha=getdate(time());

$texto=$fec;
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=33;
$y=45;
$pdf->Text($x,$y,$texto);

$texto=$perso;
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$x=33;
$y=52;
$pdf->Text($x,$y,$texto);

$texto=$vall;
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=33;
$y=59;
$pdf->Text($x,$y,$texto);

$texto=$valn;
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=157;
$y=69;
$pdf->Text($x,$y,$texto);

/*
switch($ch):
case 1:
$x=23;
$y=107;
break;
case 1:
$x=100;
$y=107;
break;
endswitch;

$texto="X";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$pdf->Text($x,$y,$texto);
*/

$texto=$nombreb;
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=18;
$y=113;
$pdf->Text($x,$y,$texto);

$texto=$retenci;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=23;
$y=119;
$pdf->Text($x,$y,$texto);

$texto=$idi;
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=195;
$y=33;
$pdf->Text($x,$y,$texto);







$pdf->Output();
?>
