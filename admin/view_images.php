<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../dbconnect.php";
    include_once "../Function/function.php";

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    if(!isset($_SESSION['admin'])){
        header("Location: ./login.php");
    }

    if(isset($_GET['house_id']) && !empty($_GET['house_id'])){
        $house_id = $_GET['house_id'];

        // retieve images usig house id

        $query = "SELECT * FROM house_images WHERE house_id='$house_id'";
        $result = mysqli_query($connect, $query);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>House Images</h1>

    <?php if(mysqli_num_rows($result)):
        while($row = mysqli_fetch_assoc($result)): ?>

        <img src='../uploads/<?php echo $row['image_name']; ?>' width="200px" height="200px" alt='house_images'>

        <?php  endwhile; 
        else: ?>

            <h3>Image Not found</h3>

        <?php endif; ?>
        
</body>
</html>