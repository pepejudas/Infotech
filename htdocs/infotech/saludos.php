<?php
/*
 * Created on 25/08/2007
 *
 *ingeniero: Ferley Ardila Caicedo
 */
    $link=conectarim();

 	$fecha=getdate(time());
 	$ano=$fecha[year];
 	$mes=$fecha[month];
	$dia=$fecha[mday];
	$hora=$fecha[hour];
	$min=$fecha[minutes];
	
	$sintx="SELECT * FROM paraminfotech JOIN seguridadsuper LIMIT 1";
	$resx=@mysql_query($sintx, $link);
	$version=@mysql_result($resx,0,"version");
	$org=@mysql_result($resx,0,"org");
        $razonsocial=@mysql_result($resx,0,"razonsocial");
	$sql="SELECT * FROM sucursales WHERE sucursales.id ='$_SESSION[sucur]'";
	$cons=@mysql_query($sql, $link);
	$ciudad=@mysql_result($cons,0,"ciudad");
	
	if($_SESSION[sucur]=="%"){$ciudad="Central";}
	
	echo '<div id="piepagina"><div><b>'.$_SESSION['persona']."</b></div><div><b>".$dia."-".$mes."-".$ano."</b></div><div><b>".$ciudad."</b></div>
	<div><b>Infotech $version</b></div>
	<div><b>$org</b></div>
	<div><b>(571) 4208107 - (571) 3132773930</b></div></div>";
?>