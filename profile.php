<?php

    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once "./dbconnect.php";
    include_once "./Function/function.php";

    if(!isset($_SESSION['seeker'])) {
        header("Location: ./index.php");
    }

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    $seeker_id = $_SESSION['seeker']['seeker_id'];
    $seeker_firstname = $_SESSION['seeker']['firstname'];
    $seeker_lastname = $_SESSION['seeker']['lastname'];
    $seeker_email = $_SESSION['seeker']['email'];
    $seeker_contact_no = $_SESSION['seeker']['contact_no'];

    $errors =[];

   if(isset($_POST['update_details'])){

        $firstname = user_input($_POST['firstname']);
        $lastname = user_input($_POST['lastname']);
        $email = user_input($_POST['email']);
        $contact_no = user_input($_POST['contact_no']);

        if(empty($firstname)  || empty($lastname) || empty($email) || empty($contact_no)){
            $errors[] = "Please fill all the fields";
        }

        if (count($errors)==0){
            $insert_q = "UPDATE  seeker SET email='$email' , first_name='$firstname', last_name='$lastname', contact_no='$contact_no' WHERE seeker_ID='$seeker_id'";

            if(mysqli_query($connect,$insert_q)){
                $_SESSION['seeker']['firstname'] = $firstname;
                $_SESSION['seeker']['lastname'] = $lastname;
                $_SESSION['seeker']['email'] = $email;
                $_SESSION['seeker']['contact_no'] = $contact_no;
                header("Location: ./profile.php");
            }
        }
   }

   
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>s
<body>
    <header>
        <h2>My profile</h2>
    </header>

    <h3>details :</h3>

    <form action="profile.php" method="post">
        <span>
            <?php
                foreach($errors as $error){
                    echo $error;
                }
            ?>
        </span>
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $seeker_firstname ?>" required> <br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $seeker_lastname ?>" required> <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $seeker_email ?>" required> <br><br>

        <label for="lastname">Mobile:</label>
        <input type="text" id="contact_no" name="contact_no" value="<?php echo $seeker_contact_no ?>" required ><br> <br>

        <button type="submit" name="update_details">Update</button>
    </form>
     

</body>
</html>