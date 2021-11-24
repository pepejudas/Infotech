<?php
/*
 * Created on 11/07/2007
 *  *ingeniero: Ferley Ardila Caicedo
 */
session_start();
$a = "localhost";
@$link = @mysql_connect($a, $_SESSION['usua'],"");
@mysql_select_db("empresasvigilancia",$link);

/******************************************************************************
para comprobacion del requerimiento de autentificacion y enlace con bd @mysql
******************************************************************************/

	if (!$link){
		echo "<br>\n<h2>primero debe ingresar a la pagina de autentificacion de usuarios!</h2>";
		echo "<h3><div align=left><A HREF=\"index.php\">Inicio</A></div><h3>";
	exit();
	}
	if (! @mysql_select_db("empresasvigilancia",$link)){
	exit();
	}
	if ($_SESSION['usua']=="vigilantes" or $_SESSION['usua']=="radiooperadores"){
		echo "<br>\n<h2>No tiene permiso para acceder a esta informacion</h2>";
		echo "<h3><div align=left><A HREF=\"inicio.php\">Inicio</A></div><h3>";
		echo "<h3><div align=left><A HREF=\"index.php\">Salir</A></div><h3>";
	exit();
	}
//consulta de fecha

$fecha=getdate(time());
$cad=$fecha[month].$fecha[year];

//consulta de socios

$p=0;
$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=@mysql_query($sql2);
$li=@mysql_num_rows($result2);

  include_once "Spreadsheet/Excel/Writer.php";
  $xls =& new Spreadsheet_Excel_Writer();
  $xls->send("reportecontrolturnos.xls");

