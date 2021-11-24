<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 63);

$vector0=explode("/",$_SERVER['HTTP_REFERER']);
$elementos0=count($vector0);
$form0=$vector0[$elementos0-1];

require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
	
switch($form0){
	case "documentosdotacion.php":	
	
$sqli="SELECT * FROM dotacion, personalactivo, productos, clientes WHERE dotacion.iddot=$_SESSION[iddota] AND dotacion.ceduladot=$_SESSION[cedulamod] AND dotacion.ceduladot = personalactivo.cedula AND dotacion.idprod=productos.id AND personalactivo.codigo=clientes.codigo";
$cons=@mysql_query($sqli);
$cedula=@mysql_result($cons,0,ceduladot);
$apellido=decod(@mysql_result($cons,0,apellidos));
$nombre=decod(@mysql_result($cons,0,nombre));
$fechaini=@mysql_result($cons,0,fechaingreso);
$cliente=decod(@mysql_result($cons,0,nombrecliente));
$comps=@mysql_result($cons,0,compsal);
$id=@mysql_result($cons,0,id);

switch(@mysql_result($cons,0,cargo)):
			
			case 1: $cargo="DIRECTIVO"; break;
	 		case 3: $cargo="DIRECTOR DE OPERACIONES"; break;
	 		case 4: $cargo="ENTRENADOR CANINO"; break;
	 		case 5: $cargo="ESCOLTA"; break;
	 		case 6: $cargo="GUIA CANINO"; break;
	 		case 7: $cargo="MANEJADOR CANINO"; break;
	 		case 8: $cargo="REPRESENTANTE LEGAL"; break;
	 		case 9: $cargo="SUPERVISOR"; break;
	 		case 10: $cargo="SUPERVISOR MEDIO TECNOLOGICO"; break;
	 		case 11: $cargo="TECNICO MEDIO TECNOLOGICO"; break;
	 		case 12: $cargo="VIGILANTE"; break;
	 		case 13: $cargo="OPERADOR MEDIO TECNOLOGICO"; break;
	 		case 14: $cargo="TRIPULANTE"; break;
	 		
endswitch;

$fecha1=getdate(time());
$fecha2=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday];
$inic=0;
$limp=@mysql_num_rows($cons);

$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=170;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=recortarcadena($apellido." ".$nombre,30);
$pdf->SetFont('Arial','',7);
$x=65;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$cargo;
$pdf->SetFont('Arial','',8);
$x=147;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$id;
$pdf->SetFont('Arial','',15);
$x=155;
$y=66;
$pdf->Text($x,$y,$texto);

$texto=$cliente;
$pdf->SetFont('Arial','',6);
$x=56;
$y=83;
$pdf->Text($x,$y,$texto);

$texto=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday]." aaaa-mm-dd";
$pdf->SetFont('Arial','',10);
$x=33;
$y=65;
$pdf->Text($x,$y,$texto);


$texto="                                 COMPROBANTE DE SALIDA
		   ";

$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$w=176;
$h=6;
$y=37;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$texto2="FECHA:__________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=61;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="NOMBRE DE QUIEN RECIBE__________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="PUESTO DE TRABAJO_______________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="CARGO:______________________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="REQUISICION No_______________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="";
$pdf->SetFont('Arial','',9);
$x=150;
$y=61;
$w=40;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

$texto="CANTIDAD";
$pdf->SetFont('Arial','',10);
$x=35;
$y=94;
$pdf->Text($x,$y,$texto);

$texto="COMPROBANTE DE SALIDA No";
$pdf->SetFont('Arial','',10);
$x=95;
$y=65;
$pdf->Text($x,$y,$texto);

$texto="DESCRIPCION";
$pdf->SetFont('Arial','',10);
$x=115;
$y=94;
$pdf->Text($x,$y,$texto);

$x=20;
$y=90;
$w=170;
$h=145;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

//lineas horizontales
$x1=20;
$y1=95;
$x2=190;
$y2=95;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=105;
$x2=190;
$y2=105;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=115;
$x2=190;
$y2=115;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=125;
$x2=190;
$y2=125;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=135;
$x2=190;
$y2=135;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=145;
$x2=190;
$y2=145;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=155;
$x2=190;
$y2=155;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=165;
$x2=190;
$y2=165;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=175;
$x2=190;
$y2=175;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=185;
$x2=190;
$y2=185;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=195;
$x2=190;
$y2=195;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=205;
$x2=190;
$y2=205;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=215;
$x2=190;
$y2=215;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=225;
$x2=190;
$y2=225;
$pdf->Line($x1,$y1,$x2,$y2);

