<header>

    <section class="header">

        <h1><a href="adminPage.php" class="icon"> Admin <span>Panel</span></a></h1>

        <nav class="navbar">

            <a href="adminPage.php">home</a>
            <a href="adminProduct.php">products</a>
            <a href="adminOrder.php">orders</a>
            <a href="adminReviews.php">reviews</a>

        </nav>

        <div class="icons">

            <div id="user-btn" class="fas fa-user"></div>

        </div>

        <div class="account-box">

            <p>username : <span><?php echo $_SESSION['admin_user']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="Logout.php" class="delete-btn">logout</a>
            
        </div> 
        
    </section>

</header>