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
      $sql0="SELECT id FROM productos WHERE nombreprod LIKE '%$_POST[query]%' OR referencia LIKE '%$_POST[query]%' OR modelo LIKE '%$_POST[query]%' or marca LIKE '%$_POST[query]%' or serial LIKE '%$_POST[query]%'";
      $res0=@mysql_query($sql0);
      $lim0=@mysql_num_rows($res0);
      
      $sql="SELECT * FROM productos WHERE nombreprod LIKE '%$_POST[query]%' OR referencia LIKE '%$_POST[query]%' OR modelo LIKE '%$_POST[query]%' or marca LIKE '%$_POST[query]%' or serial LIKE '%$_POST[query]%' LIMIT $_POST[start], $_POST[limit]";

      
      $res=@mysql_query($sql);
      $ini=0;
      
      $lim=@mysql_num_rows($res);

      for($ini=0;$ini<$lim;$ini++){
        if($ini+1==$lim){$coma="";}else{$coma=", ";}
        $saldonuevo=consultarsaldo(array('idproducto'=>@mysql_result($res, $ini, "id"), 'nuevousado'=>'1'), $link);
        $saldousado=consultarsaldo(array('idproducto'=>@mysql_result($res, $ini, "id"), 'nuevousado'=>'2'), $link);
        $cadenajson.="{id: ".@mysql_result($res, $ini, "id").", nombreprod:'".@mysql_result($res, $ini, "nombreprod")."', referencia: '".@mysql_result($res, $ini, "referencia")."', marca: '".@mysql_result($res, $ini, "marca")."', tipoprod: '".@mysql_result($res, $ini, "tipoprod")."', modelo: '".@mysql_result($res, $ini, "modelo")."', disponuevo: $saldonuevo, dispousado: $saldousado}$coma";
      }
      echo '({"success":true, "numfilas":"'.$lim0.'", "datosjson":['.$cadenajson.']})';
      break;
    default:
      echo "{failure:true}";     // Simple 1-dim JSON array to tell Ext the request failed.
      break;
  }
?>
