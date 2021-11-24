<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 40);

$fecha=getdate(time());
$ano=$fecha[year];
$ano1=$ano-1;
$ano2=$ano-2;
$ano3=$ano-3;

$_SESSION[veret0]=$_POST[veret1];
$_SESSION[veret]=$_POST[veret2];

$_SESSION['i']=0;

formularioactual();

switch($_POST[ejecut]):
case "Buscar":
			$_SESSION['i']=0;
			$_SESSION[cedulamod]=$_POST[cedpersona];
			$sql2="SELECT codigo, nombre, apellidos, telefono, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$_SESSION[cedulamod]'";
			$result=mysql_query($sql2) or $mens=@mysql_error();
			$_SESSION[mes]=$_POST[mesbusca];
			$_SESSION[anotriple]=$_POST[anobusca];
			$_SESSION[cod]=@mysql_result($result,0,codigo);
			$sql3="SELECT * FROM controlturnos WHERE `controlturnos`. `cedulacontrol` = '$_SESSION[cedulamod]' and `controlturnos`.`mescontrol` LIKE '$_SESSION[mes]$_SESSION[anotriple]'";
			$resultado=mysql_query($sql3) or $mens=@mysql_error();
			$_SESSION[idcontrol]=@mysql_result($resultado,0,id);
			$boton=1;
break;

case "Corregir":

function verificar($a){
	$dd="d".$a;
	$nn="n".$a;
	$ss="select".$a;
	$turn='$turno'.$a;
	$turnn='$turnon'.$a;
	$codig='$codigo'.$a;
	$ingres='$ingresa'.$a;
	if($_POST[$dd]=="" or $_POST[$dd]=="0"){
		$turn='NULL';
		$codig="NULL";
		$ingres="";
	}else{
	$turn="'".$_POST[$dd]."'";	
	if($_POST[$ss]!=""){
	
	$codig="'".$_POST[$ss]."'";
	$ingres=selectpers($_SESSION[cedulamod],$_SESSION[anotriple],$_SESSION[mes],$a,"d",$_POST[$dd]);
	
	}else{
		$codig="'".$_SESSION[cod]."'";
		$ingres=$_SESSION[usuariow];
		}
	}
	
	if($_POST[$nn]=="" or $_POST[$nn]=="0"){
		$turnn='NULL';
		if($codig!=""){}else{$codig="";}
		if($ingres!=""){}else{$ingres="";}	
	}else{
	$turnn="'".$_POST[$nn]."'";	
	if($_POST[$ss]!=""){
	
	$codig="'".$_POST[$ss]."'";
	$ingres=selectpers($_SESSION[cedulamod],$_SESSION[anotriple],$_SESSION[mes],$a,"n",$_POST[$nn]);
	
	}else{
	$codig="'".$_SESSION[cod]."'";
	$ingres=$_SESSION[usuariow];
		if($codig!=""){}else{$codig="";}
		if($ingres!=""){}else{$ingres="";}
	}
	}
	
$vector[turno]=$turn;
$vector[turnon]=$turnn;
$vector[codigo]=$codig;
$vector[ingresa]=$ingres;
return $vector;
}

$dia1=verificar(1);
$dia2=verificar(2);
$dia3=verificar(3);
$dia4=verificar(4);
$dia5=verificar(5);
$dia6=verificar(6);
$dia7=verificar(7);
$dia8=verificar(8);
$dia9=verificar(9);
$dia10=verificar(10);
$dia11=verificar(11);
$dia12=verificar(12);
$dia13=verificar(13);
$dia14=verificar(14);
$dia15=verificar(15);
$dia16=verificar(16);
$dia17=verificar(17);
$dia18=verificar(18);
$dia19=verificar(19);
$dia20=verificar(20);
$dia21=verificar(21);
$dia22=verificar(22);
$dia23=verificar(23);
$dia24=verificar(24);
$dia25=verificar(25);
$dia26=verificar(26);
$dia27=verificar(27);
$dia28=verificar(28);
$dia29=verificar(29);
$dia30=verificar(30);
$dia31=verificar(31);