//lineas verticales

$x1=70;
$y1=90;
$x2=70;
$y2=235;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="ENTEGADO POR:_______________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="RECIBIDO POR_________________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="OBSERVACIONES";
$pdf->SetFont('Arial','',10);
$x=22;
$y=240;
$pdf->Text($x,$y,$texto);

$texto="F-CO-006/V.00/18-04-2006";
$pdf->SetFont('Arial','',10);
$x=22;
$y=275;
$pdf->Text($x,$y,$texto);

$x=20;
$y=236;
$w=170;
$h=20;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);


$texto="C.C.________________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=272;
$pdf->Text($x,$y,$texto);

$y=92;

for($inic=0;$inic<$limp;$inic++){
	$y+=10;
	$cantidad=@mysql_result($cons,$inic,cantidad);
	$producto=recortarcadena(decod(@mysql_result($cons,$inic,nombreprod)),30);
	
	$texto=$cantidad;
	$pdf->SetFont('Arial','',15);
	$x=27;
	$pdf->Text($x,$y,$texto);
	
	$texto=$producto;
	$pdf->SetFont('Arial','',15);
	$x=72;
	$pdf->Text($x,$y,$texto);
	
	if($y>=225){
	$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=170;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=$cedula;
$pdf->SetFont('Arial','',10);
$x=50;
$y=74;
$pdf->Text($x,$y,$texto);

$texto=$apellido." ".$nombre;
$pdf->SetFont('Arial','',8);
$x=65;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$cargo;
$pdf->SetFont('Arial','',8);
$x=147;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$comps;
$pdf->SetFont('Arial','',15);
$x=155;
$y=66;
$pdf->Text($x,$y,$texto);

$texto=$cliente;
$pdf->SetFont('Arial','',6);
$x=56;
$y=83;
$pdf->Text($x,$y,$texto);

$texto=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday]." aaaa-mm-dd";
$pdf->SetFont('Arial','',10);
$x=33;
$y=65;
$pdf->Text($x,$y,$texto);


$texto="                                 COMPROBANTE DE SALIDA
		   ";

$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$w=176;
$h=6;
$y=37;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$texto2="FECHA:__________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=61;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="NOMBRE DE QUIEN RECIBE__________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="PUESTO DE TRABAJO_______________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="CARGO:______________________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="REQUISICION No_______________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="";
$pdf->SetFont('Arial','',9);
$x=150;
$y=61;
$w=40;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

$texto="CANTIDAD";
$pdf->SetFont('Arial','',10);
$x=35;
$y=94;
$pdf->Text($x,$y,$texto);

$texto="COMPROBANTE DE SALIDA No";
$pdf->SetFont('Arial','',10);
$x=95;
$y=65;
$pdf->Text($x,$y,$texto);

$texto="DESCRIPCION";
$pdf->SetFont('Arial','',10);
$x=115;
$y=94;
$pdf->Text($x,$y,$texto);

$x=20;
$y=90;
$w=170;
$h=145;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

//lineas horizontales
$x1=20;
$y1=95;
$x2=190;
$y2=95;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=105;
$x2=190;
$y2=105;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=115;
$x2=190;
$y2=115;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=125;
$x2=190;
$y2=125;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=135;
$x2=190;
$y2=135;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=145;
$x2=190;
$y2=145;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=155;
$x2=190;
$y2=155;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=165;
$x2=190;
$y2=165;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=175;
$x2=190;
$y2=175;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=185;
$x2=190;
$y2=185;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=195;
$x2=190;
$y2=195;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=205;
$x2=190;
$y2=205;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=215;
$x2=190;
$y2=215;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=225;
$x2=190;
$y2=225;
$pdf->Line($x1,$y1,$x2,$y2);

//lineas verticales

$x1=70;
$y1=90;
$x2=70;
$y2=235;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="ENTEGADO POR:_______________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="RECIBIDO POR_________________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="OBSERVACIONES";
$pdf->SetFont('Arial','',10);
$x=22;
$y=240;
$pdf->Text($x,$y,$texto);

$texto="F-CO-006/V.00/18-04-2006";
$pdf->SetFont('Arial','',10);
$x=22;
$y=275;
$pdf->Text($x,$y,$texto);

$x=20;
$y=236;
$w=170;
$h=20;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);


