<?php
session_start();
//ini_set('display_errors', 1);

@require('funciones2.php');

$link0 = validar("","","", 72);
  
$task = '';

  if ( isset($_POST['task'])){
    $task = $_POST['task'];       // Get this from Ext
  }

  switch($task){
    case "LISTING":// Give the entire list
      if($_POST['textoBuscado' ]=="Texto a Buscar"){
      $_POST['textoBuscado' ]="";
     }
     buscarTexto($_POST, $link0);
    break;
    case "APROBARTODO":
    case "RECHAZARTODO":
     if($task=="APROBARTODO"){
     $ESTAd=2;
     }else{
     $ESTAd=3;
     }
    
    $consaprobar="SELECT id FROM requisiciones WHERE requisiciones.estado=1";
    $result=@mysql_query($consaprobar, $link0) or $error=@mysql_error($link0);
    $ini=0;
    $lim=@mysql_num_rows($result);
    for($ini=0;$ini<$lim;$ini++){
    $consultaAprobar="UPDATE requisiciones SET estado=$ESTAd WHERE id=".@mysql_result($result, $ini, 'id');
    $res=@mysql_query($consultaAprobar, $link0) or $error=@mysql_error($link0);
    }

    if($error==""){
    echo escaparaJSON('({"success":true, "numfilas":"'.$ini.'"})');
    }else{
        echo escaparaJSON('({"success":false, "error":"'.$error.'"})');
    }
    break;
    case "LISTAREQSINORDEN":
    if($_POST['textoBuscado' ]=="Texto a Buscar"){
    $_POST['textoBuscado' ]="";
    }
    buscarTextoReqOrden($_POST, $link0);
    break;
    case "UPDATE":
    saveData($link0);
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

  function buscarTexto($_POST, $link){
    $fecha0=getdate(time());
    $consulta0="SELECT nou FROM requisiciones LEFT JOIN productos ON requisiciones.idprod = productos.id LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%' OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%' OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`observaciones` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`serialrequisicion` LIKE '%$_POST[textoBuscado]%') AND `requisiciones`.`estado` LIKE '$_POST[tiporeq]'";
    $result0=@mysql_query($consulta0, $link) or $error=@mysql_error($link);
    $lim0=@mysql_num_rows($result0);

    $consulta="SELECT requisiciones.id as consreq, productos.id as idprod, nou, nombre, serialrequisicion, requisiciones.estado, apellidos, referencia, modelo, marca, fechareq, fechapre, nombreprod, cantidad, requisiciones.observaciones FROM requisiciones LEFT JOIN productos ON requisiciones.idprod = productos.id LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%' OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%' OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`observaciones` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`serialrequisicion` LIKE '%$_POST[textoBuscado]%') AND `requisiciones`.`estado` LIKE '$_POST[tiporeq]' $condicion LIMIT $_POST[start], $_POST[limit]";
    $result=@mysql_query($consulta, $link) or $error=@mysql_error($link);
    $lim=@mysql_num_rows($result);
    $cadenajson="";

    for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }

    $datos['idproducto']=@mysql_result($result, $ini,"idprod");
    $datos['nuevousado']=@mysql_result($result, $ini,"nou");
    $cantidadisponible=consultarsaldo($datos, $link);
    $cadenajson.="{id:'".@mysql_result($result, $ini,"consreq")."', nou:'".@mysql_result($result, $ini,"nou")."', nombre: '".@mysql_result($result, $ini,"nombre")." ".@mysql_result($result, $ini,"apellidos")."', serialrequisicion: ".@mysql_result($result, $ini,"serialrequisicion").", estado: '".@mysql_result($result, $ini,"estado")."', fechareq: '".@mysql_result($result, $ini,"fechareq")."', fechapre: '".@mysql_result($result, $ini,"fechapre")."',
        nombreprod: '".@mysql_result($result, $ini,"nombreprod")." ".@mysql_result($result, $ini,"referencia")." ".@mysql_result($result, $ini,"modelo")." ".@mysql_result($result, $ini,"marca")."', cantidad:'".@mysql_result($result, $ini,"cantidad")."', cantidadisponible:'$cantidadisponible', observaciones:'".@mysql_result($result, $ini,"observaciones")."'}$coma";
    }
    
    if($error==""){
    echo escaparaJSON('({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.'], consulta:"'.$consulta.'"})');
    }else{
        echo escaparaJSON('({"success":false, "error":"'.$error.'"})');
    }
  }

  function buscarTextoReqOrden($_POST, $link){
    $fecha0=getdate(time());
    $consulta0="SELECT requisiciones.id as consreq FROM requisiciones LEFT JOIN productos ON requisiciones.idprod = productos.id
    LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno
    LEFT JOIN ordenescompra ON requisiciones.id=ordenescompra.idrequisicion
    WHERE ordenescompra.idrequisicion IS NULL AND (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%' OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%' OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`observaciones` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`serialrequisicion` LIKE '%$_POST[textoBuscado]%') AND `requisiciones`.`estado` LIKE '$_POST[tiporeq]' $condicion";
    $result0=@mysql_query($consulta0, $link) or $error=@mysql_error($link);
    $lim0=@mysql_num_rows($result0);

    $consulta="SELECT requisiciones.id as consreq, productos.id as idprod, nou, nombre, serialrequisicion, requisiciones.estado, valorunitario, 
    apellidos, referencia, modelo, marca, fechareq, requisiciones.fechapre, nombreprod, cantidad, IF(idrequisicion IS NULL, 'false', 'true') as tiporden,
    requisiciones.observaciones FROM requisiciones LEFT JOIN productos ON requisiciones.idprod = productos.id
    LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno
    LEFT JOIN ordenescompra ON requisiciones.id=ordenescompra.idrequisicion 
    WHERE ordenescompra.idrequisicion IS NULL AND (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%' OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%' OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`observaciones` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`serialrequisicion` LIKE '%$_POST[textoBuscado]%') AND `requisiciones`.`estado` LIKE '$_POST[tiporeq]' $condicion LIMIT $_POST[start], $_POST[limit]";

    $result=@mysql_query($consulta, $link) or $error=@mysql_error($link);
    $lim=@mysql_num_rows($result);
    //$lim=100;
    $cadenajson="";

    for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }

    $datos['idproducto']=@mysql_result($result, $ini,"idprod");
    $datos['nuevousado']=@mysql_result($result, $ini,"nou");
    $cantidadisponible=consultarsaldo($datos, $link);
    $cadenajson.="{id:'".@mysql_result($result, $ini,"consreq")."', nou:'".@mysql_result($result, $ini,"nou")."', nombre: '".@mysql_result($result, $ini,"nombre")." ".@mysql_result($result, $ini,"apellidos")."', serialrequisicion: ".@mysql_result($result, $ini,"serialrequisicion").", estado: '".@mysql_result($result, $ini,"estado")."', fechareq: '".@mysql_result($result, $ini,"fechareq")."', fechapre: '".@mysql_result($result, $ini,"fechapre")."',
        nombreprod: '".@mysql_result($result, $ini,"nombreprod")." ".@mysql_result($result, $ini,"referencia")." ".@mysql_result($result, $ini,"modelo")." ".@mysql_result($result, $ini,"marca")."', cantidad:'".@mysql_result($result, $ini,"cantidad")."', tiporden:".@mysql_result($result, $ini,"tiporden").", cantidadisponible:'$cantidadisponible', valorunitario:'".@mysql_result($result, $ini,"valorunitario")."', observaciones:'".@mysql_result($result, $ini,"observaciones")."'}$coma";
    }
    
    if($error==""){
    echo escaparaJSON('({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.']})');
    }else{
        echo escaparaJSON('({"success":false, "error":"'.$error.'"})');
    }
  }

