/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

Ext.onReady(function(){

Ext.QuickTips.init();

try{
var startdt3 = new Ext.form.DateField({
    applyTo: 'fechainiciocontrato', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Inicio Contrato',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt4 = new Ext.form.DateField({
    applyTo: 'fechafincontrato', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion del Contrato',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

}catch(er){
  Ext.Msg.alert("Atencion", er);
}

});

