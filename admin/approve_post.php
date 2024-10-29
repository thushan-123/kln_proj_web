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


    //retrieve not approved
    $sql = "SELECT * FROM houses WHERE is_approved = false";
    $data_set = mysqli_query($connect,$sql);


    $query = "SELECT * FROM location";
    $result = mysqli_query($connect, $query);
    $location = [];

    while($row = mysqli_fetch_assoc($result)){
        $location[$row['location_id']] =  $row['location_name'];
    }

    //print_r($location);
    //echo $location[1];

    if(isset($_POST['approved'])){
        $house_id = user_input($_POST['house_id']);

        $update_q =  "UPDATE houses SET is_approved = true, approved_date = CURRENT_DATE WHERE house_id = '$house_id'";

        if(mysqli_query($connect,$update_q)){
            header("Location: ./approve_post.php");
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
    <table border="1">
        <tr>
            <th>House ID</th>
            <th>Location</th>
            <th>Address</th>
            <th>Title</th>
            <th>Price</th>
            <th>Room Count</th>
            <th>Owner ID</th>
            <th>View Images</th>
            <th></th>
        </tr>
        <?php while( $row  = mysqli_fetch_assoc($data_set) ): ?>
            <tr>
                <td><?php echo $row['house_id']; ?></td>
                <td><?php echo $location[$row['location_id']]; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['room_count']; ?></td>
                <td><?php echo $row['owner_ID']; ?></td>   
                <td>
                    <a href="view_images.php?house_id=<?php echo $row['house_id']; ?> ">click</a>
                </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="house_id" value="<?php echo $row['house_id'] ?>">
                        <button type="submit" name="approved">Approve</button>
                    </form>
                </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php 

    mysqli_close($connect);

?>
