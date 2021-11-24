<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 36);

		$reg=0;
		$cadena="";
		$cad =$_POST[cedpersona];
		$array = explode (" ", $cad);
		
		formularioactual();

		switch ($_POST[ejecut]){
		case "Buscar":
			$_SESSION['i']=0;
			$_SESSION['datos'][campobusqueda]="$_POST[busc]";
			$_SESSION['datos'][crito]="$_POST[crit]";
			$_SESSION['datos'][opcion]="1";
			$_SESSION['datos'][claveprinc]="numorden";
			break;
		case ">>":
			if($_SESSION[i]<$_SESSION[numreg]-1){$_SESSION[i]++;}
		break;
		case "<<":
		if($_SESSION[i]>0){$_SESSION[i]--;}
		break;
		case ">||":
			$_SESSION[i]=$_SESSION[numreg]-1;
		break;
		case "||<":
			$_SESSION['i']=0;
		break;
		case "Nuevo":
			$_SESSION['i']=$_SESSION['numreg'];
									
			$result2=operaciones("ordenes","buscar",$_SESSION[datos]);
			$result=$result2[datos];	

			$_SESSION[cedulamod]="";
			$_SESSION[cedulamod1]="";	
			$_SESSION[clientemodi]="";
			
			$boton=1;

                        $mostra[1]="cedula";
                        $mostra[2]="apellidos";
                        $mostra[3]="nombre";
                        $otras="AND `personalactivo`.`activo` = '1' AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'";
                        $cadena1='<select name="cedpersona2" class="superextralargo1"><option value="">seleccionar</option>'.selection("personalactivo","cedula","%",$mostra,$_SESSION[cedulamod1],3,"apellidos",$otras).'</select>';

                        $mostra[3]="cedula";
                        $mostra[1]="apellidos";
                        $mostra[2]="nombre";
                        $otras="AND `personalactivo`.`activo` = '1' AND `personalactivo`.`sucursal` LIKE '$_SESSION[sucur]'";
                        $cadena='<select name="cedpersona1" class="superextralargo1"><option value="">seleccionar</option>'.selection("personalactivo","cedula","%",$mostra,$_SESSION[cedulamod],3,"personalactivo`.`activo` DESC, `personalactivo`.`apellidos",$otras).'</select>';

		break;
		case "Ingresar":
		if($_POST[motivo]!="m"){$pers2=$_POST[cedpersona2];}else{$pers2=13;}
		  if ($_POST[cedpersona1]!="" and $pers2!="" and $_POST[cliepresenta]!="" and $_POST[diapartir]!="" and $_POST[mespartir]!="" and $_POST[anopartir]!="" and $_POST[diahasta]!="" and $_POST[motivo]!="" and $_POST[turnos]!="" and $_POST[diaonoche]!=""){
			$cedpersona1=$_POST[cedpersona1];			
			$cedpersona2=$_POST[cedpersona2];
			$cliepresenta=$_POST[cliepresenta];
			$fechaq=$_POST[anopartir]."-".$_POST[mespartir]."-".$_POST[diapartir];
			$sql = "INSERT INTO ordenes (cedremplazado, cedremplazo, codcliente, fecha, diascal, motivo, turnos, ingreso, fechaactual, diaonoche, descripcion, sucursal) VALUES ('$cedpersona1', '$cedpersona2', '$cliepresenta', '$fechaq', '$_POST[diahasta]', '$_POST[motivo]', '$_POST[turnos]', '$_SESSION[persona]', NOW(),'$_POST[diaonoche]', '$_POST[descripcion]', '$_SESSION[sucur]')";
			$xcon =@mysql_query($sql) or $mens=@mysql_error();
			if($xcon){
				
				if($_POST[motivo]=="n"){
					$sql2="UPDATE `personalactivo` SET codigo='$cliepresenta' WHERE `personalactivo`.`cedula`=$cedpersona1";
					$consu=@mysql_query($sql2) or $mens=@mysql_error();
				}
                                $motivorden=$_POST[motivo];

				if($motivorden!=""){//efectuar actualizaciones de control de servicios de personas que seran reemplazadas por cualquier razon
				$mesacedula2=convertirmesaced2($_POST[mespartir], $_POST[anopartir]);
				$mesbcedula2=convertirmesbced2($_POST[mespartir], $_POST[anopartir]);
				
				$consultamesa="SELECT * FROM `controlturnos` WHERE `controlturnos`.`mescontrol` = '$mesacedula2' and `controlturnos`.`cedulacontrol` = '$cedpersona2'";
				$consultamesb="SELECT * FROM `controlturnos` WHERE `controlturnos`.`mescontrol` = '$mesbcedula2' and `controlturnos`.`cedulacontrol` = '$cedpersona2'";
				
				$fechac2=$_POST[diapartir]."-".$_POST[mespartir]."-".$_POST[anopartir];
				$retcambiar2mese=cambiar2meses($fechac2, $_POST["diahasta"]);
				$cambiar2mes=$retcambiar2mese["cambia"];
				if($_POST["diaonoche"]==1){$donum="d";}else{$donum="n";}
			
				if($cambiar2mes=="si"){
				$contar=$_POST[diapartir];
					
				for($contar;$contar<=$retcambiar2mese["ultimodiames1"];$contar++){//para el mes 1
					$consultacona=@mysql_query($consultamesa) or $mens=@mysql_error();
					
						if(@mysql_result($consultacona,0,"cedulacontrol")!="0"){
						$ida=@mysql_result($consultacona,0,"id");	
						$sq1="UPDATE controlturnos SET `$donum$contar`='$motivorden', `cod$contar`='$_POST[cliepresenta]', `reg$contar`='$_SESSION[persona]' WHERE id='$ida'";
						}else{
						$sq1="INSERT INTO controlturnos (`fecharegistro`,`cedulacontrol`,`mescontrol`,`$donum$contar`, `cod$contar`, `reg$contar`) VALUES (NOW(),'$cedpersona2','$mesacedula2','$motivorden','$_POST[cliepresenta]','$_SESSION[persona]')";
						}
						@mysql_query($sq1) or $mens=@mysql_error();
					}
					
				for($conti=1;$conti<=$retcambiar2mese["ultimodiames2"];$conti++){//para el mes 2
					$consultaconb=@mysql_query($consultamesb) or $mens=@mysql_error();
					
						if(@mysql_result($consultaconb,0,"cedulacontrol")!="0"){
						$idb=@mysql_result($consultaconb,0,"id");	
						$sq1="UPDATE controlturnos SET `$donum$conti`='$motivorden', `cod$conti`='$_POST[cliepresenta]', `reg$conti`='$_SESSION[persona]' WHERE id='$idb'";
						}else{
						$sq1="INSERT INTO controlturnos (`fecharegistro`,`cedulacontrol`,`mescontrol`,`$donum$conti`, `cod$conti`, `reg$conti`) VALUES (NOW(),'$cedpersona2','$mesbcedula2','$motivorden','$_POST[cliepresenta]','$_SESSION[persona]')";
						}
						@mysql_query($sq1) or $mens=@mysql_error();
					}	
					
				}else{
				
				$contar=$_POST[diapartir];
				$fin=$contar+$_POST[diahasta]-1;
					
				for($contar;$contar<=$fin;$contar++){//para el mes 1
					$consultacona=@mysql_query($consultamesa) or $mens=@mysql_error();
					
						if(@mysql_result($consultacona,0,"cedulacontrol")!="0"){
						$ida=@mysql_result($consultacona,0,"id");	
						$sq1="UPDATE controlturnos SET `$donum$contar`='$motivorden', `cod$contar`='$_POST[cliepresenta]', `reg$contar`='$_SESSION[persona]' WHERE id='$ida'";
						@mysql_query($sq1) or $mens=@mysql_error();
						}else{
						$sq1="INSERT INTO controlturnos (`fecharegistro`,`cedulacontrol`,`mescontrol`,`$donum$contar`, `cod$contar`, `reg$contar`) VALUES (NOW(),'$cedpersona2','$mesacedula2','$motivorden','$_POST[cliepresenta]','$_SESSION[persona]')";
						@mysql_query($sq1) or $mens=@mysql_error();	
						}
					}
				}
					
				}
			}
		  }else{
		  	$mens='Atencion debe ingresar todos los campos requeridos marcados con asterisco';
		  	}
		  
			$_SESSION[cedulamod]="";
			$_SESSION[cedulamod1]="";	
			$_SESSION[clientemodi]="";
		break;
	}


                        $result2=operaciones("ordenes","buscar",$_SESSION['datos']);
                        $result=$result2[datos];
                        
                        $_SESSION[cedulamod]=@mysql_result($result,$_SESSION['i'],cedremplazado);
			$_SESSION[codmod]=@mysql_result($result,$_SESSION['i'],numorden);
			$_SESSION[cedulamod1]=@mysql_result($result,$_SESSION['i'],cedremplazo);
			$_SESSION[clientemodi]=@mysql_result($result,$_SESSION['i'],codcliente);
			$fecha=explode("-", @mysql_result($result, $_SESSION['i'], fecha));
			$dia=$fecha[2];
			$mes=$fecha[1];
			$ano=$fecha[0];
			$diascal=@mysql_result($result,$_SESSION['i'],diascal);
			$motivo=@mysql_result($result,$_SESSION['i'],motivo);
			$turnos=@mysql_result($result,$_SESSION['i'],turnos);
			$ingreso=@mysql_result($result,$_SESSION['i'],ingreso);
			$fechaing=@mysql_result($result,$_SESSION['i'],fechaactual);
			$diaonoche=@mysql_result($result,$_SESSION['i'],diaonoche);
                        $descripcion=@mysql_result($result,$_SESSION['i'],descripcion);

			$ingreso=@mysql_result($result,$_SESSION['i'],ingreso);
			$fechaing=@mysql_result($result,$_SESSION['i'],fechaactual);

                        if($_POST['ejecut']!="Nuevo"){
                        $consultaPacientes="SELECT CONCAT(tablaremplazado.cedula, ' ', tablaremplazado.apellidos, ' ', tablaremplazado.nombre) as remplazado,
                            CONCAT(tablaremplazo.cedula, ' ', tablaremplazo.apellidos, ' ', tablaremplazo.nombre) as remplazo
                            FROM personalactivo as tablaremplazado LEFT JOIN ordenes ON ordenes.cedremplazado=tablaremplazado.cedula 
                            LEFT JOIN personalactivo as tablaremplazo ON ordenes.cedremplazo=tablaremplazo.cedula WHERE ordenes.numorden='".$_SESSION['codmod']."' LIMIT 1";

                        $respaC=@mysql_query($consultaPacientes) or $mens=@mysql_error();
                        $cadena='<input value="'.@mysql_result($respaC,0, 'remplazado').'"  class="extralargo"/>';
                        $cadena1='<input value="'.@mysql_result($respaC,0, 'remplazo').'"  class="extralargo"/>';
                        }
                        
		$mostra[1]="codigo";
		$mostra[2]="nombrecliente";
		$otras="AND `clientes`.`activo`=1 AND `clientes`.`sucursal` LIKE '$_SESSION[sucur]' AND `clientes`.`clierelevante`='0'";
		$cadenaclie=selection("clientes","codigo","%",$mostra,$_SESSION[clientemodi],2,"codigo",$otras);

		$fecha1=getdate(time());

		$r=@require('version.php');
		caracteresiso();

		$coltabla="#11ffaa"
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

