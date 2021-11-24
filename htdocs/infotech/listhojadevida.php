<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1030);

/******************************************************************************
para comprobacion de que boton ha sido presionado
******************************************************************************/	
$fecha=getdate(time());
if ($_SESSION['ord']=="") {$_SESSION['ord']=="apellidos";}
$sql="SELECT * FROM `personalactivo` WHERE (`hv` IS NULL OR `hv` =0 OR `fc` IS NULL OR `fc` =0 OR `flb` IS NULL OR `flb` =0 OR `fpj` IS NULL OR `fpj` =0 OR `fca` IS NULL OR `fca` =0 OR `fra` IS NULL OR `fra` =0 OR `rl` IS NULL OR `rl` =0 OR `rp` IS NULL OR `rp` =0 OR `cr` IS NULL OR `cr` =0 OR `vid` IS NULL OR `vid` =0 OR `ept` IS NULL OR `ept` =0 OR `epps` IS NULL OR `epps` =0 OR `emo` IS NULL OR `emo` =0 OR `ind` IS NULL OR `ind` =0 OR `vd` IS NULL OR `vd` =0 AND personalactivo.activo = 1) AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
//echo $sql;
$result=@mysql_query($sql);
$ini=0;
$lim=mysql_num_rows($result);
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage('l');
$pdf->SetFont('Arial','B',18);
$file="imagenes/super10.jpg";
$x=30;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=250;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();


	
$texto="LISTADO VERIFICACION DOCUMENTOS";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=85;
$y=32;
$pdf->Text($x,$y,$texto);

$texto="HOJA DE VIDA";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=125;
$y=42;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="H.V.=Hoja de vida, F.C.=Fotocopia cedula, F.L.M=Fotocopia libreta, F.P.J=Fotocopia pasado judicial, F.C.A=Fotocopia certificaciones academicas, F.R.A=Fotocopia recibo del agua, R.L=Recomendaciones laborales, R.P=Recomendaciones personales";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=203;
$pdf->Text($x,$y,$texto);

$texto="C.R.=Certificacion residencial, V.D.=Verificacion de datos, E.P.T=Entrevista y prueba tecnica, E.P.S=Entrevista y prueba psicologica, E.M.O=Examen medico ocupacional, I=Induccion, V.DOM=Visita Domiciliaria";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=206;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="NOMBRES Y APELLIDOS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="H.V.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x1=110;
$y1=60;
$pdf->Text($x1,$y1,$texto);

$texto="F.C.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x2=118;
$y2=60;
$pdf->Text($x2,$y2,$texto);

$texto="F.L.M.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x3=126;
$y3=60;
$pdf->Text($x3,$y3,$texto);

$texto="F.P.J.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x4=134;
$y4=60;
$pdf->Text($x4,$y4,$texto);

$texto="F.C.A.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x5=142;
$y5=60;
$pdf->Text($x5,$y5,$texto);

$texto="F.R.A.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x6=150;
$y6=60;
$pdf->Text($x6,$y6,$texto);

$texto="R.L.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x7=158;
$y7=60;
$pdf->Text($x7,$y7,$texto);

$texto="R.P.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x8=166;
$y8=60;
$pdf->Text($x8,$y8,$texto);

$texto="C.R.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x9=174;
$y9=60;
$pdf->Text($x9,$y9,$texto);

$texto="V.D.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x10=184;
$y10=60;
$pdf->Text($x10,$y10,$texto);

$texto="E.P.T.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x11=192;
$y11=60;
$pdf->Text($x11,$y11,$texto);

$texto="E.P.S.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x12=200;
$y12=60;
$pdf->Text($x12,$y12,$texto);

$texto="E.M.O.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x13=208;
$y13=60;
$pdf->Text($x13,$y13,$texto);

$texto="I.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x14=216;
$y14=60;
$pdf->Text($x14,$y14,$texto);

$texto="V.DOM..";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x15=224;
$y15=60;
$pdf->Text($x15,$y15,$texto);

