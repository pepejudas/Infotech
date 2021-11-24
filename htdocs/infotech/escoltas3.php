<?php
/*
 * Created on 22/04/2007
 * ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 43);
	
	formularioactual();

	$sql1="SELECT * FROM clientes WHERE clientes . activo = '1'  AND clientescolta='1' AND clierelevante='0' ORDER BY codigo";
	$resultaclie=@mysql_query($sql1);
	$reg=0;
	$lim=@mysql_num_rows($resultaclie);

while ($reg < $lim){
					if (@mysql_result($resultaclie,$reg,"codigo")==$_SESSION[clientemod]){
					$cadena1 = $cadena1 . '<option selected>'. mysql_result($resultaclie,$reg,codigo)." " . mysql_result($resultaclie,$reg,nombrecliente) . "</option>";
					}else{
					$cadena1=$cadena1."<option>". mysql_result($resultaclie,$reg,codigo)." ".mysql_result($resultaclie,$reg,nombrecliente). "</option>";
					}$reg++;
		
}

switch($_POST[ejecut]){
case "Consultar":
		
		if($_POST[mostrar]=="servicio"){
		$_SESSION[escb]="servicio";	
		$sql="SELECT * FROM `escoltas` WHERE `fechafinal` IS NULL ORDER BY cedula";
		$cons=@mysql_query($sql);
		$vector=@mysql_fetch_array($cons);
		$lim=@mysql_num_rows($cons);
		$cont=0;	
	
			while($cont < $lim){
		
			$ced=@mysql_result($cons,$cont,cedula);
			$clie=@mysql_result($cons,$cont,codigo);
			$fechaini=@mysql_result($cons,$cont,fechainicio);
			$sql1="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$ced ";
			$cons1=@mysql_query($sql1);
			$vector1=@mysql_fetch_array($cons1);
			$cnt=$cont+1;
			$cadena.="<tr><td align=center>$vector1[cedula]</td><td>$vector1[apellidos] $vector1[nombre]</td><td>$clie</td><td>$fechaini</td><td>"."<input type=checkbox name=$cnt></td></tr>";
				
			$cont++;
			}
		}else{
		$_SESSION[escb]="disponibles";
		$sql="SELECT cedula FROM personalactivo LEFT JOIN clientes ON personalactivo.codigo=clientes.codigo WHERE `clientes`.`clientescolta`='1' AND personalactivo.activo = 1 ORDER BY apellidos";
                //die($sql);
		$cons2=@mysql_query($sql);
		$vector2=@mysql_fetch_array($cons2);
		$lim=@mysql_num_rows($cons2);
		$cont=0;
	
	
	while($cont < $lim){
		
		$ced=@mysql_result($cons2,$cont,cedula);
		$sql1="SELECT * FROM escoltas WHERE `escoltas`.`fechafinal` IS NULL AND `escoltas`.`cedula`=$ced";
		$cons3=@mysql_query($sql1);
		$vector3=@mysql_fetch_array($cons3);
		if($vector3[cedula]==""){
		$sql3="SELECT * FROM personalactivo WHERE `personalactivo`.`cedula`=$ced";
		$cons4=@mysql_query($sql3);
		$vector4=@mysql_fetch_array($cons4);
		$cot=$cont+10000;	
		$cadena.="<tr><td align=center><a href=\"personalactivo3.php?ejecut=Buscar&criterio=".$vector4[cedula]."&campobusqueda=Cedula&opt=2'\">$vector4[cedula]</a></td><td>$vector4[apellidos] $vector4[nombre]</td><td><select name='$cont' style=WIDTH:100%>$cadena1</select></td><td></td><td align='center'><input type=checkbox name=$cot></td></tr>";
		}

		$cont++;
	}
	}
break;
case "Ingresar":

if($_SESSION[escb]=="disponibles"){
$sql4="SELECT cedula FROM personalactivo LEFT JOIN clientes ON personalactivo.codigo=clientes.codigo WHERE `clientes`.`clientescolta` = '1' AND personalactivo.activo = 1 ORDER BY apellidos";
$cons5=@mysql_query($sql4);
$ini=0;
$lim=@mysql_num_rows($cons5);
	
	while($ini<$lim){
	$ced=@mysql_result($cons5,$ini,cedula);
	$num=$ini+10000;
	$i=$ini;
	$cod=explode(" ",$_POST[$i]);
		if($_POST[$num]=="on"){
		$fecha=getdate(time());
		$hg=$fecha[month].$fecha[year];
		$sqli="INSERT INTO `escoltas` (`cedula` ,`mesreporte` ,`fechainicio`,`codigo`) VALUES ('$ced', '$hg', NOW(), '$cod[0]')";
		$consult=@mysql_query($sqli);
		}

	$ini++;	
	}

}else{
	$sqli2="SELECT * FROM `escoltas` WHERE `fechafinal` IS NULL ORDER BY cedula";
	$cons6=@mysql_query($sqli2);
	$ini=0;
	$lim=@mysql_num_rows($cons6);
	while($ini<$lim){
		$id=@mysql_result($cons6,$ini,id);
		$tiempo=@mysql_result($cons6,$ini,fechainicio);
		$num=$ini+1;
		
		if($_POST[$num]=="on"){
			
			$sqli="UPDATE `escoltas` SET `fechafinal` = NOW( ), `tiempototal`= TIMEDIFF( NOW( ) , '$tiempo' )  WHERE `escoltas`.`id` =$id LIMIT 1";
			$consult=@mysql_query($sqli);
		}
		$ini++;
	}
	
}
break;
}

$r=@require('version.php');
caracteresiso();
$colcuerpo="#FAFAFA";
$coltabla="#AA7F11";
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
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
 		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
	 		<td align="center"  width="10%">
	 		Cedula:
	 		</td>
     		<td align="left" width="40%">
	 		Apellidos y Nombres
      		</td>
	 		<td  align="center" width="10%">
	 		Codigo del cliente	
		  	</td>
		  	<td align="center">
		  	<?php if($_POST[mostrar]=="servicio"){
		  	echo "Fecha de inicio del servicio";
		  	}?>
		  	</td>
                        <td  width="10%">
		  	Reportar inicio de servicio
		  	</td>
		  	<td  width="10%">
		  	Reportar final de servicio
		  	</td>
     	</tr>
		     	
     	<?php echo $cadena;?>
		
   		</table>
     		
     		</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Escoltas
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle" colspan="2" align="center">
 			<input type="submit" class="botobusca" value="Consultar" name="ejecut">
 			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
 	 		<select name="mostrar"  class="largo2">
				<option value="servicio" <?php if($_SESSION[escb]=="servicio"){echo 'selected=""';}?>>Personal en servicio</option>
				<option value="disponibles" <?php if($_SESSION[escb]=="disponibles"){echo 'selected=""';}?>>Personal disponible</option>
			</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoing" value="Ingresar" name="ejecut">
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
