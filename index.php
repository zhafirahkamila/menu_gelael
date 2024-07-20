<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gelael Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow">
        <div class="container-lg">
            <a class="navbar-brand" href="#">
                <img src="img/LogoGelael.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            </a>
            <div class="cart-container">
                <i class="fas fa-cart-shopping cart-icon" href="#"></i>
                <span class="start-100 translate-middle badge">0</span>
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
            <div class="row">
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
                        type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-main-tab" data-bs-toggle="pill" data-bs-target="#pills-main"
                        type="button" role="tab" aria-controls="pills-main" aria-selected="true">Main Course</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-appetizer-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-appetizer" type="button" role="tab" aria-controls="pills-appetizer"
                        aria-selected="true">Appetizer</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-dessert-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-dessert" type="button" role="tab" aria-controls="pills-dessert"
                        aria-selected="true">Dessert</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-beverages-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-beverages" type="button" role="tab" aria-controls="pills-beverages"
                        aria-selected="true">Beverages</button>
                </li>

            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
                    tabindex="0">

                    <!-- Card 1 -->
                    <div class="container">
                        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            <?php
                            // Sertakan file koneksi
                            include 'database.php';

                            // Query untuk mengambil data dari tabel id_product
                            $sql = "SELECT * FROM product";
                            $result = $conn->query($sql);

                            // Output data setiap baris
                            if ($result->num_rows > 0) {
                                $idx = 0;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col mt-3">
                                        <div class="card">
                                            <img src="<?php echo $row['product_photo']; ?>" class="card-img-top" alt="...">
                                            <div class="card-body" style="padding: 5px;">
                                                <h5 class="card-title" style="font-size: 1rem;">
                                                    <?php echo $row['product_name']; ?>
                                                </h5>
                                                <p class="card-text" style="font-size: 0.7rem;">
                                                    <?php echo $row['description']; ?>
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <button class="btn btn-outline-dark btn-add"
                                                    style="border-radius: 20px; width: 60px;">Add
                                                </button>
                                                <h5 class="mb-0" style="font-size: 1rem;">
                                                    <?php echo number_format($row['product_price'], 0, ',', '.') ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card 1 -->
                                    <?php
                                }
                            } else {
                                echo "";
                            }

                            // Menutup koneksi
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <!-- All -->

                <div class="tab-pane fade show" id="pills-main" role="tabpanel" aria-labelledby="pills-main-tab"
                    tabindex="0">
                    <!-- Card 1 -->
                    <div class="container">
                        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            <?php
                            // Sertakan file koneksi
                            include 'database.php';

                            // Query untuk mengambil data dari tabel id_product
                            $sql = "SELECT * FROM product WHERE category = 'Main Course'";
                            $result = $conn->query($sql);

                            // Output data setiap baris
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col mt-3">
                                        <div class="card">
                                            <img src="<?php echo $row['product_photo']; ?>" class="card-img-top" alt="...">
                                            <div class="card-body" style="padding: 5px;">
                                                <h5 class="card-title" style="font-size: 1rem;">
                                                    <?php echo $row['product_name']; ?>
                                                </h5>
                                                <p class="card-text" style="font-size: 0.7rem;">
                                                    <?php echo $row['description']; ?>
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <button class="btn btn-outline-dark btn-add"
                                                    style="border-radius: 20px; width: 60px;">Add
                                                </button>
                                                <h5 class="mb-0" style="font-size: 1rem;">
                                                    <?php echo number_format($row['product_price'], 0, ',', '.') ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card 1 -->
                                    <?php
                                }
                            } else {
                                echo "";
                            }

                            // Menutup koneksi
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Main Course -->

                <div class="tab-pane fade show" id="pills-appetizer" role="tabpanel"
                    aria-labelledby="pills-appetizer-tab" tabindex="0">
                    <!-- Card 1 -->
                    <div class="container">
                        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            <?php
                            // Sertakan file koneksi
                            include 'database.php';

                            // Query untuk mengambil data dari tabel id_product
                            $sql = "SELECT * FROM product WHERE category = 'Appetizer'";
                            $result = $conn->query($sql);

                            // Output data setiap baris
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col mt-3">
                                        <div class="card">
                                            <img src="<?php echo $row['product_photo']; ?>" class="card-img-top" alt="...">
                                            <div class="card-body" style="padding: 5px;">
                                                <h5 class="card-title" style="font-size: 1rem;">
                                                    <?php echo $row['product_name']; ?>
                                                </h5>
                                                <p class="card-text" style="font-size: 0.7rem;">
                                                    <?php echo $row['description']; ?>
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <button class="btn btn-outline-dark btn-add"
                                                    style="border-radius: 20px; width: 60px;">Add
                                                </button>
                                                <h5 class="mb-0" style="font-size: 1rem;">
                                                    <?php echo number_format($row['product_price'], 0, ',', '.') ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card 1 -->
                                    <?php
                                }
                            } else {
                                echo "";
                            }

                            // Menutup koneksi
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Appetizer -->

                <div class="tab-pane fade show" id="pills-dessert" role="tabpanel" aria-labelledby="pills-dessert-tab"
                    tabindex="0">
                    <!-- Card 1 -->
                    <div class="container">
                        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            <?php
                            // Sertakan file koneksi
                            include 'database.php';

                            // Query untuk mengambil data dari tabel id_product
                            $sql = "SELECT * FROM product WHERE category = 'Dessert'";
                            $result = $conn->query($sql);

                            // Output data setiap baris
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col mt-3">
                                        <div class="card">
                                            <img src="<?php echo $row['product_photo']; ?>" class="card-img-top" alt="...">
                                            <div class="card-body" style="padding: 5px;">
                                                <h5 class="card-title" style="font-size: 1rem;">
                                                    <?php echo $row['product_name']; ?>
                                                </h5>
                                                <p class="card-text" style="font-size: 0.7rem;">
                                                    <?php echo $row['description']; ?>
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <button class="btn btn-outline-dark btn-add"
                                                    style="border-radius: 20px; width: 60px;">Add
                                                </button>
                                                <h5 class="mb-0" style="font-size: 1rem;">
                                                    <?php echo number_format($row['product_price'], 0, ',', '.') ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card 1 -->
                                    <?php
                                }
                            } else {
                                echo "";
                            }

                            // Menutup koneksi
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Dessert -->

                <div class="tab-pane fade show" id="pills-beverages" role="tabpanel"
                    aria-labelledby="pills-beverages-tab" tabindex="0">
                    <!-- Card 1 -->
                    <div class="container">
                        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            <?php
                            // Sertakan file koneksi
                            include 'database.php';

                            // Query untuk mengambil data dari tabel id_product
                            $sql = "SELECT * FROM product WHERE category = 'Beverages'";
                            $result = $conn->query($sql);

                            // Output data setiap baris
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col mt-3">
                                        <div class="card">
                                            <img src="<?php echo $row['product_photo']; ?>" class="card-img-top" alt="...">
                                            <div class="card-body" style="padding: 5px;">
                                                <h5 class="card-title" style="font-size: 1rem;">
                                                    <?php echo $row['product_name']; ?>
                                                </h5>
                                                <p class="card-text" style="font-size: 0.7rem;">
                                                    <?php echo $row['description']; ?>
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <button class="btn btn-outline-dark btn-add"
                                                    style="border-radius: 20px; width: 60px;">Add
                                                </button>
                                                <h5 class="mb-0" style="font-size: 1rem;">
                                                    <?php echo number_format($row['product_price'], 0, ',', '.') ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Card 1 -->
                                    <?php
                                }
                            } else {
                                echo "";
                            }

                            // Menutup koneksi
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Beverages -->

            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-3">
                    <div class="single-box">
                        <h3>Contact</h3>
                        <div class="card-area">
                            <p>
                                <i class="fa fa-envelope" aria-hidden="true"></i> gelaeljakarta@gmail.com
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
                            <a href="https://www.facebook.com/people/Gelael-Signature/100068015377811/"><i
                                    class="fab fa-facebook-square" aria-hidden="true"></i></a>
                            <a href="https://www.instagram.com/gelaelsupermarket/"><i class="fab fa-instagram"
                                    aria-hidden="true"></i></a>
                            <a href="https://www.tiktok.com/@gelaelsupermarket?lang=en"><i class="fab fa-tiktok"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <hr class="footer-divider">
                    <p class="copyright">Copyright © 2024 Smartsoft for GELAEL SUPERMARKET</p>
                </div>
            </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="app.js"></script>
</body>

</html>