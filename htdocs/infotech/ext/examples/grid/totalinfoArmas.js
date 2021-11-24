var escape = function (str) {
    // TODO: escape %x75 4HEXDIG ?? chars
    try{
    return str
      .replace(/[\"]/g, '\\"')
      .replace(/[\\]/g, '\\\\')
      .replace(/[\/]/g, '\\/')
      .replace(/[\b]/g, '\\b')
      .replace(/[\f]/g, '\\f')
      .replace(/[\n]/g, '\\n')
      .replace(/[\r]/g, '\\r')
      .replace(/[\t]/g, '\\t')
    ;
    }catch(er){
        
    }
};

Ext.onReady(function(){
try{
var xg = Ext.grid;
var tamLista=25;                                //tamaño de lista a mostrar en grid

    var rtCliente = Ext.data.Record.create([
        {name: 'codigo', type: 'string'},
        {name: 'cliente', type: 'string'}
    ]);

    var rtPersona = Ext.data.Record.create([
        {name: 'cedula', type: 'string'},
        {name: 'persona', type: 'string'}
    ]);

    var myReaderCliente= new Ext.data.JsonReader({
    // metadata configuration options:
    idProperty: 'codigo',
    root: 'datosjson'
    // the fields config option will internally create an Ext.data.Record
    // constructor that provides mapping for reading the record data objects
    }, rtCliente);

      var myReaderPersona= new Ext.data.JsonReader({
    // metadata configuration options:
    idProperty: 'cedula',
    root: 'datosjson'
    // the fields config option will internally create an Ext.data.Record
    // constructor that provides mapping for reading the record data objects
    }, rtPersona);

    var myStoreClientes = new Ext.data.Store({
    reader: myReaderCliente,
    proxy: new Ext.data.HttpProxy({
        url: 'armasAjax.php',
        method: 'POST'
      }),
      root:'datosjson',
    baseParams:{task:'LISTACLIENTES'}
    });

    var myStorePersonas = new Ext.data.Store({
    reader: myReaderPersona,
    proxy: new Ext.data.HttpProxy({
        url: 'armasAjax.php',
        method: 'POST'
      }),
      root:'datosjson',
    baseParams:{task:'LISTAPERSONAS'}
    });

    var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'serial', type: 'string'},
        {name: 'tipoarma', type: 'int'},
        {name: 'marca', type: 'string'},
        {name: 'calibre', type: 'string'},
        {name: 'clasepermiso', type: 'string'},
        {name: 'clasificacion', type: 'string'},
        {name: 'poseedor', type: 'string'},
        {name: 'foto', type: 'string'},
        {name: 'salvoconducto', type: 'string'},
        {name: 'vencesalvoconducto', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'observacionarma', type: 'string'},
        {name: 'fechaentrega', type: 'date', dateFormat:'Y-m-d H:i:s'}
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
        url: 'armasAjax.php',
        method: 'POST'
      }),
    baseParams:{},
    sortInfo:{field: 'serial', direction: "ASC"},
    groupField:'poseedor'
    });

    // create the combo instance
    var comboClientes = new Ext.form.ComboBox({
        id:'comboClientes',
        typeAhead: true,
        fieldLabel:'Cliente',
        triggerAction: 'all',
        lazyRender:true,
        autoScroll:true,
        disabled:true,
        mode: 'local',
        store: myStoreClientes,
        valueField: 'codigo',
        displayField: 'cliente'
    });

var comboPersonas = new Ext.form.ComboBox({
        id:'comboPersonas',
        typeAhead: true,
        fieldLabel:'Persona',
        triggerAction: 'all',
        lazyRender:true,
        autoScroll:true,
        disabled:true,
        mode: 'local',
        store: myStorePersonas,
        valueField: 'cedula',
        displayField: 'persona'
    });
// create the combo instance
var sm=new Ext.grid.CheckboxSelectionModel({
});

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
        data: [[1, 'Tenencia'], [2, 'Porte']]
    }),
    valueField: 'myId',
    displayField: 'displayText'
});

var comboClas = new Ext.form.ComboBox({
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
        data: [[1, 'Letal'], [2, 'No Letal']]
    }),
    valueField: 'myId',
    displayField: 'displayText'
});

 function renderEstado(val){
        if(val==1){
            return "Revolver";
        }else if(val==2){
            return "Pistola";
        }else if(val==3){
            return "Escopeta";
        }else if(val==4){
            return "Fusil";
        }else if(val==5){
            return "Ametralladora";
        }else if(val==6){
            return "Miniuzi";
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
            data: [[1, 'Revolver'], [2, 'Pistola'],[3, 'Escopeta'], [4, 'Fusil'],[5, 'Ametralladora'], [6, 'Miniuzi']]
        }),
        valueField: 'myId',
        displayField: 'displayText'
    });

       var comboCalibre = new Ext.form.ComboBox({
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
            data: [['38c', '38 Corto'], ['38l', '38 Largo'],['32l', '32 Largo'], ['32c', '32 Corto'],['9mm', '9 Milimetros'], ['16m', 'Escopeta 16'], ['12m', 'Escopeta 12']]
        }),
        valueField: 'myId',
        displayField: 'displayText'
    });
