<?php 
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 24);

formularioactual();

switch ($_POST[ejecut]):
case "Buscar":

	if ($_POST[codcli]!=""){
	$_SESSION[clientemod2]=$_POST[codcli];
	}
	
	$_SESSION['i']=0;
	
	$datos1[campobusqueda]="codigo";
	$datos1[crito]=$_SESSION[clientemod2];
	$datos1[opcion]="";
	$datos1[claveprinc]="consecutivo";
			
	$result2=operaciones("radios","buscar",$datos1);
	$result=$result2[datos];
	
break;
case ">>":
if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
	$result2=operaciones("radios","buscar",$_SESSION[datos]);
	$result=$result2[datos];
break;
case "<<":
if($_SESSION[i]>0){$_SESSION[i]--;}
	$result2=operaciones("radios","buscar",$_SESSION[datos]);
	$result=$result2[datos];
break;
case ">||":
$_SESSION[i]=$_SESSION[numreg]-1;
$result2=operaciones("radios","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
case "||<":
$_SESSION['i']=0;
$result2=operaciones("radios","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
case "Actualizar":
if ($_POST[codcli]!=""){$_SESSION[clientemod2]=$_POST[codcli];}
$_POST[codigo]=$_SESSION[clientemod2];
$_POST[fechaentrega]="NOW()";
if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
$mens=armarEjecutarSentencia("radios", $_POST, "update", $_SESSION);
	
$result2=operaciones("radios","buscar",$datos1);
$result=$result2[datos];
break;
case "Ingresar":
if ($_POST[serie]!="" and $_POST[marca]!="" and $_SESSION[clientemod2]!=""){
$_POST[codigo]=$_SESSION[clientemod2];
$_POST[fechaentrega]="NOW()";
if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
$mens=armarEjecutarSentencia("radios", $_POST, "insert", $_SESSION);
}else{
echo '<script language="JavaScript" type="text/JavaScript"> alert("Atencion todos los campos son requeridos");</script>';
}
break;
case "Nuevo":
$_SESSION[i]=$_SESSION[numreg];
$boton=1;
break;
case "Eliminar":
$sql11 ="DELETE FROM `radios` WHERE `radios` . `consecutivo` LIKE $_SESSION[clientemod] LIMIT 1";
$resu=mysql_query($sql11);
$_SESSION[numreg]=$_SESSION[numreg]-1;
break;
endswitch;

$mostra[1]="codigo";
$mostra[2]="nombrecliente";
$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("clientes","codigo","%",$mostra,$_SESSION[clientemod2],2,"codigo",$otras);
		
$r=@require('version.php');
caracteresiso();
$colcuerpo="#FAFAFA";
$coltabla="#AA7FFF";
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
 	 	<form method="post" action="<?php echo $PHP_SELF?>" onsubmit="return validaradios(boolvalidar);" name="radios">
 		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
	 	<td align="right" width="33%">Consecutivo:<input style="background-color:#DBDBDB" class="largo" readonly size="31" tabindex="2"
			 value="<?php
			 if ($_SESSION['consecutivoa']!=""){
			  	echo $_SESSION[consecutivoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"consecutivo");}
			 		?>" name="consecutivo"></td>
	 		<td width="30%" valign="top" rowspan="8" align="right">
	 		<center>Observacion de Radio<br><textarea name="observacionradio" id="sqlquery" cols="16" rows="4" dir="ltr" tabindex="12"><?php if ($_SESSION['observacionradioa']!=""){echo $_SESSION[observacionradioa];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionradio");}?></textarea></center>	
		  	</td>
     		</tr>
  			<tr>
  			<td align="right">*Numero de serie:<input class="largo" tabindex="3" name="serie"
			 value="<?php
		 if ($_SESSION['seriea']!=""){
			  	echo $_SESSION[seriea];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"serie");} ?>"></td>
     		</tr>

     		<tr>
  			<td align="right">*Marca:<input class="largo" tabindex="4"
			 value="<?php
			 if ($_SESSION['marcaa']!=""){
			  	echo $_SESSION[marcaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"marca");}
			 		?>" name="marca">
      		</td>
    	 	</tr>

	 		<tr>
  			<td align="right">*Tipo:
			<select name="tipo" class="largo1" tabindex="5">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="tipo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sexoa']==1) {echo ('selected=""');}?>>Punto a Punto</option>
  	 		<option value="2" <?php $z="tipo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sexoa']==2) {echo ('selected=""');}?>>Radio Base</option>
			</select>  
			</td>
  			</tr>
  			
  	 		<tr>
  			<td align="right">
                        Modelo:<input class="largo" value="<?php if ($_SESSION['modeloa']!=""){	echo $_SESSION[modeloa];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"modelo");}?>" name="modelo"></td>
                        </tr>
     		</table>
     		
     	</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr height="150px"><td colspan="2" class="arriba">
     		Radios
     		</td>
     		</tr>
     		<tr height="20px" valign="top"><td valign="middle" align="center" colspan="2">
 			<input type="submit" class="botobusca" value="Buscar" name="ejecut" onmousedown="boolvalidar=false;" onkeydown="boolvalidar=false;">
 			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<select name="codcli" class="largo2">
			<option value=""></option>
 	 		<?php echo $cadena;?>
 	 		</select>
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			<input type="submit" class="botoelimina" value="Eliminar" name="ejecut"/>
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut"  onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="30px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Radio $p de $_SESSION[numreg]";} ?>
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
