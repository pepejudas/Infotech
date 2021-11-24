<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1067);
	
	function verifica($te){
		if($te=="inserte" or $te=="0"){
			$ret="";
		}else{
			$ret=$te;
		}
		return $ret;
	}
	
/******************************************************************************
cargar todos los datos para poner en el formulario de solicitud de credencial
******************************************************************************/
$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$_SESSION[cedulamod]";
$result=mysql_query($sql1);
$sql2="SELECT * FROM seguridadsuper";
$resultado=mysql_query($sql2);
$apellidosynombres=recortarcadena(decod(@mysql_result($result,0,apellidos)." ".@mysql_result($result,0,nombre)),38);
$cedula=@mysql_result($result,0,cedula);
$expd=recortarcadena(decod(@mysql_result($result,0,cedula)),12);
$direccion=recortarcadena(decod(@mysql_result($result,0,direccion)),30);
$ciudad=@mysql_result($result,0,codigoresidencia);
$departamento="Cundinamarca";
$cedula=@mysql_result($result,0,cedula);
$telefono=@mysql_result($result,0,telefono);
$sexo=@mysql_result($result,0,sexo);
$rh=@mysql_result($result,0,rh);
$cedula=@mysql_result($result,0,cedula);
$cargo=@mysql_result($result,0,cargo);
$foto=@mysql_result($result,0,foto );
//die($cargo);
$nivelvig=@mysql_result($result,0,codnivelvig);
$cedula=@mysql_result($result,0,cedula);
$cred=@mysql_result($result,0,credsuperintendencia);
$expedida=@mysql_result($result,0,expedida);
$licencia=@mysql_result($resultado,0,numerolicencia);
$fechainiciolic=@mysql_result($resultado,0,fechainiciolic);
$razon=@mysql_result($resultado,0,razonsocial);
if(@mysql_result($result,0,nombre)==""){echo '<h1>!Error debe cargar una persona<br>de lo contrario no puede ser generada <br> la solicitud de credencial!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';exit();}

//guardar imagenes de huellas en el disco
$sql0="SELECT foto64, dedo FROM huellas LEFT JOIN personalactivo ON huellas.carnetpersonal=personalactivo.carnetinterno WHERE personalactivo.cedula='$_SESSION[cedulamod]' AND (huellas.dedo=0 OR huellas.dedo=5)";
$resulta=@mysql_query($sql0);
$ini=0;
$lim=@mysql_num_rows($resulta);

for($ini=0;$ini<$lim;$ini++){
$string=@mysql_result($resulta, $ini, "foto64");
$dedo=@mysql_result($resulta, $ini, "dedo");
$dedos[$dedo]=true;

    $img = imagecreatefromstring(base64_decode($string));
    $rotate = imagerotate($img, 180, 0);

        if($img != false){
           imagejpeg($rotate, "fotoshuellas/huella$dedo.jpg");
        }
}

require('fpdf/fpdf.php');
$pdf=new FPDF($orientation='P',$unit='mm',$format='legal');
$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$file="imagenes/solcara1.jpg";
$x=1;
$y=10;
$pdf->Image($file,$x,$y,$w=210);
$pdf->Ln();

//ciudad
$texto="BOGOTA D.C.";
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=20;
$y=69;
$pdf->Text($x,$y,$texto);

//razon social
$texto=$razon;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=20;
$y=107;
$pdf->Text($x,$y,$texto);

//numero licencia
$texto=$licencia;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=120;
$y=107;
$pdf->Text($x,$y,$texto);

//fecha inicio lic
$texto=$fechainiciolic;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=150;
$y=107;
$pdf->Text($x,$y,$texto);

//cargo
$texto="X";
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();

switch($cargo):
//directivo
case 1:
case 3:
case 8:
case 16:
case 17:
$x=16;
$y=130;
break;
//operadormediotecnologico
case 13:
case 11:
$x=16;
$y=140;
break;
//manejador canino
case 7:
case 6:	
case 4:
$x=78;
$y=140;
break;
//supervisor
case 9:
case 10:
$x=74;
$y=130;
break;
//tripulante
case 14:
case 15:
$x=137;
$y=140;
break;
//escolta
case 5:
$x=133;
$y=130;
break;
//vigilante
default:
$x=171;
$y=130;
break;
//predeterminado
endswitch;
$pdf->Text($x,$y,$texto);

//nivel de vigilancia
$texto="X";
$pdf->SetFont('Arial','B',15);   
$pdf->Ln();
switch($nivelvig):
//nivel IV o avanzado
case 12:
$x=118;
$y=150;
break;
//actualizaciones
case 13:
$x=165;
$y=159;
break;
//especializaciones
case 14:
$x=166;
$y=150;
break;
//avanzado especial
case 15:
$x=118;
$y=159;
break;
//predeterminado
default:
$x=16;
$y=153;
break;
endswitch;
$pdf->Text($x,$y,$texto);

