<?php 
    require_once 'config/db.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        header("Location: login.php");
        exit();
    }

    // --- Action 1: Add to Cart (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['cart']) || isset($_POST['buy']))) {
        $p_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $qty = intval($_POST['qty']);
        $img = mysqli_real_escape_string($conn, $_POST['images']);

        // Check if item is already in the user's cart
        $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE product_name = '$p_name' AND user_id = '$user_id'");
        
        if (mysqli_num_rows($check_cart) > 0) {
            echo "<script>alert('สินค้าอยู่ในตะกร้าแล้ว'); window.location.href='index.php';</script>";
            exit();
        } else {
            $sql = "INSERT INTO cart(user_id, product_name, price, quantity, image) VALUES('$user_id', '$p_name', '$price', '$qty', '$img')";
            if (mysqli_query($conn, $sql)) {
                if (isset($_POST['buy'])) {
                    // Redirect directly to cart for checkout if "Buy Now" clicked
                    echo "<script>alert('เพิ่มสินค้าลงตะกร้าเรียบร้อย'); window.location.href='cart.php';</script>";
                } else {
                    echo "<script>alert('เพิ่มสินค้าลงตะกร้าเรียบร้อย'); window.location.href='index.php';</script>";
                }
                exit();
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด'); window.location.href='index.php';</script>";
                exit();
            }
        }
    }

    // --- Action 2: Delete item(s) from Cart (GET) ---
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        
        if ($action === 'delete' && isset($_GET['id'])) {
            $cart_id = intval($_GET['id']);
            $delete_query = mysqli_query($conn, "DELETE FROM cart WHERE cart_id = '$cart_id' AND user_id = '$user_id'");
            if ($delete_query) {
                header("Location: cart.php");
                exit();
            } else {
                echo "การลบข้อมูลผิดพลาด";
                exit();
            }
        }
        
        if ($action === 'delete_all') {
            $delete_all_query = mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");
            if ($delete_all_query) {
                header("Location: cart.php");
                exit();
            } else {
                echo "การลบข้อมูลผิดพลาด";
                exit();
            }
        }
    }

    // --- Action 3: Display Cart Page (GET) ---
    // Fetch cart list
    $result_cart_show = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
    $total_price_all = 0;
    $total_qty = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php require "includes/header.php"; ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:20px">cart</h1>

    <div class="box-cart">
        <form action="checkout.php" method="post" enctype="multipart/form-data">
            <div class="box-showcart">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">ชื่อสินค้า</th>
                            <th scope="col">ราคา(บาท)</th>
                            <th scope="col">จำนวน</th>
                            <th scope="col">ราคาทั้งหมดของสินค้าชิ้นนี้</th>
                            <th scope="col">รูปภาพ</th>
                            <th scope="col">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(mysqli_num_rows($result_cart_show) > 0) {
                                while($fetch_cart = mysqli_fetch_assoc($result_cart_show)) {
                                    $item_total_price = $fetch_cart["price"] * $fetch_cart["quantity"];
                                    $total_qty += $fetch_cart["quantity"];
                                    $total_price_all += $item_total_price;
                                    ?>
                                    <tr>
                                        <input type="hidden" name="user_id" value="<?php echo $fetch_cart["user_id"];?>">
                                        <input type="hidden" name="cart_id[]" value="<?php echo $fetch_cart["cart_id"]; ?>">
                                        
                                        <td><?php echo htmlspecialchars($fetch_cart["product_name"]); ?></td>
                                        <input type="hidden" value="<?php echo htmlspecialchars($fetch_cart["product_name"]); ?>" name="product_name[]">

                                        <td><?php echo number_format($fetch_cart["price"], 2); ?>
                                            <input type="hidden" name="price[]" value="<?php echo $fetch_cart["price"]; ?>">
                                        </td>

                                        <td><?php echo $fetch_cart["quantity"]; ?>        
                                            <input type="hidden" name="qty[]" value="<?php echo $fetch_cart["quantity"]; ?>">
                                        </td>

                                        <td><?php echo number_format($item_total_price, 2); ?> บาท</td>

                                        <td><img src="upload_images/<?php echo htmlspecialchars($fetch_cart["image"]); ?>" alt="" style="width:100px; height: 100px;"></td>

                                        <td>
                                            <a href="cart.php?action=delete&id=<?php echo $fetch_cart["cart_id"]; ?>">
                                                <i class="fas fa-trash" style="font-size:25px; color:red;" onclick="return confirm('คุณแน่ใจว่าจะลบสินค้าชิ้นนี้')"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>ไม่มีสินค้าในตะกร้าของคุณ</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if(mysqli_num_rows($result_cart_show) > 0): ?>
            <div class="box-payment">
                <div class="box-detail">
                    <div class="text-payment">
                        <ul>         
                            <li style="font-weight: bold; color:white;">วิธีการชำระเงิน</li>
                            <li id="payment_method" style="margin-left: 10px; color:white;">เก็บเงินปลายทาง</li>
                            <li style="margin-left: 10px;"><a href="#" style="color:red;" data-bs-toggle="modal" data-bs-target="#paymentModal">เปลี่ยน</a></li>
                        </ul>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="color: black;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentModalLabel">เลือกวิธีการชำระเงิน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <select id="payment_type_select" class="form-select" name="payment_id">
                                        <?php 
                                            $payments_query = mysqli_query($conn, "SELECT * FROM payment_type");
                                            while($fetch_payment = mysqli_fetch_assoc($payments_query)) {
                                                echo "<option value='" . $fetch_payment["payment_id"] . "'>" . htmlspecialchars($fetch_payment["payment_name"]) . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="sendPaymentType()">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="total-all">
                        ราคาทั้งหมด <?php echo number_format($total_price_all, 2); ?> บาท
                        <input type="hidden" name="total_qty" value="<?php echo $total_qty;?>">
                        <input type="hidden" name="total_price_all" value="<?php echo $total_price_all?>">
                    </div>

                    <div class="box-input">
                        <input type="submit" value="SUBMIT" class="btn btn-success" name="submit">
                        <a href="cart.php?action=delete_all" class="btn btn-danger d" onclick="return confirm('คุณแน่ใจว่าจะลบสินค้าทั้งหมด')">DELETE ALL</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="js/script.js"></script>
    <script>
        function sendPaymentType() {
            var select = document.getElementById('payment_type_select');
            var selectedText = select.options[select.selectedIndex].text;
            document.getElementById('payment_method').innerText = selectedText;
        }
    </script>
</body>
</html>
