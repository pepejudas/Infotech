/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
try{
Ext.onReady(function(){

 Ext.QuickTips.init();

 var xg = Ext.grid;
 var eventoGrid;

    var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'serialrequisicion', type: 'int'},
        {name: 'estado', type: 'int'},
        {name: 'nombreprod', type: 'string'},
        {name: 'fechareq', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'nombre', type: 'string'},
        {name: 'cantidad', type: 'int'},
        {name: 'cantidadisponible', type: 'int'},
        {name: 'nou', type: 'string'},
        {name: 'observaciones', type: 'string'}
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
        url: 'requisicionesAjax.php',
        method: 'POST'
      }),
    baseParams:{},
    sortInfo:{field: 'fechareq', direction: "ASC"},
    groupField:'nombre'
    });

    function renderPaciente(val) {
        return '<a href="personalactivo3.php?ejecut=Buscar&campobusqueda=cedula&criterio=' + val + '&opt=2">' + val  +'</a>';
    }
    function renderEstado(val){
        if(val==2){
            return "Aprobado";
        }else if(val==3){
            return "Rechazado";
        }else{//valor por defecto para las no revisadas
            return "";
        }
    }

    // create the combo instance
    var comboEstado = new Ext.form.ComboBox({
        typeAhead: true,
        triggerAction: 'all',
        lazyRender:true,
        autoScroll:true,
        mode: 'local',
        width:120,
        store: new Ext.data.ArrayStore({
            id: 0,
            fields: [
                'myId',
                'displayText'
            ],
            data: [[1, 'No Revisada'], [2, 'Aprobar'], [3, 'Rechazar'], [4, 'Aprobar Req'], [5, 'Rechaza Req'], [6, 'Eliminar'], [7, 'Eliminar Req']]
        }),
        valueField: 'myId',
        displayField: 'displayText'
    });

    // create the combo instance
    var comboTipo = new Ext.form.ComboBox({
        typeAhead: true,
        triggerAction: 'all',
        lazyRender:true,
        mode: 'local',
        width:120,
        store: new Ext.data.ArrayStore({
            id: 0,
            fields: [
                'myId',
                'displayText'
            ],
            data: [[1, 'Nuevo'], [2, 'Usado']]
        }),
        valueField: 'myId',
        displayField: 'displayText'
    });
function funcionNou(val){
                    if(val==1){
                        return "Nuevo";
                    }else{
                        return "Usado";
                    }
}

  //{id:'2', nou:'2', nombre: 'Infotech User Sistema', idreq: 1,
  //serialrequisicion: 1, estado: '1', fechareq: '2011-12-28 09:00:46', fechapre: '',
  //nombreprod: 'Camisa manga larga blanca ronaldo', cantidad:'2', cantidadisponible:'0', observaciones:''}

    var modeloCol=new xg.ColumnModel([
            {
                header: 'Requisicion',
                width: 15,
                sortable: true,
                dataIndex: 'serialrequisicion',
                renderer: function(val){//funcion para enviar de una al link del documento
                    return '<a href="requisicion.php?cedulamod='+val+'" target="blank">'+val+'</a>';
                }
            },{
                header: 'Estado',
                width: 18,
                sortable: true,
                dataIndex: 'estado',
                groupable : true,
                align: 'center',
                falseText: 'No',
                trueText: 'Si',
                editor: comboEstado,
                renderer: renderEstado
            },{
                header: 'Nombre del Producto',
                width: 50,
                sortable: true,
                dataIndex: 'nombreprod',
                summaryType: 'count',
                hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Productos)' : '(1 Producto)');
                }
            },{
                header: 'Fecha de Requisicion',
                dataIndex: 'fechareq',
                hidden:true
            },{
                header: 'Efectua Requisicion',
                dataIndex: 'nombre',
                hidden:true
            },{
                header: 'Unds',
                width: 10,
                sortable: true,
                dataIndex: 'cantidad',
                summaryType: 'sum',
                editor: new Ext.form.TextField({
                   allowBlank: true,
                   style: 'text-align:left'
                })
            },{
                header: 'Disponible',
                width: 12,
                sortable: true,
                dataIndex: 'cantidadisponible',
                hidden : true
            },{
                header: 'Tipo',
                width: 12,
                sortable: true,
                dataIndex: 'nou',
                groupable : true,
                editor:comboTipo,
                renderer: funcionNou
            },{
                id: 'observaciones',
                header: 'Observaciones',
                sortable: false,
                flex:'1',
                editor: new Ext.form.TextField({
                   allowBlank: true,
                   style: 'text-align:left'
                }),
                dataIndex: 'observaciones'
            }
        ]);

