<?php
session_start();
session_unset();
session_destroy();
session_unset($_SESSION['iuj345iuh']);

@require('funciones2.php');

conectar();

$muestr[1]="ciudad";

$cadena=selection("sucursales","id","%",$muestr,"2",1,"id","");

if($_GET['msg']!=""){$mens=$_GET['msg'];}

caracteresiso();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<title>
	INFOTECH
	</title>
	<head>
	<!-- inicio librerias extjs -->
        <link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
        <script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="ext/ext-all.js"></script>
        <link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
        <link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
        <link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
        <style type="text/css">
        p { width:300px; }
        </style>

        <!-- fin librerias extjs -->
        <script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
        <script type="text/javascript">
            function mensajeini(msginicio){
            Ext.Msg.alert("Atencion", "<div class=\"contenedoralerta\"><div class=\"contenedorimalerta\"><img src=\"imagenes/dialog-warning.png\"></div><div class=\"contenedoral\">"+msginicio+"</div></div>");
            }

                      Ext.onReady(function(){
                      Ext.get('nombreusuario').focus();
                      });
        </script>
	<meta name="author" content="FERLEY ARDILA CAICEDO">
	<link rel="stylesheet" href="estilo2.css" type="text/css">
	<link rel="stylesheet" href="botones.css" type="text/css">
	<link rel="shortcut icon" href="imagenes/info4.ico"/>
	</head>
	<body <?php if($mens!=""){echo "onload=\"mensajeini($mens);return false;\"";}?> style="background: #CCC">
		<form method="post" action="inicio.php" name="loginform" onsubmit="return validalog();">
<table class="index" style="margin-top:150px">
<tr>
<td colspan="3" align="center" height="10px">
</td>
</tr>
<tr valign="top">
<td colspan="3"></td>
</tr>
<tr style="height:1%;  width:1px;" valign="top">
<td rowspan="8" width="185px" valign="middle"  align="center" >
<img src="imagenesnuevas/infote.png" width="100px">
</td>
<td valign="top" align="right">Usuario:</td>
<td valign="top"><input class="int" name="nombre" type="text" class="largo" id="nombreusuario">
</td>
</tr>
<tr style="height:1%;  width:1px;" valign="top">
<td align="right">Password:</td>
<td valign="top"><input class="int" type="password" name="contra" class="largo"></td>
<tr>
<tr style="height:1%;  width:1px;" valign="top">
<td align="right">Sucursal:</td>
<td valign="top">
<select name="sucursal" class="largo1">
<?php echo $cadena; ?>
</select>
</td>
<tr>
<!-- <tr style="height:1px;  width:1px;" valign="top">
<td align="right"></td>
<td valign="top">
<a href="recuperar.php" style="font-size:10px">Recuperar Contrase&ntilde;a</a>
</td>
<tr>
-->
<td></td>
<td align="left">
<input type="submit" class="botoinglogin" name="ing" value="Ingresar"/>
</td>
</tr>
</table>
</form>
<div id="divMenu" class="divMenu"></div>
<div style="margin-right: 220px;text-align: right">
<a href="http://www.xsitecompany.net">
<img width="50px" src="imagenes/logoxsite.png" alt="logo infotech" style="border:none"/></a>
<?php require('saludos.php');?></div>
<?php
@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
echo $escribir;
?>
</body>
</html>