function saveData($link){

//verificar permiso de escritura
if(consPermisoForm(72, $_SESSION['idusuario'], 2)){

    if($_POST[estado]=="4" || $_POST[estado]=="5"){//aprobar toda la requisicion
        $sql="SELECT id from requisiciones WHERE serialrequisicion=$_POST[serialreq]";
        $result=mysql_query($sql, $link) or $error+=mysql_error($link);;
        $lim=@mysql_num_rows($result);
        $cadenajson="";

        if($_POST[estado]=="4"){
        $estu="2";
        }else{
        $estu="3";
        }
        
        for($ini0=0;$ini0<$lim;$ini0++){
            $consactu="UPDATE requisiciones SET estado=$estu, `idusuarioaprueba`='$_SESSION[idusuario]', `fechapre`=NOW(), `observaciones`='$_POST[observaciones]' WHERE id=".@mysql_result($result, $ini0,"id");
            @mysql_query($consactu, $link) or $error+=@mysql_error($link);
        }

    }else if($_POST[estado]=="6" || $_POST[estado]=="7"){//eliminar toda la requisicion
        if($_POST[estado]=="6"){
        $partecons="WHERE id=$_POST[id]";
        }else{
        $partecons="WHERE serialrequisicion=$_POST[serialreq]";
        }
        $sql="DELETE FROM requisiciones ".$partecons;
    $result=@mysql_query($sql, $link) or $error=@mysql_error();
    if($result){
    registrarMod("requisiciones", $sql, "eliminacion", $_SESSION, $link);
    }
    }else{//modficar el estado del producto individualmente
    $_POST['idusuarioaprueba']=$_SESSION['idusuario'];
    $_POST['fechapre']='NOW()';
    $_SESSION['datos']['claveprinc']='id';
    $_SESSION['clientemod']=$_POST['id'];
    $error.=armarEjecutarSentencia("requisiciones", $_POST, "update", $_SESSION, $link);
    }
    
if($error==""){
    echo escaparaJSON('({"success":true, "consulta":"'.$sql.'"})');
}else{
    echo escaparaJSON('({"success":false, "error":"'.$error. $sql.'"})');
}

}else{
echo '({"success":false, "error":"no tiene permiso de escritura"})';
}
}
?>
