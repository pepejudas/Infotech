<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1006);

if($_SESSION[cedulamod]==""){
	$sql122="SELECT * FROM condicionescliente ORDER BY numerooferta DESC";
	$cons=@mysql_query($sql122);
	$_SESSION[cedulamod]=@mysql_result($cons,0,"numerooferta");
}

$sql1="SELECT * FROM necesidadescliente, condicionescliente, sucursales, clientes WHERE `clientes`.`codigo` LIKE `condicionescliente`.`codigo` AND `condicionescliente`.`numerooferta`=`necesidadescliente`.`numerooferta` AND necesidadescliente.numerooferta=$_SESSION[cedulamod] AND necesidadescliente.sucursal=sucursales.id";
$vectordatos=@mysql_query($sql1);
$idoferta=@mysql_result($vectordatos,0,"condicionescliente.numerooferta");
$ciudadyfecha=decod(recortarcadena(@mysql_result($vectordatos,0,"sucursales.ciudad").", ".date("d-M-Y",time()),50));
$nombrecliente=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.empresa"),45));
$contacto=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.contacto"),40));
$direccion=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.direccion"),60));
$direccionservicio=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.direccion2"),60));
$actividadeconomica=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.actividadeconomica"),35));
$nit=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.nit"),30));
$cargo=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.cargo"),25));
$telefono=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.telefono"),20));
$telefono=decod(recortarcadena(@mysql_result($vectordatos,0,"necesidadescliente.telefono"),20));
$fechainstalacion0=split(" ",decod(recortarcadena(@mysql_result($vectordatos,0,"clientes.fechainiciocontrato"),20)));
$lugar=decod(recortarcadena(@mysql_result($vectordatos,0,"condicionescliente.lugar"),20));
$periodofacturacion=decod(recortarcadena(@mysql_result($vectordatos,0,"condicionescliente.periodofacturacion"),20));
$requisitosfacturacion=decod(recortarcadena(@mysql_result($vectordatos,0,"condicionescliente.requisitosfacturacion"),20));
$otrosreqv=decod(recortarcadena(@mysql_result($vectordatos,0,"condicionescliente.otrosreqv"),250));
$observaciones=decod(recortarcadena(@mysql_result($vectordatos,0,"condicionescliente.observacionesnec"),250));

$fechainstalacion=$fechainstalacion0[0];
$fechainstalacion1=$fechainstalacion0[1];

$sql2="SELECT * FROM servicios WHERE `servicios`.`idoferta` = '$numerooferta'";
$vectordatos1=@mysql_query($sql2);
$lim=@mysql_num_rows($vectordatos1);
$cont=0;

$sql3="SELECT * FROM `$_SESSION[usua]`, usuarios WHERE `$_SESSION[usua]`.`id`=`usuarios`.`idregistro` AND `$_SESSION[usua]`.`usuario` LIKE '$_SESSION[persona]'";
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
$pdf->Text(92,30,decod("INSTALACION DE SERVICIO"));

$pdf->SetFont('Arial','',10);
$pdf->Text(75,39,decod("CODIGO FT-M01-03"));

$numpag=$pdf->PageNo();
$pdf->Text(140,39,decod("Pág. ".$pdf->PageNo()." de ".'{nb}'));

$pdf->Text(75,44,decod("FECHA EXP.: Septiembre de 2003"));

$pdf->Text(140,44,decod("REVISION No.: 00"));

//CUERPO DEL FORMATO
$x=20;
$y=52;
$espacio=6;

$pdf->Text($x,$y,decod("PARA:                      :"));

$pdf->Line($x+33,$y+1,$x+180,$y+1);

$y+=$espacio;
$pdf->Text($x,$y,decod("DE:                           : DIRECCION DE MERCADEO Y VENTAS"));

$pdf->Line($x+33,$y+1,$x+180,$y+1);

$y+=$espacio;

$pdf->Text($x,$y,decod("CIUDAD Y FECHA:  : $ciudadyfecha"));

$pdf->Line($x+33,$y+1,$x+180,$y+1);

$y+=$espacio;

$pdf->SetFont('Arial','',11);

$texto=decod("Se informa sobre la instalación de un nuevo servicio con las características expuestas a continuación, con el propósito de que cada uno de los directores realice las actividades necesarias al interior de su departamento para cumplir a tiempo con los requisitos del cliente y del servicio.");
$w=180;
$h=6;
$x=17;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

