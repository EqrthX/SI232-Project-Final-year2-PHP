<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;
    $category_id = isset($_GET['id']) ? intval($_GET['id']) : null;

    $category_name = "Catagory";
    if ($category_id) {
        $cat_query = mysqli_query($conn, "SELECT category_name FROM categories WHERE category_id = $category_id");
        if ($cat_query && mysqli_num_rows($cat_query) > 0) {
            $cat_data = mysqli_fetch_assoc($cat_query);
            $category_name = $cat_data['category_name'];
        } else {
            $category_id = null; // Reset if invalid category
        }
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
    <title><?php echo htmlspecialchars($category_name); ?></title>
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

        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <?php 
                    $img_folder = "upload_goodproducts/";
                    $imgs = glob($img_folder . "*");
                    if($imgs) {
                        $active = 'active';
                        foreach ($imgs as $img) {
                            ?>
                            <div class="carousel-item <?php echo $active; ?>">
                                <img src="<?php echo $img; ?>" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>สินค้าขายดี</h5>
                                </div>
                            </div>
                            <?php 
                            $active = '';
                        }
                    }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
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

    <h1 class="title"><?php echo htmlspecialchars($category_name); ?></h1>

    <?php if (!$category_id): ?>
        <!-- Show categories list -->
        <div class="container-main">
            <div class="container-cat">
                <div class="box-cat">
                    <a href="category.php?id=1"><img src="images/PlayStation_App_Icon.jpg" alt="PlayStation" width="200"></a>
                </div>
                <div class="box-cat">
                    <a href="category.php?id=3"><img src="images/nintendo-switch-logo.png" alt="Nintendo Switch" width="200"></a>
                </div>
                <div class="box-cat">
                    <a href="category.php?id=2"><img src="images/Xbox-icon.png" alt="Xbox" width="200"></a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Show category products -->
        <div class="show-product">
            <div class="container">
                <?php 
                    $imagesFolder = "upload_images/";
                    $imageFiles = glob($imagesFolder . "*");
                    
                    $sql = "SELECT * FROM products WHERE category_id = $category_id";
                    $result = mysqli_query($conn, $sql);

                    if($result && mysqli_num_rows($result) > 0) {
                        while($fetch_product = mysqli_fetch_assoc($result)) {
                            $productImageName = basename($fetch_product["image_url"]);
                            if(in_array($productImageName, array_map('basename', $imageFiles))) {
                                ?>
                                <a href="product.php?id=<?php echo $fetch_product["product_id"]; ?>">
                                    <div class="container-box">
                                        <img src="upload_images/<?php echo htmlspecialchars($fetch_product["image_url"]); ?>" alt="">
                                        <p>
                                            <?php echo htmlspecialchars($fetch_product["product_name"]); ?> 
                                            <br> 
                                            ราคา <?php echo number_format($fetch_product["price"], 2); ?> บาท
                                        </p>
                                    </div>  
                                </a>
                                <?php 
                            } else {
                                echo "ไม่พบรูปภาพที่ตรงกับ image_url '" . htmlspecialchars($productImageName) . "' ในฐานข้อมูล<br>";
                            }
                        }
                    } else {
                        echo "<p style='text-align: center; width: 100%; color: #666;'>No products found in this category.</p>";
                    }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <script src="js/script.js"></script>
</body>
</html>
