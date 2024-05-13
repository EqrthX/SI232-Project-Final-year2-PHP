<?php 

require "connection.php";

session_start();

$user_id = $_SESSION["user_id"];

if (!isset($user_id)) {
    header("Location: Login.php");
    exit;
}

if (isset($_POST["submit"])) {

    if ($user_id == $_POST["id"]) {
        
        $id = $_POST["id"];

        if (isset($_POST["order_complete_id"])) {

            $order_cID = $_POST["order_complete_id"];

            $fullname = $_POST["fullname"];

            $totalsum = $_POST["totalsum"];

            $image = $_FILES["slip"]["name"];

            $image_tmp_name = $_FILES["slip"]["tmp_name"];

            $upload_qr = "images_qr/" . $image;

            if (empty($fullname) || empty($totalsum)) {

                echo "มีค่าว่างอยู่ตัวใดตัวนึง";

            } else {

                if ($_FILES["slip"]["error"] == UPLOAD_ERR_OK) {

                    if (move_uploaded_file($image_tmp_name, $upload_qr)) {

                        $sql = "INSERT INTO tranfer_payment(orders_complete_id, slip, user_id, fullname) VALUES('$order_cID', '$image', '$id', '$fullname')";

                        $result = mysqli_query($conn, $sql);

                        if($result) {

                            header("Location:Home.php");
                            exit();

                        } else {

                            echo "เพิ่มข้อมูลการโอนเงินไม่สำเร็จ";

                        }

                    } else {

                        echo "เกิดข้อผิดพลาดในการย้ายไฟล์";

                    }

                } else {

                    echo "เกิดข้อผิดพลาดในการอัปโหลด: " . $_FILES["slip"]["error"];

                }



            }

        } else {

            echo "รหัสยืนยันรายการสินค้าไม่ถูกต้อง";

        }

    } else {

        echo "รหัสผู้ใช้ที่ชำระเงินไม่ถูกต้อง";

    }
}
?>
