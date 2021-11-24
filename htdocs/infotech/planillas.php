<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

//ini_set('display_errors', 1);

@require('funciones2.php');

validar("","","", 1060);

//set_time_limit(500);

$fecha=getdate(time());
$cad=convertirmesaced2($_SESSION['mes1'],$_SESSION['ano1']);
//require('fpdf/fpdf.php');
  require('Spreadsheet/Excel/Writer.php');
  $xls =& new Spreadsheet_Excel_Writer();
  //$xls->setTempDir('tmp/');
  //Creating the format
	$format_bold =& $xls->addFormat();
	$format_bold->setBold();
	
	$format_title =& $xls->addFormat();
	$format_title->setBold();
	$format_title->setColor('white');
	$format_title->setPattern(1);
	$format_title->setFgColor('gray');
	
	$format_agregar =& $xls->addFormat();
	$format_agregar->setBold();
	$format_agregar->setColor('white');
	$format_agregar->setPattern(1);
	$format_agregar->setFgColor('gray');
	$format_agregar->setAlign('merge');
	
	$formato3p =& $xls->addFormat();
	$formato3p->setBottom(1);
	
	$format0 =& $xls->addFormat();
	$format0->setSize(6);
	
  	$xls->send("reportecontrolturnos.xls");
  
  	$fecha=getdate(time());
	$mes=$cad;
	
$inisocio=0;
$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=@mysql_query($sql2);
$limsocio=@mysql_num_rows($result2);

$sql3="SELECT * FROM seguridadsuper LIMIT 1";
$result3=@mysql_query($sql3);
$razon=@mysql_result($result3, 0, "razonsocial")." "."Planillas Correspondientes al Mes: ".$_SESSION[mes1]." año: ".$_SESSION[ano1];
$numdias0=numdiasmes($_SESSION[mes1],$_SESSION[ano1]);

for($inisocio=0;$inisocio<$limsocio;$inisocio++){
	
	$nombresocio0=@mysql_result($result2,$inisocio,"nombres");
	$cedulasocio=@mysql_result($result2,$inisocio,"cedula");
	$nombresocio='cedulaSocio'.$cedulasocio;
  	$sheet =& $xls->addWorksheet(recortarcadena($nombresocio, 12));
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,utf8_decode($razon." ".$nombresocio0),$format_bold);
	$sheet->write(1,0,'cedula',$format_title);
	$sheet->write(1,1,'apellidos y nombres',$format_agregar);
	$sheet->write(1,2,'',$format_agregar);
	
	$consultac="SELECT * FROM clientes WHERE clientes.duenopuesto LIKE '$cedulasocio'";	
	$resultaclientes=@mysql_query($consultac);
	$iniclie=0;
	$limclie=@mysql_num_rows($resultaclientes);
	
	for($iniclie=0;$iniclie<$limclie;$iniclie++){
	$cliente=@mysql_result($resultaclientes,$iniclie,codigo);	
	$clientesocio[$cliente]=1;	
	}
	
	for($i=1;$i<$numdias0;$i++){
	$bs=$i;
	$sheet->write(1,$i+2,$bs,$format_title);	
	}
	
	$dia0=PrimerDiaMes($_SESSION["mes1"], $_SESSION["ano1"], 1);
	
	for($i=1;$i<$numdias0;$i++){//poner dias en encabezado
		$dia=PrimerDiaMes($_SESSION["mes1"], $_SESSION["ano1"], $i);
		$sheet->write(2,$i+2,$dia[0],$format_title);
	}
	
	//fijar encabezados de horas
	$sheet->write(2,$i+2,"HO",$format_title);
	$sheet->write(2,$i+3,"RN",$format_title);
	$sheet->write(2,$i+4,"FD",$format_title);
	$sheet->write(2,$i+5,"FN",$format_title);
	//fijar encabezado de total
	$sheet->write(2,$i+6,"Subsidio",$format_title);
	$sheet->write(2,$i+7,"Neto",$format_title);
	
	//fijar encabezados de liquidaciones de parafiscales
	$sheet->write(2,$i+8,"EPS",$format_title);
	$sheet->write(2,$i+9,"ARP",$format_title);
	$sheet->write(2,$i+10,"AFP",$format_title);
	
	//total pagar
	$sheet->write(2,$i+11,"Total",$format_title);
	
	$festivos=hallarfestivos($_SESSION["ano1"]);
	
	for($i=1;$i<$numdias0;$i++){//poner dias festivos en encabezado
		if($i<10){$indicedia="0$i";}else{$indicedia=$i;}
		if($festivos[$_SESSION["mes1"]][$indicedia]=="1"){
		$sheet->write(3,$i+2,"F",$format_title);	
		}
	}
	
	$sheet->setColumn(3,11,1.5);//ajustar ancho de columnas hasta la 9
	$sheet->setColumn(12,$i+1,2);//ajustar ancho de columnas mas de la 9 hasta fin de mes
	$sheet->setColumn($i+2,$i+11,4);//ajustar ancho de columnas de horas
	
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
	
	$fila=2;
	for($inipersonas;$inipersonas<$limpersonas;$inipersonas++){

		if($limpersonas!=0 and $cedulapersona!=@mysql_result($resultapersonas,$inipersonas,'cedula')){
		
		$fila=$fila+2;
			
		$cedulapersona=@mysql_result($resultapersonas,$inipersonas,'cedula');
		$nombrepersona=@mysql_result($resultapersonas,$inipersonas,'apellidos'). " ".@mysql_result($resultapersonas,$inipersonas,'nombre');

		$parametros["hoja"]=$sheet;
		$parametros["fila"]=$fila;
		$parametros["cedula"]=$cedulapersona;
		$parametros["nombres"]=$nombrepersona;
		$parametros["formato"]=$format0;
		$parametros["formato"]=$format0;
		$parametros["numdiasmes"]=$numdias0;
		$parametros["numpersona"]=$inipersonas;
		$parametros["resultpersonas"]=$resultapersonas;
		if($diapersona<3){$diapersona++;}else{$diapersona=1;}
		$parametros["dia"]=$diapersona;
		$parametros["diarelevo0"]=12;
		$parametros["diarelevo1"]=16;
		$parametros["diarelevo2"]=20;
		$parametros["festivos"]=$festivos;
		$parametros["ano"]=$_SESSION["ano1"];
		$parametros["mes"]=$_SESSION["mes1"];
		
		ponerturnospersona($parametros);
		}
	}	
		$clientesocio="";
		$fila=0;
}


  $xls->close();
  
?>  