$sql7 = "SELECT * FROM `controlturnos` WHERE `controlturnos`.`mescontrol` = '$_POST[mesbusca]$_POST[anobusca]' and `controlturnos`.`cedulacontrol` = '$_POST[cedula]'";
$cons1=mysql_query($sql7) or $mens=@mysql_error();
$cedu= $_POST[cedpersona];

if($_POST[cedula]!="inserte" and $cedu==$_POST[cedula]){
if(@mysql_result($cons1,0,cedulacontrol)!=""){
$idr=mysql_result($cons1, 0, id);	
$sql6="UPDATE `controlturnos` SET `d1`=$dia1[turno], `d2`=$dia2[turno], `d3`=$dia3[turno], `d4`=$dia4[turno], `d5`=$dia5[turno], `d6`=$dia6[turno], `d7`=$dia7[turno], `d8`=$dia8[turno], `d9`=$dia9[turno], `d10`=$dia10[turno], `d11`=$dia11[turno], `d12`=$dia12[turno], `d13`=$dia13[turno], `d14`=$dia14[turno], `d15`=$dia15[turno],`d16`=$dia16[turno], `d17`=$dia17[turno], `d18`=$dia18[turno], `d19`=$dia19[turno], `d20`=$dia20[turno], `d21`=$dia21[turno], `d22`=$dia22[turno], `d23`=$dia23[turno], `d24`=$dia24[turno], `d25`=$dia25[turno], `d26`=$dia26[turno], `d27`=$dia27[turno], `d28`=$dia28[turno], `d29`=$dia29[turno], `d30`=$dia30[turno], `d31`=$dia31[turno], `cod1`=$dia1[codigo], `cod2`=$dia2[codigo], `cod3`=$dia3[codigo], `cod4`=$dia4[codigo], `cod5`=$dia5[codigo], `cod6`=$dia6[codigo], `cod7`=$dia7[codigo], `cod8`=$dia8[codigo], `cod9`=$dia9[codigo], `cod10`=$dia10[codigo], `cod11`=$dia11[codigo], `cod12`=$dia12[codigo], `cod13`=$dia13[codigo], `cod14`=$dia14[codigo], `cod15`=$dia15[codigo],`cod16`=$dia16[codigo], `cod17`=$dia17[codigo], `cod18`=$dia18[codigo], `cod19`=$dia19[codigo], `cod20`=$dia20[codigo], `cod21`=$dia21[codigo], `cod22`=$dia22[codigo], `cod23`=$dia23[codigo], `cod24`=$dia24[codigo], `cod25`=$dia25[codigo], `cod26`=$dia26[codigo], `cod27`=$dia27[codigo], `cod28`=$dia28[codigo], `cod29`=$dia29[codigo], `cod30`=$dia30[codigo], `cod31`=$dia31[codigo], `reg1`='$dia1[ingresa]', `reg2`='$dia2[ingresa]', `reg3`='$dia3[ingresa]', `reg4`='$dia4[ingresa]', `reg5`='$dia5[ingresa]', `reg6`='$dia6[ingresa]', `reg7`='$dia7[ingresa]', `reg8`='$dia8[ingresa]', `reg9`='$dia9[ingresa]', `reg10`='$dia10[ingresa]', `reg11`='$dia11[ingresa]', `reg12`='$dia12[ingresa]', `reg13`='$dia13[ingresa]', `reg14`='$dia14[ingresa]', `reg15`='$dia15[ingresa]',`reg16`='$dia16[ingresa]', `reg17`='$dia17[ingresa]', `reg18`='$dia18[ingresa]', `reg19`='$dia19[ingresa]', `reg20`='$dia20[ingresa]', `reg21`='$dia21[ingresa]', `reg22`='$dia22[ingresa]', `reg23`='$dia23[ingresa]', `reg24`='$dia24[ingresa]', `reg25`='$dia25[ingresa]', `reg26`='$dia26[ingresa]', `reg27`='$dia27[ingresa]', `reg28`='$dia28[ingresa]', `reg29`='$dia29[ingresa]', `reg30`='$dia30[ingresa]', `reg31`='$dia31[ingresa]', `n1`=$dia1[turnon], `n2`=$dia2[turnon], `n3`=$dia3[turnon], `n4`=$dia4[turnon], `n5`=$dia5[turnon], `n6`=$dia6[turnon], `n7`=$dia7[turnon], `n8`=$dia8[turnon], `n9`=$dia9[turnon], `n10`=$dia10[turnon], `n11`=$dia11[turnon], `n12`=$dia12[turnon], `n13`=$dia13[turnon], `n14`=$dia14[turnon], `n15`=$dia15[turnon],`n16`=$dia16[turnon], `n17`=$dia17[turnon], `n18`=$dia18[turnon], `n19`=$dia19[turnon], `n20`=$dia20[turnon], `n21`=$dia21[turnon], `n22`=$dia22[turnon], `n23`=$dia23[turnon], `n24`=$dia24[turnon], `n25`=$dia25[turnon], `n26`=$dia26[turnon], `n27`=$dia27[turnon], `n28`=$dia28[turnon], `n29`=$dia29[turnon], `n30`=$dia30[turnon], `n31`=$dia31[turnon] WHERE `controlturnos`.`id` = $idr";
}else{
$sql6="INSERT INTO `controlturnos` (fecharegistro, cedulacontrol, mescontrol, d1, d2, d3, d4, d5, d6, d7, d8, d9, d10, d11, d12, d13, d14, d15, d16, d17, d18, d19, d20, d21, d22, d23, d24, d25, d26, d27, d28, d29, d30, d31, cod1, cod2, cod3, cod4, cod5, cod6, cod7, cod8, cod9, cod10, cod11, cod12, cod13, cod14, cod15, cod16, cod17, cod18, cod19, cod20, cod21, cod22, cod23, cod24, cod25, cod26, cod27, cod28, cod29, cod30, cod31, reg1, reg2, reg3, reg4, reg5, reg6, reg7, reg8, reg9, reg10, reg11, reg12, reg13, reg14, reg15, reg16, reg17, reg18, reg19, reg20, reg21, reg22, reg23, reg24, reg25, reg26, reg27, reg28, reg29, reg30, reg31, n1, n2, n3, n4, n5, n6, n7, n8, n9, n10, n11, n12, n13, n14, n15, n16, n17, n18, n19, n20, n21, n22, n23, n24, n25, n26, n27, n28, n29, n30, n31) VALUES (NOW(), '$_POST[cedula]', '$_POST[mesbusca]$_POST[anobusca]', $dia1[turno], $dia2[turno], $dia3[turno], $dia4[turno], $dia5[turno], $dia6[turno], $dia7[turno], $dia8[turno], $dia9[turno], $dia10[turno], $dia11[turno], $dia12[turno], $dia13[turno], $dia14[turno], $dia15[turno], $dia16[turno], $dia17[turno], $dia18[turno], $dia19[turno], $dia20[turno], $dia21[turno], $dia22[turno], $dia23[turno], $dia24[turno], $dia25[turno], $dia26[turno], $dia27[turno], $dia28[turno], $dia29[turno], $dia30[turno], $dia31[turno], $dia1[codigo], $dia2[codigo], $dia3[codigo], $dia4[codigo], $dia5[codigo], $dia6[codigo], $dia7[codigo], $dia8[codigo], $dia9[codigo], $dia10[codigo], $dia11[codigo], $dia12[codigo], $dia13[codigo], $dia14[codigo], $dia15[codigo], $dia16[codigo], $dia17[codigo], $dia18[codigo], $dia19[codigo], $dia20[codigo], $dia21[codigo], $dia22[codigo], $dia23[codigo], $dia24[codigo], $dia25[codigo], $dia26[codigo], $dia27[codigo], $dia28[codigo], $dia29[codigo], $dia30[codigo], $dia31[codigo], '$dia1[ingresa]', '$dia2[ingresa]', '$dia3[ingresa]', '$dia4[ingresa]', '$dia5[ingresa]', '$dia6[ingresa]', '$dia7[ingresa]', '$dia8[ingresa]', '$dia9[ingresa]', '$dia10[ingresa]', '$dia11[ingresa]', '$dia12[ingresa]', '$dia13[ingresa]', '$dia14[ingresa]', '$dia15[ingresa]', '$dia16[ingresa]', '$dia17[ingresa]', '$dia18[ingresa]', '$dia19[ingresa]', '$dia20[ingresa]', '$dia21[ingresa]', '$dia22[ingresa]', '$dia23[ingresa]', '$dia24[ingresa]', '$dia25[ingresa]', '$dia26[ingresa]', '$dia27[ingresa]', '$dia28[ingresa]', '$dia29[ingresa]', '$dia30[ingresa]', '$dia31[ingresa]', $dia1[turnon], $dia2[turnon], $dia3[turnon], $dia4[turnon], $dia5[turnon], $dia6[turnon], $dia7[turnon], $dia8[turnon], $dia9[turnon], $dia10[turnon], $dia11[turnon], $dia12[turnon], $dia13[turnon], $dia14[turnon], $dia15[turnon], $dia16[turnon], $dia17[turnon], $dia18[turnon], $dia19[turnon], $dia20[turnon], $dia21[turnon], $dia22[turnon], $dia23[turnon], $dia24[turnon], $dia25[turnon], $dia26[turnon], $dia27[turnon], $dia28[turnon], $dia29[turnon], $dia30[turnon], $dia31[turnon])";
}
$cons2=mysql_query($sql6) or $mens=@mysql_error();
$sql8="INSERT INTO `registrodemodificaciones` (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal) VALUES (NOW(), 'correccion turnos', '$_SESSION[usuariow]', '".addslashes($sql6)."', 'controlturnos', '$_SESSION[sucur]')";
$cons3=mysql_query($sql8) or $mens=@mysql_error();
$mensaje="corregido exitosamente";
}else{$mensaje="debe realizar una nueva busqueda";}
$_SESSION[mes]=$_POST[mesbusca];
$_SESSION[anotriple]=$_POST[anobusca];
$_SESSION['i']=0;
			$_SESSION[cedulamod]=$_POST[cedpersona];
			$sql2="SELECT codigo, nombre, apellidos, telefono, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$_SESSION[cedulamod]'";
			$result=mysql_query($sql2) or $mens=@mysql_error();
			$_SESSION[mes]=$_POST[mesbusca];
			$_SESSION[anotriple]=$_POST[anobusca];
			$_SESSION[cod]=@mysql_result($result,0,codigo);
			$sql3="SELECT * FROM controlturnos WHERE `controlturnos`. `cedulacontrol` = '$_SESSION[cedulamod]' and `controlturnos`.`mescontrol` LIKE '$_SESSION[mes]$_SESSION[anotriple]'";//falta meterle el and aqui
			$resultado=mysql_query($sql3) or $mens=@mysql_error();
			$_SESSION[idcontrol]=@mysql_result($resultado,0,id);
			$boton=1;
