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
    <title>Cart Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">


</head>
<body>
    
    <?php 
    
        require "header_user.php";
    
    ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:5px">cart</h1>

    <div class="box-cart">

        <form action="enter_orders.php" method="post" enctype="multipart/form-data">

            <div class="box-showcart">
                    
                    <table class="table table-bordered">

                        <thead class="table-primary">

                            <tr>
                            
                                <th scope="col" >ชื่อสินค้า</th>

                                <th scope="col" >ราคา(บาท)</th>

                                <th scope="col" >จำนวน</th>

                                <th scope="col" >ราคาทั้งหมดของสินค้าชินนี้</th>

                                <th scope="col" >รูปภาพ</th>
                                
                                <th scope="col" ></th>
                                
                            </tr>

                        </thead>

                        <?php 

                            if(isset($_GET["id"])) {

                                $sql = "SELECT * FROM cart WHERE user_id = '$user_id';";

                                $result_cart_show = mysqli_query($conn, $sql);

                                $total_price_all = 0;

                                $total_qty = 0;

                                while($fetch_cart = mysqli_fetch_assoc($result_cart_show)) {

                        ?>

                        <tbody>

                            <tr>
                                
                                <input type="hidden" name="user_id" value="<?php echo $fetch_cart["user_id"];?>">
                                
                                <input type="hidden" name="cart_id[]" value="<?php echo $fetch_cart["cart_id"]; ?>">

                                <td ><?php echo $fetch_cart["product_name"] ?></td>

                                <input type="hidden" value="<?php echo $fetch_cart["product_name"]?>" name="product_name[]">

                                <td ><?php echo $fetch_cart["price"] ?>
                                    <input type="hidden" name="price[]" value="<?php echo $fetch_cart["price"]; ?>">
                                </td>

                                <td ><?php echo $fetch_cart["quantity"] ?>        
                                    <input type="hidden" name="qty[]" value="<?php echo $fetch_cart["quantity"]; ?>">
                                </td>

                                <td ><?php 

                                        $total_price = $fetch_cart["price"] * $fetch_cart["quantity"];

                                        $total_qty += $fetch_cart["quantity"];

                                        $total_price_all += $total_price;

                                        echo $total_price . ".00 บาท";

                                    ?>

                                </td>

                                <td ><img src="upload_images/<?php echo $fetch_cart["image"] ?>" alt="" style="width:100px; height: 100px;"></td>

                                <td ><a href="cart_del.php?id=<?php echo $fetch_cart["cart_id"]; ?>"><i class="fas fa-trash" style="font-size:25px; color:red;" onclick="return confirm('คุณแน่ใจว่าจะลบสินค้าชิ้นนี้')"></i></a><br></td>

                            </tr>
                            
                        </tbody>

                        <?php } ?>

                    </table>

                </div>
                
                <?php 
                    
                    } 

                ?>

            <div class="box-payment">

                <div class="box-detail">
                    
                    <div class="text-payment">

                            <ul>         

                                <li style="font-weight: bold; color:white;">วิธีการชำระเงิน</li>

                                <li id="payment_method" style="margin-left: 10px; color:white;">เก็บเงินปลายทาง</li>

                                <li style="margin-left: 10px;"><a href="#" style="color:red;" data-bs-toggle="modal" data-bs-target="#paymentModal">เปลี่ยน</a></li>

                            </ul>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title" id="paymentModalLabel">เลือกวิธีการชำระเงิน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                </div>

                                    <div class="modal-body">

                                        <select id="payment_type_select" class="form-select" aria-label="Default select example" name="payment_id">

                                            <?php 
                                            
                                                $sql = "SELECT * FROM payment_type;";

                                                $result = mysqli_query($conn, $sql);

                                                while($fetch_payment = mysqli_fetch_assoc($result)) {

                                                    echo "<option value='" . $fetch_payment["payment_id"] . "' >" . $fetch_payment["payment_name"] . "</option>";
                                                    
                                                }
                                            
                                            ?>
                                            
                                        </select>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" name="enter" onclick="sendPaymentType()">ยืนยัน</button>
                                        
                                    </div>

                            </div>

                        </div>

                    </div>
                        
                    <div class="total-all">

                            <?php 
                            
                            
                            
                            echo "ราคาทั้งหมด " . $total_price_all . " บาท"; 
                            
                            
                            
                            ?>

                            <input type="hidden" name="total_qty" value="<?php echo $total_qty;?>">

                            <input type="hidden" name="total_price_all" value="<?php echo $total_price_all?>">

                    </div>

                    <div class="box-input">

                            <input type="submit" value="SUBMIT" class="btn btn-success" name="submit">

                            <a href="cart_del.php?del_all" name="del_all" class="btn btn-danger d" onclick="return confirm('คุณแน่ใจว่าจะลบสินค้าทั้งหมด')">DELETE ALL</a>

                    </div>

                </div>

            </div>

        </form>

    </div>

    <script src="js/script.js"></script>

</body>
</html>