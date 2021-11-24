<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 59);
	
require('fpdf/fpdf.php');
$pdf=new FPDF('p','mm','legal');
$pdf->AddPage();

$es=5;
$iniy=5.8;

$texto="SUPERINTENDENCIA DE VIGILANCIA Y SEGURIDAD PRIVADA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=65;
$y=$iniy+$es;
$pdf->Text($x,$y,$texto);

$texto="CUADRO GENERAL DE REPORTE MENSUAL DE NOVEDADES DE LOS SERVICIOS DE VIGILANCIA Y SEGURIDAD PRIVADA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="FECHA DE CORTE                                                                                    DD/MM/AAAA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=20;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=130;
$w=35;
$h=5;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-4,$w,$h);

$texto="SEDE PRINCIPAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=50;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=10;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="AGENCIA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=105;
$pdf->Text($x,$y,$texto);

$x=120;
$w=10;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="SUCURSAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=145;
$pdf->Text($x,$y,$texto);

$x=162;
$w=10;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="NIT";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=50;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="RAZON SOCIAL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=130;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="DIRECCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=130;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="DEPARTAMENTO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=60;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="MUNICIPIO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=125;
$pdf->Text($x,$y,$texto);

$x=147;
$w=45;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="TELEFONOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=60;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EMAIL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=125;
$pdf->Text($x,$y,$texto);

$x=147;
$w=45;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="GREMIO O ASOCIACION AL CUAL ESTA AFILIADO";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=112;
$w=80;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="NOMBRE REPRES LEGAL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=130;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="CEDULA REPRES LEGAL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=60;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="DE";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=125;
$pdf->Text($x,$y,$texto);

$x=147;
$w=45;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="POLIZA DE RESPONSABILIDAD CIVIL EXTRACONTRACTUAL";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="ASEGURADORA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=62;
$w=130;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="NUM POLIZA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=43;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="VALOR ASEGURADO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=75;
$pdf->Text($x,$y,$texto);

$x=105;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA EXPED";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=140;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="MODALIDAD DE VIGILANCIA:";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="FIJA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=55;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=75;
$pdf->Text($x,$y,$texto);

$x=110;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=145;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="MOVIL:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=55;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=75;
$pdf->Text($x,$y,$texto);

$x=110;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=145;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="ESCOLTA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=55;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=75;
$pdf->Text($x,$y,$texto);

$x=110;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=145;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="TIPO DE SERVICIO:";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="EMPRESA DE VIGILANCIA PRIVADA:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EMPRESA DE VIGILANCIA SIN ARMAS:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="DEPARTAMENTO DE SEGURIDAD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="COOPERATIVA DE VIGILANCIA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="INCRIP REG EQUIPOS TECNOLOGICOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);


$texto="ESCUELA DE CAPACITACION ";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="TRANSPORTADORA DE VALORES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EMPRESA ASESORA EN SEGURIDAD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="ASESOR EN SEGURIDAD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="CONSULTOR EN SEGURIDAD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="INVESTIGADOR EN SEGURIDAD";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="SERVICIO COMUNITARIO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EMPRESA BLINDADORA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="NUM RESOLUCION";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=85;
$pdf->Text($x,$y,$texto);

$x=115;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="FECHA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=149;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="NUMERO DE USUARIOS A LOS QUE SE LES PRESTAN SERVICIOS ACTUALMENTE";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="QUE CUBRIMIENTO APROXIMADO DE PERSONAS SE BENEFICIAN DE LOS SERVICIOS QUE PRESTAN?";
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="INFORMACION DEL PERSONAL (Indicar la cantidad que poseen actualmente)";
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="ADMINISTRATIVOS:";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="GUIAS CANINOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="VIGILANTES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="TECNICOS/INSTRUCTORES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="SUPERVISORES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="TRIPULANTES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="ESCOLTAS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="CONDUCTORES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="INFORMACION SOBRE MEDIOS UTILIZADOS EN LA VIGILANCIA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="ARMAS DE DEFENSA PERSONAL (Cantidad)";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="ARMAS DE USO RESTRINGIDO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$texto="ESCOPETAS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="SUBAMETRALLADORAS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="CARABINAS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="PISTOLAS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=115;
$pdf->Text($x,$y,$texto);

