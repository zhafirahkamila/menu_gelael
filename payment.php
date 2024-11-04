<?php
// payment.php
$totalPrice = isset($_GET['totalPrice']) ? $_GET['totalPrice'] : 0;
$taxRate = 0.11; // 11% tax rate
$taxAmount = $totalPrice * $taxRate;
$finalAmount = $totalPrice + $taxAmount;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="./custom.css" rel="stylesheet">
</head>

<style>
    .container-fluid.container-payment {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container-payment .card {
        width: 100%;
        max-width: 600px;
    }

    @media (max-width: 768px) {
        .container-payment .card {
            max-width: 100%;
        }
    }

    .payment,
    .c-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<body>
    <div class="container-fluid container-payment">
        <div class="card">
            <div class="card-header">
                Receipt
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item payment" id="dasarPenanganan">Dasar Pengenaan Pajak <span id="baseAmount">0,00</span></li>
                    <li class="list-group-item payment" id="pajakRest">Pajak Restoran (11%) <span id="taxAmount">0,00</span></li>
                    <li class="list-group-item c-total" style="font-weight:bold;">Total<span id="totalAmount">0,00</span></li>
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

    <script>
        $(document).ready(function () {
            // Function to format price
            function formatIndonesianPrice(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Retrieve data from session storage
            let orderData = JSON.parse(sessionStorage.getItem('orderData'));

            if (orderData) {
                let baseAmount = orderData.totalPrice;
                let taxAmount = baseAmount * 0.11;
                let totalAmount = baseAmount + taxAmount;

                $('#baseAmount').text(formatIndonesianPrice(baseAmount.toFixed(0)));
                $('#taxAmount').text(formatIndonesianPrice(taxAmount.toFixed(0)));
                $('#totalAmount').text(formatIndonesianPrice(totalAmount.toFixed(0)));
            }

            // Remove data from session storage after retrieval
            sessionStorage.removeItem('orderData');
        });
    </script>

</body>

</html>