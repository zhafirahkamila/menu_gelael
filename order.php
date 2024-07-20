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
session_start();

include 'database.php'; // Ensure database connection

$qrcode = isset($_GET['qrcode']) ? $_GET['qrcode'] : '';

// Ambil nilai qrcode dari URL
$qrcode = $_GET['qrcode'];

// Simpan nilai qrcode dalam session (jika diperlukan)
$_SESSION['qrcode'] = $qrcode;

// Validasi nilai qrcode
if (!empty($qrcode) && is_numeric($qrcode)) {
    $no_meja = substr($qrcode, -2);

    // Simpan nomor meja ke session
    $_SESSION['no_meja'] = $no_meja;
    echo "Nomor Meja: " . $_SESSION['no_meja'] . "<br>";
} else {
    echo "QR code tidak valid atau tidak ditemukan.";
    exit; 
}

// Assuming 'order' table structure: id (auto_increment), product_price, session, code_product, keterangan

// Retrieve data sent from AJAX request
$postData = json_decode(file_get_contents('php://input'), true);

$products = $postData['products'];
$totalPrice = $postData['totalPrice'];
$no_meja = $postdata['no_meja'];

// Prepare and execute insert queries for each product in cart
foreach ($products as $product) {
    $productName = $product['name'];
    $productPrice = $product['price'];
    $quantity = $product['quantity'];
    $keterangan = $product['keterangan'];

    // Find code_product based on product name
    $stmt = $conn->prepare("SELECT prdcd FROM product WHERE product_name = ?");
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codeProduct = $row['prdcd'];

        // Insert order details into 'order' table
        $stmt = $conn->prepare("INSERT INTO `order` (code_product, no_meja, product_price, quantity, keterangan) VALUES (?, ?, ?, ?, ?)");
        $session = session_id(); // Get session ID or use other unique identifier
        $stmt->bind_param("ssdds", $codeProduct, $no_meja, $productPrice, $quantity, $keterangan);
        $stmt->execute();
    }
}

// Close database connection
$conn->close();

// Respond to AJAX request (optional)
echo json_encode(['status' => 'success']);
?>