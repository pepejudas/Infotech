<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

@require('funciones2.php');

$link=validar("","","", 70);

 $task = '';

  if ( isset($_POST['task'])){
    $task = $_POST['task'];       // Get this from Ext
  }

  switch($task){
    case "BUSQUEDA":              // Give the entire list
      $sql0="SELECT cedula, nombre, apellidos, telefono, celular, direccion FROM personalactivo WHERE (cedula LIKE '%$_POST[query]%' OR nombre LIKE '%$_POST[query]%' OR apellidos LIKE '%$_POST[query]%' OR telefono LIKE '%$_POST[query]%' OR celular LIKE '%$_POST[query]%' OR pasadojudicial LIKE '%$_POST[query]%') AND activo=1 AND sucursal LIKE '$_SESSION[sucur]'";
      $res0=@mysql_query($sql0);
      $lim0=@mysql_num_rows($res0);
      
      $sql="SELECT cedula, nombre, apellidos, telefono, celular, direccion FROM personalactivo WHERE (cedula LIKE '%$_POST[query]%' OR nombre LIKE '%$_POST[query]%' OR apellidos LIKE '%$_POST[query]%' OR telefono LIKE '%$_POST[query]%' OR celular LIKE '%$_POST[query]%' OR pasadojudicial LIKE '%$_POST[query]%') AND activo=1 and sucursal LIKE '$_SESSION[sucur]' LIMIT $_POST[start], $_POST[limit]";
      
      $res=@mysql_query($sql);
      $ini=0;
      
      $lim=@mysql_num_rows($res);

      for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){$coma="";}else{$coma=", ";}
        $cadenajson.="{id: '".$ini."', cedula:'".@mysql_result($res, $ini, "cedula")."', nombre: '".@mysql_result($res, $ini, "nombre")."', apellidos: '".@mysql_result($res, $ini, "apellidos")."', telefono: '".@mysql_result($res, $ini, "telefono")."', celular: '".@mysql_result($res, $ini, "celular")."', direccion: '".@mysql_result($res, $ini, "direccion")."'}$coma";
      }
      echo '({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.'], sentencia:"'.$sql.'"})';
      break;
    default:
      echo "{failure:true}";     // Simple 1-dim JSON array to tell Ext the request failed.
      break;
  }
?>
