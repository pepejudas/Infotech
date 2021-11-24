<?php
//ini_set('display_errors', 1);
function conectar0(){//mysql consultar usuario
	$host1="localhost";
	$nombre1="infotechuser";
	$contra1="20001015006";
	$link0=@mysql_connect($host1, $nombre1, $contra1);
	@mysql_select_db("mysql",$link0) or die("error 505");
	@mysql_query("SET NAMES 'utf8'");
	htmi(cardll());
	return $link0;
}
function conectar(){//infotech consultar usuario
	$host1="localhost";
	$nombre1="infotechuser";
	$contra1="20001015006";
	$link=@mysql_connect($host1,$nombre1,$contra1) or header("Location:instalacion.php");
	@mysql_select_db("relacional",$link) or die("error 506");
	@mysql_query("SET NAMES 'utf8'");
	htmi(cardll());
	return $link;
}
function escaparaJSON($textoenviar){
    $textoenviar2=trimall($textoenviar);
    return $textoenviar2;
}
function trimall($str, $charlist = "\t\n\r\0\x0B"){
  return str_replace(str_split($charlist), ' ', $str);
}

function conectari($usuario, $contra){//infotech conexion del usuario verificado
	$host1="localhost";
	$link3=@mysql_connect($host1,$usuario,$contra);
	@mysql_select_db("relacional", $link3) or die("error 507");
	@mysql_query("SET NAMES 'utf8'");
	htmi(cardll());
	return $link3;
}
function conectarim(){//infotech conexion del usuario verificado sin datos
	$host1="localhost";
	if(isset($_SESSION['usuariow'],$_SESSION['passwdw'])){
	$link3=@mysql_connect($host1,$_SESSION['usuariow'],$_SESSION['passwdw']);
	@mysql_select_db("relacional", $link3) or die("error 508");
	@mysql_query("SET NAMES 'utf8'");
	htmi(cardll());
	return $link3;
	}else{
	return "";	
	}
}
function conectarm(){
	$host1="localhost";
	$link=@mysql_connect($host1,$_SESSION['usuariow'],$_SESSION['passwdw']);
	@mysql_select_db("mysql",$link) or die("error 509");
	@mysql_query("SET NAMES 'utf8'");
	htmi(cardll());
return $link;	
}
function validartextolog($texto){
	//compruebo que los caracteres sean los permitidos
   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ñÑáÁéÉíÍóÓúÚ";
   for ($i=0; $i<strlen($texto); $i++){
      if (strpos($permitidos, substr($texto,$i,1))===false){
         $retorna[valido]="no";
      }else{
      	 $retorna[valido]="si";
      }
	}
	$retorna['dato']=$texto;
	return $retorna;
}

function nulli($val){
	if($val==""){
	$val='NULL';	
	}
	return $val;
}

function num($r){
	$etiq=str_ireplace("$", "", "$r");
	$etiqt=str_ireplace(".", "", "$etiq");
	$etiqtw=str_ireplace(",", "", "$etiqt");
	$r=$etiqtw;
	
	return $r;
}
function validar($nombre, $contra, $sucursal, $formulario){
	try{
	if($_SESSION['iuj345iuh']!=1){
        
	$link0=conectar0();	//conexion mysql
	$link=conectar();	//conexion infotech
	
	$nombreval=validartextolog($nombre);
	$contraval=validartextolog($contra);
	$sucurval =validartextolog($sucursal);
	
		if($nombreval['valido']=="si" and $contraval['valido']=="si" and $sucurval['valido']=="si"){
		$sql="SELECT * FROM `mysql`.`user` WHERE `user`.`user`='$nombre' AND `user`.`password`=password('$contra')";
		$consulta=mysql_query($sql, $link0);
		$fila=mysql_num_rows($consulta);
		
		if($sucursal=="1"){$sucursal="%";}//para acceso central
		
		$sql1="SELECT nombre, apellidos, id, sucursal FROM `relacional`.`usuarios` LEFT JOIN `relacional`.`personalactivo` ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE `usuarios`.`usuario`='$nombre' AND `usuarios`.`contrasena`=password('$contra') AND (`personalactivo`.`activo` = 3 OR `personalactivo`.`activo` = 1) AND `personalactivo`.`sucursal` LIKE '$sucursal'";
		$consulta1=mysql_query($sql1, $link) or $error=@mysql_error($link);
		$fila1=mysql_num_rows($consulta1);
			if($fila>0){		//si hay usuario mysql registrado
				if($fila1>0){	//si hay usuario infotech registrado
					if((@mysql_result($consulta1,0,"sucursal")==2 && $sucursal=="%") || (@mysql_result($consulta1,0,"sucursal")!=2 && $sucursal!="%") || (@mysql_result($consulta1,0,"sucursal")==2 && $sucursal=="2")){
                                        //verificacion de sucursales
					$_SESSION['usuariow']=$nombre;
					$_SESSION['passwdw']=$contra;
					$_SESSION['persona']=@mysql_result($consulta1,0,"nombre")." ".@mysql_result($consulta1,0,"apellidos");
					$_SESSION['sucur']=$sucursal;
					$_SESSION['idusuario']=@mysql_result($consulta1,0,"id");
					$_SESSION['iuj345iuh']=1;
						//}
					@mysql_close($link0);
					@mysql_close($link);

					//verificar acceso a formulario
					permisoform($formulario, $_SESSION['idusuario']);
					
					$link3=conectari($nombre, $contra);	//abrir conexion infotech por defecto
					}else{
						die(header("Location: login.php?msg='Datos no Validos, Acceso Denegado - 299'"));//sucursal no valida
					}
				}else{
					die(header("Location: login.php?msg='Datos no Validos, Acceso Denegado - 300'"));
				}			
			}else{
				die(header("Location: login.php?msg='Datos no Validos, Acceso Denegado - 301'"));
			}
		}else{
			die(header("Location: login.php"));
		}
	}else{
	//verificar acceso a formulario
	permisoform($formulario, $_SESSION['idusuario']);
	$link3=conectari($_SESSION['usuariow'], $_SESSION['passwdw']);	//conexion infotech
	}
        
	return $link3;

	}catch(Exception $err){	
	}	
}
function guardarSes($_POST){
    $_SESSION['botonuevo']=1;
				$escribir.= '<script language="JavaScript" type="text/JavaScript">alert("Debe ingresar todos los campos requeridos \n estan marcados con asterisco");</script>';

				$_SESSION['codigoa']=$_POST['codigo'];
				$_SESSION['cedulaa']=$_POST['cedula'];
				$_SESSION['expedidaa']=$_POST['expedida'];
				$_SESSION['clientemod']=$_POST['cedula'];
				$_SESSION['nombrea']=$_POST['nombre'];
				$_SESSION['apellidosa']=$_POST['apellidos'];
				$_SESSION['sexoa']=$_POST['sexo'];
				$_SESSION['rha']=$_POST['rh'];
				$_SESSION['estadocivila']=$_POST['estadocivil'];
				$_SESSION['pasadojudiciala']=$_POST['pasadojudicial'];
				$_SESSION['vigenciapja']=$_POST['vigenciapj'];
				$_SESSION['direcciona']=$_POST['direccion'];
				$_SESSION['barrioa']=$_POST['barrio'];
				$_SESSION['codigoresidenciaa']=$_POST['codigoresidencia'];
				$_SESSION['telefonoa']=$_POST['telefono'];
				$_SESSION['celulara']=$_POST['celular'];
				$_SESSION['fechanacimientoa']=$_POST['fechanacimiento'];
				$_SESSION['coddeptonacima']=$_POST['coddeptonacim'];
				$_SESSION['oficiotramitecreda']=$_POST['oficiotramitecred'];
				$_SESSION['codnivelviga']=$_POST['codnivelvig'];
				$_SESSION['vigenciacursoa']=$_POST['vigenciacurso'];
				$_SESSION['numhijosa']=$_POST['numhijos'];
				$_SESSION['epsa']=$_POST['eps'];
				$_SESSION['noafepsa']=$_POST['noafeps'];
				$_SESSION['epsfechaa']=$_POST['epsfecha'];
				$_SESSION['arpa']=$_POST['arp'];
				$_SESSION['noafarpa']=$_POST['noafarp'];
				$_SESSION['arpfechaa']=$_POST['arpfecha'];
				$_SESSION['afpa']=$_POST['afp'];
				$_SESSION['noafafpa']=$_POST['noafafp'];
				$_SESSION['afpfechaa']=$_POST['afpfecha'];
				$_SESSION['rangomilitara']=$_POST['rangomilitar'];
				$_SESSION['fechaingresoa']=$_POST['fechaingreso'];
				$_SESSION['fincontratoa']=$_POST['fincontrato'];
				$_SESSION['placaa']=$_POST['placa'];
				$_SESSION['credsuperintendenciaa']=$_POST['credsuperintendencia'];
				$_SESSION['vencecredsuperintendenciaa']=$_POST['vencecredsuperintendencia'];
				$_SESSION['cargoa']=$_POST['cargo'];
				$_SESSION['carnetinternoa']=$_POST['carnetinterno'];
				$_SESSION['epschecka']=$_POST['epscheck'];
				$_SESSION['arpchecka']=$_POST['arpcheck'];
				$_SESSION['afpchecka']=$_POST['afpcheck'];
				$_SESSION['contra']=$_POST['contrato'];
}
function validarBoa($nombre, $contra, $sucursal, $formulario){
	try{

	if($_SESSION['iuj345iuh']!=1){

	$link0=conectar0();	//conexion mysql
	$link=conectar();	//conexion infotech

	$nombreval=validartextolog($nombre);
	$contraval=validartextolog($contra);
	$sucurval =validartextolog($sucursal);

		if($nombreval['valido']=="si" and $contraval['valido']=="si" and $sucurval['valido']=="si"){
		$sql="SELECT * FROM `mysql`.`user` WHERE `user`.`user`='$nombre' AND `user`.`password`=password('$contra')";
		$consulta=mysql_query($sql, $link0);
		$fila=mysql_num_rows($consulta);

		if($sucursal=="1"){$sucursal="%";}//para acceso central

                $sql1="SELECT nombre, apellidos, id FROM `relacional`.`usuarios` LEFT JOIN `relacional`.`personalactivo` ON usuarios.carnetpersonal=personalactivo.carnetinterno WHERE `usuarios`.`usuario`='$nombre' AND `usuarios`.`contrasena`=password('$contra') AND `personalactivo`.`sucursal` LIKE '$sucursal'";
		//$sql1="SELECT nombre, apellidos, id FROM `relacional`.`usuarios` WHERE `usuarios`.`usuario`='$nombre' AND `usuarios`.`contrasena`=password('$contra') AND `usuarios`.`sucursal` LIKE '$sucursal'";
		$consulta1=mysql_query($sql1, $link);
		$fila1=mysql_num_rows($consulta1);

			if($fila>0){		//si hay usuario mysql registrado
				if($fila1>0){	//si hay usuario infotech registrado
					if((@mysql_result($consulta1,0,"sucursal")==2 && $sucursal=="%") || (@mysql_result($consulta1,0,"sucursal")!=2 && $sucursal!="%") || (@mysql_result($consulta1,0,"sucursal")==2 && $sucursal=="2")){
                                        //verificacion de sucursales
					$_SESSION['usuariow']=$nombre;
					$_SESSION['passwdw']=$contra;
					$_SESSION['persona']=@mysql_result($consulta1,0,"nombres")." ".@mysql_result($consulta1,0,"apellidos");
					$_SESSION['sucur']=$sucursal;
					$_SESSION['idusuario']=@mysql_result($consulta1,0,"id");
					$_SESSION['iuj345iuh']=1;
						//}
					@mysql_close($link0);
					@mysql_close($link);

					//verificar acceso a formulario
					permisoform($formulario, $_SESSION['idusuario']);

					$link3=conectari($nombre, $contra);	//abrir conexion infotech por defecto

					}else{
						die("{success:false}");//sucursal no valida
					}
				}else{
					die("{success:false}");
				}
			}else{
				die("{success:false}");
			}
		}else{
			die("{success:false}");
		}
	}else{
	//verificar acceso a formulario
	permisoform($formulario, $_SESSION['idusuario']);

	$link3=conectari($_SESSION['usuariow'], $_SESSION['passwdw']);	//conexion infotech

	}

	return $link3;

	}catch(Exception $err){

	}
}
function permisoform($idformulario, $idusuario){
	$link=conectar();	//conexion infotech

	$sql2="SELECT * FROM `usuarios`, `permisos`, `modulos` WHERE `usuarios`.`id`='$idusuario' AND `modulos`.`id` = `permisos`.`idmodulo` AND `usuarios`.`id` = `permisos`.`idusuario` AND `modulos`.`id` = '$idformulario' ORDER BY `modulos`.`idgrupoinf`";
	$consulta2=@mysql_query($sql2) or $error=@mysql_error();
	$filas=@mysql_num_rows($consulta2);

	if(!$filas>0 || @mysql_result($consulta2, 0,"tipopermiso")=="" || @mysql_result($consulta2, 0,"tipopermiso")=="0"){// verificar si tiene permisos
	die(header("Location: inicio.php?msg='No tiene Permiso de Acceder a ese formulario'"));
	}
}

function consPermisoForm($idformulario, $idusuario, $tipo){
	$tienePermiso=false;
        
        $link=conectar();	//conexion infotech

	$sql2="SELECT * FROM `usuarios`, `permisos`, `modulos` WHERE `usuarios`.`id`='$idusuario' AND `modulos`.`id` = `permisos`.`idmodulo` AND `usuarios`.`id` = `permisos`.`idusuario` AND `permisos`.`tipopermiso`=2 AND `modulos`.`id` = '$idformulario' ORDER BY `modulos`.`idgrupoinf`";
	$consulta2=mysql_query($sql2);
	$filas=@mysql_num_rows($consulta2);

	if(!$filas>0 || @mysql_result($consulta2, 0,"tipopermiso")=="" || @mysql_result($consulta2, 0,"tipopermiso")=="0"){// verificar si tiene permisos
	//@die(header("Location: inicio.php?msg='No tiene Permiso de Acceder a ese formulario'"));
	}else{
        $tienePermiso=true;
        }

        desconectar($link);

        return $tienePermiso;
}

function desconectar($link){
    @mysql_close($link);
}

