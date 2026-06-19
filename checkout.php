<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        header("Location: login.php");
        exit();
    }

    $currentDate = date("Y-m-d H:i:s");

    // --- Action 1: Handle Order Completion (POST to checkout.php?action=complete) ---
    if (isset($_GET['action']) && $_GET['action'] === 'complete' && isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn, $_POST['user_id']);
        
        if ($id == $user_id && !empty($_POST["order_id"])) {
            $order_ids = $_POST["order_id"];
            $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
            $product_array = $_POST["product"];
            $qty_array = $_POST["qty"];
            $amount_array = $_POST["amount"];
            $totalAmount_array = $_POST["total_amount"];
            $order_date = mysqli_real_escape_string($conn, $_POST["order_date"]);
            $payment_method = mysqli_real_escape_string($conn, $_POST["payment_method"]);
            $status = mysqli_real_escape_string($conn, $_POST["status"]);
            $address = mysqli_real_escape_string($conn, $_POST["address"]);
            $tel = mysqli_real_escape_string($conn, $_POST["tel"]);

            if (empty($order_date) || empty($fullname) || empty($product_array) || empty($qty_array) || empty($amount_array) || empty($totalAmount_array) || empty($payment_method) || empty($status) || empty($address) || empty($tel)) {
                echo "<script>alert('ข้อมูลไม่ครบถ้วน'); window.location.href='cart.php';</script>";
                exit();
            }

            $success = false;
            foreach ($product_array as $index => $product_name) {
                $order_id = intval($order_ids[$index]);
                $qty = intval($qty_array[$index]);
                $amount = floatval($amount_array[$index]);
                $a_total_amount = $amount * $qty;

                $sql = "INSERT INTO orders_complete (order_id, user_id, order_date, fullname, tel, address, products, quantity, amount, total_amount, payment_method, status) 
                        VALUES ('$order_id', '$id', '$order_date', '$fullname', '$tel', '$address', '" . mysqli_real_escape_string($conn, $product_name) . "', '$qty', '$amount', '$a_total_amount', '$payment_method', '$status')";
                
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $success = true;
                }
            }

            if ($success) {
                // Delete user's cart and temporary orders
                mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$id'");
                mysqli_query($conn, "DELETE FROM orders WHERE user_id = '$id'");
                
                echo "<script>alert('ยืนยันการสั่งซื้อสำเร็จ!'); window.location.href='index.php';</script>";
                exit();
            } else {
                echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลการสั่งซื้อ: " . mysqli_error($conn);
                exit();
            }
        } else {
            echo "รหัสผู้ใช้ไม่ถูกต้อง";
            exit();
        }
    }

    // --- Action 2: Process Initial Form Submission from Cart (POST from cart.php) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
        $cart_ids = $_POST['cart_id'];
        $a_qtys = $_POST['qty'];
        $price_array = $_POST['price'];
        $product_names = $_POST['product_name'];
        $payment_id = intval($_POST['payment_id']);

        // Fetch user data
        $user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
        $row_user = mysqli_fetch_assoc($user_query);

        // Fetch payment method data
        $payment_query = mysqli_query($conn, "SELECT * FROM payment_type WHERE payment_id = '$payment_id'");
        $row_payment = mysqli_fetch_assoc($payment_query);
        $payment_name = $row_payment['payment_name'] ?? 'Cash on delivery';

        if (empty($a_qtys) || empty($price_array) || empty($product_names)) {
            echo "<script>alert('ไม่มีข้อมูลในตะกร้า'); window.location.href='cart.php';</script>";
            exit();
        }

        // Clean up any old temporary orders for this user first
        mysqli_query($conn, "DELETE FROM orders WHERE user_id = '$user_id'");

        // Insert new temporary orders
        foreach ($product_names as $index => $product_name) {
            $qty = intval($a_qtys[$index]);
            $price = floatval($price_array[$index]);
            $total_amount = $price * $qty;
            
            $sql = "INSERT INTO orders(user_id, order_date, tel, address, product, quantity, amount, total_amount, payment_method) 
                    VALUES('$user_id', '$currentDate', '$row_user[tel]', '$row_user[address]', '" . mysqli_real_escape_string($conn, $product_name) . "', '$qty', '$price', '$total_amount', '$payment_name')";
            mysqli_query($conn, $sql);
        }
    } else {
        // If accessed directly without post, check if there are temp orders, if not redirect to cart
        $check_temp = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'");
        if (mysqli_num_rows($check_temp) === 0) {
            header("Location: cart.php");
            exit();
        }
    }

    // --- Action 3: Display Checkout Review Confirmation Page (GET/POST) ---
    // Fetch temp orders
    $orders_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'");
    $user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
    $row_user = mysqli_fetch_assoc($user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php require "includes/header.php"; ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:20px">Order Confirmation</h1>

    <div class="container-order">
        <div class="container-box-order">
            <form action="checkout.php?action=complete" method="post">
                <table class="table mb-4">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ชื่อผู้ใช้งาน</th>
                            <th scope="col">สินค้า</th>
                            <th scope="col">จำนวนสินค้า</th>
                            <th scope="col">ราคาสินค้า</th>
                            <th scope="col">ราคาสินค้ารวมแต่ละชิ้น</th>
                            <th scope="col">วิธีชำระเงิน</th>
                            <th scope="col">เบอร์โทรศัพท์</th>
                            <th scope="col">ที่อยู่</th>
                            <th scope="col">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="table-warning">
                        <input type="hidden" name="user_id" value="<?php echo $row_user["user_id"]; ?>">
                        <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($row_user["firstname"] . " " . $row_user["lastname"]); ?>">
                        
                        <?php 
                            $order_index = 1;
                            while($rows = mysqli_fetch_assoc($orders_query)) {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $order_index++; ?>
                                        <input type="hidden" name="order_id[]" value="<?php echo $rows["order_id"]; ?>">
                                    </th>
                                    <td><?php echo htmlspecialchars($row_user["firstname"] . " " . $row_user["lastname"]); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($rows["product"]); ?>
                                        <input type="hidden" name="product[]" value="<?php echo htmlspecialchars($rows["product"]); ?>">
                                    </td>
                                    <td>
                                        <?php echo $rows["quantity"]; ?>
                                        <input type="hidden" name="qty[]" value="<?php echo $rows["quantity"]; ?>">
                                    </td>
                                    <td>
                                        <?php echo number_format($rows["amount"], 2); ?>
                                        <input type="hidden" name="amount[]" value="<?php echo $rows["amount"]; ?>">
                                    </td>
                                    <td>
                                        <?php echo number_format($rows["total_amount"], 2); ?>
                                        <input type="hidden" name="total_amount[]" value="<?php echo $rows["total_amount"]; ?>">
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rows["payment_method"]); ?>
                                        <input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($rows["payment_method"]); ?>">
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row_user["tel"]); ?>
                                        <input type="hidden" name="tel" value="<?php echo htmlspecialchars($row_user["tel"]); ?>">
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row_user["address"]); ?>
                                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($row_user["address"]); ?>">
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rows["status"]); ?>
                                        <input type="hidden" name="status" value="<?php echo htmlspecialchars($rows["status"]); ?>">
                                    </td>
                                    <input type="hidden" name="order_date" value="<?php echo htmlspecialchars($rows["order_date"]); ?>">
                                </tr>
                                <?php 
                            }
                        ?>
                    </tbody>
                </table>

                <div class="order-button text-center">
                    <button type="submit" class="btn btn-success mb-3 me-2" name="submit">ยืนยัน</button>
                    <a href="index.php" class="btn btn-danger mb-3">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
