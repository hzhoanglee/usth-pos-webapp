<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>CieloPOS by USTH & VHZ</title>

    @if (config('app.is_demo'))
        <meta name="keywords"
            content="point of sale" />
        <meta name="description" content="Point Of Sale Application" />
        <meta itemprop="name" content="CieloPOS by USTH & VHZ" />
        <meta itemprop="description" content="Point Of Sale Application" />
        <meta name="twitter:card" content="product" />
        <meta name="twitter:title" content="CieloPOS by USTH & VHZ" />
        <meta name="twitter:description" content="Point Of Sale Application" />
        <meta property="fb:app_id" content="655968634437471" />
        <meta property="og:title" content="CieloPOS by USTH & VHZ" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="https://www.usth.edu.vn/" />
        <meta property="og:description" content="Point Of Sale Application" />
    @endif
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.11.5/datatables.min.css"/> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/argon-dashboard.css" rel="stylesheet" />

    @stack('css')

</head>

<body class="g-sidenav-show bg-gray-100 {{ $class ?? '' }}">
    @guest
        @yield('content')
    @endguest

    @auth
        @if (str_contains(request()->url(), 'rtl') ||
            str_contains(request()->url(), 'pricing-page') ||
            in_array(
                request()->route()->getName(),
                ['signins', 'signups', 'resets', 'locks', 'verifications', 'errors']))
            @yield('content')
        @else
            @if (str_contains(request()->url(), 'landing'))
                @include('components.headers.hero', ['height' => 'h-100'])
                @include('layouts.navbars.auth.sidenav', [
                    'box' => 'box-shadow-none',
                    'logo' => '/assets/img/logo-ct.png',
                ])
            @elseif (!str_contains(request()->url(), 'vr'))
                @if (Route::currentRouteName() == 'profiles' || str_contains(request()->url(), 'new-product'))
                    @include('components.headers.image-hero')
                @else
                    @include('components.headers.hero')
                @endif
                @include('layouts.navbars.auth.sidenav', ['bg' => 'bg-white'])
            @endif

            <main class="main-content position-relative border-radius-lg">
                @yield('content')
                @include('components.fixed-plugin')
            </main>
        @endif
    @endauth

    <!--   Core JS Files   -->
    @stack('js')

    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    {{-- <script src="/assets/js/core/bootstrap.bundle.min.js"></script> --}}
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/fullcalendar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/argon-dashboard.js"></script>

    {{--  Test Pusher  --}}
    <script src="https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.css" rel="stylesheet">
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script type="text/javascript">
        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            wsHost: '{{env('PUSHER_HOST')}}',
            forceTLS: true,
            encrypted: true,
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
        });

        // Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('development');

        // Bind a function to a Event (the full Laravel class)
        channel.bind('App\\Events\\HelloPusherEvent', function(data) {
            console.log(data);
            flasher.notyf.success(data.message, {position: {x:'right',y:'top'}, dismissible: true});
        });
    </script>
</body>

</html>
