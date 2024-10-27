<?php

session_start();


session_unset();


session_destroy();

header("Location: ./login.php");  // redir the owner login page
exit();
?>