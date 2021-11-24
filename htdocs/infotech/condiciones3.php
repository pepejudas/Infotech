<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');
@require('clases/claseNotificacion.php');

validar("","","", 32);
		
	$abuscar=$_POST[campobusqueda];
	if($abuscar=="nombrecliente" OR $abuscar=="telefono"){
	$campobusqueda="clientes.$abuscar";}else{$campobusqueda="condicionescliente.$abuscar";
	}
	
//formularioactual();
	
switch($_POST[ejecut]){
case "Buscar":
$_SESSION[datos]="";
$_SESSION[tablaC]="condicionescliente";
if($_POST[opt]==1){
$cadena="%".$_POST[criterio]."%";	
}else{
$cadena=$_POST[criterio];	
}

$sql="SELECT * FROM $_SESSION[tablaC], clientes WHERE $campobusqueda LIKE '$cadena' and $_SESSION[tablaC].codigo like clientes.codigo and $_SESSION[tablaC].sucursal like '$_SESSION[sucur]' ORDER BY $_SESSION[tablaC].numerooferta DESC" ;
$_SESSION[sent2]=$sql;
$result=@mysql_query($sql);
$lim=@mysql_num_rows($result);
$_SESSION[numreg]=@mysql_num_rows($result);
$_SESSION[i]=0;
$_SESSION[procv]="";
$vectorfechas=explode("-", @mysql_result($result,$_SESSION[i], "fechainiciocontrato"));
$ano=$vectorfechas[0];
$mes=$vectorfechas[1];
$vectorhoras=explode(" ",$vectorfechas[2]);
$vectorhoras2=explode(":", $vectorhoras[1]);
$dia=$vectorhoras[0];
$hora=$vectorhoras2[0];
$min=$vectorhoras2[1];
$vectorfechas2=explode("-", @mysql_result($result,$_SESSION[i], "fechafincontrato"));
$anoxx=$vectorfechas2[0];
$mesxx=$vectorfechas2[1];
$diaxx=$vectorfechas2[2];
$_SESSION[regmod3]=@mysql_result($result,$_SESSION[i],"numerooferta");
$_SESSION[elim2]=0;
 break;
 case "Eliminar":
if($_SESSION[elim2]==""){
$mens="si realmente desea eliminar el registro No $_SESSION[regmod3], presione nuevamente eliminar";
$_SESSION[elim2]=1;
$boton2=1;
}else{
$sql2="DELETE FROM condicionescliente WHERE condicionescliente.numerooferta=$_SESSION[regmod3]";
$sql5="UPDATE necesidadescliente SET cond=0 WHERE necesidadescliente.numerooferta=$_SESSION[regmod3]";
@mysql_query($sql2) or $error=@mysql_error();
@mysql_query($sql5) or $error=@mysql_error();
if($error!=""){
$mens="error eliminando el registro";
}else{
$mens="registro eliminado pero el registro del cliente no ha sido eliminado";
}
$_SESSION[elim2]="";
$_SESSION[regmod3]="";	
}
break;	
case "||<":
$result=@mysql_query($_SESSION[sent2]);
$_SESSION[i]=0;
 $_SESSION[procv]="";
 $vectorfechas=explode("-", @mysql_result($result,$_SESSION[i], "fechainiciocontrato"));
$ano=$vectorfechas[0];
$mes=$vectorfechas[1];
$vectorhoras=explode(" ",$vectorfechas[2]);
$vectorhoras2=explode(":", $vectorhoras[1]);
$dia=$vectorhoras[0];
$hora=$vectorhoras2[0];
$min=$vectorhoras2[1];
$vectorfechas2=explode("-", @mysql_result($result,$_SESSION[i], "fechafincontrato"));
$anoxx=$vectorfechas2[0];
$mesxx=$vectorfechas2[1];
$diaxx=$vectorfechas2[2];
$_SESSION[regmod3]=@mysql_result($result,$_SESSION[i],"numerooferta");
$_SESSION[elim2]=0;
break;	
case ">||":
$result=@mysql_query($_SESSION[sent2]);
$lim=@mysql_num_rows($result);
$_SESSION[i]=$lim-1;
 $_SESSION[procv]="";
 $vectorfechas=explode("-", @mysql_result($result,$_SESSION[i], "fechainiciocontrato"));
$ano=$vectorfechas[0];
$mes=$vectorfechas[1];
$vectorhoras=explode(" ",$vectorfechas[2]);
$vectorhoras2=explode(":", $vectorhoras[1]);
$dia=$vectorhoras[0];
$hora=$vectorhoras2[0];
$min=$vectorhoras2[1];
$vectorfechas2=explode("-", @mysql_result($result,$_SESSION[i], "fechafincontrato"));
$anoxx=$vectorfechas2[0];
$mesxx=$vectorfechas2[1];
$diaxx=$vectorfechas2[2];
$_SESSION[regmod3]=@mysql_result($result,$_SESSION[i],"numerooferta");
$_SESSION[elim2]=0;
break;
case ">>":
$result=@mysql_query($_SESSION[sent2]);
if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
 $_SESSION[procv]="";
 $vectorfechas=explode("-", @mysql_result($result,$_SESSION[i], "fechainiciocontrato"));
$ano=$vectorfechas[0];
$mes=$vectorfechas[1];
$vectorhoras=explode(" ",$vectorfechas[2]);
$vectorhoras2=explode(":", $vectorhoras[1]);
$dia=$vectorhoras[0];
$hora=$vectorhoras2[0];
$min=$vectorhoras2[1];
$vectorfechas2=explode("-", @mysql_result($result,$_SESSION[i], "fechafincontrato"));
$anoxx=$vectorfechas2[0];
$mesxx=$vectorfechas2[1];
$diaxx=$vectorfechas2[2];
$_SESSION[regmod3]=@mysql_result($result,$_SESSION[i],"numerooferta");
$_SESSION[elim2]=0;
break;
case "<<":
$result=@mysql_query($_SESSION[sent2]);
if($_SESSION[i]>0){$_SESSION[i]--;}
 $_SESSION[procv]="";
 $vectorfechas=explode("-", @mysql_result($result,$_SESSION[i], "fechainiciocontrato"));
$ano=$vectorfechas[0];
$mes=$vectorfechas[1];
$vectorhoras=explode(" ",$vectorfechas[2]);
$vectorhoras2=explode(":", $vectorhoras[1]);
$dia=$vectorhoras[0];
$hora=$vectorhoras2[0];
$min=$vectorhoras2[1];
$vectorfechas2=explode("-", @mysql_result($result,$_SESSION[i], "fechafincontrato"));
$anoxx=$vectorfechas2[0];
$mesxx=$vectorfechas2[1];
$diaxx=$vectorfechas2[2];
$_SESSION[regmod3]=@mysql_result($result,$_SESSION[i],"numerooferta");
$_SESSION[elim2]=0;
break;
case "Ingresar":

	if($_POST[nombrecliente]!="" and $_POST[contacto]!="" and $_POST[direccion]!="" and $_POST[telefono]!="" and $_POST[telefono]!="0" and $_POST[codigo]!="" and $_POST[nit]!=""){

                $_POST[fechainiciocontrato]=$_POST[anoi]."-".$_POST[mesi]."-".$_POST[diai]." ".$_POST[horai].":".$_POST[mini];
                if($_POST[anov]!="" and $_POST[mesv] and $_POST[diav]){
                $_POST[fechafincontrato]=$_POST[anov]."-".$_POST[mesv]."-".$_POST[diav];
                }

                //busqueda de registros de oferta comercial y calculo de vigilantes diurnos y nocturnos del cliente
                $sql0="SELECT cantidadservicios, personal, personalnocturno FROM servicios WHERE idoferta='$_POST[numerooferta]'";
                $resulnv=@mysql_query($sql0);
                $numregnv=@mysql_num_rows($resulnv);
                $numvigd=0;
                $numvign=0;
                    
                    for($k=0;$k<$numregnv;$k++){
                    $numvigd+=@mysql_result($resulnv, $k, "personal")*@mysql_result($resulnv, $k, "cantidadservicios");
                    $numvign+=@mysql_result($resulnv, $k, "personalnocturno")*@mysql_result($resulnv, $k, "cantidadservicios");
                    }

                $_POST[personald]=$numvigd;
                $_POST[personaln]=$numvign;

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $_POST[fechasolicitud]="NOW()";
                $_POST[fecainiciocontrato]="NOW()";
                    if(!hayDuplicado("clientes", "codigo", $_POST['codigo'])){
                        $mens.=armarEjecutarSentencia("clientes", $_POST, "insert", $_SESSION);
                        $mens.=armarEjecutarSentencia("condicionescliente", $_POST, "insert", $_SESSION);
                    }else{
                        $mens.="Existe un cliente en el sistema con ese codigo operativo";
                    }
                if($mens==""){//si no hay errores anteriormente
                $_POST[cond]=2;
                $mens.=armarEjecutarSentencia("necesidadescliente", $_POST, "update", $_SESSION);
                }

                $notifica=new Notificacion();
                $notifica->crearNotificaciones($_SESSION['idusuario'], "todos", "Cliente Nuevo $z", "<a href=\"procesocomercial3.php?ejecut=Buscar&criterio=$_POST[numerooferta]&campobusqueda=numerooferta&opt=2\">Oferta</a> <a href=\"clientes3.php?ejecut=Buscar&criterio=$_POST[codigo]&campobusqueda=codigo&opt=2\">Cliente</a>");
		$_SESSION[elim2]=0;

}else{
$mens.="Atencion debe ingresar todos los campos requeridos \nmarcados con asterisco *";
$_SESSION[tablaC]="";
$tabla="necesidadescliente";
$result2=operaciones($tabla,"buscar",$_SESSION[datos]);
$result=$result2[datos];
$boton=1;	
}

break;
}

