<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1066);
	
$sql1="SELECT * FROM `personalactivo`, `clientes` WHERE `clientes`.`codigo` LIKE `personalactivo`.`codigo` AND `personalactivo`.`activo`='1' AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]' AND `personalactivo`.`codigo` LIKE '$_SESSION[clielis]' AND `clientes`.`duenopuesto` LIKE '$_SESSION[sociolis]' ORDER BY '$_SESSION[ord]'";
$result=mysql_query($sql1);
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=mysql_query($sql2);
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$file="imagenes/super10.jpg";
$x=10;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=176;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="LISTADO DE SEGURIDAD SOCIAL";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=58;
$y=32;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="EPS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=140;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="ARP";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="AFP";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=60;
$pdf->Text($x,$y,$texto);


$reg=0;

while($vector=mysql_fetch_array($result)){

$nombre=decod(mysql_result($result,$reg,nombre));
$apellido=decod(mysql_result($result,$reg,apellidos));
$cedula=mysql_result($result,$reg,cedula);
$eps=mysql_result($result,$reg,eps);
$arp=mysql_result($result,0,arp);
$afp=mysql_result($result,$reg,afp);
$fechaing=mysql_result($result,$reg,fechaingreso);

if($y==280){$pdf->AddPage();


$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="EPS";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=140;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="ARP";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=160;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="AFP";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=20;
$pdf->Text($x,$y,$texto);
$y=25;

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

}

$texto1=$cedula;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$apellido. " " . $nombre;
$pdf->SetFont('Arial','',10);   
$x=50;
$pdf->Text($x,$y,$texto2);

			
switch($eps):
			case 27:           $texto3="Barranquilla sana"; break;
	 		case 4:            $texto3="Bonsalud"; break;
	 		case 3:            $texto3="Cafesalud"; break;
	 		case 24:           $texto3="Cajanal"; break;
	 		case 28:           $texto3="Calisalud"; break;
	 		case 20:           $texto3="Caprecom"; break;
	 		case 25:           $texto3="Capresoca"; break;
	 		case 34:           $texto3="Casur"; break;
	 		case 15:           $texto3="Colpatria"; break;
	 		case 11:           $texto3="Colseguros"; break;
	 		case 9:            $texto3="Comfenalco Antioquia"; break;
	 		case 12:           $texto3="Comfenalco Valle"; break;
	 		case 8:            $texto3="Compensar"; break;
	 		case 22:           $texto3="Convida"; break;
	 		case 16:           $texto3="Coomeva"; break;
	 		case 21:           $texto3="Corporanominas"; break;
	 		case 23:           $texto3="Cruz Blanca"; break;
	 		case 30:           $texto3="Eps Condor"; break;
	 		case 29:           $texto3="Eps de Caldas"; break;
	 		case 19:           $texto3="Eps de Risaralda"; break;
	 		case 17:           $texto3="Famisanar"; break;
	 		case 14:           $texto3="Humana"; break;
	 		case 1:            $texto3="Salud Colmena"; break;
	 		case 2:            $texto3="Salud Total"; break;
	 		case 33:           $texto3="Salud Vida"; break;
	 		case 13:           $texto3="Saludcoop"; break;
	 		case 5:            $texto3="Sanitas"; break;
	 		case 6:            $texto3="Seguro Social"; break;
	 		case 31:           $texto3="Selva Salud"; break;
	 		case 26:           $texto3="Solsalud"; break;
	 		case 18:           $texto3="Sos Servicio Occ Salud"; break;
	 		case 10:           $texto3="Sura"; break;
	 		case 7:            $texto3="Unimec"; break;
	 		case 52:           $texto3="Nueva EPS"; break;
endswitch;
$pdf->SetFont('Arial','',6);  
$x=140; 
$pdf->Text($x,$y,decod($texto3));


switch($arp):
			case 200: $texto4="Agricola de Seguros"; break;
	 		case 206: $texto4="Bolivar"; break;
	 		case 203: $texto4="Colmena"; break;
	 		case 202: $texto4="Colpatria"; break;
	 		case 207: $texto4="Colseguros"; break;
	 		case 300: $texto4="Fosyga"; break;
	 		case 201: $texto4="Positiva"; break;
	 		case 208: $texto4="Liberty"; break;
	 		case 299: $texto4="Otras"; break;
	 		case 204: $texto4="Previ-Atep"; break;
	 		case 205: $texto4="Suratep"; break;
endswitch;
$pdf->SetFont('Arial','',6);  
$x=160; 
$pdf->Text($x,$y,decod($texto4));

switch($afp):
			case 309: $texto5="Askandia"; break;
	 		case 508: $texto5="Cajanal"; break;
	 		case 318: $texto5="Caldas"; break;
	 		case 307: $texto5="Cesantias de Colombia"; break;
	 		case 310: $texto5="Colfondos"; break;
	 		case 304: $texto5="Colmena"; break;
	 		case 301: $texto5="Colpatria"; break;
	 		case 308: $texto5="Davivir"; break;
	 		case 306: $texto5="Ganadera"; break;
	 		case 305: $texto5="Horizonte"; break;
	 		case 314: $texto5="Invertirmañana"; break;
	 		case 311: $texto5="Invertir"; break;
	 		case 319: $texto5="Pensionar"; break;
	 		case 303: $texto5="Porvenir"; break;
	 		case 302: $texto5="Proteccion"; break;
	 		case 509: $texto5="ING"; break;
	 		case 312: $texto5="Santander"; break;
	 		case 501: $texto5="Seguro Social"; break;
	 		case 316: $texto5="Solidez"; break;
endswitch;		 	

$pdf->SetFont('Arial','',6);  
$x=180; 
$pdf->Text($x,$y,decod($texto5));

$reg++;
}

$pdf->Output();
?>
