<?php
session_start();

@require('funciones2.php');

validar("","","", 1000);

$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$_SESSION[cedulamod]";
//echo $sql1;
$sql29="SELECT * FROM seguridadsuper";
$results=@mysql_query($sql29);
$result=@mysql_query($sql1);
$direccions=decod(@mysql_result($results,0,direccion));
$barrios=decod(@mysql_result($results,0,barrio));
$telefonos1=@mysql_result($results,0,telefono1);
$telefonos2=@mysql_result($results,0,telefono2);
$telefonos3=@mysql_result($results,0,telefono3);
$telefonos4=@mysql_result($results,0,telefono4);
$paginaweb=decod(@mysql_result($results,0,paginaweb));
$razon=decod(@mysql_result($results,0,razonsocial));
$email=decod(@mysql_result($results,0,email));
$ciudads=decod(@mysql_result($results,0,ciudad));
$nombre=decod(@mysql_result($result,0,nombre));
$apellido=decod(@mysql_result($result,0,apellidos));
$cedula=@mysql_result($result,0,cedula);
$expedida=decod(@mysql_result($result,0,expedida));
$direccion=decod(@mysql_result($result,0,direccion));
$telefono=@mysql_result($result,0,telefono);
$foto=@mysql_result($result,0,foto);

switch(@mysql_result($result,0,cargo)){

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
	case 12: $cargo="GUARDA DE SEGURIDAD"; break;
	case 13: $cargo="OPERADOR MEDIO TECNOLOGICO"; break;
	case 14: $cargo="TRIPULANTE"; break;
	default: $cargo="NO ESPECIFICADO";break;
}

$ciudadnacim=@mysql_result($result,0,coddeptonacim).@mysql_result($result,0,codciudadnacim);
$fechanacim=@mysql_result($result,0,fechanacimiento);
$fechaing=@mysql_result($result,0,fechaingreso);
$carnet=@mysql_result($result,0,carnetinterno);
$codbusca=@mysql_result($result,0,codigo);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=@mysql_query($sql2);
$nombrecliente=@mysql_result($resulta,0,nombrecliente);
$sqlr="SELECT * FROM seguridadsuper";
$consr=@mysql_query($sqlr);
$res=@mysql_result($consr,0,numerolicencia);
$fechares=@mysql_result($consr,0, fechainiciolic);
if(@mysql_result($result,0,nombre)==""){echo '<h1>!Error debe cargar una persona<br>de lo contrario no puede ser generado <br> el carnet interno!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';exit();}

require('fpdf/fpdf.php');
$pdf=new FPDF($orientation='P',$unit='mm',$format='letter');

$pdf->AddPage();
$pdf->SetFont('Arial','B',3);
$file="imagenes/super10.jpg";
$x=61;
$y=40;
$pdf->Image($file,$x,$y,$w=30,$h=30);

$fo=@mysql_result($result,$_SESSION['i'],foto);
$ruta='fotosguardas/'.$fo;

if($fo!=""){
	$file=$ruta;
	$x=17;
	$y=30;
	$pdf->Image($file,$x,$y,$w=28,$h=42);
}

