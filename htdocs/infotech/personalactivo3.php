<?php
session_start();

@require('funciones2.php');
$link = validar("","","", 1);

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
		$_SESSION['datos']['otraconsulta']="AND personalactivo.activo = 1";

		$_SESSION['botonuevo']=0;
        }else if($_POST['ejecut']=="Ingresar"){

            if($_FILES["rutafoto"]['type']!="" AND $_SESSION['fotoir']==""){
                $tamano = $_FILES["rutafoto"]['size'];
                $tipo = $_FILES["rutafoto"]['type'];
                $archivo = $_FILES["rutafoto"]['name'];
                $prefijo = substr(md5(uniqid(rand())),0,6);

                // copiar la foto al directorio de fotos
                if ($archivo != ""){
                        if($tipo=="image/jpeg"){
                                $destino =  "fotosguardas/".$prefijo.".jpg";
                                $nombrefoto=$prefijo.".jpg";
                                copy($_FILES['rutafoto']['tmp_name'],$destino);
                                $_POST['foto']=$nombrefoto;
                        }else if ($tipo=="image/png") {
                                // guardamos el archivo a la carpeta files
                                $destino =  "fotosguardas/".$prefijo.".png";
                                $nombrefoto=$prefijo.".png";
                                copy($_FILES['rutafoto']['tmp_name'],$destino);
                                $_POST['foto']=$nombrefoto;
                        }else {
                                $mens.= 'verifique el archivo que esta intentando subir\n solo se permiten imagenes jpg y png';
                        }
                }
            }elseif($_SESSION['fotoir']!=""){
                    $nombrefoto=$_SESSION['fotoir']['prefijo']."_".$_SESSION['fotoir']['archivo'];
            }

            if(!hayDuplicado("personalactivo", "cedula", $_POST['cedula'])){//no hay duplicados de cedula
                    //agregar sucursal
                    if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                    $_POST['activo']=1;
                    $_POST['estado']=1;
                    $_POST['apruebaseleccion']=1;
                    
                    $mens.=armarEjecutarSentencia("personalactivo", $_POST, "insert", $_SESSION);
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
					if($tipo=="image/jpeg"){
                                        $destino =  "fotosguardas/".$prefijo.".jpg";
                                        $nombrefoto=$prefijo.".jpg";
                                        copy($_FILES['rutafoto']['tmp_name'],$destino);
                                        $_POST['foto']=$nombrefoto;
                                        }else if ($tipo=="image/png") {
                                                // guardamos el archivo a la carpeta files
                                                $destino =  "fotosguardas/".$prefijo.".png";
                                                $nombrefoto=$prefijo.".png";
                                                copy($_FILES['rutafoto']['tmp_name'],$destino);
                                                $_POST['foto']=$nombrefoto;
                                        }else {
                                                $mens.= 'verifique el archivo que esta intentando subir\n solo se permiten imagenes jpg y png';
                                        }
				}
			}

                        if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                        $_POST['apruebaseleccion']=1;
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

        }else if($_POST['ejecut']=="Retirar"){
                
                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $_POST['activo']="0";   //actualizar a cliente retirado
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
		$_SESSION['datos']['otraconsulta']="AND personalactivo.activo = 1";

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

$muestr[1]="codigo";
$otrasent="AND clientes.activo = 1 AND clientes.sucursal LIKE '$_SESSION[sucur]'";
$cadena=selection("clientes","codigo","%",$muestr,$coddep,1,"codigo",$otrasent);

$muestrcarg[1]="cargo";
$otrasent="AND cargos.sucursal LIKE '$_SESSION[sucur]'";
$cadenacargos=selection("cargos","id","%",$muestrcarg,@mysql_result($result,$_SESSION['i'],"cargo"),1,"cargo",$otrasent);

$muestrdeptospert[1]="departamento";
$muestrdeptospert[2]="codigo";
$otrasent="AND departamentos.activo = 1 AND departamentos.sucursal LIKE '$_SESSION[sucur]'";
$cadenadeptos = selection("departamentos","id","%",$muestrdeptospert,@mysql_result($result,$_SESSION['i'],"deptoempresa"),2,"departamento",$otrasent);

$muestrdeptos[1]="NOMBRE";
$cadenadepartamentos = selection("departamentospaises","ID_DPTO","%",$muestrdeptos,@mysql_result($result,$_SESSION['i'],"coddeptonacim"),1,"NOMBRE","");

$cadenaciudades = selection("ciudades","ID_CIUDAD","%",$muestrdeptos,@mysql_result($result,$_SESSION['i'],"codciudadnacim"),1,"NOMBRE"," AND ciudades.ID_DPTO='".@mysql_result($result,$_SESSION['i'],"coddeptonacim")."'");

$muestrccf[1] = "descripcion";
$cadenaccf = selection("ccfs","id","%",$muestrccf,@mysql_result($result,$_SESSION['i'],"ccf"),1,"descripcion","");
//enviar lista de familiares para grid
$arrayJs = enviarFamilia(@mysql_result($result,$_SESSION['i'],"cedula"), $link);

$r=@require('version.php');
caracteresiso();
?>
<link	rel="stylesheet" href="estilo2.css" type="text/css"/>
<link	rel="stylesheet" href="botones.css" type="text/css"/>

<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/personalActivo.js"></script>
<script type="text/javascript" src="ext/examples/ux/GroupSummary.js"></script>
<script type="text/javascript" src="ext/examples/grid/expExcel.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<script	language="javascript" type="text/javascript" src="scripts/personalactivo1.js"></script>
<script	language="javascript" type="text/javascript" src="scripts/cargamunicipios.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->

<style type="text/css">
p { width:300px; }
ul.x-tab-strip-top{
	padding-top: 1px;
	background: repeat-x bottom;
	border-bottom: 1px solid;
	background-color: white;
}
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
                function ventana3(){
		window.open("capturaimg.php","Documento","width=1024px,height=540px,menubar=0,scrollbars=1");
		}
//-->
</script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<form method="post" name="peract" id="peract" action="personalactivo3.php" enctype="multipart/form-data" onsubmit="return validaperact(boolvalidar);">
<div id="tabspersonal"></div>
<div id="Datos Basicos" style="display:none">
<table class="tablaprinc" id="tablaprinc">
	<tr>
				<td align="right" width="210px">*Asignado al cliente:</td>
				<td align="left" width="200px"><select class="largo1" name="codigo">
					<option value=""></option>
					<?php echo $cadena;?>
				</select> </td>
				<!-- Col 1 -->
				<td rowspan="8" align="center"><?php

                        $focto=@mysql_result($result,$_SESSION['i'],"foto");
                         
	 		if($focto!=""){
                            $dim=redimensionarFoto(200, 150, "fotosguardas/".$focto);
                            print("<a href='fotosguardas/$focto' target='_blank'><img style=\"width:".$dim['ancho']."px;height:".$dim['alto']."px\" name=\"changing\" src=\"fotosguardas/"."$focto\""."/></a>") ;
                        }else{
                            echo "<img style=\"width: 150px\" name=\"changing\"	src=\"fotosguardas/foto0.gif\""."/>" ;}
	 			?></td>
			</tr>
			<tr>
				<td align="right">*Cedula de Ciudadania:</td>
				<td align="left"><input class="corto" size="31"
					value="<?php
			
			  if ($_SESSION['cedulaa']!=""){
			  	echo $_SESSION[cedulaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cedula");}
			 
			?>"
					name="cedula">
				</td>
			</tr>
                        <tr>
                        <td align="right">De</td><td><input class="largo" name="expedida"
					value="<?php if ($_SESSION['expedidaa']!=""){echo $_SESSION[expedidaa];
			}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"expedida");} ?>"></td>
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
				<!-- Row 6 -->
				<td align="right">Rh:</td>
				<td align="left"><select name="rh" class="corto1">
					<option value=""></option>
					<option value="1"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['rha']==1) {echo ('selected');}?>>O
					+</option>
					<option value="2"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['rha']==2) {echo ('selected');}?>>O
					-</option>
					<option value="3"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['rha']==3) {echo ('selected');}?>>A
					+</option>
					<option value="4"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['rha']==4) {echo ('selected');}?>>A
					-</option>
					<option value="5"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['rha']==5) {echo ('selected');}?>>B
					+</option>
					<option value="6"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['rha']==6) {echo ('selected');}?>>B
					-</option>
					<option value="7"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==7 or $_SESSION['rha']==7) {echo ('selected');}?>>AB
					+</option>
					<option value="8"
					<?php $z="rh"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==8 or $_SESSION['rha']==8) {echo ('selected');}?>>AB
					-</option>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 7 -->
				<td align="right">Estado civil:</td>
				<td align="left"><select name="estadocivil" class="largo1">
					<option value=""></option>
					<option value="1"
					<?php $z="estadocivil"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['estadocivila']==1) {echo ('selected');}?>>Soltero</option>
					<option value="2"
					<?php $z="estadocivil"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['estadocivila']==2) {echo ('selected');}?>>Casado</option>
					<option value="3"
					<?php $z="estadocivil"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['estadocivila']==3) {echo ('selected');}?>>Union
					libre</option>
					<option value="4"
					<?php $z="estadocivil"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['estadocivila']==4) {echo ('selected');}?>>Separado</option>
					<option value="5"
					<?php $z="estadocivil"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['estadocivila']==5) {echo ('selected');}?>>Viudo</option>
					<option value="6"
					<?php $z="estadocivil"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['estadocivila']==6) {echo ('selected');}?>>Divorciado</option>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<td align="right">Cargar Fotografia:</td>
				<td><input class="largo" type="file" size="8px" name="rutafoto"></td>
                                <td align="center">
                                    <?php if($_SESSION[clientemod]!=""){echo "<a href=\"capturaimg.php\" target=\"_blank\">Capturar Foto</a>";}?>
                                </td>
			</tr>
			<tr>
				<!-- Row 8 -->
				<td align="right">Num Verificaci&oacute;n Judicial:</td>
				<td align="left"><input class="largo" name="pasadojudicial"
					value="<?php
			 if ($_SESSION['pasadojudiciala']!=""){
			  	echo $_SESSION[pasadojudiciala];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"pasadojudicial");}  ?>">
				</td>
				<!-- Col 1 -->
				<td rowspan="6" align="center">Observaciones<br>
				<textarea name="observaciones" id="sqlquery" cols="20" rows="7"
					dir="ltr"><?php if ($_SESSION['observacionesa']!=""){echo $_SESSION[observacionesa];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observaciones");}?></textarea>
				</td>
			</tr>
                        <tr>
				<!-- Row 8 -->
				<td align="right">Email:</td>
				<td align="left"><input class="largo" name="email" id="email" 
					value="<?php
			 if ($_SESSION['emaila']!=""){
			  	echo $_SESSION[emaila];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"email");}  ?>">
			</tr>
			<tr>
				<!-- Row 9 -->
				<td align="right">Fecha de vencimiento:</td>
				<td align="left"><input class="largo" name="vigenciapj" id="vigenciapj"
					value="<?php
			 if ($_SESSION['vigenciapja']!=""){
			  	echo $_SESSION[vigenciapja];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"vigenciapj");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 10 -->
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
				<!-- Col 1 -->
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
				<td align="center"><?php 
				$sqldocs="SELECT * FROM `docspersonal` WHERE `docspersonal`.`ceduladoc` ='". @mysql_result($result,$_SESSION['i'],"cedula")."'";
				$numdocs=@mysql_num_rows(@mysql_query($sqldocs, $link)) or $error=@mysql_error();
	 		if($_SESSION[clientemod]!=""){echo "<a href=\"subirdoc.php\" target=\"_blank\">Documentos ($numdocs)</a>";}
	 		?></td>
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Fecha de nacimiento:</td>
				<td align="left"><input name="fechanacimiento" id="fechanacimiento"  class="largo"
					value="<?php
			 if ($_SESSION['fechanacimientoa']!=""){
			  	echo $_SESSION[fechanacimientoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechanacimiento");}  ?>">
				</td><td align="center">
                                <?php if($_SESSION[clientemod]!=""){echo "<a href=\"huellas.php\" target=\"_blank\">Biometr&iacute;a</a>";}?>
                                </td>
			</tr>
			<tr>
				<!-- Row 6 -->
				<td align="right">Departamento nacimiento:</td>
				<td align="left"><select class="largo1" name="coddeptonacim" id="coddeptonacim">
                                <option value=""></option>
                                <?php echo $cadenadepartamentos;?>
				</select></td>
                                <td align="center">
                                <?php if($_SESSION[clientemod]!=""){echo "<a id=\"enviarComunicado\">Enviar Correo al Guarda</a>";}?>
                                
                                </td>
			</tr>
			<tr>
				<!-- Row 6 -->
				<td align="right">Ciudad de nacimiento:</td>
				<td valign="top"><select name="codciudadnacim" class="largo1" id="codciudadnacim">
					<option value=""></option>
					<?php echo $cadenaciudades; ?>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Oficio tramite credencial:</td>
				<td align="left"><input name="oficiotramitecred" class="largo"
					value="<?php
			if ($_SESSION['oficiotramitecreda']!=""){
			  	echo $_SESSION[oficiotramitecreda];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"oficiotramitecred");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
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
                                        <option value="16"
					<?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==16 or $_SESSION['codnivelviga']==16) {echo ('selected');}?>>Basico Supervisor</option>
                                        <option value="17"
                                        <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==17 or $_SESSION['codnivelviga']==17) {echo ('selected');}?>>Avanzado Supervisor</option>
                                        <option value="18"
                                        <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==18 or $_SESSION['codnivelviga']==18) {echo ('selected');}?>>Actualizaciones Supervisor</option>
                                        <option value="19"
                                        <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==19 or $_SESSION['codnivelviga']==19) {echo ('selected');}?>>Basico Escolta</option>
                                        <option value="20"
                                        <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==20 or $_SESSION['codnivelviga']==20) {echo ('selected');}?>>Avanzado Escolta</option>
                                        <option value="21"
                                        <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==21 or $_SESSION['codnivelviga']==21) {echo ('selected');}?>>Actualizaciones Escolta</option>
                                        <option value="1101" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1101 or $_SESSION['codnivelviga']==1101) {echo ('selected');}?>>FUNDAMENTACION VIGILANCIA</option>
                                        <option value="1201" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1201 or $_SESSION['codnivelviga']==1201) {echo ('selected');}?>>REENTRENAMIENTO VIGILANCIA</option>
                                        <option value="1301" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1301 or $_SESSION['codnivelviga']==1301) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA AEROPORTUARIA</option>
                                        <option value="1302" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1302 or $_SESSION['codnivelviga']==1302) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA SECTOR FINANCIERO</option>
                                        <option value="1303" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1303 or $_SESSION['codnivelviga']==1303) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA COMERCIAL</option>
                                        <option value="1304" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1304 or $_SESSION['codnivelviga']==1304) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA EDUCATIVA</option>
                                        <option value="1305" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1305 or $_SESSION['codnivelviga']==1305) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA EVENTOS PUBLICOS</option>
                                        <option value="1306" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1306 or $_SESSION['codnivelviga']==1306) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA HOSPITALARIA</option>
                                        <option value="1307" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1307 or $_SESSION['codnivelviga']==1307) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA PORTUARIA</option>
                                        <option value="1308" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1308 or $_SESSION['codnivelviga']==1308) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA INDUSTRIAL</option>
                                        <option value="1309" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1309 or $_SESSION['codnivelviga']==1309) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA RESIDENCIAL</option>
                                        <option value="1310" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1310 or $_SESSION['codnivelviga']==1310) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA PETROLERA</option>
                                        <option value="1311" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1311 or $_SESSION['codnivelviga']==1311) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA TURISTICA</option>
                                        <option value="1312" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1312 or $_SESSION['codnivelviga']==1312) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA ENTIDADES OFICIALES</option>
                                        <option value="1313" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1313 or $_SESSION['codnivelviga']==1313) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA MINERA</option>
                                        <option value="1314" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1314 or $_SESSION['codnivelviga']==1314) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA GRANDES SUPERFICIES</option>
                                        <option value="1315" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1315 or $_SESSION['codnivelviga']==1315) {echo ('selected');}?>>ESPECIALIZACION VIGILANCIA TRANSPORTE MASIVO</option>
                                        <option value="1401" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1401 or $_SESSION['codnivelviga']==1401) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA AEROPORTUARIA</option>
                                        <option value="1402" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1402 or $_SESSION['codnivelviga']==1402) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA SECTOR FINANCIERO</option>
                                        <option value="1403" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1403 or $_SESSION['codnivelviga']==1403) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA COMERCIAL</option>
                                        <option value="1404" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1404 or $_SESSION['codnivelviga']==1404) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA EDUCATIVA</option>
                                        <option value="1405" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1405 or $_SESSION['codnivelviga']==1405) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA EVENTOS PUBLICOS</option>
                                        <option value="1406" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1406 or $_SESSION['codnivelviga']==1406) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA HOSPITALARIA</option>
                                        <option value="1407" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1407 or $_SESSION['codnivelviga']==1407) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA PORTUARIA</option>
                                        <option value="1408" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1408 or $_SESSION['codnivelviga']==1408) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA INDUSTRIAL</option>
                                        <option value="1409" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1409 or $_SESSION['codnivelviga']==1409) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA RESIDENCIAL</option>
                                        <option value="1410" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1410 or $_SESSION['codnivelviga']==1410) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA PETROLERA</option>
                                        <option value="1411" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1411 or $_SESSION['codnivelviga']==1411) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA TURISTICA</option>
                                        <option value="1412" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1412 or $_SESSION['codnivelviga']==1412) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA ENTIDADES OFICIALES</option>
                                        <option value="1413" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1413 or $_SESSION['codnivelviga']==1413) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA MINERA</option>
                                        <option value="1414" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1414 or $_SESSION['codnivelviga']==1414) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA GRANDES SUPERFICIES</option>
                                        <option value="1415" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1415 or $_SESSION['codnivelviga']==1415) {echo ('selected');}?>>PROFUNDIZACION VIGILANCIA TRANSPORTE MASIVO</option>
                                        <option value="2101" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2101 or $_SESSION['codnivelviga']==2101) {echo ('selected');}?>>FUNDAMENTACION ESCOLTAS</option>
                                        <option value="2201" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2201 or $_SESSION['codnivelviga']==2201) {echo ('selected');}?>>REENTRENAMIENTO ESCOLTAS</option>
                                        <option value="2301" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2301 or $_SESSION['codnivelviga']==2301) {echo ('selected');}?>>ESPECIALIZACION ESCOLTA PERSONAS</option>
                                        <option value="2302" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2302 or $_SESSION['codnivelviga']==2302) {echo ('selected');}?>>ESPECIALIZACION ESCOLTA MERCANCIAS</option>
                                        <option value="2303" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2303 or $_SESSION['codnivelviga']==2303) {echo ('selected');}?>>ESPECIALIZACION ESCOLTA MANEJO DEFENSIVO</option>
                                        <option value="2304" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2304 or $_SESSION['codnivelviga']==2304) {echo ('selected');}?>>ESPECIALIZACION ESCOLTA TRANSPORTE  VALORES</option>
                                        <option value="2305" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2305 or $_SESSION['codnivelviga']==2305) {echo ('selected');}?>>ESPECIALIZACION ESCOLTA PROTECCION A DIGNATARIOS</option>
                                        <option value="2401" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2401 or $_SESSION['codnivelviga']==2401) {echo ('selected');}?>>PROFUNDIZACION ESCOLTA PERSONAS</option>
                                        <option value="2402" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2402 or $_SESSION['codnivelviga']==2402) {echo ('selected');}?>>PROFUNDIZACION ESCOLTA MERCANCIAS</option>
                                        <option value="2403" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2403 or $_SESSION['codnivelviga']==2403) {echo ('selected');}?>>PROFUNDIZACION ESCOLTA MANEJO DEFENSIVO</option>
                                        <option value="2404" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2404 or $_SESSION['codnivelviga']==2404) {echo ('selected');}?>>PROFUNDIZACION ESCOLTA TRANSPORTE  VALORES</option>
                                        <option value="2405" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2405 or $_SESSION['codnivelviga']==2405) {echo ('selected');}?>>PROFUNDIZACION ESCOLTA PROTECCION A DIGNATARIOS</option>
                                        <option value="3101" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3101 or $_SESSION['codnivelviga']==3101) {echo ('selected');}?>>FUNDAMENTACION SUPERVISORES</option>
                                        <option value="3201" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3201 or $_SESSION['codnivelviga']==3201) {echo ('selected');}?>>REENTRENAMIENTO SUPERVISORES</option>
                                        <option value="3301" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3301 or $_SESSION['codnivelviga']==3301) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES AEROPORTUARIA</option>
                                        <option value="3302" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3302 or $_SESSION['codnivelviga']==3302) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES SECTOR FINANCIERO</option>
                                        <option value="3303" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3303 or $_SESSION['codnivelviga']==3303) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES COMERCIAL</option>
                                        <option value="3304" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3304 or $_SESSION['codnivelviga']==3304) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES EDUCATIVA</option>
                                        <option value="3305" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3305 or $_SESSION['codnivelviga']==3305) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES EVENTOS PUBLICOS</option>
                                        <option value="3306" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3306 or $_SESSION['codnivelviga']==3306) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES HOSPITALARIA</option>
                                        <option value="3307" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3307 or $_SESSION['codnivelviga']==3307) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES PORTUARIA</option>
                                        <option value="3308" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3308 or $_SESSION['codnivelviga']==3308) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES INDUSTRIAL</option>
                                        <option value="3309" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3309 or $_SESSION['codnivelviga']==3309) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES RESIDENCIAL</option>
                                        <option value="3310" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3310 or $_SESSION['codnivelviga']==3310) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES MEDIOS TECNOLOGICOS</option>
                                        <option value="3311" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3311 or $_SESSION['codnivelviga']==3311) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES PETROLERA</option>
                                        <option value="3312" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3312 or $_SESSION['codnivelviga']==3312) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES TURISTICA</option>
                                        <option value="3313" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3313 or $_SESSION['codnivelviga']==3313) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES ENTIDADES OFICIALES</option>
                                        <option value="3314" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3314 or $_SESSION['codnivelviga']==3314) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES MINERA</option>
                                        <option value="3315" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3315 or $_SESSION['codnivelviga']==3315) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES GRANDES SUPERFICIES</option>
                                        <option value="3316" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3316 or $_SESSION['codnivelviga']==3316) {echo ('selected');}?>>ESPECIALIZACION SUPERVISORES TRANSPORTE MASIVO</option>
                                        <option value="3401" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3401 or $_SESSION['codnivelviga']==3401) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES AEROPORTUARIA</option>
                                        <option value="3402" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3402 or $_SESSION['codnivelviga']==3402) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES SECTOR FINANCIERO</option>
                                        <option value="3403" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3403 or $_SESSION['codnivelviga']==3403) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES COMERCIAL</option>
                                        <option value="3404" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3404 or $_SESSION['codnivelviga']==3404) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES EDUCATIVA</option>
                                        <option value="3405" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3405 or $_SESSION['codnivelviga']==3405) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES EVENTOS PUBLICOS</option>
                                        <option value="3406" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3406 or $_SESSION['codnivelviga']==3406) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES HOSPITALARIA</option>
                                        <option value="3407" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3407 or $_SESSION['codnivelviga']==3407) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES PORTUARIA</option>
                                        <option value="3408" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3408 or $_SESSION['codnivelviga']==3408) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES INDUSTRIAL</option>
                                        <option value="3409" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3409 or $_SESSION['codnivelviga']==3409) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES RESIDENCIAL</option>
                                        <option value="3410" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3410 or $_SESSION['codnivelviga']==3410) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES MEDIOS TECNOLOGICOS</option>
                                        <option value="3411" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3411 or $_SESSION['codnivelviga']==3411) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES PETROLERA</option>
                                        <option value="3412" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3412 or $_SESSION['codnivelviga']==3412) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES TURISTICA</option>
                                        <option value="3413" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3413 or $_SESSION['codnivelviga']==3413) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES ENTIDADES OFICIALES</option>
                                        <option value="3414" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3414 or $_SESSION['codnivelviga']==3414) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES MINERA</option>
                                        <option value="3415" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3415 or $_SESSION['codnivelviga']==3415) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES GRANDES SUPERFICIES</option>
                                        <option value="3416" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3416 or $_SESSION['codnivelviga']==3416) {echo ('selected');}?>>PROFUNDIZACION SUPERVISORES TRANSPORTE MASIVO</option>
                                        <option value="4101" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4101 or $_SESSION['codnivelviga']==4101) {echo ('selected');}?>>FUNDAMENTACION MEDIOS TECNOLOGICOS</option>
                                        <option value="4201" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4201 or $_SESSION['codnivelviga']==4201) {echo ('selected');}?>>REENTRENAMIENTO MEDIOS TECNOLOGICOS</option>
                                        <option value="4301" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4301 or $_SESSION['codnivelviga']==4301) {echo ('selected');}?>>ESPECIALIZACION MEDIOS TECNOLOGICOS COORDINADOR</option>
                                        <option value="4302" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4302 or $_SESSION['codnivelviga']==4302) {echo ('selected');}?>>ESPECIALIZACION MEDIOS TECNOLOGICOS INSTALADOR</option>
                                        <option value="4401" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4401 or $_SESSION['codnivelviga']==4401) {echo ('selected');}?>>PROFUNDIZACION MEDIOS TECNOLOGICOS COORDINADOR</option>
                                        <option value="4402" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4402 or $_SESSION['codnivelviga']==4402) {echo ('selected');}?>>PROFUNDIZACION MEDIOS TECNOLOGICOS INSTALADOR</option>
                                        <option value="5101" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5101 or $_SESSION['codnivelviga']==5101) {echo ('selected');}?>>FUNDAMENTACION MANEJADOR CANINO ENFASIS EN NARCOTICOS</option>
                                        <option value="5102" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5102 or $_SESSION['codnivelviga']==5102) {echo ('selected');}?>>FUNDAMENTACION MANEJADOR CANINO ENFASIS EN MONEDA</option>
                                        <option value="5103" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5103 or $_SESSION['codnivelviga']==5103) {echo ('selected');}?>>FUNDAMENTACION MANEJADOR CANINO ENFASIS EN DEFENSA</option>
                                        <option value="5104" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5104 or $_SESSION['codnivelviga']==5104) {echo ('selected');}?>>FUNDAMENTACION MANEJADOR CANINO ENFASIS EN EXPLOSIVOS</option>
                                        <option value="5105" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5105 or $_SESSION['codnivelviga']==5105) {echo ('selected');}?>>FUNDAMENTACION MANEJADOR CANINO ENFASIS EN BUSQUEDA Y RESCATE</option>
                                        <option value="5201" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5201 or $_SESSION['codnivelviga']==5201) {echo ('selected');}?>>REENTRENAMIENTO MANEJADOR CANINO ENFASIS EN NARCOTICOS</option>
                                        <option value="5202" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5202 or $_SESSION['codnivelviga']==5202) {echo ('selected');}?>>REENTRENAMIENTO MANEJADOR CANINO ENFASIS EN MONEDA</option>
                                        <option value="5203" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5203 or $_SESSION['codnivelviga']==5203) {echo ('selected');}?>>REENTRENAMIENTO MANEJADOR CANINO ENFASIS EN DEFENSA</option>
                                        <option value="5204" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5204 or $_SESSION['codnivelviga']==5204) {echo ('selected');}?>>REENTRENAMIENTO MANEJADOR CANINO ENFASIS EN EXPLOSIVOS</option>
                                        <option value="5205" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5205 or $_SESSION['codnivelviga']==5205) {echo ('selected');}?>>REENTRENAMIENTO MANEJADOR CANINO ENFASIS EN BUSQUEDA Y RESCATE</option>
                                        <option value="5301" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5301 or $_SESSION['codnivelviga']==5301) {echo ('selected');}?>>ESPECIALIZACION MANEJADOR CANINO SUPERVISOR</option>
                                        <option value="5302" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5302 or $_SESSION['codnivelviga']==5302) {echo ('selected');}?>>ESPECIALIZACION MANEJADOR CANINO DEFENSA CONTROLADA</option>
                                        <option value="5303" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5303 or $_SESSION['codnivelviga']==5303) {echo ('selected');}?>>ESPECIALIZACION MANEJADOR CANINO DETECCION EXPLOSIVOS</option>
                                        <option value="5304" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5304 or $_SESSION['codnivelviga']==5304) {echo ('selected');}?>>ESPECIALIZACION MANEJADOR CANINO DETECCION NARCOTICOS</option>
                                        <option value="5305" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5305 or $_SESSION['codnivelviga']==5305) {echo ('selected');}?>>ESPECIALIZACION MANEJADOR CANINO DETECCION MONEDA</option>
                                        <option value="5306" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5306 or $_SESSION['codnivelviga']==5306) {echo ('selected');}?>>ESPECIALIZACION MANEJADOR CANINO BUSQUEDA Y RESCATE</option>
                                        <option value="5401" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5401 or $_SESSION['codnivelviga']==5401) {echo ('selected');}?>>PROFUNDIZACION MANEJADOR CANINO SUPERVISOR</option>
                                        <option value="5402" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5402 or $_SESSION['codnivelviga']==5402) {echo ('selected');}?>>PROFUNDIZACION MANEJADOR CANINO DEFENSA CONTROLADA</option>
                                        <option value="5403" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5403 or $_SESSION['codnivelviga']==5403) {echo ('selected');}?>>PROFUNDIZACION MANEJADOR CANINO DETECCION EXPLOSIVOS</option>
                                        <option value="5404" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5404 or $_SESSION['codnivelviga']==5404) {echo ('selected');}?>>PROFUNDIZACION MANEJADOR CANINO DETECCION NARCOTICOS</option>
                                        <option value="5405" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5405 or $_SESSION['codnivelviga']==5405) {echo ('selected');}?>>PROFUNDIZACION MANEJADOR CANINO DETECCION MONEDA</option>
                                        <option value="5406" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5406 or $_SESSION['codnivelviga']==5406) {echo ('selected');}?>>PROFUNDIZACION MANEJADOR CANINO BUSQUEDA Y RESCATE</option>
                                        <option value="6101" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6101 or $_SESSION['codnivelviga']==6101) {echo ('selected');}?>>SEMINARIO ADMINISTRACION DE SERVICIOS DE V.S.P.</option>
                                        <option value="6102" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6102 or $_SESSION['codnivelviga']==6102) {echo ('selected');}?>>SEMINARIO JEFES DE RECURSOS HUMANOS</option>
                                        <option value="6103" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6103 or $_SESSION['codnivelviga']==6103) {echo ('selected');}?>>SEMINARIO JEFES DE OPERACION DE EMPRESA DE V.S.P.</option>
                                        <option value="6104" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6104 or $_SESSION['codnivelviga']==6104) {echo ('selected');}?>>SEMINARIO ESPECTACULOS PUBLICOS</option>
                                        <option value="6105" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6105 or $_SESSION['codnivelviga']==6105) {echo ('selected');}?>>SEMINARIO JEFES DE SEGURIDAD DE DEPARTAMENTOS</option>
                                        <option value="6106" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6106 or $_SESSION['codnivelviga']==6106) {echo ('selected');}?>>SEMINARIO COORDINADORES DE MEDIOS TECNOLOGICOS</option>
                                        <option value="6107" <?php $z="codnivelvig"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6107 or $_SESSION['codnivelviga']==6107) {echo ('selected');}?>>SEMINARIO INSTALADORES DE EQUIPOS PARA LA VIGILANCIA Y S.P.</option>
				</select></td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Fecha vencimiento curso:</td>
				<td align="left"><input name="vigenciacurso" class="largo" id="vigenciacurso"
					value="<?php
			if ($_SESSION['vigenciacursoa']!=""){
			  	echo $_SESSION[vigenciacursoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"vigenciacurso");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
                         <tr>
				<!-- Row 11 -->
				<td align="right">Num Verificacion Curso:</td>
				<td align="left"><input name="numverificacioncurso" class="largo"
					value="<?php
			if ($_SESSION['oficiotranumverificacioncursomitecreda']!=""){
			  	echo $_SESSION[oficiotramitecreda];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"numverificacioncurso");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Numero de hijos:</td>
				<td align="left"><input name="numhijos" class="largo"
					value="<?php
			if ($_SESSION['numhijosa']!=""){
			  	echo $_SESSION[numhijosa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"numhijos");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Numero de Cuenta:</td>
				<td align="left"><input name="numerocuenta" class="largo"
					value="<?php
			if ($_SESSION['numerocuenta']!=""){
			  	echo $_SESSION[numerocuenta];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"numerocuenta");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 7 -->
				<td align="right">EPS:<select name="eps" class="largo1">
					<option value=""></option>
					<option value="27"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==27  or $_SESSION['epsa']==27) {echo ('selected');}?>>Barranquilla
					sana</option>
					<option value="4"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4  or $_SESSION['epsa']==4) {echo ('selected');}?>>Bonsalud</option>
					<option value="3"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['epsa']==3) {echo ('selected');}?>>Cafesalud</option>
					<option value="24"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==24 or $_SESSION['epsa']==24) {echo ('selected');}?>>Cajanal</option>
					<option value="28"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==28 or $_SESSION['epsa']==28) {echo ('selected');}?>>Calisalud</option>
					<option value="20"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==20 or $_SESSION['epsa']==20) {echo ('selected');}?>>Caprecom</option>
					<option value="25"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==25 or $_SESSION['epsa']==25) {echo ('selected');}?>>Capresoca</option>
					<option value="34"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==34 or $_SESSION['epsa']==34) {echo ('selected');}?>>Casur</option>
					<option value="50"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==50 or $_SESSION['epsa']==50) {echo ('selected');}?>>Colmedica</option>
					<option value="15"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==15 or $_SESSION['epsa']==15) {echo ('selected');}?>>Colpatria</option>
					<option value="11"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==11 or $_SESSION['epsa']==11) {echo ('selected');}?>>Colseguros</option>
					<option value="9"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==9 or $_SESSION['epsa']==9) {echo ('selected');}?>>Comfenalco
					Antioquia</option>
					<option value="12"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==12 or $_SESSION['epsa']==12) {echo ('selected');}?>>Comfenalco
					Valle</option>
					<option value="8"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==8 or $_SESSION['epsa']==8) {echo ('selected');}?>>Compensar</option>
					<option value="22"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==22 or $_SESSION['epsa']==22) {echo ('selected');}?>>Convida</option>
					<option value="16"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==16 or $_SESSION['epsa']==16) {echo ('selected');}?>>Coomeva</option>
					<option value="21"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==21 or $_SESSION['epsa']==21) {echo ('selected');}?>>Corporanominas</option>
					<option value="23"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==23 or $_SESSION['epsa']==23) {echo ('selected');}?>>Cruz
					Blanca</option>
					<option value="30"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==30 or $_SESSION['epsa']==30) {echo ('selected');}?>>Eps
					Condor</option>
					<option value="29"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==29 or $_SESSION['epsa']==29) {echo ('selected');}?>>Eps
					de Caldas</option>
					<option value="19"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==19 or $_SESSION['epsa']==19) {echo ('selected');}?>>Eps
					de Risaralda</option>
					<option value="17"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==17 or $_SESSION['epsa']==17) {echo ('selected');}?>>Famisanar</option>
					<option value="51"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==51 or $_SESSION['epsa']==51) {echo ('selected');}?>>Fosyga</option>
					<option value="14"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==14 or $_SESSION['epsa']==14) {echo ('selected');}?>>Humana</option>
					<option value="52"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==52 or $_SESSION['epsa']==52) {echo ('selected');}?>>Nueva
					EPS</option>
					<option value="53"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==53 or $_SESSION['epsa']==53) {echo ('selected');}?>>Red
					Salud</option>
					<option value="1"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['epsa']==1) {echo ('selected');}?>>Salud
					Colmena</option>
					<option value="2"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['epsa']==2) {echo ('selected');}?>>Salud
					Total</option>
					<option value="33"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==33 or $_SESSION['epsa']==33) {echo ('selected');}?>>Salud
					Vida</option>
					<option value="13"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==13 or $_SESSION['epsa']==13) {echo ('selected');}?>>Saludcoop</option>
					<option value="5"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['epsa']==5) {echo ('selected');}?>>Sanitas</option>
					<option value="34"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==34 or $_SESSION['epsa']==34) {echo ('selected');}?>>Sanidad
					Militar</option>
					<option value="6"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['epsa']==6) {echo ('selected');}?>>Seguro
					Social</option>
					<option value="31"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==31 or $_SESSION['epsa']==31) {echo ('selected');}?>>Selva
					Salud</option>
					<option value="26"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==26 or $_SESSION['epsa']==26) {echo ('selected');}?>>Solsalud</option>
					<option value="18"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==18 or $_SESSION['epsa']==18) {echo ('selected');}?>>Sos
					Servicio Occ Salud</option>
					<option value="10"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==10 or $_SESSION['epsa']==10) {echo ('selected');}?>>Sura</option>
					<option value="7"
					<?php $z="eps"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==7 or $_SESSION['epsa']==7) {echo ('selected');}?>>Unimec</option>
				</select></td>
				<td align="left">Afiliado:<input type="checkbox"
					name="epscheck"
					<?php if(@mysql_result($result,$_SESSION['i'],epscheck)==1 or $_SESSION[epschecka]=="on"){echo "checked";}?> />Radicado:
				<input name="noafeps" class="corto"
					value="<?php if ($_SESSION['noafepsa']!=""){echo $_SESSION[noafepsa];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"noafeps");}?>"></td><td>
				<input name="epsfecha" class="corto"  id="epsfecha" value="<?php if ($_SESSION['epsfechaa']!=""){echo $_SESSION[epsfechaa];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"epsfecha");}?>">
				</td>
			</tr>
			<tr>
				<td align="right">ARP: <select name="arp" class="largo1">
					<option value=""></option>
					<option value="200"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==200 or $_SESSION['arpa']==200) {echo ('selected');}?>>Agricola
					de Seguros</option>
					<option value="206"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==206 or $_SESSION['arpa']==206) {echo ('selected');}?>>Bolivar</option>
					<option value="203"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==203 or $_SESSION['arpa']==203) {echo ('selected');}?>>Colmena</option>
					<option value="202"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==202 or $_SESSION['arpa']==202) {echo ('selected');}?>>Colpatria</option>
					<option value="207"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==207 or $_SESSION['arpa']==207) {echo ('selected');}?>>Colseguros</option>
					<option value="300"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==300 or $_SESSION['arpa']==300) {echo ('selected');}?>>Fosyga</option>
					<option value="201"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==201 or $_SESSION['arpa']==201) {echo ('selected');}?>>Positiva</option>
					<option value="208"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==208 or $_SESSION['arpa']==208) {echo ('selected');}?>>Liberty</option>
					<option value="299"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==299 or $_SESSION['arpa']==299) {echo ('selected');}?>>Otras</option>
					<option value="204"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==204 or $_SESSION['arpa']==204) {echo ('selected');}?>>Previ-Atep</option>
					<option value="205"
					<?php $z="arp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==205 or $_SESSION['arpa']==205) {echo ('selected');}?>>Suratep</option>
				</select></td>
				<td align="left">Afiliado:<input type="checkbox"
					name="arpcheck"
					<?php if(@mysql_result($result,$_SESSION['i'],arpcheck)==1 or $_SESSION[arpchecka]=="on"){echo "checked";}?> />Radicado:
				<input name="noafarp" class="corto"
					value="<?php
			if ($_SESSION['noafarpa']!=""){
			  	echo $_SESSION[noafarpa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"noafarp");}  ?>"></td><td>
				<input name="arpfecha" class="corto" id="arpfecha"
					value="<?php
			if ($_SESSION['arpfechaa']!=""){
			  	echo $_SESSION[arpfechaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"arpfecha");}  ?>"></td>
			</tr>
			<tr>
				<td align="right">ARL:<select name="afp" class="largo1">
					<option value=""></option>
					<option value="309"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==309 or $_SESSION['afpa']==309) {echo ('selected');}?>>Askandia</option>
					<option value="508"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==508 or $_SESSION['afpa']==508) {echo ('selected');}?>>Cajanal</option>
					<option value="318"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==318 or $_SESSION['afpa']==318) {echo ('selected');}?>>Caldas</option>
					<option value="307"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==307 or $_SESSION['afpa']==307) {echo ('selected');}?>>Cesantias
					de Colombia</option>
					<option value="310"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==310 or $_SESSION['afpa']==310) {echo ('selected');}?>>Colfondos</option>
					<option value="304"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==304 or $_SESSION['afpa']==304) {echo ('selected');}?>>Colmena</option>
					<option value="301"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==301 or $_SESSION['afpa']==301) {echo ('selected');}?>>Colpatria</option>
					<option value="308"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==308 or $_SESSION['afpa']==308) {echo ('selected');}?>>Davivir</option>
					<option value="306"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==306 or $_SESSION['afpa']==306) {echo ('selected');}?>>Ganadera</option>
					<option value="305"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==305 or $_SESSION['afpa']==305) {echo ('selected');}?>>Horizonte</option>
					<option value="509"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==509 or $_SESSION['afpa']==509) {echo ('selected');}?>>ING</option>
					<option value="314"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==314 or $_SESSION['afpa']==314) {echo ('selected');}?>>Invertirma&ntilde;ana</option>
					<option value="311"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==311 or $_SESSION['afpa']==311) {echo ('selected');}?>>Invertir</option>
					<option value="319"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==319 or $_SESSION['afpa']==319) {echo ('selected');}?>>Pensionar</option>
					<option value="303"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==303 or $_SESSION['afpa']==303) {echo ('selected');}?>>Porvenir</option>
					<option value="302"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==302 or $_SESSION['afpa']==302) {echo ('selected');}?>>Proteccion</option>
					<option value="312"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==312 or $_SESSION['afpa']==312) {echo ('selected');}?>>Santander</option>
					<option value="501"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==501 or $_SESSION['afpa']==501) {echo ('selected');}?>>Seguro
					Social</option>
					<option value="316"
					<?php $z="afp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==316 or $_SESSION['afpa']==316) {echo ('selected');}?>>Solidez</option>
				</select></td>
				<td align="left">Afiliado:<input type="checkbox"
					name="afpcheck"
					<?php if(@mysql_result($result,$_SESSION['i'],afpcheck)==1 or $_SESSION[afpchecka]=="on"){echo "checked";}?> />Radicado:
				<input name="noafafp" class="corto"
					value="<?php
			if ($_SESSION['noafafpa']!=""){
			  	echo $_SESSION[noafafpa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"noafafp");}  ?>"></td><td>
				<input name="afpfecha" class="corto" id="afpfecha"
					value="<?php
			if ($_SESSION['afpfechaa']!=""){
			  	echo $_SESSION[afpfechaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"afpfecha");}  ?>">
				</td>
			</tr>
                        <tr>
				<td align="right">CCF:<select name="ccf" class="largo1">
					<option value=""></option>
					<?php echo $cadenaccf;?>
    				</select></td>
				<td align="left">Afiliado:<input type="checkbox"
					name="cajacheck"
					<?php if(@mysql_result($result,$_SESSION['i'],cajacheck)==1 or $_SESSION[cajachecka]=="on"){echo "checked";}?> />Radicado:
				<input name="noafcaja" class="corto"
					value="<?php
			if ($_SESSION['noafcajaa']!=""){
			  	echo $_SESSION[noafcajaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"noafcaja");}  ?>"></td><td>
				<input name="cajafecha" class="corto" id="cajafecha"
					value="<?php
			if ($_SESSION['cajafechaa']!=""){
			  	echo $_SESSION[afpfechaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cajafecha");}  ?>">
				</td>
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
				<td align=right>Tipo contrato</td>
				<td><select name="contrato" class="largo1">
					<option value=""></option>
					<option value="1"
					<?php $z="contrato"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sueldoa']==1) {echo ('selected');}?>>Fijo Inferior a 1 a&ntilde;o</option>
					<option value="2"
					<?php $z="contrato"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sueldoa']==2) {echo ('selected');}?>>Fijo Inferior a 3 a&ntilde;os</option>
					<option value="3"
					<?php $z="contrato"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['sueldoa']==3) {echo ('selected');}?>>Labor u Obra</option>
                                        <option value="4"
					<?php $z="contrato"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['sueldoa']==4) {echo ('selected');}?>>Termino Indefinido</option>
				</select></td>
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">*Fecha de ingreso:</td>
				<td align="left"><input name="fechaingreso" class="largo" id="fechaingreso"
					value="<?php
			if ($_SESSION['fechaingresoa']!=""){
			  	echo $_SESSION[fechaingresoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechaingreso");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Fecha fin contrato:</td>
				<td align="left"><input name="fincontrato" class="largo" id="fincontrato"
					value="<?php
			if ($_SESSION['fincontratoa']!=""){
			  	echo $_SESSION[fincontratoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fincontrato");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Placa asignada:</td>
				<td align="left"><input name="placa" class="largo"
					value="<?php
			if ($_SESSION['placaa']!=""){
			  	echo $_SESSION[placaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"placa");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Credencial SVySP:</td>
				<td align="left"><input name="credsuperintendencia" class="largo"
					value="<?php
			if ($_SESSION['credsuperintendenciaa']!=""){
			  	echo $_SESSION[credsuperintendenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"credsuperintendencia");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<!-- Row 11 -->
				<td align="right">Fecha vence Credencial:</td>
				<td align="left"><input name="vencecredsuperintendencia" class="largo" id="vencecredsuperintendencia" value="<?php
			if ($_SESSION['vencecredsuperintendenciaa']!=""){
			  	echo $_SESSION[vencecredsuperintendenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"vencecredsuperintendencia");}  ?>">
				</td>
			</tr>

			<tr>
				<td align="right">Carnet interno:</td>
				<td align="left"><input style="background-color: #DBDBDB"
					class="largo" readonly name="carnetinterno"
					value="<?php
			if ($_SESSION['carnetinternoa']!=""){
			  	echo $_SESSION[carnetinternoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"carnetinterno");}  ?>">
				</td>
				<!-- Col 1 -->
			</tr>
			<tr>
				<td align="right">*Cargo asignado:</td>
				<td align="left"><select name="cargo" class="largo1">
					<option value=""></option>
					<?php echo $cadenacargos;?>
				</select></td>
			</tr>
			
			<?php
			if($_SESSION[sucur]=="%"){
				$muestr2[1]="ciudad";
				$muestr2[saltar]="1";
				$cadena34=selection("sucursales","id","%",$muestr2,@mysql_result($result,$_SESSION['i'],"sucursal"),1,"id","");
				
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

		</table></div>
<div id="Nucleo Familiar" style="display:none;margin-left:305px;margin-top:5px"></div>
<div id="Datos de Psicologia" style="display:none;margin-left:305px"><div style="background:#eee;padding: 10px">Pruebas Psicologicas</div></div>

<div id="controlex">
<table class="control">
	<tr>
		<td colspan="2" class="arriba" align="center">Personal Activo
		</td>
	</tr>
	<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"><input type="text" name="criterio"
			style="width:110px;margin-left:5px" class="busqueda" /></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><input checked name="opt" type="radio" value="1">cualquier <input type="radio" name="opt" value="2">mismo</td>
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
			class="botoreti" value="Retirar" name="ejecut" /></td>
	</tr>
	<tr height="10px">
	<td colspan="2" align="center"><input type="submit"
			class="botonuev" value="Nuevo" name="ejecut"> <input type="submit"
			class="botoing" value="Ingresar"
			<?php if($_SESSION['botonuevo']==0){echo "disabled";}?> name="ejecut"
			onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"></td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Persona $p de $_SESSION[numreg]";} ?>
		</td>
	</tr>
</table>

<div id="divMenu" class="divMenu"></div>
<?php require('saludos.php');?>

</div>
</form>
<?php
print("<script type=\"text/javascript\"> ".$arrayJs."</script> ");

@mysql_free_result($result);
@mysql_free_result($resulta);
@mysql_free_result($resultado);
@mysql_free_result($resultado1);
@mysql_close($link);
echo $escribir;
?>
</body>
</html>