var textoDefecto="Texto a Buscar";
function ejecutarTodo(apruebaTODO){
    try{
        if(Ext.get('tiporeq').getValue()!="%"){
        valcomb="optiporeq"+Ext.get('tiporeq').getValue();
        }else{
        valcomb="optiporeq";
        }
        var selcomb=Ext.get(valcomb).dom.innerHTML;

        var opcion="";
        
        if(apruebaTODO){
            opcion="APROBARTODO";
        }else{
            opcion="RECHAZARTODO"
        }

        Ext.Msg.confirm("Atención", "Al confirmar modificara el estado de todas las requisiciones \"No revisadas\", incluyendo todas las que no aparecen en la hoja actual, desea continuar ", function(evt){
       if(evt=="yes"){
               Ext.Ajax.request({
                  waitMsg: 'Por favor Espere...',
                  url: 'requisicionesAjax.php',
                  params: {
                     task: opcion
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

                        myStore.commitChanges();   // changes successful, get rid of the red triangles
                        myStore.reload();          // reload our datastore.
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
       }
        });

    }catch(errorExcel){
        Ext.MessageBox.alert('error aprobando todo',errorExcel);
    }
}
var tb = new Ext.Toolbar({
    items: [
       {
            xtype: 'tbsplit',
            text: 'Acciones',
            menu: [{
                text: 'Aprobar Todo',
                onClick: function(){
                    ejecutarTodo(true);
                }
            },{
                text: 'Rechazar Todo',
                onClick: function(){
                    ejecutarTodo(false);
                }
            }]
        },'',{
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
                    peticionPDF('gridHtml');
                    }catch(errorExcel){
                    Ext.MessageBox.alert('error exportando a PDF',errorExcel);
                    }
                }
            }]
        },
        // begin using the right-justified button container
        {xtype:'tbfill'}, // same as {xtype: 'tbfill'}, // Ext.Toolbar.Fill
        {
            xtype: 'button', // default for Toolbars, same as 'tbbutton'
            text: 'Buscar',
            onClick: function(){
            buscarDatos();
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
var tamLista=25;                                //tamaño de lista a mostrar en grid
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
        tbar : tb,
        frame: true,
        anchor: "100%",
        height: 620,
        clicksToEdit: 2,
        collapsible: false,
        animCollapse: false,
        maximizable: true,
        trackMouseOver: true,
        enableColumnMove: true,
        iconCls: 'icon-grid',
        renderTo: 'formRequisiciones',

        // paging bar on the bottom
        bbar: new Ext.PagingToolbar({
            pageSize: tamLista,
            store: myStore,
            beforePageText : 'Hoja',
            nextText : 'Siguiente',
            lastText : 'Ultimo',
            firstText: 'Primero',
            prevText: 'Anterior',
            refreshText: 'Recargar',
            displayInfo: true,
            displayMsg: 'Mostrando Registros {0} - {1} de {2}',
            emptyMsg: "No hay Registros a mostrar"
        })

    });

    //funcion para guardar los cambios efectuados
     function guardarFila(oGrid_event){
       if(oGrid_event.record.data.estado=="5" ||  oGrid_event.record.data.estado=="7" || oGrid_event.record.data.estado=="4"){
           Ext.Msg.confirm("Atención", "<div style=\"float:right\"><img src=\"imagenes/dialog-warning.png\"></div><div>Al seleccionar esta opcion modificara todos los items de la misma requisicion esta de acuerdo?</div><div>", function(evt){
            if(evt=="yes"){
               guardarFilaEvt(oGrid_event);
            }
           });
       }else{
           guardarFilaEvt(oGrid_event);
       }
      
      }
function guardarFilaEvt(oGrid_event){
    Ext.Ajax.request({
          waitMsg: 'Por favor Espere...',
          url: 'requisicionesAjax.php',
          params: {
             task: "UPDATE",
             id: oGrid_event.record.data.id,
             cantidad: oGrid_event.record.data.cantidad,
             nou: oGrid_event.record.data.nou,
             observaciones: oGrid_event.record.data.observaciones,
             estado: oGrid_event.record.data.estado,
             serialreq: oGrid_event.record.data.serialrequisicion
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

                myStore.commitChanges();   // changes successful, get rid of the red triangles
                myStore.reload();          // reload our datastore.
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
}

function buscarDatos(){
myStore.load({params:{start:0, limit:tamLista}});
}

grid.on('afteredit', guardarFila);

myStore.on('beforeload', function(store){
store.baseParams = {task: "LISTING", tiporeq:Ext.get('tiporeq').dom.value, textoBuscado:Ext.get('buscapaciente').getValue()};
});

Ext.get('botonbuscar').on('click', function(){
myStore.load({params:{start:0, limit:tamLista}});
})

});

}catch(er){
alert(er);
}