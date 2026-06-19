<?php
    require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login_register.css">
</head>
<body>
    <div class="container">
        <?php 
            if(isset($_POST['reg'])){
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = $_POST['pws'];
                $password_con = $_POST['con_pws'];
                $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
                $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
                $gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : '';
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $tel = mysqli_real_escape_string($conn, $_POST['tel']);
                $address = mysqli_real_escape_string($conn, $_POST['address']);

                $errors = array();

                if(empty($username) || empty($password) || empty($password_con) || empty($first_name) || empty($last_name) || empty($gender) || empty($email) || empty($tel) || empty($address)) {
                    array_push($errors, "All fields are required!");
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }

                if(strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }

                if($password !== $password_con) {
                    array_push($errors, "Password does not match!");
                }

                if(strlen($tel) !== 10) {
                    array_push($errors, "Telephone number must be exactly 10 digits");
                }

                // Check database for duplicates
                $sql_users = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
                $result_users = mysqli_query($conn, $sql_users);
                if(mysqli_num_rows($result_users) > 0) {
                    array_push($errors, "Username or Email already exists!");
                }

                if(count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='box-alert'><div class='alert alert-danger'>$error</div></div>";
                    }
                } else {
                    $sql_insert_user = "INSERT INTO users(username, password, firstname, lastname, gender, email, tel, address) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(mysqli_stmt_prepare($stmt, $sql_insert_user)) {
                        mysqli_stmt_bind_param($stmt, "ssssssss", $username, $password, $first_name, $last_name, $gender, $email, $tel, $address);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You registered successfully! <a href='login.php'>Login here</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>Something went wrong!</div>";
                    }
                }
            }
        ?>
        <form action="register.php" method="POST">
            <h1>Register</h1>
            <div class="form-group">
                <input type="text" name="username" id="username" placeholder="username" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="pws" id="pws" placeholder="password" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="con_pws" id="con_pws" placeholder="confirm password" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="firstname" id="name" placeholder="firstname" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="lastname" id="lastname" placeholder="lastname" class="form-control" required>
            </div>
            
            <div class="radio-box mb-3">
                <p class="gender">Gender</p>
                <div class="form-check d-inline-block me-3">
                    <input type="radio" name="gender" id="flexRadioDefault1" value="men" class="form-check-input" checked>
                    <label for="flexRadioDefault1" class="form-check-label">Male</label>      
                </div>
                <div class="form-check d-inline-block me-3">
                    <input type="radio" name="gender" id="flexRadioDefault2" value="women" class="form-check-input">
                    <label for="flexRadioDefault2" class="form-check-label">Female</label>
                </div>
                <div class="form-check d-inline-block">
                    <input type="radio" name="gender" id="flexRadioDefault3" value="other" class="form-check-input">
                    <label for="flexRadioDefault3" class="form-check-label">Other</label>
                </div>
            </div>

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" name="tel" placeholder="telephone (10 digits)" class="form-control" required>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Address" id="floatingTextarea" name="address" style="height: 100px;" required></textarea>
                <label for="floatingTextarea">Address</label>
            </div>
            
            <div class="form-btn mb-3">
                <input type="submit" value="Register" name="reg" class="btn btn-success">
            </div>
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>
</html>