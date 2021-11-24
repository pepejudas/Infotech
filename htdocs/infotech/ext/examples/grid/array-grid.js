/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){
    Ext.QuickTips.init();

    // NOTE: This is an example showing simple state management. During development,
    // it is generally best to disable state management as dynamically-generated ids
    // can change across page loads, leading to unpredictable results.  The developer
    // should ensure that stable state ids are set for stateful components in real apps.    

    var rt = Ext.data.Record.create([
        {name: 'fullname', type: 'string'},
        {name: 'first', type: 'int'},
        {name: 'documento', type: 'string'},
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

    var myStore = new Ext.data.Store({
    // explicitly create reader
    reader: myReader,
    proxy: new Ext.data.HttpProxy({
        url: 'reportarasistencia.php',
        method: 'POST'
      }),
    baseParams:{task: "LISTING"}
    });
    

    // create the Grid
    var grid = new Ext.grid.EditorGridPanel({
    store: myStore,
    colModel: new Ext.grid.ColumnModel({
        defaults: {
            width: 120,
            sortable: true
        },
        columns: [
            {id: 'company', header: 'Company', width: 200, sortable: true},
            {header: 'Fullname', dataIndex: 'fullname'},
            {header: 'First', dataIndex: 'first'},
            {header: 'Documento', dataIndex: 'documento'},
            {header: 'Fecha Ingreso', dataIndex: 'due'}
        ]
    }),
    tbar : [{
            text: 'Eliminar Resumen',
            tooltip: 'Elimina las Filas de Resumen por Cliente',
            handler: function(){summary.toggleSummaries();}
    }],
    width: 700,
    height: 600,
    frame: true,
    title: 'Framed with Row Selection and Horizontal Scrolling',
    iconCls: 'icon-grid'
    });

    // render the grid to the specified div in the page
    grid.render('grid-example');

    grid.getStore().load();
});