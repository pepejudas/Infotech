<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

@require('funciones2.php');

$link=conectarim();

switch($_POST[operacion]){
case "CargarDeptos":
$sql="SELECT * FROM ciudades WHERE ciudades.`ID_DPTO` LIKE '$_POST[departamento]'";
$result=@mysql_query($sql, $link) or $error=@mysql_error();
$ini=0;
$lim=@mysql_num_rows($result);

for($ini=0;$ini<$lim;$ini++){
if($ini+1==$lim){//ultimo registro
$coma="";
}else{
$coma=", ";
}

$ciudades.="'".@mysql_result($result, $ini, "NOMBRE")."'".$coma;
$idciudades.="'".@mysql_result($result, $ini, "ID_CIUDAD")."'".$coma;
}

echo '({"success":true, "ciudades":['.$ciudades.'], "idciudades":['.$idciudades.']})';

echo $retorno;
break;
}
?>
