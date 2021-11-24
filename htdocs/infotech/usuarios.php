<?php 
/*
 * Created on 22/04/2007
 * ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');
@require('clases/claseNotificacion.php');

$link0=validar("","","", 48);

formularioactual();
	
switch($_POST[ejecut]):
case "Buscar":	
		$_SESSION['i']=0;

                 if($_POST['campobusqueda']=="usuario" && $_POST['criterio']!=""){
                 $nombreb="%%";
                 $apellidob="%%";
                 $usuariob="%".$_POST['criterio']."%";
                 }else if($_POST['campobusqueda']=="nombre" && $_POST['criterio']!=""){
                 $nombreb="%".$_POST['criterio']."%";
                 $apellidob="%%";
                 $usuariob="%%";
                 }else if($_POST['campobusqueda']=="apellidos" && $_POST['criterio']!=""){
                 $nombreb="%%";
                 $apellidob="%".$_POST['criterio']."%";
                 $usuariob="%%";
                 }else{
                 $nombreb="%%";
                 $apellidob="%%";
                 $usuariob="%%";
                 }

                $sql="SELECT nombre, apellidos, email, usuario, id, carnetinterno FROM `usuarios` LEFT JOIN `personalactivo` ON `usuarios`.`carnetpersonal`=`personalactivo`.`carnetinterno` WHERE `usuarios`.`usuario` LIKE '$usuariob' AND `personalactivo`.`nombre` LIKE '$nombreb' AND `personalactivo`.`apellidos` LIKE '$apellidob' AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'  AND `personalactivo`.`activo`=1 ORDER BY `usuario` ASC";
                $_SESSION[datos]=$sql;
                $result=@mysql_query($_SESSION[datos]);
                $_SESSION[numreg]=@mysql_num_rows($result);
                $_SESSION[clientemod]=@mysql_result($result, $_SESSION[i], "id");
break;
case ">>":	
	if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
	$result=@mysql_query($_SESSION[datos]);
        $_SESSION[clientemod]=@mysql_result($result, $_SESSION[i], "id");
break;
case "<<":	
	if($_SESSION[i]>0){$_SESSION[i]--;}
	$result=@mysql_query($_SESSION[datos]);
        $_SESSION[clientemod]=@mysql_result($result, $_SESSION[i], "id");
break;
case ">||":	
	$_SESSION[i]=$_SESSION[numreg]-1;
	$result=@mysql_query($_SESSION[datos]);
        $_SESSION[clientemod]=@mysql_result($result, $_SESSION[i], "id");
break;
case "||<":	
	$_SESSION[i]=0;
	$result=@mysql_query($_SESSION[datos]);
        $_SESSION[clientemod]=@mysql_result($result, $_SESSION[i], "id");
break;
case "Nuevo":
	$boton=1;
        $_SESSION[i]=$_SESSION[numreg];
	$result=@mysql_query($_SESSION[datos]);
        $_SESSION[clientemod]="";
break;
case "Ingresar";

if($_POST[usuario]!="" && $_POST[contrasena]!="" && $_POST[concontrasena]!="" && $_POST[persona]!="" && $_POST[contrasena]==$_POST[concontrasena]){
	try{
	//consulta de ingreso a usuario info
	$sql="INSERT INTO `relacional`.`usuarios` (`carnetpersonal`, `usuario`, `contrasena`) VALUES ('$_POST[persona]', '$_POST[usuario]', PASSWORD('$_POST[contrasena]'))";
	$consulta=@mysql_query($sql, $link0) or $error.=@mysql_error()." 86";
	
	//consultar el id del usuario infotech
	if(!$error){
	$sql1="SELECT * FROM `relacional`.`usuarios` WHERE `usuarios`.`usuario` LIKE '$_POST[usuario]';";
	$consulta1=@mysql_query($sql1, $link0) or $error.=@mysql_error()." 91";
	$idusuario=@mysql_result($consulta1,0,"id");
	
	
	//ingresar permisos basicos de inicio
	$sql2="INSERT INTO `relacional`.`permisos` (`idmodulo`,`idusuario`, `tipopermiso`) VALUES ('73','$idusuario','1');";
	$consulta2=@mysql_query($sql2, $link0) or $error.=@mysql_error()." 97";
	
	//ingresar permisos basicos en el sistema
        $_SESSION['arrpermisos']=array();
        $_SESSION['permisosdar']=0;
        $_SESSION['permisosrev']=0;

	//$link=conectarm();
	$sql3="GRANT SELECT ON relacional.parametros TO '$_POST[usuario]'@'localhost' IDENTIFIED BY '$_POST[contrasena]';";
	$consulta3=@mysql_query($sql3, $link0) or $error.=@mysql_error()." 109";
	
	$sql4="FLUSH PRIVILEGES";
	$consulta4=@mysql_query($sql4, $link0) or $error.=@mysql_error()." 112";

        //permiso por defecto para el inicio del sistema
        crearcons(73, 1, $idusuario);
        $error=ejecutarcons()." Usuarios - 105";

        //crear notificacion de nuevo usuario
        $notifica=new Notificacion();
        $notifica->crearNotificaciones(1, $idusuario, "Usuario Nuevo", "<a href='ayudainfotech.pdf' target='blank'>Bienvenido a Infotech</a>");
	}
	
	$mens=$error;
	
	} catch (Exception $e) {
    //echo $e->getMessage(), "\n";
	}
}
break;
case "Eliminar":
$sql10="SELECT * FROM `relacional`.`usuarios` WHERE `id` LIKE '$_SESSION[clientemod]'";
$regs0=@mysql_query($sql10, $link0) or $error=@mysql_error();
$us0=@mysql_result($regs0,0,"usuario");

$sql11="DELETE FROM `relacional`.`usuarios` WHERE `usuario`='$us0'";
$regs1=mysql_query($sql11, $link0) or $error=@mysql_error();

$link=conectarm();

$sql12="DELETE FROM `user` WHERE `user`='$us0'";
@mysql_query($sql12, $link) or $error=@mysql_error();

$sql13="FLUSH PRIVILEGES";
$consulta13=@mysql_query($sql13, $link) or $error=@mysql_error();
	
$mens=$error;

$result2=operaciones("usuarios","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
endswitch;

$mostra[1]="apellidos";
$mostra[2]="nombre";
$mostra[3]="cedula";
$otras="AND `personalactivo`.`activo`='1' AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("personalactivo","carnetinterno","%",$mostra,@mysql_result($result, $_SESSION['i'], "carnetinterno"),3,"apellidos",$otras);

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
		<form method="post" action="usuarios.php" name="usuarios" onsubmit="return validausuarios(boolvalidar);">
 		<table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
	 		<td align="right">*Usuario del sistema:  
      		</td>
     		<td align="left">
	 		 <input class="largo" size="31"
			  value="<?php if ($_SESSION['cedulaa']!=""){echo $_SESSION[cedulaa];}elseif (!$result){}else{ echo @mysql_result($result,$_SESSION['i'],"usuario");}?>" name="usuario">
			</td>
		</tr>
		<tr>
	 		<td align="right">*Persona Asociada</td>
     		<td align="left"><select name="persona" style="width:300px"><option></option>
	 		 <?php echo $cadena;?>
                    </select>
			</td>
		</tr>
  		<tr>
  			<td align="right">*Contrase&ntilde;a:</td>
     		<td align="left">
	 		<input class="medio" type="password"
			 value="" name="contrasena">
     	</tr>
     	
     	<tr>
  			<td align="right">*Confirmar Contrase&ntilde;a:</td>
     		<td align="left">
	 		<input class="medio" type="password"
			 value="" name="concontrasena">
      		</td>
    	 </tr>
    	 
 	  	 	<?php
			if($_SESSION[sucur]=="%"){
			$muestr2[1]="ciudad";
			$muestr2[saltar]="1";	
			$cadena34=selection("sucursales","id","%",$muestr2,@mysql_result($result,$_SESSION['i'],sucursal),1,"id","");	
			echo '
 	 		<tr>
  			<td align="right">*Sucursal: </td>
     		<td align="left">
	 		<select name="sucurs" class="largo1">'.$cadena34.'
	 		</select>
	 		</td><!-- Col 1 -->
     		</tr>
			';	
			}
     		?>
		</table>
		</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr"><td colspan="2" class="arriba">
     		Usuarios Infotech
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
		<td  colspan="2" align="center">Criterio <select
			name="campobusqueda" style="WIDTH: 115px" class="busqueda">
			<option value="usuario">Usuario</option>
			<option value="nombre">Nombres</option>
			<option value="apellidos">Apellidos</option>
		</select></td>
	</tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton!=1){echo "disabled";}?> name="ejecut"  onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Persona $p de $_SESSION[numreg]";} ?>
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
