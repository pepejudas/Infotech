<?php
session_start();

@require('funciones2.php');

validar("","","", 58);
$db="relacional";  // Nombre de la Base de Datos a exportar

if($_POST['usuario']!="" && $_POST['pass']!=""){

$nombre=$_POST['usuario'];
$contra=$_POST['pass'];
$rutamy0=$_POST['rutamy'];

$link=@mysql_connect("localhost", $nombre, $contra) or $error.="backup0 15 ".@mysql_error();
mysql_select_db($db, $link) or $error.="backup0 16 ".@mysql_error();
mysql_query("SET NAMES 'utf8'") or $error.="backup0 17 ".@mysql_error();;

$backupFile = $db ."_". date("Y-m-d-H-i-s")  . '.sql';

// Cabeceras para forzar al navegador a guardar el archivo

header("Pragma: no-cache");
header("Expires: 0");
header("Content-Transfer-Encoding: binary");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=$backupFile");


// Funciones para exportar la base de datos
if($_POST['estructura']=="on"){
    $estructura=" --no-create-db";
    }else{
    $estructura=" --no-create-info";
    }

    if($rutamy0!=""){
    $rutamy0.="/";
    }

    $consultablas="SELECT deinfotech, nombretabla FROM tablas ORDER BY nombretabla";
    $res=@mysql_query($consultablas);

    $ejecutado="";
    
    while($fila=@mysql_fetch_array($res)){

    if($fila[deinfotech]!=1){//solo exportar las tablas de informacion de
        if($_POST['datos']!="on"){
        $datos=" --no-data";
        }

        $executa = $rutamy0."mysqldump -u $nombre --password=$contra --opt $db --tables $fila[nombretabla] --complete-insert --skip-comments --no-autocommit $estructura $datos";

        $ejecutado.=$ejecuta."\n";

        $resultado.=passthru($executa);
    }
    }

//exportar los permisos asignados en la base de datos para cada usuario de la tabla usuarios

$consulusuarios="SELECT usuario, contrasena FROM usuarios";

$resconsu=mysql_query($consulusuarios, $link) or $error.="backup0 65 ".@mysql_error();
$ini=0;
$lim=mysql_num_rows($resconsu) or $error.="backup0 67 ".@mysql_error();
$permisos="";

for($ini=0;$ini<$lim;$ini++){
$usuarioMysql=mysql_result($resconsu, $ini, "usuario") or $error.="backup0 71 ".@mysql_error();
$consulpermisos="SHOW GRANTS FOR '$usuarioMysql'@'localhost'";
$resconsper=mysql_query($consulpermisos, $link) or $error.="backup0 73 ".@mysql_error();

    //escribir los permisos de cada usuario en el backup
    $inip=0;
    $limp=mysql_num_rows($resconsper) or $error.="backup0 77 ".@mysql_error();
    for($inip=0;$inip<$limp;$inip++){
    $permisos.= mysql_result($resconsper,$inip).";\n";
    }
}

if($error==""){
    echo $resultado;
    echo $permisos;
    echo $ejecutado;

}else{
    echo "error en consulta de permisos: $error";
}

// Comprobar si se a realizado bien, si no es asi, mostrará un mensaje de error
if ($resultado){
    echo "<h1>Error ejecutando backup: $executa</h1>\n$resultado\n$error\n"; }
}
?>