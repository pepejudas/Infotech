/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){

 Ext.QuickTips.init();

 var xg = Ext.grid;

    var rt = Ext.data.Record.create([
        {name: 'fullname', type: 'string'},
        {name: 'documento', type: 'int'},
        {name: 'project', type: 'string'},
        {name: 'taskId', type: 'int'},
        {name: 'description', type: 'string'},
        {name: 'estimate', type: 'float'},
        {name: 'telefonos', type: 'string'},
        {name: 'observaciones', type: 'string'},
        {name: 'due', type: 'date', dateFormat:'Y-m-d H:i:s'}
    ]);

    var myReader = new Ext.data.JsonReader({
    // metadata configuration options:
    idProperty: 'id',
    root: 'datosjson',
    totalProperty: 'numfilas'
    // the fields config option will internally create an Ext.data.Record
    // constructor that provides mapping for reading the record data objects
    }, rt);

    var myStore = new Ext.data.GroupingStore({
    // explicitly create reader
    reader: myReader,
    proxy: new Ext.data.HttpProxy({
        url: 'reportarasistencia.php',
        method: 'POST'
      }),
    baseParams:{task: "LISTING", tipoturno: Ext.get('tipoturno').dom.value},
    sortInfo:{field: 'fullname', direction: "ASC"},
    groupField:'project'

    });

    // define a custom summary function
    //Ext.ux.grid.GroupSummary.Calculations['totalCost'] = function(v, record, field){
        //return v + (record.data.estimate * record.data.rate);
    //};

    // utilize custom extension for Group Summary
    //var summary = new Ext.ux.grid.GroupSummary();
    var tamLista=25;                                //tamaño de lista a mostrar en grid

    function renderPaciente(val) {
        return '<a href="personalactivo3.php?ejecut=Buscar&campobusqueda=cedula&criterio=' + val + '&opt=2">' + val  +'</a>';
    }

    var modeloCol=new xg.ColumnModel([
            {
                header: 'Documento',
                width: 20,
                sortable: true,
                dataIndex: 'documento',
                groupable : true,
                renderer: renderPaciente
            },{
                id: 'description',
                header: 'Apellidos y Nombres',
                width: 50,
                sortable: true,
                dataIndex: 'description',
                summaryType: 'count',
                hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Personas)' : '(1 Persona)');
                }
            },{
                header: 'Cliente',
                width: 10,
                sortable: true,
                dataIndex: 'project',
                groupable : true
            },{
                header: 'Fecha y Hora',
                width: 27,
                sortable: true,
                dataIndex: 'due',
                summaryType: 'max',
                renderer: Ext.util.Format.dateRenderer('Y-m-d H:i:s'),
                editor: new Ext.form.DateField({
                    format: 'Y-m-d H:i:s'
                })
            },{
                header: 'Minutos',
                width: 15,
                sortable: true,
                dataIndex: 'estimate',
                summaryType: 'sum',
                renderer : function(v){
                    return v +' Minutos';
                },
                editor: new Ext.form.NumberField({
                   allowBlank: true,
                   allowNegative: false,
                   style: 'text-align:left'
                })
            },{
                header: 'Telefonos',
                width: 20,
                sortable: true,
                dataIndex: 'telefonos',
                editor: new Ext.form.TextField({
                   allowBlank: true,
                   style: 'text-align:left'
                })
            },{
                id: 'observaciones',
                header: 'Observaciones',
                width: 55,
                sortable: false,
                editor: new Ext.form.TextField({
                   allowBlank: true,
                   style: 'text-align:left'
                }),
                dataIndex: 'observaciones'
            }
        ]);

function buscarDatos(textoBuscado){
    myStore.baseParams.task='BUSCAR';
    myStore.load({params:{start:0, limit:tamLista, textoBuscado: textoBuscado}});
}

var textoDefecto="Escriba el texto a buscar";

var tb = new Ext.Toolbar({
    items: [
        {
            xtype: 'tbsplit',
            text: 'Exportar Hoja Actual',
            menu: [{
                text: 'Formato Excel',
                onClick: function(){
                    try{
                    window.open("data:application/vnd.ms-excel;base64," +
                    Base64.encode(Ext.get('gridHtml').dom.innerHTML), "_blank");
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a excel',errorExcel);
                    }
                }
            },{
                text: 'Formato Word',
                onClick: function(){
                    try{
                    window.open("data:application/msword;base64," +
                    Base64.encode(Ext.get('gridHtml').dom.innerHTML), "_blank");
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a word',errorExcel);
                    }
                }
            },{
                text: 'Formato PDF',
                onClick: function(){
                    try{
                    peticionPDF();
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a PDF',errorExcel);
                    }
                }
            }]
        },
        // begin using the right-justified button container
        '->', // same as {xtype: 'tbfill'}, // Ext.Toolbar.Fill
        {
            xtype: 'button', // default for Toolbars, same as 'tbbutton'
            text: 'Buscar',
            onClick: function(){
            searchText = Ext.get('buscapaciente').getValue();
            
            if(searchText!=textoDefecto){
            buscarDatos(searchText);
            }
            }
        },
        {
            id: 'buscapaciente',
            xtype: 'textfield',
            name: 'field1',
            emptyText: textoDefecto
        }
    ]
});

// utilize custom extension for Group Summary
var summary = new Ext.ux.grid.GroupSummary();

    var grid = new xg.EditorGridPanel({
        id:'gridHtml',
        store: myStore,
        colModel: modeloCol,
        plugins: summary,
        view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
            enableGroupingMenu: true,
            hideGroupedColumn: true
        }),

        //plugins: summary,

        tbar : tb,
        frame: true,
        width: 800,
        height: 650,
        clicksToEdit: 2,
        collapsible: false,
        animCollapse: false,
        maximizable: true,
        trackMouseOver: false,
        enableColumnMove: true,
        title: 'Informe de Asistencia de Personal',
        iconCls: 'icon-grid',
        renderTo:'formRequisiciones'
    });

myStore.load();

Ext.get('botonbuscar').on('click', function(){
myStore.baseParams.tipoturno=Ext.get('tipoturno').dom.value;
myStore.load();
})

var el = Ext.get("insertarFrec");
var establecido=false;
var actauto=Ext.get('actauto');
var frecact=Ext.get('frecact');

var timer;
//evento boton actualizacion
actauto.on('click', function(){
if(establecido){
frecact.dom.disabled=true;
establecido=false;
clearInterval(timer);
}else{
frecact.dom.disabled=false;
establecido=true;
estableceTiempo();
}
});

frecact.on('change', function(){
//Ext.MessageBox.alert('buenas', 'ha cambiado el valor de combo');
estableceTiempo();
});

function estableceTiempo(){
clearInterval(timer);
timer=setInterval(function(){
myStore.load();
}, Ext.get('frecact').dom.value);
}

});

