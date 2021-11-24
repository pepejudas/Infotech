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
    applyTo: 'fechainiciolic', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Inicio Licencia de Funcionamiento',
    format: 'Y-m-d',
    showToday: false
});

var startdt4 = new Ext.form.DateField({
    applyTo: 'fechafinlic', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Licencia',
    format: 'Y-m-d',
    showToday: false
});

var startdt5 = new Ext.form.DateField({
    applyTo: 'fechaexpedicion', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Licencia',
    format: 'Y-m-d',
    showToday: false
});

var startdt6 = new Ext.form.DateField({
    applyTo: 'fechafija', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Licencia',
    format: 'Y-m-d',
    showToday: false
});

var startdt6w = new Ext.form.DateField({
    applyTo: 'fechamovil', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Licencia',
    format: 'Y-m-d',
    showToday: false
});

var startdt7 = new Ext.form.DateField({
    applyTo: 'fechaescolta', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Licencia',
    format: 'Y-m-d',
    showToday: false
});

var startdt8 = new Ext.form.DateField({
    applyTo: 'fechamediostec', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Licencia',
    format: 'Y-m-d',
    showToday: false
});

}catch(er){
  Ext.Msg.alert("Atencion", er);
}

});

