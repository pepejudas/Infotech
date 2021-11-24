<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1069);

	$fecha=getdate(time());
	$ano=$fecha[year];
	switch($fecha[month]):
			case "January": $mesbusca="December"; $ano=$fecha[year]-1;break;
			case "February": $mesbusca="January"; break;
			case "March": $mesbusca="February"; break;
			case "April": $mesbusca="March"; break;
			case "May": $mesbusca="April"; break;
			case "June": $mesbusca="May"; break;
			case "July": $mesbusca="June"; break;
			case "August": $mesbusca="July"; break;
			case "September": $mesbusca="August"; break;
			case "October": $mesbusca="September"; break;
			case "November": $mesbusca="October"; break;
			case "December": $mesbusca="November"; break;
endswitch;
	
	$mes=$mon.$fecha[year];
		
/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	
$sql1="SELECT * FROM escoltas, personalactivo WHERE personalactivo.cedula = $_SESSION[cedulamod] AND escoltas.mesreporte LIKE '$mesbusca$ano' AND escoltas.cedula=$_SESSION[cedulamod] ORDER BY escoltas.codigo";
//echo $sql1;
$result=mysql_query($sql1);
$ini=0;
$lim=@mysql_num_rows($result);
//$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
//$resulta=mysql_query($sql2);
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
$texto="REPORTE ESCOLTA INDIVIDUAL";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=55;
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


$texto="CODIGO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=79;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=55;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="FECHA INICIO SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=55;
$y=79;
$pdf->Text($x,$y,$texto);

$texto="FECHA FINAL SERVICIO";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=110;
$y=79;
$pdf->Text($x,$y,$texto);

$texto="TIEMPO TOTAL";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=165;
$y=79;
$pdf->Text($x,$y,$texto);

$reg=0;


	$nombre=@mysql_result($result,$reg,nombre);
	$apellido=@mysql_result($result,$reg,apellidos);
	$cedula=@mysql_result($result,$reg,cedula);
	
	$texto=decod($apellido." ".$nombre);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=55;
	$y=68;
	$pdf->Text($x,$y,$texto);
	
	$texto=$cedula;
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=20;
	$y=68;
	$pdf->Text($x,$y,$texto);
	
	
	$x1=20;
	$y1=70;
	$x2=196;
	$y2=70;
	$pdf->SetLineWidth(0.3);
	$pdf->Line($x1,$y1,$x2,$y2);

$y=80;
while($ini<$lim){
	$texto=@mysql_result($result,$ini,codigo);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=20;
	$y=$y+6;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,fechainicio);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=55;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,fechafinal);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=110;
	$pdf->Text($x,$y,$texto);
	
	$texto=@mysql_result($result,$ini,tiempototal);
	$pdf->SetFont('Arial','',12);   
	$pdf->Ln();
	$x=165;
	$pdf->Text($x,$y,$texto);
	
	if($y==280){
		$pdf->AddPage();
		
			
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln();
		$x11=20;
		$y11=285;
		require('saludoslis.php');
	
		$texto="FECHA INICIO SERVICIO";
		$pdf->SetFont('Arial','B',12);   
		$pdf->Ln();
		$x=55;
		$y=20;
		$pdf->Text($x,$y,$texto);

		$texto="FECHA FINAL SERVICIO";
		$pdf->SetFont('Arial','B',12);   
		$pdf->Ln();
		$x=110;
		$y=20;
		$pdf->Text($x,$y,$texto);

		$texto="TIEMPO TOTAL";
		$pdf->SetFont('Arial','B',12);   
		$pdf->Ln();
		$x=165;
		$y=20;
		$pdf->Text($x,$y,$texto);
		
		$y=25;
	}
	
	$ini++;
}

/*
while($vector=mysql_fetch_array($result)){
$v=mysql_result($result,$reg,vigenciacurso);
$fec=explode("-",$v);
$dia=$fec[2];
$mes=$fec[1];
$ano=$fec[0];
$t=getdate(time());
$num=$ano*365.25+$mes*30.416+$dia;
$com=$t[year]*365.25+$t[mon]*30.416+$t[mday]+2;

if($num<$com){
	
	$nombre=mysql_result($result,$reg,nombre);
	$apellido=mysql_result($result,$reg,apellidos);
	$cedula=mysql_result($result,$reg,cedula);
	$n=mysql_result($result,$reg,codnivelvig);
	$codbusca=mysql_result($result,$reg,codigo);
	
	switch($n):
			case 10: $nivel="Nivel I, curso de Introduccion"; break;
  	 		case 11: $nivel="Nivel II o III, curso Basico"; break;
  	 		case 12: $nivel="Nivel IV, curso Avanzado"; break;
  	 		case 13: $nivel="Actualizaciones"; break;
			case 14: $nivel="Especializaciones"; break;
			case 15: $nivel="Avanzado Especial"; break;
	endswitch;

	if($y==280){$pdf->AddPage();
	
	$texto="USUARIO: ".$_SESSION[persona]." "."FECHA Y HORA: ".$fecha[year]."/".$fecha[month]."/".$fecha[mday]." ".$fecha[hours].":".$fecha[minutes].":".$fecha[seconds]." "."INFOTECH 3.0 by Datapower and Softsecurity";
	$pdf->SetFont('Arial','B',8);   
	$pdf->Ln();
	$x=20;
	$y=285;
	$pdf->Text($x,$y,$texto);
	
	$texto="CODIGO";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=20;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="CEDULA";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=50;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="APELLIDOS Y NOMBRES";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=70;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="NIVEL";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=140;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$texto="VIGENCIA";
	$pdf->SetFont('Arial','B',12);   
	$pdf->Ln();
	$x=175;
	$y=20;
	$pdf->Text($x,$y,$texto);
	
	$y=25;

	}
	
	$texto1=$codbusca;
	$pdf->SetFont('Arial','',8);  
	$x=20; 
	$y=$y+5;
	$pdf->Text($x,$y,$texto1);
	
	$texto2=$cedula;
	$pdf->SetFont('Arial','',8);   
	$x=50;
	$pdf->Text($x,$y,$texto2);
	
	$texto3=$apellido ." " . $nombre;
	$pdf->SetFont('Arial','',8);  
	$x=70; 
	$pdf->Text($x,$y,$texto3);
	
	$texto4=$nivel;
	$pdf->SetFont('Arial','',7);  
	$x=140; 
	$pdf->Text($x,$y,$texto4);
	
	$texto4=$v;
	$pdf->SetFont('Arial','',10);  
	$x=175; 
	$pdf->Text($x,$y,$texto4);
	
	
}
$reg++;
}
*/
$pdf->Output();
?>

