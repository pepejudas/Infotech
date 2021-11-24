<?php
/*
 * Created on 22/04/2007
 *ingeniero: Ferley Ardila Caicedo
 */
session_start();

@require('funciones2.php');

validar("","","", 1052);

$sql="SELECT * FROM personalactivo ORDER BY apellidos ASC";
$sql2="SELECT * FROM armas";
$sql3="SELECT * FROM clientes WHERE `clientes`.`svysp` = 1 ORDER BY nombrecliente";
$sql4="SELECT * FROM socios WHERE `socios`.`svysp` = 1 ORDER BY apellidos"; 
$consulta=@mysql_query($sql);
$consulta2=@mysql_query($sql2);
$consulta3=@mysql_query($sql3);
$consulta4=@mysql_query($sql4);
$lip=@mysql_num_rows($consulta);
$lia=@mysql_num_rows($consulta2);
$licl=@mysql_num_rows($consulta3);
$lis=@mysql_num_rows($consulta4);

$r=0;
$pat="AP_SUPER.txt";
$ar=fopen($pat, 'w+');

function completar($arg1){
$car1=strlen($arg1);
for($r=1;$r+$car1<1026;$r++){
$completa.=" ";	
}
return $completa;
}
 	
function gorros($tex,$fin){
$a=strlen($tex);
	if($a<=$fin){
		for($j=0;$j+$a<$fin;$j++){
		$ret.="^";	
		}
	}else{
		$tex="";	
		for($j=0;$j<$fin;$j++){
		$ret.="^";	
		}	
	}
return $ret.$tex;
}

function vuelta($t){
$cd=explode("-",$t);
$f=$cd[2]."/".$cd[1]."/".$cd[0];	
return $f;
}
//grupo 0
$sql="SELECT * FROM seguridadsuper";
$con1=@mysql_query($sql);

//normalizar nit
$cad=@mysql_result($con1, 0, nit);
$nit=gorros($cad,12);

//normalizar fecha del reporte
$fe=getdate(time());

if(strlen($fe[mday])==1){
	$dia="0".$fe[mday];	
}else{$dia=$fe[mday];}

if(strlen($fe[mon])==1){
	$mes="0".$fe[mon];	
}else{$mes=$fe[mon];}

$fecha=$dia."/".$mes."/".$fe[year];

//normalizar codigo del servicio
$cad=@mysql_result($con1, 0, codigoservicio);
$codserv=gorros($cad,2);

//normalizar numero de la licencia
$cad=@mysql_result($con1, 0, numerolicencia);
$numlic=gorros($cad,8);

//normalizar fecha de inicio lic
$cad=@mysql_result($con1, 0, fechainiciolic);
$fechainilic=vuelta($cad);

//normalizar fecha fin llic
$cad=@mysql_result($con1, 0, fechafinlic);
$fechafinlic=vuelta($cad);


$grupo0="0".$nit.$fecha.$codserv.$numlic.$fechainilic.$fechafinlic;
$linea=$grupo0.completar($grupo0);
fwrite($ar,$linea);

$gr="1"."HOJAS DE VIDA";
$linea=$gr.completar($gr);
fwrite($ar,$linea);

