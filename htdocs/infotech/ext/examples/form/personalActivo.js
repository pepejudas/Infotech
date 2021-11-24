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
    applyTo: 'vencecredsuperintendencia', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Vencimiento Credencial',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt4 = new Ext.form.DateField({
    applyTo: 'vigenciapj', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Vencimiento Pasado Judicial',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt5 = new Ext.form.DateField({
    applyTo: 'fechanacimiento', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Nacimiento',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt6 = new Ext.form.DateField({
    applyTo: 'vigenciacurso', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Vencimiento Curso',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt7 = new Ext.form.DateField({
    applyTo: 'epsfecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Radicado EPS',
    format: 'Y-m-d',
    width:'80',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});
var startdt8 = new Ext.form.DateField({
    applyTo: 'arpfecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Radicado ARP',
    format: 'Y-m-d',
    width:'80',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});
var startdt9 = new Ext.form.DateField({
    applyTo: 'afpfecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Radicado AFP',
    width:'80',
    format: 'Y-m-d',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt10 = new Ext.form.DateField({
    applyTo: 'fechaingreso', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Ingreso',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt11 = new Ext.form.DateField({
    applyTo: 'fincontrato', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Finalizacion de Contrato',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

var startdt12 = new Ext.form.DateField({
    applyTo: 'cajafecha', // <-- here you say where it must be rendered
    fieldLabel: 'Fecha de Afiliacion CCF',
    format: 'Y-m-d',
    width:'180',
    endDateField: 'enddt', // id of the end date field
    showToday: false
});

}catch(er){

}

try{

Ext.get('enviarComunicado').on('click', function(){

var formPanelCreaOrden =  {
                        xtype       : 'form',
                        id          : 'formpanelOrdenes',
                        //params  : {operacion:'email'},
                        border : false,
                        defaultType : 'field',
                        method: 'POST',
                        frame       : true,
                        items       : [
                        {xtype: 'field',fieldLabel: 'Email', value:Ext.get('email').dom.value, id:'email2', name:'email2'},
                        {xtype: 'textarea',fieldLabel: 'Comunicado', id:'comunicado', width:'250', name:'comunicado'},
                        ],
                        buttons:[{
                                scope:this,
                                text: 'Aceptar',
                                handler: function(){
                                if(Ext.get('email2').getValue()!="" && Ext.get('comunicado').getValue()!=""){

                                 Ext.Ajax.request({
                                  waitMsg: 'Por favor Espere...',
                                  url: 'emailAjax.php',
                                  params: {
                                     operacion: "email",
                                     correo:Ext.getCmp('email2').getValue(),
                                     comunicado:Ext.getCmp('comunicado').getValue()
                                  },
                                  success: function(response){
                                      try{
                                        var respuesta = eval(response.responseText);
                                        if(respuesta.error){
                                        Ext.MessageBox.alert('error', respuesta.error);
                                        }
                                      }catch(err){
                                        Ext.MessageBox.alert('error','respuesta no es un objeto Json:' + response.responseText);
                                      }
                                  },
                                  failure: function(response){
                                     try{
                                      var respuesta = eval(response.responseText);
                                      Ext.MessageBox.alert('error','se ha presentado un error en el servidor:' + respuesta.error);
                                      }catch(err){
                                      Ext.MessageBox.alert('error','falla de comunicacion con el servidor:' + response.responseText);
                                      }
                                  }
                               });
                                
                                myWinReq.close();
                                }else{
                                    mensajeini('Debe ingresar el comunicado');
                                }

                                }
                                        },{
                                            formBind:true,
                                            text: 'Cancelar',
                                            onClick: function(){
                                            myWinReq.close();
                                            }
                                        }]
                    };

var myWinReq = new Ext.Window({
            id     : 'myWinReq',
            title       : 'Enviar Email',
            resizable:false,
            autoscroll:true,
            width:710,
            modal:true,
            closable:true,
            items  : [formPanelCreaOrden]
});

myWinReq.show();
});

Ext.get('capturaFoto').on('click', function(){
ventana3();
});

}catch(er){

}

function handleActivate(tab){
    if(tab.title=="Datos Basicos"){
    Ext.get('Datos Basicos').dom.style.display='block';
    Ext.get('Datos de Psicologia').dom.style.display='none';
    Ext.get('Nucleo Familiar').dom.style.display='none';
    }else if(tab.title=="Nucleo Familiar"){
    Ext.get('Datos Basicos').dom.style.display='none';
    Ext.get('Datos de Psicologia').dom.style.display='none';
    Ext.get('Nucleo Familiar').dom.style.display='block';
    }else if(tab.title=="Datos de Psicologia"){
    Ext.get('Datos Basicos').dom.style.display='none';
    Ext.get('Datos de Psicologia').dom.style.display='block';
    Ext.get('Nucleo Familiar').dom.style.display='none';
    }
}

try{
    var tabs = new Ext.TabPanel({
        width:650,
        style:'margin-left:300px',
        activeTab: 0,
        border:false,
        frame:true,
        defaults:{autoHeight: true},
        renderTo:'tabspersonal',
        items:[
            {title: 'Datos Basicos',
             html:'',
             id:'datosbasicos',
             listeners: {activate: handleActivate}},
            {title: 'Nucleo Familiar', id:'nucleofamiliar', html:'',listeners: {activate: handleActivate}},
            {title: 'Datos de Psicologia', id:'psicologia', html:'',listeners: {activate: handleActivate}}
        ]
    });
}catch(er){
    mensajeini("Error crea tabs");
}


});

