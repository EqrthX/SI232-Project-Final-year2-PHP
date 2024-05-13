<?php 
    require "connection.php";
    session_start();

    if (!isset($_SESSION["admin_id"])) {
        header("Location: Login.php");
        exit();
    }

    $order_cID = $_GET["id"] ?? ''; // Default to empty string if not set
    if (!$order_cID) {
        echo "ไม่พบรหัสออเดอร์";
    } else {
        $order_cID = mysqli_real_escape_string($conn, $order_cID); // Prevent SQL Injection
        $sql = "SELECT * FROM tranfer_payment WHERE orders_complete_id = '$order_cID'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check order</title>
    <link rel="stylesheet" href="css/style_admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php require "adminHeader.php" ?>

    <div class="container">

        <h1>Check Order</h1>

        <div class="check-box">

            <a href="adminOrder.php" class="arrow">&#x2190;</a>

            <div class="box-order-check">

                <?php if (!empty($row)): ?>

                    <form action="update_Payment.php" method="post">

                        <div class="order-details">
                            <div class="text">
                                <h3>Order ID: <?php echo $row["orders_complete_id"]; ?></h3>
                                <input type="hidden" value="<?php echo $row["orders_complete_id"]; ?>" name="order_cID">
                                <p>ชื่อ: <?php echo $row["fullname"]; ?></p>
                            </div>

                            <div class="form-check-group">

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="รอดำเนินการ" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        ยังไม่ชำระ
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="ชำระเงินเรียบร้อย">
                                    <label class="form-check-label" for="exampleRadios2">
                                        ชำระเงินเรียบร้อย
                                    </label>
                                </div>

                            </div>

                            <?php if (!empty($row["slip"])): ?>

                                <img src="images_qr/<?php echo $row["slip"]; ?>" width="250px">

                            <?php else: ?>

                                <p>ไม่มีสลิปเงิน</p>

                            <?php endif; ?>

                        </div>

                        <button type="submit" class="btn btn-primary" name="submit">ยืนยัน</button>

                    </form>

                <?php else: ?>

                    <p>ไม่พบข้อมูล</p>

                <?php endif; ?>

            </div>

        </div>

    </div>

</body>
</html>
