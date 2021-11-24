<?php
/*
 * Created on 5/01/2008
 *
 * diseñado por ferley ardila
 * By xsite information technology company ltda
 */
 	$fecha=getdate(time());
 	$ano=$fecha[year];
 	$mes=$fecha[month];
	$dia=$fecha[mday];
	$hora=$fecha[hour];
	$min=$fecha[minutes];
	
	$sintx="SELECT * FROM paraminfotech LIMIT 1";
	$resx=@mysql_query($sintx);
	$version=@mysql_result($resx,0,'version');
	$org=@mysql_result($resx,0,'org');
	
	$piepagina="Infotech $version, elaborado por $_SESSION[persona], el ".$dia."-".$mes."-".$ano." $org";

        $pdf->SetFont('Arial','B',5);
	$pdf->Text($x11,$y11,$piepagina);

?>
