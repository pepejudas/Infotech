/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){

 Ext.QuickTips.init();

try{
    
 var xg = Ext.grid;

    var rt = Ext.data.Record.create([
        {name: 'id', type: 'int'},
        {name: 'nombrenoti', type: 'string'},
        {name: 'usuanotifica', type: 'string'},
        {name: 'fechacreanoti', type: 'date', dateFormat:'Y-m-d H:i:s'},
        {name: 'estado', type: 'int'},
        {name: 'descripcion', type: 'string'}
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
        url: 'notificacionesAjax.php',
        method: 'POST'
      }),
    baseParams:{task: "BUSQUEDA", idusuario:idusua},
    sortInfo:{field: 'fechacreanoti', direction: "ASC"},
    groupField:'usuanotifica'
    });

    // create the combo instance
    var comboEstado = new Ext.form.ComboBox({
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
            data: [[1, 'No Revisada'], [2, 'Verificado']]
        }),
        valueField: 'myId',
        displayField: 'displayText'
    });

  function renderEstado(val){
        if(val==1){
            return "No Revisado";
        }else if(val==2){
            return "Notificado";
        }else{//valor por defecto para las no revisadas
            return "";
        }
  }

var modeloCol=new xg.ColumnModel([
            {header: 'Id',
                width:20,
                sortable: true,
                dataIndex: 'id',
                editable: false
            },{
                header: 'Titulo',
                width:112,
                sortable: true,
                dataIndex: 'nombrenoti',
                groupable : true,
                align: 'left',
                summaryType: 'count',
                hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '<b>(' + v +' Notificaciones)</b>' : '<b>(1 Notificaci&oacute;n)</b>');
                }
            },{
                header: 'Usuario',
                sortable: true,
                dataIndex: 'usuanotifica'
            },{
                header: 'Fecha Notificacion',
                width:40,
                sortable: true,
                dataIndex: 'fechacreanoti'
            },{
                header: 'Estado',
                width:83,
                align: 'center',
                sortable: true,
                dataIndex: 'estado',
                editor: comboEstado,
                renderer: renderEstado
            },{
                header: 'Descripci&oacute;n',
                width: 180,
                flex: 2,
                align: 'left',
                sortable: true,
                dataIndex: 'descripcion',
                groupable : true,
                editor: new Ext.form.TextField({
                allowBlank: true,
                style: 'text-align:left'
                })
            }
        ]);

var tb = new Ext.Toolbar({
    items: [
        // begin using the right-justified button container
        '->', // same as {xtype: 'tbfill'}, // Ext.Toolbar.Fill
        {
            xtype: 'button', // default for Toolbars, same as 'tbbutton'
            text: 'Toda la Hoja Revisada',
            onClick: function(){

            Ext.Msg.confirm("Atenci&oacute;n",
            "<div style=\"float:right\"><img src=\"imagenes/dialog-warning.png\"></div><div>¿Esta seguro que desea marcar como revisadas todas las notificaciones de la hoja actual?</div>",
            function(respuesta){
            if(respuesta=="yes"){
                var numnoti=myStore.data.length;
                    for(var i=0;i<numnoti;i++){
                     var registro=myStore.data.items[i];
                     registro.data.estado=2;        //marcar como leidos todos los registros
                     var obj={record:registro}
                     guardarFila(obj);
                    }
            }
            });
            }
        }
    ]
});

function peticionPDF(){
       Ext.Ajax.request({
          waitMsg: 'Por favor Espere...',
          url: 'exportarPDFAjax.php',
          params: {
          textoHTML: Ext.get('gridHtml').dom.innerHTML
          },
          success: function(response){

          try{
          var respuesta = eval(response.responseText);
          }catch(err){
              Ext.MessageBox.alert('error respuesta','la respuesta del servidor no es un objeto json:' + response.responseText);
          }
          window.open(respuesta.ruta, "_blank");
          },
          failure: function(response){
              try{
              var respuesta = eval(response.responseText);
              Ext.MessageBox.alert('error comunicacion','se ha presentado un error en el servidor:' + respuesta.error);
              }catch(err){
              Ext.MessageBox.alert('error comunicacion','la respuesta del servidor no es un objeto json:' + response.responseText);
              }
          }
       });
}

// utilize custom extension for Group Summary
var summary = new Ext.ux.grid.GroupSummary();
var tamLista=25;                                //tamaño de lista a mostrar en grid
    var grid = new xg.EditorGridPanel({
        id:'gridHtml',
        store: myStore,
        colModel: modeloCol,
        plugins: summary,
        view: new Ext.grid.GroupingView({
            //forceFit: true,
            showGroupName: false,
            enableNoGroups: false,
            enableGroupingMenu: true,
            hideGroupedColumn: true
        }),

        tbar : tb,
        frame: true,
        width: 470,
        height: 520,
        clicksToEdit: 2,
        collapsible: true,
        animCollapse: true,
        maximizable: true,
        collapsed: true,
        trackMouseOver: false,
        enableColumnMove: true,
        //title: 'Atencion Tiene ('+numNoti+') Notificaciones',
        iconCls: 'icon-grid',
        renderTo: 'grid-example',

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
       Ext.Ajax.request({
          waitMsg: 'Por favor Espere...',
          url: 'notificacionesAjax.php',
          params: {
             task: "UPDATE",
             id: oGrid_event.record.data.id,
             estado: oGrid_event.record.data.estado,
             descripcion: oGrid_event.record.data.descripcion
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
myStore.load({params:{start:0, limit:tamLista}});
var numregn=myReader.totalProperty;
grid.setTitle('Atenci&oacute;n tiene Notificaciones Pendientes!');
}catch(er){//generado cuando no hay notificaciones para mostrar
//Ext.Msg.alert("atencion", er.toString());
}
/*
Ext.get('botonbuscar').on('click', function(){
myStore.baseParams.tiporeq=Ext.get('tiporeq').dom.value;
myStore.load({params:{start:0, limit:tamLista}});
})cuenta bancaria No:
*/
});