function conectar2($nivel, $idmodulo){
	
	if($_SESSION['iuj345iuh']==1){

	 $host1="localhost";
	 $link=mysql_connect($host1,$nombre1,$contra1);
	 mysql_select_db("relacional",$link);
	 mysql_query("SET NAMES 'utf8'");
	}else{
	print("
	<link	rel=\"stylesheet\" href=\"estilo2.css\" type=\"text/css\"/>
	<link	rel=\"stylesheet\" href=\"botones.css\" type=\"text/css\"/>
	<link	rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"estilos/sexyalertbox.css\" />
	<script	type=\"text/javascript\" src=\"scripts/jquery.min.js\"></script>
	<script	type=\"text/javascript\" src=\"scripts/jquery.easing.1.3.js\"></script>
	<script	type=\"text/javascript\" src=\"scripts/sexyalertbox.v1.2.jquery.js\"></script>
	<script type='text/javascript'>
    var pagina = 'inicio.php';
    var segundos = 8000;
    function redireccion() {
        document.location.href=pagina;
    }
    setTimeout('redireccion()',segundos);
    alert('Debe Ingresar a la pagina de Acceso');
	</script></head><body></body></html>");	
	}
	htmi(cardll());
}
function formularioactual(){
	if(formanterior($_SERVER['HTTP_REFERER'], $_SERVER['PHP_SELF'])){
		resetearsesion();
		$_SESSION['cade']="";
		$_SESSION['numreg']="";
	}
}
function conectar3($nivel){
	if($_SESSION['iuj345iuh']==1){
	 switch($nivel){
		case "gerentes":
		$nombre1="infotechgere";
		$contra1="20001015006gere";
		$tabla="gerentes";
		break;
	 }
	
	 $host1="localhost";
	 $link=mysql_connect($host1,$nombre1,$contra1);
	 mysql_select_db("registro",$link);
	 @mysql_query("SET NAMES 'utf8'");
	
	return $link;
	}else{
	print("
	<link	rel=\"stylesheet\" href=\"estilo2.css\" type=\"text/css\"/>
	<link	rel=\"stylesheet\" href=\"botones.css\" type=\"text/css\"/>
	<link	rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"estilos/sexyalertbox.css\" />
	<script	type=\"text/javascript\" src=\"scripts/jquery.min.js\"></script>
	<script	type=\"text/javascript\" src=\"scripts/jquery.easing.1.3.js\"></script>
	<script	type=\"text/javascript\" src=\"scripts/sexyalertbox.v1.2.jquery.js\"></script>
	<script type='text/javascript'>
    var pagina = 'inicio.php';
    var segundos = 8000;
    function redireccion() {
        document.location.href=pagina;
    }
    setTimeout('redireccion()',segundos);
    alert('Debe Ingresar a la pagina de Acceso');
	</script></head><body></body></html>");	
	}
}

function resetearsesion(){
                $_SESSION['cade']="";
                $_SESSION['numfacturaa']="";
                $_SESSION['fechadesdea']="";
                $_SESSION['fechahastaa']="";
                $_SESSION['subtotala']="";
                $_SESSION['conceptoa']="";
                $_SESSION['valorenletrasa']="";
                $_SESSION['observacionesfacta']="";
                $_SESSION['ivaa']="";
                $_SESSION['icaa']="";
                $_SESSION['retefuentea']="";
                $_SESSION['totalfacturaa']="";
                $_SESSION['totalabonosa']="";
                $_SESSION['saldofacturaa']="";
                $_SESSION['fecharegistroa']="";
                $_SESSION['usuarioinga']="";
                $_SESSION['totala']="";
                $_SESSION['numregab']="";
                $_SESSION['mes']="";
                $_SESSION['anotriple']="";
                $_SESSION['checka']="";
                $_SESSION['idreg']="";
                $_SESSION['cedulamod']="";
                $_SESSION['cedulamod1']="";
                $_SESSION['clientemodi']="";
                $_SESSION['ordenc']="";
                $_SESSION['abomod']="";
                $_SESSION['cedulamod10']="";
                $_SESSION['camp']="";
                $_SESSION['cont']="";
                $_SESSION['lis']="";
                $_SESSION['ord']="";
                $_SESSION['foto']="";
                $_SESSION['cod']="";
                $_SESSION['idprod']="";
                $_SESSION['idprodmod']="";
                $_SESSION['i']="";
                $_SESSION['ord']="";
                $_SESSION['iddota']="";
                $_SESSION['busca']="";
                $_SESSION['sent']="";
                $_SESSION['regmod']="";
                $_SESSION['elim1']="";
                $_SESSION['procv']="";
                $_SESSION['sent2']="";
                $_SESSION['tablaC']="";
                $_SESSION['ofertamod']="";
		$_SESSION['codigoa']="";
		$_SESSION['cedulaa']="";
		$_SESSION['expedidaa']="";
		$_SESSION['nombrea']="";
		$_SESSION['apellidosa']="";
		$_SESSION['sexoa']="";
		$_SESSION['rha']="";
		$_SESSION['estadocivila']="";
		$_SESSION['pasadojudiciala']="";
		$_SESSION['vigenciapja']="";
		$_SESSION['direcciona']="";
		$_SESSION['barrioa']="";
		$_SESSION['codigoresidenciaa']="";
		$_SESSION['telefonoa']="";
		$_SESSION['celulara']="";
		$_SESSION['fechanacimientoa']="";
		$_SESSION['coddeptonacima']="";
		$_SESSION['oficiotramitecreda']="";
		$_SESSION['codnivelviga']="";
		$_SESSION['vigenciacursoa']="";
		$_SESSION['numhijosa']="";
		$_SESSION['epsa']="";
		$_SESSION['noafepsa']="";
		$_SESSION['epsfechaa']="";
		$_SESSION['arpa']="";
		$_SESSION['noafarpa']="";
		$_SESSION['arpfechaa']="";
		$_SESSION['afpa']="";
		$_SESSION['noafafpa']="";
		$_SESSION['afpfechaa']="";
		$_SESSION['rangomilitara']="";
		$_SESSION['fechaingresoa']="";
		$_SESSION['fincontratoa']="";
		$_SESSION['placaa']="";
		$_SESSION['credsuperintendenciaa']="";
		$_SESSION['vencecredsuperintendenciaa']="";
		$_SESSION['cargoa']="";
		$_SESSION['carnetinternoa']="";
		$_SESSION['epschecka']="";
		$_SESSION['arpchecka']="";
		$_SESSION['afpchecka']="";
		$_SESSION['contra']="";
                $_SESSION['datos']=null;
		
}
function obtenerfecha($vector){
$vector1=explode("-", $vector);
$vector2=explode(" ", $vector1[2]);
$vector3=explode(":", $vector2[1]);
$vector4 = array('ano' => "$vector1[0]",
'mes' => "$vector1[1]",
'dia' => "$vector2[0]",
'hora' => "$vector3[0]",
'minuto' => "$vector3[1]",
'segundo' => "$vector3[2]",
);

return $vector4;	
}
function ponerversion(){
	$sintx="SELECT * FROM parametros";
	$resx=@mysql_query($sintx);
	$version=@mysql_result($resx,0,version);
	$org=@mysql_result($resx,0,org);
	echo '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<link rel="icon" href="./favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="imagenes/info4.ico"/>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<title>'. $version .'</title>';
}
function consultarparam($nombre){//consulta de parametro de sistema
	$sintx="SELECT $nombre FROM parametros";
	$resx=@mysql_query($sintx);
	$param=@mysql_result($resx,0,$nombre);
	return $param;
}
function caracteresiso(){
	$link=conectarim();
	$sql300="select razonsocial from seguridadsuper limit 1";
	$consd=@mysql_query($sql300, $link);
	$cad1=@mysql_result($consd,0,"razonsocial");
	$encr1=md5($cad1);
	$encr1=$_SESSION[nencri]; //para desarrollo en linux quitar linea con comentarios
	if($encr1!=$_SESSION[nencri]){
	exit();
	}
	return $cad1;
}
function htmi($en){
	$_SESSION['nencri']=$en;
}
function consultarslogan(){
	$sql="SELECT slogan FROM parametros";
	$cons=mysql_query($sql);
	$cad1=mysql_result($cons,0,"slogan");
	return $cad1;
}
function selectturno($cedula, $ano, $mes, $dia, $diurnoctur,$cliente="no",$nombreselect=""){
	if($cliente=="no"){
	$sql="SELECT $diurnoctur$dia FROM controlturnos WHERE controlturnos.cedulacontrol LIKE '$cedula' AND controlturnos.mescontrol LIKE '$mes$ano' LIMIT 1";
	}else{
	$sql="SELECT $diurnoctur$dia FROM controlturnos WHERE controlturnos.cedulacontrol LIKE '$cedula' AND controlturnos.mescontrol LIKE '$mes$ano' AND controlturnos.cod$dia LIKE '$cliente' LIMIT 1";	
	}
	
	$consulta=@mysql_query($sql);
	$dato=@mysql_result($consulta,0,"$diurnoctur$dia");
	$cadena1=obtenerNovedades($dato, "si");
	$cadenaretorna="<select name='$nombreselect$diurnoctur$dia' id='$nombreselect$diurnoctur$dia' class='corto0' name='opcionturnos'>".$cadena1."</select>";
	return $cadenaretorna;
}
function cardll(){
	return $encr2;
}
function selectpers($cedula, $ano, $mes, $dia, $diurnoctur, $turnomodificado){
	$sql="SELECT $diurnoctur$dia, reg$dia FROM controlturnos WHERE controlturnos.cedulacontrol LIKE '$cedula' AND controlturnos.mescontrol LIKE '$mes$ano' LIMIT 1";
	$consulta=@mysql_query($sql);
	$turno=@mysql_result($consulta,0,"$diurnoctur$dia");
	
	if($turno==$turnomodificado){
	$nombre=@mysql_result($consulta,0,"reg$dia");	
	}else{
	$nombre=$_SESSION[usuariow];
	}
	
	return $nombre;
}
function decod($cadena){
$cadena2=utf8_decode($cadena);
//$cadena3=htmlspecialchars($cadena2);
return $cadena2;	
}
function decod1($cadena){
$cadena2=htmlspecialchars($cadena);
return $cadena2;
}
function convertirmes($mesnumero){
	switch($mesnumero){
		case "01":
			$mesbusc="January";
		break;
		case "02":
			$mesbusc="February";
		break;	
		case "03":
			$mesbusc="March";
		break;
		case "04":
			$mesbusc="April";
		break;
		case "05":
			$mesbusc="May";
		break;
		case "06":
			$mesbusc="June";
		break;
		case "07":
			$mesbusc="July";
		break;
		case "08":
			$mesbusc="August";
		break;
		case "09":
			$mesbusc="September";
		break;
		case "10":
			$mesbusc="October";
		break;
		case "11":
			$mesbusc="November";
		break;
		case "12":
			$mesbusc="December";
		break;
}return $mesbusc;
}
function convertirmesaced2($mesnumero, $ano){
	switch($mesnumero){
		case "01":
			$mesbusc="January$ano";
		break;
		case "02":
			$mesbusc="February$ano";
		break;	
		case "03":
			$mesbusc="March$ano";
		break;
		case "04":
			$mesbusc="April$ano";
		break;
		case "05":
			$mesbusc="May$ano";
		break;
		case "06":
			$mesbusc="June$ano";
		break;
		case "07":
			$mesbusc="July$ano";
		break;
		case "08":
			$mesbusc="August$ano";
		break;
		case "09":
			$mesbusc="September$ano";
		break;
		case "10":
			$mesbusc="October$ano";
		break;
		case "11":
			$mesbusc="November$ano";
		break;
		case "12":
			$mesbusc="December$ano";
		break;
}return $mesbusc;
}
function convertirmesbced2($mesnumero, $ano){
	switch($mesnumero){
		case "12":
			$ano2=$ano+1;
			$mesbusc="January$ano2";
		break;
		case "01":
			$mesbusc="February$ano";
		break;	
		case "02":
			$mesbusc="March$ano";
		break;
		case "03":
			$mesbusc="April$ano";
		break;
		case "04":
			$mesbusc="May$ano";
		break;
		case "05":
			$mesbusc="June$ano";
		break;
		case "06":
			$mesbusc="July$ano";
		break;
		case "07":
			$mesbusc="August$ano";
		break;
		case "08":
			$mesbusc="September$ano";
		break;
		case "09":
			$mesbusc="October$ano";
		break;
		case "10":
			$mesbusc="November$ano";
		break;
		case "11":
			$mesbusc="December$ano";
		break;
}return $mesbusc;
}
//para la nueva actualizacion del sistema para realizar todas las consultas del programa 
function operaciones($tabla,$operacion,$datos, $link=""){
	//$datos;
    $error="";
    
	switch($operacion){
		case "ingresar":
		//$sql="INSERT INTO $tabla ()";	
		break;
		case "actualizar":
			
		break;
		case "buscar":
				
		$_SESSION[datos][campobusqueda]=$datos[campobusqueda];
		$_SESSION[datos][crito]=$datos[crito];
		$_SESSION[datos][opcion]=$datos[opcion];
		$_SESSION[datos][orden]=$datos[orden];
		$_SESSION[datos][claveprinc]=$datos[claveprinc];
		$_SESSION[datos][otraconsulta]=$datos[otraconsulta];
		
		//desde aqui aplica a todo el resto de consultas
		
		$campo=$_SESSION[datos][campobusqueda];
		$crito=$_SESSION[datos][crito];
		$clave=$_SESSION[datos][claveprinc];
		$otras=$_SESSION[datos][otraconsulta];
		$orden=$_SESSION[datos][orden];
		
		if($orden==""){$orden=$campo;}
				
		//para opcion mismo o cualquier
		
			if ($_SESSION[datos][opcion]==1){
			$crito="%". $crito. "%";
			}
		
		//AND `clientes`.`activo` = 1 falta en cada consulta poner switch para saber para cada tabla para el resto de consulta
		switch ($tabla){
			case "gerentes":
			case "productos":
			case "armas":
			case "radios":
			case "socios":
			case "novedades":
			case "sucursales":
			case "permisos":							
				$sql="SELECT * FROM `$tabla` WHERE `$tabla`.`$campo` LIKE '$crito' $otras ORDER BY `$orden` ASC";
			break;
			case "personalactivo, controlturnos":
				$sql="SELECT * FROM $tabla WHERE `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]' $otras ORDER BY personalactivo.`$orden` ASC";
			break;
			default:
				$sql="SELECT * FROM `$tabla` WHERE `$tabla`.`$campo` LIKE '$crito' AND `$tabla`.`sucursal` LIKE '$_SESSION[sucur]' $otras ORDER BY `$orden` ASC";	
			break;			
		}
		
		//die("<center>".$sql."</center>");
		
		if($link!=""){$consulta[datos]=@mysql_query($sql,$link) or $error=@mysql_error();}else{$consulta[datos]=@mysql_query($sql) or $error=@mysql_error();}
		
		//numero de registros de consulta
		
		$_SESSION['numreg']=@mysql_num_rows($consulta[datos]) or $error=@mysql_error();
		$_SESSION['clientemod']=@mysql_result($consulta[datos],$_SESSION['i'],$clave) or $error=@mysql_error();
		
		$consulta[numreg]=@mysql_num_rows($consulta[datos]) or $error=@mysql_error();
		
		if($error==""){//si no hay error retornar la consulta
                return $consulta;
                }else{//si hay error enviar la causa
                return $error;
                }
		break;		
	}
}
function numvigact($datos){
	$sql="SELECT * FROM personalactivo WHERE personalactivo.codigo LIKE '$datos[cliente]' AND personalactivo.activo	= 1";
	$consulta=@mysql_query($sql);
	$num2=@mysql_num_rows($consulta);
	return $num2;
}
/*
 * SELECT * FROM `cargos` WHERE `cargos`.`id` LIKE '%' AND (cargos.idsucursal = 1 OR cargos.idsucursal LIKE '2') ORDER BY `cargo`
 * SELECT * FROM `departamentos` WHERE `departamentos`.`id` LIKE '%' departamentos.sucursal LIKE '2') ORDER BY `departamento`SELECT * FROM `departamentospaises` WHERE `departamentospaises`.`ID_DPTO` LIKE '%' ORDER BY `NOMBRE`SELECT * FROM `ciudades` WHERE `ciudades`.`ID_CIUDAD` LIKE '%' AND ciudades.ID_DPTO='91' ORDER BY `NOMBRE`
 */
function selection($tabla,$clave,$criterio,$vectorcamposmostrar,$seleccionado,$numerocamposamostrar,$orden,$otrasentencias){
	$link=conectarim();
	
	$sql="SELECT * FROM `$tabla` WHERE `$tabla`.`$clave` LIKE '$criterio' $otrasentencias ORDER BY `$orden`";
	
	if($link==""){
	$cons=@mysql_query($sql);	
	}else{
	$cons=@mysql_query($sql, $link);	
	}
	
	$ini=0;
	$inic=1;
	$saltar=$vectorcamposmostrar[saltar];
	$lim=@mysql_num_rows($cons);
	
	for($ini=(0+$saltar);$ini<$lim;$ini++){
		if(@mysql_result($cons,$ini,$clave)==$seleccionado){
		$cadena.='<option selected="selected" value="'.@mysql_result($cons,$ini,$clave).'">';
		
		for($inic=1;$inic<=$numerocamposamostrar;$inic++){$cadena.=@mysql_result($cons,$ini,$vectorcamposmostrar[$inic])." ";}
		
		$cadena.="</option>";
		}else{
		$cadena.='<option value="'.@mysql_result($cons,$ini,$clave).'">';
		
		for($inic=1;$inic<=$numerocamposamostrar;$inic++){$cadena.=@mysql_result($cons,$ini,$vectorcamposmostrar[$inic])." ";}
		
		$cadena.="</option>";
		}
		$inic=1;
	}
	return $cadena;
}
function cargadepto($depto,$ciudad){
//die($depto.":".$ciudad);
    $_SESSION[cade]="";
    
    switch ($depto):
	case 91:
	include("departamentos/amazonas.inc");
	break;
	case "05":
	include("departamentos/antioquia.inc");
	break;	
	case 81:
	include("departamentos/arauca.inc");
	break;
	case 88:
	include("departamentos/sanandres.inc");
	break;
	case "08":
	include("departamentos/atlantico.inc");
	break;
	case 11:
	include("departamentos/bogota.inc");
	break;
	case 13:
	include("departamentos/bolivar.inc");
	break;
	case 15:
	include("departamentos/boyaca.inc");
	break;
	case 17:
	include("departamentos/caldas.inc");
	break;
	case 18:
	include("departamentos/caqueta.inc");
	break;
	case 85:
	include("departamentos/casanare.inc");
	break;
	case 19:
	include("departamentos/cauca.inc");
	break;
	case 20:
	include("departamentos/cesar.inc");
	break;
	case 27:
	include("departamentos/choco.inc");
	break;
	case 23:
	include("departamentos/cordoba.inc");
	break;
	case 25:	
	include("departamentos/cundinamarca.inc");
	break;
	case 94:
	include("departamentos/guainia.inc");
	break;
	case 95:
	include("departamentos/guaviare.inc");
	break;
	case 41:
	include("departamentos/huila.inc");
	break;
	case 44:
	include("departamentos/laguajira.inc");
	break;
	case 47:
	include("departamentos/magdalena.inc");
	break;
	case 50:
	include("departamentos/meta.inc");
	break;
	case 52:
	include("departamentos/narino.inc");
	break;
	case 54:
	include("departamentos/nortesantander.inc");
	break;
	case 86:
	include("departamentos/putumayo.inc");
	break;
	case 63:
	include("departamentos/quindio.inc");
	break;
	case 66:
	include("departamentos/risaralda.inc");
	break;
	case 68:
	include("departamentos/santander.inc");
	break;
	case 70:
	include("departamentos/sucre.inc");
	break;
	case 73:
	include("departamentos/tolima.inc");
	break;
	case 76:
	include("departamentos/valledelcauca.inc");
	break;
	case 97:
	include("departamentos/vaupes.inc");
	break;
	case 99:
	include("departamentos/vichada.inc");
	break;
	endswitch;
}
function consulturno($parametros){
	
	$cedula=$parametros[cedula];
	$mesbuscar=$parametros[mesbuscar];
	$clientebuscar=$parametros[clientebusca];
	
	$sqlx="SELECT * FROM personalactivo, controlturnos WHERE personalactivo.cedula LIKE controlturnos.cedulacontrol AND cedulacontrol = $cedula AND mescontrol LIKE '$mesbuscar'";
	//echo $sqlx;
	$consulturno=@mysql_query($sqlx);
	
	$diasdelmes=32; //establecer dias del mes
	
	for ($cont=1; $cont<$diasdelmes; $cont++){
	$diam="d".$cont;
	$nocm="n".$cont;
	$codbus="cod".$cont;
	$compara=@mysql_result($consulturno,0,$codbus);
	
		if($compara==$clientebuscar){
			$datos[$diam]=@mysql_result($consulturno,0,$diam);
			$datos[$nocm]=@mysql_result($consulturno,0,$nocm);
		}
	}
	
	return $datos;
}
function selecturno($parametros){
}
function saldoinv($idprod,$nou){
	//consulta de saldo de inventarios
	try{
	$reqpos="SELECT sum(cantidad) from movproductos WHERE idprod LIKE '$idprod' AND movproductos.nou = $nou AND sucursal LIKE '$_SESSION[sucur]' AND eos = 1";
	$reqneg="SELECT sum(cantidad) from movproductos WHERE idprod LIKE '$idprod' AND movproductos.nou = $nou AND sucursal LIKE '$_SESSION[sucur]' AND eos = 2";
	
	$res23=@mysql_query($reqpos);
	$res24=@mysql_query($reqneg);
	
	$existenciapos=@mysql_result($res23,0);
	$existencianeg=@mysql_result($res24,0);
	
	$disponible=$existenciapos-$existencianeg;
	}catch(Exception $error){
		
	}
	
return $disponible;
}
function exportartodo($parametros){

//parametros vector con valor parametros[tabla];
$_SESSION[tabla]=$parametros[tabla];

if($parametros[campos]!=""){$_SESSION[campos]=$parametros[campos];}else{$_SESSION[campos]="*";}

$_SESSION[condiciones]=$parametros[condiciones];

$cadena= '<table cellpadding="0" class="tabladocs" width="55%" align="center">
	  	<tr>
	  		<td align="left" colspan="3" >
			</td>
		</tr>
	  		  	
	  	<tr>
			<td>
			Exportar Informaci&oacute;n a Excel
			</td>
		</tr>
		
		<tr>
			
	 		<td>
			<a href="exportar.php" target="_blank"><input type="button" style="width:150px;" size="2" value="Generar" name="ejecut" src="imagenes/aa_19.gif"></a>
			</td>
		</tr>
		</table>	
	
';
return $cadena;
}
function operacionesfoto($tabla,$operacion,$datos1){

	//$datos;
	switch($operacion){
		case "buscar":
				
		$_SESSION[datos][campobusqueda]=$datos1[campobusqueda];
		$_SESSION[datos][crito]=$datos1[crito];
		$_SESSION[datos][opcion]=$datos1[opcion];
		$_SESSION[datos][orden]=$datos1[orden];
		$_SESSION[datos][claveprinc]=$datos1[claveprinc];
		$_SESSION[datos][otraconsulta]=$datos1[otraconsulta];
		
		//desde aqui aplica a todo el resto de consultas
		
		$campo=$_SESSION[datos][campobusqueda];
		$crito=$_SESSION[datos][crito];
		$clave=$_SESSION[datos][claveprinc];
		$otras=$_SESSION[datos][otraconsulta];
		$orden=$_SESSION[datos][orden];
		
		if($orden==""){$orden=$campo;}
				
		//para opcion mismo o cualquier
		
			if ($_SESSION[datos][opcion]==1){
			$crito="%". $crito. "%";
			}
		
		//AND `clientes`.`activo` = 1 falta en cada consulta poner switch para saber para cada tabla para el resto de consulta
		switch ($tabla){
			default:
				$sql="SELECT * FROM `$tabla` WHERE `$tabla`.`$campo` LIKE '$crito' AND `$tabla`.`sucursal` LIKE '$_SESSION[sucur]' $otras ORDER BY `$orden` ASC";	
			break;			
		}
		
		$consulta[datos]=mysql_query($sql);
		
		//numero de registros de consulta
		
		$_SESSION['numregf']=@mysql_num_rows($consulta[datos]);

		$consulta[numregf]=@mysql_num_rows($consulta[datos]);
		
		//control de registro a modificar
		
		$_SESSION['clientemodf']=@mysql_result($consulta[datos],$_SESSION['i'],$clave);
		
		return $consulta;
		break;		
	}
}
function consultarsaldo($datos, $link){

/*
$datos[idproducto]
$datos[nuevousado]
*/

	$reqpos="SELECT sum(cantidad) from `movproductos` WHERE idprod LIKE '$datos[idproducto]' AND sucursal LIKE '$_SESSION[sucur]' AND eos = 1 AND nou='$datos[nuevousado]'";
	$reqneg="SELECT sum(cantidad) from `movproductos` WHERE idprod LIKE '$datos[idproducto]' AND sucursal LIKE '$_SESSION[sucur]' AND eos = 2 AND nou='$datos[nuevousado]'";
	
	$res23=mysql_query($reqpos, $link) or die(mysql_error($link));
	$res24=mysql_query($reqneg, $link) or die(mysql_error($link));
	
	$existenciapos=@mysql_result($res23,0);
	$existencianeg=@mysql_result($res24,0);
	
	$existencia=$existenciapos-$existencianeg;

	return $existencia;
}
function formanterior($formviene, $formactual){
	
	$vector0=explode("/",$formviene);
	$elementos0=count($vector0);
	$form0=$vector0[$elementos0-1];
	
	$vector1=explode("/",$formactual);
	$elementos1=count($vector1);
	$form1=$vector1[$elementos1-1];
	
	if($form0!=$form1){
	$_SESSION['formanterior']=$form0;
	$igual=true;
	}else{
	$igual=false;	
	}
	
return $igual;	
}
	
function recortarcadena($cadenalarga, $longmaxima){
$numcaract=strlen($cadenalarga);
	
	if($numcaract>$longmaxima){
	$cadenacorta=substr($cadenalarga,0,$longmaxima)."..";
	}else{
	$cadenacorta=$cadenalarga;	
	}
	
return 	$cadenacorta;
}
function selectnombreletras($numopcion, $campo){
switch($campo){
case "modalidadservicio":
		switch($numopcion){
		case "1";
		$cadena="Fijo sin Arma";
		break;
		case "2";
		$cadena="Fijo con Arma Letal";
		break;
		case "3";
		$cadena="Fijo con Arma no Letal";
		break;
		case "4";
		$cadena="Movil sin Arma";
		break;
		case "5";
		$cadena="Movil con Arma Letal";
		break;
		case "6";
		$cadena="Movil con Arma no letal";
		break;
		}
break;
case "diastrabajo":
		switch($numopcion){
		case "1";
		$cadena="Lunes a Domingo";
		break;
		case "2";
		$cadena="Sabado y Domingo";
		break;
		case "3";
		$cadena="Lunes a Viernes";
		break;
		case "4";
		$cadena="Lunes a Viernes con refuerzo";
		break;
		case "5";
		$cadena="Otro";
		break;
		}
break;	
case "tipoarma":
		switch($numopcion){
		case "1";
		$cadena="Revolver";
		break;
		case "2";
		$cadena="Pistola";
		break;
		case "3";
		$cadena="Escopeta";
		break;
		case "4";
		$cadena="Fusil";
		break;
		case "5";
		$cadena="Ametralladora";
		break;
		case "6";
		$cadena="Miniuzi";
		break;
		case "7";
		$cadena="No letal";
		break;
		}
break;
case "clasepermiso":
		switch($numopcion){
		case "1";
		$cadena="Tenencia";
		break;
		case "2";
		$cadena="Porte";
		break;
		}
break;
case "calibre":
		switch($numopcion){
		case "38c";
		$cadena="38 Corto";
		break;
		case "32l";
		$cadena="32 Largo";
		break;
		case "32c";
		$cadena="32 Corto";
		break;
		case "9mm";
		$cadena="9 Milimetros";
		break;
		case "16m";
		$cadena="Escopeta 16";
		break;
		case "12m";
		$cadena="Escopeta 12";
		break;
		case "38l";
		$cadena="38 Largo";
		break;
		}
break;
}
return $cadena;
}
function cambiar2meses($fecha, $hasta){
$fecha1=$fecha;
$fecha1des=explode("-",$fecha1);
$fecha2=date('d-m-Y',mktime(0,0,0, $fecha1des[1],$fecha1des[0]+$hasta-1,$fecha1des[2]));
$fecha2des=explode("-",$fecha2);

if($fecha1des[1]==$fecha2des[1] && $fecha1des[2]==$fecha2des[2]){
$retorno["cambia"]="no";	
}else{
$retorno["cambia"]="si";
$retorno["ultimodiames1"]=date('t',mktime(0,0,0, $fecha1des[1],"1",$fecha1des[2]));
$retorno["ultimodiames2"]=date('d',mktime(0,0,0, $fecha1des[1],$fecha1des[0]+$hasta-1,$fecha1des[2]));;	
}

return $retorno;
}
function selectcliente($cedula, $cliente, $clierelevante){
if($clierelevante=="1"){	
$select="<select name=\"codcliente-$cedula\"  class=\"medio1\">";	
$mostra[1]="codigo";
$mostra[2]="nombrecliente";
$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]' AND `clientes`.`clierelevante`='0'";
$select.=selection("clientes","codigo","%",$mostra,"",2,"codigo",$otras)."</select>";
}else{
$select=$cliente;	
}
return $select;
}
function opciones($vectoro){
$numefilas0=count($vectoro);	

for($ini=0;$ini<$numefilas0;$ini++){
if($ini!=0 ){
	if($vectoro["etiquetas-".$ini]!=""){
	$numefilas++;
	}	
}	
	
}	
$numefilas;
for($in=1;$in<=$numefilas;$in++){
if($vectoro["seleccionado-".$in]=="si"){
$cadena.="<option value=\"".$vectoro["valores-".$in]."\" selected=\"selected\">".$vectoro["etiquetas-".$in]."</option>";	
}else{	
$cadena.="<option value=\"".$vectoro["valores-".$in]."\">".$vectoro["etiquetas-".$in]."</option>";
}	
}
return $cadena;
}
function armarmenu($idusuario){

                $razon=caracteresiso();
                if($razon!=""){
		$menu='
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="scripts/jquery.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="scripts/sexyalertbox.v1.2.jquery.js"></script>
		<link rel="stylesheet" type="text/css" media="all" href="estilos/sexyalertbox.css"/>
		<link rel="stylesheet" type="text/css" href="estilos/jGlideMenu.css" />
		<script type="text/javascript" src="scripts/jQuery.jGlideMenu.067.min.js"></script>
		<script type="text/javascript">
				$(document).ready(function(){
					// Initialize Menu
					$(\'#jGlide_001\').jGlideMenu({
						tileSource	: \'.jGlide_001_tiles\' , 
						demoMode	: false 
					}).show();
		
					// Connect "Toggle" Link	
					$(\'#switch\').click(function(){$(this).jGlideMenuToggle();});
				});
			</script>
		</head>
		<body>';
		
		$menu.="
		<div class=\"menudiv1\">
		<a href=\"menu.php\" id=\"switch\">Mostrar Menu</a><!-- Menu Holder -->
		<div class=\"jGM_box\" id=\"jGlide_001\">
			<!-- Tiles for Menu -->";
		
		$menu.="<ul id=\"tile_001\" class=\"jGlide_001_tiles\" title=\"Menu\" alt=\"$razon\">
			<li><a href=\"inicio.php\">Inicio</a></li>
			<li rel=\"tile_002\">Talento Humano</li>
			<li rel=\"tile_003\">Almac&eacute;n</li>
			<li rel=\"tile_004\">Clientes</li>
			<li rel=\"tile_005\">Radioperaci&oacute;n</li>
			<li rel=\"tile_006\">Control de Servicios</li>
			<li rel=\"tile_007\">Escoltas</li>
			<li rel=\"tile_008\">Correspondencia</li>
			<li rel=\"tile_009\">Sistema</li>
			<li rel=\"tile_010\">Organizaci&oacute;n</li>
			<li><a href=\"ayudainfotech.pdf\">Ayuda</a></li>
			<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		<ul id=\"tile_002\" class=\"jGlide_001_tiles\" title=\"Talento Humano\" alt=\"Informaci&oacute;n de Personal\">
			<li rel=\"tile_200\">Personal Activo</li>
			<li rel=\"tile_201\">Personal Inactivo</li>
			<li rel=\"tile_202\">Aspirantes</li>
			<li rel=\"tile_203\">Verificaci&oacute;n Documental</li>
			<li rel=\"tile_204\">Historial Disciplinario</li>
                        <li rel=\"tile_205\">Antecedentes</li>
			<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_200\" class=\"jGlide_001_tiles\" title=\"Personal Activo\" alt=\"Informaci&oacute;n de Personal Activo\">
		<li><a href=\"personalactivo3.php\">Personal Activo</a></li>
		<li><a href=\"documentospersonalactivo.php\">Documentos Personal Activo</a></li>
		</ul>
		
		<ul id=\"tile_201\" class=\"jGlide_001_tiles\" title=\"Personal Retirado\" alt=\"Informaci&oacute;n de Personal Retirado\">
		<li><a href=\"personalretirado3.php\">Personal Inactivo</a></li>
		<li><a href=\"documentospersonalretirado.php\">Documentos Personal Retirado</a></li>
		</ul>
		
		<ul id=\"tile_202\" class=\"jGlide_001_tiles\" title=\"Aspirantes\" alt=\"Informaci&oacute;n de Aspirantes\">
		<li><a href=\"aspirantes.php\">Aspirantes a Funcionarios</a></li>
		<li><a href=\"documentosaspirantes.php\">Documentos Aspirantes</a></li>
		</ul>
		
		<ul id=\"tile_203\" class=\"jGlide_001_tiles\" title=\"Documentaci&oacute;n\" alt=\"Verificaci&oacute;n de Documentaci&oacute;n\">
		<li><a href=\"verificacion3.php\">Verificaci&oacute;n Documental</a></li>
		<li><a href=\"documentosverificacion.php\">Documentos Verificaci&oacute;n</a></li>
		</ul>
		
		<ul id=\"tile_204\" class=\"jGlide_001_tiles\" title=\"Disciplinario\" alt=\"Informaci&oacute;n Disciplinaria\">
		<li><a href=\"novedades3.php\">Historial Disciplinario</a></li>
		<li><a href=\"documentosnovedades.php\">Documentos Historial Disciplinario</a></li>
		</ul>

                <ul id=\"tile_205\" class=\"jGlide_001_tiles\" title=\"Antecedentes\" alt=\"Verificacion de Antecedentes\">
		<li><a href=\"antecedentes.php\">Antecedentes</a></li>
		</ul>

		<ul id=\"tile_003\" class=\"jGlide_001_tiles\" title=\"Almac&eacute;n\" alt=\"Informaci&oacute;n de Almac&eacute;n e Intendencia\">
                        <li rel=\"tile_300_0\">Requisici&oacute;n</li>
                        <li rel=\"tile_300_1\">Ordenes de Compra</li>
                        <li rel=\"tile_300\">Proveedores</li>
			<li rel=\"tile_301\">Productos</li>
			<li rel=\"tile_302\">Dotaci&oacute;nes</li>
			<li rel=\"tile_303\">Armamento</li>
			<li rel=\"tile_304\">Radios</li>
			<li><a href=\"salir.php\">Salir</a></li>
		</ul>

                <ul id=\"tile_300_0\" class=\"jGlide_001_tiles\" title=\"Requisici&oacute;n\" alt=\"Informaci&oacute;n de Requisiciones\">
		<li><a href=\"requisiciones.php\">Elaboraci&oacute;n Requisici&oacute;n</a></li>
                <li><a href=\"apruebarequisicion.php\">Estado de Requisici&oacute;n</a></li>
		<li><a href=\"documentosreq.php\">Documentos Requisiciones</a></li>
		</ul>

                <ul id=\"tile_300_1\" class=\"jGlide_001_tiles\" title=\"Ordenes de Compra\" alt=\"Ordenes de Compra\">
		<li><a href=\"ordenescompra.php\">Ordenes de Compra</a></li>
		<li><a href=\"documentosordenescompra.php\">Documentos Ordenes</a></li>
		</ul>
                
		<ul id=\"tile_300\" class=\"jGlide_001_tiles\" title=\"Proveedores\" alt=\"Informaci&oacute;n de Proveedores\">
		<li><a href=\"proveedores.php\">Proveedores</a></li>
		<li><a href=\"documentosproveedores.php\">Documentos Proveedores</a></li>
		</ul>
		
		<ul id=\"tile_301\" class=\"jGlide_001_tiles\" title=\"Productos\" alt=\"Informaci&oacute;n de Productos\">
		<li><a href=\"existencias3.php\">Productos</a></li>
		<li rel=\"tile_3011\">Existencias de Productos</li>
		</ul>
		
		<ul id=\"tile_3011\" class=\"jGlide_001_tiles\" title=\"Existencias\" alt=\"Informaci&oacute;n de Existencias\">
		<li><a href=\"controlinvent3.php\">Existencias de Productos</a></li>
		<li><a href=\"documentosexistencias.php\">Documentos Existencias</a></li>
		</ul>
		
		<ul id=\"tile_302\" class=\"jGlide_001_tiles\" title=\"Dotaciones\" alt=\"Informaci&oacute;n de Dotaciones\">
		<li><a href=\"dotacion.php\">Dotaci&oacute;n Personal</a></li>
		<li><a href=\"documentosdotacion.php\">Documentos Dotaci&oacute;n Personal</a></li>
		<li><a href=\"dotacioncliente.php\">Dotaci&oacute;n Clientes</a></li>
		<li><a href=\"documentosdotacioncliente.php\">Documentos Dotaci&oacute;n Clientes</a></li>
		<li><a href=\"dotacioninterna.php\">Dotaci&oacute;n Interna</a></li>
		<li><a href=\"documentosdotacioninterna.php\">Documentos Dotaci&oacute;n Interna</a></li>
		</ul>
		
		<ul id=\"tile_303\" class=\"jGlide_001_tiles\" title=\"Armamento\" alt=\"Informaci&oacute;n de Armas\">
		<li><a href=\"armas3.php\">Armamento</a></li>
		<li><a href=\"documentosarmas.php\">Documentos Armamento</a></li>
		</ul>
		
		<ul id=\"tile_304\" class=\"jGlide_001_tiles\" title=\"Radios\" alt=\"Informaci&oacute;n de Radios\">
		<li><a href=\"radios3.php\">Radios</a></li>
		<li><a href=\"documentosradios.php\">Documentos Radios</a></li>
		</ul>
		
		<ul id=\"tile_004\" class=\"jGlide_001_tiles\" title=\"Clientes\" alt=\"Informaci&oacute;n de Clientes\">
		<li rel=\"tile_400\">Clientes Activos</li>
		<li rel=\"tile_401\">Clientes Inactivos</li>
		<li rel=\"tile_402\">Calidad</li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_400\" class=\"jGlide_001_tiles\" title=\"Clientes Activos\" alt=\"Informaci&oacute;n de Clientes\">
		<li><a href=\"clientes3.php\">Clientes Activos</a></li>
		<li><a href=\"documentosclientes.php\">Documentos Clientes Activos</a></li>
		</ul>
		
		<ul id=\"tile_401\" class=\"jGlide_001_tiles\" title=\"Clientes Inactivos\" alt=\"Informaci&oacute;n de Clientes Inactivos\">
		<li><a href=\"clienteret.php\">Clientes Inactivos</a></li>
		<li><a href=\"documentosclientesret.php\">Documentos Clientes Inactivos</a></li>
		</ul>
		
		<ul id=\"tile_402\" class=\"jGlide_001_tiles\" title=\"Calidad\" alt=\"Informaci&oacute;n de Calidad\">
		<li><a href=\"procesocomercial3.php\">Ofertas Comerciales</a></li>
		<li><a href=\"documentosnecesidades.php\">Documentos Ofertas</a></li>
		<li><a href=\"condiciones3.php\">Condiciones de Instalaci&oacute;n</a></li>
		<li><a href=\"documentoscondiciones.php\">Documentos Condiciones</a></li>
		</ul>
		
		<ul id=\"tile_005\" class=\"jGlide_001_tiles\" title=\"Radioperaci&oacute;n\" alt=\"Informaci&oacute;n de Radioperaci&oacute;n\">
		<li><a href=\"radioperacion.php\">Radioperaci&oacute;n</a></li>
		<li><a href=\"documentosradioperacion.php\">Documentos Radioperaci&oacute;n</a></li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_006\" class=\"jGlide_001_tiles\" title=\"Control Servicios\" alt=\"Informaci&oacute;n de Control de Servicios\">
		<li rel=\"tile_600\">Control de Asistencia</li>
		<li rel=\"tile_601\">Ordenes de Servicio</li>
		<li rel=\"tile_602\">Programaci&oacute;n</li>
		<li><a href=\"controlturnos.php\">Control Individual</a></li>
		<li><a href=\"controlcliente.php\">Control por Cliente</a></li>
		<li><a href=documentoscontrolturnos.php\">Documentos Control Servicios</a></li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_600\" class=\"jGlide_001_tiles\" title=\"Control de Asistencia\" alt=\"Control de Asistencia\">
		<li><a href=\"asistencia.php\">Control de Asistencia</a></li>
		<li><a href=\"documentosasistencia.php\">Documentos Control Asistencia</a></li>
		</ul>
		
		<ul id=\"tile_601\" class=\"jGlide_001_tiles\" title=\"Radioperaci&oacute;n\" alt=\"Informaci&oacute;n de Radioperaci&oacute;n\">
		<li><a href=\"ordenes3.php\">Ordenes de Servicio</a></li>
		<li><a href=\"documentosordenes.php\">Documentos Ordenes de Servicio</a></li>
		</ul>
		
		<ul id=\"tile_602\" class=\"jGlide_001_tiles\" title=\"Programaci&oacute;n\" alt=\"Programaci&oacute;n de Servicios\">
		<li><a href=\"programacion.php\">Programaci&oacute;n</a></li>
		<li><a href=\"documentosprogramacion.php\">Documentos Programaci&oacute;n</a></li>
		</ul>
		
		<ul id=\"tile_007\" class=\"jGlide_001_tiles\" title=\"Escoltas\" alt=\"Informaci&oacute;n de Escoltas\">
		<li><a href=\"escoltas3.php\">Escoltas</a></li>
		<li><a href=\"documentosescoltas.php\">Documentos Escoltas</a></li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_008\" class=\"jGlide_001_tiles\" title=\"Correspondencia\" alt=\"Informaci&oacute;n de Correspondencia\">
		<li><a href=\"correspondencia3.php\">Correspondencia</a></li>
		<li><a href=\"documentoscorrespondencia.php\">Documentos Correspondencia</a></li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_009\" class=\"jGlide_001_tiles\" title=\"Sistema\" alt=\"Informaci&oacute;n de Sistema\">
		<li><a href=\"sistema3.php\">Sistema</a></li>
		<li><a href=\"usuarios.php\">Usuarios</a></li>
		<li><a href=\"permisos.php\">Permisos</a></li>
		<li><a href=\"parametros.php\">Parametros</a></li>
		<li><a href=\"modificardocs.php\">Modificaci&oacute;n de Documentos</a></li>
		<li><a href=\"editordocs.php\">Editor de Documentos</a></li>
                <li><a href=\"backup.php\">Backup</a></li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>
		
		<ul id=\"tile_010\" class=\"jGlide_001_tiles\" title=\"Organizaci&oacute;n\" alt=\"Informaci&oacute;n de Organizaci&oacute;\">
		<li><a href=\"empresa3.php\">Organizaci&oacute;n</a></li>
		<li><a href=\"documentosempresa.php\">Documentos Organizaci&oacute;n</a></li>
		<li rel=\"tile_100\">Socios</li>
		<li><a href=\"sucursales.php\">Sucursales</a></li>
		<li rel=\"tile_011\">Departamentos</li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>

                <ul id=\"tile_011\" class=\"jGlide_001_tiles\" title=\"Departamentos\" alt=\"Departamentos de la Organizacion\">
		<li><a href=\"departamentos.php\">Deptos Activos</a></li>
		<li><a href=\"departinactivos.php\">Deptos Inactivos</a></li>
		<li><a href=\"salir.php\">Salir</a></li>
		</ul>

		<ul id=\"tile_100\" class=\"jGlide_001_tiles\" title=\"Sistema\" alt=\"Informaci&oacute;n de Sistema\">
		<li><a href=\"socios3.php\">Socios</a></li>
		<li><a href=\"documentossocios.php\">Documentos Socios</a></li>
		</ul>
		
		</div>
		<!-- Menu Holder -->
		</div></body>
		</html>";
		
		print($menu);
		}
			
}

function crearcons($idmodulo, $tipopermisoprimario, $idus){
//consulta de tablas para asignar permisos
$sql0="SELECT * FROM `tablas`, `modulos`, `tablamodulo` WHERE `modulos`.`id`=`tablamodulo`.`idmodulo` AND `tablamodulo`.`idtabla`=`tablas`.`id` AND `modulos`.`id`='$idmodulo'";
$cons=@mysql_query($sql0);
$numf=@mysql_num_rows($cons);
//consuta de nombre de usuario
$sql1="SELECT * FROM `usuarios` WHERE `usuarios`.`id`='$idus'";
$consu=@mysql_query($sql1);
$nombreusuario=@mysql_result($consu,0,"usuario");
//consulta para saber si el paciente tiene el permiso asignado
$sql2="SELECT * FROM `permisos` WHERE `permisos`.`idusuario`='$idus' AND `permisos`.`idmodulo`='$idmodulo' LIMIT 1";
$consul=@mysql_query($sql2);
$tipoasignado=@mysql_result($consul,0,"tipopermiso");

if($numf > 0){
	for($i=0;$i<$numf;$i++){
		
	$tipopermisorequerido=@mysql_result($cons, $i,"tipopreq");//permiso prestablecido para hacer uso de modulo correspondiente a tabla derivada
	
		if($tipopermisoprimario=="0" && $tipoasignado!=""){//ningun permiso eliminar permisos
		$indice=$_SESSION['permisosrev']++;
		$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` FROM '$nombreusuario'@'localhost'";
		}else if($tipopermisorequerido=="1" && $tipopermisoprimario!="0"){
		$indice=$_SESSION['permisosdar']++;
		$_SESSION['arrpermisos']['dar'][$indice]="GRANT SELECT ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` TO '$nombreusuario'@'localhost'";
		$indice=$_SESSION['permisosrev']++;
		$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` FROM '$nombreusuario'@'localhost'";
		}else if($tipopermisorequerido=="2" && $tipopermisoprimario!="0"){
		$indice=$_SESSION['permisosdar']++;	
		$_SESSION['arrpermisos']['dar'][$indice]="GRANT SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` TO '$nombreusuario'@'localhost'";
		$indice=$_SESSION['permisosrev']++;
		$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` FROM '$nombreusuario'@'localhost'";
		}else if($tipopermisorequerido=="3" && $tipopermisoprimario!="0"){
			if($tipopermisoprimario=="0"){
			$indice=$_SESSION['permisosrev']++;
			$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` FROM '$nombreusuario'@'localhost'";
			}else if($tipopermisoprimario=="1"){
			$indice=$_SESSION['permisosdar']++;
			$_SESSION['arrpermisos']['dar'][$indice]="GRANT SELECT ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` TO '$nombreusuario'@'localhost'";
			$indice=$_SESSION['permisosrev']++;
			$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` FROM '$nombreusuario'@'localhost'";
			}else if($tipopermisoprimario=="2"){
			$indice=$_SESSION['permisosdar']++;
			$_SESSION['arrpermisos']['dar'][$indice]="GRANT SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` TO '$nombreusuario'@'localhost'";
			$indice=$_SESSION['permisosrev']++;
			$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE ON `relacional`.`".@mysql_result($cons,$i,"nombretabla")."` FROM '$nombreusuario'@'localhost'";
			}
		}
		if($idmodulo=="48"){//si se estan modificando permisos para agregar usuarios dar permisos grant option
			if($tipopermisoprimario=="0" && $tipoasignado!=""){
			$indice=$_SESSION['permisosrev']++;
			$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE, GRANT OPTION  ON `mysql`.`user` FROM '$nombreusuario'@'localhost'";
			$indice=$_SESSION['permisosrev']++;
			$_SESSION['arrpermisos']['revocar'][$indice]="GRANT RELOAD ON *.* TO '$nombreusuario'@'localhost';";
			}else if($tipopermisoprimario=="2"  && $tipopermisoprimario!="0"){
			$indice=$_SESSION['permisosdar']++;
			$_SESSION['arrpermisos']['dar'][$indice]="GRANT SELECT, INSERT, UPDATE, DELETE, GRANT OPTION  ON `mysql`.`user` TO '$nombreusuario'@'localhost'";
			$indice=$_SESSION['permisosdar']++;
			$_SESSION['arrpermisos']['dar'][$indice]="REVOKE RELOAD ON *.* FROM '$nombreusuario'@'localhost';";
			}
		}
		if($idmodulo=="57"){//si se estan modificando permisos para agregar cambiar permisos dar permisos grant option
			if($tipopermisoprimario=="0" && $tipoasignado!=""){
			$indice=$_SESSION['permisosrev']++;
			$_SESSION['arrpermisos']['revocar'][$indice]="REVOKE SELECT, INSERT, UPDATE, DELETE, GRANT OPTION  ON `relacional`.* FROM '$nombreusuario'";
			}else if($tipopermisoprimario=="2"  && $tipopermisoprimario!="0"){
			$indice=$_SESSION['permisosdar']++;
			$_SESSION['arrpermisos']['dar'][$indice]="GRANT SELECT, INSERT, UPDATE, DELETE, GRANT OPTION  ON `relacional`.* TO '$nombreusuario'@'localhost'";
			}
		}
					
	}	
}
}
 
