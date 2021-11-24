<?php
session_start();
//ini_set('display_errors', 1);

@require('funciones2.php');

$link0 = validar("","","", 75);
$task = '';
$error="";

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
    case "CREAREXISTENCIA":
    crearExistencia($_POST, $link0, true);
    break;
    case "ELIMINARITEM":
    case "ELIMINARORDEN":
    if($task=="ELIMINARITEM"){
    $campo="id";
    }else{
    $campo="serialorden";
    }
    
    $sql="DELETE FROM ordenescompra WHERE $campo=".$_POST[$campo];
    $res=@mysql_query($sql, $link0);
    $cuantas=@mysql_affected_rows($link);

    if($error==""){
        echo '({"success":true, "numfilas":"'.$cuantas.'"})';
    }else{
        echo '({"success":false, "error":"'.$error.'"})';
    }
    break;
    case "CREAREXISTENCIAORDEN":
    //consultar listado de ordenes de la misma serie
    $sql="SELECT id FROM ordenescompra WHERE serialorden=".$_POST[idorden];
    $result=@mysql_query($sql, $link0) or $error=@mysql_error($link0);

    $lim=@mysql_num_rows($result);

    for($ini=0;$ini<$lim;$ini++){//iterar todas las ordenes de la misma orden
        $_POST['idorden']=@mysql_result($result, $ini, 'id');
        $cuantas+=crearExistencia($_POST, $link0, false);
    }
    
    if($error==""){
        echo '({"success":true, "numfilas":"'.$cuantas.'"})';
    }else{
        echo '({"success":false, "error":"'.$error.'"})';
    }
    break;
    case "LISTAPROVEEDORES":// Give the entire list
    $consulta="SELECT id, CONCAT(IFNULL(nombreprov,''), ' ', IFNULL(contacto,''), ' ', IFNULL(nit,''), ' ') as provee FROM proveedores WHERE sucursal='".$_SESSION[sucur]."'";
    $result=@mysql_query($consulta, $link0) or $error=@mysql_error($link0);
    $lim=@mysql_num_rows($result);
    $cadenajson="";

    for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }
    $cadenajson.=escaparaJSON("{id:'".@mysql_result($result, $ini,"id")."', provee:'".@mysql_result($result, $ini,"provee")."'}$coma");
    }
    if($error==""){
    echo escaparaJSON('({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.'], consulta:"'.$consulta.'"})');
    }else{
    echo escaparaJSON('({"success":false, "error":"'.$error.'"})');
    }
    break;
    case "UPDATE":
    saveData($link0);
    break;
    case "CREARORDEN":
    crearOrden($_POST, $link0);
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
function crearExistencia($_post, $link, $responder){//con cantidauto carga desde la requisicion el numero de unidades para la existencia
//consultar primero si la orden no ha generado antes un registro de existencias
$sql="SELECT ordenescompra.estado, nou, cantidad, idprod, valorunitario, idprov, NOW() as fechaOr, serialrequisicion FROM ordenescompra LEFT JOIN requisiciones ON ordenescompra.idrequisicion=requisiciones.id
LEFT JOIN productos ON productos.id=requisiciones.idprod
WHERE ordenescompra.id=".$_post['idorden']." LIMIT 1";
$consestado=@mysql_query($sql, $link) or $error=@mysql_error($link);

$estadOrden=mysql_result($consestado, 0, 'ordenescompra.estado');
if($estadOrden==1){//si la orden fue creada pero no se ha recibido aun crear registro de existencia

$_post['estado']=2;
$_post['idprod']=@mysql_result($consestado, 0, 'idprod');
$_post['fecha']=@mysql_result($consestado, 0, 'fechaOr');
$_post['precio']=@mysql_result($consestado, 0, 'valorunitario');
$_post['facturaoreq']=@mysql_result($consestado, 0, 'serialrequisicion');
$_post['eos']=1;
$_post['proveedor']=@mysql_result($consestado, 0, 'idprov');
$_post['sucursal']=$_SESSION['sucur'];
$_post['observacionesreg'].=" Registro generado desde elaboracion de ordenes de compra";

$_post['cantidad']=validarDato($consestado, $_post, 'cantidad');
$_post['nou']=validarDato($consestado, $_post, 'nou');

$error=armarEjecutarSentencia("movproductos", $_post, "insert", $_SESSION);

if($error==""){
$sql1="UPDATE ordenescompra SET estado=2 WHERE id=".$_post[idorden];
$consestado=@mysql_query($sql1, $link) or $error=@mysql_error($link);
$contado=@mysql_affected_rows($link);
}
}else{
 $error.=" El estado de la requsicion no permite crear un ingreso de existencias";
}

if($responder){
 if($error==""){
    echo '({"success":true, "numfilas":"'.$contado.'"})';
    }else{
    echo '({"success":false, "error":"'.$error.'"})';
    }
}
return $contado;
}
function validarDato($result, $post, $dato){
    if($post[$dato]!=""){
    return $post[$dato];
    }else{
     return @mysql_result($result, 0, $dato);
    }
}
 function crearOrden($_POST, $link){
//consultar serial de orden para ingresar
$serialOrden="SELECT serialorden FROM ordenescompra ORDER BY serialorden DESC LIMIT 1";  
$conserial=@mysql_query($serialOrden, $link) or $error=@mysql_error($link);
$numNuevo=@mysql_result($conserial, 0,'serialorden')+1;
$numOrdenes=split(",", $_POST['requisiciones']);

foreach($numOrdenes as $key => $value){//ejecutar una sentencia por cada requisicion a incluir en las ordenes de compra
$contado++;
$consRequi="SELECT * FROM requisiciones WHERE id='".$value."' LIMIT 1";
$resRequi=@mysql_query($consRequi, $link) or $error=@mysql_error($link);
$sqlcreaorden="INSERT INTO `relacional`.`ordenescompra` (`serialorden`,`idusuariordena`, `idrequisicion`,`idprov`,`fechaorden`,
`formadepago`,`plazodentrega`,`estado`,`observacionesorden`,`sucursal`) VALUES (
'$numNuevo', '$_SESSION[idusuario]', '$value', '$_POST[idprov]', NOW(),'$_POST[formapago]','$_POST[plazoentrega]', '1','$_POST[observaciones]','$_SESSION[sucur]')";
$resOrden=@mysql_query($sqlcreaorden, $link) or $error=@mysql_error();
}
   if($error==""){
    echo '({"success":true, "numfilas":"'.$contado.'"})';
    }else{
    echo '({"success":false, "error":"'.$error.'"})';
    }
}

