<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Your Logo</a>
    <span class="datetime-indicator" id="datetime"></span>
</nav>
<div class="container d-flex m-0"><div class="screen_left shadow p-3 bg-white rounded">
        <label for="cart_id">CartID</label>
        <select id="cart_id">
            <option value="0">Cart 0</option>
            <option value="1">Cart 1</option>
            <option value="2">Cart 2</option>
        </select>
        <div class="cart-top d-flex align-items-center justify-content-sm-between mt-2">


            <div class="new-customer">
                <span><svg xmlns="http://www.w3.org/2000/svg" height="30px" width="30px" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg></span>
                Walk in customer
            </div>

            <div>
                <button class="clear_cart btn btn-danger" onclick="clear_cart()" data-id="{{$screen}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></span>
                    Clear Cart
                </button>
            </div>

        </div>
        <div class="cart-middle scrollableContainer">
            <table id="middle-table">
                <thead>
                <tr>
                    <th>Item name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="cart-bottom">
            <hr>
            <div class="checkout">
                <div class="p-2 count">
                    <p class="d-flex justify-content-sm-between">
                        Subtotal: <span id="subtotal_value"></span>
                    </p>

                    <p class="d-flex justify-content-sm-between">
                        <span style="font-weight: bold; color: var(--system_primary_color)">Discount:</span> <span>0</span>
                    </p>

                    <p class="d-flex justify-content-sm-between">
                        TAX: <span id="tax_value">0</span>
                    </p>
                </div>

                <div class="total">
                    <p class="d-flex justify-content-sm-between">
                        Total due: <span class="total_due_value">0</span>
                    </p>
                </div>

                <div class="d-flex justify-items-center justify-content-sm-between mt-3">
                    <button class="cancelBtn shadow">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                        </span>
                        Cancel
                    </button>

                    <button class="holdBtn shadow" onclick="sendQr()">
                        (DEV)QR Gen
                    </button>

                    <button class="paymentBtn">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        </span>
                        Payments
                    </button>
                </div>



            </div>
        </div>

    </div>
    <div class="screen_right">
        <div class=" container listContainer">

            <div class="search-group">
                <h3>ITEM LIST</h3>
                <div class="input-group">
                    <button class="searchBtn " type="button" id="search-button" onclick="search_product()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
                    </button>
                    <input id="search_box" type="text" class="form-control" placeholder="Search for products..." aria-label="Search" aria-describedby="search-button">

                </div>
            </div>
            <div class="scrollableContainer justify-between mt-2">
                <table id="product-list">
                    <thead>
                    <tr>
                        <th>Item name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Photo</th>
                        <th>Action</th>
                        {{--                        <th>Status</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="shadow bg-white rounded">
                            <td>{{$product->product_name}}</td>
                            <td>
                                <select id="unit_{{$product->id}}">
                                    <option value="0">Box</option>
                                    <option value="1">Item</option>
                                </select>
                            </td>
                            <td>Box: {{$product->price_box_discounted}} <br> Item: {{$product->price_item_discounted}}</td>
                            <td>{{$product->quantity}}</td>
                            <td><img src="{{$product->product_image}}" height="70px" width="70px" alt="{{$product->id}}"></td>
                            <td>
                                <button class="add_to_cart btn btn-primary" onclick="add_to_cart('{{$product->id}}')" data-id="{{$product->id}}">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg></span>Add to Cart</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="form-container">
            <form class="popup-form bg-light p-3">
                <h2 class="text-center mb-4">Payment</h2>

                <div class="form-group row">
                    <label for="customerType" class="col-sm-4 col-form-label">Customer Type:</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="customerType" name="customerType">
                            <option value="new">New Customer</option>
                            <option value="old">Old Customer</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="totalMoney" class="col-sm-4 col-form-label">Total Money:</label>
                    <div class="col-sm-8">
                        <h4 class="total_due_value">0.00</h4>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="quantity" class="col-sm-4 col-form-label">Quantity:</label>
                    <div class="col-sm-8">
                        <h4>0.00</h4>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Payment Method:</label>
                        <div class="col-sm-8 button-group btn-group">
                            <button type="button" class="btn btn-secondary credit-btn">
                                <span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96v32H576V96c0-35.3-28.7-64-64-64H64zM576 224H0V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V224zM112 352h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 16c0-8.8 7.2-16 16-16H368c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"/></svg></span>
                                Credit</button>
                            <button type="button" class="btn btn-secondary cash-btn">
                                <span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg></span>
                                Cash
                            </button>
                        </div>
                    </div>

                    <div class="form-group row" id="cashAmount" style="visibility: hidden;">
                        <label for="cashInput" class="col-sm-4 col-form-label">Cash Amount:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="cashInput" name="cashInput">
                        </div>
                    </div>

                    <div class="form-group row button-group">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary close-btn">Close</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script>
    function add_to_cart(product_id) {
        $.ajax({
            url: '{{route('cart.add-to-cart')}}',
            method: 'POST',
            data: {
                product_id: product_id,
                _token: '{{csrf_token()}}',
                screen_id : '{{$screen}}',
                selling_type: $('#unit_'+product_id).val(),
                cart_id: $('#cart_id').val(),
            },
            success: function(data) {
                console.log(data);
                update_cart();
                update_total();
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function remove_from_cart(product_id, type) {
        let item_id = '#product_' + product_id + '_' + type;
        $(item_id).remove();
        $.ajax({
            url: '{{route('cart.remove-from-cart')}}',
            method: 'POST',
            data: {
                product_id: product_id,
                _token: '{{csrf_token()}}',
                screen_id : '{{$screen}}',
                selling_type: type,
                cart_id: $('#cart_id').val(),
            },
            success: function(data) {
                console.log(data);
                update_total();
                flasher.notyf.success(data.message, {position: {x:'right',y:'top'}, dismissible: true});
            }, error: function(data) {
                update_cart();
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function update_quantity(product_id, type, quantity) {
        alert("So, you want to update product "+product_id + ' with type ' + type + " to " + quantity + ". Let do it later...");
    }

    function clear_cart() {
        let cart_id = $('#cart_id').val();
        $("#middle-table").find("tr:gt(0)").remove();
        update_total_value(0, 0, 0);
        $.ajax({
            url: '{{route('cart.clear-cart-route')}}',
            method: 'GET',
            data: {
                _token: '{{csrf_token()}}',
                screen_id : '{{$screen}}',
                cart_id: cart_id,
            },
            success: function(data) {
                console.log(data);
                update_total();
            }
        });
    }

    function updateDateTime() {
        var now = new Date();
        var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var dayOfWeek = daysOfWeek[now.getDay()];

        var formattedDateTime = dayOfWeek + ', ' + now.toLocaleString();
        var datetimeElement = document.getElementById("datetime");
        datetimeElement.textContent = formattedDateTime;
    }

    function update_cart() {
        let cart_id = $('#cart_id').val();
        $.ajax({
            url: '{{route('cart.load-cart')}}/' + cart_id,
            method: 'GET',
            success: function(data) {
                console.log(data);
                display_product_list(data);
            }
        });
    }

    function display_product_list(products) {
        let cart_table = $('#middle-table tbody');
        cart_table.empty();
        $.each(products, function(key, product) {
            let product_id = key;
            if (product[0] !== undefined) {
                let row = $('<tr class="shadow bg-white rounded" id="product_' + product_id + '_' + '0' + '"></tr>');
                let product_box = product[0];
                let name = $('<td></td>').text(product_box.name);
                let unit = $('<td></td>').text("Box(s)");
                let price = $('<td></td>').text(product_box.price);
                let qty = $('<td></td>').html('<input type="number" value="'+product_box.quantity+'" onchange="update_quantity(\''+product_id+'\', 0, this.value)">');
                let photo = $('<td></td>').append($('<img>').attr('src', product_box.photo));
                let action = $('<td></td>').html('<button class="btn btn-danger" onclick="remove_from_cart(\''+product_id+'\', 0)">Remove</button>');
                row.append(name, unit, price, qty, photo, action);
                cart_table.append(row);
            }
            if (product[1] !== undefined) {
                let row = $('<tr class="shadow bg-white rounded" id="product_' + product_id + '_' + '1' + '"></tr>');
                let product_item = product[1];
                let name = $('<td></td>').text(product_item.name);
                let unit = $('<td></td>').text("Item(s)");
                let price = $('<td></td>').text(product_item.price);
                let qty = $('<td></td>').html('<input type="number" value="'+product_item.quantity+'" onchange="update_quantity(\''+product_id+'\', 1, this.value)">');
                let photo = $('<td></td>').append($('<img>').attr('src', product_item.photo).css('width', '100px'));
                let action = $('<td></td>').html('<button class="btn btn-danger" onclick="remove_from_cart(\''+product_id+'\', 1)">Remove</button>');
                row.append(name, unit, price, qty, photo, action);
                cart_table.append(row);
            }
        });
    }

    function search_product() {
        let search_box = $('#search_box').val();
        $.ajax({
            url: '{{route('cart.search-cart')}}?name=' + search_box,
            method: 'GET',
            success: function(data) {
                console.log(data);
                display_search_product_list(data);
            }
        });
    }

    function display_search_product_list(products) {
        let cart_table = $('.scrollableContainer #product-list tbody');
        cart_table.empty();
        $.each(products, function(key, product) {
            let product_id = product._id;
            let row = $('<tr class="shadow bg-white rounded"></tr>');
            let product_box = product;
            let name = $('<td></td>').text(product_box.product_name);
            let unit = $('<td></td>').html('<select id="unit_'+product_id+'"><option value="0">Box</option> <option value="1">Item</option> </select>');
            let price = $('<td></td>').html('Box: ' + product_box.price_box_discounted + ' <br> Item: ' + product_box.price_item_discounted);
            let qty = $('<td></td>').text(product_box.quantity);
            let photo = $('<td></td>').append($('<img>').attr('src', product_box.product_image).css('width', '100px'));
            let action = $('<td></td>').html('<button class="btn btn-primary" onclick="add_to_cart(\''+product_id+'\')">Add to cart</button>');
            row.append(name, unit, price, qty, photo, action);
            cart_table.append(row);
        });

    }

    function update_total() {
        let cart_id = $('#cart_id').val();
        $.ajax({
            url: '{{route('cart.load-total')}}/' + cart_id,
            method: 'GET',
            success: function(data) {
                console.log(data);
                update_total_value(data.data.subtotal, data.data.vat, data.data.total_due);
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function update_total_value(subtotal, vat, total_due) {
        $('#subtotal_value').text(subtotal);
        $('#tax_value').text(vat);
        $('.total_due_value').text(total_due);
    }

    function sendQr() {
        let cart_id = $('#cart_id').val();
        $.ajax({
            url: '{{route('cart.generate-qr-code')}}?cart_id=' + cart_id + '&screen_id={{$screen}}',
            method: 'GET',
            success: function(data) {
                console.log(data);
                saveNeedleCode(data.needle);

            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function callCheck(needle) {
        $.ajax({
            url: '{{route('transaction.find')}}?needle=' + needle,
            method: 'GET',
            success: function(data) {
                console.log(data);
                if(data.success === true) {
                    flasher.notyf.success("Received: "+data.data[0].amount + "VND", {position: {x:'right',y:'top'}, dismissible: true});
                    checkoutSuccess();
                }
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });

    }

    function checkoutSuccess() {
        // TODO: POC
        flasher.notyf.success('Checkout success', {position: {x:'right',y:'top'}, dismissible: true});
        clear_cart();
    }

    function saveNeedleCode(needle) {
        let cart_id = $('#cart_id').val();
        localStorage.setItem('cart_' + cart_id, needle);
    }

    function loadNeedleCode() {
        let cart_id = $('#cart_id').val();
        return localStorage.getItem('cart_' + cart_id);
    }

    function clearNeedleCode() {
        let cart_id = $('#cart_id').val();
        localStorage.removeItem('cart_' + cart_id);
    }


</script>
<script>
    update_cart();
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

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
    let channel = pusher.subscribe('pos_{{$screen}}');

    channel.bind('App\\Events\\PushPosData', function(data) {
        console.log(data);
        switch (data.msg_key) {
            case 'payment_noti':
                console.log(loadNeedleCode());
                callCheck(loadNeedleCode());
                break;
        }
    });



</script>
<script>
    $(document).ready(function () {
        const cashBtn = $('.cash-btn');
        const creditBtn = $('.credit-btn');
        const cashAmount = $('#cashAmount');
        const revealBtn = $('.paymentBtn');
        const formcontainer = $('.form-container');
        const closeBtn = $('.close-btn');



        cashBtn.click(function () {
            cashAmount.css('visibility', cashBtn.hasClass('active') ? 'hidden' : 'visible');
        });

        creditBtn.click(function () {
            cashAmount.css('visibility', 'hidden');
        });

        revealBtn.click(function () {
            cashAmount.css('visibility', 'hidden');
            formcontainer.toggleClass('show');
        });


        closeBtn.click(function () {
            formcontainer.removeClass('show');
            cashAmount.css('visibility', 'hidden');
        });
    });




</script>
</body>
</html>
