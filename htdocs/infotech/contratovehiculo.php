<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 69);
	
	$sql="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$_SESSION[clientemod]'";
	$cons=@mysql_query($sql);
	$admin=decod(@mysql_result($cons,0,nombreadministrador));
	$nit=decod(@mysql_result($ocns,0,nit));
	$direccion=decod(@mysql_result($cons,0,direccion));
	
	$sql2="SELECT * FROM seguridadsuper";
	$cons2=@mysql_query($sql2);
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
$texto="CONTRATO DE SERVICIO DE TRANSPORTE.";
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

$texto2=decod("ENTRE LOS SUSCRITOS a saber: $representante, mayor de edad, identificado como aparece al pie de la firma, domiciliado y residente en esta ciudad, en Representación de la sociedad $empresa)., quien en adelante se llamará EL CONTRATANTE por una parte; y _______________________________, también mayor de edad, identificado como aparece al pie de su firma, domiciliado y residente en esta ciudad, quien en adelante se llamará EL CONTRATISTA hemos convenido celebrar el presente contrato de transporte, que se rige por las siguientes cláusulas. PRIMERO. Objeto. El objeto del presente contrato es el servicio de transporte para nuestro trabajador__________________________________________, identificado con la cédula de ciudadanía No.____________________________ durante su jornada laboral, única y exclusivamente para la ejecución de sus acitividades propias de su cargo. Se excluye el transporte a su lugar de residencia. SEGUNDO. Plazo. El término de ejecución del presente contrato es de SEIS (6) MESES, prorrogable automáticamente por periodos iguales. No obstante, cualquiera de las partes podrá darlo por terminado unilateralmente en cualquier tiempo sin lugar a ningún tipo de indemnización, con solo avisarle a la otra su decisión. TERCERO. Precio y Forma de Pago. El valor del contrato es la suma de ______________________________ Moneda Legal por __________________________prestado, los cuales serán pagados en la Dirección administrativa dentro de los cinco (5) primero días de cada mes vencido, previa presentación de cuenta de cobro firmada por el CONTRATISTA y entrega a satisfacción de todos los documentos, dinero y soportes que posea por razón del servicio. CUARTA. Obligaciones del Contratista. Aportar los documentos en regla del vehículo utilizado habitualmente para el servicio que hace parte del contrato; en caso de cambio de vehículo deberá informarlo oportunamente a EL CONTRATANTE y aportar copia de los documentos; EL CONTRATISTA se obliga a su costa a mantener el vehículo en perfecto estado de funcionamiento y aseo; concurrir con presteza a los requerimientos de servicio que se realice; mantener vigentes los documentos del vehículo tales como licencia de tránsito, licencia de conducción, seguro obligatorio y RUT; Se obliga a observar todas las normas de tránsito y seguridad vial; Mantener los elementos y equipos de protección propios de este tipo de vehículos. QUINTA. Obligaciones del CONTRATANTE. Se obliga a pagar el servicio en las condiciones antes descritas; dar aviso con anticipación de los servicios a cumplir; prestar los medios para la ejecución del contrato. SEXTA. Domicilio. Las partes acuerdan que para todo efecto el domicilio es la ciudad de Bogotá, D.C. Para constancia se firma en Bogotá D.C., el ______ de __________del año _______. ");
$pdf->SetFont('Arial','',10);   
$pdf->Ln();
$x=20;
$y=55;
$pdf->Setxy($x,$y);
$pdf->MultiCell(170,5,$texto2,$border=0,$align='J',$fill=0);
$texto3="El Contratista:						                                  El Contratante:





_____________________________     $representante
C.C. No. ______________________    C.C. $cedrepres DE $expcedrep.
NIT. _________________________					NIT. $nit.
_____________________________.			 $empresa.
";
$pdf->SetFont('Arial','',13);   
$pdf->Ln();
$x=20;
$y=220;
$pdf->Setxy($x,$y);
$pdf->MultiCell(170,5,$texto3,$border=0,$align='J',$fill=0);

$pdf->Output();
?>

