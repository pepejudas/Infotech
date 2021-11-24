/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function verificarCantidades(){//verifique que la devolucion es menor al total de productos asignados para cada producto
for(var i=1;i<regtabladotanuevo.length;i++){
try{
var nombrecontroln="idprodevn-"+regtabladotanuevo[i];
var nombrecontrolu="idprodevu-"+regtabladotausado[i];

var controln=document.getElementById(nombrecontroln);
var controlu=document.getElementById(nombrecontrolu);

var nombreprod=document.getElementById("etiqprod-"+idprods[i]).innerHTML;

try{
//checkear nuevo
if(controln.value > cantprodnuevo[i]){
    Ext.MessageBox.confirm("Atenci&oacute;n", "<p>Esta tratando de registrar la devoluci&oacute;n de " + controln.value + " unidades de " + nombreprod + " y solo se han entregado " + cantprodnuevo[i]
            + " en dotaci&oacute;n<\/p>Para establecer al numero de unidades maximas permitidas presione \"Yes\", si desea modificar manualmente presione \"No\"",
        function(returnvalue) {
          if (returnvalue=="yes") {
            controln.value=cantprodnuevo[i];
          }else{
              controln.focus();
          }
        }
  );
return false;
}else if(controln.value < cantprodnuevodevuelto[i]){
Ext.MessageBox.confirm("Atenci&oacute;n", "<p>No puede ingresar una cantidad menor de unidades devueltas de " + nombreprod + " ("+controln.value+")<br/>a las previamente registradas ("+cantprodnuevodevuelto[i]+")<br\/> debe sumarlas ("+(parseInt(controln.value)+parseInt(cantprodnuevodevuelto[i]))+")<\/p>" +
        "Para establecer al numero de unidades devueltas a ("+(parseInt(cantprodnuevodevuelto[i])+parseInt(controln.value))+"), presione \"Yes\", si desea modificar manualmente presione \"No\"",
        function(returnvalue) {
          if (returnvalue=="yes") {
            controln.value=parseInt(cantprodnuevodevuelto[i])+parseInt(controln.value);
          }else{
            controln.focus();
          }
        }
);
return false;
}
}catch(err){
Ext.MessageBox.alert("atencion", "error:"+err);
}
try{
//checkear usado
if(controlu.value > cantprodusado[i]){
  Ext.MessageBox.confirm("Atenci&oacute;n", "<p>Esta tratando de registrar la devoluci&oacute;n de " + controlu.value + " unidades de " + nombreprod + " y solo se han entregado " + cantprodusado[i]
            + " en dotaci&oacute;n<\/p>Para establecer al numero de unidades maximas permitidas presione \"Yes\", si desea modificar manualmente presione \"No\"",
        function(returnvalue) {
          if (returnvalue=="yes") {
            controlu.value=cantprodusado[i];
          }else{
            controlu.focus();
          }
        }
  );
return false;
}else if(controlu.value < cantprodusadodevuelto[i]){
Ext.MessageBox.confirm("Atenci&oacute;n", "<p>No puede ingresar una cantidad menor de unidades devueltas de " + nombreprod + " ("+controlu.value+")<br\/>a las previamente registradas ("+cantprodusadodevuelto[i]+")<br\/> debe sumarlas ("+(parseInt(controlu.value)+parseInt(cantprodusadodevuelto[i]))+")<\/p>" +
        "Para establecer al numero de unidades devueltas a ("+(parseInt(cantprodusadodevuelto[i])+parseInt(controlu.value))+"), presione \"Yes\", si desea modificar manualmente presione \"No\"",
        function(returnvalue) {
          if (returnvalue=="yes") {
            controlu.value=parseInt(cantprodusadodevuelto[i])+parseInt(controlu.value);
          }else{
            controlu.focus();
          }
        }
);
return false;
}
}catch(err){
//Ext.MessageBox.alert("atencion", "error:"+err);
}
}catch(er){
Ext.MessageBox.alert("atencion", "error:"+er);
}
}
}

