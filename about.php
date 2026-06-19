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
    <title>About us</title>
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

    <div class="heading">
        <h1>About us</h1>
        <p>ประวัติเครื่องเล่นเกม</p>
    </div>

    <div class="container">
        <section class="about">
            <div class="about-image">
                <img src="images/Microsoft-Xbox-Series-X-Console.png" alt="Xbox">
            </div>
            <div class="about-content">
                <h2>Xbox</h2>
                <p>Xbox เป็นเครื่องเล่นวิดีโอเกมรุ่นแรกภายใต้เครื่องเล่นวิดีโอเกมชุด Xbox ซึ่งผลิตโดย Microsoft วางจำหน่ายครั้งแรกเมื่อวันที่ 15 พฤศจิกายน ค.ศ. 2001 ในทวีปอเมริกาเหนือ ตามด้วยประเทศออสเตรเลีย ทวีปยุโรปและประเทศญี่ปุ่นในปี ค.ศ. 2002 โดยนับเป็นครั้งแรกที่ Microsoft เข้าสู่ตลาดเครื่องเล่นวิดีโอเกม Xbox เป็นเครื่องเล่นวิดีโอเกมรุ่นที่ 6 ที่เป็นคู่แข่งกับ Sony PlayStation 2 และ Nintendo Gamecube ซึ่ง Xbox นับว่าเป็นเครื่องเล่นวิดีโอเกมแรกที่ถูกผลิตโดยบริษัทสัญชาติอเมริกานับตั้งแต่เครื่อง Atari jaguar หยุดการผลิตในปี ค.ศ. 1996...</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </section>

        <section class="about">
            <div class="about-image">
                <img src="images/Playplaystation_5_controller_edition.png" alt="PlayStation" onerror="this.src='images/Playstation_5_controller_edition.png'">
            </div>
            <div class="about-content">
                <h2>PlayStation</h2>
                <p>PlayStation เป็นเครื่องเล่นวิดีโอเกมระบบ 32 บิตที่พัฒนาและวางตลาดโดยโซนี่คอมพิวเตอร์เอนเตอร์เทนเมนท์ วางจำหน่ายในญี่ปุ่นในวันที่ 3 ธันวาคม ค.ศ. 1994 ในอเมริกาเหนือในวันที่ 9 กันยายน ค.ศ. 1995 ในยุโรปในวันที่ 29 กันยายน ค.ศ. 1995 และในออสเตรเลียในวันที่ 15 พฤศจิกายน ค.ศ. 1995...</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </section>

        <section class="about">
            <div class="about-image">
                <img src="images/Nintendo_switch.png" alt="Nintendo Switch">
            </div>
            <div class="about-content">
                <h2>Nintendo Switch</h2>
                <p>Nintendo Switch หรือที่รู้จักกันภายใต้ชื่อรหัสพัฒนาว่า เอ็นเอกซ์ (NX) เป็นเครื่องเล่นวิดีโอเกมที่ได้วางจำหน่ายในวันที่ 3 มีนาคม ค.ศ. 2017 ซึ่ง Nintendo Switch เป็นเครื่องเล่นเกมแบบไฮบริด สามารถใช้เล่นได้ทั้งแบบในบ้าน...</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </section>        
    </div>

    <script src="js/script.js"></script>
</body>
</html>