$x=162;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="REVOLVERES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="CANINOS";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=45;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EQUIPOS TECNOLOGICOS PARA VIGILANCIA";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="VENDIDOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=77;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="PARA VENTA";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=106;
$pdf->Text($x,$y,$texto);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EN ARRIENDO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=135;
$pdf->Text($x,$y,$texto);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="PROPIOS";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="CIRCUITOS CERRADOS DE TV";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="EQUIPOS DE MONITOREO";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="ALARMAS PARA INMUEBLES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="RADIOS Y BASES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="RADIOS CON SERVICIO AVANTEL";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="DETECTORES DE METALES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="SIST DE ALARMA CON SENSORES";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$x=75;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=104;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=133;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="OTROS: Especifique brevemente en hoja anexa";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="VEHICULOS CON BLINDAJE";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="AUTOS(Cant)";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=70;
$pdf->Text($x,$y,$texto);

$x=95;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="TRANSVALORES(Cant)";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=127;
$pdf->Text($x,$y,$texto);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="VEHICULOS SIN BLINDAJE";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=25;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto="AUTOS(Cant)";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=70;
$pdf->Text($x,$y,$texto);

$x=95;
$w=30;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

$texto="MOTOCICLETAS(Cant)";
$pdf->SetFont('Arial','',8);   
$pdf->Ln();
$x=127;
$pdf->Text($x,$y,$texto);

$x=162;
$w=27;
$h=4;
$pdf->SetLineWidth(0.3);
$pdf->Rect($x,$y-3,$w,$h);

//REINICIALIZAR LAS VARIABLES DE CONTROL DMENSIONAL PARA EMPEZAR A LLENAR FORMULARIO//////////////////////////////////////////////
$es=5;
$iniy=5.8;

$fecha1=getdate(time());
$fecha2=$fecha1[mday]."-".$fecha1[mon]."-".$fecha1[year];


$sql="SELECT * FROM seguridadsuper WHERE seguridadsuper.sucursal LIKE '$_SESSION[sucur]'";
$cons=@mysql_query($sql);
$sql1="SELECT codigo FROM clientes WHERE clientes.svysp=1";
$cons2=@mysql_query($sql1);
$n=@mysql_num_rows($cons2);
$sql2="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=1 OR personalactivo.cargo=3 OR personalactivo.cargo=8";
$cons3=@mysql_query($sql2);
$admi=@mysql_num_rows($cons3);
$sql3="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=12";
$cons4=@mysql_query($sql3);
$vig=@mysql_num_rows($cons4);
$sql4="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=9";
$cons5=@mysql_query($sql4);
$sup=@mysql_num_rows($cons5);
$sql5="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=5";
$cons6=@mysql_query($sql5);
$esc=@mysql_num_rows($cons6);
$sql6="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=6";
$cons7=@mysql_query($sql6);
$guia=@mysql_num_rows($cons7);
$sql7="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=11";
$cons8=@mysql_query($sql7);
$tec=@mysql_num_rows($cons8);
$sql8="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=14";
$cons9=@mysql_query($sql8);
$tri=@mysql_num_rows($cons9);
$sql9="SELECT cedula FROM personalactivo WHERE personalactivo.cargo=15";
$cons10=@mysql_query($sql9);
$cho=@mysql_num_rows($cons10);
$sql10="SELECT id FROM armas WHERE armas.tipoarma=3";
$cons11=@mysql_query($sql10);
$escop=@mysql_num_rows($cons11);
$sql11="SELECT id FROM armas WHERE armas.tipoarma=1";
$cons12=@mysql_query($sql11);
$rev=@mysql_num_rows($cons12);
$sql12="SELECT id FROM armas WHERE armas.tipoarma=5";
$cons13=@mysql_query($sql12);
$sub=@mysql_num_rows($cons13);
$sql13="SELECT id FROM armas WHERE armas.tipoarma=2";
$cons14=@mysql_query($sql13);
$pis=@mysql_num_rows($cons14);



