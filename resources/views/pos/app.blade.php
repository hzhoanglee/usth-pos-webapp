<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        :root{
            --system_primary_color: #64BEFF;
            --system-white: #FFFFFF;
            --system-success: #3BDEE9;
            --system-secondary-color-10: rgba(206, 234, 255, 0.59);
            --text-color: #777777;
            --system-gray: #D6D6D6;
            --neutral-10: #F0F0F0;
            --backkground-color: #EDF8FF

        }

        body {
            overflow-y: auto;
        }

        .navbar{
            background-color: var(--system_primary_color);
            color: var(--system-white);
            font-weight: bold;

        }

        .datetime-indicator {
            font-size: 18px;
            margin-right: 15px
        }


        .screen_left{
            flex: 0 0 620px;

        }

        .screen_right{
            flex: 0 0 65%;
            margin-left: 1rem;

        }

        .custom-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin-bottom: 15px;
        }

        svg{
            fill: var(--system-white)
        }

        h1, h2, h3{
            color: var(--system_primary_color);
            font-weight: 600;
        }

        .scrollableContainer{
            max-height: 440px;
            overflow-y: auto;

        }

        .search-group{
            white-space: nowrap;
            justify-content: space-between;
        }

        .input-group{
            width: 250px;
        }

        .form-control{
            border-radius: 1rem;
            height: 30px;
            background-color: var(--system_primary_color);
        }

        .searchBtn{
            height: 30px;
            border-radius: 1rem;
            background-color: var(--system_primary_color);
            fill: var(--system-white);
            border: none;
            z-index: 2;
            padding-left: 10px;
            transition: all .3s ease;

        }

        .searchBtn:hover{
            opacity: .6;
        }

        .input-group  input::placeholder {
            color: var(--system-white);
        }

        th, td{
            padding: 10px;
            color: var(--text-color);
        }

        table {
            border-collapse: separate;
            border-spacing: 5px 10px; /* Adjust the second value to set the vertical spacing */
        }

        .cart-middle{
            height: 380px;
        }

        p{
            margin-bottom:.2rem;
        }




        .btn-success{
            background-color: var(--system-success) !important;
            border: var(--system-success) !important;
        }


        .btn-primary{
            background-color: var(--system_primary_color);
            border: var(--system_primary_color);
        }

        .new-customer{
            background-color: var(--system-secondary-color-10);
            border-radius: 1.5rem;
            padding: .3rem;
            color: var(--text-color);
            font-weight: 600;
            font-size: 16px;
            width: 186px;

        }

        .new-customer svg{
            fill: var(--text-color);
            margin-left: 6px;
        }

        .total{
            border-radius: .5rem;
            border: 3px solid var(--system_primary_color);
            padding: .5rem 1rem;
            font-size: 20px;
            font-weight: bold;
            color:var(--system_primary_color);
            background-color: var(--system-secondary-color-10) ;
        }

        .total > p{
            margin: 0;
        }

        .cancelBtn, .holdBtn, .paymentBtn{
            padding: 1rem;
            width: 180px;
            border: none;
            border-radius: .5rem;
            font-weight: 600;
        }

        .cancelBtn, .holdBtn{
           color: var(--text-color);
        }

        .cancelBtn{
            background-color: var(--system-gray);
            transition: all .1s linear;
        }
        .cancelBtn:hover{
            background-color: var(--neutral-10);
        }

        .cancelBtn > span > svg{
            fill: var(--text-color);
        }
        .holdBtn > span > svg{
            fill: var(--text-color);
        }

        .holdBtn{
            background-color: var(--neutral-10);
            transition: all .1s linear;

        }

        .holdBtn:hover{
            background-color: var(--system-gray);
        }

        .paymentBtn{
            background-color: var(--system_primary_color);
            color: var(--system-white);
            transition: all .1s linear;
        }

        .paymentBtn:hover{
            background-color: #0d6efd;
        }



        .count{
            font-size: 14px;
        }

        ::-webkit-scrollbar {
            width: 15px;

        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow:  inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: var(--system_primary_color);
            border-radius: 10px;
        }



    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Your Logo</a>
    <span class="datetime-indicator" id="datetime"></span>
