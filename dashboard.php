<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:../menu_gelael/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GelaelCafe - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="icon" href="img/LogoGelael.png">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <link href="./custom.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="dashboard.php" style="text-decoration: none;">Gelael</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboard.php?page=admin-page" class="sidebar-link" style="text-decoration: none;">
                        <i class="lni lni-user"></i>
                        <span>Admin</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=productList" class="sidebar-link" style="text-decoration: none;">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=category" class="sidebar-link" style="text-decoration: none;">
                        <i class="fa-solid fa-list"></i>
                        <span>Category</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="dashboard.php?page=kode-cabang" class="sidebar-link" style="text-decoration: none;">
                        <i class="fa-solid fa-barcode"></i>
                        <span>Kode Cabang</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <li class="sidebar-item">
                    <a href="logout.php" class="sidebar-link" style="text-decoration: none;">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </div>
        </aside>
        <div class="main p-3">
            <div class="content" id="content-area">
                <!-- Konten dinamis akan dimuat di sini -->
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    $allowed_pages = ['admin-page', 'productList', 'category', 'kode-cabang'];
                    if (in_array($page, $allowed_pages)) {
                        include $page . '.php';
                    } else {
                        echo '<p>Page not found</p>';
                    }
                } else {
                    include 'home.php';
                }
                ?>
            </div>
        </div>
    </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    const hamburger = document.querySelector("#toggle-btn");

    hamburger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });
</script>
</html>