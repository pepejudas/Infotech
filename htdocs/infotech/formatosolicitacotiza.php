<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1010);

if($_SESSION[cedulamod]==""){
	$sql122="SELECT * FROM condicionescliente ORDER BY numerooferta DESC";
	$cons=@mysql_query($sql122);
	$_SESSION[cedulamod]=@mysql_result($cons,0,"numerooferta");
}

$sql1="SELECT * FROM necesidadescliente, sucursales WHERE necesidadescliente.numerooferta=$_SESSION[cedulamod] AND necesidadescliente.sucursal=sucursales.id";
$vectordatos=@mysql_query($sql1);

$ciudadyfecha=decod(recortarcadena(@mysql_result($vectordatos,0,"sucursales.ciudad").", ".date("d-M-Y",time()),50));
$nombrecliente=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.empresa"),45));
$numerooferta=decod(@mysql_result($vectordatos,0,"necesidadescliente.numerooferta"));
$contacto=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.contacto"),40));
$direccion=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.direccion"),60));
$email=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.email"),45));
$actividadeconomica=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.actividadeconomica"),35));
$nit=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.nit"),30));
$cargo=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.cargo"),25));
$telefono=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.telefono"),20));
$fax=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.fax"),20));
$estrato=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.estrato"),5));
$otrosreqv=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.otrosreqv"),250));
$comoenteroempresa=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.comoenteroempresa"),100));
$verificaclinton0=@mysql_result($vectordatos,0,"necesidadescliente.verificacionclinton");
$fechaverifica=@mysql_result($vectordatos,0,"necesidadescliente.fechaverifica");
$fechaentrega=@mysql_result($vectordatos,0,"necesidadescliente.fechaentrega");
$nombreverificaclinton=recortarcadena(decod(@mysql_result($vectordatos,0,"necesidadescliente.nombreverificaclinton")),100);
$apruebacotizacion0=@mysql_result($vectordatos,0,"necesidadescliente.apruebacotizacion");


$sql2="SELECT * FROM servicios WHERE `servicios`.`idoferta` = '$numerooferta'";
$vectordatos1=@mysql_query($sql2);
$lim=@mysql_num_rows($vectordatos1);
$cont=0;

$sql3="SELECT * FROM usuarios WHERE `usuarios`.`usuario` LIKE '$_SESSION[persona]'";
$conspersona=@mysql_query($sql3,$link);
$datostomadospor=recortarcadena(@mysql_result($conspersona,0,"nombres")." ".@mysql_result($conspersona,0,"apellidos"),100);
$cargotomadatos0=@mysql_result($conspersona,0,"cargo");

switch($cargotomadatos0){
	case "1":$cargotomadatos="Directivo";break;
	case "3":$cargotomadatos="Director de Operaciones";break;
	case "16":$cargotomadatos="Director	de Recurso Humanos";break;
	case "17":$cargotomadatos="Director de Contabilidad";break;
	case "4":$cargotomadatos="Entrenador Canino";break;
	case "5":$cargotomadatos="Escoltas";break;
	case "6":$cargotomadatos="Guia	Canino";break;
	case "7":$cargotomadatos="Manejador Canino";break;
	case "8":$cargotomadatos="Representante Legal";break;
	case "9":$cargotomadatos="Supervisor";break;
	case "10":$cargotomadatos="Supervisor Medio Tecnologico";break;
	case "11":$cargotomadatos="Tecnico Medio Tecnologico";break;
	case "12":$cargotomadatos="Vigilante";break;
	case "13":$cargotomadatos="Operador	Medio Tecnologico";break;
	case "14":$cargotomadatos="Tripulante";break;
	case "15":$cargotomadatos="Conductor";break;
	default: $cargotomadatos="Directivo";break;
}
switch($verificaclinton0){
	case "1":
		$verificaclintonx=56;
		break;
	case "2":
		$verificaclintonx=66;
		break;
	default:
		$verificaclintonx=-100;
		break;
}

switch($apruebacotizacion0){
	case "1":
		$apruebacotizacionx=73;
		break;
	case "2":
		$apruebacotizacionx=88;
		break;
	default:
		$apruebacotizacionx=-100;
		break;
}
//$verificaclintonx=

require('fpdf/fpdf.php');
$pdf=new FPDF('P','mm', 'letter');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=25;
$y=22;
$pdf->Image($file,$x,$y,$h=20);
$pdf->Ln();

