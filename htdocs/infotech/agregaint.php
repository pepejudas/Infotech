<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

$link=validar("","","", 59);

	formularioactual();
	
	switch($_POST[ejecut]){
	case "ingresar":

		$sql1="SELECT * FROM productos ORDER BY nombreprod";
		$cons=@mysql_query($sql1);
		$ini=0;
		$limi=@mysql_num_rows($cons);
		
	for($ini=0;$ini<$limi;$ini++){
		
	$pdo=@mysql_result($cons,$ini,nombreprod);
	$pdrf=@mysql_result($cons,$ini,referencia);
	$idp=@mysql_result($cons,$ini,id);
	$entregadonou=$_POST[nou.$idp];
	
	$pdo2=str_replace(" ","_",$pdo);
	$pdo3=str_replace(".","_",$pdo2);
	
	$entregado=$_POST[$pdo3];
	
		if($entregado>0 && $entregadonou!=""){
			
		$sqlin2="INSERT INTO dotanecesidad (idprod, idoferta, cantidad, nou) VALUES ('$idp', '$_SESSION[clientemod]', '$entregado', '$entregadonou')";
		@mysql_query($sqlin2);
		}
	}	
		
	break;
	}
	
	
		$sql1="SELECT * FROM productos ORDER BY nombreprod";
		$cons=@mysql_query($sql1);
		$ini=0;
		$limi=@mysql_num_rows($cons);
		$r=@require('version.php');
		caracteresiso();
	?>
<html>
<head>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
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
</script>
</head>
<body>
<br>

<form method="post" action="agregaint.php" name="agregaint">
<center>
<table class="tablaprincpq">
	 		<?php
	 		while($limi>$ini){
	 		if(@mysql_result($cons,$ini,nombreprod)!=""){
	 		$prod=	@mysql_result($cons,$ini,nombreprod);
	 		$n=@mysql_result($cons,$ini,id);
	 		
	 		$vec[idproducto]=$n;$vec[nuevousado]=1;$saldo1=consultarsaldo($vec, $link);$vec2[idproducto]=$n;$vec2[nuevousado]=2;$saldo2=consultarsaldo($vec2, $link);
	 		
	 		$c=@mysql_result($cons,$ini,id);
	 		echo "<tr><td align=\"right\"><b>$prod: ($saldo1, $saldo2)* </b></td>".'<td><input style="width:20px;height:10px" tabindex=2 name="'.$prod.'">'.'&nbsp;<select name="'.nou.$n.'"><option value=""></option><option value="1">Nuevo</option><option value="2">Usado</option></select><br>';}
	 		echo "</td></tr>";
	 		$ini++;
	 		}
	 		?>			
     		<tr>
  			<td align="right"><b>Agregar:</b></td>
     		<td align="left" valign="top">
	 		<input type="submit" class="botoing" value="ingresar" name="ejecut">
      		</td>
			</tr>
			<tr>
  			<td align="center" colspan="2">*No influye en el almacen</td>
			</tr>
			</table>
			</center>
			</form>
	 		<center><input type="submit" class="botcerrar"  value="Cerrar" name="ejecut" onclick="cerrarventana();"/></center>
	 		
</body>
</html>
     	<?php 
@mysql_free_result($result);
@mysql_close($link);
/*
while (list($name, $value) = each($HTTP_POST_VARS)) { echo " POST $name = $value<br>\n";
}

while (list($name, $value) = each($HTTP_SESSION_VARS)) { echo "SESSION $name = $value<br>\n";
}*/
?>