<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;

    $alert_message = '';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        if (!empty($name) && !empty($email) && !empty($phone) && !empty($subject) && !empty($message)) {
            // Check for duplicate email in message table
            $check_email = mysqli_query($conn, "SELECT email FROM message WHERE email = '$email' LIMIT 1");
            if (mysqli_num_rows($check_email) > 0) {
                $alert_message = "<script>alert('อีเมลซ้ำ มีอีเมลนี้ในระบบแล้ว!!')</script>";
            } else {
                $sql = "INSERT INTO message (name, email, phone, subject, message) VALUES ('$name', '$email', '$phone', '$subject', '$message')";
                if (mysqli_query($conn, $sql)) {
                    $alert_message = "<script>alert('บันทึกข้อมูลเรียบร้อย')</script>";
                } else {
                    $alert_message = "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล')</script>";
                }
            }
        } else {
            $alert_message = "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง')</script>";
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php echo $alert_message; ?>
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

    <section class="contact-container">
        <div class="contact">
            <h2>CONTACT</h2>
            <p>Message us</p>
            <form action="contact.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" style="width: 100%; padding: 10px; border: 1px solid #ccc; box-sizing: border-box;" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>

                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone" style="width: 100%; padding: 10px; border: 1px solid #ccc; box-sizing: border-box;" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Enter your subject" style="width: 100%; padding: 10px; border: 1px solid #ccc; box-sizing: border-box;" required>

                <label for="message">Message</label>
                <textarea id="text" name="message" placeholder="Enter your message" required></textarea>

                <button type="submit" name="send_message" class="mt-3">Send</button>
            </form>
        </div>

        <div class="contactat">
            <h2 style="margin-bottom: 20px;">Contact at</h2>
            <center>
                <!-- Instagram -->
                <div style="margin-bottom: 20px;">
                    <i class="fab fa-instagram" style="font-size: 50px; margin-bottom: 10px; color: #bc2a8d;"></i>
                    <h5>@cgame_shop</h5>
                </div>

                <!-- Facebook -->
                <div style="margin-bottom: 20px;">
                    <i class="fab fa-facebook-square" style="font-size: 50px; margin-bottom: 10px; color: #3b5998;"></i>
                    <h5>Facebook.com/cgameshop</h5>
                </div>

                <!-- LINE -->
                <div style="margin-bottom: 20px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/LINE_logo.svg/1200px-LINE_logo.svg.png" alt="LINE" style="width: 50px; height: 50px; margin-bottom: 10px;">
                    <h5>@cgameshop</h5>
                </div>

                <!-- Phone -->
                <h3 style="margin-bottom: 10px;">Phone</h3>
                <h5>เบอร์โทรศัพท์ของคุณ</h5>

                <!-- Gmail -->
                <h3 style="margin-bottom: 10px;">Gmail</h3>
                <h5>cgameshop@gmail.com</h5>
            </center>
        </div>
    </section>

    <footer>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="category.php">CATAGORY</a></li>
                <li><a href="about.php">ABOUT US</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </nav>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>