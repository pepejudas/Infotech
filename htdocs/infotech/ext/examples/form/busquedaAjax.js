/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

var boolvalidar = false;  //validacion de datos
var mododevolver=true;      //modo devolucion de elementos

Ext.onReady(function(){

//Ext.QuickTips.init();

try{
Ext.get("adevoluciones").on('click', function(){
devolverElementos();
});

Ext.get("formdotacion").dom.onsubmit = function(){
if(boolvalidar){
return verificarCantidades()
}
};

Ext.get("botobusca").on('click',function(){
boolvalidar=false;
});

Ext.get("btactualizar").on('click', function(){
boolvalidar=true;
});
}catch(er){
//Ext.MessageBox.alert("atencion", "error: 34"+er);
}

try{
var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'nombreprod', type: 'string'},
        {name: 'referencia', type: 'string'},
        {name: 'marca', type: 'string'},
        {name: 'modelo', type: 'string'},
        {name: 'tipoprod', type: 'int'},
        {name: 'disponuevo', type: 'int'},
        {name: 'dispousado', type: 'int'}
    ]);
}catch(er){
Ext.MessageBox.alert("atencion", "error 49:"+er);
}

try{
var myReader = new Ext.data.JsonReader({
// metadata configuration options:
idProperty: 'id',
root: 'datosjson',
totalProperty: 'numfilas'
// the fields config option will internally create an Ext.data.Record
// constructor that provides mapping for reading the record data objects
}, rt);
}catch(er){
Ext.MessageBox.alert("atencion", "error 62:"+er);
}

var valorbuscar="";

try{
  valorbuscar=Ext.get('search').dom.value;
}catch(er){

}

try{
var myStore = new Ext.data.Store({
// explicitly create reader
reader: myReader,
proxy: new Ext.data.HttpProxy({
    url: 'productosAjax.php',
    method: 'POST'
  }),
baseParams:{task: "BUSQUEDA", buscar: valorbuscar},
sortInfo:{field: 'nombreprod', direction: "ASC"}
});
}catch(er){
Ext.MessageBox.alert("atencion", "error 85:"+er);
}

try{
    // Custom rendering Template
    var resultTpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<h3><span>{nombreprod}</span>{referencia}</h3>',
            '{modelo} {marca}',
            '<div>Nuevo <b>{disponuevo}</b> Usado <b>{dispousado}</b></div>',
        '</div></tpl>'
    );
}catch(er){
Ext.MessageBox.alert("atencion", "error 98:"+er);
}

try{
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
        onSelect: function(record){// override default onSelect to do redirect
            //Ext.MessageBox.alert("atencion a seleccionado el producto: " + record.data.nombreprod + " referencia:"+record.data.referencia);
        var consum="No Consumible";
        if(record.data.tipoprod==2){
        consum="Consumible";
        }
        
        Ext.get('filaproductosentregar').dom.innerHTML+="<div id=\"eliminar-div-"+record.data.id+"\">Producto: <span id=\"etiqprod-"+record.data.id+"\">"+record.data.nombreprod+"</span><span style=\"float:right\"><a href=\"#\" onclick=\"cerrarDiv("+record.data.id+")\" id=\"eliminar-span\"><img src=\"imagenesnuevas/icono-cerrar.png\"></a></span><div>Referencia:"+record.data.referencia+"</div><div>Nuevo ("+record.data.disponuevo+"): <input name=\"idprodn-"+record.data.id+"\" id=\"idprodn-"+record.data.id+"\" onblur=\"verificarEntrega(this);\" style=\"width:20px\"> Usado ("+record.data.dispousado+"): <input name=\"idprodu-"+record.data.id+"\" id=\"idprodu-"+record.data.id+"\" style=\"width:20px\" onblur=\"verificarEntrega(this);\"> "+consum+"</div><hr/></div>";
        
        if(idprods==null){
        idprods=Array('f', record.data.id);
        prodnuevoexis=Array('f', record.data.disponuevo);
        produsadoexis=Array('f', record.data.dispousado);
        }else{
        var longitud=idprods.length;
        idprods[longitud]=record.data.id;
        prodnuevoexis[longitud]=record.data.disponuevo;
        produsadoexis[longitud]=record.data.dispousado;
        }
        }
    });
}catch(er){
//Ext.MessageBox.alert("atencion", "error 135:"+er);
}

    // create the Grid

    try{
    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
    }catch(er){
    Ext.MessageBox.alert("atencion", "error 180:"+er);
    }
    /**
     * Custom function used for column renderer
     * @param {Object} val
     */
    var cantentregado = 0;  //
    var tipoprod = 1;       //tipo no comsumible
    
    function change0(entregado) {
        if (entregado > 0) {
        cantentregado=entregado;
        }
        return entregado;
    }

    function change(entregado) {
        if (entregado == cantentregado) {
            return '<span style="color:green;">' + entregado + '</span>';
        }else{
            if(tipoprod==2){//es tipo de producto consumible por tanto no debe estar a paz y salvo
            return '<span style="color:green;">' + entregado + '</span>';
            }else{
            return '<span style="color:red;">' + entregado + '</span>';
            }
        }
        return entregado;
    }

    function rendTipo(tipo){
    tipoprod=tipo;
    var tiporet="No";
    
    if(tipo==2){
    tiporet="Si";
    }
    return tiporet;
    }

    function rendNou(tipo){
     var ret0="Usado";
     if(tipo==1){
     ret0="Nuevo";
     }
     return ret0;
    }

    function renderIdotacion(idotacion){
    return "<a href=\"entregadotacion.php?idotacion="+idotacion+"\" target=\"blank\">"+idotacion+"</a>";
    }

