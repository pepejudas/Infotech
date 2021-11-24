/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){

/*
    var ds = new Ext.data.Store({
        proxy: new Ext.data.ScriptTagProxy({
            url: rutaInfotech + 'productosAjax.php'
        }),
        reader: new Ext.data.JsonReader({
            root: 'datosjson',
            totalProperty: 'numfilas',
            id: 'id'
        }, [
            {name: 'nomreprod', mapping: 'topic_title'},
            {name: 'referencia', mapping: 'topic_id'},
            {name: 'marca', mapping: 'author'},
            {name: 'modelo', mapping: 'post_time', type: 'date', dateFormat: 'timestamp'},
            {name: 'disponuevo', mapping: 'dispo_nuevo'},
            {name: 'dispousado', mapping: 'dispo_usado'}
        ])
    });

*/

var rt = Ext.data.Record.create([
        {name: 'nombreprod', type: 'string'},
        {name: 'referencia', type: 'string'},
        {name: 'marca', type: 'string'},
        {name: 'modelo', type: 'string'},
        {name: 'disponuevo', type: 'int'},
        {name: 'dispousado', type: 'int'}
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
baseParams:{task: "LISTING", tipoturno: Ext.get('tipoturno').dom.value},
sortInfo:{field: 'fullname', direction: "ASC"}
});

    // Custom rendering Template
    var resultTpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<h3><span>{nombreprod}</span>{referencia}</h3>',
            '{modelo}',
        '</div></tpl>'
    );
    
    var search = new Ext.form.ComboBox({
        store: myStore,
        displayField:'nombreprod',
        typeAhead: false,
        loadingText: 'Cargando...',
        width: 275,
        pageSize:10,
        hideTrigger:true,
        tpl: resultTpl,
        applyTo: 'search',
        itemSelector: 'div.search-item',
        onSelect: function(record){ // override default onSelect to do redirect
            Ext.MessageBox.alert("atencion a seleccionado el producto: "+record.nombreprod);
        }
    });
});