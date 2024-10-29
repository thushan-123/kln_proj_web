<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../../dbconnect.php";
    include_once "../../Function/function.php";

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    if(!isset($_SESSION['admin'])){
        header("Location: ../login.php");
    }

    $query = "SELECT * FROM seeker";
    $result = mysqli_query($connect, $query);

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Seekers Details</h1>

    <table border="1">
        <tr>
            <th>Seeker ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Contact no</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['seeker_ID']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['contact_no']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    
</body>
</html>

