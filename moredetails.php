<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "./dbconnect.php";
include_once "./Function/function.php";

if (isset($_GET['house_ID']) && !empty($_GET['house_ID'])) {  // Fixing variable name here
    $house_ID = user_input($_GET['house_ID']);

    $query = "SELECT houses.location_id, houses.address, houses.title, houses.description, houses.price, houses.room_count, 
              owner.email, owner.contact_no, owner.first_name, owner.last_name
              FROM houses INNER JOIN owner 
              ON houses.owner_ID = owner.owner_ID
              WHERE houses.house_id = '$house_ID' AND houses.is_approved=true";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Error: Unable to fetch house details.";
        exit;
    }

    $img_q = "SELECT * FROM house_images WHERE house_id = '$house_ID'";
    $img_result = mysqli_query($connect, $img_q);

    if (!$img_result) {
        echo "Error: Unable to fetch house images.";
        exit;
    }

    $query_ = "SELECT * FROM location";
    $result_ = mysqli_query($connect, $query_);
    $location = [];

    while ($row = mysqli_fetch_assoc($result_)) {
        $location[$row['location_id']] = $row['location_name'];
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
    <?php include_once "./header-1.php"; ?>

    <div>
        <?php if (isset($data)): ?>
            <?php while ($row = mysqli_fetch_assoc($img_result)): ?>
                <img src="uploads/<?php echo $row['image_path']; ?>" alt="house images" width="200" height="200">
            <?php endwhile; ?>

            <label>Location: <?php echo $location[$data['location_id']] ?? 'N/A'; ?></label>
            <label>Address: <?php echo $data['address']; ?></label>
            <label>Title: <?php echo $data['title']; ?></label>
            <label>Description: <?php echo $data['description']; ?></label>
            <label>Price: <?php echo $data['price']; ?></label>
            <label>Room Count: <?php echo $data['room_count']; ?></label>
            <label>Owner Email: <?php echo $data['email']; ?></label>
            <label>Owner Contact No: <?php echo $data['contact_no']; ?></label>
            <label>Owner First Name: <?php echo $data['first_name']; ?></label>
            <label>Owner Last Name: <?php echo $data['last_name']; ?></label>
        <?php else: ?>
            <p>House details not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
