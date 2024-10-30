<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "./dbconnect.php";
include_once "./Function/function.php";

if (isset($_GET['house_ID']) && !empty($_GET['house_ID'])) {  
    $house_ID = user_input($_GET['house_ID']);

    $query = "SELECT * FROM houses WHERE house_id = '$house_ID' AND is_approved=true ";
    $result = mysqli_query($connect, $query);

    if ( mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Not Found";
        exit;
    }

    if($data){
        $owner_ID = $data['owner_ID'];
        $q = "SELECT * FROM  owner WHERE owner_ID = '$owner_ID'";
        $r = mysqli_query($connect, $q);
        $owner_data = mysqli_fetch_assoc($r);
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
    <style>
        .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        }

        
        .modal-content {
        background-color: #fefefe;
        margin: 15% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
        }

        
        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include_once "./header-1.php"; ?>

    <div>
        <?php if (isset($data)): ?>
            <?php while ($row = mysqli_fetch_assoc($img_result)): ?>
                <img src="uploads/<?php echo $row['image_name']; ?>" alt="house images" width="200" height="200">
            <?php endwhile; ?>
            
            <br><br>

            <label>Location: <?php echo $location[$data['location_id']] ?? 'N/A'; ?></label><br><br>
            <label>Address: <?php echo $data['address']; ?></label><br><br>
            <label>Title: <?php echo $data['title']; ?></label><br><br>
            <label>Description: <?php echo $data['description']; ?></label><br><br>
            <label>Price: <?php echo $data['price']; ?></label><br><br>
            <label>Room Count: <?php echo $data['room_count']; ?></label><br><br>
            

            <button id="myBtn">Open Modal</button>

            
            <div id="myModal" class="modal">

            <div class="modal-content">
                <span class="close">&times;</span>
                <?php if(isset($_SESSION['seeker']) || isset($_SESSION['owner'])): ?>
                    <h4>Owner Details</h4>
                    <label>Owner Email: <?php echo $owner_data['email']; ?></label><br><br>
                    <label>Owner Contact No: <?php echo $owner_data['contact_no']; ?></label><br><br>
                    <label>Owner First Name: <?php echo $owner_data['first_name']; ?></label><br><br>
                    <label>Owner Last Name: <?php echo $owner_data['last_name']; ?></label><br><br>
                <?php else: ?>
                    <h4>Please login here: </h4> <br><br>
                    <button type="button" onclick="window.location.href='login.php'">Login Now</button>
                    
                <?php endif; ?>
            </div>

            </div>


            
        <?php else: ?>
            <p>House details not found.</p>
        <?php endif; ?>
    </div>

    <script>
        
        var modal = document.getElementById("myModal");

        
        var btn = document.getElementById("myBtn");

        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
        modal.style.display = "block";
        }

        span.onclick = function() {
        modal.style.display = "none";
        }

        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
</script>
</body>
</html>
