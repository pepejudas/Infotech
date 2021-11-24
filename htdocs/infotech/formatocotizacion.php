<?php
/*
 * Created on 7/09/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();
@require('funciones2.php');

if($_SESSION['iuj345iuh']!=1){
	validar($_POST[nombre], $_POST[contra], $_POST[nivel]);	
}
conectar2($_SESSION['usua']);

	if ($_SESSION['usua']=="vigilantes"){
		echo "<br>\n<h2>No tiene permiso para acceder a esta informacion</h2>";
		echo "<h3><div align=left><A HREF=\"inicio.php\">Inicio</A></div><h3>";
		echo "<h3><div align=left><A HREF=\"index.php\">Salir</A></div><h3>";
	exit();
	}
	if($_SESSION[cedulamod]==""){
	$sql122="SELECT * FROM condicionescliente ORDER BY numerooferta DESC";
	$cons=@mysql_query($sql122);
	$_SESSION[cedulamod]=@mysql_result($cons,0,"numerooferta");
	}
$sql1="SELECT * FROM condicionescliente, clientes, necesidadescliente WHERE `condicionescliente`.`numerooferta`=$_SESSION[cedulamod] AND necesidadescliente.numerooferta=$_SESSION[cedulamod] AND condicionescliente.codigo LIKE clientes.codigo";
$vectordatos=@mysql_query($sql1);
$nombrecliente=decod(@mysql_result($vectordatos,0,"clientes.nombrecliente"));
$codigo=decod(@mysql_result($vectordatos,0,"clientes.codigo"));
$contacto=decod(@mysql_result($vectordatos,0,"condicionescliente.contacto"));
$telefono=@mysql_result($vectordatos,0,"clientes.telefono");
$nit=@mysql_result($vectordatos,0,"clientes.nit");
$direccion=decod(@mysql_result($vectordatos,0,"clientes.direccion"));
$direccion1=decod(@mysql_result($vectordatos,0,"clientes.direccion1"));
$fax=@mysql_result($vectordatos,0,"clientes.fax");
$puestos1=@mysql_result($vectordatos,0,"condicionescliente.puestos1");
$puestos2=@mysql_result($vectordatos,0,"condicionescliente.puestos2");
$personalreq=@mysql_result($vectordatos,0,"condicionescliente.personalreq");
$personalreq2=@mysql_result($vectordatos,0,"condicionescliente.personalreq2");
$turno=@mysql_result($vectordatos,0,"condicionescliente.turno");
$diastrabajo=@mysql_result($vectordatos,0,"condicionescliente.diastrabajo");
$valor=@mysql_result($vectordatos,0,"necesidadescliente.valor");
$valor2=@mysql_result($vectordatos,0,"necesidadescliente.valor2");
$modalidadservicio=@mysql_result($vectordatos,0,"condicionescliente.modalidadservicio");
$tipoarma=@mysql_result($vectordatos,0,"condicionescliente.tipoarma");
$cantarma=@mysql_result($vectordatos,0,"condicionescliente.cantarma");
$rb=@mysql_result($vectordatos,0,"condicionescliente.rb");
$rpp=@mysql_result($vectordatos,0,"condicionescliente.rpp");
$cv=@mysql_result($vectordatos,0,"condicionescliente.cv");
$m=@mysql_result($vectordatos,0,"condicionescliente.m");
$eg=@mysql_result($vectordatos,0,"condicionescliente.eg");
$adm=@mysql_result($vectordatos,0,"condicionescliente.adm");
$g=@mysql_result($vectordatos,0,"condicionescliente.g");
$sm=@mysql_result($vectordatos,0,"condicionescliente.sm");
$ac=@mysql_result($vectordatos,0,"condicionescliente.ac");
$rm=@mysql_result($vectordatos,0,"condicionescliente.rm");
$omt=@mysql_result($vectordatos,0,"condicionescliente.omt");
$es1=@mysql_result($vectordatos,0,"condicionescliente.es");
$cp=@mysql_result($vectordatos,0,"condicionescliente.cp");
$oreq=@mysql_result($vectordatos,0,"condicionescliente.oreq");
$bm=@mysql_result($vectordatos,0,"condicionescliente.bm");
$bic=@mysql_result($vectordatos,0,"condicionescliente.bic");
$bin=@mysql_result($vectordatos,0,"condicionescliente.bin");
$condicionesesp=decod(@mysql_result($vectordatos,0,"condicionescliente.condicionesesp"));
$observacionesnec=decod(@mysql_result($vectordatos,0,"condicionescliente.observacionesnec"));
$fechainstalacion=@mysql_result($vectordatos,0,"clientes.fechainiciocontrato");
$feen=obtenerfecha($fechainstalacion);
$fechafincontrato=@mysql_result($vectordatos,0,"clientes.fechafincontrato");
$fefin=obtenerfecha($fechafincontrato);
$numerooferta=@mysql_result($vectordatos,0,"numerooferta");
$elem1=decod(@mysql_result($vectordatos,0,"condicionescliente.elem1"));
$elem2=decod(@mysql_result($vectordatos,0,"condicionescliente.elem2"));
$elem3=decod(@mysql_result($vectordatos,0,"condicionescliente.elem3"));
$elem4=decod(@mysql_result($vectordatos,0,"condicionescliente.elem4"));
$cant1=decod(@mysql_result($vectordatos,0,"condicionescliente.cant1"));
$cant2=decod(@mysql_result($vectordatos,0,"condicionescliente.cant2"));
$cant3=decod(@mysql_result($vectordatos,0,"condicionescliente.cant3"));
$cant4=decod(@mysql_result($vectordatos,0,"condicionescliente.cant4"));

$sqlpar="SELECT * FROM parametros";
$conspar=@mysql_query($sqlpar);
$iva=@mysql_result($conspar,0,"iva");
$aiu=@mysql_result($conspar,0,"aiu");
$retencion=@mysql_result($conspar,0,"retencion");

/*
echo "<pre>";
print_r(getdate(time()));
echo "</pre>";
*/

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
$pdf=new FPDF('P','mm', 'legal');
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

