<?php 

    require "connection.php";

    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)) {

        header("location:Login.php");
        exit();
        
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDER</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">


</head>
<body>
    
    <?php 
    
        require "header_user.php";
    
    ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:5px">order</h1>

    <?php 
    
        $sql = "SELECT * FROM orders WHERE user_id = $user_id";
        
        $result = mysqli_query($conn, $sql);

        $select_users = "SELECT * FROM users WHERE user_id = $user_id";

        $result_users = mysqli_query($conn, $select_users);

        $row_user = mysqli_fetch_assoc($result_users);
    
    ?>

    <div class="container-order">

        <div class="container-box-order">

            <form action="Order_complete.php" method="post">

                <table class="table mb-3">

                        <thead class="table-primary" >

                            <tr>

                                <th scope="col">#</th>
                                <th scope="col">ชื่อผู้ใช้งาน</th>
                                <th scope="col">สินค้า</th>
                                <th scope="col">จำนวนสินค้า</th>
                                <th scope="col">ราคาสินค้า</th>
                                <th scope="col">ราคาสินค้ารวมแต่ละชิ้น</th>
                                <th scope="col">วิธีชำระเงิน</th>
                                <th scope="col">เบอร์โทรศัพท์</th>
                                <th scope="col">ที่อยู่</th>
                                <th scope="col">สถานะ</th>
                                
                            </tr>

                        </thead>

                        <input type="hidden" name="user_id" value="<?php echo $row_user["user_id"]; ?>">
                        
                        <?php 
                        
                            while($rows = mysqli_fetch_assoc($result)) {

                        ?>

                        <tbody class="table-warning">
                            <tr>

                                <th scope="row">
                                    <?php echo $rows["order_id"] ?>
                                    <input type="hidden" name="order_id[]" value="<?php echo $rows["order_id"] ?>">
                                </th>

                                <td>
                                    <?php echo $row_user["firstname"] . " " . $row_user["lastname"]; ?>
                                    <input type="hidden" name="fullname" value="<?php echo $row_user["firstname"] . " " . $row_user["lastname"]; ?>">
                                </td>

                                <td>
                                    <?php echo $rows["product"] ?>
                                    <input type="hidden" name="product[]" value="<?php echo $rows["product"] ?>">
                                </td>

                                <td>
                                    <?php echo $rows["quantity"] ?>
                                    <input type="hidden" name="qty[]" value="<?php echo $rows["quantity"] ?>">

                                </td>

                                <td>
                                    <?php echo $rows["amount"] ?>
                                    <input type="hidden" name="amount[]" value="<?php echo $rows["amount"] ?>">

                                </td>

                                <td>
                                    <?php echo $rows["total_amount"] ?>
                                    <input type="hidden" name="total_amount[]" value="<?php echo $rows["total_amount"] ?>">
                                </td>

                                <td>
                                    <?php echo $rows["payment_method"] ?>
                                    <input type="hidden" name="payment_method" value="<?php echo $rows["payment_method"] ?>">
                                </td>

                                <td>
                                    <?php echo $row_user["tel"] ?>
                                    <input type="hidden" name="tel" value="<?php echo $rows["tel"] ?>">
                                </td>

                                <td>
                                    <?php echo $row_user["address"] ?>
                                    <input type="hidden" name="address" value="<?php echo $rows["address"] ?>">
                                </td>

                                <td>
                                    <?php echo $rows["status"] ?>
                                    <input type="hidden" name="status" value="<?php echo $rows["status"] ?>">
                                </td>

                                <input type="hidden" name="order_date" value="<?php echo $rows["order_date"] ?>">

                            </tr>
                            
                        </tbody>

                        <?php } ?>
                        
                </table>

                <div class="order-button">

                    <button type="submit" class="btn btn-success mb-3" name="submit">ยืนยัน</button>
                    <a href="Home.php" type="submit" class="btn btn-danger mb-3">ยกเลิก</a>

                </div>

            </form>
            
        </div>

    </div>

    <script src="js/script.js"></script>

</body>
</html>