function verifica($val){
	if($val==0 OR $val==NULL){
		$doc="X";
	}else{
		$doc="";
	}
	return $doc;
}
$y=60;
while($ini<$lim){
	
$y=$y+5;
$cedula=@mysql_result($result,$ini,cedula);
$apellidos=decod(@mysql_result($result,$ini,apellidos)." ".@mysql_result($result,$ini,nombre));
$hv=verifica(@mysql_result($result,$ini,hv));
$fc=verifica(@mysql_result($result,$ini,fc));	
$flb=verifica(@mysql_result($result,$ini,flb));
$fpj=verifica(@mysql_result($result,$ini,fpj));
$fca=verifica(@mysql_result($result,$ini,fca));
$fra=verifica(@mysql_result($result,$ini,fra));
$rl=verifica(@mysql_result($result,$ini,rl));
$rp=verifica(@mysql_result($result,$ini,rp));
$cr=verifica(@mysql_result($result,$ini,cr));
$vid=verifica(@mysql_result($result,$ini,vid));
$ept=verifica(@mysql_result($result,$ini,ept));
$epps=verifica(@mysql_result($result,$ini,epps));
$emo=verifica(@mysql_result($result,$ini,emo));
$ind=verifica(@mysql_result($result,$ini,ind));
$vd=verifica(@mysql_result($result,$ini,vd));

$pdf->Text("20", $y, $cedula);
$pdf->Text("50", $y, $apellidos);
$pdf->Text($x1,$y,$hv);
$pdf->Text($x2,$y,$fc);	
$pdf->Text($x3,$y, $flb);
$pdf->Text($x4,$y, $fpj);
$pdf->Text($x5,$y, $fca);
$pdf->Text($x6,$y,$fra);
$pdf->Text($x7,$y,$rl);
$pdf->Text($x8,$y,$rp);
$pdf->Text($x9,$y,$cr);
$pdf->Text($x10,$y,$vid);
$pdf->Text($x11,$y,$ept);
$pdf->Text($x12,$y,$epps);
$pdf->Text($x13,$y,$emo);
$pdf->Text($x14,$y,$ind);
$pdf->Text($x15,$y, $vd);

if($y>185){
$pdf->AddPage('l');

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="H.V.=Hoja de vida, F.C.=Fotocopia cedula, F.L.M=Fotocopia libreta, F.P.J=Fotocopia pasado judicial, F.C.A=Fotocopia certificaciones academicas, F.R.A=Fotocopia recibo del agua, R.L=Recomendaciones laborales, R.P=Recomendaciones personales";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=203;
$pdf->Text($x,$y,$texto);

$texto="C.R.=Certificacion residencial, V.D.=Verificacion de datos, E.P.T=Entrevista y prueba tecnica, E.P.S=Entrevista y prueba psicologica, E.M.O=Examen medico ocupacional, I=Induccion, V.DOM=Visita Domiciliaria";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x=20;
$y=206;
$pdf->Text($x,$y,$texto);
	
$texto="CEDULA";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="NOMBRES Y APELLIDOS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="H.V.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x1=110;
$y1=20;
$pdf->Text($x1,$y1,$texto);

$texto="F.C.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x2=118;
$y2=20;
$pdf->Text($x2,$y2,$texto);

$texto="F.L.M.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x3=126;
$y3=20;
$pdf->Text($x3,$y3,$texto);

$texto="F.P.J.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x4=134;
$y4=20;
$pdf->Text($x4,$y4,$texto);

$texto="F.C.A.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x5=142;
$y5=20;
$pdf->Text($x5,$y5,$texto);

$texto="F.R.A.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x6=150;
$y6=20;
$pdf->Text($x6,$y6,$texto);

$texto="R.L.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x7=158;
$y7=20;
$pdf->Text($x7,$y7,$texto);

$texto="R.P.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x8=166;
$y8=20;
$pdf->Text($x8,$y8,$texto);

$texto="C.R.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x9=174;
$y9=20;
$pdf->Text($x9,$y9,$texto);

$texto="V.D.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x10=184;
$y10=20;
$pdf->Text($x10,$y10,$texto);

$texto="E.P.T.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x11=192;
$y11=20;
$pdf->Text($x11,$y11,$texto);

$texto="E.P.S.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x12=200;
$y12=20;
$pdf->Text($x12,$y12,$texto);

$texto="E.M.O.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x13=208;
$y13=20;
$pdf->Text($x13,$y13,$texto);

$texto="I.";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x14=216;
$y14=20;
$pdf->Text($x14,$y14,$texto);

$texto="V.DOM..";
$pdf->SetFont('Arial','B',6);   
$pdf->Ln();
$x15=224;
$y15=20;
$pdf->Text($x15,$y15,$texto);	
}



$ini++;
}




$pdf->Output();
?>