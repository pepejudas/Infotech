<?php
session_start();
set_time_limit(500);
@require('funciones2.php');

if($_SESSION['iuj345iuh']!=1){
	validar($_POST[nombre], $_POST[contra], $_POST[nivel]);	
}
conectar2($_SESSION['usua']);

	if ($_SESSION['usua']=="vigilantes" or $_SESSION['usua']=="radiooperadores"){
		echo "<br>\n<h2>No tiene permiso para acceder a esta informacion</h2>";
		echo "<h3><div align=left><A HREF=\"inicio.php\">Inicio</A></div><h3>";
		echo "<h3><div align=left><A HREF=\"index.php\">Salir</A></div><h3>";
	exit();
	}

$fecha=getdate(time());
$cad=$fecha[month].$fecha[year];


$sql2="SELECT * FROM socios ORDER BY nombres";
$result2=mysql_query($sql2);
$li=mysql_num_rows($result2);

  require("Spreadsheet/Excel/Writer.php");
  $xls =& new Spreadsheet_Excel_Writer();
  $xls->send("reportecontrolturnos.xls");
  
  $fecha=getdate(time());
	$mes=$cad;

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
$contad=0;

//for($contad=1;$contad<$li;$contad++){
	

	$nombresoc=mysql_result($result2,$contad,"nombres");
	$cedulasoc=mysql_result($result2,$contad,"cedula");
  	$sheet =& $xls->addWorksheet("$nombresoc");
	$format =& $xls->addFormat();
	$format->setBold();
	$sheet->write(0,0,'cedula',$format);
	$sheet->write(0,1,'apellidos y nombres',$format);
	
	$clientesdelsocio=NULL;
	$sqlc="SELECT * FROM clientes WHERE clientes.duenopuesto LIKE '$cedulasoc'";
	$cons1=@mysql_query($sqlc);
	$ic=0;
	$lic=@mysql_num_rows($cons1);
	
		while($ic<$lic){
		$clie=@mysql_result($cons1,$ic,nombrecliente);
		$clientesdelsocio["$clie"]=1;
		$ic++;	
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

		$sql1="SELECT * FROM controlturnos, personalactivo, clientes WHERE	
		personalactivo.cedula LIKE controlturnos.cedulacontrol AND controlturnos.mescontrol LIKE '$mes' 
	AND (
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
		
		AND (
		controlturnos.d1 NOT LIKE 'NULL' OR
		controlturnos.d2 NOT LIKE 'NULL' OR
		controlturnos.d3 NOT LIKE 'NULL' OR
		controlturnos.d4 NOT LIKE 'NULL' OR
		controlturnos.d5 NOT LIKE 'NULL' OR
		controlturnos.d6 NOT LIKE 'NULL' OR
		controlturnos.d7 NOT LIKE 'NULL' OR
		controlturnos.d8 NOT LIKE 'NULL' OR
		controlturnos.d9 NOT LIKE 'NULL' OR
		controlturnos.d10 NOT LIKE 'NULL' OR
		controlturnos.d11 NOT LIKE 'NULL' OR
		controlturnos.d12 NOT LIKE 'NULL' OR
		controlturnos.d13 NOT LIKE 'NULL' OR
		controlturnos.d14 NOT LIKE 'NULL' OR
		controlturnos.d15 NOT LIKE 'NULL' OR
		controlturnos.d16 NOT LIKE 'NULL' OR
		controlturnos.d17 NOT LIKE 'NULL' OR
		controlturnos.d18 NOT LIKE 'NULL' OR
		controlturnos.d19 NOT LIKE 'NULL' OR
		controlturnos.d20 NOT LIKE 'NULL' OR
		controlturnos.d21 NOT LIKE 'NULL' OR
		controlturnos.d22 NOT LIKE 'NULL' OR
		controlturnos.d23 NOT LIKE 'NULL' OR
		controlturnos.d23 NOT LIKE 'NULL' OR
		controlturnos.d25 NOT LIKE 'NULL' OR
		controlturnos.d26 NOT LIKE 'NULL' OR
		controlturnos.d27 NOT LIKE 'NULL' OR
		controlturnos.d28 NOT LIKE 'NULL' OR
		controlturnos.d29 NOT LIKE 'NULL' OR
		controlturnos.d30 NOT LIKE 'NULL' OR
		controlturnos.d31 NOT LIKE 'NULL' OR
		controlturnos.n1 NOT LIKE 'NULL' OR
		controlturnos.n2 NOT LIKE 'NULL' OR
		controlturnos.n3 NOT LIKE 'NULL' OR
		controlturnos.n4 NOT LIKE 'NULL' OR
		controlturnos.n5 NOT LIKE 'NULL' OR
		controlturnos.n6 NOT LIKE 'NULL' OR
		controlturnos.n7 NOT LIKE 'NULL' OR
		controlturnos.n8 NOT LIKE 'NULL' OR
		controlturnos.n9 NOT LIKE 'NULL' OR
		controlturnos.n10 NOT LIKE 'NULL' OR
		controlturnos.n11 NOT LIKE 'NULL' OR
		controlturnos.n12 NOT LIKE 'NULL' OR
		controlturnos.n13 NOT LIKE 'NULL' OR
		controlturnos.n14 NOT LIKE 'NULL' OR
		controlturnos.n15 NOT LIKE 'NULL' OR
		controlturnos.n16 NOT LIKE 'NULL' OR
		controlturnos.n17 NOT LIKE 'NULL' OR
		controlturnos.n18 NOT LIKE 'NULL' OR
		controlturnos.n19 NOT LIKE 'NULL' OR
		controlturnos.n20 NOT LIKE 'NULL' OR
		controlturnos.n21 NOT LIKE 'NULL' OR
		controlturnos.n22 NOT LIKE 'NULL' OR
		controlturnos.n23 NOT LIKE 'NULL' OR
		controlturnos.n23 NOT LIKE 'NULL' OR
		controlturnos.n25 NOT LIKE 'NULL' OR
		controlturnos.n26 NOT LIKE 'NULL' OR
		controlturnos.n27 NOT LIKE 'NULL' OR
		controlturnos.n28 NOT LIKE 'NULL' OR
		controlturnos.n29 NOT LIKE 'NULL' OR
		controlturnos.n30 NOT LIKE 'NULL' OR
		controlturnos.n31 NOT LIKE 'NULL')
		
		AND clientes.duenopuesto LIKE '$cedulasoc' ORDER BY $criterio
	";
		//consultar personas
	$result=mysql_query($sql1);
	$li2=mysql_num_rows($result);
	
	//escribir cedula y nombres
	
	if($li2!=0){
		
		$fila=2;
	for($contad=0;$contad<$li2;$contad++){
		
		$columna=0;
		$cedula=mysql_result($result,$contad,cedulacontrol);
		$nombre=mysql_result($result,$contad,apellidos)." ".mysql_result($result,$contad,nombre);
		
		for($columna=0;$columna<31;$columna++){
		
			$contado=$columna+1;	
			
			if($columna==0){	
			$sheet->write($fila,$columna,$cedula,$format);	
			$sheet->write($fila,$columna+1,$nombre,$format);
			}
			
			$dia="d".$contado;
			$noche="n".$contado;
			$codcli="cod".$contado;
			
			if((mysql_result($result,$contad,$dia)!="" OR mysql_result($result,$contad,$noche)!="") AND $clientesdelsocio[mysql_result($result,$contad,$codcli)]==1){
			$turnod=mysql_result($result,$contad,$dia);
			$turnon=mysql_result($result,$contad,$noche);
			
			$sheet->write($fila,$columna+3,$turnod,$format);
			$sheet->write($fila+1,$columna+3,$turnon,$format);

			}
			if($columna==30){	
			$fila=$fila+2;
			}	
		}
	}	
	}	
//}	
	$xls->close();
?>  
