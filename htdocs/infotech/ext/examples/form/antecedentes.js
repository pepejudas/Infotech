Ext.onReady(function(){
//
//Ext.QuickTips.init();
//
//var msg = function(title, msg) {
//Ext.Msg.show({
//title: title,
//msg: msg,
//minWidth: 200,
//modal: true,
//icon: Ext.Msg.INFO,
//buttons: Ext.Msg.OK
//});
//};
//var loginForm = new Ext.form.FormPanel({
//frame:true,
//labelWidth:160,
//defaults: {
//width: 165
//},
//items: [
//    {
//        xtype: 'combo',
//        id:'tipoid',
//        fieldLabel: 'Tipo de Documento',
//        hiddenName: 'tipoid',
//        emptyText: 'Seleccione...',
//        store:
//          new Ext.data.SimpleStore({
//            fields: ['displayText','myId'],
//            data: [[1, 'Cedula de Ciudadania'], [2, 'Nit'], [3, 'Pasaporte'], [4, 'Tarjeta de Identidad'], [5, 'Cedula de Extranjeria']]
//        }), // end of Ext.data.SimpleStore
//        displayField: 'myId',
//        valueField: 'displayText',
//        selectOnFocus: true,
//        mode: 'local',
//        typeAhead: true,
//        editable: false
//      },
//new Ext.form.TextField({
//id:"idnum",
//fieldLabel:"Numero de Documento",
//allowBlank:false
//})
//],
//buttons: [{
//text: 'Verificar',
//handler: function(){
//    loginForm.getForm().submit({
//        url: 'cargarantecedentes.php',
//        waitMsg: 'Verificando Antecedentes...',
//        success: function(loginForm, resp){
//            Ext.Msg.alert(resp.response.responseText);
//        }
//    });
//}
//}]
//});
//
//var loginWindow = new Ext.Window({
//layout: 'fit',
//height: 140,
//width: 460,
//closable: false,
//resizable: false,
//draggable: false,
//items: [loginForm]
//});
//
//loginWindow.show();

}); //end onReady