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

if($_GET['cedulamod']!=""){
$_SESSION[iddota]=$_GET['cedulamod'];
}
//die($_SESSION[iddota]." ".$_GET['idotacion']);
function ponerFormato($pdf, $datos){
    $pdf->SetFont('Arial','B',18);
	$pdf->Ln();
	$file="imagenes/super10.jpg";
	$x=83;
	$y=10;
	$pdf->Image($file,$x,$y,$w=27,$h=27);
	$pdf->Ln();
	$x=20;
	$y=40;
	$w=127;
	$h=30;
	$pdf->SetLineWidth(0.3);
	$pdf->Rect($x,$y,$w,$h);
	$x1=20;
	$y1=45;
	$x2=147;
	$y2=45;
	$pdf->Line($x1,$y1,$x2,$y2);

	$texto=$datos[nombreprov];
	$pdf->SetFont('Arial','',10);
	$x=37;
	$y=48;
	$pdf->Text($x,$y,$texto);

	$texto=$datos[direccion];
	$x=37;
	$y=54;
	$pdf->Text($x,$y,$texto);

	$texto=$datos[ciudad];
	$pdf->SetFont('Arial','',8);
	$x=37;
	$y=60;
	$pdf->Text($x,$y,$texto);

        $texto=$datos[nitprovee];
	$pdf->SetFont('Arial','',8);
	$x=37;
	$y=66;
	$pdf->Text($x,$y,$texto);

        $texto=$datos[telefono1];
	$pdf->SetFont('Arial','',8);
	$x=99;
	$y=60;
	$pdf->Text($x,$y,$texto);

        $texto=$datos[fax];
	$pdf->SetFont('Arial','',8);
	$x=99;
	$y=66;
	$pdf->Text($x,$y,$texto);

        $texto= $datos[serialorden];
	$pdf->SetFont('Arial','',15);
	$x=158;
	$y=31;
	$pdf->Text($x,$y,$texto);

	$pdf->SetFont('Arial','B',10);
	$pdf->Text(152,22,"ORDEN DE COMPRA");
        $pdf->SetFont('Arial','B',8);
        $pdf->Text(70,44,"DATOS DEL PROVEEDOR");
	$pdf->Text(152,33,"");
        $pdf->SetFont('Arial','B',7);
        $pdf->SetFont('Arial','B',7);
        $pdf->Text(22,49,"NOMBRE_________________________________________________________________________________");
        $pdf->Text(22,55,"DIRECCION_______________________________________________________________________________");
        $pdf->Text(22,61,"CIUDAD____________________________________");
        $pdf->Text(22,67,"NIT/C.C.____________________________________");
        $pdf->Text(83,61,"TELEFONO___________________________________");
        $pdf->Text(83,67,"FAX_________________________________________");

        $pdf->SetFont('Arial','',5);
        $pdf->Text(150,38,"de Vigilancia y Seguridad Privada");

        $pdf->SetFont('Arial','B',6);

        $texto2="No";
	$pdf->SetFont('Arial','',10);
	$x=149;
	$y=25;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,9,$texto2,$border=1,$align='L',$fill=0);

	$texto2="FECHA DE ORDEN";
	$pdf->SetFont('Arial','',4);
	$x=149;
	$y=40;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,9,$texto2,$border=1,$align='L',$fill=0);

        $texto2="FORMA DE PAGO";
	$pdf->SetFont('Arial','',4);
	$x=149;
	$y=50;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,9,$texto2,$border=1,$align='L',$fill=0);

        $texto2="PLAZO ENTREGA";
	$pdf->SetFont('Arial','',4);
	$x=149;
	$y=60;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,10,$texto2,$border=1,$align='L',$fill=0);

	$texto="CANT.";
	$pdf->SetFont('Arial','',8);
	$x=22;
	$y=76;
	$pdf->Text($x,$y,$texto);

	$texto="REFER.";
	$pdf->SetFont('Arial','',8);
	$x=45;
	$y=76;
	$pdf->Text($x,$y,$texto);

	$texto="DESCRIPCION";
	$pdf->SetFont('Arial','',8);
	$x=97;
	$y=76;
	$pdf->Text($x,$y,$texto);

	$texto="VR. UNIT";
	$pdf->SetFont('Arial','',8);
	$x=150;
	$y=76;
	$pdf->Text($x,$y,$texto);

	$texto="VALOR TOTAL";
	$pdf->SetFont('Arial','',8);
	$x=167;
	$y=76;
	$pdf->Text($x,$y,$texto);

        $pdf->Text(150,227,"TOTAL");

	$x=20;
	$y=72;
	$w=170;
	$h=156;
	$pdf->SetLineWidth(0.3);
	$pdf->Rect($x,$y,$w,$h);

	//lineas horizontales
	$x1=20;
	$y1=78;
	$x2=190;
	$y2=78;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=84;
	$x2=190;
	$y2=84;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=90;
	$x2=190;
	$y2=90;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=96;
	$x2=190;
	$y2=96;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=102;
	$x2=190;
	$y2=102;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=108;
	$x2=190;
	$y2=108;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=114;
	$x2=190;
	$y2=114;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=120;
	$x2=190;
	$y2=120;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=126;
	$x2=190;
	$y2=126;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=132;
	$x2=190;
	$y2=132;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=138;
	$x2=190;
	$y2=138;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=144;
	$x2=190;
	$y2=144;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=150;
	$x2=190;
	$y2=150;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=156;
	$x2=190;
	$y2=156;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=162;
	$x2=190;
	$y2=162;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=168;
	$x2=190;
	$y2=168;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=174;
	$x2=190;
	$y2=174;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=180;
	$x2=190;
	$y2=180;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=20;
	$y1=186;
	$x2=190;
	$y2=186;
	$pdf->Line($x1,$y1,$x2,$y2);

        $x1=20;
	$y1=192;
	$x2=190;
	$y2=192;
	$pdf->Line($x1,$y1,$x2,$y2);

        $x1=20;
	$y1=198;
	$x2=190;
	$y2=198;
	$pdf->Line($x1,$y1,$x2,$y2);

        $x1=20;
	$y1=204;
	$x2=190;
	$y2=204;
	$pdf->Line($x1,$y1,$x2,$y2);

        $x1=20;
	$y1=210;
	$x2=190;
	$y2=210;
	$pdf->Line($x1,$y1,$x2,$y2);

        $x1=20;
	$y1=216;
	$x2=190;
	$y2=216;
	$pdf->Line($x1,$y1,$x2,$y2);

        $x1=20;
	$y1=222;
	$x2=190;
	$y2=222;
	$pdf->Line($x1,$y1,$x2,$y2);

	//lineas verticales

	$x1=32;
	$y1=72;
	$x2=32;
	$y2=228;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=70;
	$y1=72;
	$x2=70;
	$y2=228;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=145;
	$y1=72;
	$x2=145;
	$y2=228;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=165;
	$y1=72;
	$x2=165;
	$y2=228;
	$pdf->Line($x1,$y1,$x2,$y2);

        $pdf->SetFont('Arial','',7);
        $pdf->Text(23,235,"OBSERVACIONES");

        $pdf->SetFont('Arial','',5);
        $pdf->Text(23,253,"CONDICIONES DE COMPRA");
        $pdf->Text(23,255,"* FAVOR ENTREGAR ORIGINAL DE LA FACTURA");
        $pdf->Text(23,257,"* NO SE ACEPTA FACTURA CON PRECIO Y FORMA DIFERENTE AL ESTIPULADO EN EL PEDIDO SALVO PREVIO AUTORIZACION Y MODIFICACION DEL MISMO");
        $pdf->Text(23,259,"* TODO PEDIDO SERA ANULADO SI VENCE SU PLAZO DE ENTREGA");


        $pdf->SetFont('Arial','',7);
        $pdf->Text(43,275,"ELABORADO POR");
        $pdf->Text(123,275,"APROBADO POR");

        $pdf->Text(23,272,"__________________________________________");
        $pdf->Text(103,272,"___________________________________________");

        $pdf->SetFont('Arial','',5);
        $pdf->Text(150,36,"Res. $datos[resolucion] de la Superintendencia");
        $pdf->SetFont('Arial','',7);
        $pdf->Text(40,39,"NIT $datos[nitempresa] Regimen Comun Actividad ICA 13.8 x 1000");

        $pdf->Text(113,253,"Favor Hacer referencia de esta orden es su factura o cuenta de cobro");

        $pdf->Text(30,270,$datos[elaboradopor]);

        $pdf->Text(163,48,$datos[fechaorden]);
        $pdf->Text(163,57,$datos[formadepago]);
        $pdf->Text(163,68,$datos[plazodentrega]);

	$pdf->SetFont('Arial','',7);
	$x=20;
	$y=230;
	$w=170;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,20,"",$border=1,$align='L',$fill=0);

        $pdf->SetFont('Arial','',7);
	$x=165;
	$y=222;
	$w=25;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,6,"$ ".$datos[valortotal],$border=1,$align='R',$fill=0);

        $pdf->SetFont('Arial','',7);
	$x=20;
	$y=230;
	$w=170;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,20,  trimall($datos[observaciones]),$border=0,$align='J',$fill=0);

        $pdf->SetFont('Arial','',7);
        $pdf->Text(63,282,$datos[linea1pie]);
        $pdf->Text(73,285,$datos[linea2pie]);
        $pdf->Text(83,288,$datos[linea3pie]);

