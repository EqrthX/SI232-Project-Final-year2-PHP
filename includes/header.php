<section class="header">
    <?php if (isset($user_id)): ?>
        <h1><a href="index.php" class="icon"> C-game <span>Shop</span></a></h1> 
    <?php else: ?>
        <h1><a href="index.php" class="icon"> C-game <span>Shop</span></a></h1> 
    <?php endif; ?>

    <nav class="navbar">       
        <form action="search.php" method="post">
            <input type="text" name="keyword" id="keyword" placeholder="ค้นหา">
            <button type="submit" name="submit" class="fa fa-search"></button>
        </form>
    </nav>
    
    <?php if (isset($user_id)): ?>
        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <a href="cart.php" id="cart-btn" class="fa fa-shopping-cart" style="font-size:30px;"></a>
        </div>

        <div class="account-box">
            <p>username : <span><?php echo htmlspecialchars($_SESSION['user_username']); ?></span></p>
            <p>email : <span><?php echo htmlspecialchars($_SESSION['user_email']); ?></span></p>
            <a href="profile.php" class="waring-btn">edit</a>
            <a href="orders.php" class="order-btn">order</a>
            <a href="reviews.php" class="review-btn">review</a>
            <a href="logout.php" class="delete-btn">logout</a>
        </div> 
    <?php else: ?>
        <ul>
            <li><a href="login.php"><span class="l">Login</span></a></li>
            <li><a href="register.php"><span class="r">Register</span></a></li>
        </ul>
    <?php endif; ?>
</section>
