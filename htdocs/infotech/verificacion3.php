<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 7);

formularioactual();

		$sqcl="SELECT * FROM `personalactivo` ORDER BY apellidos";
		$resultadota = mysql_query($sqcl);
		$reg=0;
		$cadena="";
		$lim= mysql_num_rows($resultadota);
		$cad =$_POST[cedpersona];
		$array = explode (" ", $cad);
		$vtor=explode(" ",$_POST[cedpersona]);
		$wd=$vtor[0];
	
		switch ($_POST[ejecut]):
				case "Buscar":
					$_SESSION[cedulamod]=$_POST[cedpersona];
					$sqql = "SELECT * FROM personalactivo WHERE cedula LIKE '$_SESSION[cedulamod]' ";
					$result= mysql_query($sqql);
					$_SESSION['i']=0;
					
		break;
		case "Actualizar":
	
		if ($_POST[hv]=="on"){$vhv=1;}else{$vhv=0;}
		if ($_POST[fc]=="on"){$vfc=1;}else{$vfc=0;}
		if ($_POST[flb]=="on"){$vflb=1;}else{$vflb=0;}
		if ($_POST[fpj]=="on"){$vfpj=1;}else{$vfpj=0;}
		if ($_POST[fca]=="on"){$vfca=1;}else{$vfca=0;}
		if ($_POST[fra]=="on"){$vfra=1;}else{$vfra=0;}
		if ($_POST[rl]=="on"){$vrl=1;}else{$vrl=0;}
		if ($_POST[rp]=="on"){$vrp=1;}else{$vrp=0;}
		if ($_POST[cr]=="on"){$vcr=1;}else{$vcr=0;}
		if ($_POST[vid]=="on"){$vvid=1;}else{$vvid=0;}
		if ($_POST[ept]=="on"){$vept=1;}else{$vept=0;}
		if ($_POST[epps]=="on"){$vepps=1;}else{$vepps=0;}
		if ($_POST[emo]=="on"){$vemo=1;}else{$vemo=0;}
		if ($_POST[ind]=="on"){$vind=1;}else{$vind=0;}
		if ($_POST[vd]=="on"){$vvd=1;}else{$vvd=0;}
		if ($_POST[numcuenta]=="on"){$numc=1;}else{$numc=0;}
		$sql2="UPDATE `personalactivo` SET `numcuenta`='$numc', `hv`='$vhv', `fc`='$vfc', `flb`='$vflb', `fpj`='$vfpj', `fca`='$vfca', `fra`='$vfra', `rl`='$vrl', `rp`='$vrp', `cr`='$vcr', `vid`='$vvid', `ept`='$vept', `epps`='$vepps', `emo`='$vemo', `ind`='$vind', `vd`='$vvd', `observacionesver`='$_POST[observacionesver]'WHERE `personalactivo`.`cedula`='$_SESSION[cedulamod]' LIMIT 1";
                //die($sql2);
		@mysql_query($sql2);		
			$sqql = "SELECT * FROM personalactivo WHERE cedula LIKE '$_SESSION[cedulamod]' ";
			$result= mysql_query($sqql);
			
		break;
		endswitch;
		
		$mostrar[1]="apellidos";
		$mostrar[2]="nombre";
		$otrasent="AND `personalactivo`.`activo`=1 AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'";
		$cadena=selection("personalactivo","cedula","%",$mostrar,$_SESSION[cedulamod],2,"apellidos",$otrasent);
		
		$r=@require('version.php');
		caracteresiso();
	
