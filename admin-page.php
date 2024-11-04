<?php
include 'database.php';
$query_select = 'SELECT * FROM admin';
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
            data-bs-target="#addAdmin">
            Add New Admin
        </button>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="adminForm" action="" method="POST">
                    <div class="modal-body">
                        <label for="Email">Email</label>
                        <input type="text" name="email" placeholder="Enter your email" id="Email" class="form-control"
                            autocomplete="on">
                        <label for="Name">Name</label>
                        <input type="text" name="name" placeholder="Enter your name" id="Name" class="form-control"
                            autocomplete="on">
                        <label for="Pass">Password</label>
                        <input type="text" name="password" placeholder="Enter your password" id="Pass"
                            class="form-control" autocomplete="off">
                        <label for="adminRole">Roles</label>
                        <select class="form-control admin-role" name="roles" id="adminRole">
                            <option value="" disabled selected>Choose Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Superadmin">Superadmin</option>
                        </select>
                        <label for="kodeCabang">Kode Cabang</label>
                        <input type="text" name="kodecabang" placeholder="Enter kode cabang" id="kodeCabang"
                            class="form-control" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                    </div>
                </form>
                <?php
                if (isset($_POST['save'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $name = $_POST['name'];
                    $roles = $_POST['roles'];
                    $kodecabang = $_POST['kodecabang'];

                    $query = "INSERT INTO admin(email, password, name, roles, kodecabang)VALUES('$email', '$password', '$name', '$roles', '$kodecabang')";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                            alert("Data Saved");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=admin-page";
                        </script>';
                    } else {
                        echo '<script> alert("Data Not Saved"); </script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End of Add New Products -->


    <!-- EDIT POP UP MODAL -->
    <div class="modal fade" id="editAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAdminForm" action="" method="POST">
                    <input type="hidden" name="id" id="editAdminId">
                    <div class="modal-body">
                        <label for="editEmail">Email</label>
                        <input type="text" name="email" placeholder="Enter your email" id="editEmail"
                            class="form-control" autocomplete="on">
                        <label for="editName">Name</label>
                        <input type="text" name="name" placeholder="Enter your name" id="editName" class="form-control"
                            autocomplete="on">
                        <label for="editPass">Password</label>
                        <input type="text" name="password" placeholder="Enter your password" id="editPass"
                            class="form-control" autocomplete="off">
                        <label for="editRole">Roles</label>
                        <select class="form-control admin-role" name="roles" id="editRole">
                            <option value="" disabled selected>Choose Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Superadmin">Superadmin</option>
                        </select>
                        <label for="editKode">Kode Cabang</label>
                        <input type="text" name="kodecabang" placeholder="Enter kode cabang" id="editKode"
                            class="form-control" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['update'])) {
                    $id = $_POST['id'];

                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $name = $_POST['name'];
                    $roles = $_POST['roles'];
                    $kodecabang = $_POST['kodecabang'];

                    $query = "UPDATE admin SET email='$email', name='$name', roles='$roles', kodecabang='$kodecabang'" .
                        (!empty($password) ? ", password='$password'" : "") .
                        " WHERE id='$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        if ($_SESSION['id'] == $id) {
                            $_SESSION['roles'] = $roles;
                            $_SESSION['kodecabang'] = $kodecabang;
                        }

                        echo '<script>
                            alert("Data Update Successfully");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=admin-page";
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
    <div class="modal fade" id="deleteAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteAdminForm" action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteAdminId">

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

                    $query = "DELETE FROM admin WHERE id='$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                            alert("Data Deleted Successfully");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=admin-page";
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
                    <th style="font-size: 1.1rem">Name</th>
                    <th style="font-size: 1.1rem">Email</th>
                    <th style="font-size: 1.1rem">Roles</th>
                    <th style="font-size: 1.1rem; text-align: left">Kode Cabang</th>
                    <th style="font-size: 1.1rem">Action</th>
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <?php if (mysqli_num_rows($run_query_select) >= 0) { ?>
                    <?php while ($row = mysqli_fetch_array($run_query_select)) { ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['roles'] ?></td>
                            <td style="text-align: left"><?= $row['kodecabang'] ?></td>
                            <td>
                                <button class="btn-admin btn-edit" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editAdmin" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>"
                                    data-email="<?= $row['email'] ?>" data-roles="<?= $row['roles'] ?>" data-kodecabang="<?= $row['kodecabang'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-admin btn-delete" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteAdmin" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>"
                                    data-email="<?= $row['email'] ?>" data-roles="<?= $row['roles'] ?>" data-kodecabang="<?= $row['kodecabang'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">Data Tidak Ada</td>
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
        new DataTable('#example', {
            responsive: true
        });

        $(document).ready(function () {
            // Handle Edit Button Click
            $('.btn-edit').on('click', function () {
                // Get data attributes
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var password = $(this).data('password');
                var roles = $(this).data('roles');
                var kodecabang = $(this).data('kodecabang');

                // Set data to modal form
                $('#editAdminId').val(id);
                $('#editName').val(name);
                $('#editEmail').val(email);
                $('#editPass').val(password);
                $('#editRole').val(roles);
                $('#editKode').val(kodecabang);

                // Show the modal
                $('#editAdmin').modal('show');
            });

            // Handle Delete Button Click
            $('.btn-delete').on('click', function () {
                console.log("Delete button clicked");
                var id = $(this).data('id');
                console.log(id);
                $('#deleteAdminId').val(id);
                $('#deleteAdmin').modal('show');
            });
        });
    </script>
</body>

</html>