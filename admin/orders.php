<?php 
    require_once '../config/db.php';
    session_start();

    $admin_id = $_SESSION['admin_id'] ?? null;
    if(!$admin_id) {
        header("Location: ../login.php");
        exit();
    }

    $action = $_GET['action'] ?? '';
    $alert_message = '';

    // --- Action 1: Update Payment Status & Adjust Product Stock (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_payment' && isset($_POST['submit_update'])) {
        $order_cID = intval($_POST["order_cID"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);

        $check_order = mysqli_query($conn, "SELECT * FROM orders_complete WHERE orders_complete_id = '$order_cID'");
        
        if (mysqli_num_rows($check_order) > 0) {
            $row = mysqli_fetch_assoc($check_order);
            
            // Update order status
            $update = "UPDATE orders_complete SET status = '$status' WHERE orders_complete_id = '$order_cID'";
            if (mysqli_query($conn, $update)) {
                
                // If payment completed, deduct product stock
                if ($status === 'ชำระเงินเรียบร้อย') {
                    $prod_name_esc = mysqli_real_escape_string($conn, $row['products']);
                    $product_query = mysqli_query($conn, "SELECT * FROM products WHERE product_name = '$prod_name_esc'");
                    
                    if ($product_query && mysqli_num_rows($product_query) > 0) {
                        $fetch_products = mysqli_fetch_assoc($product_query);
                        $new_qty = $fetch_products["quantity"] - $row["quantity"];
                        $new_qty = ($new_qty < 0) ? 0 : $new_qty; // stock shouldn't be negative
                        
                        $status_stock = ($new_qty > 0) ? 'In stock' : 'Not in stock';
                        
                        // Update stock and status
                        mysqli_query($conn, "UPDATE products SET quantity = '$new_qty', status = '$status_stock' WHERE product_name = '$prod_name_esc'");
                    }
                }
                $alert_message = "<script>alert('อัปเดตสถานะการชำระเงินเรียบร้อยแล้ว'); window.location.href='orders.php';</script>";
            } else {
                $alert_message = "<script>alert('เกิดข้อผิดพลาดในการอัปเดตสถานะ');</script>";
            }
        } else {
            $alert_message = "<script>alert('ไม่พบข้อมูลออเดอร์นี้');</script>";
        }
    }

    // Determine view content
    $order_cID = isset($_GET['id']) ? intval($_GET['id']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Manager</title>
    
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php echo $alert_message; ?>
    <?php require 'includes/header.php' ?>

    <section class="dashboard">
        <div class="container">
            <?php if ($action === 'check' && $order_cID): ?>
                <!-- Check Order Slip and Details -->
                <?php 
                    $sql_payment = mysqli_query($conn, "SELECT * FROM tranfer_payment WHERE orders_complete_id = '$order_cID'");
                    $has_payment = mysqli_num_rows($sql_payment) > 0;
                    $row_payment = $has_payment ? mysqli_fetch_assoc($sql_payment) : null;

                    $sql_order = mysqli_query($conn, "SELECT * FROM orders_complete WHERE orders_complete_id = '$order_cID'");
                    $row_order = mysqli_fetch_assoc($sql_order);
                ?>
                <h1 class="mt-3">Check Order Payment</h1>
                <div class="check-box mx-auto">
                    <a href="orders.php" class="arrow mb-3 d-inline-block">&#x2190; ย้อนกลับ</a>

                    <?php if ($row_order): ?>
                        <form action="orders.php?action=update_payment" method="post">
                            <div class="order-details text-start mb-3">
                                <h3>Order ID: <?php echo $row_order["orders_complete_id"]; ?></h3>
                                <input type="hidden" value="<?php echo $row_order["orders_complete_id"]; ?>" name="order_cID">
                                <p>ชื่อผู้สั่ง: <strong><?php echo htmlspecialchars($row_order["fullname"]); ?></strong></p>
                                <p>เบอร์โทรศัพท์: <strong><?php echo htmlspecialchars($row_order["tel"]); ?></strong></p>
                                <p>ที่อยู่จัดส่ง: <strong><?php echo htmlspecialchars($row_order["address"]); ?></strong></p>
                                <p>สินค้า: <strong><?php echo htmlspecialchars($row_order["products"]); ?> (x<?php echo $row_order["quantity"]; ?>)</strong></p>
                                <p>ยอดชำระทั้งหมด: <strong><?php echo number_format($row_order["total_amount"], 2); ?> บาท</strong></p>
                                <p>วิธีการชำระเงิน: <strong><?php echo htmlspecialchars($row_order["payment_method"]); ?></strong></p>
                            </div>

                            <div class="form-check-group text-start mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="รอดำเนินการ" <?php if($row_order['status'] === 'รอดำเนินการ') echo 'checked'; ?>>
                                    <label class="form-check-label" for="exampleRadios1">ยังไม่ชำระ / รอดำเนินการ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="ชำระเงินเรียบร้อย" <?php if($row_order['status'] === 'ชำระเงินเรียบร้อย') echo 'checked'; ?>>
                                    <label class="form-check-label" for="exampleRadios2">ชำระเงินเรียบร้อย</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5>สลิปโอนเงิน:</h5>
                                <?php if ($row_payment && !empty($row_payment["slip"])): ?>
                                    <img src="../images_qr/<?php echo htmlspecialchars($row_payment["slip"]); ?>" width="100%" class="border rounded" alt="Transfer Slip">
                                <?php else: ?>
                                    <p class="text-danger">ไม่มีหลักฐานการชำระเงิน (สลิปโอนเงิน)</p>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" name="submit_update">ยืนยันการทำรายการ</button>
                        </form>
                    <?php else: ?>
                        <p>ไม่พบข้อมูลออเดอร์นี้</p>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Default Order List View -->
                <h1>Order Check</h1>

                <form action="orders.php" method="post" class="mb-4">
                    <div class="mb-3">
                        <label class="form-label">ค้นหารายการออเดอร์ (ตามชื่อลูกค้า หรือสินค้า)</label>
                        <input type="text" class="form-control" name="keyword" placeholder="พิมพ์คีย์เวิร์ดสำหรับค้นหา...">
                    </div>
                    <button type="submit" name="search" class="btn btn-primary">ค้นหา</button>
                </form>

                <div class="container-checkorder mt-4 d-flex flex-wrap justify-content-center">
                    <?php 
                        $keyword = isset($_POST['keyword']) ? mysqli_real_escape_string($conn, $_POST['keyword']) : '';
                        if (!empty($keyword)) {
                            $sql = "SELECT * FROM orders_complete WHERE fullname LIKE '%$keyword%' OR products LIKE '%$keyword%' ORDER BY orders_complete_id DESC";
                        } else {
                            $sql = "SELECT * FROM orders_complete ORDER BY orders_complete_id DESC";
                        }

                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0) {
                            while($rows = mysqli_fetch_assoc($result)) {
                                ?>
                                <div class="box-order m-3">
                                    <div class="content text-start">
                                        <h3>Order ID: <span><?php echo $rows["orders_complete_id"]; ?></span></h3>
                                        <p>ชื่อผู้สั่ง: <span><?php echo htmlspecialchars($rows["fullname"]); ?></span> </p>
                                        <p>สินค้า: <span><?php echo htmlspecialchars($rows["products"]); ?> (x<?php echo $rows["quantity"]; ?>)</span></p>
                                        <p>ยอดชำระ: <span><?php echo number_format($rows["total_amount"], 2); ?> บาท</span></p>
                                        <p>การชำระ: <span><?php echo htmlspecialchars($rows["payment_method"]); ?></span></p>
                                        <p>สถานะชำระเงิน: 
                                            <strong>
                                                <?php 
                                                    if($rows["status"] == "รอดำเนินการ") {
                                                        echo "<span class='text-warning'>" . htmlspecialchars($rows["status"]) . "</span>";
                                                    } else if($rows["status"] == "ชำระเงินเรียบร้อย") {
                                                        echo "<span class='text-success'>" . htmlspecialchars($rows["status"]) . "</span>";
                                                    }
                                                ?>
                                            </strong> 
                                        </p>
                                        <a href="orders.php?action=check&id=<?php echo $rows["orders_complete_id"] ?>" class="btn btn-warning w-100 mt-2">ตรวจสอบสถานะชำระเงิน</a>
                                    </div>
                                </div>
                                <?php 
                            }
                        } else {
                            echo "<p class='text-center text-muted w-100'>ไม่พบรายการสั่งซื้อ</p>";
                        }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="../js/Adminscript.js"></script>
</body>
</html>