if($carnet!=""){
	$x1=15;
	$y1=15;
	$w1=91;
	$h1=60;
	$pdf->SetLineWidth(.3);
	$pdf->Rect($x1, $y1, $w1, $h1);

	$x1=17;
	$y1=30;
	$w1=28;
	$h1=42;
	$pdf->SetLineWidth(.3);
	$pdf->Rect($x1, $y1, $w1, $h1);

	$x1=110;
	$y1=15;
	$w1=91;
	$h1=60;
	$pdf->SetLineWidth(.3);
	$pdf->Rect($x1, $y1, $w1, $h1);

	$x1=13;
	$y1=13;
	$w1=95;
	$h1=64;
	$pdf->SetLineWidth(.2);
	$pdf->Rect($x1, $y1, $w1, $h1);

	$x1=108;
	$y1=13;
	$w1=95;
	$h1=64;
	$pdf->SetLineWidth(.2);
	$pdf->Rect($x1, $y1, $w1, $h1);



	$pdf->SetDrawColor(66,172,220);
	$pdf->SetLineWidth(.5);
	$x1=15;
	$x2=106;
	$y1=15;
	$y2=15;
	$pdf->Line($x1,$y1,$x2,$y2);

	$pdf->SetDrawColor(66,172,220);
	$pdf->SetLineWidth(.5);
	$x1=15;
	$x2=15;
	$y1=15;
	$y2=26;
	$pdf->Line($x1,$y1,$x2,$y2);

	$pdf->SetDrawColor(66,172,220);
	$pdf->SetLineWidth(.5);
	$x1=15;
	$x2=47;
	$y1=26;
	$y2=26;
	$pdf->Line($x1,$y1,$x2,$y2);

	$pdf->SetDrawColor(66,172,220);
	$pdf->SetLineWidth(.5);
	$x1=47;
	$x2=47;
	$y1=26;
	$y2=35;
	$pdf->Line($x1,$y1,$x2,$y2);

	$pdf->SetDrawColor(66,172,220);
	$pdf->SetLineWidth(.5);
	$x1=47;
	$x2=106;
	$y1=35;
	$y2=35;
	$pdf->Line($x1,$y1,$x2,$y2);

	$pdf->SetDrawColor(66,172,220);
	$pdf->SetLineWidth(.5);
	$x1=106;
	$x2=106;
	$y1=15;
	$y2=35;
	$pdf->Line($x1,$y1,$x2,$y2);

	$texto=recortarcadena($apellido." ".$nombre,38);
	$pdf->SetFont('Arial','',7.1);
	$x=48;
	$y=28;
	$pdf->Text($x,$y,$texto);

	$texto="C.C. ".$cedula." ".$expedida;
	$pdf->SetFont('Arial','',10);
	$x=48;
	$y=33;
	$pdf->Text($x,$y,$texto);

	$texto=$cargo;
	$pdf->SetFont('Arial','B',13);
	$x=20;
	$y=22;
	$pdf->Text($x,$y,$texto);

	$fecha1=getdate(time());
	$texto="Fecha: ".$fecha1[mday]."-".$fecha1[mon]."-".$fecha1[year];
	$pdf->SetFont('Arial','B',15);
	$pdf->Ln();
	$x=112;
	$y=25;
	$pdf->Text($x,$y,$texto);

	$pdf->SetDrawColor(0,0,0);
	$x1=130;
	$x2=190;
	$y1=26;
	$y2=26;
	$pdf->Line($x1,$y1,$x2,$y2);


	$texto=decod("Este documento es personal e intransferible y se debera entregar al retiro del empleado. En caso de perdida comuniquese con los telefonos de la compañía. El presente carnet debe ser portado en forma permanente.");
	$pdf->Ln();
	$pdf->SetXY(115,30);
	$w=75;
	$h=4;
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

	$texto="EL EMPLEADOR";
	$pdf->SetFont('Arial','B',12);
	$pdf->Ln();
	$x=137;
	$y=60;
	$pdf->Text($x,$y,$texto);

	$x1=122;
	$x2=190;
	$y1=56;
	$y2=56;
	$pdf->Line($x1,$y1,$x2,$y2);

	$texto=$direccions. " ". $barrios." Tels: ".$telefonos1."-".$telefonos2;
	$pdf->Ln();
	$pdf->SetXY(115,62);
	$w=80;
	$h=4;
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

	$texto=$paginaweb;
	$pdf->Ln();
	$pdf->SetXY(115,65);
	$w=80;
	$h=4;
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

	$pdf->SetFont('Arial','B',8);
	$pdf->Ln();
	$x11=20;
	$y11=85;
	require('saludoslis.php');

	$pdf->Output();

}
?>