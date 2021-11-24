<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//must set the contenttype of response as text/xml
/*
__EVENTTARGET:
__EVENTARGUMENT:
__VIEWSTATE:/wEPDwULLTEyNDY1MzQ5MzRkZD5D5HkEbXaB44mo9DpKPdWA6SHD
tipoid:1
idnum:80222593
Button1:Generar consulta
__EVENTVALIDATION:/wEWCQKZpdm5AgKQubWRBwKcufmSBwKdufmSBwKeufmSBwKfufmSBwKYufmSBwK2lqGpAQKM54rGBuw6za03FS99eFA9fvASql9bB5Jc
 * 
 */
try{
include('/htmlParser/simple_html_dom.php');

/* STEP 1. let’s create a cookie file */
$ckfile = tempnam ("/tmp", "CURLCOOKIE");
/* STEP 2. visit the homepage to set the cookie properly */
$ch = curl_init ("https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx/");
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);

$html = file_get_html('https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx');

// Find all article blocks
foreach($html->find('input') as $element){
       if($element->id=="__VIEWSTATE"){
           $nombreparam1valor=$element->value;
       }
       if($element->id=="__EVENTVALIDATION"){
           $nombreparam2valor=$element->value;
       }
}

/* STEP 3. visit cookiepage.php */
$ch = curl_init ("https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx");

$nombreparam1 = "__VIEWSTATE";
$nombreparam2 = "__EVENTVALIDATION";
$parametrosaenv="$nombreparam1=".urlencode($nombreparam1valor)."&$nombreparam2=".urlencode($nombreparam2valor)."&tipoid=$_POST[tipoid]&idnum=$_POST[idnum]&".
"Button1=Generar consulta&__EVENTTARGET=&__EVENTARGUMENT=";
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $parametrosaenv);
//para entrar sitios ssl
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
//headers
curl_setopt($ch,CURLOPT_HTTPHEADER,array('POST /cwebciddno/Consulta.aspx HTTP/1.1', 'Host: siri.procuraduria.gov.co','Connection: keep-alive','Connection: keep-alive','Connection: keep-alive'
 ,'Content-Length: 270','Cache-Control: max-age=0','Origin: https://siri.procuraduria.gov.co','User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2'
 ,'Content-Type: application/x-www-form-urlencoded','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
 ,'Referer: https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx','Accept-Encoding: gzip,deflate,sdch'
 ,'Accept-Language: es-ES,es;q=0.8', 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3' ));
//cookies
curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);

/* here you can do whatever you want with $output */

echo "{success:true, parametros:'$parametrosaenv', respuesta:'$output', cookie:'$ckfile'}";
}catch(Exception $er){
echo $er;
}

function curlRetrieve($url, $ssl = TRUE, $headersOnly = FALSE) {

$curl_handle=curl_init();

curl_setopt($curl_handle,CURLOPT_URL, $url);
curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,15);
curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl_handle,CURLOPT_FOLLOWLOCATION,1);

// for SSL

if ($ssl) {
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
}

// header opts
if ($headersOnly) {
curl_setopt($curl_handle, CURLOPT_HEADER, 1);
curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'HEAD');
}

$buffer = curl_exec($curl_handle);
// uncomment out for debugging
/*
if ($error = curl_error($curl_handle)) {
echo "Error: $error<br />\n";
}
*/
curl_close($curl_handle);

return $buffer;
}
 
?>

<iframe src="https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx" name="SubHtml" width="400" height="500" scrolling="auto" frameborder="1">
      <p>Texto alternativo para navegadores que no aceptan iframes.</p>
</iframe>
