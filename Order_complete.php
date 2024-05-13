<?php
require "connection.php";

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header("location:Login.php");
    exit();
}

if (isset($_POST["submit"])) {

    if (isset($_POST["user_id"]) == $user_id) {

        $id = $_POST["user_id"];

        if (!empty($_POST["order_id"])) {

            $order_ids = $_POST["order_id"];

            $fullname = $_POST["fullname"];

            $product_array = $_POST["product"];

            $qty_array = $_POST["qty"];

            $amount_array = $_POST["amount"];

            $totalAmount_array = $_POST["total_amount"];

            $order_date = $_POST["order_date"];

            $payment_method = $_POST["payment_method"];

            $status = $_POST["status"];

            $address = $_POST["address"];

            $tel = $_POST["tel"];

            if (empty($order_date) || empty($fullname) || empty($product_array) || empty($qty_array) || empty($amount_array) || empty($totalAmount_array) || empty($payment_method) || empty($status) || empty($address) || empty($tel)) {

                echo "ไม่พบข้อมูล";

            } else {

                foreach($product_array as $index => $product_name) {

                    $order_id = $order_ids[$index];

                    $qty = $qty_array[$index];

                    $amount = $amount_array[$index];

                    $total_amount = $amount_array[$index];

                    $a_total_amount = $amount * $qty;

                    $sql = "INSERT INTO orders_complete (order_id, user_id, order_date, fullname, tel, address, products, quantity, amount, total_amount, payment_method, status) VALUES ('$order_id', '$id', '$order_date', '$fullname', '$tel', '$address', '$product_name', '$qty', '$amount', '$a_total_amount', '$payment_method', '$status')";

                    $result = mysqli_query($conn, $sql);

                }

                if($result) {

                    $delete_cart = "DELETE FROM cart WHERE user_id = '$id'";

                    $result_cart = mysqli_query($conn, $delete_cart);

                    $delete_order = "DELETE FROM orders WHERE user_id = '$id'";

                    $result_order = mysqli_query($conn, $delete_order);

                    header("Location:Home.php");

                    exit();

                } else {

                    echo mysqli_errno($conn) . " เกิดข้อผิดพลาดในการเก็บข้อมูลลงตาราง orders_complete";

                }

            }
        } else {

            echo mysqli_errno($conn) . "ไม่พบรหัสรายการสินค้า";
        }
    } else {

        echo mysqli_errno($conn) .  "ไม่พบรหัสผู้ใช้งานนี้";
    }
}

?>