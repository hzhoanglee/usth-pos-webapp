<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CieloPOS</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <span class="datetime-indicator" style="margin-left: 1rem" id="datetime"></span>

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
                <button class="lock_system btn btn-danger" onclick="lock_system()" data-id="{{$screen}}">
                    Lock System
                </button>
                <button class="unlock_system btn btn-danger" onclick="unlock_system()" data-id="{{$screen}}">
                    Unlock System
                </button>
                <button type="button" class="btn" onclick="lockSystem()">Lock</button>
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
                        <span style="font-weight: bold; color: var(--system_primary_color)">Discount:</span> <span id="discount_value">0</span>
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

                <div class="d-flex justify-items-center  mt-3">
                    <button class="cancelBtn shadow" onclick="clear_cart()" data-id="{{$screen}}">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                        </span>
                        Clear cart
                    </button>
                    <button class="paymentBtn mx-3">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        </span>
                        Payments
                    </button>
                    <button class="couponBtn mx-3">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        </span>
                        Coupons
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
                            <td><img src="{{(!str_contains($product->product_image,'http')) ? Storage::disk('r2')->url($product->product_image) : $product->product_image}}" height="70px" width="70px" alt="{{$product->id}}"></td>
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
            {{--      Divide 2 part --}}
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <div style="margin-left: 10px"><form class="popup-form bg-light p-3">
                            <h2 class="text-center mb-4">Payment</h2>

                            <div class="form-group row">
                                <div class="col-sm-8 d-flex align-items-center">
                                    <label for="customerType" class="col-sm-4 col-form-label">Customer:</label>
                                    <select class="form-control ml-2 mx-3" id="customerType" name="customerType" onchange="loadCustomerData()" style="padding: 1px 7px; width: auto">
                                        <option value="walk_in">Walk In Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}} - {{$customer->mobile}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <button type="button" onclick="loadAddCustomerModal()" class="btn btn-primary ml-2 d-flex add-customer">
                                        Add
                                    </button>
                                </div>
                                <div class="col-sm-2 d-flex align-items-center">
                                    <button type="button" onclick="openCameraModal()" class="btn btn-primary ml-2 d-flex add-customer">
                                        Face
                                    </button>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="totalMoney" class="col-sm-4 col-form-label">Total Money:</label>
                                <div class="col-sm-8">
                                    <h4 class="total_due_value">0.00</h4>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Payment Method:</label>
                                    <div class="col-sm-8 button-group btn-group">
                                        <input value="bank-transfer" class="form-check-input" type="radio" name="payment-method" id="payment-method" checked>
                                        <label class="form-check-label" for="payment-method">
                                            Bank Transfer
                                        </label>
                                        <input value="cash" class="form-check-input" type="radio" name="payment-method" id="payment-method">
                                        <label class="form-check-label" for="payment-method">
                                            Cash
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row" id="gen-qr-button">
                                    <label class="col-sm-4 col-form-label">Generate QR Code</label>
                                    <button type="button" class="btn-secondary btn p-3 col-sm-8 my-3 " onclick="sendQr()">
                                        (DEV)QR Gen
                                    </button>
                                </div>
                                <div class="form-group row button-group">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-secondary close-btn">Close</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" onclick="checkoutSuccess(1)" class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form></div>
                </div>
                <div class="d-flex flex-column">
                    <div style="margin-left: 10px">
                        <div class="popup-form bg-light p-3">
                            <h2 class="text-center mb-4">Customer Information</h2>
                            <div class="form-group row">
                                <label for="customerName" class="col-sm-4 col-form-label">Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="customerName">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customerAge" class="col-sm-4 col-form-label">Age:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="customerAge">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customerPhone" class="col-sm-4 col-form-label">Phone:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="customerPhone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customerBloodType" class="col-sm-4 col-form-label">BloodType:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="customerBloodType">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customerAllergy" class="col-sm-4 col-form-label">Allergy:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="customerAllergy">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="customerSymptomps" class="col-sm-4 col-form-label">Symptomps:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="customerSymptomps">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="overlay glass" id="overlay">
    <div class="popup" id="popup">
        <h2>System has been locked</h2>
        <label for="textInput">Enter Text:</label>
        <input type="text" id="textInput" name="textInput">
        <button type="button" onclick="unlockSystem()">Unlock</button>
    </div>
</div>

<div class="glass" id="blur" style="display: none"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    // Select2
    $(document).ready(function() {
        $('#customerType').select2();
        // on change of payment method
        $('input[type=radio][name=payment-method]').change(function() {
            if (this.value === 'bank-transfer') {
                $('#gen-qr-button').show();
            } else {
                $('#gen-qr-button').hide();
            }
        });
    });

    // Modal with iframe
    function loadAddCustomerModal() {
        $('#n-user').modal('show');
        ifrhgh();
    }

    function ifrhgh(){
        let n_user = $("#n-user");
        let iframe = $("#print_frame");
        let modal_height = $(window).height()*75/100;
        let iframe_width = $('.modal-dialog').width()*95/100;
        n_user.height(modal_height*120/100);
        iframe.width(iframe_width);
        iframe.height(modal_height);
    }

    function loadCustomerData() {
        let id = $('#customerType').val();
        $.ajax({
            url: '{{route('pos.get-customer-info')}}/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data);
                $('#customerName').val(data.name);
                $('#customerAge').val(data.age);
                $('#customerPhone').val(data.mobile);
                $('#customerBloodType').val(data.details['Blood type']);
                $('#customerAllergy').val(data.details.Allergy);
                $('#customerSymptomps').val(data.details.Symptoms);
            }, error: function(data) {
                flasher.notyf.error("Cannot find that user", {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }


    // Lock & Lock
    let popup = document.getElementById("overlay");

    function lockSystem (){
        popup.classList.add("open-overlay");
    }
    function unlockSystem (){
        $.ajax({
            url: '{{route('get-password')}}',
            method: 'GET',
            // data: {
            //     password: ,
            //     // Other necessary data
            // },
            success: function(response) {
                // Handle the response from the server

                console.log(response);
                var userInput = document.getElementById('textInput').value;
                let count = 0;
                for (let i =0; i <= response.length; i++) {
                    if (userInput === response[i]){
                        console.log('1 matches')
                        count += 1;
                    }
                }

                if (count >= 1){
                    popup.classList.remove("open-overlay");
                }
            },
            error: function(error) {
                // Handle errors
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

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
        update_total_value(0, 0, 0, 0);
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
            if (product[3] !== undefined) {
                let row = $('<tr class="shadow bg-white rounded" id="product_' + product_id + '_' + '3' + '"></tr>');
                let coupon = product[3];
                let name = $('<td></td>').text(coupon.name);
                let unit = $('<td></td>').text("Coupon");
                let price = $('<td></td>').text(coupon.price);
                let qty = $('<td></td>').html(1);
                let photo = $('<td></td>');
                let action = $('<td></td>').html('<button class="btn btn-danger" onclick="remove_from_cart(\''+product_id+'\', 3)">Remove</button>');
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

    // function getOrderList(){
    //     $.ajax({
    //         url: '{{route('get-order-list')}}',
    //         method: 'GET',
    //         console.log(response);
    //     })
    // }

    function update_total() {
        let cart_id = $('#cart_id').val();
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

    function update_total_value(subtotal, vat, total_due, discount) {
        $('#subtotal_value').text(subtotal);
        $('#tax_value').text(vat);
        $('.total_due_value').text(total_due);
        $('#discount_value').text(discount);

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

    function checkoutSuccess(button=0) {
        let cart_id = $('#cart_id').val();
        let customer_id = $('#customerType').val();
        let payment_method = $('input[name=payment-method]:checked').val();
        if(payment_method === 'bank-transfer' && button === 1) {
            flasher.notyf.error("Please scan QR code to pay", {position: {x:'right',y:'top'}, dismissible: true});
            return;
        }
        $.ajax({
            url: '{{route('pos.perform-checkout')}}',
            method: 'POST',
            data: {
                cart_id: cart_id,
                customer_id: customer_id,
                payment_type: payment_method,
                payment_record: 0,
                _token: '{{csrf_token()}}',
            },
            success: function(data) {
                console.log(data);
                flasher.notyf.success(data.message, {position: {x:'right',y:'top'}, dismissible: true});
                clear_cart();
                $('.form-container').removeClass('show');
                $('.form-customer-container').removeClass('show');
                blur.removeClass('show');
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
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

    function loadCouponList() {
        $.ajax({
            url: '{{route('cart.get-coupon-list')}}?cart_id=' + $('#cart_id').val(),
            method: 'GET',
            success: function(data) {
                console.log(data);
                displayCouponList(data);
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function displayCouponList(coupons) {
        $('#n-coupon').modal('show');
        let coupon_table = $('#n-coupon-table tbody');
        coupon_table.empty();
        $.each(coupons, function(key, coupon) {
            let row = $('<tr class="shadow bg-white rounded"></tr>');
            let name = $('<td></td>').text(coupon.coupon_code);
            let type = $('<td></td>').text(coupon.coupon_type);
            let amount = $('<td></td>').text(coupon.coupon_value);
            if(coupon.coupon_type === 'percent') {
                amount.append('%');
            } else {
                amount.append('VND');
            }
            let min_apply = $('<td></td>');
            if(coupon.coupon_condition === null || coupon.coupon_condition === []) {
                min_apply.text(0);
            } else {
                min_apply.text(coupon.coupon_minimum_condition);
            }
            let expire = $('<td></td>').text(coupon.expired_date);
            let action = $('<td></td>').html('<button class="btn btn-primary" onclick="applyCoupon(\''+coupon.coupon_code+'\')">Apply</button>');
            row.append(name, type, amount, min_apply, expire, action);
            coupon_table.append(row);
        });
    }

    function applyCoupon(coupon_code) {
        $.ajax({
            url: '{{route('cart.apply-coupon')}}?cart_id=' + $('#cart_id').val() + '&coupon_id=' + coupon_code,
            method: 'GET',
            success: function(data) {
                console.log(data);
                flasher.notyf.success(data.message, {position: {x:'right',y:'top'}, dismissible: true});
                update_cart();
                update_total();
                $('#n-coupon').modal('hide');
            }, error: function(data) {
                flasher.notyf.error(data.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
            }
        });
    }

    function showFaceCaptureModal() {
        $('#n-face').modal('show');
    }


</script>
<script>
    update_cart();
    update_total();
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
            case 'new_product':
                update_cart();
                update_total();
                break;
            case 'new_customer_id':
                console.log(data.msg_data);
                console.log(data.msg_data.id);
                $('#n-user').modal('hide');
                $('#n-face').modal('hide');
                let customer_box = $('#customerType');
                customer_box.append('<option value="'+data.msg_data.id+'">'+data.msg_data.name+' - '+data.msg_data.phone+'</option>');
                customer_box.val(data.msg_data.id).trigger('change');
                break;
        }
    });

</script>
<script>
    $(document).ready(function () {
        const revealBtn = $('.paymentBtn');
        const formContainer = $('.form-container');
        const formCustomerContainer = $('.form-customer-container');
        const closeBtn = $('.close-btn');
        const couponBtn = $('.couponBtn');
        const blur = $('#blur');


        revealBtn.click(function () {
            formContainer.toggleClass('show');
            blur.toggleClass('show');
        });

        couponBtn.click(function () {
            loadCouponList();
        });


        closeBtn.click(function () {
            formContainer.removeClass('show');
            formCustomerContainer.removeClass('show');
            blur.removeClass('show');
        });
    });




</script>
<div class="modal" tabindex="-1" id="n-user" style="position: fixed; width: 100vw; padding: 50px;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="print_frame" src="/admin/customers/create" style="background-color: rgb(23, 22, 26); border-radius: 5px; width: 100%; height: 100%;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="n-coupon" style="position: fixed; width: 100vw; padding: 50px;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Coupon List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table" id="n-coupon-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Coupon</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Minimum apply</th>
                            <th>Expire</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="n-face" style="position: fixed; width: 100vw; padding: 50px;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Coupon List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Choose camera --}}
                <div class="form-group row">
                    <label for="camera" class="col-sm-4 col-form-label">Camera:</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="cameraselector" onchange="changeCamera()">

                        </select>
                    </div>
                </div>
                <div id="camera-container"></div>

                <button type="button" class="btn btn-primary" id="capture-btn">Capture and Post Image</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    function openCameraModal() {
        $('#n-face').modal('show');
        // Get the camera list
        navigator.mediaDevices.enumerateDevices().then(function (devices) {
            let camera_list = $('#cameraselector');
            camera_list.empty();
            devices.forEach(function (device) {
                if (device.kind === 'videoinput') {
                    camera_list.append('<option value="' + device.deviceId + '">' + device.label + '</option>');
                }
            });
        });
        initCamera();
    }

    function changeCamera() {
        Webcam.reset();
        let camera_id = $('#cameraselector').val();
        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90,
            constraints: {
                deviceId: camera_id,
            }
        });
        Webcam.attach('#camera-container');
    }

    function initCamera() {
        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera-container');
    }

    // Function to capture and post image
    function captureAndPostImage() {
        // Capture the image from the webcam
        Webcam.snap(function (data_uri) {
            // Create a FormData object to send the image data
            var formData = new FormData();
            formData.append('image', data_uri);
            formData.append('pos_screen', '{{$screen}}')

            // Use ajax to send image data to the route {{route("pos.check-user-face")}}
            $.ajax({
                url: '{{route('pos.check-user-face')}}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let data = JSON.parse(response);
                    $('#n-face').modal('hide');
                    $('#n-user').modal('hide');
                    $('#n-customer').modal('hide');
                    let customer_box = $('#customerType');
                    customer_box.val(data.msg_data.id).trigger('change');
                    flasher.notyf.error("OK", {position: {x:'right',y:'top'}, dismissible: true});
                },
                error: function (response) {
                    flasher.notyf.error(response.responseJSON.message, {position: {x:'right',y:'top'}, dismissible: true});
                }
            });
        });
        Webcam.reset();
    }

    // Attach click event listener to the capture button
    document.getElementById('capture-btn').addEventListener('click', captureAndPostImage);
    // listen if modal is closed
    $('#n-face').on('hidden.bs.modal', function () {
        Webcam.reset();
    })
</script>
</body>
</html>
