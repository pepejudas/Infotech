<?php

/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 38);

		switch ($_POST['ejecut']){
			case "nuevo"://nueva programacion
				$_SESSION['paramprograma']=array();
				//definicion de parametros de fecha de programacion
				$fecha=getdate(time());
				
				$mes['valores-1']="01";
				$mes['etiquetas-1']="Enero";
				$mes['valores-2']="02";
				$mes['etiquetas-2']="Febrero";
				$mes['valores-3']="03";
				$mes['etiquetas-3']="Marzo";
				$mes['valores-4']="04";
				$mes['etiquetas-4']="Abril";
				$mes['valores-5']="05";
				$mes['etiquetas-5']="Mayo";
				$mes['valores-6']="06";
				$mes['etiquetas-6']="Junio";
				$mes['valores-7']="07";
				$mes['etiquetas-7']="Julio";
				$mes['valores-8']="08";
				$mes['etiquetas-8']="Agosto";
				$mes['valores-9']="09";
				$mes['etiquetas-9']="Septiembre";
				$mes['valores-10']="10";
				$mes['etiquetas-10']="Octubre";
				$mes['valores-11']="11";
				$mes['etiquetas-11']="Noviembre";
				$mes['valores-12']="12";
				$mes['etiquetas-12']="Diciembre";
				
				$ano['valores-1']=$fecha['year']-1;
				$ano['etiquetas-1']=$fecha['year']-1;
				$ano['valores-2']=$fecha['year'];
				$ano['etiquetas-2']=$fecha['year'];
				$ano['valores-3']=$fecha['year']+1;
				$ano['etiquetas-3']=$fecha['year']+1;
				
				$hora['valores-1']=0;
				$hora['etiquetas-1']="00:00";
				$hora['valores-2']=1;
				$hora['etiquetas-2']="01:00";
				$hora['valores-3']=2;
				$hora['etiquetas-3']="02:00";
				$hora['valores-4']=3;
				$hora['etiquetas-4']="03:00";
				$hora['valores-5']=4;
				$hora['etiquetas-5']="04:00";
				$hora['valores-6']=5;
				$hora['etiquetas-6']="05:00";
				$hora['valores-7']=6;
				$hora['etiquetas-7']="06:00";
				$hora['seleccionado-7']="si";
				$hora['valores-8']=7;
				$hora['etiquetas-8']="07:00";
				$hora['valores-9']=8;
				$hora['etiquetas-9']="08:00";
				$hora['valores-10']=9;
				$hora['etiquetas-10']="09:00";
				$hora['valores-11']=10;
				$hora['etiquetas-11']="10:00";
				$hora['valores-12']=11;
				$hora['etiquetas-12']="11:00";
				$hora['valores-13']=12;
				$hora['etiquetas-13']="12:00";
				$hora['valores-14']=13;
				$hora['etiquetas-14']="13:00";
				$hora['valores-15']=14;
				$hora['etiquetas-15']="14:00";
				$hora['valores-16']=15;
				$hora['etiquetas-16']="15:00";
				$hora['valores-17']=16;
				$hora['etiquetas-17']="16:00";
				$hora['valores-18']=17;
				$hora['etiquetas-18']="17:00";
				$hora['valores-19']=18;
				$hora['etiquetas-19']="18:00";
				$hora['valores-20']=19;
				$hora['etiquetas-20']="19:00";
				$hora['valores-21']=20;
				$hora['etiquetas-21']="20:00";
				$hora['valores-22']=21;
				$hora['etiquetas-22']="21:00";
				$hora['valores-23']=22;
				$hora['etiquetas-23']="22:00";
				$hora['valores-24']=23;
				$hora['etiquetas-24']="23:00";
				
				$contenido="<div id=\"contenidotabla\">";
				$contenido.="<h1>Seleccione la fecha para efectuar programaci&oacute;n</h1><br/>";
				$contenido.="<br/><div align=\"middle\"><input name=\"siguiente\" value=\"Continuar-1\" type=\"submit\"/></div><br/>";
				$contenido.="<div class=\"fila\">Mes:<div class=\"spantabula\"><select name=\"mes\" class=\"medio1\">".opciones($mes).
				"</select></div></div>
				<div class=\"fila\">A&ntilde;o:<div class=\"spantabula\"><select name=\"ano\" class=\"medio1\">".
				opciones($ano)."</select></div></div>
				<div class=\"fila\">Hora Inicio Primer Dia:<div class=\"spantabula\"><select name=\"hora\" class=\"corto1\">".
				opciones($hora)."</select></div></div>
				<div class=\"fila\">Hora Fin Ultimo Dia + 1:<div class=\"spantabula\"><select name=\"minuto\" class=\"corto1\">".
				opciones($hora)."</select></div></div></div>
				";
			break;
			default:
				$contenido="<div id=\"contenidotabla\">";
				$contenido.="<b>Para efectuar una nueva Programaci&oacute;n presione \"Nuevo\" y seleccione los parametros solicitados</b>";
				$contenido.="</div>";
			break;
		}
		switch($_POST['siguiente']){
			case "Continuar-1";

			$_SESSION['paramprograma']['mes']=$_POST['mes'];
			$_SESSION['paramprograma']['ano']=$_POST['ano'];
			
			$datos[campobusqueda]="codigo";
			$datos[crito]="";
			$datos[opcion]="1";
			$datos[claveprinc]="codigo";
			$datos[otraconsulta]="AND `clientes`.`clierelevante`='0'";
				
			$result2=operaciones("clientes","buscar",$datos);
			$result=$result2['datos'];
			$numeroclientes=$result2['numreg'];
			
			for($in=0;$in<$numeroclientes;$in++){
			if($in==0){//encabezado de tabla de seleccion de clientes
				$contenido="<div id=\"contenidotabla\">";
				$contenido.="<h1>Seleccione los Clientes para efectuar programaci&oacute;n</h1><br/>";
				$contenido.="<br/><div align=\"middle\"><input name=\"siguiente\" value=\"Continuar-2\" type=\"submit\" onclick=\"return validaprogramacion();\"/></div><br/>";
				$contenido.="<table class=\"tablaprinc\" align=\"center\">";
				$contenido.="<tr><td><b>Codigo</b></td><td><b>Nombre Cliente</b></td><td><b>Seleccionar</b></td><td><b>Diurnos</b></td><td><b>Nocturnos</b></td></tr>";
				$matrizcodigos="var matrizcodigos=new Array(";
			}
				
			$contenido.="<tr><td>".@mysql_result($result,$in,"codigo")."</td><td>".@mysql_result($result,$in,"nombrecliente")."</td><td><input name=\"cliente-".@mysql_result($result,$in,"codigo")."\" id=\"cliente-".@mysql_result($result,$in,"codigo")."\" type=\"checkbox\"/></td><td><input name=\"personald-".@mysql_result($result,$in,"codigo")."\" id=\"personald-".@mysql_result($result,$in,"codigo")."\" class=\"corto1\"  value=\"".@mysql_result($result,$in,"personald")."\" type=\"text\"/></td><td><input name=\"personaln-".@mysql_result($result,$in,"codigo")."\" id=\"personaln-".@mysql_result($result,$in,"codigo")."\" class=\"corto1\"  value=\"".@mysql_result($result,$in,"personaln")."\" type=\"text\"/></td></tr>";
			$matrizcodigos.="'".@mysql_result($result,$in,"codigo")."', ";
			
			if($in+1==$numeroclientes){
				$contenido.="</table></div>";
				$matrizcodigos.="'ninguno' );";
			}
				
			}
				
			break;
			case "Continuar-2";
			//obtener valores de variables de clientes
			
			$numero2 = count($_POST);
			$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
			$valores2 = array_values($_POST);// obtiene los valores de las varibles
			$_SESSION['paramprograma']['numclientes']=0;
			
			for($contador=0;$contador<$numero2;$contador++){//almacenar variables de clientes
				
				$codigos=explode("cliente-",$tags2[$contador]);
				$codigosc[$contador]=$codigos[1];
				
				if($_POST["cliente-".$codigosc[$contador]]=="on"){//guardar en session los clientes que fueron seleccionados
					$_SESSION['paramprograma']["cliente-".$codigosc[$contador]]=$_POST["cliente-".$codigosc[$contador]];
					$_SESSION['paramprograma']["personald-".$codigosc[$contador]]=$_POST["personald-".$codigosc[$contador]];
					$_SESSION['paramprograma']["personaln-".$codigosc[$contador]]=$_POST["personaln-".$codigosc[$contador]];
					
					$_SESSION['paramprograma']['clientes'][$_SESSION['paramprograma']['numclientes']]=$codigosc[$contador];
					$_SESSION['paramprograma']['numclientes']++;
				}
			}
			//definicion de opciones de parametros
			$opcioneshoraxturno['valores-1']="8";
			$opcioneshoraxturno['etiquetas-1']="8  Horas";
			$opcioneshoraxturno['valores-2']="12";
			$opcioneshoraxturno['etiquetas-2']="12 Horas";
			$opcioneshoraxturno['seleccionado-2']="si";		//valor seleccionado por defecto
			$opcioneshoraxturno['valores-3']="24";
			$opcioneshoraxturno['etiquetas-3']="24 Horas";
			
			$opcioneshoraxturno['valores-24']="24";
			$opcioneshoraxturno['etiquetas-24']="24 Horas";
			
			$opcionesdescansos['valores-1']="1";
			$opcionesdescansos['etiquetas-1']="1 Descanso por Semana";
			$opcionesdescansos['valores-2']="2";
			$opcionesdescansos['etiquetas-2']="1 Descanso por Mes";
			$opcionesdescansos['valores-3']="3";
			$opcionesdescansos['etiquetas-3']="2 Descansos por Mes";
			$opcionesdescansos['valores-4']="4";
			$opcionesdescansos['etiquetas-4']="3 Descansos por Mes";
			
			$opcionescambiosturno['valores-1']="1";
			$opcionescambiosturno['etiquetas-1']="1 Cambio de Turno por Semana";
			$opcionescambiosturno['valores-2']="2";
			$opcionescambiosturno['etiquetas-2']="1 Cambio de Turno por Mes";
			$opcionescambiosturno['valores-3']="3";
			$opcionescambiosturno['etiquetas-3']="2 Cambios de Turno por Mes";
			$opcionescambiosturno['valores-4']="4";
			$opcionescambiosturno['etiquetas-4']="3 Cambios de Turno por Mes";
			
				$contenido="<div id=\"contenidotabla\">";
				$contenido.="<h1>Seleccione los parametros de la programaci&oacute;n</h1><br/>";
				$contenido.="<br/><div align=\"middle\"><input name=\"siguiente\" value=\"Continuar-3\" type=\"submit\" onclick=\"return validaprogramacion();\"/></div><br/>";
				$contenido.="<div class=\"fila\">Horas x Turno:<div class=\"spantabula\"><select name=\"horasxturno\" class=\"medio1\">/n".opciones($opcioneshoraxturno)."</select></div></div><div class=\"fila\">Descansos:<div class=\"spantabula\"><select name=\"descansos\" class=\"largo11\">".opciones($opcionesdescansos)."</select></div></div><div class=\"fila\">Cambios de Turno:<div class=\"spantabula\"><select name=\"cambiosturno\" class=\"largo11\">".opciones($opcionescambiosturno)."</select></div></div>";
				$contenido.="</div>";	
			break;
			case "Continuar-3";
			//capturar parametros de programacion
			$_SESSION['paramprograma']['horasxturno']=$_POST['horasxturno'];
			$_SESSION['paramprograma']['descansos']=$_POST['descansos'];
			$_SESSION['paramprograma']['cambiosturno']=$_POST['cambiosturno'];
			
				$contenido="<div id=\"contenidotabla\"><center>";
				$contenido.="<h1>Seleccione las personas actualmente asignadas</h1><br/>";
				$contenido.="<br/><div align=\"middle\"><input name=\"siguiente\" value=\"Continuar-4\" type=\"submit\"/><br/><div align=\"left\"><input type=\"radio\" name=\"selp\" checked=\"true\" value=\"1\" onchange=\"chekar(this);\">Ninguno<input type=\"radio\" name=\"selp\" value=\"2\" onchange=\"chekar(this);\">Todos</div><br/>";
				$contenido.=listapersprog($_SESSION['paramprograma']);
				$contenido.="</div></div>";
			break;
			case "Continuar-4";
			//capturar parametros de programacion
			$numero2 = count($_POST);
			$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
			$valores2 = array_values($_POST);// obtiene los valores de las varibles

			for($contador=0;$contador<$numero2;$contador++){//almacenar variables de personas
				
				$codigos=explode("persona-",$tags2[$contador]);
				$codigosc[$contador]=$codigos[1];
				
				if($_POST["persona-".$codigosc[$contador]]=="on"){//guardar en session los clientes que fueron seleccionados
					$cont++;
					$_SESSION['paramprograma']['personalprog'][$cont]=$codigosc[$contador];
				}
			}
			
				$contenido="<div id=\"contenidotabla\"><center>";
				$contenido.="<h1>Seleccione los Relevantes</h1><br/>";
				$contenido.="<br/><div align=\"middle\"><input name=\"siguiente\" value=\"Continuar-5\" type=\"submit\"/><br/><div align=\"left\"><input type=\"radio\" name=\"selp\" checked=\"true\" value=\"1\" onchange=\"chekar1(this);\">Ninguno<input type=\"radio\" name=\"selp\" value=\"2\" onchange=\"chekar1(this);\">Todos</div><br/>";
				$contenido.=sentencli("SELECT * FROM `personalactivo`, `clientes` WHERE `personalactivo`.`codigo`=`clientes`.`codigo` AND `clientes`.`clierelevante`=1 AND `personalactivo`.`sucursal`='$_SESSION[sucur]' AND `personalactivo`.`activo`='1'", "2");
				$contenido.="<br/><div align=\"left\"></div></div></div>";
			break;
			case "Continuar-5";
			
			$numero2 = count($_POST);
			$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
			$valores2 = array_values($_POST);// obtiene los valores de las varibles

			for($contador=0;$contador<$numero2;$contador++){//almacenar variables de personas
				
				$codigos=explode("relpersona-",$tags2[$contador]);
				$codigosc[$contador]=$codigos[1];
				
				if($_POST["relpersona-".$codigosc[$contador]]=="on"){//guardar en session los relevantes que fueron seleccionados
					$cont++;
					$_SESSION['paramprograma']['relpersonalprog'][$cont]=$codigosc[$contador];
				}
			}
			
			$fecha=convertirmes($_SESSION['paramprograma']['mes']). " de " .$_SESSION['paramprograma']['ano'];
			
			$contenido="<div id=\"contenidotabla\">";
			$contenido.="<h1>Programaci&oacute;n correspondiente a $fecha </h1><br/>";
			$contenido.=mostrarfilas($_SESSION['paramprograma']);
			$contenido.="<br/></div>";
			break;
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
<script type="text/javascript">
<?php echo $matrizcodigos;?>
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<br/><br/>
	<form method="post" action="<?php echo $PHP_SELF?>" name="programacion">
 	
		<?php echo $contenido;?>

			<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		<!-- <img src="imagenesnuevas/ordenserv.png"/> -->
     		Programaci&oacute;n de Servicios
     		</td>
     		</tr>
     		<tr valign="top"><td valign="middle">
 			</td><td valign="middle">
			</td></tr>
			<tr><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="nuevo" name="ejecut"/>
			</td></tr>
			<tr><td colspan="2" align="center" class="arriba">
			</td></tr>
			</table>
     			<iframe src="menu.php" height="450px" marginheight="0" marginwidth="0" scrolling="no" frameborder="0">
				</iframe>
     		</div>
     </form>
     <?php 
		$matrizidpys=$_SESSION['paramprograma']['cedulas'];     
		$fin=count($matrizidpys);
		$agregararray="'a', ";

		if($fin>0){
		
		for($ini=0;$ini<$fin;$ini++){
			if($ini+1==$fin){
			$agregararray.=$matrizidpys[$ini];	
			}else{
			$agregararray.=$matrizidpys[$ini].", ";	
			} 	
		}	
		echo "<script	language=\"javascript\" type=\"text/javascript\">
		function chekar(valor){
			try{
			var matrizidprendas=Array(".$agregararray.");
			var ini=1;
			var fin=matrizidprendas.length;
			var ponerval=false;
			if(valor.value==1){
			ponerval=false;	
			}else{
			ponerval=true;	
			}		
			
			for(ini=1;ini<fin;ini++){
				document.getElementById(\"persona-\"+matrizidprendas[ini]).checked=ponerval;
			}
		}catch(exception){
		alert(exception+fin+matrizidprendas[ini]);
		}	
		}</script>
		";
		}

		$matrizidpys=$_SESSION['paramprograma']['cedulasrel'];     
		$fin=count($matrizidpys);
		$agregararray="'a', ";

		if($fin>0){
		
		for($ini=0;$ini<$fin;$ini++){
			if($ini+1==$fin){
			$agregararray.=$matrizidpys[$ini];	
			}else{
			$agregararray.=$matrizidpys[$ini].", ";	
			} 	
		}	
		echo "<script	language=\"javascript\" type=\"text/javascript\">
		function chekar1(valor){
			try{
			var matrizidprendas=Array(".$agregararray.");
			var ini=1;
			var fin=matrizidprendas.length;
			var ponerval=false;
			if(valor.value==1){
			ponerval=false;	
			}else{
			ponerval=true;	
			}		
			
			for(ini=1;ini<fin;ini++){
				document.getElementById(\"relpersona-\"+matrizidprendas[ini]).checked=ponerval;
			}
		}catch(exception){
		alert(exception+fin+matrizidprendas[ini]);
		}	
		}</script>
		";
		}
?>		
<?php 
@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
echo $escribir;

while (list($name, $value) = each($_POST)) { echo "<p align='center'> POST $name = $value<br>\n</p>";
}
while (list($name, $value) = each($_SESSION)) { echo "<p align='center'> SESSION $name = $value<br>\n</p>";
}
?>
<br/>
<?php require('saludos.php');?>
</body>
</html>