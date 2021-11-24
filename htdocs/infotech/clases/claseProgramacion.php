<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Programacion{

private $ano="";
private $mes="";
private $numclientes=0;
private $clientes;                      //array con los clientes forma Array ( [0] => fastino )
private $cedulasrelevantes;             //array iterativo con cedulas de los relevantes
private $cedulaspersonalprog;           //array iterativo con cedulas de personal fijo del cliente
private $paramprogclieact;              //array con los parametros de programacion del cliente actual
private $parametros;                    //mantiene una copia de los datos de programacion completos
private $htmlprog;                      //contiene la programacion en formato html
private $dias;                          /*array contiene numero de primer dia y ultimo del mes y numero de dias del mes
                                        *  Array ( [numdias] => 31 [primerdia] => 5 [ultimodia] => 0 )*/
private $link;                          //identificador del link mysql para consultas
private $db;                            //guarda los datos para consultarlos a traves de la clase
private $cedulapersonactiva;                  //guarda el numero de cedula de la persona activa
private $numtdispoperact;               //guarda el numero de turnos que dispone para programar la persona activa descontando descansos y ct

/**
 *
 * @param <type> $parametros Array (
 *  [mes] => 01
 *  [ano] => 2010
 *  [numclientes] => 1
 *  [cliente-fastino] => on
 *  [clientes] => Array ( [0] => fastino )
 *  [paratodos] => si       //por defecto buscar los arametros que deben estar establecidos para cada cliente
 *  [param-fastino] => Array ( [dia-1] => si [dia-2] => si [dia-3] => si [dia-4] => si [dia-5] => si [dia-6] => si [dia-7] => si
    [HDS] => 24 [DT] => 8 [Numd] => 0 [NumCT] => 0 [Prr] => 5 [NT] => 3 [Npers-1] => 1 [Npers-2] => 1 [Npers-3] => 1 )
 *  [relpersonalprog] => Array ( [1] => 21341234 [2] => 70987087098 ) )
 */

public function __construct($parametros, $link){
try{
$this->setLink($link);
$this->setParametros($parametros);
$this->setAno($parametros['ano']);
$this->setMes($parametros['mes']);
$this->setNumClientes($parametros['numclientes']);
$this->setParaTodos($parametros['paratodos']);
$this->setClientes($parametros['clientes']);
$this->setPersonalProg($parametros['personalprog']);
$this->setRelevantes($parametros['relpersonalprog']);
$this->establecerDias();
$this->establecerDb();
$this->crearProgramacion();
}catch(Exception $er){
    exit($er->getMessage());
}
}
private function setLink($link){
$this->link=$link;
}
//guardar la copia de los parametros de programacion
private function setParametros($parametros){
$this->parametros=$parametros;
}

private function setAno($ano){
if($ano!=""){
$this->ano=$ano;
 }else{
    $this->getException('1');
}
}

private function setMes($mes){
if($mes!=""){
$this->mes=$mes;
}else{
    $this->getException('2');
}
}

private function setNumClientes($numclientes){
if($numclientes>0){
$this->numclientes=$numclientes;
}else{
    $this->getException('3');
}
}
/** este motodo ofunciona y todo
 * @param agonia
 */
private function setClientes($clientes){
if(count($clientes)>0){
$this->clientes=$clientes;
}else{
    $this->getException('4');
}
}

private function setPersonalProg($personalprog){
if(count($personalprog)>0){
$this->cedulaspersonalprog=$personalprog;
}else{
    $this->getException('5');
}
}

private function setRelevantes($relevantes){
if(count($relevantes)>0){
$this->cedulasrelevantes=$relevantes;
}else{
    $this->getException('6');
}
}
private function setParaTodos($paratodos){
if($paratodos=="si" || $paratodos=="no"){
$this->paratodos=$paratodos;
}else{
    $this->getException('7');
}
}

private function setParamProgClieAct($numcliente){
if($this->numclientes>=$numcliente){
$cliente=$this->clientes[$numcliente];
$this->paramprogclieact=$this->parametros['param-'.$cliente];
}else{
    $this->getException('8');
}
}

private function getException($numexepcion){
 switch($numexepcion){
 case "1"://año
 case "2"://mes
 case "3"://numero de clientes
 case "4"://array de clientes
 case "8";//parametros del cliente actual, inicialmente el 0
  throw new Exception("Falta parametro requerido: ".$numexepcion);
 case "5"://matriz de cedulas personal
 case "6"://matriz cedulas relevantes
 case "7"://si los parametros e programacion son para todos los clientes
 break;
 }
}
/*
 * almacena en htmlprog la programacion generada con parametros establecidos
 */

private function establecerDias(){
$this->dias=NumDias($this->ano, $this->mes);
}
private function establecerDb(){
@require_once 'claseBaseDatos.php';
$this->db=new BaseDatos($this->link);
}
private function crearProgramacion(){
//inciamente usar los parametros establecidos en paramprogclieact
$this->htmlprog="<table border=\"0\" class=\"programacion\">";
$this->htmlprog.=filasEncabezado($this->dias, $this->mes, $this->ano);

//iteracion sobre los clientes
for($j=0;$j<count($this->numclientes);$j++){
$this->setParamProgClieAct($j);
$this->htmlprog.="<tr><td colspan=\"".($this->dias['numdias']+3)."\" class=\"encabezadocliente\">Cliente ".$this->clientes[$j]."</td></tr>";

  $lim=@ceil($this->paramprogclieact['HDS']/$this->paramprogclieact['DT']);
  //iteracion sobre numero de turnos de servicio para el cliente
  for($k=0;$k<=$lim;$k++){

    //iteracion sobre numero de personas asignadas por turno para el cliente
    for($i=1;$i<=$this->paramprogclieact["Npers-$k"];$i++){
    //$this->htmlprog.="<tr><td>". $this->personActiva['cedula']."</td><td>". $this->personActiva['cedula']."</td></tr>";
    $this->setPersonActiva($i);
    $this->htmlprog.=$this->armarFila($k, $i);
    }
  }
}

$this->htmlprog.="</table>";
}
private function setPersonActiva($num){
    if(count($this->cedulaspersonalprog)>=$num){//primero programar las personas que estan fijas en los puestos
    $this->cedulapersonactiva=$this->cedulaspersonalprog[$num];
    exit("valor:".$i-count($this->cedulaspersonalprog));
    }
}

private function armarFila($numturno, $numpaciente){
$diascorridos=0;

if($this->cedulapersonactiva!=""){
$numdatos=$this->db->ejecuCons("SELECT cedula, nombre, apellidos FROM personalactivo WHERE cedula='$this->cedulapersonactiva'");
 if($numdatos>0){
        $filapaciente="<tr><td>".$this->db->devolverCampo(0, "cedula")."</td><td>".$this->db->devolverCampo(0, "nombre")."</td><td>".$this->db->devolverCampo(0, "apellidos")."</td>";
    if($this->paramprogclieact['Numd']!=0){
        $diasparadescanso=@ceil($this->dias['numdias']/$this->paramprogclieact['Numd']);
    }else{
        $diasparadescanso=$this->dias['numdias'];
    }

    for($i=$this->dias['numdias'];$i>0;$i--){
        $diascorridos+=1;

        if($diascorridos>$diasparadescanso){//tiene derecho a descanso
        $filapaciente.="<td>D</td>";
        $diascorridos=0;
        }else{//no tiene derecho a descanso
        $filapaciente.="<td>T$numturno</td>";
        }
    }
    $filapaciente.="</tr>";
 return $filapaciente;
 }
}
}

public function retornarProgramacionHTML(){
return $this->htmlprog;
}
}
?>
