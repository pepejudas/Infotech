<?php 
session_start();

@require('funciones2.php');

validar("","","", 58);

formularioactual();

$r=@require('version.php');
caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9AFF83";

?>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

<!-- GC -->
<!-- LIBS -->
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->

<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />

<!-- Common Styles for the examples -->
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<style type="text/css">
p { width:300px; }
</style>

<!-- fin librerias extjs -->
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>

		<form method="post" action="backup0.php" name="formbackup" id="formbackup">
		<br>
 		<center>
                <table align="center" width="55%" class="tablaprinc"><tr><td>
		<table>
                <tr>
                <td align="right" width="25%">
                Ruta MysqlDump:</td>
     		<td align="left" width="30%">
     		<input class="largo1" tabindex="2" value="" name="rutamy" type="file">
   		</td><!-- Col 1 -->
 		</tr>
                
                <tr>
                <td align="right" width="25%">
                Usuario:</td>
                <td align="left" width="30%">
                <input class="largo1" tabindex="2" value="" name="usuario" id="usuario">
                </td><!-- Col 1 -->
 		</tr>
                <tr>
                <td align="right" width="25%">Contrase&ntilde;a:</td>
     		<td align="left" width="30%">
                <input class="largo1" tabindex="2" type="password" value="" name="pass" id="pass">
                </td><!-- Col 1 -->
 		</tr>
                <tr>
	 	<td align="right" width="25%">Estructura:</td>
     		<td align="left" width="30%">
     		<input class="largo1" name="estructura" type="checkbox" checked="checked">
                </td><!-- Col 1 -->
 		</tr>
                <tr>
                <td align="right" width="25%">Datos:</td>
     		<td align="left" width="30%">
     		<input class="largo1" name="datos" type="checkbox" checked="checked">
                </td><!-- Col 1 -->
 		</tr>
 		<tr>
     		<td align="left" class="arriba" colspan="2">
      		<input type="submit" name="boton" value="Exportar" id="exportar">
                </td><!-- Col 1 -->
                </tr>
		<tr>
                <td align="right" width="25%">Ruta Archivo:</td>
     		<td align="left" width="30%">
     		<input class="largo1" tabindex="2" value="" name="rutaarchivo" type="file">
                </td><!-- Col 1 -->
 		</tr>
                <tr>
                <td align="right" width="25%">*Usuario:</td>
     		<td align="left" width="30%">
     		<input class="largo1" tabindex="2" value="" name="usuariog">
                </td><!-- Col 1 -->
 		</tr>
                <tr>
                <td align="right" width="25%">*Contrase&ntilde;a:</td>
     		<td align="left" width="30%">
                <input class="largo1" tabindex="2" type="password" value="" name="passg">
                </td><!-- Col 1 -->
 		</tr>
                <tr>
                <td align="right" width="25%">Tipo:</td>
     		<td align="left" width="30%">
                <select name="tipo">
                    <option>Estructura</option>
                    <option>Datos</option>
                </select>
                </td><!-- Col 1 -->
 		</tr>
 		<tr>
     		<td align="left" class="arriba" colspan="2">
      		<input type="submit" name="boton" value="Importar">
                </td><!-- Col 1 -->
                </tr>
 		</table>
                </td></tr>
                </table></center>
                </form>
    
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Backup Infotech
     		</td>
     		</tr>
     		<tr height="20px" valign="top"><td valign="middle">
 			</td><td valign="middle">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			</td></tr>
			<tr height="20px"><td valign="middle" colspan="2" align="center">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			</td></tr>
			<tr height="30px"><td colspan="2" align="center">
			</td></tr>
			</table>
                        <div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
     		</div>
<script>
try{
    document.getElementById("formbackup").onsubmit = function(){
    var usuario=document.getElementById("usuario");
    var pass=document.getElementById("pass");

    if(usuario.value==""){
    mensajeini('Debe Ingresar el usuario');
    usuario.focus();
    return false;
    }
    if(pass.value==""){
    mensajeini('No ha Ingresado la contrase&ntilde;a');
    pass.focus();
    return false;
    }
    }
}catch(er){
    mensajeini(er);
}
</script>
</body>
</html>