break;
case "Ver Novedades":
$_SESSION['i']=0;
			$_SESSION[cedulamod]=$_POST[cedpersona];
			$sql2="SELECT codigo, nombre, apellidos, telefono, cedula FROM personalactivo WHERE `personalactivo`.`cedula`='$_SESSION[cedulamod]'";
			$result=mysql_query($sql2) or $mens=@mysql_error();
			$_SESSION[mes]=$_POST[mesbusca];
			$_SESSION[anotriple]=$_POST[anobusca];
			$_SESSION[cod]=@mysql_result($result,0,codigo);
			$sql3="SELECT * FROM controlturnos WHERE `controlturnos`. `cedulacontrol` = '$_SESSION[cedulamod]' and `controlturnos`.`mescontrol` LIKE '$_SESSION[mes]$_SESSION[anotriple]'";//falta meterle el and aqui
			$resultado=mysql_query($sql3) or $mens=@mysql_error();
			$_SESSION[idcontrol]=@mysql_result($resultado,0,id);
			$boton=1;	
break;	
default:
$_SESSION[cedulamod]="";
$_SESSION[anotriple]=""; 
$_SESSION[mes]="";
break;	
endswitch;

$mostra[3]="cedula";
$mostra[1]="apellidos";
$mostra[2]="nombre";
if($_SESSION[veret0]=="2"){
$otras="AND personalactivo.sucursal LIKE '$_SESSION[sucur]'";}else{
$otras="AND personalactivo.sucursal LIKE '$_SESSION[sucur]' AND personalactivo.activo = 1";	
}
$cadena=selection("personalactivo","cedula","%",$mostra,$_SESSION[cedulamod],3,"apellidos",$otras);