function ejecutarcons(){

$link=conectarim();
	
$numrevocar=$_SESSION['permisosrev'];
$numdar=$_SESSION['permisosdar'];

/*
echo "<center>dar-";
print_r($_SESSION['arrpermisos']['dar']);
echo "</center>-dar";
*/

if($numrevocar>0){
	for($ini=0;$ini<$numrevocar;$ini++){
		if(isset($_SESSION['arrpermisos']['revocar'][$ini])){
		//echo "<center>sentenr -".$_SESSION['arrpermisos']['revocar'][$ini]."<br></center>";	
			@mysql_query($_SESSION['arrpermisos']['revocar'][$ini], $link) or $error=@mysql_error($link)." funciones2 - ".$_SESSION[arrpermisos][revocar][$ini];
		}	
	}
}

if($numdar>0){
	for($ini=0;$ini<$numdar;$ini++){
		if(isset($_SESSION['arrpermisos']['dar'][$ini])){
		//echo "<center>sentend -".$_SESSION['arrpermisos']['dar'][$ini]." $ini<br></center>";	
			@mysql_query($_SESSION['arrpermisos']['dar'][$ini], $link) or $error=@mysql_error($link)." funciones2 - ".$_SESSION[arrpermisos][dar][$ini];
		}
	}
}

return $error;	
}
function verificarpys($iddotacion, $cedulapaciente, $link){
	try{

	if($iddotacion!="" && $cedulapaciente!=""){
	$sql="SELECT pazysalvo FROM `dotacion` WHERE `dotacion`.`ceduladot`='$cedulapaciente' AND `dotacion`.`iddot`='$iddotacion'";

	$cons=mysql_query($sql, $link);
	$numf=mysql_num_rows($cons);

		for($ini=0;$ini<$numf;$ini++){
			$campo=mysql_result($cons, $ini, "pazysalvo");
			if($campo!=1){
			return false;	
			}
		}
		
	return true;	
	}else{
	return false;	
	}
	}catch(Exception $err){
		
	}
	return true;
}
function listapersprog($array){
			
			$numero2 = count($array);
			$tags2 = array_keys($array); // obtiene los nombres de las varibles
			$valores2 = array_values($array);// obtiene los valores de las varibles
			$cont=0;
			$sentencli="";
			
			for($contador=0;$contador<$numero2;$contador++){//almacenar variables de clientes
				
				$codigos=explode("cliente-",$tags2[$contador]);
				$codigosc[$contador]=$codigos[1];
				
				if($array["cliente-".$codigosc[$contador]]=="on"){//guardar en session los clientes que fueron seleccionados
						if($sentencli==""){
						$sentencli.="`personalactivo`.`codigo`='$codigosc[$contador]'";
						}else{
						$sentencli.=" OR `personalactivo`.`codigo`='$codigosc[$contador]'";	
						}
				}
			}
			
			$sql="SELECT * FROM `personalactivo` WHERE $sentencli ORDER BY `codigo`, `apellidos`";
			
			return sentencli($sql);
			
}
function sentencli($senten, $l=0){
	
			$cons=mysql_query($senten);
			$ini=0;
			$numpac=mysql_num_rows($cons);
			
			for($ini=0;$ini<$numpac;$ini++){
				
			$cedula=mysql_result($cons,$ini,"cedula");
			$nombre=mysql_result($cons,$ini,"apellidos")." ".mysql_result($cons,$ini,"nombre");
				if($l==0){	
				$listapacientes.="<div align=\"left\"><input name=\"persona-$cedula\" id=\"persona-$cedula\" type=\"checkbox\">$cedula<br/>$nombre<hr></div>";
				$_SESSION['paramprograma']['cedulas'][$ini]=$cedula;
				}else{
				$listapacientes.="<div align=\"left\"><input name=\"relpersona-$cedula\" id=\"relpersona-$cedula\" type=\"checkbox\">$cedula<br/>$nombre<hr></div>";	
				$_SESSION['paramprograma']['cedulasrel'][$ini]=$cedula;	
				}
			}
			
			return $listapacientes;
}

