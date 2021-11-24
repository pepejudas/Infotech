<?php
session_start();
set_time_limit(500);
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
	
	
	$sql1="SELECT * FROM controlturnos WHERE `controlturnos`.`mescontrol` LIKE '$cad' ORDER BY cedulacontrol"; 
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
	
	/*
	$i=0;
	for($i==0;$i<5;$i++){
		
	$escribe1=0;
	$cedula=@mysql_result($result1,$k,cedulacontrol);
	$cliente=@mysql_result($result1,$k,cod.$i);
	$turnod=@mysql_result($result1,$k,d.$i);
	$turnon=@mysql_result($result1,$k,n.$i);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0) ){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,$i+3,$turnod);
	$sheet->write($cont+1,$i+3,$turnon);
	$sheet->write($cont,$i+34,$cliente);
	$escribe1=1;
	}}
	
	
	if($escribe1==1){$cont=$cont+2;}
	}
	*/
	
	$cedula=@mysql_result($result1,$k,cedulacontrol);
	$cliente=@mysql_result($result1,$k,cod1);
	$turnod=@mysql_result($result1,$k,d1);
	$turnon=@mysql_result($result1,$k,n1);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0) ){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,3,$turnod);
	$sheet->write($cont+1,3,$turnon);
	$sheet->write($cont,34,$cliente);
	$escribe1=1;
	}} 
	 
	$cliente=@mysql_result($result1,$k,cod2);
	$turnod=@mysql_result($result1,$k,d2);
	$turnon=@mysql_result($result1,$k,n2);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,4,$turnod); 
	$sheet->write($cont+1,4,$turnon);
	$sheet->write($cont,35,$cliente);
	$escribe2=1;		
	}}
	
	
	
	$cliente=@mysql_result($result1,$k,cod3);
	$turnod=@mysql_result($result1,$k,d3);
	$turnon=@mysql_result($result1,$k,n3);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,5,$turnod); $sheet->write($cont+1,5,$turnon);
	$sheet->write($cont,36,$cliente);
	$escribe3=1;
	}}
	
	$cliente=@mysql_result($result1,$k,cod4);
	$turnod=@mysql_result($result1,$k,d4);
	$turnon=@mysql_result($result1,$k,n4);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,6,$turnod); $sheet->write($cont+1,6,$turnon);
	$sheet->write($cont,37,$cliente);
	$escribe4=1;		
	}}

	$cliente=@mysql_result($result1,$k,cod5);
	$turnod=@mysql_result($result1,$k,d5);
	$turnon=@mysql_result($result1,$k,n5);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,7,$turnod); $sheet->write($cont+1,7,$turnon);
	$sheet->write($cont,38,$cliente);
	$escribe5=1;		
	}}

	$cliente=@mysql_result($result1,$k,cod6);
	$turnod=@mysql_result($result1,$k,d6);
	$turnon=@mysql_result($result1,$k,n6);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,8,$turnod); $sheet->write($cont+1,8,$turnon);
	$sheet->write($cont,39,$cliente);
	$escribe6=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod7);
	$turnod=@mysql_result($result1,$k,d7);
	$turnon=@mysql_result($result1,$k,n7);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,9,$turnod); $sheet->write($cont+1,9,$turnon);
	$sheet->write($cont,40,$cliente);
	$escribe7=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod8);
	$turnod=@mysql_result($result1,$k,d8);
	$turnon=@mysql_result($result1,$k,n8);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,10,$turnod); $sheet->write($cont+1,10,$turnon);
	$sheet->write($cont,41,$cliente);
	$escribe8=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod9);
	$turnod=@mysql_result($result1,$k,d9);
	$turnon=@mysql_result($result1,$k,n9);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,11,$turnod); $sheet->write($cont+1,11,$turnon);
	$sheet->write($cont,42,$cliente);
	$escribe9=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod10);
	$turnod=@mysql_result($result1,$k,d10);
	$turnon=@mysql_result($result1,$k,n10);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,12,$turnod); $sheet->write($cont+1,12,$turnon);
	$sheet->write($cont,43,$cliente);
	$escribe10=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod11);
	$turnod=@mysql_result($result1,$k,d11);
	$turnon=@mysql_result($result1,$k,n11);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,13,$turnod); $sheet->write($cont+1,13,$turnon);
	$sheet->write($cont,44,$cliente);
	$escribe11=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod12);
	$turnod=@mysql_result($result1,$k,d12);
	$turnon=@mysql_result($result1,$k,n12);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,14,$turnod); $sheet->write($cont+1,14,$turnon);
	$sheet->write($cont,45,$cliente);
	$escribe12=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod13);
	$turnod=@mysql_result($result1,$k,d13);
	$turnon=@mysql_result($result1,$k,n13);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,15,$turnod); $sheet->write($cont+1,15,$turnon);
	$sheet->write($cont,46,$cliente);
	$escribe13=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod14);
	$turnod=@mysql_result($result1,$k,d14);
	$turnon=@mysql_result($result1,$k,n14);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,16,$turnod); $sheet->write($cont+1,16,$turnon);
	$sheet->write($cont,47,$cliente);
	$escribe14=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod15);
	$turnod=@mysql_result($result1,$k,d15);
	$turnon=@mysql_result($result1,$k,n15);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,17,$turnod); $sheet->write($cont+1,17,$turnon);
	$sheet->write($cont,48,$cliente);
	$escribe15=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod16);
	$turnod=@mysql_result($result1,$k,d16);
	$turnon=@mysql_result($result1,$k,n16);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,18,$turnod); $sheet->write($cont+1,18,$turnon);
	$sheet->write($cont,49,$cliente);
	$escribe16=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod17);
	$turnod=@mysql_result($result1,$k,d17);
	$turnon=@mysql_result($result1,$k,n17);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,19,$turnod); $sheet->write($cont+1,19,$turnon);
	$sheet->write($cont,50,$cliente);
	$escribe17=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod18);
	$turnod=@mysql_result($result1,$k,d18);
	$turnon=@mysql_result($result1,$k,n18);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,20,$turnod); $sheet->write($cont+1,20,$turnon);
	$sheet->write($cont,51,$cliente);
	$escribe18=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod19);
	$turnod=@mysql_result($result1,$k,d19);
	$turnon=@mysql_result($result1,$k,n19);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,21,$turnod); $sheet->write($cont+1,21,$turnon);
	$sheet->write($cont,52,$cliente);
	$escribe19=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod20);
	$turnod=@mysql_result($result1,$k,d20);
	$turnon=@mysql_result($result1,$k,n20);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,22,$turnod); $sheet->write($cont+1,22,$turnon);
	$sheet->write($cont,53,$cliente);
	$escribe20=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod21);
	$turnod=@mysql_result($result1,$k,d21);
	$turnon=@mysql_result($result1,$k,n21);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,23,$turnod); $sheet->write($cont+1,23,$turnon);
	$sheet->write($cont,54,$cliente);
	$escribe21=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod22);
	$turnod=@mysql_result($result1,$k,d22);
	$turnon=@mysql_result($result1,$k,n22);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,24,$turnod); $sheet->write($cont+1,24,$turnon);
	$sheet->write($cont,55,$cliente);
	$escribe22=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod23);
	$turnod=@mysql_result($result1,$k,d23);
	$turnon=@mysql_result($result1,$k,n23);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,25,$turnod); $sheet->write($cont+1,25,$turnon);
	$sheet->write($cont,56,$cliente);
	$escribe23=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod24);
	$turnod=@mysql_result($result1,$k,d24);
	$turnon=@mysql_result($result1,$k,n24);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,26,$turnod); $sheet->write($cont+1,26,$turnon);
	$sheet->write($cont,57,$cliente);
	$escribe24=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod25);
	$turnod=@mysql_result($result1,$k,d25);
	$turnon=@mysql_result($result1,$k,n25);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,27,$turnod); $sheet->write($cont+1,27,$turnon);
	$sheet->write($cont,58,$cliente);
	$escribe25=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod26);
	$turnod=@mysql_result($result1,$k,d26);
	$turnon=@mysql_result($result1,$k,n26);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,28,$turnod); $sheet->write($cont+1,28,$turnon);
	$sheet->write($cont,59,$cliente);
	$escribe26=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod27);
	$turnod=@mysql_result($result1,$k,d27);
	$turnon=@mysql_result($result1,$k,n27);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,29,$turnod); $sheet->write($cont+1,29,$turnon);
	$sheet->write($cont,60,$cliente);
	$escribe27=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod28);
	$turnod=@mysql_result($result1,$k,d28);
	$turnon=@mysql_result($result1,$k,n28);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,30,$turnod); $sheet->write($cont+1,30,$turnon);
	$sheet->write($cont,61,$cliente);
	$escribe28=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod29);
	$turnod=@mysql_result($result1,$k,d29);
	$turnon=@mysql_result($result1,$k,n29);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,31,$turnod); $sheet->write($cont+1,31,$turnon);
	$sheet->write($cont,62,$cliente);
	$escribe29=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod30);
	$turnod=@mysql_result($result1,$k,d30);
	$turnon=@mysql_result($result1,$k,n30);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,32,$turnod); $sheet->write($cont+1,32,$turnon);
	$sheet->write($cont,63,$cliente);
	$escribe30=1;		
	}}


	$cliente=@mysql_result($result1,$k,cod31);
	$turnod=@mysql_result($result1,$k,d31);
	$turnon=@mysql_result($result1,$k,n31);
	if(($turnod!="" and $turnod!=0) or($turnon!="" and $turnon!=0)){
	$sql5="SELECT nombre, apellidos, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$cedula'";
	$result5=@mysql_query($sql5);
	$nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre); if($nombrepersona==" "){$sql5="SELECT nombre, apellidos, cedula FROM personalretirado WHERE `personalretirado`.`cedula`='$cedula'"; $result5=@mysql_query($sql5); $nombrepersona=@mysql_result($result5,0,apellidos)." ".@mysql_result($result5,0,nombre);}
	$sql6="SELECT * FROM clientes WHERE `clientes`.`codigo` LIKE '$cliente'";
	$result6=@mysql_query($sql6);
	$socio=@mysql_result($result6,0,duenopuesto);
	if($socio==$nombresocio){		
	$sheet->write($cont,0,$cedula); $sheet->write($cont,2,diurno); $sheet->write($cont+1,2,nocturno);
	$sheet->write($cont,1,$nombrepersona);
	$sheet->write($cont,33,$turnod); $sheet->write($cont+1,33,$turnon);
	$sheet->write($cont,64,$cliente);
	$escribe31=1;		
	}}

	
	$k++;if($escribe1==1 or $escribe2==1 or $escribe3==1 or $escribe4==1 or $escribe5==1 or $escribe6==1 or $escribe7==1 or $escribe8==1 or $escribe9==1 or $escribe10==1 or $escribe11==1 or $escribe12==1 or $escribe13==1 or $escribe14==1 or $escribe15==1 or $escribe16==1 or $escribe17==1 or $escribe18==1 or $escribe19==1 or $escribe20==1 or $escribe21==1 or $escribe22==1 or $escribe23==1 or $escribe24==1 or $escribe25==1 or $escribe26==1 or $escribe27==1 or $escribe28==1 or $escribe29==1 or $escribe30==1 or $escribe31==1){$cont=$cont+2;}
	}
	
	
	
$p++;
}

  

  $xls->close();
?>  
