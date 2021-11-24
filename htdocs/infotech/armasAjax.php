<?php
session_start();
//ini_set('display_errors', 1);

@require('funciones2.php');

$link0 = validar("","","", 22);
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
    case "LISTACLIENTES":
    listarClientes($link0);
    break;
    case "LISTAPERSONAS":
    listarPersonas($link0);
    break;
/*
 * task:CREAREXISTENCIAORDEN
observacionesreg:asdasd asd
 */
    case "ACTUALIZARMA":
    saveData($link0);
    break;
    default:
    echo "{failure:true}";     // Simple 1-dim JSON array to tell Ext the request failed.
    break;
  }

 function listarClientes($lin){
 $consulta="SELECT codigo, CONCAT(codigo, ' ', nombrecliente) as cliente FROM clientes WHERE activo = 1 AND sucursal='$_SESSION[sucur]' ORDER BY codigo";
 $res=@mysql_query($consulta, $lin) or $error=@mysql_error($lin); ;
 $ini=0;
 $lim=@mysql_num_rows($res);
 for($ini=0;$ini<$lim;$ini++){

        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }

    $cadenajson.="{codigo:'".@mysql_result($res, $ini,"codigo")."', cliente:'".@mysql_result($res, $ini,"cliente")."'}$coma";
   
 }
 
   if($error==""){
    echo escaparaJSON('({"success":true, "datosjson":['.$cadenajson.']})');
    }else{
    echo escaparaJSON('({"success":false, "error":"'.$error.'", consulta:"'.$consulta.'"})');
    }
 }
 function listarPersonas($lin){
 $consulta="SELECT cedula, CONCAT(apellidos, ' ', nombre, ' ', cedula) as persona FROM personalactivo WHERE activo=1 AND sucursal='$_SESSION[sucur]' ORDER BY apellidos";
 $res=@mysql_query($consulta, $lin) or $error=@mysql_error($lin);;
 $ini=0;
 $lim=@mysql_num_rows($res);
 for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){
            $coma="";
        }else{
            $coma=", ";
        }
$cadenajson.="{cedula:'".@mysql_result($res, $ini,"cedula")."', persona:'".@mysql_result($res, $ini,"persona")."'}$coma";
}

if($error==""){
    echo escaparaJSON('({"success":true, "datosjson":['.$cadenajson.']})');
    }else{
    echo escaparaJSON('({"success":false, "error":"'.$error.'", consulta:"'.$consulta.'"})');
    }
 }
 
