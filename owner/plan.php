<?php

    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once "../dbconnect.php";

    if(!isset($_SESSION['owner'])) {
        header("Location: ./index.php");
    }

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

   

    

?>