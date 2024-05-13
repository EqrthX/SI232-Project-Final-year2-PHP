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

    <title>About us</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/style.css">
    <style>
        *{
            margin:0px;
            padding: 0px;
            box-sizing: border-box;
        }
        .heading{
            width:90;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 20 auto;
        }
        .heading h1{
            font-family: 'Roboto', sans-serif;
            font-size: 50px;
            color: #000;
            margin-bottom: 25px;
            position: relative;
        }
        .heading h1::after{
            content: "";
            position:absolute;
            width: 100%;
            height: 4px;
            display: block;
            margin: 0 auto;
            background-color: #0936b0;
        }
        .heading p{
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            color: #666;
            margin-bottom: 35px;
        }
        .container{
            width:90%;
            margin:0 auto;
            padding:10px 20px;
            margin-top: 20px;
        }
        .about{
            background-color: #f2f2f2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .about-image{
            flex:1;
            margin-right: 40px;
            overflow: hidden;
        }
        .about-image img{
            max-width: 100%;
            height: auto;
            display: block;
            transition: 0.5s ease;
        }
        .about-content{
            flex:1;
        }
        .about-content h2{
            font-family: 'Roboto', sans-serif;
            font-size: 23px;
            margin-bottom: 15px;
            color:#333;
        }
        .about-content p{
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            line-height:1.5;
            color:#666;
        }
        .about-content .read-more{
            font-family: 'Roboto', sans-serif;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color:#ffffff;
            font-size: 19;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 15px;
            transition: 0.3 ease;
        }
        .about-content .read-more:hover{
            background-color: #3e8e41;
        }
    </style>
    
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

    <div class="heading">
        <h1>About us</h1>
        <p>ประวัติเครื่องเล่นเกม</p>
    </div>

    <div class="container">
        <section class="about">
            <div class="about-image">
                <img src="images/Microsoft-Xbox-Series-X-Console.png">
            </div>
            <div class="about-content">
                <h2>Xbox</h2>
                <p>Xbox เป็นเครื่องเล่นวิดีโอเกมรุ่นแรกภายใต้เครื่องเล่นวิดีโอเกมชุด Xbox ซึ่งผลิตโดย Microsoft วางจำหน่ายครั้งแรกเมื่อวันที่ 15 พฤศจิกายน ค.ศ. 2001 ในทวีปอเมริกาเหนือ ตามด้วยประเทศออสเตรเลีย ทวีปยุโรปและประเทศญี่ปุ่นในปี ค.ศ. 2002 โดยนับเป็นครั้งแรกที่ Microsoft เข้าสู่ตลาดเครื่องเล่นวิดีโอเกม Xbox เป็นเครื่องเล่นวิดีโอเกมรุ่นที่ 6 ที่เป็นคู่แข่งกับ Sony PlayStation 2 และ Nintendo Gamecube ซึ่ง Xbox นับว่าเป็นเครื่องเล่นวิดีโอเกมแรกที่ถูกผลิตโดยบริษัทสัญชาติอเมริกานับตั้งแต่เครื่อง Atari jaguar หยุดการผลิตในปี ค.ศ. 1996
                    Xbox เปิดตัวครั้งแรกเมื่อปี 2543 โดยชูจุดเด่นด้านสมรรถนะทางกราฟิกว่าเหนือกว่าคู่แข่ง โดยเครื่อง Xbox ประกอบไปด้วย CPU ที่ใช้กันในคอมพิวเตอร์ส่วนบุคคลอย่างอินเทลเพนเทียม III ความเร็ว 733 เมกะเฮิร์ตซ์ นอกจากนี้ยังถูกระบุว่ามีน้ำหนักและขนาดเหมือนคอมพิวเตอร์ส่วนบุคคล เป็นเครื่องเล่นวิดีโอเกมแรกที่ประกอบฮาร์ดดิสก์ไว้ภายใน ในเดือนพฤศจิกายน ค.ศ. 2002 Microsoft ได้เปิดให้บริการ Xbox Live บริการแบบเสียเงินเพื่อเล่นเกมแบบออนไลน์และอนุญาตให้ผู้สมัครใช้บริการดาวน์โหลดเนื้อหาและเชื่อมต่อกับให้เล่นอื่นผ่านระบบอินเทอร์เน็ตแบบบรอดแบนด์ ต่างจากบริการออนไลน์อื่นๆ จากเซกาและโซนี่ โดยXbox Live นั้นรองรับการเชื่อมต่อผ่านพอร์ตอีเทอร์เน็ตซึ่งถูกประกอบไว้มาในเครื่อง ทำให้ Microsoft สามารถตั้งหลักในบริการการเล่นเกมแบบออนไลน์และยังช่วยให้เอกซ์บอกซ์กลายเป็นคู่แข่งโดยตรงกับเครื่องเล่นอื่นๆ ในเครื่องเล่นวิดีโอเกมรุ่นที่ 6 ได้</p>
            <a href="" class="read-more">Read More</a>
            </div>
        </section>

        <section class="about">
            <div class="about-image">
                <img src="images/Playstation_5_controller_edition.png">
            </div>
            <div class="about-content">
                <h2>PlayStation</h2>
                <p>PlayStation  เป็นเครื่องเล่นวิดีโอเกมระบบ 32 บิตที่พัฒนาและวางตลาดโดยโซนี่คอมพิวเตอร์เอนเตอร์เทนเมนท์ วางจำหน่ายในญี่ปุ่นในวันที่ 3 ธันวาคม ค.ศ. 1994 ในอเมริกาเหนือในวันที่ 9 กันยายน ค.ศ. 1995 ในยุโรปในวันที่ 29 กันยายน ค.ศ. 1995 และในออสเตรเลียในวันที่ 15 พฤศจิกายน ค.ศ. 1995 ในฐานะเครื่องเล่นวิดีโอเกมยุคที่ 5 PlayStation แข่งขันกับ Nintendo 64 และ Sega Saturn เป็นหลัก
                    Sony เริ่มพัฒนา PlayStation หลังจากล้มเหลวในการร่วมทุนกับ Nintendo ในการสร้างอุปกรณ์ต่อพ่วงแผ่นซีดีสำหรับเครื่องซูเปอร์แฟมิคอมในต้นคริสต์ทศวรรษ 1990 เครื่องเล่นวิดีโอเกมนี้ได้รับการออกแบบโดยเคน คูตาระกิ และโซนี่คอมพิวเตอร์เอนเตอร์เทนเมนท์ในญี่ปุ่นเป็นหลัก ในขณะที่การพัฒนาเพิ่มเติมนั้นได้รับการว่าจ้างจากทีมงานภายนอกในสหราชอาณาจักร การเน้นที่กราฟิกรูปหลายเหลี่ยม 3 มิติถูกวางไว้ที่ส่วนหน้าของการออกแบบเครื่องเล่นวิดีโอเกมนี้ การผลิตเกมของ PlayStation ได้รับการออกแบบให้มีความคล่องตัวและครอบคลุม ซึ่งดึงดูดการสนับสนุนจากนักพัฒนาบุคคลที่สามจำนวนมาก
                    เครื่องเล่นวิดีโอเกมนี้ได้รับการพิสูจน์แล้วว่าได้รับความนิยมจากคลังเกมที่กว้างขวาง แฟรนไชส์ที่ยอดนิยม ราคาขายปลีกที่ถูก และการตลาดเชิงรุกสำหรับเยาวชนซึ่งโฆษณาว่าเป็นเครื่องเล่นเกมยอดนิยมสำหรับวัยรุ่นและผู้ใหญ่</p>
            <a href="" class="read-more">Read More</a>
            </div>
        </section>

        <section class="about">
            <div class="about-image">
                <img src="images/Nintendo_switch.png">
            </div>
            <div class="about-content">
                <h2>Nintendo Switch</h2>
                <p>Nintendo Switch หรือที่รู้จักกันภายใต้ชื่อรหัสพัฒนาว่า เอ็นเอกซ์ (NX) เป็นเครื่องเล่นวิดีโอเกมที่ได้วางจำหน่ายในวันที่ 3 มีนาคม ค.ศ. 2017  ซึ่ง Nintendo Switch เป็นเครื่องเล่นเกมแบบไฮบริด สามารถใช้เล่นได้ทั้งแบบในบ้าน โดยจะมีตัวแท่นวางเพื่อเชื่อมต่อเข้ากับทีวีผ่านช่อง HDMI และแบบพกพา โดยสามารถเอาตัวเครื่องออกไปเล่นนอกบ้านได้ เป็นครั้งแรกที่ไม่รองรับคุณสมบัติความเข้ากันได้ย้อนหลังกับวิดีโอเกมเก่าของ วียู และ Nintendo 3DS เนื่องมาจากวียูใช้ซีพียูของเพาเวอร์พีซีเป็นเวลานานตั้งแต่เกมคิวบ์ นินเท็นโดเปลี่ยนโปรเซสเซอร์และสถาปัตยกรรมเป็น ARM แทน ไม่สามารถรันเกมเก่าสถาปัตยกรรมแตกต่างกับได้ ส่วน Nintendo 3DS ใช้ซีพียูของ ARM แต่ไม่สามารถแสดงผล 2 หน้าจอได้</p>
            <a href="" class="read-more">Read More</a>
            </div>
        </section>        
    </div>

    <script src="js/script.js"></script>

</body>
</html>

