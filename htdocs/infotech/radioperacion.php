<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 34);

formularioactual();

$fecha=getdate(time());

switch($fecha[hours]){
	case 6;
	case 7;
	case 8;
	case 9;
	case 10;
	case 11;
	case 12;
	case 13;
	case 14;
	case 15;
	case 16;
	case 17;
	$activar=1;
	$cturno="d";
	$tabla="controlturnos";
	$val=1;
	break;
	case 18;
	case 19;
	case 20;
	case 21;
	case 22;
	case 23;
	$activar=1;
	$cturno="n";
	$tabla="controlturnos";
	$val=1;
	break;

	case 0;
	case 1;
	case 2;
	case 3;
	case 4;
	if($fecha[minutes]<=50){
		$activar=1;}
		$cturno="n";
		$tabla="reportes";
		break;
}
switch($_POST['ejecut']){
    case "Buscar";
		$_SESSION['i']=0;
		$_SESSION[clientemod]=$_POST[codcli];
			
		$datos[campobusqueda]="codigo";
		$datos[crito]=$_SESSION[clientemod];
		$datoscliente=operaciones("clientes","buscar",$datos);
		$cliente=@mysql_result($datoscliente[datos],0,"nombrecliente");
		$clierelevante=@mysql_result($datoscliente[datos],0,"clierelevante");
		
		$_SESSION['personald1']=$personald=@mysql_result($datoscliente[datos],0,"personald");
		$_SESSION['personaln1']=$personaln=@mysql_result($datoscliente[datos],0,"personaln");
			
		$sqql = "SELECT * FROM personalactivo  LEFT JOIN clientes ON personalactivo.codigo=clientes.codigo WHERE personalactivo.activo = 1 AND clientes.id LIKE '$_SESSION[clientemod]' ORDER BY apellidos ASC";
                $result= @mysql_query($sqql) or $mens.=@mysql_error();
		$numfilas= @mysql_num_rows($result);
		$filas= @mysql_fetch_array($result);
		$opcionesSel=obtenerNovedades("");
                
		while($ini<$numfilas){
			$chorrero.="<tr><td><a href=personalactivo3.php?ejecut=Buscar&criterio=".@mysql_result($result,$ini,cedula)."&campobusqueda=cedula&opt=2>".@mysql_result($result,$ini,cedula)."</a></td><td>".@mysql_result($result,$ini,apellidos)." ".@mysql_result($result,$ini,nombre)."</td><td>" . '<input type="checkbox"' .' name="cedula-' .@mysql_result($result,$ini,cedula). '" id="cedula-' .@mysql_result($result,$ini,cedula). '"/>'."</td><td>".selectcliente(@mysql_result($result,$ini,cedula), $_POST["codcli"], $clierelevante)."</td><td>".'<select name="novedad-'.@mysql_result($result,$ini,cedula).'" class="medio1" id="novedad-'.@mysql_result($result,$ini,cedula).'">'.$opcionesSel.'</select>'.'</td></tr>';
			if($ini+1==$numfilas){$coma="";}else{$coma=", ";}
			$matrizced.="\"".@mysql_result($result,$ini,cedula)."\"$coma";
			$ini++;
		}
        break;
        default;
		$numero2 = count($_POST);
		$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
		$valores2 = array_values($_POST);// obtiene los valores de las varibles

		for($i=0;$i<$numero2;$i++){
			$cedula0=explode("cedula-",$tags2[$i]);
			$cedula1=explode("novedad-",$tags2[$i]);
			$cedula[$i]=$cedula0[1];
			$cedulanov[$i]=$cedula1[1];

			$sql="SELECT clierelevante FROM `clientes` WHERE `clientes`.`codigo`='$_POST[codcli]' LIMIT 1";
			$consclier=@mysql_query($sql) or $mens.=@mysql_error();
			$clierel=@mysql_result($consclier, 0, "clierelevante");
			
			if($clierel=="1"){//verificar si turnos o novedades o reportes son de relevantes
				if($cedula[$i]!=""){
				$codclif=$_POST["codcliente-$cedula[$i]"];
				}else{
				$codclif=$_POST["codcliente-$cedulanov[$i]"];	
				}
			}else{
				$codclif=$_POST["codcli"];
			}
			if($_POST["cedula-".$cedula[$i]]=="on"){//verificar reportes de turnos
				$sql5="SELECT * FROM `$tabla` WHERE `$tabla`.`cedulacontrol`= '$cedula[$i]' AND `$tabla`.`mescontrol` LIKE '$fecha[month]$fecha[year]' ";
				$resultacons=@mysql_query($sql5) or $mens.=@mysql_error();
				$hayreg=@mysql_num_rows($resultacons);
				$idcontrol=@mysql_result($resultacons,0, "id");

				if($hayreg>0){//ya existe registro del mes año y persona creado por tanto debe buscarse y actualizar
					$sql3="UPDATE `$tabla` SET `$cturno$fecha[mday]` = '1', `cod$fecha[mday]`='$codclif', `reg$fecha[mday]`='$_SESSION[usuariow]' WHERE `$tabla`.`id` = '$idcontrol' LIMIT 1";
				}else{//si no existe crear registro de mes persona y año dado
					$sql3="INSERT INTO $tabla (`fecharegistro`, `cedulacontrol`, `mescontrol`, `$cturno$fecha[mday]`, `cod$fecha[mday]`, `reg$fecha[mday]` ) VALUES (NOW(), '$cedula[$i]', '$fecha[month]$fecha[year]', 1, '$codclif', '$_SESSION[usuariow]') ";
				}

                                $sql8="INSERT INTO `registrodemodificaciones` (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal) VALUES (NOW(), 'correccion turnos', '$_SESSION[usuariow]', '".addslashes($sql3)."', '$tabla', '$_SESSION[sucur]')";
                                $cons3=mysql_query($sql8) or $mens.=@mysql_error();

				try{
                                $resultcons=@mysql_query($sql3) or $mens.=@mysql_error().$sql3;
				}catch(Exception $err){

				}
			}
			
			if($_POST["novedad-".$cedulanov[$i]]!=""){//verificar reportes de novedades y control de servicios
				$nov="novedad-".$cedulanov[$i];
				$sql13="INSERT INTO `novedades` (cedula, novedad, fechareg, ingresadopor, codcliente) VALUES ('$cedulanov[$i]', '$_POST[$nov]', NOW(), '$_SESSION[usuariow]', '$codclif')";
				
				try{
                                $resultconsnov=@mysql_query($sql13) or $mens.=@mysql_error();
				}catch(Exception $err){

				}

                                //registrar la novedad de la persona dentro del control de servicios
                                $sql5="SELECT * FROM `controlturnos` WHERE `controlturnos`.`cedulacontrol`= '$cedulanov[$i]' AND `controlturnos`.`mescontrol` LIKE '$fecha[month]$fecha[year]' ";
				$resultacons=@mysql_query($sql5) or $mens.=@mysql_error();
				$hayreg=@mysql_num_rows($resultacons);
				$idcontrol=@mysql_result($resultacons,0, "id");

                                //$novingr=verificarNovedadRadiop($_POST[$nov]);
                                //die($_POST[$nov]);
                                
				if($hayreg>0){//ya existe registro del mes año y persona creado por tanto debe buscarse y actualizar con la novedad
					$sql3="UPDATE `controlturnos` SET `$cturno$fecha[mday]` = '$_POST[$nov]', `cod$fecha[mday]`='$codclif', `reg$fecha[mday]`='$_SESSION[usuariow]' WHERE `controlturnos`.`id` = '$idcontrol' LIMIT 1";
				}else{//si no existe crear registro de mes persona y año dado junto con la novedad
					$sql3="INSERT INTO controlturnos (`fecharegistro`, `cedulacontrol`, `mescontrol`, `$cturno$fecha[mday]`, `cod$fecha[mday]`, `reg$fecha[mday]` ) VALUES (NOW(), '$cedulanov[$i]', '$fecha[month]$fecha[year]', '$_POST[$nov]', '$codclif', '$_SESSION[usuariow]') ";
				}
				try{
                                $resultcons=@mysql_query($sql3) or $mens.=@mysql_error();
				}catch(Exception $err){

				}
			}
		}
    break;
}

