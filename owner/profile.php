<?php

    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once "../dbconnect.php";
    include_once "../Function/function.php";

    if(!isset($_SESSION['owner'])) {
        header("Location: ./index.php");
    }

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    $owner_id = $_SESSION['owner']['owner_id'];
    $owner_firstname = $_SESSION['owner']['firstname'];
    $owner_lastname = $_SESSION['owner']['lastname'];
    $owner_email = $_SESSION['owner']['email'];
    $owner_contact_no = $_SESSION['owner']['contact_no'];

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
            $insert_q = "UPDATE  owner SET email='$email' , first_name='$firstname', last_name='$lastname', contact_no='$contact_no' WHERE owner_id='$owner_id'";

            if(mysqli_query($connect,$insert_q)){
                $_SESSION['owner']['firstname'] = $firstname;
                $_SESSION['owner']['lastname'] = $lastname;
                $_SESSION['owner']['email'] = $email;
                $_SESSION['owner']['contact_no'] = $contact_no;
                header("Location: ./profile.php");
            }
        }
   }

   $query = "SELECT owner_plan.plan_ID,end_date,plan_type,plan_price FROM  owner_plan 
             INNER JOIN subscription_plans ON  owner_plan.plan_ID = subscription_plans.plan_ID WHERE owner_plan.owner_ID='$owner_id'";

    $result = mysqli_query($connect,$query);

    $rt_q = "SELECT * FROM houses WHERE  owner_ID='$owner_id'";
    $rt_d = mysqli_query($connect,$rt_q);
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
        <input type="text" id="firstname" name="firstname" value="<?php echo $owner_firstname ?>" required> <br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $owner_lastname ?>" required> <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $owner_email ?>" required> <br><br>

        <label for="lastname">Mobile:</label>
        <input type="text" id="contact_no" name="contact_no" value="<?php echo $owner_contact_no ?>" required ><br> <br>

        <button type="submit" name="update_details">Update</button>
    </form>

    <div>
        <h3>My Subscription:</h3>

        <?php
            if(mysqli_num_rows($result)>0): 
                        $row = mysqli_fetch_assoc($result)
        ?>
            <table>
                <tr>
                    <th>Plan Name</th>
                    <th>Plan Price</th>
                    <th>Plan Duration</th>
                    <th>Plan Status</th>
                </tr>
                <tr> 
                    <td><?php  echo $row['plan_type']; ?></td> 
                    <td><?php  echo $row['plan_price']; ?></td> 
                    <td><?php  echo $row['end_date']; ?></td> 
                    <td><?php  $current_date = date("Y-m-d"); 
                            if (strtotime($current_date) > strtotime($row['end_date'])) {
                                echo "Expired";
                            }else{
                                echo "Active";
                            } ?></td>
                </tr>
            </table>
        <?php else: ?>
            <p>No subscription found</p>
        <?php endif; ?>
    </div>

    <div>
        <h3>My Adds:</h3>

        <?php
            if(mysqli_num_rows($rt_d)>0): 
                        
        ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Address</th>
                    <th>Approved</th>
                    <th></th>
                </tr>
                <?php  while($row = mysqli_fetch_assoc($rt_d)): ?>
                <tr> 
                    <td><?php  echo $row['title']; ?></td> 
                    <td><?php  echo $row['address']; ?></td> 
                    <td><?php  echo $row['is_approved']; ?></td> 
                    <td><button type="button" onclick="window.location.href='../moredetails.php?house_ID=<?php echo  $row['house_id']; ?>'">More Details</button></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No Adds found</p>
        <?php endif; ?>
    </div>

    

            

</body>
</html>