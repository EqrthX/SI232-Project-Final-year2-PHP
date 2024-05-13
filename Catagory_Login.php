<?php 

    include 'connection.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)) {

        header("location:Login.php");
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
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
    <?php require 'header_user.php'; ?>
    
    <div class="show-curosel">

        <div id="carouselExample" class="carousel slide">
            
            <div class="carousel-inner">
                
                <?php

                    showImagesCarousel();
                
                ?>

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

            <li><a href="Home.php">Home</a></li>
            <li><a href="Catagory_Login.php">Catagory</a></li>
            <li><a href="About_us_Login.php">About us</a></li>
            <li><a href="Contact_Login.php">Contact</a></li>

        </ul>

    </nav>

    <h1 class="title">Catagory</h1>

    <div class="container-main">

            <div class="container-cat">

                    <div class="box-cat">

                        <a href="Catagory_PlayStation_Login.php"><img src="images/PlayStation_App_Icon.jpg" alt="" width="200"></a>

                    </div>

                    <div class="box-cat">

                        <a href="Catagory_NintendoSwitch_Login.php"><img src="images/nintendo-switch-logo.png" alt="" width="200"></a>

                    </div>

                    <div class="box-cat">

                        <a href="Catagory_Xbox_Login.php"><img src="images/Xbox-icon.png" alt="" width="200"></a>

                    </div>

            </div>

    </div>

    <script src="js/script.js"></script>

</body>
</html>