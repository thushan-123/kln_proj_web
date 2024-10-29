<?php

    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once "../dbconnect.php";

    if(!isset($_SESSION['owner'])) {
        header("Location: ./login.php");
    }
    /*
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    */
   $owner_id =  $_SESSION['owner']['owner_id'];

    $query = "SELECT * FROM  owner_plan WHERE owner_ID = '$owner_id' LIMIT 1";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)==0){
        header("Location:  ./plan.php");
    } 

    $data = mysqli_fetch_assoc($result);
    $exp_date = $data['end_date'];

    $current_date = date("Y-m-d"); 
    if (strtotime($current_date) > strtotime($exp_date)) {
        header("Location: ./plan.php?owner_plan=expired");
    }

    $errors = [];

    if (isset($_POST['post_add'])){
        $house_id = uniqid();
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = (float) $_POST['price'];
        $category_id = $_POST['category_id'];
        $location_id = $_POST['location_id'];
        $address = $_POST['address'];
        $room_count =  $_POST['room_count'];

        

        $images =  $_FILES['images'];   // asosiative array

        $owner_id = $_SESSION['owner']['owner_id'];

        $insert_q_data = "INSERT INTO houses(house_id,category_id,location_id,address,title,description,room_count,price,owner_ID)
                     VALUES ('$house_id','$category_id','$location_id','$address','$title','$description','$room_count','$price','$owner_id')";

        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";  

        if(!mysqli_query($connect,$insert_q_data)){
            $errors[] = "Error in inserting data";
            exit;
        }
    
        for ($i = 0; $i < count($images['name']); $i++) {
            // Extract each file's details
            $file_name = $images['name'][$i];
            $file_tmp = $images['tmp_name'][$i];
            $file_type = $images['type'][$i];
            $file_size = $images['size'][$i];
            $file_error = $images['error'][$i];

            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $unique_file_name = uniqid() . '.' . $file_extension;

            if( ! in_array($file_extension, ['png','jpg','jpeg']) ){
                $errors[] = "Invalid file type";
            }

            $save_dir = (string) "../uploads/". $unique_file_name;
            

            if(move_uploaded_file($file_tmp, $save_dir)){
                $insert_img = "INSERT INTO house_images(house_id,image_name) VALUES ('$house_id','$unique_file_name')";

                if(!mysqli_query($connect,$insert_img)){

                    $errors[] =  "Error in inserting image";
                    
                }
            }
        
            
        }

        if(count($errors) == 0){
            header("Location: ./adverticer.php?upload=success");
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

    <?php  include_once "./owner_nav.php"; ?>
    <span color="red">
        <?php

            if(count($errors)>0){
                foreach($errors as $error){
                    echo $error . "<br>";
                }
            }
        ?>
    </span>

    <form action="<?php echo htmlspecialchars("adverticer.php"); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateFiles();">
        <lable>Category :</lable>
        <select name="category_id">
            <?php
            $query = "SELECT * FROM category";
            $result = mysqli_query($connect,$query);

            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
                }
            }
            ?>
        </select> <br><br>

        <lable>location</lable>
        <select name="location_id">
        <?php
            $query = "SELECT * FROM location";
            $result = mysqli_query($connect,$query);

            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<option value='".$row['location_id']."'>".$row['location_name']."</option>";
                }
            }
            ?>
        </select> <br><br>
        <label>Address</label>
        <input type="text" name="address"  placeholder="address" required> <br><br>

        <label>title</label>
        <input type="text" name="title" placeholder="title" required> <br><br>

        <lable>description</lable>
        <textarea name="description" placeholder="description" required></textarea> <br><br>

        <lable>Room Count</lable>
        <input type="number" name="room_count" placeholder="features" required> <br><br>

        <lable>price</lable>
        <input type="number" name="price" placeholder="price" required> <br><br>

        <label for="images">Upload Images:</label>
        <input type="file" id="images" name="images[]" accept="image/*" multiple required>
        <small>(Minimum 1 image, Maximum 5 images)</small><br><br>

        

        <button type="submit" name="post_add">Add Post</button>
    </form>

    
<script>
function validateFiles() {
    const files = document.getElementById('images').files;
    if (files.length < 1) {
        alert("Please upload at least 1 image.");
        return false;
    } else if (files.length > 5) {
        alert("You can only upload a maximum of 5 images.");
        return false;
    }
    return true;
}
</script>
</body>
</html>