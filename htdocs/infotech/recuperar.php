<?php
@require('funciones2.php');

conectar();

$muestr[1]="ciudad";

$cadena=selection("sucursales","id","%",$muestr,"2",1,"id","");

caracteresiso();

require("correo/phpmail/class.phpmailer.php");

if($_POST['boton']=="Enviar" && $_POST['email']!=""){

	$sql0="SELECT * FROM `relacional`.`usuarios`";
	$cons=@mysql_query() or $error." 17";
	
	$datos;//la contraseña esta encriptada ahh
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
	$mail->Username = "usuarios@xsitecompany.net";
	$mail->Password = "20001015";
	$mail->From = "usuarios@xsitecompany.net";
	$mail->FromName = "Soporte Infotech";
	$mail->AddAddress("$email", "$usuario");
	$mail->WordWrap = 50;                                 // set word wrap to 50 characters

	//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

	$mail->IsHTML(true);                                  // set email format to HTML

	$mail->Subject = "Recuperacion de Cuenta Infotech";
	$mail->Body    = "Recuperacion de Cuenta Infotech";
	$mail->AltBody = "Los datos de Ingreso al sistema Infotech son Usuario: $usuario, Password: $pass, Email: $email, Sucursal: $sucursal";

	
	if(!$mail->Send())
	{
    //echo "Message could not be sent. <p>";
    //echo "Mailer Error: " . $mail->ErrorInfo;
    //exit;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<title/>
	Recuperar Contrase&ntilde;a
	</title>
	<head>
	<script type="text/javascript" src="scripts/jquery.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="scripts/sexyalertbox.v1.2.jquery.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="estilos/sexyalertbox.css"/>
	<script	language="javascript" type="text/javascript" src="scripts/validacion.js"></script>
	<script type="text/javascript">
	function mensajeini(msginicio){
		Sexy.alert(msginicio);
	}
	</script>
	<meta name="author" content="FERLEY ARDILA CAICEDO">
	<link rel="stylesheet" href="estilo3.css" type="text/css">
	<link rel="stylesheet" href="estiloletras.css" type="text/css">
	<link rel="stylesheet" href="botones.css" type="text/css">
	<link rel="shortcut icon" href="imagenes/info4.ico"/>
	</head>
	<body <?php if($mens!=""){echo "onload=\"mensajeini($mens);return false;\"";}?>>
			<center><br/><h5>By Xsite Information Technology Company</h5>			
		<br>
		<form method="post" action="inicio.php" name="loginform" onsubmit="return validalog();">
<br/><br/>
<table align="center" class="index" border=0>
<tr>
<td colspan="3" align="center" height="10px">
</td>
</tr>
<tr valign="top">
<td colspan="3"></td>
</tr>
<tr style="height:1%;  width:1px;" valign="top">
<td rowspan="8" width="185px" valign="middle"  align="center" >
<img src="imagenesnuevas/infote.png" width="150px">
</td>
<td valign="top" align="right"><b>Email:</b></td>
<td valign="top"><input class="int" name="email" type="text" style="width:115px">
</td>
</tr>
<tr style="height:1%;  width:1px;" valign="top">
<td align="right"><b>Sucursal:</b></td>
<td valign="top">
<select name="sucursal" style="width:120px">
<?php echo $cadena; ?>
</select>
</td>
<tr>
<td></td>
<td align="left">
<input type="submit" class="botoing" name="ing" value="Ingresar al sistema"/>
</td>
</tr>
</table>
</form></center>
</body>
</html>