while($p<$li){
	$nombresocio=@mysql_result($result2,$p,nombres);
	//$idsocio=@mysql_result($result2,$p,id);	
  	$sheet =& $xls->addWorksheet($nombresocio);
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,'cedula',$format);
	$sheet->write(0,1,'apellidos y nombres',$format);

	//$cont='$fila'.$idsocio;
	
	for($i=1;$i<32;$i++){
	$bs='dia'.$i;
	$sheet->write(0,$i+2,$bs,$format);	
	}
	for($i=34;$i<65;$i++){
	$m=$i-33;
	$bus='cod'.$m;
	$sheet->write(0,$i,$bus,$format);	
	}
	

	$cont=2;
	$k=0;
	$escribe1=0;
	
	
	$sql1="SELECT * FROM controlturnos WHERE `controlturnos`.`mescontrol` LIKE '$cad' ORDER BY $_SESSION[ord]"; 
	$result1=@mysql_query($sql1);
	$jh=@mysql_num_rows($result1);

	while($k<$jh){

	//variables de escritura

	$escribe1=0;
	$escribe2=0;
	$escribe3=0;
	$escribe4=0;
	$escribe5=0;
	$escribe6=0;
	$escribe7=0;
	$escribe8=0;
	$escribe9=0;
	$escribe10=0;
	$escribe11=0;
	$escribe12=0;
	$escribe13=0;
	$escribe14=0;
	$escribe15=0;
	$escribe16=0;
	$escribe17=0;
	$escribe18=0;
	$escribe19=0;
	$escribe20=0;
	$escribe21=0;
	$escribe22=0;
	$escribe23=0;
	$escribe24=0;
	$escribe25=0;
	$escribe26=0;
	$escribe27=0;
	$escribe28=0;
	$escribe29=0;
	$escribe30=0;
	$escribe31=0;

	$cedula=@mysql_result($result1,$k,cedulacontrol);
	$cliente=@mysql_result($result1,$k,cod1);
	$turno=@mysql_result($result1,$k,d1);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,3,$turno);
	$sheet->write($cont,34,$cliente);
	$escribe1=1;
	}}
	
	$cliente=@mysql_result($result1,$k,cod2);
	$turno=@mysql_result($result1,$k,d2);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,4,$turno);
	$sheet->write($cont,35,$cliente);
	$escribe2=1;		
	}}
	
	$cedula=@mysql_result($result1,$k,cedulacontrol);
	$cliente=@mysql_result($result1,$k,cod3);
	$turno=@mysql_result($result1,$k,d3);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,5,$turno);
	$sheet->write($cont,36,$cliente);
	$escribe3=1;
	}}
	
	$cliente=@mysql_result($result1,$k,cod4);
	$turno=@mysql_result($result1,$k,d4);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,6,$turno);
	$sheet->write($cont,37,$cliente);
	$escribe4=1;		
	}}

	$cliente=@mysql_result($result1,$k,cod5);
	$turno=@mysql_result($result1,$k,d5);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,7,$turno);
	$sheet->write($cont,38,$cliente);
	$escribe5=1;		
	}}

	$cliente=@mysql_result($result1,$k,cod6);
	$turno=@mysql_result($result1,$k,d6);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,8,$turno);
	$sheet->write($cont,39,$cliente);
	$escribe6=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod7);
	$turno=@mysql_result($result1,$k,d7);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,9,$turno);
	$sheet->write($cont,40,$cliente);
	$escribe7=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod8);
	$turno=@mysql_result($result1,$k,d8);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,10,$turno);
	$sheet->write($cont,41,$cliente);
	$escribe8=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod9);
	$turno=@mysql_result($result1,$k,d9);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,11,$turno);
	$sheet->write($cont,42,$cliente);
	$escribe9=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod10);
	$turno=@mysql_result($result1,$k,d10);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,12,$turno);
	$sheet->write($cont,43,$cliente);
	$escribe10=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod11);
	$turno=@mysql_result($result1,$k,d11);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,13,$turno);
	$sheet->write($cont,44,$cliente);
	$escribe11=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod12);
	$turno=@mysql_result($result1,$k,d12);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,14,$turno);
	$sheet->write($cont,45,$cliente);
	$escribe12=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod13);
	$turno=@mysql_result($result1,$k,d13);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,15,$turno);
	$sheet->write($cont,46,$cliente);
	$escribe13=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod14);
	$turno=@mysql_result($result1,$k,d14);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,16,$turno);
	$sheet->write($cont,47,$cliente);
	$escribe14=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod15);
	$turno=@mysql_result($result1,$k,d15);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,17,$turno);
	$sheet->write($cont,48,$cliente);
	$escribe15=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod16);
	$turno=@mysql_result($result1,$k,d16);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,18,$turno);
	$sheet->write($cont,49,$cliente);
	$escribe16=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod17);
	$turno=@mysql_result($result1,$k,d17);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,19,$turno);
	$sheet->write($cont,50,$cliente);
	$escribe17=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod18);
	$turno=@mysql_result($result1,$k,d18);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,20,$turno);
	$sheet->write($cont,51,$cliente);
	$escribe18=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod19);
	$turno=@mysql_result($result1,$k,d19);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,21,$turno);
	$sheet->write($cont,52,$cliente);
	$escribe19=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod20);
	$turno=@mysql_result($result1,$k,d20);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,22,$turno);
	$sheet->write($cont,53,$cliente);
	$escribe20=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod21);
	$turno=@mysql_result($result1,$k,d21);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,23,$turno);
	$sheet->write($cont,54,$cliente);
	$escribe21=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod22);
	$turno=@mysql_result($result1,$k,d22);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,24,$turno);
	$sheet->write($cont,55,$cliente);
	$escribe22=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod23);
	$turno=@mysql_result($result1,$k,d23);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,25,$turno);
	$sheet->write($cont,56,$cliente);
	$escribe23=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod24);
	$turno=@mysql_result($result1,$k,d24);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,26,$turno);
	$sheet->write($cont,57,$cliente);
	$escribe24=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod25);
	$turno=@mysql_result($result1,$k,d25);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,27,$turno);
	$sheet->write($cont,58,$cliente);
	$escribe25=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod26);
	$turno=@mysql_result($result1,$k,d26);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,28,$turno);
	$sheet->write($cont,59,$cliente);
	$escribe26=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod27);
	$turno=@mysql_result($result1,$k,d27);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,29,$turno);
	$sheet->write($cont,60,$cliente);
	$escribe27=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod28);
	$turno=@mysql_result($result1,$k,d28);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,30,$turno);
	$sheet->write($cont,61,$cliente);
	$escribe28=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod29);
	$turno=@mysql_result($result1,$k,d29);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,31,$turno);
	$sheet->write($cont,62,$cliente);
	$escribe29=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod30);
	$turno=@mysql_result($result1,$k,d30);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,32,$turno);
	$sheet->write($cont,63,$cliente);
	$escribe30=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod31);
	$turno=@mysql_result($result1,$k,d31);
	if($turno!="" and $turno!=0){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,33,$turno);
	$sheet->write($cont,64,$cliente);
	$escribe31=1;		
	}}


	$k++;if($escribe1==1 or $escribe2==1 or $escribe3==1 or $escribe4==1 or $escribe5==1 or $escribe6==1 or $escribe7==1 or $escribe8==1 or $escribe9==1 or $escribe10==1 or $escribe11==1 or $escribe12==1 or $escribe13==1 or $escribe14==1 or $escribe15==1 or $escribe16==1 or $escribe17==1 or $escribe18==1 or $escribe19==1 or $escribe20==1 or $escribe21==1 or $escribe22==1 or $escribe23==1 or $escribe24==1 or $escribe25==1 or $escribe26==1 or $escribe27==1 or $escribe28==1 or $escribe29==1 or $escribe30==1 or $escribe31==1){$cont++;}
	}
	
	
$p++;
}

  

  $xls->close();
?>  

