<?php

require("funciones2.php");
require('clases/claseInformeSimple.php');

session_start();

validar("","","", 26);//ingresar el id por cada informe creado para poder darle permisos personalizadamente

try{
    $informe = new claseInformeSimple($_POST['textoHTML']);
}catch(Exception $err){
echo "No se ha podido generar el informe, posiblemente las imagenes combinadas no existen para el registro seleccionado";
}
?>
