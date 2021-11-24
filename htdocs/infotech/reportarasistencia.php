<?php
session_start();

@require('funciones2.php');

$link=validar("","","", 70);

 $task = '';
 
  if ( isset($_POST['task'])){
    $task = $_POST['task'];       // Get this from Ext
  }
  
  switch($task){
    case "LISTING":              // Give the entire list
      getList("");
      break;
    case "BUSCAR":
      getList($_POST[textoBuscado]);
    break;
    default:
      echo "{failure:true}";     // Simple 1-dim JSON array to tell Ext the request failed.
      break;
  }

  if($_SESSION['numpeticiones']>=3){
    $_SESSION['numpeticiones']=1;
  }else{
    $_SESSION['numpeticiones']++;
  }
  
function getList($textobuscado){//consultar las personas que han llegado recientemente
$fecha0=getdate(time());

if($textobuscado!=""){
$cadenasent="AND (personalactivo.nombre LIKE '%$textobuscado%' OR personalactivo.apellidos LIKE '%$textobuscado%' OR personalactivo.cedula LIKE '%$textobuscado%')";
}

switch($_POST[tipoturno]){
case 1://6 a 14
$complemento=" fechaios>'$fecha0[year]-$fecha0[mon]-$fecha0[mday] 04:00:00' && fechaios<'$fecha0[year]-$fecha0[mon]-$fecha0[mday] 11:59:00'";
break;
case 2://14 a 22
$complemento=" fechaios>'$fecha0[year]-$fecha0[mon]-$fecha0[mday] 12:00:00' && fechaios<'$fecha0[year]-$fecha0[mon]-$fecha0[mday] 19:59:00'";
break;
case 3://22 a 6
$complemento=" fechaios>'$fecha0[year]-$fecha0[mon]-$fecha0[mday] 20:00:00' && fechaios<'$fecha0[year]-$fecha0[mon]-$fecha0[mday] 23:59:00'";
break;
}

$consulta="SELECT apellidos, nombre, cedula, comentarios, personalactivo.telefono, fechaios, clientes.codigo, nombrecliente FROM personalactivo LEFT JOIN asistencia ON personalactivo.carnetinterno=asistencia.idcarnetpersonal LEFT JOIN clientes ON personalactivo.codigo=clientes.codigo WHERE personalactivo.codigo=clientes.codigo AND personalactivo.carnetinterno=asistencia.idcarnetpersonal AND tipo=1 AND $complemento $cadenasent GROUP BY cedula";
$result=@mysql_query($consulta);
$lim=@mysql_num_rows($result);
$cadenajson="";

for($ini=0;$ini<$lim;$ini++){
    if($ini+1==$lim){
        $coma="";
    }else{
        $coma=", ";
    }

$cadenajson.="{id: $ini, documento:'".@mysql_result($result, $ini,"cedula")."', project: '".@mysql_result($result, $ini,"codigo")."', taskId: 112, description: '".@mysql_result($result, $ini,"apellidos")." ".@mysql_result($result, $ini,"nombre")."', estimate: 6, telefonos: '".@mysql_result($result, $ini,"telefono")."', observaciones:'".@mysql_result($result, $ini,"comentarios")."', due:'".@mysql_result($result, $ini,"fechaios")."'}$coma";

}

//para mostrar conslta "consulta":"'./*$consulta*/.'"
echo '({"success":true, "numfilas":"'.$ini.'", "datosjson":['.$cadenajson.']})';
}
?>
