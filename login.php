<?php

    // Start the session
    session_start();

    include "dbconnect.php";

    // Initialize error messages
    $errors = [
        'email' => '',
        'password' => ''
    ];

    // Initialize input values
    $email = $password = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['sign_in_submit'])){

        // Sanitize input
        $email = clean_input($_POST["email"]);
        $password = clean_input($_POST["password"]);

        // Email validation
        if (empty($email)) {
            $errors['email'] = "*Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "*Please enter a valid email address";
        }

        // Password validation
        if (empty($password)) {
            $errors['password'] = "*Password is required";
        }

        }

        // If no errors, check for email and password in the database
        if (!array_filter($errors)) {
            // Check if the user exists in the database
            $sql = "SELECT * FROM seeker WHERE email = ?";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                // Verify the hashed password
                if (password_verify($password, $user['password'])) {
                    // Store user information in the session
                    $_SESSION['seeker']['seeker_id'] = $user['seeker_ID']; 
                    $_SESSION['seeker']['email'] = $user['email'];
                    $_SESSION['seeker']['firstname'] = $user['first_name'];
                    $_SESSION['seeker']['lastname'] = $user['last_name'];
                    $_SESSION['seeker']['contact_no'] = $user['contact_no'];
                    
                    
    
                    // Redirect to a protected page (dashboard.php)
                    
                    header("Location: ./index.php");
                    
                    
                    exit();
                } else {
                    $errors['password'] = "*Incorrect password";
                }
            } else {
                $errors['email'] = "*No account found with this email";
            }
    
            mysqli_stmt_close($stmt);
        }
    }
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
<div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form action="" method="post">

            
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>">
                <label for="email">Email</label>
                <span class="error-message"><?php echo $errors['email']; ?></span>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>">
                <label for="password">Password</label>
                <span class="error-message"><?php echo $errors['password']; ?></span>
            </div>
            <p class="recover">
                <a href="#">Forget Password</a>
            </p>
            <input type="submit" name="sign_in_submit" class="btn" value="Sign In">

        </form>
        <p class="or">
            ---------or---------
        </p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Don't have account yet ?</p>
            <a href="register.php"><button id="signUpButton">Sign Up</button></a>
        </div>
    </div>
</body>