function mostrarfilas($vectordatos){

	$dias0=NumDias($vectordatos['ano'], $vectordatos['mes']);

	//validar numero de personas requeridas y en datos para la programacion
	if(suficientepersonal($vectordatos)){
		
		$todosclientes="\n<table border=\"0\" class=\"programacion\">\n";
		
		$todosclientes.=encabezado($dias0, $vectordatos['mes'], $vectordatos['ano']);
		
		$stilodescanso=" style=\"background:#000000\"";
		
		$historialrelevos=array();
		
		for($j=0;$j<$vectordatos['numclientes'];$j++){//iteracion sobre los clientes
		
		$clie=$vectordatos['clientes'][$j];
		
		$filacliente="\n<tr><td class=\"encabezado\" colspan=\"3\" style=\"font-size:8px\"><b>$clie:</b></td></tr>\n";
		$saltodct=0;

		if($vectordatos["param-$clie"]['Numd']>0 && !isset($relevante)){//si los descansos son mayor que 0 y no se asigno nigun relevante aun
		$relevante="1";
		$cadacuantosdiasrel=floor($dias0['numdias']/$vectordatos["param-$clie"]['Numd']);
		}

		$lim=@ceil($vectordatos["param-$clie"]['HDS']/$vectordatos["param-$clie"]['DT']);
		
		if($lim>0){//verificar 

		$turnoscliente="";
		
				for($k=1;$k<=$lim;$k++){//iteracion sobre turnos
				$turnopersonas="";
			
					for($i=1;$i<=$vectordatos["param-$clie"]["Npers-$k"];$i++){//iteracion sobre numero de personas asignadas por turno
					
					$filapersonas0=armarfila($saltodct, $k, $vectordatos["param-$clie"], $dias0, $vectordatos['ano'], $vectordatos['mes']);
					$filapersonas=$filapersonas0['filapaciente'];
					$historialrelevos=sumarelevos($dias0['numdias'], $historialrelevos, $filapersonas0['relevospaciente']);
					
						if($saltodct<=@floor($dias0['numdias']/$vectordatos["param-$clie"]['Numd'])){//resetear persona a 0 si es mayor del ciclo $cadacuantos dias
							//armado de figura de turnos rotativa segun la politica de descansos
							$saltodct+=$vectordatos["param-$clie"]['Prr'];	
						}else{//cada vez que reinicia ciclo se requiere relevante adicional
							$saltodct=0;
						}
					//$turnopersonas.=$filapersona.$diaspersona."</tr>";
					$turnopersonas.=$filapersonas;
					}
				$filacliente.=$turnopersonas;
				}
		}else{$filacliente.="<td colspan=\"20\">Debe agregar parametros para programacion</td>";}
		$todosclientes.=$filacliente;
		}
		
		$todosclientes.=todosrelevantes($historialrelevos, $vectordatos, $dias0);
		
		/*
			for($ini=1;$ini<=$relevante;$ini++){
				if($vectordatos["param-$clie"]['Numd']>0){//si los descansos son dif de 0
				$todosclientes.=armarfilarel($vectordatos, $celdasrelevante[$ini], $dias0['numdias'], $ini);
				}
		    }
		*/
		
	$todosclientes.="</table>";
	
	arsort($historialrelevos);

	}else{
	$todosclientes="No es posible efectuar programaci&oacute;n hace falta personal <br/><input name=\"siguiente\" value=\"Continuar-2\" type=\"submit\" onclick=\"return validaprogramacion();\"/>";	
	}
	
	return $todosclientes;	
}
function sumarelevos($numdias, $array1, $array2){
	
$suma=array();
	
for($ini=1;$ini<=$numdias;$ini++){
	$suma[$ini]=$array1[$ini] + $array2[$ini];
}	

return $suma;	
}

