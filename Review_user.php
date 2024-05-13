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

    <h1 style="text-align:center; text-transform: uppercase; margin-top:5px">review</h1>

    <?php 

        if($_GET["id"]) {

            $sql = "SELECT * FROM orders_complete WHERE orders_complete_id = '$_GET[id]' AND status = 'ชำระเงินเรียบร้อย'";
            
            $result = mysqli_query($conn, $sql);

            if($result) {
            
    ?>
         
        <div class="container">

            <div class="review">

                <a href="Reviews.php" class="arrow">&#x2190;</a>

                <div class="content-review">

                    <form action="check_review.php" method="post">

                        <?php 

                            $row_order = mysqli_fetch_assoc($result);

                            $sql_product = "SELECT * FROM products WHERE product_name = '$row_order[products]'";
                            
                            $result_product = mysqli_query($conn, $sql_product);

                            if($result_product) {

                                $row_product = mysqli_fetch_assoc($result_product);
                        ?>         

                            <div class="text-review">    

                                <h4>ORDER ID: <?php echo $row_order["orders_complete_id"] ?></h4>
                                <input type="hidden" name="order_cID" value="<?php echo $row_order["orders_complete_id"] ?>">

                                <p>ชื่อผู้ใช้: <?php echo $row_order["fullname"] ?></p>
                                <input type="hidden" name="fullname" value="<?php echo $row_order["fullname"] ?>">

                                <p>ชื่อสินค้า: <?php echo $row_product["product_name"]?></p>
                                <input type="hidden" name="product_name" value="<?php echo $row_product["product_name"] ?>">

                                <img src="upload_images/<?php echo $row_product["image_url"] ?>" width="100%" height="25%" style="border-radius: .5rem;" alt="">

                            </div> 

                            <div class="mt-3 form-floating">

                                <textarea class="form-control mb-3" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="content"></textarea>
                                <label for="floatingTextarea2">Review</label>

                            </div>

                            <button type="submit" class="btn btn-primary" name="submit">ยืนยัน</button>

                        <?php

                            }
                        
                        ?>

                    </form>

                </div>

            </div>
                

        </div>


    <?php
            } else {

                header("Location:Reviews.php");
                exit();

            }
 
        }
    
    ?>
    

    <script src="js/script.js"></script>
</body>
</html>
