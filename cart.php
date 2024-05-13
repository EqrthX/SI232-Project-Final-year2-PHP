<?php 

    require "connection.php";

    session_start();

    if(isset($_POST["cart"])) {

        $p_name = $_POST["product_name"];

        $price = $_POST["price"];

        $qty = $_POST["qty"];

        $img = $_POST["images"];

        $user_id = $_SESSION["user_id"];

        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE product_name = '$p_name' AND user_id = '$user_id'");

        if(mysqli_num_rows($check_cart_numbers) > 0) {

            echo "<script>alert('สินค้าอยู่ในตะกร้า')</script>";

            header("location:Home.php");


        } else {

            $sql = "INSERT INTO cart(user_id, product_name, price, quantity, image) VALUES('$user_id', '$p_name', '$price', '$qty', '$img')";

            $result = mysqli_query($conn, $sql);

            echo "<script>alert('เพิ่มสินค้าลงตะกร้า')</script>";

            header("location:Home.php");


        }

    }

    if(isset($_POST["buy"])) {

        $p_name = $_POST["product_name"];

        $price = $_POST["price"];

        $qty = $_POST["qty"];

        $img = $_POST["images"];

        $user_id = $_SESSION["user_id"];

        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE product_name = '$p_name' AND user_id = '$user_id'");

        if(mysqli_num_rows($check_cart_numbers) > 0) {

            echo "<script>alert('สินค้าอยู่ในตะกร้า')</script>";

            header("location:Home.php");


        } else {

            $sql = "INSERT INTO cart(user_id, product_name, price, quantity, image) VALUES('$user_id', '$p_name', '$price', '$qty', '$img')";

            $result = mysqli_query($conn, $sql);

            echo "<script>alert('เพิ่มสินค้าลงตะกร้า')</script>";

            header("location:Home.php");


        }
        
    }

?>
