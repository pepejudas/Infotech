<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 68);
	
	$sql="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$_SESSION[clientemod]'";
	$cons=@mysql_query($sql);
	$admin=@mysql_result($cons,0,nombreadministrador);
	$nit=@mysql_result($ocns,0,nit);
	$direccion=@mysql_result($cons,0,direccion);
	
	$sql2="SELECT * FROM seguridadsuper";
	$cons2=@mysql_query($sql2);
	$empresa=@mysql_result($cons2,0,razonsocial);
	$representante=@mysql_result($cons2,0,representantelegal);
	$cedrepres=@mysql_result($cons2,0,cedularepres);
	$expcedrep=@mysql_result($cons2,0,expedicioncedrep);
	$nit=@mysql_result($cons2,0,nit);

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
$texto="CONTRATO DE COMODATO.";
$pdf->SetFont('Arial','B',16);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Setxy($x,$y);
$pdf->MultiCell(125,5,$texto,$border=0,$align='C',$fill=0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$texto2=decod("ENTRE LOS SUSCRITOS a saber: $empresa., Sociedad constituida legalmente conforme las leyes colombianas mediante escritura pública No. 1516 del 30 de julio de 202 de la Notaría 46 de Bogotá, Representada legalmente por $representante, mayor de edad, domiciliado en Bogotá D.C. identificado con la cédula de ciudadanía No. 59969.540 de Ortega Tolima, y _________________________, Representada Legalmente por el señor ____________________, también mayor de edad, domiciliado y residente en _____________, identificado con la Cédula de ciudadanía No. ____________ de ___________, quienes para el efecto del presente contrato se denominarán EL COMODANTE y el COMODATARIO respectivamente, hemos convenido celebrar el presente CONTRATO DE COMODATO, que se regirán por las cláusulas que a continuación se señalan y en su defecto por la normatividad correspondiente del Código Civil: PRIMERA. EL COMODANTE entrega al COMODATARIO y éste recibe, a título de comodato o préstamo de uso, los bienes que se relacionan a continuación: __________________,_________________,________________ con los siguientes componentes: ________________(__________, ________,_________, _____________), ______________________________. El sistema será utilizado como apoyo para la prestación del servicio de seguridad privada de la copropiedad. SEGUNDA:  Estado de conservación del sistema. LA EMPRESA hace entrega del sistema antes descrito en perfectas condiciones (nuevo) de funcionamiento como de operación. TERCERA: Plazo de ejecución. La duración del presente contrato será de ____ (_) años contados a partir de la firma, fecha desde la cual se perfecciona. CUARTA: Concesión. Queda acordado, entendido y aceptado por las partes, que transcurridos __(_) años consecutivos EL COMODANTE concederá al COMODATARIO, la propiedad de todo el sistema y equipos ya relacionados al COMODATARIO, con la advertencia que si el contrato de vigilancia fija termina por cualquiera de las circunstancias pactadas en dicho contrato antes de su vencimiento, EL COMODATARIO podrá cancelar el valor del equipo, siempre y cuando haya acuerdo en su precio con el COMODANTE. QUINTA: Mantenimiento y Reparación del Sistema. EL COMODANTE , se obliga a: El mantenimiento de los bienes recibidos en comodato, y a la responsabilidad por los daños, siempre y cuando los daños no se deriven de hechos diferentes al uso ordinario, adecuado y cuidadoso del sistema. En los casos en que se presenten daños por uso indebido, descuido, o negligencia en su uso, la reparación será a cargo del COMODATARIO. SEXTA: Obligaciones del COMODATARIO. Serán obligaciones especiales 1) Mantener en lugar que ofrezca la seguridad adecuada de los equipos del sistema; 2) abstenerse de ceder el presente contrato sin la autorización escrita del COMODANTE; 3) mantener y evitar cualquier modificación o adulteración de las características técnicas de los equipos; 4) Usar el sistema exclusivamente para los fines de este contrato; 5) informar cualquier daño o falla que presente el sistema; 6) impedir la manipulación del sistema por parte de personas inexpertas o sin la capacitación adecuada; 7) efectuar las instalaciones de las cámaras que determine poner en operación. SEPTIMA: Obligaciones del COMODANTE 1) Entregar los equipos del sistema en perfectas condiciones (NUEVO) de funcionamiento y operación; 2) Instruir al COMODATARIO de su correcto uso y prestaciones que le ofrece el sistema; 3) Efectuar las reparaciones y mantenimientos que requiera el sistema por uso y deterioro ordinario; las demás propias de este tipo de contratos. OCTAVA: Causales de terminación del contrato. El presente contrato se podrá terminar, además de las causales de Ley, en los siguientes casos: 1) Por acuerdo entre las partes, 2) Por daño o mal funcionamiento de los equipos y cuya responsabilidad sea defectos de fábrica o defectuosa instalación; 3) Por daño, avería o pérdida atribuible a falta de diligencia o descuido del COMODATARIO. 4) Incumplimiento de las obligaciones por cualquiera de las partes de este contrato.  NOVENA: Acuerdan las partes estimar el valor de los bienes dados en comodato en ____________________ ($______________) Domicilio, suma que deberá pagar el COMODATARIO al COMODANTE si este ejerce la facultad que en su favor consagra el artículo 2203 del Código Civil, pero teniendo en cuenta lo acordado en la cláusula tercera de este contrato. Las partes acuerdan como domicilio contractual la ciudad de Bogotá D.C. En señal de asentimiento se firma hoy __________________.");
$pdf->SetFont('Arial','',12);   
$pdf->Ln();
$x=20;
$y=55;
$pdf->Setxy($x,$y);
$pdf->MultiCell(170,5,$texto2,$border=0,$align='J',$fill=0);
$texto3="El Contratista:						                                  El Contratante:





_____________________________     $representante
C.C. No. ______________________    C.C. No. $cedrepres DE $expcedrep.
NIT. _________________________					NIT. $nit.
_____________________________.			 $empresa.
";
$pdf->SetFont('Arial','',13);   
$pdf->Ln();
$x=20;
$y=100;
$pdf->Setxy($x,$y);
$pdf->MultiCell(170,5,$texto3,$border=0,$align='J',$fill=0);

$pdf->Output();
?>

