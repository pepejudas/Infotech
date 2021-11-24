<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1007);

	if($_SESSION[ofertamod]==""){
	$sql122="SELECT * FROM necesidadescliente ORDER BY numerooferta DESC";
	$cons=@mysql_query($sql122);
	$_SESSION[ofertamod]=@mysql_result($cons,0,"numerooferta");
	}

$sql1="SELECT * FROM necesidadescliente WHERE `necesidadescliente`.`numerooferta`=$_SESSION[ofertamod]";
$vectordatos=@mysql_query($sql1);
$fechasolicitud=@mysql_result($vectordatos,0,"fechasolicitud");
$fechasol=obtenerfecha($fechasolicitud);
$empresa=decod(@mysql_result($vectordatos,0,"empresa"));
$contacto=decod(@mysql_result($vectordatos,0,"contacto"));
$telefono=@mysql_result($vectordatos,0,"telefono");
$direccion=decod(@mysql_result($vectordatos,0,"direccion"));
$fax=@mysql_result($vectordatos,0,"fax");
$tipocontacto=@mysql_result($vectordatos,0,"tipocontacto");
$puestos1=@mysql_result($vectordatos,0,"puestos1");
$puestos2=@mysql_result($vectordatos,0,"puestos2");
$personalreq=@mysql_result($vectordatos,0,"personalreq");
$personalreq2=@mysql_result($vectordatos,0,"personalreq2");
$turno=@mysql_result($vectordatos,0,"turno");
$turno2=@mysql_result($vectordatos,0,"turno2");
$diastrabajo=@mysql_result($vectordatos,0,"diastrabajo");
$valor=@mysql_result($vectordatos,0,"valor");
$valor2=@mysql_result($vectordatos,0,"valor2");
$modalidadservicio=@mysql_result($vectordatos,0,"modalidadservicio");
$tipoarma=@mysql_result($vectordatos,0,"tipoarma");
$cantarma=@mysql_result($vectordatos,0,"cantarma");
$rb=@mysql_result($vectordatos,0,"rb");
$rpp=@mysql_result($vectordatos,0,"rpp");
$cv=@mysql_result($vectordatos,0,"cv");
$m=@mysql_result($vectordatos,0,"m");
$eg=@mysql_result($vectordatos,0,"eg");
$adm=@mysql_result($vectordatos,0,"adm");
$g=@mysql_result($vectordatos,0,"g");
$sm=@mysql_result($vectordatos,0,"sm");
$ac=@mysql_result($vectordatos,0,"ac");
$rm=@mysql_result($vectordatos,0,"rm");
$omt=@mysql_result($vectordatos,0,"omt");
$es1=@mysql_result($vectordatos,0,"es");
$cp=@mysql_result($vectordatos,0,"cp");
$oreq=@mysql_result($vectordatos,0,"oreq");
$bm=@mysql_result($vectordatos,0,"bm");
$bic=@mysql_result($vectordatos,0,"bic");
$bin=@mysql_result($vectordatos,0,"bin");
$otrosreqv=decod(@mysql_result($vectordatos,0,"otrosreqv"));
$fechaentrega=@mysql_result($vectordatos,0,"fechaentrega");
$feen=obtenerfecha($fechaentrega);
$numerooferta=@mysql_result($vectordatos,0,"numerooferta");

switch(@mysql_result($result,0,cargo)):
			
			case 1: $cargo="DIRECTIVO"; $oper=1;break;
	 		case 3: $cargo="DIRECTOR DE OPERACIONES"; $oper=1; break;
	 		case 4: $cargo="ENTRENADOR CANINO"; $oper=2; break;
	 		case 5: $cargo="ESCOLTA"; $oper=2; break;
	 		case 6: $cargo="GUIA CANINO"; $oper=2; break;
	 		case 7: $cargo="MANEJADOR CANINO"; $oper=2; break;
	 		case 8: $cargo="REPRESENTANTE LEGAL"; $oper=1; break;
	 		case 9: $cargo="SUPERVISOR"; $oper=2; break;
	 		case 10: $cargo="SUPERVISOR MEDIO TECNOLOGICO"; $oper=2; break;
	 		case 11: $cargo="TECNICO MEDIO TECNOLOGICO"; $oper=2; break;
	 		case 12: $cargo="GUARDA"; $oper=2; break;
	 		case 13: $cargo="OPERADOR MEDIO TECNOLOGICO"; $oper=2; break;
	 		case 14: $cargo="TRIPULANTE"; $oper=2; break;
	 		
