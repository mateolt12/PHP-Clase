<?php
        session_start();
        echo "Adios " .$_SESSION["user"];
        echo "<br> Serás redirigido a la pagina principal en 3 segundos MA NIGGA.";
        session_unset();
        session_destroy();
        header('refresh:3;url=login.php');
?>
 