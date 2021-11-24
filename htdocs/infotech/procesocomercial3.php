<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');
@require('clases/claseNotificacion.php');

validar("","","", 30);

formularioactual();

$fecha=getdate(time());
$ano1=$fecha[year]-2;
$ano2=$fecha[year]-1;
$ano3=$fecha[year];
$ano4=$fecha[year]+1;
$ano5=$fecha[year]+2;
$ano6=$fecha[year]+3;

$vect1=explode("-",$_POST['ejecut']);

if($vect1[0]=="elimina"){
	switch($vect1[1]){
		case "serv";
		$tabla="servicios";
		break;
		case "arm";
		$tabla="armasnecesidades";
		break;
		case "int";
		$tabla="dotanecesidad";
		break;
                case "seg";
		$tabla="seguimiento";
		break;
	}
	$sql="DELETE FROM $tabla WHERE `$tabla`.`id` = $vect1[2]";
        //echo $sql;
	@mysql_query($sql) or $mens.=@mysql_error();
	
	$result2=operaciones("necesidadescliente","buscar",$_SESSION[datos]);
	$result=$result2[datos];

	$lim=@mysql_num_rows($result);
	$_SESSION[elim1]="";
	$_SESSION[clientemod]=@mysql_result($result,$_SESSION[i],"numerooferta");
	$_SESSION[procv]=0;
	
}

if($_POST[ejecut]=="Buscar" || $_GET[ejecut]=="Buscar"){

    //die("entra a buscar paciente");
     if($_POST[ejecut]=="Buscar"){
		$datos1[campobusqueda]=$_POST[campobusqueda];
                $datos1[crito]=$_POST[criterio];
                $datos1[opcion]=$_POST[opt];
                }else{//busquieda con get
                $datos1[campobusqueda]=$_GET[campobusqueda];
		$datos1[crito]=$_GET[criterio];
		$datos1[opcion]=$_GET[opt];
                }

	$datos1[claveprinc]="numerooferta";
	$datos1[otraconsulta]="";
		
	$result2=operaciones("necesidadescliente","buscar",$datos1);
	$result=$result2[datos];

	$_SESSION[i]=0;
	$lim=@mysql_num_rows($result);
	$_SESSION[elim1]="";
	$_SESSION[clientemod]=@mysql_result($result,$_SESSION[i],"numerooferta");
	$_SESSION[procv]=0;
	
}else if($_POST[ejecut]=="||<"){

	$result2=operaciones("necesidadescliente","buscar",$_SESSION[datos]);
	$result=$result2[datos];
		
	$_SESSION[i]=0;
	$_SESSION[elim1]="";
	$_SESSION[clientemod]=@mysql_result($result,$_SESSION[i],"numerooferta");
	$_SESSION[procv]=0;
}else if($_POST[ejecut]==">||"){

	$result2=operaciones("necesidadescliente","buscar",$_SESSION[datos]);
	$result=$result2[datos];

	$_SESSION[i]=$_SESSION[numreg]-1;
	$_SESSION[elim1]="";
	$_SESSION[clientemod]=@mysql_result($result,$_SESSION[i],"numerooferta");
	$_SESSION[procv]=0;
}else if($_POST[ejecut]==">>"){

	$result2=operaciones("necesidadescliente","buscar",$_SESSION[datos]);
	$result=$result2[datos];

	if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}

	$_SESSION[elim1]="";
	$_SESSION[clientemod]=@mysql_result($result,$_SESSION[i],"numerooferta");
	$_SESSION[procv]=0;

}else if($_POST[ejecut]=="<<"){

	$result2=operaciones("necesidadescliente","buscar",$_SESSION[datos]);
	$result=$result2[datos];

	if($_SESSION[i]>0){$_SESSION[i]--;}
	$_SESSION[elim1]="";
	$_SESSION[clientemod]=@mysql_result($result,$_SESSION[i],"numerooferta");
	$_SESSION[procv]=0;

}else if($_POST[ejecut]=="Actualizar"){
	if($_POST[empresa]!="" and $_POST[contacto]!="" and $_POST[direccion]!="" and $_POST[telefono]!="" and $_POST[telefono]!="0" and $_POST[fechaentrega]!=""){

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $mens.=armarEjecutarSentencia("necesidadescliente", $_POST, "update", $_SESSION);

        }else{
		$mens.="Atencion debe ingresar todos los campos \nmarcados con asterisco";
		$_SESSION[elim1]="";
	}

	$_SESSION[procv]=0;

}else if($_POST[ejecut]=="Eliminar"){
	if($_SESSION[elim1]==""){
		$mens.="Atencion si desea eliminar el registro No ". $_SESSION[clientemod]."elimine primero todos los servicios, armas e intendencia ingresada y luego presione nuevamente eliminar en el formulario";
		$_SESSION[elim1]=1;
		$boton2=1;
	}else{
		$sql2="DELETE FROM necesidadescliente WHERE necesidadescliente.numerooferta='$_SESSION[clientemod]'";
		@mysql_query($sql2) or $error=@mysql_error();
		$sql22="INSERT INTO `registrodemodificaciones` (`id`, `fecha`, `cambio`, `hechopor`, `cedulamodificada`, `tablamod`, `sucursal`) VALUES (NULL, NOW(), 'eliminaroferta', '$_SESSION[persona]', '$_SESSION[clientemod]', '4', '$_SESSION[sucur]')";
		@mysql_query($sql22) or $error=@mysql_error();

                if($error!=""){
                $mens="error eliminando el registro";
                }

		$mens.="registro eliminado con exito";
		$_SESSION[elim1]="";
		$_SESSION[clientemod]="";
	}
	$_SESSION[procv]=0;
}else if($_POST[ejecut]=="Nuevo"){
	$_SESSION[i]=$_SESSION[numreg];
	$boton=1;
	$result=null;
	$_SESSION[elim1]="";
	$_SESSION[procv]=0;

}else if($_POST[ejecut]=="ingresar"){
	if($_POST[empresa]!="" and $_POST[contacto]!="" and $_POST[direccion]!="" and $_POST[telefono]!="" and $_POST[telefono]!="0" and $_POST[fechaentrega]!=""){

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $_POST[fechasolicitud]="NOW()";
                $mens.=armarEjecutarSentencia("necesidadescliente", $_POST, "insert", $_SESSION);

	}else{
		$mens.="Atencion debe ingresar todos los campos marcados \ncon asterisco *";
	}
        
	$_SESSION[procv]=0;
}

