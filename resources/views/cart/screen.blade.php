<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<style>
.cont{
    border: 1px solid rgba(0, 0, 0, 0.3);
}
.ads_area{
    padding: 3rem;
    background-color: gray;;
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
            <th>Photo</th>
        </tr>
        </thead>

        <tbody>
        </tbody>

    </table>

    <div class="prices-totals">
        <p class="d-flex justify-content-sm-between">
            Subtotal: <span>3.12</span>
        </p>

        <p class="d-flex justify-content-sm-between">
            Rounding: <span>3.12</span>
        </p>

        <p class="d-flex justify-content-sm-between">
            <span style="font-weight: bold; color: var(--system_primary_color)">Discount:</span>
            <span>3.12</span>
        </p>

        <p class="d-flex justify-content-sm-between">
            Change: <span>3.12</span>
        </p>

        <p class="d-flex justify-content-sm-between">
            VAT: <span>3.12</span>
        </p>

        <p class="d-flex justify-content-sm-between" style="font-weight: bold">
            Total due: <span>25.62</span>
        </p>
    </div>
</div>



<div class="thank_screen" style="text-align: center">
    <div class="ads_area">
        This is some ads
    </div>
    <h2>Thank you for your visit !</h2>
    <h3>Please come again</h3>
    <br>
    <p>If you are happy with our services, please tell to your friends otherwise let us know so that we can improve.</p>
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
        update_screen();
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
                let photo = $('<td></td>').append($('<img>').attr('src', product_box.photo).css('width', '100px'));
                row.append(name, unit, price, qty, photo);
                cart_table.append(row);
            }
            if (product[1] !== undefined) {
                let product_item = product[1];
                let row = $('<tr></tr>');
                let name = $('<td></td>').text(product_item.name);
                let unit = $('<td></td>').text("Item(s)");
                let price = $('<td></td>').text(product_item.price);
                let qty = $('<td></td>').text(product_item.quantity);
                let photo = $('<td></td>').append($('<img>').attr('src', product_item.photo).css('width', '100px'));
                row.append(name, unit, price, qty, photo);
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
</script>