if($_GET[elaborarcond]){
$_SESSION[tablaC]="";
$tabla="necesidadescliente";
$result2=operaciones($tabla,"buscar",$_SESSION[datos]);
$result=$result2[datos];
$boton=1;
$mens="Diligencie la informacion que falta o modifique la existente y luego presione ingresar";
}

$fecha=getdate(time());
$ano1=$fecha[year]-2;
$ano2=$fecha[year]-1;
$ano3=$fecha[year];
$ano4=$fecha[year]+1;
$ano5=$fecha[year]+2;
$ano6=$fecha[year]+3;

$sqlpar="SELECT * FROM parametros";
$conspar=@mysql_query($sqlpar);
$iva=@mysql_result($conspar,0,"iva");
$aiu=@mysql_result($conspar,0,"aiu");
//$retencion=@mysql_result($conspar,0,"retencion");

$muestr[1]="nombres";
$muestr[2]="apellidos";
$otrasent="AND socios.habilitadoinfotech = 1";
$cadena=selection("socios","cedula","%",$muestr,@mysql_result($result,$_SESSION['i'],"duenopuesto"),1,"cedula",$otrasent);

		$r=@require('version.php');
		caracteresiso();
$colcuerpo="#FAFAFA";
$coltabla="#9AFFaa";
?>
<link	rel="stylesheet" href="estilo2.css" type="text/css">
<link	rel="stylesheet" href="botones.css" type="text/css">

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
<body <?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>

		<form method="post" action="condiciones3.php" onsubmit="return validacondiciones(boolvalidar);" name="condiciones">
		<table class="tablaprinc"><tr><td>
			<table>
	  		<tr>
  			<td align="right">
  			Numero de oferta:
  			</td>
		    <td align="left">
		  	<input class="corto" readonly value="<?php if (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"numerooferta");}?>" name="numerooferta">
		  	</td>
  			</tr>
	  		  	
	  		<tr>
	 		<td align="right" width="25%">
	 		*Nombre del cliente:</td>
     		<td align="left" width="30%">
     		<input class="extralargo"
			  value="<?php if (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"empresa");echo @mysql_result($result,$_SESSION['i'],"nombrecliente");}?>" name="nombrecliente">
			</td>
		  	</tr>
		  	
  			<tr>
  			<td align="right">*Contacto:  
      		</td>
     		<td align="left"><input class="extralargo"
			  value="<?php if (!$result){ echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"contacto");}?>" name="contacto">
			</td>
     		</tr>

     		<tr>
  			<td align="right">*Direccion de Servicio:</td>
     		<td align="left">
	 		<input class="extralargo"
			 value="<?php if (!$result){echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"direccion");}?>" name="direccion">
      		</td>
    	 	</tr>
    	 	
     		<tr>
  			<td align="right">Direccion de correspondencia:</td>
     		<td align="left">
	 		<input class="extralargo"
			 value="<?php if (!$result){echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"direccion2");}?>" name="direccion2">
      		</td>
    	 	</tr>

			<tr>
  			<td align="right">Email:</td>
     		<td align="left">
	 		<input class="extralargo"
			 value="<?php if (!$result){echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"email");}?>" name="email">
      		</td>
    	 	</tr>
    	 	
	 		<tr>
  			<td align="right">*Telefono:</td>
     		<td align="left">
	 		<input class="medio" name="telefono"
			 value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono");} ?>">
      		</td>
  			</tr>

  	 		<tr>
  			<td align="right">Fax:</td>
     		<td align="left">
	 		<input class="medio" name="fax"
			 value="<?php if (!$result){echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"fax");} ?>">
      		</td>
  			</tr>

		  	<tr>
  			<td align="right">
  			*Codigo asignado al cliente:
  			</td>
		    <td align="left">
		    <input class="largo" name="codigo" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"codigo");}  ?>">
  	 		</td>
  			</tr>

			<tr>	
  			<td align="right">
  			Lugar prestaci&oacute;n de Servicio:
  			</td>
		    <td align="left">
		    <input class="largo" name="lugar" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"lugar");}  ?>">
  	 		</td>
  			</tr>
  			
			<tr>	
  			<td align="right">
  			Periodo Facturaci&oacute;n:
  			</td>
		    <td align="left">
		    <input class="largo" name="periodofacturacion" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"periodofacturacion");}  ?>">
  	 		</td>
  			</tr>

		  	<tr>
  			<td align="right">
  			Socio administrador:
  			</td>
		    <td align="left">
		    <select tabindex="1" class="largo1" name="duenopuesto">
  	 		<?php echo $cadena;?>
			</select>
  	 		</td>
  			</tr>

		  	<tr>
  			<td align="right">
  			SVySP:
  			</td>
		    <td align="left">
		   <select name="svysp" class="corto1" tabindex="10">
			<option value="2" <?php $z="svysp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['svyspa']==2) {echo ('selected=""');}?>>No</option>
			<option value="1" <?php $z="svysp"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['svyspa']==1) {echo ('selected=""');}?>>Si</option>
			</select>
  	 		</td>
  			</tr>

  			<tr>
  			<td align="right">*Nit:</td>
			<td align="left">
			<input class="largo" name="nit" value="<?php if (!$result){echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nit");}  ?>">
      		</td>
     		</tr> 

  			<tr>
  			<td align="right">*Fecha de instalacion:</td>
			<td align="left">
			<select name="anoi" style="WIDTH: 60px">
  	 		<option value="<?php echo $ano3;?>" <?php if($ano==$ano3){echo 'selected=""';}?>><?php echo $ano3;?></option>
  	 		<option value="<?php echo $ano4;?>" <?php if($ano==$ano4){echo 'selected=""';}?>><?php echo $ano4;?></option>
  	 		</select><select name="mesi" style="WIDTH: 110px">
  	 		<option value="1" <?php if($mes==1){echo 'selected';}?>>Enero</option>
  	 		<option value="2" <?php if($mes==2){echo 'selected';}?>>Febrero</option>
  	 		<option value="3" <?php if($mes==3){echo 'selected';}?>>Marzo</option>
  	 		<option value="4" <?php if($mes==4){echo 'selected';}?>>Abril</option>
  	 		<option value="5" <?php if($mes==5){echo 'selected';}?>>Mayo</option>
  	 		<option value="6" <?php if($mes==6){echo 'selected';}?>>Junio</option>
  	 		<option value="7" <?php if($mes==7){echo 'selected';}?>>Julio</option>
  	 		<option value="8" <?php if($mes==8){echo 'selected';}?>>Agosto</option>
  	 		<option value="9" <?php if($mes==9){echo 'selected';}?>>Septiembre</option>
  	 		<option value="10" <?php if($mes==10){echo 'selected';}?>>Octubre</option>
  	 		<option value="11" <?php if($mes==11){echo 'selected';}?>>Noviembre</option>
  	 		<option value="12" <?php if($mes==12){echo 'selected';} ?>>Diciembre</option>
  	 		</select><select name="diai" style="WIDTH: 42px">
  	 		<option value="1" <?php if($dia==1){echo 'selected';}?>>1</option>
  	 		<option value="2" <?php if($dia==2){echo 'selected';}?>>2</option>
  	 		<option value="3" <?php if($dia==3){echo 'selected';}?>>3</option>
  	 		<option value="4" <?php if($dia==4){echo 'selected';}?>>4</option>
  	 		<option value="5" <?php if($dia==5){echo 'selected';}?>>5</option>
  	 		<option value="6" <?php if($dia==6){echo 'selected';}?>>6</option>
  	 		<option value="7" <?php if($dia==7){echo 'selected';}?>>7</option>
  	 		<option value="8" <?php if($dia==8){echo 'selected';}?>>8</option>
  	 		<option value="9" <?php if($dia==9){echo 'selected';}?>>9</option>
  	 		<option value="10" <?php if($dia==10){echo 'selected';}?>>10</option>
  	 		<option value="11" <?php if($dia==11){echo 'selected';}?>>11</option>
  	 		<option value="12" <?php if($dia==12){echo 'selected';} ?>>12</option>
  	 		<option value="13" <?php if($dia==13){echo 'selected';}?>>13</option>
  	 		<option value="14" <?php if($dia==14){echo 'selected';}?>>14</option>
  	 		<option value="15" <?php if($dia==15){echo 'selected';}?>>15</option>
  	 		<option value="16" <?php if($dia==16){echo 'selected';}?>>16</option>
  	 		<option value="17" <?php if($dia==17){echo 'selected';}?>>17</option>
  	 		<option value="18" <?php if($dia==18){echo 'selected';}?>>18</option>
  	 		<option value="19" <?php if($dia==19){echo 'selected';}?>>19</option>
  	 		<option value="20" <?php if($dia==20){echo 'selected';}?>>20</option>
  	 		<option value="21" <?php if($dia==21){echo 'selected';}?>>21</option>
  	 		<option value="22" <?php if($dia==22){echo 'selected';}?>>22</option>
  	 		<option value="23" <?php if($dia==23){echo 'selected';}?>>23</option>
  	 		<option value="24" <?php if($dia==24){echo 'selected';}?>>24</option>
  	 		<option value="25" <?php if($dia==25){echo 'selected';}?>>25</option>
  	 		<option value="26" <?php if($dia==26){echo 'selected';}?>>26</option>
  	 		<option value="27" <?php if($dia==27){echo 'selected';}?>>27</option>
  	 		<option value="28" <?php if($dia==28){echo 'selected';}?>>28</option>
  	 		<option value="29" <?php if($dia==29){echo 'selected';}?>>29</option>
  	 		<option value="30" <?php if($dia==30){echo 'selected';}?>>30</option>
  	 		<option value="31" <?php if($dia==31){echo 'selected';}?>>31</option>
  	 		</select>Hora<select name="horai" style="WIDTH: 42px">
  	 		<option value="0" <?php if($hora==0){echo 'selected';}?>>00</option>
  	 		<option value="1" <?php if($hora==1){echo 'selected';}?>>01</option>
  	 		<option value="2" <?php if($hora==2){echo 'selected';}?>>02</option>
  	 		<option value="3" <?php if($hora==3){echo 'selected';}?>>03</option>
  	 		<option value="4" <?php if($hora==4){echo 'selected';}?>>04</option>
  	 		<option value="5" <?php if($hora==5){echo 'selected';}?>>05</option>
  	 		<option value="6" <?php if($hora==6){echo 'selected';}?>>06</option>
  	 		<option value="7" <?php if($hora==7){echo 'selected';}?>>07</option>
  	 		<option value="8" <?php if($hora==8){echo 'selected';}?>>08</option>
  	 		<option value="9" <?php if($hora==9){echo 'selected';}?>>09</option>
  	 		<option value="10" <?php if($hora==10){echo 'selected';}?>>10</option>
  	 		<option value="11" <?php if($hora==11){echo 'selected';}?>>11</option>
  	 		<option value="12" <?php if($hora==12){echo 'selected';} ?>>12</option>
  	 		<option value="13" <?php if($hora==13){echo 'selected';}?>>13</option>
  	 		<option value="14" <?php if($hora==14){echo 'selected';}?>>14</option>
  	 		<option value="15" <?php if($hora==15){echo 'selected';}?>>15</option>
  	 		<option value="16" <?php if($hora==16){echo 'selected';}?>>16</option>
  	 		<option value="17" <?php if($hora==17){echo 'selected';}?>>17</option>
  	 		<option value="18" <?php if($hora==18){echo 'selected';}?>>18</option>
  	 		<option value="19" <?php if($hora==19){echo 'selected';}?>>19</option>
  	 		<option value="20" <?php if($hora==20){echo 'selected';}?>>20</option>
  	 		<option value="21" <?php if($hora==21){echo 'selected';}?>>21</option>
  	 		<option value="22" <?php if($hora==22){echo 'selected';}?>>22</option>
  	 		<option value="23" <?php if($hora==23){echo 'selected';}?>>23</option>
  	 		</select>:<select name="mini" style="WIDTH: 42px">
  	 		<option value="0" <?php if($min==0){echo 'selected';}?>>00</option>
  	 		<option value="1" <?php if($min==1){echo 'selected';}?>>01</option>
  	 		<option value="2" <?php if($min==2){echo 'selected';}?>>02</option>
  	 		<option value="3" <?php if($min==3){echo 'selected';}?>>03</option>
  	 		<option value="4" <?php if($min==4){echo 'selected';}?>>04</option>
  	 		<option value="5" <?php if($min==5){echo 'selected';}?>>05</option>
  	 		<option value="6" <?php if($min==6){echo 'selected';}?>>06</option>
  	 		<option value="7" <?php if($min==7){echo 'selected';}?>>07</option>
  	 		<option value="8" <?php if($min==8){echo 'selected';}?>>08</option>
  	 		<option value="9" <?php if($min==9){echo 'selected';}?>>09</option>
  	 		<option value="10" <?php if($min==10){echo 'selected';}?>>10</option>
  	 		<option value="11" <?php if($min==11){echo 'selected';}?>>11</option>
  	 		<option value="12" <?php if($min==12){echo 'selected';} ?>>12</option>
  	 		<option value="13" <?php if($min==13){echo 'selected';}?>>13</option>
  	 		<option value="14" <?php if($min==14){echo 'selected';}?>>14</option>
  	 		<option value="15" <?php if($min==15){echo 'selected';}?>>15</option>
  	 		<option value="16" <?php if($min==16){echo 'selected';}?>>16</option>
  	 		<option value="17" <?php if($min==17){echo 'selected';}?>>17</option>
  	 		<option value="18" <?php if($min==18){echo 'selected';}?>>18</option>
  	 		<option value="19" <?php if($min==19){echo 'selected';}?>>19</option>
  	 		<option value="20" <?php if($min==20){echo 'selected';}?>>20</option>
  	 		<option value="21" <?php if($min==21){echo 'selected';}?>>21</option>
  	 		<option value="22" <?php if($min==22){echo 'selected';}?>>22</option>
  	 		<option value="23" <?php if($min==23){echo 'selected';}?>>23</option>
  	 		<option value="24" <?php if($min==24){echo 'selected';}?>>24</option>
  	 		<option value="25" <?php if($min==25){echo 'selected';}?>>25</option>
  	 		<option value="26" <?php if($min==26){echo 'selected';}?>>26</option>
  	 		<option value="27" <?php if($min==27){echo 'selected';}?>>27</option>
  	 		<option value="28" <?php if($min==28){echo 'selected';}?>>28</option>
  	 		<option value="29" <?php if($min==29){echo 'selected';}?>>29</option>
  	 		<option value="30" <?php if($min==30){echo 'selected';}?>>30</option>
  	 		<option value="31" <?php if($min==31){echo 'selected';}?>>31</option>
  	 		<option value="32" <?php if($min==32){echo 'selected';} ?>>32</option>
  	 		<option value="33" <?php if($min==33){echo 'selected';}?>>33</option>
  	 		<option value="34" <?php if($min==34){echo 'selected';}?>>34</option>
  	 		<option value="35" <?php if($min==35){echo 'selected';}?>>35</option>
  	 		<option value="36" <?php if($min==36){echo 'selected';}?>>36</option>
  	 		<option value="37" <?php if($min==37){echo 'selected';}?>>37</option>
  	 		<option value="38" <?php if($min==38){echo 'selected';}?>>38</option>
  	 		<option value="39" <?php if($min==39){echo 'selected';}?>>39</option>
  	 		<option value="40" <?php if($min==40){echo 'selected';}?>>40</option>
  	 		<option value="41" <?php if($min==41){echo 'selected';}?>>41</option>
  	 		<option value="42" <?php if($min==42){echo 'selected';}?>>42</option>
  	 		<option value="43" <?php if($min==43){echo 'selected';}?>>43</option>
  	 		<option value="44" <?php if($min==44){echo 'selected';}?>>44</option>
  	 		<option value="45" <?php if($min==45){echo 'selected';}?>>45</option>
  	 		<option value="46" <?php if($min==46){echo 'selected';}?>>46</option>
  	 		<option value="47" <?php if($min==47){echo 'selected';}?>>47</option>
  	 		<option value="48" <?php if($min==48){echo 'selected';}?>>48</option>
  	 		<option value="49" <?php if($min==49){echo 'selected';}?>>49</option>
  	 		<option value="50" <?php if($min==50){echo 'selected';}?>>50</option>
  	 		<option value="51" <?php if($min==51){echo 'selected';}?>>51</option>
  	 		<option value="52" <?php if($min==52){echo 'selected';}?>>52</option>
  	 		<option value="53" <?php if($min==53){echo 'selected';}?>>53</option>
  	 		<option value="54" <?php if($min==54){echo 'selected';}?>>54</option>
  	 		<option value="55" <?php if($min==55){echo 'selected';}?>>55</option>
  	 		<option value="56" <?php if($min==56){echo 'selected';}?>>56</option>
  	 		<option value="57" <?php if($min==57){echo 'selected';}?>>57</option>
  	 		<option value="58" <?php if($min==58){echo 'selected';}?>>58</option>
  	 		<option value="59" <?php if($min==59){echo 'selected';}?>>59</option>
  	 		</select>
      		</td>
     		</tr>

  			<tr>
  			<td align="right">Vigencia de contrato:</td>
			<td align="left">
			<select name="anov" style="WIDTH: 60px">
			<option value="" ></option>
  	 		<option value="<?php echo $ano3;?>" <?php if($anoxx==$ano3){echo 'selected=""';}?>><?php echo $ano3;?></option>
  	 		<option value="<?php echo $ano4;?>" <?php if($anoxx==$ano4){echo 'selected=""';}?>><?php echo $ano4;?></option>
  	 		<option value="<?php echo $ano5;?>" <?php if($anoxx==$ano5){echo 'selected=""';}?>><?php echo $ano5;?></option>
  	 		<option value="<?php echo $ano6;?>" <?php if($anoxx==$ano6){echo 'selected=""';}?>><?php echo $ano6;?></option>
  	 		</select><select name="mesv" style="WIDTH: 110px">
  	 		<option value="" ></option>
  	 		<option value="1" <?php if($mesxx==1){echo 'selected';}?>>Enero</option>
  	 		<option value="2" <?php if($mesxx==2){echo 'selected';}?>>Febrero</option>
  	 		<option value="3" <?php if($mesxx==3){echo 'selected';}?>>Marzo</option>
  	 		<option value="4" <?php if($mesxx==4){echo 'selected';}?>>Abril</option>
  	 		<option value="5" <?php if($mesxx==5){echo 'selected';}?>>Mayo</option>
  	 		<option value="6" <?php if($mesxx==6){echo 'selected';}?>>Junio</option>
  	 		<option value="7" <?php if($mesxx==7){echo 'selected';}?>>Julio</option>
  	 		<option value="8" <?php if($mesxx==8){echo 'selected';}?>>Agosto</option>
  	 		<option value="9" <?php if($mesxx==9){echo 'selected';}?>>Septiembre</option>
  	 		<option value="10" <?php if($mesxx==10){echo 'selected';}?>>Octubre</option>
  	 		<option value="11" <?php if($mesxx==11){echo 'selected';}?>>Noviembre</option>
  	 		<option value="12" <?php if($mesxx==12){echo 'selected';} ?>>Diciembre</option>
  	 		</select><select name="diav" style="WIDTH: 42px">
  	 		<option value="" ></option>
  	 		<option value="1" <?php if($diaxx==1){echo 'selected';}?>>1</option>
  	 		<option value="2" <?php if($diaxx==2){echo 'selected';}?>>2</option>
  	 		<option value="3" <?php if($diaxx==3){echo 'selected';}?>>3</option>
  	 		<option value="4" <?php if($diaxx==4){echo 'selected';}?>>4</option>
  	 		<option value="5" <?php if($diaxx==5){echo 'selected';}?>>5</option>
  	 		<option value="6" <?php if($diaxx==6){echo 'selected';}?>>6</option>
  	 		<option value="7" <?php if($diaxx==7){echo 'selected';}?>>7</option>
  	 		<option value="8" <?php if($diaxx==8){echo 'selected';}?>>8</option>
  	 		<option value="9" <?php if($diaxx==9){echo 'selected';}?>>9</option>
  	 		<option value="10" <?php if($diaxx==10){echo 'selected';}?>>10</option>
  	 		<option value="11" <?php if($diaxx==11){echo 'selected';}?>>11</option>
  	 		<option value="12" <?php if($diaxx==12){echo 'selected';} ?>>12</option>
  	 		<option value="13" <?php if($diaxx==13){echo 'selected';}?>>13</option>
  	 		<option value="14" <?php if($diaxx==14){echo 'selected';}?>>14</option>
  	 		<option value="15" <?php if($diaxx==15){echo 'selected';}?>>15</option>
  	 		<option value="16" <?php if($diaxx==16){echo 'selected';}?>>16</option>
  	 		<option value="17" <?php if($diaxx==17){echo 'selected';}?>>17</option>
  	 		<option value="18" <?php if($diaxx==18){echo 'selected';}?>>18</option>
  	 		<option value="19" <?php if($diaxx==19){echo 'selected';}?>>19</option>
  	 		<option value="20" <?php if($diaxx==20){echo 'selected';}?>>20</option>
  	 		<option value="21" <?php if($diaxx==21){echo 'selected';}?>>21</option>
  	 		<option value="22" <?php if($diaxx==22){echo 'selected';}?>>22</option>
  	 		<option value="23" <?php if($diaxx==23){echo 'selected';}?>>23</option>
  	 		<option value="24" <?php if($diaxx==24){echo 'selected';}?>>24</option>
  	 		<option value="25" <?php if($diaxx==25){echo 'selected';}?>>25</option>
  	 		<option value="26" <?php if($diaxx==26){echo 'selected';}?>>26</option>
  	 		<option value="27" <?php if($diaxx==27){echo 'selected';}?>>27</option>
  	 		<option value="28" <?php if($diaxx==28){echo 'selected';}?>>28</option>
  	 		<option value="29" <?php if($diaxx==29){echo 'selected';}?>>29</option>
  	 		<option value="30" <?php if($diaxx==30){echo 'selected';}?>>30</option>
  	 		<option value="31" <?php if($diaxx==31){echo 'selected';}?>>31</option>
  	 		</select>
      		</td>
     		</tr>
  	 		 
	 		<tr>
  			<td align="right">Estudio de Seguridad:</td>
     		<td align="left" valign="top">
	 		<select name="estudioseguridad" class="corto1"><option></option>
  	 		<option value="1" <?php $z="estudioseguridad"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['svyspa']==1) {echo ('selected=""');}?>>No</option>
  	 		<option value="2" <?php $z="estudioseguridad"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['svyspa']==2) {echo ('selected=""');}?>>Si</option>
  	 		</select>
   			</td>
			</tr>
			
			<tr>
  			<td align="right">Coordinadores de puesto:</td>
     		<td align="left" valign="top">
	 		<input  class="corto" name="coordinadores" value="<?php if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"coordinadores");}  ?>">
      		</td>
			</tr>
			
		    <tr>
  			<td align="right">Requisitos Facturaci&oacute;n:</td>
     		<td align="left" valign="top">
	 		<textarea name="requisitosfacturacion" id="sqlquery" cols="25" rows="3" dir="ltr"><?php if (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"requisitosfacturacion");}?></textarea>
      		</td>
			</tr>
			
			<tr>
  			<td align="right">Requerimientos especiales:</td>
     		<td align="left" valign="top">
	 		<textarea name="otrosreqv" id="sqlquery" cols="25" rows="3" dir="ltr"><?php if (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"otrosreqv");}?></textarea>
      		</td>
			</tr>
			
			<tr>
  			<td align="right">Observaciones:</td>
     		<td align="left" valign="top">
	 		<textarea name="observacionesnec" id="sqlquery" cols="25" rows="7" dir="ltr"><?php if (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionesnec");}?></textarea>
   			</td>
			</tr>
</table>
</td></tr></table>
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Condiciones de Instalaci&oacute;n
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"><input type="text" name="criterio"
			style="width:110px;margin-left:5px" class="busqueda" /></td>
                </tr>
			<tr height="10px"><td colspan="2" align="center">
			<input checked name="opt" type="radio" value="1">cualquier
			<input type="radio" name="opt" value="2">mismo
			</td></tr>
			<tr height="10px"><td valign="middle" colspan="2" align="center">
			Criterio
  			<select name="campobusqueda" style="WIDTH:115px" class="busqueda">
  	 		<option value="nombrecliente">Razon Social</option>
  	 		<option value="contacto" >Contacto</option>
  	 		<option value="telefono">Telefono</option>
  	 		<option value="numerooferta">Numero de oferta</option>
  	 		<option value="fechasolicitud">Fecha de Solicitud</option>
  	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;">
			<input type="submit" class="botoelimina" value="Eliminar" name="ejecut"/>
			</td></tr>
			
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Formato $p de $_SESSION[numreg]";} ?>
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
