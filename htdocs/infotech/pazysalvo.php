<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1059);

	$vector0=explode("/",$_SERVER['HTTP_REFERER']);
	$elementos0=count($vector0);
	$form0=$vector0[$elementos0-1];
	
require('fpdf/fpdf.php');
$pdf=new FPDF('P','mm','legal');
	
switch($form0){
	
case "documentosdotacion.php";
$pdf->AddPage();	
$sql1="SELECT * FROM personalactivo, dotacion, productos WHERE personalactivo.cedula = dotacion.ceduladot AND dotacion.idprod = productos.id AND `personalactivo`.`cedula` ='$_SESSION[cedulamod]' ORDER BY iddot";

$sql29="SELECT * FROM seguridadsuper";
$consseg=@mysql_query($sql29);
$direccions=@mysql_result($consseg,0,direccion)." BARRIO ".@mysql_result($consseg,0,barrio);
$result=@mysql_query($sql1);
$lim=@mysql_num_rows($result);
$nombre=decod(@mysql_result($result,0,nombre));
$apellido=decod(@mysql_result($result,0,apellidos));
$cedula=decod(@mysql_result($result,0,cedula));
$contrata=decod(@mysql_result($contr,0,contrato1));
$razonsocial=decod(@mysql_result($consseg,0,razonsocial));

switch(@mysql_result($result,0,cargo)):
			
			case 1: $cargo="DIRECTIVO"; break;
	 		case 3: $cargo="DIRECTOR DE OPERACIONES"; break;
	 		case 4: $cargo="ENTRENADOR CANINO"; break;
	 		case 5: $cargo="ESCOLTA"; break;
	 		case 6: $cargo="GUIA CANINO"; break;
	 		case 7: $cargo="MANEJADOR CANINO"; break;
	 		case 8: $cargo="REPRESENTANTE LEGAL"; break;
	 		case 9: $cargo="SUPERVISOR"; break;
	 		case 10: $cargo="SUPERVISOR MEDIO TECNOLOGICO"; break;
	 		case 11: $cargo="TECNICO MEDIO TECNOLOGICO"; break;
	 		case 12: $cargo="GUARDA DE SEGURIDAD"; break;
	 		case 13: $cargo="OPERADOR MEDIO TECNOLOGICO"; break;
	 		case 14: $cargo="TRIPULANTE"; break;
	 		
endswitch;

$direccion=decod(@mysql_result($result,0,direccion)." BARRIO ".@mysql_result($result,0,barrio));
$ciudadnacim=decod(@mysql_result($result,0,coddeptonacim).@mysql_result($result,0,codciudadnacim));
$fechanacim=decod(@mysql_result($result,0,fechanacimiento));
$fechaing=decod(@mysql_result($result,0,fechaingreso));
$carnet=decod(@mysql_result($result,0,carnetinterno));
$ciudadres=decod(@mysql_result($result,0,codigoresidencia));
$codbusca=decod(@mysql_result($result,0,codigo));
$sql2="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resulta=@mysql_query($sql2);
$sql15="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$codbusca'";
$resultac=@mysql_query($sql15);
$cod=decod(@mysql_result($resultac,0,codigo));
if($cod==""){
echo '<h1>!Error debe actualizar el codigo del cliente asignado <br>a esta persona de lo contrario no puede ser generado <br> el contrato de trabajo!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';
exit();	
};
if($cod=="relevantes"){
echo '<h1>!Error para relevantes utilice contrato a un año!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';
exit();	
}
//ciudad de residencia
switch($ciudadres):
			case "08001": $city="BARRANQUILLA"; break;
 	 		case "11001": $city="BOGOTA"; break;
 	 		case "76001": $city="CALI"; break;
 	 		case "25269": $city="FACATATIVA"; break;			   	 		
 	 		case "25286": $city="FUNZA"; break; 	 		
 	 		case "25377": $city="LA CALERA"; break; 	 		
 	 		case "25430": $city="MADRID"; break; 	 		
 	 		case "05001": $city="MEDELLIN"; break;
 	 		case "25473": $city="MOSQUERA"; break; 	 		
 	 		case "25740": $city="SIBATE"; break; 	 		
	 		case "25754": $city="SOACHA"; break;
 	 		case "50001": $city="VILLAVICENCIO"; break;
 	 		case "15759": $city="SOGAMOSO"; break;
endswitch;

if(@mysql_result($result,0,codigo)==""){echo '<h1>!Error debe actualizar el codigo del cliente asignado <br>a esta persona de lo contrario no puede ser generado <br> el contrato de trabajo!</h1><br><a href="documentospersonalactivo.php" target="_top"><h3>regresar</h3></a>';exit();}
$nombrecliente=@mysql_result($resulta,0,nombrecliente);

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
                                                                                                         ".$carnet."

                                    $razonsocial
                                    PAZ Y SALVO DE ALMACEN 
			                          ";
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$pdf->Write(5,$texto);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$texto2="
NOMBRES DEL TRABAJADOR:		       $nombre"." "."$apellido
IDENTIFICADO CON CC. No:	              $cedula
DIRECCION DEL TRABAJADOR:	      $direccion
LUGAR Y FECHA DE NACIMIENTO:  ".$ciudadnacim." ".$fechanacim."
CARGO A DESEMPE".utf8_decode(Ñ)."AR:                  $cargo 
FECHA DE INICIO DE LABORES:	      $fechaing
CLIENTE:                                              $nombrecliente
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

for($i=0;$i<$lim;$i++){

	$prod=decod(@mysql_result($result,$i, "nombreprod")." Ref:".@mysql_result($result,$i, "referencia")." Marca:".@mysql_result($result,$i, "marca"));
	$cantidad=@mysql_result($result,$i, "cantidad");
        $undsdev=@mysql_result($result,$i, "cantidadevuelta");
        
        if($undsdev>0){$undsdevv=$undsdev;}else{$undsdevv=0;}

	$fecha=@mysql_result($result,$i, "fechaent");
	$b=@mysql_result($result,$i, "iddot");
        $entregadopor=@mysql_result($result,$i, "usuaent");
        $recibidopor=@mysql_result($result,$i, "usuarec");

         if(@mysql_result($result,$i,"tipoprod")==1){
            if(@mysql_result($result,$i,"pazysalvo")==1){
            $pys0="A paz y Salvo: Si";
            }else{
            $pys0="A paz y Salvo: No";
            }
        }else{
            $pys0="Consumible";
        }

	$pdf->SetFont('Arial','B',8);	
	$pdf->MultiCell($w,$h,"Dotacion $b, Elemento: $prod",$border=0,$align='J',$fill=0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,"Cantidad: $cantidad, Unidades Devueltas: $undsdevv, Fecha de Entrega: $fecha, $pys0",$border=0,$align='J',$fill=0);
        $pdf->MultiCell($w,$h,"Entregado por: $entregadopor, Recibido por: $recibidopor",$border=0,$align='J',$fill=0);
        
        if($b!==@mysql_result($result,$i+1, "iddot")){
            $pdf->MultiCell($w,"3","",$border=0,$align='R',$fill=0);
            $pdf->MultiCell($w,"3","Final Dotacion: $b",$border=1,$align='R',$fill=0);
            }

	$pdf->Ln();
}

$pdf->Ln();
$pdf->Ln();
$texto10="
___________________________________			                                    ____________________________________
C.C._______________________________			                                    C.C.________________________________
ALMACEN $razonsocial                                    EL TRABAJADOR	
";
$pdf->SetFont('Arial','B',8);
$w=185;
$h=4;
$pdf->MultiCell($w,$h,$texto10,$border=0,$align='J',$fill=0);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;
break;
case "documentosdotacioncliente.php":
$pdf->AddPage();
$sql1="SELECT * FROM clientes, dotacion, productos WHERE clientes.codigo = dotacion.ceduladot AND dotacion.idprod = productos.id AND `clientes`.`codigo` ='$_SESSION[cedulamod]' ORDER BY iddot";

$sql29="SELECT * FROM seguridadsuper";
$consseg=@mysql_query($sql29);
$direccions=decod(@mysql_result($consseg,0,direccion)).decod(" BARRIO ".@mysql_result($consseg,0,barrio));
$razonsocial=decod(@mysql_result($consseg,0,razonsocial));

$result=@mysql_query($sql1);
$lim=@mysql_num_rows($result);
$nombrecliente=decod(@mysql_result($result,0,nombrecliente));
$administrador=decod(@mysql_result($result,0,nombreadministrador));
$nit=decod(@mysql_result($result,0,nit));
$codigo=decod(@mysql_result($result,0,codigo));
$direccion=recortarcadena(decod(@mysql_result($result,0,direccion)),30);

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
                                                                                                         ".$carnet."

                                    $razonsocial
                                    PAZ Y SALVO DE ALMACEN 
			                          ";
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$pdf->Write(5,$texto);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$texto2="
NOMBRES DEL CLIENTE:		       $nombrecliente
IDENTIFICADO CON NIT. No:	  $nit
DIRECCION DEL CLIENTE:	      $direccion
REPRESENTANTE:                    $administrador 
CODIGO ASIGNADO:                 $codigo
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
$h=4;
$pdf->SetFont('Arial','B',8);

$x=10;
$x1=200;
$y=115;

for($i=0;$i<$lim;$i++){

	$prod=decod(recortarcadena(@mysql_result($result,$i, nombreprod),30));
	$cantidad=@mysql_result($result,$i, cantidad);
	$fecha=@mysql_result($result,$i, fechaent);
	$b=@mysql_result($result,$i, iddot);
        $entregadopor=@mysql_result($result,$i, "usuaent");
        $recibidopor=@mysql_result($result,$i, "usuarec");

	//if(@mysql_result($result,$i,"pazysalvo")==1){$pys="Si";}else{$pys="No";}
        if(@mysql_result($result,$i,"tipoprod")==1){
            if(@mysql_result($result,$i,"pazysalvo")==1){
            $pys0="A paz y Salvo: Si";
            }else{
            $pys0="A paz y Salvo: No";
            }
        }else{
            $pys0="Consumible";
        }

	$pdf->SetFont('Arial','B',8);	
	$pdf->MultiCell($w,$h," Dotacion $b, Elemento: $prod",$border=0,$align='J',$fill=0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,"Cantidad: $cantidad, Fecha de Entrega: $fecha, $pys0",$border=0,$align='J',$fill=0);
	$pdf->MultiCell($w,$h,"Entregado por: $entregadopor, Recibido por: $recibidopor",$border=0,$align='J',$fill=0);
        
        if($b!==@mysql_result($result,$i+1, "iddot")){
            $pdf->MultiCell($w,"3","",$border=0,$align='R',$fill=0);
            $pdf->MultiCell($w,"3","Final Dotacion: $b",$border=1,$align='R',$fill=0);
        }
        
	$pdf->Ln();
}

$pdf->Ln();
$pdf->Ln();
$texto10="
___________________________________			                                    ____________________________________
C.C._______________________________			                                    C.C.________________________________
ALMACEN $razonsocial                                    EL TRABAJADOR	
";
$pdf->SetFont('Arial','B',8);
$w=185;
$h=4;
$pdf->MultiCell($w,$h,$texto10,$border=0,$align='J',$fill=0);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;	
 	
 	
 	
 break;	
case "documentosdotacioninterna.php":
$pdf->AddPage();
$sql1="SELECT * FROM departamentos, dotacion, productos WHERE departamentos.codigo = dotacion.ceduladot AND dotacion.idprod = productos.id AND `departamentos`.`codigo` ='$_SESSION[cedulamod]' ORDER BY iddot";
$sql29="SELECT * FROM seguridadsuper";
$consseg=@mysql_query($sql29);
$direccions=@mysql_result($consseg,0,direccion)." BARRIO ".@mysql_result($consseg,0,barrio);
$razonsocial=decod(@mysql_result($consseg,0,razonsocial));

$result=@mysql_query($sql1);
$lim=@mysql_num_rows($result);
$nombrecliente=decod(@mysql_result($result,0,nombredepto));
$responsable=decod(@mysql_result($result,0,responsable));
$codigo=decod(@mysql_result($result,0,codigo));

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
                                                                                                         ".$carnet."

                                    $razonsocial
                                    PAZ Y SALVO DE ALMACEN 
			                          ";
$pdf->SetFont('Arial','B',14);   
$pdf->Ln();
$pdf->Write(5,$texto);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$texto2="
NOMBRE DEL DEPARTAMENTO:		       $nombrecliente
RESPONSABLE:                                   $responsable
CODIGO ASIGNADO:                            $codigo
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
$h=4;
$pdf->SetFont('Arial','B',8);

$x=10;
$x1=200;
$y=115;

for($i=0;$i<$lim;$i++){

	$prod=decod(recortarcadena(@mysql_result($result,$i, nombreprod),30));
	$cantidad=@mysql_result($result,$i, cantidad);
	$fecha=@mysql_result($result,$i, fechaent);
	$b=@mysql_result($result,$i, iddot);
        $entregadopor=@mysql_result($result,$i, "usuaent");
        $recibidopor=@mysql_result($result,$i, "usuarec");

	 if(@mysql_result($result,$i,"tipoprod")==1){
            if(@mysql_result($result,$i,"pazysalvo")==1){
            $pys0="A paz y Salvo: Si,";
            }else{
            $pys0="A paz y Salvo: No,";
            }
        }else{
            $pys0="Consumible,";
        }
        
	$pdf->SetFont('Arial','B',8);	
	$pdf->MultiCell($w,$h,"Elemento: $prod",$border=0,$align='J',$fill=0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell($w,$h,"Cantidad: $cantidad, Fecha de Entrega: $fecha, $pys0 Dotacion $b",$border=0,$align='J',$fill=0);
	$pdf->MultiCell($w,$h,"Entregado por: $entregadopor, Recibido por: $recibidopor",$border=0,$align='J',$fill=0);

        if($b!==@mysql_result($result,$i+1, "iddot")){
            $pdf->MultiCell($w,"3","",$border=0,$align='R',$fill=0);
            $pdf->MultiCell($w,"3","Final Dotacion: $b",$border=1,$align='R',$fill=0);
        }

        $pdf->Ln();

}

$pdf->Ln();
$pdf->Ln();
$texto10="
___________________________________			                                    ____________________________________
C.C._______________________________			                                    C.C.________________________________
ALMACEN $razonsocial                                    EL TRABAJADOR	
";
$pdf->SetFont('Arial','B',8);
$w=185;
$h=4;
$pdf->MultiCell($w,$h,$texto10,$border=0,$align='J',$fill=0);

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$x11=20;
$y11=340;	
 	
 	
 	
 break;	



}
require('saludoslis.php');
$pdf->Output();
?>