$sql="SELECT codigo FROM clientes WHERE id='$_SESSION[clientemod]'";
$res=@mysql_query($sql);
$codigo=@mysql_result($res, 0, "codigo");

$mostra[1]="codigo";
$mostra[2]="nombrecliente";
$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("clientes","codigo","%",$mostra,$codigo,2,"codigo",$otras);

$r=@require('version.php');
caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#8CA8FB";
?>
<link	rel="stylesheet" href="estilo2.css" type="text/css"/>
<link	rel="stylesheet" href="botones.css" type="text/css"/>

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

<script type="text/javascript" src="ext/examples/form/busquedaAjaxPersonal.js"></script>
<script type="text/javascript">
<?php    echo "var codclie34='$codigo';"; ?>
</script>
<?php //pasar variables a javascript
if($numfilas!=""){	
echo "<script type=\"text/javascript\">";
echo "var matrizced=new Array($matrizced)";
echo "</script>";}else{
echo "<script type=\"text/javascript\">";
echo "var matrizced=new Array();";
echo "</script>";
}
if($cturno=="d"){echo "<script type=\"text/javascript\">var turno=\"persond\"</script>";}else if($cturno=="n"){echo "<script type=\"text/javascript\">var turno=\"personn\"</script>";}
?>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<form method="post" action="radioperacion.php"
	onsubmit="return validaradiop(boolvalidar);" name="radioperacion"  id="radioperacion">