$texto="C.C.________________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=272;
$pdf->Text($x,$y,$texto);

$y=92;
	}
}
break;
case "documentosdotacioncliente.php":

	$sqli="SELECT * FROM dotacion, productos, clientes WHERE dotacion.iddot=$_SESSION[iddota] AND dotacion.ceduladot='$_SESSION[cedulamod]' AND dotacion.ceduladot = clientes.codigo AND dotacion.idprod=productos.id";
	$cons=@mysql_query($sqli);
	$codigo=@mysql_result($cons,0,ceduladot);
	$nombrecliente=recortarcadena(decod(@mysql_result($cons,0,nombrecliente)),30);
	$administrador=recortarcadena(decod(@mysql_result($cons,0,nombreadministrador)),30);
	$fechaini=@mysql_result($cons,0,fechaingreso);
	$nit=decod(@mysql_result($cons,0,nombrecliente));
	$id=@mysql_result($cons,0,id);
	
$fecha1=getdate(time());
$fecha2=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday];
$inic=0;
$limp=@mysql_num_rows($cons);

$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=170;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=recortarcadena($administrador,30);
$pdf->SetFont('Arial','',7);
$x=65;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$codigo;
$pdf->SetFont('Arial','',8);
$x=147;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$id;
$pdf->SetFont('Arial','',15);
$x=155;
$y=66;
$pdf->Text($x,$y,$texto);

$texto=$nombrecliente;
$pdf->SetFont('Arial','',6);
$x=56;
$y=83;
$pdf->Text($x,$y,$texto);

$texto=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday]." aaaa-mm-dd";
$pdf->SetFont('Arial','',10);
$x=33;
$y=65;
$pdf->Text($x,$y,$texto);


$texto="                                 COMPROBANTE DE SALIDA
		   ";

$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$w=176;
$h=6;
$y=37;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$texto2="FECHA:__________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=61;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="NOMBRE REPRESENTANTE__________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="NOMBRE CLIENTE__________________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="CODIGO:______________________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="REQUISICION No_______________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="";
$pdf->SetFont('Arial','',9);
$x=150;
$y=61;
$w=40;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

$texto="CANTIDAD";
$pdf->SetFont('Arial','',10);
$x=35;
$y=94;
$pdf->Text($x,$y,$texto);

$texto="COMPROBANTE DE SALIDA No";
$pdf->SetFont('Arial','',10);
$x=95;
$y=65;
$pdf->Text($x,$y,$texto);

$texto="DESCRIPCION";
$pdf->SetFont('Arial','',10);
$x=115;
$y=94;
$pdf->Text($x,$y,$texto);

$x=20;
$y=90;
$w=170;
$h=145;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

//lineas horizontales
$x1=20;
$y1=95;
$x2=190;
$y2=95;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=105;
$x2=190;
$y2=105;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=115;
$x2=190;
$y2=115;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=125;
$x2=190;
$y2=125;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=135;
$x2=190;
$y2=135;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=145;
$x2=190;
$y2=145;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=155;
$x2=190;
$y2=155;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=165;
$x2=190;
$y2=165;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=175;
$x2=190;
$y2=175;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=185;
$x2=190;
$y2=185;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=195;
$x2=190;
$y2=195;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=205;
$x2=190;
$y2=205;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=215;
$x2=190;
$y2=215;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=225;
$x2=190;
$y2=225;
$pdf->Line($x1,$y1,$x2,$y2);

//lineas verticales

$x1=70;
$y1=90;
$x2=70;
$y2=235;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="ENTEGADO POR:_______________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="RECIBIDO POR_________________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="OBSERVACIONES";
$pdf->SetFont('Arial','',10);
$x=22;
$y=240;
$pdf->Text($x,$y,$texto);

$texto="F-CO-006/V.00/18-04-2006";
$pdf->SetFont('Arial','',10);
$x=22;
$y=275;
$pdf->Text($x,$y,$texto);

$x=20;
$y=236;
$w=170;
$h=20;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);


$texto="C.C.________________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=272;
$pdf->Text($x,$y,$texto);

$y=92;

