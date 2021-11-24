<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 */
class BaseDatos{
private $link;                          //identificador del link mysql para consultas
private $db;
private $result;
private $error="";

/**
 * constructor de la clase
 * @param <type> $link
 */
public function __construct($link){
try{
$this->setLink($link);
}catch(Exception $er){
    exit($er->getMessage());
}
}
/**
 * establece el $link
 * @param <conexion_mysql> $link
 */
private function setLink($link){
$this->link=$link;
}

/**
 * ejecuta una consulta al servidor mysql
 * @param <type> $consulta SQL
 * @return <entero> numreo de registros devueltos por la consulta
 */
public function ejecuCons($consulta){//retorna el numero de registros coincidentes
$this->result=@mysql_query($consulta, $this->link) or $this->error=@mysql_error($this->link);
$numtotalreg=@mysql_num_rows($this->result);
if($numtotalreg>=0 && $this->error==""){
return $numtotalreg;
}
}
/**
 *
 * @param <entero> $numreg numero de registro el cual devolver
 * @param <string> $nombre nombre del campo a devolver
 * @return <type>
 */
public function devolverCampo($numreg, $nombre){
$campo=@mysql_result($this->result, $numreg, $nombre) or $this->error=@mysql_error($this->link);
if($this->result!="" && $campo!=""){
return $campo;
}
}
public function mostrarError(){
 if($this->error!=""){
 return $this->error;
 }
}
}
?>