$y+=$espacio+17;

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

$x1=$x;
$y1=$y+15;
$x2=202;
$y2=$y+15;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+20;
$x2=202;
$y2=$y+20;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+25;
$x2=202;
$y2=$y+25;
$pdf->Line($x1,$y1,$x2,$y2);


$x1=$x;
$y1=$y+30;
$x2=202;
$y2=$y+30;
$pdf->Line($x1,$y1,$x2,$y2);


$x1=$x;
$y1=$y+35;
$x2=202;
$y2=$y+35;
$pdf->Line($x1,$y1,$x2,$y2);


$x1=$x;
$y1=$y+40;
$x2=202;
$y2=$y+40;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+125;
$y1=$y+5;
$x2=$x+125;
$y2=$y+25;
$pdf->Line($x1,$y1,$x2,$y2);

$x=17;
$w=185;
$h=45;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$y+=$espacio-2;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+70,$y,decod("DATOS DEL CLIENTE"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Nombre de la Empresa:   $nombrecliente"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+128,$y,decod("Nit ó CC.:   $nit"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Nombre del contacto:   $contacto"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+128,$y,decod("Cargo:   $cargo"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Dirección oficinas:  $direccion"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+128,$y,decod("Teléfono:   $telefono"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Actividad Economica Empresa:   $actividadeconomica"));

$y+=$espacio-1;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+70,$y,decod("DATOS DEL SERVICIO"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Direccion del Servicio:   $direccionservicio"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+128,$y,decod("Teléfono:   $telefonoservicio"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Fecha de instalación:   $fechainstalacion"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+80,$y,decod("Hora:   $fechainstalacion1"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+128,$y,decod("Lugar:   $lugar"));

$y+=$espacio-1;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Periodo de Facturación:   $periodofacturacion"));

$pdf->SetFont('Arial','',10);
$pdf->Text($x+80,$y,decod("Requisitos para Facturar:  $requisitosfacturacion"));

$y+=$espacio-3;
$x=17;
$w=185;
$h=80;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);//RECTANGULO

$y+=$espacio-2;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+3,$y,decod("CANTIDAD"));

$pdf->SetFont('Arial','B',10);
$pdf->Text($x+38,$y,decod("DESCRIPCION DEL SERVICIO"));

$pdf->SetFont('Arial','B',10);
$pdf->Text($x+115,$y,decod("DIAS"));

$pdf->SetFont('Arial','B',10);
$pdf->Text($x+139,$y,decod("HORARIO"));

$pdf->SetFont('Arial','B',10);
$pdf->Text($x+165,$y,decod("VALOR"));

$x1=$x+25;
$y1=$y-4;
$x2=$x+25;
$y2=$y+36;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+105;
$y1=$y-4;
$x2=$x+105;
$y2=$y+36;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+132;
$y1=$y-4;
$x2=$x+132;
$y2=$y+36;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x+160;
$y1=$y-4;
$x2=$x+160;
$y2=$y+36;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+1;
$x2=202;
$y2=$y+1;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+6;
$x2=202;
$y2=$y+6;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+12;
$x2=202;
$y2=$y+12;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+18;
$x2=202;
$y2=$y+18;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+24;
$x2=202;
$y2=$y+24;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+30;
$x2=202;
$y2=$y+30;
$pdf->Line($x1,$y1,$x2,$y2);

$x1=$x;
$y1=$y+36;
$x2=202;
$y2=$y+36;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+35;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+3,$y,decod("REQUERIMIENTOS ESPECIALES"));

$pdf->SetFont('Arial','',10);

$w=180;
$h=6;
$x=17;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$otrosreqv,$border=0,$align='J',$fill=0);

$x1=$x;
$y1=$y+15;
$x2=202;
$y2=$y+15;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+14;
$pdf->SetFont('Arial','B',10);
$pdf->Text($x+3,$y,decod("OBSERVACIONES"));

$pdf->SetFont('Arial','',10);
$w=180;
$h=6;
$x=17;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$observaciones,$border=0,$align='J',$fill=0);

$y+=$espacio+14;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Cordialmente,"));

