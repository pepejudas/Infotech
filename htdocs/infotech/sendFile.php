<?php

ini_set('display_errors', 1);

session_start();
set_time_limit(500);

@require('funciones2.php');

validar("","","", 1054);

$fecha = getdate(time());

if($_SESSION['mes1']!="" && $_SESSION['ano1']!=""){
$mes=convertirmesaced2($_SESSION['mes1'], $_SESSION['ano1']);
}else{
exit("no ha seleccionado fecha de reporte");
}

require('Spreadsheet/Excel/Writer.php');
$xls =& new Spreadsheet_Excel_Writer();

$inisocio=0;
$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=@mysql_query($sql2);
$limsocio=@mysql_num_rows($result2);

//print_r($sql2);

for($inisocio=0;$inisocio<$limsocio;$inisocio++){

	$nombresocio0=@mysql_result($result2,$inisocio,"nombres");
	$cedulasocio=@mysql_result($result2,$inisocio,"cedula");
	$nombresocio='cedulaSocio'.$cedulasocio;
	
	$sheet =& $xls->addWorksheet(recortarcadena($nombresocio, 12));
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,utf8_decode($razon." ".$nombresocio0),$format_bold);
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
	
	$consultap="SELECT * FROM controlturnos LEFT JOIN personalactivo ON personalactivo.cedula = controlturnos.cedulacontrol LEFT JOIN clientes ON controlturnos.mescontrol LIKE '$mes' WHERE
        ( controlturnos.cod1 LIKE clientes.codigo OR
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

		// sending query
		$table = 'controlturnos';
$result = mysql_query($consultap);
if (!$result) {
    die("Query to show fields from table failed");
}

$fields_num = mysql_num_fields($result);

$fecha = time();
$nombreArchivo = "../archivos/". $fecha . "_test.html";

$myfile = fopen($nombreArchivo, "w") or die("Unable to open file!");

$cabecera = "";
$cabecera = "<h1>Table: {$table}</h1>";
$cabecera .= "<table border='1'><tr>";
fwrite($myfile, $cabecera);

// printing table headers
$cabeceralinea = "";

for($i=0; $i<$fields_num; $i++)
{	
    $field = mysql_fetch_field($result);
    $cabeceralinea .= "<td>{$field->name}</td>";
}

$cabeceralinea .= "</tr>\n";
// printing table rows

fwrite($myfile, $cabeceralinea);

while($row = mysql_fetch_row($result))
{
	$lineaPaciente = "";
    $lineaPaciente .= "<tr>";

    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
    foreach($row as $cell)
        $lineaPaciente .= "<td>$cell</td>";

    $lineaPaciente .= "</tr>\n";
	
	fwrite($myfile, $lineaPaciente);
}

mysql_free_result($result);

fclose($myfile);

$filename = $nombreArchivo;

if(file_exists($filename)){

    //Get file type and set it as Content Type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    header('Content-Type: ' . finfo_file($finfo, $filename));
    finfo_close($finfo);

    //Use Content-Disposition: attachment to specify the filename
    header('Content-Disposition: attachment; filename='.basename($filename));

    //No cache
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    //Define file size
    header('Content-Length: ' . filesize($filename));

    ob_clean();
    flush();
    readfile($filename);
    exit;
}
}
?>