<?php

/*
 * Created on 22/04/2007
 * ingeniero: Ferley Ardila Caicedo
 */

session_start();

@require('funciones2.php');

validar("","","", 38);

if($_POST['boton']=="Guardar para Todos"){

$_SESSION['paramprograma']['paratodos']="si"; //parametros para todos los clientes

for($inic=0;$inic<$_SESSION['paramprograma']['numclientes'];$inic++){	
	
	$pclientedatos=$_POST['cliente'];
	$pcliente0=$_SESSION['paramprograma']['clientes'][$inic];
	//obtener valores de variables de clientes
	for($in=0;$in<7;$in++){//dias seleccionados
		$cli='dia-'.($in+1)."-".$pclientedatos;
		
		if($_POST[$cli]=="on"){
		$_SESSION['paramprograma']["param-$pcliente0"]['dia-'.($in+1)]="si";
		}
	}
	
		$_SESSION['paramprograma']["param-$pcliente0"]['HDS']=$_POST["HDS-$pclientedatos"];
		$_SESSION['paramprograma']["param-$pcliente0"]['DT']=$_POST["DT-$pclientedatos"];
		$_SESSION['paramprograma']["param-$pcliente0"]['Numd']=$_POST["Numd-$pclientedatos"];
		$_SESSION['paramprograma']["param-$pcliente0"]['NumCT']=$_POST["NumCT-$pclientedatos"];
		$_SESSION['paramprograma']["param-$pcliente0"]['Prr']=$_POST["Prr-$pclientedatos"];

		$lim=ceil($_SESSION['paramprograma']["param-$pcliente0"]['HDS']/$_SESSION['paramprograma']["param-$pcliente0"]['DT']);
		
		$_SESSION['paramprograma']["param-$pcliente0"]['NT']=$lim;

		for($in=0;$in<$lim;$in++){//numero de personas por turno
		$nper='Npers-'.($in+1)."-$pclientedatos";
		$_SESSION['paramprograma']["param-$pcliente0"]['Npers-'.($in+1)]=$_POST[$nper];
		}
}

$script="function cerra(){window.close();}cerra();";
}elseif($_POST['boton']=="Guardar para Este"){
	
	$_SESSION['paramprograma']['paratodos']="no"; //parametros solo para este cliente

	$pcliente=$_POST['cliente'];
	//obtener valores de variables de clientes
	for($in=1;$in<8;$in++){//dias seleccionados
		$cli="dia-$in-$pcliente";
		if($_POST[$cli]=="on"){
		$_SESSION['paramprograma']["param-$pcliente"]["dia-$in"]="si";
		}
	}
	
		$_SESSION['paramprograma']["param-$pcliente"]['HDS']=$_POST["HDS-$pcliente"];
		$_SESSION['paramprograma']["param-$pcliente"]['DT']=$_POST["DT-$pcliente"];
		$_SESSION['paramprograma']["param-$pcliente"]['Numd']=$_POST["Numd-$pcliente"];
		$_SESSION['paramprograma']["param-$pcliente"]['NumCT']=$_POST["NumCT-$pcliente"];
		$_SESSION['paramprograma']["param-$pcliente"]['Prr']=$_POST["Prr-$pcliente"];
		
		$lim=ceil($_SESSION['paramprograma']["param-$pcliente"]['HDS']/$_SESSION['paramprograma']["param-$pcliente"]['DT']);
		
		$_SESSION['paramprograma']["param-$pcliente"]['NT']=$lim;

		for($in=0;$in<$lim;$in++){//numero de personas por turno
		$nper='Npers-'.($in+1)."-$pcliente";
		$_SESSION['paramprograma']["param-$pcliente"]['Npers-'.($in+1)]=$_POST[$nper];
		}
		
	$script="function cerra(){window.close();}cerra();";	
}else{
	$clieget=$_GET['cod'];
	
	for($ini=1;$ini<8;$ini++){//seleccionar dias de servicio establecidos
		$nombreVariable = "var$ini";
		if($_SESSION['paramprograma']["param-$clieget"]["dia-$ini"]=="si"){$$nombreVariable=" checked=\"checked\"";}
	}
		
	if(isset($_SESSION[paramprograma]["param-$clieget"]['HDS'])){//seleccion de HDS
		$nombreVariable = "HDS".$_SESSION[paramprograma]["param-$clieget"]['HDS'];
		$$nombreVariable=" selected=\"selected\"";
	}else{$HDS24=" selected=\"selected\"";}	//valor seleccionado por defecto
	
	if(isset($_SESSION[paramprograma]["param-$clieget"]['DT'])){//seleccion de DT
		$nombreVariable = "DT".$_SESSION[paramprograma]["param-$clieget"]['DT'];
		$$nombreVariable=" selected=\"selected\"";
	}else{$DT8=" selected=\"selected\"";}  //valor seleccionado por defecto

	if(isset($_SESSION[paramprograma]["param-$clieget"]['Numd'])){//seleccion de numero de descansos
		$nombreVariable = "Numd".$_SESSION[paramprograma]["param-$clieget"]['Numd'];
		$$nombreVariable=" selected=\"selected\"";
	}	
	
	if(isset($_SESSION[paramprograma]["param-$clieget"]['NumCT'])){//seleccion de Numero de cambios de turno
		$nombreVariable = "NumCT".$_SESSION[paramprograma]["param-$clieget"]['NumCT'];
		$$nombreVariable=" selected=\"selected\"";
	}	
	
	if(isset($_SESSION[paramprograma]["param-$clieget"]['Prr'])){//seleccion de Politica de relevos
		$nombreVariable = "Prr".$_SESSION[paramprograma]["param-$clieget"]['Prr'];
		$$nombreVariable=" selected=\"selected\"";
	}else{//seleccion por defecto
	$Prr5=" selected=\"selected\"";
	}
	
	if(isset($_SESSION[paramprograma]["param-$clieget"]['HDS'])){//seleccion de HDS
	$fin=ceil($_SESSION[paramprograma]["param-$clieget"]['HDS']/$_SESSION[paramprograma]["param-$clieget"]['DT']);
	for($ini=0;$ini<$fin;$ini++){	
	$perscontr.="<tr id=\"trremover$ini\"><td align=\"right\"><input name=\"Npers-".($ini+1)."-$clieget\" id=\"Npers-".($ini+1)."\" class=\"cortopeque\" value=\"".$_SESSION['paramprograma']["param-$clieget"]["Npers-".($ini+1)]."\"/></td><td>Personal Contratado Turno 1</td></tr>";
	}
	}else{
	$perscontr.="<tr id=\"trremover0\"><td align=\"right\"><input name=\"Npers-1-$clieget\" id=\"Npers-1\" class=\"cortopeque\"/></td><td>Personal Contratado Turno 1</td></tr>";
	$perscontr.="<tr id=\"trremover1\"><td align=\"right\"><input name=\"Npers-2-$clieget\" id=\"Npers-2\" class=\"cortopeque\"/></td><td>Personal Contratado Turno 2</td></tr>";
	$perscontr.="<tr id=\"trremover2\"><td align=\"right\"><input name=\"Npers-3-$clieget\" id=\"Npers-3\" class=\"cortopeque\"/></td><td>Personal Contratado Turno 3</td></tr>";	
	}
		
$contenido="<tr><td>Par&aacute;metros para el cliente:</td><td><input name=\"cliente\" value=\"$clieget\" readonly=\"readonly\"></td></tr>";
$contenido.="<tr><td>Dias de Servicio</td><td><input type=\"checkbox\" name=\"sel\" id=\"seltodo\" onclick=\"selecctodo(this);\">Todos los Dias</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-1-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-1\" $var1/></td><td>Lunes</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-2-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-2\" $var2/></td><td>Martes</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-3-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-3\" $var3/></td><td>Miercoles</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-4-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-4\" $var4/></td><td>Jueves</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-5-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-5\" $var5/></td><td>Viernes</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-6-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-6\" $var6/></td><td>Sabado</td></tr>";
$contenido.="<tr><td align=\"right\"><input name=\"dia-7-$clieget\" type=\"checkbox\" onclick=\"desmarcaseltodo(this);\" id=\"dia-7\" $var7/></td><td>Domingo</td></tr>";
$contenido.="<tr><td align=\"right\"><select id=\"HDS\" name=\"HDS-$clieget\" onchange=\"verificarfilas(this);\">
<option value=\"8\" $HDS8>8 Horas</option>
<option value=\"12\" $HDS12>12 Horas</option>
<option value=\"16\" $HDS16>16 Horas</option>
<option value=\"24\" $HDS24>24 Horas</option>
</select></td><td>Horas Contratadas al d&iacute;a</td></tr>";
$contenido.="<tr><td align=\"right\"><select id=\"DT\" name=\"DT-$clieget\" onchange=\"verificarfilas(this);\">
<option value=\"6\" $DT6>6 Horas</option>
<option value=\"8\" $DT8>8 Horas</option>
<option value=\"12\" $DT12>12 Horas</option>
</select></td><td>Duraci&oacute;n del Turno</td></tr>";
$contenido.="<tr><td align=\"right\"><select name=\"Numd-$clieget\">
<option value=\"0\" $Numd0>Ninguno</option>
<option value=\"1\" $Numd1>1 al Mes</option>
<option value=\"2\" $Numd2>2 al Mes</option>
<option value=\"3\" $Numd3>3 al Mes</option>
<option value=\"4\" $Numd4>1 por Semana</option>
</select></td><td>Politica de Descansos</td></tr>";
$contenido.="<tr><td align=\"right\"><select name=\"NumCT-$clieget\">
<option value=\"0\" $NumCT0>Ninguno</option>
<option value=\"1\" $NumCT1>1 al Mes</option>
<option value=\"2\" $NumCT2>2 al Mes</option>
<option value=\"3\" $NumCT3>3 al Mes</option>
<option value=\"4\" $NumCT4>1 por Semana</option>
</select></td><td>Politica de Cambios de Turno</td></tr>";
$contenido.="<tr><td align=\"right\"><select name=\"Prr-$clieget\">
<option value=\"0\" $Prr0>0</option>
<option value=\"1\" $Prr1>1</option>
<option value=\"2\" $Prr2>2</option>
<option value=\"3\" $Prr3>3</option>
<option value=\"4\" $Prr4>4</option>
<option value=\"5\" $Prr5>5</option>
<option value=\"6\" $Prr6>6</option>
<option value=\"7\" $Prr7>7</option>
<option value=\"8\" $Prr8>8</option>
<option value=\"9\" $Prr9>9</option>
</select></td><td>Politica de Rotacion de Relevos</td></tr>";
$contenido.=$perscontr;
$contenido.="<tr id=\"trremover3\"></tr>";
}

		$r=@require('version.php');
		caracteresiso();

		$coltabla="#11ffaa"
