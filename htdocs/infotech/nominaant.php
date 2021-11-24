<?php
session_start();
set_time_limit(500);
@require('funciones2.php');

if($_SESSION['iuj345iuh']!=1){
	validar($_POST[nombre], $_POST[contra], $_POST[nivel]);	
}
conectar2($_SESSION['usua'],"2");

	if ($_SESSION['usua']=="vigilantes" or $_SESSION['usua']=="radiooperadores"){
		echo "<br>\n<h2>No tiene permiso para acceder a esta informacion</h2>";
		echo "<h3><div align=left><A HREF=\"inicio.php\">Inicio</A></div><h3>";
		echo "<h3><div align=left><A HREF=\"index.php\">Salir</A></div><h3>";
	exit();
	}

$fecha=getdate(time());
switch($fecha[month]):
			case "January": $cad="December".$fecha[year]-1;break;
			case "February": $cad="January".$fecha[year]; break;
			case "March": $cad="February".$fecha[year]; break;
			case "April": $cad="March".$fecha[year]; break;
			case "May": $cad="April".$fecha[year]; break;
			case "June": $cad="May".$fecha[year]; break;
			case "July": $cad="June".$fecha[year]; break;
			case "August": $cad="July".$fecha[year]; break;
			case "September": $cad="August".$fecha[year]; break;
			case "October": $cad="September".$fecha[year]; break;
			case "November": $cad="October".$fecha[year]; break;
			case "December": $cad="November".$fecha[year]; break;
endswitch;

  require("Spreadsheet/Excel/Writer.php");
  $xls =& new Spreadsheet_Excel_Writer();
  $xls->send("reportecontrolturnos.xls");
  
  	$fecha=getdate(time());
	$mes=$cad;
	
$inisocio=0;
$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=@mysql_query($sql2);
$limsocio=@mysql_num_rows($result2);

