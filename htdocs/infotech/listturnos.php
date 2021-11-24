<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1050);

$fecha=getdate(time());
$sql1="SELECT * FROM controlturnos, personalactivo WHERE controlturnos.cedulacontrol LIKE personalactivo.cedula AND personalactivo.sucursal LIKE '$_SESSION[sucur]' AND `controlturnos`. `mescontrol` LIKE '$fecha[month]$fecha[year]' ORDER BY $_SESSION[ord]";
$result=@mysql_query($sql1);
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

switch($fecha[month]):
			case "January": $mes="ENERO"; break;
			case "February": $mes="FEBRERO"; break;
			case "March": $mes="MARZO"; break;
			case "April": $mes="ABRIL"; break;
			case "May": $mes="MAYO"; break;
			case "June": $mes="JUNIO"; break;
			case "July": $mes="JULIO"; break;
			case "August": $mes="AGOSTO"; break;
			case "September": $mes="SEPTIEMBRE"; break;
			case "October": $mes="OCTUBRE"; break;
			case "November": $mes="NOVIEMBRE"; break;
			case "December": $mes="DICIEMBRE"; break;
endswitch;

$texto="LISTADO CONTROL DE TURNOS ".$mes;
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=72;
$y=32;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=70;
$y11=200;
require('saludoslis.php');

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

$texto="DIAS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=55;
$pdf->Text($x,$y,$texto);

$texto="1";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="2";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=125;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="3";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=130;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="4";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=135;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="5";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="6";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=145;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="7";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=150;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="8";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=155;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="9";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="10";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=165;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="11";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=170;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="12";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=175;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="13";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=180;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="14";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=185;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="15";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=190;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="16";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=195;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="17";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=200;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="18";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=205;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="19";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=210;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="20";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=215;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="21";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=220;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="22";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=225;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="23";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=230;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="24";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=235;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="25";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=240;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="26";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=245;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="27";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=250;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="28";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=255;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="29";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=260;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="30";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=265;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="31";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=270;
$y=60;
$pdf->Text($x,$y,$texto);

$y=60;
$reg=0;