$x=17;
$y=20;
$w=185;
$h=25;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$x1=73;
$y1=20;
$x2=73;
$y2=45;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=73;
$y1=40;
$x2=202;
$y2=40;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=73;
$y1=35;
$x2=202;
$y2=35;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=135;
$y1=35;
$x2=135;
$y2=45;
$pdf->Line($x1,$y1,$x2,$y2);

$pdf->SetFont('Arial','B',15);
$pdf->Text(92,30,decod("SOLICITUD DE COTIZACIONES"));

$pdf->SetFont('Arial','',10);
$pdf->Text(75,39,decod("CODIGO FT-M01-01"));

$numpag=$pdf->PageNo();
$pdf->Text(140,39,decod("Pág. ".$pdf->PageNo()." de ".'{nb}'));

$pdf->Text(75,44,decod("FECHA EXP.: Enero de 2008"));

$pdf->Text(140,44,decod("REVISION No.: 01"));

//CUERPO DEL FORMATO
$x=20;
$y=52;
$espacio=5;

$pdf->Text($x,$y,decod("Ciudad y Fecha:    $ciudadyfecha"));

$pdf->Line($x+30,$y+1,$x+180,$y+1);

$y+=$espacio;
$pdf->Text($x,$y,decod("Nombre de la empresa:   $nombrecliente"));

$pdf->Line($x+40,$y+1,$x+120,$y+1);

$pdf->Text($x+122,$y,decod("Nit o C.C.:  $nit"));

$pdf->Line($x+140,$y+1,$x+180,$y+1);

$y+=$espacio;
$pdf->Text($x,$y,decod("A quien se dirige la cotización:   $contacto"));

$pdf->Line($x+50,$y+1,$x+120,$y+1);

$pdf->Text($x+122,$y,decod("Cargo:   $cargo"));

$pdf->Line($x+135,$y+1,$x+180,$y+1);

$y+=$espacio;
$pdf->Text($x,$y,decod("Direccion:    $direccion"));

$pdf->Line($x+20,$y+1,$x+120,$y+1);

$pdf->Text($x+122,$y,decod("Tel:   $telefono"));

$pdf->Line($x+130,$y+1,$x+180,$y+1);

$y+=$espacio;
$pdf->Text($x,$y,decod("Dirección Electrónica:   $email"));

$pdf->Line($x+37,$y+1,$x+120,$y+1);

$pdf->Text($x+122,$y,decod("Fax:   $fax"));

$pdf->Line($x+130,$y+1,$x+180,$y+1);

$y+=$espacio;
$pdf->Text($x,$y,decod("Actividad Económica de la Empresa:   $actividadeconomica"));

$pdf->Line($x+58,$y+1,$x+120,$y+1);

$pdf->Text($x+122,$y,decod("Estrato:   $estrato"));

$pdf->Line($x+135,$y+1,$x+180,$y+1);

$x=17;
$y+=$espacio;
$w=185;
$h=55;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$x1=$x;
$y1=$y+5;
$x2=202;
$y2=$y+5;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+10;
$x2=202;
$y2=$y+10;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+25;
$y1=$y+5;
$x2=$x+25;
$y2=$y+55;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+145;
$y1=$y+5;
$x2=$x+145;
$y2=$y+55;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio-1;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+70,$y,decod("SERVICIOS SOLICITADOS"));

$y+=$espacio;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("CANTIDAD"));

$pdf->Text($x+80,$y,decod("DESCRIPCIÓN"));

$pdf->Text($x+150,$y,decod("VALOR MENSUAL"));

$x=17;
$y+=$espacio+43;
$w=185;
$h=17;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO



$y+=$espacio;
$pdf->SetFont('Arial','',8);
$pdf->Text($x+2,$y,decod("REQUERIMIENTOS ESPECIALES SIN COSTO ADICIONAL:"));

$w=180;
$h=5;
$xw=20;
$pdf->Sety($y+2);
$pdf->Setx($xw);
$pdf->MultiCell($w,$h,recortarcadena($otrosreqv,250),$border=0,$align='J',$fill=0);

$x=17;
$y+=$espacio+8;
$w=185;
$h=12;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$y+=$espacio;
$pdf->SetFont('Arial','',8);
$pdf->Text($x+2,$y,decod("Como se enteró de nuestra empresa:  $comoenteroempresa"));

$y+=$espacio;
$pdf->Text($x+2,$y,decod("Datos Tomados por:  $datostomadospor"));

