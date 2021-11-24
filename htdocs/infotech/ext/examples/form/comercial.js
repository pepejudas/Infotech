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
    applyTo: 'fechasolicitud', // <-- here you say where it must be rendered
    format: 'Y-m-d',
    showToday: false
});

var startdt4 = new Ext.form.DateField({
    applyTo: 'fechaentrega', // <-- here you say where it must be rendered
    format: 'Y-m-d',
    showToday: false
});

var startdt5 = new Ext.form.DateField({
    applyTo: 'fechaverifica', // <-- here you say where it must be rendered
    format: 'Y-m-d',
    showToday: false
});

}catch(er){
  Ext.Msg.alert("Atencion", er);
}

});

