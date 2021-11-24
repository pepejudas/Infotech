<?php 
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 11);

formularioactual();

 	switch ($_POST[ejecut]):
	case "Buscar":
		$_SESSION[datos]="";	
		$_SESSION[i]=0;	
		
		$datos[campobusqueda]=$_POST[campobusqueda];
		$datos[crito]=$_POST[criterio];
		$datos[opcion]=$_POST[opt];
		$datos[claveprinc]="id";
		$result2=operaciones("proveedores","buscar",$datos);
		$result=$result2[datos];
		
		break;
	case ">>":
		
		if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
		$result2=operaciones("proveedores","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
				break;
	case "<<":
		
		if($_SESSION[i]>0){$_SESSION[i]--;}
		$result2=operaciones("proveedores","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
				break;
	case "||<":
		
		$_SESSION[i]=0;
		$result2=operaciones("proveedores","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
				break;
	case ">||":	
		
		$_SESSION[i]=$_SESSION[numreg]-1;
		$result2=operaciones("proveedores","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
				break;
	break;
	
	case "Actualizar":
		if($_SESSION[sucur]=="%"){$suckur=$_POST[sucurs];}else{$suckur=$_SESSION[sucur];}
		
		try{

		$mens=armarEjecutarSentencia("proveedores", $_POST, "update", $_SESSION);

		if ($mens==""){
		$reg="INSERT INTO `registrodemodificaciones` (`id`, `fecha`, `cambio`, `hechopor`, `cedulamodificada`, `tablamod`, `sucursal`) VALUES (NULL, NOW(), 'actualizarcliente', '$_SESSION[persona]', '$_POST[nombreprov]', '7', '$_SESSION[sucur]')";
		$consulta = @mysql_query($reg);
		}
		}catch(Exception $error){
		$escribir="<script>alert('$error');</script>";	
		}
		
		$result2=operaciones("proveedores","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		
	break;
	
	case "Ingresar":

		if($_SESSION[sucur]=="%"){$suckur=$_POST[sucurs];}else{$suckur=$_SESSION[sucur];}
		
		try{
		if($_POST[nombreprov]!="" && $_POST[contacto]!="" && $_POST[telefono1]!=""){

                if(!hayDuplicado("proveedores", "nombreprov", $_POST[nombreprov])){//no hay duplicados de cedula
                    //agregar sucursal
                    if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}

                    $mens.=armarEjecutarSentencia("proveedores", $_POST, "insert", $_SESSION);
                    }else{
                    $mens.="Existe un registro duplicado";
                    }

                $sql3="INSERT INTO `registrodemodificaciones` (`id`, `fecha`, `cambio`, `hechopor`, `cedulamodificada`, `tablamod`, `sucursal`) VALUES (NULL, NOW(), 'ingresarproveedor', '$_SESSION[persona]', '$_POST[nombreprov]', '7', '$_SESSION[sucur]')";
		$ref=mysql_query($sql3);																		
		}else{
		$escribir="<script>alert('Debe ingresar los campos requeridos')</script>";	
		}
		}catch(Exception $error){
		$escribir="<script>alert('$error')</script>";	
		}
		
	break;

	case "Nuevo":
		$_SESSION[i]=$_SESSION[numreg];
		$boton=1;
		break;
		
	endswitch;

        $muestrdeptos[1]="NOMBRE";
        $cadenadepartamentos=selection("departamentospaises","ID_DPTO","%",$muestrdeptos,@mysql_result($result,$_SESSION['i'],"codepto"),1,"NOMBRE","");

        $cadenaciudades=selection("ciudades","ID_CIUDAD","%",$muestrdeptos,@mysql_result($result,$_SESSION['i'],"codciudad"),1,"NOMBRE"," AND ciudades.ID_DPTO='".@mysql_result($result,$_SESSION['i'],"codepto")."'");

	
	$r=@require('version.php');
	caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9AFF83";
 
?>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script	language="javascript" type="text/javascript" src="scripts/cargamunicipios.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->

</head>
<body>
<form method="post" action="<?php echo $PHP_SELF?>" name="proveedores" onsubmit="return validaproveedor(boolvalidar);">
		<table class="tablaprinc"><tr><td>
		<table >
		<tr>
	 	<td align="right" width="40%">*Nombre Proveedor:<input class="largo"
	 		value="<?php
			 if ($_SESSION['nombreprova']!=""){
			  	echo $_SESSION[nombreprova];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombreprov");}
			 		?>" name="nombreprov"></td>
     		<!-- Col 1 -->
	 		<td width="30%" valign="top" rowspan="4" align="right">
	 		<center>Observaciones<br><textarea name="observacionesprov" id="sqlquery" cols="16" rows="4" dir="ltr"><?php if ($_SESSION['observacionrega']!=""){echo $_SESSION[observacionrega];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionesprov");}?></textarea></center>	
		  	</td>
     		</tr>
     		
     		<tr><!-- Row 3 -->
  			<td align="right">*Contacto:<input class="largo" 
			 value="<?php
			 if ($_SESSION['contactoa']!=""){
			  	echo $_SESSION[contactoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"contacto");}
			 		?>" name="contacto">
      		</td>
      		</tr>
      		
			<tr>
			<td align="right">Nit:<input class="largo" name="nit"
			 value="<?php
		 if ($_SESSION['nita']!=""){
			  	echo $_SESSION[nita];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nit");} ?>"></td>
     		</tr>
     		<tr><!-- Row 3 -->
  			<td align="right">*Telefono 1:<input class="largo" 
			 value="<?php
			 if ($_SESSION['telefono1a']!=""){
			  	echo $_SESSION[telefono1a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono1");}
			 		?>" name="telefono1">
      		</td>
      		<tr><!-- Row 3 -->
  			<td align="right">Telefono 2:<input class="largo" 
			 value="<?php
			 if ($_SESSION['telefono2a']!=""){
			  	echo $_SESSION[telefono2a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono2");}
			 		?>" name="telefono2">
      		</td>
    	 	</tr>
    	 	
    	 	<tr><!-- Row 3 -->
  			<td align="right">Telefono 3:<input class="largo" 
			 value="<?php
			 if ($_SESSION['telefono3a']!=""){
			  	echo $_SESSION[telefono3a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono3");}
			 		?>" name="telefono3">
      		</td>
      		</tr>
                <tr><!-- Row 3 -->
  			<td align="right">Fax:<input class="largo"
			 value="<?php
			 if ($_SESSION['fax3a']!=""){
			  	echo $_SESSION[fax3a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fax");}
			 		?>" name="fax">
      		</td>
      		</tr>
      		
      		<tr><!-- Row 3 -->
  			<td align="right">Direcci&oacute;n:<input class="largo" 
			 value="<?php
			 if ($_SESSION['direcciona']!=""){
			  	echo $_SESSION[direcciona];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"direccion");}
			 		?>" name="direccion">
      		</td>
      		</tr>
      		<tr>
				<!-- Row 6 -->
				<td align="right">Departamento:
				<select class="largo1" name="codepto" id="coddeptonacim">
                                <option value=""></option>
                                <?php echo $cadenadepartamentos;?>
				</select></td>
			</tr>
			<tr>
				<!-- Row 6 -->
				<td align="right">Ciudad:<select name="codciudad" class="largo1" id="codciudadnacim">
					<option value=""></option>
					<?php echo $cadenaciudades; ?>
				</select></td>
				<!-- Col 1 -->
			</tr>
      		<tr><!-- Row 3 -->
  			<td align="right">Email:<input class="largo" 
			 value="<?php
			 if ($_SESSION['emaila']!=""){
			  	echo $_SESSION[emaila];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"email");}
			 		?>" name="email">
      		</td>
      		</tr>
      		
  			</table>
  			
  			</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Proveedores
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
			<input checked name="opt" type="radio" value="1">cualquier
			<input type="radio" name="opt" value="2">mismo
			</td></tr>
			<tr height="10px"><td valign="middle" colspan="2" align="center">
			Criterio
  			<select name="campobusqueda" style="WIDTH:115px" class="busqueda">
  			<option value="nombreprov">Nombre Proveedor</option>
  	 		<option value="contacto">Contacto</option>
  	 		<option value="nit">Nit</option>
  	 		<option value="telefono1">Telefono</option>
  	 		<option value="direccion">Direccion</option>
  	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut"/>
			<input type="submit" class="botoant" value="<<" name="ejecut"/>
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Proveedor $p de $_SESSION[numreg]";} ?>
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
