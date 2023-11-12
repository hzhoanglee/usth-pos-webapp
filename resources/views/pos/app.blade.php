<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>POS</h1>
    <h2>Screen {{$screen}}</h2>
    <label for="cart_id">CartID</label><select id="cart_id">
        <option value="0">Cart 0</option>
        <option value="1">Cart 1</option>
        <option value="2">Cart 2</option>
    </select>
    <button class="clear_cart btn btn-danger" onclick="clear_cart()" data-id="{{$screen}}">Clear Cart</button>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product->product_name}}</td>
                <td>
                    <select id="unit_{{$product->id}}">
                        <option value="0">Box</option>
                        <option value="1">Item</option>
                    </select>
                </td>
                <td>Box: {{$product->price_box_discounted}} <br> Item: {{$product->price_item_discounted}}</td>
                <td>{{$product->quantity}}</td>
                <td><img src="{{$product->product_image}}" height="100px" width="100px" alt="{{$product->id}}"></td>
                <td>
                    <button class="add_to_cart btn btn-primary" onclick="add_to_cart('{{$product->id}}')" data-id="{{$product->id}}">Add to Cart</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
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
            }
        });
    }
    function clear_cart() {
        $.ajax({
            url: '{{route('cart.clear-cart-route')}}',
            method: 'POST',
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
</script>
</body>
</html>
