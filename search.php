<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;

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
    <title>Search Results</title>
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

    <h1 class="title">Search Results</h1>

    <div class="show-product">
        <div class="container">
            <?php 
                if(isset($_POST["submit"]) || isset($_POST["keyword"])) {
                    $imagesFolder = "upload_images/";
                    $imageFiles = glob($imagesFolder . "*");

                    $keyword = mysqli_real_escape_string($conn, $_POST["keyword"]);
                    $sql_search = "SELECT * FROM products WHERE product_name LIKE '%" . $keyword . "%'";
                    $result = mysqli_query($conn, $sql_search);

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
                        echo "<p style='text-align: center; width: 100%; color: #666;'>No products found matching your search query.</p>";
                    }
                } else {
                    echo "<p style='text-align: center; width: 100%; color: #666;'>Please enter a search query.</p>";
                }
            ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>