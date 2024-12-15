<?php
include 'database.php';
$query_select = 'SELECT * FROM sub_product';
$run_query_select = mysqli_query($conn, $query_select);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" /> -->
    <!-- <link href="./custom.css" rel="stylesheet"> -->
</head>

<body>

    <!-- Add New Product Button -->
    <div class="container mt-3">
        <button type="button" class="btn btn-secondary" style="font-weight: 600;" data-bs-toggle="modal"
            data-bs-target="#addSubProduct">
            Add New Sub Product
        </button>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addSubProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Sub Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="subProductForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <label for="codeProduct">Product Code</label>
                        <input type="text" name="codeproduct" placeholder="Enter Product Code" id="codeProduct"
                            class="form-control code-product" autocomplete="on">
                        <label for="sub-Name">Sub Product Name</label>
                        <input type="text" name="sub_name" placeholder="Enter Sub Product Name" id="sub-Name"
                            class="form-control sub-name" autocomplete="on">
                        <label for="productPhoto">Image</label>
                        <input type="file" name="product_photo" id="productPhoto" accept=".jpg, .jpeg, .png"
                            class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add" class="btn btn-primary">Add</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['add'])) {
                    $codeproduct = $_POST['codeproduct'];
                    $sub_name = $_POST['sub_name'];

                    $product_photo = $_FILES['product_photo']['name'];
                    $product_photo_tmp_name = $_FILES['product_photo']['tmp_name'];
                    $product_photo_error = $_FILES['product_photo']['error'];

                    $photo_info = pathinfo($product_photo);
                    $new_product_photo = 'sub-' . $photo_info['filename'] . '.' .$photo_info['extension'];

                    $product_photo_folder = $_SERVER['DOCUMENT_ROOT'] . '/menu_gelael/img/' . $new_product_photo;

                    $product_photo_db_path = 'img/' . $new_product_photo;

                    try {
                        $query = "INSERT INTO sub_product(prdcd, text, image)VALUES('$codeproduct', '$sub_name', '$product_photo_db_path')";
                        echo "============= $query";
                        $query_run = mysqli_query($conn, $query);

                        if ($query_run) {
                            move_uploaded_file($product_photo_tmp_name, $product_photo_folder);
                            echo '<script>
                                alert("New Sub Product Saved");
                                window.location.href = "http://localhost/menu_gelael/dashboard.php?page=sub_product_admin";
                            </script>';
                        } else {
                            echo '<script> alert("Data Sub Product Not Saved"); </script>';
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                        echo '<script> alert("' . $th->getMessage() . 'Data Sub Product Not Saved"); </script>';
                        echo "========= {$th->getMessage()}";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End of Add New Products -->


    <!-- EDIT POP UP MODAL -->
    <div class="modal fade" id="editSubProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Sub Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editsubProductForm" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editSubProductId">
                    <input type="hidden" name="existing_photo" id="existingPhoto">
                    <div class="modal-body">
                        <label for="codeProduct">Code Product</label>
                        <input type="text" name="codeproduct" placeholder="Enter Product Code" id="editCodeProduct"
                            class="form-control" autocomplete="on">
                        <!-- <label for="productName">Product Name</label>
                        <input type="text" name="product_name" placeholder="Product Name" id="productName"
                            class="form-control product-name"> -->
                        <label for="editSubProductName">Sub Product Name</label>
                        <input type="text" name="sub_name" placeholder="Enter Sub Product Name" id="editSubProductName"
                            class="form-control" autocomplete="on">
                        <label for="productPhoto">Image</label>
                        <input type="file" name="product_photo" id="productPhoto" accept=".jpg, .jpeg, .png"
                            class="form-control">

                        <img name="photoPreview" id="productPhotoPreview" src="" alt="Product Photo"
                            class="form-control" style="width: 120px; height: 100px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['update'])) {
                    $id = $_POST['id'];

                    $codeproduct = $_POST['codeproduct'];
                    $sub_name = $_POST['sub_name'];

                    $existing_photo = $_POST['existing_photo'];

                    $product_photo = $_FILES['product_photo']['name'];
                    $product_photo_tmp_name = $_FILES['product_photo']['tmp_name'];
                    $product_photo_error = $_FILES['product_photo']['error'];

                    if ($product_photo_error === UPLOAD_ERR_OK && !empty($product_photo)) {
                        // File baru diunggah
                        $product_photo_folder = $_SERVER['DOCUMENT_ROOT'] . '/menu_gelael/img/sub_product/' . $product_photo;
                        $product_photo_db_path = 'img/sub_product/' . $product_photo;
                    } else {
                        // Tidak ada file baru diunggah, gunakan foto yang sudah ada
                        $product_photo_db_path = $existing_photo;
                    }

                    $query = "UPDATE sub_product SET prdcd='$codeproduct', text='$sub_name', image='$product_photo_db_path' WHERE id='$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        if ($product_photo_error === UPLOAD_ERR_OK && !empty($product_photo)) {
                            move_uploaded_file($product_photo_tmp_name, $product_photo_folder);
                        }
                        echo '<script>
                            alert("Data Update Successfully");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=sub_product_admin";
                        </script>';
                    } else {
                        echo '<script> alert("Data Not Update"); </script>';
                    }
                }
                ?>

            </div>
        </div>
    </div>


    <!-- DELETE POP UP MODAL -->
    <div class="modal fade" id="deleteSubProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deletesubProductForm" action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteSubProductId">

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
                    $id = $_POST['id'];

                    $query = "DELETE FROM sub_product WHERE id='$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                            alert("Data Deleted Successfully");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=sub_product_admin";
                        </script>';
                    } else {
                        echo '<script> alert("Data Not Deleted"); </script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Display Data -->
    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="font-size: 1.1rem; text-align: left;">Code</th>
                    <th style="font-size: 1.1rem">Sub Product</th>
                    <th style="font-size: 1.1rem">Image</th>
                    <th style="font-size: 1.1rem">Action</th>
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <?php if (mysqli_num_rows($run_query_select) > 0) { ?>
                    <?php while ($row = mysqli_fetch_array($run_query_select)) { ?>
                        <tr>
                            <td style="text-align: left"><?= $row['prdcd'] ?></td>
                            <td><?= $row['text'] ?></td>
                            <td><img src="<?= $row['image'] ?>" width="45" height="45"></td>
                            <td>
                                <button class="btn-admin btn-edit" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editSubProduct" data-id="<?= $row['id'] ?>"
                                    data-codeproduct="<?= $row['prdcd'] ?>" data-name="<?= $row['text'] ?>"
                                    data-photo="<?= $row['image'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-admin btn-delete" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteCategory" data-id="<?= $row['id'] ?>"
                                    data-codeproduct="<?= $row['prdcd'] ?>" data-name="<?= $row['text'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="3">Data Tidak Ada</td>
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

    <!-- Script Untuk Update dan Delete Data Admin -->

    <script>
        $(document).ready(function () {
            new DataTable('#example', {
                responsive: true
            });

            // Handle Edit Button Click
            $(document).on('click', '.btn-edit', function () {
                // Get data attributes
                var id = $(this).data('id');
                var codeproduct = $(this).data('codeproduct');
                var sub_name = $(this).data('name');
                var photo = $(this).data('photo');

                console.log('Edit button clicked!');

                console.log({
                    id: id,
                    codeproduct: codeproduct,
                    sub_name: name,
                    photo: photo,
                });


                // Set data to modal form
                $('#editSubProductId').val(id);
                $('#editCodeProduct').val(codeproduct);
                $('#editSubProductName').val(sub_name);

                // Set image source
                $('#productPhotoPreview').attr('src', photo);
                $('#existingPhoto').val(photo);
                $('#existingPhoto').val(photo);

                // Show the modal
                $('#editSubProduct').modal('show');
            });

            // Handle Delete Button Click
            $('.btn-delete').on('click', function () {
                console.log("Delete button clicked");
                var id = $(this).data('id');
                console.log(id);
                $('#deleteSubProductId').val(id);
                $('#deleteSubProduct').modal('show');
            });
        });
    </script>
</body>

</html>