$file1="imagenes/sgs.jpg";
$x=165;
$y=256;
$pdf->Image($file1,$x,$y,$w=12,$h=24);
}
switch($form0){
	case "ordenescompra.php";
	$pdf->AddPage();
        $sqli="SELECT ordenescompra.id, serialorden, ordenescompra.estado, fechaorden, plazodentrega, formadepago,
    referencia, valorunitario,
    CONCAT (IFNULL(nombreprod,''), ' ', IFNULL(modelo,''), ' ', IFNULL(marca,'')) as descripcionprod ,
    ciudades.`NOMBRE`,
    (cantidad * valorunitario) AS valortotalfila,
    proveedores.nombreprov, proveedores.direccion, proveedores.telefono1, proveedores.nit, proveedores.fax,
    CONCAT(personalactivo.nombre, ' ', apellidos) as  nombresolicitante, cantidad, observacionesorden,
    seguridadsuper.*
    FROM ordenescompra LEFT JOIN usuarios ON ordenescompra.idusuariordena=usuarios.id
    LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno
    LEFT JOIN proveedores ON ordenescompra.idprov = proveedores.id INNER JOIN requisiciones ON requisiciones.id=ordenescompra.idrequisicion
    LEFT JOIN productos ON requisiciones.idprod=productos.id
    LEFT JOIN ciudades ON (proveedores.codepto=ciudades.`ID_DPTO` and proveedores.codciudad=ciudades.`ID_CIUDAD`)
    JOIN seguridadsuper
    WHERE ordenescompra.serialorden=$_SESSION[iddota]";

         $sqli2="SELECT
    SUM(cantidad*valorunitario) as valortotal
    FROM ordenescompra
    INNER JOIN requisiciones ON requisiciones.id=ordenescompra.idrequisicion
    WHERE ordenescompra.serialorden=$_SESSION[iddota]";

	$cons=@mysql_query($sqli);
        $cons2=@mysql_query($sqli2);

        //encabezado de orden
        $datos[serialorden]=recortarcadena(@mysql_result($cons,0,'serialorden'),30);
	$datos[fechaorden]=recortarcadena(decod(@mysql_result($cons,0,'fechaorden')),30);
        $datos[formadepago]=recortarcadena(decod(@mysql_result($cons,0,'formadepago')),25);
        $datos[plazodentrega]=recortarcadena(decod(@mysql_result($cons,0,'plazodentrega')),30);
        $datos[observaciones]=recortarcadena(decod(@mysql_result($cons,0,'observacionesorden')),250);
        $datos[elaboradopor]=recortarcadena(decod(@mysql_result($cons,0,'nombresolicitante')),60);

        //proveedor
	$datos[nombreprov]=recortarcadena(@mysql_result($cons,0,'nombreprov'),30);
	$datos[direccion]=recortarcadena(decod(@mysql_result($cons,0,'proveedores.direccion')),30);
        $datos[ciudad]=recortarcadena(decod(@mysql_result($cons,0,'ciudades.NOMBRE')),30);
        $datos[telefono1]=recortarcadena(decod(@mysql_result($cons,0,'telefono1')),30);
        $datos[nitprovee]=recortarcadena(decod(@mysql_result($cons,0,'proveedores.nit')),30);
        $datos[fax]=recortarcadena(decod(@mysql_result($cons,0,'fax')),30);
        //empresa
        $datos[nitempresa]=recortarcadena(@mysql_result($cons,0,'seguridadsuper.nit'),30);
	$datos[resolucion]=recortarcadena(decod(@mysql_result($cons,0,'numerolicencia')),30);
        $datos[linea1pie]=recortarcadena(decod(@mysql_result($cons,0,'seguridadsuper.direccion')),30)." Tels:".recortarcadena(decod(@mysql_result($cons,0,'seguridadsuper.telefono1')),30)." ".recortarcadena(decod(@mysql_result($cons,0,'seguridadsuper.telefono2')),30)." ".recortarcadena(decod(@mysql_result($cons,0,'telefono3')),30)." ".recortarcadena(decod(@mysql_result($cons,0,'municipio')),30);
        $datos[linea2pie]="Email ".recortarcadena(decod(@mysql_result($cons,0,'seguridadsuper.email')),60)." / ".recortarcadena(decod(@mysql_result($cons,0,'seguridadsuper.email1')),60);
        $datos[linea3pie]=recortarcadena(decod(@mysql_result($cons,0,'seguridadsuper.paginaweb')),30);

        $datos[valortotal]=recortarcadena(number_format(@mysql_result($cons2,0,'valortotal'),0,"", "."),30);

        ponerFormato($pdf, $datos);

	$y=77;

        $inic=0;
	$limp=@mysql_num_rows($cons);

	for($inic=0;$inic<$limp;$inic++){
		$y+=6;
		$obnou="";
                 //producto
                $descripcion=recortarcadena(decod(@mysql_result($cons,$inic,'descripcionprod')),30);
                $referencia=recortarcadena(decod(@mysql_result($cons,$inic,'referencia')),30);
                $valorunitario=recortarcadena(number_format(@mysql_result($cons,$inic,'valorunitario'), 0,".", "."),30);
                $valortotalfila=recortarcadena(number_format(@mysql_result($cons,$inic,'valortotalfila'), 0,".", "."),30);
		$cantidad=@mysql_result($cons,$inic,'cantidad');

		$texto=$cantidad;
		$pdf->SetFont('Arial','',10);
		$x=22;
		$pdf->Text($x,$y,$texto);

		$texto=$producto;
		$pdf->SetFont('Arial','',7);
		$x=72;
		$pdf->Text($x,$y,$texto);

                $x=34;
		$pdf->Text($x,$y,$referencia);

                 $x=72;
		$pdf->Text($x,$y,$descripcion);

                $x=165;
                $w=25;
                $pdf->Setxy($x,$y-5);
                $pdf->MultiCell($w,6,"$ ".$valortotalfila,$border=0,$align='R',$fill=0);

                $x=145;
                $w=20;
                $pdf->Setxy($x,$y-5);
                $pdf->MultiCell($w,6,"$ ".$valorunitario,$border=0,$align='R',$fill=0);

                if($y>=220){
                    $pdf->AddPage();
                    ponerFormato($pdf, $datos);
                    $y=77;
                }
	}
	break;
}
$pdf->Output();
?>

