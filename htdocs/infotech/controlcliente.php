<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 41);
	
$fecha=getdate(time());
$ano=$fecha[year];
$ano1=$ano-1;
$ano2=$ano-2;
$ano3=$ano-3;

$_SESSION[veret1]=$_POST[veret1];
$_SESSION[veret2]=$_POST[veret2];

switch($_POST[ejecut]){
case "Buscar":
	
if($_POST[cedpersona]!=""){	
	//busqueda de datos del cliente
	$_SESSION[clientemod2]=$_POST[cedpersona];
	$_SESSION[mesbuscas]=$_POST[mesbusca];
	$_SESSION[anobuscas]=$_POST[anobusca];
	$datos2[campobusqueda]="codigo";
	$datos2[crito]=$_POST[cedpersona];
	$datos2[opcion]="";
	$datos2[claveprinc]="codigo";
	$datos2[otraconsulta]="";
			
	$result2=operaciones("clientes","buscar",$datos2);
	$result=$result2[datos];
	
	if($_SESSION[veret1]==1 or $_SESSION[veret1]==""){
		//solo personal activo
	$datos[campobusqueda]="codigo";
	$datos[crito]=$_POST[cedpersona];
	$datos[opcion]="";
	$datos[orden]="apellidos";
	$datos[claveprinc]="cedula";
	$datos[otraconsulta]="AND personalactivo.activo = 1 AND personalactivo.cedula LIKE controlturnos.cedulacontrol
	AND (
	controlturnos.cod1 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod2 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod3 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod4 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod5 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod6 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod7 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod8 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod9 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod10 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod11 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod12 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod13 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod14 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod15 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod16 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod17 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod18 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod19 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod20 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod21 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod22 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod23 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod24 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod25 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod26 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod27 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod28 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod29 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod30 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod31 LIKE '$_SESSION[clientemod2]')
	AND controlturnos.mescontrol LIKE '$_SESSION[mesbuscas]$_SESSION[anobuscas]'
	";
			
	$resultado2=operaciones("personalactivo, controlturnos","buscar",$datos);
	$resultado=$resultado2[datos];
	
	}else{
		//todo el personal
	$datos[campobusqueda]="codigo";
	$datos[crito]=$_POST[cedpersona];;
	$datos[opcion]="";
	$datos[orden]="apellidos";
	$datos[claveprinc]="cedula";
	$datos[otraconsulta]="AND personalactivo.cedula LIKE controlturnos.cedulacontrol
	AND (
	controlturnos.cod1 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod2 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod3 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod4 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod5 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod6 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod7 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod8 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod9 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod10 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod11 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod12 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod13 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod14 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod15 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod16 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod17 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod18 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod19 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod20 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod21 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod22 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod23 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod24 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod25 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod26 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod27 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod28 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod29 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod30 LIKE '$_SESSION[clientemod2]' OR
	controlturnos.cod31 LIKE '$_SESSION[clientemod2]')
	AND controlturnos.mescontrol LIKE '$_SESSION[mesbuscas]$_SESSION[anobuscas]' 
	";
	$resultado2=operaciones("personalactivo, controlturnos","buscar",$datos);
	$resultado=$resultado2[datos];	
	
	}
	
	//listado de personas a modificar turnos
	$mesbuscar=$_SESSION[mesbuscas].$_SESSION[anobuscas];
	for ($cont=0; $cont<$_SESSION[numreg]; $cont++){

	$cedula=@mysql_result($resultado,$cont,cedula);
	$nombre=@mysql_result($resultado,$cont,apellidos)." ".@mysql_result($resultado,$cont,nombre);
	
	//realizar busqueda de turnos
	$vector[cedula]=$cedula;
	$vector[mesbuscar]=$mesbuscar;
	$vector[clientebusca]=$_SESSION[clientemod2];
	
	$_SESSION["datov".$cedula]=$datosvector=consulturno($vector);
	
	$cad1="";
	$cad2="";
	
		for ($contar=0; $contar<68; $contar++){
			$contare=$contar-1;
			$contare2=$contar-34;
			$diab="d$contare";
			$nocb="n$contare2";
			
			$cad1=selectturno($vector[cedula],"$_SESSION[anobuscas]","$_SESSION[mesbuscas]",$contare,"d","$_SESSION[clientemod2]","$vector[cedula]");
			$cad2=selectturno($vector[cedula],"$_SESSION[anobuscas]","$_SESSION[mesbuscas]",$contare2,"n","$_SESSION[clientemod2]","$vector[cedula]");
			
			switch ($contar){
				case "0";
				$chorrerod.="<tr><td align='center' width='70px'>$cedula</td>";
				break;
				case "1":
				$chorrerod.="<td align='left' width='200px'>$nombre</td>";	
				break;
				case "2":
				case "3":
				case "4":
				case "5":
				case "6":
				case "7":
				case "8":
				case "9":
				case "10":
				case "11":
				case "12":
				case "13":
				case "14":
				case "15":
				case "16":
				case "17":
				case "18":
				case "19":
				case "20":
				case "21":
				case "22":
				case "23":
				case "24":
				case "25":
				case "26":
				case "27":
				case "28":
				case "29":
				case "30":
				case "31":
				$chorrerod.="<td align='left' width='12px'>$cad1</td>";
				break;
				case "32":
				$chorrerod.="<td align='left' width='12px'>$cad1</td></tr>";	
				break;
				case "33";
				case "34";
				$chorrerod.="<td align='left' class='lsup' width='12px'></td>";
				break;
				case "35";
				case "36";
				case "37":
				case "38":
				case "39":
				case "40":
				case "41":
				case "42":
				case "43":
				case "44":
				case "45":
				case "46":
				case "47":
				case "48":
				case "49":
				case "50":
				case "51":
				case "52":
				case "53":
				case "54":
				case "55":
				case "56":
				case "57":
				case "58":
				case "59":
				case "60":
				case "61":
				case "62":
				case "63":
				case "64":
				$chorrerod.="<td align='left' class='lsup'  width='12px'>$cad2</td>";
				break;
				case "65":
				$chorrerod.="<td align='left' class='lsup'  width='12px'>$cad2</td></tr>";
				break;
			}
		}
	}
}
break;
case "Corregir":

	$resultado2=operaciones("personalactivo, controlturnos","buscar",$_SESSION[datos]);
	$resultado=$resultado2[datos];
	
	
	for($ocont=0;$ocont<$_SESSION[numreg];$ocont++){
	$cedula=mysql_result($resultado,$ocont,cedula);
	$idconm=mysql_result($resultado,$ocont,id);
	
		for($cond=1;$cond<32;$cond++){
		$posd=$cedula."d".$cond;
		$posn=$cedula."n".$cond;	
			if($_SESSION["datov".$cedula][d.$cond]!=$_POST[$posd]){
				
				if($_POST[$posd]!="" or $_POST[$posn]!=""){$cliente="'".$_SESSION[clientemod2]."'";$modific="'".$_SESSION[persona]."'";}else{$cliente='NULL';$modific='NULL';}
					
			$senten1="UPDATE `controlturnos` SET `d$cond` = '$_POST[$posd]', `cod$cond` = $cliente,  `reg$cond` = $modific WHERE controlturnos.id ='$idconm'";
			$sql8="INSERT INTO `registrodemodificaciones` (fecha, cambio, hechopor, cedulamodificada) VALUES (NOW(), 'correccion turnos', '$_SESSION[persona]', '$cedula')";
			$cons3=@mysql_query($senten1);
			$cons4=@mysql_query($sql8);
			}
			if($_SESSION["datov".$cedula][n.$cond]!=$_POST[$posn]){
				
				if($_POST[$posd]!="" or $_POST[$posn]!=""){$cliente="'".$_SESSION[clientemod2]."'";$modific="'".$_SESSION[persona]."'";}else{$cliente='NULL';$modific='NULL';}
				
			$senten2="UPDATE `controlturnos` SET `n$cond` = '$_POST[$posn]', `cod$cond` = $cliente, `reg$cond` = $modific WHERE controlturnos.id ='$idconm'";
			$sql9="INSERT INTO `registrodemodificaciones` (fecha, cambio, hechopor, cedulamodificada) VALUES (NOW(), 'correccion turnos', '$_SESSION[persona]', '$cedula')";
			$cons5=@mysql_query($senten2);
			$cons6=@mysql_query($sql9);
			}
		}
	}

break;
}
	
