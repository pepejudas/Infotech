/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.onReady(function(){

var startdt3 = new Ext.form.DateField({
    applyTo: 'fechasolicitud', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de solicitud',
    name: 'startdt',
    format: 'Y-m-d',
    id: 'startdt',
    endDateField: 'enddt', // id of the end date field
    showToday: false,
    size:10
});

});