endswitch;

function verifica($campo){
$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$_SESSION[cedulamod]";
$result=mysql_query($sql1);
if(@mysql_result($result,0,$campo)==1){
$sizas="X";	
}else{$sizas="";}	
return $sizas;	
}

require('fpdf/fpdf.php');
$pdf=new FPDF('P','mm', 'a4');
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
$x1=170;
$y1=45;
$x2=170;
$y2=55;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$x2=190;
$y1=32;
$y2=32;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="NECESIDADES Y REQUERIMIENTOS DEL CLIENTE";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=176;
$h=6;
$y=36;
$x=17;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','B',10);
$pdf->Text(157,30,"Procedimiento");
$pdf->Text(152,37,decod("Código:"));
$pdf->Text(158,42,"F-P-LIC-01-01");
$pdf->SetFont('Arial','B',7);
$pdf->Text(152,51,decod("Revisión:01"));
$pdf->Text(172,51,"Pagina 1 de 1");


$es=60;
$iniy=3.3;





$texto="FECHA DE SOLICITUD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$es;
$pdf->Text($x,$y,$texto);

$texto="DIA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=60;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+14,$y);

$texto="MES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=78;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+14,$y);

$texto=decod("AÑO");
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=95;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+14,$y);


$texto="INFORMACION DE QUIEN SOLICITA EL SERVICIO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=176;
$h=6;
$x=23;
$y=$iniy+$es+5;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$texto="EMPRESA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+4;
$pdf->Text($x,$y+1,$texto);

$x=45;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+140,$y+2);

$texto="CONTACTO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="TEL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=120;
$pdf->Text($x,$y+1,$texto);

$x=45;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+70,$y+2);

$x=130;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+55,$y+2);

$texto="DIRECCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="FAX";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=120;
$pdf->Text($x,$y+1,$texto);

$x=45;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+70,$y+2);

$x=130;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+55,$y+2);

$texto="Contacto";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+5;
$pdf->Text($x,$y+1,$texto);

$texto="Telefonico";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=70;
$pdf->Text($x,$y,$texto);

$x=85;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$texto="Referido";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=110;
$pdf->Text($x,$y,$texto);

$x=125;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$texto="Comercial";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y,$texto);

$x=165;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$texto="DESCRIPCION DEL SERVICIO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=150;
$h=4;
$x=30;
$y=$iniy+$y+5;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$texto="";
$w=150;
$h=50;
$x=30;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);


$texto="No";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=32;
$y=$iniy+$y+5;
$pdf->Text($x,$y+1,$texto);

$texto="Cantidad de";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=38.3;
//$y=$iniy+$y+5;
$pdf->Text($x,$y-2,$texto);

$texto="puestos";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=39.5;
//$y=$iniy+$y+5;
$pdf->Text($x,$y,$texto);

$texto="Modalidad del servicio";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=59;
//$y=$iniy+$y+5;
$pdf->Text($x,$y,$texto);

$texto="Personal";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=89;
//$y=$iniy+$y+5;
$pdf->Text($x,$y,$texto);

$texto="Horas al Dia";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=100;
//$y=$iniy+$y+5;
$pdf->Text($x,$y,$texto);

$texto="Dias de trabajo";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=133;
//$y=$iniy+$y+5;
$pdf->Text($x,$y,$texto);

$texto="Valor";
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=165;
//$y=$iniy+$y+5;
$pdf->Text($x,$y,$texto);

$x=30;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+150,$y+2);

$x=36;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y-4.3,$x,$y+41.7);

$x=52;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y-4.3,$x,$y+41.7);