<table class="tablaprinc">
	<tr>
		<td>
		<table>
			<tr>
				<th>Cliente</th>
				<td>Personal Diurno</td>
				<td>Personal Nocturno</td>
			</tr>
			<tr>
				<td align="center"><?php echo $cliente;?></td>
				<td align="center"><input name="persond" id="persond" class="corto" disabled="disabled" value="<?php echo $personald;?>"/></td>
				<td align="center"><input name="personn" id="personn" class="corto" disabled="disabled" value="<?php echo $personaln;?>"/></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<table class="tablaprinc" align="center" width="55%">
        <tr><td>
            <?php if($clierelevante==0 && $_SESSION[clientemod]!=""){echo '<a href="#" id="mostrardiv">Agregar Personal</a>';}?>
                
            <div style="width:500px;display:none;" id="ocultarmostrar">
            <div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>
            <div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
                <input type="text" name="search" id="search" style="width:10px"/>
                <div style="padding-top:4px;">
                    mínimo 4 caracteres.
                </div>
            </div></div></div>
            <div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
            </div>
        </td></tr>
	<tr>
		<td>
		<table cellpadding="0" border="0" id="tablaparagregar"
			width="100%" align="center">
                    
			<tr>
				<td align="left" valign="middle" width="15%">C.C.</td>
				<td align="left" width="55%" valign="middle">Apellidos y Nombres</td>
				<!-- Col 1 -->
				<td width="10%" valign="middle" align="left">Se reporto</td>
				<td width="5%">Codigo</td>
				<td>Novedad</td>
			</tr>
			<?php echo $chorrero;?>
		</table>
		</td>
	</tr>
</table>
<div id="controlex">
<table class="control">
	<tr>
		<td colspan="2" class="arriba">
			Radioperaci&oacute;n</td>
	</tr>
	<tr valign="top">
		<td valign="middle" colspa="2" align="center"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><select name="codcli" class="largo2">
			<option></option>
			<?php echo $cadena;?>
		</select></td>
	</tr>
	<tr>
		<td colspan="2" align="center"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
                <input type="submit" class="botoing" value="Ingresar" <?php if($activar!=1){echo "disabled=\"disabled\"";}?> name="ejecut"
			id="ejecut" onmousedown="boolvalidar=true;"
			onkeydown="boolvalidar=true;"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"></td>
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