$pdf->Text($x+100,$y,decod("Cargo:   $cargotomadatos"));

$x=17;
$y+=$espacio-2;
$w=185;
$h=12;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$y+=$espacio;
$pdf->SetFont('Arial','',8);
$pdf->Text($x+2,$y,decod("Verificación Lista Clinton Si:___   No:___"));

$pdf->Text($verificaclintonx,$y,"X");

$pdf->Text($x+80,$y,decod("Fecha de Consulta:  $fechaverifica"));

$y+=$espacio;
$pdf->Text($x+2,$y,decod("Nombre de Quien Verifica:   $nombreverificaclinton"));

$x=17;
$y+=$espacio-2;
$w=185;
$h=70;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$y+=$espacio-1;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+35,$y,decod("PARA USO EXCLUSIVO DE LA DIRECCION DE MERCADEO Y VENTAS"));

$x1=$x;
$y1=$y+1;
$x2=$x+185;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+3;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+2,$y,decod("Se aprueba realizar cotización Si:___   No:___"));

$pdf->Text($apruebacotizacionx,$y,"X");

$pdf->Text($x+90,$y,decod("Firma de Aprobación:"));

$x1=$x+80;
$y1=$y-7;
$x2=$x+80;
$y2=$y+13;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+3;
$x2=$x+185;
$y2=$y+3;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+3;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+2,$y,decod("Fecha de Entrega:  $fechaentrega"));

$pdf->Text($x+90,$y,decod("Número de Cotización:                              $numerooferta"));

$x1=$x;
$y1=$y+5;
$x2=$x+185;
$y2=$y+5;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+5;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+75,$y,decod("SEGUIMIENTO"));

$x1=$x;
$y1=$y+1;
$x2=$x+185;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio;
$pdf->Text($x+18,$y,decod("FECHA"));

$pdf->Text($x+75,$y,decod("DESCRIPCIÓN"));

$pdf->Text($x+130,$y,decod("RESPONSABLE"));

$pdf->SetFont('Arial','',10);

$y+=$espacio-3;
$x1=$x;
$y1=$y+1;
$x2=$x+185;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+40;
$y1=$y-6;
$x2=$x+40;
$y2=$y+33;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+120;
$y1=$y-6;
$x2=$x+120;
$y2=$y+33;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+3;
$x1=$x;
$y1=$y+1;
$x2=$x+185;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+3;
$x1=$x;
$y1=$y+1;
$x2=$x+185;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+3;
$x1=$x;
$y1=$y+1;
$x2=$x+185;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

//seguimiento
$sql4="SELECT * FROM `seguimiento` WHERE `seguimiento`.`idoferta` = '$numerooferta' ORDER BY `seguimiento`.`id` DESC";
$resultaseg=@mysql_query($sql4);
$iniseg=0;
$limseg=@mysql_num_rows($resultaseg);

$y3=219;

while($iniseg<$limseg){
	$y3+=$espacio+2.6;
	$pdf->Text($x+4,$y3,decod(@mysql_result($resultaseg,$iniseg,"fecha")));
	$pdf->SetFont('Arial','',8);
	$pdf->Text($x+42,$y3,recortarcadena(decod(@mysql_result($resultaseg,$iniseg,"comentarios")),60));
	$pdf->Text($x+125,$y3,recortarcadena(decod(@mysql_result($resultaseg,$iniseg,"encargado")),33));
	$pdf->SetFont('Arial','',10);
	if($iniseg==3){break;}
	$iniseg++;
}
//fin seguimiento

$yserv=$y-160;
$x=25;

