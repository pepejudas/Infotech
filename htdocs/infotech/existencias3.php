<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 13);

formularioactual();
	
switch($_POST[ejecut]):
case "Buscar":

		$_SESSION['i']=0;
		
		$datos[campobusqueda]=$_POST[campobusqueda];
		$datos[crito]=$_POST[criterio];
		$datos[opcion]=$_POST[opt];
		$datos[claveprinc]="id";
		$datos[otraconsulta]="";
		
		$result2=operaciones("productos","buscar",$datos);
		$result=$result2[datos];
		
		$idprod=@mysql_result($result,$_SESSION['i'],"id");
		$disponible=saldoinv($idprod,"1");
		$disponible2=saldoinv($idprod,"2");

break;
case ">>":
	
	if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}

		$result2=operaciones("productos","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
		$idprod=@mysql_result($result,$_SESSION['i'],"id");
		$disponible=saldoinv($idprod,"1");
		$disponible2=saldoinv($idprod,"2");

break;
case "<<":
if($_SESSION[i]>0){$_SESSION[i]--;}	

$result2=operaciones("productos","buscar",$_SESSION[datos]);
$result=$result2[datos];

		$idprod=@mysql_result($result,$_SESSION['i'],"id");
		$disponible=saldoinv($idprod,"1");
		$disponible2=saldoinv($idprod,"2");

break;
case ">||":

$_SESSION[i]=$_SESSION[numreg]-1;
	
$result2=operaciones("productos","buscar",$_SESSION[datos]);
$result=$result2[datos];

		$idprod=@mysql_result($result,$_SESSION['i'],"id");
		$disponible=saldoinv($idprod,"1");
		$disponible2=saldoinv($idprod,"2");

break;
case "||<":
	
	$_SESSION[i]=0;
	
	$result2=operaciones("productos","buscar",$_SESSION[datos]);
	$result=$result2[datos];
	
		$idprod=@mysql_result($result,$_SESSION['i'],"id");
		$disponible=saldoinv($idprod,"1");
		$disponible2=saldoinv($idprod,"2");

break;
case "Nuevo":
$sql="SELECT * FROM productos ORDER BY nombreprod";
$result=@mysql_query($sql);
$lim=@mysql_num_rows($result);
$_SESSION[numreg]=$lim;
$_SESSION[i]=$lim;
$boton=1;
break;
case "Ingresar":
if($_POST[nombreprod]!=""){
	if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
        $mens.=armarEjecutarSentencia("productos", $_POST, "insert", $_SESSION);
}
break;
case "Actualizar":
if($_POST[nombreprod]!=""){

        if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
        $mens.=armarEjecutarSentencia("productos", $_POST, "update", $_SESSION);
	
		$idprod=@mysql_result($result,$_SESSION['i'],"id");
		$disponible=saldoinv($idprod,"1");
		$disponible2=saldoinv($idprod,"2");
	
	$result2=operaciones("productos","buscar",$_SESSION[datos]);
	$result=$result2[datos];
		
}

break;
case "eliminar":
	$sql1="DELETE FROM `productos` WHERE `productos`.`id` = '$_SESSION[clientemod]'";
	$cons=@mysql_query($sql1);
	$_SESSION[i]=$lim;	
break;

endswitch;

		$r=@require('version.php');
		caracteresiso();
$coltabla="#88sd111"
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
<br><form method="post" action="<?php echo $PHP_SELF?>" onsubmit="return validaproductos(boolvalidar);" name="productos">
		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
	 		<td align="right" width="35%">Id articulo:<input class="largo" style="background-color:#DBDBDB" readonly size="31" 
			 value="<?php
			 if ($_SESSION['ida']!=""){
			  	echo $_SESSION[ida];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"id");}
			 		?>" name="id"></td>
     		<td width="30%" valign="top" rowspan="5" align="center">
	 		Observacion de Articulo<br><textarea name="observacionesprod" id="sqlquery" cols="16" rows="4" dir="ltr"><?php if ($_SESSION['observacionproda']!=""){echo $_SESSION[observacionproda];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionesprod");}?></textarea>	
		  	</td>
     	</tr>
     		<tr>
			<td align="right">Numero de Serie:<input class="largo" name="serial"
			 value="<?php
			 if ($_SESSION['seriala']!=""){
			  	echo $_SESSION[seriala];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"serial");} ?>"></td>
   		</tr>
		<tr>
			<td align="right">*Nombre de articulo:<input class="largo" name="nombreprod"
			 value="<?php
			 if ($_SESSION['nombreproda']!=""){
			  	echo $_SESSION[nombreproda];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombreprod");} ?>"></td>
   		</tr>
   		
     	<tr><!-- Row 3 -->
   	 	</tr>
                <tr><!--
                        <?php
                        if (@mysql_result($result,$_SESSION['i'],"tipoprod")=="1"){$selecprod1="selected";$selecprod2="";}else if(@mysql_result($result,$_SESSION['i'],"tipoprod")=="2"){$selecprod1="";$selecprod2="selected";}else{$selecprod1="";$selecprod2="";}// para saber tipo de producto
                        $tiprod="<select name=\"tipoprod\" class=\"largo1\"><option value=\"1\" $selecprod1 >No Consumible</option><option value=\"2\" $selecprod2 >Consumible</option></select>";
                        ?>

                    -->

  		<td align="right">*Tipo Producto:
                <?php echo $tiprod;?>
      		</td>
   	 	</tr>

 	 	<tr style="border-width: thin ;"><!-- Row 4 -->
 			<td align="right">Referencia:
			<input class="largo" 
			 value="<?php
			 if ($_SESSION['referenciaa']!=""){
			  	echo $_SESSION[referenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"referencia");}
			 		?>" name="referencia"> 
			</td>
		</tr>
		
  		<tr>
  			<td align="right">
  			Modelo:
			<input class="largo" 
			 value="<?php
			 if ($_SESSION['modeloa']!=""){
			  	echo $_SESSION[modeloa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"modelo");}
			 		?>" name="modelo"> 
  			</td>
		</tr>
		
  		<tr style="border-width: thin ;"><!-- Row 4 -->
 			<td align="right">
 			Marca:
			<input class="largo" 
			 value="<?php
			 if ($_SESSION['marcaa']!=""){
			  	echo $_SESSION[marcaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"marca");}
			 		?>" name="marca">
			</td>
		</tr>
		
  		<tr><!-- Row 4 -->
 			<td align="right">
 			Disponible Nuevo:
			<input class="largo" style="background-color:#DBDBDB" size="31" readonly 
			 value="<?php
			 if ($disponible!=""){
			  	echo $disponible;
			  }
			 		?>" name="cantidaddisp">
			</td>
  		</tr>
  		<tr><!-- Row 4 -->
 			<td align="right">
 			Disponible Usado:
			<input class="largo" style="background-color:#DBDBDB" size="31" readonly
			 value="<?php
			 if ($disponible2!=""){
			  	echo $disponible2;
			  }
			 		?>" name="cantidaddisp">
			</td>
  		</tr>
  		</table>
		    
		</td></tr></table>		
		
			<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Productos
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
  	 		<option value="nombreprod">Nombre Producto</option>
  	 		<option value="precio">Precio</option>
  	 		<option value="referencia">Referecia</option>
  	 		<option value="modelo">Modelo</option>
  	 		<option value="marca">Marca</option>
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
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Producto $p de $_SESSION[numreg]";} ?>
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