function armarfila($saltodct, $turno, $datos, $dias, $ano, $mes){
	
		$fila="<tr><td>Doc $saltodct</td><td>Nom $saltodct</td><td>Apell $saltodct</td>";
		$diaspersona="";
		$relevos=hallarrelevos($dias, $datos, $saltodct, $ano, $mes);
		$relevospac=array();
		
		for($ini=1;$ini<=$dias['numdias'];$ini++){//iteracion de dias
			if($relevos[$ini]=="d"){
				$diaspersona.="<td width=\"30px\" ".estilocelda($turno,"").">d</td>";
				$relevospac[$ini]++;
			}elseif($relevos[$ini]=="c"){
				$diaspersona.="<td width=\"30px\" ".estilocelda($turno,"2").">c</td>";
				$relevospac[$ini]++;
			}elseif($relevos[$ini]=="n"){//no aplica turno ese dia
				$diaspersona.="<td width=\"30px\">n/a</td>";
			}else{
				$diaspersona.="<td width=\"30px\" ".estilocelda($turno,"1").">c</td>";
			}
		}
		$fila.=$diaspersona."<tr>";
		
$retorno['filapaciente']=$fila;
$retorno['relevospaciente']=$relevospac;
		
return $retorno;	
}
function todosrelevantes($relevosnecesarios, $datos, $dias){//funcion para armar las celdas de los relevantes teniendo en cuenta la politica de descanso
echo "<center>";
print_r($relevosnecesarios);
"</center>";
/*	
$numrel=0;	
$filasrel="";	

	for($ini=1;$ini<=$dias['numdias'];$ini++){
		
		if($ini<10){$ini0="0".$ini;}else{$ini0=$ini;}//el valor del dia viene 1 y el array trae 01
		
	}
*/	
}
function armarfilarel($datos, $celdas, $numdias, $numrel){
	//die(print_r($celdas));
	
for($ini=0;$ini<=$numdias;$ini++){
if($ini==0){
$filapac="<tr><td>Cedr$numrel</td><td>Nomr$numrel</td><td>Apellr$numrel</td>";	
}elseif($descansos[$ini]=="d"){
$filapac.="<td ".estilocelda($celdas[$ini]['estilo'], $celdas[$ini]['esdesc'])."></td>";	
}else{
$filapac.="<td ".estilocelda($celdas[$ini]['estilo'], $celdas[$ini]['esdesc'])."></td>";	
}
}	

return $filapac;
}
function estilocelda($k, $esdescanso){
$estilo="";

if($esdescanso=="1"){//es dia de trabajo normal 
switch($k){
	case 1:
	$estilo="style=\"background:#ff0033\"";	
	break;
	case 2:
	$estilo="style=\"background:#ffcc33\"";	
	break;
	case 3:
	$estilo="style=\"background:#ffcccc\"";	
	break;
	case 4:
	$estilo="style=\"background:#bbbbbb\"";	
	break;
	case 5:
	$estilo="style=\"background:#ff0033\"";	
	break;
	case 6:
	$estilo="style=\"background:#ff0033\"";	
	break;		
}
}elseif($esdescanso=="2"){//es cambio de turno
	$estilo="style=\"background:#0033ff\"";
}else{//es descanso
	$estilo="style=\"background:#000000\"";
}

return $estilo;	
}
function hallarrelevos($dias, $paramclie, $saltodct, $ano, $mes){

$relevos=array();

$diasefectivos=diasefect($dias, $paramclie);

if($paramclie['Numd']!=0 || $paramclie['NumCT']!=0){	
	
	$cadacuantosdiasdesc=floor($diasefectivos/$paramclie['Numd'])-1;
	$cadacuantosdiasct=floor($diasefectivos/$paramclie['NumCT'])-1;

	$diasemana=$dias['ultimodia'];
	
	$asignarluegod=0;	//variable para asignar descanso en un dia que no sea el coincidente con $cadacuantosdias.
	$asignarluegoct=0;
	
	for($ini=$dias['numdias'];$ini>=1;$ini--){//iteracion de dias
		
	 if($paramclie["dia-$diasemana"]=="si"){//si es un dia de servicio para el cliente
	 	
	 	if($saltodct>=$cadacuantosdiasdesc){//si el salto es mayor a cada cuanto descansa la persona

	 			$diasemana0 = mktime (0,0,0, $mes, $saltodct-$cadacuantosdiasdesc-1, $ano);
				$dia = date('w', $diasemana0);
					
				if($paramclie["dia-$dia"]=="si"){//si el dia esta es de servicio asignar de una, sino luego.
		 		$relevos[$dias['numdias']-($saltodct-$cadacuantosdiasdesc-1)]="d";
				}else{
				$asignarluegod=1;	
				}
	 	}
	 	
	 	if($saltodct>=$cadacuantosdiasct){
	 		//echo "<center>a la persona le falta un cambio de turno</center>";
	 		$relevos[$dias['numdias']-($saltodct-$cadacuantosdiasdesc)]="c";
	 	}
	 	
		if($ini==$dias['numdias'] || $diasdespuesdesc==$cadacuantosdiasdesc || $asignarluegod==1){//marca descanso cada ciclo cadacuantosdias empezando por ultimo dia
			if(!isset($relevos[$ini-$saltodct])){//si el turno no esta asignado
			$relevos[$ini-$saltodct]="d";
			$diasdespuesdesc=0;
			$asignarluegod=0;
			}else{//asignar luego
			$asignarluegod=1;	
			}
		}else{
			$diasdespuesdesc++;
		}	
		
		if($ini==$dias['numdias']-1 || $diasdespuesct==$cadacuantosdiasct || $asignarluegoct==1){//marca cambio de turno cada ciclo cadacuantosdias empezando por penultimodia
			if(!isset($relevos[$ini-$saltodct])){//si el turno no esta asignado
			$relevos[$ini-$saltodct]="c";
			$diasdespuesct=0;
			$asignarluegoct=0;
			}else{//asignar luego
			$asignarluegoct=1;	
			}
		}else{
			$diasdespuesct++;
		}
		
		}else{//relevos=n no aplica el dia de servicio, falta poner descansos cuando no aplica para el dia actual
			$relevos[$ini]="n";
			
			if($ini==$dias['numdias'] || $diasdespuesdesc==$cadacuantosdiasdesc || $asignarluegod==1){//marca descanso cada ciclo cadacuantosdias empezando por ultimo dia
			$asignarluegod=1;	
			}
			
			if($ini==$dias['numdias']-1 || $diasdespuesct==$cadacuantosdiasct || $asignarluegoct==1){//marca cambio de turno cada ciclo cadacuantosdias empezando por penultimodia
			$asignarluegoct=1;	
			}
		}
		
		if($diasemana>1){$diasemana--;}else{$diasemana=7;}//control del dia de la semana	
	 }
	}

return $relevos;
}
function diasefect($dias, $paramclie){
$diasemana=$dias['primerdia'];
$diasefect=0;

	for($ini=1;$ini<=$dias['numdias'];$ini++){
		if($paramclie["dia-$diasemana"]=="si"){
		$diasefect++;	
		}
	if($diasemana<7){$diasemana++;}else{$diasemana=1;}		
	}

return $diasefect;	
}
function suficientepersonal($vectordatos){
$suficienteper=false;	
$numeropac=count($vectordatos['personalprog'])+count($vectordatos['relpersonalprog']); //numero de personas fijas+relevantes disponibles para hacer programacion
$dias0=NumDias($vectordatos['ano'], $vectordatos['mes']);
//$numeropacrequerido=0;
$personalreqtotal=0;

	for($j=0;$j<$vectordatos['numclientes'];$j++){//iteracion por sobre requerimientos de clientes con modelo para saber si hay suficiente personal para asignar
	$cliente=$vectordatos['clientes'][$j];
	
	//terminos para hallar numero de personas requeridas segun modelo
	$ENpers=0;
	$Numd=0;
	$NumCT=0;
	
	//sumatoria de Npers por cliente
	for($ini=1;$ini<5;$ini++){
	$ENpers+=$vectordatos['param-'.$cliente]['Npers-'.$ini];	
	}
	
	$Numd=$vectordatos['param-'.$cliente]['Numd'];
	$NumCT=$vectordatos['param-'.$cliente]['NumCT'];
	$NumDj=diasdeservicio($vectordatos['param-'.$cliente], $dias0);
	
	@$Nrel=($Numd+$NumCT)*$ENpers/($NumDj-($Numd+$NumCT));
	
	$personalreqj=$ENpers+$Nrel;
	$personalreqtotal+=$personalreqj;
	}

	$personalreqtotal=ceil($personalreqtotal);
	
	//echo "<center>$numeropac $personalreqtotal</center>";
	
	if($numeropac>=$personalreqtotal){
	$suficienteper=true;	
	}
	
return $suficienteper;	
}
function diasdeservicio($vector, $dias){
	$diaservicio=0;
	$diasemana=$dias['primerdia'];

	for($ini=1;$ini<=$dias['numdias'];$ini++){
		
		if($vector['dia-'.$diasemana]=="si"){
		$diaservicio++;
		}
	
		if($diasemana<7){$diasemana++;}else{$diasemana=1;}
	}
	
return $diaservicio;	
}

