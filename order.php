<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid container-payment">
        <div class="card">
            <div class="card-header">
                Receipt
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Dasar Pengenaan Pajak</li>
                    <li class="list-group-item">Pajak Restoran (11%)</li>
                    <li class="list-group-item c-total" style="font-weight:bold;">Total</li>
                </ul>
                <button class="btn btn-danger back" style="margin-top:10px">Back</button>
                <button class="btn btn-dark" style="margin-top:10px">Payment</button>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="app.js"></script>
</body>

</html> -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database.php';

// Retrieve data sent from AJAX request
$postData = json_decode(file_get_contents('php://input'), true);

$products = $postData['products'];
$no_meja = $postData['no_meja'];
$kodecabang = $postData['kodecabang'];

// Prepare and execute insert queries for each product in cart
foreach ($products as $product) {
    $prdcd = $product['prdcd'];
    $productPrice = $product['price'];
    $quantity = $product['quantity'];
    $keterangan = $product['keterangan'];

    // Find code_product based on product name
    $stmt = $conn->prepare("SELECT prdcd, counter FROM product WHERE prdcd = ? AND kodecabang = ?");
    $stmt->bind_param("ss", $prdcd, $kodecabang);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codeProduct = $row['prdcd'];
        $counter = $row['counter'];

        try {
            // Insert order details into 'order' table
            $stmt = $conn->prepare("INSERT INTO `order` (code_product, no_meja, product_price, quantity, keterangan, kodecabang, counter) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $session = session_id(); // Get session ID or use other unique identifier
            $stmt->bind_param("ssddsss", $codeProduct, $no_meja, $productPrice, $quantity, $keterangan, $kodecabang, $counter);
            $stmt->execute();
        } catch (\Throwable $th) {
            //throw $th;
            echo '<script> alert("' . $th->getMessage() . 'Data Not Saved"); </script>';
            echo "========= {$th->getMessage()}";
        }
    }
}

// Close database connection
$conn->close();

// Respond to AJAX request (optional)
echo json_encode(['status' => 'success']);
?>