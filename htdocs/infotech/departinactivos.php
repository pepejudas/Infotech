<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');
@require('clases/claseNotificacion.php');

validar("","","", 56);

formularioactual();

 	if($_POST[ejecut]=="Buscar" || $_GET[ejecut]=="Buscar"){

		$_SESSION[datos]="";
		$_SESSION[i]=0;

                if($_POST[ejecut]=="Buscar"){
		$datos[campobusqueda]=$_POST[campobusqueda];
		$datos[crito]=$_POST[criterio];
		$datos[opcion]=$_POST[opt];
                }else{//busqieda con get
                $datos[campobusqueda]=$_GET[campobusqueda];
		$datos[crito]=$_GET[criterio];
		$datos[opcion]=$_GET[opt];
                //print_r($_GET);
                }

                $sent="SELECT * FROM departamentos LEFT JOIN personalactivo ON departamentos.responsable=personalactivo.cedula WHERE departamentos.activo = 1 AND departamentos.$datos[campobusqueda]= AND `sucursal` LIKE '$_SESSION[sucur]'";
                $datos[otraconsulta]="AND departamentos.activo = 2";
		$datos[claveprinc]="id";

		$result2=operaciones("departamentos","buscar",$datos);
		$result=$result2[datos];

        }else if($_POST[ejecut]==">>"){

		if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
		$result2=operaciones("departamentos","buscar",$_SESSION[datos]);
		$result=$result2[datos];

        }else if($_POST[ejecut]=="<<"){

		if($_SESSION[i]>0){$_SESSION[i]--;}
		$result2=operaciones("departamentos","buscar",$_SESSION[datos]);
		$result=$result2[datos];

        }else if($_POST[ejecut]=="||<"){

		$_SESSION[i]=0;
		$result2=operaciones("departamentos","buscar",$_SESSION[datos]);
		$result=$result2[datos];

	}else if($_POST[ejecut]==">||"){

		$_SESSION[i]=$_SESSION[numreg]-1;
		$result2=operaciones("departamentos","buscar",$_SESSION[datos]);
		$result=$result2[datos];

	}else if($_POST[ejecut]=="Actualizar"){

		try{
		if($_POST[codigo]!="" && $_POST[departamento]!=""){
		$sql = "UPDATE `departamentos` SET `codigo` = '$_POST[codigo]', `departamento` = '$_POST[departamento]', `responsable` = '$_POST[responsable]' WHERE `departamentos`.`id` = '$_SESSION[clientemod]' LIMIT 1";
		$cons=@mysql_query($sql);

		$reg="INSERT INTO `registrodemodificaciones` (`id`, `fecha`, `cambio`, `hechopor`, `cedulamodificada`, `tablamod`, `sucursal`) VALUES (NULL, NOW(), 'actualizardepto', '$_SESSION[persona]', '$_POST[codigo]', '6', '$_SESSION[sucur]')";
		$consulta = @mysql_query($reg);

		$result2=operaciones("clientes","buscar",$_SESSION[datos]);
		$result=$result2[datos];
		}
		}catch(Exception $error){
		$mens=$error;
		}

		$result2=operaciones("departamentos","buscar",$datos);
		$result=$result2[datos];

        }else if($_POST[ejecut]=="Ingresar"){
		if($_POST[codigo]!="" && $_POST[codigo]!="inserte"){
		$senten="UPDATE `departamentos` SET `activo` = '1' WHERE `departamentos`.`id` = '$_SESSION[clientemod]' LIMIT 1";
		$consulta = @mysql_query($senten);
		$reg="INSERT INTO `registrodemodificaciones` (`id`, `fecha`, `cambio`, `hechopor`, `cedulamodificada`, `tablamod`, `sucursal`) VALUES (NULL, NOW(), 'retirardepartamento', '$_SESSION[persona]', '$_SESSION[clientemod]', '2', '$_SESSION[sucur]')";
		$consulta = @mysql_query($reg);
		}
        }

	$datos2[cliente]=$_SESSION[clientemod];
	$numvig=numvigact($datos2);

        $mostra[1]="apellidos";
        $mostra[2]="nombre";
        $mostra[3]="cedula";
        $otras="AND `personalactivo`.`activo`='1' AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'";
        $cadena=selection("personalactivo","cedula","%",$mostra,@mysql_result($result,$_SESSION['i'],"responsable"),3,"apellidos",$otras);


	$r=@require('version.php');
	caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9AFF83";

?>
<link rel="stylesheet" href="estilo2.css" type="text/css"/>
<link rel="stylesheet" href="botones.css" type="text/css"/>

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

		<form method="post" action="departinactivos.php" name="departamentos" onsubmit="return validadepartamento(boolvalidar);">
 		<table class="tablaprinc"><tr><td>
		<table>
 		<tr>
  			<td align="right">*Codigo:
      		</td>
     		<td align="left">
      		<input class="largo1" tabindex="2"
			  value="<?php
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"codigo");}

			?>" name="codigo">
	  		</td><!-- Col 1 3174373496 -->
    	</tr>

   		<tr><!-- Row 3 -->
  			<td align="right">*Nombre Departamento:</td>
     		<td align="left">
	 		<input class="extralargo" tabindex="3"
			 value="<?php
			 /*if ($_SESSION['nombrea']!=""){
			  	echo $_SESSION[nombrea];
			  }else*/
			  if (!$result){
			  	echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"departamento");}
			 		?>" name="departamento">
      			</td><!-- Col 1 -->
   	 	</tr>

		<tr style="border-width: thin ;"><!-- Row 4 -->
  			<td align="right">Director de Departamento</td>
     		<td align="left"><select name="responsable" style="width:300px"><option></option>
	 		 <?php echo $cadena;?>
                    </select>
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
	 		</td><!-- Col 1 -->
     		</tr>
			';
			}
     	?>

 		</table>

 		</td></tr></table>
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Departamentos Inactivos
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
  			<option value="codigo">Codigo</option>
 	 		<option value="departamento">Nombre Departamento</option>
  	 		<option value="nombreadministrador">Responsable</option>
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
                        <input type="submit" class="botoing" value="Ingresar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Departamento $p de $_SESSION[numreg]";} ?>
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
