<?php
/*
 * Created on 15/10/2007
 *
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();
 
@require('funciones2.php');
@require('clases/claseNotificacion.php');

$link = validar("","","", 26);

formularioactual();

 	if($_POST[ejecut]=="Buscar" || $_GET[ejecut]=="Buscar"){
            
		$_SESSION[datos]="";	
		$_SESSION[i]=0;

                 if($_POST[ejecut]=="Buscar"){
		$datos[campobusqueda]=$_POST[campobusqueda];
		$datos[crito]=$_POST[criterio];
		$datos[opcion]=$_POST[opt];
                }else{//busqieda con get
                $datos[campobusqueda]=$_GET[campobusqueda];
		$datos[crito]=$_GET[criterio];
		$datos[opcion]=$_GET[opt];
                //print_r($_GET);
                }

		$datos[claveprinc]="codigo";
		$datos[otraconsulta]="AND `clientes`.`activo` = 1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]'";
			
		$result2=operaciones("clientes","buscar",$datos);
		$result=$result2[datos];
		
	}else if($_POST[ejecut]==">>"){
		
		if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
		$result2=operaciones("clientes","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
	}else if($_POST[ejecut]=="<<"){
		
		if($_SESSION[i]>0){$_SESSION[i]--;}
		$result2=operaciones("clientes","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
	}else if($_POST[ejecut]=="||<"){
		
		$_SESSION[i]=0;
		$result2=operaciones("clientes","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
	}else if($_POST[ejecut]==">||"){
		
		$_SESSION[i]=$_SESSION[numreg]-1;
		$result2=operaciones("clientes","buscar",$_SESSION[datos]);
		$result=$result2[datos];
	
	}else if($_POST[ejecut]=="Actualizar"){

        if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
        $mens.=armarEjecutarSentencia("clientes", $_POST, "update", $_SESSION);

	}else if($_POST[ejecut]=="Ingresar"){

            if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
            $mens.=armarEjecutarSentencia("clientes", $_POST, "insert", $_SESSION);

                $notifica=new Notificacion();
                $z=$_POST[codigo];
                $notifica->crearNotificaciones($_SESSION[idusuario], "todos", "Cliente Nuevo", "<a href='clientes3.php?ejecut=Buscar&criterio=$z&campobusqueda=codigo&opt=2' target='blank'>".$_POST['nombrecliente']."</a>");

                if($notifica->error!=""){//hay un error de ejecucion
                    $mens.=$notifica->error.$notifica->cons;
                }

        }else if($_POST[ejecut]=="Retirar"){

                if($_POST['sucursal']==""){$_POST['sucursal']=$_SESSION['sucur'];}
                $_POST['activo']="0";   //actualizar a cliente retirado
                $_POST[fechafincontrato]="NOW()";
                $mens=armarEjecutarSentencia("clientes", $_POST, "update", $_SESSION);

	}else if($_POST[ejecut]=="Nuevo"){
		$_SESSION[i]=$_SESSION[numreg];
		$boton=1;
        }
	
	$mostrar[1]="nombres";
	$otras="AND habilitadoinfotech = 1";
	$selec=@mysql_result($result,$_SESSION['i'],"duenopuesto");
	$cadena=selection("socios","cedula","%",$mostrar,$selec,1,"nombres",$otras);
	
	$datos2[cliente]=$_SESSION[clientemod];
	$numvig=numvigact($datos2);
	
	$r=@require('version.php');
	caracteresiso();

$colcuerpo="#FAFAFA";
$coltabla="#9AFF83";
 
?>
<link rel="stylesheet" href="estilo2.css" type="text/css"/>
<link rel="stylesheet" href="botones.css" type="text/css"/>

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

<!-- fin librerias extjs -->
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>

		<form method="post" action="clientes3.php" name="clientes" onsubmit="return validacliente(boolvalidar);">
 		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
	 		<td align="right" width="25%">
	 		*Administrador del cliente:</td>
     		<td align="left" width="30%">
     		<select tabindex="1" class="largo1" name="duenopuesto">
  	 		<option value=""></option>
  	 		<?php echo $cadena;?>
			</select>
   			</td><!-- Col 1 -->
                        <td align="center"><?php
				$sqldocs="SELECT * FROM `docsclientes` WHERE `docsclientes`.`codigodoc` ='". @mysql_result($result,$_SESSION['i'],"codigo")."'";
				$numdocs=@mysql_num_rows(@mysql_query($sqldocs, $link)) or $error=@mysql_error($link);
	 		if($_SESSION[clientemod]!=""){echo "<a href=\"subirdoclientes.php\" target=\"_blank\">Documentos ($numdocs)</a>";}
	 		?></td>
 		</tr>
 
 		<tr>
  			<td align="right">*Codigo:  
      		</td>
     		<td align="left">
      		<input class="largo1" tabindex="2" 
			  value="<?php /*if ($_SESSION['cedulaa']!=""){
			  	echo $_SESSION[cedulaa];
			  }else*/
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"codigo");}
			 
			?>" name="codigo"/>
	  		</td><!-- Col 1 -->
    	</tr>

   		<tr><!-- Row 3 -->
  			<td align="right">*Nit:</td>
     		<td align="left">
	 		<input class="largo" tabindex="3"
			 value="<?php
			 /*if ($_SESSION['nombrea']!=""){
			  	echo $_SESSION[nombrea];
			  }else*/
			  if (!$result){
			  	echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"nit");}
			 		?>" name="nit"/>
      			</td><!-- Col 1 -->
   	 	</tr>

		<tr style="border-width: thin ;"><!-- Row 4 -->
  			<td align="right">*Nombre del cliente:</td>
     		<td align="left">
	 		<input class="extralargo" tabindex="4" name="nombrecliente"
			 value="<?php
			  if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"nombrecliente");} ?>"/>
      			</td><!-- Col 1 -->
  		</tr>

 		<tr><!-- Row 6 -->
  			<td align="right">Fecha inicio contrato:</td>
     		<td align="left">
	 		<input class="largo" tabindex="4" name="fechainiciocontrato" id="fechainiciocontrato"
			 value="<?php 
			  if (!$result){
			  	echo "";}else{   $l=split(" ", @mysql_result($result,$_SESSION['i'],"fechainiciocontrato"));echo $l[0];} ?>"/>
	 		</td><!-- Col 1 -->
  		</tr>

	  	<tr><!-- Row 6 -->
  			<td align="right">Nombre del administrador:</td>
		    <td align="left">
			<input class="extralargo" tabindex="4" name="nombreadministrador"
			 value="<?php 
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"nombreadministrador");} ?>"/>
      		
	 		</td><!-- Col 1 -->
  		</tr>
      	
      	<tr><!-- Row 7 -->
			<td align="right">Direccion Servicio: </td>
     		<td align="left">
			<input class="extralargo" tabindex="4" name="direccion"
			 value="<?php 
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"direccion");} ?>"/>
      			</td><!-- Col 1 -->
  		</tr>
  		
  		<tr><!-- Row 7 -->
			<td align="right">Direccion Correspondencia: </td>
     		<td align="left">
			<input class="extralargo" tabindex="4" name="direccion2"
			 value="<?php 
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"direccion2");} ?>"/>
      			</td><!-- Col 1 -->
  		</tr>
  		
 		<tr><!-- Row 8 -->
  			<td align="right">Email: </td>
			<td align="left">
			<input class="extralargo" tabindex="5" name="email" value="<?php
			  if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"email");}  ?>"/>
      		</td><!-- Col 1 -->
   		</tr>
   		 		

		<tr><!-- Row 8 -->
  			<td align="right">Telefono: </td>
			<td align="left">
			<input class="largo" tabindex="5" name="telefono" value="<?php
			  if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"telefono");}  ?>"/>
      		</td><!-- Col 1 -->
   		</tr> 


		<tr><!-- Row 9 -->
  			<td align="right">Valor mensual del contrato:  
      		</td>
     		<td align="left">
	 		<input class="largo" tabindex="6" name="valormensualcontrato" value="<?php
			  if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"valormensualcontrato");}  ?>"/>
      			</td><!-- Col 1 -->
   		</tr>

		<tr><!-- Row 10 -->
  			<td align="right">Valor asignado de salarios:</td>
     		<td align="left">
	 		<input class="largo" name="valoracordadosalarios" tabindex="7" value="<?php
			  if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"valoracordadosalarios");}  ?>"/>
      			</td><!-- Col 1 -->
		</tr>

  		<tr><!-- Row 11 -->
  			<td align="right">Fecha fin del contrato:</td>
     		<td align="left">
	 		<input class="largo" name="fechafincontrato" tabindex="8" id="fechafincontrato"
                       value="<?php
			  if (!$result){
			  	echo "";}else{ $l=split(" ", @mysql_result($result,$_SESSION['i'],"fechafincontrato"));echo $l[0];}  ?>"/>
	 		</td><!-- Col 1 -->
	 	</tr>
	 	
 		<tr><!-- Row 7 -->
  			<td align="right">Numero de porterias: </td>
     		<td align="left">
	 		<input class="corto" name="numeroporterias" tabindex="9" value="<?php
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"numeroporterias");}  ?>"/>
	 		</td><!-- Col 1 -->
   		</tr>
	
 		<tr><!-- Row 7 -->
  			<td align="right">Personal Diurno: </td>
     		<td align="left">
	 		<input class="corto" name="personald" tabindex="9" value="<?php
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"personald");}  ?>"/>
	 		</td><!-- Col 1 -->
   		</tr>
   		
   		
 		<tr><!-- Row 7 -->
  			<td align="right">Personal Nocturno: </td>
     		<td align="left">
	 		<input class="corto" name="personaln" tabindex="9" value="<?php
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"personaln");}  ?>"/>
	 		</td><!-- Col 1 -->
   		</tr>
   		
   		<tr><!-- Row 11 -->
  			<td align="right">Cliente de Servicio de Escoltas:</td>
     		<td align="left">
	 		<select name="clientescolta">
	 		<option value="0" <?php if(@mysql_result($result,$_SESSION['i'], "clientescolta")=="0"){echo "selected=\"selected\"";}?>>No</option>
	 		<option value="1" <?php if(@mysql_result($result,$_SESSION['i'], "clientescolta")=="1"){echo "selected=\"selected\"";}?>>Si</option>
	 		</select>
	 		</td><!-- Col 1 -->
                </tr>

                <tr><!-- Row 11 -->
  			<td align="right">Codigo para Relevantes:</td>
     		<td align="left">
	 		<select name="clierelevante">
	 		<option value="0" <?php if(@mysql_result($result,$_SESSION['i'], "clierelevante")=="0"){echo "selected=\"selected\"";}?>>No</option>
	 		<option value="1" <?php if(@mysql_result($result,$_SESSION['i'], "clierelevante")=="1"){echo "selected=\"selected\"";}?>>Si</option>
	 		</select>
	 		</td><!-- Col 1 -->
	 	</tr>
   		
		<tr><!-- Row 11 -->
  			<td align="right">Vigilantes en Sistema:</td>
     		<td align="left">
	 		<input class="corto" name="numvig" tabindex="9" value="<?php
			  if (!$result){
			  	echo "";}else{  echo $numvig;}  ?>" disabled />
	 		</td><!-- Col 1 -->
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
	 		</td><!-- Col 1 -->
     		</tr>
			';	
			}
                ?>
 		</table>
 		
 		</td></tr></table>
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Clientes Activos
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
                                value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
                                onkeydown="boolvalidar=false;"></td>
                        <td align="left"><input type="text" name="criterio"
                                style="width:110px;margin-left:5px" class="busqueda" /></td>
                </tr>
			<tr height="20px"><td colspan="2" align="center">
			<input checked name="opt" type="radio" value="1"/>cualquier
			<input type="radio" name="opt" value="2"/>mismo
			</td></tr>
			<tr height="10px"><td valign="middle" colspan="2" align="center">
			Criterio
  			<select name="campobusqueda" style="WIDTH:115px" class="busqueda">
  			<option value="codigo">Codigo Cliente</option>
 	 		<option value="nombrecliente">Nombre cliente</option>
  	 		<option value="nombreadministrador">Administrador</option>
  	 		<option value="telefono">Telefono</option>
  	 		<option value="direccion">Direccion</option>
  	 		<option value="duenopuesto">Socio Administrador</option>
  	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut"/>
			<input type="submit" class="botoant" value="<<" name="ejecut"/>
			<input type="submit" class="botosig" value=">>" name="ejecut"/>
			<input type="submit" class="botoult" value=">||" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			<input type="submit" class="botoreti" value="Retirar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Cliente $p de $_SESSION[numreg]";} ?>
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