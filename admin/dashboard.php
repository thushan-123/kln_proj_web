<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../dbconnect.php";

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="approve_post.php">Pending Approve Post</a></li>
            <li><a href="profiles/owner_profiles.php">Owners Details</a></li>
            <li><a href="profiles/seeker_details.php">Seekers Details</a></li>
        </ul>
    </nav>
</body>
</html>