<?php
session_start();

@require('funciones2.php');

validar("","","", 22);

formularioactual();
	
switch ($_POST[ejecut]):
case "Buscar":

if ($_POST[codcli]!=""){
$_SESSION[clientemod2]=$_POST[codcli];
}

$_SESSION['i']=0;

$datos1[campobusqueda]="codigo";
$datos1[crito]=$_SESSION[clientemod2];
$datos1[opcion]="";
$datos1[claveprinc]="id";

$result2=operaciones("armas","buscar",$datos1);
$result=$result2[datos];
	
break;
case ">>":
if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
$result2=operaciones("armas","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
case "<<":
if($_SESSION[i]>0){$_SESSION[i]--;}
$result2=operaciones("armas","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
case ">||":
$_SESSION[i]=$_SESSION[numreg]-1;
$result2=operaciones("armas","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
case "||<":
$_SESSION['i']=0;
$result2=operaciones("armas","buscar",$_SESSION[datos]);
$result=$result2[datos];
break;
case "Actualizar":
if ($_POST[codcli]!=""){$_SESSION[clientemod2]=$_POST[codcli];}


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
						$destino =  "fotosarmas/".$prefijo."_".$archivo;
						$nombrefoto=$prefijo."_".$archivo;
						copy($_FILES['rutafoto']['tmp_name'],$destino);
						$agregasql="`foto` = '$nombrefoto',";
                                                $_POST['foto']=$nombrefoto;
					}else {
						$mens.= 'verifique el archivo que esta intentando subir\n solo se permiten imagenes jpg y png';
					}
				}
			}
                        
$_POST[codigo]=$_SESSION[clientemod2];
if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
$mens=armarEjecutarSentencia("armas", $_POST, "update", $_SESSION);

$datos1[campobusqueda]="codigo";
$datos1[crito]=$_SESSION[clientemod2];
$datos1[opcion]="";
$datos1[claveprinc]="id";
	
$result2=operaciones("armas","buscar",$datos1);
$result=$result2[datos];
break;
case "Ingresar":
    
if($_POST[serial]!="" and $_SESSION[clientemod2]!="" and $_POST[marca]!=""){

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
						$destino =  "fotosarmas/".$prefijo."_".$archivo;
						$nombrefoto=$prefijo."_".$archivo;
						copy($_FILES['rutafoto']['tmp_name'],$destino);
						$agregasql="`foto` = '$nombrefoto',";
                                                $_POST['foto']=$nombrefoto;
					}else {
						$mens.= 'verifique el archivo que esta intentando subir\n solo se permiten imagenes jpg y png';
					}
				}
			}
                        
    $_POST[codigo]=$_SESSION[clientemod2];
    if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
    $mens=armarEjecutarSentencia("armas", $_POST, "insert", $_SESSION);
}else{
$mens='Atencion todos los campos son requeridos';
}
break;
case "Nuevo":
$_SESSION[i]=$_SESSION[numreg];
$boton=1;
break;
case "Eliminar":
$sql11 ="DELETE FROM `armas` WHERE `armas` . `id` LIKE $_SESSION[clientemod] LIMIT 1";
$resu=mysql_query($sql11);
$_SESSION[i]=$_SESSION[numreg]-1;
break;
endswitch;

$mostra[1]="codigo";
$mostra[2]="nombrecliente";
$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("clientes","codigo","%",$mostra,$_SESSION[clientemod2],2,"codigo",$otras);

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
		window.open("fotomysqlarma.php","Imagen","width=600px,height=600px,menubar=0,scrollbars=1");
		}
