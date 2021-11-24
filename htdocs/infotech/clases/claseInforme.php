<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require("./dompdf/dompdf_config.inc.php");

class claseInforme{
public $orientacion;
public $tamano;
public $arrayCampos;        //contiene los campos en la forma tabla.campo
public $contenidoHTML;      //contiene el informe en formato html
public $numeroCampos;       //numero de campos a reemplazar en el informe html
public $idinforme;
public $clavePrim;          //nombre de campo de clave primaria a buscar, para generar informe individual ej:personalactivo.cedula
public $valorClavePrim;     //valor de clave primaria para generar informe individual ej:80989899
public $nombreInforme;      //nombre del informe generado si no establecido timestamp unix
public $formato;            //formato de guardado de informe en carpeta informes doc, xls, txt
public $error="";
public $tipo="individual";  //tipo de informe, por defecto individual
public $limiteRegistros;//numero de registros maximo a exportar en informe general por defecto

function claseInforme($orientacion, $tamano, $idinforme, $clavePrim, $valorClavePrim, $nombreInforme, $formato, $limiteRegistros){//constructor
$this->orientacion=$orientacion;
$this->tamano=$tamano;
$this->idinforme=$idinforme;
$this->clavePrim=$clavePrim;
$this->valorClavePrim=$valorClavePrim;
$this->nombreInforme=$nombreInforme;
$this->limiteRegistros=$limiteRegistros;
$this->formato=$formato;
$this->buscarInforme();
$this->buscarCampos();
$this->verificarTipo();
$this->guardarInforme();
//if($this->error==""){//si no hay errores ejecutar el informe
$this->enviarInforme();
}

function enviarInformeHTML2PDF(){
	try{
	if ( get_magic_quotes_gpc() ){
        $this->contenidoHTML = stripslashes($this->contenidoHTML);
    }
	 
    require_once(dirname(__FILE__).'/../html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->WriteHTML($this->contenidoHTML);
    $html2pdf->Output('example.pdf');
    
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}



function enviarInforme(){
     if ( get_magic_quotes_gpc() ){
        $this->contenidoHTML = stripslashes($this->contenidoHTML);
     }
     
  $dompdf = new DOMPDF();
  $dompdf->load_html($this->contenidoHTML);
  $dompdf->set_paper($this->tamano, $this->orientacion);
  $dompdf->render();

  if($this->nombreInforme==""){
  $nombreinf=time();
  }else{
  $nombreinf=$this->nombreInforme;
  }
  $stream = $dompdf->stream($nombreinf.".pdf");

  //exit(0);
}
function guardarInforme(){
try{

if($this->nombreInforme==""){
$date=time();
$archivo= "informes/informe".$date.".";
if(!isset($this->formato)){$archivo.="xls";}else{$archivo.=$this->formato;}//tipo de archivo por defecto para exportar informes xls excel
}else{
$archivo= "informes/".$this->nombreInforme.".";
if(!isset($this->formato)){$archivo.="xls";}else{$archivo.=$this->formato;}
}

$contenido= $this->contenidoHTML;

$fch= fopen($archivo, "w");
fwrite($fch, $contenido);
fclose($fch);

}catch(Exception $err){
$this->error.=$err;
}
}
function buscarInforme(){   //establece el informe en formato html
   try{
   if(!isset($this->idinforme)){throw "No hay idinfome asignado";}
   $sql="SELECT * FROM `informes` WHERE `informes`.`id`='$this->idinforme'";
   $res=@mysql_query($sql) or $this->error.=@mysql_error();
   $this->contenidoHTML=@mysql_result($res,0,"htmlinforme") or $this->error.=@mysql_error();
   $this->tipo=@mysql_result($res,0,"tipo");
   }catch(Exception $error){
   $this->error.=$error;
   }
}
function buscarCampos(){    //busca los campos registrados al crear el informe para ser reemplazados
   try{
   if(!isset($this->idinforme)){throw "No hay idinfome asignado";}
    $sql="SELECT * FROM `caminformes` WHERE `caminformes`.`idinforme`='$this->idinforme'";
    $res=@mysql_query($sql) or $this->error.=@mysql_error();
    $this->arrayCampos=$res;
   }catch(Exception $error){
   $this->error.=$error;
   }
}
function verificarTipo(){
if($this->tipo=="1"){       //informe individual
$this->contenidoHTML=$this->reemplazarCamposInd($this->contenidoHTML, $this->clavePrim, $this->valorClavePrim);
}else if($this->tipo=="2"){ //informe general
$this->contenidoHTML=$this->reemplazarCamposGen($this->contenidoHTML);
}

}
function reemplazarCamposInd($cadenaHTML, $clavePrim, $valorClavePrim){//recibe el informe en formato html con los campos sin remplazar y retorna el mismo con los campos listos
    try{
    $numcampos=@mysql_num_rows($this->arrayCampos);
    for($ini=0;$ini<$numcampos;$ini++){
       $camporemp=@mysql_result($this->arrayCampos,$ini,"nombrecampo");
       $tabla0=explode(".",$camporemp);
       $dato=$this->buscarDato($tabla0[0],$tabla0[1],$clavePrim, $valorClavePrim);
       $cadenaHTML=str_replace("~$camporemp~",$dato,$cadenaHTML);
    }
    return $cadenaHTML;
    }catch(Exception $err){
    $this->error.=$err;
    }
}
function reemplazarCamposGen($cadenaHTML){
    try{
    $numcampos=@mysql_num_rows($this->arrayCampos);
    $arrPartesInforme=explode("<tr>",$cadenaHTML);
    $numFilas=count($arrPartesInforme);
    $primeraParteInforme="";
    $camposIterados="";
    $pieInforme="";

    for($ini=0;$ini<$numFilas;$ini++){
        if($this->contieneCampos($arrPartesInforme[$ini])){
        $filaRpt0=explode("</tr>",$arrPartesInforme[$ini],2); //dividir en </tr>, en dos partes para eliminar contenido sobrante de fila a repetir
        $filaRpt1=$filaRpt0[0]."</tr>";
        $filaRpt2="<tr>".$filaRpt0[0]."</tr>";
        $pieInforme=$filaRpt0[1];
        //die(print_r($filaRpt0));

        $clave0=explode(".", $this->clavePrim);
        $claveprimaria=$clave0[1];
        $tablaclaveprim=$clave0[0];
        $sql="SELECT $claveprimaria FROM `$tablaclaveprim`";
        $res=@mysql_query($sql);
        $numf=@mysql_num_rows($res);
        
        if($numf>$this->limiteRegistros){$numf=$this->limiteRegistros;}//limitar la cantidad de registros a exportar

        for($i=0;$i<$numf;$i++){
        $valorClavePrim=@mysql_result($res,$i,$claveprimaria);
            if($i==0){//la primera fila tiene ya el tr al principio
            $camposIterados.=$this->reemplazarCamposInd($filaRpt1, $claveprimaria, $valorClavePrim);
            }else{
            $camposIterados.=$this->reemplazarCamposInd($filaRpt2, $claveprimaria, $valorClavePrim);
            }
        }
        
        return $primeraParteInforme.$camposIterados.$pieInforme;
        }else{//si no contiene los campos es porque esta al principio del informe
        $primeraParteInforme.=$arrPartesInforme[$ini]."<tr>";
        }
    }
    }catch(Exception $err){
    $this->error.=$err;
    }
}
function contieneCampos($filaTabla){//recibe una fila de la tabla si tiene los campos retorna true o falso en otro caso
$campos0=explode("~".@mysql_result($this->arrayCampos,0,"nombrecampo")."~", $filaTabla);//dividir la fila con el primer campo insertado en el informe
if(count($campos0)>1){
return true;
}else{
return false;
}
}
function buscarDato($tabla, $camporetornar, $claveprimaria, $valorclaveprimaria){//funcion para hacer el remplazo de cada campo busca el valor de la clave primaria
//claveprimaria esta en formato tabla.campo, para verificar la tablaa la que pertenece
try{
    $clave0=explode(".", $this->clavePrim);
    $claveprimaria=$clave0[1];
    $tablaclaveprim=$clave0[0];
    
    if($tabla==$tablaclaveprim){
    $sql="SELECT $camporetornar FROM `$tabla` WHERE `$tabla`.`$claveprimaria`='$valorclaveprimaria'";
    }else{
    $sql="SELECT $camporetornar FROM `$tabla` LIMIT 1";
    }

    $res=@mysql_query($sql) or $this->error.=@mysql_error();
    $dato=@mysql_result($res,0,$camporetornar) or $this->error.=@mysql_error();
    
    return decod($dato);
}catch(Exception $err){
    $this->error.=$err;
}
}
}

?>
