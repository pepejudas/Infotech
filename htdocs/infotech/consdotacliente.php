<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1071);

require('fpdf/fpdf.php');
$pdf=new FPDF('P','mm','legal');

$pdf->AddPage();
$sql0="SELECT * FROM clientes WHERE clientes.codigo ='$_SESSION[consclie]'";
$result=@mysql_query($sql0);
$codigo=decod(@mysql_result($result,0,"codigo"));
$direccion=decod(@mysql_result($result,0,direccion));
$nombrecliente=decod(@mysql_result($result,0,nombrecliente));
$administrador=decod(@mysql_result($result,0,nombreadministrador));

$sqlradios="SELECT * FROM radios WHERE `radios`.`codigo` = '$_SESSION[consclie]'";
$resultaradios=@mysql_query($sqlradios);

$sqlarmas="SELECT * FROM armas WHERE `armas`.`codigo` = '$_SESSION[consclie]'";
$resultaarmas=@mysql_query($sqlarmas);

$sqldotacion="SELECT * FROM clientes, dotacion, productos WHERE clientes.codigo = dotacion.ceduladot AND dotacion.idprod = productos.id AND `clientes`.`codigo` ='$_SESSION[consclie]' ORDER BY iddot";
$resultadotacion=@mysql_query($sqldotacion);

$pdf->SetFont('Arial','B',18);
$pdf->Ln();
$file="imagenes/super10.jpg";
$x=10;
$y=10;
$pdf->Image($file,$x,$y,$w=40,$h=40);
$file1="imagenes/sgs.jpg";
$x=176;
$y=10;
$pdf->Image($file1,$x,$y,$w=16,$h=33);
$pdf->Ln();
$texto="
                                                                                                         

                                    
                                    INFORME CONSOLIDADO DE ALMACEN
			                          ";
$pdf->SetFont('Arial','B',14);
$pdf->Ln();
$pdf->Write(5,$texto);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$texto2="
NOMBRE DEL CLIENTE:		       $nombrecliente
CODIGO:                                 $codigo
DIRECCION DEL CLIENTE:	   $direccion
REPRESENTANTE:                $administrador
";

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;
require('saludoslis.php');

$pdf->SetFont('Arial','B',12);
$pdf->Write(5,$texto2);
$pdf->Ln();
$w=185;
$h=3;
$pdf->SetFont('Arial','B',8);

$x=10;
$x1=200;
$y=115;

$ini=0;
$Lim=@mysql_num_rows($resultaarmas);

for($ini=0;$ini<$Lim;$ini++){//armas
$b++;
        $serie=decod(@mysql_result($resultaarmas,$ini,"serial"));
        $marca=decod(@mysql_result($resultaarmas,$ini,"marca"));
        $tipo=decod(@mysql_result($resultaarmas,$ini,"tipoarma"));
        $calibre=decod(@mysql_result($resultaarmas,$ini,"calibre"));
        $fecha=decod(@mysql_result($resultaarmas,$ini,"fechaentrega"));
        
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell($w,$h,"$b Arma: $serie $marca $tipo $calibre",$border=0,$align='J',$fill=0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,"Cantidad: 1, Fecha de Entrega: $fecha",$border=0,$align='J',$fill=0);
	$pdf->Ln();

}

$ini=0;
$Lim=@mysql_num_rows($resultaradios);

for($ini=0;$ini<$Lim;$ini++){//radios
$b++;
        $serie=decod(@mysql_result($resultaradios,$ini,"serie"));
        $marca=decod(@mysql_result($resultaradios,$ini,"marca"));
        $tipo=decod(@mysql_result($resultaradios,$ini,"tipo"));
        $calibre=decod(@mysql_result($resultaradios,$ini,"modelo"));
        $fecha=decod(@mysql_result($resultaarmas,$ini,"fechaentrega"));

	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell($w,$h,"$b Radio: $serie $marca $tipo $modelo",$border=0,$align='J',$fill=0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,"Cantidad: 1, Fecha de Entrega: $fecha",$border=0,$align='J',$fill=0);
	$pdf->Ln();

}

while($fila=@mysql_fetch_array($resultadotacion)){
$b++;
        $cantidad=$fila["cantidad"];
        $fechaentrega=$fila["fechaent"];
        $producto=$fila["nombreprod"];
        $iddot=$fila["iddot"];
        
         if($fila["tipoprod"]==1){
            if($fila["pazysalvo"]==1){
            $pys0="A paz y Salvo: Si";
            }else{
            $pys0="A paz y Salvo: No";
            }
        }else{
            $pys0="Consumible";
        }


	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell($w,$h,"$b Consecutivo $iddot Elemento $producto",$border=0,$align='J',$fill=0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,"Cantidad: $cantidad, Fecha de Entrega: $fechaentrega, $pys0 ",$border=0,$align='J',$fill=0);
	$pdf->Ln();

}

$pdf->Ln();
$pdf->Ln();
$texto10="
___________________________________			                                    ____________________________________
C.C._______________________________			                                    C.C.________________________________
ALMACEN $razonsocial                                                                                      REPRESENTANTE CLIENTE
";
$pdf->SetFont('Arial','B',8);
$w=185;
$h=4;
$pdf->MultiCell($w,$h,$texto10,$border=0,$align='J',$fill=0);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;

require('saludoslis.php');
$pdf->Output();
?>
