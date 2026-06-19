<?php 
    require_once '../config/db.php';
    session_start();

    $admin_id = $_SESSION['admin_id'] ?? null;
    if(!$admin_id) {
        header("Location: ../login.php");
        exit();
    }

    $action = $_GET['action'] ?? '';
    $alert_message = '';

    // --- Action 1: Add Product (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
        $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
        $price = floatval($_POST["price"]);
        $quantity = intval($_POST["quantity"]);
        $category_id = intval($_POST["category_id"]);
        $type_game = intval($_POST["type"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $date = date("Y-m-d", strtotime($_POST["date"]));
        
        $image = $_FILES["image"]["name"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $image_folder = "../upload_images/" . $image;

        $check_duplicate = mysqli_query($conn, "SELECT product_name FROM products WHERE product_name = '$product_name'");
        if(mysqli_num_rows($check_duplicate) > 0) {
            $alert_message = "<script>alert('มีสินค้าชิ้นนี้อยู่แล้ว!')</script>";
        } else {
            $status = ($quantity > 0) ? 'In stock' : 'Not in stock';
            
            $sql = "INSERT INTO products(product_name, description, price, quantity, category_id, type_id, image_url, status, added_date) 
                    VALUES('$product_name', '$description', '$price', '$quantity', '$category_id', '$type_game', '$image', '$status', '$date')";            
            
            if(mysqli_query($conn, $sql)) {
                if(!empty($image)) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
                $alert_message = "<script>alert('เพิ่มสินค้าสำเร็จ'); window.location.href='products.php';</script>";
            } else {
                $alert_message = "<script>alert('เกิดข้อผิดพลาดในการเพิ่มสินค้า')</script>";
            }
        }
    }

    // --- Action 2: Add Pattern (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_pattern'])) {
        $pattern_name = mysqli_real_escape_string($conn, $_POST["pattern_name"]);
        $category_id = intval($_POST["category_id"]);
        $type = intval($_POST["type"]);
        
        $media = $_FILES["media"]["name"];
        $media_tmp_name = $_FILES["media"]["tmp_name"];
        $uploaded_folder = "../upload_media_design/" . $media;

        $sql = "INSERT INTO pattern(pattern_name, pattern_media, category_id, type_id) VALUES('$pattern_name', '$media', '$category_id', '$type')";
        if(mysqli_query($conn, $sql)) {
            if(!empty($media)) {
                move_uploaded_file($media_tmp_name, $uploaded_folder);
            }
            $alert_message = "<script>alert('เพิ่มลายเครื่องสำเร็จ'); window.location.href='products.php';</script>";
        } else {
            $alert_message = "<script>alert('เกิดข้อผิดพลาดในการเพิ่มลายเครื่อง')</script>";
        }
    }

    // --- Action 3: Edit Product (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
        $id = intval($_POST["product_id"]);
        $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
        $price = floatval($_POST["price"]);
        $quantity = intval($_POST["quantity"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $type_game = intval($_POST["type"]);
        
        $status = ($quantity > 0) ? 'In stock' : 'Not in stock';

        $sql = "UPDATE products 
                SET product_name = '$product_name', 
                    description = '$description', 
                    price = '$price', 
                    quantity = '$quantity',
                    type_id = '$type_game',
                    status = '$status'
                WHERE product_id = '$id'";

        if(mysqli_query($conn, $sql)) {
            $alert_message = "<script>alert('แก้ไขข้อมูลสินค้าเรียบร้อย'); window.location.href='products.php';</script>";
        } else {
            $alert_message = "<script>alert('เกิดข้อผิดพลาด')</script>";
        }
    }

    // --- Action 4: Delete Product (GET) ---
    if ($action === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if(mysqli_query($conn, "DELETE FROM products WHERE product_id = '$id'")) {
            header("Location: products.php");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการลบข้อมูล";
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Manager</title>
    
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        img.prod-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .form-edit {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: black;
        }
    </style>
</head>
<body>
    <?php echo $alert_message; ?>
    <?php require 'includes/header.php' ?>
    
    <section class="dashboard">
        <?php if ($action === 'edit' && isset($_GET['id'])): ?>
            <!-- Product Edit Interface -->
            <?php 
                $product_id = intval($_GET["id"]);
                $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
                $result = mysqli_query($conn, $sql);
                $fetch_product = mysqli_fetch_assoc($result);
            ?>
            <h1 class="text-center mt-3">Update Product</h1>
            <form action="products.php?action=edit&id=<?php echo $product_id; ?>" method="post" class="form-edit">
                <div class="mb-3">
                    <label class="form-label">ID</label>
                    <input type="text" value="<?php echo $fetch_product["product_id"]; ?>" class="form-control" name="product_id" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product name</label>
                    <input type="text" name="product_name" value="<?php echo htmlspecialchars($fetch_product["product_name"]); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $fetch_product["price"]; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" value="<?php echo $fetch_product["quantity"]; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" cols="5" rows="5" class="form-control" required><?php echo htmlspecialchars($fetch_product["description"]); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">หมวดหมู่</label>
                    <select name="type" class="form-select" required>
                        <option value="1" <?php if($fetch_product['type_id'] == 1) echo 'selected'; ?>>Controller</option>
                        <option value="2" <?php if($fetch_product['type_id'] == 2) echo 'selected'; ?>>Console</option>
                        <option value="3" <?php if($fetch_product['type_id'] == 3) echo 'selected'; ?>>Game</option>
                    </select>
                </div>
                
                <div class="text-center mt-4">
                    <input type="submit" value="update" class="btn btn-primary" name="update_product">
                    <a href="products.php" class="btn btn-danger">Back</a>
                </div>
            </form>
        <?php else: ?>
            <!-- Product Management List -->
            <h1>Products</h1>

            <div class="d-flex justify-content-start mb-3 ms-5">
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    add product
                </button>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    add pattern
                </button>
            </div>

            <!-- Add Product Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="color: black;">
                <div class="modal-dialog">
                    <form method="post" action="products.php" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">รายละเอียดสินค้า</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อสินค้า</label>
                                    <input type="text" name="product_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ราคา</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">จำนวน</label>
                                    <input type="number" min="0" name="quantity" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ประเภทสินค้า</label>
                                    <select name="category_id" class="form-select" required>
                                        <option disabled selected>เลือกประเภทสินค้า</option>
                                        <option value="1">PlayStation</option>
                                        <option value="2">Xbox</option>
                                        <option value="3">Nintendo Switch</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">หมวดหมู่</label>
                                    <select name="type" class="form-select" required>
                                        <option disabled selected>เลือกหมวดหมู่</option>
                                        <option value="1">Controller</option>
                                        <option value="2">Console</option>
                                        <option value="3">Game</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">รายละเอียดสินค้า</label>
                                    <textarea name="description" cols="20" rows="5" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">วันที่เพิ่มสินค้า</label>
                                    <input type="date" name="date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">รูปภาพสินค้า</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" name="add_product" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Pattern Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="color: black;">
                <div class="modal-dialog">
                    <form method="post" action="products.php" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">รายละเอียดลายเครื่อง</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อลาย</label>
                                    <input type="text" class="form-control" name="pattern_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ไฟล์สื่อ</label>
                                    <input type="file" name="media" class="form-control" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ประเภทสินค้า</label>
                                    <select name="category_id" class="form-select" required>
                                        <option disabled selected>เลือกประเภทสินค้า</option>
                                        <option value="1">PlayStation</option>
                                        <option value="2">Xbox</option>
                                        <option value="3">Nintendo Switch</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">หมวดหมู่</label>
                                    <select name="type" class="form-select" required>
                                        <option disabled selected>เลือกหมวดหมู่</option>
                                        <option value="1">Controller</option>
                                        <option value="2">Console</option>
                                        <option value="3">Game</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" name="add_pattern" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Table List -->
            <div class="show-contect mt-4 px-5">
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
                            <th scope="col" colspan="2" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = "SELECT p.product_id, p.product_name, p.price, p.quantity, c.category_name, t.type_name, p.image_url, p.status, p.added_date
                                    FROM products p 
                                    INNER JOIN categories c ON p.category_id = c.category_id
                                    INNER JOIN type t ON t.type_id = p.type_id";
                            $result_product = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($result_product) > 0) {
                                while($fetch_product = mysqli_fetch_assoc($result_product)) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $fetch_product["product_id"];?></th>
                                        <td><?php echo htmlspecialchars($fetch_product["product_name"]);?></td>
                                        <td><?php echo number_format($fetch_product["price"], 2);?> บาท</td>
                                        <td><?php echo $fetch_product["quantity"];?></td>
                                        <td><?php echo htmlspecialchars($fetch_product["category_name"]);?></td>
                                        <td><?php echo htmlspecialchars($fetch_product["type_name"]);?></td>
                                        <td><img src="../upload_images/<?php echo htmlspecialchars($fetch_product["image_url"]);?>" alt="" class="prod-img"></td>
                                        <td>
                                            <?php 
                                                if ($fetch_product["status"] === 'In stock') {
                                                    echo "<span class='badge bg-success'>In stock</span>";
                                                } else {
                                                    echo "<span class='badge bg-danger'>Not in stock</span>";
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $fetch_product["added_date"];?></td>
                                        <td class="text-center">
                                            <a href="products.php?action=edit&id=<?php echo $fetch_product["product_id"]; ?>" class="btn btn-warning btn-sm">Update</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="products.php?action=delete&id=<?php echo $fetch_product["product_id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจนะว่าต้องการลบสินค้าชิ้นนี้')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php 
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center'>ยังไม่มีรายการสินค้า</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>        
        <?php endif; ?>
    </section>

    <script src="../js/Adminscript.js"></script>
</body>
</html>
