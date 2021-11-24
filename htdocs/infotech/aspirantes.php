<?php
session_start();

@require('funciones2.php');
$link=validar("","","", 1);

formularioactual();

	if($_POST['ejecut']=="Buscar" || $_GET['ejecut']=="Buscar"){

                resetearsesion();

		$_SESSION['i']=0;
		$_SESSION['fotoir']="";

                if($_POST['ejecut']=="Buscar"){
		$_SESSION['datos']['campobusqueda']=$_POST['campobusqueda'];
		$_SESSION['datos']['crito']=$_POST['criterio'];
		$_SESSION['datos']['opcion']=$_POST['opt'];
                }else{//busqieda con get
                $_SESSION['datos']['campobusqueda']=$_GET['campobusqueda'];
		$_SESSION['datos']['crito']=$_GET['criterio'];
		$_SESSION['datos']['opcion']=$_GET['opt'];
                }

                $_SESSION['datos']['claveprinc']="cedula";
		$_SESSION['datos']['otraconsulta']="AND personalactivo.activo = 2";

		$_SESSION['botonuevo']=0;
        }else if($_POST['ejecut']=="Ingresar"){

            if($_FILES["rutafoto"]['type']!="" AND $_SESSION['fotoir']==""){
                $tamano = $_FILES["rutafoto"]['size'];
                $tipo = $_FILES["rutafoto"]['type'];
                $archivo = $_FILES["rutafoto"]['name'];
                $prefijo = substr(md5(uniqid(rand())),0,6);

                // copiar la foto al directorio de fotos

                if ($archivo != ""){
                        if($tipo=="image/jpeg" or $tipo=="image/png") {

                                // guardamos el archivo a la carpeta files
                                $destino =  "fotosguardas/".$prefijo."_".$archivo;
                                $nombrefoto=$prefijo."_".$archivo;
                                copy($_FILES['rutafoto']['tmp_name'],$destino);
                                $_POST['foto']=$nombrefoto;
                        }else {
                                $mens='verifique el archivo que esta intentando subir\n solo se permiten imagenes jpg y png';
                        }
                }
            }elseif($_SESSION['fotoir']!=""){
                    $nombrefoto=$_SESSION['fotoir']['prefijo']."_".$_SESSION['fotoir']['archivo'];
            }

            if(!hayDuplicado("personalactivo", "cedula", $_POST['cedula'])){//no hay duplicados de cedula
                    if(!hayDuplicado("personalactivo", "pasadojudicial", $_POST['pasadojudicial'])){//no hay duplicados de pasado judicial
                    //agregar sucursal
                    if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                    $_POST['activo']=2;
                    $_POST['estado']=1;
                    $_POST['codigo']='ClienteInfotech';

                    $mens.=armarEjecutarSentencia("personalactivo", $_POST, "insert", $_SESSION);
                    }else{
                    $mens.="Existe un registro con este numero de pasado judicial";
                    guardarSes($_POST);
                    }
            }else{
                $mens.="Existe un registro con este numero de cedula";
                guardarSes($_POST);
            }
        }else if($_POST['ejecut']=="Actualizar"){

			if($_FILES["rutafoto"]['type']!=""){

				//funciones para almacenamiento de la foto en la base de datos

				$tamano = $_FILES["rutafoto"]['size'];
				$tipo = $_FILES["rutafoto"]['type'];
				$archivo = $_FILES["rutafoto"]['name'];
				$prefijo = substr(md5(uniqid(rand())),0,6);

				// copiar la foto al directorio de fotos

				if ($archivo != ""){
					if($tipo=="image/jpeg" or $tipo=="image/png") {
						// guardamos el archivo a la carpeta files
						$destino =  "fotosguardas/".$prefijo."_".$archivo;
						$nombrefoto=$prefijo."_".$archivo;
						copy($_FILES['rutafoto']['tmp_name'],$destino);
						$agregasql="`foto` = '$nombrefoto',";
                                                $_POST['foto']=$nombrefoto;
					}else {
						$mens='verifique el archivo que esta intentando subir\n solo se permiten imagenes jpg y png87-';
					}
				}
			}

                        if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                        $_POST['claveprinc']="cedula";

                        $mens.=armarEjecutarSentencia("personalactivo", $_POST, "update", $_SESSION);

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

        }else if($_POST['ejecut']=="Contratar"){

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $_POST['activo']="1";   //actualizar a cliente retirado
                $_POST['apruebaseleccion']==2;
                $_POST['fincontrato']="NOW()";
                $mens=armarEjecutarSentencia("personalactivo", $_POST, "update", $_SESSION);

		$_SESSION['botonuevo']=0;

        }else{//ingreso por primera vez al formulario

                resetearsesion();

                $_SESSION['i']=0;
		$_SESSION[fotoir]="";

		$_SESSION['datos']['campobusqueda']="cedula";
		$_SESSION['datos']['opcion']=1;
                $_SESSION['datos']['claveprinc']="cedula";
		$_SESSION['datos']['otraconsulta']="AND personalactivo.activo = 2";

        }

