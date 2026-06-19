<?php 
    require_once '../config/db.php';
    session_start();

    $admin_id = $_SESSION['admin_id'] ?? null;
    if(!$admin_id) {
        header("Location: ../login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    
    <?php require 'includes/header.php' ?>

    <section class="dashboard">
        <h1>Customer Reviews</h1>

        <div class="container mt-4 d-flex flex-wrap justify-content-center">
            <?php 
                $sql_review = "SELECT * FROM reviews ORDER BY reviews_id DESC";
                $result_review = mysqli_query($conn, $sql_review);

                if(mysqli_num_rows($result_review) > 0) {
                    while($rows_review = mysqli_fetch_assoc($result_review)) {
                        ?>
                        <div class="box-review m-3" style="width: 300px;">
                            <div class="text-start">
                                <p><strong>Order ID:</strong> <?php echo $rows_review["orders_complete_id"] ?></p>
                                <p><strong>User ID:</strong> <?php echo $rows_review["user_id"] ?></p>
                                <p><strong>ชื่อผู้รีวิว:</strong> <?php echo htmlspecialchars($rows_review["fullname"]) ?></p>
                                <p><strong>สินค้า:</strong> <?php echo htmlspecialchars($rows_review["products"]) ?></p>
                                <p><strong>วันที่รีวิว:</strong> <?php echo $rows_review["review_date"] ?></p>
                                <hr>
                                <p><strong>ข้อความรีวิว:</strong><br><?php echo nl2br(htmlspecialchars($rows_review["content"])) ?></p>
                            </div>
                        </div>
                        <?php 
                    }
                } else {
                    echo "<p class='text-center text-muted w-100'>ยังไม่มีคำรีวิวจากลูกค้า</p>";
                }
            ?>
        </div>
    </section>

    <script src="../js/Adminscript.js"></script>
</body>
</html>
