<?php
session_start();
$current_user_role = $_SESSION['roles'];
$current_user_kodecabang = $_SESSION['kodecabang'];

include 'database.php';
$query_select = "
    SELECT p.*, c.category_name 
    FROM product p
    LEFT JOIN categories c ON p.category = c.id
    WHERE p.kodecabang = '$current_user_kodecabang'
";

$run_query_select = mysqli_query($conn, $query_select);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Table List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>

    <!-- Add New Product Button -->
    <div class="container mt-3">
        <button type="button" class="btn btn-secondary" style="font-weight: 600;" data-bs-toggle="modal"
            data-bs-target="#addProduct">
            Add New Product
        </button>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="productForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <label for="prdcd">Code Product</label>
                        <input type="text" name="prdcd" placeholder="Code Product" id="prdcd"
                            class="form-control product-code">
                        <label for="kodeCabang">Code Cabang</label>
                        <select class="form-control kode-cabang" name="kodecabang" id="kodeCabang">
                            <option value="" disabled selected>Choose Cabang</option>
                            <?php
                            // Fetch categories from the database
                            $cabangSql = "SELECT * FROM cabang WHERE kodecabang='$current_user_kodecabang'";
                            $cabangResult = $conn->query($cabangSql);

                            // Check if there are any categories
                            if ($cabangResult->num_rows > 0) {
                                // Loop through the categories and create options
                                while ($cabangRow = $cabangResult->fetch_assoc()) {
                                    $kodecabang = $cabangRow['kodecabang'];
                                    $namacabang = $cabangRow['namacabang'];
                                    echo "<option value='$kodecabang'>$namacabang</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Cabang Available</option>";
                            }
                            ?>
                        </select>
                        <label for="counter">Counter</label>
                        <input type="number" name="counter" placeholder="Counter" id="counter"
                            class="form-control counter">
                        <label for="productName">Product Name</label>
                        <input type="text" name="product_name" placeholder="Product Name" id="productName"
                            class="form-control product-name">
                        <label for="productPrice">Product Price</label>
                        <input type="text" name="product_price" placeholder="Product Price" id="productPrice"
                            class="form-control product-price">
                        <label for="description">Description</label>
                        <input type="text" name="product_description" placeholder="Description" id="description"
                            class="form-control product-description">
                        <label for="productCategory">Category</label>
                        <select class="form-control product-category" name="product_category" id="productCategory">
                            <option value="" disabled selected>Choose Cabang</option>
                            <?php
                            // Include the database connection file
                            include 'database.php';

                            // Fetch categories from the database
                            $categorySql = "SELECT * FROM categories WHERE kodecabang='$current_user_kodecabang'";
                            $categoryResult = $conn->query($categorySql);

                            // Check if there are any categories
                            if ($categoryResult->num_rows > 0) {
                                // Loop through the categories and create options
                                while ($categoryRow = $categoryResult->fetch_assoc()) {
                                    $categoryId = $categoryRow['id'];
                                    $categoryName = $categoryRow['category_name'];
                                    echo "<option value='$categoryId'>$categoryName</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Categories Available</option>";
                            }
                            ?>
                        </select>
                        <label for="productPhoto">Image</label>
                        <input type="file" name="product_photo" id="productPhoto" accept=".jpg, .jpeg, .png"
                            class="form-control">
                        <label for="toggleStatus">Status</label>
                        <div class="toggle-status-container">
                            <label class="toggleStatus">
                                <input name="toggleStat" type="checkbox" id="toggleStatus" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Add</button>
                    </div>
                </form>
                <?php
                if (isset($_POST['save'])) {
                    $product_name = $_POST['product_name'];
                    $product_code = $_POST['prdcd'];
                    $kodecabang = $_POST['kodecabang'];
                    $counter = $_POST['counter'];

                    $product_price = $_POST['product_price'];
                    $product_price = str_replace('.', '', $product_price); // Menghapus titik
                    $product_price = str_replace(',', '.', $product_price); // Mengganti koma dengan titik
                    $product_price = (float) $product_price; // Mengubah ke tipe data float
                
                    $product_description = $_POST['product_description'];
                    $product_category = $_POST['product_category'];

                    $product_photo = $_FILES['product_photo']['name'];
                    $product_photo_tmp_name = $_FILES['product_photo']['tmp_name'];
                    $product_photo_error = $_FILES['product_photo']['error'];
                    $product_photo_folder = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $product_photo;

                    $product_photo_db_path = 'img/' . $product_photo;

                    $toggleStat = isset($_POST['toggleStat']) ? 1 : 0;

                    try {
                        //code...
                        $query = "INSERT INTO product(prdcd, product_name, product_price, description, product_photo, category, kodecabang, counter, status)VALUES('$product_code', '$product_name', '$product_price', '$product_description', '$product_photo_db_path', '$product_category', '$kodecabang', '$counter', '$toggleStat')";
                        echo "============= $query";
                        $query_run = mysqli_query($conn, $query);

                        if ($query_run) {
                            move_uploaded_file($product_photo_tmp_name, $product_photo_folder);
                            echo '<script>
                                alert("Data Saved");
                                window.location.href = "https://cafe.gelaelsignature.com/dashboard.php?page=productList";
                            </script>';
                        } else {
                            echo '<script> alert("Data Not Saved"); </script>';
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                        echo '<script> alert("' . $th->getMessage() . 'Data Not Saved"); </script>';
                        echo "========= {$th->getMessage()}";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End of Add New Products -->

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editInputProduct" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editProductId">
                    <input type="hidden" name="existing_photo" id="existingPhoto">
                    <div class="modal-body">
                        <label for="productName">Product Name</label>
                        <input type="text" name="product_name" placeholder="Product Name" id="productName"
                            class="form-control product-name" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <label for="productCode">Product Code</label>
                        <input type="number" name="product_code" placeholder="Product Code" id="productCode"
                            class="form-control product-code" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <label for="kodeCabang">Code Cabang</label>
                        <select class="form-control kode-cabang" name="kodecabang" id="kodeCabang" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>> 
                            <option value="" disabled selected>Choose Cabang</option>
                            <?php
                            // Fetch categories from the database
                            $cabangSql = "SELECT * FROM cabang WHERE kodecabang='$current_user_kodecabang'";
                            $cabangResult = $conn->query($cabangSql);

                            // Check if there are any categories
                            if ($cabangResult->num_rows > 0) {
                                // Loop through the categories and create options
                                while ($cabangRow = $cabangResult->fetch_assoc()) {
                                    $kodecabang = $cabangRow['kodecabang'];
                                    $namacabang = $cabangRow['namacabang'];
                                    echo "<option value='$kodecabang'>$namacabang</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Cabang Available</option>";
                            }
                            ?>
                        </select>

                        <label for="counter">Counter</label>
                        <input type="number" name="counter" placeholder="Counter" id="counter"
                            class="form-control counter" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <label for="productPrice">Price</label>
                        <input type="text" name="product_price" placeholder="Product Price" id="productPrice"
                            class="form-control product-price" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <label for="productDescription">Description</label>
                        <input type="text" name="product_description" placeholder="Description" id="productDescription"
                            class="form-control product-description" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <label for="productCategory">Category</label>
                        <select class="form-control product-category" name="product_category" id="product_category"
                            <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>
                            <option value="" disabled selected>Choose Category</option>
                            <?php
                            // Include the database connection file
                            include 'database.php';

                            // Fetch categories from the database
                            $categorySql = "SELECT * FROM categories WHERE kodecabang='$current_user_kodecabang'";
                            $categoryResult = $conn->query($categorySql);

                            // Check if there are any categories
                            if ($categoryResult->num_rows > 0) {
                                // Loop through the categories and create options
                                while ($categoryRow = $categoryResult->fetch_assoc()) {
                                    $categoryId = $categoryRow['id'];
                                    $categoryName = $categoryRow['category_name'];
                                    echo "<option value='$categoryId'>$categoryName</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Categories Available</option>";
                            }

                            ?>
                        </select>
                        <label for="productPhoto">Image</label>
                        <input type="file" name="product_photo" id="productPhoto" accept=".jpg, .jpeg, .png"
                            class="form-control" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <img name="photoPreview" id="productPhotoPreview" src="" alt="Product Photo"
                            class="form-control" style="width: 120px; height: 100px;" <?php echo ($current_user_role !== 'Admin' && $current_user_role !== 'Superadmin') ? 'disabled' : ''; ?>>

                        <label for="toggleStatus">Status</label>
                        <div class="toggle-status-container">
                            <label class="toggleStatus">
                                <input name="toggleStat" type="checkbox" id="toggleStatus">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Edit</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['update'])) {
                    $id = $_POST['id'];

                    $product_name = $_POST['product_name'];
                    $product_code = $_POST['product_code'];
                    $kodecabang = $_POST['kodecabang'];
                    $counter = $_POST['counter'];

                    $product_price = $_POST['product_price'];
                    $product_price = str_replace('.', '', $product_price); // Menghapus titik
                    $product_price = str_replace(',', '.', $product_price); // Mengganti koma dengan titik
                    $product_price = (float) $product_price; // Mengubah ke tipe data float
                
                    $product_description = $_POST['product_description'];
                    $product_category = $_POST['product_category'];
                    $existing_photo = $_POST['existing_photo'];

                    $product_photo = $_FILES['product_photo']['name'];
                    $product_photo_tmp_name = $_FILES['product_photo']['tmp_name'];
                    $product_photo_error = $_FILES['product_photo']['error'];

                    if ($product_photo_error === UPLOAD_ERR_OK && !empty($product_photo)) {
                        // File baru diunggah
                        $product_photo_folder = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $product_photo;
                        $product_photo_db_path = 'img/' . $product_photo;
                    } else {
                        // Tidak ada file baru diunggah, gunakan foto yang sudah ada
                        $product_photo_db_path = $existing_photo;
                    }

                    $toggleStat = isset($_POST['toggleStat']) ? 1 : 0;

                    if ($current_user_role === 'Admin') {
                        $query = "UPDATE product SET status='$toggleStat' WHERE id='$id'";
                    } else {
                        $query = "UPDATE product SET product_name='$product_name', prdcd='$product_code', kodecabang='$kodecabang', counter='$counter', product_price='$product_price', description='$product_description', category='$product_category', product_photo='$product_photo_db_path', status='$toggleStat' WHERE id='$id'";
                    }

                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        // Jika ada file baru, pindahkan file ke folder target
                        if ($product_photo_error === UPLOAD_ERR_OK && !empty($product_photo)) {
                            move_uploaded_file($product_photo_tmp_name, $product_photo_folder);
                        }
                        echo '<script>
                                alert("Data Updated Successfully");
                                window.location.href = "https://cafe.gelaelsignature.com/dashboard.php?page=productList";
                            </script>';
                    } else {
                        echo '<script> alert("Data Not Updated"); </script>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <!-- End of Edit Product Modal -->

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteProductForm" action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteProductId">
                        <i class="lni lni-warning warning"></i>
                        <h4 style="text-align: center;">Are you sure you want to delete?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete" id="deletebutton" class="btn btn-primary">Delete</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['delete'])) {
                    var_dump($_POST);
                    $id = $_POST['id'];


                    $query = "DELETE FROM product WHERE id='$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                                alert("Data Deleted Successfully");
                                window.location.href = "https://cafe.gelaelsignature.com/dashboard.php?page=productList";
                            </script>';
                    } else {
                        echo '<script> alert("Data Not Deleted"); </script>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <!-- End of Delete Modal -->

   <!-- Display Data -->
    <div class="container">
        <table id="example" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th style="font-size: 1.1rem; text-align: left;">Code</th>
                    <th style="font-size: 1.1rem">Name</th>
                    <th style="font-size: 1.1rem; text-align: left;">Price</th>
                    <th style="font-size: 1.1rem">Description</th>
                    <th style="font-size: 1.1rem">Image</th>
                    <th style="font-size: 1.1rem; text-align: left;">Category</th>
                    <th style="font-size: 1.1rem; text-align: left;">Cabang</th>
                    <th style="font-size: 1.1rem; text-align: left;">Counter</th>
                    <th style="font-size: 1.1rem">Action</th>
                    <th style="font-size: 1.1rem">Status</th>
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <?php if (mysqli_num_rows($run_query_select) >= 0) { ?>
                    <?php while ($row = mysqli_fetch_array($run_query_select)) { ?>
                        <tr>
                            <td style="text-align: left"><?= $row['prdcd'] ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td style="text-align: left"><?= number_format($row['product_price'], 0, ',', '.') ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><img src="<?= $row['product_photo'] ?>" width="45" height="45"></td>
                            <td style="text-align: left"><?= $row['category_name'] ?? 'No Category' ?></td>
                            <td style="text-align: left"><?= $row['kodecabang'] ?></td>
                            <td style="text-align: left"><?= $row['counter'] ?></td>
                            <td>
                                <button class="btn-input editBtn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editProduct" data-id="<?= $row['id'] ?>"
                                    data-name="<?= $row['product_name'] ?>" data-code="<?= $row['prdcd'] ?>"
                                    data-kodecabang="<?= $row['kodecabang'] ?>" data-counter="<?= $row['counter'] ?>"
                                    data-price="<?= $row['product_price'] ?>" data-description="<?= $row['description'] ?>"
                                    data-category="<?= $row['category'] ?>" data-photo="<?= $row['product_photo'] ?>"
                                    data-status="<?= $row['status'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-input deleteBtn" data-bs-toggle="modal"
                                    data-bs-target="#deleteProduct" data-id="<?= $row['id'] ?>"><i
                                        class="fa-solid fa-trash"></i></button>
                            </td>
                            <td style="text-align: center">
                                <label class="toggleStatus">
                                    <input name="toggleStat" type="checkbox" <?= $row['status'] ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="10">Data Tidak Ada</td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- End of Display Data -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

    <script>
        $(document).ready(function () {
            new DataTable('#example', {
                responsive: true
            });

            $(document).on('click', '.editBtn', function () {
                // Get data attributes from the clicked button
                var id = $(this).data('id');
                var name = $(this).data('name');
                var code = $(this).data('code');
                var kodecabang = $(this).data('kodecabang');
                var counter = $(this).data('counter');
                var price = $(this).data('price');
                var description = $(this).data('description');
                var category = $(this).data('category');
                var photo = $(this).data('photo');
                var toggleStatus = $(this).data('status');

                console.log('Edit button clicked!');

                console.log({
                    id: id,
                    name: name,
                    code: code,
                    kodecabang: kodecabang,
                    counter: counter,
                    price: price,
                    description: description,
                    category: category,
                    photo: photo,
                    toggleStatus: toggleStatus
                });

                // Set data into the modal inputs
                $('#editProductId').val(id);
                $('.product-name').val(name);
                $('.product-code').val(code);
                $('.kode-cabang').val(kodecabang);
                $('.counter').val(counter);
                $('.product-price').val(price);
                $('.product-description').val(description);
                $('.product-category').val(category);
                $('#toggleStatus').prop('checked', toggleStatus == 1);

                // Set image source
                $('#productPhotoPreview').attr('src', photo);
                $('#existingPhoto').val(photo);
                $('#existingPhoto').val(photo);

                // Show the modal
                $('#editProduct').modal('show');
            });

            $(document).on('click', '.deleteBtn', function () {
                var id = $(this).data('id');
                $('#deleteProductId').val(id);
                $('#deleteProduct').modal('show');
            })

            $(document).on('change', 'input[name="toggleStat"]', function () {
    console.log('Toggle status has changed');
    let toggleSwitch = $(this);
    
    // Cari elemen .editBtn dan periksa data-id
    let editBtn = toggleSwitch.closest('tr').find('.editBtn');
    console.log("editBtn element:", editBtn); // Periksa apakah elemen ditemukan
    console.log("Data ID:", editBtn.data('id')); // Periksa nilai data-id
    
    let productId = editBtn.data('id');
    var newStatus = toggleSwitch.is(':checked') ? 1 : 0;

    if (productId !== undefined) {
        console.log("ID:", productId);
        console.log("New Status:", newStatus);
        // Kirim permintaan AJAX untuk memperbarui status
        $.ajax({
            url: 'toggle.php', // File PHP untuk menangani pembaruan
            method: 'POST',
            data: {
                id: productId,
                status: newStatus
            },
            success: function (response) {
                resp = JSON.parse(response)
                alert(resp['message']);
            },
            error: function () {
                alert('Error occurred while updating status.');
            }
        });
    } else {
        console.log("Product ID is undefined.");
    }
});
        });

    </script>
    <?php $conn->close(); ?>
</body>

</html>