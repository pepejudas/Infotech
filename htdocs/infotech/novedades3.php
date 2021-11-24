<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 9);
	
	formularioactual();
	
switch($_POST[ejecut]):
case "Buscar":
$_SESSION['i']=0;
		
		if($_POST[cedpersona]!=""){
		$_SESSION['cedulamod']=$_POST[cedpersona];
		
		$datos[campobusqueda]="cedula";
		$datos[crito]=$_SESSION['cedulamod'];
		$datos[opcion]="";
		$datos[claveprinc]="consecutivo";
		$datos[otraconsulta]="";
		$result1=operaciones("novedades","buscar",$datos);
		$result=$result1[datos];
		$_SESSION['idmod']=@mysql_result($result,0,consecutivo);
		}else{$_SESSION['cedulamod']="";}

break;
case ">>":
if($_SESSION[i]<$_SESSION[numreg]-1){
$_SESSION[i]++;}		
$result1=operaciones("novedades","buscar",$_SESSION[datos]);
$result=$result1[datos];
$_SESSION['idmod']=@mysql_result($result,$_SESSION['i'],consecutivo);
break;
case "<<":
if($_SESSION[i]>0){		
$_SESSION[i]--;}		
$result1=operaciones("novedades","buscar",$_SESSION[datos]);
$result=$result1[datos];
$_SESSION['idmod']=@mysql_result($result,$_SESSION['i'],consecutivo);
break;
case ">||":
$_SESSION[i]=$_SESSION[numreg]-1;		
$result1=operaciones("novedades","buscar",$_SESSION[datos]);
$result=$result1[datos];
$_SESSION['idmod']=@mysql_result($result,$_SESSION['i'],consecutivo);

break;
case "||<":
$_SESSION[i]=0;		
$result1=operaciones("novedades","buscar",$_SESSION[datos]);
$result=$result1[datos];
$_SESSION['idmod']=@mysql_result($result,$_SESSION['i'],consecutivo);

break;
case "Nuevo":
$boton=1;
$_SESSION[i]=$_SESSION[numreg];		
$result1=operaciones("novedades","buscar",$_SESSION[datos]);
$result=$result1[datos];
break;
case "Ingresar":
if($_POST[novedad]!="" and $_POST[fechanov]!=""){
$sql1="INSERT INTO `novedades` (cedula, novedad, fechanov, fechareg, ingresadopor, codcliente, observacionesfalta) VALUES ('$_SESSION[cedulamod]', '$_POST[novedad]', '$_POST[fechanov]', NOW(), '$_SESSION[persona]', '$_POST[codcliente]', '$_POST[observacionesfalta]')";
$resultar=@mysql_query($sql1);

}
break;
case "Actualizar":
if($_POST[novedad]!="" and $_POST[fechanov]!=""){
$sql1="UPDATE `novedades` SET cedula='$_SESSION[cedulamod]', novedad='$_POST[novedad]', fechanov='$_POST[fechanov]', fechareg=NOW(), ingresadopor='$_SESSION[persona]', codcliente='$_POST[codcliente]', observacionesfalta='$_POST[observacionesfalta]' WHERE `novedades`.`consecutivo`=$_SESSION[idmod]";
$resultar=@mysql_query($sql1);
$result1=operaciones("novedades","buscar",$_SESSION[datos]);
$result=$result1[datos];
$_SESSION['idmod']=@mysql_result($result,$_SESSION['i'],consecutivo);
}
break;
endswitch;

$mostra[1]="apellidos";
$mostra[2]="nombre";
$otras="AND `personalactivo`.`activo`=1 AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'";
$cadena=selection("personalactivo","cedula","%",$mostra,$_SESSION[cedulamod],2,"apellidos",$otras);

$muestr[1]="codigo";
$otrasent="AND clientes.sucursal LIKE '$_SESSION[sucur]'";
$seleccionado=@mysql_result($result,$_SESSION['i'],"codcliente");
$cadenac=selection("clientes","codigo","%",$muestr,$seleccionado,1,"codigo",$otrasent);

		$r=@require('version.php');
		caracteresiso();
		
$colcuerpo="#FAFAFA";
$coltabla="#11FF83";
 
