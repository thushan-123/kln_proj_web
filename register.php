<?php

 error_reporting(E_ALL);
 ini_set('display_errors', 1);

 include "dbconnect.php";

    // Initialize error messages
    $errors = [
        'firstname' => '',
        'lastname' => '',
        'contact' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'user_type' => ''
    ];

    // Initialize input values
    $firstname = $lastname = $contact = $email = $password = $confirm_password = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (isset($_POST['sign_up_submit'])){

            if(!isset($_POST['user_type'])){
                $errors['user_type'] = 'Please select a user type';
            }else{
                $user_type = clean_input($_POST['user_type']);
            }
            // Sanitize input
            
            $firstname = clean_input($_POST["firstname"]);
            $lastname = clean_input($_POST["lastname"]);
            $contact = clean_input($_POST["contact"]);
            $email = clean_input($_POST["email"]);
            $password = clean_input($_POST["password"]);
            $confirm_password = clean_input($_POST["confirm_password"]);

            // check user_type  nll
            /*
            if (empty($user_type)) {
                $errors['user_type'] = 'Please select user type';
            }
            */

            // First name validation: only letters
            if (empty($firstname)) {
                $errors['firstname'] = "*First name is required";
            } elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
                $errors['firstname'] = "*First name can only contain letters";
            }

            // Last name validation: only letters
            if (empty($lastname)) {
                $errors['lastname'] = "*Last name is required";
            } elseif (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
                $errors['lastname'] = "*Last name can only contain letters";
            }

            // Sri Lankan contact number validation
            if (empty($contact)) {
                $errors['contact'] = "*Contact number is required";
            } elseif (!preg_match("/^(\+94|0)?7[0-9]{8}$/", $contact)) {
                $errors['contact'] = "*Please enter a valid Sri Lankan mobile number";
            }

            // Email validation
            if (empty($email)) {
                $errors['email'] = "*Email is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "*Please enter a valid email address";
            } else {
                // Check if email already exists in the database

                if($user_type == 'seeker'){
                    $sql = "SELECT * FROM seeker WHERE email = ?";
                }else{
                    $sql = "SELECT * FROM owner WHERE email = ?";
                }
                
                $stmt = mysqli_prepare($connect, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $errors['email'] = "*This email is already registered";
                }

                mysqli_stmt_close($stmt);
            }

            // Password validation: minimum 5 characters
            if (empty($password)) {
                $errors['password'] = "*Password is required";
            } elseif (strlen($password) < 5) {
                $errors['password'] = "*Password must be at least 5 characters long";
            }

            // Confirm password validation
            if (empty($confirm_password)) {
                $errors['confirm_password'] = "*Please confirm your password";
            } elseif ($password !== $confirm_password) {
                $errors['confirm_password'] = "*Passwords do not match";
            }

            // If there are no errors, proceed with registration
            if (!array_filter($errors)) {
                // Hash the password before storing it
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                

                if($user_type == 'seeker'){
                    $seeker_id = uniqid();

                    $sql = "INSERT INTO seeker (seeker_ID,email, password, contact_no, first_name, last_name) VALUES (?,?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connect, $sql);
                    mysqli_stmt_bind_param($stmt, "ssssss",$seeker_id, $email, $hashed_password, $contact, $firstname, $lastname);
                }else{

                    
                    $sql = "INSERT INTO owner (owner_ID,email, password, contact_no, first_name, last_name) VALUES (?,?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connect, $sql);
                    mysqli_stmt_bind_param($stmt, "ssssss",$seeker_id, $email, $hashed_password, $contact, $firstname, $lastname);
                }

                // Insert data into the database
                

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: login.php?message=Registration successful!");
                } else {
                    echo "Error: " . mysqli_error($connect);
                }

                mysqli_stmt_close($stmt);
            }

        }
        
    }
    // Function to clean input
    function clean_input($data) {
        return htmlspecialchars(trim($data));
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="login-registration-style.css">
</head>
<body>
    <div class="container" id="signUp" >
        <h1 class="form-title">Register</h1>
        <form action="" method="post">

        <label>seeker</label>
        <input type="radio" name="user_type" value="seeker" id="" cheked> 

        <lable>adverticer</lable>
        <input type="radio" name="user_type" value="adverticer" id=""> 
        <span class="error-message" ><?php echo $errors['user_type']; ?></span>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="firstname" id="first_name" placeholder="First Name" value="<?php echo $firstname; ?>">
                <label for="firstname">First Name</label>
                <span class="error-message" ><?php echo $errors['firstname']; ?></span>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lastname" id="last_name" placeholder="Last Name" value="<?php echo $lastname; ?>">
                <label for="last_name"><Label></Label>Last Name</label>
                <span class="error-message" ><?php echo $errors['lastname']; ?></span>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>">
                <label for="email">Email</label>
                <span class="error-message" ><?php echo $errors['email']; ?></span>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="tel" name="contact" id="contact" placeholder="Contact Number" value="<?php echo $contact; ?>">
                <label for="contact_no">Contact Number</label>
                <span class="error-message" ><?php echo $errors['contact']; ?></span>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>">
                <label for="password">Password</label>
                <span class="error-message" ><?php echo $errors['password']; ?></span>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                <label for="confirm_password">Confirm Password</label>
                <span class="error-message" ><?php echo $errors['confirm_password']; ?></span>
            </div>
            <input type="submit" name="sign_up_submit" class="btn" value="Sign Up">

        </form>
        <p class="or">
            ---------or---------
        </p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Already Have Account ?</p>
            <a href="login.php"><button id="signInButton">Sign In</button></a>
        </div>
    </div>
    
</body>
</html>