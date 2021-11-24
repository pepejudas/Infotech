<?php
session_start();

@require('funciones2.php');

$link=validar("","","", 1);

switch($_POST['ejecut']){
	case "Nuevo":
	$boton=1;
	$campos0=camposEd(0);
	$campos=$campos0["divcampos"];
	$informehtml=$campos0["informehtml"];
	$varsjs=$campos0["varsjs"];
	break;
	case "Ingresar":
	if(isset($_POST['htmlinforme']) && isset($_POST['tabla']) && $_POST['nombreinforme']!=""){
	$info=addslashes($_POST['htmlinforme']);
	$sql="INSERT INTO `informes` (`nombre`, `idmodulo`, `sucursal`, `htmlinforme`, `tipo`) VALUES ('$_POST[nombreinforme]', '$_POST[tabla]', '$_SESSION[sucur]', '$info', '$_POST[tipoinforme]');";
	$cons=@mysql_query($sql) or $error=@mysql_error();
	if(!$error){
	$matrizCampos = verificarCampos($_POST['htmlinforme'], @mysql_insert_id());
	}
	}
	break;
	case "Actualizar":
	if(isset($_POST['htmlinforme']) && isset($_POST['tabla']) && $_POST['nombreinforme']!=""){
	$info=addslashes($_POST['htmlinforme']);		
	$sql0="UPDATE `informes` SET `nombre`='$_POST[nombreinforme]', `idmodulo`='$_POST[tabla]', `sucursal`='$_SESSION[sucur]', `htmlinforme`='$info' WHERE `informes`.`id`='$_SESSION[idinforme]';";
	$cons=@mysql_query($sql0);
	
	$campos0=camposEd($_SESSION['idinforme']);
	$campos=$campos0["divcampos"];
	$varsjs=$campos0["varsjs"];
	
	//$_SESSION['idinforme']=@mysql_result($cons, 0, "id");
	
	if(!$error){
	$matrizCampos = verificarCampos($_POST['htmlinforme'], $_SESSION['idinforme']);
	}
	}
	break;	
	case "Buscar":
	if(isset($_POST['informe'])){
	$sql="SELECT id, htmlinforme, nombre FROM `informes` WHERE `informes`.`id`='$_POST[informe]'";
	$cons=@mysql_query($sql);
	
	$campos0=camposEd($_SESSION['idinforme']);
	$campos=$campos0["divcampos"];
	$informehtml=$campos0["informehtml"];
	$varsjs=$campos0["varsjs"];
	$_SESSION['idinforme']=@mysql_result($cons, 0, "id");
	}
	break;	
	case "eliminar":
	$sql1="DELETE  FROM `informes` WHERE `informes`.`id`='$_SESSION[idinforme]'";
	$resu=@mysql_query($sql1);
	$_SESSION[i]="";
	break;
}

$muestr[1]="nombre";
$otrasent="AND modulos.permitereporte = 1";
$cadena="<select name=\"tabla\" style=\"width:170px\">".selection("modulos","id","%",$muestr,$_POST['tabla'],1,"nombre",$otrasent)."</select>";

$otrasent2="AND informes.idmodulo = '$_POST[tabla]'";
$cadena2="<select name=\"informe\" style=\"width:170px\">".selection("informes","id","%",$muestr,$_POST['informe'],1,"nombre",$otrasent2)."</select>";

$r=@require('version.php');
caracteresiso();
$colcuerpo="#FAFAFA";
$coltabla="#67BFFD";
?>
	<link href="editor/_samples/sample.css" rel="stylesheet" type="text/css" />
	<link	rel="stylesheet" href="estilo2.css" type="text/css">
	<link	rel="stylesheet" href="botones.css" type="text/css">

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

        <script type="text/javascript" src="editor/ckeditor.js"></script>
	<script src="editor/_samples/sample.js" type="text/javascript"></script>
	<script type="text/javascript"><?php echo $varsjs;?></script>
	<script type="text/javascript" src="editor/inicio.js"></script>
        <!--
	<script type="text/javascript" src="scripts/jquery.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="scripts/sexyalertbox.v1.2.jquery.js"></script>
	<script	language="javascript" type="text/javascript" src="scripts/validacion.js"></script>
	<link href="editor/sample.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" media="all" href="estilos/sexyalertbox.css"/>
	<link	rel="stylesheet" href="estilo2.css" type="text/css">
	<link	rel="stylesheet" href="botones.css" type="text/css">
        -->
</head>
<body>
	<!-- This <div> holds alert messages to be display in the sample page. -->
	<div id="alerts">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
        <form action="editordocs.php" method="post" onsubmit="return validarInforme(boolvalidar);">
	<div style="margin-left:300px">
	
		<p>
			<?php 
			if(isset($campos)){echo $campos;}
			?>
                    <textarea id="editor1" name="htmlinforme">
			<?php 
                                          if(isset($informehtml)){echo $informehtml;}
                                          ?>
			</textarea>
			<script type="text/javascript">
			//<![CDATA[
				// Replace the <textarea id="editor1"> with an CKEditor instance.
				var editor = CKEDITOR.replace( 'editor1',{
                                    skin : 'office2003',
				    uiColor : '#9AB8F3',
				    language : 'es',
				    width:'85%',
				    height:'750px'
					    
				});
			//]]>
			</script>
			
		</p>
	</div>
<div id="controlex">
<table class="control">
	<tr>
        <td colspan="2" class="arriba">Editor de Documentos
        </td>
	</tr>
	<tr height="10px" valign="top">
		<td valign="middle" colspan="2" align="center"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><?php echo $cadena;?></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><?php echo $cadena2;?></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input type="submit" class="botoactu"
			value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;"
			onkeydown="boolvalidar=true;" /><input type="submit" class="botoelimina" value="eliminar" name="ejecut"/></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input type="submit"
			class="botonuev" value="Nuevo" name="ejecut"><input type="submit"
			class="botoing" value="Ingresar"
			<?php if($boton==0){echo "disabled";}?> name="ejecut"
			onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center">
		</td>
	</tr>
</table>
<div id="divMenu" class="divMenu"></div>
<?php require('saludos.php');?>
</div>
</form>
<script type="text/javascript">
	function mostrarTabla(tabla0){
	try{	
	if(tabla0==""){tabla0="abonos";}
			
	var tabla=this[tabla0];
	var sel=document.getElementById("campos");
	
    for(ini=0;ini<tabla.length;ini++){
        sel.options[ini]=new Option(tabla[ini]);   
    };
	}catch(err){
		}
	}
	
	function agregarCampo(){
	try{	
	//var editor = CKEDITOR.replace("editor_office2003");	
	var sel=document.getElementById("campos");
	var campo="~"+sel.value+"~";
	InsertHTML(campo);
	}catch(err){
	alert(err);	
	}
	}
	mostrarTabla("");
	</script>	
</body>
</html>
