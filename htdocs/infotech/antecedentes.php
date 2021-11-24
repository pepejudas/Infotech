<?php
/*
 * Created on 15/10/2007
 *
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');
@require('clases/claseNotificacion.php');

validar("","","", 74);

$colcuerpo="#FAFAFA";
$coltabla="#9AFF83";

?>
<link rel="stylesheet" href="estilo2.css" type="text/css"/>
<link rel="stylesheet" href="botones.css" type="text/css"/>

<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

<!-- GC -->
<!-- LIBS -->
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->

<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/antecedentes.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />

<!-- Common Styles for the examples -->
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<style type="text/css">
p { width:300px; }
</style>

<!-- fin librerias extjs -->
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<script type="text/javascript">
function mensajeini(msginicio){
        Ext.Msg.alert("Atencion", "<div style=\"float:right\"><img src=\"imagenes/dialog-warning.png\"></div><div>"+msginicio+"</div>");
}
</script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>

                <div style="width:800px; height:650px; margin:auto">
                <iframe class="antecedentes" name="ifr" id="ifr" src="https://siri.procuraduria.gov.co/cwebciddno/Consulta.aspx" frameborder="0"></iframe>
                </div>
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Verificaci&oacute;n de Antecedentes
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
</body>
</html>