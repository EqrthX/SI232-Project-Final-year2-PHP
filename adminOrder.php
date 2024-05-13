<?php 

    require "connection.php";

    session_start();

    $user_id = $_SESSION["admin_id"];

    if(!isset($user_id)) {

        header("Location:Login.php");

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Check</title>

    <link rel="stylesheet" href="css/style_admin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>

    <?php require "adminHeader.php" ?>

    <section class="dashboard">

        <div class="container">
        <h1>Order Check</h1>

            <form action="" method="post">

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">ค้นหารายการสินค้า</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" >
                </div>

                <button type="submit" class="btn btn-primary mb-5">Check</button>

            </form>

        <div class="container-checkorder">

            <?php 
                
                $sql = "SELECT * FROM orders_complete";

                $result = mysqli_query($conn, $sql);

                while($rows = mysqli_fetch_assoc($result)) {
            
            ?>

            <div class="box-order">

                <div class="content">
                    
                    <h3>order complete id :<span><?php echo $rows["orders_complete_id"]; ?></span></h3>

                    <p>ชื่อผู้สั่ง : <span><?php echo $rows["fullname"]; ?></span> </p>

                    <p>เบอร์โทรศัพท์ : <span><?php echo $rows["fullname"]; ?></span></p>

                    <address>ที่อยู่ : <span><?php echo $rows["address"]; ?></span></address>
                    <h5>สถานนะการชำระเงิน : 

                        <span>

                            <?php 
                    
                                if($rows["status"] == "รอดำเนินการ") {

                                    echo "<p style='color:yellow;'>". $rows["status"] ."</p>";

                                } else if($rows["status"] == "ชำระเงินเรียบร้อย") {

                                    echo "<p style='color:green;'>". $rows["status"] ."</p>";

                                }
                    
                            ?>

                        </span> 
                    </h5>

                    <a href="admin_checkOrder.php?id=<?php echo $rows["orders_complete_id"] ?>" class="btn btn-warning">เช็ค</a>
                    
                </div>

            </div>

            <?php } ?>
                

        </div>

        </div>
        
    </section>



    <script src="js/script.js"></script>
</body>
</html>
