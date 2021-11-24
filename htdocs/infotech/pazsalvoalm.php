<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1058);

$vector0=explode("/",$_SERVER['HTTP_REFERER']);
$elementos0=count($vector0);
$ultimo=$elementos0-1;
$form0=$vector0[$ultimo];
	
require('fpdf/fpdf.php');
$pdf=new FPDF();

switch($form0){
case "documentosdotacion.php":
	
	switch($_SESSION[ord]):
	case "ceduladot":
	$or='dotacion.ceduladot';
	break;
	case "apellidos":
	$or='personalactivo.apellidos';
	break;
	case "codigo":
	$or='personalactivo.codigo, dotacion.ceduladot';
	break;
	endswitch;

$sql1="SELECT * FROM dotacion, personalactivo, clientes, productos WHERE ((dotacion.pazysalvo=0 OR dotacion.pazysalvo IS NULL)  AND dotacion.idprod=productos.id AND productos.tipoprod='1' AND personalactivo.cedula=dotacion.ceduladot AND personalactivo.codigo=clientes.codigo) AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY $or";
$resulta=@mysql_query($sql1);
$ini=1;
$lim=@mysql_num_rows($resulta);

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

$texto="PERSONAL SIN PAZ Y SALVO";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=58;
$y=32;
$pdf->Text($x,$y,$texto);

$texto="DE DOTACION Y ALMACEN";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=58;
$y=40;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=240;
$pdf->Setxy($x11,$y11);

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Setxy($x,$y);
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=80;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="CARNET";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=60;
$pdf->Text($x,$y,$texto);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$reg=0;

$y=60;

while($ini<=$lim){
if(@mysql_result($resulta,$ini,ceduladot)!=@mysql_result($resulta,$ini-1,ceduladot)){
$codbusca=recortarcadena(decod(@mysql_result($resulta,$ini-1,codigo)),20);
$nombre=decod(@mysql_result($resulta,$ini-1,apellidos). " ".@mysql_result($resulta,$ini-1,nombre));
$carnet=@mysql_result($resulta,$ini-1,carnetinterno);
$cedula=@mysql_result($resulta,$ini-1,ceduladot);


if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=80;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="CARNET";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=20;
$pdf->Text($x,$y,$texto);

$y=55;}


$texto1=$codbusca;
$pdf->SetFont('Arial','',7);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$cedula;
$pdf->SetFont('Arial','',10);   
$x=50;
$pdf->Text($x,$y,$texto2);

$texto3=$nombre ." " . $apellido;
$pdf->SetFont('Arial','',10);  
$x=80; 
$pdf->Text($x,$y,$texto3);

$texto4=$carnet;
$pdf->SetFont('Arial','',10);  
$x=180; 
$pdf->Text($x,$y,$texto4);


}$ini++;
}
break;
case "documentosdotacioncliente.php":
$sql1="SELECT * FROM dotacion, clientes, productos WHERE (dotacion.pazysalvo=0 OR dotacion.pazysalvo IS NULL)  AND dotacion.idprod=productos.id AND productos.tipoprod='1' AND clientes.codigo=dotacion.ceduladot AND clientes.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
$resulta=@mysql_query($sql1);
$ini=1;
$lim=@mysql_num_rows($resulta);

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

$texto="CLIENTES SIN PAZ Y SALVO";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=58;
$y=32;
$pdf->Text($x,$y,$texto);

$texto="DE DOTACION Y ALMACEN";
$pdf->SetFont('Arial','B',20);   
$pdf->Ln();
$x=58;
$y=40;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=240;
$pdf->Setxy($x11,$y11);

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=60;
$pdf->Setxy($x,$y);
$pdf->Text($x,$y,$texto);

$texto="NIT";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="NOMBRE CLIENTE";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=80;
$y=60;
$pdf->Text($x,$y,$texto);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$reg=0;

$y=60;