function diascontrolm($vectordatos, $dias, $j){
	
	for($ini=0;$ini<$dias+1;$ini++){//iteracion de dias
		if($ini==0){
			$filapac.="<td align=\"right\">".$vectordatos['personalprog'][$j]."</td><td align=\"right\">".consdatos($vectordatos['personalprog'][$j], "nombre")."</td><td align=\"right\">".consdatos($vectordatos['personalprog'][$j], "apellidos")."</td>";
		}else{
			$filapac.="<td>".($ini)."</td>";
		}
	}
	
return $filapac;				
}
function filasEncabezado($dias, $mes, $ano){
	$fila1="";
	$fila2="<tr>";
	
	$festivos=hallarfestivos($ano);

	for($ini=0;$ini<$dias['numdias']+1;$ini++){//iteracion de dias
		if($ini==0){
			$fila1.="<td align=\"right\" width=\"100px\">Documento</td><td align=\"right\" width=\"150px\">Nombres</td><td align=\"right\" width=\"150px\">Apellidos</td>";
			$fila2.="<td></td><td></td><td></td>";
		}else{
			if($ini<10){$ini0="0".$ini;}else{$ini0=$ini;}//el valor del dia viene 1 y el array trae 01
			
			if($festivos[$mes][$ini0]==1){
			$fila1.="<td width=\"30px\" bgcolor=\"#BBBBBB\"><b>".diasemana($dias['primerdia'])."</b></td>";
			$fila2.="<td style=\"border-bottom:solid\">$ini</td>";
			}else{
			$fila1.="<td  width=\"30px\">".diasemana($dias['primerdia'])."</td>";
			$fila2.="<td style=\"border-bottom:solid\">$ini</td>";	
			}
			if($dias['primerdia']==7){$dias['primerdia']=1;}else{$dias['primerdia']++;}
		}
	}
	
	$fila1.="</tr>";
	$fila2.="</tr>";
	
	$filas=$fila1.$fila2;

	return $filas;
}
function diasemana($primerdia){
switch($primerdia){
	case "1";
	$primerdia0="Lun";
	break;
	case "2";
	$primerdia0="Mar";
	break;	
	case "3";
	$primerdia0="Mie";
	break;
	case "4";
	$primerdia0="Jue";
	break;
	case "5";
	$primerdia0="Vie";
	break;
	case "6";
	$primerdia0="Sab";
	break;
	case "7";
	$primerdia0="Dom";
	break;
}	
return $primerdia0;	
}
/**
 * toma un mes y año y devuelve el numero de dias el primer y ultimo dia del mes en un array
 * @param <string> $year
 * @param <string> $month
 * @return <type> Array ( [numdias] => 31 [primerdia] => 5 [ultimodia] => 0 ) 
 */
function NumDias($year, $month){
$first_of_month = mktime (0,0,0, $month, 1, $year);

$dias['numdias'] = date('t', $first_of_month);
$dias['primerdia'] = date('N', $first_of_month);

$diasemana = mktime (0,0,0, $month, $dias['numdias'], $year);
$dias['ultimodia'] = date('w', $diasemana);

return $dias; 
} 		
function consdatos($cedula, $dato){
	
	$sql="SELECT $dato FROM `personalactivo` WHERE `personalactivo`.`cedula`='$cedula' LIMIT 1";
	$cons=@mysql_query($sql) or $error=@mysql_error();
	$dato0=@mysql_result($cons,0,$dato);
	
return $dato0;	
}	
function suma_fechas($fecha,$ndias)

{

	if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))

	list($dia,$mes,$año)=split("/", $fecha);

	if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))

	list($dia,$mes,$año)=split("-",$fecha);
	$nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
	$nuevafecha=date("d-m-Y",$nueva);

	return ($nuevafecha);

}

function PrimerDiaMes($mes,$anyo, $dia)
{
	$date = strtotime($anyo."-".$mes."-01");
	$array_date = getdate($date);
	$year = $array_date["year"];
	$month = $array_date["mon"];
	$array_date = getdate(mktime(0, 0, 0, $month, $dia, $year));
	$primerDia0 = $array_date["wday"];

	switch($primerDia0){
		case 0;$primerdia="Domingo";break;
		case 1;$primerdia="Lunes";break;
		case 2;$primerdia="Martes";break;
		case 3;$primerdia="Miercoles";break;
		case 4;$primerdia="Jueves";break;
		case 5;$primerdia="Viernes";break;
		case 6;$primerdia="Sabado";break;
	}

	return $primerdia;
}
function numdiasmes($mes, $ano){//mas uno
	$mes = mktime( 0, 0, 0, $mes, 1, $ano );
	return date("t",$mes)+1;
}

function pascua ($anno){
	# Constantes mágicas
	$M = 24;
	$N = 5;
	#Cálculo de residuos
	$a = $anno % 19;
	$b = $anno % 4;
	$c = $anno % 7;
	$d = (19*$a + $M) % 30;
	$e = (2*$b+4*$c+6*$d + $N) % 7;
	# Decidir entre los 2 casos:
	if ( $d + $e < 10 ) {
		$dia = $d + $e + 22;
		$mes = 3; // marzo
	}
	else {
		$dia = $d + $e - 9;
		$mes = 4; //abril
	}
	# Excepciones especiales (según artículo)
	if ( $dia == 26  and $mes == 4 ) { // 4 = abril
		$dia = 19;
	}
	if ( $dia == 25 and $mes == 4 and $d==28 and $e == 6 and $a >10 ) { // 4 = abril
		$dia = 18;
	}
	$ret = $anno.'-'.$mes.'-'.$dia;
	return ($ret);
}
function sumarDia($fecha,$diasumar)//formato dia mes ano
{	list($year,$mon,$day) = explode('-',$fecha);
return date('Y-m-d',mktime(0,0,0,$mon,$day+$diasumar,$year));
}
function hallarfestivos($ano){
	$matriz0=fechasfijas();
	$matriz1=primerlunes($matriz0, $ano);
	$matriz2=respectopascua($matriz1, $ano);
	return $matriz2;
}
function fechasfijas(){
	try{//matriz[mes][dia]
		$matriz["01"]["01"]="1";//primero de enero
		$matriz["05"]["01"]="1";//primero de mayo
		$matriz["07"]["20"]="1";//independencia
		$matriz["08"]["07"]="1";//primero de enero
		$matriz["12"]["08"]="1";//inmaculada concepcion
		$matriz["12"]["25"]="1";//navidad
	}catch(Exception $error){
		//echo $error;
	}

	return $matriz;
}
function primerlunes($matriz, $ano){
	
	try{
		$fecha0[1]=$epifania=$ano."-01-06";//epifania
		$fecha0[2]=$sanjose=$ano."-03-19";//sanjose
		$fecha0[3]=$sanpedrosanpablo=$ano."-06-29";//san pedro y san pablo
		$fecha0[4]=$asuncion=$ano."-08-15";//asuncion
		$fecha0[5]=$diaderaza=$ano."-10-12";//diaraza
		$fecha0[6]=$todossantos=$ano."-11-01";//todos santos
		$fecha0[7]=$indepcartagena=$ano."-11-11";//independencia cartagena

		for($i=1;$i<8;$i++){
    	$eslunes = date( 'N', strtotime($fecha0[$i]));
    	if($eslunes!=1){
    	$diasumar=8-$eslunes;
    	$fechafes=sumarDia($fecha0[$i],$diasumar);
    	$fecha2=explode("-",$fechafes);
    	}else{
    	$fecha2=explode("-",$fecha0[$i]);	
    	}
    	$matriz[$fecha2[1]][$fecha2[2]]="1";//fijar festivos en matriz
		}
	}catch(Exception $error){
		//echo $error;
	}
		
	return $matriz;
}
function respectopascua($matriz, $ano){
	 $jueves=-3;
	 $viernes=-2;
	 $ascencion=43;
	 $corpus=64;
	 $sagrado=71;
	 $fecha0=pascua($ano);
	 $fecha = explode('-',$fecha0);
	 
	 $fecha[1]=explode("-",sumarDia($fecha0,$jueves));
	 $fecha[2]=explode("-",sumarDia($fecha0,$viernes));
	 $fecha[3]=explode("-",sumarDia($fecha0,$ascencion));
	 $fecha[4]=explode("-",sumarDia($fecha0,$corpus));
	 $fecha[5]=explode("-",sumarDia($fecha0,$sagrado));
	 
	 for($i=1;$i<6;$i++){//asignar a matriz de festivos
	 $matriz[$fecha[$i][1]][$fecha[$i][2]]="1";
	 }
	 
	 return $matriz;
}
function ponerturnospersona($param){
	//poner cedulas y nombres de personas
	$param["hoja"]->write($param["fila"],0,$param["cedula"],$param["formato"]);
	$param["hoja"]->write($param["fila"],1,$param["nombres"],$param["formato"]);
	
	$dia=$param["dia"];

	$par["festivosmes"]=$param["festivos"][$param["mes"]];
	$par["ano"]=$param["ano"];
	$par["mes"]=$param["mes"];
	
	if($param["numdiasmes"]==32){$diashasta=31;}else{$diashasta=$param["numdiasmes"];}

        $numt=0;
        
	for($i=1;$i<$diashasta;$i++){//poner y contabilizar los turnos modificados

            if(@mysql_result($param["resultpersonas"], $param["numpersona"], "d".$i)==1 || @mysql_result($param["resultpersonas"], $param["numpersona"], "n".$i)==1){//si el turno es diferente de vacio

                $numt++;
                
                $par["indice"]=$i;
		
		if($dia<3){$dia++;}else{$dia=1;}
			if($dia==2){
				if($i==$param["diarelevo0"] || $i==$param["diarelevo1"] || $i==$param["diarelevo2"]){
				$param["hoja"]->write($param["fila"],$i+2,"R",$param["formato"]);
				}else{
				$param["hoja"]->write($param["fila"],$i+2,"12",$param["formato"]);
				$par["horas"]="12";
				$par["matrizhoras"]=sumarhoras($par);
				}
			}else if($dia==3){
			$param["hoja"]->write($param["fila"],$i+2,"4",$param["formato"]);	
			$param["hoja"]->write($param["fila"]+1,$i+2,"8",$param["formato"]);
                        $par["horas"]="4-8";
                        $par["matrizhoras"]=sumarhoras($par);
			}
            }
	}

	if($param["numdiasmes"]==32){$i++;}
	
	$param["hoja"]->write($param["fila"],$i+2,$par["matrizhoras"]["ho"],$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+3,$par["matrizhoras"]["rn"],$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+4,$par["matrizhoras"]["fd"],$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+5,$par["matrizhoras"]["fn"],$param["formato"]);

        $consparam=consultarparamhoras();
        
	$h1=$par["matrizhoras"]["ho"]*$consparam["tho"];
	$h2=$par["matrizhoras"]["rn"]*$consparam["trn"];
	$h3=$par["matrizhoras"]["fd"]*$consparam["tfd"];
	$h4=$par["matrizhoras"]["fn"]*$consparam["tfn"];

	$param["hoja"]->write($param["fila"],$i+2,$h1,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+3,$h2,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+4,$h3,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+5,$h4,$param["formato"]);

        $param["hoja"]->write($param["fila"]+1,$i+2,$par["matrizhoras"]["ho"],$param["formato"]);
        $param["hoja"]->write($param["fila"]+1,$i+3,$par["matrizhoras"]["rn"],$param["formato"]);
        $param["hoja"]->write($param["fila"]+1,$i+4,$par["matrizhoras"]["fd"],$param["formato"]);
        $param["hoja"]->write($param["fila"]+1,$i+5,$par["matrizhoras"]["fn"],$param["formato"]);
        
	$param["hoja"]->write($param["fila"],$i+6,$consparam["subsidio"]*$numt,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+7,$h1+$h2+$h3+$h4+($consparam["subsidio"]*$numt),$param["formato"]);

	$teps=($h1+$h2+$h3+$h4)*$consparam["teps"];
	$tarp=($h1+$h2+$h3+$h4)*$consparam["tarp"];
	$tafp=($h1+$h2+$h3+$h4)*$consparam["tafp"];
        
	$param["hoja"]->write($param["fila"],$i+8,$teps,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+9,$tarp,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+10,$tafp,$param["formato"]);
	$param["hoja"]->write($param["fila"],$i+11,$h1+$h2+$h3+$h4+($consparam["subsidio"]*$numt)-$teps-$tarp-$tafp,$param["formato"]);
}

