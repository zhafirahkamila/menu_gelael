<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database.php';
$query_select = 'SELECT * FROM cabang';
$run_query_select = mysqli_query($conn, $query_select);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Cabang Page</title>
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
            data-bs-target="#addKodeCabang">
            Add New Kode Cabang
        </button>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addKodeCabang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Kode Cabang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="kodeCabangForm" action="" method="POST">
                    <div class="modal-body">
                        <label for="kodeCabang">Kode Cabang</label>
                        <input type="text" name="kodecabang" placeholder="Enter Kode Cabang" id="kodeCabang" class="form-control"
                            autocomplete="on">
                        <label for="namaCabang">Nama Cabang</label>
                        <input type="text" name="namacabang" placeholder="Enter nama cabang" id="namaCabang" class="form-control"
                            autocomplete="on">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                    </div>
                </form>
                <?php
                if (isset($_POST['save'])) {
                    $kodecabang = $_POST['kodecabang'];
                    $namacabang = $_POST['namacabang'];

                    $query = "INSERT INTO cabang(kodecabang, namacabang)VALUES('$kodecabang', '$namacabang')";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                            alert("Data Cabang Saved");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=kode-cabang";
                        </script>';
                    } else {
                        echo '<script> alert("Data Cabang Not Saved"); </script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End of Add New Products -->


    <!-- EDIT POP UP MODAL -->
    <div class="modal fade" id="editKodeCabang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Kode Cabang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editKodeCabangForm" action="" method="POST">
                    <input type="hidden" name="id" id="editKodeCabangId">
                    <div class="modal-body">
                        <label for="editKode">Kode Cabang</label>
                        <input type="text" name="kodecabang" placeholder="Enter kode cabang" id="editKode" class="form-control"
                            autocomplete="on">
                        <label for="editNama">Nama Cabang</label>
                        <input type="text" name="namacabang" placeholder="Enter nama cabang" id="editNama" class="form-control"
                            autocomplete="on">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['update'])) {
                    $id = $_POST['id'];

                    $kodecabang = $_POST['kodecabang'];
                    $namacabang = $_POST['namacabang'];

                    $query = "UPDATE admin SET kodecabang='$kodecabang', namacabang='$namacabang' WHERE id='$id'" ;
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                            alert("Data Update Successfully");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=kode-cabang";
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
    <div class="modal fade" id="deleteKodeCabang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteKodeCabangForm" action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteKodeCabangId">

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

                    $query = "DELETE FROM cabang WHERE id='$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo '<script>
                            alert("Data Deleted Successfully");
                            window.location.href = "http://localhost/menu_gelael/dashboard.php?page=kode-cabang";
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
                    <th style="font-size: 1.1rem; text-align: left;">Kode Cabang</th>
                    <th style="font-size: 1.1rem">Nama Cabang</th>
                    <th style="font-size: 1.1rem">Action</th>
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <?php if (mysqli_num_rows($run_query_select) >= 0) { ?>
                    <?php while ($row = mysqli_fetch_array($run_query_select)) { ?>
                        <tr>
                            <td style="text-align: left"><?= $row['kodecabang'] ?></td>
                            <td><?= $row['namacabang'] ?></td>
                            <td>
                                <button class="btn-admin btn-edit" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editKodeCabang" data-id="<?= $row['id'] ?>" data-kodecabang="<?= $row['kodecabang'] ?>" data-namacabang="<?= $row['namacabang'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-admin btn-delete" type="button" data-bs-toggle="modal"
                                    data-bs-target="#deleteKodeCabang" data-id="<?= $row['id'] ?>" data-kode="<?= $row['kodecabang'] ?>" data-namacabang="<?= $row['namacabang'] ?>">
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
        new DataTable('#example', {
            responsive: true
        });

        $(document).ready(function () {
            // Handle Edit Button Click
            $('.btn-edit').on('click', function () {
                // Get data attributes
                var id = $(this).data('id');
                var kodecabang = $(this).data('kodecabang');
                var namacabang = $(this).data('namacabang');

                // Set data to modal form
                $('#editKodeCabangId').val(id);
                $('#editKode').val(kodecabang);
                $('#editNama').val(namacabang);

                // Show the modal
                $('#editKodeCabang').modal('show');
            });

            // Handle Delete Button Click
            $('.btn-delete').on('click', function () {
                console.log("Delete button clicked");
                var id = $(this).data('id');
                console.log(id);
                $('#deleteKodeCabangId').val(id);
                $('#deleteKodeCabang').modal('show');
            });
        });
    </script>
</body>

</html>