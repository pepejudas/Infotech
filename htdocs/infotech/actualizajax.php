<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

@require('funciones2.php');
$link=validar("","","", 1);

//print_r($_POST);
if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
$_POST['claveprinc']="cedula";

$mens.=armarEjecutarSentencia("personalactivo", $_POST, "update", $_SESSION);
if($mens==""){
    echo '({"success":true})';
}else{
    echo '({"success":false, "error":"'.$mens.'"})';
}
?>