try{
    // create the data store
    var store = new Ext.data.ArrayStore({
        fields: [
           {name: 'id'},
           {name: 'nombreprod', type: 'string'},
           {name: 'iddot',     type: 'int'},
           {name: 'cantidad',  type: 'int'},
           {name: 'tipoprod', type: 'int'},
           {name: 'cantidadevuelta', type: 'int'},
           {name: 'nou', type: 'int'},
           {name: 'fechaent', type: 'date', dateFormat:'Y-m-d H:i:s'},
           {name: 'fechadev', type: 'date', dateFormat:'Y-m-d H:i:s'}
        ]
    });

    //manually load local data
    store.loadData(myData);

    // create the Grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        columns: [
            {
                id       :'id',
                header   : 'Id Producto',
                sortable : true,
                hidden : true,
                dataIndex: 'id'
            },
            {
                header   : 'Nombre Producto',
                sortable : true,
                dataIndex: 'nombreprod'
            },
            {
                header   : 'Consecutivo',
                width    : 35,
                sortable : true,
                dataIndex: 'iddot',
                renderer:renderIdotacion
            },
            {
                header   : 'Entregado',
                width    : 30,
                sortable : true,
                renderer : change0,
                dataIndex: 'cantidad'
            },
            {
                header   : 'Consumible',
                width    : 30,
                hidden : true,
                sortable : true,
                renderer : rendTipo,
                dataIndex: 'tipoprod'
            },
            {
                header   : 'Devuelto',
                width    : 25,
                sortable : true,
                renderer : change,
                dataIndex: 'cantidadevuelta'
            },
            {
                header   : 'Tipo',
                width    : 25,
                sortable : true,
                renderer : rendNou,
                dataIndex: 'nou'
            },
            {
                header   : 'Fecha Entrega',
                width    : 40,
                sortable : true,
                renderer : Ext.util.Format.dateRenderer('d/m/Y'),
                dataIndex: 'fechaent'
            },
            {
                header   : 'Fecha Retorno',
                width    : 40,
                sortable : true,
                renderer : Ext.util.Format.dateRenderer('d/m/Y'),
                dataIndex: 'fechadev'
            },
        ],
        stripeRows: false,
        autoExpandColumn: 'company',
        height: 300,
        width: 670,
        title: 'Resumen de Dotaciones ',
        // config options for stateful behavior
        stateful: false,
        collapsible: true,
        collapsed: true,
        stateId: 'grid',
        viewConfig: {
        forceFit:true
        }
    });
}catch(er){//lanzado cuando no hay dotaciones
//Ext.MessageBox.alert("atencion", "error 301:"+er);
}

try{
grid.render('grid-example');
}catch(er){//lanzado cuando no hay registros de dotaciones
//Ext.MessageBox.alert("atencion", "error 307:" + er);
}

});

