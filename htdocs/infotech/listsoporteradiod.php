<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1047);

require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=16;
$pdf->Image($file,$x,$y,$w=27,$h=27);
$fecha=getdate(time());

$texto="SOPORTE DIARIO DE RADIOPERACION DIA $fecha[mday]-$fecha[mon]-$fecha[year]";
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=100;
$h=6;
$x=60;
$y=30;
$pdf->Sety($y);
$pdf->Setx($x);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);

$mesc=$fecha[month].$fecha[year];
$sql="SELECT * FROM `personalactivo`,`controlturnos`, `clientes` WHERE `reg$fecha[mday]` LIKE '$_SESSION[persona]' AND `d$fecha[mday]` NOT LIKE ''  AND `mescontrol` LIKE '$mesc' AND `controlturnos`.`cedulacontrol`=`personalactivo`.`cedula` AND `personalactivo`.`codigo`=`clientes`.`codigo` ORDER BY `clientes`.`codigo`, `apellidos`";
$result=@mysql_query($sql);
$ini=0;
$lim=@mysql_num_rows($result);
$y+=10;
$x=15;
$cuentapersonas=0;

for($ini=0;$ini<=$lim;$ini++){	
if(@mysql_result($result,$ini,"codigo")!=@mysql_result($result,$ini-1,"codigo")){
$texto=@mysql_result($result,$ini,"codigo");
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;

if($ini!=0){
$y+=5;	
$reporteesperado=@mysql_result($result,$ini,"personald");
$reporteejecutado=$cuentapersonas;
$porcejecucion=@ceil(($reporteejecutado/$reporteesperado)*100);
$pdf->SetFont('Arial','B',9); 
$pdf->Text($x,$y,"Reportes Esperados: $reporteesperado, Reportes Ejecutados: $reporteejecutado, Porcentaje Ejecucion: $porcejecucion %");
}

$pdf->SetFont('Arial','B',14); 
$y+=7;
$pdf->Text($x,$y,$texto);
$cuentapersonas=0;
}

$y+=5;
$cuentapersonas++;
$texto0=@mysql_result($result,$ini,"cedula");
$texto1=decod(@mysql_result($result,$ini,"apellidos")." ".@mysql_result($result,$ini,"nombre"));
$texto2=@mysql_result($result,$ini,"d$fecha[mday]");
$pdf->SetFont('Arial','',10);   

if($texto2==1 && $texto0!="" && $texto0!=0){$texto3="Turno Diurno";}else{$texto3="";}

$pdf->Text($x,$y,$texto0);
$pdf->Text($x+30,$y,$texto1);
$pdf->Text($x+150,$y,$texto3);

if($y>270){	
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=27;
$y=16;
$pdf->Image($file,$x,$y,$w=27,$h=27);

$texto="                          SOPORTE DIARIO DE RADIOPERACION";
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$w=176;
$h=6;
$y=30;
$pdf->Sety($y);
$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$y+=15;
$x=15;
}	

if($ini==$lim){
$y+=7;	
$sql="SELECT SUM(personald) AS total from clientes WHERE clientes.activo=1 AND clientes.sucursal=$_SESSION[sucur]";
$result=@mysql_query($sql);
$total=@mysql_result($result,0,"total");
$porcejecucion=@ceil(($lim/$total)*100);

$pdf->SetFont('Arial','B',11); 
$pdf->Text($x,$y,"Reporte Total Esperado: $total Reporte Total Ejecutado: $lim Porcentaje Ejecucion: $porcejecucion %");
$y+=7;
$pdf->Text($x,$y,"Reporte Realizado Por: $_SESSION[persona]");	
}
}

/*
 * select SUM(personald) from clientes WHERE clientes.activo=1 AND clientes.sucursal=$_SESSION[sucur]
 */

//echo $sql;
$pdf->Output();
?>