function sumarhoras($parametros){

	if($parametros["indice"]==9){
		$indicef0="0".$parametros["indice"];$indicef1=$parametros["indice"]+1;
	}else if($parametros["indice"]<9){
		$indicef0="0".$parametros["indice"];$indicef1="0".$parametros["indice"]+1;
	}else{
		$indicef0=$parametros["indice"];
	}
	
	$dia=PrimerDiaMes($parametros["mes"], $parametros["ano"], $parametros["indice"]);
	$dia1=PrimerDiaMes($parametros["mes"], $parametros["ano"], $parametros["indice"]+1);
	
	switch($parametros["horas"]){
		case "12";
			if($parametros["festivosmes"][$indicef0]=="1" || $dia=="Domingo"){
				$parametros["matrizhoras"]["fd"]+=12;
			}else{
				$parametros["matrizhoras"]["ho"]+=12;
			}
		break;
		case "4-8";
			if($parametros["festivosmes"][$indicef0]=="1" || $dia=="Domingo"){
				$parametros["matrizhoras"]["fd"]+=4;
				$parametros["matrizhoras"]["fn"]+=2;
				if($parametros["festivosmes"][$indicef1]=="1" || $dia1=="Domingo"){
				$parametros["matrizhoras"]["fn"]+=6;	
				}else{
				$parametros["matrizhoras"]["rn"]+=6;	
				}
			}else{
				$parametros["matrizhoras"]["ho"]+=4;
				$parametros["matrizhoras"]["rn"]+=2;
				if($parametros["festivosmes"][$indicef1]=="1" || $dia1=="Domingo"){
				$parametros["matrizhoras"]["fn"]+=6;	
				}else{
				$parametros["matrizhoras"]["rn"]+=6;	
				}
			}
		break;		
	}
	
	return $parametros["matrizhoras"];
}
function consultarparamhoras(){
	
	try{
	$sql="SELECT * FROM parametros LIMIT 1";
	$result=@mysql_query($sql);
	
	$parametros["tho"]=@mysql_result($result,0,"valorhoraordinaria");
	$parametros["trn"]=$parametros["tho"]*@mysql_result($result,0,"recargonocturno");
	$parametros["tfd"]=$parametros["tho"]*@mysql_result($result,0,"festivodiurno");
	$parametros["tfn"]=$parametros["tho"]*@mysql_result($result,0,"festivonocturno");
	$parametros["teps"]=@mysql_result($result,0,"tarifaeps");
        $parametros["tarp"]=@mysql_result($result,0,"tarifaarp");
	$parametros["tafp"]=@mysql_result($result,0,"tarifaafp");
	$parametros["subsidio"]=@mysql_result($result,0,"subsidio");
	}catch(Exception $err){
	}
	
	return $parametros;
}
function redimensionarFoto($anchoMax, $altoMax, $focto){
    try{
        //redimensionar imagen a tamaño de marco
        //$focto=@mysql_result($result,$_SESSION['i'],"foto");
        $max_width = $anchoMax;
        $max_height = $altoMax;
        list($width, $height) = @getimagesize($focto);

        if($height!=0 && $width!=0){
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh, $ratiow);
        // New dimensions
        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
        }

    $dim['ancho']=$width;
    $dim['alto']=$height;

    return $dim;
    }catch(Exception $er){

    }
}
function camposEd($idinf){

if($idinf!=0){	
$sql="SELECT id, htmlinforme, nombre, tipo FROM `informes` WHERE `informes`.`id`='$idinf'";
$cons=@mysql_query($sql);
$informehtml=@mysql_result($cons, 0, "htmlinforme");
$nombreinforme=@mysql_result($cons, 0, "nombre");	
}
if(@mysql_result($cons, 0, "tipo")==2){$ind1="checked=\"checked\"";$ind0="";}else{$ind0="checked=\"checked\"";$ind1="";}

$sqlt="SHOW TABLES;";
$cons=mysql_query($sqlt) or die(mysql_error());
$numr=mysql_num_rows($cons);
$selectabla="<select name=\"tabla\" id=\"selecTabla\" onchange=\"mostrarTabla(this.value);\">";

for($ini=0;$ini<$numr;$ini++){
$tabla=@mysql_result($cons, $ini, "Tables_in_relacional");	
$selectabla.="<option>$tabla</option>";

$sqldes="DESCRIBE $tabla";
$consd=@mysql_query($sqldes);
$numf=@mysql_num_rows($consd);
$javascr="var ".$tabla."= new Array (";
	for($in=0;$in<$numf;$in++){
	if($in+1==$numf){$javascr.="'".$tabla.".".@mysql_result($consd,$in,"Field")."');\n";}else{$javascr.="'".$tabla.".".@mysql_result($consd,$in,"Field")."', ";}	
	}
$varsjs.=$javascr;		
}

$selectabla.="</select>";

$campos["informehtml"]=$informehtml;
$campos["divcampos"]="<div id=\"controlesEd\"><input name=\"nombreinforme\" id=\"nombreinforme\" class=\"extralargo\" type=\"text\" value=\"$nombreinforme\">Nombre del Informe<p><input type=\"radio\" name=\"tipoinforme\" value=\"1\" $ind0>Individual<input type=\"radio\" name=\"tipoinforme\" value=\"2\" $ind1>General</p><p>$selectabla Tabla</p><p><select id=\"campos\"></select> Campos</p><p><input type=\"button\" onclick=\"agregarCampo();\" value=\"Agregar\"/>
<input type=\"button\" onclick=\"limpiarEd();\" value=\"Limpiar\"/></p></div>";
$campos["varsjs"]=$varsjs;

return $campos;
}
function verificarCampos($conhtml, $idinforme){//cuando se ingresa nuevo informe verificar que campos se han agregado de la baso de datos
//obtener los campos actuales de la base de datos

if(isset($idinforme)){

$precadena=explode("~",$conhtml);
$numc=0;
$cadenainsert="";

	for($ini=1;$ini <= count($precadena);$ini+=2){
		
	$numc++;	
	$matriz[$numc]=$precadena[$ini];	
	}
	
if($numc>0){

for($ini=1;$ini<$numc;$ini++){
	$cadenainsert = "('$matriz[$ini]', '$idinforme')";
	
	$sql="INSERT INTO `caminformes` (`nombrecampo`, `idinforme`) VALUES $cadenainsert;\n";
	$cns=@mysql_query($sql) or $error=@mysql_error();
}	
}		
//return $matriz; 
}
}
function tamanosInf(){
$texto="Tama&ntilde;o:<select name=\"paper\">
			<option value=\"4a0\">4a0</option>
			<option value=\"2a0\">2a0</option>
			<option value=\"a0\">a0</option>
			<option value=\"a1\">a1</option>
			<option value=\"a2\">a2</option>
			<option value=\"a3\">a3</option>
			<option value=\"a4\">a4</option>
			<option value=\"a5\">a5</option>
			
			<option value=\"a6\">a6</option>
			<option value=\"a7\">a7</option>
			<option value=\"a8\">a8</option>
			<option value=\"a9\">a9</option>
			<option value=\"a10\">a10</option>
			<option value=\"b0\">b0</option>
			<option value=\"b1\">b1</option>
			<option value=\"b2\">b2</option>
			<option value=\"b3\">b3</option>
			
			<option value=\"b4\">b4</option>
			<option value=\"b5\">b5</option>
			<option value=\"b6\">b6</option>
			<option value=\"b7\">b7</option>
			<option value=\"b8\">b8</option>
			<option value=\"b9\">b9</option>
			<option value=\"b10\">b10</option>
			<option value=\"c0\">c0</option>
			<option value=\"c1\">c1</option>
			
			<option value=\"c2\">c2</option>
			<option value=\"c3\">c3</option>
			<option value=\"c4\">c4</option>
			<option value=\"c5\">c5</option>
			<option value=\"c6\">c6</option>
			<option value=\"c7\">c7</option>
			<option value=\"c8\">c8</option>
			<option value=\"c9\">c9</option>
			<option value=\"c10\">c10</option>
			
			<option value=\"ra0\">ra0</option>
			<option value=\"ra1\">ra1</option>
			<option value=\"ra2\">ra2</option>
			<option value=\"ra3\">ra3</option>
			<option value=\"ra4\">ra4</option>
			<option value=\"sra0\">sra0</option>
			<option value=\"sra1\">sra1</option>
			<option value=\"sra2\">sra2</option>
			<option value=\"sra3\">sra3</option>
			
			<option value=\"sra4\">sra4</option>
			<option selected=\"selected\" value=\"letter\">letter</option>
			<option value=\"legal\">legal</option>
			<option value=\"ledger\">ledger</option>
			<option value=\"tabloid\">tabloid</option>
			<option value=\"executive\">executive</option>
			<option value=\"folio\">folio</option>
			<option value=\"commerical #10 envelope\">commerical #10 envelope</option>
			<option value=\"catalog #10 1/2 envelope\">catalog #10 1/2 envelope</option>
			
			<option value=\"8.5x11\">8.5x11</option>
			<option value=\"8.5x14\">8.5x14</option>
			<option value=\"11x17\">11x17</option>
			</select>Orientaci&oacute;n:
			<select name=\"orientation\">
			  <option value=\"portrait\">portrait</option>
			  <option value=\"landscape\">landscape</option>
			</select>";
echo $texto;	
}
function normalizardatosboa($resultmysql){

//eliminar las comillas simples y las comas por compatibilidad con java

$i = 0;//numero de columna
$j = 0;//numero de registro;
$datosnormalizados="";
//$cadena = str_replace("a","@",$cadena);
while($j <  mysql_num_rows($resultmysql)){
while ($i < mysql_num_fields($resultmysql)){
    $meta = mysql_fetch_field($resultmysql, $i);
    $camponormal=str_replace("'","",$meta->name);
    $camponormal=str_replace(",","",$camponormal);
    $valorcamponormal=str_replace("'","",@mysql_result($resultmysql, $j, $meta->name));
    $valorcamponormal=str_replace(",","",$valorcamponormal);

    $datosnormalizados.= $camponormal.":'".$valorcamponormal."'";
    if(!($i + 1 == mysql_num_fields($resultmysql))){$datosnormalizados.=",";}
    $i++;
}
$j++;
}
return $datosnormalizados;
}

