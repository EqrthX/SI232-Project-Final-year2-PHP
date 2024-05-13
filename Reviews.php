<?php 

    require "connection.php";

    session_start();

    $user_id = $_SESSION["user_id"];

    if(!isset($user_id)) {

        header("Location:Login.php");
        exit();

    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>REVIEWS</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>

<body>

    <?php 
        require "header_user.php";
    ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:5px">reviews</h1>

    <div class="container container-reviews">

        <?php 

            $sql_order_complete = "SELECT * FROM orders_complete WHERE user_id = '$user_id' AND status = 'ชำระเงินเรียบร้อย'";

            $result_order_complete = mysqli_query($conn, $sql_order_complete);

            while ($fetch_review = mysqli_fetch_assoc($result_order_complete)) {
                
                $sql_products = "SELECT * FROM products WHERE product_name = '{$fetch_review['products']}'";

                $result_products = mysqli_query($conn, $sql_products);

                while ($fetch_products = mysqli_fetch_assoc($result_products)) {

        ?>

            <div class="box-review">

                <p>ORDER ID: <span><?php echo $fetch_review["orders_complete_id"] ?></span></p>

                <p>ชื่อสินค้า: <span><?php echo $fetch_review["products"] ?></span></p>

                <p>สถานะการจ่ายเงิน: <span style="color: green;"><?php echo $fetch_review["status"] ?></span></p>

                <img src="upload_images/<?php echo $fetch_products["image_url"] ?>" width="100%" alt="">

                <a href="Review_user.php?id=<?php echo $fetch_review["orders_complete_id"] ?>" class="btn btn-primary">รีวิว</a>
                
            </div>
            
        <?php 

                }

            }

        ?>

    </div>

    <script src="js/script.js"></script>
</body>
</html>
