<?php

    //session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    /* echo "<pre>";
        print_r($_SESSION);
    echo "</pre>";
*/


?>

<header>
    <h3> hello owner navbar </h3>

    <?php if(isset($_SESSION['owner'])):  ?>
        <lable> <?php  echo $_SESSION['owner']['firstname'] . " " . $_SESSION['owner']['lastname']; ?></lable>
        <button onclick="window.location.href='./profile.php'"> My Account</button>
        <button onclick="window.location.href='./owner_logout.php'"> Logout</button>


    <?php else: ?>
        <button onclick="window.location.href='./login.php'" > Login</button>
    <?php endif ?>
</header>
