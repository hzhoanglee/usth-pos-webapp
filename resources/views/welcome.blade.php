<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Machine</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            background-image: url('background-image.jpg'); /* Add your background image URL here */
            background-size: cover;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
            margin-top: 50px;
        }

        .button {
            display: inline-block;
            padding: 20px 40px;
            font-size: 20px;
            text-align: center;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border: 2px solid #2980b9;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<h1>POS Machine</h1>

<a href="#" class="button" onclick="login()">Login</a>
<a href="#" class="button" onclick="logout()">Logout</a>
<a href="#" class="button" onclick="posMachine()">POS Machine</a>
<a href="#" class="button" onclick="posScreen()">POS Screen</a>

<script>
    function login() {
        window.location.href = '{{ route('login') }}';
    }

    function logout() {
        window.location.href = '{{ route('logout') }}';
    }

    function posMachine() {
        window.location.href = '{{ route('pos.app', ['screen' => 0]) }}';
    }

    function posScreen() {
        window.location.href = '{{ route('cart.screen', ['screen' => 0]) }}';
    }
</script>

</body>
</html>
