<?php 
    require_once 'config/db.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login_register.css">
</head>
<body>
    <div class="game-bg-elements">
        <!-- SVG 1: Gamepad -->
        <svg class="game-icon icon-1" viewBox="0 0 24 24" width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="6" width="20" height="12" rx="3"></rect>
            <path d="M6 12h4M8 10v4M15 11h.01M18 13h.01"></path>
        </svg>
        <!-- SVG 2: Space Invader / Alien -->
        <svg class="game-icon icon-2" viewBox="0 0 24 24" width="70" height="70" fill="currentColor">
            <path d="M4 2h2v2H4V2zm14 0h2v2h-2V2zm-4 2h2v2h-2V4zm-6 0h2v2H8V4zm-4 4h16v2H4V8zm2 2h2v2H6v-2zm10 0h2v2h-2v-2zm-6 2h4v2h-4v-2zm-6 2h2v2H4v-2zm14 0h2v2h-2v-2z"></path>
        </svg>
        <!-- SVG 3: D-Pad -->
        <svg class="game-icon icon-3" viewBox="0 0 24 24" width="90" height="90" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 8v8M8 12h8"></path>
        </svg>
        <!-- SVG 4: Play Button -->
        <svg class="game-icon icon-4" viewBox="0 0 24 24" width="75" height="75" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 3l14 9-14 9V3z"></path>
        </svg>
    </div>
    <div class="container">
        <a href="index.php" class="arrow">&#x2190;</a>
        <?php 
            if(isset($_POST['enter'])) {
                $user = mysqli_real_escape_string($conn, $_POST['user']);
                $password = mysqli_real_escape_string($conn, $_POST['pws']);

                $sql_user = "SELECT * FROM users WHERE username = '$user'";
                $result_users = mysqli_query($conn, $sql_user);
                $userData = mysqli_fetch_array($result_users, MYSQLI_ASSOC);

                if($userData) {
                    if($password === $userData['password']) {
                        if($userData['user_type'] === 'user') {
                            $_SESSION['user_email'] = $userData["email"];
                            $_SESSION['user_username'] = $userData["username"];
                            $_SESSION['user_id'] = $userData["user_id"];
                            header("Location: index.php");
                            exit();
                        } elseif($userData['user_type'] === 'admin') {
                            $_SESSION['admin_email'] = $userData['email'];
                            $_SESSION['admin_user'] = $userData['username'];
                            $_SESSION['admin_id'] = $userData['user_id'];
                            header("Location: admin/index.php");
                            exit();
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Password incorrect!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>User not found!</div>";
                }
            }
        ?>
        <form action="login.php" method="POST">
            <h1>Login</h1>
            <input type="text" name="user" id="user" placeholder="username" class="form-control" required>
            <br>
            <input type="password" name="pws" id="pws" placeholder="password" class="form-control" required>
            <br>
            <input type="submit" value="submit" name="enter" class="btn btn-primary md-3">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>