/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

Ext.onReady(function(){

Ext.QuickTips.init();

Ext.get("mostrardiv").on('click', function(){
var estado=Ext.get("ocultarmostrar").dom.style.display;
if(estado=='none'){
Ext.get("ocultarmostrar").dom.style.display='block';
Ext.get("mostrardiv").dom.innerHTML='Ocultar Opcion de Agregar Personal';
Ext.get("search").dom.focus();
}else{
Ext.get("ocultarmostrar").dom.style.display='none';
Ext.get("mostrardiv").dom.innerHTML='Agregar Personal';
}
});

try{
var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'cedula', type: 'int'},
        {name: 'nombre', type: 'string'},
        {name: 'apellidos', type: 'string'},
        {name: 'telefono', type: 'int'},
        {name: 'celular', type: 'int'},
        {name: 'direccion', type: 'string'}
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

try{
var myStore = new Ext.data.Store({
// explicitly create reader
reader: myReader,
proxy: new Ext.data.HttpProxy({
    url: 'personalAjax.php',
    method: 'POST'
  }),
baseParams:{task: "BUSQUEDA", buscar: "%"},
sortInfo:{field: 'apellidos', direction: "ASC"}
});
}catch(er){
Ext.MessageBox.alert("atencion", "error 85:"+er);
}

try{
    // Custom rendering Template
    var resultTpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<h3><span>{cedula}</span></h3>',
            '<b>{apellidos} {nombre}</b>',
            '<div>{telefono} {celular} {direccion}</div>',
        '</div></tpl>'
    );
}catch(er){
Ext.MessageBox.alert("atencion", "error 98:"+er);
}

try{
    var search = new Ext.form.ComboBox({
        store: myStore,
        displayField:'nombre',
        typeAhead: false,
        loadingText: 'Cargando...', 
        width: 475,
        pageSize:20,
        hideTrigger:true,
        tpl: resultTpl,
        applyTo: 'search',
        itemSelector: 'div.search-item',
        onSelect: function(record){// override default onSelect to do redirect
        var tlin = Ext.get("tablaparagregar").dom;
        var oRow = tlin.insertRow(-1);
        //contenido de la fila
        oRow.innerHTML = '<td><a href="personalactivo3.php?ejecut=Buscar&criterio='+record.data.cedula+'&campobusqueda=cedula&opt=2">'+record.data.cedula + '</a>' +
        '</td><td>'+record.data.apellidos+ " "+ record.data.nombre+'</td><td><input name="cedula-'+record.data.cedula+'" id="cedula-'+record.data.cedula+'"'+
        'type="checkbox"></td><td>'+codclie34+'</td><td><select name="novedad-'+record.data.cedula+'" class="medio1" id="novedad-'+record.data.cedula+'"><option></option><option value="c">Cambio de Turno</option><option value="n">Cambio Permanente</option><option value="d">Descanso</option><option value="a">Abandono</option><option value="l">Licencia</option><option value="p">Permiso</option><option value="k">Vacaciones</option><option value="z">Dormido</option><option value="f">Inasistencia</option><option value="e">Enfermo</option><option value="y">Evadido</option><option value="x">Accidente</option><option value="w">Relevado</option><option value="v">Ebrio</option><option value="u">Hurto</option><option value="t">Otro</option><option value="s">Incapacidad</option><option value="m">Refuerzo</option><option value="r">Inicia Labor</option><option value="q">Ultimo Turno</option></select></td></td>';
        var numfilasac=matrizced.length;
        matrizced[numfilasac]=record.data.cedula;
        }
    });
}catch(er){
//Ext.MessageBox.alert("atencion", "error 135:"+er);
}

    // create the Grid

    try{
    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

    // sample static data for the store
    /*
    var myData = [
        ['3m Co',                               71.72, 0.02,  0.03,  '9/1 12:00am'],
        ['Alcoa Inc',                           29.01, 0.42,  1.47,  '9/1 12:00am'],
        ['Altria Group Inc',                    83.81, 0.28,  0.34,  '9/1 12:00am'],
        ['American Express Company',            52.55, 0.01,  0.02,  '9/1 12:00am'],
        ['American International Group, Inc.',  64.13, 0.31,  0.49,  '9/1 12:00am'],
        ['AT&T Inc.',                           31.61, -0.48, -1.54, '9/1 12:00am'],
        ['Boeing Co.',                          75.43, 0.53,  0.71,  '9/1 12:00am'],
        ['Caterpillar Inc.',                    67.27, 0.92,  1.39,  '9/1 12:00am'],
        ['Citigroup, Inc.',                     49.37, 0.02,  0.04,  '9/1 12:00am'],
        ['E.I. du Pont de Nemours and Company', 40.48, 0.51,  1.28,  '9/1 12:00am'],
        ['Exxon Mobil Corp',                    68.1,  -0.43, -0.64, '9/1 12:00am'],
        ['General Electric Company',            34.14, -0.08, -0.23, '9/1 12:00am'],
        ['General Motors Corporation',          30.27, 1.09,  3.74,  '9/1 12:00am'],
        ['Hewlett-Packard Co.',                 36.53, -0.03, -0.08, '9/1 12:00am'],
        ['Honeywell Intl Inc',                  38.77, 0.05,  0.13,  '9/1 12:00am'],
        ['Intel Corporation',                   19.88, 0.31,  1.58,  '9/1 12:00am'],
        ['International Business Machines',     81.41, 0.44,  0.54,  '9/1 12:00am'],
        ['Johnson & Johnson',                   64.72, 0.06,  0.09,  '9/1 12:00am'],
        ['JP Morgan & Chase & Co',              45.73, 0.07,  0.15,  '9/1 12:00am'],
        ['McDonald\'s Corporation',             36.76, 0.86,  2.40,  '9/1 12:00am'],
        ['Merck & Co., Inc.',                   40.96, 0.41,  1.01,  '9/1 12:00am'],
        ['Microsoft Corporation',               25.84, 0.14,  0.54,  '9/1 12:00am'],
        ['Pfizer Inc',                          27.96, 0.4,   1.45,  '9/1 12:00am'],
        ['The Coca-Cola Company',               45.07, 0.26,  0.58,  '9/1 12:00am'],
        ['The Home Depot, Inc.',                34.64, 0.35,  1.02,  '9/1 12:00am'],
        ['The Procter & Gamble Company',        61.91, 0.01,  0.02,  '9/1 12:00am'],
        ['United Technologies Corporation',     63.26, 0.55,  0.88,  '9/1 12:00am'],
        ['Verizon Communications',              35.57, 0.39,  1.11,  '9/1 12:00am'],
        ['Wal-Mart Stores, Inc.',               45.45, 0.73,  1.63,  '9/1 12:00am']
    ];
    */
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
     var ret="Usado";
     if(tipo==1){
     ret="Nuevo";
     }
     return ret;
    }

});

