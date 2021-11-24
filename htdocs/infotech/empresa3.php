<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 51);

$_SESSION['i']=0;

formularioactual();

	if($_POST[ejecut]=="Actualizar"){
	
		$_SESSION['camp']=$_POST[campobusqueda];
		$datos[campobusqueda]="id";
		$datos[crito]="%";
		$datos[opcion]="1";
		$datos[claveprinc]="id";
		$datos[otraconsulta]="";
		$datos[orden]="";
			
		$result2=operaciones("seguridadsuper","buscar",$datos);
		$result=$result2[datos];

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}

                if($_SESSION['idcambiar']!="" AND $_SESSION['idcambiar']!="NULL"){
		$mens.=armarEjecutarSentencia("seguridadsuper", $_POST, "update", $_SESSION);
		}else{
		$mens.=armarEjecutarSentencia("seguridadsuper", $_POST, "insert", $_SESSION);
		}
	}


		$_SESSION['i']=0;
		$_SESSION['camp']=$_POST[campobusqueda];
		$datos[campobusqueda]="id";
		$datos[crito]="%";
		$datos[opcion]="1";
		$datos[claveprinc]="id";
		$datos[otraconsulta]="";
		$datos[orden]="";
			
		$result2=operaciones("seguridadsuper","buscar",$datos);
		$result=$result2[datos];
		
		$_SESSION['idcambiar']=@mysql_result($result,$_SESSION['i'],"id");

                $mens.=$error;
                
$r=@require('version.php');
caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#22CD82";
?>
<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

<!-- GC -->
<!-- LIBS -->
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->

<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/empresa.js"></script>
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
<script type="text/javascript">
		function mensajeini(msginicio){
			Ext.Msg.alert("Atencion", "<div style=\"float:right\"><img src=\"imagenes/dialog-warning.png\"></div><div>"+msginicio+"</div>");
		}
