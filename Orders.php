<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION["user_id"] ?? null;

    if (!$user_id) {
        header("Location: login.php");
        exit();
    }

    $alert_message = '';

    // --- Action: Handle Payment Slip Upload (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_slip'])) {
        $id = intval($_POST["id"]);
        
        if ($id === $user_id && isset($_POST["order_complete_id"])) {
            $order_cID = intval($_POST["order_complete_id"]);
            $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
            $totalsum = floatval($_POST["totalsum"]);
            
            $image = $_FILES["slip"]["name"];
            $image_tmp_name = $_FILES["slip"]["tmp_name"];
            $upload_qr = "images_qr/" . $image;

            if (empty($fullname) || empty($totalsum)) {
                $alert_message = "<script>alert('มีข้อมูลบางส่วนว่างเปล่า')</script>";
            } else {
                if ($_FILES["slip"]["error"] == UPLOAD_ERR_OK) {
                    if (move_uploaded_file($image_tmp_name, $upload_qr)) {
                        $sql = "INSERT INTO tranfer_payment(orders_complete_id, slip, user_id, fullname) 
                                VALUES('$order_cID', '$image', '$id', '$fullname')";
                        
                        if (mysqli_query($conn, $sql)) {
                            $alert_message = "<script>alert('แจ้งชำระเงินสำเร็จแล้ว รอผู้ดูแลระบบตรวจสอบข้อมูล'); window.location.href='orders.php';</script>";
                        } else {
                            $alert_message = "<script>alert('เพิ่มข้อมูลการโอนเงินไม่สำเร็จ')</script>";
                        }
                    } else {
                        $alert_message = "<script>alert('เกิดข้อผิดพลาดในการบันทึกสลิป')</script>";
                    }
                } else {
                    $alert_message = "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์: " . $_FILES["slip"]["error"] . "')</script>";
                }
            }
        } else {
            $alert_message = "<script>alert('รหัสผู้ใช้ไม่ถูกต้อง')</script>";
        }
    }

    // --- Action 2: Display Orders Page ---
    $sql_order_complete = "SELECT * FROM orders_complete WHERE user_id = '$user_id'";
    $result_order_complete = mysqli_query($conn, $sql_order_complete);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php echo $alert_message; ?>
    <?php require "includes/header.php"; ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:20px">Check order</h1>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table">
            <thead class="table-success">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">ชื่อสินค้า</th>
                    <th scope="col">จำนวนที่สั่ง</th>
                    <th scope="col">ราคาสินค้าแต่ละชิ้น</th>
                    <th scope="col">ราคารวมสินค้าแต่ละชิ้น</th>
                    <th scope="col">วิธีการชำระเงิน</th>
                    <th scope="col">สถานะการจ่ายเงิน</th>
                    <th scope="col">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $order_index = 1;
                    if(mysqli_num_rows($result_order_complete) > 0) {
                        while ($rows = mysqli_fetch_assoc($result_order_complete)) {
                            ?>
                            <tr>
                                <td><?php echo $order_index++; ?></td>
                                <td><?php echo htmlspecialchars($rows["fullname"]); ?></td>
                                <td><?php echo htmlspecialchars($rows["products"]); ?></td>
                                <td><?php echo $rows["quantity"]; ?></td>
                                <td><?php echo number_format($rows["amount"], 2); ?></td>
                                <td><?php echo number_format($rows["total_amount"], 2); ?></td>
                                <td><?php echo htmlspecialchars($rows["payment_method"]); ?></td>
                                <td>
                                    <?php 
                                        if($rows["status"] == "รอดำเนินการ") {
                                            echo "<span class='badge bg-warning text-dark'>" . htmlspecialchars($rows["status"]) . "</span>";
                                        } else if ($rows["status"] == "ชำระเงินเรียบร้อย") {
                                            echo "<span class='badge bg-success'>" . htmlspecialchars($rows["status"]) . "</span>";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php if($rows["status"] == "รอดำเนินการ" && trim($rows["payment_method"]) === "Transfer money"): ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal_<?php echo $rows["orders_complete_id"] ?>">
                                            ชำระเงิน
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_<?php echo $rows["orders_complete_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">แจ้งชำระเงิน</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="orders.php" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body text-start">
                                                            <p>วิธีการชำระเงิน: <strong><?php echo htmlspecialchars($rows["payment_method"]); ?></strong></p>
                                                            <img src="images/qr.jpg" alt="Payment QR" width="100%" class="mt-2 mb-3 border rounded">
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">แนบสลิปเงินโอน</label>
                                                                <input class="form-control" type="file" id="formFile" name="slip" required accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" value="<?php echo $rows["user_id"] ?>" name="id">
                                                            <input type="hidden" value="<?php echo $rows["orders_complete_id"] ?>" name="order_complete_id">
                                                            <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($rows["fullname"]); ?>">
                                                            <input type="hidden" name="totalsum" value="<?php echo $rows["total_amount"]; ?>">

                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                            <button type="submit" class="btn btn-primary" name="submit_slip">ยืนยัน</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>ไม่พบรายการสั่งซื้อ</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