for($inic=0;$inic<$limp;$inic++){
	$y+=10;
	$cantidad=@mysql_result($cons,$inic,cantidad);
	$producto=recortarcadena(decod(@mysql_result($cons,$inic,nombreprod)),30);
	
	$texto=$cantidad;
	$pdf->SetFont('Arial','',15);
	$x=27;
	$pdf->Text($x,$y,$texto);
	
	$texto=$producto;
	$pdf->SetFont('Arial','',15);
	$x=72;
	$pdf->Text($x,$y,$texto);
	
	if($y>=225){
	$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=26;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$pdf->Ln();
$x=20;
$y=25;
$w=170;
$h=30;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);
$x1=60;
$y1=25;
$x2=60;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);

$texto=$cedula;
$pdf->SetFont('Arial','',10);
$x=50;
$y=74;
$pdf->Text($x,$y,$texto);

$texto=$apellido." ".$nombre;
$pdf->SetFont('Arial','',8);
$x=65;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$cargo;
$pdf->SetFont('Arial','',8);
$x=147;
$y=79;
$pdf->Text($x,$y,$texto);

$texto=$comps;
$pdf->SetFont('Arial','',15);
$x=155;
$y=66;
$pdf->Text($x,$y,$texto);

$texto=$cliente;
$pdf->SetFont('Arial','',6);
$x=56;
$y=83;
$pdf->Text($x,$y,$texto);

$texto=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday]." aaaa-mm-dd";
$pdf->SetFont('Arial','',10);
$x=33;
$y=65;
$pdf->Text($x,$y,$texto);


$texto="                                 COMPROBANTE DE SALIDA
		   ";

$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
$w=176;
$h=6;
$y=37;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$texto2="FECHA:__________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=61;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="NOMBRE DE QUIEN RECIBE__________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="PUESTO DE TRABAJO_______________________________________";
$pdf->SetFont('Arial','',9);
$x=20;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="CARGO:______________________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=75;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="REQUISICION No_______________";
$pdf->SetFont('Arial','',9);
$x=130;
$y=80;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

$texto2="";
$pdf->SetFont('Arial','',9);
$x=150;
$y=61;
$w=40;
$pdf->Setxy($x,$y);
$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

$texto="CANTIDAD";
$pdf->SetFont('Arial','',10);
$x=35;
$y=94;
$pdf->Text($x,$y,$texto);

$texto="COMPROBANTE DE SALIDA No";
$pdf->SetFont('Arial','',10);
$x=95;
$y=65;
$pdf->Text($x,$y,$texto);

$texto="DESCRIPCION";
$pdf->SetFont('Arial','',10);
$x=115;
$y=94;
$pdf->Text($x,$y,$texto);

$x=20;
$y=90;
$w=170;
$h=145;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

//lineas horizontales
$x1=20;
$y1=95;
$x2=190;
$y2=95;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=105;
$x2=190;
$y2=105;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=115;
$x2=190;
$y2=115;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=125;
$x2=190;
$y2=125;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=135;
$x2=190;
$y2=135;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=145;
$x2=190;
$y2=145;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=155;
$x2=190;
$y2=155;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=165;
$x2=190;
$y2=165;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=175;
$x2=190;
$y2=175;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=185;
$x2=190;
$y2=185;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=195;
$x2=190;
$y2=195;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=205;
$x2=190;
$y2=205;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=215;
$x2=190;
$y2=215;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=20;
$y1=225;
$x2=190;
$y2=225;
$pdf->Line($x1,$y1,$x2,$y2);

//lineas verticales

$x1=70;
$y1=90;
$x2=70;
$y2=235;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="ENTEGADO POR:_______________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="RECIBIDO POR_________________________________________";
$pdf->SetFont('Arial','',10);
$x=20;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=260;
$pdf->Text($x,$y,$texto);

$texto="FIRMA______________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=266;
$pdf->Text($x,$y,$texto);

$texto="OBSERVACIONES";
$pdf->SetFont('Arial','',10);
$x=22;
$y=240;
$pdf->Text($x,$y,$texto);

$texto="F-CO-006/V.00/18-04-2006";
$pdf->SetFont('Arial','',10);
$x=22;
$y=275;
$pdf->Text($x,$y,$texto);

$x=20;
$y=236;
$w=170;
$h=20;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);


$texto="C.C.________________________";
$pdf->SetFont('Arial','',10);
$x=130;
$y=272;
$pdf->Text($x,$y,$texto);

$y=92;
	}
}	
	
break;	 	
}

$pdf->Output();

?>