function deshabnoudev(control, controldesactivar){
if(control!="noudevn-" && control!="noudevu-"){
var estado=document.getElementById(control).disabled;

if(estado){
    document.getElementById(control).disabled=false;
}else{
    document.getElementById(control).disabled=true;
}
}else{
Ext.MessageBox.alert("Atencion", "No puede Efectuar devolucion de este producto porque no ha sido entregado dentro de la dotaci&oacute;n.");
controldesactivar.checked=false;
}
}

function validarcontrol(ctrl){
    if(ctrl.id=="idprodevn-" || ctrl.id=="idprodevu-"){
    Ext.MessageBox.alert("Atencion", "No puede Efectuar devoluciones de este producto porque no ha sido entregado en la dotaci&oacute;n");
    ctrl.value="";
    }
}

function verificarEntrega(ctrl){
try{
var idctrlprod=ctrl.id;
var nombre=idctrlprod.split("-", -1);
    idctrlprod=nombre[1];
var indiceprod;
var saldo;
var tipo;

if(idctrlprod>=0){
for(i=1;i<idprods.length;i++){
if(idprods[i]==idctrlprod){
indiceprod=i;
break;
}
}

if(nombre[0]=="idprodn"){//buscar en array de nuevo
saldo=prodnuevoexis[indiceprod];
tipo="Nuevo";
}else if(nombre[0]=="idprodu"){//buscar en array de usados
saldo=produsadoexis[indiceprod];
tipo="Usado";
}

//verificar la existencia de producto antes de enviar el formulario
if(saldo<ctrl.value){
Ext.MessageBox.confirm("Atenci&oacute;n", "<p>No hay Suficiente inventario de "+Ext.get('etiqprod-'+idctrlprod).dom.innerHTML+" "+tipo+".<p>Disponible: "+saldo+"<\/p><p>Para establecel al maximo de unidades presione \"Yes\", para modificar manualmente presione \"No\"",
    function(returnvalue) {
          if (returnvalue=="yes") {
            ctrl.value=saldo;
          }else{
            ctrl.focus();
          }
        }

);
}

}
}catch(er){
 Ext.MessageBox.alert("Atencion", er);
}
}

function ventana(){
var ventana = window.open("devoluciones.php","Imagen","width=600px,height=600px,menubar=0,scrollbars=1");
}

function devolverElementos(){
try{
//Ext.MessageBox.alert("Atencion", "entra a devolver elementos");

var matrizetiqdev=document.getElementsByClassName("unidadesdev");

for(var ini=0;ini<matrizetiqdev.length;ini++){
if(mododevolver){
matrizetiqdev[ini].innerHTML="&nbsp;Unidades Devueltas: ";
}else{
matrizetiqdev[ini].innerHTML="&nbsp;Unidades: ";
}
}

var matrizelementos=document.getElementsByClassName("ocultar");

for(ini=0;ini<matrizelementos.length;ini++){
if(mododevolver){
matrizelementos[ini].style.display='none';
}else{
matrizelementos[ini].style.display='inline';
}

if(ini+1==matrizelementos.length){
    if(mododevolver){
    mododevolver=false;
    document.getElementById("filaproductos").align="left";
    document.getElementById("adevoluciones").innerHTML='<blink>Modo Devoluci&oacute;n Activo<\/blink>';
    document.getElementById("btactualizar").style.display='inline';
    }else{
    mododevolver=true;
    document.getElementById("filaproductos").align="right";
    document.getElementById("adevoluciones").innerHTML="Habilitar Devoluci&oacute;n";
    document.getElementById("btactualizar").style.display='none';
    }
}
}
var matrizelementosm=document.getElementsByClassName("mostrar");

for(ini=0;ini<matrizelementosm.length;ini++){
if(mododevolver){
matrizelementosm[ini].style.display='none';
}else{
matrizelementosm[ini].style.display='inline';
}
}
}catch(er){
Ext.MessageBox.alert("Atencion", er);
}
}

function mensajeini(msginicio){
Ext.MessageBox.alert("Atenci&oacute;n", msginicio);
}

function cerrarDiv(idiv){
Ext.get('eliminar-div-'+idiv).remove();
}