while($vector=@mysql_fetch_array($result)){
$ced=@mysql_result($result,$reg,cedulacontrol);

$sql3="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula` = $ced ORDER BY apellidos";
$cons=@mysql_query($sql3);
if($nombre=@mysql_result($cons,0,nombre)==""){
$sql3="SELECT * FROM personalretirado WHERE `personalretirado`.`cedula` = $ced ORDER BY apellidos";
$cons=@mysql_query($sql3);
}
$nombre=decod(@mysql_result($cons,0,nombre));

if($nombre!=""){

$apellido=decod(@mysql_result($cons,0,apellidos));
$cedula=@mysql_result($cons,0,cedula);
$d1=@mysql_result($result,$reg,d1);
$d2=@mysql_result($result,$reg,d2);
$d3=@mysql_result($result,$reg,d3);
$d4=@mysql_result($result,$reg,d4);
$d5=@mysql_result($result,$reg,d5);
$d6=@mysql_result($result,$reg,d6);
$d7=@mysql_result($result,$reg,d7);
$d8=@mysql_result($result,$reg,d8);
$d9=@mysql_result($result,$reg,d9);
$d10=@mysql_result($result,$reg,d10);
$d11=@mysql_result($result,$reg,d11);
$d12=@mysql_result($result,$reg,d12);
$d13=@mysql_result($result,$reg,d13);
$d14=@mysql_result($result,$reg,d14);
$d15=@mysql_result($result,$reg,d15);
$d16=@mysql_result($result,$reg,d16);
$d17=@mysql_result($result,$reg,d17);
$d18=@mysql_result($result,$reg,d18);
$d19=@mysql_result($result,$reg,d19);
$d20=@mysql_result($result,$reg,d20);
$d21=@mysql_result($result,$reg,d21);
$d22=@mysql_result($result,$reg,d22);
$d23=@mysql_result($result,$reg,d23);
$d24=@mysql_result($result,$reg,d24);
$d25=@mysql_result($result,$reg,d25);
$d26=@mysql_result($result,$reg,d26);
$d27=@mysql_result($result,$reg,d27);
$d28=@mysql_result($result,$reg,d28);
$d29=@mysql_result($result,$reg,d29);
$d30=@mysql_result($result,$reg,d30);
$d31=@mysql_result($result,$reg,d31);
$n1=@mysql_result($result,$reg,n1);
$n2=@mysql_result($result,$reg,n2);
$n3=@mysql_result($result,$reg,n3);
$n4=@mysql_result($result,$reg,n4);
$n5=@mysql_result($result,$reg,n5);
$n6=@mysql_result($result,$reg,n6);
$n7=@mysql_result($result,$reg,n7);
$n8=@mysql_result($result,$reg,n8);
$n9=@mysql_result($result,$reg,n9);
$n10=@mysql_result($result,$reg,n10);
$n11=@mysql_result($result,$reg,n11);
$n12=@mysql_result($result,$reg,n12);
$n13=@mysql_result($result,$reg,n13);
$n14=@mysql_result($result,$reg,n14);
$n15=@mysql_result($result,$reg,n15);
$n16=@mysql_result($result,$reg,n16);
$n17=@mysql_result($result,$reg,n17);
$n18=@mysql_result($result,$reg,n18);
$n19=@mysql_result($result,$reg,n19);
$n20=@mysql_result($result,$reg,n20);
$n21=@mysql_result($result,$reg,n21);
$n22=@mysql_result($result,$reg,n22);
$n23=@mysql_result($result,$reg,n23);
$n24=@mysql_result($result,$reg,n24);
$n25=@mysql_result($result,$reg,n25);
$n26=@mysql_result($result,$reg,n26);
$n27=@mysql_result($result,$reg,n27);
$n28=@mysql_result($result,$reg,n28);
$n29=@mysql_result($result,$reg,n29);
$n30=@mysql_result($result,$reg,n30);
$n31=@mysql_result($result,$reg,n31);

if($y>185){$pdf->AddPage('l');

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=70;
$y11=200;
require('saludoslis.php');

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

$texto="DIAS";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=15;
$pdf->Text($x,$y,$texto);

$texto="1";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=120;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="2";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=125;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="3";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=130;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="4";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=135;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="5";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=140;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="6";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=145;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="7";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=150;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="8";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=155;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="9";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=160;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="10";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=165;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="11";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=170;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="12";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=175;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="13";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=180;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="14";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=185;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="15";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=190;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="16";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=195;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="17";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=200;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="18";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=205;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="19";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=210;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="20";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=215;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="21";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=220;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="22";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=225;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="23";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=230;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="24";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=235;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="25";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=240;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="26";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=245;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="27";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=250;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="28";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=255;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="29";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=260;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="30";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=265;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="31";
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=270;
$y=20;
$pdf->Text($x,$y,$texto);
}

$texto1=$cedula;
$pdf->SetFont('Arial','',10);  
$x=20; 
$y=$y+8;
$pdf->Text($x,$y,$texto1);

$texto2=$nombre. " " . $apellido;
$pdf->SetFont('Arial','',8);   
$x=50;
$pdf->Text($x,$y,$texto2);

$texto5=$d1;
$pdf->SetFont('Arial','',6);  
$x=120; 
$pdf->Text($x,$y,$texto5);

$texto4=$d2;
$pdf->SetFont('Arial','',6);  
$x=125; 
$pdf->Text($x,$y,$texto4);

		 	
$texto2=$d3;
$pdf->SetFont('Arial','',6);  
$x=130; 
$pdf->Text($x,$y,$texto2);

$texto2=$d4;
$pdf->SetFont('Arial','',6);  
$x=135; 
$pdf->Text($x,$y,$texto2);

$texto2=$d5;
$pdf->SetFont('Arial','',6);  
$x=140; 
$pdf->Text($x,$y,$texto2);

$texto2=$d6;
$pdf->SetFont('Arial','',6);  
$x=145; 
$pdf->Text($x,$y,$texto2);

$texto2=$d7;
$pdf->SetFont('Arial','',6);  
$x=150; 
$pdf->Text($x,$y,$texto2);

$texto2=$d8;
$pdf->SetFont('Arial','',6);  
$x=155; 
$pdf->Text($x,$y,$texto2);

$texto2=$d9;
$pdf->SetFont('Arial','',6);  
$x=160; 
$pdf->Text($x,$y,$texto2);

$texto2=$d10;
$pdf->SetFont('Arial','',6);  
$x=165; 
$pdf->Text($x,$y,$texto2);

$texto2=$d11;
$pdf->SetFont('Arial','',6);  
$x=170; 
$pdf->Text($x,$y,$texto2);

$texto2=$d12;
$pdf->SetFont('Arial','',6);  
$x=175; 
$pdf->Text($x,$y,$texto2);

$texto2=$d13;
$pdf->SetFont('Arial','',6);  
$x=180; 
$pdf->Text($x,$y,$texto2);

$texto2=$d14;
$pdf->SetFont('Arial','',6);  
$x=185; 
$pdf->Text($x,$y,$texto2);

$texto2=$d15;
$pdf->SetFont('Arial','',6);  
$x=190; 
$pdf->Text($x,$y,$texto2);

$texto2=$d16;
$pdf->SetFont('Arial','',6);  
$x=195; 
$pdf->Text($x,$y,$texto2);

$texto2=$d17;
$pdf->SetFont('Arial','',6);  
$x=200; 
$pdf->Text($x,$y,$texto2);

$texto2=$d18;
$pdf->SetFont('Arial','',6);  
$x=205; 
$pdf->Text($x,$y,$texto2);

$texto2=$d19;
$pdf->SetFont('Arial','',6);  
$x=210; 
$pdf->Text($x,$y,$texto2);

$texto2=$d20;
$pdf->SetFont('Arial','',6);  
$x=215; 
$pdf->Text($x,$y,$texto2);

$texto2=$d21;
$pdf->SetFont('Arial','',6);  
$x=220; 
$pdf->Text($x,$y,$texto2);

$texto2=$d22;
$pdf->SetFont('Arial','',6);  
$x=225; 
$pdf->Text($x,$y,$texto2);

$texto2=$d23;
$pdf->SetFont('Arial','',6);  
$x=230; 
$pdf->Text($x,$y,$texto2);

$texto2=$d24;
$pdf->SetFont('Arial','',6);  
$x=235; 
$pdf->Text($x,$y,$texto2);

$texto2=$d25;
$pdf->SetFont('Arial','',6);  
$x=240; 
$pdf->Text($x,$y,$texto2);

$texto2=$d26;
$pdf->SetFont('Arial','',6);  
$x=245; 
$pdf->Text($x,$y,$texto2);

$texto2=$d27;
$pdf->SetFont('Arial','',6);  
$x=250; 
$pdf->Text($x,$y,$texto2);

$texto2=$d28;
$pdf->SetFont('Arial','',6);  
$x=255; 
$pdf->Text($x,$y,$texto2);

$texto2=$d29;
$pdf->SetFont('Arial','',6);  
$x=260; 
$pdf->Text($x,$y,$texto2);

$texto2=$d30;
$pdf->SetFont('Arial','',6);  
$x=265; 
$pdf->Text($x,$y,$texto2);

$texto2=$d31;
$pdf->SetFont('Arial','',6);  
$x=270; 
$pdf->Text($x,$y,$texto2);

$y=$y+4;

$texto5=$n1;
$pdf->SetFont('Arial','',6);  
$x=120; 
$pdf->Text($x,$y,$texto5);

$texto4=$n2;
$pdf->SetFont('Arial','',6);  
$x=125; 
$pdf->Text($x,$y,$texto4);

		 	
$texto2=$n3;
$pdf->SetFont('Arial','',6);  
$x=130; 
$pdf->Text($x,$y,$texto2);

$texto2=$n4;
$pdf->SetFont('Arial','',6);  
$x=135; 
$pdf->Text($x,$y,$texto2);

$texto2=$n5;
$pdf->SetFont('Arial','',6);  
$x=140; 
$pdf->Text($x,$y,$texto2);

$texto2=$n6;
$pdf->SetFont('Arial','',6);  
$x=145; 
$pdf->Text($x,$y,$texto2);

$texto2=$n7;
$pdf->SetFont('Arial','',6);  
$x=150; 
$pdf->Text($x,$y,$texto2);

$texto2=$n8;
$pdf->SetFont('Arial','',6);  
$x=155; 
$pdf->Text($x,$y,$texto2);

$texto2=$n9;
$pdf->SetFont('Arial','',6);  
$x=160; 
$pdf->Text($x,$y,$texto2);

$texto2=$n10;
$pdf->SetFont('Arial','',6);  
$x=165; 
$pdf->Text($x,$y,$texto2);

$texto2=$n11;
$pdf->SetFont('Arial','',6);  
$x=170; 
$pdf->Text($x,$y,$texto2);

$texto2=$n12;
$pdf->SetFont('Arial','',6);  
$x=175; 
$pdf->Text($x,$y,$texto2);

$texto2=$n13;
$pdf->SetFont('Arial','',6);  
$x=180; 
$pdf->Text($x,$y,$texto2);

$texto2=$n14;
$pdf->SetFont('Arial','',6);  
$x=185; 
$pdf->Text($x,$y,$texto2);

$texto2=$n15;
$pdf->SetFont('Arial','',6);  
$x=190; 
$pdf->Text($x,$y,$texto2);

$texto2=$n16;
$pdf->SetFont('Arial','',6);  
$x=195; 
$pdf->Text($x,$y,$texto2);

$texto2=$n17;
$pdf->SetFont('Arial','',6);  
$x=200; 
$pdf->Text($x,$y,$texto2);

$texto2=$n18;
$pdf->SetFont('Arial','',6);  
$x=205; 
$pdf->Text($x,$y,$texto2);

$texto2=$n19;
$pdf->SetFont('Arial','',6);  
$x=210; 
$pdf->Text($x,$y,$texto2);

$texto2=$n20;
$pdf->SetFont('Arial','',6);  
$x=215; 
$pdf->Text($x,$y,$texto2);

$texto2=$n21;
$pdf->SetFont('Arial','',6);  
$x=220; 
$pdf->Text($x,$y,$texto2);

$texto2=$n22;
$pdf->SetFont('Arial','',6);  
$x=225; 
$pdf->Text($x,$y,$texto2);

$texto2=$n23;
$pdf->SetFont('Arial','',6);  
$x=230; 
$pdf->Text($x,$y,$texto2);

$texto2=$n24;
$pdf->SetFont('Arial','',6);  
$x=235; 
$pdf->Text($x,$y,$texto2);

$texto2=$n25;
$pdf->SetFont('Arial','',6);  
$x=240; 
$pdf->Text($x,$y,$texto2);

$texto2=$n26;
$pdf->SetFont('Arial','',6);  
$x=245; 
$pdf->Text($x,$y,$texto2);

$texto2=$n27;
$pdf->SetFont('Arial','',6);  
$x=250; 
$pdf->Text($x,$y,$texto2);

$texto2=$n28;
$pdf->SetFont('Arial','',6);  
$x=255; 
$pdf->Text($x,$y,$texto2);

$texto2=$n29;
$pdf->SetFont('Arial','',6);  
$x=260; 
$pdf->Text($x,$y,$texto2);

$texto2=$n30;
$pdf->SetFont('Arial','',6);  
$x=265; 
$pdf->Text($x,$y,$texto2);

$texto2=$n31;
$pdf->SetFont('Arial','',6);  
$x=270; 
$pdf->Text($x,$y,$texto2);

$x1=20;
$x2=274;
$y1=$y-3.3-4;
$y2=$y-3.3-4;
$y=$y-4;
$pdf->Line($x1,$y1,$x2,$y2);
}

$reg++;
}

$pdf->Output();
?>