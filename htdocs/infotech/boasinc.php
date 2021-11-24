<?php

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_start("boa");

@require('funciones2.php');

validarBoa($_POST['usuario'], $_POST['contra'], $_POST['sucursal'], 73);

$retornar="{success:true";

switch($_POST['operacion']){
case "eliminar":

break;
case "actualizarestado":
$sql="INSERT INTO `asistencia` (idcarnetpersonal, fechaios, comentarios, tipo) VALUES ('".$_POST['carnetinterno']."', NOW(), '".$_POST['comentarios']."', '".$_POST['tipo']."')";
@mysql_query($sql) or $error=@mysql_error();

$fecha=getdate(time());
$consultarpac="SELECT cedula, codigo FROM personalactivo WHERE personalactivo.carnetinterno='$_POST[carnetinterno]'";
$rescedulap=@mysql_query($consultarpac);
$cedulapac=@mysql_result($rescedulap, 0, "cedula");
$codigopac=@mysql_result($rescedulap, 0, "codigo");

switch($fecha[hours]){
	case 6;
	case 7;
	case 8;
	case 9;
	case 10;
	case 11;
	case 12;
	case 13;
	case 14;
	case 15;
	case 16;
	case 17;
	$cturno="d";
	break;
	case 18;
	case 19;
	case 20;
	case 21;
	case 22;
	case 23;
        case 0;
	case 1;
	case 2;
	case 3;
	case 4;
	$cturno="n";
	break;
}

//verificar a donde se ingresan los turnos de las personas con este codigo

if($_POST['tipo']==1){// si es un ingreso registrarlo en el control de turnos
    $sql5="SELECT id FROM `controlturnos` WHERE `controlturnos`.`cedulacontrol`= '$cedulapac' AND `controlturnos`.`mescontrol` LIKE '$fecha[month]$fecha[year]' ";
    $resultacons=@mysql_query($sql5) or $mens=@mysql_error();
    $hayreg=@mysql_num_rows($resultacons);
    $idcontrol=@mysql_result($resultacons,0, "id");
    $codclif=$_POST['codcliente'];
    
    if($codclif==""){
    $codclif=$codigopac;
    }

    if($hayreg>0){//ya existe registro del mes año y persona creado por tanto debe buscarse y actualizar
            $sql3="UPDATE `controlturnos` SET `$cturno$fecha[mday]` = '1', `cod$fecha[mday]`='$codclif', `reg$fecha[mday]`='$_SESSION[persona]' WHERE `controlturnos`.`id` = '$idcontrol' LIMIT 1";
    }else{//si no existe crear registro de mes persona y año dado
            $sql3="INSERT INTO controlturnos (`fecharegistro`, `cedulacontrol`, `mescontrol`, `$cturno$fecha[mday]`, `cod$fecha[mday]`, `reg$fecha[mday]` ) VALUES (NOW(), '$cedulapac', '$fecha[month]$fecha[year]', 1, '$codclif', '$_SESSION[persona]') ";
    }

    try{
    $resultcons=@mysql_query($sql3) or $mens=@mysql_error();
    }catch(Exception $err){

    }
}
break;
case "actualizar"://manda tabla y campos con sus valores respectivos de una sola tabla
$sql="";
while (list($name, $value) = each($_POST)) {
//echo " POST $name = $value<br>\n";
}
break;
//buscar la descripcion de la tabla y preguntar por cada uno de los campos de ella en los datos post enviados
case "ingresar"://manda tabla y campos con sus valores respectivos de una sola tabla
if($_POST['tabla']!=""){
$result = @mysql_query("SHOW COLUMNS FROM $_POST[tabla]") or $error.=@mysql_error();
$numcampos=@mysql_num_rows($result);
$sentencia="INSERT INTO $_POST[tabla]";
$amenosuno=false;


for($i=0;$i<$numcampos;$i++){

if($almenosuno){
$agregarcoma=", ";
}else{
$agregarcoma="";
}

$campo=@mysql_result($result, $i, "Field");

if($_POST[$campo]!=""){
$campos.="$agregarcoma `".$campo."`";
$valorescampo.="$agregarcoma '".$_POST[$campo]."'";
$almenosuno=true;
}
}

$sentencia.="(".$campos.") VALUES (".$valorescampo.")";
@mysql_query($sentencia) or $error.=@mysql_error();

}
break;
case "obtener":
if($_POST['tabla']!=""){
$sql="SELECT * FROM $_POST[tabla]";
$cons=@mysql_query($sql) or $error=@mysql_error();

if($error==""){
$clientes=@mysql_num_rows($cons);
    if($clientes> 0){
       $retornar.=", numreg:$clientes,".normalizardatosboa($cons);
    }else{
       $retornar.=", numreg:0";
    }
}
}
break;
case "buscar":
if($_POST['campos']!="" && $_POST['tablas']!="" && $_POST['condiciones']!=""){
$sql="SELECT $_POST[campos] FROM $_POST[tablas] $_POST[condiciones]";
$cons=@mysql_query($sql) or $error=@mysql_error();

if($error==""){
$persona=@mysql_num_rows($cons);
    if($persona > 0){
       $retornar.=", buscar:true, numreg:$persona,".normalizardatosboa($cons);
    }else{
       $retornar.=", numreg:0";
    }
}
}
break;
case "buscarclientes":
if($_POST['campos']!="" && $_POST['tablas']!="" && $_POST['condiciones']!=""){
$sql="SELECT $_POST[campos] FROM $_POST[tablas] $_POST[condiciones]";
$cons=@mysql_query($sql) or $error.=@mysql_error();
$clientes=@mysql_num_rows($cons);
if($clientes>0){
$retornar.=", buscarclientes:true, numreg:$clientes,".normalizardatosboa($cons);
}
}
break;
case "buscarhuellas":
if($_POST['campos']!="" && $_POST['tablas']!="" && $_POST['condiciones']!=""){
//busqueda de persona
$sql="SELECT $_POST[campos] FROM $_POST[tablas] $_POST[condiciones]";
$cons=@mysql_query($sql) or $error.=@mysql_error();
$persona=@mysql_num_rows($cons);

if($persona > 0){
$sqlhuellas="SELECT tpt64, dedo, carnetpersonal FROM huellas WHERE carnetpersonal='".@mysql_result($cons, 0, "carnetinterno")."'";
$conshuellas=@mysql_query($sqlhuellas) or $error.=@mysql_error();
$numhuellas=@mysql_num_rows($conshuellas);
for($i=0;$i<$numhuellas;$i++){//recorrer registros de huellas y enviar todas de una vez en base64
if(@mysql_result($conshuellas, $i, "tpt64")!="" && @mysql_result($conshuellas, $i, "dedo")!="" && @mysql_result($conshuellas, $i, "carnetpersonal")){
$jsonhuellas.=", tpt64".$i.":'".@mysql_result($conshuellas, $i, "tpt64")."', dedo".$i.":'".@mysql_result($conshuellas, $i, "dedo")."'";
}
}
}

if($error==""){
    if($persona > 0){
       $retornar.=", buscarhuellas:true, numreg:$persona,".normalizardatosboa($cons).$jsonhuellas;
    }else{
       $retornar.=", numreg:0";
    }
}
}
break;
default:
die("{success:true, sincronizabien:false, error:'no se identifica la operacion a efectuar'}");
break;
}

if($error==""){//verificacion de errores de actualizacion o ingreso y retorno de datos
$retornar.=", sincronizabien:true";
}else{
$retornar.=", sincronizabien:false, error:'".$error."', consulta='$sentencia'";
}

$retornar.="}";

print(($retornar));
?>