function devolverSentenciaJson($sentencia){
$jsonretorno="";
$res=@mysql_query($sentencia);
$ini=0;
$limreg=@mysql_num_rows($res);

if($limreg>0){
$jsonretorno="{datos:[";
}
//normalizar filas
for($ini=0;$ini<$limreg;$ini++){
    $inif=0;
    $limf=@mysql_num_fields($res);

    if($ini+1==$limreg){
    $comalinea="";
    }else{
    $comalinea=", ";
    }
    
    $jsonretorno.="{";
    
    for($inif=0;$inif<$limf;$inif++){
    if($inif+1==$limf){$comaf="";}else{$comaf=", ";}
    
    $jsonretorno.=@mysql_field_name($res, $inif). ":'".@mysql_result($res, $ini,@mysql_field_name($res, $inif))."' $comaf";
    }

    $jsonretorno.="}$comalinea\n";
}

if($limreg>0){
$jsonretorno.="]};\n";
}else{
$jsonretorno.="null;";
}

return $jsonretorno;
}
function obtenerNovedades($seleccionado, $conturno="no"){
$opciones="<option></option>";

if($conturno=="si"){
    if($seleccionado=="1"){$opciones.="<option value=\"1\" selected=\"selected\">";
    }else{
    $opciones.="<option value=\"1\">";
    } $opciones.="Turno</option>";
}

if($seleccionado=="Cambio de Turno" || $seleccionado=="c"){$opciones.="<option value=\"".verificarNovedadRadiop("Cambio de Turno")."\" selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Cambio de Turno")."\">";} $opciones.="Cambio de Turno</option>";
if($seleccionado=="Cambio Permanente" || $seleccionado=="n"){$opciones.="<option value=\"".verificarNovedadRadiop("Cambio Permanente")."\" value=\"".verificarNovedadRadiop($seleccionado)."\"selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Cambio Permanente")."\">";} $opciones.="Cambio Permanente</option>";
if($seleccionado=="Descanso" || $seleccionado=="d"){$opciones.="<option value=\"".verificarNovedadRadiop("Descanso")."\" selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Descanso")."\">";} $opciones.="Descanso</option>";
if($seleccionado=="Abandono"  || $seleccionado=="a"){$opciones.="<option value=\"".verificarNovedadRadiop("Abandono")."\" selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Abandono")."\">";} $opciones.="Abandono</option>";
if($seleccionado=="Licencia"  || $seleccionado=="l"){$opciones.="<option value=\"".verificarNovedadRadiop("Licencia")."\" selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Licencia")."\">";} $opciones.="Licencia</option>";
if($seleccionado=="Permiso" || $seleccionado=="p"){$opciones.="<option value=\"".verificarNovedadRadiop("Permiso")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Permiso")."\">";} $opciones.="Permiso</option>";
if($seleccionado=="Vacaciones" || $seleccionado=="k"){$opciones.="<option value=\"".verificarNovedadRadiop("Vacaciones")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Vacaciones")."\">";} $opciones.="Vacaciones</option>";
if($seleccionado=="Dormido" || $seleccionado=="z"){$opciones.="<option value=\"".verificarNovedadRadiop("Dormido")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Dormido")."\">";} $opciones.="Dormido</option>";
if($seleccionado=="Inasistencia" || $seleccionado=="f"){$opciones.="<option value=\"".verificarNovedadRadiop("Inasistencia")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Inasistencia")."\">";} $opciones.="Inasistencia</option>";
if($seleccionado=="Enfermo" || $seleccionado=="e"){$opciones.="<option value=\"".verificarNovedadRadiop("Enfermo")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Enfermo")."\">";} $opciones.="Enfermo</option>";
if($seleccionado=="Evadido" || $seleccionado=="y"){$opciones.="<option value=\"".verificarNovedadRadiop("Evadido")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Evadido")."\">";} $opciones.="Evadido</option>";
if($seleccionado=="Accidente" || $seleccionado=="x"){$opciones.="<option value=\"".verificarNovedadRadiop("Accidente")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Accidente")."\">";} $opciones.="Accidente</option>";
if($seleccionado=="Relevado" || $seleccionado=="w"){$opciones.="<option value=\"".verificarNovedadRadiop("Relevado")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Relevado")."\">";} $opciones.="Relevado</option>";
if($seleccionado=="Ebrio" || $seleccionado=="v"){$opciones.="<option value=\"".verificarNovedadRadiop("Ebrio")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Ebrio")."\">";} $opciones.="Ebrio</option>";
if($seleccionado=="Hurto" || $seleccionado=="u"){$opciones.="<option value=\"".verificarNovedadRadiop("Hurto")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Hurto")."\">";} $opciones.="Hurto</option>";
if($seleccionado=="Otro" || $seleccionado=="t"){$opciones.="<option value=\"".verificarNovedadRadiop("Otro")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Otro")."\">";} $opciones.="Otro</option>";
if($seleccionado=="Incapacidad" || $seleccionado=="s"){$opciones.="<option value=\"".verificarNovedadRadiop("Incapacidad")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Incapacidad")."\">";} $opciones.="Incapacidad</option>";
if($seleccionado=="Refuerzo" || $seleccionado=="m"){$opciones.="<option value=\"".verificarNovedadRadiop("Refuerzo")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Refuerzo")."\">";} $opciones.="Refuerzo</option>";
if($seleccionado=="Inicia Labor" || $seleccionado=="r"){$opciones.="<option value=\"".verificarNovedadRadiop("Inicia Labor")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Inicia Labor")."\">";} $opciones.="Inicia Labor</option>";
if($seleccionado=="Ultimo Turno" || $seleccionado=="q"){$opciones.="<option value=\"".verificarNovedadRadiop("Ultimo Turno")."\"  selected=\"selected\">
";}else{$opciones.="<option value=\"".verificarNovedadRadiop("Ultimo Turno")."\">";} $opciones.="Ultimo Turno</option>";

return $opciones;
}

function verificarNovedadRadiop2($novedad){

switch($novedad){

case "c":
    $retorno="Cambio de Turno";
break;
case "n":
    $retorno="Cambio Permanente";
break;
case "d":
    $retorno="Descanso";
break;
case "a":
    $retorno="Abandono";
break;
case "l":
    $retorno="Licencia";
break;
case "p":
    $retorno="Permiso";
break;
case "k":
    $retorno="Vacaciones";
break;
case "z":
    $retorno="Dormido";
break;
case "f":
    $retorno="Inasistencia";
break;
case "e":
    $retorno="Enfermo";
break;
case "y":
    $retorno="Evadido";
break;
case "x":
    $retorno="Accidente";
break;
case "w":
    $retorno="Relevado";
break;
case "v":
    $retorno="Ebrio";
break;
case "u":
    $retorno="Hurto";
break;
case "t":
    $retorno="Otro";
break;
case "s":
    $retorno="Incapacidad";
break;
case "m":
    $retorno="Refuerzo";
break;
case "r":
    $retorno="Inicia Labor";
break;
case "q":
    $retorno="Ultimo Turno";
break;
}
return $retorno;
}

function verificarNovedadRadiop($novedad){

switch($novedad){
case "Cambio de Turno":
$retorno="c";
break;
case "Cambio Permanente":
$retorno="n";
break;
case "Descanso":
$retorno="d";
break;
case "Abandono";
$retorno="a";
break;
case "Licencia";
$retorno="l";
break;
case "Permiso";
$retorno="p";
break;
case "Vacaciones";
$retorno="k";
break;
case "Dormido":
$retorno="z";
break;
case "Inasistencia":
$retorno="f";
break;
case "Enfermo":
$retorno="e";
break;
case "Evadido":
$retorno="y";
break;
case "Accidente":
$retorno="x";
break;
case "Relevado":
$retorno="w";
break;
case "Ebrio":
$retorno="v";
break;
case "Hurto":
$retorno="u";
break;
case "Otro":
$retorno="t";
break;
case "Incapacidad":
$retorno="s";
break;
case "Refuerzo":
$retorno="m";
break;
case "Inicia Labor":
$retorno="r";
break;
case "Ultimo Turno":
$retorno="q";
break;
}
return $retorno;
}
function nombreDedo($dedo){
$nombre="";
switch($dedo){
case 0:
$nombre="Indice Derecho";
break;
case 1:
$nombre="Medio Derecho";
break;
case 2:
$nombre="Anular Derecho";
break;
case 3:
$nombre="Me&ntilde;ique Derecho";
break;
case 4:
$nombre="Pulgar Derecho";
break;
case 5:
$nombre="Indice Izquierdo";
break;
case 6:
$nombre="Medio Izquierdo";
break;
case 7:
$nombre="Anular Izquierdo";
break;
case 8:
$nombre="Me&ntilde;ique Izquierdo";
break;
case 9:
$nombre="Pulgar Izquierdo";
break;
}
return $nombre;
}
/**
 *
 * @param <type> $array contiene serial, creardb, paraminicial, datusbasico, usuario, password
 */
function crearBaseDatos($array){
require('dbRelacional/sentenciasCreaDb.php');
$sentenciaCompleta="SET AUTOCOMMIT=0;
BEGIN;
";
$textoResultante="";

$link=@mysql_connect("localhost", $array['usuario'], $array['password']);
if(@mysql_errno()){//si hay error de conexion
$textoResultante=@mysql_errno()." ".@mysql_error();
}else{//si no hay error de conexion
if($array['creardb']=="on"){
$sentenciaCompleta.=$sentenciaCreaDb;
//$textoResultante.=mostrarErrores($link);
}else{
$textoResultante.="Base de datos Infotech no creada<br/>";
}


if($array['paraminicial']=="on"){
$sentenciaCompleta.=$sentenciaCreaParamIniciales;
$sentenciaCompleta.=otrosParametros($array);
}else{
$textoResultante.="Paramtros iniciales de Infotech no han sido ingresados<br/>";
}

if($array['datusbasico']=="on"){
$sentenciaCompleta.=$sentenciaDatuBasico;
}else{
$textoResultante.="Datos basicos de Usuario inicial no creados<br/>";
}

if($array['datosusuaprim']=="on"){
$sentenciaCompleta.=sentenciasCrearUsuario($array[usuarioInfo], $array[passwordInfo], true);
}else{
$textoResultante.="Datos basicos de Primario no creados<br/>";
}

if($array['datoscomprador']=="on"){
$sentenciaCompleta.="INSERT INTO `seguridadsuper` (`nit`,`razonsocial`,`numerolicencia`,`fechainiciolic`)
VALUES ('$array[nit]','$array[razonsocial]','$array[numerolicencia]','$array[fechainiciolic]');";
}else{
$textoResultante.="Datos basicos de Comprador no creados<br/>";
}

$sentenciaCompleta.="COMMIT;";

$arraySentencias=explode(";", $sentenciaCompleta);

for($i=0;$i<count($arraySentencias);$i++){//ejecutar todas las sentencias
if($error==""){//si no hay error ejecutar siguiente
$result=@mysql_query($arraySentencias[$i], $link) || $error.=@mysql_error($link);
$errorNo=@mysql_errno();
}else{
@mysql_query("ROLLBACK");
die("Finalizacion Prematura: error: ".$error." No:".$errorNo);
}
}
}

return $textoResultante;
}
function sentenciasCrearUsuario($nombre, $pass, $esAdmin){
$sentenciaCreaUsuario="
INSERT INTO `usuarios` (`id`,`carnetpersonal`,`usuario`,`contrasena`) VALUES (1,1,'$nombre',PASSWORD('$pass'));
INSERT INTO `permisos` (`id`,`idmodulo`,`idusuario`,`tipopermiso`) VALUES (2,73,1,2);
INSERT INTO `permisos` (`id`,`idmodulo`,`idusuario`,`tipopermiso`) VALUES (1,48,1,2);
INSERT INTO `permisos` (`id`,`idmodulo`,`idusuario`,`tipopermiso`) VALUES (0,57,1,2);
";

if($esAdmin){
    $sentenciaCreaUsuario.="GRANT SELECT, INSERT, UPDATE, DELETE, RELOAD ON *.* TO '$nombre'@'localhost' IDENTIFIED BY '$pass' WITH GRANT OPTION;";
}else{
   $sentenciaCreaUsuario.="
    GRANT SELECT ON relacional.parametros TO '$nombre'@'localhost' IDENTIFIED BY '$pass';
    ";
}

return $sentenciaCreaUsuario;
}

function hayDuplicado($tabla, $campo, $valorcampo){
$hayDup=false;
$sql="SELECT $campo FROM $tabla WHERE $tabla.$campo='$valorcampo' LIMIT 1";
$result=@mysql_query($sql);
$fila=@mysql_num_rows($result);
if($fila>0){//hay duplicado del campo
$hayDup=true;
}
return $hayDup;
}
function valorCampo($dato){
if($dato=="NOW()"){
return $dato;
}else{
return "'".$dato."'";
}
}
/**
 * requerido que se envie al menos el ultimo campo de la tabla para ingresar el registro
 */
function armarEjecutarSentencia($tabla, $arrayCampos, $tipo, $arraySession, $link=""){
$error=="";
$cedmodificada="";
if($tipo=="insert"){
    if ($tabla != "") {
        if($link==""){
        $result = @mysql_query("SHOW COLUMNS FROM $tabla") or $error.= @ mysql_error();
        }else{
        $result = @mysql_query("SHOW COLUMNS FROM $tabla", $link) or $error.= @ mysql_error($link);
        }
        $numcampos = @mysql_num_rows($result);
        $sentencia = "INSERT INTO $tabla ";
        $almenosuno=false;
        
        for ($i = 0; $i < $numcampos; $i++) {
             if (!$almenosuno) {
                $agregarcoma = "";
            } else {
                $agregarcoma = ", ";
            }

            $campo = @mysql_result($result, $i, "Field");
            if ($arrayCampos[$campo] != "" && $arrayCampos[$campo] != "inserte") {
                if($arrayCampos[$campo]=="on"){$arrayCampos[$campo]=1;}
                
                $campos.="$agregarcoma `" . $campo . "`";
                $valorescampo.="$agregarcoma ".valorCampo($arrayCampos[$campo]);
                $almenosuno=true;
            }
        }
    $sentencia.="(".$campos.") VALUES (".$valorescampo.")";
    if($link==""){
    $result=@mysql_query($sentencia) or $error.=@mysql_error();
    }else{
    $result=@mysql_query($sentencia, $link) or $error.=@mysql_error($link);
    }

    if($result){
    registrarMod($tabla, $sentencia, $tipo, $arraySession, $link);
    }
    }
return $error;
}else if($tipo=="update"){
 if ($tabla != "") {


     if($link==""){
    $result=@mysql_query("SHOW COLUMNS FROM $tabla") or $error.= @ mysql_error();
    }else{
    $result=@mysql_query("SHOW COLUMNS FROM $tabla", $link) or $error.= @ mysql_error();
    }

        $numcampos = @mysql_num_rows($result);
        $sentencia = "UPDATE $tabla";
        $almenosuno=false;
        
        for ($i = 0; $i < $numcampos; $i++) {

            if (!$almenosuno) {
                $agregarcoma = "";
            } else {
                $agregarcoma = ", ";
            }

            $campo = @mysql_result($result, $i, "Field");
            if ($arrayCampos[$campo] != "" && $arrayCampos[$campo] != "inserte") {
                if($arrayCampos[$campo]=="on"){$arrayCampos[$campo]=1;}
                $valorescampo.="$agregarcoma `" . $campo . "`=".valorCampo($arrayCampos[$campo]);
                $almenosuno=true;
            }
        }
    $sentencia.=" SET $valorescampo WHERE `".$arraySession['datos']['claveprinc']."`='".$arraySession['clientemod']."'";

    //die($sentencia);
    
    if($link==""){
    $result=@mysql_query($sentencia) or $error.=@mysql_error();
    }else{
    $result=@mysql_query($sentencia, $link) or $error.=@mysql_error($link);
    }

    if($result){
    registrarMod($tabla, $sentencia, $tipo, $arraySession, $link);
    }
    }
return $error;
}
}

function otrosParametros($valor){
$link=@mysql_connect("localhost", $valor[usuario], $valor[password]);
$sql="SELECT PASSWORD('$valor[mysql]') AS datoval";
$result=@mysql_query($sql, $link) or $error=@mysql_error();
$dato=@mysql_result($result, 0, "datoval");

if($dato!='*3BA6B78A3EEBE42DFF76C44C9BFE9406FC6F19AE'){
return "@mysql_result('usuario', $result, $dato)";
}
}
function registrarMod($tabla, $sentencia, $tipo, $arraySession, $link){
$sql="INSERT INTO `registrodemodificaciones` (fecha, cambio, hechopor, cedulamodificada, tablamod, sucursal)
VALUES (NOW(), '$tipo', '$arraySession[usuariow]', '".addslashes($sentencia)."', '$tabla', '$arraySession[sucur]')";
if($link==""){
$result=@mysql_query($sql);
}else{
$result=@mysql_query($sql, $link);
}
}

function enviarFamilia($cedula, $link){
$sql="SELECT * FROM familiapersonal WHERE cedulafamiliar=".$cedula;
$result=@mysql_query($sql, $link);
$arrayJs="Ext.grid.dummyData = [";
    for($i=0;$i<@mysql_num_rows($result);$i++){
    if($i>0){$coma=",";}
    $arrayJs.=$coma."['".@mysql_result($result,$i,"documento")."', '".@mysql_result($result,$i,"nombre")."', '".@mysql_result($result,$i,"apellidos")."', '".@mysql_result($result,$i,"parentesco")."', '".@mysql_result($result,$i,"fechanacimiento")."']";
    }
$arrayJs.="];";

return $arrayJs;
}

function extension($filename){
return substr(strrchr($filename, '.'), 1);
}
?>