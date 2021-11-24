<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1002);

require('fpdf/fpdf.php');
$pdf=new FPDF();

        //capturar parametros de get
        if($_GET[cedulamod]!=""){//verifcar que viene el parametro id del documento y asignarlo
        $_SESSION[cedulamod]=$_GET[cedulamod];
        }
        //boleano para aprobar algo
        $seapruebalgo=false;
        
	$pdf->AddPage();
        //personal clientes productos requisiciones usuarios
        $sqli="SELECT CONCAT(responsabledepto.nombre, ' ', responsabledepto.apellidos) as jefedepto, CONCAT(solicitante.nombre,' ', solicitante.apellidos) AS nombresolic, usuapruebasol.nombre, requisiciones.estado, usuapruebasol.apellidos, cargos.cargo, nou, solicitante.cedula, nombrecliente, clientes.codigo, fechareq, serialrequisicion, requisiciones.observaciones, requisiciones.cantidad, nombreprod, referencia, modelo, marca FROM requisiciones LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo AS solicitante ON usuarios.carnetpersonal=solicitante.carnetinterno LEFT JOIN clientes ON solicitante.codigo=clientes.codigo LEFT JOIN productos ON requisiciones.idprod=productos.id LEFT JOIN cargos ON solicitante.cargo=cargos.id LEFT JOIN usuarios as usuaprueba ON requisiciones.idusuarioaprueba=usuaprueba.id LEFT JOIN personalactivo as usuapruebasol ON usuaprueba.carnetpersonal=usuapruebasol.carnetinterno LEFT JOIN cargos as cargopac ON solicitante.cargo=cargopac.id LEFT JOIN departamentos ON cargopac.idepto=departamentos.id LEFT JOIN personalactivo as responsabledepto ON responsabledepto.cedula=departamentos.responsable WHERE serialrequisicion='$_SESSION[cedulamod]'";

	$cons=@mysql_query($sqli);//, usuarios, personalactivo, productos WHERE dotacion.iddot='$_SESSION[iddota]' AND dotacion.ceduladot='$_SESSION[cedulamod]' AND dotacion.ceduladot = clientes.codigo AND dotacion.idprod=productos.id ORDER BY nombreprod";
	$nombresolicitante=recortarcadena(decod(@mysql_result($cons,0,'nombresolic')),30);
	$fecha=recortarcadena(decod(@mysql_result($cons,0,'fechareq')),30);
	$cargo=@mysql_result($cons,0,'cargo');
        $serialreq=@mysql_result($cons,0,'serialrequisicion');
	$puestotrabajo=recortarcadena(decod(@mysql_result($cons,0,'nombrecliente')), 60);
        $codigo=recortarcadena(@mysql_result($cons,0,'ceduladot'),30);
        $jefedepto=recortarcadena(decod(@mysql_result($cons,0,'jefedepto')), 60);

        //exit($usuarioautoriza);
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

	$texto=$nombresolicitante;
	$pdf->SetFont('Arial','',10);
	$x=47;
	$y=75;
	$pdf->Text($x,$y,$texto);

	$texto=$serialreq;
	$pdf->SetFont('Arial','',10);
	$x=155;
	$y=61;
	$pdf->Text($x,$y,$texto);

	$texto=$fecha;
	$pdf->SetFont('Arial','',8);
	$x=35;
	$y=68;
	$pdf->Text($x,$y,$texto);

	$texto=$cargo;
	$pdf->SetFont('Arial','',10);
	$x=143;
	$y=74;
	$pdf->Text($x,$y,$texto);

	$texto=$puestotrabajo;
	$pdf->SetFont('Arial','',10);
	$x=64;
	$y=83;
	$pdf->Text($x,$y,$texto);

        $texto=$usuarioautoriza;
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=275;
	$pdf->Text($x,$y,$texto);

        $texto=$jefedepto;
	$pdf->SetFont('Arial','',7);
	$x=55;
	$y=274;
	$pdf->Text($x,$y,$texto);

	$texto=utf8_decode("REQUISICIÓN");

	$pdf->SetFont('Arial','B',14);
	$pdf->Ln();
	$w=90;
	$h=6;
        $x=77;
	$y=38;
	$pdf->Sety($y);
        $pdf->Setx($x);
	$pdf->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
	$y=46;
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();

	$texto2="FECHA_____________________________";
	$pdf->SetFont('Arial','',10);
	$x=20;
	$y=65;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="SOLICITANTE______________________________________";
	$pdf->SetFont('Arial','',10);
	$x=20;
	$y=72;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell(100,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="PUESTO DE TRABAJO___________________________________________________________________";
	$pdf->SetFont('Arial','',10);
	$x=21;
	$y=84;
	$pdf->Text($x,$y,$texto2);

        $texto2="REQUISICION No";
	$pdf->SetFont('Arial','',10);
	$x=117;
	$y=57;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);
        
	$texto2="CARGO__________________________";
	$pdf->SetFont('Arial','',10);
	$x=125;
	$y=70;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=0,$align='J',$fill=0);

	$texto2="";
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=57;
	$w=40;
	$pdf->Setxy($x,$y);
	$pdf->MultiCell($w,$h,$texto2,$border=1,$align='L',$fill=0);

	$texto="CANTIDAD";
	$pdf->SetFont('Arial','',10);
	$x=21;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="DESCRIPCION";
	$pdf->SetFont('Arial','',10);
	$x=85;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$texto="OBSERVACIONES";
	$pdf->SetFont('Arial','',10);
	$x=150;
	$y=94;
	$pdf->Text($x,$y,$texto);

	$x=20;
	$y=90;
	$w=170;
	$h=175;
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

	//lineas verticales

	$x1=40;
	$y1=90;
	$x2=40;
	$y2=265;
	$pdf->Line($x1,$y1,$x2,$y2);

	$x1=140;
	$y1=90;
	$x2=140;
	$y2=265;
	$pdf->Line($x1,$y1,$x2,$y2);

        $texto="Visto Bo:";
	$pdf->SetFont('Arial','',10);
	$x=25;
	$y=270;
	$pdf->Text($x,$y,$texto);

        $texto="Director y/o Responsable    ______________________________";
	$pdf->SetFont('Arial','',7);
	$x=25;
	$y=275;
	$pdf->Text($x,$y,$texto);

        $texto="F-CO-003/V.01/18-04-2006";
	$pdf->SetFont('Arial','',7);
	$x=25;
	$y=280;
	$pdf->Text($x,$y,$texto);

        $texto=utf8_decode("Autorización:");
	$pdf->SetFont('Arial','',10);
	$x=125;
	$y=270;
	$pdf->Text($x,$y,$texto);

        $texto="________________________________";
	$pdf->SetFont('Arial','',7);
	$x=145;
	$y=275;
	$pdf->Text($x,$y,$texto);

	$y=92;

	for($inic=0;$inic<$limp;$inic++){
		$y+=10;

                if(@mysql_result($cons,$inic,nou)==1){$tipoprod="Nuevo";}else{$tipoprod="Usado";}
                $cantidad=@mysql_result($cons,$inic,"cantidad");
		$producto=recortarcadena(decod(@mysql_result($cons,$inic,"nombreprod")." ".@mysql_result($cons,$inic,"referencia")." ".@mysql_result($cons,$inic,"modelo")." ".@mysql_result($cons,$inic,"marca")." ".$tipoprod),75);
                
                switch(@mysql_result($cons,$inic,"estado")){
                case "1":
                $estadobj="No Revisado ";
                break;
                case "2":
                $estadobj="Aprobado por: ". @mysql_result($cons,$inic,"usuapruebasol.nombre")." ".@mysql_result($cons,$inic,"usuapruebasol.apellidos")." ";
                $seapruebalgo=true;
                $nombreaprueba=@mysql_result($cons,$inic,"usuapruebasol.nombre")." ".@mysql_result($cons,$inic,"usuapruebasol.apellidos");
                break;
                case "3":
                $estadobj="Rechazado por: ".@mysql_result($cons,$inic,"usuapruebasol.nombre")." ".@mysql_result($cons,$inic,"usuapruebasol.apellidos")." ";
                break;
                }

                $obnou=recortarcadena(decod($estadobj.@mysql_result($cons,$inic,"observaciones")),55);
		$fecha1=@mysql_result($cons,$inic,"fechaent");
		$nou=@mysql_result($cons,$inic,"nou");

		$texto=$cantidad;
		$pdf->SetFont('Arial','',10);
		$x=22;
		$pdf->Text($x,$y,$texto);

		$pdf->SetFont('Arial','',7);
		$x=40;
                $pdf->Setxy($x,$y-7);
                $pdf->MultiCell(100,10,$producto,$border=0,$align='J',$fill=0);

                $pdf->SetFont('Arial','',5);
		$x=140;
                $pdf->Setxy($x,$y-7);
                $pdf->MultiCell(50,10,  trimall($obnou),$border=1,$align='J',$fill=0);

		$texto=$fecha1;
		$pdf->SetFont('Arial','',8.4);
		$x=21;
		$pdf->Text($x,$y,$texto);

		if($y>=260){
                    $pdf->AddPage();
                    $y=26;

                    $x=20;
                    $w=170;
                    $h=240;
                    $pdf->SetLineWidth(0.3);
                    $pdf->Rect($x,$y,$w,$h);

                    //lineas horizontales
                    for($i=1;$i<=24;$i++){
                    $x1=20;
                    $y1=$y2=16+$i*10;
                    $x2=190;
                    $pdf->Line($x1,$y1,$x2,$y2);
                    }

                    //lineas verticales
                    $x1=40;
                    $y1=26;
                    $x2=40;
                    $y2=266;
                    $pdf->Line($x1,$y1,$x2,$y2);

                    $x1=140;
                    $y1=26;
                    $x2=140;
                    $y2=266;
                    $pdf->Line($x1,$y1,$x2,$y2);

                    $texto="Visto Bo:";
                    $pdf->SetFont('Arial','',10);
                    $x=25;
                    $y=270;
                    $pdf->Text($x,$y,$texto);

                    $texto="Director y/o Responsable    ______________________________";
                    $pdf->SetFont('Arial','',7);
                    $x=25;
                    $y=275;
                    $pdf->Text($x,$y,$texto);

                    $texto="F-CO-003/V.01/18-04-2006";
                    $pdf->SetFont('Arial','',7);
                    $x=25;
                    $y=280;
                    $pdf->Text($x,$y,$texto);

                    $texto=utf8_decode("Autorización:");
                    $pdf->SetFont('Arial','',10);
                    $x=125;
                    $y=270;
                    $pdf->Text($x,$y,$texto);

                    $texto="________________________________";
                    $pdf->SetFont('Arial','',7);
                    $x=145;
                    $y=275;
                    $pdf->Text($x,$y,$texto);

                    $y=23;
		}
	}
//linea de aprobacion
if($seapruebalgo){
    $texto=recortarcadena($nombreaprueba, 35);
    $pdf->SetFont('Arial','',7);
    $x=147;
    $y=274;
    $pdf->Text($x,$y,$texto);
}

$pdf->Output();
?>

