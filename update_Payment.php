<?php 

    require "connection.php";

    session_start();

    $user_id = $_SESSION["admin_id"];

    if(!isset($user_id)) {

        header("Location:Login.php");
        exit();

    }

    if(isset($_POST["submit"])) {

        $order_cID = $_POST["order_cID"];

        $status = $_POST["status"];

        $sql = "SELECT * FROM orders_complete WHERE orders_complete_id = '$order_cID'";

        $result = mysqli_query($conn, $sql);
            
        if(mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            if($status == "รอดำเนินการ") {

                $update = "UPDATE orders_complete SET status = '$status' WHERE orders_complete_id = '$order_cID'";

                $result = mysqli_query($conn, $update);

                if($result) {

                    echo "อัพเดทสถานะเรียบร้อยแล้วเป็น 'ยังไม่ชำระ' ";

                } else {

                    echo mysqli_errno($conn);

                }

            } else if ($status == "ชำระเงินเรียบร้อย") {

                $update = "UPDATE orders_complete SET status = '$status' WHERE orders_complete_id = '$order_cID'";

                $result = mysqli_query($conn, $update);
                
                if($result) {

                    echo "อัพเดทสถานะเรียบร้อยแล้วเป็น 'ชำระเงินเรียบร้อย' ";

                    $sql_update_products = "SELECT * FROM products WHERE product_name = '$row[products]'";

                    $result_update_products = mysqli_query($conn, $sql_update_products);

                    if($result_update_products) {

                        $fetch_products = mysqli_fetch_assoc($result_update_products);

                        $minus = $fetch_products["quantity"] - $row["quantity"];

                        $update_product = "UPDATE products SET quantity = '$minus' WHERE product_name = '$row[products]'";

                        $result = mysqli_query($conn, $update_product);

                        if($result) {

                            echo "อัพเดทจำนวนสินค้าเรียบร้อย";
                            header("Location:adminOrder.php");
                            exit();

                        } else {

                            echo mysqli_errno($conn) . "เกิดข้อผิดพลาดในการอัพเดท";

                        }
                    }


                } else {

                    echo mysqli_errno($conn);

                }

            }

        } else {

            echo "ไม่พบข้อมูล";

        }

    }

?>