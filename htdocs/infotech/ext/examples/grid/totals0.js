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
        {name: 'due', type: 'date', dateFormat:'d/m/Y'}
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
    baseParams:{task: "LISTING"},
    sortInfo:{field: 'fullname', direction: "ASC"},
    groupField:'project'

    });

    // define a custom summary function
    //Ext.ux.grid.GroupSummary.Calculations['totalCost'] = function(v, record, field){
        //return v + (record.data.estimate * record.data.rate);
    //};

    // utilize custom extension for Group Summary
    //var summary = new Ext.ux.grid.GroupSummary();

    var modeloCol=new xg.ColumnModel([
            {
                header: 'projectId',
                width: 17,
                sortable: true,
                dataIndex: 'projectId',
                groupable : true
            },{
                header: 'Documento',
                width: 10,
                sortable: true,
                dataIndex: 'documento',
                groupable : true
            },{
                header: 'Cliente',
                width: 10,
                sortable: true,
                dataIndex: 'project',
                groupable : true
            },{
                header: 'TaskId',
                width: 10,
                sortable: true,
                dataIndex: 'taskId',
                groupable : true
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
                width: 45,
                sortable: false,
                editor: new Ext.form.TextField({
                   allowBlank: true,
                   style: 'text-align:left'
                }),
                dataIndex: 'observaciones'
            },{
                header: 'Fecha y Hora',
                width: 27,
                sortable: true,
                dataIndex: 'due',
                summaryType: 'max',
                renderer: Ext.util.Format.dateRenderer('d/m/Y h:m:s'),
                editor: new Ext.form.DateField({
                    format: 'd/m/Y'
                })
            }
        ]);

var tb = new Ext.Toolbar({
    items: [
        {
            xtype: 'button', // default for Toolbars, same as 'tbbutton'
            text: 'Ocultar Resumen'
        },{
            xtype: 'tbsplit',
            text: 'Opciones',
            menu: [{
                text: 'Opcion 1'
            },{
                text: 'Opcion 2'
            },{
                text: 'Opcion 3'
            }]
        },
        // begin using the right-justified button container
        '->', // same as {xtype: 'tbfill'}, // Ext.Toolbar.Fill
        {
            xtype: 'button', // default for Toolbars, same as 'tbbutton'
            text: 'Buscar'
        },
        {
            xtype: 'textfield',
            name: 'field1',
            emptyText: 'enter search term'
        }
    ]
});

    var grid = new xg.EditorGridPanel({
        store: myStore,
        colModel: modeloCol,

        view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
            enableGroupingMenu: true,
            hideGroupedColumn: false
        }),

        //plugins: summary,

        tbar : tb,

        frame: true,
        width: 800,
        height: 650,
        clicksToEdit: 1,
        collapsible: false,
        animCollapse: false,
        trackMouseOver: false,
        enableColumnMove: true,
        title: 'Informe de Asistencia de Personal',
        iconCls: 'icon-grid',
        renderTo: document.body
    });

myStore.load();

Ext.get('botonbuscar').on('click', function(){
    
    Ext.Ajax.request(
        { //ajax request configuration  
        waitMsg: 'Esperando Respuesta',
        url: 'reportarasistencia.php', //url to server side script
        params: { //these will be available via $_POST or $_REQUEST:
        task: "LISTING" //pass task to do to the server script
        //key: primaryKey,//pass to server same 'id' that the reader used
        //keyID: checkID,//for existing records this is the unique id (we need this one to relate to the db)
        //newRecord: isNewRecord,//pass the new Record status indicator to server for special handling
        //field: myField,//the column name
        //value: checkBoolean,//the updated value
        //originalValue: !checkBoolean//the original value (oGrid_Event.orginalValue does not work for some reason)
        },//end params
        failure:function(response, options){
        Ext.MessageBox.alert('Warning','Oops...');
        },//end failure block                                      
        success:function(response, options){
        var responseData = Ext.util.JSON.decode(response.responseText);
        Ext.MessageBox.alert('Success','Yeah...'+responseData.datosjson.toSource());
        
        try{
        Pacientestore.loadData(responseData.datosjson);
        }catch(e){
        alert(e);
        }
        }
        });
})
});

// set up namespace for application

// store dummy data in the app namespace
