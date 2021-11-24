<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1056);
	
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	
if($_SESSION[ordenc]!=""){
$sql1="SELECT * FROM ordenes WHERE `ordenes`.`numorden`= $_SESSION[ordenc]";
$result=@mysql_query($sql1);
$cod=@mysql_result($result,0,codcliente);
$ced1=@mysql_result($result,0,cedremplazado);
$ced2=@mysql_result($result,0,cedremplazo);
$sql2="SELECT nombrecliente, nit, direccion, telefono, nombreadministrador FROM clientes WHERE `clientes`.`codigo` LIKE '$cod'";
$sql3="SELECT nombre, apellidos, telefono, carnetinterno FROM personalactivo WHERE `personalactivo`.`cedula` LIKE '$ced1'";
$sql4="SELECT nombre, apellidos, telefono FROM personalactivo WHERE `personalactivo`.`cedula` LIKE '$ced2'";
$sql22="SELECT * FROM seguridadsuper";
//echo "<br>". $sql1;
//echo "<br>". $sql2;
//echo "<br>". $sql3;
//echo "<br>". $sql4;
$result1=@mysql_query($sql2);
$result2=@mysql_query($sql3);
$result3=@mysql_query($sql4);
$result22=@mysql_query($sql22);
$fechapartir=@mysql_result($result, 0, fecha);
$nombreclie=decod(@mysql_result($result1, 0, nombrecliente));
$admin=decod(@mysql_result($result1, 0, nombreadministrador));
$direccion=decod(@mysql_result($result1, 0, direccion));
$telefono=@mysql_result($result1, 0, telefono);
$nombre1=decod(@mysql_result($result2,0,nombre)." ".@mysql_result($result2,0,apellidos));
$carnet=@mysql_result($result2,0,carnetinterno);
$nombre2=decod(@mysql_result($result3,0,nombre)." ".@mysql_result($result3,0,apellidos));
$apartir=@mysql_result($result, 0, fecha);
$turno=@mysql_result($result, 0, turnos);
$empresa=decod(@mysql_result($result22, 0, razonsocial));
if(@mysql_result($result, 0, diascal)==999){
$dias="Indefinidamente";	
}else{
$dias=@mysql_result($result, 0, diascal);}
$motivo=verificarNovedadRadiop2(@mysql_result($result, 0, motivo));


//echo $fecha;
//echo $nombreclie;
//echo $admin;
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();


/*
echo "<pre>";
print_r(getdate(time()));
echo "</pre>";*/

/*
if($_sESSION[factmod]==""){
echo "<h1>error debe seleccionar la factura a mostrar</h1>";
}
*/
$file="imagenes/super10.jpg";
$x=27;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=17;
$y=25;
$w=173;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$y1=25;
$x2=150;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$y1=45;
$x2=190;
$y2=45;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$x2=190;
$y1=35;
$y2=35;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=17;
$x2=17;
$y1=25;
$y2=270;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=17;
$x2=190;
$y1=270;
$y2=270;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=190;
$x2=190;
$y1=25;
$y2=270;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="      FORMATO OFICIO DE 
		   PRESENTACION";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=33;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','B',10);
$pdf->Text(152,30,"FECHA APROBACION");
$pdf->Text(152,33,"15/09/2007");
$pdf->Text(152,41,"CODIGO:F-P-OPER-03");
$pdf->Text(152,51,"VERSION:01");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$fecha1=getdate(time());
$texto=$fecha1[mday]."-".$fecha1[mon]."-".$fecha1[year];
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$x=50;
$y=90;
//$pdf->Text($x,$y,$texto);


$fecha1=getdate(time());
$texto=decod("Bogotá D.C.   ".$fecha1[mday]."-".$fecha1[mon]."-".$fecha1[year]);
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$x=18;
$y=75;
$pdf->Text($x,$y,$texto);

$texto=$nombreclie;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=18;
$y=97;
$pdf->Text($x,$y,$texto);

$texto="CODIGO: ".$cod;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=130;
$y=43;
//$pdf->Text($x,$y,$texto);

$texto="Oficio de presentacion No: ".$_SESSION[ordenc];
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=18;
$y=268;
$pdf->Text($x,$y,$texto);

$texto="Doctor(a): ";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=18;
$y=85;
$pdf->Text($x,$y,$texto);

$texto=$admin;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=18;
$y=92;
$pdf->Text($x,$y,$texto);

$texto="Cordial saludo: ";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=18;
$y=102;
$pdf->Text($x,$y,$texto);

$texto="DIRECCION: ".$direccion;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=18;
$y=64;
//$pdf->Text($x,$y,$texto);

$texto="TELEFONO: ".$telefono;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=130;
$y=64;
//$pdf->Text($x,$y,$texto);

$texto="CON LA PRESENTE ME PERMITO PRESENTAR AL(A)";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=18;
$y=125;
$pdf->Text($x,$y,$texto);

$texto=decod("Señor (a): ");
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=135;
$pdf->Text($x,$y,$texto);

$x1=68;
$x2=185;
$y1=137;
$y2=137;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=141;
$y2=141;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=145;
$y2=145;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=$nombre1;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=68;
$y=135;
$pdf->Text($x,$y,$texto);

$texto=decod("Cedula de Ciudadanía: ");
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=152;
$pdf->Text($x,$y,$texto);

$x1=68;
$x2=185;
$y1=154;
$y2=154;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=158;
$y2=158;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=163;
$y2=163;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=$ced1;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=68;
$y=152;
$pdf->Text($x,$y,$texto);

$texto="Carnet interno No: ";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=170;
$pdf->Text($x,$y,$texto);

$x1=68;
$x2=185;
$y1=173;
$y2=173;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=177;
$y2=177;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=181;
$y2=181;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=$carnet;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=68;
$y=171;
$pdf->Text($x,$y,$texto);

$texto=decod("Quien cumplirá la siguiente programación:");
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=187;
$pdf->Text($x,$y,$texto);

$x1=25;
$x2=185;
$y1=193;
$y2=193;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=25;
$x2=185;
$y1=197;
$y2=197;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=25;
$x2=185;
$y1=201;
$y2=201;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="En reemplazo del(a) sr(a):";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=210;
$pdf->Text($x,$y,$texto);

$x1=68;
$x2=185;
$y1=212;
$y2=212;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=216;
$y2=216;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=220;
$y2=220;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=$nombre2;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=68;
$y=210;
$pdf->Text($x,$y,$texto);

$texto="Identificado con CC: ".$ced2;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=68;
$y=215.6;
$pdf->Text($x,$y,$texto);

$texto=$motivo;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=68;
$y=228;
$pdf->Text($x,$y,$texto);
if($dias!="Indefinidamente"){$mens3="durante " .$dias." dia(s)";}else{$mens3="Cambio por Tiempo Indefinido";};
$texto="A partir del: ".$fechapartir." aaaa-mm-dd ".$mens3;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=192;
$pdf->Text($x,$y,$texto);

$texto="Motivo: ";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=227;
$pdf->Text($x,$y,$texto);

$x1=68;
$x2=185;
$y1=229;
$y2=229;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=233;
$y2=233;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=68;
$x2=185;
$y1=237;
$y2=237;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="Atentamente:";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=18;
$y=242;
$pdf->Text($x,$y,$texto);

$texto="DIRECTOR OPERATIVO $empresa.";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=18;
$y=263;
$pdf->Text($x,$y,$texto);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=280;
require('saludoslis.php');

$texto="F-P-OPER-03/V.01/15/09/2007";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=20;
$y=275;
$pdf->Text($x,$y,$texto);

$pdf->Output();
}else{echo "<h2>Debe cargar una orden de trabajo para realizar el documento</h2>".'<h3><div align=left><A HREF="documentosordenes.php">Atras</A></div><h3>';exit();}
?>