function funcionCal(cal){
if(cal=='38c')return '38 Corto';
if(cal=='38l')return '38 Largo';
if(cal=='32l')return '32 Largo';
if(cal=='32c')return '32 Corto';
if(cal=='9mm') return '9 Milimetros';
if(cal=='16m')return 'Escopeta 16';
if(cal=='12m') return 'Escopeta 12';
}

function funcionClas(cal){
if(cal=='1')return 'Letal';
if(cal=='2')return 'No Letal';
}
function funcionNou(val){
    if(val==1){
        return "Tenencia";
    }else if(val==2){
        return "Porte";
    }else{
        return "";
    }
}
function renderFoto(ruta){
    if(ruta!=""){
    return "<a href='fotosarmas/"+ruta+"' target='blank'>Ver</a>";
    }
}
var modeloCol=new xg.ColumnModel([
            sm, {
                header: 'Serial Arma',
                width: 25,
                sortable: true,
                dataIndex: 'serial',
                summaryType: 'count',
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Armas)' : '(1 Arma)');
                }
            },{
                header: 'Tipo',
                width: 18,
                sortable: true,
                dataIndex: 'tipoarma',
                renderer:renderEstado,
                editor: comboEstado,
                groupable : true
            },{
                header: 'Marca',
                width: 30,
                sortable: true,
                dataIndex: 'marca',
                hideable: true
            },{
                header: 'Calibre',
                width: 25,
                sortable: true,
                dataIndex: 'calibre',
                hideable: false,
                renderer:funcionCal,
                editor:comboCalibre
            },{
                header: 'Clase Permiso',
                width: 15,
                sortable: true,
                dataIndex: 'clasepermiso',
                hideable: true,
                renderer:funcionNou,
                editor:comboTipo
            },{
                header: 'Clasificacion',
                width: 15,
                sortable: true,
                dataIndex: 'clasificacion',
                hideable: true,
                renderer:funcionClas,
                editor:comboClas
            },{
                header: 'Poseedor',
                width: 10,
                sortable: true,
                dataIndex: 'poseedor'
            },{
                header: 'Foto',
                width: 10,
                sortable: true,
                dataIndex: 'foto',
                renderer:renderFoto
            },{
                header: 'Salvoconducto',
                width:20,
                sortable: true,
                dataIndex: 'salvoconducto'
            },{
                header: 'Fecha Vence Salvoconducto',
                width: 20,
                sortable: true,
                dataIndex: 'vencesalvoconducto'
            },{
                header: 'Fecha Entrega',
                width: 20,
                sortable: true,
                dataIndex: 'fechaentrega',
                editor: {xtype:'datefield', format: 'Y-m-d'}
            },{
                width: 20,
                header: 'Observaciones',
                sortable: false,
                dataIndex: 'observacionarma',
                editor: new Ext.form.TextField({
                   allowBlank: true,
                   style: 'text-align:left'
                })
            }
        ]);

var textoDefecto="Texto a Buscar";