$x=87;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y-4.3,$x,$y+41.7);

$x=99;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y-4.3,$x,$y+41.7);

$x=122;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y-4.3,$x,$y+41.7);

$x=156;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y-4.3,$x,$y+41.7);

$y=$iniy+$y+4.5;
$x=30;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+150,$y+2);

$y=$iniy+$y+4.5;
$x=30;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+150,$y+2);

$y=$iniy+$y+4.5;
$x=30;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+150,$y+2);

$y=$iniy+$y+4.5;
$x=30;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+150,$y+2);


$texto="2. ARMAMENTO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+12;
$pdf->Text($x,$y+1,$texto);

$texto="Tipo de arma";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=45;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+40,$y+2);

$texto="Cantidad";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=90;
$pdf->Text($x,$y+1,$texto);

$x=107;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+15,$y+2);

$texto="3. MEDIOS DE COMUNICACION Y TECNOLOGIA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$y=$iniy+$y+5;
$x=35;
$pdf->Text($x,$y+4,$texto);

$texto="4. REQUERIMIENTOS VARIOS";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=120;
$pdf->Text($x,$y+4,$texto);

$x=107;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y,$x,$y+54);

$texto="";
$w=150;
$h=4;
$x=30;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=0,$align='L',$fill=0);

$texto="";
$w=150;
$h=54;
$x=30;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$texto="DESCRIPCION";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$y=$iniy+$y+5;
$x=38;
$pdf->Text($x,$y+4,$texto);

$texto="CANT";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=95;
$pdf->Text($x,$y+4,$texto);

$texto="DESCRIPCION";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$texto="CANT";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=168;
$pdf->Text($x,$y+4,$texto);

$texto="a.  Radio Base";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="a.  Estudio de seguridad";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=168;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="b.  Radios punto a punto";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="b.  Coordinador de puesto";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=168;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="c.  Camaras de video";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="c.  Bastones de mando";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=168;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="d.  Monitores";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="d.  Bicicletas";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=168;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="e.  Equipo de grabacion";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="e.  Binoculares";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=168;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="f.   Arco detector de metales";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="f.  Otros";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=168;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="g.  Garret";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="    Cuales";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y+4,$texto);

$x=126;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+50,$y+4.2);

$texto="h.  Sensor de movimiento";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="i.   Alarma comunitaria";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="j.   Reloj de marcacion";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="k.  Otro medio tecnologico";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=38;
$pdf->Text($x,$y+4,$texto);

$x=95;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+8,$y+4.2);

$texto="FECHA DE ENTREGA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+10;
$pdf->Text($x,$y,$texto);

$texto="DIA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=60;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+14,$y);

$texto="MES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=78;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+14,$y);

$texto=decod("AÑO");
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=95;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+14,$y);

$texto="No OFERTA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=125;
$pdf->Text($x,$y,$texto);

$x=150;
$w=30;
$h=5;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="Vo Bo GERENCIA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=30;
$y=$iniy+$y+5;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+40,$y+2);

$texto="";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=170;
$h=4;
$x=20;
$y=$iniy+$y+5;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$texto="";
$w=170;
$h=8;
$x=20;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='L',$fill=0);

$texto="NOMBRE DEL FUNCIONARIO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=65;
$y=$iniy+$y-1;
$pdf->Text($x,$y+1,$texto);

$texto="CARGO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y+1,$texto);

$texto="ELABORADO POR";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+0.7;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.3);
$pdf->Line($x,$y-6,$x,$y+1.7);

$x=125;
$pdf->SetLineWidth(0.3);
$pdf->Line($x,$y-6,$x,$y+1.7);

$x=25;
$y=$iniy+$y;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+10,$x+34,$y+10);

$texto="1. Fija/ Movil - Con / Sin Armas";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y+5;
$x=25;
$pdf->Text($x,$y+4,$texto);

$texto="2. 24 Horas- 12 Horas  Diurnas/ Nocturnas - 8 Horas Diurnas / Nocturnas";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=25;
$pdf->Text($x,$y+4,$texto);