if(@mysql_result($cons,0,spaos)==1){$spaos=X; $xx=80;}
$nit=@mysql_result($cons,0,nit);
$razon=decod(@mysql_result($cons,0,razonsocial));
$direccion=decod(@mysql_result($cons,0,direccion));
$depto=decod(@mysql_result($cons,0,depto));
$municipio=decod(@mysql_result($cons,0,municipio));
$telefonos=@mysql_result($cons,0,telefono1)." ".@mysql_result($cons,0,telefono2)." ".@mysql_result($cons,0,telefono3)." ".@mysql_result($cons,0,telefono4);
$email=@mysql_result($cons,0,email);
$asoc=decod(@mysql_result($cons,0,asociadoa));
$repres=decod(@mysql_result($cons,0,representantelegal));
$cedrepres=@mysql_result($cons,0,cedularepres);
$expcedrepres=@mysql_result($cons,0,expedicioncedrep);
$aseguradora=decod(@mysql_result($cons,0,aseguradora));
$numpol=@mysql_result($cons,0,numpoliza);
$valorasegurado=@mysql_result($cons,0,valorasegurado);
$fechaex=@mysql_result($cons,0,fechaexpedicion);
$resfija=@mysql_result($cons,0,resfija);
$resmovil=@mysql_result($cons,0,resmovil);
$resescolta=@mysql_result($cons,0,resescolta );
$fechafi=@mysql_result($cons,0,fechafija);
$fechamo=@mysql_result($cons,0,fechamovil);
$fechaes=@mysql_result($cons,0,fechaescolta);
$lic=@mysql_result($cons,0,numerolicencia);
$inilic=@mysql_result($cons,0,fechainiciolic);
$usuar=@mysql_result($cons,0,personasaprox);
$autos=@mysql_result($cons,0,autos);
$camperos=@mysql_result($cons,0,camperos);
$transvalores=@mysql_result($cons,0,transvalores);
$motos=@mysql_result($cons,0,motos);
$id=@mysql_result($cons,0,sucursal);







/////////////////////empieza llenado de formulario//////////////////////////////////////////////////////////////////////////////////////
$texto=$fecha2;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=135;
$y=$iniy+$es;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$spaos;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
if($id==2){
$x=$xx;
}else{
$x=$xx+85;	
}	
$y=$iniy+$y;

	

$pdf->Text($x,$y,$texto);

$texto=$nit;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$razon;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$direccion;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$depto;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$municipio;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y,$texto);

$texto=$telefonos;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$email;
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y,$texto);

$texto=$asoc;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=115;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$repres;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$cedrepres;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$expcedrepres;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=150;
$pdf->Text($x,$y,$texto);

$texto=$aseguradora;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=70;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$numpol;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=47;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$valorasegurado;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=110;
$pdf->Text($x,$y,$texto);

$texto=$fechaex;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$resfija;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=113;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$fechafi;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$resmovil;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=113;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$fechamo;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$resescolta;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=113;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$fechaes;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$lic;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=118;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$inilic;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$n;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$usuar;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$admi;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$guia;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$vig;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$tec;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$sup;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$tri;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$esc;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$cho;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$escop;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$sub;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto="0";
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$pis;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);


$texto=$rev;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=80;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$autos;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=100;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$transvalores;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);

$texto=$camperos;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=100;
$y=$iniy+$y;
$pdf->Text($x,$y,$texto);

$texto=$motos;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=165;
$pdf->Text($x,$y,$texto);



$pdf->Output();
?>
