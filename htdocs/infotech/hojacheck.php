<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1011);
	
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	

$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$_SESSION[cedulamod]";
$sql2="SELECT * FROM parametros";
$sql29="SELECT * FROM seguridadsuper";
$consseg=mysql_query($sql29);
$contr=mysql_query($sql2);
$direccions=decod(@mysql_result($consseg,0,direccion)." BARRIO ".@mysql_result($consseg,0,barrio));
$tel=@mysql_result($consseg,0,telefono1)." /".@mysql_result($consseg,0,telefono2)." Fax: ".@mysql_result($consseg,0,telefono3);
$result=mysql_query($sql1);
$nombre=decod(@mysql_result($result,0,nombre));
$estadocivil=@mysql_result($result,0,estadocivil);
$apellido=decod(@mysql_result($result,0,apellidos));
$cedula=@mysql_result($result,0,cedula);
$expedida=decod(@mysql_result($result,0,expedida));
$barrio=decod(@mysql_result($result,0,barrio));
$telefono=@mysql_result($result,0,telefono);
$fechaingreso=@mysql_result($result,0,fechaingreso);
$celular=@mysql_result($result,0,celular);
$direccion=decod(@mysql_result($result,0,direccion));
$fincontrato=@mysql_result($result,0,fincontrato);
$placa=@mysql_result($result,0,placa);
$rh=@mysql_result($result,0,rh);
$fechanacimiento=@mysql_result($result,0,fechanacimiento);
$ciudad=decod(@mysql_result($consseg,0,ciudad));

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
$pdf=new FPDF();
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
$x1=60;
$y1=45;
$x2=190;
$y2=45;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=150;
$x2=190;
$y1=35;
$y2=35;
$pdf->Line($x1,$y1,$x2,$y2);
$x1=20;
$x2=190;
$y1=270;
$y2=270;
$pdf->Line($x1,$y1,$x2,$y2);

$texto="         		HOJA DE CHEQUEO
		   ";

$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=30;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$pdf->SetFont('Arial','B',10);
$pdf->Text(152,30,"FECHA APROBACION");
$pdf->Text(152,33,"17/03/2006");
$pdf->Text(152,41,"CODIGO: F-RH-000");
$pdf->Text(152,51,"VERSION:01");
$y=46;
$pdf->Sety($y);
$pdf->SetFont('Arial','B',10);
$w=182;
$h=6;
$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
$x=20;
$y=25;
$w=170;
$h=260;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$es=60;
$iniy=3.3;





$texto="CARGO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$es;
$pdf->Text($x,$y,$texto);

$pdf->SetLineWidth(0.1);
$pdf->Line($x+15,$y,$x+70,$y);

$texto="Administrativo";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y,$texto);

$x=125;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$texto="Operativo";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=135;
$pdf->Text($x,$y,$texto);

$x=155;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);


$texto="LUGAR DE TRABAJO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="APELLIDOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="NOMBRES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="IDENTIFICACION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="DE";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.3);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="FECHA DE NACIMIENTO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="EDAD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="DIRECCION RESIDENCIA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="TELEFONOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="ESTADO CIVIL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="Casado";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=70;
$pdf->Text($x,$y,$texto);

$x=85;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$texto="Soltero";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=110;
$pdf->Text($x,$y,$texto);

$x=125;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$texto="Union libre";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y,$texto);

$x=165;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-2,$w,$h);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="GRUPO SANGUINEO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="FACTOR RH";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.3);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="FECHA INICIACION DEL CONTRATO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="FECHA TERMINACION DEL CONTRATO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="FECHA DE RETIRO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+1,$texto);

$texto="PLACA No";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=100;
$pdf->Text($x,$y+1,$texto);

$x=20;
$pdf->SetLineWidth(0.1);
$pdf->Line($x,$y+2,$x+170,$y+2);

$texto="INSTRUCCIONES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+5,$texto);

$texto="Diligencie total y claramente los espacios del encabezado, teniendo en cuenta que la direccion y el telefono debe escribirse a lapiz. Marque con una X en cada cuadro, en la medida en que se va agotando cada etapa del proceso. Firmar el documento diligenciado en el espacio.";
$y=$iniy+$y+4;
$pdf->Sety($y);
$x=24;
$pdf->Setx($x);
$pdf->SetFont('Arial','',9);
$w=160;
$h=6;
$pdf->MultiCell($w,$h,$texto,$border=0,$align='J',$fill=0);

$texto="ETAPA DEL PROCESO";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+18;
$pdf->Text($x,$y+5,$texto);

$texto="CUMPLIDA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$pdf->Text($x,$y+5,$texto);

$texto="DOCUMENTOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+2;
$pdf->Text($x,$y+5,$texto);