$texto="3. Todos los dias de la semana (TS) -Lunes a Viernes (LV) - Fines de semana (FS)";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$y=$iniy+$y;
$x=25;
$pdf->Text($x,$y+4,$texto);

$es=58;
$iniy=3.3;

$texto=$fechasol[ano];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$es;
$x=103;
$pdf->Text($x,$y+1,$texto);

$texto=$fechasol[mes];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=87;
$pdf->Text($x,$y+1,$texto);

$texto=$fechasol[dia];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=69;
$pdf->Text($x,$y+1,$texto);

$texto=$empresa;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+11;
$x=45;
$pdf->Text($x,$y+1,$texto);

$texto=$contacto;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+2;
$x=45;
$pdf->Text($x,$y+1,$texto);

$texto=$telefono;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=130;
$pdf->Text($x,$y+1,$texto);

$texto=$direccion;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+2;
$x=45;
$pdf->Text($x,$y+1,$texto);

$texto=$fax;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=130;
$pdf->Text($x,$y+1,$texto);

switch($tipocontacto){
case 1:
$x=85;
break;
case 2:
$x=125;
break;	
case 3:
$x=165;
break;	
default;
$x=85;	
}

$texto="X";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$y=$iniy+$y+4;
$pdf->Text($x,$y+1,$texto);

$texto="1";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=32;	
$y=$iniy+$y+21;
$pdf->Text($x,$y+1,$texto);

$texto=$puestos1;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=42;	
$pdf->Text($x,$y+1,$texto);

switch($modalidadservicio){
case 1:
$texto="Fijo sin Armas";
break;
case 2:
$texto="Fijo con Arma Letal";
break;	
case 3:
$texto="Movil con Arma Letal";
break;	
case 4:
$texto="Movil sin Arma";
break;
case 5:
$texto="Fijo con Arma no Letal";
break;
case 6:
$texto="Movil con Arma no Letal";
break;			
default;
$texto="Fijo sin Armas";	
}

$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=55;	
$pdf->Text($x,$y+1,$texto);

$texto=$personalreq;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=92;	
$pdf->Text($x,$y+1,$texto);

switch($turno){
case 1:
$texto="24 Horas";
break;
case 2:
$texto="12 Horas Diurnas";
break;	
case 3:
$texto="12 Horas Mixtas";
break;	
case 4:
$texto="8 Horas Diurnas";
break;	
case 5:
$texto="8 Horas Nocturnas";
break;	
default;
$texto="12 Horas Diurnas";	
}

$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=99.5;	
$pdf->Text($x,$y+1,$texto);

switch($diastrabajo){
case 1:
$texto="Toda la Semana";
$tama="6";
break;
case 2:
$texto="Fines de Semana";
$tama="6";
break;	
case 3:
$texto="Lunes  a Viernes";
$tama="6";
break;	
case 5:
$texto="Lunes a Domingo con refuerzos";
$teto="Fines de semana y Festivos";
$tama="5";
break;
case 4:
$texto="Otro";
$tama="6";
break;	
default;
$texto="Toda la Semana";	
}

$pdf->SetFont('Arial','',$tama);   
$pdf->Ln();
$x=123;	
$pdf->Text($x,$y-1,$texto);

$pdf->SetFont('Arial','',$tama);   
$pdf->Ln();
$x=123;	
$pdf->Text($x,$y+2,$teto);

$texto="$ ".number_format($valor);
;$pdf->SetFont('Arial','',9);   
$pdf->Ln();
$x=159;	
$pdf->Text($x,$y+1,$texto);

