
    
    <header class="site-header">
        <div class="container">
            <!-- Site Logo -->
            <div class="site-logo">
                <a href="index.php">
                    <img src="src-img/logo.jpg.png" alt="Site Logo">
                </a>
            </div>

            <div class="serch-bar-div">
                <!-- Search Bar -->
                <form class="search-bar" action="index.php" method="GET">
                    <input type="text" name="search" placeholder="What are you looking for ?" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit"><img src="src-img/search.jpg.png"></button>
                </form>
            </div>

            <!-- Get Started Button -->
            <div class="get-started">
                <?php  if (isset($_SESSION['seeker'])) : ?>
                    <a href="profile.php" class="get-started-btn">My Account</a>
                <?php else: ?>

                    <a href="login.php" class="get-started-btn">Get Started</a>
                <?php  endif; 
                    if (isset($_SESSION['owner'])) :

                ?>
                    <a href="owner/profile.php" class="get-started-btn">My Account</a>
                    <a href="owner/adverticer.php" class="get-started-btn">Post Add</a>

                <?php  endif; ?>

            </div>
        </div>
    </header>
