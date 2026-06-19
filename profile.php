<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;
    if(!$user_id) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php require 'includes/header.php'; ?>

    <h1 class="title" style="margin-top: 20px;">Profile</h1>

    <div class="profile-container text-center">
        <img src="images/user (2).png" alt="User Image" width="150" class="mb-3">

        <div class="content-profile mx-auto" style="max-width: 500px;">
            <div class="input-profile text-start">
                <hr>
                <?php 
                    if(isset($_POST['submit'])) {
                        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
                        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
                        $email = mysqli_real_escape_string($conn, $_POST['email']);
                        $address = mysqli_real_escape_string($conn, $_POST['address']);
                        
                        $sql_user_update = "UPDATE users SET firstname = ?, lastname = ?, email = ?, address = ? WHERE user_id = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if(mysqli_stmt_prepare($stmt, $sql_user_update)) {
                            mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $address, $user_id);
                            mysqli_stmt_execute($stmt);
                            echo "<div class='alert alert-success'>อัพเดทข้อมูลเรียบร้อย</div>";
                            // Update current session values as well
                            $_SESSION['user_email'] = $email;
                        } else {
                            echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัพเดทข้อมูล</div>";
                        }
                    }

                    // Fetch user details to prefill the form
                    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
                    $result_user = mysqli_query($conn, $sql);
                    $fetch_user = mysqli_fetch_assoc($result_user);
                ?>
                <form action="profile.php" method="post">    
                    <div class="profile-box">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">First Name</span>
                            <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($fetch_user["firstname"]); ?>" required>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Last Name</span>
                            <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($fetch_user["lastname"]); ?>" required>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($fetch_user["email"]); ?>" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">Address</span>
                            <textarea class="form-control" name="address" style="height: 100px;" required><?php echo htmlspecialchars($fetch_user["address"]); ?></textarea>
                        </div>

                        <div class="submit-box-profile text-center">
                            <button type="submit" name="submit" class="btn btn-primary me-2">ยืนยัน</button>
                            <button type="reset" class="btn btn-secondary">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
