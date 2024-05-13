<?php 

    require "connection.php";

    session_start();

    $user_id = $_SESSION["user_id"];

    if(!isset($user_id)) {

        header("Location:Login.php");
        exit();

    }

    if(isset($_POST["submit"])) {

        $order_cID = $_POST["order_cID"];

        $fullname = $_POST["fullname"];

        $product_name = $_POST["product_name"];

        $content = $_POST["content"];

        $date = date("Y:m:d H:m:s");

        $sql_status = "SELECT status FROM orders_complete WHERE orders_complete_id = '$order_cID' AND status = 'ชำระเงินเรียบร้อย' ";

        $result_status = mysqli_query($conn, $sql_status);

        if($result_status) {

            $row_status = mysqli_fetch_assoc($result_status);

        }
    
        if(empty($order_cID) || empty($fullname) || empty($product_name) || empty($content) || empty($date)) {

            echo "ไม่มีข้อมูลตัวใดตัวนึง";

        } else {

            $sql = "INSERT INTO reviews(orders_complete_id, user_id, fullname, products, content, review_date, status) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

            if($prepareStmt) {

                mysqli_stmt_bind_param($stmt, "sssssss" , $order_cID, $user_id, $fullname, $product_name, $content, $date, $row_status['status']);
                mysqli_stmt_execute($stmt);
                header("Location:Reviews.php");
                exit();

            } else {

                echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";

            }

        }

    }

?>