<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../dbconnect.php";

    if(!isset($_SESSION['owner'])){
        header('Location: ../owner/login.php');
    }

    echo "<pre>";
    print_r($_SESSION);
    echo  "</pre>";

    $success = false;

    if (isset($_GET['plan_ID']) && !empty($_GET['plan_ID'])){
        $plan_ID = $_GET['plan_ID'];
        $sql = "SELECT * FROM subscription_plans WHERE plan_ID = '$plan_ID' LIMIT 1";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $price =  $row['plan_price'];
        }
    }

    if  (isset($_GET['payment']) && $_GET['payment'] == "success"){
        $ref_no =  $_GET['ref_no'];
        $owner_id = $_SESSION['owner']['owner_id'];
        $plan_id = (int) $_GET['plan_id'];
        $sql = "INSERT INTO subscription_payment(payment_ID,date,owner_ID) VALUES('$ref_no',CURRENT_DATE,'$owner_id')";
        mysqli_query($connect, $sql);

        $s_q = "SELECT * FROM owner_plan WHERE owner_ID='$owner_id'";
        $result = mysqli_query($connect, $s_q);

        $date = new DateTime();

        if($plan_id == 1){
            $date->modify('+1 months');
        }elseif($plan_id ==2){
            $date->modify('+6 months');
        }else{
            $date->modify('+12 months');
        }
        $date = $date->format('Y-m-d');

        if (mysqli_num_rows($result) > 0) {
            $q = "UPDATE  owner_plan SET plan_ID='$plan_id',end_date='$date' WHERE owner_ID='$owner_id'";
        }else{
            $q = "INSERT INTO owner_plan(owner_ID,plan_ID,end_date) VALUES('$owner_id','$plan_id','$date')";
        }

        if (mysqli_query($connect,$q)){
            $success = true;
        }
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
    <h2>Payments</h2>
    <form action="gateway.php" method="post">
        <?php if(isset($_GET['plan_ID'])  && !empty($_GET['plan_ID'])): ?>
        <lable>plan ID : <?php echo $plan_ID ?></lable><br><br>
        <lable>price: <?php echo  $price ?></lable><br><br>
        <input type="hidden" name="plan_ID" value="<?php echo $plan_ID ?>">
        <input type="hidden" name="price" value="<?php echo $price ?>">
        <button type="submit" name="pay">pay here</button>
        <?php endif; ?>
    </form>

    <?php  if($success): ?>
        <h2>payment success</h2>
        <?php endif; ?>
</body>
</html>