$r=@require('version.php');
caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9AFF00";

if(@mysql_result($result,$_SESSION[i],"numerooferta")!=""){
	$boton2=1;
}
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
<script type="text/javascript" src="ext/examples/form/comercial.js"></script>
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ventana1(){
		var ventana = window.open("agregaserv.php","Infotech","menubar=0,scrollbars=1,maximized=1,width=500px,height=400px");
		}
function ventana2(){
		var ventana = window.open("agregarm.php","Infotech","menubar=0,scrollbars=1,maximized=1,width=500px,height=400px");
		}
function ventana3(){
		var ventana = window.open("agregaint.php","Infotech","menubar=0,scrollbars=1,maximized=1,width=500px,height=400px");
		}
function ventana4(){
		var ventana = window.open("agregaseg.php","Infotech","menubar=0,scrollbars=1,maximized=1,width=500px,height=400px");
		}				
</script>
</head>
<body <?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
<br/>
<form method="post" action="procesocomercial3.php" onsubmit="return validaofertas(boolvalidar);" name="ofertas">
    <table class="tablaprinc"><tr><td>
		<table>
			<tr>
				<td></td>
				<td align="right" width="250px">Numero de oferta:</td>
				<td align="left" width="230px"><input class="corto" disabled
					size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"numerooferta");}?>"
					name="numerooferta"></td>
			</tr>

			<tr>
				<td align="center">
				</td>
				<td align="right">*Nit:</td>
				<td align="left"><input class="extralargo" size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"nit");}?>"
					name="nit"></td>
			</tr>
			
			<tr>
				<td align="center">
				<a onclick="ventana1();"><img src="imagenesnuevas/agregas1.png"></a>
				</td>
				
				<td align="right">*Empresa:</td>
				<td align="left"><input class="extralargo" size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"empresa");}?>"
					name="empresa"></td>
			</tr>
			
			<tr>
				<td align="center">
				<a onclick="ventana2();"><img src="imagenesnuevas/agregar1.png"></a>
				</td>
				<td align="right">Actividad Económica:</td>
				<td align="left"><input class="extralargo" size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"actividadeconomica");}?>"
					name="actividadeconomica"></td>
			</tr>
			
			<tr>
				<td align="center">
				<a onclick="ventana3();"><img src="imagenesnuevas/agregai1.png"></a>
				</td>
				<td align="right">*Contacto:</td>
				<td align="left"><input class="extralargo" size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"contacto");}?>"
					name="contacto"></td>
			</tr>
			
			<tr>
				<td align="center">
				<a onclick="ventana4();"><img src="imagenesnuevas/botrese1.png"></a>
				</td>
				<td align="right">Cargo:</td>
				<td align="left"><input class="extralargo" size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"cargo");}?>"
					name="cargo"></td>
			</tr>

			<tr><td></td>
				<td align="right">*Direccion de Servicio:</td>
				<td align="left"><input class="extralargo"
					value="<?php if (!$result){echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"direccion");}?>"
					name="direccion"></td>
			</tr>

			<tr><td></td>
				<td align="right">Direccion de Correspondencia:</td>
				<td align="left"><input class="extralargo"
					value="<?php if (!$result){echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"direccion2");}?>"
					name="direccion2"></td>
			</tr>
			
			<tr><td></td>
				<td align="right">Estrato:</td>
				<td align="left"><input class="extralargo" size="31"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"estrato");}?>"
					name="estrato"></td>
			</tr>
			
			<tr>
			<td align="center"></td>
				
				<td align="right">Email:</td>
				<td align="left"><input class="extralargo"
					value="<?php if (!$result){echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"email");}?>"
					name="email"></td>
			</tr>

			<tr>
			<td align="center"></td>
				<td align="right">*Telefono:</td>
				<td align="left"><input class="medio" name="telefono"
					value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono");} ?>">
				</td>
			</tr>

			<tr>
			<td align="center"></td>
				<td align="right">Fax:</td>
				<td align="left"><input class="medio" name="fax"
					value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"fax");} ?>">
				</td>
			</tr>

			<tr>
				<td></td>
				<td align="right">*Tipo de contacto:</td>
				<td align="left"><select name="tipocontacto" class="medio1">
				<option></option>
					<option value="1"
					<?php $z="tipocontacto"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['svyspa']==1) {echo ('selected=""');}?>>Tel&eacute;fonico</option>
					<option value="2"
					<?php $z="tipocontacto"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['svyspa']==2) {echo ('selected=""');}?>>Referido</option>
					<option value="3"
					<?php $z="tipocontacto"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['svyspa']==3) {echo ('selected=""');}?>>Comercial</option>
				</select></td>
			</tr>

			<tr>
				<td></td>
				<td align="right">Fecha de Solicitud:</td>
				<td align="left"><input class="medio" name="fechasolicitud" id="fechasolicitud" value="<?php if (!$result){echo "";}else{
                                                        $fechasol=explode(" ", @mysql_result($result,$_SESSION['i'],"fechasolicitud"));
                                                        echo $fechasol[0];
                                                        }?>">
				</td>
			</tr>

			<tr>
				<td></td>
				<td align="right">*Fecha de entrega:</td>
				<td align="left"><input class="medio" name="fechaentrega" id="fechaentrega"
					value="<?php if (!$result){echo "";}else{
                                            $fechaent=explode(" ", @mysql_result($result,$_SESSION['i'],"fechaentrega"));
                                            echo $fechaent[0];
                                            }?>">
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td align="right">Verificación Lista Clinton:</td>
				<td align="left">
				<select name="verificacionclinton" class="medio1">
					<option></option>
					<option value="1"
					<?php $z="verificacionclinton"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1) {echo ('selected=""');}?>>Si</option>
					<option value="2"
					<?php $z="verificacionclinton"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2) {echo ('selected=""');}?>>No</option>
				</select>
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td align="right">Nombre de quien verifica:</td>
				<td align="left">
				<input name="nombreverificaclinton" class="largo" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombreverificaclinton");}?>">
				</td>
			</tr>
			

			<tr>
				<td></td>
				<td align="right">Fecha de Verificaci&oacute;n:</td>
				<td align="left">
				<input name="fechaverifica" id="fechaverifica" class="medio" value="<?php if (!$result){echo "";}else{
                                                        $fechavc=explode(" ", @mysql_result($result,$_SESSION['i'],"fechaverifica"));
                                                        echo $fechavc[0];
                                                        }?>">
				</td>
			</tr>

			<tr>
				<td></td>
				<td align="right">Se aprueba realizar cotización:</td>
				<td align="left">
				<select name="apruebacotizacion" class="medio1">
					<option></option>
					<option value="1" <?php $z="apruebacotizacion"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1) {echo ('selected');} ?>>Si</option>
					<option value="2" <?php $z="apruebacotizacion"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2) {echo ('selected');} ?>>No</option>
				</select>
				</td>
			</tr>
			

			<tr>
				<td></td>
				<td align="right">como se enteró de nuestra empresa:</td>
				<td align="left">
				<textarea rows="5" cols="30" name="comoenteroempresa"><?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"comoenteroempresa");}?></textarea>
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td align="right">Requerimientos Especiales:</td>
				<td align="left">
				<textarea rows="5" cols="30" name="otrosreqv"><?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"otrosreqv");}?></textarea>
				</td>
			</tr>
			
			<?php
			if($_SESSION[sucur]=="%"){
				$muestr2[1]="ciudad";
				$muestr2[saltar]="1";
				$cadena34=selection("sucursales","id","%",$muestr2,@mysql_result($result,$_SESSION['i'],sucursal),1,"id","");
				echo '
 	 		<tr>
 	 		<td></td>
  			<td align="right">*Sucursal: </td>
     		<td align="left">
	 		<select name="sucurs" class="largo1">'.$cadena34.'
	 		
	 		</select>
	 		</td><!-- Col 1 -->
     		</tr>
			';	

			}
			?>
		</table>
		</td></tr></table>

			<?php
			
			if($_POST['ejecut']=="Buscar" || $_POST['ejecut']=="Buscar" || $_POST['ejecut']==">||" || $_POST['ejecut']=="||<" || $_POST['ejecut']==">>" || $_POST['ejecut']=="<<" || $_POST['ejecut']=="Actualizar" || $vect1[0]=="elimina" || $_GET['ejecut']=="Buscar"){
			
                        if($_GET['ejecut']=="Buscar"){$idoferta=$_GET['criterio'];}else{$idoferta=$_SESSION[clientemod];}

			$sql="SELECT * FROM `servicios` WHERE `servicios`.`idoferta`='$idoferta'";
			$resultserv=@mysql_query($sql) or $mens.=@mysql_error();
			$numfilas=@mysql_num_rows($resultserv);
			if($numfilas>0){
				echo "<table class=\"tablaprinc\"><th><b>Servicios</b></th>";
				for($i=0;$i<$numfilas;$i++){
					echo "<tr><td>Tipo Servicio</td><td>".selectnombreletras(@mysql_result($resultserv,$i,modalidadservicio),"modalidadservicio")." Cantidad (".@mysql_result($resultserv,$i,cantidadservicios).")</td><td>Personal Diurno (".@mysql_result($resultserv,$i,personal).")</td><td>Personal Nocturno (".@mysql_result($resultserv,$i,personalnocturno).")</td><td>Dias</td><td>".selectnombreletras(@mysql_result($resultserv,$i,diastrabajo),"diastrabajo")."</td><td>Valor del Servicio:</td><td align=\"right\">$".number_format(@mysql_result($resultserv,$i,valorservicio),0)."</td><td><input name=\"ejecut\"   type=\"submit\" class=\"botoelimina\" value=\"elimina-serv-".@mysql_result($resultserv,$i,id)."\"></td></tr>";
				}
				echo "<hr/></table>";
			}

                        $sql="SELECT * FROM `armasnecesidades` WHERE `armasnecesidades`.`idnecesidad`='$idoferta'";
			$resultarm=@mysql_query($sql) or $mens.=@mysql_error();
			$numfilas=@mysql_num_rows($resultarm);
			if($numfilas>0){
				echo "<table class=\"tablaprinc\"><th><b>Armas</b></th>";
				for($i=0;$i<$numfilas;$i++){
					echo "<tr><td>Tipo de Arma</td><td>".selectnombreletras(@mysql_result($resultarm,$i,tipoarma),"tipoarma")."</td><td>Marca</td><td>".@mysql_result($resultarm,$i,marca)."</td><td>Calibre</td><td>".selectnombreletras(@mysql_result($resultarm,$i,calibre),"calibre")."</td><td>Clase Permiso</td><td>".selectnombreletras(@mysql_result($resultarm,$i,clasepermiso),"clasepermiso")."</td><td><input name=\"ejecut\" type=\"submit\" class=\"botoelimina\" value=\"elimina-arm-".@mysql_result($resultarm,$i,id)."\"></td></tr>";
				}
				echo "<hr/></table>";
			}

			$sql="SELECT * FROM `dotanecesidad`, `productos` WHERE `dotanecesidad`.`idoferta`='$idoferta' AND `dotanecesidad`.`idprod`=`productos`.`id`";
			$resultdota=@mysql_query($sql) or $mens.=@mysql_error();
			$numfilas=@mysql_num_rows($resultdota);
			if($numfilas>0){
				echo "<table class=\"tablaprinc\"><th><b>Intendencia</b></th>";
				for($i=0;$i<$numfilas;$i++){
					echo "<tr><td>Cantidad</td><td>".@mysql_result($resultdota,$i,cantidad)."</td><td>Elemento</td><td>".@mysql_result($resultdota,$i,nombreprod)."</td><td><input name=\"ejecut\"  type=\"submit\" class=\"botoelimina\" value=\"elimina-int-".@mysql_result($resultdota,$i,id)."\"></td></tr>";
				}
				echo "<hr/></table>";
			}
			
			
			$sql="SELECT * FROM `seguimiento`, `necesidadescliente` WHERE `necesidadescliente`.`numerooferta`='$idoferta' AND `seguimiento`.`idoferta`=`necesidadescliente`.`numerooferta`";
			$resultseg=@mysql_query($sql) or $mens.=@mysql_error();
			$numfilas=@mysql_num_rows($resultseg);
			if($numfilas>0){
				echo "<table class=\"tablaprinc\"><th><b>Seguimiento</b></th>";
				for($i=0;$i<$numfilas;$i++){
					echo "<tr><td>Fecha</td><td>".@mysql_result($resultseg,$i,"fecha")."</td><td>Comentarios</td><td>".@mysql_result($resultseg,$i,"comentarios")."</td><td><input name=\"ejecut\" type=\"submit\" class=\"botoelimina\" value=\"elimina-seg-".@mysql_result($resultseg,$i,"id")."\"></td></tr>";
				}
				echo "<hr/></table>";
			}
			}
			?>


