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
        <title>ORDER</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>

    <?php 
        require "header_user.php";
    ?>

    <h1 style="text-align:center; text-transform: uppercase; margin-top:5px">Check order</h1>

    <?php 
        $sql_order_complete = "SELECT * FROM orders_complete WHERE user_id = '$user_id'";
        $result_order_complete = mysqli_query($conn, $sql_order_complete);
    ?>

    <div class="container">

        <table class="table">

            <thead class="table-success">

                <tr>

                    <th scope="col">#</th>
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">ชื่อสินค้า</th>
                    <th scope="col">จำนวนที่สั่ง</th>
                    <th scope="col">ราคาสินค้าแต่ละชิ้น</th>
                    <th scope="col">ราคารวมสินค้าแต่ละชิ้น</th>
                    <th scope="col">วิธีการชำระเงิน</th>
                    <th scope="col">สถานะการจ่ายเงิน</th>

                </tr>
            </thead>

            <tbody>

                <?php 
                    $totalSum = 0;
                    while ($rows = mysqli_fetch_assoc($result_order_complete)) {
                        $totalSum += $rows["total_amount"];
                ?>

                <tr>

                    <td><?php echo $rows["orders_complete_id"] ?></td>

                    <td><?php echo $rows["fullname"] ?></td>

                    <td><?php echo $rows["products"] ?></td>
                    
                    <td><?php echo $rows["quantity"] ?></td>

                    <td><?php echo $rows["amount"] ?></td>

                    <td><?php echo $rows["total_amount"] ?></td>

                    <td><?php echo $rows["payment_method"] ?></td>

                    <td>
                        
                        <?php 

                            if($rows["status"] == "รอดำเนินการ") {

                                echo "<p style='color:#DD761C;'>" . $rows["status"] . "</p>";

                            } else if ($rows["status"] == "ชำระเงินเรียบร้อย") {
                                
                                echo "<p style='color:#0A6847;'>" . $rows["status"] . "</p>";

                            }

                        ?>

                    </td>

                    <td>

                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal_<?php echo $rows["orders_complete_id"] ?>">
                            ชำระเงิน
                        </button>

                        <!-- Modal -->

                        <div class="modal fade" id="exampleModal_<?php echo $rows["orders_complete_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            
                        <div class="modal-dialog">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h1 class="modal-title fs-5" id="exampleModalLabel">แจ้งชำระเงิน</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>

                                    <form action="Check_Payment.php" method="post" enctype="multipart/form-data">

                                        <div class="modal-body">

                                            <?php echo $rows["payment_method"]; ?>

                                            <img src="images/qr.jpg" alt="" width="100%" height="25%" class="mt-2 mb-2">

                                            <div class="mb-3">

                                                <label for="formFile" class="form-label">แนปสลิปเงินโอน</label>
                                                <!-- ส่งสลิปไปเช็คว่าลูกค้าส่งสลิปเข้ามายังให้แอดมินเช็ค -->
                                                <input class="form-control" type="file" id="formFile" name="slip">

                                            </div>
                                        </div>

                                        <div class="modal-footer">

                                            <input type="hidden" value="<?php echo $rows["user_id"] ?>" name="id">

                                            <input type="hidden" value="<?php echo $rows["orders_complete_id"] ?>" name="order_complete_id">

                                            <input type="hidden" name="fullname" value="<?php echo $rows["fullname"]; ?>">

                                            <input type="hidden" name="totalsum" value="<?php echo $totalSum; ?>">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            
                                            <button type="submit" class="btn btn-primary" name="submit">ยืนยัน</button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <script src="js/script.js"></script>
</body>
</html>
