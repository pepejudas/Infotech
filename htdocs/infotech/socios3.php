<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 53);
	
formularioactual();
	
switch($_POST[ejecut]):

	case "Buscar":
		
		$_SESSION['i']=0;
		
		$datos[campobusqueda]=$_POST[campobusqueda];
		$datos[crito]=$_POST[criterio];
		$datos[opcion]=$_POST[opt];
		$datos[claveprinc]="id";
		$datos[otraconsulta]="AND habilitadoinfotech = 1";
			
		$result2=operaciones("socios","buscar",$datos);
		$result=$result2[datos];
		break;
		
		case "Ingresar":
                if($_POST[cedula]!="inserte" and $_POST[nombres]!="inserte" and $_POST[apellidos]!="inserte" and $_POST[cedula]!="" and $_POST[nombres]!="" and $_POST[apellidos]!=""){
                  
                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $mens.=armarEjecutarSentencia("socios", $_POST, "insert", $_SESSION);
                
		}else{
		echo '<script language="JavaScript" type="text/JavaScript"> alert("Atencion debe ingresar todos los campos requeridos \nmarcados con asterisco *");</script>';	
		}	
		break;

		case "Eliminar":
		//$sql = "DELETE FROM 'socios' WHERE cedula = $_SESSION[cedulaborra] LIMIT 1";
		$sql ="DELETE FROM `socios` WHERE `socios` . `cedula` LIKE $_SESSION[cedulamod] LIMIT 1";
		$result = mysql_query($sql);
		$result ="";
		break;
		
		
		case "Actualizar":
			
		if($_POST[cedula]!="inserte" and $_POST[nombres]!="inserte" and $_POST[apellidos]!="inserte" and $_POST[cedula]!="" and $_POST[nombres]!="" and $_POST[apellidos]!=""){	
                 
                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $mens.=armarEjecutarSentencia("socios", $_POST, "update", $_SESSION);

                /*
                $sql87="UPDATE `socios` SET `cedula` = '$_POST[cedula]' ,`nombres` = '$_POST[nombres]' ,`apellidos` = '$_POST[apellidos]' ,`sexo` = '$_POST[sexo]' ,`direccion` = '$_POST[direccion]' ,`telefono` = '$_POST[telefono]' ,`celular` = '$_POST[celular]' ,`ciudadresidencia` = '$_POST[ciudadresidencia]' ,`deptoresidencia` = '$depto' ,`rangomilitar` = '$_POST[rangomilitar]' ,`svysp` = '$_POST[svysp]',`profesion` = '$_POST[profesion]' WHERE `socios`. `cedula`= '$_SESSION[clientemod]'";
		$consul=mysql_query($sql87);
                 * 
                 */
		}else{
		echo '<script language="JavaScript" type="text/JavaScript"> alert("Atencion debe ingresar todos los campos requeridos \nmarcados con asterisco *");</script>';	
		}
		
		$result2=operaciones("socios","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
				
		break;
	
		case "Nuevo":
		
		$_SESSION[i]=$_SESSION[numreg];
		$boton=1;
		break;

		case ">>":
		if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}	
		
		$result2=operaciones("socios","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
	break;
		case "<<":
		
		if($_SESSION[i]>0){$_SESSION[i]--;}
		
		$result2=operaciones("socios","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	break;
	
	case "||<":
		
		$_SESSION[i]=0;
	
		$result2=operaciones("socios","buscar",$_SESSION[datos]);
		$result=$result2[datos];	
	break;
	
	case ">||":
		
		$_SESSION[i]=$_SESSION[numreg]-1;
		
		$result2=operaciones("socios","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		
	break;
	
endswitch;
		$r=@require('version.php');
		caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#ABABAB";

//echo "<center>numreg: ".$_SESSION[numreg]."</center>";
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
<form method="post" action="<?php echo $PHP_SELF?>" name="socios"  onsubmit="return validasocios(boolvalidar);">
 		<table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
	 		<td align="right">*Cedula de Ciudadania:  
      		</td>
     		<td align="left">
      		<input class="medio" tabindex="2" 
			  value="<?php
			  if ($_SESSION['cedulaa']!=""){
			  	echo $_SESSION[cedulaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cedula");}
			?>" name="cedula">
			</td>
		</tr>
		
  		<tr>
  			<td align="right">*Nombres:</td>
     		<td align="left">
	 		<input class="extralargo" tabindex="3"
			 value="<?php
			 if ($_SESSION['nombresa']!=""){
			  	echo $_SESSION[nombresa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombres");}
			 		?>" name="nombres">
   		</tr>
   		
   		<tr>
  			<td align="right">*Apellidos:</td>
     		<td align="left">
	 		<input class="extralargo" tabindex="4" name="apellidos"
			 value="<?php
		 if ($_SESSION['apellidosa']!=""){
			  	echo $_SESSION[apellidosa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"apellidos");} ?>">
	 		</td>
   	 	</tr>
   	 	
 		<tr>
  			<td align="right">Sexo:</td>
     		<td align="left">
	 		<select name="sexo" class="medio1" tabindex="5">
			<option value=""></option>
  	 		<option value="1" <?php $z="sexo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sexoa']==1) {echo ('selected=""');}?>>Masculino</option>
  	 		<option value="2" <?php $z="sexo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sexoa']==2) {echo ('selected=""');}?>>Femenino</option>
			</select>
   			</td>
  		</tr>
  		
 		<tr>
  			<td align="right">Direccion:</td>
     		<td align="left">
	 		<input class="extralargo" name="direccion" tabindex="10" value="<?php
			 if ($_SESSION['direcciona']!=""){
			  	echo $_SESSION[direcciona];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"direccion");}  ?>">
			</td>
	     </tr>

	  	<tr>
  			<td align="right">Ciudad residencia: </td>
     		<td align="left">
	 		<select name="ciudadresidencia" class="medio1" tabindex="12">
  	 		<option value=""></option>
 	 		<option value="08001" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="08001" or $_SESSION['ciudadresidenciaa']=="08001") {echo ('selected=""');}?>>Barranquilla</option>
 	 		<option value="11001" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="11001" or $_SESSION['ciudadresidenciaa']=="11001") {echo ('selected=""');}?>>Bogot&aacute;</option>
 	 		<option value="76001" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="76001" or $_SESSION['ciudadresidenciaa']=="76001") {echo ('selected=""');}?>>Cali</option>
 	 		<option value="25269" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25269" or $_SESSION['ciudadresidenciaa']=="25269") {echo ('selected=""');}?>>Facatativ&aacute;</option>			   	 		
 	 		<option value="25286" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25286" or $_SESSION['ciudadresidenciaa']=="25286") {echo ('selected=""');}?>>Funza</option> 	 		
 	 		<option value="25377" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25377" or $_SESSION['ciudadresidenciaa']=="25377") {echo ('selected=""');}?>>La Calera</option> 	 		
 	 		<option value="25430" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25430" or $_SESSION['ciudadresidenciaa']=="25430") {echo ('selected=""');}?>>Madrid</option> 	 		
 	 		<option value="05001" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="05001" or $_SESSION['ciudadresidenciaa']=="05001") {echo ('selected=""');}?>>Medell&iacute;n</option>
 	 		<option value="25473" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25473" or $_SESSION['ciudadresidenciaa']=="25473") {echo ('selected=""');}?>>Mosquera</option> 	 		
 	 		<option value="25740" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25740" or $_SESSION['ciudadresidenciaa']=="25740") {echo ('selected=""');}?>>Sibat&eacute;</option> 	 		
	 		<option value="25754" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25754" or $_SESSION['ciudadresidenciaa']=="25754") {echo ('selected=""');}?>>Soacha</option>
 	 		<option value="50001" <?php $z="ciudadresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="50001" or $_SESSION['ciudadresidenciaa']=="50001") {echo ('selected=""');}?>>Villavicencio</option>
 	 		</select>
	 		</td>
     	</tr>

   		<tr>
			<td align="right">Telefono:</td>
     		<td align="left">
	 		<input class="medio" tabindex="13" name="telefono" value="<?php
			 if ($_SESSION['telefonoa']!=""){
			  	echo $_SESSION[telefonoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono");}  ?>">
	 		</td>
   		</tr>

 		<tr>
  			<td align="right">Celular:</td>
     		<td align="left">
	 		<input class="medio" name="celular" tabindex="14" value="<?php
			 if ($_SESSION['celulara']!=""){
			  	echo $_SESSION[celulara];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"celular");}  ?>">
	 		</td>
	 	</tr>

 		<tr>
  			<td align="right">Rango militar:</td>
     		<td align="left">
	 		<select name="rangomilitar" class="largo1" tabindex="15">
  	 		<option value=""></option>
  	 		<option value="00" <?php $z="rangomilitar"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="00") {echo ('selected=""');}?>>No tiene libreta</option>
	 		<option value="1" <?php $z="rangomilitar"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="1") {echo ('selected=""');}?>>Libreta de primera</option>
	 		<option value="2" <?php $z="rangomilitar"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="2") {echo ('selected=""');}?>>Libreta de segunda</option>
	 		</select>
	 		</td>
     	</tr>

		<tr>
  			<td align="right">Profesion:</td>
     		<td align="left">
	 		<input class="medio" tabindex="16" name="profesion" value="<?php
			 if ($_SESSION['profesiona']!=""){
			  	echo $_SESSION[profesiona];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"profesion");}  ?>">
	 		</td>
     	</tr>
		<tr>
  			<td align="right">SVySP:</td>
     		<td align="left">
	 		<input type="checkbox" tabindex="17" <?php if (@mysql_result($result,$_SESSION['i'],svysp)==1){echo "checked";}?> style="WIDTH: 150; HEIGHT: 22px" size="31" tabindex="13" name="svysp" value="1">
	 		</td>
     	</tr>
 	</table>
 	
 		</td></tr></table>
		
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Socios
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
  	 		<option value="cedula">Cedula</option>
  	 		<option value="nombres">nombres</option>
  	 		<option value="apellidos">Apellido</option>
  	 		<option value="telefono">Telefono</option>
  	 		<option value="celular">Celular</option>
  	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut"  onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut"  onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="30px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Socio $p de $_SESSION[numreg]";} ?>
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
