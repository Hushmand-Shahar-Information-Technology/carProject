<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="stylesheet" href="{{ asset('images/favicon.ico') }}" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

    <!-- flaticon -->
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}" />

    <!-- mega menu -->
    <link rel="stylesheet" href="{{ asset('css/mega-menu/mega_menu.css') }}" />

    <!-- font awesome -->
    {{--
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" /> --}}

    <!-- owl-carousel -->
    <link rel="stylesheet" href="{{ asset('css/owl-carousel/owl.carousel.css') }}" />
    <!-- Magnific Popup CSS -->
    <!-- Make sure you have Bootstrap JS included -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup/dist/magnific-popup.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Magnific Popup JS -->
    <script src="https://cdn.jsdelivr.net/npm/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" />
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/> --}}

    <!-- magnific-popup -->
    {{--
    <link rel="stylesheet" href="{{asset('css/magnific-popup/magnific-popup.css')}}" /> --}}

    {{-- <link rel="stylesheet" type="text/css" href="css/slick/slick.css" /> --}}
    {{-- <link rel="stylesheet" type="text/css" href="css/slick/slick-theme.css" /> --}}

    <!-- revolution -->
    <link rel="stylesheet" href="{{ asset('revolution/css/settings.css') }}" />

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    {{-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> --}}
    {{ $slot }}
    {{-- </div> --}}

</body>

</html>
