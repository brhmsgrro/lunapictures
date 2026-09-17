<?php
session_start();
unset($_SESSION ['acceso']);
$_SESSION ['codCli']="";
session_destroy();
header("Location: Catalogo.php")
?>