if($_SESSION[veret]=="1"){
$todosclientes="";}else{
$todosclientes="AND clientes.activo = 1";	
}

			$sqql = "SELECT * FROM clientes WHERE clientes.sucursal LIKE '$_SESSION[sucur]' $todosclientes ORDER BY codigo ASC";
			$resultar= mysql_query($sqql) or $mens=@mysql_error();
			$ini=0;
			$fin=mysql_num_rows($resultar);	
		
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
function ventana(){
window.open('novedadescontrol.php','Novedades del personal','width=1712px,height=350px,top=900,left=0');
}
//-->
</script>
<script language="javascript" type="text/javascript" src="scripts/funciones.js"></script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<form method="post" action="<?php echo $PHP_SELF?>">
 		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
			<td>
			No de cedula
			</td>
			<td>
			Asignado a:
			</td>
			<td>
			Nombres y apellidos
			</td>
			<td>
			telefono
			</td>
		</tr>
		
		<tr>
			<td>
				<input class="medio" readonly
			  	value="<?php
				if ($_SESSION['cedulaa']!=""){
			  	echo $_SESSION[cedulaa];
			  	}elseif (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"cedula");}
			 	?>" name="cedula" id="cedula">
			</td>
			<td>
				<input class="medio" readonly
			  	value="<?php
				if ($_SESSION['puestoa']!=""){
			  	echo $_SESSION[puestoa];
			  	}elseif (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"codigo");}
			 	?>" name="puesto">
			</td>
			<td>
				<input class="extralargo" tabindex="3" readonly
			 	value="<?php
			 	if ($_SESSION['nombrea']!=""){
			  	echo $_SESSION[nombrea];
			  	}elseif (!$result){
			  	echo "inserte";}else{ echo @mysql_result($result,$_SESSION['i'],"apellidos")." ".@mysql_result($result,$_SESSION['i'],"nombre");}
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
		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
			<td align="center" width="13%">
			Dias
			</td>
			<td align="center" width="13%">
			Diurno
			</td>
			<td align="center" width="9%">
			Nocturno
			</td>
			<td align="center" width="40%">
			Codigos
			</td>
			<td align="center" >
			Ingres&oacute;
			</td>	
			</tr>
			<?php 
			$inict=1;
			$finct=31;
			for($inict=1;$inict<=$finct;$inict++){
			echo "<tr><td align=\"center\">
			$inict</td>
			<td align=\"center\">
			".selectturno($_SESSION[cedulamod], $_SESSION[anotriple], $_SESSION[mes], "$inict", "d")."<td>".selectturno($_SESSION[cedulamod], $_SESSION[anotriple], $_SESSION[mes], "$inict", "n").  
			"</td>
			<td align=\"center\">";

                        $sel="<select name=\"select$inict\"  class=\"largo1\"><option></option>";
                        
			while($ini<$fin){
					if(mysql_result($resultar,$ini,"clierelevante")!="1"){
						if (@mysql_result($resultado,0,"cod$inict")==mysql_result($resultar,$ini,codigo)){
					 	$sel.='<option selected="">'.mysql_result($resultar,$ini,codigo).'</option>';
						}else{
						$sel.='<option>'.mysql_result($resultar,$ini,codigo).'</option>';
						}
					}
				$ini++;
				}
                        $sel.="</select>";
                        
			$ini=0;		
			echo $sel."</td><td align=\"center\"><input style=\"width:1px;visibility:hidden\">";
			if($resultado){ 
				echo @mysql_result($resultado,$_SESSION['i'],"reg$inict");
			}
			echo "</td></tr>";
			}
			?>
		</table>
		
		</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Control de Servicios Individual
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle" align="center" colspan="2">
 			<input type="submit" class="botobusca" value="Buscar" name="ejecut">
 			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="cedpersona" class="largo2">
			<option value=""></option>
 	 		<?php echo $cadena;?>
 	 		</select><br/>
 	 		<select name="anobusca" class="corto2" id="anobusca">
  	 		<option value="<?php echo $ano;?>"<?php if($_SESSION[anotriple]==$ano) { echo 'selected=""';}?>><?php echo "".$ano."";?></option>
			<option value="<?php echo $ano1;?>"<?php if($_SESSION[anotriple]==$ano1) { echo 'selected=""';}?>><?php echo "".$ano1."";?></option>
			<option value="<?php echo $ano2;?>"<?php if($_SESSION[anotriple]==$ano2) { echo 'selected=""';}?>><?php echo "".$ano2."";?></option>
			<option value="<?php echo $ano3;?>"<?php if($_SESSION[anotriple]==$ano3) { echo 'selected=""';}?>><?php echo "".$ano3."";?></option>
			</select>
			<select name="mesbusca" class="medio2" id="mesbusca">
  	 		<option value="January" <?php if($_SESSION[mes]=="January") { echo 'selected=""';}?>>Enero</option>
			<option value="February" <?php if($_SESSION[mes]=="February") { echo 'selected=""';}?>>Febrero</option>
			<option value="March" <?php if($_SESSION[mes]=="March") { echo 'selected=""';}?>>Marzo</option>
			<option value="April" <?php if($_SESSION[mes]=="April") { echo 'selected=""';}?>>Abril</option>
			<option value="May" <?php if($_SESSION[mes]=="May") { echo 'selected=""';}?>>Mayo</option>
			<option value="June" <?php if($_SESSION[mes]=="June") { echo 'selected=""';}?>>Junio</option>
			<option value="July" <?php if($_SESSION[mes]=="July") { echo 'selected=""';}?>>Julio</option>
			<option value="August" <?php if($_SESSION[mes]=="August") { echo 'selected=""';}?>>Agosto</option>
			<option value="September" <?php if($_SESSION[mes]=="September") { echo 'selected=""';}?>>Septiembre</option>
			<option value="October" <?php if($_SESSION[mes]=="October") { echo 'selected=""';}?>>Octubre</option>
			<option value="November" <?php if($_SESSION[mes]=="November") { echo 'selected=""';}?>>Noviembre</option>
			<option value="December" <?php if($_SESSION[mes]=="December") { echo 'selected=""';}?>>Diciembre</option>
 	 		</select>
			</td></tr>
			<tr><td colspan="2" align="center">
			<p align="left" style="line-height:0px;margin-left:40px;">
			<input name="veret1" type="radio" value="1" <?php if($_SESSION[veret0]==1 or $_SESSION[veret0]==""){echo "checked";} ?>>Solo Personal Activo<br>
			<input name="veret1" type="radio" value="2" <?php if($_SESSION[veret0]==2){echo "checked";} ?>>Todo el Personal<br>
			<input name="veret2" type="radio" value="1" <?php if($_SESSION[veret]==1 or $_SESSION[veret]==""){echo "checked";} ?>>Todos los Clientes<br>
			<input name="veret2" type="radio" value="2" <?php if($_SESSION[veret]==2){echo "checked";} ?>>Solo Clientes Activos<br>
			</p>
			</td></tr>
			<tr><td colspan="2" align="center">
			<input type="submit" class="botocorre" name="ejecut" value="Corregir" <?php if(@mysql_result($result,$_SESSION['i'],"cedula")==""){echo "disabled=\"disabled\"";}?>/><br/>
			<input type="button" class="botovenov" name="ejecut" value="Ver Novedades" onclick="ventana()" <?php if(@mysql_result($result,$_SESSION['i'],"cedula")==""){echo "disabled=\"disabled\"";}?>/>
			</td></tr>
			<tr><td colspan="2" align="center">
			<select name="opcionturnos" id="opcionturnos"  class="corto2">
			<option value="1">Diurnos</option>
			<option value="2">Nocturnos</option>
			<option value="3">Todos</option>
			<option value="4">Ninguno</option>
                        </select>&nbsp;<input type="text" id="tdesde" style="width:20px;text-align:center" value="1">&nbsp;<input type="text" id="thasta" style="width:20px;text-align:center">
			<input type="button" value="Ver" id="botonver"/>
			</td></tr>
			<tr height="10px"></tr>
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