$coltabla="#35d199"
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
<body>
		<form method="post" action="verificacion3.php">
 		<table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
                <td align="right"  width="50%">Hoja de vida:<input type="checkbox"  tabindex="2"
			 <?php
			 if (@mysql_result($result,$_SESSION['i'],"hv")==1){
			 echo "checked";	
			 } 
			 ?> name="hv"></td>
	 		<td rowspan="6"align="center">Observaciones<br><textarea name="observacionesver" id="sqlquery" cols="20" rows="7" dir="ltr"><?php  echo @mysql_result($result,$_SESSION['i'],"observacionesver");?></textarea>
		</tr>
		<tr> 
  			<td align="right">Fotocopia cedula:<input type="checkbox"  tabindex="3" name="fc"
			<?php
			 if (@mysql_result($result,$_SESSION['i'],"fc")==1){
			 echo "checked";
			 } 
			 ?>></td>
     	</tr>
     	<tr>
  			<td align="right">Fotocopia libreta militar:
  			<input  type="checkbox"  tabindex="4"
			<?php
			 if (@mysql_result($result,$_SESSION['i'],"flb")==1){
			 echo "checked";	
			 } 
			 ?> name="flb"></td>
    	</tr>
	 		
	 	<tr style="border-width: thin ;"><!-- Row 4 -->
  			<td align="right">Fotocopia pasado judicial:<input type="checkbox"  tabindex="5"
			<?php
			 if (@mysql_result($result,$_SESSION['i'],"fpj")==1){
			 echo "checked";	
			 } 
			 ?> name="fpj"></td>
  		</tr>
  	 	<tr><!-- Row 6 -->
  			<td align="right">
      		Fotocopia certificaciones academicas:<input type="checkbox"  tabindex="5"
			 <?php
			 if (@mysql_result($result,$_SESSION['i'],"fca")==1){
			 echo "checked";	
			 } 
			 ?> name="fca"></td>
	    </tr>
	  	<tr><!-- Row 6 -->
  			<td align="right">Fotocopia recibo del agua: <input type="checkbox"  tabindex="6"
			 <?php
			 if (@mysql_result($result,$_SESSION['i'],"fra")==1){
			 echo "checked";	
			 } 
			 ?> name="fra"></td>
   		</tr>
	   	<tr><!-- Row 7 -->
			<td align="right">Recomendaciones laborales:<input type="checkbox"  tabindex="7"
			<?php
			 if (@mysql_result($result,$_SESSION['i'],"rl")==1){
			 echo "checked";	
			 } 
			 ?> name="rl"> </td>
     	</tr>
		<tr><!-- Row 8 -->
  			<td align="right">Recomendaciones personales:<input type="checkbox"  tabindex="8"
			<?php
			 if (@mysql_result($result,$_SESSION['i'],"rp")==1){
			 echo "checked";	
			 } 
			 ?> name="rp"></td>
   		</tr> 
  		<tr><!-- Row 11 -->
  			<td align="right">Certificacion residencia J.A.C.:<input type="checkbox"  name="cr" tabindex="9" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"cr")==1){
			 echo "checked";	
			 } 
			 ?>></td>
   		</tr>
 		<tr><!-- Row 7 -->
  			<td align="right">Verificacion de datos: <input type="checkbox"  name="vid" tabindex="10" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"vid")==1){
			 echo "checked";	
			 } 
			 ?>></td>
   		</tr>
 		<tr><!-- Row 11 -->
  			<td align="right">Entrevista y prueba tecnica:<input type="checkbox"  name="ept" tabindex="11"
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"ept")==1){
			 echo "checked";	
			 } 
			 ?>></td>
 		</tr>
 		<tr><!-- Row 11 -->
  			<td align="right">Entrevista y prueba psicologica:<input type="checkbox"  name="epps" tabindex="12" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"epps")==1){
			 echo "checked";	
			 } 
			 ?>></td>
 		</tr>
 		<tr><!-- Row 11 -->
  			<td align="right">Prueba psicologica:<input type="checkbox"  name="numcuenta" tabindex="12" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"numcuenta")==1){
			 echo "checked";	
			 } 
			 ?>></td>
 		</tr>
  	 	<tr><!-- Row 11 -->
  			<td align="right">Examen medico ocupacional:<input type="checkbox"  name="emo" tabindex="13" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"emo")==1){
			 echo "checked";	
			 } 
			 ?>></td>
	 		</tr>
 		<tr><!-- Row 6 -->
  			<td align="right">Induccion:<input type="checkbox"  name="ind" tabindex="14" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"ind")==1){
			 echo "checked";	
			 } 
			 ?>></td>
   		</tr>
 	 	<tr><!-- Row 6 -->
  			<td align="right">Visita domiciliaria:<input type="checkbox"  name="vd" tabindex="15" 
  			<?php
			 if (@mysql_result($result,$_SESSION['i'],"vd")==1){
			 echo "checked";	
			 } 
			 ?>></td>
   		</tr>
   		</table>
     		
     		</td></tr></table>
     		
		<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Verificacion Documental
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle" align="center">
 			<input type="submit" class="botobusca" value="Buscar" name="ejecut">
 			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="cedpersona" class="largo2" tabindex="1">
 	 		<?php echo $cadena;?></select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center" class="arriba">
			<input type="submit" class="botoactu" value="Actualizar" name="ejecut"/>
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
