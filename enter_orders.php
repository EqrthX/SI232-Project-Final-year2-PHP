<?php 

require "connection.php";

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header("location:Login.php");
    exit();
}

if($user_id === $_POST["user_id"]) {
    
    $id = $_POST["user_id"];

    if(isset($_POST["cart_id"])) {
        
        $cart_id = $_POST["cart_id"];
        
        $currentDate = date("Y-m-d H:i:s");

        $a_qtys = $_POST["qty"];
        
        $price_array = $_POST["price"];

        $product_names = $_POST["product_name"]; // เปลี่ยนชื่อตัวแปรเป็น $product_names (เป็น array)

        $payment_id = $_POST["payment_id"];

        $select_user = "SELECT * FROM users WHERE user_id = '$id'";

        $result_user = mysqli_query($conn, $select_user);

        $row_user = mysqli_fetch_assoc($result_user);

        $select_payment = "SELECT * FROM payment_type WHERE payment_id = '$payment_id'";

        $result_payment = mysqli_query($conn, $select_payment);

        $row_payment = mysqli_fetch_assoc($result_payment);

        if(empty($a_qtys) OR empty($price_array) OR empty($product_names) OR empty($payment_id)) {

            echo "ไม่มีข้อมูลทั้งหมด";

        } else {
            
            foreach($product_names as $index => $product_name) {

                $qty = $a_qtys[$index];

                $price = $price_array[$index];

                $total_amount = 0 ;

                $total_amount = $price * $qty;

                $sql_array = "INSERT INTO orders(user_id, order_date, tel, address, product, quantity, amount, total_amount , payment_method) VALUES('$id', '$currentDate', '$row_user[tel]', '$row_user[address]', '$product_name', '$qty', '$price', '$total_amount','$row_payment[payment_name]')";
                
                $result_product_array = mysqli_query($conn, $sql_array);

            }

            if($result_product_array) {

                header("Location:Orders_Page.php");
                exit();
                    
            } else {

                echo mysqli_errno($conn) . "\tเกิดข้อผิดพลาดในการเพิ่มข้อมูลแบบ array";

            }
        }

    } else {

        echo "<div class='alert alert-danger'>ไม่มีข้อมูลตะกร้าสินค้า</div>";

    }

    

} else {

    echo "<div class='alert alert-danger'>รหัสลูกค้าไม่ถูกต้อง</div>";
    header("Location: Home.php");
    exit();

}

?>