while($cont<$lim){


	if($yserv>120){

		$pdf->AddPage();
		$pdf->SetFont('Arial','B',18);
		$pdf->Ln();
		$file="imagenes/logonap.jpg";
		$x=25;
		$y=22;
		$pdf->Image($file,$x,$y,$w=40,$h=20);
		$pdf->Ln();

		$x=17;
		$y=20;
		$w=185;
		$h=25;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$x1=73;
		$y1=20;
		$x2=73;
		$y2=45;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=73;
		$y1=40;
		$x2=202;
		$y2=40;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=73;
		$y1=35;
		$x2=202;
		$y2=35;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=135;
		$y1=35;
		$x2=135;
		$y2=45;
		$pdf->Line($x1,$y1,$x2,$y2);

		$pdf->SetFont('Arial','B',15);
		$pdf->Text(92,30,decod("SOLICITUD DE COTIZACIONES"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text(75,39,decod("CODIGO FT-M01-01"));

		$numpag=$pdf->PageNo();
		$pdf->Text(140,39,decod("Pág. ".$pdf->PageNo()." de ".'{nb}'));

		$pdf->Text(75,44,decod("FECHA EXP.: Enero de 2008"));

		$pdf->Text(140,44,decod("REVISION No.: 01"));

		//CUERPO DEL FORMATO
		$x=20;
		$y=52;
		$espacio=5;

		$pdf->Text($x,$y,decod("Ciudad y Fecha:    $ciudadyfecha"));

		$pdf->Line($x+30,$y+1,$x+180,$y+1);

		$y+=$espacio;
		$pdf->Text($x,$y,decod("Nombre de la empresa:   $nombrecliente"));

		$pdf->Line($x+40,$y+1,$x+120,$y+1);

		$pdf->Text($x+122,$y,decod("Nit o C.C.:  $nit"));

		$pdf->Line($x+140,$y+1,$x+180,$y+1);

		$y+=$espacio;
		$pdf->Text($x,$y,decod("A quien se dirige la cotización:   $contacto"));

		$pdf->Line($x+50,$y+1,$x+120,$y+1);

		$pdf->Text($x+122,$y,decod("Cargo:   $cargo"));

		$pdf->Line($x+135,$y+1,$x+180,$y+1);

		$y+=$espacio;
		$pdf->Text($x,$y,decod("Direccion:    $direccion"));

		$pdf->Line($x+20,$y+1,$x+120,$y+1);

		$pdf->Text($x+122,$y,decod("Tel:   $telefono"));

		$pdf->Line($x+130,$y+1,$x+180,$y+1);

		$y+=$espacio;
		$pdf->Text($x,$y,decod("Dirección Electrónica:   $email"));

		$pdf->Line($x+37,$y+1,$x+120,$y+1);

		$pdf->Text($x+122,$y,decod("Fax:   $fax"));

		$pdf->Line($x+130,$y+1,$x+180,$y+1);

		$y+=$espacio;
		$pdf->Text($x,$y,decod("Actividad Económica de la Empresa:   $actividadeconomica"));

		$pdf->Line($x+58,$y+1,$x+120,$y+1);

		$pdf->Text($x+122,$y,decod("Estrato:   $estrato"));

		$pdf->Line($x+135,$y+1,$x+180,$y+1);

		$x=17;
		$y+=$espacio;
		$w=185;
		$h=55;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$x1=$x;
		$y1=$y+5;
		$x2=202;
		$y2=$y+5;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+10;
		$x2=202;
		$y2=$y+10;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+25;
		$y1=$y+5;
		$x2=$x+25;
		$y2=$y+55;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+145;
		$y1=$y+5;
		$x2=$x+145;
		$y2=$y+55;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio-1;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+70,$y,decod("SERVICIOS SOLICITADOS"));

		$y+=$espacio;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("CANTIDAD"));

		$pdf->Text($x+80,$y,decod("DESCRIPCIÓN"));

		$pdf->Text($x+150,$y,decod("VALOR MENSUAL"));

		$x=17;
		$y+=$espacio+43;
		$w=185;
		$h=17;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO



		$y+=$espacio;
		$pdf->SetFont('Arial','',8);
		$pdf->Text($x+2,$y,decod("REQUERIMIENTOS ESPECIALES SIN COSTO ADICIONAL:"));

		$w=180;
		$h=5;
		$xw=20;
		$pdf->Sety($y+2);
		$pdf->Setx($xw);
		$pdf->MultiCell($w,$h,recortarcadena($otrosreqv,250),$border=0,$align='J',$fill=0);

		$x=17;
		$y+=$espacio+8;
		$w=185;
		$h=12;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$y+=$espacio;
		$pdf->SetFont('Arial','',8);
		$pdf->Text($x+2,$y,decod("Como se enteró de nuestra empresa:  $comoenteroempresa"));

		$y+=$espacio;
		$pdf->Text($x+2,$y,decod("Datos Tomados por:  $datostomadospor"));

		$pdf->Text($x+100,$y,decod("Cargo:   $cargotomadatos"));

		$x=17;
		$y+=$espacio-2;
		$w=185;
		$h=12;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$y+=$espacio;
		$pdf->SetFont('Arial','',8);
		$pdf->Text($x+2,$y,decod("Verificación Lista Clinton Si:___   No:___"));

		$pdf->Text($verificaclintonx,$y,"X");

		$pdf->Text($x+80,$y,decod("Fecha de Consulta:  $fechaverifica"));

		$y+=$espacio;
		$pdf->Text($x+2,$y,decod("Nombre de Quien Verifica:   $nombreverificaclinton"));

		$x=17;
		$y+=$espacio-2;
		$w=185;
		$h=70;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$y+=$espacio-1;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+35,$y,decod("PARA USO EXCLUSIVO DE LA DIRECCION DE MERCADEO Y VENTAS"));

		$x1=$x;
		$y1=$y+1;
		$x2=$x+185;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+3;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+2,$y,decod("Se aprueba realizar cotización Si:___   No:___"));

		$pdf->Text($apruebacotizacionx,$y,"X");

		$pdf->Text($x+90,$y,decod("Firma de Aprobación:"));

		$x1=$x+80;
		$y1=$y-7;
		$x2=$x+80;
		$y2=$y+13;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+3;
		$x2=$x+185;
		$y2=$y+3;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+3;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+2,$y,decod("Fecha de Entrega:  $fechaentrega"));

		$pdf->Text($x+90,$y,decod("Número de Cotización:                              $numerooferta"));

		$x1=$x;
		$y1=$y+5;
		$x2=$x+185;
		$y2=$y+5;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+5;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+75,$y,decod("SEGUIMIENTO"));

		$x1=$x;
		$y1=$y+1;
		$x2=$x+185;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio;
		$pdf->Text($x+18,$y,decod("FECHA"));

		$pdf->Text($x+75,$y,decod("DESCRIPCIÓN"));

		$pdf->Text($x+130,$y,decod("RESPONSABLE"));

		$pdf->SetFont('Arial','',10);

		$y+=$espacio-3;
		$x1=$x;
		$y1=$y+1;
		$x2=$x+185;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+40;
		$y1=$y-6;
		$x2=$x+40;
		$y2=$y+33;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+120;
		$y1=$y-6;
		$x2=$x+120;
		$y2=$y+33;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+3;
		$x1=$x;
		$y1=$y+1;
		$x2=$x+185;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+3;
		$x1=$x;
		$y1=$y+1;
		$x2=$x+185;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+3;
		$x1=$x;
		$y1=$y+1;
		$x2=$x+185;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		//seguimiento
		$sql4="SELECT * FROM `seguimiento` WHERE `seguimiento`.`idoferta` = '$numerooferta' ORDER BY `seguimiento`.`id` DESC";
		$resultaseg=@mysql_query($sql4);
		$iniseg=0;
		$limseg=@mysql_num_rows($resultaseg);

		$y3=219;

		while($iniseg<$limseg){
			$y3+=$espacio+2.6;
			$pdf->Text($x+4,$y3,decod(@mysql_result($resultaseg,$iniseg,"fecha")));
			$pdf->SetFont('Arial','',8);
			$pdf->Text($x+42,$y3,recortarcadena(decod(@mysql_result($resultaseg,$iniseg,"comentarios")),60));
			$pdf->Text($x+125,$y3,recortarcadena(decod(@mysql_result($resultaseg,$iniseg,"encargado")),33));
			$pdf->SetFont('Arial','',10);
			if($iniseg==3){break;}
			$iniseg++;
		}
		//fin seguimiento

		$yserv=$y-160;
		$x=25;

	}

	$cantidad=decod(@mysql_result($vectordatos1,$cont,"cantidadservicios"));
	$descripcion=decod(@mysql_result($vectordatos1,$cont,"descripcion"));
	$valormensual=decod(@mysql_result($vectordatos1,$cont,"valorservicio"));

	$yserv+=10;

	$pdf->SetFont('Arial','',10);
	$pdf->Text($x+5,$yserv+3,decod($cantidad));


	$w=115;
	$h=5;
	$xw=45;
	$pdf->Sety($yserv);
	$pdf->Setx($xw);
	$pdf->MultiCell($w,$h,recortarcadena($descripcion,135),$border=0,$align='J',$fill=0);

	$pdf->Sety($yserv);
	$pdf->Setx($xw+120);
	$pdf->MultiCell(35,5,recortarcadena("$ ".number_format($valormensual,0),100),$border=0,$align='R',$fill=0);


	$cont++;
}



$pdf->Output();
?>