</nav>
<div class="container d-flex m-0"><div class="screen_left shadow p-3 mb-5 bg-white rounded">
        <label for="cart_id">CartID</label><select id="cart_id">
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
                <button class="add_customer btn btn-primary  " onclick="clear_cart()" data-id="{{$screen}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></span>
                    Add customer
                </button>
                <button class="add-note btn btn-success" onclick="clear_cart()" data-id="{{$screen}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H288V368c0-26.5 21.5-48 48-48H448V96c0-35.3-28.7-64-64-64H64zM448 352H402.7 336c-8.8 0-16 7.2-16 16v66.7V480l32-32 64-64 32-32z"/></svg></span>
                    Add note
                </button>
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
                        Subtotal: <span>3.12</span>
                    </p>

                    <p class="d-flex justify-content-sm-between">
                        Rounding: <span>3.12</span>
                    </p>

                    <p class="d-flex justify-content-sm-between">
                        <span style=" font-weight: bold; color: var(--system_primary_color)">Discount:</span> <span>3.12</span>
                    </p>

                    <p class="d-flex justify-content-sm-between">
                        Change: <span>3.12</span>
                    </p>

                    <p class="d-flex justify-content-sm-between">
                        VAT: <span>3.12</span>
                    </p>
                </div>

                <div class="total">
                    <p class="d-flex justify-content-sm-between">
                        Total due: <span>3.12</span>
                    </p>
                </div>

                <div class="d-flex justify-items-center justify-content-sm-between mt-3">
                    <button class="cancelBtn shadow">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                        </span>
                        Cancel
                    </button>

                    <button class="holdBtn shadow" >
                        <span>
                           <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                        </span>
                        Hold
                    </button>

                    <button class="paymentBtn">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        </span>
                        Payment
                    </button>
                </div>



            </div>
        </div>

    </div>
<div class="screen_right">
        <div class="categoryContainer">
            <h3>CATEGORY</h3>
            <div class="container">
                @for ($row = 1; $row <= 3; $row++)
                    <div class="row">
                        @for ($col = 1; $col <= 4; $col++)
                            <div class="col-md-3">
                                <div class="custom-box">Category {{ ($row - 1) * 4 + $col }}</div>
                            </div>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        <div class="listContainer">

            <div class="search-group d-flex align-items-center justify-between">
                <h3>ITEM LIST</h3>
                <div class="input-group">
                    <button class="searchBtn " type="button" id="search-button" onclick="search_product()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
                    </button>
                    <input id="search_box" type="text" class="form-control" placeholder="Search for products..." aria-label="Search" aria-describedby="search-button">

                </div>
            </div>
            <div class="scrollableContainer">
                <table id="product-list">
                    <thead>
                    <tr>
                        <th>Item name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Photo</th>
                        <th>Action</th>
                        <th>Status</th>
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
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function remove_from_cart(product_id, type) {
        // alert("So, you want to remove product "+product_id + ' with type ' + type + ". Let do it later...");
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
        $.ajax({
            url: '{{route('cart.clear-cart-route')}}',
            method: 'GET',
            data: {
                _token: '{{csrf_token()}}',
                screen_id : '{{$screen}}',
                cart_id: $('#cart_id').val(),
            },
            success: function(data) {
                console.log(data);
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
                let photo = $('<td></td>').append($('<img>').attr('src', product_box.photo).css('width', '100px'));
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
            let price = $('<td></td>').text(product_box.price_box_discounted);
            let qty = $('<td></td>').text(product_box.quantity);
            let photo = $('<td></td>').append($('<img>').attr('src', product_box.photo).css('width', '100px'));
            let action = $('<td></td>').html('<button class="btn btn-primary" onclick="add_to_cart(\''+product_id+'\')">Add to cart</button>');
            row.append(name, unit, price, qty, photo, action);
            cart_table.append(row);
        });

    }


</script>
<script>
    update_cart();
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
</body>
</html>
