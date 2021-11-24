<?php 
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 49);

$_SESSION['i']=0;

	if($_POST[ejecut]=="Actualizar"){
	$mens.=armarEjecutarSentencia("parametros", $_POST, "update", $_SESSION);
	}

$sql1="SELECT * FROM parametros";
$result=@mysql_query($sql1);
$_SESSION['idcambiar']=@mysql_result($result,$_SESSION['i'],"id");

		$r=@require('version.php');
		caracteresiso();
$colcuerpo="#FAFAFA";
$coltabla="#22CD82";
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
		<form method="post" action="<?php echo $PHP_SELF?>">
 		<table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
	 		<td align="left" valign="middle">
			Salario Minimo
			</td>
                        <td align="left" width="15%" valign="middle">
	 		Valor Hora Ordinaria
                        </td>
     		<td align="left" width="15%" valign="middle">
	 		Retencion	
      		</td><!-- Col 1 -->
	 		<td width="20%" valign="middle" align="left">
	 		Iva
		  	</td>
			<td >Ica</td>
             	</tr>
		<tr>
		<td>
		<input class="medio" tabindex="3" name="salariominimo"
			 value="<?php
		 if ($_SESSION['nita']!=""){
			  	echo $_SESSION[nita];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"salariominimo");} ?>">
		</td>
                <td>
		<input class="corto" tabindex="3" name="valorhoraordinaria"
			 value="<?php
		 if ($_SESSION['valorhoraordinariaa']!=""){
			  	echo $_SESSION[valorhoraordinariaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"valorhoraordinaria");} ?>">
		</td>
		<td>
		<input class="corto" tabindex="3" name="retefuente"
			 value="<?php
		 if ($_SESSION['numerolicenciaa']!=""){
			  	echo $_SESSION[numerolicenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"retefuente");} ?>"> 
		</td>
		<td>
		<input class="corto" tabindex="3" name="iva"
			 value="<?php
		 if ($_SESSION['numerolicenciaa']!=""){
			  	echo $_SESSION[numerolicenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"iva");} ?>">
		<td>
		<input class="corto" tabindex="3" name="ica"
			 value="<?php
		 if ($_SESSION['numerolicenciaa']!=""){
			  	echo $_SESSION[numerolicenciaa];
			  }elseif (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"ica");} ?>">
		</td>
		</table>
		
		</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Par&aacute;metros del Sistema
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle">
 			</td><td valign="middle">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
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
