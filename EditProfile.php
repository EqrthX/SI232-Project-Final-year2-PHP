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


    <h1 class="title">Profile</h1>
    

    <div class="profile-container">

        <img src="images/user (2).png" alt="" width="150">

        <?php 

            if(empty($user_id)) {

                echo "<div class='alert alert-danger'>ไม่เจอรหัสสมาชิกคนนี้</div>";

            } else {

                $sql = "SELECT * FROM users WHERE user_id = '$user_id';";

                $result_user = mysqli_query($conn, $sql);

                $fetch_user = mysqli_fetch_assoc($result_user);

        ?>
            <div class="content-profile">
                
                <div class="input-profile">
                    <hr>
                    <?php 

                        if(isset($_POST['submit'])) {

                            $user_id = $_POST['user_id'];

                            if(empty($user_id)) {

                                echo "<script>alert('ไม่พบรหัสผู้ใช้งาน')</script>";

                            } else {

                                $firstname = $_POST['firstname'];

                                $lastname = $_POST['lastname'];
                        
                                $email = $_POST['email'];

                                $address = $_POST['address'];
                                
                                $sql_user_update = "UPDATE users SET
                                                    firstname = ?,
                                                    lastname = ?,
                                                    email = ?,
                                                    address = ?
                                                    WHERE user_id = ?";

                                $stmt = mysqli_stmt_init($conn);

                                $prepareStmt = mysqli_stmt_prepare($stmt, $sql_user_update);
                                
                                if($prepareStmt) {

                                    mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $address, $user_id);
                                    mysqli_stmt_execute($stmt);
                                    if(mysqli_stmt_affected_rows($stmt) > 0) {

                                        echo "<div class='alert alert-success'>อัพเดทข้อมูลเรียบร้อย</div>";
                                        sleep(1);
                                        exit();
                                        

                                    } else {

                                        echo "<div class='alert alert-danger'>อัพเดทข้อมูลไม่สำเร็จ</div>";
                                        sleep(1);
                                    }

                                }

                            }

                        } 

                    ?>
                    <form action="EditProfile.php" method="post">    

                        <input type="hidden" name="user_id" value="<?php echo $fetch_user["user_id"];?>" readonly>

                        <div class="profile-box">

                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">First Name</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="firstname" value="<?php echo $fetch_user["firstname"] ?>" name="firstname">
                            </div>

                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Last Name</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="lastname" value="<?php echo $fetch_user["lastname"] ?>" name="lastname">
                            </div>

                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
                                <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php echo $fetch_user["email"] ?>" name="email">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">Address</span>
                                <textarea class="form-control" aria-label="With textarea" name="address"><?php echo $fetch_user["address"]; ?></textarea>
                            </div>

                            <div class="submit-box-profile">

                                <button type="submit" name="submit" class="btn btn-primary">ยืนยัน</button>

                                <button type="reset" name="reset" class="btn btn-info">ยกเลิก</button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        <?php }?>

    </div>


    <script src="js/script.js"></script>

</body>
</html>