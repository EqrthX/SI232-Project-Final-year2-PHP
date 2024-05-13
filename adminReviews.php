<?php 
    require "connection.php";

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)) {

        header("location:Login.php");

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</head>
<body>
    
    <?php require 'adminHeader.php' ?>

    <section class="dashboard">

        <h1>Review</h1>

        <div class="container">

            <?php 
            
                $sql_review = "SELECT * FROM reviews";

                $result_review = mysqli_query($conn, $sql_review);

                while($rows_reivew = mysqli_fetch_assoc($result_review)) {

                
            
            ?>

            <div class="container-review">

                <div class="box-review">

                    <p>Order ID : <?php echo $rows_reivew["orders_complete_id"] ?></p>
                    <p>User ID : <?php echo $rows_reivew["user_id"] ?></p>
                    <p>ชื่อผู้ใช้งาน : <?php echo $rows_reivew["fullname"] ?></p>
                    <p>สินค้า : <?php echo $rows_reivew["products"] ?></p>
                    <p>วันที่รีวิว : <?php echo $rows_reivew["review_date"] ?></p>
                    <p>บทความ : <?php echo $rows_reivew["content"] ?></p>

                </div>

            </div>

            <?php 
            
                }
            
            ?>

        </div>

    </section>


    <script src="js/Adminscript.js"></script>
</body>
</html>