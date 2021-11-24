<?php
@session_start("acceso");
@require('funciones2.php');
@require('clases/claseNotificacion.php');
validar($_POST['nombre'], $_POST['contra'], $_POST['sucursal'], 73);
if($_GET['msg']!=""){$mens=$_GET['msg'];}
htmi(cardll());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script	type="text/javascript" src="scripts/validacionExt.js"></script>
<!-- CSS -->
<link	rel="stylesheet" href="estilo2.css" type="text/css"/>
<link	rel="stylesheet" href="botones.css" type="text/css"/>
<!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="css/style-ie.css" media="screen, projection, tv" /><![endif]-->
<link rel="shortcut icon" href="imagenes/info4.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<!-- LIBS -->
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/ux/GroupSummaryNotifica.js"></script>
<script type="text/javascript" src="ext/examples/form/busquedaNotifica.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<!-- Common Styles for the examples -->
<style type="text/css">
p { width:300px; }
</style>
<script type="text/javascript">
<?php echo "var idusua=".$_SESSION['idusuario']."; ";?>
</script>
<title></title>
</head>
<body <?php if($mens!=""){echo "onload=\"mensajeini($mens);return false;\"";}?>>

<div style="margin-left:220px; padding-top:0;width:465px;">
<?php
$not=new Notificacion();
//$not->verificarCreacionAutomatica();
$not->setIdusuarioNotificar($_SESSION['idusuario'], 0, 0);

if($not->numNotificaciones>0){
 echo '<div id="grid-example" style="position:fixed;z-index:10;margin-left: 105px;margin-top:0px"></div>';
}
echo "<script type=\"text/javascript\">var numNoti=".$not->numNotificaciones.";</script>";
?>
</div>
<div style="margin-top:40px">
<div id="divMenu" class="divMenu" style="top:60px;left:40px;"></div></div>
<div class="ininfo">
<img src="imagenesnuevas/infote.png" alt="Infotech" width="100px"/>
</div>
<div style="color:#000000;top:450px;left:90px;position:absolute">
<a href="http://www.xsitecompany.net" style="color:#ffffff;">
<img width="50px" src="imagenes/logoxsite.png" alt="logo infotech" style="border:none"/></a>
<?php require('saludos.php');?>
</div>
    <div class="mensajeBienv"><?php echo $razonsocial;?></div>
    <div class="mensajeBienv2"><?php echo "Infotech ".$version;?></div>
</body>
</html>