$texto="CONDICIONES PARA LA INSTALACION Y FACTURACION AL CLIENTE";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$w=76;
$h=6;
$y=36;
$x=67;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','B',10);
$pdf->Text(157,30,"Procedimiento");
$pdf->Text(152,37,decod("Código:"));
$pdf->Text(158,42,"F-P-LIC-01-04");
$pdf->SetFont('Arial','B',7);
$pdf->Text(152,51,decod("Revisión:01"));
$pdf->Text(172,51,"Pagina 1 de 1");


$es=60;
$iniy=3.3;





$texto="FECHA:";
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


$texto="DIRIGIDO A:";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=176;
$h=6;
$x=24;
$y=$iniy+$es+5;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='L',$fill=0);

$texto="DIR OPERACIONES:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+8;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+80,$y+2);

$x=155;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+35,$y+2);

$texto="DIR REC HUMANOS:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+80,$y+2);

$x=155;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+35,$y+2);

$texto="DIR CONTABILIDAD:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+80,$y+2);

$x=155;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+35,$y+2);

$texto="ESPECIFICACIONES DEL PUESTO:";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=176;
$h=6;
$x=24;
$y=$iniy+$y+5;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='L',$fill=0);

$texto="RAZON SOCIAL:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+8;
$pdf->Text($x,$y+1,$texto);

$texto="COD ASIGNADO:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=136;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+80,$y+2);

$x=160;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+30,$y+2);

$texto="DIRECCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$texto="TELEFONO:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=136;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+80,$y+2);

$x=160;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+30,$y+2);

$texto="NIT O C.C.:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$texto="FAX:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=136;
$pdf->Text($x,$y+1,$texto);

$x=55;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+80,$y+2);

$x=160;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+30,$y+2);

$texto="DIRECCION ENVIO FACTURA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$texto="CONTACTO:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=136;
$pdf->Text($x,$y+1,$texto);

$x=65;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+70,$y+2);

$x=160;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+30,$y+2);

$texto="FECHA DE INSTALACION:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+4;
$pdf->Text($x,$y,$texto);

$texto="HORA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=135;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+10,$y,$x+18,$y);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+20,$y,$x+28,$y);

