<?php
session_start();
set_time_limit('300');

@require('funciones2.php');
@require (dirname (__FILE__) . "/class-excel-xml.inc.php");

$link=conectarim();

$sql="SELECT $_SESSION[campos] FROM $_SESSION[tabla] WHERE $_SESSION[condiciones] AND `sucursal`='$_SESSION[sucur]' LIMIT 1000";
$result=@mysql_query($sql);

$xls = new Excel_XML;
$ini=0;

if($_SESSION[campos]!="*"){
		
$cadena=explode(",","$_SESSION[campos]");
$num=count($cadena);

	for($ini=0;$ini<$num;$ini++){
	$campo=$cadena[$ini];
        $cab[0][$ini]=strtoupper($campo);
	}
	
}else{
$cadena=explode(",","$_SESSION[tabla]");
$sql2="DESCRIBE $cadena[0]";
$result2=@mysql_query($sql2);
$num=@mysql_num_rows($result2);

for($ini=0;$ini<$num;$ini++){

$campo=@mysql_result($result2,$ini);
    	$cab[0][$ini]=strtoupper($campo);
	}	
}

$xls->addArray ($cab);

    while($row = mysql_fetch_row($result)){

    	$doc = array (
    	$row
    	);
	$xls->addArray ($doc);
	}
	
$xls->generateXML (time());

?>
