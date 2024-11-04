<?php
include 'database.php';
$query_select = 'SELECT * FROM `order`';
$run_query_select = mysqli_query($conn, $query_select);

$query_product = 'SELECT COUNT(*) as total FROM product';
$result_product = mysqli_query($conn, $query_product);
$data_product = mysqli_fetch_assoc($result_product);
$total_products = $data_product['total'];

$query_cabang = 'SELECT COUNT(*) as total FROM cabang';
$result_cabang = mysqli_query($conn, $query_cabang);
$data_cabang = mysqli_fetch_assoc($result_cabang);
$total_cabang = $data_cabang['total'];

$query_category = 'SELECT COUNT(*) as total FROM categories';
$result_category = mysqli_query($conn, $query_category);
$data_category = mysqli_fetch_assoc($result_category);
$total_category = $data_category['total'];

$query_admin = 'SELECT COUNT(*) as total FROM admin';
$result_admin = mysqli_query($conn, $query_admin);
$data_admin = mysqli_fetch_assoc($result_admin);
$total_admin = $data_admin['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GelaelCafe - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    <link rel="icon" href="img/LogoGelael.png">
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <div>
        <div class="cardBox">
            <a href="dashboard.php?page=admin-page" class="card-home">
                <div>
                    <h5 class="card-num"><?php echo $total_admin; ?></h5>
                    <h3 class="card-text">Admins</h3>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </a>

            <a href="dashboard.php?page=productList" class="card-home">
                <div>
                    <h5 class="card-num"><?php echo $total_products; ?></h5>
                    <h3 class="card-text">Products</h3>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-grip-vertical"></i>
                </div>
            </a>

            <a href="dashboard.php?page=category" class="card-home">
                <div>
                    <h5 class="card-num"><?php echo $total_category; ?></h5>
                    <h3 class="card-text">Category</h3>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-list"></i>
                </div>
            </a>

            <a href="dashboard.php?page=kode-cabang" class="card-home">
                <div>
                    <h5 class="card-num"><?php echo $total_cabang; ?></h5>
                    <h3 class="card-text">Cabang</h3>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-barcode"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Display Data -->
    <div class="container" style="background-color: white; padding-top: 15px; margin-top: 30px;">
        <h1 style="margin-bottom: 15px;">Data Order</h1>
        <table id="example" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th style="font-size: 1.1rem; text-align: left;">No</th>
                    <th style="font-size: 1.1rem">Code</th>
                    <th style="font-size: 1.1rem">No Meja</th>
                    <th style="font-size: 1.1rem">Price</th>
                    <th style="font-size: 1.1rem">Quantity</th>
                    <th style="font-size: 1.1rem">Description</th>
                    <th style="font-size: 1.1rem">Cabang</th>
                    <th style="font-size: 1.1rem">Counter</th>
                    <!-- <th style="font-size: 1.1rem">Action</th> -->
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <?php if (mysqli_num_rows($run_query_select) >= 0) { ?>
                    <?php $num = 1; ?>
                    <?php while ($row = mysqli_fetch_array($run_query_select)) { ?>
                        <tr>
                            <td style="text-align: center;"><?= $num++ ?></td>
                            <td align="center"><?= $row['code_product'] ?></td>
                            <td align="center"><?= $row['no_meja'] ?></td>
                            <td style="text-align: center;"><?= $row['product_price'] ?></td>
                            <td align="center"><?= $row['quantity'] ?></td>
                            <td align="center"><?= $row['keterangan'] ?></td>
                            <td style="text-align: center;"><?= $row['kodecabang'] ?></td>
                            <td style="text-align: center;"><?= $row['counter'] ?></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="8">Data Tidak Ada</td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- End of Display Data -->
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

</html>