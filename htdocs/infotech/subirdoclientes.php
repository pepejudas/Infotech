<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 26);

$result2=operaciones("clientes","buscar",$_SESSION[datos]);
$result=$result2[datos];

$cliente=@mysql_result($result,$_SESSION['i'],"nit")." ".@mysql_result($result,$_SESSION['i'],"nombrecliente");
$codigo=@mysql_result($result,$_SESSION['i'],"codigo");

switch ($_POST[boton]){
case "Guardar":

if($_FILES["rutafoto"]['type']!=""){

    		$tamano = $_FILES["rutafoto"]['size'];
    		$tipo = $_FILES["rutafoto"]['type'];
    		$archivo = $_FILES["rutafoto"]['name'];
    		$prefijo = substr(md5(uniqid(rand())),0,6);

                // copiar la foto al directorio de fotos
                $extension=extension($archivo);

                if ($archivo != ""){
                // guardamos el archivo a la carpeta files
                $narch=$prefijo."_".time().".".$extension;
    	    	$destino =  "docsclientes/".$narch;
                //die($destino);
        		copy($_FILES['rutafoto']['tmp_name'],$destino);
        		$sql="INSERT INTO docsclientes (nombre, codigodoc, titulo, observaciones) VALUES ('$narch', '$codigo', '$_POST[titulo]', '$_POST[observaciones]')";
            		$sql2="INSERT INTO registrodemodificaciones (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal) VALUES (NOW(), 'Ingreso de documento de cliente', '$_SESSION[persona]','$_SESSION[clientemod]','1', $_SESSION[sucur])";
        		@mysql_query($sql);
        		@mysql_query($sql2);
		    }
}
break;
}
function consultardocs($cedula1){
	$sql="SELECT * FROM docsclientes WHERE docsclientes.codigodoc = '$cedula1' ORDER BY titulo";
	$result2=@mysql_query($sql);

	$docs='<div style="margin-left:-70px"><form action="eliminardoclientes.php" method="post">';
	while($row = @mysql_fetch_array($result2)){
	$contad++;
	$docs.= '<table class="control2"><tr><td><b>'.$row["titulo"].' </td><td><input name="elimina'.$row["id"].'" type="checkbox"/></td></tr><tr><td rowspan="2"><a href="docsclientes/'.$row["nombre"].'" target="_blank">'.$row[nombre].'</a></td><td valign="top">'.$row["observaciones"].'</td></tr><tr><td valign="top"></td></tr></table><hr style="margin-left:0px;margin-right:30px"/><br>';
	$casilla=$row["id"];
	$_SESSION[docselimina][$casilla]=$row["id"];
	}
	$docs.='<table class="control2"><tr><td colspan="2"><b>Eliminar Documentos seleccionados</td></tr><tr><td rowspan="2"><input type="submit" class="botoelimina" value="Eliminar" name="boton"/></td><td valign="top"></td></tr><tr><td valign="top"></td></tr></table><br></form></div>';

return $docs;
}
$docs2=consultardocs($codigo);

echo $escribir;

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
	<title>Documentos de <?php echo $cliente;?></title>
<script language="JavaScript" type="text/JavaScript">
<!--
function cerrarventana(){
var ventana = window.close();
}
//-->
</script>

</head>
<body style="margin-left:0px;"><br>
<div align="left" style="margin-right:70px;"><img src="imagenesnuevas/documentos.png"/></div>
<br>
<div>
<form action="subirdoclientes.php" method="post" enctype="multipart/form-data">
<table class="control2">
	<tr>
		<td>Agregar Archivo:</td>
		<td><input type="file" name="rutafoto"/></td>
	</tr>
        <tr>
		<td>Titulo Archivo:</td>
		<td><input type="text" name="titulo"/></td>
	</tr>
	<tr>
		<td>Comentarios:</td>
                <td><textarea rows="3" name="observaciones" cols="20"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="botoactu" value="Guardar" name="boton"/></td>
	</tr>

</table>
<hr style="margin-left:-70px;margin-right:30px"/>
</form>

</div>
<div name="listado" style="margin-left:-70px;"><h1>Listado de Archivos de:</h1><h3><?php echo "$cliente</h3><h3>Codigo: $codigo";?></h3></div>
<br>
<?php
echo $docs2;
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


