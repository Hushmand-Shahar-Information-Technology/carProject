<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themes.potenzaglobalsolutions.com/html/cardealer/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 May 2025 11:17:54 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Car Dealer - The Best Car Dealer Automotive Responsive HTML5 Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="stylesheet" href="{{ asset('images/favicon.ico') }}" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

    <!-- flaticon -->
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}" />

    <!-- mega menu -->
    <link rel="stylesheet" href="{{ asset('css/mega-menu/mega_menu.css') }}" />

    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />

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

    <!-- revolution -->
    <link rel="stylesheet" href="{{ asset('revolution/css/settings.css') }}" />

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

    <!-- Custom font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Additional styles will be added here by pages -->
    @stack('styles')

    <!-- Custom styles for navigation -->
    <style>
        /* ====== Topbar Styles ====== */
        .topbar {
            background: transparent !important;
            border-bottom: 1px solid #e5e7eb !important;
            /* light border for separation */
            color: rgb(255, 255, 255) !important;
            font-size: 14px !important;
            padding: 8px 0 !important;
            width: 100% !important;
        }

        .topbar .container {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
        }

        /* ===== Left and Right Sections ===== */
        .topbar-left ul,
        .topbar-right ul {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .topbar-left li,
        .topbar-right li {
            display: inline-flex !important;
            align-items: center !important;
            margin-right: 20px !important;
            color: rgb(254, 254, 254) !important;
            transition: color 0.3s ease !important;
        }

        .topbar-left li:last-child,
        .topbar-right li:last-child {
            margin-right: 0 !important;
        }

        /* ===== Icons ===== */
        .topbar i {
            color: rgb(246, 59, 59) !important;
            margin-right: 6px !important;
        }

        /* ===== Links ===== */
        .topbar a {
            color: rgb(255, 255, 255) !important;
            text-decoration: none !important;
            transition: color 0.3s ease !important;
        }

        .topbar a:hover {
            color: rgb(255, 104, 104) !important;
        }

        /* ===== Dropdown ===== */
        .topbar .dropdown-menu {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }

        .topbar .dropdown-item {
            color: #374151 !important;
            font-size: 14px !important;
        }

        .topbar .dropdown-item:hover {
            background: #f3f4f6 !important;
            color: rgb(246, 59, 59) !important;
        }

        /* ===== Responsive ===== */
        @media (max-width: 991px) {
            .topbar {
                text-align: center !important;
                padding: 10px 0 !important;
            }

            .topbar .container {
                flex-direction: column !important;
                gap: 5px !important;
            }

            .topbar-left li,
            .topbar-right li {
                margin-right: 10px !important;
                font-size: 13px !important;
            }
        }

        @media (max-width: 768px) {
            .media .fa-brands {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .media.fa-brands {
                display: none !important;
            }
        }

        .menu-links li {
            list-style: none;
            margin: 0 10px;
        }

        .menu-links a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            padding: 10px 0;
            transition: all 0.3s ease;
        }

        .menu-links a:hover,
        .menu-links .active a {
            color: #db2d2e;
        }

        .nav-link {
            color: #fff !important;
            padding: 10px 0 !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #db2d2e !important;
        }

        /* Logo sizing */
        /* Responsive styles */
        @media (max-width: 992px) {
            .menu-list-items .row {
                flex-direction: column;
            }

            .menu-logo {
                margin-bottom: 15px;
            }

            .menu-links {
                justify-content: center;
            }

            .menu-links li {
                margin: 5px 8px;
            }
        }

        @media (max-width: 768px) {
            .menu-links {
                flex-direction: column;
                align-items: flex-start;
                background-color: #323232 !important;
                /* Dark background for mobile menu */
                padding: 15px !important;
                border-radius: 5px;
                margin-top: 10px;
            }

            .menu-links li {
                margin: 8px 0;
                width: 100%;
            }

            .menu-links a {
                display: block;
                padding: 12px 15px !important;
                color: #fff !important;
                /* Ensure text is visible on dark background */
                border-radius: 3px;
            }

            .menu-links a:hover,
            .menu-links .active a {
                background-color: #db2d2e;
                color: #fff !important;
            }
        }

        /* Fix for mobile menu toggle */
        .menu-mobile-collapse-trigger {
            background: #323232 !important;
            display: none;
            /* Hidden by default on desktop */
            width: 30px;
            height: 30px;
            position: relative;
            cursor: pointer;
            margin-left: 15px;
            z-index: 1001;
            /* Ensure it's above other elements */
        }

        .menu-mobile-collapse-trigger span,
        .menu-mobile-collapse-trigger:before,
        .menu-mobile-collapse-trigger:after {
            background: #fff !important;
            height: 2px;
            width: 100%;
            display: block;
            position: absolute;
            left: 0;
            transition: all 0.3s ease;
        }

        .menu-mobile-collapse-trigger span {
            top: 50%;
            transform: translateY(-50%);
        }

        .menu-mobile-collapse-trigger:before {
            content: '';
            top: 8px;
        }

        .menu-mobile-collapse-trigger:after {
            content: '';
            bottom: 8px;
        }

        .menu-mobile-collapse-trigger.active span {
            opacity: 0;
        }

        .menu-mobile-collapse-trigger.active:before {
            transform: rotate(45deg);
            top: 50%;
        }

        .menu-mobile-collapse-trigger.active:after {
            transform: rotate(-45deg);
            bottom: 50%;
        }

        .menu {
            position: relative;
        }

        /* Mobile menu styles */
        @media (max-width: 991px) {
            .menu-mobile-collapse-trigger {
                display: block !important;
            }

            .menu-links {
                display: none !important;
                background: #323232 !important;
                width: 100% !important;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 1000 !important;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1) !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .menu-links.active {
                display: block !important;
            }

            .menu-links li {
                display: block !important;
                width: 100% !important;
                border-bottom: 1px solid #555 !important;
                margin: 0 !important;
                list-style: none !important;
            }

            .menu-links li:last-child {
                border-bottom: none !important;
            }

            .menu-links a {
                display: block !important;
                padding: 12px 15px !important;
                color: #fff !important;
                text-decoration: none !important;
                border-radius: 0 !important;
            }

            .menu-links a:hover,
            .menu-links .active a {
                background-color: #db2d2e !important;
                color: #fff !important;
            }

            /* Hide compare count badge on mobile menu items */
            .menu-links .badge {
                display: none !important;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Axios CSRF setup
        (function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (window.axios && token) {
                window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            }
        })();
    </script>
</head>

<body>
    <!--=================================
 header -->

    <header id="header" class="defualt mb-5">
        <div class="topbar">
            <div class="container"
                style="display: flex; align-items: center; justify-content: space-between !important;">
                <!-- Left side -->
                <div>
                    <div class="topbar-left text-lg-start text-center">
                        <ul class="list-inline mb-0" style="display: flex; align-items: center;">
                            <li class="list-inline-item">
                                <i class="fa-solid fa-envelope"></i> topmotor@gmail.com
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-phone"></i>0 780 480 980 / 072 806 3532
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right side -->
                <div>
                    <div class="topbar-right text-lg-end text-center">
                        <ul class="list-inline mb-0" style="display: flex; align-items: center;">
                            <!-- Language Switcher -->
                            <li class="list-inline-item">
                                <x-language-switcher />
                            </li>


                            <li class="list-inline-item media"><a href="#"><i
                                        class="fa-brands fa-facebook"></i></a>
                            </li>
                            <!-- <li class="list-inline-item"><a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                <li class="list-inline-item"><a href="#"><i
                                            class="fa-brands fa-instagram"></i></a></li> -->
                            <li class="list-inline-item media"><a href="#"><i
                                        class="fa-brands fa-youtube"></i></a>
                            </li>

                            <!-- Authentication -->
                            @guest
                                <li class="list-inline-item">
                                    <a href="{{ route('login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Register</a>
                                </li>
                            @endguest

                            @auth
                                <li class="list-inline-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-sign-out-alt"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>


                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!--=================================
    mega menu -->

        <div class="menu">
            <!-- menu start -->
            <nav id="menu" class="mega-menu">
                <!-- menu list items container -->
                <section class="menu-list-items">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-12 position-relative d-flex justify-content-between align-items-center">
                                <!-- menu logo -->
                                <ul class="menu-logo mb-0">
                                    <li>
                                        <a href="/"><img id="logo_img" class="logo"
                                                src="{{ asset('images/logo-light.png') }}" alt="logo"> </a>
                                    </li>
                                </ul>

                                <!-- Mobile menu toggle button -->
                                <div class="menu-mobile-collapse-trigger">
                                    <span></span>
                                </div>

                                <!-- Main menu for desktop -->
                                <ul class="menu-links d-flex flex-wrap mb-0" style="list-style: none;">
                                    <li class="{{ request()->routeIs('home.index') ? 'active' : '' }} mx-2">
                                        <a href="/home" class="nav-link">Home</a>
                                    </li>
                                    <!-- Car menu items -->
                                    <li class="{{ request()->routeIs('car.create') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('car.create') }}" class="nav-link">Car Register</a>
                                    </li>
                                    <li class="{{ request()->routeIs('car.index') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('car.index') }}" class="nav-link">Car Listing</a>
                                    </li>
                                    <li class="{{ request()->routeIs('car.rent') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('car.rent') }}" class="nav-link">Rent a Car</a>
                                    </li>
                                    <li class="{{ request()->routeIs('car.auction') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('car.auction') }}" class="nav-link">Car Auction</a>
                                    </li>
                                    <li class="{{ request()->routeIs('promotions.index') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('promotions.index') }}" class="nav-link">Promoted</a>
                                    </li>
                                    <li class="{{ request()->routeIs('user.profile') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('user.profile') }}" class="nav-link">Profile</a>
                                    </li>
                                    <li class="{{ request()->routeIs('car.compare') ? 'active' : '' }} mx-2">
                                        <a href="{{ route('car.compare') }}"
                                            class="nav-link position-relative text-decoration-none">
                                            <i class="fa fa-exchange-alt fa-lg"></i>
                                            <span id="compare-count"
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                style="font-size: 0.75rem; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                                0
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </nav>
            <!-- menu end -->
        </div>
    </header>

    <!--=================================
 header -->

    @yield('content')
    @stack('scripts')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to check if we're in bargain mode and show alert for bargain registration
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on the bargain registration page link
            const bargainRegisterLink = document.querySelector('a[href*="bargains/create"]');

            if (bargainRegisterLink) {
                bargainRegisterLink.addEventListener('click', function(e) {
                    // Check if we're in bargain mode by looking at localStorage or URL parameters
                    const currentProfileMode = localStorage.getItem('currentProfileMode');
                    const urlParams = new URLSearchParams(window.location.search);
                    const bargainId = urlParams.get('bargain_id');

                    // If in bargain mode, show SweetAlert
                    if (currentProfileMode === 'bargain' || bargainId) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Switch to User Profile?',
                            text: 'You are currently in bargain mode. To register a new bargain, please switch to user profile mode first.',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Switch to User Profile',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Switch to user profile mode with proper session handling and then redirect to bargain registration
                                fetch('/set-profile-mode', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                    body: JSON.stringify({
                                        mode: 'user'
                                    })
                                }).then(() => {
                                    // After successfully switching to user profile mode, redirect to bargain registration page
                                    window.location.href = '/bargains/create';
                                }).catch(error => {
                                    console.error('Error setting profile mode:', error);
                                    // Even if there's an error, still redirect to bargain registration page
                                    window.location.href = '/bargains/create';
                                });
                            }
                        });
                    }
                });
            }

            // Hide bargains dropdown when in bargain mode
            function updateNavbarForProfileMode() {
                const bargainsDropdown = document.getElementById('bargains-dropdown');
                if (!bargainsDropdown) return;

                const currentProfileMode = localStorage.getItem('currentProfileMode');
                const bargainId = localStorage.getItem('currentBargainId');

                if (currentProfileMode === 'bargain' && bargainId) {
                    // Hide bargains dropdown when in bargain mode
                    bargainsDropdown.style.display = 'none';
                } else {
                    // Show bargains dropdown when in user mode
                    bargainsDropdown.style.display = 'list-item';
                }
            }

            // Update navbar on page load
            updateNavbarForProfileMode();

            // Listen for storage changes (when switching profiles in other tabs)
            window.addEventListener('storage', function(e) {
                if (e.key === 'currentProfileMode' || e.key === 'currentBargainId') {
                    updateNavbarForProfileMode();
                }
            });

            // Also listen for custom events that might be dispatched when profile mode changes
            window.addEventListener('profileModeChanged', function(e) {
                setTimeout(updateNavbarForProfileMode, 100);
            });

            // Also check URL parameters on page load
            const urlParams1 = new URLSearchParams(window.location.search);
            const bargainIdFromUrl1 = urlParams1.get('bargain_id');
            if (bargainIdFromUrl1) {
                localStorage.setItem('currentProfileMode', 'bargain');
                localStorage.setItem('currentBargainId', bargainIdFromUrl1);
                updateNavbarForProfileMode();
            }

            // Check session data from server on page load
            // This handles cases where localStorage might be out of sync with server session
            fetch('/api/profile-mode')
                .then(response => response.json())
                .then(data => {
                    if (data.mode === 'bargain' && data.bargain_id) {
                        localStorage.setItem('currentProfileMode', 'bargain');
                        localStorage.setItem('currentBargainId', data.bargain_id);
                        updateNavbarForProfileMode();
                        // Also update the navbar switcher
                        setTimeout(initializeNavbarSwitcher, 100);
                    } else if (data.mode === 'user') {
                        localStorage.setItem('currentProfileMode', 'user');
                        localStorage.setItem('currentBargainId', null);
                        updateNavbarForProfileMode();
                        // Also update the navbar switcher
                        setTimeout(initializeNavbarSwitcher, 100);
                    }
                })
                .catch(error => {
                    console.log('Could not fetch profile mode from server, using localStorage');
                    // Still try to initialize the navbar switcher
                    setTimeout(initializeNavbarSwitcher, 100);
                });

            // Additional check to ensure bargains section is hidden when in bargain mode
            // This is a fallback in case the profile page doesn't properly hide it
            const urlParams2 = new URLSearchParams(window.location.search);
            const bargainIdFromUrl2 = urlParams2.get('bargain_id');
            if (bargainIdFromUrl2) {
                // Hide bargains dropdown when in bargain mode
                const bargainsDropdown = document.getElementById('bargains-dropdown');
                if (bargainsDropdown) {
                    bargainsDropdown.style.display = 'none';
                }
            }
        });
    </script>

    <!--=================================
 footer -->

    <footer class="footer bg-2 bg-overlay-black-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="social">
                        <ul>
                            <li><a class="facebook nav-link hover:text-gray-100" href="#">facebook <i
                                        class="fa-brands fa-facebook"></i> </a></li>
                            <li><a class="twitter nav-link hover:text-gray-100" href="#">twitter <i
                                        class="fa-brands fa-twitter"></i> </a></li>
                            <!-- <li><a class="pinterest nav-link hover:text-gray-100" href="#">pinterest <i
                                        class="fa-brands fa-pinterest-p"></i> </a></li> -->
                            <!-- <li><a class="google-plus nav-link hover:text-gray-100" href="#">google plus <i
                                        class="fa-brands fa-google-plus"></i> </a></li> -->
                            <li><a class="behance nav-link hover:text-gray-100" href="#">behance <i
                                        class="fa-brands fa-behance"></i> </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row flex justify-content-between ">
                <div class="col-lg-3 col-md-6">
                    <div class="about-content">
                        <img class="img-fluid" id="logo-footer" src="{{ asset('images/logo-light.png') }}"
                            alt="">
                        <p>We provide everything you need to build an amazing dealership website developed especially
                            for car sellers dealers or auto motor retailers.</p>
                    </div>
                    <div class="address">
                        <ul>
                            <li> <i class="fa fa-map-marker"></i><span>Kart-e-Mamorin, Khushal khan Mena, Kabul,
                                    Afghanistan</span> </li>
                            <li> <i class="fa fa-phone"></i><span>0 780 480 980 / 072 806 3532 </span> </li>
                            <li> <i class="fa-solid fa-envelope"></i><span>topmotor@gmail.com</span> </li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-6">
                    <div class="usefull-link">
                        <h6 class="text-white">Useful Links</h6>
                        <ul>
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Change Oil and Filter</a>
                            </li>
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Brake Pads Replacement</a>
                            </li>
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Timing Belt Replacement</a>
                            </li>
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Pre-purchase Car
                                    Inspection</a></li>
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Starter Replacement</a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <div class="col-lg-3 col-md-6">
                    <div class="recent-post-block">
                        <h6 class="text-white">recent posts </h6>
                        <div class="recent-post">
                            <!-- Started here -->
                            @php
                                $cars = App\Models\Car::all()->take(3);
                            @endphp
                            @foreach ($cars as $car)
                                <div class="recent-post">
                                    <div class="recent-post-image">
                                        @if (!empty($car->images) && is_array($car->images) && isset($car->images[0]))
                                            <img class="img-fluid" src="{{ asset('storage/' . $car->images[0]) }}"
                                                alt="{{ $car->title }}">
                                        @else
                                            <img class="img-fluid" src="{{ asset('images/demo.jpg') }}"
                                                alt="Default car image">
                                        @endif
                                    </div>
                                    <div class=" recent-post-info">
                                        <a href="#">{{ $car->title }} </a>
                                        <span class="post-date"><i class="fa fa-calendar"></i>
                                            {{ Carbon\Carbon::parse($car->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                            <!-- End here -->
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="news-letter text-white">
                        <h6 class="text-white">subscribe Our Newsletter </h6>
                        <p>Keep up on our always evolving products features and technology. Enter your e-mail and
                            subscribe to our newsletter.</p>
                        <form id="email_form" class="news-letter">
                            @csrf
                            <input type="email" id="email" name="email" placeholder="Enter your Email"
                                style="background-color: aliceblue;" class="form-control placeholder" required
                                value="{{ auth()->check() ? auth()->user()->email : '' }}">
                            <button class="button red mt-2" type="submit"
                                id="make_an_email_submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr />
            <div class="copyright">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="text-lg-start text-center">
                            <p style="color: aliceblue;">©Copyright 2021 Car Dealer Developed by <a
                                    href="http://www.motorsaal.com/" target="_blank">Top Motor</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <ul class="list-inline text-lg-end text-center">
                            <li><a href="{{ route('privacy.policy') }}">privacy policy </a> | </li>
                            <li><a href="{{ route('terms.conditions') }}">terms and conditions </a> |</li>
                            <li><a href="{{ route('contact.us') }}">contact us </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--=================================
 footer -->

    <!--=================================
 back to top -->

    <div class="car-top">
        <span><img src="{{ asset('images/car.png') }}" alt=""></span>
    </div>

    <!--=================================
 jquery -->

    <!-- jquery  -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/popper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- mega-menu -->
    <script type="text/javascript" src="{{ asset('js/mega-menu/mega_menu.js') }}"></script>

    <!-- appear -->
    <script type="text/javascript" src="{{ asset('js/jquery.appear.js') }}"></script>

    <!-- counter -->
    <script type="text/javascript" src="{{ asset('js/counter/jquery.countTo.js') }}"></script>

    <!-- owl-carousel -->
    <script type="text/javascript" src="{{ asset('js/owl-carousel/owl.carousel.min.js') }}"></script>

    <!-- select -->
    <script type="text/javascript" src="{{ asset('js/select/jquery-select.js') }}"></script>

    <!-- magnific popup -->
    <script type="text/javascript" src="{{ asset('js/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- revolution -->
    <script type="text/javascript" src="{{ asset('revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.actions.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.carousel.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.kenburn.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.migration.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.navigation.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.parallax.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.slideanims.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.video.min.js') }}">
    </script>
    <!-- Custom JS -->
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>

    <!-- Slick JS (Add this!) -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script type="text/javascript">
        (function($) {
            "use strict";

            var tpj = jQuery;
            var revapi2;
            tpj(document).ready(function() {
                if (tpj("#rev_slider_2_1").revolution == undefined) {
                    revslider_showDoubleJqueryError("#rev_slider_2_1");
                } else {
                    revapi2 = tpj("#rev_slider_2_1").show().revolution({
                        sliderType: "standard",
                        sliderLayout: "fullwidth",
                        dottedOverlay: "none",
                        delay: 9000,
                        navigation: {
                            keyboardNavigation: "off",
                            keyboard_direction: "horizontal",
                            mouseScrollNavigation: "off",
                            mouseScrollReverse: "default",
                            onHoverStop: "off",
                            bullets: {
                                enable: true,
                                hide_onmobile: false,
                                style: "hermes",
                                hide_onleave: false,
                                direction: "horizontal",
                                h_align: "center",
                                v_align: "bottom",
                                h_offset: 0,
                                v_offset: 50,
                                space: 10,
                                tmp: ''
                            }
                        },
                        visibilityLevels: [1240, 1024, 778, 480],
                        gridwidth: 1570,
                        gridheight: 1000,
                        lazyType: "none",
                        shadow: 0,
                        spinner: "spinner3",
                        stopLoop: "off",
                        stopAfterLoops: -1,
                        stopAtSlide: -1,
                        shuffle: "off",
                        autoHeight: "off",
                        disableProgressBar: "on",
                        hideThumbsOnMobile: "off",
                        hideSliderAtLimit: 0,
                        hideCaptionAtLimit: 0,
                        hideAllCaptionAtLilmit: 0,
                        debugMode: false,
                        fallbacks: {
                            simplifyAll: "off",
                            nextSlideOnWindowFocus: "off",
                            disableFocusListener: false,
                        }
                    });
                }
            });
        })(jQuery);

        // this function will update all the count dynamically
        function updateNavbarCompareCount() {
            const countEl = document.getElementById('compare-count');
            if (!countEl) return;

            const stored = localStorage.getItem('compareCars');
            if (!stored) {
                countEl.innerText = '0';
                return;
            }

            try {
                const data = JSON.parse(stored);
                // Check if data has expired (5 minutes)
                if (data.timestamp && (Date.now() - data.timestamp) > 5 * 60 * 1000) {
                    localStorage.removeItem('compareCars');
                    countEl.innerText = '0';
                    return;
                }
                countEl.innerText = (data.cars || []).length;
            } catch (e) {
                countEl.innerText = '0';
            }
        }

        // Update count on page load
        document.addEventListener('DOMContentLoaded', updateNavbarCompareCount);

        // Update count every minute to check for expiration
        setInterval(updateNavbarCompareCount, 60000);

        $(document).ready(function() {
            $('#make_an_email_submit').on('click', function(e) {
                e.preventDefault();

                var formData = {
                    email: $('#email').val(),
                };

                console.log('Form data:', formData);

                $.ajax({
                    type: 'POST',
                    url: '/email',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        console.log('Sending AJAX request...');
                    },
                    success: function(response) {
                        console.log('Success response received:', response);

                        // Check if the response indicates success
                        if (response && response.success === true) {
                            console.log('Email submitted successfully');
                            $('#email_form')[0].reset();

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message ||
                                    'Email submitted successfully!',
                                timer: 3000,
                                showConfirmButton: false,
                                heightAuto: false,
                            });

                        } else {
                            console.log('Server returned success=false');
                            // Handle case where response.success is false
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message ||
                                    'Something went wrong. Please try again.',
                                heightAuto: false
                            });
                        }
                    },
                });
            });

            // Remove mega menu initialization to prevent conflicts
            /*
            try {
                $('#menu').megaMenu({
                    mobile_settings: {
                        collapse: true,
                        sibling: true,
                        scrollBar: true,
                        scrollBar_height: 400,
                        top_fixed: false,
                        sticky_header: false,
                        sticky_header_height: 200
                    }
                });
            } catch (e) {
                console.log('Mega menu initialization failed:', e);
            }
            */

            // Completely rewrite mobile menu functionality - simple and reliable
            function initMobileMenu() {
                console.log('Initializing mobile menu');

                // Ensure only one mobile trigger exists
                if ($('.menu-mobile-collapse-trigger').length > 1) {
                    $('.menu-mobile-collapse-trigger').not(':first').remove();
                    console.log('Removed duplicate triggers');
                }

                // Simple click handler without event delegation issues
                $('.menu-mobile-collapse-trigger').off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Mobile menu trigger clicked');

                    // Toggle classes
                    $(this).toggleClass('active');

                    // Show/hide menu with explicit display control
                    if ($(this).hasClass('active')) {
                        $('.menu-links').addClass('active').css('display', 'block');
                        console.log('Menu shown');
                    } else {
                        $('.menu-links').removeClass('active').css('display', 'none');
                        console.log('Menu hidden');
                    }
                });

                // Close menu when clicking outside
                $(document).off('click.mobileMenuClose').on('click.mobileMenuClose', function(e) {
                    if (!$(e.target).closest('.menu-mobile-collapse-trigger').length &&
                        !$(e.target).closest('.menu-links').length &&
                        $('.menu-mobile-collapse-trigger').hasClass('active')) {
                        $('.menu-mobile-collapse-trigger').removeClass('active');
                        $('.menu-links').removeClass('active').css('display', 'none');
                        console.log('Menu closed by clicking outside');
                    }
                });

                // Handle window resize
                $(window).off('resize.mobileMenu').on('resize.mobileMenu', function() {
                    if ($(window).width() > 991) {
                        // Desktop view - always show menu
                        $('.menu-mobile-collapse-trigger').removeClass('active');
                        $('.menu-links').removeClass('active').css('display', 'flex');
                    } else {
                        // Mobile view - hide menu by default
                        $('.menu-links').css('display', 'none');
                    }
                });

                console.log('Mobile menu initialization complete');
            }

            // Initialize on document ready
            initMobileMenu();

            // Also initialize after a small delay to ensure DOM is fully loaded
            setTimeout(initMobileMenu, 100);
        });

        // Initialize Fancybox for video playback

        // Newsletter subscription handling
        $(document).ready(function() {
            $('#email_form').on('submit', function(e) {
                e.preventDefault();

                var email = $('#email').val();
                var submitBtn = $('#make_an_email_submit');

                // Basic email validation
                if (!email || !isValidEmail(email)) {
                    Swal.fire({
                        title: 'Invalid Email',
                        text: 'Please enter a valid email address.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Disable submit button and show loading
                submitBtn.prop('disabled', true).text('Subscribing...');

                // Send AJAX request
                $.ajax({
                    url: '{{ route('email.store') }}',
                    method: 'POST',
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#email').val(''); // Clear the form
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        var message = response && response.message ? response.message :
                            'An error occurred. Please try again.';

                        Swal.fire({
                            title: 'Error',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function() {
                        // Re-enable submit button
                        submitBtn.prop('disabled', false).text('Subscribe');
                    }
                });
            });
        });

        // Email validation function
        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>

</html>
