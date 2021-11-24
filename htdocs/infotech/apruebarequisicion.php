<?php
session_start();

@require('funciones2.php');

$link=validar("","","", 72);

formularioactual();

$r=@require('version.php');
caracteresiso();
$colcuerpo="#FAFAFA";
$coltabla="#67BFFD";

?>
<link	rel="stylesheet" href="estilo2.css" type="text/css">
<link	rel="stylesheet" href="botones.css" type="text/css">

<!-- ** CSS ** -->
    <!-- base library -->
    <link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

    <!-- overrides to base library -->
    <link rel="stylesheet" type="text/css" href="ext/examples/ux/css/GroupSummary.css" />

    <!-- page specific -->
    <link rel="stylesheet" type="text/css" href="ext/examples/shared/examples.css" />
    <link rel="stylesheet" type="text/css" href="ext/examples/grid/grid-examples.css" />

    <style type="text/css">
        #ext-gen3{
        margin-left: 220px;
        }
        .x-grid3-cell-inner {
            font-family:"segoe ui",tahoma, arial, sans-serif;
        }
        .x-grid-group-hd div {
            font-family:"segoe ui",tahoma, arial, sans-serif;
        }
        .x-grid3-hd-inner {
            font-family:"segoe ui",tahoma, arial, sans-serif;
            font-size:12px;
        }
        .x-grid3-body .x-grid3-td-cost {
            background-color:#f1f2f4;
        }
        .x-grid3-summary-row .x-grid3-td-cost {
            background-color:#e1e2e4;
        }
        .icon-grid {
            background-image:url(ext/examples//shared/icons/fam/grid.png) !important;
        }
        .x-grid3-dirty-cell {
            background-image:none;
        }
    </style>

    <!-- ** Javascript ** -->
    <!-- ExtJS library: base/adapter -->
    <script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>

    <!-- ExtJS library: all widgets -->
    <script type="text/javascript" src="ext/ext-all.js"></script>

    <!-- extensions -->
    <script type="text/javascript" src="ext/examples/ux/GroupSummary.js"></script>

    <!-- page specific -->
    <script type="text/javascript" src="ext/examples/grid/expExcel.js"></script>

    <!-- page specific -->
    <script type="text/javascript" src="ext/examples/grid/totalinfoReq.js"></script>
    <script type="text/javascript" src="scripts/menu.js"></script>

</head>
<body<?php if($mens!=""){echo " onload=\"mensajeini('".addslashes($mens)."');return false;\"";}?>>
    <div id="formRequisiciones"></div>
    <div style="display:inline;position: absolute">
<div id="controlex">
<table class="control">
	<tr>
		<td colspan="2" class="arriba">Aprobaci&oacute;n de Requisici&oacute;n
		</td>
	</tr>
	<tr height="10px" valign="top">
		<td valign="middle" align="center"><input type="submit" class="botobusca"
			value="Buscar" name="ejecut" id="botonbuscar"></td>
	</tr>
	<tr height="10px">
            <td valign="middle" colspan="2" align="center">
                <select id="tiporeq" class="largo1">
                    <option value="1" id="optiporeq1">No Revisadas</option>
                    <option value="2" id="optiporeq2">Aprobadas</option>
                    <option value="3" id="optiporeq3">Rechazadas</option>
                    <option value="%" id="optiporeq">Todas</option>
                </select>
            </td>
	</tr>
	<tr height="10px">
		<td colspan="2" align="center">
                </td>
	</tr>
</table>
<div id="divMenu" class="divMenu"></div><?php require('saludos.php');?>
</div>
</div>
</body>
</html>
