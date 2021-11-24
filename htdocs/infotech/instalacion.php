<?php
@require('funciones2.php');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if($_POST['boton']=="Registrar"){
$texto=crearBaseDatos($_POST);
}
?>
<html>
    <style type="text/css" >
        .flotante{
        float:right;
        }
        .flotanteiz{
        float:left;
        }
        .peque{
        width: 400px;
        margin-left: 50px;
        }
        .serial{
        width: 400px;
        height: 20px;
        }
        .salto{
        height: 50px
        }
        body{
	font-family: Verdana, Helvetica, sans-serif;
	font-size: 10px;
        font-style: normal;
	line-height: 20px;
	color: #444499;
	margin: 0px;
	padding: 30px 0px 0px 100px;
	background: #cccccc no-repeat center right url("imagenesnuevas/infote3.png") fixed;
        }
        .texto{
           width: 100px;
           height: 20px;
        }
    </style>
<body>
    <div class="peque"><h2>Instalacion B&aacute;sica Infotech</h2></div>
<form action="instalacion.php" method="post">
    <div class="peque">Crear Base de Datos Infotech<div class="flotante"><input name="creardb" type="checkbox" checked="checked"></div></div>
    <div class="peque">Parametrizacion Inicial<div class="flotante"><input name="paraminicial" type="checkbox" checked="checked"></div></div>
    <div class="peque">Ingresar Datos de Usuario Basico<div class="flotante"><input name="datusbasico" type="checkbox" checked="checked"></div></div>
    <div class="peque">Serial MySql<div class="flotante"><input name="mysql" class="texto" type="text"></div></div>
    <div class="peque">Usuario Mysql<div class="flotante"><input name="usuario" class="texto" type="text"></div></div>
    <div class="peque">Password<div class="flotante"><input name="password" class="texto" type="password"></div></div>
    <div class="salto"></div>
    <div class="peque"><h2>Datos del Cliente</h2></div>
    <div class="peque">Ingresar Datos de Comprador<div class="flotante"><input name="datoscomprador" type="checkbox" checked="checked"></div></div>
    <div class="peque">Nit<div class="flotante"><input name="nit" class="texto" type="text"></div></div>
    <div class="peque">Razon Social<div class="flotante"><input name="razonsocial" class="texto" type="text"></div></div>
    <div class="peque">Numero Licencia<div class="flotante"><input name="numerolicencia" class="texto" type="text"></div></div>
    <div class="peque">Fecha de Inicio Licencia<div class="flotante"><input name="fechainiciolic" class="texto" type="text"></div></div>
    <div class="peque"><div class="flotanteiz"><a href="index.php">Login</a></div></div>
    <div class="salto"></div>
    <div class="peque"><h2>Usuario Primario</h2></div>
    <div class="peque">Ingresar Datos de Usuario Primario<div class="flotante"><input name="datosusuaprim" type="checkbox" checked="checked"></div></div>
    <div class="peque">Usuario<div class="flotante"><input name="usuarioInfo" class="texto" type="text"></div></div>
    <div class="peque">Password<div class="flotante"><input name="passwordInfo" class="texto" type="password"></div></div>
    <div class="salto"></div>
    <div class="peque"><div class="flotante"><input name="boton" type="submit" value="Registrar"></div></div>
</form>
    <div class="salto"></div>
    <div class="peque"><b>Resultado Ejecuci&oacute;n:</b><br/><textarea cols="80" rows="20" name="comentarios"><?php echo $texto;?></textarea></div>
</body>
</html>