$x1=$x;
$y1=$y+13;
$x2=70;
$y2=$y+13;
$pdf->Line($x1,$y1,$x2,$y2);

$y+=$espacio+13;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("Director de Mercadeo y Ventas"));

$x=17;
$w=185;
$h=20;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y+7,$w,$h);//RECTANGULO

$y+=$espacio+7;
$pdf->SetFont('Arial','',10);
$pdf->Text($x+3,$y,decod("FIRMAS DE ENTERADO"));

$sqlserv="SELECT * FROM `servicios` WHERE `servicios`.`idoferta`='$idoferta' ORDER BY `idoferta` DESC";
$resultserv=@mysql_query($sqlserv);
$cont=0;
$lim=@mysql_num_rows($resultserv);
$y=143;

function fdiastrabajo($diastrabajo0){
	switch($diastrabajo0){
		case "1"; $diastrabajo="Lunes a Domingo";break;
		case "2"; $diastrabajo="Sabado y Domingo";break;
		case "3"; $diastrabajo="Lunes a Viernes";break;
		case "5"; $diastrabajo="Lunes a Domingo con refuerzo fin de Semana y Festivo";break;
		case "4"; $diastrabajo="Otro";break;
	}

	return recortarcadena($diastrabajo,16);
}

function fturno($turno0){
	switch($turno0){
		case "1"; $turno="24 Horas";break;
		case "2"; $turno="12 Horas diurnas";break;
		case "3"; $turno="12 Horas mixtas";break;
		case "4"; $turno="8 Horas nocturnas";break;
		case "5"; $turno="8 Horas diurnas";break;
	}

	return recortarcadena($turno,20);
}

