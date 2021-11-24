<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 67);
	
	$sql="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$_SESSION[clientemod]'";
	$sql2="SELECT * FROM seguridadsuper";
	$cons=@mysql_query($sql);
	$cons2=@mysql_query($sql2);
	$admin=decod(@mysql_result($cons,0,nombreadministrador));
	$nit=decod(@mysql_result($ocns,0,nit));
	$direccion=decod(@mysql_result($cons,0,direccion));
	$empresa=decod(@mysql_result($cons2,0,razonsocial));
	$representante=decod(@mysql_result($cons2,0,representantelegal));
	$cedrepres=decod(@mysql_result($cons2,0,cedularepres));
	$expcedrep=decod(@mysql_result($cons2,0,expedicioncedrep));
	$nit=decod(@mysql_result($cons2,0,nit));

require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=10;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=180;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="CONTRATO DE  SERVICIO DE VIGILANCIA Y SEGURIDAD PRIVADA ENTRE $empresa. Y _______________________________.";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Setxy($x,$y);
$pdf->MultiCell(125,5,$texto,$border=0,$align='J',$fill=0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$texto2=decod("Entre los suscritos _____________________, ____________Mayor de edad, domiciliado y residente en esta ciudad, identificado como aparece al pie de su firma, actuando en condición de Representante Legal de la sociedad denominada _________________________, NIT. ________________, ubicado en la _______________piso _ DE __________, quien para efectos del presente contrato en adelante se denominará EL CONTRATANTE por una parte; y, por la otra parte $representante, Colombiano también  mayor de edad, vecino y Residente de Bogotá, identificado como aparece al pie de su firma, obrando en condición de Gerente y Representante Legal de SEGURIDAD $empresa., NIT No.830106586-1, Matrícula mercantil No. 01201974, constituida mediante escritura pública No. 0001516 de la notaria 46 de Bogotá, quien para los efectos del presente contrato se denominará EL CONTRATISTA; hemos acordado celebrar el presente contrato de prestación de servicio de vigilancia y seguridad privada con formalidades plenas, que se rige por las normas del Derecho privado y las siguientes Cláusulas: CLAUSULA PRIMERA: Objeto: El objeto del presente contrato es la prestación de los servicios de vigilancia y seguridad privada para la obra  denominada ________________________ubicada en la _____________________de la ciudad de _____________, conforme a las disposiciones Legales que regulan la actividad. SEGUNDA: Responsabilidad de Prestaciones Sociales: SEGURIDAD $empresa., en su condición de CONTRATISTA es el responsable de los salarios, prestaciones sociales y demás obligaciones laborales frente a sus trabajadores; en consecuencia queda claro que EL CONTRATANTE queda exonerado de cualquier responsabilidad laboral frente al personal de vigilancia que se destine al cumplimiento del objeto del presente contrato. TERCERA: Número de Servicios y Modalidad: El servicio contratado se prestará con UN (_) vigilante(s) las __ horas del día _________. CUARTA: valor: EL CONTRATANTE pagará a SEGURIDAD $empresa., por los servicios de vigilancia y seguridad prestados durante el mes, la suma de ________________________ ($__________________) MONEDA LEGAL. El pago ha de efectuarse dentro de los ______ (__) primeros días vencidos de cada mes, previa presentación de la factura por parte de EL CONTRATISTA, mediante cheque girado a favor de SEGURIDAD $empresa., o mediante transferencia a nuestra cuenta corriente, caso en el cual EL CONTRATANTE, dará aviso por cualquier medio idóneo de dicha operación bancaria. QUINTA: Reajuste de Tarifas: Queda expresamente entendido y aceptado que la tarifa acordada en la Cláusula Cuarta se reajustará automáticamente cada primero (1) de enero, en un porcentaje igual al que decrete el Gobierno nacional para el salario mínimo legal. SEXTA: Vigencia: El presente contrato tiene una vigencia igual a _______________ fecha de inicio el día _________________. SEPTIMA: Calidad del Personal: EL CONTRATISTA se obliga a seleccionar el personal que prestará el servicio conforme a las condiciones de idoneidad establecidas por la Empresa y las disposiciones legales que regulan la actividad de la seguridad privada. OCTAVA: Dirección y Control. EL CONTRATISTA es el directo responsable de la Dirección y Supervisión del personal de seguridad que preste el servicio contratado. NOVENA: Relevo del Personal: EL CONTRATISTA acepta relevar el personal de seguridad cuando el CONTRATANTE lo estime conveniente para el servicio, previa solicitud con al menos 48 horas de anticipación, salvo que se trate de un evento grave, caso en el cual el relevo se hará en el término de la distancia. DECIMA: Garantías: EL CONTRATISTA se compromete Para con EL CONTRATANTE, a mantener vigente una Póliza de Responsabilidad Civil extracontractual por valor de CUATROCIENTOS (400) SALARIOS MINIMOS MENSUALES LEGALES conforme lo ordena el Decreto 356 de 1994, Estatuto de vigilancia y seguridad privada. DECIMA PRIMERA: obligaciones de EL CONTRATISTA: Está obligado a cumplir  con todas las estipulaciones del contrato; Colocar todos los elementos de dotación ofrecidos por la empresa en su oferta de servicio que hace parte integral de este contrato; mantener un  buen nivel de seguridad en la copropiedad; suministrar personal idóneo para el servicio; atender con prontitud los requerimientos del usuario; desarrollar actividades preventivas de seguridad; observar las instrucciones del usuario que redunden en mejoramiento del servicio; capacitar periódicamente el personal de vigilancia. DECIMA SEGUNDA: Obligaciones de EL CONTRATANTE: Observar las recomendaciones de seguridad que presente EL CONTRATISTA para minimizar riesgos; Utilizar el personal de vigilancia en actividades exclusivamente de seguridad; informar oportunamente cualquier inconsistencia  que se observe en el cumplimiento de las tareas propias de los vigilantes  a fin de tomar los correctivos del caso; tomar las medidas de seguridad en las áreas privadas de la obra; dar a conocer oportunamente instrucciones o información necesaria para ejercer controles de seguridad. DECIMA TERCERA: Domicilio: Las partes acuerdan que para todo efecto el domicilio contractual es la ciudad de Bogotá, D.C.  Para constancia y señal de asentimiento se firma por las partes hoy  ______________ en la ciudad de Bogotá D.C.  ");
$pdf->SetFont('Arial','',13);   
$pdf->Ln();
$x=20;
$y=55;
$pdf->Setxy($x,$y);
$pdf->MultiCell(170,5,$texto2,$border=0,$align='J',$fill=0);



$texto2="El Contratante:						                                  El Contratista:





_____________________________     $representante
C.C. No. ______________________    C.C. No. $cedrepres DE $expcedrep.
NIT. _________________________					NIT. $nit.
_____________________________.  SEGURIDAD $empresa.
";
$pdf->SetFont('Arial','',13);   
$pdf->Ln();
$x=20;
$y=190;
$pdf->Setxy($x,$y);
$pdf->MultiCell(170,5,$texto2,$border=0,$align='J',$fill=0);

$pdf->Output();
?>

