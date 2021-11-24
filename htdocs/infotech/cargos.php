<?php
session_start();

@require('funciones2.php');
$link=validar("","","", 76);

formularioactual();

	if($_POST['ejecut']=="Buscar" || $_GET['ejecut']=="Buscar"){

                resetearsesion();

		$_SESSION['i']=0;
		$_SESSION['fotoir']="";

                if($_POST['ejecut']=="Buscar"){
		$_SESSION['datos']['campobusqueda']='cargo';
		$_SESSION['datos']['crito']=$_POST['criterio'];
		$_SESSION['datos']['opcion']=$_POST['opt'];
                }else{//busqieda con get
                $_SESSION['datos']['campobusqueda']=$_GET['campobusqueda'];
		$_SESSION['datos']['crito']=$_GET['criterio'];
		$_SESSION['datos']['opcion']=$_GET['opt'];
                }

                $_SESSION['datos']['claveprinc']="id";
		$_SESSION['datos']['otraconsulta']="";

		$_SESSION['botonuevo']=0;
        }else if($_POST['ejecut']=="Ingresar"){

                    //agregar cargo
                    if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                    $mens.=armarEjecutarSentencia("cargos", $_POST, "insert", $_SESSION);
                    
        }else if($_POST['ejecut']=="Actualizar"){

                        if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                        $_POST['claveprinc']="id";

                        $mens.=armarEjecutarSentencia("cargos", $_POST, "update", $_SESSION);

        }else if($_POST['ejecut']=="Nuevo"){

		$result="";
		//resetearsesion();
		$_SESSION['i']=$_SESSION['numreg'];

		$_SESSION['botonuevo']=1;
        }else if($_POST['ejecut']==">>"){

		if($_SESSION['i']<$_SESSION['numreg']-1){$_SESSION['i']++;}

		$_SESSION['botonuevo']=0;

        }else if($_POST['ejecut']=="<<"){

		if($_SESSION['i']>0){$_SESSION['i']--;}

		$_SESSION['botonuevo']=0;

        }else if($_POST['ejecut']=="||<"){

		$_SESSION['i']=0;

		$_SESSION['botonuevo']=0;

        }else if($_POST['ejecut']==">||"){

		$_SESSION['i']=$_SESSION[numreg]-1;

		$_SESSION['botonuevo']=0;

        }else if($_POST['ejecut']=="Retirar"){

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $_POST['activo']="0";   //actualizar a cliente retirado
                $_POST['fincontrato']="NOW()";
                $mens=armarEjecutarSentencia("personalactivo", $_POST, "update", $_SESSION);

		$_SESSION['botonuevo']=0;

        }else{//ingreso por primera vez al formulario

                resetearsesion();

                $_SESSION['i']=0;
		$_SESSION[fotoir]="";

		$_SESSION['datos']['campobusqueda']="cargo";
		$_SESSION['datos']['opcion']=1;
                $_SESSION['datos']['claveprinc']="id";
		$_SESSION['datos']['otraconsulta']="";

        }

$mens.=$error;

$result2=operaciones("cargos","buscar",$_SESSION['datos']);
$tipo=gettype($result2);

if($tipo=="string"){//hay un error en la consulta mostrarlo en extjs
$mens.=$result2;
}

$result=$result2[datos];

$_SESSION['foto']=@mysql_result($result,$_SESSION['i'],foto);

$despto=@mysql_result($result,$_SESSION['i'],"coddeptonacim");
$ciudaestos=@mysql_result($result,$_SESSION['i'],"codciudadnacim");

if(@mysql_result($result,$_SESSION['i'],"codigo")==""){
    $coddep=$_SESSION[codigoa];
}else{
    $coddep=@mysql_result($result,$_SESSION['i'],"codigo");
}

$muestrdeptospert[1]="departamento";
$muestrdeptospert[2]="codigo";
$otrasent="AND departamentos.activo = 1 AND departamentos.sucursal LIKE '$_SESSION[sucur]'";
$cadenadeptos=selection("departamentos","id","%",$muestrdeptospert,@mysql_result($result,$_SESSION['i'],"idepto"),2,"departamento",$otrasent);

$r=@require('version.php');
caracteresiso();
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
<form method="post" action="<?php echo $PHP_SELF?>" name="cargos"  onsubmit="return validacargos(boolvalidar);">
		<br>
 		<center><table class="tablaprinc" align="center" width="55%"><tr><td>
 		<table>
	  	<tr>
	 		<td align="right">*Nombre Cargo:
      		</td>
     		<td align="left">
      		<input class="extralargo" tabindex="2"
			  value="<?php
			  if ($_SESSION['cargoaa']!=""){
			  	echo $_SESSION[cargoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cargo");}
			?>" name="cargo">
			</td>
		</tr>
   		<tr>
				<td align="right">*Pertenece a Departamento:</td>
				<td align="left"><select name="idepto" class="extralargo">
					<option value=""></option>
					<?php echo $cadenadeptos;?>
				</select></td>
                </tr>
 	</table>
 	
 		</td></tr></table></center>
		
		<div id="controlex">
     		<table class="control">
	<tr>
		<td colspan="2" class="arriba" align="center">Cargos
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
		<td colspan="2" align="center"><input checked name="opt" type="radio" value="1">cualquier <input type="radio" name="opt" value="2">mismo</td>
	</tr>
	<tr height="10px">
		<td valign="middle" colspan="2" align="center"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input type="submit" class="botopri"
			value="||<" name="ejecut"> <input type="submit" class="botoant"
			value="<<" name="ejecut"> <input type="submit" class="botosig"
			value=">>" name="ejecut"> <input type="submit" class="botoult"
			value=">||" name="ejecut"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input type="submit" class="botoactu"
			value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;"
			onkeydown="boolvalidar=true;" /> </td>
	</tr>
	<tr height="10px">
	<td colspan="2" align="center"><input type="submit"
			class="botonuev" value="Nuevo" name="ejecut"> <input type="submit"
			class="botoing" value="Ingresar"
			<?php if($_SESSION['botonuevo']==0){echo "disabled";}?> name="ejecut"
			onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"></td>
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
  