$mens.=$error;

$result2=operaciones("personalactivo","buscar",$_SESSION['datos']);
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

$muestrcarg[1]="cargo";
$otrasent="AND (cargos.idsucursal = 1 OR cargos.idsucursal LIKE '$_SESSION[sucur]')";
$cadenacargos=selection("cargos","id","%",$muestrcarg,@mysql_result($result,$_SESSION['i'],"cargo"),1,"cargo",$otrasent);

$r=@require('version.php');
caracteresiso();
?>
<link	rel="stylesheet" href="estilo2.css" type="text/css">
<link	rel="stylesheet" href="botones.css" type="text/css">

<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

<!-- GC -->
<!-- LIBS -->
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->

<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/aspirantes.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />

<!-- Common Styles for the examples -->
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<style type="text/css">
p { width:300px; }
</style>

<!-- fin librerias extjs -->
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
		function ventana(){
		var ventana = window.open("fotomysql.php","Imagen","width=600px,height=600px,menubar=0,scrollbars=1");
		}
//-->
</script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<form method="post" name="peract" id="peract"
	action="aspirantes.php" enctype="multipart/form-data"
	onsubmit="return validaperasp(boolvalidar);"><br>
<table class="tablaprinc" >
	<tr>
		<td>
		<table>
			<tr>
				<td align="right">*Cedula de Ciudadania:</td>
				<td align="left"><input class="corto" size="31"
					value="<?php
			
			  if ($_SESSION['cedulaa']!=""){
			  	echo $_SESSION[cedulaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cedula");}
			 
			?>"
					name="cedula">De<input class="largo"
					name="expedida"
					value="<?php if ($_SESSION['expedidaa']!=""){echo $_SESSION[expedidaa];
			}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"expedida");} ?>">
				</td>
				<!-- Col 1 -->
				<td rowspan="8" align="center"><?php
                        $focto=@mysql_result($result,$_SESSION['i'],"foto");

	 		if(@mysql_result($result,$_SESSION['i'],"foto")!=""){

                            $dim=redimensionarFoto(160, 150, "fotosguardas/".$focto);

	 			echo "<img style=\"width:".$dim['ancho']."px;height:".$dim['alto']."px\" name=\"changing\" onclick=\"ventana()\"
					src=\"fotosguardas/"."$focto\""."/>" ;}else{echo "<img style=\"width: 150px\" name=\"changing\"
					src=\"fotosguardas/foto0.gif\""."/>" ;}
	 			?></td>
			</tr>
			<tr>
				
			</tr>
			<tr>
				<td align="right">*Nombres:</td>
				<td align="left"><input class="largo"
					value="<?php
			 if ($_SESSION['nombrea']!=""){
			  	echo $_SESSION[nombrea];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombre");}
			 		?>"
					name="nombre"> </td>
			</tr>
			<tr style="border-width: thin;">
				<td align="right">*Apellidos:</td>
				<td align="left"><input class="largo" name="apellidos"
					value="<?php
		 if ($_SESSION['apellidosa']!=""){
			  	echo $_SESSION[apellidosa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"apellidos");} ?>">
				</td>
			</tr>
			<tr>
				<td align="right">Sexo:</td>
				<td align="left"><select name="sexo" class="corto1">
					<option value=""></option>
					<option value="1"
					<?php $z="sexo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sexoa']==1) {echo ('selected');}?>>Masculino</option>
					<option value="2"
					<?php $z="sexo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sexoa']==2) {echo ('selected');}?>>Femenino</option>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 8 -->
				<td align="right">Direccion:</td>
				<td align="left"><input name="direccion" class="largo"
					value="<?php
			 if ($_SESSION['direcciona']!=""){
			  	echo $_SESSION[direcciona];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"direccion");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Barrio:</td>
				<td align="left"><input name="barrio" class="largo"
					value="<?php
			 if ($_SESSION['barrioa']!=""){
			  	echo $_SESSION[barrioa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"barrio");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 8 -->
				<td align="right">*Pasado judicial:</td>
				<td align="left"><input class="largo"
					name="pasadojudicial"
					value="<?php
			 if ($_SESSION['pasadojudiciala']!=""){
			  	echo $_SESSION[pasadojudiciala];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"pasadojudicial");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<td align="right">Cargar Fotografia:</td>
				<td><input class="largo" type="file" size="8px"
					name="rutafoto"></td>
			</tr>
			<tr>
				<!-- Row 7 -->
				<td align="right">Ciudad residencia:</td>
				<td align="left"><select name="codigoresidencia" class="largo1">
					<option value=""></option>
					<option value="08001"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="08001" or $_SESSION['codigoresidenciaa']=="08001") {echo ('selected');}?>>Barranquilla</option>
					<option value="11001"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="11001" or $_SESSION['codigoresidenciaa']=="11001") {echo ('selected');}?>>Bogot&aacute;</option>
					<option value="76001"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="76001" or $_SESSION['codigoresidenciaa']=="76001") {echo ('selected');}?>>Cali</option>
					<option value="25269"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25269" or $_SESSION['codigoresidenciaa']=="25269") {echo ('selected');}?>>Facatativ&aacute;</option>
					<option value="25286"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25286" or $_SESSION['codigoresidenciaa']=="25286") {echo ('selected');}?>>Funza</option>
					<option value="25377"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25377" or $_SESSION['codigoresidenciaa']=="25377") {echo ('selected');}?>>La
					Calera</option>
					<option value="25430"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25430" or $_SESSION['codigoresidenciaa']=="25430") {echo ('selected');}?>>Madrid</option>
					<option value="05001"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="05001" or $_SESSION['codigoresidenciaa']=="05001") {echo ('selected');}?>>Medell&iacute;n</option>
					<option value="25473"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25473" or $_SESSION['codigoresidenciaa']=="25473") {echo ('selected');}?>>Mosquera</option>
					<option value="25740"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25740" or $_SESSION['codigoresidenciaa']=="25740") {echo ('selected');}?>>Sibat&eacute;</option>
					<option value="25754"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="25754" or $_SESSION['codigoresidenciaa']=="25754") {echo ('selected');}?>>Soacha</option>
					<option value="50001"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="50001" or $_SESSION['codigoresidenciaa']=="50001") {echo ('selected');}?>>Villavicencio</option>
					<option value="15759"
					<?php $z="codigoresidencia"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="15759" or $_SESSION['codigoresidenciaa']=="15759") {echo ('selected');}?>>Sogamoso</option>
				</select></td>
				<td rowspan="6" align="center">Observaciones<br>
				<textarea name="observaciones" id="sqlquery" cols="20" rows="7"
					dir="ltr"><?php if ($_SESSION['observacionesa']!=""){echo $_SESSION[observacionesa];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observaciones");}?></textarea>
				</td>
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Telefono:</td>
				<td align="left"><input class="largo" name="telefono"
					value="<?php
			 if ($_SESSION['telefonoa']!=""){
			  	echo $_SESSION[telefonoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Celular:</td>
				<td align="left"><input name="celular" class="largo"
					value="<?php
			 if ($_SESSION['celulara']!=""){
			  	echo $_SESSION[celulara];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"celular");}  ?>">
				</td>
			</tr>
				<!-- Row 11 -->
			<tr>
				<!-- Row 7 -->
				<td align="right">Nivel de vigilancia:</td>
				<td align="left"><select name="codnivelvig" class="largo1">
					<option value=""></option>
					<option value="10"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==10 or $_SESSION['codnivelviga']==10) {echo ('selected');}?>>Nivel
					I, curso de Introduccion</option>
					<option value="11"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==11 or $_SESSION['codnivelviga']==11) {echo ('selected');}?>>Nivel
					II o III, curso Basico</option>
					<option value="12"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==12 or $_SESSION['codnivelviga']==12) {echo ('selected');}?>>Nivel
					IV, curso Avanzado</option>
					<option value="13"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==13 or $_SESSION['codnivelviga']==13) {echo ('selected');}?>>Actualizaciones</option>
					<option value="14"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==14 or $_SESSION['codnivelviga']==14) {echo ('selected');}?>>Especializaciones</option>
					<option value="15"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==15 or $_SESSION['codnivelviga']==15) {echo ('selected');}?>>Avanzado
					Especial</option>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 7 -->
				<td align="right">Rango militar:</td>
				<td align="left"><select name="rangomilitar" class="largo1">
					<option value=""></option>
					<option value="00"
					<?php $z="rangomilitar"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="00" or $_SESSION['rangomilitara']=="00") {echo ('selected');}?>>No
					tiene libreta</option>
					<option value="1"
					<?php $z="rangomilitar"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="1" or $_SESSION['rangomilitara']=="1") {echo ('selected');}?>>Libreta
					de primera</option>
					<option value="2"
					<?php $z="rangomilitar"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="2" or $_SESSION['rangomilitara']=="2") {echo ('selected');}?>>Libreta
					de segunda</option>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<td align="right">*Cargo al que Aspira:</td>
				<td align="left"><select name="cargo" class="largo1">
					<option value=""></option>
					<option value="1"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['cargoa']==1) {echo ('selected');}?>>Directivo</option>
					<option value="3"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['cargoa']==3) {echo ('selected');}?>>Director
					de Operaciones</option>
					<option value="16"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==16 or $_SESSION['cargoa']==16) {echo ('selected');}?>>Director
					de Recursos Humanos</option>
					<option value="17"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==17 or $_SESSION['cargoa']==17) {echo ('selected');}?>>Director
					de Contabilidad</option>
					<option value="4"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['cargoa']==4) {echo ('selected');}?>>Entrenador
					Canino</option>
					<option value="5"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['cargoa']==5) {echo ('selected');}?>>Escoltas</option>
					<option value="6"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['cargoa']==6) {echo ('selected');}?>>Guia
					Canino</option>
					<option value="7"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==7 or $_SESSION['cargoa']==7) {echo ('selected');}?>>Manejador
					Canino</option>
					<option value="8"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==8 or $_SESSION['cargoa']==8) {echo ('selected');}?>>Representante
					Legal</option>
					<option value="9"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==9 or $_SESSION['cargoa']==9) {echo ('selected');}?>>Supervisor</option>
					<option value="10"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==10 or $_SESSION['cargoa']==10) {echo ('selected');}?>>Supervisor
					Medio Tecnologico</option>
					<option value="11"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==11 or $_SESSION['cargoa']==11) {echo ('selected');}?>>Tecnico
					Medio Tecnologico</option>
					<option value="12"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==12 or $_SESSION['cargoa']==12) {echo ('selected');}?>>Guarda de Seguridad</option>
					<option value="13"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==13 or $_SESSION['cargoa']==13) {echo ('selected');}?>>Operador
					Medio Tecnologico</option>
					<option value="14"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==14 or $_SESSION['cargoa']==14) {echo ('selected');}?>>Tripulante</option>
					<option value="15"
					<?php $z="cargo"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==15 or $_SESSION['cargoa']==15) {echo ('selected');}?>>Conductor</option>
				</select></td>
			</tr>
                        <tr>
				<td align="right">Fecha de Solicitud:</td>
				<td align="left"><input name="fechasolicitud" id="fechasolicitud" class="largo"
					value="<?php
			 if ($_SESSION['fechasolicituda']!=""){
			  	echo $_SESSION[fechasolicituda];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechasolicitud");}  ?>"></td>
			</tr>
                         <tr>
				<td align="right">Contratacion aprobada:</td>
				<td align="left">
                                <select name="apruebaseleccion" class="corto1">
                                    <option value=""></option>
                                    <option value="2" <?php $z="apruebaseleccion"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['cargoa']==2) {echo ('selected');}?>>Si</option>
                                    <option value="3" <?php $z="apruebaseleccion"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['cargoa']==3) {echo ('selected');}?>>No</option>
				</select>
                                </td>
			</tr>
			<?php
			if($_SESSION[sucur]=="%"){
				$muestr2[1]="ciudad";
				$muestr2[saltar]="1";
				$cadena34=selection("sucursales","id","%",$muestr2,@mysql_result($result,$_SESSION['i'],sucursal),1,"id","");
				echo '
 	 		<tr>
  			<td align="right">*Sucursal: </td>
     		<td align="left">
	 		<select name="sucurs" class="largo1">'.$cadena34.'
	 		</select>
	 		</td>
     		</tr>
			';	
			}
			?>

		</table>
		</td>
	</tr>
