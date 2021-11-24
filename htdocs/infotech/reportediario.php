<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1009);

	if($_SESSION[cedulamod]==""){
	$sql122="SELECT * FROM necesidadescliente ORDER BY numerooferta DESC";
	$cons=@mysql_query($sql122);
	$_SESSION[cedulamod]=@mysql_result($cons,0,"numerooferta");
	}

require('fpdf/fpdf.php');

$pdf=new FPDF('L','mm', 'legal');

//llenar con datos el formato
$mescontrol=convertirmes($_SESSION[mes1]).$_SESSION['ano1'];
$sql="SELECT * FROM `controlturnos` LEFT JOIN personalactivo ON controlturnos.cedulacontrol=personalactivo.cedula LEFT JOIN clientes ON
    personalactivo.codigo=clientes.codigo WHERE controlturnos.mescontrol LIKE '$mescontrol' AND personalactivo.sucursal LIKE '$_SESSION[sucur]' ORDER BY clientes.codigo ASC, personalactivo.apellidos";
//echo $sql;
$res=@mysql_query($sql);
$lim=@mysql_num_rows($res);

$y=68.7;
$x=53;
$filasmaximas=35;
$filactual=1;
$casillaslibrescajacliente=4;

agregarPagina($pdf);

$pdf->SetFont('Arial','',7);

for($ini=0;$ini<$lim;$ini++){
        if($ini==0){
        escribirCliente($res, $ini+1, $pdf, $filactual, $casillaslibrescajacliente);}
        escribirFila($res, $ini, $pdf, $filactual);

    if(@mysql_result($res, $ini, "codigo")!=@mysql_result($res, $ini+1, "codigo")){//el codigo del cliente siguiente es diferente
        if($filactual+1+$casillaslibrescajacliente<=$filasmaximas){//si cabe en la hoja
        $filactual+=$casillaslibrescajacliente+1;
        }else{//no cabe en la hoja
        agregarPagina($pdf);
        $filactual=1;
        }
        escribirCliente($res, $ini+1, $pdf, $filactual, $casillaslibrescajacliente);
        $casillaslibrescajacliente=4;
        
    }else{// el codigo del cliente siguiente es el mismo
        if($filactual+1<=$filasmaximas){//si cabe en la hoja
        $filactual++;
            if($casillaslibrescajacliente>=1){
                $casillaslibrescajacliente--;
            }else{
                escribirCliente($res, $ini+1, $pdf, $filactual, $casillaslibrescajacliente);
                $casillaslibrescajacliente=4;
                }
        }else{//no cabe en la hoja
        agregarPagina($pdf);
        $filactual=1;
        escribirCliente($res, $ini+1, $pdf, $filactual, $casillaslibrescajacliente);
        $casillaslibrescajacliente=4;
        }
    }
}

function escribirCliente($res, $ini, $pdf, $var, $casillaslibrescajacliente){
    $y=68.7;
    $x=53;
    $pdf->Text($x-30,$y+(3.5*$var), recortarcadena(utf8_decode(@mysql_result($res, $ini, "codigo")), 40));
    $pdf->SetFont('Arial','B',4);
    $pdf->Text($x-30,$y+(3.5*$var)+3, recortarcadena(utf8_decode(@mysql_result($res, $ini, "nombrecliente")), 30));
    $pdf->Text($x-30,$y+(3.5*$var)+6, recortarcadena("Diurnos:".@mysql_result($res, $ini, "personald"). " Nocturnos:".@mysql_result($res, $ini, "personaln"), 30));
    $pdf->SetFont('Arial','B',7);
}
function escribirFila($res, $ini, $pdf, $var){
$y=68.7;
$x=53;
$pdf->Text($x,$y+(3.5*$var), recortarcadena(utf8_decode(@mysql_result($res, $ini, "nombre")." ".@mysql_result($res, $ini, "apellidos")), 40));
for($in=1;$in<=31;$in++){
    renderTurno($x, $y, $in, $var, $ini, $res, $pdf);
}
}

