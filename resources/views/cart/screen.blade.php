<body style="width: auto">
    <table id="cart_table" style="border: solid black;">
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
</body>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>
<script>
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
        let cart_table = $('#cart_table tbody');
        let products = data.cart;
        console.log(products);
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
    });
</script>
