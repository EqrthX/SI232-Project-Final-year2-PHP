<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION["user_id"] ?? null;

    if (!$user_id) {
        header("Location: login.php");
        exit();
    }

    $alert_message = '';

    // --- Action 1: Handle Review Submission (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
        $order_cID = intval($_POST["order_cID"]);
        $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
        $content = mysqli_real_escape_string($conn, $_POST["content"]);
        $date = date("Y-m-d H:i:s");

        $sql_status = mysqli_query($conn, "SELECT status FROM orders_complete WHERE orders_complete_id = '$order_cID' AND status = 'ชำระเงินเรียบร้อย'");
        
        if (mysqli_num_rows($sql_status) > 0) {
            $row_status = mysqli_fetch_assoc($sql_status);
            $status = $row_status['status'];

            if (!empty($content)) {
                $sql = "INSERT INTO reviews(orders_complete_id, user_id, fullname, products, content, review_date, status) 
                        VALUES(?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iisssss", $order_cID, $user_id, $fullname, $product_name, $content, $date, $status);
                    mysqli_stmt_execute($stmt);
                    $alert_message = "<script>alert('ขอบคุณสำหรับคำรีวิวของคุณ!'); window.location.href='reviews.php';</script>";
                } else {
                    $alert_message = "<script>alert('เกิดข้อผิดพลาดในการเพิ่มรีวิว')</script>";
                }
            } else {
                $alert_message = "<script>alert('กรุณากรอกข้อความรีวิว')</script>";
            }
        } else {
            $alert_message = "<script>alert('ออเดอร์นี้ยังไม่ได้ชำระเงินหรือรหัสไม่ถูกต้อง')</script>";
        }
    }

    // Determine view mode
    $action = $_GET['action'] ?? '';
    $order_cID = isset($_GET['id']) ? intval($_GET['id']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REVIEWS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php echo $alert_message; ?>
    <?php require "includes/header.php"; ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:20px">Reviews</h1>

    <div class="container mt-4">
        <?php if ($action === 'add' && $order_cID): ?>
            <!-- Review submission form -->
            <?php 
                $order_query = mysqli_query($conn, "SELECT * FROM orders_complete WHERE orders_complete_id = '$order_cID' AND status = 'ชำระเงินเรียบร้อย' AND user_id = '$user_id'");
                if (mysqli_num_rows($order_query) > 0) {
                    $row_order = mysqli_fetch_assoc($order_query);
                    $product_query = mysqli_query($conn, "SELECT * FROM products WHERE product_name = '" . mysqli_real_escape_string($conn, $row_order['products']) . "'");
                    $row_product = mysqli_fetch_assoc($product_query);
                    ?>
                    <div class="review mx-auto" style="max-width: 600px; padding: 20px;">
                        <a href="reviews.php" class="arrow mb-3 d-inline-block">&#x2190; ย้อนกลับ</a>
                        <div class="content-review">
                            <form action="reviews.php" method="post">
                                <div class="text-review">    
                                    <h4>ORDER ID: <?php echo $row_order["orders_complete_id"] ?></h4>
                                    <input type="hidden" name="order_cID" value="<?php echo $row_order["orders_complete_id"] ?>">

                                    <p>ชื่อผู้ใช้: <?php echo htmlspecialchars($row_order["fullname"]) ?></p>
                                    <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($row_order["fullname"]) ?>">

                                    <p>ชื่อสินค้า: <?php echo htmlspecialchars($row_order["products"]) ?></p>
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row_order["products"]) ?>">

                                    <?php if ($row_product): ?>
                                        <img src="upload_images/<?php echo htmlspecialchars($row_product["image_url"]) ?>" width="100%" class="mb-3 border rounded" alt="">
                                    <?php endif; ?>
                                </div> 

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="เขียนรีวิวของคุณ..." id="floatingTextarea2" style="height: 120px" name="content" required></textarea>
                                    <label for="floatingTextarea2">Review</label>
                                </div>

                                <button type="submit" class="btn btn-primary" name="submit_review">ยืนยัน</button>
                            </form>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<p class='text-center'>ไม่พบรายการสั่งซื้อที่ชำระเงินเรียบร้อยสำหรับการรีวิว</p>";
                }
            ?>
        <?php else: ?>
            <!-- List complete orders for review -->
            <div class="container container-reviews d-flex flex-wrap justify-content-center">
                <?php 
                    $sql_order_complete = "SELECT * FROM orders_complete WHERE user_id = '$user_id' AND status = 'ชำระเงินเรียบร้อย'";
                    $result_order_complete = mysqli_query($conn, $sql_order_complete);

                    if (mysqli_num_rows($result_order_complete) > 0) {
                        while ($fetch_review = mysqli_fetch_assoc($result_order_complete)) {
                            $sql_products = "SELECT * FROM products WHERE product_name = '" . mysqli_real_escape_string($conn, $fetch_review['products']) . "'";
                            $result_products = mysqli_query($conn, $sql_products);
                            $fetch_products = mysqli_fetch_assoc($result_products);
                            ?>
                            <div class="box-review m-3">
                                <p>ORDER ID: <span><?php echo $fetch_review["orders_complete_id"] ?></span></p>
                                <p>ชื่อสินค้า: <span><?php echo htmlspecialchars($fetch_review["products"]) ?></span></p>
                                <p>สถานะการจ่ายเงิน: <span style="color: green;"><?php echo htmlspecialchars($fetch_review["status"]) ?></span></p>
                                
                                <?php if ($fetch_products): ?>
                                    <img src="upload_images/<?php echo htmlspecialchars($fetch_products["image_url"]) ?>" width="100%" class="mb-3 rounded" style="height: 200px; object-fit: cover;" alt="">
                                <?php endif; ?>

                                <a href="reviews.php?action=add&id=<?php echo $fetch_review["orders_complete_id"] ?>" class="btn btn-primary w-100">รีวิว</a>
                            </div>
                            <?php 
                        }
                    } else {
                        echo "<p class='text-center w-100 text-muted'>ยังไม่มีออเดอร์ที่ชำระเงินเรียบร้อยสำหรับเขียนรีวิว</p>";
                    }
                ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