$texto="Hoja de vida";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y+7;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Fotocopia Cedula de ciudadania";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Fotocopia Libreta Militar";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Fotocopia Certificado Judicial";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Fotocopia Certificados Academicos";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Fotocopia Recibo de Agua";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Recomendaciones Personales";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Certificado de Residencia (J.A.C.)";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="VERIFICACION DE DATOS DE IDENTIFICACION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="ENTREVISTA Y PRUEBA TECNICA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="ENTREVISTA Y PRUEBA PSICOLOGICA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="CELEBRACION DEL CONTRATO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="AFILIACIONES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$texto="A.R.P.";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="E.P.S";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Pensiones";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="Caja de Compesacion Familiar";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=28;
$y=$iniy+$y;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="CARNETIZACION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="EXAMEN MEDICO OCUPACIONAL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="INDUCCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="VISITA DOMICILIARIA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y+3;
$pdf->Text($x,$y+1,$texto);

$x=120;
$w=2;
$h=2;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y,$w,$h);

$texto="FIRMA EMPLEADOR";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=90;
$y=$iniy+$y+20;
$pdf->Text($x,$y+1,$texto);

$texto=$cargo;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=40;
$y=62;
$pdf->Text($x,$y+1,$texto);

if($oper==1){$texto=X;}else{$texto="";}
$pdf->SetFont('Arial','B',10);   
$y=63;
$x=125;
$pdf->Text($x,$y,$texto);

if($oper==2){$texto=X;}else{$texto="";}
$pdf->SetFont('Arial','B',10);   
$y=63;
$x=155;
$pdf->Text($x,$y,$texto);

$texto=$apellido;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=42;
$y=72;
$pdf->Text($x,$y+1,$texto);

$texto=$nombre;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=125;
$y=72;
$pdf->Text($x,$y+1,$texto);

$texto=$cedula;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=52;
$y=77;
$pdf->Text($x,$y+1,$texto);

$texto=$expedida;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=125;
$y=77;
$pdf->Text($x,$y+1,$texto);

$texto=$fechanacimiento;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=65;
$y=83;
$pdf->Text($x,$y+1,$texto);


$texto=$direccion." ".$barrio;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=65;
$y=88;
$pdf->Text($x,$y+1,$texto);

$texto=$telefono." ".$celular;
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=65;
$y=93;
$pdf->Text($x,$y+1,$texto);

switch($estadocivil):
case 1:
$x=125;
$y=97;
break;
case 2:
$x=85;
$y=97;
break;
case 3:
$x=165;
$y=97;
break;
default;
$x=65;
$y=97;
endswitch;

$texto="X";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

switch($rh):
case 1:
$texto="O";
$texto1="+";
break;
case 2:
$texto="O";
$texto1="-";
break;
case 3:
$texto="A";
$texto1="+";
break;
case 4:
$texto="A";
$texto1="-";
break;
case 5:
$texto="B";
$texto1="+";
break;
case 6:
$texto="B";
$texto1="-";
break;
case 7:
$texto="AB";
$texto1="+";
break;
case 8:
$texto="AB";
$texto1="-";
break;
endswitch;


$x=65;
$y=104;
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$x=125;
$y=104;
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto1);

$texto=$fechaingreso;
$x=76;
$y=109;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=$fincontrato;
$x=155;
$y=109;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=$placa;
$x=125;
$y=114;
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);


$texto=verifica('hv');
$x=120;
$y=165;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('fc');
$x=120;
$y=168.5;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('flb');
$x=120;
$y=172;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);	

$texto=verifica('fpj');
$x=120;
$y=175;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);	

$texto=verifica('fca');
$x=120;
$y=178;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);	

$texto=verifica('fra');
$x=120;
$y=181.5;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);	

$texto=verifica('rp');
$x=120;
$y=184.5;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);	

$texto=verifica('cr');
$x=120;
$y=188;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('vid');
$x=120;
$y=194;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);		

$texto=verifica('ept');
$x=120;
$y=200.5;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('epps');
$x=120;
$y=207;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

if($fechaingreso!="" and $fechaingreso!="0000-00-00" and $fechaingreso!="0"){$texto="X";}else{$texto="";}
$x=120;
$y=213;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('epscheck');
$x=120;
$y=226;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('arpcheck');
$x=120;
$y=229;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('afpcheck');
$x=120;
$y=232;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('afpcheck');
$x=120;
$y=232;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('emo');
$x=120;
$y=248;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('ind');
$x=120;
$y=255;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);

$texto=verifica('vd');
$x=120;
$y=261;
$pdf->SetFont('Arial','B',9);   
$pdf->Ln();
$pdf->Text($x,$y+1,$texto);


$pdf->Output();
?>
