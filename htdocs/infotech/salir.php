<?php
session_start();
session_unset();
session_destroy();
session_unset($_SESSION['iuj345iuh']);
//exit();
?>
<html>
<head>
<script language="JavaScript" type="text/JavaScript">
<!--
    var pagina = 'index.php';
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