</script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
		<form method="post" action="<?php echo $PHP_SELF;?>" >
 		<table class="tablaprinc"><tr>
	 		<td align="left" valign="middle">
			Nit
			</td>
     		<td align="left" valign="middle">
	 		Clase servicio	
      		</td>
	 		<td valign="middle" align="left">
	 		Numero licencia
		  	</td>
			<td valign="middle" align="left">
	 		Fecha inicio licencia
		  	</td>
			<td valign="middle" align="left">
	 		Fecha final licencia
		  	</td>
     	</tr>
     	
		<tr>
			<td>
			<input class="medio" tabindex="3" name="nit"
			 value="<?php if ($_SESSION['nita']!=""){
			  	echo $_SESSION[nita];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nit");} ?>">
			</td>
			<td>
			<select name="codigoservicio" class="largo1" tabindex="5">
			<option value="">seleccionar</option>
  	 		<option value="1" <?php $z="codigoservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==1 or $_SESSION['sexoa']==1) {echo ('selected=""');}?>>Vigilancia</option>
  	 		<option value="2" <?php $z="codigoservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==2 or $_SESSION['sexoa']==2) {echo ('selected=""');}?>>Departamentos</option>
  	 		<option value="3" <?php $z="codigoservicio"; $sex=@mysql_result($result,$_SESSION['i'],$z); if ($sex==3 or $_SESSION['sexoa']==3) {echo ('selected=""');}?>>Servicios especiales</option>
  	 		</select> 
			</td>
			<td>
			<input class="corto" tabindex="3" name="numerolicencia"
			 value="<?php
		 	if ($_SESSION['numerolicenciaa']!=""){
			  	echo $_SESSION[numerolicenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"numerolicencia");} ?>">
			</td>
			<td>
			<input class="medio" tabindex="3" name="fechainiciolic" id="fechainiciolic"
			 value="<?php
			 if ($_SESSION['fechainiciolica']!=""){
			  	echo $_SESSION[fechainiciolica];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechainiciolic");} ?>">
			</td>
			<td>
			<input class="medio" tabindex="3" name="fechafinlic" id="fechafinlic"
			 value="<?php
		 	if ($_SESSION['fechafinlica']!=""){
			  	echo $_SESSION[fechafinlica];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechafinlic");} ?>">
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right" WIDTH="40%">
			Informacion de la organizacion
			</td>
		</tr>

		<tr>
			<td colspan="4"  align="right">
			Razon Social:<input  class="extralargo" tabindex="3" name="razonsocial"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"razonsocial");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Sede:
			<select class="largo1" name="spaos">
    		<option value="1" <?php if (@mysql_result($result,$_SESSION['i'],"spaos")==1){echo selected;} ?>>Sede principal</option>
    		<option value="2" <?php if (@mysql_result($result,$_SESSION['i'],"spaos")==2){echo selected;} ?>>Agencia</option>
    		<option value="3" <?php if (@mysql_result($result,$_SESSION['i'],"spaos")==3){echo selected;} ?>>Sucursal</option>
  			</select>
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Direccion principal<input  class="extralargo" tabindex="3" name="direccion"
			 value="<?php
		 	if ($_SESSION['direcciona']!=""){
			  	echo $_SESSION[direcciona];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"direccion");} ?>">
			</td>
		</tr>
			
		<tr>
			<td colspan="4"  align="right" >
			Departamento:<input  class="extralargo" tabindex="3" name="depto"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"depto");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Municipio<input  class="extralargo" tabindex="3" name="municipio"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"municipio");} ?>">
			</td>
		</tr>
			
		<tr>
			<td colspan="4"  align="right" >
			Representante legal:<input  class="extralargo" tabindex="3" name="representantelegal"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"representantelegal");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Cedula rep legal<input  class="extralargo" tabindex="3" name="cedularepres"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"cedularepres");} ?>">
			</td>
			<td align=right>
			De<input  class="corto" tabindex="3" name="expedicioncedrep"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"expedicioncedrep");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Aseguradora poliza resp.<input  class="extralargo" tabindex="3" name="aseguradora"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"aseguradora");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Numero poliza<input  class="extralargo" tabindex="3" name="numpoliza"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"numpoliza");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Valor asegurado<input  class="extralargo" tabindex="3" name="valorasegurado"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"valorasegurado");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Fecha expedicion poliza<input  class="corto" tabindex="3" name="fechaexpedicion" id="fechaexpedicion"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechaexpedicion");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan=3  align="right" >
			Resolucion vigilancia fija<input  class="medio" tabindex="3" name="resfija"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"resfija");} ?>">
			</td>
			<td align="left" colspan="2">
			<input  class="corto" tabindex="3" name="fechafija" id="fechafija"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechafija");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan=3  align="right" >
			Resolucion vigilancia movil<input  class="medio" tabindex="3" name="resmovil"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"resmovil");} ?>">
			</td>
			<td align="left" colspan="2">
			<input  class="corto" tabindex="3" name="fechamovil" id="fechamovil"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechamovil");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan=3  align="right" >
			Resolucion escoltas<input  class="medio" tabindex="3" name="resescolta"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"resescolta");} ?>">		
			</td>
			<td align="left" colspan="2">
			<input  class="corto" tabindex="3" name="fechaescolta" id="fechaescolta"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechaescolta");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan=3  align="right" >
			Resolucion medios tecn.<input  class="medio" tabindex="3" name="resoluciontecnologicos"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"resoluciontecnologicos");} ?>">
			</td>
			<td align="left" colspan="2">
			<input  class="corto" tabindex="3" name="fechamediostec" id="fechamediostec"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechamediostec");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Asociados a:<input  class="extralargo" tabindex="3" name="asociadoa"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"asociadoa");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Usuarios aproximados:<input  class="medio" tabindex="3" name="personasaprox"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"personasaprox");} ?>">
		
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			No de autos<input  class="medio" tabindex="3" name="camperos"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"camperos");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			No de autos blindados<input  class="medio" tabindex="3" name="autos"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"autos");} ?>">
		
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			No transvalores<input  class="medio" tabindex="3" name="transvalores"
			 value="<?php
		 		if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"transvalores");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			No de motos<input  class="medio" tabindex="3" name="motos"
			 value="<?php
				if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"motos");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Telefono 1<input  class="medio" tabindex="3" name="telefono1"
			 value="<?php
			 if ($_SESSION['telefono1a']!=""){
			  	echo $_SESSION[telefono1a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono1");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Telefono 2<input  class="medio" tabindex="3" name="telefono2"
			 value="<?php
			 if ($_SESSION['telefono2a']!=""){
			  	echo $_SESSION[telefono2a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono2");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Telefono 3<input  class="medio" tabindex="3" name="telefono3"
			 value="<?php
			 if ($_SESSION['telefono3a']!=""){
			  	echo $_SESSION[telefono3a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono3");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Telefono 4<input  class="medio" tabindex="3" name="telefono4"
			 value="<?php
		 	if ($_SESSION['telefono4a']!=""){
			  	echo $_SESSION[telefono4a];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono4");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Barrio<input  class="extralargo" tabindex="3" name="barrio"
			 value="<?php
		 	if ($_SESSION['barrioa']!=""){
			  	echo $_SESSION[barrioa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"barrio");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Pagina Web<input  class="extralargo" tabindex="3" name="paginaweb"
			 value="<?php
		 	if ($_SESSION['paginaweba']!=""){
			  	echo $_SESSION[paginaweba];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"paginaweb");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Correo Electronico<input  class="extralargo" tabindex="3" name="email"
			 value="<?php
		 	if ($_SESSION['emaila']!=""){
			  	echo $_SESSION[emaila];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"email");} ?>">
			</td>
		</tr>
		
		<tr>
			<td colspan="4"  align="right" >
			Ciudad<input  class="extralargo" tabindex="3" name="ciudad"
			 value="<?php
		 	if ($_SESSION['ciudada']!=""){
			  	echo $_SESSION[ciudada];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"ciudad");} ?>">
			</td>
		</tr>
		</table>

                <div id="controlex">
     		<table  class="control">
     		<tr height="150px"><td colspan="2" class="arriba">
     		Nuestra Organizaci&oacute;n
     		</td>
     		</tr>
     		<tr height="20px" valign="top"><td valign="middle">
 			</td><td valign="middle">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut"/>
			</td></tr>
			<tr height="20px"><td colspan="2" align="center">
			</td></tr>
			<tr height="30px"><td colspan="2" align="center">
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
