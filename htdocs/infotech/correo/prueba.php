<?php
/*
 * Created on 12/03/2009
 *
 * Desarrollado por Xsite Company Ltda
 * Ing. Ferley Ardila Caicedo
 * 
 */

require("phpmail/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->Username = "soporte@xsitecompany.net";
$mail->Password = "20001015006";


$mail->From = "soporte@xsitecompany.net";
$mail->FromName = "Soporte Xsite Company";
$mail->AddAddress("necronslaught666@hotmail.com", "Ferley");

//$mail->AddAddress("ellen@example.com");                  // name is optional
//$mail->AddReplyTo("info@example.com", "Information");


$mail->WordWrap = 50;                                 // set word wrap to 50 characters

/*
$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
*/

$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "Mensaje de prueba de soporte Xsite";
$mail->Body    = "Cuerpo del mensaje Html <b>in bold!</b>";
$mail->AltBody = "Cuerpo del mensaje para clientes sin html";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "el mensaje fue enviado";
//echo phpinfo();

?>