$texto="DIA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=62;
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

$texto="VALOR A FACTURAR:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y,$texto);

$texto="TOTAL:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=148;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+10,$y,$x+42,$y);

$texto="NETO:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=60;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+9,$y,$x+22,$y);

$texto="A.I.U";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=90;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+22,$y);

$texto="I.V.A";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=120;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+22,$y);

$texto="VIGENCIA CONTRATO:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y,$texto);

$texto="DIA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=62;
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

$texto="CONDICIONES ESPECIALES:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y,$texto);

$x=60;
$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+130,$y);

$x=17;
$y=$iniy+$y+3;
$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+173,$y);

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

$texto="3. MEDIOS DE COMUNICACION Y TECNOLOGIA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$y=$iniy+$y+8;
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

$texto="4. OTROS ELEMENTOS ADICIONALES PARA LA INSTALACION";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$w=150;
$h=6;
$x=30;
$y=$iniy+$y+4;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='L',$fill=0);

$texto="";
$w=150;
$h=20;
$x=30;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->SetLineWidth(0.3);
$pdf->MultiCell($w,$h,$texto, $border=1,$align='C',$fill=0);

$texto="a.";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=38;
$y=$iniy+$y+4;
$pdf->Text($x,$y+4,$texto);

$x=40;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+28,$y+4.2);

$texto="Cantidad";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=70;
$pdf->Text($x,$y+4,$texto);

$x=80;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+18,$y+4.2);

$texto="b.";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=113;
$pdf->Text($x,$y+4,$texto);

$x=115;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+28,$y+4.2);

$texto="Cantidad";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y+4,$texto);

$x=160;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+18,$y+4.2);

$texto="c.";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=38;
$y=$iniy+$y+2;
$pdf->Text($x,$y+4,$texto);

$x=40;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+28,$y+4.2);

$texto="Cantidad";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=70;
$pdf->Text($x,$y+4,$texto);

$x=80;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+18,$y+4.2);

$texto="d.";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=113;
$pdf->Text($x,$y+4,$texto);

$x=115;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+28,$y+4.2);

$texto="Cantidad";
$pdf->SetFont('Arial','',7);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y+4,$texto);

$x=160;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+4.2,$x+18,$y+4.2);

$texto="OBSERVACIONES:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+13;
$pdf->Text($x,$y,$texto);

$x=60;
$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+130,$y);

$x=17;
$y=$iniy+$y+3;
$pdf->SetLineWidth(0.1);
$pdf->Line($x+8,$y,$x+173,$y);

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

//llenar los campos del formulario

$es=58;
$iniy=3.3;

$fechacond=getdate(time());

$texto=$fechacond[year];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$es;
$x=103;
$pdf->Text($x,$y+1,$texto);

$texto=$fechacond[mon];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=87;
$pdf->Text($x,$y+1,$texto);

$texto=$fechacond[mday];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=69;
$pdf->Text($x,$y+1,$texto);

$sqldirig="SELECT * FROM personalactivo WHERE cargo=3 OR cargo=16 OR cargo=17";
$vectorfunciona=@mysql_query($sqldirig);
$r=0;
$lr=@mysql_num_rows($vectorfunciona);
while($r<$lr){
if(@mysql_result($vectorfunciona,$r,cargo)==3){
$nombredirop=decod(@mysql_result($vectorfunciona,$r,nombre)." ".@mysql_result($vectorfunciona,$r,apellidos));	
}
if(@mysql_result($vectorfunciona,$r,cargo)==16){
$nombredirrec=decod(@mysql_result($vectorfunciona,$r,nombre)." ".@mysql_result($vectorfunciona,$r,apellidos));	
}
if(@mysql_result($vectorfunciona,$r,cargo)==17){
$nombredircon=decod(@mysql_result($vectorfunciona,$r,nombre)." ".@mysql_result($vectorfunciona,$r,apellidos));	
}
$r++;	
}

$texto=$nombredirop;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+15;
$x=55;
$pdf->Text($x,$y+1,$texto);

$texto=$nombredirrec;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=55;
$pdf->Text($x,$y+1,$texto);

