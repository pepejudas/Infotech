<?php

session_start();
//ini_set('display_errors', 1);

@require('funciones2.php');

$link0 = validar("","","", 1);

require("correo/phpmail/class.phpmailer.php");
if($_POST['operacion']=="email" && $_POST['correo']!="" && $_POST['comunicado']!=""){
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
	$mail->Username = "soporte@xsitecompany.net";
	$mail->Password = "20001015006";
	$mail->From = "soporte@xsitecompany.net";
	$mail->FromName = "InfoTech";
	$mail->AddAddress($_POST['correo'], "Destinatario");
	$mail->WordWrap = 50;                                 // set word wrap to 50 characters

	//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
	

	$mail->IsHTML(true);                                  // set email format to HTML

	$mail->Subject = "Comunicado Importante";
	$mail->Body    = utf8_decode("Atencion Señor Destinatario <br/> El usuario del Sistema Infotech: $_SESSION[persona] le notifica lo siguiente:<br/>$_POST[comunicado]<br/>");
	$mail->AltBody    = utf8_decode("Atencion Señor Destinatario <br/> El usuario del Sistema Infotech: $_SESSION[persona] le notifica lo siguiente:<br/>$_POST[comunicado]<br/>");

}

      if(!$mail->Send()){
           echo escaparaJSON('({"success":false, "error":"'.$mail->ErrorInfo.'"})');
        }else{
           echo escaparaJSON('({"success":true})');
        }
?>	