for($inisocio=0;$inisocio<$limsocio;$inisocio++){
	
	$nombresocio=@mysql_result($result2,$inisocio,nombres);
	$cedulasocio=@mysql_result($result2,$inisocio,cedula);
  	$sheet =& $xls->addWorksheet($nombresocio);
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,'cedula',$format);
	$sheet->write(0,1,'apellidos y nombres',$format);
	
	$consultac="SELECT * FROM clientes WHERE clientes.duenopuesto LIKE '$cedulasocio'";	
	$resultaclientes=@mysql_query($consultac);
	$iniclie=0;
	$limclie=@mysql_num_rows($resultaclientes);
	
	for($iniclie=0;$iniclie<$limclie;$iniclie++){
	$cliente=@mysql_result($resultaclientes,$iniclie,codigo);	
	$clientesocio[$cliente]=1;	
	}
	
	for($i=1;$i<32;$i++){
	$bs='dia'.$i;
	$sheet->write(0,$i+2,$bs,$format);	
	}
	for($i=34;$i<65;$i++){
	$m=$i-33;
	$bus='cod'.$m;
	$sheet->write(0,$i,$bus,$format);	
	}
	
	switch ($_SESSION[ord]) {
		case "codigo":
			$criterio="personalactivo.codigo";
			break;
		case "cedulacontrol":
			$criterio="controlturnos.cedulacontrol";
			break;
		case "apellidos":
			$criterio="personalactivo.apellidos";
			break;
		default:
		$criterio="personalactivo.codigo";
			break;
	}
	
	$consultap="SELECT * FROM controlturnos, personalactivo, clientes WHERE
	personalactivo.cedula LIKE controlturnos.cedulacontrol AND controlturnos.mescontrol LIKE '$mes' 
	AND (controlturnos.cod1 LIKE clientes.codigo OR
		controlturnos.cod1 LIKE clientes.codigo OR
		controlturnos.cod2 LIKE clientes.codigo OR
		controlturnos.cod3 LIKE clientes.codigo OR
		controlturnos.cod4 LIKE clientes.codigo OR
		controlturnos.cod5 LIKE clientes.codigo OR
		controlturnos.cod6 LIKE clientes.codigo OR
		controlturnos.cod7 LIKE clientes.codigo OR
		controlturnos.cod8 LIKE clientes.codigo OR
		controlturnos.cod9 LIKE clientes.codigo OR
		controlturnos.cod10 LIKE clientes.codigo OR
		controlturnos.cod11 LIKE clientes.codigo OR
		controlturnos.cod12 LIKE clientes.codigo OR
		controlturnos.cod13 LIKE clientes.codigo OR
		controlturnos.cod14 LIKE clientes.codigo OR
		controlturnos.cod15 LIKE clientes.codigo OR
		controlturnos.cod16 LIKE clientes.codigo OR
		controlturnos.cod17 LIKE clientes.codigo OR
		controlturnos.cod18 LIKE clientes.codigo OR
		controlturnos.cod19 LIKE clientes.codigo OR
		controlturnos.cod20 LIKE clientes.codigo OR
		controlturnos.cod21 LIKE clientes.codigo OR
		controlturnos.cod22 LIKE clientes.codigo OR
		controlturnos.cod23 LIKE clientes.codigo OR
		controlturnos.cod23 LIKE clientes.codigo OR
		controlturnos.cod25 LIKE clientes.codigo OR
		controlturnos.cod26 LIKE clientes.codigo OR
		controlturnos.cod27 LIKE clientes.codigo OR
		controlturnos.cod28 LIKE clientes.codigo OR
		controlturnos.cod29 LIKE clientes.codigo OR
		controlturnos.cod30 LIKE clientes.codigo OR
		controlturnos.cod31 LIKE clientes.codigo) 
		AND (controlturnos.cod1 NOT LIKE 'NULL' OR
		controlturnos.cod1 NOT LIKE 'NULL' OR
		controlturnos.cod2 NOT LIKE 'NULL' OR
		controlturnos.cod3 NOT LIKE 'NULL' OR
		controlturnos.cod4 NOT LIKE 'NULL' OR
		controlturnos.cod5 NOT LIKE 'NULL' OR
		controlturnos.cod6 NOT LIKE 'NULL' OR
		controlturnos.cod7 NOT LIKE 'NULL' OR
		controlturnos.cod8 NOT LIKE 'NULL' OR
		controlturnos.cod9 NOT LIKE 'NULL' OR
		controlturnos.cod10 NOT LIKE 'NULL' OR
		controlturnos.cod11 NOT LIKE 'NULL' OR
		controlturnos.cod12 NOT LIKE 'NULL' OR
		controlturnos.cod13 NOT LIKE 'NULL' OR
		controlturnos.cod14 NOT LIKE 'NULL' OR
		controlturnos.cod15 NOT LIKE 'NULL' OR
		controlturnos.cod16 NOT LIKE 'NULL' OR
		controlturnos.cod17 NOT LIKE 'NULL' OR
		controlturnos.cod18 NOT LIKE 'NULL' OR
		controlturnos.cod19 NOT LIKE 'NULL' OR
		controlturnos.cod20 NOT LIKE 'NULL' OR
		controlturnos.cod21 NOT LIKE 'NULL' OR
		controlturnos.cod22 NOT LIKE 'NULL' OR
		controlturnos.cod23 NOT LIKE 'NULL' OR
		controlturnos.cod23 NOT LIKE 'NULL' OR
		controlturnos.cod25 NOT LIKE 'NULL' OR
		controlturnos.cod26 NOT LIKE 'NULL' OR
		controlturnos.cod27 NOT LIKE 'NULL' OR
		controlturnos.cod28 NOT LIKE 'NULL' OR
		controlturnos.cod29 NOT LIKE 'NULL' OR
		controlturnos.cod30 NOT LIKE 'NULL' OR
		controlturnos.cod31 NOT LIKE 'NULL')
		AND clientes.duenopuesto LIKE '$cedulasocio' AND clientes.sucursal LIKE '$_SESSION[sucur]' ORDER BY '$criterio' ASC";

	$inipersonas=0;	
	$resultapersonas=@mysql_query($consultap);
	$limpersonas=@mysql_num_rows($resultapersonas);
	
	for($inipersonas;$inipersonas<$limpersonas;$inipersonas++){

		if($limpersonas!=0 and $cedulapersona!=@mysql_result($resultapersonas,$inipersonas,cedula)){
		
		$fila=$fila+2;
		$columna=0;
			
		$cedulapersona=@mysql_result($resultapersonas,$inipersonas,cedula);
		$nombrepersona=@mysql_result($resultapersonas,$inipersonas,apellidos). " ".@mysql_result($resultapersonas,$inipersonas,nombre);
		$sheet->write($fila,$columna,$cedulapersona,$format);
		$sheet->write($fila,$columna+1,$nombrepersona,$format);
		
			$initurno=1;
			for($initurno=1;$initurno<32;$initurno++){
			$tdiurno=@mysql_result($resultapersonas,$inipersonas,"d".$initurno);
			$tnocturno=@mysql_result($resultapersonas,$inipersonas,"n".$initurno);
			$codturno=@mysql_result($resultapersonas,$inipersonas,"cod".$initurno);
				if($clientesocio[$codturno]==1){	
				$sheet->write($fila,$columna+$initurno+2,$tdiurno,"");
				$sheet->write($fila+1,$columna+$initurno+2,$tnocturno,"");
				$sheet->write($fila,$columna+$initurno+33,$codturno,"");
				}
			}
		}
	}	
		$clientesocio="";
		$fila=0;
}


  $xls->close();
  
?>  