while($cont<$lim){
	$y+=$espacio;
	$pdf->SetFont('Arial','',10);
	$pdf->Text($x+8,$y,decod(@mysql_result($resultserv,$cont,"cantidadservicios")));
	$pdf->SetFont('Arial','',8);
	$pdf->Text($x+28,$y,recortarcadena(decod(@mysql_result($resultserv,$cont,"descripcion")),58));
	$pdf->Text($x+106,$y,fdiastrabajo(@mysql_result($resultserv,$cont,"diastrabajo")));
	$pdf->Text($x+133,$y,fturno(@mysql_result($resultserv,$cont,"turno")));
	$pdf->Text($x+162,$y,decod("$ ".number_format(@mysql_result($resultserv,$cont,"valorservicio"))));

	if($y>176){
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
		$pdf->Text(92,30,decod("INSTALACION DE SERVICIO"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text(75,39,decod("CODIGO FT-M01-03"));

		$numpag=$pdf->PageNo();
		$pdf->Text(140,39,decod("Pág. ".$pdf->PageNo()." de ".'{nb}'));

		$pdf->Text(75,44,decod("FECHA EXP.: Septiembre de 2003"));

		$pdf->Text(140,44,decod("REVISION No.: 00"));

		//CUERPO DEL FORMATO
		$x=20;
		$y=52;
		$espacio=6;

		$pdf->Text($x,$y,decod("PARA:                      :"));

		$pdf->Line($x+33,$y+1,$x+180,$y+1);

		$y+=$espacio;
		$pdf->Text($x,$y,decod("DE:                           : DIRECCION DE MERCADEO Y VENTAS"));

		$pdf->Line($x+33,$y+1,$x+180,$y+1);

		$y+=$espacio;

		$pdf->Text($x,$y,decod("CIUDAD Y FECHA:  : $ciudadyfecha"));

		$pdf->Line($x+33,$y+1,$x+180,$y+1);

		$y+=$espacio;

		$pdf->SetFont('Arial','',11);

		$texto=decod("Se informa sobre la instalación de un nuevo servicio con las características expuestas a continuación, con el propósito de que cada uno de los directores realice las actividades necesarias al interior de su departamento para cumplir a tiempo con los requisitos del cliente y del servicio.");
		$w=180;
		$h=6;
		$x=17;
		$pdf->Sety($y);
		$pdf->Setx($x);
		$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

		$y+=$espacio+17;

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

		$x1=$x;
		$y1=$y+15;
		$x2=202;
		$y2=$y+15;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+20;
		$x2=202;
		$y2=$y+20;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+25;
		$x2=202;
		$y2=$y+25;
		$pdf->Line($x1,$y1,$x2,$y2);


		$x1=$x;
		$y1=$y+30;
		$x2=202;
		$y2=$y+30;
		$pdf->Line($x1,$y1,$x2,$y2);


		$x1=$x;
		$y1=$y+35;
		$x2=202;
		$y2=$y+35;
		$pdf->Line($x1,$y1,$x2,$y2);


		$x1=$x;
		$y1=$y+40;
		$x2=202;
		$y2=$y+40;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+125;
		$y1=$y+5;
		$x2=$x+125;
		$y2=$y+25;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x=17;
		$w=185;
		$h=45;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$y+=$espacio-2;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+70,$y,decod("DATOS DEL CLIENTE"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Nombre de la Empresa:   $nombrecliente"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+128,$y,decod("Nit ó CC.:   $nit"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Nombre del contacto:   $contacto"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+128,$y,decod("Cargo:   $cargo"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Dirección oficinas:  $direccion"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+128,$y,decod("Teléfono:   $telefono"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Actividad Economica Empresa:   $actividadeconomica"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+70,$y,decod("DATOS DEL SERVICIO"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Direccion del Servicio:   $direccionservicio"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+128,$y,decod("Teléfono:   $telefonoservicio"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Fecha de instalación:   $fechainstalacion"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+80,$y,decod("Hora:   $fechainstalacion1"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+128,$y,decod("Lugar:   $lugar"));

		$y+=$espacio-1;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Periodo de Facturación:   $periodofacturacion"));

		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+80,$y,decod("Requisitos para Facturar:  $requisitosfacturacion"));

		$y+=$espacio-3;
		$x=17;
		$w=185;
		$h=80;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);//RECTANGULO

		$y+=$espacio-2;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+3,$y,decod("CANTIDAD"));

		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+38,$y,decod("DESCRIPCION DEL SERVICIO"));

		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+115,$y,decod("DIAS"));

		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+139,$y,decod("HORARIO"));

		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+165,$y,decod("VALOR"));

		$x1=$x+25;
		$y1=$y-4;
		$x2=$x+25;
		$y2=$y+36;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+105;
		$y1=$y-4;
		$x2=$x+105;
		$y2=$y+36;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+132;
		$y1=$y-4;
		$x2=$x+132;
		$y2=$y+36;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x+160;
		$y1=$y-4;
		$x2=$x+160;
		$y2=$y+36;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+1;
		$x2=202;
		$y2=$y+1;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+6;
		$x2=202;
		$y2=$y+6;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+12;
		$x2=202;
		$y2=$y+12;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+18;
		$x2=202;
		$y2=$y+18;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+24;
		$x2=202;
		$y2=$y+24;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+30;
		$x2=202;
		$y2=$y+30;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=$x;
		$y1=$y+36;
		$x2=202;
		$y2=$y+36;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+35;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+3,$y,decod("REQUERIMIENTOS ESPECIALES"));

		$pdf->SetFont('Arial','',10);

		$w=180;
		$h=6;
		$x=17;
		$pdf->Sety($y);
		$pdf->Setx($x);
		$pdf->MultiCell($w,$h,$otrosreqv,$border=0,$align='J',$fill=0);

		$x1=$x;
		$y1=$y+15;
		$x2=202;
		$y2=$y+15;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+14;
		$pdf->SetFont('Arial','B',10);
		$pdf->Text($x+3,$y,decod("OBSERVACIONES"));

		$pdf->SetFont('Arial','',10);
		$w=180;
		$h=6;
		$x=17;
		$pdf->Sety($y);
		$pdf->Setx($x);
		$pdf->MultiCell($w,$h,$observaciones,$border=0,$align='J',$fill=0);

		$y+=$espacio+14;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Cordialmente,"));

		$x1=$x;
		$y1=$y+13;
		$x2=70;
		$y2=$y+13;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y+=$espacio+13;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("Director de Mercadeo y Ventas"));

		$x=17;
		$w=185;
		$h=20;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y+7,$w,$h);//RECTANGULO

		$y+=$espacio+7;
		$pdf->SetFont('Arial','',10);
		$pdf->Text($x+3,$y,decod("FIRMAS DE ENTERADO"));

		$y=143;
	}


	$cont++;
}

$pdf->Output();
?>