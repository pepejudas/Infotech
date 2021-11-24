<?php

require("funciones2.php");
require('clases/claseInformeSimple.php');

//ini_set('display_errors', 1);

session_start();

validar("","","", 26);//ingresar el id por cada informe creado para poder darle permisos personalizadamente

try{
$informe = new claseInformeSimple($_POST['textoHTML']);
}catch(Exception $err){
echo "No se ha podido generar el informe, posiblemente contiene rutas a imagenes inexistentes, mas informacion del error: ".$err;
}
?>