//personas
while($r<$lip){

//grupo 1
$cad=@mysql_result($consulta, $r, cedula);
$cedula=gorros($cad,10);

//espacio para normalizar el nombre
$cad=@mysql_result($consulta, $r, nombre);
$nombre=gorros($cad,25);

//espacio para normalizar el apellido
$cad=@mysql_result($consulta, $r, apellidos);
$apellidos=gorros($cad,25);

//espacio para normalizar el sexo
$cad=@mysql_result($consulta, $r, sexo);
$sexo=gorros($cad,1);

//espacio para normalizar el rh
$cad=@mysql_result($consulta, $r, rh);
$rh=gorros($cad,1);

//espacio para normalizar el estadocivil
$cad=@mysql_result($consulta, $r, estadocivil);
$estadocivil=gorros($cad,1);

//espacio para normalizar el pasadojudicial
$cad=@mysql_result($consulta, $r, pasadojudicial);
$pasadojudicial=gorros($cad,10);

//espacio para normalizar vigencia pasadojudicial
$cad=@mysql_result($consulta, $r, vigenciapj);
$vigenciapj=vuelta($cad);

//espacio para normalizar la direccion
$cad=@mysql_result($consulta, $r, direccion);
$direccion=gorros($cad,45);

//espacio para normalizar el barrio
$cad=@mysql_result($consulta, $r, barrio);
$barrio=gorros($cad,40);

//espacio para normalizar el codiciudadres
$cad=@mysql_result($consulta, $r, codigoresidencia);
$ciudadres=gorros($cad,9);

//espacio para normalizar el telefono
$cad=@mysql_result($consulta, $r, telefono);
$telefono=gorros($cad,12);

//espacio para normalizar la fecha de nacimiento
$cad=@mysql_result($consulta, $r, fechanacimiento);
$fechanacim=vuelta($cad);

//espacio para normalizar ciudad de nacimiento
$cad=@mysql_result($consulta, $r, codciudadnacim);
$ciudadnacim=gorros($cad,9);

//espacio para normalizar departamento de nacimiento
$cad=@mysql_result($consulta, $r, coddeptonacim);
$deptonacim=gorros($cad,9);

//espacio para normalizar el oficio tramitecredencial
$cad=@mysql_result($consulta, $r, oficiotramitecred);
$oficio=gorros($cad,10);

//espacio para normalizar el codigonivelvig
$cad=@mysql_result($consulta, $r, codnivelvig);
$codnivel=gorros($cad,2);

//espacio para normalizar fecha de vigencia curso
$cad=@mysql_result($consulta, $r, vigenciacurso);
$vigenciacurso=vuelta($cad);

//espacio para normalizar numero de hijos
$cad=@mysql_result($consulta, $r, numhijos);
$hijos=gorros($cad,2);

//espacio para normalizar la eps
$cad=@mysql_result($consulta, $r, eps);
$eps=gorros($cad,4);

//espacio para normalizar el apr
$cad=@mysql_result($consulta, $r, arp);
$arp=gorros($cad,4);

//espacio para normalizar el afp
$cad=@mysql_result($consulta, $r, afp);
$afp=gorros($cad,4);

//espacio para normalizar libreta
$cad=@mysql_result($consulta, $r, rangomilitar);
$libreta=gorros($cad,2);

//espacio para normalizar cred superintendencia
$cad=@mysql_result($consulta, $r, credsuperintendencia);
$cred=gorros($cad,10);

//espacio para normalizar fecha vence cred
$cad=@mysql_result($consulta, $r, vencecredsuperintendencia);
$vencecred=vuelta($cad);

//espacio para cargar el salario minimo
$sql1="SELECT salariominimo FROM parametros";
$con=@mysql_query($sql1);
$salario=@mysql_result($con,0,salariominimo)."00";
$salariomin=gorros($salario,10);

$grupo1="1".$cedula.$nombre.$apellidos.$sexo.$rh.$estadocivil.$pasadojudicial.$vigenciapj.$direccion.$barrio.$ciudadres.$telefono.$fechanacim.$ciudadnacim.$deptonacim.$oficio.$codnivel.$vigenciacurso.$hijos.$eps.$arp.$afp.$libreta.$cred.$vencecred.$salariomin;
$linea=$grupo1.completar($grupo1);
fwrite($ar,$linea);
$r++;
}
//grupo 4 de armas
$r=0;

$gr="4"."ARMAMENTO";
$linea=$gr.completar($gr);
fwrite($ar,$linea);