function agregarPagina($obj){
$obj->AddPage();
$obj->SetFont('Arial','B',18);
$obj->Ln();
$file="imagenes/super10.jpg";
$x=32;
$y=26;
$obj->Image($file,$x,$y,$w=18,$h=18);
$obj->Ln();
$x=20;
$y=25;
$w=315;
$h=20;
$obj->SetLineWidth(0.3);
$obj->Rect($x,$y,$w,$h);
$x1=70;
$y1=25;
$x2=70;
$y2=45;
$obj->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=25;
$x2=240;
$y2=45;
$obj->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=32;
$x2=335;
$y2=32;
$obj->Line($x1,$y1,$x2,$y2);
$x1=240;
$y1=38;
$x2=335;
$y2=38;
$obj->Line($x1,$y1,$x2,$y2);
$x1=50;
$y1=59;
$x2=50;
$y2=192;
$obj->Line($x1,$y1,$x2,$y2);

$texto="REPORTE DIARIO DE PUESTOS";
$obj->SetFont('Arial','B',10);
$obj->Ln();
$w=166;
$h=6;
$y=33;
$x=70;
$obj->Sety($y);
$obj->Setx($x);
$obj->MultiCell($w,$h,$texto,$border=0,$align='C',$fill=0);
$obj->SetFont('Arial','',10);
$obj->Text(245,30,  utf8_decode("Fecha Aprobación:"));
$obj->Text(245,36,utf8_decode("Código: F -SC -005"));
$obj->Text(245,42,utf8_decode("Versión: 00"));

$es=55;
$iniy=4;

$texto="";
$obj->SetFont('Arial','B',10);
$obj->Ln();
$w=315;
$h=133;
$y=$iniy+$es;
$x=20;
$obj->Sety($y);
$obj->Setx($x);
$obj->MultiCell($w,$h,$texto,$border=1,$align='C',$fill=0);

//lineas de cada persona
$iniylineas=62.5;
for($i=2;$i<37;$i++){

if($i==2){
$x1=20;
}else{
$x1=50;
}

$x2=335;
$y1=$i*3.5+$iniylineas;
$y2=$i*3.5+$iniylineas;
$obj->Line($x1,$y1,$x2,$y2);
}

//lineas de cada cliente
$iniylineas=69.5;
for($i=1;$i<7;$i++){
$x1=20;
$y1=$i*17.5+$iniylineas;
$x2=50;
$y2=$i*17.5+$iniylineas;
$obj->Line($x1,$y1,$x2,$y2);
}
$x1=70;

//encabezado dias
//
$inixlineas=111;
$obj->SetFont('Arial','',8);
for($i=1;$i<32;$i++){
$obj->Line($inixlineas+(7*$i),59,$inixlineas+(7*$i),192);
$obj->Text($inixlineas+2+(7*$i),66,$i);
}

$obj->SetFont('Arial','',10);
//datos de encabezado
$obj->AliasNbPages("{np}");
$obj->Text(44,52,$_SESSION[mes1]);
$obj->Text(97,52,$_SESSION[ano1]);
$obj->Text(44,57,$obj->PageNo().'  de {np}');

//encabezados del formulario
$obj->Text(34,52,"MES____________________");
$obj->Text(22,57,"PAGINA No____________________");
$obj->Text(87,52,decod("AÑO________"));
$obj->Text(117,52,decod("Convenciones:   D:Día     I:Inasistencia    =:Turno de 24 Horas     Per:permiso    Init:Inicia Labor"));
$obj->Text(143,57,decod("N:Noche     Inc:Incapacidad "  ));//.:Descanso     Ult:Ultimo Turno"
$obj->Text(193,57,decod("O:Descanso     Ult:Ultimo Turno"  ));

$obj->Text(28,66,"PUESTO");
$obj->Text(52,66,"APELLIDOS Y NOMBRES");
$y=$y+14;

$y=72;
$x=53;

$obj->SetFont('Arial','',7);

}

function renderTurno($x, $y, $in, $var, $ini, $res, $pdf){
$diurnoturno=@mysql_result($res, $ini, "d$in");
$nocturnoturno=@mysql_result($res, $ini, "n$in");
$retorno="";

if($diurnoturno=="1" && $nocturnoturno=="1"){
$pdf->SetTextColor(0,0,0);
$retorno="=";
}else if($diurnoturno=="1"){
$pdf->SetTextColor(0,0,0);
$retorno="D";
}else if($nocturnoturno=="1"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$retorno="N";
}else if($diurnoturno=="f" || $nocturnoturno=="f"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="I";
}else if($diurnoturno=="s" || $nocturnoturno=="s"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="Inc";
}else if($diurnoturno=="d" || $nocturnoturno=="d"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="O";
}else if($diurnoturno=="p" || $nocturnoturno=="p"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="Per";
}else if($diurnoturno=="r" || $nocturnoturno=="r"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="Init";
}else if($diurnoturno=="q" || $nocturnoturno=="q"){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="Ult";
}else if($diurnoturno!=""){
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(255,0,0);
$retorno="Otr";
}


/*
 * 		function verificarNovedadRadiop($novedad){
$retorno="";
switch($novedad){
case "Cambio de Turno":
$retorno="c";
break;
case "Cambio Permanente":
$retorno="n";
break;
case "Descanso":
$retorno="d";
break;
case "Abandono";
$retorno="a";
break;
case "Licencia";
$retorno="l";
break;
case "Permiso";
$retorno="p";
break;
case "Vacaciones";
$retorno="v";
break;
case "Dormido":
$retorno="z";
break;
case "Inasistencia":
$retorno="f";
break;
case "Enfermo":
$retorno="e";
break;
case "Evadido":
$retorno="y";
break;
case "Accidente":
$retorno="x";
break;
case "Relevado":
$retorno="w";
break;
case "Ebrio":
$retorno="v";
break;
case "Hurto":
$retorno="u";
break;
case "Otro":
default:
$retorno="t";
break;
case "Incapacidad":
$retorno="s";
break;
case "Refuerzo":
$retorno="m";
break;
case "Inicia Labor":
$retorno="r";
break;
case "Ultimo Turno":
$retorno="q";
break;
 */

$pdf->Text($x+(7*$in)+60,$y+(3.5*$var),$retorno);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',7);
}

$pdf->Output();
?>