?>
<link rel="stylesheet" href="estilo2.css" type="text/css"/>
<link rel="stylesheet" href="botones.css" type="text/css"/>
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="scripts/sexyalertbox.v1.2.jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="estilos/sexyalertbox.css"/>
<script	language="javascript" type="text/javascript" src="scripts/validacion.js"></script>
<script	language="javascript" type="text/javascript">
<?php echo "var cliente=\"$clieget\"";?>

var lpj=3;

function verificarfilas(){
try{	
	var hds=document.getElementById("HDS").value;
	var dt=document.getElementById("DT").value;
	lpj=Math.ceil(hds/dt);
	
	if(lpj>0){
	for(i=0;i<4;i++){
		if(lpj>i){		
		var tr = document.getElementById("trremover"+i).innerHTML="<td align=\"right\"><input name=\"Npers-"+(i+1)+"-"+cliente+"\" id=\"Npers-"+(i+1)+"\" class=\"cortopeque\"/></td><td>Personal Contratado Turno "+(i+1)+"</td>";
		}else{
		var tr = document.getElementById("trremover"+i).innerHTML="<td></td>";
		}
	}
	}
}catch(err){
//alert(err);	
}	
}
function selecctodo(todo){
	try{
		var sele=false;

		if(todo.checked){sele=true;}else{sele=false;}
			
		for(ini=1;ini<8;ini++){
			document.getElementById("dia-"+ini).checked=sele;
		}
	}catch(Exception){
	alert(Exception);	
	}	
}
function desmarcaseltodo(campo){
	try{
		if(!campo.checked){//desmarcar cuando alguno se desmarca
		document.getElementById("seltodo").checked=false;
		}else{//marcar si todos estan marcados
			for(ini=1;ini<8;ini++){
				if(!document.getElementById("dia-"+ini).checked){
				return false;		
				}	
			}
			document.getElementById("seltodo").checked=true;	
		}
	}catch(Exception){
	alert(Exception);	
	}
}
</script>
<script	language="javascript" type="text/javascript">
<?php echo $script;?>
</script>
</head>
<body>
<br/><br/>
<form method="post" action="<?php echo $PHP_SELF?>">
<table class="tablaprincpq" id="tablarem" border="0">
	 		<?php
			echo $contenido;
	 		?>			
     		<tr>
  			<td align="right"><input type="submit" name="boton" value="Guardar para Este"  onclick="return valiparprog();"/></td>
     		<td align="left" valign="top">
	 		Guardar:
      		</td>
			</tr>
			<tr>
			<td align="right"><input type="submit" name="boton" value="Guardar para Todos" onclick="return valiparprog();"/></td>
  			<td align="left" colspan="2"></td>
			</tr>
			</table>

<?php 
@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
/*
while (list($name, $value) = each($_POST)) { echo "<p align='center'> POST $name = $value<br>\n</p>";
}
while (list($name, $value) = each($_SESSION)) { echo "<p align='center'> SESSION $name = $value<br>\n</p>";
}*/
?>
</form>
</body>
</html>