function crearExistencia($_post, $link, $responder){
/*
* task:CREAREXISTENCIA
cantidad:6
estado:1
observaciones:ninguna por ahora
idorden:1
*/
    //consultar primero si la orden no ha generado antes un registro de existencias
$sql="SELECT ordenescompra.estado, idprod, valorunitario, idprov, NOW() as fechaOr, serialrequisicion FROM ordenescompra LEFT JOIN requisiciones ON ordenescompra.idrequisicion=requisiciones.id
LEFT JOIN productos ON productos.id=requisiciones.idprod
WHERE ordenescompra.id=".$_post['idorden']." LIMIT 1";
$consestado=@mysql_query($sql, $link) or $error=@mysql_error($link);
/*
INSERT INTO `relacional`.`movproductos`
(`id`,`idprod`,`fecha`,`cantidad`,`precio`,`facturaoreq`,`remisionocom`,`eos`,`observacionesreg`,`sucursal`,`nou`,`proveedor`)
*/

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

$post['cantidad']=validarDato($contestado, $_post, 'cantidad');
$post['nou']=validarDato($contestado, $_post, 'nou');

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
    $consulta0="SELECT armas.id
FROM armas
LEFT JOIN personalactivo ON armas.codigo = personalactivo.cedula
LEFT JOIN clientes ON armas.codigo = clientes.codigo
WHERE (
SERIAL LIKE  '%$_POST[textoBuscado]%'
OR tipoarma LIKE  '%$_POST[textoBuscado]%'
OR marca LIKE  '%$_POST[textoBuscado]%'
OR calibre LIKE  '%$_POST[textoBuscado]%'
OR clasepermiso LIKE  '%$_POST[textoBuscado]%'
OR armas.codigo LIKE  '%$_POST[textoBuscado]%'
OR salvoconducto LIKE  '%$_POST[textoBuscado]%'
OR vencesalvoconducto LIKE  '%$_POST[textoBuscado]%'
OR observacionarma LIKE  '%$_POST[textoBuscado]%'
OR fechaentrega LIKE  '%$_POST[textoBuscado]%'
OR clientes.nombrecliente LIKE  '%$_POST[textoBuscado]%'
OR clientes.codigo LIKE  '%$_POST[textoBuscado]%'
OR clientes.nit LIKE  '%$_POST[textoBuscado]%'
OR personalactivo.cedula LIKE  '%$_POST[textoBuscado]%'
OR personalactivo.nombre LIKE  '%$_POST[textoBuscado]%'
OR personalactivo.apellidos LIKE  '%$_POST[textoBuscado]%'
)";

    $result0=@mysql_query($consulta0, $link) or $error=@mysql_error($link);
    $lim0=@mysql_num_rows($result0);

$consulta="SELECT cedula, armas . * , CONCAT( personalactivo.nombre,  ' ', personalactivo.apellidos,  ' ', personalactivo.cedula ) AS poseedorpersona, CONCAT( clientes.codigo,  ' ', clientes.nombrecliente ) AS poseedorcliente
FROM armas
LEFT JOIN personalactivo ON armas.codigo = personalactivo.cedula
LEFT JOIN clientes ON armas.codigo = clientes.codigo
WHERE (
SERIAL LIKE  '%$_POST[textoBuscado]%'
OR tipoarma LIKE  '%$_POST[textoBuscado]%'
OR marca LIKE  '%$_POST[textoBuscado]%'
OR calibre LIKE  '%$_POST[textoBuscado]%'
OR clasepermiso LIKE  '%$_POST[textoBuscado]%'
OR armas.codigo LIKE  '%$_POST[textoBuscado]%'
OR salvoconducto LIKE  '%$_POST[textoBuscado]%'
OR vencesalvoconducto LIKE  '%$_POST[textoBuscado]%'
OR observacionarma LIKE  '%$_POST[textoBuscado]%'
OR fechaentrega LIKE  '%$_POST[textoBuscado]%'
OR clientes.nombrecliente LIKE  '%$_POST[textoBuscado]%'
OR clientes.codigo LIKE  '%$_POST[textoBuscado]%'
OR clientes.nit LIKE  '%$_POST[textoBuscado]%'
OR personalactivo.cedula LIKE  '%$_POST[textoBuscado]%'
OR personalactivo.nombre LIKE  '%$_POST[textoBuscado]%'
OR personalactivo.apellidos LIKE  '%$_POST[textoBuscado]%'
) ORDER BY clientes.codigo, personalactivo.apellidos
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

        if(@mysql_result($result, $ini,"poseedorpersona")!="" && @mysql_result($result, $ini,"cedula")!="0"){
            $posee="poseedor:'".@mysql_result($result, $ini,"poseedorpersona")."',";
        }else{
            $posee="poseedor:'".@mysql_result($result, $ini,"poseedorcliente")."',";
        }
/*
 *   var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'serial', type: 'int'},
        {name: 'tipoarma', type: 'int'},
        {name: 'marca', type: 'string'},
        {name: 'calibre', type: 'string'},
        {name: 'clasepermiso', type: 'string'},
        {name: 'poseedor', type: 'string'},
        {name: 'salvoconducto', type: 'string'},
        {name: 'vencesalvoconducto', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'observacionarma', type: 'string'},
        {name: 'fechaentrega', type: 'date', dateFormat:'Y-m-d H:i:s'}
    ]);
 */
    $cadenajson.="{id:'".@mysql_result($result, $ini,"id")."', serial:'".@mysql_result($result, $ini,"serial")."', tipoarma: '".@mysql_result($result, $ini,"tipoarma")."',
        marca: '".@mysql_result($result, $ini,"marca")."', calibre: '".@mysql_result($result, $ini,"calibre")."',
        clasepermiso: '".@mysql_result($result, $ini,"clasepermiso")."',
        clasificacion: '".@mysql_result($result, $ini,"clasificacion")."',
        $posee
        foto: '".@mysql_result($result, $ini,"foto")."',
        salvoconducto: '".@mysql_result($result, $ini,"salvoconducto")."',
        vencesalvoconducto: '".@mysql_result($result, $ini,"vencesalvoconducto")."',
        observacionarma: '".@mysql_result($result, $ini,"observacionarma")."', fechaentrega:'".@mysql_result($result, $ini,"fechaentrega")."'}$coma";
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

    /*
            $consactu="UPDATE armas SET codigo='$_POST[codigo]', `fechaentrega`='$_POST[fechaentrega]', `observacionarma`='$_POST[observacionarma]' WHERE id=".$_POST[idarma];
            @mysql_query($consactu, $link) or $error+=@mysql_error($link);
    */

$datos1['clientemod']=$_POST['idarma'];
$datos1['datos']['claveprinc']="id";

$error=armarEjecutarSentencia("armas", $_POST, "update", $datos1);

if($error==""){
    echo escaparaJSON('({"success":true, "consulta":"'.$consactu.'"})');
}else{
    echo escaparaJSON('({"success":false, "error":"'.$error. $sql.'"})');
}

}
?>
