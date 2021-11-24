<?php
@session_start();
@require('funciones2.php');
validar($_POST[nombre], $_POST[contra],$_POST[sucursal]);
?>
<html>
<head>
<script language="JavaScript" type="text/JavaScript">
<!--
    var pagina = 'inicio.php';
    var segundos = 2000;
    function redireccion() {
        document.location.href=pagina;
    }
    setTimeout("redireccion()",segundos);
//-->
</script>
</head>
<body onload="redireccion();">
</body>
</html>