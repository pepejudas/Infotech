/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

Ext.onReady(function(){

Ext.QuickTips.init();

var startdt3 = new Ext.form.DateField({
    applyTo: 'vencecredsuperintendencia', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Vencimiento Credencial',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
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

var startdt5 = new Ext.form.DateField({
    applyTo: 'fechanacimiento', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Nacimiento',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt6 = new Ext.form.DateField({
    applyTo: 'vigenciacurso', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Vencimiento Curso',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt7 = new Ext.form.DateField({
    applyTo: 'epsfecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Radicado EPS',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});
var startdt8 = new Ext.form.DateField({
    applyTo: 'arpfecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Radicado ARP',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});
var startdt9 = new Ext.form.DateField({
    applyTo: 'afpfecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Radicado AFP',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt10 = new Ext.form.DateField({
    applyTo: 'fechaingreso', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Ingreso',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt11 = new Ext.form.DateField({
    applyTo: 'fincontrato', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Contrato',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

try{
Ext.get('coddeptonacim').on('change', function(){
Ext.Ajax.request({
   url: 'peticionesAjax.php',
   success: funcionBien,
   failure: funcionMal,
   params: {operacion:"CargarDeptos", departamento: Ext.get('coddeptonacim').dom.value}
});
});
}catch(er){

}
function funcionBien(retorno){
try{
var respuesta = eval(retorno.responseText);
var combo=Ext.get('codciudadnacim');
combo.dom.options.length=0; //eliminar opciones del combo actuales
var numciudades=respuesta.ciudades.length;
    for(var i=0;i<numciudades;i++){
    combo.dom.options[i]=new Option(respuesta.ciudades[i], respuesta.idciudades[i]);
    }
}catch(err){
Ext.MessageBox.alert('error','falla de comunicacion con el servidor:' + retorno.responseText);
}
}
function funcionMal(retorno){

}
});

