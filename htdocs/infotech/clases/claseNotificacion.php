<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Notificacion{
private $resultNotificaciones;
private $idUsuarioNotificar;
public  $numNotificaciones;
private $numNotificaCons;
public  $error;
public  $cons;

public function setIdusuarioNotificar($id, $inicio, $maxtamlista){
    $this->idUsuarioNotificar=$id;
    $this->getNotificaNuevas($inicio, $maxtamlista);
    $listaHTML=$this->listarNotificaciones();
return $listaHTML;
}
/*
public function verificarCreacionAutomatica(){
    
}
*/
public function crearNotificaciones($idusuariocrea, $idusuarioanotificar, $titulo, $descripcion){

if($idusuarioanotificar=="todos"){//crear notificaciones para todos los usuarios del sistema con la misma descripcion y titulo
$sql="SELECT id FROM usuarios";
$link=conectar();
$res=@mysql_query($sql, $link) or $this->error.=" ClaseNotificacion 29 ".@mysql_error();
$numusuarios=@mysql_num_rows($res);
    
    for($i=0;$i<$numusuarios;$i++){
    $idusuanoti=@mysql_result($res, $i, "id");
    
    if($idusuanoti!=$idusuariocrea){// si no es para el mismo usuario que crea la notificacion
    $this->crearNotificacion($idusuariocrea, $idusuanoti, $titulo, $descripcion);
    }
    }
    
}else{
    $this->crearNotificacion($idusuariocrea, $idusuarioanotificar, $titulo, $descripcion);
}
}
public function crearNotificacion($idusuariocrea, $idusuanoti, $titulo, $descripcion){
$sql="INSERT INTO notificaciones (`nombrenoti`, `descripcion`, `estado`, `usuariocrea`, `fechacreanoti`, `usuarionotificado`) VALUES 
('$titulo', '".addslashes($descripcion)."', '1', '$idusuariocrea', NOW(), '$idusuanoti')";
$this->cons=$sql;
$res=@mysql_query($sql) or $this->error.=" ClaseNotificacion 47 $sql".@mysql_error();
}

private function getNotificaNuevas($inicio, $maxtamlista){
$link=conectar();

$sql0="SELECT notificaciones.id, fechacreanoti, nombrenoti, descripcion, notificaciones.estado,
CONCAT( notifica.nombre, ' ', notifica.apellidos ) AS usuanotifica, CONCAT( notificado.nombre, ' ', notificado.apellidos ) AS usuarecibe
FROM notificaciones LEFT JOIN usuarios AS usuacrea ON usuacrea.id = notificaciones.usuariocrea LEFT JOIN personalactivo AS notifica
ON usuacrea.carnetpersonal = notifica.carnetinterno LEFT JOIN usuarios AS usuarecibe ON usuarecibe.id = notificaciones.usuarionotificado
LEFT JOIN personalactivo AS notificado ON usuarecibe.carnetpersonal = notificado.carnetinterno WHERE usuarionotificado ='$this->idUsuarioNotificar'
AND notificaciones.estado = 1";
$res=@mysql_query($sql0, $link) or $this->error.=" ClaseNotificacion 59 ".@mysql_error();;
$this->numNotificaciones=@mysql_num_rows($res);

$sql="SELECT notificaciones.id, fechacreanoti, nombrenoti, descripcion, notificaciones.estado,
CONCAT( notifica.nombre, ' ', notifica.apellidos ) AS usuanotifica, CONCAT( notificado.nombre, ' ', notificado.apellidos ) AS usuarecibe
FROM notificaciones LEFT JOIN usuarios AS usuacrea ON usuacrea.id = notificaciones.usuariocrea LEFT JOIN personalactivo AS notifica
ON usuacrea.carnetpersonal = notifica.carnetinterno LEFT JOIN usuarios AS usuarecibe ON usuarecibe.id = notificaciones.usuarionotificado
LEFT JOIN personalactivo AS notificado ON usuarecibe.carnetpersonal = notificado.carnetinterno WHERE usuarionotificado ='$this->idUsuarioNotificar'
AND notificaciones.estado = 1 LIMIT $inicio, $maxtamlista ";

$this->cons=$sql;
$this->resultNotificaciones=@mysql_query($sql, $link) or $error.=" ClaseNotificacion 69 ".@mysql_error();
$this->numNotificaCons=@mysql_num_rows($this->resultNotificaciones);
}

private function listarNotificaciones(){
    for($i=0;$i<$this->numNotificaCons;$i++){

    if($i+1==$this->numNotificaCons){
    $coma="";
    }else{
    $coma=", ";
    }
    $cadenajson.="{id: ".@mysql_result($this->resultNotificaciones, $i, "id").", nombrenoti:'".@mysql_result($this->resultNotificaciones, $i, "nombrenoti")."', usuanotifica: '".@mysql_result($this->resultNotificaciones, $i, "usuanotifica")."', fechacreanoti: '".@mysql_result($this->resultNotificaciones, $i, "fechacreanoti")."', estado: '".@mysql_result($this->resultNotificaciones, $i, "estado")."', descripcion: '".addslashes(@mysql_result($this->resultNotificaciones, $i, "descripcion"))."'}$coma";
    }

    $listaNotifica = '({"success":true, "numfilas":"'.($this->numNotificaciones).'", "datosjson":['.$cadenajson.']})';
    return $listaNotifica;
}
public function actualizarRegistro($id, $estado, $descripcion){
  $sql="UPDATE notificaciones SET estado='$estado', fechanotifica=NOW() WHERE notificaciones.id=$id";
  $this->cons=$sql;
  @mysql_query($sql) or $this->error.=" ClaseNotificacion 90 ".@mysql_error();
}
    
}
?>
