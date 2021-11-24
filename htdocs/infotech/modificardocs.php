<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 50);

		switch ($_POST[ejecut]):
		case "cargar":
			
			$_SESSION[cont]=$_POST[docum];
			$_SESSION[lis]=$_POST[li];
			$_SESSION['ord']=$_POST[orden];
			
		switch ($_SESSION['cont']):
 		case 1:
  		$nj='contrato1';
  		break;
  		case 3:
  		$nj='contrato2';
  		break;
  		case 6:
  		$nj='certificacion';
  		break;
  		case 7:
  		$nj='cartaapertura';
  		break;
  		case 8:
  		$nj='contrato3';
  		break;
  	 	default:
  		$nj='contrato1';
  	endswitch;
  	
                        $sql="SELECT * FROM parametros";
			$cons=@mysql_query($sql);
			$contrata=@mysql_result($cons,0,$nj);
			$_SESSION['i']=0;
                        //die($nj);
		break;
		case "actualizar":

                    $sql="SELECT * FROM parametros";
                    $cons=@mysql_query($sql);
                    $contrata=@mysql_result($cons,0,$nj);

                    $numf=@mysql_num_rows($cons);
                    
			switch ($_SESSION['cont']):
 			case 1:
  			$nj="contrato1";
  			break;
  			case 3:
  			$nj="contrato2";
  			break;
  			case 6:
  			$nj="certificacion";
  			break;
  			case 7:
  			$nj="cartaapertura";
  			break;
  			case 8:
  			$nj="contrato3";
  			break;
  	 		default:
  			$nj="contrato1";
  			endswitch;

                 if($numf>0){
                    $sql1="UPDATE `relacional`.`parametros` SET  `$nj`= '$_POST[$nj]' WHERE `parametros`.`id`=1 LIMIT 1 ";
                 }else{//no hay fila
                    $_POST[id]=1;
                    $mens.=armarEjecutarSentencia("parametros", $_POST, "insert", $_SESSION);
                 }
  		
                 $cons=@mysql_query($sql1);

                break;
		endswitch;

		
		if($_SESSION[cont]==""){$_SESSION[cont]=1;}
		
		$r=@require('version.php');
		caracteresiso();
		
$coltabla="#678811"
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
<form method="post" action="modificardocs.php">
 		<table class="tablaprinc"><tr><td>
 		<table>
	  	<tr>
	  		<td align="left">
			</td>
		</tr>
	  		  	
	  	<tr>
	  		<td align="left" width="80%">
	  		Texto del documento
			</td>
		</tr>
		
		<tr>
	  		<td align="left" width="50%">
			<textarea name="<?php echo $nj;?>" rows="30" cols="70" ><?php echo $contrata;?>
  			</textarea>
			</td>
			<td>
			
			</td>
		</tr>
		</table>
		</td></tr></table>
	 	
	 	<div id="controlex">
     		<table  class="control">
     		<tr><td colspan="2" class="arriba">
     		Modificaci&oacute;n de Documentos
     		</td>
     		</tr>
     		<tr height="10px" valign="top"><td valign="middle" align="center" colspan="2">
 			<input type="submit" class="botobusca" value="cargar" name="ejecut">
 			</td><td valign="middle">
 			
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<select name="docum" class="largo2" tabindex="39">
  	 		<option value="1" <?php  if ($_SESSION['cont']==1) {echo ('selected=""');}?>>Contrato por labor u obra</option>
	 		<option value="3" <?php if ($_SESSION['cont']==3) {echo ('selected=""');}?>>Contrato a termino fijo inferior a un a&ntilde;o</option>
	 		<option value="8" <?php if ($_SESSION['cont']==8) {echo ('selected=""');}?>>Contrato a termino fijo de uno a tres a&ntilde;os</option>
	 		<option value="6" <?php if ($_SESSION['cont']==6) {echo ('selected=""');}?>>Certificacion</option>
	 		<option value="7" <?php if ($_SESSION['cont']==7) {echo ('selected=""');}?>>Carta apertura de cuenta</option>
	 		</select>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center">
			<input type="submit" class="botoactu" value="actualizar" name="ejecut"/>
			</td></tr>
			<tr height="10px"><td colspan="2" align="center" class="arriba">
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