//nombres y apellidos
$texto=$apellidosynombres;
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=18;
$y=174;
$pdf->Text($x,$y,$texto);

//cedula
$texto=$cedula;
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$x=130;
$y=174;
$pdf->Text($x,$y,$texto);

//expedicion cc
$texto=verifica($expedida);
$pdf->SetFont('Arial','B',7);   
$pdf->Ln();
$x=169;
$y=174;
$pdf->Text($x,$y,$texto);

//credencial
$texto=verifica($cred);
$pdf->SetFont('Arial','B',10);   
$pdf->Ln();
$x=145;
$y=193;
$pdf->Text($x,$y,$texto);

//direccion
$texto=verifica($direccion);
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
$x=16;
$y=182;
$pdf->Text($x,$y,$texto);

//ciudad
$texto=$ciudad;
$pdf->SetFont('Arial','B',8);   
$pdf->Ln();
switch($ciudad):
case "08001":
$texto="BARRANQUILLA";
$texto1="ALTLANTICO";
break;
case "11001":
$texto="BOGOTA D.C.";
$texto1="CUNDINAMARCA";
break;
case "76001":
$texto="CALI";
$texto1="VALLE DEL CAUCA";
break;
case "25269":
$texto="FACATATIVA";
$texto1="CUNDINAMARCA";
break;
case "25286":
$texto="FUNZA";
$texto1="CUNDINAMARCA";
break;
case "25377":
$texto="LA CALERA";
$texto1="CUNDINAMARCA";
break;
case "25430":
$texto="MADRID";
$texto1="CUNDINAMARCA";
break;
case "05001":
$texto="MEDELLIN";
$texto1="ANTIOQUIA";
break;
case "25473":
$texto="MOSQUERA";
$texto1="CUNDINAMARCA";
break;
case "25740":
$texto="SIBATE";
$texto1="CUNDINAMARCA";
break;
case "25754":
$texto="SOACHA";
$texto1="CUNDINAMARCA";
break;
case "50001":
$texto="VILLAVICENCIO";
$texto1="META";
break;
case "15759":
$texto="SOGAMOSO";
$texto1="BOYACA";
break;
default:
$texto="";
$texto1="";
break;
endswitch;
$x=74;
$y=182;
$pdf->Text($x,$y,$texto);
$x=99;
$y=182;
$pdf->Text($x,$y,$texto1);	

//TELEFONO
$texto=verifica($telefono);
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
$x=128;
$y=182;
$pdf->Text($x,$y,$texto);

//sexo
$texto="X";
$pdf->SetFont('Arial','B',12);   
$pdf->Ln();
switch($sexo):
case 2:
$x=195;
$y=182;
break;
default:
$x=186;
$y=182;
break;
endswitch;
$pdf->Text($x,$y,$texto);

//poner la foto del paciente si la tiene

/*
 * cuanto cuesta direccion carreara 27 a No 53 a 56 mañana temprano,
 * supradyn prenatal, s26mama.
 * acido folico, calcio, sulfato ferroso.
 */

if($foto!=""){
    $dim=redimensionarFoto(31.5, 42, "fotosguardas/".$foto);
    $file="fotosguardas/".$foto;
    //print_r($dim);
    $x=27;
    $y=196;
    $pdf->Image($file,$x,$y, $dim['ancho'], $dim['alto']);
    $pdf->Ln();
}

//cargar las fotos de las huellas
if($dedos[0]){//hay dedo indice derecho o izquierdo
    if($dedos[5]){//hay dedo indice izquierdo
    $dim=redimensionarFoto(30, 35, "fotoshuellas/huella5.jpg");
    $file5="fotoshuellas/huella5.jpg";
    $file0="fotoshuellas/huella0.jpg";
    //print_r($dim);
    $x=170;
    $y=196;
    $pdf->Image($file5,$x,$y, $dim['ancho'], $dim['alto']);
    $x=137;
    $y=196;
    $pdf->Image($file0,$x,$y, $dim['ancho'], $dim['alto']);
    $pdf->Ln();
    }else{
    $dim=redimensionarFoto(30, 35, "fotoshuellas/huella5.jpg");
    $file0="fotoshuellas/huella0.jpg";
    //print_r($dim);
    $x=137;
    $y=196;
    $pdf->Image($file0,$x,$y, $dim['ancho'], $dim['alto']);
    $pdf->Ln();
    }
}

$pdf->AddPage();
$pdf->SetFont('Arial','B',18);
$file="imagenes/solcara2.jpg";
$x=1;
$y=10;
$pdf->Image($file,$x,$y,$w=210);
$pdf->Ln();

$pdf->Output();
?>