<div id="controlex">
<table class="control">
	<tr>
		<td colspan="2" class="arriba">Ofertas Comerciales</td>
	</tr>
	<tr height="10px" align="center">
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
			<option value="empresa">Razon Social</option>
			<option value="contacto">Contacto</option>
			<option value="telefono">Telefono</option>
			<option value="numerooferta">Numero de oferta</option>
			<option value="fechasolicitud">Fecha de Solicitud</option>
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
			class="botoelimina" value="Eliminar" name="ejecut" /></td>
	</tr>

	<tr height="10px">
		<td colspan="2" align="center"><input type="submit"
			class="botonuev" value="Nuevo" name="ejecut"> <input type="submit"
			class="botoing" value="ingresar"
			<?php if($boton==0){echo "disabled";}?> name="ejecut"
			onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"></td>
	</tr>
	<tr height="10px" valign="top">
		<td valign="middle" colspan="2" align="center"><?php
		if(@mysql_result($result,$_SESSION['i'],"cond")==1 and @mysql_result($result,$_SESSION['i'],cond)!="" and $_POST[ejecut]!="ingresar" and $_POST[ejecut]!="Nuevo" and $_POST[ejecut]!="Actualizar" and $_POST[ejecut]!="Eliminar"){
			print('<a href="condiciones3.php?elaborarcond=true"><input type="button" class="botcoin" value="Condiciones" name="botc"></a>');
		}
		?></td>
	</tr>
	<tr height="30px">
		<td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Oferta $p de $_SESSION[numreg]";} ?>
		</td>
	</tr>
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


