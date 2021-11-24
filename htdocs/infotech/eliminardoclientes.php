<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 26);


foreach($_SESSION[docselimina] as $valor){

 	$eli="elimina".$valor;

 	if ($_POST[$eli]=="on"){
 		$sql="DELETE FROM `docsclientes` WHERE `docsclientes`.`id` = $valor LIMIT 1";
 		$sql2="INSERT INTO registrodemodificaciones (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal) VALUES (NOW(), 'Elimino documento', '$_SESSION[persona]','$_SESSION[clientemod]','1', $_SESSION[sucur])";
 		@mysql_query($sql);
 		@mysql_query($sql2);
 	}
}

echo 	"<script type='text/javascript'>
    	var pagina = 'subirdoclientes.php';
    	var segundos = 0;
    	function redireccion() {
	        document.location.href=pagina;
    	}
    	redireccion();
		</script>
		";
?>
