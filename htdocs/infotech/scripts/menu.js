/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function mensajeini(msginicio){
    Ext.Msg.alert("Atencion", "<div class=\"contenedoralerta\"><div class=\"contenedorimalerta\"><img src=\"imagenes/dialog-warning.png\"></div><div class=\"contenedoral\">"+msginicio+" menu.js:6</div></div>");
}

Ext.onReady(function(){
try{
// Create the "SampleTreePanel" pre-configured class

    SampleTreePanel = Ext.extend(Ext.tree.TreePanel, {
        renderTo:'divMenu',
        id:'capaArbolMenu',
        loader: new Ext.tree.TreeLoader(),
        rootVisible: false,
        width:270,
        autoScroll:true,
        padding:2,
        height:320,
        border: true,
        initComponent: function(){
            Ext.apply(this, {
                root: new Ext.tree.AsyncTreeNode({
                    children: [{"text":"Inicio Infotech","id":"inicio","iconCls":"data","leaf":true,"draggable":false,"href":"inicio.php","hrefTarget":""},{
                        text: 'Talento Humano',
                        expanded: true,
                        children: [
                        {
                        text: 'Personal Activo',
                        expanded: false,
                        children: [
                        {"text":"Personal Activo","id":"personalactivo","iconCls":"data","leaf":true,"draggable":false,"href":"personalactivo3.php","hrefTarget":""},
                        {"text":"Documentos","id":"docspersonalactivo","iconCls":"report","leaf":true,"draggable":false,"href":"documentospersonalactivo.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Personal Inactivo',
                        expanded: false,
                        children: [
                        {"text":"Personal Inactivo","id":"personalinactivo","iconCls":"data","leaf":true,"draggable":false,"href":"personalretirado3.php","hrefTarget":""},
                        {"text":"Documentos","id":"docspersonalinactivo","iconCls":"report","leaf":true,"draggable":false,"href":"documentospersonalretirado.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Aspirantes',
                        expanded: false,
                        children: [
                        {"text":"Aspirantes","id":"aspirantes","iconCls":"data","leaf":true,"draggable":false,"href":"aspirantes.php","hrefTarget":""},
                        {"text":"Documentos","id":"docsaspirantes","iconCls":"report","leaf":true,"draggable":false,"href":"documentosaspirantes.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Verificaci&oacute;n Documental',
                        expanded: false,
                        children: [
                        {"text":"Verificacion Documental","id":"verificaciondocumental","iconCls":"data","leaf":true,"draggable":false,"href":"verificacion3.php","hrefTarget":""},
                        {"text":"Documentos","id":"docspersonalinactivo","iconCls":"report","leaf":true,"draggable":false,"href":"documentosverificacion.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Historial Disciplinario',
                        expanded: false,
                        children: [
                        {"text":"Antecedentes","id":"antecedentes","iconCls":"data","leaf":true,"draggable":false,"href":"antecedentes.php","hrefTarget":""},
                        {"text":"Historial Disciplinario","id":"historialdisciplinario","iconCls":"data","leaf":true,"draggable":false,"href":"novedades3.php","hrefTarget":""},
                        {"text":"Documentos","id":"docshistorialdisciplinario","iconCls":"report","leaf":true,"draggable":false,"href":"documentosnovedades.php","hrefTarget":""}
                        ]
                        }
                        ]
                    }, {
                        text: 'Almac&eacute;n',
                        expanded: false,
                        children: [{
                        text: 'Requisiciones',
                        expanded: false,
                        children: [
                        {"text":"Elaboraci&oacute;n","id":"requisiciones","iconCls":"data","leaf":true,"draggable":false,"href":"requisiciones.php","hrefTarget":""},
                        {"text":"Aprobaci&oacute;n","id":"aprobacionrequisiciones","iconCls":"data","leaf":true,"draggable":false,"href":"apruebarequisicion.php","hrefTarget":""},
                        {"text":"Documentos","id":"docrequisiciones","iconCls":"report","leaf":true,"draggable":false,"href":"documentosreq.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Ordenes de Compra',
                        expanded: false,
                        children: [
                        {"text":"Elaboraci&oacute;n","id":"ordenesdecompra","iconCls":"data","leaf":true,"draggable":false,"href":"ordenescompra.php","hrefTarget":""},
                        {"text":"Documentos","id":"docrequisiciones","iconCls":"report","leaf":true,"draggable":false,"href":"documentosordenes.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Proveedores',
                        expanded: false,
                        children: [
                        {"text":"Proveedores","id":"proveedores","iconCls":"data","leaf":true,"draggable":false,"href":"proveedores.php","hrefTarget":""},
                        {"text":"Documentos","id":"docproveedores","iconCls":"report","leaf":true,"draggable":false,"href":"documentosproveedores.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Productos',
                        expanded: false,
                        children: [
                        {"text":"Productos","id":"productos","iconCls":"data","leaf":true,"draggable":false,"href":"existencias3.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Existencias',
                        expanded: false,
                        children: [
                        {"text":"Existencias","id":"existencias","iconCls":"data","leaf":true,"draggable":false,"href":"controlinvent3.php","hrefTarget":""},
                        {"text":"Documentos","id":"docexistencias","iconCls":"report","leaf":true,"draggable":false,"href":"documentosexistencias.php","hrefTarget":""}
                        ]
                        },{
                        text: 'Dotaciones',
                        expanded: false,
                        children: [
                            {
                            text: 'Personal',
                            expanded: false,
                            children: [
                            {"text":"Personal","id":"dotacionpersonal","iconCls":"data","leaf":true,"draggable":false,"href":"dotacion.php","hrefTarget":""},
                            {"text":"Documentos","id":"docdotacionpersonal","iconCls":"report","leaf":true,"draggable":false,"href":"documentosdotacion.php","hrefTarget":""}
                            ]
                            },
                             {
                            text: 'Cliente',
                            expanded: false,
                            children: [
                            {"text":"Cliente","id":"dotacioncliente","iconCls":"data","leaf":true,"draggable":false,"href":"dotacioncliente.php","hrefTarget":""},
                            {"text":"Documentos","id":"docdotacioncliente","iconCls":"report","leaf":true,"draggable":false,"href":"documentosdotacioncliente.php","hrefTarget":""}
                            ]
                            },
                            {
                            text: 'Interna',
                            expanded: false,
                            children: [
                            {"text":"Interna","id":"dotacioninterna","iconCls":"data","leaf":true,"draggable":false,"href":"dotacioninterna.php","hrefTarget":""},
                            {"text":"Documentos","id":"docdotacioninterna","iconCls":"report","leaf":true,"draggable":false,"href":"documentosdotacioninterna.php","hrefTarget":""}
                            ]
                            }
                        ]
                        },{
                            text: 'Armamento',
                            expanded: false,
                            children: [
                            {"text":"Armamento","id":"armamento","iconCls":"data","leaf":true,"draggable":false,"href":"armamento.php","hrefTarget":""},
                            {"text":"Armamento por Clientes","id":"armamento","iconCls":"data","leaf":true,"draggable":false,"href":"armas3.php","hrefTarget":""},
                            {"text":"Documentos","id":"docarmas","iconCls":"report","leaf":true,"draggable":false,"href":"documentosarmas.php","hrefTarget":""}
                            ]
                            },{
                            text: 'Radios',
                            expanded: false,
                            children: [
                            {"text":"Radios","id":"radios","iconCls":"data","leaf":true,"draggable":false,"href":"radios3.php","hrefTarget":""},
                            {"text":"Documentos","id":"docradios","iconCls":"report","leaf":true,"draggable":false,"href":"documentosradios.php","hrefTarget":""}
                            ]
                            }]
                    },{
                            text: 'Clientes',
                            expanded: false,
                            children: [
                                {
                                text: 'Activos',
                                expanded: false,
                                children: [
                                {"text":"Activos","id":"clientes","iconCls":"data","leaf":true,"draggable":false,"href":"clientes3.php","hrefTarget":""},
                                {"text":"Documentos","id":"docclientes","iconCls":"report","leaf":true,"draggable":false,"href":"documentosclientes.php","hrefTarget":""}
                                ]},{
                                text: 'Inactivos',
                                expanded: false,
                                children: [
                                {"text":"Inactivos","id":"clientes","iconCls":"data","leaf":true,"draggable":false,"href":"clienteret.php","hrefTarget":""},
                                {"text":"Documentos","id":"docclientesinactivos","iconCls":"report","leaf":true,"draggable":false,"href":"documentosclientesret.php","hrefTarget":""}
                                ]}
                            ]
                            },{
                            text: 'Gesti&oacute;n Comercial',
                            expanded: false,
                            children: [
                                {
                                text: 'Ofertas',
                                expanded: false,
                                children: [
                                {"text":"Ofertas","id":"ofertas","iconCls":"data","leaf":true,"draggable":false,"href":"procesocomercial3.php","hrefTarget":""},
                                {"text":"Documentos","id":"docofertas","iconCls":"report","leaf":true,"draggable":false,"href":"documentosnecesidades.php","hrefTarget":""}
                                ]},{
                                text: 'Condiciones de Instalaci&oacute;n',
                                expanded: false,
                                children: [
                                {"text":"Condiciones","id":"condiciones","iconCls":"data","leaf":true,"draggable":false,"href":"condiciones3.php","hrefTarget":""},
                                {"text":"Documentos","id":"doccondiciones","iconCls":"report","leaf":true,"draggable":false,"href":"documentoscondiciones.php","hrefTarget":""}
                                ]}
                            ]
                            }, {
                                text: 'Gesti&oacute;n de Operaciones',
                                expanded: false,
                                children: [
                                 {
                                text: 'Radioperaci&oacute;n',
                                expanded: false,
                                children: [
                                {"text":"Radioperaci&oacute;n","id":"radioperacion","iconCls":"data","leaf":true,"draggable":false,"href":"radioperacion.php","hrefTarget":""},
                                {"text":"Documentos","id":"docradioperacion","iconCls":"report","leaf":true,"draggable":false,"href":"documentosradioperacion.php","hrefTarget":""}
                                ]},{
                                text: 'Control de Asistencia',
                                expanded: false,
                                children: [
                                {"text":"Control de Asistencia","id":"controldeasistencia","iconCls":"data","leaf":true,"draggable":false,"href":"asistencia.php","hrefTarget":""},
                                {"text":"Documentos","id":"docasistencia","iconCls":"report","leaf":true,"draggable":false,"href":"documentosasistencia.php","hrefTarget":""}
                                ]},{
                                text: 'Ordenes de Servicio',
                                expanded: false,
                                children: [
                                {"text":"Ordenes de Servicio","id":"ordenesdeservicio","iconCls":"data","leaf":true,"draggable":false,"href":"ordenes3.php","hrefTarget":""},
                                {"text":"Documentos","id":"docordenes","iconCls":"report","leaf":true,"draggable":false,"href":"documentosordenes.php","hrefTarget":""}
                                ]},{
                                text: 'Programaci&oacute;n',
                                expanded: false,
                                children: [
                                {"text":"Programaci&oacute;n","id":"programacion","iconCls":"data","leaf":true,"draggable":false,"href":"programacion.php","hrefTarget":""},
                                {"text":"Documentos","id":"docprogramacion","iconCls":"report","leaf":true,"draggable":false,"href":"documentosprogramacion.php","hrefTarget":""}
                                ]},{
                                text: 'Control de Servicios',
                                expanded: false,
                                children: [
                                {"text":"Control Individual","id":"controlindividual","iconCls":"data","leaf":true,"draggable":false,"href":"controlturnos.php","hrefTarget":""},
                                {"text":"Control Cliente","id":"controlporcliente","iconCls":"data","leaf":true,"draggable":false,"href":"controlcliente.php","hrefTarget":""},
                                {"text":"Documentos","id":"doccontrolservicios","iconCls":"report","leaf":true,"draggable":false,"href":"documentoscontrolturnos.php","hrefTarget":""}
                                ]},{
                                text: 'Escoltas',
                                expanded: false,
                                children: [
                                {"text":"Escoltas","id":"escoltas","iconCls":"data","leaf":true,"draggable":false,"href":"escoltas3.php","hrefTarget":""},
                                {"text":"Documentos","id":"docescoltas","iconCls":"report","leaf":true,"draggable":false,"href":"documentosescoltas.php","hrefTarget":""}
                                ]}
                                ]},{
                                text: 'Correspondencia',
                                expanded: false,
                                children: [
                                {"text":"Correspondencia","id":"correspondencia","iconCls":"data","leaf":true,"draggable":false,"href":"correspondencia3.php","hrefTarget":""},
                                {"text":"Documentos","id":"doccorrespondencia","iconCls":"report","leaf":true,"draggable":false,"href":"documentoscorrespondencia.php","hrefTarget":""}
                                ]},{
                                text: 'Organizaci&oacute;n',
                                expanded: false,
                                children: [
                                {
                                text: 'Organizaci&oacute;n',
                                expanded: false,
                                children: [
                                {"text":"Organizacion","id":"parametrosorganizacion","iconCls":"data","leaf":true,"draggable":false,"href":"empresa3.php","hrefTarget":""},
                                {"text":"Documentos","id":"docempresa","iconCls":"report","leaf":true,"draggable":false,"href":"documentosempresa.php","hrefTarget":""}
                                ]},{
                                text: 'Socios',
                                expanded: false,
                                children: [
                                {"text":"Socios","id":"socios","iconCls":"data","leaf":true,"draggable":false,"href":"socios3.php","hrefTarget":""},
                                {"text":"Documentos","id":"docsocios","iconCls":"report","leaf":true,"draggable":false,"href":"documentossocios.php","hrefTarget":""}
                                ]},{
                                text: 'Departamentos',
                                expanded: false,
                                children: [
                                {"text":"Activos","id":"deptosactivos","iconCls":"data","leaf":true,"draggable":false,"href":"departamentos.php","hrefTarget":""},
                                {"text":"Inactivos","id":"deptosinactivos","iconCls":"data","leaf":true,"draggable":false,"href":"departinactivos.php","hrefTarget":""},
                                ]},{"text":"Sucursales","id":"sucursales","iconCls":"data","leaf":true,"draggable":false,"href":"sucursales.php","hrefTarget":""},
                                     {"text":"Cargos","id":"cargos","iconCls":"data","leaf":true,"draggable":false,"href":"cargos.php","hrefTarget":""}
                                ]},{
                                text: 'Configuraci&oacute;n',
                                expanded: false,
                                children: [
                                {"text":"Registro de Actividades","id":"sistema","iconCls":"data","leaf":true,"draggable":false,"href":"sistema3.php","hrefTarget":""},
                                {"text":"Parametros de Sistema","id":"parametros","iconCls":"data","leaf":true,"draggable":false,"href":"parametros.php","hrefTarget":""},
                                {"text":"Usuarios","id":"usuarios","iconCls":"data","leaf":true,"draggable":false,"href":"usuarios.php","hrefTarget":""},
                                {"text":"Permisos","id":"permisos","iconCls":"data","leaf":true,"draggable":false,"href":"permisos.php","hrefTarget":""},
                                {"text":"Modificaci&oacute;n de Documentos","id":"modificadocs","iconCls":"data","leaf":true,"draggable":false,"href":"modificardocs.php","hrefTarget":""},
                                {"text":"Creador de Documentos","id":"creardocs","iconCls":"data","leaf":true,"draggable":false,"href":"editordocs.php","hrefTarget":""},
                                {"text":"Copia de Seguridad","id":"copiaseguridad","iconCls":"data","leaf":true,"draggable":false,"href":"backup.php","hrefTarget":""}
                                ]},
                                    {"text":"Ayuda","id":"ayuda","iconCls":"dataset","leaf":true,"draggable":false,"href":"ayuda","hrefTarget":"blank"},
                                    {"text":"Salir","id":"salir","iconCls":"data","leaf":true,"draggable":false,"href":"salir.php","hrefTarget":""}
                        ]
                })
            })

            SampleTreePanel.superclass.initComponent.apply(this, arguments);
        }
    });
    Ext.reg('tree_panel', SampleTreePanel);


    // Instantiate the tree panel, then attach an event listener..

    var tree = new SampleTreePanel();

    tree.on('click', function(node, e){
        //debugger;
    }, this);

}catch(er){
    mensajeini(er);
}
});