$mostra[1]="codigo";
$mostra[2]="nombrecliente";

if($_SESSION[veret2]==1 or $_SESSION[veret2]==""){
	$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]' AND `clientes`.`clierelevante`='0'";	//clientes activos
	}else{
	$otras="AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]' AND `clientes`.`clierelevante`='0'";																	//todos los cientes
}
	
$cadena=selection("clientes","codigo","%",$mostra,$_SESSION[clientemod2],2,"codigo",$otras);

		$r=@require('version.php');
		caracteresiso();	
				
		$colcuerpo="#FAFAFA";
		$coltabla="#DEDEbb";
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

<script language="JavaScript" type="text/JavaScript">
<!--
function cerrarventana(){
var ventana = window.close();
}
//-->
Ext.onReady(function(){
        // create the grid
        var grid = new Ext.grid.TableGrid("the-table", {
            stripeRows: true // stripe alternate rows
        });
        grid.render();
});
</script>
<script language="JavaScript" type="text/JavaScript">
	<!--
function ventana(){
window.open('novedadescontrol.php','Novedades del personal','width=1712px,height=350px,top=900,left=0');

}
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
	<!--
function ventana(){
window.open('novedadescontrol2.php','Novedades del personal','width=1712px,height=350px,top=900,left=0');

}
//-->
</script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<form method="post" action="<?php echo $PHP_SELF?>">
 		<table class="tablaprinc" ><tr><td>
		<table>
		<tr>
			<td>
			C&oacute;digo
			</td>
			<td>
			Nombre del Cliente
			</td>
			<td>
			Admnistrador(a)
			</td>
			<td>
			Tel&eacute;fono
			</td>
		</tr>
		<tr>
			<td>
                        <input class="medio" readonly
			  	value="<?php
				if (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"codigo");}
			 	?>" name="cedula">
			</td>
			<td>
				<input class="extralargo" readonly
			  	value="<?php
				if (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"nombrecliente");}
			 	?>" name="puesto">
			</td>
			<td>
				<input class="extralargo" tabindex="3" readonly
			 	value="<?php
			 	if (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"nombreadministrador");}
			 	?>" name="nombre">
			</td>
			<td>
				<input class="medio" tabindex="13" readonly 
				name="telefono" value="<?php
			 	if ($_SESSION['telefonoa']!=""){
			  	echo $_SESSION[telefonoa];
			  	}elseif (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono");}  ?>">
      			</td>
		</tr>
		</table>
		
		</td></tr></table>
	
	<table class="tablaprinc">
	<tr><td>
		<table id="the-table">
		<tr>
			<td align="center" width="70px">
			Documento
			</td>
			<td align="center" width="200px">
			Nombre
			</td>
			<td align="center">
			1
			</td>
			<td align="center">
			2
			</td>
			<td align="center">
			3
			</td>
			<td align="center">
			4
			</td>
			<td align="center">
			5
			</td>
			<td align="center">
			6
			</td>
			<td align="center">
			7
			</td>
			<td align="center">
			8
			</td>
			<td align="center">
			9
			</td>
			<td align="center">
			10
			</td>
			<td align="center">
			11
			</td>
			<td align="center">
			12
			</td>
			<td align="center">
			13
			</td>
			<td align="center">
			14
			</td>
			<td align="center">
			15
			</td>
			<td align="center">
			16
			</td>
			<td align="center">
			17
			</td>
			<td align="center">
			18
			</td>
			<td align="center">
			19
			</td>
			<td align="center">
			20
			</td>
			<td align="center">
			21
			</td>
			<td align="center">
			22
			</td>
			<td align="center">
			23
			</td>
			<td align="center">
			24
			</td>
			<td align="center">
			25
			</td>
			<td align="center">
			26
			</td>
			<td align="center">
			27
			</td>
			<td align="center">
			28
			</td>
			<td align="center">
			29
			</td>
			<td align="center">
			30
			</td>
			<td align="center">
			31
			</td>
		</tr>
		
		<?php
//aqui va el listado de personas con sus respectivos turnos
		print($chorrerod);
		?>
		
		</table>
		
	</td></tr>
	</table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Control de Servicios por Cliente
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"></td>
                </tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="cedpersona" class="largo2">
			<option value=""></option>
 	 		<?php echo $cadena;?>
 	 		</select><br/>
 	 		<select name="anobusca" class="corto2">
  	 		<option value="<?php echo $ano;?>"<?php if($_SESSION[anotriple]==$ano) { echo 'selected=""';}?>><?php echo "".$ano."";?></option>
			<option value="<?php echo $ano1;?>"<?php if($_SESSION[anotriple]==$ano1) { echo 'selected=""';}?>><?php echo "".$ano1."";?></option>
			<option value="<?php echo $ano2;?>"<?php if($_SESSION[anotriple]==$ano2) { echo 'selected=""';}?>><?php echo "".$ano2."";?></option>
			<option value="<?php echo $ano3;?>"<?php if($_SESSION[anotriple]==$ano3) { echo 'selected=""';}?>><?php echo "".$ano3."";?></option>
			</select>
			<select name="mesbusca" class="medio2">
  	 		<option value="January" <?php if($_SESSION[mesbuscas]=="January") { echo 'selected=""';}?>>Enero</option>
			<option value="February" <?php if($_SESSION[mesbuscas]=="February") { echo 'selected=""';}?>>Febrero</option>
			<option value="March" <?php if($_SESSION[mesbuscas]=="March") { echo 'selected=""';}?>>Marzo</option>
			<option value="April" <?php if($_SESSION[mesbuscas]=="April") { echo 'selected=""';}?>>Abril</option>
			<option value="May" <?php if($_SESSION[mesbuscas]=="May") { echo 'selected=""';}?>>Mayo</option>
			<option value="June" <?php if($_SESSION[mesbuscas]=="June") { echo 'selected=""';}?>>Junio</option>
			<option value="July" <?php if($_SESSION[mesbuscas]=="July") { echo 'selected=""';}?>>Julio</option>
			<option value="August" <?php if($_SESSION[mesbuscas]=="August") { echo 'selected=""';}?>>Agosto</option>
			<option value="September" <?php if($_SESSION[mesbuscas]=="September") { echo 'selected=""';}?>>Septiembre</option>
			<option value="October" <?php if($_SESSION[mesbuscas]=="October") { echo 'selected=""';}?>>Octubre</option>
			<option value="November" <?php if($_SESSION[mesbuscas]=="November") { echo 'selected=""';}?>>Noviembre</option>
			<option value="December" <?php if($_SESSION[mesbuscas]=="December") { echo 'selected=""';}?>>Diciembre</option>
 	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<p align="left" style="line-height:1px;margin-left:50px">
			<input name="veret1" type="radio" value="1" <?php if($_SESSION[veret1]==1 or $_SESSION[veret1]==""){echo "checked";} ?>>Solo Personal Activo<br>
			<input name="veret1" type="radio" value="2" <?php if($_SESSION[veret1]==2){echo "checked";} ?>>Todo el Personal
			<p align="left" style="line-height:1px;margin-left:50px">
			<input name="veret2" type="radio" value="1" <?php if($_SESSION[veret2]==1 or $_SESSION[veret2]==""){echo "checked";} ?>>Solo Clientes Activos<br>
			<input name="veret2" type="radio" value="2" <?php if($_SESSION[veret2]==2){echo "checked";} ?>>Todos los Clientes<br>
			</p>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botocorre" name="ejecut" value="Corregir" <?php if($_SESSION[clientemod]==""){echo "disabled";}?>>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="button" class="botnovcli" name="ejecut" value="Ver Novedades" onclick="ventana()" <?php if($_SESSION[clientemod2]==""){echo "disabled";}?>>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
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