$texto=$nombredircon;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=55;
$pdf->Text($x,$y+1,$texto);

$texto=$nombrecliente;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+16;
$x=55;
$pdf->Text($x,$y+1,$texto);

$texto=$codigo;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=160;
$pdf->Text($x,$y+1,$texto);

$texto=$direccion;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=55;
$pdf->Text($x,$y+1,$texto);

$texto=$telefono;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=160;
$pdf->Text($x,$y+1,$texto);

$texto=$nit;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=55;
$pdf->Text($x,$y+1,$texto);

$texto=$fax;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=160;
$pdf->Text($x,$y+1,$texto);

$texto=$direccion1;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=67;
$pdf->Text($x,$y+1,$texto);

$texto=$contacto;
$pdf->SetFont('Arial','',6);   
$pdf->Ln();
$x=160;
$pdf->Text($x,$y+1,$texto);

$texto=$feen[ano];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+2.5;
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
$x=71;
$pdf->Text($x,$y+1,$texto);

$texto=$feen[hora];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=147;
$pdf->Text($x,$y+1,$texto);

$texto=$feen[minuto];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=157;
$pdf->Text($x,$y+1,$texto);

$aiu2=(@mysql_result($vectordatos,0,"clientes.valormensualcontrato")/(1+$aiu))*$aiu;
//$retencion2=(@mysql_result($vectordatos,0,"clientes.valormensualcontrato")/(1+$retencion))*$retencion;
$iva2=(@mysql_result($vectordatos,0,"clientes.valormensualcontrato")/(1+$iva))*$iva;
$numl2=@mysql_result($vectordatos,0,"clientes.valormensualcontrato")-$aiu2-$iva2;
$numl3=@mysql_result($vectordatos,0,"clientes.valormensualcontrato");

$texto='$ '.number_format($aiu2);
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+2.5;
$x=98;
$pdf->Text($x,$y+1,$texto);

$texto='$ '.number_format($iva2);
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=128;
$pdf->Text($x,$y+1,$texto);

$texto='$ '.number_format($numl2);
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=69;
$pdf->Text($x,$y+1,$texto);

$texto='$ '.number_format($numl3);
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y+1,$texto);

$texto=$fefin[ano];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$y=$iniy+$y+3;
$x=103;
$pdf->Text($x,$y+1,$texto);

$texto=$fefin[mes];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=87;
$pdf->Text($x,$y+1,$texto);

$texto=$fefin[dia];
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=71;
$pdf->Text($x,$y+1,$texto);

$texto=$condicionesesp;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$w=124;
$h=6;
$x=67;
$y=$iniy+$y+1;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

$texto="1";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=32;	
$y=$iniy+$y+30;
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
$x=125;	
$pdf->Text($x,$y+1,$texto);

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

$pdf->SetFont('Arial','',10);   
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

$pdf->SetFont('Arial','',$tama);   
$pdf->Ln();
$x=125;	
$pdf->Text($x,$y+1,$texto);

$pdf->SetFont('Arial','',$tama);   
$pdf->Ln();
$x=123;	
$pdf->Text($x,$y+2,$teto);

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
$x=125;	
$pdf->Text($x,$y+1,$texto);

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
$texto="Sin Armas";	
}

$texto=$rb;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=97;
$y=$iniy+$y+43;	
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

$texto=$elem1;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=40;
$y=$iniy+$y+27;	
$pdf->Text($x,$y+1,$texto);

$texto=$elem2;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=116;
$pdf->Text($x,$y+1,$texto);

$texto=$cant1;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=90;
$pdf->Text($x,$y+1,$texto);

$texto=$cant2;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y+1,$texto);

$texto=$elem3;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=40;
$y=$iniy+$y+2;	
$pdf->Text($x,$y+1,$texto);

$texto=$elem4;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=116;
$pdf->Text($x,$y+1,$texto);

$texto=$cant3;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=90;
$pdf->Text($x,$y+1,$texto);

$texto=$cant4;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y+1,$texto);

$texto=$observacionesnec;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$w=124;
$h=6;
$x=67;
$y=$iniy+$y+6;	
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

$pdf->Output();
?>















