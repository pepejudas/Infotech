/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.onReady(function(){
try{

var xg = Ext.grid;
var deshabilita=true;
var tamLista=25;                                //tamaño de lista a mostrar en grid

// shared reader
    var reader = new Ext.data.ArrayReader({}, [
       {name: 'documento'},
       {name: 'nombre'},
       {name: 'apellidos'},
       {name: 'parentesco'},
       {name: 'fechanacimiento', type: 'date', dateFormat: 'n/j h:ia'}
    ]);

    var store = new Ext.data.GroupingStore({
            reader: reader,
            data: xg.dummyData,
            sortInfo:{field: 'documento', direction: "ASC"}
        });

var tbReq = new Ext.Toolbar({
    items: [
       {
            xtype: 'tbsplit',
            text: 'Exportar Hoja Actual',
            menu: [{
                text: 'Formato Excel',
                onClick: function(){
                    try{
                    window.open("data:application/vnd.ms-excel;base64," +
                    Base64.encode(Ext.get('gridHtmlReq').dom.innerHTML), "_blank");
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a excel',errorExcel);
                    }
                }
            },{
                text: 'Formato Word',
                onClick: function(){
                    try{
                    window.open("data:application/msword;base64," +
                    Base64.encode(Ext.get('gridHtmlReq').dom.innerHTML), "_blank");
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a word',errorExcel);
                    }
                }
            },{
                text: 'Formato PDF',
                onClick: function(){
                    try{
                    peticionPDF('gridHtmlReq');
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a PDF',errorExcel);
                    }
                }
            }]
        }
    ]
});

    var grid = new xg.GridPanel({
        store: store,
        id:'gridHtmlReq',
        tbar:tbReq,
        columns: [
            {id:'company',header: "Documento", sortable: true, dataIndex: 'documento'},
            {header: "Nombres", sortable: true, dataIndex: 'nombre'},
            {header: "Apellidos", sortable: true, dataIndex: 'apellidos'},
            {header: "Parentesco", sortable: true, dataIndex: 'parentesco'},
            {header: "Fecha Nacimiento", sortable: true, renderer: Ext.util.Format.dateRenderer('m/d/Y'), dataIndex: 'fechanacimiento'}
        ],

        frame:true,
        width: 700,
        height: 450,
        iconCls: 'icon-grid',
        renderTo:'Nucleo Familiar'
    });
    
}catch(er){
    mensajeini("Error grid nucleo Familiar "+er);
}
});