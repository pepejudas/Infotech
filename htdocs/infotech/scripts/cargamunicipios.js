/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.onReady(function(){
Ext.get('coddeptonacim').on('change', function(){
Ext.Ajax.request({
   url: 'peticionesAjax.php',
   success: funcionBien,
   failure: funcionMal,
   params: {operacion:"CargarDeptos", departamento: Ext.get('coddeptonacim').dom.value}
});
});

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