function buscarTexto($_POST, $link){
    $fecha0=getdate(time());
    $consulta0="SELECT ordenescompra.id
    FROM ordenescompra LEFT JOIN usuarios ON ordenescompra.idusuariordena=usuarios.id
    LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno
    LEFT JOIN proveedores ON ordenescompra.idprov = proveedores.id INNER JOIN requisiciones ON requisiciones.id=ordenescompra.idrequisicion
    LEFT JOIN productos ON requisiciones.idprod=productos.id
    WHERE (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%'
    OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%'
    OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `ordenescompra`.`observacionesorden`
    LIKE '%$_POST[textoBuscado]%' OR `ordenescompra`.`serialorden` LIKE '%$_POST[textoBuscado]%') AND `ordenescompra`.`estado` LIKE '$_POST[tiporeq]'";

    $result0=@mysql_query($consulta0, $link) or $error=@mysql_error($link);
    $lim0=@mysql_num_rows($result0);

    $consulta="SELECT ordenescompra.id, serialorden, ordenescompra.estado, fechaorden, plazodentrega, formadepago,
    CONCAT(IFNULL(nombreprod, ''), ' ', IFNULL(referencia,''), ' ', IFNULL(modelo,''), ' ', IFNULL(marca,'')) as  nombreproducto,
    CONCAT(IFNULL(nombreprov,''), ' ', IFNULL(proveedores.contacto,''), ' ', IFNULL(proveedores.telefono1,'')) as  nombreprovee,
    CONCAT(nombre, ' ', apellidos) as  nombresolicitante, cantidad, observacionesorden
    FROM ordenescompra LEFT JOIN usuarios ON ordenescompra.idusuariordena=usuarios.id
    LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno
    LEFT JOIN proveedores ON ordenescompra.idprov = proveedores.id INNER JOIN requisiciones ON requisiciones.id=ordenescompra.idrequisicion
    LEFT JOIN productos ON requisiciones.idprod=productos.id 
    WHERE (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%'
    OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%'
    OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `ordenescompra`.`observacionesorden`
    LIKE '%$_POST[textoBuscado]%' OR `ordenescompra`.`serialorden` LIKE '%$_POST[textoBuscado]%') AND `ordenescompra`.`estado` LIKE '$_POST[tiporeq]'
    LIMIT $_POST[start], $_POST[limit]";

    $result=@mysql_query($consulta, $link) or $error=@mysql_error($link);
    $lim=@mysql_num_rows($result);
    $cadenajson="";

    for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }

    $cadenajson.="{id:'".@mysql_result($result, $ini,"id")."', serialorden:'".@mysql_result($result, $ini,"serialorden")."', estado: '".@mysql_result($result, $ini,"estado")."',        fechaorden: '".@mysql_result($result, $ini,"fechaorden")."', plazodentrega: '".@mysql_result($result, $ini,"plazodentrega")."',
        formadepago: '".@mysql_result($result, $ini,"formadepago")."', nombreproducto: '".@mysql_result($result, $ini,"nombreproducto")."', 
        nombreprovee: '".@mysql_result($result, $ini,"nombreprovee")."',
        nombresolicitante: '".@mysql_result($result, $ini,"nombresolicitante")."',
        cantidad: '".@mysql_result($result, $ini,"cantidad")."', observacionesorden:'".@mysql_result($result, $ini,"observacionesorden")."'}$coma";
    }

    if($error==""){
    echo escaparaJSON('({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.']})');
    }else{
    echo escaparaJSON('({"success":false, "error":"'.$error.'", consulta:"'.$consulta.'"})');
    }
  }


  function buscarTextoRequisiciones($_POST, $link){
    $fecha0=getdate(time());
    $consulta0="SELECT nou FROM requisiciones LEFT JOIN productos ON requisiciones.idprod = productos.id LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%' OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%' OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`observaciones` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`serialrequisicion` LIKE '%$_POST[textoBuscado]%') AND `requisiciones`.`estado` LIKE '$_POST[tiporeq]'";
    $result0=@mysql_query($consulta0, $link) or $error=@mysql_error($link);
    $lim0=@mysql_num_rows($result0);

    $consulta="SELECT requisiciones.id as consreq, productos.id as idprod, nou, nombre, idreq, serialrequisicion, requisiciones.estado, apellidos, referencia, modelo, marca, fechareq, fechapre, nombreprod, cantidad, requisiciones.observaciones FROM requisiciones LEFT JOIN productos ON requisiciones.idprod = productos.id LEFT JOIN usuarios ON requisiciones.idusuarioreq=usuarios.id LEFT JOIN personalactivo ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE (`personalactivo`.`nombre` LIKE '%$_POST[textoBuscado]%' OR `personalactivo`.`apellidos` LIKE '%$_POST[textoBuscado]%' OR `productos`.`nombreprod` LIKE '%$_POST[textoBuscado]%' OR `productos`.`referencia` LIKE '%$_POST[textoBuscado]%' OR `productos`.`modelo` LIKE '%$_POST[textoBuscado]%' OR `productos`.`marca` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`observaciones` LIKE '%$_POST[textoBuscado]%' OR `requisiciones`.`serialrequisicion` LIKE '%$_POST[textoBuscado]%') AND `requisiciones`.`estado` LIKE '$_POST[tiporeq]' LIMIT $_POST[start], $_POST[limit]";
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
    $cadenajson.="{id:'".@mysql_result($result, $ini,"consreq")."', nou:'".@mysql_result($result, $ini,"nou")."', nombre: '".@mysql_result($result, $ini,"nombre")." ".@mysql_result($result, $ini,"apellidos")."', idreq: ".@mysql_result($result, $ini,"idreq").", serialrequisicion: ".@mysql_result($result, $ini,"serialrequisicion").", estado: '".@mysql_result($result, $ini,"estado")."', fechareq: '".@mysql_result($result, $ini,"fechareq")."', fechapre: '".@mysql_result($result, $ini,"fechapre")."',
        nombreprod: '".@mysql_result($result, $ini,"nombreprod")." ".@mysql_result($result, $ini,"referencia")." ".@mysql_result($result, $ini,"modelo")." ".@mysql_result($result, $ini,"marca")."', cantidad:'".@mysql_result($result, $ini,"cantidad")."', cantidadisponible:'$cantidadisponible', observaciones:'".@mysql_result($result, $ini,"observaciones")."'}$coma";

    }

    if($error==""){
    echo escaparaJSON('({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.'], consulta:"'.$consulta.'"})');
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
    registrarMod("ordenesdecompra", $sql, "eliminacion", $_SESSION, $link);
    }
    }else{//modficar el estado del producto individualmente
    $sql="UPDATE requisiciones SET `estado`=$_POST[estado], `idusuarioaprueba`='$_SESSION[idusuario]', `nou`=$_POST[nou], `fechapre`=NOW(), `cantidad`='$_POST[cantidad]', `observaciones`='$_POST[observaciones]' WHERE id='$_POST[id]'";
    $result=@mysql_query($sql, $link) or $error=@mysql_error();
    if($result){
    registrarMod("ordenesdecompra", $sql, "actualizacion", $_SESSION, $link);
    }
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
