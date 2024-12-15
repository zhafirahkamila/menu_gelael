<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gelael Cafe Signature</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="icon" href="img/LogoGelael.png">
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/LogoGelael.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            </a>
            <div class="cart-container">
                <i class="fas fa-cart-shopping cart-icon" href="#"></i>
                <span class="start-100 translate-middle badge badge-cart">0</span>
            </div>
        </div>
    </nav>
    <!-- End Header -->

    <!-- List Order -->
    <div class="cartTab">
        <h1>Order</h1>
        <div class="listCard"></div>
        <div class="total-price-container">
            <h3>Total Price: <span class="total-price">0,00</span></h3>
        </div>
        <div class="btn">
            <button class="close">CLOSE</button>
            <button class="order">ORDER</button>
        </div>
    </div>
    <!-- End List Order -->

    <!-- Carousel -->
    <div id="controller" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            include 'database.php';

            $sql = "SELECT image FROM banner";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $idx = 0;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="carousel-item active c-item">
                        <img src="<?php echo $row['image']; ?>" class="d-block w-100 c-img" alt="...">
                    </div>
                    <?php
                }
            } else {
                echo "";
            }
            $conn->close();
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#controller" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#controller" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- End Carousel -->

    <!-- Menu -->
    <div class="full-width-background bg-light">
        <div class="container">
            <div class="row-custom">
                <div class="col-12 text-section">
                    <h1>Explore Our Menu</h1>
                    <p>Selamat Datang di Gelael Cafe. Silahkan pesen makanan dan minuman di Gelael Cafe
                        yang dijamin akan ketagihan karena kelezatannya dan kenikmatannya.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Button -->
    <section id="menu" class="bg-white">
        <div class="container">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all"
                        type="button" role="tab" aria-controls="pills-all" aria-selected="true">
                        All
                    </button>
                </li>
                <?php
                // Include the database connection file
                include 'database.php';
                // Fetch categories from the database
                $kodecabang = isset($_GET['qrcode']) ? substr($_GET['qrcode'], 0, 4) : '';
                $categorySql = "SELECT * FROM categories WHERE kodecabang = '$kodecabang'";
                $categoryResult = $conn->query($categorySql);
                while ($row = mysqli_fetch_assoc($categoryResult)) {
                    $categoryId = $row['id'];
                    $categoryName = $row['category_name'];

                    // Convert category name to a valid ID for the target (replace spaces with hyphens)
                    $categorySlug = strtolower(str_replace(' ', '-', $categoryName));
                    ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-<?php echo $categorySlug; ?>-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-<?php echo $categorySlug; ?>" type="button" role="tab"
                            aria-controls="pills-<?php echo $categorySlug; ?>"
                            aria-selected="<?php echo $isFirst ? 'true' : 'false'; ?>">
                            <?php echo $categoryName; ?>
                        </button>
                    </li>
                    <?php
                    $isFirst = false; // After the first iteration, set this to false
                }

                $conn->close();
                ?>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <?php
                // Include the database connection file
                include 'database.php';

                $kodecabang = isset($_GET['qrcode']) ? substr($_GET['qrcode'], 0, 4) : '';

                // Fetch categories from the database
                $categorySql = "SELECT * FROM categories WHERE kodecabang = '$kodecabang'";
                $categoryResult = $conn->query($categorySql);

                if ($categoryResult->num_rows > 0) {
                    // Tab for All products
                    ?>
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
                        tabindex="0">
                        <div class="container">
                            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                <?php
                                $kodecabang = isset($_GET['qrcode']) ? substr($_GET['qrcode'], 0, 4) : '';
                                // Query to fetch all products for the branch
                                $allProductSql = "SELECT * FROM product WHERE kodecabang = '$kodecabang'";
                                $allProductResult = $conn->query($allProductSql);

                                if ($allProductResult->num_rows > 0) {
                                    while ($productRow = $allProductResult->fetch_assoc()) {
                                        $toggleStat = $productRow['status'];
                                        $productId = $productRow['id'];
                                        ?>
                                        <div class="col mt-3">
                                            <div class="card" onclick="openModalAll(<?php echo $productId; ?>)"
                                                data-product-id="<?php echo $productId; ?>" data-prdcd="<?php echo $productRow['prdcd']; ?>">
                                                <div class="position-relative">
                                                    <img src="<?php echo $productRow['product_photo']; ?>" class="card-img-top"
                                                        alt="...">
                                                    <?php if ($toggleStat == 0) { ?>
                                                        <span class="badge position-absolute bottom-0 end-0 rounded-pill bg-danger"
                                                            id="badgeProduct">Product Not Available</span>
                                                    <?php } ?>
                                                </div>
                                                <div class="card-body" style="padding: 5px;">
                                                    <h5 class="card-title" style="font-size: 1rem;">
                                                        <?php echo $productRow['product_name']; ?>
                                                    </h5>
                                                    <p class="card-text" style="font-size: 0.7rem;">
                                                        <?php echo $productRow['description']; ?>
                                                    </p>
                                                </div>
                                                <div class="card-footer d-flex justify-content-between align-items-center">
                                                    <?php if ($toggleStat == 0) { ?>
                                                        <button class="btn btn-outline-dark btn-md btn-add disabled"
                                                            style="margin-left: 0;">Add</button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-outline-dark btn-md btn-add" style="margin-left: 0;"
                                                            onclick="handleAddClick(event, <?php echo $productId; ?>)">Add</button>
                                                    <?php } ?>
                                                    <?php if ($productRow['product_price'] != 0) { ?>
                                                        <h5 class="mb-0">
                                                            <?php echo number_format($productRow['product_price'], 0, ',', '.') ?>
                                                        </h5>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="productModalAll-<?php echo $productId; ?>" tabindex="-1"
                                            aria-labelledby="productModalLabel-<?php echo $productId; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <img src="<?php echo $productRow['product_photo']; ?>" class="card-img-top"
                                                            alt="...">
                                                        <h5 class="modal-title mt-3"
                                                            id="productModalLabel-<?php echo $productId; ?>">
                                                            <?php echo $productRow['product_name']; ?>
                                                        </h5>
                                                        <p class="mt-2"><?php echo $productRow['description']; ?></p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-0" style="font-size: 1.3rem;">
                                                                <?php echo number_format($productRow['product_price'], 0, ',', '.') ?>
                                                            </h5>
                                                            <?php if ($toggleStat == 0) { ?>
                                                                <button class="btn btn-outline-dark btn-md btn-add disabled" data-prdcd="<?php echo $productRow['prdcd']; ?>"
                                                                    style="margin-left: 0;">Add</button>
                                                            <?php } else { ?>
                                                                <button class="btn btn-outline-dark btn-md btn-add" data-prdcd="<?php echo $productRow['prdcd']; ?>"
                                                                    style="margin-left: 0;">Add</button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<p>No products available.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php

                    // Loop through categories
                    while ($categoryRow = $categoryResult->fetch_assoc()) {
                        $categoryId = $categoryRow['id'];
                        $categoryName = $categoryRow['category_name'];
                        $tabId = strtolower(str_replace(' ', '-', $categoryName)); // Creating an ID based on category name
                        ?>

                        <!-- Tab content for each category -->
                        <div class="tab-pane fade" id="pills-<?php echo $tabId; ?>" role="tabpanel"
                            aria-labelledby="pills-<?php echo $tabId; ?>-tab" tabindex="0">
                            <div class="container">
                                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                    <?php
                                    // Query to fetch products based on category and branch code
                                    $kodecabang = isset($_GET['qrcode']) ? substr($_GET['qrcode'], 0, 4) : '';
                                    $productSql = "SELECT * FROM product WHERE category = '$categoryId' AND kodecabang = '$kodecabang'";
                                    $productResult = $conn->query($productSql);

                                    if ($productResult->num_rows > 0) {
                                        while ($productRow = $productResult->fetch_assoc()) {
                                            $toggleStat = $productRow['status'];
                                            $productId = $productRow['id'];
                                            ?>
                                            <div class="col mt-3">
                                                <div class="card" onclick="openModal(<?php echo $productId; ?>)"
                                                    data-product-id="<?php echo $productId; ?>">
                                                    <div class="position-relative">
                                                        <img src="<?php echo $productRow['product_photo']; ?>" class="card-img-top"
                                                            alt="...">
                                                        <?php if ($toggleStat == 0) { ?>
                                                            <span class="badge position-absolute bottom-0 end-0 rounded-pill bg-danger"
                                                                id="badgeProduct">Product Not Available</span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="card-body" style="padding: 5px;">
                                                        <h5 class="card-title" style="font-size: 1rem;">
                                                            <?php echo $productRow['product_name']; ?>
                                                        </h5>
                                                        <p class="card-text" style="font-size: 0.7rem;">
                                                            <?php echo $productRow['description']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                                        <?php if ($toggleStat == 0) { ?>
                                                            <button class="btn btn-outline-dark btn-md btn-add disabled"
                                                                style="margin-left: 0;">Add</button>
                                                        <?php } else { ?>
                                                            <button class="btn btn-outline-dark btn-md btn-add" style="margin-left: 0;"
                                                                onclick="handleAddClick(event, <?php echo $productId; ?>)">Add</button>
                                                        <?php } ?>
                                                        <?php if ($productRow['product_price'] != 0) { ?>
                                                            <h5 class="mb-0">
                                                                <?php echo number_format($productRow['product_price'], 0, ',', '.') ?>
                                                            </h5>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="productModal-<?php echo $productId; ?>" tabindex="-1"
                                                aria-labelledby="productModalLabel-<?php echo $productId; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <img src="<?php echo $productRow['product_photo']; ?>" class="card-img-top"
                                                                alt="...">
                                                            <h5 class="modal-title mt-3"
                                                                id="productModalLabel-<?php echo $productId; ?>">
                                                                <?php echo $productRow['product_name']; ?>
                                                            </h5>
                                                            <p class="mt-2"><?php echo $productRow['description']; ?></p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h5 class="mb-0" style="font-size: 1.3rem;">
                                                                    <?php echo number_format($productRow['product_price'], 0, ',', '.') ?>
                                                                </h5>
                                                                <?php if ($toggleStat == 0) { ?>
                                                                    <button class="btn btn-outline-dark btn-md btn-add disabled"
                                                                        style="margin-left: 0;">Add</button>
                                                                <?php } else { ?>
                                                                    <button class="btn btn-outline-dark btn-md btn-add"
                                                                        style="margin-left: 0;">Add</button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No categories found.</p>";
                }
                // Close the connection
                $conn->close();
                ?>
            </div>
        </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row-footer">
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="single-box">
                        <h3>Contact</h3>
                        <div class="card-area">
                            <p>
                                <i class="fa fa-envelope" aria-hidden="true"></i> gelaelsupermarket.co.id
                            </p>
                            <p>
                                <i class="fa fa-phone" aria-hidden="true"></i> +62-812-127-89998
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-box">
                        <h3>Follow us</h3>
                        <div class="social-links">
                            <a href="https://www.facebook.com/people/Gelael-Signature/100068015377811/"
                                target="_blank"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
                            <a href="https://www.instagram.com/gelaelsupermarket/" target="_blank"><i
                                    class="fab fa-instagram" aria-hidden="true"></i></a>
                            <a href="https://www.tiktok.com/@gelaelsupermarket?lang=en" target="_blank"><i
                                    class="fab fa-tiktok" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-footer">
                <div class="col-12 text-center">
                    <hr class="footer-divider">
                    <a href="https://smartsoft.co.id/" class="copyright moving-text" target="_BLANK"
                        style="color: red; font-weight: bold;">Copyright © 2024 Smartsoft for GELAEL SUPERMARKET</a>
                </div>
            </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="app.js"></script>

    <script>
        function openModalAll(productId) {
            var modalId = '#productModalAll-' + productId;
            var modalElement = document.querySelector(modalId);
            if (modalElement) {
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            } else {
                console.log('Modal element not found for product ID:', productId);
            }
        }

        function openModal(productId) {
            var modalId = '#productModal-' + productId;
            var modalElement = document.querySelector(modalId);
            if (modalElement) {
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            } else {
                console.log('Modal element not found for product ID:', productId);
            }
        }

        function handleAddClick(event, productId) {
            // Prevent the click event from bubbling up to the card, which would trigger the modal
            event.stopPropagation();

            // Your logic for handling the "Add" button click, like adding to cart
            console.log('Add button clicked for product ID:', productId);
        }
    </script>

</body>

</html>