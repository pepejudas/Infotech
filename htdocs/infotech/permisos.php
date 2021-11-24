<?php
/*
 * Created on 15/10/2007
 *
 * ingeniero: Ferley Ardila Caicedo
 */
session_start();
 
@require('funciones2.php');

$link=validar("","","", 57);

formularioactual();

 	switch ($_POST['ejecut']){
	case "Buscar":
		$_SESSION[datos]="";	
		$_SESSION['arrpermisos']=array();
		$_SESSION[i]=0;
		$_SESSION['perm']=$_POST['criterio'];	
		
		if($_SESSION['perm']!=""){
		$idusuario=$_SESSION['perm'];
		$sql="SELECT * FROM `modulos` LEFT JOIN (`permisos` , `grupoinfo`) ON ( `permisos`.`idusuario` = '$idusuario' AND `permisos`.`idmodulo` = `modulos`.`id` AND `modulos`.`idgrupoinf` = `grupoinfo`.`id`) ORDER BY `modulos`.`nombre`";
		
		$result=@mysql_query($sql);
		$numr=@mysql_num_rows($result);
		$imatrizidpys=0;
		
		for($ini=0;$ini<$numr;$ini++){
			if(@mysql_result($result,$ini,"tipopermiso")=="1"){
			$ninguno="";	
			$lectura=" checked=\"checked\" ";
			$escritura="";
			$resumen.="Lectura: ".@mysql_result($result,$ini,"nombre")."<br/>";	
			}else if(@mysql_result($result,$ini,"tipopermiso")=="2"){
			$ninguno="";
			$lectura="";
			$escritura=" checked=\"checked\" ";				
			$resumen.="Lectura y Escritura: ".@mysql_result($result,$ini,"nombre")."<br/>";
			}else{
			$ninguno=" checked=\"checked\" ";	
			$lectura="";
			$escritura="";
			}
		$listapermisos.="<tr><td align=\"right\"><hr/>Ningun Permiso<input onclick=\"verificaperm();\" type=\"radio\" name=\"modulo-".@mysql_result($result,$ini,"modulos.id")."\" id=\"modulo-".@mysql_result($result,$ini,"modulos.id")."-0\" value=\"0\" $ninguno/><br/>Lectura<input onclick=\"verificaperm();\" type=\"radio\" name=\"modulo-".@mysql_result($result,$ini,"modulos.id")."\"  id=\"modulo-".@mysql_result($result,$ini,"modulos.id")."-1\" value=\"1\" $lectura/><br/>Lectura y Escritura<input onclick=\"verificaperm();\" type=\"radio\" name=\"modulo-".@mysql_result($result,$ini,"modulos.id")."\" id=\"modulo-".@mysql_result($result,$ini,"modulos.id")."-2\" value=\"2\" $escritura/></td><td><b>".@mysql_result($result,$ini,"nombre")."</b><br/><input type=\"checkbox\" name=\"notificacion-".@mysql_result($result,$ini,"modulos.id")."\"/> Notificaciones</td></tr>";
		$pys=@mysql_result($result,$ini,"modulos.id");
		if($pys!=""){
                    $matrizidpys[$imatrizidpys]=$pys;
                    $imatrizidpys++;
                }
		}
		}
		
		break;
	case "Actualizar":
		$idusario=$_SESSION['perm'];
		$numero2 = count($_POST);	
		$tags2 = array_keys($_POST); 		// obtiene los nombres de las varibles
		$valores2 = array_values($_POST);	// obtiene los valores de las varibles
		
		for($i=0;$i<$numero2;$i++){			//capturar valores de variables
			$permisos0=explode("modulo-",$tags2[$i]);

			if($permisos0[1]!=""){			//captura solo permisos asignados
			$permisos[$i]=$permisos0[1];
			}
		}
		
		$numper=count($permisos);
		$_SESSION['arrpermisos']=array();
		$_SESSION['permisosdar']=0;
		$_SESSION['permisosrev']=0;
		
		for($ini=0;$ini<$numper;$ini++){

			$sql0="SELECT * FROM `relacional`.`permisos`,`relacional`.`usuarios` WHERE `usuarios`.`id`='$idusario' AND `idmodulo`='$permisos[$ini]' AND `permisos`.`idusuario` = `usuarios`.`id`";
			$consu=@mysql_query($sql0, $link) or $error=@mysql_error()." - 71";
			$idreg=@mysql_result($consu,0,"id");
			$tipop=$_POST['modulo-'.$permisos[$ini]];

			if(@mysql_num_rows($consu)>0){
					if(@mysql_result($consu,0,"tipopermiso")!=$tipop){//tiene un permiso diferente asignado
					$sqlpi="UPDATE `relacional`.`permisos` SET `tipopermiso`='".$tipop."' WHERE `id`='$idreg';";
					}
			}else{
					$sqlpi="INSERT INTO `relacional`.`permisos` (`idmodulo`,`idusuario`,`tipopermiso`) VALUES ('$permisos[$ini]', '$idusario', '$tipop');";
			}
				if(isset($sqlpi)){
				@mysql_query($sqlpi, $link) or $error=@mysql_error()." - 82";
				crearcons($permisos[$ini], $tipop, $idusario);
				}
		}
		
		$error=ejecutarcons();
		$mens=$error;

		break;
 	}
	
	$mostrar[1]="usuario";
        $mostrar[2]="carnetpersonal";
	$cadena=selection("usuarios","id","%",$mostrar,$idusuario,2,"id",$otras);
	
	$datos2[cliente]=$_SESSION[clientemod];
	$numvig=numvigact($datos2);
	
	$r=@require('version.php');

	caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9AFF83";

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

		<form method="post" action="permisos.php" name="permisos">
 		<table class="tablaprinc"><tr><td>
		<table>
   		<tr>
     		<td align="left"><hr/><br/><h1>Resumen Permisos Actuales</h1><br/>
			<?php print($resumen);?>
			<hr/><br/><h1>Asignaci&oacute;n de Permisos</h1><br/>
   			</td><!-- Col 1 -->
 		</tr>
 		<tr>
     	<td><select onchange="chekar(this);"><option value="0">Ningun Permiso</option><option value="1">Permiso Lectura</option><option value="2">Permisos Completos</option></select></td>
     	</tr>
 		<tr>
   			<td>
   			<?php print($listapermisos);?></td>
 		</tr>
 		</table>
 		</td></tr></table>	
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Permisos de Usuarios
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle" colspan="2" align="center">
     		<input type="submit" class="botobusca" value="Buscar" name="ejecut">
 			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<select tabindex="1" name="criterio" class="largo2">
  	 		<option value=""></option>
  	 		<?php echo $cadena;?>
			</select>
			</td></tr>
			<tr height="10px"><td valign="middle" colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="30px"><td colspan="2" align="center">
			</td></tr>
			</table>
                        <div id="divMenu" class="divMenu"></div>
<?php require('saludos.php');?>
</div>
</form>
<script type="text/javascript">
		
<?php 
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
		echo "
		function chekar(valor){
			try{
			var matrizidpermisos=Array(".$agregararray.");
			var ini=1;
			var fin=matrizidpermisos.length;
			var nom=\"\";
			
			for(ini=1;ini<fin;ini++){
				nom=\"modulo-\"+matrizidpermisos[ini]+\"-\"+valor.value
				document.getElementById(nom).checked=true;
			}
		}catch(exception){

		}	
		}
		";
		}else{
		echo "
		function chekar(valor){
			try{

		}catch(exception){

		}	
		}
		";	
		}
?>
</script>
</body>
</html>
  