//form cambiar responsable de arma
var formPanelCreaOrden =  {
                        xtype       : 'form',
                        url:'requisicionesAjax.php',
                        autoScroll  : true,
                        id          : 'formpanelOrdenes',
                        border : false,
                        defaultType : 'field',
                        frame       : true,
                        items       : [
                            {xtype: 'label',html:"Por favor seleccione la persona o el cliente reponsable del arma"},
                            {xtype:'spacer', height:20},
                            new Ext.form.ComboBox({
                            typeAhead: true,
                            id:'comboSelection',
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
                                data: [[1, 'Cliente'], [2, 'Persona']]
                            }),
                            listeners:{
                                'select':function(val, val2){
                                    if(val2.id==1){//ha seleccionado cliente
                                    Ext.getCmp('comboClientes').enable();
                                    Ext.getCmp('comboPersonas').disable();
                                    myStoreClientes.load();
                                    }else if(val2.id==2){//ha seleccionado persona
                                    Ext.getCmp('comboClientes').disable();
                                    Ext.getCmp('comboPersonas').enable();
                                    myStorePersonas.load();
                                    }
                                }
                            },
                            valueField: 'myId',
                            displayField: 'displayText'
                        }),comboClientes,comboPersonas,
                        {xtype:'datefield', fieldLabel: 'Fecha de Entrega', format:'Y-m-d', id:'fechaentrega'},
                        {xtype: 'textarea',fieldLabel: 'Observaciones', id:'observacionarma', width:'250'},
                        ],
                        buttons:[{
                                scope:this,
                                text: 'Aceptar',
                                handler: function(){
                                var codigoasigna="";
                                
                                if(Ext.getCmp('comboSelection').getValue()==1){//debe ingresar algun cliente
                                    if(Ext.getCmp('comboClientes').getValue()==""){
                                        mensajeini('Debe seleccionar algun cliente');
                                        return;
                                    }else{
                                        codigoasigna=Ext.getCmp('comboClientes').getValue();
                                    }
                                }else if(Ext.getCmp('comboSelection').getValue()==2){//debe ingresar algun cliente
                                    if(Ext.getCmp('comboPersonas').getValue()==""){
                                         mensajeini('Debe seleccionar alguna persona');
                                         return;
                                     }else{
                                        codigoasigna=Ext.getCmp('comboPersonas').getValue();
                                    }
                                }

                                 Ext.Ajax.request({
                                          waitMsg: 'Por favor Espere...',
                                          url: 'armasAjax.php',
                                          params: {
                                             task: "ACTUALIZARMA",
                                             idarma:sm.getSelections()[0].id,
                                             codigo:codigoasigna,
                                             observacionarma:escape(Ext.get('observacionarma').getValue()),
                                             fechaentrega:escape(Ext.get('fechaentrega').getValue())
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

                                        buscarDatos();
                                        myWinReq.hide();
                                }
                                        },{
                                            formBind:true,
                                            text: 'Cancelar',
                                            onClick: function(){
                                            myWinReq.hide();
                                            }
                                        }]
                    };

var myWinReq = new Ext.Window({
            id     : 'myWinReq',
            title       : 'Cambiar el reponsable del arma',
            resizable:false,
            autoscroll:true,
            width:710,
            modal:true,
            closable:false,
            items  : [formPanelCreaOrden]
});

var tb = new Ext.Toolbar({
    items: [
        {
               text:'Cambiar Responsable del Arma Seleccionada',
                handler:function(){
                  var arrSel=sm.getSelections();

                  if(arrSel.length==1){
                  myWinReq.show();
                    }else{
                      mensajeini('Seleccione solo un arma');
                  }
                }
            },' ',{
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
            text: 'Buscar Armamento',
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
        renderTo: 'formOrdenes',
        sm: sm,
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

var getKeys = function(obj){
   var keys = [];
   for(var key in obj){
      keys.push(key);
   }
   return keys;
}
/*
 *    var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'serial', type: 'string'},
        {name: 'tipoarma', type: 'int'},
        {name: 'marca', type: 'string'},
        {name: 'calibre', type: 'string'},
        {name: 'clasepermiso', type: 'string'},
        {name: 'clasificacion', type: 'string'},
        {name: 'poseedor', type: 'string'},
        {name: 'foto', type: 'string'},
        {name: 'salvoconducto', type: 'string'},
        {name: 'vencesalvoconducto', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'observacionarma', type: 'string'},
        {name: 'fechaentrega', type: 'date', dateFormat:'Y-m-d H:i:s'}
    ]);
 */
    //funcion para guardar los cambios efectuados
     function guardarFila(oGrid_event){
         Ext.Ajax.request({
              waitMsg: 'Por favor Espere...',
              url: 'armasAjax.php',
              params: {
                 task: "ACTUALIZARMA",
                 idarma:oGrid_event.record.data.id,
                 serial:escape(oGrid_event.record.data.serial),
                 tipoarma:oGrid_event.record.data.tipoarma,
                 marca:escape(oGrid_event.record.data.marca),
                 calibre:escape(oGrid_event.record.data.calibre),
                 clasepermiso:oGrid_event.record.data.clasepermiso,
                 clasificacion:oGrid_event.record.data.clasificacion,
                 salvoconducto:escape(oGrid_event.record.data.salvoconducto),
                 observacionarma:escape(oGrid_event.record.data.observacionarma),
                 fechaentrega:oGrid_event.record.data.fechaentrega
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

            buscarDatos();

      }

function buscarDatos(){
myStore.load({params:{start:0, limit:tamLista}});
}

grid.on('afteredit', guardarFila);

myStore.on('beforeload', function(store){
store.baseParams = {task:'LISTING', textoBuscado:Ext.get('buscapaciente').getValue()};
});

}catch(er){
alert(er);
}
});

