<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

@require('funciones2.php');
@require('clases/claseNotificacion.php');

$link=validar("","","", 73);

 $task = '';

  if ( isset($_POST['task'])){
    $task = $_POST['task'];       // Get this from Ext
  }

  $listaJSON=new Notificacion();
  
  switch($task){
    case "BUSQUEDA":              // Give the entire list
      echo $listaJSON->setIdusuarioNotificar($_POST['idusuario'], $_POST[start], $_POST[limit]);
      break;
    case "UPDATE":
      $listaJSON->setIdusuarioNotificar($_POST['idusuario'], $_POST[start], $_POST[limit]);
      $listaJSON->actualizarRegistro($_POST['id'], $_POST['estado'], $_POST['descripcion']);
      if($listaJSON->error==""){//no hay error
       echo '({"success":true})';
      }else{
       echo '({"success":false, "error":"'.$this->error.'"})';
      }
    break;
    default:
    echo "{failure:true}";     // Simple 1-dim JSON array to tell Ext the request failed.
    break;
  }
?>