//-->
</script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
		<form method="post" action="<?php echo $PHP_SELF?>" onsubmit="return validArmas(boolvalidar);"  enctype="multipart/form-data" name="armas"><br/>
		<table align="center" width="55%" class="tablaprinc"><tr><td>
			<table>
			<tr>
	 		<td align="right" width="45%">id:<input style="background-color:#DBDBDB" readonly class="corto" tabindex="2"
			 value="<?php
			 if ($_SESSION['ida']!=""){
			  	echo $_SESSION[ida];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"id");}
			 		?>" name="id"></td>
     		<td rowspan="8" align="center"><?php

                        $focto=@mysql_result($result,$_SESSION['i'],"foto");

	 		if($focto!=""){
                            $dim=redimensionarFoto(200, 150, "fotosarmas/".$focto);
                            print("<img style=\"width:".$dim['ancho']."px;height:".$dim['alto']."px\" name=\"changing\" onclick=\"ventana()\" src=\"fotosarmas/"."$focto\""."/>") ;
                        }else{
                            echo "<img style=\"width: 150px\" name=\"changing\"	src=\"fotosarmas/guns.png\""."/>" ;}
	 			?></td>
     		</tr>
     		
			<tr>
			<td align="right">*Numero de serial:<input class="largo" tabindex="3" name="serial"
			 value="<?php if ($_SESSION['seriala']!=""){echo $_SESSION[seriala];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"serial");} ?>">
			</td>
     		</tr>
     		
     		<tr>
  			<td align="right">*Marca:<input class="largo" tabindex="4"
			 value="<?php if($_SESSION['marcaa']!=""){echo $_SESSION[marcaa];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"marca");}?>" name="marca">
			</td>
    	 	</tr>
    	 	
 	 		<tr>
 			<td align="right">*Tipo de arma:
			<select name="tipoarma" class="largo1" tabindex="5">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="tipoarma"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sexoa']==1) {echo ('selected');}?>>Revolver</option>
  	 		<option value="2" <?php $z="tipoarma"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sexoa']==2) {echo ('selected');}?>>Pistola</option>
  	 		<option value="3" <?php $z="tipoarma"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['sexoa']==3) {echo ('selected');}?>>Escopeta</option>
  	 		<option value="4" <?php $z="tipoarma"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==4 or $_SESSION['sexoa']==4) {echo ('selected');}?>>Fusil</option>
  	 		<option value="5" <?php $z="tipoarma"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==5 or $_SESSION['sexoa']==5) {echo ('selected');}?>>Ametralladora</option>
  	 		<option value="6" <?php $z="tipoarma"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==6 or $_SESSION['sexoa']==6) {echo ('selected');}?>>Miniuzi</option>
  	 		</select>  
			</td>
  			</tr>
  			<tr>
 			<td align="right">Clasificaci&oacute;n:
			<select name="clasificacion" class="largo1" tabindex="5">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="clasificacion"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['clasificaciona']==1) {echo ('selected');}?>>Letal</option>
  	 		<option value="2" <?php $z="clasificacion"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['clasificaciona']==2) {echo ('selected');}?>>No Letal</option>
  	 		</select>
			</td>
  			</tr>
                        <tr>
				<td align="right">Fotografia:<input class="largo" type="file" size="8px" name="rutafoto"></td>
				<td></td>
			</tr>
   	 		<tr>
   			<td align="right">
      		*Calibre:
			<select name="calibre" class="medio1" tabindex="5">
			<option value="">seleccionar</option>
  	 		<option value="38c" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="38c" or $_SESSION['sexoa']=="38c") {echo ('selected');}?>>38 corto</option>
  	 		<option value="32l" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="32l" or $_SESSION['sexoa']=="32l") {echo ('selected');}?>>32 largo</option>
  	 		<option value="32c" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="32c" or $_SESSION['sexoa']=="32c") {echo ('selected');}?>>32 corto</option>
  	 		<option value="9mm" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="9mm" or $_SESSION['sexoa']=="9mm") {echo ('selected');}?>>9 milimetros</option>
  	 		<option value="16m" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="16m" or $_SESSION['sexoa']=="16m") {echo ('selected');}?>>Escopeta 16</option>
  	 		<option value="12m" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="12m" or $_SESSION['sexoa']=="12m") {echo ('selected');}?>>Escopeta 12</option>
  	 		<option value="38l" <?php $z="calibre"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex=="38l" or $_SESSION['sexoa']=="38l") {echo ('selected');}?>>38 largo</option>
  	 		</select>
			</td>
	     	</tr>
	     	
		  	<tr>
  			<td align="right">
      		*Clase permiso:
			<select name="clasepermiso" class="medio1" tabindex="5">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="clasepermiso"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sexoa']==1) {echo ('selected');}?>>Tenencia</option>
  	 		<option value="2" <?php $z="clasepermiso"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sexoa']==2) {echo ('selected');}?>>Porte</option>
  	 		</select>  
			</td>
     		</tr>
     		
     		<tr>
  			<td align="right">
      		Salvoconducto No:<input class="medio" tabindex="6"
			 value="<?php
			 if ($_SESSION['salvoconductoa']!=""){
			  	echo $_SESSION[salvoconductoa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"salvoconducto");}
			 		?>" name="salvoconducto"></td>
     		<td align="left">
			</td>
     		</tr>
     		
     		<tr>
  			<td align="right">
      		Vence permiso:<input class="medio" tabindex="6"
			 value="<?php if($_SESSION['vencesalvoconductoa']!=""){echo $_SESSION[vencesalvoconductoa];}elseif (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"vencesalvoconducto");}?>" name="vencesalvoconducto">
			</td>
     		</tr><tr>
                    <td align="right">Observacion de Arma<br><textarea name="observacionarma" id="sqlquery" cols="26" rows="14" dir="ltr" tabindex="12"><?php if ($_SESSION['observacionarmaa']!=""){echo $_SESSION[observacionarmaa];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionarma");}?></textarea></td>
                </tr>
     		 			</table>
 </td></tr></table>
     		
     		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Armamento por Cliente
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td align="center">
 			<input type="submit" class="botobusca" value="Buscar" name="ejecut" onmousedown="boolvalidar=false;" onkeydown="boolvalidar=false;">
 			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="codcli" class="largo2">
			<option value=""></option>
 	 		<?php echo $cadena;?>
 	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			<input type="submit" class="botoelimina" value="Eliminar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Dotaci&oacute;n $p de $_SESSION[numreg]";} ?>
			</td></tr>
			</table>
     			<div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
</div></form>
</body>
</html>
  
