$(document).ready(function () {
    let cart_products = [];
    let totalPrice = 0;

    $(".cart-icon").click(function () {
        $(".cartTab").toggleClass("active");
        renderCart();
    });

    $(".close").click(function () {
        $(".cartTab").removeClass("active");
    });

    $(".order").click(function () {
        let orderData = {
            products: cart_products,
            no_meja: no_meja,
        };

        // Send AJAX request to save order
        $.ajax({
            type: 'POST',
            url: 'order.php', // Create this PHP file
            data: JSON.stringify(orderData),
            contentType: "application/json",
            success: function (response) {
                alert('Order placed successfully!');
                cart_products = []; // Clear cart after order
                renderCart(); // Re-render cart to reflect changes
            },
            error: function (error) {
                alert('Failed to place order. Please try again.');
            }
        });
    });
        

    $(".back").click(function () {
    window.location.href = "index.php";
});

$(".btn-add").click(function () {// Get the product details
    var product_card = $(this).closest('.card');
    var product_name = product_card.find('.card-title').text().trim().replace(/\n/g, '').replace(/\s\s+/g, ' ');;
    var product_price_str = product_card.find('.card-footer h5').text().trim().replace(/\n/g, '').replace(/\s\s+/g, ' ');;
    var product_photo = product_card.find('.card-img-top').attr('src');
    var product_price = parseFloat(product_price_str.replace(/\./g, '').replace(',', '.'));

    var existing_product = cart_products.find(item => item.name === product_name);

    if (existing_product) {
        existing_product.quantity += 1;
    } else {
        var product = {
            name: product_name,
            price: product_price,
            photo: product_photo,
            quantity: 1,
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

        var product_html = `
                <div class="item" data-index="${index}">
                    <div class="image">
                        <img src="${item.photo}" alt="">
                    </div>
                    <div class="name">
                        ${item.name}
                    </div>
                    <div class="price">
                        ${formatIndonesianPrice(item.price)}
                    </div>
                    <div class="quantity">
                    <button class="btn-minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
                        <span>${item.quantity}</span>
                        <button class="btn-plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm bg-light fs-6 keterangan-input" placeholder="Keterangan" id="inputKeterangan" value="${item.keterangan}">
                    </div>
                </div>
            `;
        $('.listCard').append(product_html);
    });

    $('.total-price').text(formatIndonesianPrice(totalPrice.toFixed(0)));

    if (cart_products.length === 0) {
        $('.total-price-container').hide();
    } else {
        $('.total-price-container').show();
    }

    $(".badge").text(cart_products.length);

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
}
function formatIndonesianPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
});