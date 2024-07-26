<?php

include 'database.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];

    $product_price = $_POST['product_price'];
    $product_price = str_replace('.', '', $product_price); // Menghapus titik
    $product_price = str_replace(',', '.', $product_price); // Mengganti koma dengan titik
    $product_price = (float) $product_price; // Mengubah ke tipe data float

    $product_description = $_POST['product_description'];
    $product_category = $_POST['product_category'];

    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_error = $_FILES['product_image']['error'];
    $product_image_folder = $_SERVER['DOCUMENT_ROOT'].'/menu_gelael/img/'.$product_image;

    // Create the path to be stored in the database
    $product_image_db_path = 'img/'.$product_image;

    // Debug output
    echo $_SERVER['DOCUMENT_ROOT'];
    echo $product_image_folder;

    if (!empty($product_name) && !empty($product_code) && !empty($product_price) && !empty($product_description) && !empty($product_category) && !empty($product_image)) {
        $stmt = $conn->prepare("INSERT INTO product (prdcd, product_name, product_price, description, product_photo, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsss", $product_code, $product_name, $product_price, $product_description, $product_image_db_path, $product_category);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            
            // Move the uploaded file to the target folder
            if (move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
                echo "New product added successfully";
                echo "<br>File uploaded to: " . $product_image_folder;
                header("Location: http://localhost/menu_gelael/index.php");
            } else {
                echo "Failed to upload the image";
                exit();
            }
        } else {
            echo "Couldn't add the product: {$stmt->error}";
        }

        // Close the statement
        $stmt->close();
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid container-payment">
        <div class="card">
            <div class="card-header" style="font-weight: 600; text-align: center;">
                Add a New Product
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <form id="product-form" method="POST" enctype="multipart/form-data" action="input.php">
                        <div class="d-flex mb-2">
                            <input class="form-control me-2" name="product_name" type="text" placeholder="Name Product"
                                id="product-name" required="">
                        </div>
                        <div class="d-flex mb-2">
                            <input class="form-control me-2" name="product_code" type="number"
                                placeholder="Code Product" id="product-code" required="">
                        </div>
                        <div class="d-flex mb-2">
                            <input class="form-control me-2" name="product_price" type="number" placeholder="Price"
                                id="product-price" required="">
                        </div>
                        <div class="d-flex mb-2">
                            <input class="form-control me-2" name="product_description" type="text"
                                placeholder="Description" id="product-description" required="">
                        </div>
                        <div class="d-flex mb-2">
                            <select class="form-control me-2" name="product_category" id="product-category" required="">
                                <option value="" disabled selected>Choose Category</option>
                                <option value="main course">Main Course</option>
                                <option value="appetizer">Appetizer</option>
                                <option value="beverages">Beverages</option>
                                <option value="dessert">Dessert</option>
                            </select>
                        </div>
                        <label for="product-image" class="d-flex mb-2">Image:</label>
                        <input class="form-control me-2" name="product_image" type="file" id="product-image"
                            accept=".jpg, .jpeg, .png" style="margin-top: 6px">
                        <button type="submit" name="submit" value="Upload" class="btn btn-primary btn-sm btn-submit"
                            style="margin-top:10px">Submit</button>
                    </form>
                </ul>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>

</html>