<?php 

    session_start();
    require "connection.php";

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
    
    <link rel="stylesheet" type="text/css" href="css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>

        img {

            width: 50px;
            height: 50px;

        }

    </style>

</head>
<body>
    
    <?php require 'adminHeader.php' ?>
    
    
    <section class="dashboard">
        
        <h1>Products</h1>

        <button type="button" class="btn btn-primary ms-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            add product
        </button>

            <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <form method="post" action="addProduct.php" enctype="multipart/form-data">

                        <div class="modal-content">

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">รายละเอียดสินค้า</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                <label for="product_name">ชื่อสินค้า</label>
                                <input type="text" name="product_name" id="product_name">

                                <label for="product_price">ราคา</label>
                                <input type="number" name="price" id="price">

                                <label for="product_quantity">จำนวน</label>
                                <input type="number" min="0" name="quantity" id="quantity">

                                <label for=""></label>
                                <select name="category_id" id="category_id">
                                    <option disabled selected>เลือกประเภทสินค้า</option>
                                    <option value="1">PlayStation</option>
                                    <option value="2">Xbox</option>
                                    <option value="3">Nintendo Switch</option>
                                </select>

                                <label for=""></label>
                                <select name="type" id="type">
                                    <option disabled selected>เลือกหมวดหมู่</option>
                                    <option value="1">Controller</option>
                                    <option value="2">Console</option>
                                    <option value="3">Game</option>
                                </select>

                                <label for="description">รายละเอียดสินค้า</label>
                                <textarea name="description" id="" cols="20" rows="5"></textarea>

                                <label for="date">วันที่เพิ่มสินค้า</label>
                                <input type="date" name="date" id="date">

                                <label for="">Images</label>
                                <input type="file" name="image" id="image" accept="image/jpg, image/jpeg, image/png">

                            </div>

                            <div class="modal-footer">
                                <input type="reset" class="btn btn-secondary reset" data-bs-dismiss="modal"></input>
                                <input type="submit" class="btn btn-primary sumit" name="add_product"></input>
                            </div>

                        </div>

                    </form>

                </div>
                
        </div>

        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">add pattern</button>
        
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">รายละเอียดลายเครื่อง</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form method="post" action="addPattern.php" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">ชื่อลาย</label>
                                <input type="text" class="form-control" id="recipient-name" name="pattern_name">
                            </div>

                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Media</label>
                                <input type="file" name="media" id="media" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for=""></label>
                                <select name="category_id" id="category_id">
                                        <option disabled selected>เลือกประเภทสินค้า</option>
                                        <option value="1">PlayStation</option>
                                        <option value="2">Xbox</option>
                                        <option value="3">Nintendo Switch</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for=""></label>
                                <select name="type" id="type">
                                        <option disabled selected>เลือกหมวดหมู่</option>
                                        <option value="1">Controller</option>
                                        <option value="2">Console</option>
                                        <option value="3">Game</option>
                                </select>
                            </div>
                        

                    </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="pattern"></input>
                        </div>

                        </form>
                </div>
            </div>
        </div>
        
        <div class="show-contect">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product name</th>
                        <th scope="col">price</th>
                        <th scope="col">quantity</th>
                        <th scope="col">category</th>
                        <th scope="col">type</th>
                        <th scope="col">image</th>
                        <th scope="col">status</th>
                        <th scope="col">date</th>
                    </tr>
                </thead>

                <?php 

                    $sql = "SELECT p.product_id, p.product_name, p.price, p.quantity, c.category_name, t.type_name, p.image_url, p.status, p.added_date
                            FROM products p 
                            INNER JOIN categories c ON p.category_id = c.category_id
                            INNER JOIN type t ON t.type_id = p.type_id";

                    $result_product = mysqli_query($conn, $sql);

                    while($fetech_product = mysqli_fetch_assoc($result_product)) {

                ?>

                <tbody>

                    <tr>
                        <th scope="row">
                            <?php echo $fetech_product["product_id"];?>
                        </th>

                        <td>
                            <?php echo $fetech_product["product_name"];?>
                        </td>

                        <td>
                            <?php echo $fetech_product["price"];?> บาท
                        </td>

                        <td>
                            <?php echo $fetech_product["quantity"];?>
                        </td>

                        <td>
                            <?php echo $fetech_product["category_name"];?>
                        </td>

                        <td>
                            <?php echo $fetech_product["type_name"];?>
                        </td>

                        <td>
                            <img src="upload_images/<?php echo $fetech_product["image_url"];?>" alt="">
                        </td>

                        <td>
                            <?php echo $fetech_product["status"];?>
                        </td>

                        <td>
                            <?php echo $fetech_product["added_date"];?>
                        </td>

                        <td>
                            <a href="updateProduct.php?id=<?php echo $fetech_product["product_id"]; ?>" class="btn btn-warning">Update</a>
                        </td>

                        <td>
                            <a href="deleteProduct.php?id=<?php echo $fetech_product["product_id"]; ?>" name="delete" class="btn btn-danger" onclick="return confirm('คุณแน่ใจนะว่าต้องการลบสินค้าชิ้นนี้')">Delete</a>
                        </td>
                    </tr>

                </tbody>

                <?php } ?>
            </table>

        </div>        

    </section>


    <script src="js/Adminscript.js"></script>
</body>
</html>