<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 45);

formularioactual();
	
	switch ($_POST[ejecut]):
	case "Buscar":
		
	$_SESSION['i']=0;
	
	$datos1[campobusqueda]="$_POST[campobusqueda]";
	$datos1[crito]="$_POST[criterio]";
	$datos1[opcion]="$_POST[opt]";
	$datos1[claveprinc]="id";
			
	$result2=operaciones("correspondencia","buscar",$datos1);
	$result=$result2[datos];
	
	$_SESSION['clientemod2']=@mysql_result($result,$_SESSION['i'],"codigo");
	
	break;
	case ">>":
	
	if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
	
	$result2=operaciones("correspondencia","buscar",$_SESSION[datos]);
	$result=$result2[datos];
	
	$_SESSION['clientemod2']=@mysql_result($result,$_SESSION['i'],"codigo");
	
	break;
	case "<<":
	
	if($_SESSION[i]>0){$_SESSION[i]--;}
	
	$result2=operaciones("correspondencia","buscar",$_SESSION[datos]);
	$result=$result2[datos];
	
	$_SESSION['clientemod2']=@mysql_result($result,$_SESSION['i'],"codigo");
	
	break;
	case "Actualizar":
	if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
        if($_POST['contestada']=="on"){$_POST['contestada']=1;}else{$_POST['contestada']=2;}
        $mens.=armarEjecutarSentencia("correspondencia", $_POST, "update", $_SESSION);
	break;
	case "Ingresar":
		
		if ($_POST[codigo]!="" and $_POST[nombreusuario]!=""){

                        if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                        $_POST['fecharegistro']="NOW()";
                        if($_POST['contestada']=="on"){$_POST['contestada']=1;}else{$_POST['contestada']=2;}
                        $_POST['registradopor']=$_SESSION[persona];
                        $mens.=armarEjecutarSentencia("correspondencia", $_POST, "insert", $_SESSION);

                        }else{
			$mens.="Atencion debe ingresar todos los campos requeridos \nmarcados con asterisco *";
			$boton=1;
			}
	break;
	case "Nuevo":

		$_SESSION[i]=$_SESSION[numreg];
		
		$result2=operaciones("correspondencia","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		
		$_SESSION['clientemod2']=@mysql_result($result,$_SESSION['i'],"codigo");
		
		$boton=1;
		break;
		
		case ">||":
			
		$_SESSION[i]=$_SESSION[numreg]-1;
		
		$result2=operaciones("correspondencia","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		
		$_SESSION['clientemod2']=@mysql_result($result,$_SESSION['i'],"codigo");
	
	break;
	case "||<":
		$_SESSION[i]=0;
		
		$result2=operaciones("correspondencia","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		
		$_SESSION['clientemod2']=@mysql_result($result,$_SESSION['i'],"codigo");
	break;
	
	
	endswitch;
	
	
$mostra[1]="codigo";
$mostra[2]="nombrecliente";
$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("clientes","codigo","%",$mostra,$_SESSION[clientemod2],2,"nombrecliente",$otras);
	
	
	
	$r=@require('version.php');
	caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9Affff";
?>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">


<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/correspondencia.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->

</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>

		<form method="post" action="<?php echo $PHP_SELF?>" name="correspondencia" onsubmit="return validacorrespondencia(boolvalidar);">
 		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
	 		<td align="right" width="23%">
	 		*Codigo del cliente:      
	 		</td>
     		<td align="left" width="35%">
     		<select tabindex="1" style="WIDTH:250px" name="codigo">
  	 		<option value="" selected>seleccionar</option>
  	 		<?php echo $cadena;?>
			</select>
	 		</td><!-- Col 1 -->
	 		<td width="13%" rowspan="10" align="center">Contestada:<input type="checkbox" name="contestada" <?php if(@mysql_result($result,$_SESSION['i'],contestada)==1){echo "checked=\"checked\"";}?> ><br>
	 		Consecutivo:<br><input style="background-color:#DBDBDB" readonly class="medio"
			  value="<?php
			
			  if ($_SESSION['ida']!=""){
			  	echo $_SESSION[ida];
			  }elseif (!$result){
			  	echo "autoasignado";}else{ echo @mysql_result($result,$_SESSION['i'],"id");}
			 
			?>" name="id">
			Observaciones<br><textarea name="observacionescarta" id="sqlquery" cols="20" tabindex="5" rows="7" dir="ltr"><?php if ($_SESSION['observacionescartaa']!=""){echo $_SESSION[observacionescartaa];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionescarta");}?></textarea>
			</tr>

  			<tr> 
  			<td align="right">*Nombre Remitente:  
      		</td>
     		<td align="left">
	 				<input class="extralargo" tabindex="2"
			  value="<?php if ($_SESSION['nombreusuarioa']!=""){echo $_SESSION[nombreusuarioa];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombreusuario");}?>" name="nombreusuario">
			</td>
     		</tr>

     		<tr>
                <td align="right">Telefono Remitente:</td>
     		<td align="left">
	 		<input class="medio" tabindex="3"
			 value="<?php
			 if ($_SESSION['telefonousuarioa']!=""){
			  	echo $_SESSION[telefonousuarioa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefonousuario");}
			 		?>" name="telefonousuario">
	 		</td><!-- Col 1 -->
    	 	</tr>

	 		<tr>
  			<td align="right">*Motivo:</td>
     		<td align="left">
	 		<select name="problema" class="extralargo1" tabindex="4">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['problemaa']==1) {echo ('selected=""');}?>>Queja supervision</option>
  	 		<option value="2" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['problemaa']==2) {echo ('selected=""');}?>>Hurto</option>
  	 		<option value="3" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['problemaa']==3) {echo ('selected=""');}?>>Da&ntilde;os en propiedad</option>
  	 		<option value="4" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['problemaa']==4) {echo ('selected=""');}?>>Queja por vigilantes</option>
  	 		<option value="5" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['problemaa']==5) {echo ('selected=""');}?>>Reclamacion de indemnizacion</option>
  	 		<option value="6" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['problemaa']==6) {echo ('selected=""');}?>>Comunicado</option>
  	 		<option value="7" <?php $z="problema"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==7 or $_SESSION['problemaa']==7) {echo ('selected=""');}?>>Otro</option>
			</select>
	 		</td>
  			</tr>
                        <tr>
				<!-- Row 11 -->
				<td align="right">*Fecha del Comunicado:</td>
				<td align="left"><input name="fecha" class="largo" id="fecha"
					value="<?php
			if ($_SESSION['fechaingresoa']!=""){
			  	echo $_SESSION[fechaingresoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fecha");}  ?>"/>
				</td>
				<!-- Col 1 -->
			</tr>
  	 		<tr>
  			<td align="right">Fecha de registro:</td>
     		<td align="left">
	 		<input style="background-color:#DBDBDB" readonly  class="largo"
			  value="<?php
			
			  if ($_SESSION['fecharegistroa']!=""){
			  	echo $_SESSION[fecharegistroa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fecharegistro");}
			 
			?>" name="fecharegistro">
	 		</td>
	     	</tr>

		  	<tr>
  			<td align="right">Ingresado por:</td>
		    <td align="left">
			<input style="background-color:#DBDBDB" class="largo" tabindex="8" readonly name="registradopor" value="<?php
			 if ($_SESSION['registradopora']!=""){
			  	echo $_SESSION[registradopora];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"registradopor");}  ?>">
	 		</td>
     		</tr>
     		
	   		<tr>
			<td align="right">Fecha de respuesta: </td>
     		<td align="left">
			<input style="background-color:#DBDBDB" readonly class="largo"
			  value="<?php
			
			  if ($_SESSION['fechaenviorespuestaa']!=""){
			  	echo $_SESSION[fechaenviorespuestaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechaenviorespuesta");}
			 
			?>" name="fechaenviorespuesta">
	 		</td>
     		</tr>

  			<tr>
  			<td align="right">Contestado por: </td>
			<td align="left">
			<input class="largo" style="background-color:#DBDBDB" readonly tabindex="8" name="contestadopor" value="<?php
			 if ($_SESSION['contestadopora']!=""){
			  	echo $_SESSION[contestadopora];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"contestadopor");}  ?>">
	 		</td><!-- Col 1 -->
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
	 		</td>
     		</tr>
			';	
			}
     		?>
		</table>
		</td></tr></table>
     		<div id="controlex">
     		<table  class="control">
     		<tr height="150px"><td colspan="2" class="arriba">
     		Correspondencia
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
			<option value="id">Consecutivo</option>
  	 		<option value="codigo">Codigo cliente</option>
  	 		<option value="nombreusuario">Nombre Remitente</option>
  	 		<option value="telefonousuario">Telefono Remitente</option>
  	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Carta $p de $_SESSION[numreg]";} ?>
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
