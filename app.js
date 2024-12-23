$(document).ready(function () {
    let cart_products = [];
    let totalPrice = 0;
    let isSubmitting = 0;

    function getParameterByName(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    let qrcode = getParameterByName('qrcode');
    let no_meja = qrcode ? qrcode.slice(-2) : null;
    let kodecabang = qrcode ? qrcode.slice(0, 4) : null;

    console.log('No meja:', no_meja);
    console.log('Kode Cabang:', kodecabang);

    $(".cart-icon").click(function () {
        $(".cartTab").toggleClass("active");
        renderCart();
    });

    $(".close").click(function () {
        $(".cartTab").removeClass("active");
    });

    $(".order").click(function () {
        // Disable the button to prevent double-click
        if (isSubmitting) {
            return;
        }
        isSubmitting = true;

        let orderData = {
            products: cart_products,
            no_meja: no_meja,
            kodecabang: kodecabang,
            totalPrice: totalPrice,
        };

        sessionStorage.setItem('orderData', JSON.stringify(orderData));

        // Send AJAX request to save order
        $.ajax({
            type: 'POST',
            url: 'order.php',
            data: JSON.stringify(orderData),
            contentType: "application/json",
            success: function (response) {
                isSubmitting = false;
                alert('Order placed successfully!');
                cart_products = []; // Clear cart after order
                renderCart(); // Re-render cart to reflect changes

                window.location.href = "payment.php?qrcode=" + qrcode;
            },
            error: function (error) {
                alert('Failed to place order. Please try again.');
                // Re-enable the button if an error occurs
                isSubmitting = false;
            }
        });
    });


    $(".back").click(function () {
        if (qrcode) {
            window.location.href = "index.php?qrcode=" + qrcode;
        } else {
            alert('QR code not found. Redirecting to home page.');
            window.location.href = "index.php";
        }
    });

    $(".btn-add").click(function () {// Get the product details
        var button = $(this);
        if (button.hasClass('disabled')) {
            alert("Product tidak tersedia");
            return;
        }

        // Tentukan konteks klik (card atau modal)
        var isModal = $(this).closest('.modal').length > 0;

        var product_name, product_price_str, product_photo, product_price, prdcd;

        if (isModal) {
            // Ambil data dari modal
            var modal = $(this).closest('.modal');
            product_name = modal.find('.modal-title').text().trim();
            product_price_str = modal.find('.d-flex h5').text().trim();
            product_photo = modal.find('.card-img-top').attr('src');
            prdcd = modal.data('prdcd');
        } else {
            // Ambil data dari card
            var product_card = $(this).closest('.card');
            product_name = product_card.find('.card-title').text().trim();
            product_price_str = product_card.find('.card-footer h5').text().trim();
            product_photo = product_card.find('.card-img-top').attr('src');
            prdcd = product_card.data('prdcd');
        }

        // Konversi harga menjadi angka
        product_price = parseFloat(product_price_str.replace(/\./g, '').replace(',', '.'));

        console.log("Product Name:", product_name);
        console.log("Product Price:", product_price);
        console.log("Product Photo:", product_photo);
        console.log("Prdcd:", prdcd);

        var existing_product = cart_products.find(item => item.name === product_name);

        if (existing_product) {
            existing_product.quantity += 1;
        } else {
            var product = {
                name: product_name,
                price: isNaN(product_price) ? 0 : product_price,
                photo: product_photo,
                quantity: 1,
                prdcd: prdcd,
                keterangan: '',
            };
            cart_products.push(product);
        }

        // Render cart
        renderCart();
    });

    // Function to render cart
    function renderCart() {
        $('.listCard').empty();

        totalPrice = 0;
        cart_products = cart_products.filter(item => item.quantity > 0);

        // Append each product to listCard
        cart_products.forEach(function (item, index) {
            totalPrice += item.price * item.quantity;
            var displayPrice = item.price === 0 ? '' : formatIndonesianPrice(item.price);

            console.log(item); // Cek semua data produk, termasuk prdcd

            var product_html = `
                <div class="item" data-index="${index}" data-prdcd="${item.prdcd}">
                    <div class="image">
                        <img src="${item.photo}" alt="">
                    </div>
                    <div class="name">
                        ${item.name}
                    </div>
                    <div class="price">
                        ${displayPrice}
                    </div>
                    <div class="quantity">
                    <button class="btn-minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
                        <span>${item.quantity}</span>
                        <button class="btn-plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                    <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm bg-light fs-6 keterangan-input" placeholder="Keterangan" id="inputKeterangan" value="${item.keterangan}">
                    <button class="btn btn-secondary dropdown-toggle atribut-btn" type="button" data-bs-toggle="dropdown"></button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-${item.prdcd}" style="width: 350px;">
                            <li><span class="dropdown-item">Data Tidak Ada...</span></li>
                         </ul>
                    </div>
                </div>
            `;
            $('.listCard').append(product_html);

            $.ajax({
                url: 'get_sub_product.php',
                type: 'GET',
                data: { prdcd: item.prdcd }, // Kirim prdcd ke server
                success: function (response) {
                    console.log(`Response from server for prdcd ${item.prdcd}: ${response}`);

                    try {
                        let subProducts = JSON.parse(response);
                        console.log('Sub Products:', subProducts);

                        // Proses setiap item untuk menggantikan \/ menjadi /
                        let dropdownContent = subProducts.map(sub => {
                            // Perbaiki path gambar
                            let imagePath = sub.sub_product_image.replace(/\\\//g, '/');  // Memperbaiki path
                            imagePath = 'http://localhost/menu_gelael/' + imagePath

                            return `
                    <li>
                        <a class="dropdown-item" href="#" style="padding: 5px 10px;">
                            <img src="${imagePath}" alt="${sub.sub_product_text}" class="me-2" style="width: 70px; height: 70px; object-fit: cover;">
                            ${sub.sub_product_text}
                        </a>
                    </li>
                `;
                        }).join('');

                        // Update dropdown dengan konten produk sub
                        $(`.dropdown-${item.prdcd}`).html(dropdownContent); // Ubah isi dropdown dengan konten baru
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        // Jika ada error, tampilkan pesan gagal
                        $(`.dropdown-${item.prdcd}`).html('<li><span class="dropdown-item text-danger">Data Tidak ada...</span></li>');
                    }
                },
                error: function () {
                    // Menangani error jika terjadi kesalahan pada AJAX request
                    $(`.dropdown-${item.prdcd}`).html('<li><span class="dropdown-item text-danger">Data Tidak ada...</span></li>');
                }
            });
        });

        if (totalPrice === 0) {
            $('.total-price').text('');
            $('.total-price-container').hide();
        } else {
            $('.total-price').text(formatIndonesianPrice(totalPrice.toFixed(0)));
            $('.total-price-container').show();
        }

        $(".badge-cart").text(cart_products.length);

        $('.listCard .btn-minus').click(function () {
            var itemIndex = $(this).closest('.item').data('index');
            if (cart_products[itemIndex].quantity > 0) {
                cart_products[itemIndex].quantity -= 1;
                if (cart_products[itemIndex].quantity === 0) {
                    cart_products.splice(itemIndex, 1);
                }
                renderCart();
            }
        });

        $('.listCard .btn-plus').click(function () {
            var itemIndex = $(this).closest('.item').data('index');
            cart_products[itemIndex].quantity += 1;
            renderCart();
        });

        $('.listCard .keterangan-input').on('input', function () {
            var itemIndex = $(this).closest('.item').data('index');
            cart_products[itemIndex].keterangan = $(this).val();
        });

        $('.listCard').on('click', '.dropdown-item', function () {
            var selectedText = $(this).text().trim();
            var $input = $(this).closest('.input-group').find('.keterangan-input');

            var existingText = $input.val().trim();
            if (existingText.includes(selectedText)) {
                return; // Jika sudah ada, tidak perlu menambah lagi
            }
        
            // Jika input sudah berisi teks, tambahkan koma sebagai pemisah
            if (existingText) {
                $input.val(existingText + ', ' + selectedText);
            } else {
                $input.val(selectedText);
            }
        });
    }
    
    function formatIndonesianPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Handle form submission using AJAX
    $("#product-form").submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'input.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('Product added successfully!');
                $("#product-form")[0].reset(); // Clear form after submission
                window.location.href = "http://localhost/menu_gelael/dashboard.php?page=input";
            },
            error: function (error) {
                console.log("AJAX Error:", error)
                alert('Failed to add product. Please try again.');
            },
        });
    });
});

