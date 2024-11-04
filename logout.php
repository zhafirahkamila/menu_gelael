<?php 
    session_start();

    session_destroy();
    header('location: ../menu_gelael/login.php');
?>