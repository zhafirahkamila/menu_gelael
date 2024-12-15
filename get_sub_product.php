<?php
include 'database.php';

$prdcd = $_GET['prdcd'];

$sql = "SELECT p.prdcd, p.product_name, p.product_price, sp.text AS sub_product_text, sp.image AS sub_product_image
        FROM product p
        INNER JOIN sub_product sp ON p.prdcd = sp.prdcd
        WHERE p.prdcd = '$prdcd'";

$result = $conn->query($sql);

$sub_products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sub_products[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
echo json_encode($sub_products);
?>