if($puestos2!=0 and $puestos2!=""){
$texto="2";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=32;	
$y=$iniy+$y+4;
$pdf->Text($x,$y+1,$texto);

$texto=$puestos2;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=42;	
$pdf->Text($x,$y+1,$texto);

switch($modalidadservicio){
case 1:
$texto="Fijo sin Armas";
break;
case 2:
$texto="Fijo con Arma Letal";
break;	
case 3:
$texto="Movil con Arma Letal";
break;	
case 4:
$texto="Movil sin Arma";
break;
case 5:
$texto="Fijo con Arma no Letal";
break;
case 6:
$texto="Movil con Arma no Letal";
break;			
default;
$texto="Fijo sin Armas";	
}

$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=55;	
$pdf->Text($x,$y+1,$texto);

$texto=$personalreq2;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=92;	
$pdf->Text($x,$y+1,$texto);

switch($turno){
case 1:
$texto="24 Horas";
break;
case 2:
$texto="12 Horas Diurnas";
break;	
case 3:
$texto="12 Horas Mixtas";
break;	
case 4:
$texto="8 Horas Diurnas";
break;	
case 5:
$texto="8 Horas Nocturnas";
break;	
default;
$texto="12 Horas Diurnas";	
}

$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=99.5;	
$pdf->Text($x,$y+1,$texto);

switch($diastrabajo){
case 1:
$texto="Toda la Semana";
$tama="6";
break;
case 2:
$texto="Fines de Semana";
$tama="6";
break;	
case 3:
$texto="Lunes  a Viernes";
$tama="6";
break;	
case 5:
$texto="Lunes a Domingo con refuerzos";
$teto="Fines de semana y Festivos";
$tama="5";
break;
case 4:
$texto="Otro";
$tama="6";
break;	
default;
$texto="Toda la Semana";	
}

$pdf->SetFont('Arial','',$tama);   
$pdf->Ln();
$x=123;	
$pdf->Text($x,$y-1,$texto);

$pdf->SetFont('Arial','',$tama);   
$pdf->Ln();
$x=123;	
$pdf->Text($x,$y+2,$teto);

$texto="$ ".number_format($valor2);
;$pdf->SetFont('Arial','',9);   
$pdf->Ln();
$x=159;	
$pdf->Text($x,$y+1,$texto);
}else{$y=$iniy+$y+4;}

switch($tipoarma){
case 1:
$texto="Revolver";
break;
case 2:
$texto="Pistola";
break;	
case 3:
$texto="Escopeta";
break;	
case 4:
$texto="Fusil";
break;	
case 5:
$texto="Ametralladora";
break;	
case 6:
$texto="Miniuzi";
break;	
case 7:
$texto="No Letal";
break;	
default;
$texto="";	
}

$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=45;
$y=$iniy+$y+35;	
$pdf->Text($x,$y+1,$texto);

$texto=$cantarma;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=113;
$pdf->Text($x,$y+1,$texto);

$texto=$cantarma;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=113;
$pdf->Text($x,$y+1,$texto);

$texto=$rb;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y+23;	
$pdf->Text($x,$y+1,$texto);

$texto=$rpp;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$cv;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$m;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$eg;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$adm;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$g;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$sm;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$ac;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$rm;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

if($omt==1){$texto="Si";}else{$texto="No";}
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);


if($es1==1){$texto="Si";}else{$texto="No";}
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=170;
$y=$iniy+$y-36;	
$pdf->Text($x,$y+1,$texto);

$texto=$cp;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=170;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$bm;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=170;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$bic;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=170;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

$texto=$bin;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=170;
$y=$iniy+$y;	
$pdf->Text($x,$y+1,$texto);

if($oreq==1){$texto="Si";$y=$iniy+$y;}else{
$y=$iniy+$y;		
$texto="No";}
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=170;
$pdf->Text($x,$y+1,$texto);


$texto=$otrosreqv;
$pdf->SetFont('Arial','',5);   
$pdf->Ln();
$w=50;
$h=5;
$x=126;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

$texto=$feen[ano];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+22;
$x=103;
$pdf->Text($x,$y+1,$texto);

$texto=$feen[mes];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=87;
$pdf->Text($x,$y+1,$texto);

$texto=$feen[dia];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=69;
$pdf->Text($x,$y+1,$texto);

$texto=$numerooferta;
$pdf->SetFont('Arial','b',10);   
$pdf->Ln();
$x=160;
$pdf->Text($x,$y+1.5,$texto);

$pdf->Output();
?>

