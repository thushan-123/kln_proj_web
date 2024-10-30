<?php

    $host_name = "127.0.0.1";
    $db_username = "thush";
    $db_password = "thush";
    $db_name = "stayfinder";

    $connect = mysqli_connect($host_name,$db_username,$db_password,$db_name);

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>