</table>
<div id="controlex">
<table class="control">
	<tr>
		<td colspan="2" class="arriba">Aspirantes a Funcionarios
		</td>
	</tr>
	<tr height="10px"align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"><input type="text" name="criterio"
			style="width:110px;margin-left:5px" class="busqueda" /></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input checked name="opt" type="radio"
			value="1">cualquier <input type="radio" name="opt" value="2">mismo</td>
	</tr>
	<tr height="10px">
		<td valign="middle" colspan="2" align="center">Criterio <select
			name="campobusqueda" style="WIDTH: 115px" class="busqueda">
			<option value="cedula">Cedula</option>
			<option value="codigo">Codigo Cliente</option>
			<option value="nombre">Nombre</option>
			<option value="apellidos">Apellido</option>
			<option value="pasadojudicial">Pasado Judicial</option>
			<option value="telefono">Telefono</option>
			<option value="celular">Celular</option>
			<option value="fechanacimiento">Fecha nacimiento</option>
			<option value="fechaingreso">Fecha ingreso</option>
			<option value="placa">Placa</option>
			<option value="carnetinterno">Carnet</option>
			<option value="credsuperintendencia">Credencial SVySP</option>
		</select></td>
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
			onkeydown="boolvalidar=true;" /> <input type="submit"
			class="botoasp" value="Contratar" name="ejecut"/></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input type="submit"
			class="botonuev" value="Nuevo" name="ejecut"> <input type="submit"
			class="botoing" value="Ingresar"
			<?php if($_SESSION['botonuevo']==0){echo "disabled";}?> name="ejecut"
			onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Aspirante $p de $_SESSION[numreg]";} ?>
		</td>
	</tr>
</table>
<div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
</div></form>
</body>
</html>