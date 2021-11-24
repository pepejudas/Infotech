<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 66);
	
$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$_SESSION[cedulamod]";
$sql2="SELECT * FROM parametros";
$sql29="SELECT * FROM seguridadsuper";
$consseg=mysql_query($sql29);
$contr=mysql_query($sql2);
$direccions=decod(@mysql_result($consseg,0,direccion)." BARRIO ".@mysql_result($consseg,0,barrio));
$result=mysql_query($sql1);
$nombre=decod(@mysql_result($result,0,nombre));
$apellido=decod(@mysql_result($result,0,apellidos));
$cedula=decod(@mysql_result($result,0,cedula));
$contrata=decod1(@mysql_result($contr,0,contrato3));
$razonsocial=decod(@mysql_result($consseg,0,razonsocial));

switch(@mysql_result($result,0,cargo)):
			
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
	 		case 12: $cargo="VIGILANTE"; break;
	 		case 13: $cargo="OPERADOR MEDIO TECNOLOGICO"; break;
	 		case 14: $cargo="TRIPULANTE"; break;
	 		
endswitch;

$direccion=decod(@mysql_result($result,0,direccion));
$ciudadnacim=decod(@mysql_result($result,0,coddeptonacim).@mysql_result($result,0,codciudadnacim));
$fechanacim=decod(@mysql_result($result,0,fechanacimiento));
$fechaing=decod(@mysql_result($result,0,fechaingreso));
$carnet=decod(@mysql_result($result,0,carnetinterno));
$ciudadres=decod(@mysql_result($result,0,codigoresidencia));
$codbusca=decod(@mysql_result($result,0,codigo));
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=mysql_query($sql2);
$sql15="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resultac=@mysql_query($sql15);
$cod=@mysql_result($resultac,0,codigo);
if($cod==""){
echo '<h1>!Error debe actualizar el codigo del cliente asignado <br>a esta persona de lo contrario no puede ser generado <br> el contrato de trabajo!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';
exit();	
};
if($cod=="relevantes"){
echo '<h1>!Error para relevantes utilice contrato a un año!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';
exit();	
}
//ciudad de residencia
switch($ciudadres):
			case "08001": $city="BARRANQUILLA"; break;
 	 		case "11001": $city="BOGOTA"; break;
 	 		case "76001": $city="CALI"; break;
 	 		case "25269": $city="FACATATIVA"; break;			   	 		
 	 		case "25286": $city="FUNZA"; break; 	 		
 	 		case "25377": $city="LA CALERA"; break; 	 		
 	 		case "25430": $city="MADRID"; break; 	 		
 	 		case "05001": $city="MEDELLIN"; break;
 	 		case "25473": $city="MOSQUERA"; break; 	 		
 	 		case "25740": $city="SIBATE"; break; 	 		
	 		case "25754": $city="SOACHA"; break;
 	 		case "50001": $city="VILLAVICENCIO"; break;
 	 		case "15759": $city="SOGAMOSO"; break;
endswitch;

if(@mysql_result($result,0,codigo)==""){echo '<h1>!Error debe actualizar el codigo del cliente asignado <br>a esta persona de lo contrario no puede ser generado <br> el contrato de trabajo!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';exit();}
$nombrecliente=mysql_result($resulta,0,nombrecliente);
require('fpdf/fpdf.php');
$pdf=new FPDF('P','mm','legal');
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=10;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=176;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="                         
                                                                                                         ".$carnet."

                                 CONTRATO INDIVIDUAL DE TRABAJO A  
			                                TERMINO FIJO DE UNO A TRES A".utf8_decode(Ñ)."OS";
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$pdf->Write(5,$texto);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$texto2="

NOMBRE DEL EMPLEADOR: 	            $razonsocial.
DIRECCION DEL EMPLEADOR:         $direccions
NOMBRES DEL TRABAJADOR:		       $nombre"." "."$apellido
IDENTIFICADO CON CC. No:	              $cedula
DIRECCION DEL TRABAJADOR:	      $direccion
LUGAR Y FECHA DE NACIMIENTO:  ".$ciudadnacim." ".$fechanacim."
CARGO A DESEMPE".utf8_decode(Ñ)."AR:                  $cargo 
SALARIO:                                             MINIMO LEGAL VIGENTE
PERIODOS DE PAGO: 		                      Entre los 10 _ 15 de cada mes.
FECHA DE INICIO DE LABORES:	      $fechaing
LUGAR A DESEMPE".utf8_decode(Ñ)."AR LABORES:$city $codbusca
CLIENTE:                                              $nombrecliente
";

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;
require('saludoslis.php');

$pdf->SetFont('Arial','B',12);
$pdf->Write(5,$texto2);
$pdf->Ln();
$w=185;
$h=4;
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell($w,$h,utf8_decode($contrata),$border=0,$align='J',$fill=0);
$pdf->Ln();
$pdf->Ln();
$texto10="
___________________________________			                                    ____________________________________
C.C._______________________________			                                    C.C.________________________________
GERENTE GENERAL $razonsocial										 		                       EL TRABAJADOR	






___________________________________			                                    ____________________________________
C.C._______________________________			                                    C.C.________________________________
TESTIGO                                                                                            TESTIGO	

";
$pdf->SetFont('Arial','B',8);
//$pdf->Text($x,$y,$texto10);
$w=185;
$h=4;
$pdf->MultiCell($w,$h,$texto10,$border=0,$align='J',$fill=0);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;
require('saludoslis.php');

$pdf->Output();
?>

