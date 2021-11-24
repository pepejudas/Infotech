<?php
session_start();

@require('funciones2.php');
$link=validar("","","", 1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Captura de Imagen</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Joseph Huckaby">
	<!-- Date: 2008-03-15 -->
        <link	rel="stylesheet" href="estilo2.css" type="text/css"/>
        <link	rel="stylesheet" href="botones.css" type="text/css"/>
        <script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="ext/ext-all.js"></script>
</head>
<body>
	<table style="margin-top: 10px;margin-left: 10px"><tr><td valign=top>

	<!-- First, include the JPEGCam JavaScript Library -->
	<script type="text/javascript" src="capturaimg/webcam.js"></script>

	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'fotosguardas/subirfotopersona.php' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>

	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(640, 480) );
	</script>

	<!-- Some buttons for controlling things -->
	<br/><form>
            <div style="margin-top:10px">
		<input type=button value="Opciones" onClick="webcam.configure()">
		<input type=button value="Guardar" onClick="take_snapshot()">
                <input type=button value="Cerrar" onClick="window.close()">
            </div>
	</form>

	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );

		function take_snapshot() {
			// take snapshot and upload to server
			document.getElementById('upload_results').innerHTML = '<b>Guardando...</b>';
			webcam.snap();
		}

		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				document.getElementById('upload_results').innerHTML =
					'<h3>JPEG URL: ' + image_url + '</h3>' +
					'<img src="' + image_url + '" width="200">';

				// reset camera for another shot
				webcam.reset();
                                //ejecutar actualizacion del registro del paciente al que se le toma la foto
                                var imgurl=image_url.split("/");
                                
                                try{
                                Ext.Ajax.request({
                                  waitMsg: 'Por favor Espere...',
                                  url: 'actualizajax.php',
                                  params: {
                                     foto:imgurl[imgurl.length-1]
                                  },
                                  success: function(response){
                                      try{
                                        var respuesta = eval(response.responseText);
                                        if(respuesta.error){
                                        Ext.MessageBox.alert('error', respuesta.error);
                                        }
                                      }catch(err){
                                        Ext.MessageBox.alert('error','respuesta no es un objeto Json:' + response.responseText);
                                      }
                                  },
                                  failure: function(response){
                                     try{
                                      var respuesta = eval(response.responseText);
                                      Ext.MessageBox.alert('error','se ha presentado un error en el servidor:' + respuesta.error);
                                      }catch(err){
                                      Ext.MessageBox.alert('error','falla de comunicacion con el servidor:' + response.responseText);
                                      }
                                  }
                               });
                                }catch(er){
                                alert(er);
                                }
			}
			else alert("PHP Error: " + msg);
		}
	</script>

	</td><td width=50>&nbsp;</td><td valign=top>
		<div id="upload_results" style="background-color:#eee;"></div>
	</td></tr></table>
</body>
</html>
