<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../dbconnect.php";


    // get the subscripton 

    $sql_q = "SELECT * FROM subscription_plans";
    $result = mysqli_query($connect, $sql_q);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/subscription.css?v=<?php echo time(); ?>">

    
</head>
<body>

    <?php 
        include_once "./owner_nav.php";  // import navigtion bar
    ?>

    <h2>Subscription Types</h2>

    <div class="container">
        <?php if (mysqli_num_rows($result) > 0): 
            while ($row = mysqli_fetch_assoc($result)): ?>
            <div id="card">
                <h3><?php echo $row['plan_type'] ?></h3>
                <label>Rs <?php echo (int)$row['plan_price'] ?>/=</label>
            <div>
        <?php endwhile;
        else: ?>
        <p>No subscription plans not found</p>
        <?php endif; ?>
    </div>
    
</body>
</html>