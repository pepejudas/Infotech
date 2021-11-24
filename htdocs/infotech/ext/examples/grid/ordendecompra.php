<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1072);

require('fpdf/fpdf.php');
$pdf=new FPDF();

$vector0=explode("/",$_SERVER['HTTP_REFERER']);
$elementos0=count($vector0);
$form0=$vector0[$elementos0-1];

if($_GET['idotacion']!=""){
$_SESSION[iddota]=$_GET['idotacion'];
}
//die($_SESSION[iddota]." ".$_GET['idotacion']);
switch($form0){
	case "documentosdotacioncliente.php";
       case "dotacioncliente.php":
	$pdf->AddPage();
	$sqli="SELECT * FROM dotacion, clientes, productos WHERE dotacion.iddot='$_SESSION[iddota]' AND dotacion.ceduladot = clientes.codigo AND dotacion.idprod=productos.id ORDER BY nombreprod";
	$cons=@mysql_query($sqli);
	$codigo=recortarcadena(@mysql_result($cons,0,ceduladot),30);
	$nombrecliente=recortarcadena(decod(@mysql_result($cons,0,nombrecliente)),30);
	$nombreadministrador=recortarcadena(decod(@mysql_result($cons,0,nombreadministrador)),30);
	$fechaini=@mysql_result($cons,0,fechainiciocontrato);
	$iddot=@mysql_result($cons,0,'iddot');
	$fecha1=getdate(time());
	$fecha2=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday];
	$inic=0;
	$limp=@mysql_num_rows($cons);

	$pdf->SetFont('Arial','B',18);
	$pdf->Ln();
	$file="imagenes/super10.jpg";
	$x=27;
	$y=26;
	$pdf->Image($file,$x,$y,$w=27,$h=27);
	$pdf->Ln();
	$x=20;
	$y=25;
	$w=170;
	$h=30;
	$pdf->SetLineWidth(0.3);
	$pdf->Rect($x,$y,$w,$h);
	$x1=60;
	$y1=25;
	$x2=60;
	$y2=55;
	$pdf->Line($x1,$y1,$x2,$y2);
	$x1=150;
	$y1=25;
	$x2=150;
	$y2=55;
	$pdf->Line($x1,$y1,$x2,$y2);
	$x1=60;
	$y1=45;
	$x2=190;
	$y2=45;
	$pdf->Line($x1,$y1,$x2,$y2);
	$x1=150;
	$x2=190;
	$y1=35;
	$y2=35;
	$pdf->Line($x1,$y1,$x2,$y2);

	$texto=$codigo;
	$pdf->SetFont('Arial','',10);
	$x=37;
	$y=74;
	$pdf->Text($x,$y,$texto);

	$texto=$nombrecliente;
	$pdf->SetFont('Arial','',8);
	$x=37;
	$y=68;
	$pdf->Text($x,$y,$texto);

	$texto=$nombreadministrador;
	$pdf->SetFont('Arial','',8);
	$x=133;
	$y=68;
	$pdf->Text($x,$y,$texto);

	$texto=$fechaini;
	$pdf->SetFont('Arial','',10);
	$x=147;
	$y=74;
	$pdf->Text($x,$y,$texto);

	$texto=$iddot;
	$pdf->SetFont('Arial','',10);
	$x=158;
	$y=61.5;
	$pdf->Text($x,$y,$texto);


	$texto="        ENTREGA DE DOTACION
		   ";

	$pdf->SetFont('Arial','B',14);
	$pdf->Ln();
	$w=176;
	$h=6;
	$y=30;
	$pdf->Sety($y);
	$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Text(152,30,"FECHA APROBACION");
	$pdf->Text(152,33,"");
	$pdf->Text(152,41,"CODIGO: ");
	$pdf->Text(152,51,"VERSION:00");
	$y=46;
	$pdf->Sety($y);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();

	$texto2="CLIENTE_____________________________";
	$pdf->SetFont('Arial','',10);
	$x=20;
	$y=65;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="CODIGO__________________________";
	$pdf->SetFont('Arial','',10);
	$x=20;
	$y=70;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="ADMINISTRADOR______________________________";
	$pdf->SetFont('Arial','',10);
	$x=100;
	$y=65;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="FECHA INICIO CONTRATO_______________________";
	$pdf->SetFont('Arial','',10);
	$x=100;
	$y=70;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="No";
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=57;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

	$texto="FECHA Y HORA";
	$pdf->SetFont('Arial','',10);
	$x=22;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="CANTIDAD";
	$pdf->SetFont('Arial','',10);
	$x=51;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="DESCRIPCION";
	$pdf->SetFont('Arial','',10);
	$x=95;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="FIRMA";
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="OBSERVACIONES";
	$pdf->SetFont('Arial','',7);
	$x=167;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$x=20;
	$y=90;
	$w=170;
	$h=195;
	$pdf->SetLineWidth(0.3);
	$pdf->Rect($x,$y,$w,$h);

	//lineas horizontales
	$x1=20;
	$y1=95;
	$x2=190;
	$y2=95;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=105;
	$x2=190;
	$y2=105;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=115;
	$x2=190;
	$y2=115;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=125;
	$x2=190;
	$y2=125;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=135;
	$x2=190;
	$y2=135;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=145;
	$x2=190;
	$y2=145;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=155;
	$x2=190;
	$y2=155;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=165;
	$x2=190;
	$y2=165;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=175;
	$x2=190;
	$y2=175;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=185;
	$x2=190;
	$y2=185;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=195;
	$x2=190;
	$y2=195;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=205;
	$x2=190;
	$y2=205;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=215;
	$x2=190;
	$y2=215;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=225;
	$x2=190;
	$y2=225;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=235;
	$x2=190;
	$y2=235;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=245;
	$x2=190;
	$y2=245;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=255;
	$x2=190;
	$y2=255;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=265;
	$x2=190;
	$y2=265;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=275;
	$x2=190;
	$y2=275;
	$pdf->Line($x1,$y1,$x2,$y2);

	//lineas verticales

	$x1=50;
	$y1=90;
	$x2=50;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=70;
	$y1=90;
	$x2=70;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=145;
	$y1=90;
	$x2=145;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=165;
	$y1=90;
	$x2=165;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$y=92;

	for($inic=0;$inic<$limp;$inic++){
		$y+=10;
		$obnou="";
		$cantidad=@mysql_result($cons,$inic,cantidad);
		$producto=recortarcadena(decod(@mysql_result($cons,$inic,nombreprod)),30);
		$fecha1=@mysql_result($cons,$inic,fechaent);
		$nou=@mysql_result($cons,$inic,nou);

		if($nou==1){$obnou="Nuevo";}
		if($nou==2){$obnou="Usado";}


		$texto=$cantidad;
		$pdf->SetFont('Arial','',15);
		$x=52;
		$pdf->Text($x,$y,$texto);

		$texto=$producto;
		$pdf->SetFont('Arial','',10);
		$x=72;
		$pdf->Text($x,$y,$texto);

		$texto=$obnou;
		$pdf->SetFont('Arial','',8);
		$x=167;
		$pdf->Text($x,$y,$texto);

		$texto=$fecha1;
		$pdf->SetFont('Arial','',8.4);
		$x=21;
		$pdf->Text($x,$y,$texto);

		if($y>=275){
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',18);
			$pdf->Ln();
			$file="imagenes/super10.jpg";
			$x=27;
			$y=26;
			$pdf->Image($file,$x,$y,$w=27,$h=27);
			$pdf->Ln();
			$x=20;
			$y=25;
			$w=170;
			$h=30;
			$pdf->SetLineWidth(0.3);
			$pdf->Rect($x,$y,$w,$h);
			$x1=60;
			$y1=25;
			$x2=60;
			$y2=55;
			$pdf->Line($x1,$y1,$x2,$y2);
			$x1=150;
			$y1=25;
			$x2=150;
			$y2=55;
			$pdf->Line($x1,$y1,$x2,$y2);
			$x1=60;
			$y1=45;
			$x2=190;
			$y2=45;
			$pdf->Line($x1,$y1,$x2,$y2);
			$x1=150;
			$x2=190;
			$y1=35;
			$y2=35;
			$pdf->Line($x1,$y1,$x2,$y2);

			$texto=$cedula;
			$pdf->SetFont('Arial','',10);
			$x=50;
			$y=74;
			$pdf->Text($x,$y,$texto);

			$texto=$apellido;
			$pdf->SetFont('Arial','',10);
			$x=43;
			$y=68;
			$pdf->Text($x,$y,$texto);

			$texto=$nombre;
			$pdf->SetFont('Arial','',10);
			$x=123;
			$y=68;
			$pdf->Text($x,$y,$texto);

			$texto=$fechaini." aaaa-mm-dd";
			$pdf->SetFont('Arial','',10);
			$x=147;
			$y=74;
			$pdf->Text($x,$y,$texto);

			$texto=$id;
			$pdf->SetFont('Arial','',10);
			$x=158;
			$y=61.5;
			$pdf->Text($x,$y,$texto);


			$texto="        ENTREGA DE DOTACION
		   ";

			$pdf->SetFont('Arial','B',14);
			$pdf->Ln();
			$w=176;
			$h=6;
			$y=30;
			$pdf->Sety($y);
			$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
			$pdf->SetFont('Arial','B',10);
			$pdf->Text(152,30,"FECHA APROBACION");
			$pdf->Text(152,33,"");
			$pdf->Text(152,41,"CODIGO: ");
			$pdf->Text(152,51,"VERSION:00");
			$y=46;
			$pdf->Sety($y);
			$pdf->SetFont('Arial','B',10);
			$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Ln();

			$texto2="APELLIDOS_____________________________";
			$pdf->SetFont('Arial','',10);
			$x=20;
			$y=65;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="No DE CEDULA__________________________";
			$pdf->SetFont('Arial','',10);
			$x=20;
			$y=70;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="NOMBRES____________________________________";
			$pdf->SetFont('Arial','',10);
			$x=100;
			$y=65;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="FECHA INICIO CONTRATO_______________________";
			$pdf->SetFont('Arial','',10);
			$x=100;
			$y=70;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="No";
			$pdf->SetFont('Arial','',10);
			$x=150;
			$y=57;
			$w=40;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

			$texto="FECHA Y HORA";
			$pdf->SetFont('Arial','',10);
			$x=22;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="CANTIDAD";
			$pdf->SetFont('Arial','',10);
			$x=51;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="DESCRIPCION";
			$pdf->SetFont('Arial','',10);
			$x=95;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="FIRMA";
			$pdf->SetFont('Arial','',10);
			$x=150;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="OBSERVACIONES";
			$pdf->SetFont('Arial','',7);
			$x=167;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$x=20;
			$y=90;
			$w=170;
			$h=195;
			$pdf->SetLineWidth(0.3);
			$pdf->Rect($x,$y,$w,$h);

			//lineas horizontales
			$x1=20;
			$y1=95;
			$x2=190;
			$y2=95;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=105;
			$x2=190;
			$y2=105;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=115;
			$x2=190;
			$y2=115;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=125;
			$x2=190;
			$y2=125;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=135;
			$x2=190;
			$y2=135;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=145;
			$x2=190;
			$y2=145;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=155;
			$x2=190;
			$y2=155;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=165;
			$x2=190;
			$y2=165;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=175;
			$x2=190;
			$y2=175;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=185;
			$x2=190;
			$y2=185;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=195;
			$x2=190;
			$y2=195;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=205;
			$x2=190;
			$y2=205;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=215;
			$x2=190;
			$y2=215;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=225;
			$x2=190;
			$y2=225;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=235;
			$x2=190;
			$y2=235;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=245;
			$x2=190;
			$y2=245;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=255;
			$x2=190;
			$y2=255;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=265;
			$x2=190;
			$y2=265;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=275;
			$x2=190;
			$y2=275;
			$pdf->Line($x1,$y1,$x2,$y2);

			//lineas verticales

			$x1=50;
			$y1=90;
			$x2=50;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=70;
			$y1=90;
			$x2=70;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=145;
			$y1=90;
			$x2=145;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=165;
			$y1=90;
			$x2=165;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$y=92;
		}


	}

	break;
	case "documentosdotacion.php";
        case "dotacion.php";
	$pdf->AddPage();
	$sqli="SELECT * FROM dotacion, personalactivo, productos WHERE dotacion.iddot=$_SESSION[iddota] AND dotacion.ceduladot = personalactivo.cedula AND dotacion.idprod=productos.id  ORDER BY nombreprod";
	$cons=@mysql_query($sqli);
	$cedula=@mysql_result($cons,0,ceduladot);
	$apellido=recortarcadena(decod(@mysql_result($cons,0,apellidos)),20);
	$nombre=recortarcadena(decod(@mysql_result($cons,0,nombre)), 20);
	$fechaini=@mysql_result($cons,0,fechaingreso);
	$id=@mysql_result($cons,0,'iddot');

	$fecha1=getdate(time());
	$fecha2=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday];
	$inic=0;
	$limp=@mysql_num_rows($cons);

	$pdf->SetFont('Arial','B',18);
	$pdf->Ln();
	$file="imagenes/super10.jpg";
	$x=27;
	$y=26;
	$pdf->Image($file,$x,$y,$w=27,$h=27);
	$pdf->Ln();
	$x=20;
	$y=25;
	$w=170;
	$h=30;
	$pdf->SetLineWidth(0.3);
	$pdf->Rect($x,$y,$w,$h);
	$x1=60;
	$y1=25;
	$x2=60;
	$y2=55;
	$pdf->Line($x1,$y1,$x2,$y2);
	$x1=150;
	$y1=25;
	$x2=150;
	$y2=55;
	$pdf->Line($x1,$y1,$x2,$y2);
	$x1=60;
	$y1=45;
	$x2=190;
	$y2=45;
	$pdf->Line($x1,$y1,$x2,$y2);
	$x1=150;
	$x2=190;
	$y1=35;
	$y2=35;
	$pdf->Line($x1,$y1,$x2,$y2);

	$texto=$cedula;
	$pdf->SetFont('Arial','',10);
	$x=50;
	$y=74;
	$pdf->Text($x,$y,$texto);

	$texto=$apellido;
	$pdf->SetFont('Arial','',10);
	$x=43;
	$y=68;
	$pdf->Text($x,$y,$texto);

	$texto=$nombre;
	$pdf->SetFont('Arial','',10);
	$x=123;
	$y=68;
	$pdf->Text($x,$y,$texto);

	$texto=$fechaini." aaaa-mm-dd";
	$pdf->SetFont('Arial','',10);
	$x=147;
	$y=74;
	$pdf->Text($x,$y,$texto);

	$texto=$id;
	$pdf->SetFont('Arial','',10);
	$x=158;
	$y=61.5;
	$pdf->Text($x,$y,$texto);


	$texto="        ENTREGA DE DOTACION
		   ";

	$pdf->SetFont('Arial','B',14);
	$pdf->Ln();
	$w=176;
	$h=6;
	$y=30;
	$pdf->Sety($y);
	$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Text(152,30,"FECHA APROBACION");
	$pdf->Text(152,33,"");
	$pdf->Text(152,41,"CODIGO: ");
	$pdf->Text(152,51,"VERSION:00");
	$y=46;
	$pdf->Sety($y);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();

	$texto2="APELLIDOS_____________________________";
	$pdf->SetFont('Arial','',10);
	$x=20;
	$y=65;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="No DE CEDULA__________________________";
	$pdf->SetFont('Arial','',10);
	$x=20;
	$y=70;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="NOMBRES____________________________________";
	$pdf->SetFont('Arial','',10);
	$x=100;
	$y=65;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="FECHA INICIO CONTRATO_______________________";
	$pdf->SetFont('Arial','',10);
	$x=100;
	$y=70;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="No";
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=57;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

	$texto="FECHA Y HORA";
	$pdf->SetFont('Arial','',10);
	$x=22;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="CANTIDAD";
	$pdf->SetFont('Arial','',10);
	$x=51;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="DESCRIPCION";
	$pdf->SetFont('Arial','',10);
	$x=95;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="FIRMA";
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="OBSERVACIONES";
	$pdf->SetFont('Arial','',7);
	$x=167;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$x=20;
	$y=90;
	$w=170;
	$h=195;
	$pdf->SetLineWidth(0.3);
	$pdf->Rect($x,$y,$w,$h);

	//lineas horizontales
	$x1=20;
	$y1=95;
	$x2=190;
	$y2=95;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=105;
	$x2=190;
	$y2=105;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=115;
	$x2=190;
	$y2=115;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=125;
	$x2=190;
	$y2=125;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=135;
	$x2=190;
	$y2=135;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=145;
	$x2=190;
	$y2=145;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=155;
	$x2=190;
	$y2=155;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=165;
	$x2=190;
	$y2=165;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=175;
	$x2=190;
	$y2=175;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=185;
	$x2=190;
	$y2=185;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=195;
	$x2=190;
	$y2=195;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=205;
	$x2=190;
	$y2=205;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=215;
	$x2=190;
	$y2=215;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=225;
	$x2=190;
	$y2=225;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=235;
	$x2=190;
	$y2=235;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=245;
	$x2=190;
	$y2=245;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=255;
	$x2=190;
	$y2=255;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=265;
	$x2=190;
	$y2=265;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=275;
	$x2=190;
	$y2=275;
	$pdf->Line($x1,$y1,$x2,$y2);

	//lineas verticales

	$x1=50;
	$y1=90;
	$x2=50;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=70;
	$y1=90;
	$x2=70;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=145;
	$y1=90;
	$x2=145;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=165;
	$y1=90;
	$x2=165;
	$y2=285;
	$pdf->Line($x1,$y1,$x2,$y2);

	$y=92;

	for($inic=0;$inic<$limp;$inic++){
		$y+=10;
		$obnou="";
		$cantidad=@mysql_result($cons,$inic,cantidad);
		$producto=recortarcadena(decod(@mysql_result($cons,$inic,nombreprod)), 30);
		$fecha1=@mysql_result($cons,$inic,fechaent);
		$nou=@mysql_result($cons,$inic,nou);

		if($nou==1){$obnou="Nuevo";}
		if($nou==2){$obnou="Usado";}


		$texto=$cantidad;
		$pdf->SetFont('Arial','',15);
		$x=52;
		$pdf->Text($x,$y,$texto);

		$texto=$producto;
		$pdf->SetFont('Arial','',10);
		$x=72;
		$pdf->Text($x,$y,$texto);

		$texto=$obnou;
		$pdf->SetFont('Arial','',8);
		$x=167;
		$pdf->Text($x,$y,$texto);

		$texto=$fecha1;
		$pdf->SetFont('Arial','',8.4);
		$x=21;
		$pdf->Text($x,$y,$texto);

		if($y>=275){
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',18);
			$pdf->Ln();
			$file="imagenes/super10.jpg";
			$x=27;
			$y=26;
			$pdf->Image($file,$x,$y,$w=27,$h=27);
			$pdf->Ln();
			$x=20;
			$y=25;
			$w=170;
			$h=30;
			$pdf->SetLineWidth(0.3);
			$pdf->Rect($x,$y,$w,$h);
			$x1=60;
			$y1=25;
			$x2=60;
			$y2=55;
			$pdf->Line($x1,$y1,$x2,$y2);
			$x1=150;
			$y1=25;
			$x2=150;
			$y2=55;
			$pdf->Line($x1,$y1,$x2,$y2);
			$x1=60;
			$y1=45;
			$x2=190;
			$y2=45;
			$pdf->Line($x1,$y1,$x2,$y2);
			$x1=150;
			$x2=190;
			$y1=35;
			$y2=35;
			$pdf->Line($x1,$y1,$x2,$y2);

			$texto=$cedula;
			$pdf->SetFont('Arial','',10);
			$x=50;
			$y=74;
			$pdf->Text($x,$y,$texto);

			$texto=$apellido;
			$pdf->SetFont('Arial','',10);
			$x=43;
			$y=68;
			$pdf->Text($x,$y,$texto);

			$texto=$nombre;
			$pdf->SetFont('Arial','',10);
			$x=123;
			$y=68;
			$pdf->Text($x,$y,$texto);

			$texto=$fechaini." aaaa-mm-dd";
			$pdf->SetFont('Arial','',10);
			$x=147;
			$y=74;
			$pdf->Text($x,$y,$texto);

			$texto=$id;
			$pdf->SetFont('Arial','',10);
			$x=158;
			$y=61.5;
			$pdf->Text($x,$y,$texto);


			$texto="        ENTREGA DE DOTACION
		   ";

			$pdf->SetFont('Arial','B',14);
			$pdf->Ln();
			$w=176;
			$h=6;
			$y=30;
			$pdf->Sety($y);
			$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
			$pdf->SetFont('Arial','B',10);
			$pdf->Text(152,30,"FECHA APROBACION");
			$pdf->Text(152,33,"");
			$pdf->Text(152,41,"CODIGO: ");
			$pdf->Text(152,51,"VERSION:00");
			$y=46;
			$pdf->Sety($y);
			$pdf->SetFont('Arial','B',10);
			$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Ln();
			$pdf->Ln();

			$texto2="APELLIDOS_____________________________";
			$pdf->SetFont('Arial','',10);
			$x=20;
			$y=65;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="No DE CEDULA__________________________";
			$pdf->SetFont('Arial','',10);
			$x=20;
			$y=70;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="NOMBRES____________________________________";
			$pdf->SetFont('Arial','',10);
			$x=100;
			$y=65;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="FECHA INICIO CONTRATO_______________________";
			$pdf->SetFont('Arial','',10);
			$x=100;
			$y=70;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

			$texto2="No";
			$pdf->SetFont('Arial','',10);
			$x=150;
			$y=57;
			$w=40;
			$pdf->Setxy($x,$y);
			$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

			$texto="FECHA Y HORA";
			$pdf->SetFont('Arial','',10);
			$x=22;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="CANTIDAD";
			$pdf->SetFont('Arial','',10);
			$x=51;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="DESCRIPCION";
			$pdf->SetFont('Arial','',10);
			$x=95;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="FIRMA";
			$pdf->SetFont('Arial','',10);
			$x=150;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$texto="OBSERVACIONES";
			$pdf->SetFont('Arial','',7);
			$x=167;
			$y=94;
			$pdf->Text($x,$y,$texto);

			$x=20;
			$y=90;
			$w=170;
			$h=195;
			$pdf->SetLineWidth(0.3);
			$pdf->Rect($x,$y,$w,$h);

			//lineas horizontales
			$x1=20;
			$y1=95;
			$x2=190;
			$y2=95;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=105;
			$x2=190;
			$y2=105;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=115;
			$x2=190;
			$y2=115;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=125;
			$x2=190;
			$y2=125;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=135;
			$x2=190;
			$y2=135;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=145;
			$x2=190;
			$y2=145;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=155;
			$x2=190;
			$y2=155;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=165;
			$x2=190;
			$y2=165;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=175;
			$x2=190;
			$y2=175;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=185;
			$x2=190;
			$y2=185;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=195;
			$x2=190;
			$y2=195;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=205;
			$x2=190;
			$y2=205;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=215;
			$x2=190;
			$y2=215;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=225;
			$x2=190;
			$y2=225;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=235;
			$x2=190;
			$y2=235;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=245;
			$x2=190;
			$y2=245;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=255;
			$x2=190;
			$y2=255;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=265;
			$x2=190;
			$y2=265;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=20;
			$y1=275;
			$x2=190;
			$y2=275;
			$pdf->Line($x1,$y1,$x2,$y2);

			//lineas verticales

			$x1=50;
			$y1=90;
			$x2=50;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=70;
			$y1=90;
			$x2=70;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=145;
			$y1=90;
			$x2=145;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$x1=165;
			$y1=90;
			$x2=165;
			$y2=285;
			$pdf->Line($x1,$y1,$x2,$y2);

			$y=92;


		}

	}
	break;
	case "documentosdotacioninterna.php":
        case "dotacioninterna.php";

		$pdf->AddPage();
		$sqli="SELECT * FROM dotacion, departamentos, productos WHERE dotacion.iddot=$_SESSION[iddota] AND dotacion.ceduladot = departamentos.codigo AND dotacion.idprod=productos.id  ORDER BY nombreprod";

		$cons=@mysql_query($sqli);
		$codigo=recortarcadena(@mysql_result($cons,0,ceduladot),20);
		$nombredepto=recortarcadena(decod(@mysql_result($cons,0,departamento)),70);
		$responsable=recortarcadena(decod(@mysql_result($cons,0,responsable)),20);
		$id=@mysql_result($cons,0,'iddot');

		$fecha1=getdate(time());
		$fecha2=$fecha1[year]."-".$fecha1[mon]."-".$fecha1[mday];
		$inic=0;
		$limp=@mysql_num_rows($cons);

		$pdf->SetFont('Arial','B',18);
		$pdf->Ln();
		$file="imagenes/super10.jpg";
		$x=27;
		$y=26;
		$pdf->Image($file,$x,$y,$w=27,$h=27);
		$pdf->Ln();
		$x=20;
		$y=25;
		$w=170;
		$h=30;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);
		$x1=60;
		$y1=25;
		$x2=60;
		$y2=55;
		$pdf->Line($x1,$y1,$x2,$y2);
		$x1=150;
		$y1=25;
		$x2=150;
		$y2=55;
		$pdf->Line($x1,$y1,$x2,$y2);
		$x1=60;
		$y1=45;
		$x2=190;
		$y2=45;
		$pdf->Line($x1,$y1,$x2,$y2);
		$x1=150;
		$x2=190;
		$y1=35;
		$y2=35;
		$pdf->Line($x1,$y1,$x2,$y2);

		$texto=$codigo;
		$pdf->SetFont('Arial','',10);
		$x=40;
		$y=74;
		$pdf->Text($x,$y,$texto);

		$texto=$nombredepto;
		$pdf->SetFont('Arial','',10);
		$x=70;
		$y=68;
		$pdf->Text($x,$y,$texto);

		$texto=$responsable;
		$pdf->SetFont('Arial','',10);
		$x=130;
		$y=74;
		$pdf->Text($x,$y,$texto);

		$texto=$id;
		$pdf->SetFont('Arial','',10);
		$x=158;
		$y=61.5;
		$pdf->Text($x,$y,$texto);


		$texto="        ENTREGA DE DOTACION
		   ";

		$pdf->SetFont('Arial','B',14);
		$pdf->Ln();
		$w=176;
		$h=6;
		$y=30;
		$pdf->Sety($y);
		$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(152,30,"FECHA APROBACION");
		$pdf->Text(152,33,"");
		$pdf->Text(152,41,"CODIGO: ");
		$pdf->Text(152,51,"VERSION:00");
		$y=46;
		$pdf->Sety($y);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();

		$texto2="NOMBRE DEPARTAMENTO______________________________________________________";
		$pdf->SetFont('Arial','',10);
		$x=20;
		$y=65;
		$pdf->Setxy($x,$y);
		$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

		$texto2="CODIGO_________________________";
		$pdf->SetFont('Arial','',10);
		$x=20;
		$y=70;
		$pdf->Setxy($x,$y);
		$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

		$texto2="RESPONSABLE_______________________";
		$pdf->SetFont('Arial','',10);
		$x=100;
		$y=70;
		$pdf->Setxy($x,$y);
		$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

		$texto2="No";
		$pdf->SetFont('Arial','',10);
		$x=150;
		$y=57;
		$w=40;
		$pdf->Setxy($x,$y);
		$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

		$texto="FECHA Y HORA";
		$pdf->SetFont('Arial','',10);
		$x=22;
		$y=94;
		$pdf->Text($x,$y,$texto);

		$texto="CANTIDAD";
		$pdf->SetFont('Arial','',10);
		$x=51;
		$y=94;
		$pdf->Text($x,$y,$texto);

		$texto="DESCRIPCION";
		$pdf->SetFont('Arial','',10);
		$x=95;
		$y=94;
		$pdf->Text($x,$y,$texto);

		$texto="FIRMA";
		$pdf->SetFont('Arial','',10);
		$x=150;
		$y=94;
		$pdf->Text($x,$y,$texto);

		$texto="OBSERVACIONES";
		$pdf->SetFont('Arial','',7);
		$x=167;
		$y=94;
		$pdf->Text($x,$y,$texto);

		$x=20;
		$y=90;
		$w=170;
		$h=195;
		$pdf->SetLineWidth(0.3);
		$pdf->Rect($x,$y,$w,$h);

		//lineas horizontales
		$x1=20;
		$y1=95;
		$x2=190;
		$y2=95;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=105;
		$x2=190;
		$y2=105;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=115;
		$x2=190;
		$y2=115;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=125;
		$x2=190;
		$y2=125;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=135;
		$x2=190;
		$y2=135;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=145;
		$x2=190;
		$y2=145;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=155;
		$x2=190;
		$y2=155;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=165;
		$x2=190;
		$y2=165;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=175;
		$x2=190;
		$y2=175;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=185;
		$x2=190;
		$y2=185;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=195;
		$x2=190;
		$y2=195;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=205;
		$x2=190;
		$y2=205;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=215;
		$x2=190;
		$y2=215;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=225;
		$x2=190;
		$y2=225;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=235;
		$x2=190;
		$y2=235;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=245;
		$x2=190;
		$y2=245;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=255;
		$x2=190;
		$y2=255;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=265;
		$x2=190;
		$y2=265;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=20;
		$y1=275;
		$x2=190;
		$y2=275;
		$pdf->Line($x1,$y1,$x2,$y2);

		//lineas verticales

		$x1=50;
		$y1=90;
		$x2=50;
		$y2=285;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=70;
		$y1=90;
		$x2=70;
		$y2=285;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=145;
		$y1=90;
		$x2=145;
		$y2=285;
		$pdf->Line($x1,$y1,$x2,$y2);

		$x1=165;
		$y1=90;
		$x2=165;
		$y2=285;
		$pdf->Line($x1,$y1,$x2,$y2);

		$y=92;

		for($inic=0;$inic<$limp;$inic++){
			$y+=10;
			$obnou="";
			$cantidad=@mysql_result($cons,$inic,cantidad);
			$producto=decod(@mysql_result($cons,$inic,nombreprod));
			$fecha1=@mysql_result($cons,$inic,fechaent);
			$nou=@mysql_result($cons,$inic,nou);

			if($nou==1){$obnou="Nuevo";}
			if($nou==2){$obnou="Usado";}


			$texto=$cantidad;
			$pdf->SetFont('Arial','',15);
			$x=52;
			$pdf->Text($x,$y,$texto);

			$texto=$producto;
			$pdf->SetFont('Arial','',15);
			$x=72;
			$pdf->Text($x,$y,$texto);

			$texto=$obnou;
			$pdf->SetFont('Arial','',8);
			$x=167;
			$pdf->Text($x,$y,$texto);

			$texto=$fecha1;
			$pdf->SetFont('Arial','',8.4);
			$x=21;
			$pdf->Text($x,$y,$texto);

			if($y>=275){
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',18);
				$pdf->Ln();
				$file="imagenes/super10.jpg";
				$x=27;
				$y=26;
				$pdf->Image($file,$x,$y,$w=27,$h=27);
				$pdf->Ln();
				$x=20;
				$y=25;
				$w=170;
				$h=30;
				$pdf->SetLineWidth(0.3);
				$pdf->Rect($x,$y,$w,$h);
				$x1=60;
				$y1=25;
				$x2=60;
				$y2=55;
				$pdf->Line($x1,$y1,$x2,$y2);
				$x1=150;
				$y1=25;
				$x2=150;
				$y2=55;
				$pdf->Line($x1,$y1,$x2,$y2);
				$x1=60;
				$y1=45;
				$x2=190;
				$y2=45;
				$pdf->Line($x1,$y1,$x2,$y2);
				$x1=150;
				$x2=190;
				$y1=35;
				$y2=35;
				$pdf->Line($x1,$y1,$x2,$y2);

				$texto=$cedula;
				$pdf->SetFont('Arial','',10);
				$x=50;
				$y=74;
				$pdf->Text($x,$y,$texto);

				$texto=$apellido;
				$pdf->SetFont('Arial','',10);
				$x=43;
				$y=68;
				$pdf->Text($x,$y,$texto);

				$texto=$nombre;
				$pdf->SetFont('Arial','',10);
				$x=123;
				$y=68;
				$pdf->Text($x,$y,$texto);

				$texto=$fechaini." aaaa-mm-dd";
				$pdf->SetFont('Arial','',10);
				$x=147;
				$y=74;
				$pdf->Text($x,$y,$texto);

				$texto=$id;
				$pdf->SetFont('Arial','',10);
				$x=158;
				$y=61.5;
				$pdf->Text($x,$y,$texto);


				$texto="        ENTREGA DE DOTACION
		   ";

				$pdf->SetFont('Arial','B',14);
				$pdf->Ln();
				$w=176;
				$h=6;
				$y=30;
				$pdf->Sety($y);
				$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
				$pdf->SetFont('Arial','B',10);
				$pdf->Text(152,30,"FECHA APROBACION");
				$pdf->Text(152,33,"");
				$pdf->Text(152,41,"CODIGO: ");
				$pdf->Text(152,51,"VERSION:00");
				$y=46;
				$pdf->Sety($y);
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell($w,$h,"FORMATO",$border=0,$align='C',$fill=0);
				$pdf->Ln();
				$pdf->Ln();
				$pdf->Ln();
				$pdf->Ln();

				$texto2="APELLIDOS_____________________________";
				$pdf->SetFont('Arial','',10);
				$x=20;
				$y=65;
				$pdf->Setxy($x,$y);
				$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

				$texto2="No DE CEDULA__________________________";
				$pdf->SetFont('Arial','',10);
				$x=20;
				$y=70;
				$pdf->Setxy($x,$y);
				$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

				$texto2="NOMBRES____________________________________";
				$pdf->SetFont('Arial','',10);
				$x=100;
				$y=65;
				$pdf->Setxy($x,$y);
				$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

				$texto2="FECHA INICIO CONTRATO_______________________";
				$pdf->SetFont('Arial','',10);
				$x=100;
				$y=70;
				$pdf->Setxy($x,$y);
				$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

				$texto2="No";
				$pdf->SetFont('Arial','',10);
				$x=150;
				$y=57;
				$w=40;
				$pdf->Setxy($x,$y);
				$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

				$texto="FECHA Y HORA";
				$pdf->SetFont('Arial','',10);
				$x=22;
				$y=94;
				$pdf->Text($x,$y,$texto);

				$texto="CANTIDAD";
				$pdf->SetFont('Arial','',10);
				$x=51;
				$y=94;
				$pdf->Text($x,$y,$texto);

				$texto="DESCRIPCION";
				$pdf->SetFont('Arial','',10);
				$x=95;
				$y=94;
				$pdf->Text($x,$y,$texto);

				$texto="FIRMA";
				$pdf->SetFont('Arial','',10);
				$x=150;
				$y=94;
				$pdf->Text($x,$y,$texto);

				$texto="OBSERVACIONES";
				$pdf->SetFont('Arial','',7);
				$x=167;
				$y=94;
				$pdf->Text($x,$y,$texto);

				$x=20;
				$y=90;
				$w=170;
				$h=195;
				$pdf->SetLineWidth(0.3);
				$pdf->Rect($x,$y,$w,$h);

				//lineas horizontales
				$x1=20;
				$y1=95;
				$x2=190;
				$y2=95;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=105;
				$x2=190;
				$y2=105;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=115;
				$x2=190;
				$y2=115;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=125;
				$x2=190;
				$y2=125;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=135;
				$x2=190;
				$y2=135;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=145;
				$x2=190;
				$y2=145;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=155;
				$x2=190;
				$y2=155;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=165;
				$x2=190;
				$y2=165;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=175;
				$x2=190;
				$y2=175;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=185;
				$x2=190;
				$y2=185;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=195;
				$x2=190;
				$y2=195;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=205;
				$x2=190;
				$y2=205;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=215;
				$x2=190;
				$y2=215;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=225;
				$x2=190;
				$y2=225;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=235;
				$x2=190;
				$y2=235;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=245;
				$x2=190;
				$y2=245;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=255;
				$x2=190;
				$y2=255;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=265;
				$x2=190;
				$y2=265;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=20;
				$y1=275;
				$x2=190;
				$y2=275;
				$pdf->Line($x1,$y1,$x2,$y2);

				//lineas verticales

				$x1=50;
				$y1=90;
				$x2=50;
				$y2=285;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=70;
				$y1=90;
				$x2=70;
				$y2=285;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=145;
				$y1=90;
				$x2=145;
				$y2=285;
				$pdf->Line($x1,$y1,$x2,$y2);

				$x1=165;
				$y1=90;
				$x2=165;
				$y2=285;
				$pdf->Line($x1,$y1,$x2,$y2);

				$y=92;


			}

		}

		break;


}
/*
 while (list($name, $value) = each($HTTP_POST_VARS)) { echo "<p align='center'> POST $name = $value<br>\n</p>";
 }

 while (list($name, $value) = each($HTTP_SESSION_VARS)) { echo "<p align='center'> SESSION $name = $value<br>\n</p>";
 }
 */

$pdf->Output();
?>