</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
	<form method="post" action="<?php echo $PHP_SELF?>" name="ordenes" onsubmit="return validagregaorden(boolvalidar);">
 	<table class="tablaprinc">
 	<tr><td>
		<table>
		<tr>
		<td align="right">
		Orden de Servicio:</td><td><input style="text-align:right" class="largo"
			  value="<?php if (!$result){/*echo "inserte";*/}else{  echo @mysql_result($result,$_SESSION['i'],"numorden");}
			  ?>" name="codigo" readonly>
		</td>
		
		</tr>
		<tr>
  			<td  align="right">
  			*Motivo de la Orden:</td><td><select name="motivo" class="largo1">
                         <?php echo obtenerNovedades($motivo);?>
			</select>
  			</td>
  		</tr>
	  	<tr>
	 		<td align="right" width="30%">
			*Ejecutante:</td><td>
 	 		<?php echo $cadena;?>
			</td>
		</tr>
 		<tr>
  			<td align="right">*Reemplazado:</td><td>
 	 		<?php echo $cadena1;?>
			</td>
  		</tr>
  		
  		<tr>
  			<td align="right">
   			*Cliente:</td><td>
			<select name="cliepresenta" class="superextralargo1">
  	 		<option value="">seleccionar</option>
 	 		<?php echo $cadenaclie;?></select>
			</td>
     	</tr>

		<tr>
  			<td align="right">*A partir del:</td><td>
			<select name="diapartir" class="corto1">
			<option></option>
			<option <?php if ($dia==1){echo 'selected=""';}?>>1</option>
			<option <?php if ($dia==2){echo 'selected=""';}?>>2</option>
			<option <?php if ($dia==3){echo 'selected=""';}?>>3</option>
			<option <?php if ($dia==4){echo 'selected=""';}?>>4</option>
			<option <?php if ($dia==5){echo 'selected=""';}?>>5</option>
			<option <?php if ($dia==6){echo 'selected=""';}?>>6</option>
			<option <?php if ($dia==7){echo 'selected=""';}?>>7</option>
			<option <?php if ($dia==8){echo 'selected=""';}?>>8</option>
			<option <?php if ($dia==9){echo 'selected=""';}?>>9</option>
			<option <?php if ($dia==10){echo 'selected=""';}?>>10</option>
			<option <?php if ($dia==11){echo 'selected=""';}?>>11</option>
			<option <?php if ($dia==12){echo 'selected=""';}?>>12</option>
			<option <?php if ($dia==13){echo 'selected=""';}?>>13</option>
			<option <?php if ($dia==14){echo 'selected=""';}?>>14</option>
			<option <?php if ($dia==15){echo 'selected=""';}?>>15</option>
			<option <?php if ($dia==16){echo 'selected=""';}?>>16</option>
			<option <?php if ($dia==17){echo 'selected=""';}?>>17</option>
			<option <?php if ($dia==18){echo 'selected=""';}?>>18</option>
			<option <?php if ($dia==19){echo 'selected=""';}?>>19</option>
			<option <?php if ($dia==20){echo 'selected=""';}?>>20</option>
			<option <?php if ($dia==21){echo 'selected=""';}?>>21</option>
			<option <?php if ($dia==22){echo 'selected=""';}?>>22</option>
			<option <?php if ($dia==23){echo 'selected=""';}?>>23</option>
			<option <?php if ($dia==24){echo 'selected=""';}?>>24</option>
			<option <?php if ($dia==25){echo 'selected=""';}?>>25</option>
			<option <?php if ($dia==26){echo 'selected=""';}?>>26</option>
			<option <?php if ($dia==27){echo 'selected=""';}?>>27</option>
			<option <?php if ($dia==28){echo 'selected=""';}?>>28</option>
			<option <?php if ($dia==29){echo 'selected=""';}?>>29</option>
			<option <?php if ($dia==30){echo 'selected=""';}?>>30</option>
			<option <?php if ($dia==31){echo 'selected=""';}?>>31</option>
			</select>
			<select name="mespartir" class="medio1">
			<option></option>
			<option value="1"<?php if ($mes==1){echo 'selected=""';}?>>Enero</option>
			<option value="2" <?php if ($mes==2){echo 'selected=""';}?>>Febrero</option>
			<option value="3" <?php if ($mes==3){echo 'selected=""';}?>>Marzo</option>
			<option value="4" <?php if ($mes==4){echo 'selected=""';}?>>Abril</option>
			<option value="5" <?php if ($mes==5){echo 'selected=""';}?>>Mayo</option>
			<option value="6" <?php if ($mes==6){echo 'selected=""';}?>>Junio</option>
			<option value="7" <?php if ($mes==7){echo 'selected=""';}?>>Julio</option>
			<option value="8" <?php if ($mes==8){echo 'selected=""';}?>>Agosto</option>
			<option value="9" <?php if ($mes==9){echo 'selected=""';}?>>Septiembre</option>
			<option value="10" <?php if ($mes==10){echo 'selected=""';}?>>Octubre</option>
			<option value="11" <?php if ($mes==11){echo 'selected=""';}?>>Noviembre</option>
			<option value="12" <?php if ($mes==12){echo 'selected=""';}?>>Diciembre</option>
			</select>
			<select name="anopartir" class="corto1">
			<option></option>
			<option <?php if ($ano==$fecha1[year]+1){echo 'selected=""';}?>><?php $e=$fecha1[year]+1; echo $e;?></option>
			<option <?php if ($ano==$fecha1[year]){echo 'selected=""';}?>><?php $e=$fecha1[year]; echo $e;?></option>
			<option <?php if ($ano==$fecha1[year]-1){echo 'selected=""';}?>><?php $e=$fecha1[year]-1; echo $e;?></option>
			</select>
			</td>
		</tr>
		
		<tr>
			<td align="right">
			*Dias:</td><td>
			<select name="diahasta" class="medio1">
			<option></option>
			<option <?php if($diascal==1){echo 'selected=""';}?>>1</option>
			<option <?php if($diascal==2){echo 'selected=""';}?>>2</option>
			<option <?php if($diascal==3){echo 'selected=""';}?>>3</option>
			<option <?php if($diascal==4){echo 'selected=""';}?>>4</option>
			<option <?php if($diascal==5){echo 'selected=""';}?>>5</option>
			<option <?php if($diascal==6){echo 'selected=""';}?>>6</option>
			<option <?php if($diascal==7){echo 'selected=""';}?>>7</option>
			<option <?php if($diascal==8){echo 'selected=""';}?>>8</option>
			<option <?php if($diascal==9){echo 'selected=""';}?>>9</option>
			<option <?php if($diascal==10){echo 'selected=""';}?>>10</option>
			<option <?php if($diascal==11){echo 'selected=""';}?>>11</option>
			<option <?php if($diascal==12){echo 'selected=""';}?>>12</option>
			<option <?php if($diascal==13){echo 'selected=""';}?>>13</option>
			<option <?php if($diascal==14){echo 'selected=""';}?>>14</option>
			<option <?php if($diascal==15){echo 'selected=""';}?>>15</option>
			<option value="999" <?php if($diascal==999){echo 'selected=""';}?>>Indefinidamente</option>
			</select>
			</td>
		</tr>
   		<tr>
			<td align="right">
			*Diurno o Nocturno:</td><td><select name="diaonoche" class="medio1">
			<option></option>
			<option value="1" <?php if($diaonoche==1){echo 'selected=""';}?>>Diurno</option>
			<option value="2" <?php if($diaonoche==2){echo 'selected=""';}?>>Nocturno</option>
			</select>
			</td>
		</tr>	
		<tr>
			<td align="right">	
			*Turno:</td><td><select name="turnos" class="medio1">
			<option></option>
			<option value="1" <?php if($turnos==1){echo 'selected=""';}?>>1 hora</option>
			<option value="2" <?php if($turnos==2){echo 'selected=""';}?>>2 horas</option>
			<option value="3" <?php if($turnos==3){echo 'selected=""';}?>>3 horas</option>
			<option value="4" <?php if($turnos==4){echo 'selected=""';}?>>4 horas</option>
			<option value="5" <?php if($turnos==5){echo 'selected=""';}?>>5 horas</option>
			<option value="6" <?php if($turnos==6){echo 'selected=""';}?>>6 horas</option>
			<option value="7" <?php if($turnos==7){echo 'selected=""';}?>>7 horas</option>
			<option value="8" <?php if($turnos==8){echo 'selected=""';}?>>8 horas</option>
			<option value="9" <?php if($turnos==9){echo 'selected=""';}?>>9 horas</option>
			<option value="10" <?php if($turnos==10){echo 'selected=""';}?>>10 horas</option>
			<option value="11" <?php if($turnos==11){echo 'selected=""';}?>>11 horas</option>
			<option value="12" <?php if($turnos==12){echo 'selected=""';}?>>12 horas</option>
			<option value="13" <?php if($turnos==13){echo 'selected=""';}?>>13 horas</option>
			<option value="14" <?php if($turnos==14){echo 'selected=""';}?>>14 horas</option>
			<option value="15" <?php if($turnos==15){echo 'selected=""';}?>>15 horas</option>
			<option value="16" <?php if($turnos==16){echo 'selected=""';}?>>16 horas</option>
			<option value="17" <?php if($turnos==17){echo 'selected=""';}?>>17 horas</option>
			<option value="18" <?php if($turnos==18){echo 'selected=""';}?>>18 horas</option>
			<option value="19" <?php if($turnos==19){echo 'selected=""';}?>>19 horas</option>
			<option value="20" <?php if($turnos==20){echo 'selected=""';}?>>20 horas</option>
			<option value="21" <?php if($turnos==21){echo 'selected=""';}?>>21 horas</option>
			<option value="22" <?php if($turnos==22){echo 'selected=""';}?>>22 horas</option>
			<option value="23" <?php if($turnos==23){echo 'selected=""';}?>>23 horas</option>
			<option value="24" <?php if($turnos==24){echo 'selected=""';}?>>24 horas</option>
			</select></td>
		</tr>
		<tr>    
			<td align="right" colspan="2">
                        <textarea rows="10" cols="55" name="descripcion"><?php echo $descripcion;?></textarea>
			</td>
 		</tr>
 		
     	<tr>
			<td align="right" colspan="2">
			<?php
			if($ingreso){echo $ingreso;}
			if($fechaing){echo " ".$fechaing."";}
			?>
			</td>     		
		</tr>
		</table> 
     	</td></tr></table>	
                <div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Ordenes de Servicio
     		</td>
     		</tr>
     		<tr height="10px" align="center">
		<td align="right"  width="100" valign="middle"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" onmousedown="boolvalidar=false;"
			onkeydown="boolvalidar=false;"></td>
		<td align="left"><input type="text" name="crit"
			style="width:110px;margin-left:5px" class="busqueda" /></td>
                </tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="busc" class="largo2">
 	 		<option value="numorden">Numero Orden de Servicio</option>
			<option value="cedremplazado">Cedula del que remplaza</option>
			<option value="cedremplazo">Cedula del remplazado</option>
			<option value="codcliente">Codigo del cliente</option>
			<option value="fecha">Fecha de inicio</option>
 	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botopri" value="||<" name="ejecut">
			<input type="submit" class="botoant" value="<<" name="ejecut">
			<input type="submit" class="botosig" value=">>" name="ejecut">
			<input type="submit" class="botoult" value=">||" name="ejecut">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botonuev" value="Nuevo" name="ejecut">
			<input type="submit" class="botoing" value="Ingresar" <?php if($boton==0){echo "disabled";}?> name="ejecut" onmousedown="boolvalidar=true;" onkeydown="boolvalidar=true;"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center" class="arriba">
			</td></tr>
			<tr height="10px"><td colspan="2" align="center"><?php if ($_SESSION['numreg']!=""){$p=$_SESSION['i']+1; print "Orden $p de $_SESSION[numreg]";} ?>
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
