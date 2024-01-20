<?php // comprueba la existencia de usuario autenticado
   session_start();
   if ($_SESSION["autentificado"] != true){
    header("Location: login.php");
    exit();
    }

?>