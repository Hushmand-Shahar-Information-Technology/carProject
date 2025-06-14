<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themes.potenzaglobalsolutions.com/html/cardealer/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 May 2025 11:17:54 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
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
    {{--
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" /> --}}

    <!-- owl-carousel -->
    <link rel="stylesheet" href="{{ asset('css/owl-carousel/owl.carousel.css') }}" />
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup/dist/magnific-popup.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Magnific Popup JS -->
    <script src="https://cdn.jsdelivr.net/npm/magnific-popup/dist/jquery.magnific-popup.min.js"></script>

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


</head>

<body>
    <!--=================================
 header -->

    <header id="header" class="defualt"> 
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="topbar-left text-lg-start text-center">
                            <ul class="list-inline">
                                <li> <i class="fa-solid fa-envelope"> </i> support@motarsal.com</li>



                                <li> <i class="fa-solid fa-clock"></i> Mon - Sat 8.00 - 18.00. Fridy CLOSED</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="topbar-right text-lg-end text-center">
                            <ul class="list-inline">
                                <li> <i class="fa fa-phone"></i> 077 9600 2750 / 072 806 3532 </li>
                                <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
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
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 position-relative">
                                <!-- menu logo -->
                                <ul class="menu-logo">
                                    <li>
                                        <a href="{{ route('home.index') }}"><img id="logo_img"
                                                src="{{ asset('images/logo-light.png') }}" alt="logo"> </a>
                                    </li>
                                </ul>
                                <ul class="menu-links">
                                    <li class="active"><a href="{{route("home.index")}}">Home </a></li>
                                    <li><a href="{{ route('car.index') }}">Car listing </a></li>
                                    <li><a href="javascript:void(0)"> Contact </a></li>
                                    <a href="{{ route('send.product.message', ['user_id' => 1, 'car_id' => 4]) }}"
                                        class="btn btn-primary">
                                        Chat Now
                                    </a>

                                    <li><a href="{{route('car.directory')}}">Car directory</a></li>
                                    <li><a href="{{route('car.create')}}">Car Register</a></li>
                                    <li>
                                        <div class="search-top">
                                            <a class="search-btn not_click d-none d-lg-block"
                                                href="javascript:void(0);">
                                                <i class="fa-solid fa-search"></i>
                                            </a>
                                            <div class="search-box not-click">
                                              <form id="searchForm" action="{{ route('car.index') }}" method="GET">
                                                <div class="row">
                                                    @php
                                                        $years = range(1990, now()->year);
                                                    @endphp
                                                    <x-search-option name="Make[]" label="Make" :options="$distinctValues['make']" />
                                                    <x-search-option name="Model[]" label="Models" :options="$distinctValues['models']" />
                                                    <x-search-option name="Year[]" label="Years" :options="$years" />
                                                    <x-search-option name="Body[]" label="Body Styles" :options="$distinctValues['body_type']" />
                                                    <x-search-option name="Color[]" label="Color" :options="$distinctValues['colors']" />
                                                    {{-- <x-search-option name="Condition[]" label="Vehicle Status" :options="$distinctValues['car_condition']" /> --}}
                                                    <div class="col-xl-2 col-md-4 col-sm-6">
                                                        <div class="text-center">
                                                            <button class="button red" type="submit">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                              </form>    
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{route('user.profile')}}">profile</a>
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

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="about-content">
                        <img class="img-fluid" id="logo-footer" src="{{ asset('images/logo-light.png') }}" alt="">
                        <p>We provide everything you need to build an amazing dealership website developed especially
                            for car sellers dealers or auto motor retailers.</p>
                    </div>
                    <div class="address">
                        <ul>
                            <li> <i class="fa fa-map-marker"></i><span>220E Front St. Burlington NC 27215</span> </li>
                            <li> <i class="fa fa-phone"></i><span>077 9600 2750 / 072 806 3532 </span> </li>
                            <li> <i class="fa-solid fa-envelope"></i><span>support@motarsal.com</span> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
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
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="recent-post-block">
                        <h6 class="text-white">recent posts </h6>
                        <div class="recent-post">
                            <!-- Started here -->
                            @php
                                $cars = App\Models\Car::all()->take(3);
                            @endphp
                            @foreach($cars as $car)
                                <div class="recent-post">
                                    <div class="recent-post-image">
                                        <img class="img-fluid" src="{{  '/' . $car->images[0] }}" alt="{{ $car->title }}">
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
                    <div class="news-letter">
                        <h6 class="text-white">subscribe Our Newsletter </h6>
                        <p>Keep up on our always evolving products features and technology. Enter your e-mail and
                            subscribe to our newsletter.</p>
                        <form class="news-letter">
                            <input type="email" placeholder="Enter your Email" class="form-control placeholder">
                            <a class="button red" href="#">Subscribe</a>
                        </form>
                    </div>
                </div>
            </div>
            <hr />
            <div class="copyright">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="text-lg-start text-center">
                            <p>©Copyright 2021 Car Dealer Developed by <a href="http://www.motorsaal.com/"
                                    target="_blank">Motor Saal</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <ul class="list-inline text-lg-end text-center">
                            <li><a href="#">privacy policy </a> | </li>
                            <li><a href="#">terms and conditions </a> |</li>
                            <li><a href="#">contact us </a></li>
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
    {{--
    <script type="text/javascript" src="{{ asset('js/select/jquery-select.js') }}"></script> --}}

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
        (function ($) {
            "use strict";

            var tpj = jQuery;
            var revapi2;
            tpj(document).ready(function () {
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
    </script>
</body>

</html>
