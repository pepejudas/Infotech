<?php 
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 55);

function usuap($id){
	
	$sqlup="SELECT * FROM registro.gerentes WHERE registro.gerentes.sucursal LIKE $id ORDER BY registro.gerentes.id ASC LIMIT 1";
	$resultu=@mysql_query($sqlup) or $mens=@mysql_error();
	
	return $resultu;
}

formularioactual();

switch($_POST[ejecut]):
case "Buscar":

		$_SESSION['i']="0";
		$datos[campobusqueda]="nombre";
		$datos[crito]="$_POST[criterio]";
		$datos[opcion]="1";
		$datos[claveprinc]="id";
		$datos[otraconsulta]=" AND id LIKE '$_SESSION[sucur]'";
			
		$result2=operaciones("sucursales","buscar",$datos);
		$result=$result2[datos];
		
		$id=@mysql_result($result,$_SESSION['i'],"id");
		
		$resultu=usuap($id);
		
break;
case ">>":
if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
		$result2=operaciones("sucursales","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		$id=@mysql_result($result,$_SESSION['i'],"id");
		$resultu=usuap($id);
break;
case "<<":
if($_SESSION[i]>0){$_SESSION[i]--;}
		$result2=operaciones("sucursales","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		$id=@mysql_result($result,$_SESSION['i'],"id");
		$resultu=usuap($id);
break;
case ">||":
$_SESSION[i]=$_SESSION[numreg]-1;
		$result2=operaciones("sucursales","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		$id=@mysql_result($result,$_SESSION['i'],"id");
		$resultu=usuap($id);
break;
case "||<":
$_SESSION['i']=0;
		$result2=operaciones("sucursales","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		$id=@mysql_result($result,$_SESSION['i'],"id");
		$resultu=usuap($id);
break;
case "Nuevo":
$_SESSION[i]=$_SESSION[numreg];
$boton=1;
break;
case "Ingresar":
if($_POST[nombre]!="" and $_POST[ciudad]!="" and $_POST[usuario]!=""){

$sql2="INSERT INTO `sucursales` (nombre, ciudad, responsable) VALUES ('$_POST[nombre]', '$_POST[ciudad]', '$_POST[usuario]')";
$result0=@mysql_query($sql2) or $mens.=@mysql_error();

$sql3="SELECT id FROM `sucursales` WHERE sucursales.nombre='$_POST[nombre]' AND sucursales.ciudad='$_POST[ciudad]'";
$result1=@mysql_query($sql3) or $mens.=@mysql_error();

$suc=@mysql_result($result1,0,"id");

$sql4="UPDATE `usuarios` SET `sucursal`='$suc' WHERE `usuarios`.`usuario` LIKE '$_POST[usuario]'";

}else{
$mens.="Atencion debe ingresar los campos requeridos \nmarcados con asterisco *";
$boton=1;
}
break;
case "Eliminar":
$sql11 ="DELETE FROM `sucursales` WHERE `sucursales` . `id` LIKE '$_SESSION[clientemod]' LIMIT 1";
//echo $sql11;
$resu=mysql_query($sql11) or $mens=@mysql_error();
$_SESSION[i]=$_SESSION[numreg]-1;
$result="";
break;
endswitch;

$mostra[1]="usuario";
$mostra[2]="nombres";
$mostra[3]="apellidos";
$cadena=selection("usuarios","usuario","%",$mostra,@mysql_result($result,$_SESSION['i'],"responsable"),2,"id",$otras);

$r=@require('version.php');
caracteresiso();
		
$colcuerpo="#FAFAFA";
$coltabla="#11bfbf";
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
		<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
		<form method="post" action="<?php echo $PHP_SELF?>"  name="sucursales" onsubmit="return validasucursales(boolvalidar);">
                <table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
                    <td align="right">*Nombre Sucursal:
      		</td>
     		<td align="left">
	 		 <input class="largo" tabindex="2" size="31"
			  value="<?php if (!$result){}else{ echo @mysql_result($result,$_SESSION['i'],"nombre");}?>" name="nombre">
			</td>
		</tr>
			
  		<tr>
  			<td align="right">*Ciudad:</td>
     		<td align="left">
	 		<input class="medio" tabindex="3"
			 value="<?php if (!$result){}else{ echo @mysql_result($result,$_SESSION['i'],"ciudad");}?>" name="ciudad">
     	</tr>
     	
    	<tr>
  			<td align="right">*Usuario Primario:</td>
     		<td align="left">
	 		<select name="usuario">
	 		<option value=""></option>
	 		<?php echo $cadena;?>
	 		</select>
      		</td>
    	 </tr>
		</table>
		</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Sucursales
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"><input type="text" name="criterio"
			style="width:110px;margin-left:5px" class="busqueda" /></td>
                </tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoelimina" value="Eliminar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton!=1){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Sucursal $p de $_SESSION[numreg]";} ?>
			</td></tr>
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