while($r<$lia){
//espacio para normalizar cred superintendencia
$cad=@mysql_result($consulta2, $r, serial);
$serial=gorros($cad,20);

//espacio para normalizar tipo de aarma
$cad=@mysql_result($consulta2, $r, tipoarma);
$tipoarma=gorros($cad,15);

//espacio para normalizar cred superintendencia
$cad=@mysql_result($consulta2, $r, marca);
$marca=gorros($cad,20);

//espacio para normalizar el calibre
$cad=@mysql_result($consulta2, $r, calibre);
$cal=gorros($cad,3);

//espacio para normalizar clase permiso
$cad=@mysql_result($consulta2, $r, clasepermiso);
$perm=gorros($cad,7);

$grupo4="4".$serial.$tipoarma.$marca.$cal.$perm;
$linea=$grupo4.completar($grupo4);
fwrite($ar,$linea);
$r++;	
}
//grupo 5 de clientes
$r=0;

$gr="5"."CLIENTES";
$linea=$gr.completar($gr);
fwrite($ar,$linea);

//CLIENTES
while($r<$licl){
	
//espacio para normalizar el nit del cliente
$cad=@mysql_result($consulta3, $r, nit);
$nit=gorros($cad,12);	

//espacio para normalizar el nombre del cliente
$cad=@mysql_result($consulta3, $r, nombrecliente);
$nombrec=gorros($cad,40);	

//espacio para normalizar direccion
$cad=@mysql_result($consulta3, $r, direccion);
$direc=gorros($cad,40);

//espacio para normalizar telefono
$cad=@mysql_result($consulta3, $r, telefono);
$telc=gorros($cad,12);

//espacio para normalizar valor cobrado
$cad=@mysql_result($consulta3, $r, valormensualcontrato);
$val=gorros($cad,12);

//espacio para normalizar numero de frentes
$cad=@mysql_result($consulta3, $r, numeroporterias);
$port=gorros($cad,3);
	
$grupo5="5".$nit.$nombrec.$direc.$telc.$val.$port;
$linea=$grupo5.completar($grupo5);
fwrite($ar,$linea);
$r++;	
}

//grupo a de socios
$r=0;

$gr="A"."SOCIOS";
$linea=$gr.completar($gr);
fwrite($ar,$linea);

//SOCIOS
while($r<$lis){
	
//espacio para normalizar el nit del cliente
$cad=@mysql_result($consulta4, $r, cedula);
$ceds=gorros($cad,10);	

//espacio para normalizar nombre
$cad=@mysql_result($consulta4, $r, nombres);
$noms=gorros($cad,25);

//espacio para normalizar apellidos
$cad=@mysql_result($consulta4, $r, apellidos);
$apes=gorros($cad,25);

//espacio para normalizar el sexo
$cad=@mysql_result($consulta4, $r, sexo);
$ses=gorros($cad,1);
	
//espacio para normalizar direccion
$cad=@mysql_result($consulta4, $r, direccion);
$dirs=gorros($cad,45);

//espacio para normalizar el telefono
$cad=@mysql_result($consulta4, $r, telefono);
$tels=gorros($cad,12);

//espacio para normalizar ciudad
$cad=@mysql_result($consulta4, $r, ciudadresidencia);
$cius=gorros($cad,9);

//espacio para normalizar el departamento
$cad=@mysql_result($consulta4, $r, deptoresidencia);
$deps=gorros($cad,9);

//espacio para normalizar el rango militar
$cad=@mysql_result($consulta4, $r, rangomilitar);
$rans=gorros($cad,2);

//espacio para normalizar profesion
$cad=@mysql_result($consulta4, $r, profesion);
$pros=gorros($cad,20);
	
$grupoa="A".$ceds.$noms.$apes.$ses.$dirs.$tels.$cius.$deps.$rans.$pros;
$linea=$grupoa.completar($grupoa);
fwrite($ar,$linea);
$r++;	
}


fclose($ar);

echo "<br><br><h3>INFORME CREADO EXITOSAMENTE, UBICADO EN LA CARPETA $pat </h3><br>";
echo "<h5>INFOTECH by Xsite Company</h5>"
?>