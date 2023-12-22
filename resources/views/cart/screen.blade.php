

<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<style>
.cont{
    border: 1px solid rgba(0, 0, 0, 0.3);
}
.ads_area{
    padding: 3rem;
    background-color: gray;
}

table {
    border-collapse: collapse;
    width: 100%;
}

tr {
    border-bottom: 1px solid rgba(0, 0, 0, 0.3);
}
</style>

<body style="width: auto; display: flex">
<div class="cont" style="width: 400px">
    <table id="cart_table" style="" >
        <thead>
        <tr>
            <th>Product</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Qty</th>
            {{--            <th>Photo</th>--}}
        </tr>
        </thead>

        <tbody>
        </tbody>

    </table>

    <div class="prices-totals">
        <p class="d-flex justify-content-sm-between">
            Subtotal: <span id="subtotal_value">0</span>
        </p>

        <p class="d-flex justify-content-sm-between">
            <span style="font-weight: bold; color: var(--system_primary_color)">Discount:</span>
            <span id="discount_value">0</span>
        </p>

        <p class="d-flex justify-content-sm-between">
            Tax: <span id="tax_value">0</span>
        </p>

        <div class="total">
            <p class="d-flex justify-content-sm-between" style="font-weight: bold">
                Total due: <span id="total_due_value">0</span>
            </p>
        </div>

    </div>
</div>

<div class="thank_screen" style="text-align: center; flex: 1">
    <div class="ads_area">
        This is some ads
    </div>
    <div id="thank_you" class="thank_you" style="display: none;">
        <h2>Thank you for your visit !</h2>
        <h3>Please come again</h3>
        <br>
        <p>If you are happy with our services, please tell to your friends otherwise let us know so that we can improve.</p>
    </div>

    <br>
    <p><div id="qr_code" class="d-flex" style="height: 300px; width: 300px"></div></p>
</div>



</body>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>
<script>
    // document on load
    $(document).ready(function() {
        // update_screen();
    });

    let pusher = new Pusher('lkey', {
        wsHost: 'socket.vslim.io',
        forceTLS: true,
        encrypted: true,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
        cluster: 'ap1',
    });
    let channel = pusher.subscribe('screen_{{$screen}}');

    channel.bind('App\\Events\\NewProductToCart', function(data) {
        console.log("Cart updated");
        let products = data.cart;
        console.log(products);
        update_cart(products);
        update_total(data.cart_id);
    });

    channel.bind('App\\Events\\PushScreenData', function(data) {
        console.log(data);
        switch (data.msg_key) {
            case 'new_qr':
                show_qr(atob(data.msg_data));
                break;
            case 'new_cart':
                let products = data.msg_data;
                update_cart(products);
                break;
            case 'new_total':
                let total = data.msg_data;
                $('#total_due_value').text(total);
                break;
            case 'payment_received':
                $('#thank_you').show();
                clear_screen();
                break;
        }
    });

    function update_cart(products) {
        let cart_table = $('#cart_table tbody');
        cart_table.empty();
        $.each(products, function(key, product) {
            if (product[0] !== undefined) {
                let product_box = product[0];
                let row = $('<tr></tr>');
                let name = $('<td></td>').text(product_box.name);
                let unit = $('<td></td>').text("Box(s)");
                let price = $('<td></td>').text(product_box.price);
                let qty = $('<td></td>').text(product_box.quantity);
                // let photo = $('<td></td>').append($('<img>').attr('src', product_box.photo).css('width', '100px'));
                row.append(name, unit, price, qty);
                cart_table.append(row);
            }
            if (product[1] !== undefined) {
                let product_item = product[1];
                let row = $('<tr></tr>');
                let name = $('<td></td>').text(product_item.name);
                let unit = $('<td></td>').text("Item(s)");
                let price = $('<td></td>').text(product_item.price);
                let qty = $('<td></td>').text(product_item.quantity);
                // let photo = $('<td></td>').append($('<img>').attr('src', product_item.photo).css('width', '100px'));
                row.append(name, unit, price, qty);
                cart_table.append(row);
            }
            if (product[3] !== undefined) {
                let product_item = product[3];
                let row = $('<tr></tr>');
                let name = $('<td></td>').text(product_item.name);
                let unit = $('<td></td>').text("Coupon");
                let price = $('<td></td>').text(product_item.price);
                let qty = $('<td></td>').text(product_item.quantity);
                // let photo = $('<td></td>').append($('<img>').attr('src', product_item.photo).css('width', '100px'));
                row.append(name, unit, price, qty);
                cart_table.append(row);
            }
        });
    }

    function update_screen() {
        let screen_id = {{$screen}};
        $.ajax({
            url: '{{route('cart.screen-data')}}/' + screen_id,
            method: 'GET',
            success: function(data) {
                console.log(data);
                update_cart(data);
            }
        });
    }

    function update_total(cart_id) {
        $.ajax({
            url: '{{route('cart.load-total')}}/' + cart_id,
            method: 'GET',
            success: function(data) {
                console.log(data);
                update_total_value(data.data.subtotal, data.data.vat, data.data.total_due, data.data.discount);
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function show_qr(svg) {
        console.log(svg);
        $('#thank_you').hide();
        let qr = $('#qr_code');
        qr.show();
        qr.html(svg);
    }

    function update_total_value(subtotal, vat, total_due, discount) {
        $('#subtotal_value').text(subtotal);
        $('#tax_value').text(vat);
        $('#total_due_value').text(total_due);
        $('#discount_value').text(discount);
    }

    function clear_screen() {
        $('#cart_table tbody').empty();
        $('#qr_code').hide();
        update_total_value(0, 0, 0);
    }

</script>
