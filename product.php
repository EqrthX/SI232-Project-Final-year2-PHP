<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;
    $product_id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$product_id) {
        header("Location: index.php");
        exit();
    }

    function showImagesCarousel() {
        $image_folder = 'upload_images/';
        $images = glob($image_folder . '*');
        if ($images) {
            $active = 'active';
            foreach ($images as $image) {
                ?>
                <div class="carousel-item <?php echo $active ?>">
                    <img src="<?php echo $image ?>" class="d-block w-100" alt="...">
                </div>
                <?php
                $active = '';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php require 'includes/header.php'; ?>

    <div class="show-curosel">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <?php showImagesCarousel(); ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <nav class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Catagory</a></li>
            <li><a href="about.php">About us</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <?php 
        $imgF = "upload_images/";
        $imgFiles = glob($imgF . "*");
        
        $sql = "SELECT products.*, categories.category_name FROM products 
                INNER JOIN categories ON products.category_id = categories.category_id
                WHERE products.product_id = $product_id";
        $result = mysqli_query($conn, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            $fetch_product = mysqli_fetch_assoc($result);
            $productImage = basename($fetch_product["image_url"]);
            
            if(in_array($productImage, array_map('basename', $imgFiles))) {
                ?>
                <?php if (isset($user_id)): ?>
                    <form action="cart.php" method="post" enctype="multipart/form-data">
                <?php endif; ?>

                <div class="product-box">
                    <div class="box-item">
                        <a href="index.php" class="arrow">&#x2190;</a>
                        
                        <?php if (isset($user_id)): ?>
                            <input type="hidden" name="product_id" value="<?php echo $fetch_product["product_id"]; ?>">
                        <?php endif; ?>

                        <div class="box-img">
                            <img src="upload_images/<?php echo htmlspecialchars($fetch_product["image_url"]); ?>" alt="">
                            <?php if (isset($user_id)): ?>
                                <input type="hidden" name="images" value="<?php echo htmlspecialchars($fetch_product["image_url"]); ?>">
                            <?php endif; ?>
                        </div>

                        <div class="box-text">
                            <h2><?php echo htmlspecialchars($fetch_product["product_name"]); ?></h2>
                            <?php if (isset($user_id)): ?>
                                <input type="hidden" name="product_name" id="product_name" value="<?php echo htmlspecialchars($fetch_product["product_name"]); ?>">
                            <?php endif; ?>

                            <p class="brand-name">
                                แบรนด์ : <?php echo htmlspecialchars($fetch_product["category_name"]); ?> | 
                                Product ID : <?php 
                                    if($fetch_product["category_name"] === "PlayStation") {
                                        echo "S" . $fetch_product["product_id"]; 
                                    } else if($fetch_product["category_name"] === "Xbox") {
                                        echo "X" . $fetch_product["product_id"];
                                    } else if($fetch_product["category_name"] === "Nintendo Switch") {
                                        echo "NS" . $fetch_product["product_id"];
                                    }
                                ?>
                            </p> 

                            <p class="des"><?php echo nl2br(htmlspecialchars($fetch_product["description"])); ?></p>

                            <div class="box-qty">
                                <input type="number" value="1" min="1" name="qty"/>
                                <p id="price"><?php echo number_format($fetch_product["price"], 2); ?> บาท</p>
                                <?php if (isset($user_id)): ?>
                                    <input type="hidden" name="price" value="<?php echo $fetch_product["price"]; ?>">
                                <?php endif; ?>
                            </div>

                            <div class="box-input-submit">
                                <?php if (isset($user_id)): ?>
                                    <input type="submit" value="add to cart" name="cart" class="btn btn-danger">
                                    <input type="submit" value="buy now" name="buy" class="btn btn-success">
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger" onclick="openPopup()">เพิ่มสินค้าลงตะกร้า</button>
                                    <button type="button" class="btn btn-success" onclick="openPopup()">ซื้อเลย</button>
                                    
                                    <div class="popup" id="popup">
                                        <h2>Warning</h2>
                                        <p>คุณต้องสมัครสมาชิกก่อนถึงจะซื้อสินค้าได้</p>
                                        <button type="button" onclick="closePopup()">OK</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (isset($user_id)): ?>
                    </form>
                <?php endif; ?>
                <?php
            } else {
                echo "<p style='text-align:center;'>ไม่พบรูปภาพผลิตภัณฑ์ในเซิร์ฟเวอร์</p>";
            }
        } else {
            echo "<p style='text-align:center;'>ไม่พบข้อมูลผลิตภัณฑ์นี้</p>";
        }
    ?>

    <script src="js/script.js"></script>
</body>
</html>