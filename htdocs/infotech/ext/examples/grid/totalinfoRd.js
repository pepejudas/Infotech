 /* Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
var escape = function (str) {
    // TODO: escape %x75 4HEXDIG ?? chars
    return str
      .replace(/[\"]/g, '\\"')
      .replace(/[\\]/g, '\\\\')
      .replace(/[\/]/g, '\\/')
      .replace(/[\b]/g, '\\b')
      .replace(/[\f]/g, '\\f')
      .replace(/[\n]/g, '\\n')
      .replace(/[\r]/g, '\\r')
      .replace(/[\t]/g, '\\t')
    ;};

Ext.onReady(function(){
try{
var xg = Ext.grid;
var deshabilita=true;
var tamLista=25;                                //tamaño de lista a mostrar en grid
var tamListaReq=50;

var rtReq = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'serialrequisicion', type: 'int'},
        {name: 'nombreprod', type: 'string'},
        {name: 'fechareq', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'nombre', type: 'string'},
        {name: 'cantidad', type: 'int'},
        {name: 'cantidadisponible', type: 'int'},
        {name: 'nou', type: 'string'},
        {name: 'valorunitario', type: 'int'},
        {name: 'observaciones', type: 'string'},
        {name: 'fechapre', type: 'date', dateFormat:'Y-m-d H:i:s'}
    ]);

    var rtProvee = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'provee', type: 'string'}
    ]);

    var myReaderReq = new Ext.data.JsonReader({
    // metadata configuration options:
    idProperty: 'id',
    root: 'datosjson',
    totalProperty: 'numfilas'
    // the fields config option will internally create an Ext.data.Record
    // constructor that provides mapping for reading the record data objects
    }, rtReq);

    var myReaderProvee= new Ext.data.JsonReader({
    // metadata configuration options:
    idProperty: 'id',
    root: 'datosjson',
    totalProperty: 'numfilas'
    // the fields config option will internally create an Ext.data.Record
    // constructor that provides mapping for reading the record data objects
    }, rtProvee);

    var myStoreReq = new Ext.data.GroupingStore({
    // explicitly create reader
    reader: myReaderReq,
    proxy: new Ext.data.HttpProxy({
        url: 'requisicionesAjax.php',
        method: 'POST'
      }),
    baseParams:{},
    sortInfo:{field: 'serialrequisicion', direction: "ASC"},
    groupField:'nombre'
    });
    
    var myStoreProveedores = new Ext.data.Store({
    reader: myReaderProvee,
    proxy: new Ext.data.HttpProxy({
        url: 'ordenesAjax.php',
        method: 'POST'
      }),
      root:'datosjson',
    baseParams:{task:'LISTAPROVEEDORES'}
    });

     var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'serialorden', type: 'int'},
        {name: 'estado', type: 'int'},
        {name: 'fechaorden', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'plazodentrega', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'formadepago', type: 'string'},
        {name: 'nombreproducto', type: 'string'},
        {name: 'nombreprovee', type: 'string'},
        {name: 'nombresolicitante', type: 'string'},
        {name: 'cantidad', type: 'int'},
        {name: 'observacionesorden', type: 'string'}
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
        url: 'ordenesAjax.php',
        method: 'POST'
      }),
    baseParams:{},
    sortInfo:{field: 'serialorden', direction: "ASC"},
    groupField:'nombreprovee'
    });

    // create the combo instance
    var comboProveedores = new Ext.form.ComboBox({
        id:'proveedor',
        typeAhead: true,
        fieldLabel:'Proveedor',
        triggerAction: 'all',
        disabled:true,
        lazyRender:true,
        autoScroll:true,
        mode: 'local',
        store: myStoreProveedores,
        valueField: 'id',
        displayField: 'provee'
    });

// create the combo instance
var sm=new Ext.grid.CheckboxSelectionModel();

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

 function renderEstado(val){
        if(val==1){
            return "Pendiente";
        }else if(val==2){
            return "Recibida";
        }else{//valor por defecto
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
            data: [[1, 'Pendiente por Recibir'], [2, 'Recibir Item'], [3, 'Recibir Orden'], [4, 'Elimina Item'], [5, 'Elimina Orden']]
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
 var modeloCol=new xg.ColumnModel([
            {
                header: 'No Orden',
                width: 15,
                sortable: true,
                dataIndex: 'serialorden',
                renderer: function(val){//funcion para enviar de una al link del documento
                    return '<a href="ordendecompra.php?cedulamod='+val+'" target="blank">'+val+'</a>';
                }
            },{
                header: 'Estado',
                width: 18,
                sortable: true,
                dataIndex: 'estado',
                renderer:renderEstado,
                editor: comboEstado,
                groupable : true,
                align: 'center',
                falseText: 'No',
                trueText: 'Si'
            },{
                header: 'Nombre del Producto',
                width: 30,
                sortable: true,
                dataIndex: 'nombreproducto',
                summaryType: 'count',
                hideable: true
            },{
                header: 'Nombre del Proveedor',
                width: 30,
                sortable: true,
                dataIndex: 'nombreprovee',
                summaryType: 'count',
                hideable: false
            },{
                header: 'Nombre Solicitante',
                width: 30,
                sortable: true,
                dataIndex: 'nombresolicitante',
                summaryType: 'count',
                hideable: true,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Referencias)' : '(1 Referencia)');
                }
            },{
                header: 'Unds',
                width: 10,
                sortable: true,
                dataIndex: 'cantidad',
                summaryType: 'sum'
            },{
                id: 'observaciones',
                header: 'Observaciones',
                sortable: false,
                flex:'1',
                dataIndex: 'observacionesorden'
            }
        ]);

 var modeloColReq=new xg.ColumnModel([
            sm, {
                header: 'No Req',
                width: 17,
                sortable: true,
                dataIndex: 'serialrequisicion',
                renderer: function(val){//funcion para enviar de una al link del documento
                    return '<a href="requisicion.php?cedulamod='+val+'" target="blank">'+val+'</a>';
                }
            }, {
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
                width: 13,
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
                header: 'Valor Unitario',
                width: 30,
                sortable: true,
                dataIndex: 'valorunitario',
                editable:true,
                groupable : false,
                editor: new Ext.form.TextField({
                   allowBlank: false,
                   style: 'text-align:left'
                })
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
        },
        '->',// begin using the right-justified button container
        {
            xtype: 'button', // default for Toolbars, same as 'tbbutton'
            text: 'Buscar Requisición',
            onClick: function(){
            buscarDatosReq();
            }
        },
        {
            id: 'buscarequisiciones',
            xtype: 'textfield',
            name: 'field1',
            emptyText: textoDefecto
        }
    ]
});

        var formPanelCreaOrden =  {
        xtype       : 'form',
        url:'requisicionesAjax.php',
        autoScroll  : true,
        id          : 'formpanelOrdenes',
        border : false,
        defaultType : 'field',
        frame       : true,
        items       : [
            {xtype: 'label',html:"Por favor seleccione las requisiciones que seran gestionadas con la nueva orden de compra"},
            {xtype:'spacer', height:20},
            {xtype:'checkbox', id:'checkgeneraorden',  fieldLabel : 'Generar Orden',
                handler:function(){
                if(deshabilita){
                Ext.getCmp('formapago').enable();
                Ext.getCmp('plazoentrega').enable();
                Ext.getCmp('observaciones').enable();
                Ext.getCmp('proveedor').enable();
                Ext.getCmp('aceptarOrden').enable();
                deshabilita=false;
                }else{
                Ext.getCmp('formapago').disable();
                Ext.getCmp('plazoentrega').disable();
                Ext.getCmp('observaciones').disable();
                Ext.getCmp('proveedor').disable();
                Ext.getCmp('aceptarOrden').disable();
                deshabilita=true;
                }
            }},
            {fieldLabel : 'Forma de Pago', id:'formapago', disabled:true},
            {xtype:'datefield', fieldLabel: 'Plazo de Entrega', format: 'Y-m-d', id:'plazoentrega', disabled:true},
            comboProveedores,
            {xtype: 'textarea',fieldLabel: 'Observaciones', id:'observaciones', disabled:true, width:'250'},
        ],
        buttons:[{
                scope:this,
                id:'aceptarOrden',
                disabled:true,
                text: 'Aceptar',
                handler: function(){
                
                 if(Ext.get('checkgeneraorden').getValue()=='on'){
                     var arrSel=sm.getSelections();
                     var arrReqJSON="";
                     for(var i=0;i < arrSel.length;i++){
                      var agreg="";
                      if(i>0){//es el ultimo elemento
                      agreg=",";
                      }
                     arrReqJSON+=agreg+arrSel[i].id;
                     }
                     
                     if( Ext.get('formapago').getValue()!="" && Ext.get('plazoentrega').getValue()!="" && comboProveedores.getValue()!="" && arrReqJSON!=""){

                     Ext.Ajax.request({
                      waitMsg: 'Por favor Espere...',
                      url: 'ordenesAjax.php',
                      params: {
                         task: "CREARORDEN",
                         formapago:escape(Ext.get('formapago').getValue()),
                         plazoentrega:Ext.get('plazoentrega').getValue(),
                         observaciones:escape(Ext.get('observaciones').getValue()),
                         idprov:comboProveedores.getValue(),
                         requisiciones:arrReqJSON
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
                }else{
                    mensajeini("Debe seleccionar al menos una requisicion y todos los campos del formulario son requeridos");
                }
                buscarDatos();
                buscarDatosReq();
                myWinReq.hide();
                }
                }
            },{
                formBind:true,
                text: 'Cancelar',
                onClick: function(){
                myWinReq.hide();
                }
            }]
    };
    
    var gridReq = new xg.EditorGridPanel({
        id:'gridHtmlReq',
        store: myStoreReq,
        colModel: modeloColReq,
        plugins: summary,
        view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
            enableGroupingMenu: true,
            hideGroupedColumn: false
        }),
        tbar : tbReq,
        frame: true,
        anchor: 'none 100%',
        width:700,
        height:400,
        clicksToEdit: 2,
        collapsible: false,
        animCollapse: false,
        trackMouseOver: true,
        enableColumnMove: true,
        iconCls: 'icon-grid',
        sm: sm,
        // paging bar on the bottom
        bbar: new Ext.PagingToolbar({
            pageSize: tamListaReq,
            store: myStoreReq,
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

var myWinReq = new Ext.Window({
            id     : 'myWinReq',
            title       : 'Creación Orden de Compra',
            resizable:false,
            autoscroll:true,
            width:710,
            modal:true,
            closable:false,
            items  : [formPanelCreaOrden, gridReq]
        });

var tb = new Ext.Toolbar({
    items: [
      {
        text: 'Agregar Orden de Compra',
        handler: function() {
        myStoreProveedores.load();
        myWinReq.show();
        }},'',{
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
            text: 'Buscar Orden de Compra',
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

    //funcion para guardar los cambios efectuados
     function guardarFila(oGrid_event){
       var deshabilitaExis=true;

       if(oGrid_event.record.data.estado=="2"){
       
        var myWinExistencia= new Ext.Window({
            id     : 'myWinExistencia',
            title       : 'Generar Registro de Ingreso de Producto',
            resizable:true,
            width:700,
            modal:true,
            closable:true,
            items  : [ {
                xtype       : 'form',
                url:'ordenesAjax.php',
                autoScroll  : true,
                id          : 'formpanelExistencias',
                border : false,
                defaultType : 'field',
                frame       : true,
                items       : [
                    {xtype: 'label',html:"<div>Se va a generar el ingreso a existencias del producto: <div><b>"+ oGrid_event.record.data.nombreproducto+"</b></div><div>Si esta de Acuerdo. Seleccione la casilla siguiente</div>"},
                    {xtype:'spacer', height:20},
                    {xtype:'checkbox', id:'checkGeneraExistencia',  fieldLabel : 'Existencia',
                        handler:function(evt, rec){
                        if(deshabilitaExis){
                        Ext.getCmp('cantidadExistencia').enable();
                        Ext.getCmp('estadoExis').enable();
                        Ext.getCmp('observacionesExis').enable();
                        Ext.getCmp('aceptarExistencia').enable();
                        deshabilitaExis=false;
                        }else{
                        Ext.getCmp('cantidadExistencia').disable();
                        Ext.getCmp('estadoExis').disable();
                        Ext.getCmp('observacionesExis').disable();
                        Ext.getCmp('aceptarExistencia').disable();
                        deshabilitaExis=true;
                        }
                    }},
                    {fieldLabel : 'Cantidad', id:'cantidadExistencia', disabled:true, width:'100', value:oGrid_event.record.data.cantidad},new Ext.form.ComboBox({
            id:'estadoExis',
            typeAhead: true,
            disabled:true,
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
        }),
                    {xtype: 'textarea',fieldLabel: 'Observaciones', id:'observacionesExis', disabled:true, width:'250'},
                ],
                buttons:[{
                        scope:this,
                        id:'aceptarExistencia',
                        text: 'Aceptar',
                        disabled:true,
                        handler: function(){
                         if(Ext.get('checkGeneraExistencia').getValue()=='on'){

                             Ext.Ajax.request({
                              waitMsg: 'Por favor Espere...',
                              url: 'ordenesAjax.php',
                              params: {
                                 task: "CREAREXISTENCIA",
                                 cantidad:Ext.getCmp('cantidadExistencia').getValue(),
                                 nou:Ext.getCmp('estadoExis').getValue(),
                                 observacionesreg:Ext.getCmp('observacionesExis').getValue(),
                                 idorden:oGrid_event.record.data.id
                              },
                              success: function(response){
                                  try{
                                    var respuesta = eval(response.responseText);
                                    if(respuesta.error){
                                    Ext.MessageBox.alert('error', respuesta.error);
                                    }else{
                                    buscarDatos();
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
                        }
                        myWinExistencia.close();
                        }
                    },{
                        formBind:true,
                        text: 'Cancelar',
                        onClick: function(){
                        buscarDatos();
                        myWinExistencia.close();
                        }
                    }]
            }]
        });

        Ext.getCmp('estadoExis').setValue(1);

        myWinExistencia.show();

       } else if(oGrid_event.record.data.estado=="3"){

        var myWinExistencia2= new Ext.Window({
            id     : 'myWinExistencia',
            title       : 'Generar Registro de Ingreso de Producto',
            resizable:true,
            width:700,
            modal:true,
            closable:true,
            items  : [{
                xtype       : 'form',
                url:'ordenesAjax.php',
                autoScroll  : true,
                id          : 'formpanelExistencias',
                border : false,
                defaultType : 'field',
                frame       : true,
                items       : [
                    {xtype: 'label',html:"<div>Se va a generar el ingreso a existencias tal como estan definidas, para todos los items de la orden de compra: <div>No: <b>"+ oGrid_event.record.data.serialorden+"</b></div><div>Si esta de Acuerdo. Seleccione la casilla siguiente</div>"},
                    {xtype:'spacer', height:20},
                    {xtype:'checkbox', id:'checkgeneraexistenciaorden',  fieldLabel : 'Existencia',
                        handler:function(evt, rec){
                        if(deshabilitaExis){
                        Ext.getCmp('observacionesExis').enable();
                        Ext.getCmp('aceptarExistenciaOrden').enable();
                        deshabilitaExis=false;
                        }else{
                        Ext.getCmp('observacionesExis').disable();
                        Ext.getCmp('aceptarExistenciaOrden').disable();
                        deshabilitaExis=true;
                        }
                    }},
                    {xtype: 'textarea',fieldLabel: 'Observaciones', id:'observacionesExis', disabled:true, width:'250'},
                ],
                buttons:[{
                        scope:this,
                        id:'aceptarExistenciaOrden',
                        disabled:true,
                        text: 'Aceptar',
                        handler: function(){
                         if(Ext.get('checkgeneraexistenciaorden').getValue()=='on'){
                            
                             Ext.Ajax.request({
                              waitMsg: 'Por favor Espere...',
                              url: 'ordenesAjax.php',
                              params: {
                                 task: "CREAREXISTENCIAORDEN",
                                 observacionesreg:Ext.getCmp('observacionesExis').getValue(),
                                 idorden:oGrid_event.record.data.serialorden
                              },
                              success: function(response){
                                  try{
                                    var respuesta = eval(response.responseText);
                                    if(respuesta.error){
                                    Ext.MessageBox.alert('error', respuesta.error);
                                    }else{
                                    buscarDatos();
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
                        }
                        myWinExistencia2.close();
                        }
                    },{
                        formBind:true,
                        text: 'Cancelar',
                        onClick: function(){
                        buscarDatos();
                        myWinExistencia2.close();
                        }
                    }]
            }]
        });

        myWinExistencia2.show();

       } else if(oGrid_event.record.data.estado=="4"){
       Ext.Msg.confirm("Atencion", "Si confirma eliminara el item seleccionado", function(){
           Ext.Ajax.request({
                              waitMsg: 'Por favor Espere...',
                              url: 'ordenesAjax.php',
                              params: {
                                 task: "ELIMINARITEM",
                                 id:oGrid_event.record.data.id
                              },
                              success: function(response){
                                  try{
                                    var respuesta = eval(response.responseText);
                                    if(respuesta.error){
                                    Ext.MessageBox.alert('error', respuesta.error);
                                    }else{
                                    buscarDatos();
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
       });
       } else if(oGrid_event.record.data.estado=="5"){
       Ext.Msg.confirm("Atencion", "Si confirma eliminara todos los elementos de la orden de compra seleccionada", function(){
           Ext.Ajax.request({
                              waitMsg: 'Por favor Espere...',
                              url: 'ordenesAjax.php',
                              params: {
                                 task: "ELIMINARORDEN",
                                 serialorden:oGrid_event.record.data.serialorden
                              },
                              success: function(response){
                                  try{
                                    var respuesta = eval(response.responseText);
                                    if(respuesta.error){
                                    Ext.MessageBox.alert('error', respuesta.error);
                                    }else{
                                    buscarDatos();
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
       });
       }

      }

function guardarFilaEvt(oGrid_event){
    Ext.Ajax.request({
          waitMsg: 'Por favor Espere...',
          url: 'requisicionesAjax.php',
          params: {
             task: "UPDATE",
             id: oGrid_event.record.data.id,
             cantidad: escape(oGrid_event.record.data.cantidad),
             nou: oGrid_event.record.data.nou,
             observaciones: escape(oGrid_event.record.data.observaciones),
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

 //funcion para guardar los cambios efectuados
     function guardarFilaRequisicion(oGrid_event){
          Ext.Ajax.request({
          waitMsg: 'Por favor Espere...',
          url: 'requisicionesAjax.php',
          params: {
             task: "UPDATE",
             id: oGrid_event.record.data.id,
             cantidad: oGrid_event.record.data.cantidad,
             nou: oGrid_event.record.data.nou,
             observaciones: escape(oGrid_event.record.data.observaciones),
             estado: 2,
             valorunitario: oGrid_event.record.data.valorunitario,
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

function buscarDatosReq(){
myStoreReq.load({params:{start:0, limit:tamListaReq}});
}

grid.on('afteredit', guardarFila);

gridReq.on('afteredit', guardarFilaRequisicion);

myStoreReq.on('beforeload', function(store){//deben ser unicamente las aprobadas las cuales pueden generar orden de compra
store.baseParams = {task: "LISTAREQSINORDEN", tiporeq:2, textoBuscado:Ext.get('buscarequisiciones').getValue(), gridOrdenes:true, estado:2};
});

myStore.on('beforeload', function(store){
store.baseParams = {task:'LISTING', tiporeq:Ext.get('tiporeq').dom.value, textoBuscado:Ext.get('buscapaciente').getValue()};
});

Ext.get('botonbuscar').on('click', function(){
myStore.load({params:{start:0, limit:tamLista}});
})

}catch(er){
alert(er);
}
});

