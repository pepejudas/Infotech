<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1);

$sql="SELECT foto64, dedo FROM huellas LEFT JOIN personalactivo ON huellas.carnetpersonal=personalactivo.carnetinterno WHERE personalactivo.cedula='$_SESSION[clientemod]'";

$resulta=@mysql_query($sql);
$ini=0;
$lim=@mysql_num_rows($resulta);

for($ini=0;$ini<$lim;$ini++){
  $huella64=@mysql_result($resulta, $ini, "foto64");
  $dedo=@mysql_result($resulta, $ini, "dedo");
  $cadenaH.='<div><h1>'.nombreDedo($dedo).'</h1><img alt="Huella Digital" src="data:image/jpg;base64,'.$huella64.'" style="margin-right: 5px; vertical-align: middle;" width="150px" class="bbns_itemDragger" /></div><br/>';
}

$result2=operaciones("personalactivo","buscar",$_SESSION[datos]);
$result=$result2[datos];

$persona=@mysql_result($result,$_SESSION['i'],"nombre")." ".@mysql_result($result,$_SESSION['i'],"apellidos");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<title>Huellas de <?php echo $persona;?></title>
<script language="JavaScript" type="text/JavaScript">
<!--
function cerrarventana(){
var ventana = window.close();
}
//-->
</script>

</head>
<body style="margin-left:0px;"><br>
<br/>
<div name="listado" style="margin-left:-70px;"><h1>Listado de Huellas Enroladas de:</h1><h3><?php echo "$persona</h3><h3>CC: $cedula";?></h3></div>
<br/>
<?php
echo $cadenaH;
/*
while (list($name, $value) = each($HTTP_POST_VARS)) { echo "<p align='center'>POST $name = $value<br>\n</p>";
}
while (list($name, $value) = each($HTTP_SESSION_VARS)) { echo "<p align='center'>SESSION $name = $value<br>\n";
}
*/
?>
<center><input type="submit" class="botcerrar" value="Cerrar" name="ejecut" onclick="cerrarventana();"/></center>
</body>

</html>