?>

<link rel="stylesheet" href="estilo2.css" type="text/css">
<link rel="stylesheet" href="botones.css" type="text/css">
<!-- inicio librerias extjs -->
<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext/ext-all.js"></script>
<script type="text/javascript" src="ext/examples/form/personalActivo.js"></script>
<script type="text/javascript" src="scripts/menu.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/form/combos.css" />
<script	language="javascript" type="text/javascript" src="scripts/validacionExt.js"></script>
<link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />
<!-- fin librerias extjs -->
<script type="text/javascript">
Ext.onReady(function(){

Ext.QuickTips.init();

var startdt3 = new Ext.form.DateField({
    applyTo: 'fechanov', // <-- here you say where it must be rendered
    name: 'fechanov',
    format: 'Y-m-d',
    showToday: false,
    size:10
});

var startdt4 = new Ext.form.DateField({
    applyTo: 'vigenciapj', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Vencimiento Pasado Judicial',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});
});
</script>
</head>
<body>
		<form method="post" action="<?php echo $PHP_SELF?>">
 		<table class="tablaprinc"><tr><td>
		<table>
		<tr>
	 		<td align="right" width="25%">
			Novedad:
	 		</td>
	     	<td align="left" width="30%">
			<select tabindex="1" class="largo1" name="novedad">
 			<?php echo obtenerNovedades(@mysql_result($result,$_SESSION['i'],"novedad"), $conturno="no");?>
                        </select>
			</td>
	 	</tr>
	 	
  		<tr>
  			<td align="right">Dado en cliente:
      		</td>
     		<td align="left">
			<select tabindex="1" class="largo1" name="codcliente">
			<option></option>
			<?php echo $cadenac;?>
      		</select>
     		</td><!-- Col 1 -->
     	</tr>

   		<tr><!-- Row 3 -->
  			<td align="right">Fecha de novedad:</td>
     		<td align="left">
	 		<input class="medio" tabindex="3"
			 value="<?php
			 /*if ($_SESSION['fechanova']!=""){
			  	echo $_SESSION[fechanova];
			  }else*/
			  if (!$result){
			  	echo "";}  else{ echo @mysql_result($result,$_SESSION['i'],"fechanov");}
			 		?>" name="fechanov" id="fechanov" >
      			</td><!-- Col 1 -->
    	 </tr>
	 
	 	 <tr><!-- Row 4 -->
  			<td align="right">Fecha registrado:</td>
     		<td align="left">
	 		<input class="medio" tabindex="4" name="fechareg" readonly
			 value="<?php
			  if (!$result){
			  	echo "";}else{ echo @mysql_result($result,$_SESSION['i'],"fechareg");} ?>">
      			</td><!-- Col 1 -->
  		</tr>

 		<tr><!-- Row 6 -->
  			<td align="right">Registrado por:</td>
     		<td align="left">
	 		<input class="medio" tabindex="4" name="ingresadopor" readonly
			 value="<?php 
			  if (!$result){
			  	echo "";}else{  echo @mysql_result($result,$_SESSION['i'],"ingresadopor");} ?>">
	 		</td><!-- Col 1 -->
  		</tr>

	  	<tr><!-- Row 6 -->
  			<td align="right"></td>
		    <td align="left">
			Observaciones de novedad:
	 		</td><!-- Col 1 -->
  		</tr>
      		
	   	<tr><!-- Row 7 -->
			<td align="right"></td>
			<td align="left"><textarea name="observacionesfalta" id="sqlquery" cols="17" rows="7" dir="ltr"><?php if ($_SESSION['observacionesfaltaa']!=""){echo $_SESSION[observacionesfaltaa];}elseif (!$result){echo "";}else{echo @mysql_result($result,$_SESSION['i'],"observacionesfalta");}?></textarea>
			</td>
  		</tr>

			<!-- fila de guia dura -->
  		</table>
  			
  			</td></tr></table>
		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Faltas Disciplinarias
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle" align="center" colspan="2">
 			<input type="submit" class="botobusca" value="Buscar" name="ejecut">
 			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="cedpersona" class="largo2">
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
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Novedad $p de $_SESSION[numreg]";} ?>
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