while($ini<=$lim){
if(@mysql_result($resulta,$ini,ceduladot)!=@mysql_result($resulta,$ini-1,ceduladot)){
$codigo=recortarcadena(decod(@mysql_result($resulta,$ini-1,codigo)),30);
$nombrecliente=recortarcadena(decod(@mysql_result($resulta,$ini-1,nombrecliente)), 30);
$nit=@mysql_result($resulta,$ini-1,nit);

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=20;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="CEDULA";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=50;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="APELLIDOS Y NOMBRES";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=80;
$y=20;
$pdf->Text($x,$y,$texto);

$texto="CARNET";
$pdf->SetFont('Arial','B',13);   
$pdf->Ln();
$x=180;
$y=20;
$pdf->Text($x,$y,$texto);

$y=55;}

$texto1=$codigo;
$pdf->SetFont('Arial','',7);  
$x=20; 
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nombrecliente;
$pdf->SetFont('Arial','',10);  
$x=80; 
$pdf->Text($x,$y,$texto2);

$texto4=$nit;
$pdf->SetFont('Arial','',10);  
$x=50; 
$pdf->Text($x,$y,$texto4);


}$ini++;
}	
	
break;
case "documentosdotacioninterna.php":
$sql1="SELECT * FROM dotacion, departamentos, productos WHERE (dotacion.pazysalvo=0 OR dotacion.pazysalvo IS NULL)  AND dotacion.idprod=productos.id AND productos.tipoprod='1' AND departamentos.codigo=dotacion.ceduladot AND departamentos.sucursal LIKE '$_SESSION[sucur]' ORDER BY $_SESSION[ord]";
$resulta=@mysql_query($sql1);
$ini=1;
$lim=@mysql_num_rows($resulta);

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

$texto="DEPARTAMENTOS SIN PAZ Y SALVO";
$pdf->SetFont('Arial','B',20);
$pdf->Ln();
$x=58;
$y=32;
$pdf->Text($x,$y,$texto);

$texto="DE DOTACION Y ALMACEN";
$pdf->SetFont('Arial','B',20);
$pdf->Ln();
$x=58;
$y=40;
$pdf->Text($x,$y,$texto);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$fecha=getdate(time());

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=240;
$pdf->Setxy($x11,$y11);

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=20;
$y=60;
$pdf->Setxy($x,$y);
$pdf->Text($x,$y,$texto);

$texto="NOMBRE DEPARTAMENTO";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="RESPONSABLE";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$reg=0;

$y=60;

while($ini<=$lim){
if(@mysql_result($resulta,$ini,ceduladot)!=@mysql_result($resulta,$ini-1,ceduladot)){
$codigo=recortarcadena(decod(@mysql_result($resulta,$ini-1,codigo)),30);
$nombredepto=recortarcadena(decod(@mysql_result($resulta,$ini-1,nombredepto)), 30);
$responsable=@mysql_result($resulta,$ini-1,responsable);

if($y==280){$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=285;
require('saludoslis.php');

$texto="CODIGO";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=20;
$y=60;
$pdf->Setxy($x,$y);
$pdf->Text($x,$y,$texto);

$texto="NOMBRE DEPARTAMENTO";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=50;
$y=60;
$pdf->Text($x,$y,$texto);

$texto="RESPONSABLE";
$pdf->SetFont('Arial','B',13);
$pdf->Ln();
$x=120;
$y=60;
$pdf->Text($x,$y,$texto);

$y=55;}

$texto1=$codigo;
$pdf->SetFont('Arial','',7);
$x=20;
$y=$y+5;
$pdf->Text($x,$y,$texto1);

$texto2=$nombredepto;
$pdf->SetFont('Arial','',10);
$x=50;
$pdf->Text($x,$y,$texto2);

$texto4=$responsable;
$pdf->SetFont('Arial','',10);
$x=120;
$pdf->Text($x,$y,$texto4);


}$ini++;
}

break;
}
$pdf->Output();

?>