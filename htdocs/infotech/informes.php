<?php

require("funciones2.php");
require('clases/claseInforme.php');

session_start();

validar("","","", 26);//ingresar el id por cada informe creado para poder darle permisos personalizadamente

try{

    $informe = new claseInforme($_POST['orientation'], $_POST['paper'], $_POST['informe'], $_SESSION['clavepi'], $_POST['cedpac'], "", "html", 200);
}catch(Exception $err){
echo "No se ha podido generar el informe, posiblemente las imagenes combinadas no existen para el registro seleccionado";
}
?>