<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

$link=validar("","","", 22);

$cos="SELECT foto FROM armas WHERE id=$_SESSION[clientemod]";
$res=@mysql_query($cos);
$foto=mysql_result($res,0,'foto');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<title>Imagen Arma</title>
<link rel="stylesheet" href="estilo3.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">	
<script language="JavaScript" type="text/JavaScript">
<!--
function cerrarventana(){
var ventana = window.close();
}
//-->
</script>

</head>
<body style="margin-top:0px;margin-left:0px">
<?php echo '<img style="width:100%" name="changing" src="fotosarmas/'.$foto.'">';?>
<br/><br/>
<center><input type="submit" class="botcerrar" value="Cerrar" name="ejecut" onclick="cerrarventana();"/></center>
</body>
</html>