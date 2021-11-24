<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 47);

formularioactual();
 
switch($_POST[ejecut]):
case "Buscar":
        $_SESSION[inicio]=0;
        $_SESSION[crito]=$_POST[criterio];
break;
case ">>":
    $_SESSION[inicio]+=100;
break;
case "<<":
    $_SESSION[inicio]-=100;
break;
case "||<":
    $_SESSION[inicio]=0;
break;
case ">||":
    //$_SESSION[inicio]=0;
break;
endswitch;

$criterio="'%".$_SESSION[crito]."%'";
$sqql = "SELECT * FROM registrodemodificaciones WHERE registrodemodificaciones.sucursal LIKE '$_SESSION[sucur]'
AND (fecha LIKE $criterio OR cambio LIKE $criterio OR hechopor LIKE $criterio OR cedulamodificada LIKE $criterio) ORDER BY id ASC LIMIT $_SESSION[inicio], 100";
	$result= mysql_query($sqql);
        $numfilas=mysql_num_rows($result);
        
	while($vector=@mysql_fetch_array($result)){
			$chorrero='<tr><td align="center">' .$vector["fecha"].'</td><td align="center">' .$vector["cedulamodificada"].'</td><td align="center">'.$vector["hechopor"]."</td><tr><td><hr/></td></tr><tr>" . $chorrero;
	}
$r=@require('version.php');
caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#AACD82";
?>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->
</head>
<body>
		<form method="post" action="<?php echo $PHP_SELF?>">
 		<table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
	  		<td align="center" width="15%">
	  		Fecha de modificacion
	  		</td>
	 		<td align="center" width="70%">Registro Modificado:
			</td>
	 		<td width="15%" valign="top" align="center">
	 		Usuario que lo realiz&oacute;:
			</td>
     		</tr>
	    	<?php
		echo $chorrero;
		?>
		</table>
		</td></tr></table>
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Registro de Actividades
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"><input type="text" name="criterio"
			style="width:110px;margin-left:5px" class="busqueda" /></td>
                </tr>
			<tr height="10px">
		<td colspan="2" align="center"><input type="submit" class="botopri"
			value="||<" name="ejecut"> <input type="submit" class="botoant"
			value="<<" name="ejecut"> <input type="submit" class="botosig"
			value=">>" name="ejecut"> <input type="submit" class="botoult"
			value=">||" name="ejecut"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Persona $p de $_SESSION[numreg]";} ?>
		</td>
	</tr>
			</table>
<div id="divMenu" class="divMenu"></div>
<?php require('saludos.php');?>
</div>
</form>
<?php
@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
echo $escribir;
?>
</body>
</html>
