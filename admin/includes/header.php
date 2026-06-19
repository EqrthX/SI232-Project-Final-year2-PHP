<header>
    <section class="header">
        <h1><a href="index.php" class="icon"> Admin <span>Panel</span></a></h1>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="products.php">products</a>
            <a href="orders.php">orders</a>
            <a href="reviews.php">reviews</a>
        </nav>

        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>username : <span><?php echo htmlspecialchars($_SESSION['admin_user']); ?></span></p>
            <p>email : <span><?php echo htmlspecialchars($_SESSION['admin_email']); ?></span></p>
            <a href="../logout.php" class="delete-btn">logout</a>
        </div> 
    </section>
</header>
