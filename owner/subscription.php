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

    <?php include_once "./owner_nav.php"; ?>

    <h2>Subscription Types</h2>

    <div class="container">
        <?php if (mysqli_num_rows($result) > 0): 
            while ($row = mysqli_fetch_assoc($result)): 
                
                $unique_id = $row['plan_ID']; 
        ?>
            <div id="card">
                <h3><?php echo $row['plan_type'] ?></h3>
                <label>Rs <?php echo (int)$row['plan_price'] ?>/=</label> <br><br>
                
                <button id="myBtn_<?php echo $unique_id; ?>">Buy Now</button>

                <div id="myModal_<?php echo $unique_id; ?>" class="modal">
                    <class="modal-content">
                        <span class="close" data-modal="myModal_<?php echo $unique_id; ?>">&times;</span>
                        <?php if(isset($_SESSION['owner'])): ?>
                            <h4>Plan Details</h4>
                            <p>Plan Type: <?php echo $row['plan_type']; ?></p>
                            <p>Plan Price: <?php echo (int)$row['plan_price']; ?>/=</p>

                            <button type="button" onclick="window.location.href='../payment/payment.php?plan_ID=<?php echo $row['plan_ID']; ?>'"> Buy Now </button>
                        <?php else: ?>
                            <h4>Please login here:</h4> <br><br>
                            <button type="button" onclick="window.location.href='login.php'">Login Now</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile;
        else: ?>
            <p>No subscription plans found</p>
        <?php endif; ?>
    </div>

    <script>
        
        document.querySelectorAll("button[id^='myBtn_']").forEach(btn => {
            btn.addEventListener("click", function() {
                const uniqueId = this.id.split('_')[1];
                document.getElementById(`myModal_${uniqueId}`).style.display = "block";
            });
        });

        
        document.querySelectorAll(".close").forEach(span => {
            span.addEventListener("click", function() {
                const modalId = this.getAttribute("data-modal");
                document.getElementById(modalId).style.display = "none";
            });
        });

        
        window.onclick = function(event) {
            document.querySelectorAll(".modal").forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        }
    </script>
    
</body>
</html>
