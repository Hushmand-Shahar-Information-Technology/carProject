@extends('layouts.layout')
@section('title', 'Home Page')
@section('content')


    <style>
        /* Modal Overlay (full screen, centered) */
        .modal-overlay {
            display: none;
            /* default hidden to avoid flash */
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1050;
            justify-content: center;
            align-items: center;
        }

        /* Visible state for modal */
        .modal-overlay.is-open {
            display: flex;
        }

        /* Modal Content */
        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px 25px;
            max-width: 700px;
            width: 90vw;
            position: relative;
            /* box-shadow: 0 12px 30px rgba(0,0,0,0.2); */
        }

        .body-div {
            /* background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%); */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }


        .containerw {
            max-width: 700px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            padding: 40px 35px;
            position: relative;
        }

        /* Close Button */
        .close-modal {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 28px;
            border: none;
            background: transparent;
            cursor: pointer;
            color: #333;
            font-weight: bold;
        }

        .container-width1 {
            width: 80% !important;
        }

        @media (max-width: 790px) {
            .container-width1 {
                width: 70% !important;
            }
        }

        /* Our Stocks section styling - same as car listing */
        #carListContainer .fixed-img {
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            border-radius: 8px;
        }

        #carListContainer .car-image {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        #carListContainer .car-image:hover .fixed-img {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Responsive spacing for car items */
        #carListContainer .car-item {
            margin-bottom: 20px;
        }

        /* Mobile devices - more spacing */
        @media (max-width: 576px) {
            #carListContainer .car-item {
                margin-bottom: 30px;
            }
        }

        /* Small tablets */
        @media (max-width: 768px) {
            #carListContainer .car-item {
                margin-bottom: 25px;
            }
        }

        /* Hero section styles */
        .hero-section {
            min-height: 900px;
        }

        .service-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .card-img-container {
            transition: all 0.3s ease;
        }

        .card-img-container:hover {
            transform: scale(1.05);
        }

        .card-img-container:hover .hover-overlay {
            opacity: 1 !important;
        }

        .transition-opacity {
            transition: opacity 0.3s ease;
        }

        .hero-content h1 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Hero background slider */
        .hero-background-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-background-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .hero-background-slide.active {
            opacity: 1;
        }

        .hero-background-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-background-slide .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        /* Slider indicators */
        .hero-slider-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .hero-slider-indicators .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hero-slider-indicators .indicator.active {
            background-color: #fff;
        }
    </style>
    <!--=================================
                                                                hero section -->
    <section class="hero-section position-relative overflow-hidden " style="min-height: 900px; padding-top: 8rem;">
        <div class="hero-background-slider">
            <div class="hero-background-slide active">
                <img src="{{ asset('images/bg/01.jpg') }}" alt="TopMotor Hero 1">
                <div class="overlay"></div>
            </div>
            <div class="hero-background-slide">
                <img src="{{ asset('images/bg/02.jpg') }}" alt="TopMotor Hero 2">
                <div class="overlay"></div>
            </div>
            <div class="hero-background-slide">
                <img src="{{ asset('images/bg/03.jpg') }}" alt="TopMotor Hero 3">
                <div class="overlay"></div>
            </div>
            <div class="hero-background-slide">
                <img src="{{ asset('images/bg/04.jpg') }}" alt="TopMotor Hero 4">
                <div class="overlay"></div>
            </div>
            <div class="hero-background-slide">
                <img src="{{ asset('images/bg/05.jpg') }}" alt="TopMotor Hero 5">
                <div class="overlay"></div>
            </div>
        </div>

        <div class="hero-slider-indicators">
            <div class="indicator active" data-slide="0"></div>
            <div class="indicator" data-slide="1"></div>
            <div class="indicator" data-slide="2"></div>
            <div class="indicator" data-slide="3"></div>
            <div class="indicator" data-slide="4"></div>
        </div>

        <div class="container position-relative h-100 d-flex align-items-center" style="z-index: 2;">
            <div class="row w-100 align-items-center">
                <!-- Hero Text - Left Side -->
                <div class="col-lg-6">
                    <div class="hero-content text-white py-5 animate__animated animate__fadeInLeft">
                        <h1 class="display-2 fw-bold mb-4">TOP<span class="text-danger">MOTOR</span></h1>
                        <p class="lead fs-3 mb-4">Your Ultimate Destination for Premium Vehicles</p>
                        <p class="fs-5 mb-5">Discover the finest selection of cars, from luxury sedans to rugged SUVs.
                            Experience unmatched quality and service at TopMotor.</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('car.index') }}" class="btn btn-danger btn-lg px-5 py-3 rounded-pill">Explore
                                Cars</a>
                            <a href="{{ route('car.create') }}"
                                class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">Sell Your Car</a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links Cards - Right Side -->
                <div class="col-lg-6">
                    <div class="quick-links-section py-4">
                        <div class="row g-3">
                            <!-- Card 1 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/01.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Rent Car">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('car.rent') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Rent Car</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-1s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/02.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Auction">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('car.auction') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Auction</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-2s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/03.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Bargain List">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('bargains.index') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Bargain List</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-3s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/04.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Promote">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('promotions.index') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Promote</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 5 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-4s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/05.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Directory">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('car.directory') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Directory</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 6 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-5s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/06.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Listing">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('car.index') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Listing</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 7 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-6s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/07.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Register">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('car.create') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Register</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 8 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-7s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/08.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Profile">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('user.profile') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Profile</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 9 -->
                            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp animate__delay-8s">
                                <div class="card h-100 border-0 service-card">
                                    <div class="card-img-container position-relative overflow-hidden"
                                        style="height: 150px;">
                                        <img src="{{ asset('images/car/09.jpg') }}"
                                            class="card-img w-100 h-100 object-fit-cover" alt="Compare">
                                        <div
                                            class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-75 opacity-0 hover-overlay transition-opacity">
                                            <a href="{{ route('car.compare') }}"
                                                class="text-white text-decoration-none stretched-link">
                                                <h5 class="mb-0 fw-bold">Compare</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                                                hero section -->
    @include('components.feature-car', [
        'promotedCars' => $promotedCars ?? [],
        'latestCars' => $latestCars ?? [],
    ])

    <!--================================= -->
    {{-- Car list cart --}}
    <div class="col-md-12">
        <div class="section-title mb-4 pb-0">
            {{-- <span>Welcome to our website</span> --}}
            <h2>Our Stocks</h2>
            <div class="separator"></div>
        </div>
        <div class="container border row p-5 mb-5 mx-auto" id="carListContainer">
        </div>
    </div>



    <!--=================================
                                                                                                                                                                     play-video -->

    <section class="play-video popup-gallery">
        <div class="p-5 bg-3 bg-overlay-black-70">
            <div class="row justify-content-center">
                <h3 class="text-white text-center mt-0 mb-5">Bargains Section Features</h3>
            </div>

            <div class="container container-width1 mb-0" style="width: 80%;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme" data-nav-arrow="true" data-items="4" data-md-items="4"
                            data-sm-items="2" data-xs-items="1" data-space="20">
                            <div class="item">
                                <div class="car-item text-center">
                                    <div class="car-image">
                                        <img class="img-fluid" src="{{ asset('images/car/01.jpg') }}" alt="">
                                        <div class="car-overlay-banner">
                                            <ul>show
                                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                                                <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="car-list">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-registered"></i> 2021</li>
                                            <li><i class="fa fa-cog"></i> Manual </li>
                                            <li><i class="fa fa-dashboard"></i> 6,000 mi</li>
                                        </ul>
                                    </div>
                                    <div class="car-content">
                                        <div class="star">
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star-o orange-color"></i>
                                        </div>
                                        <a href="#" style="font-size: 12px;">Acura Rsx</a>
                                        <div class="separator"></div>
                                        <div class="price">
                                            <span class="old-price" style="font-size: 10px;">$35,568</span>
                                            <span class="new-price" style="font-size: 10px;">$32,698 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="car-item text-center">
                                    <div class="car-image">
                                        <img class="img-fluid" src="{{ asset('images/car/02.jpg') }}" alt="">
                                        <div class="car-overlay-banner">
                                            <ul>
                                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                                                <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="car-list">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-registered"></i> 2021</li>
                                            <li><i class="fa fa-cog"></i> Manual </li>
                                            <li><i class="fa fa-dashboard"></i> 6,000 mi</li>
                                        </ul>
                                    </div>
                                    <div class="car-content">
                                        <div class="star">
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star-o orange-color"></i>
                                        </div>
                                        <a href="#" style="font-size: 12px;">Lexus GS 450h</a>
                                        <div class="separator"></div>
                                        <div class="price">
                                            <span class="old-price" style="font-size: 10px;">$35,568</span>
                                            <span class="new-price" style="font-size: 10px;">$32,698 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="car-item text-center">
                                    <div class="car-image">
                                        <img class="img-fluid" src="{{ asset('images/car/03.jpg') }}" alt="">
                                        <div class="car-overlay-banner">
                                            <ul>
                                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                                                <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="car-list">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-registered"></i> 2021</li>
                                            <li><i class="fa fa-cog"></i> Manual </li>
                                            <li><i class="fa fa-dashboard"></i> 6,000 mi</li>
                                        </ul>
                                    </div>
                                    <div class="car-content">
                                        <div class="star">
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star-o orange-color"></i>
                                        </div>
                                        <a href="#" style="font-size: 12px;">GTA 5 Lowriders DLC</a>
                                        <div class="separator"></div>
                                        <div class="price">
                                            <span class="old-price" style="font-size: 10px;">$35,568</span>
                                            <span class="new-price" style="font-size: 10px;">$32,698 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="car-item text-center">
                                    <div class="car-image">
                                        <img class="img-fluid" src="{{ asset('images/car/04.jpg') }}" alt="">
                                        <div class="car-overlay-banner">
                                            <ul>
                                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                                                <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="car-list">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-registered"></i> 2021</li>
                                            <li><i class="fa fa-cog"></i> Manual </li>
                                            <li><i class="fa fa-dashboard"></i> 6,000 mi</li>
                                        </ul>
                                    </div>
                                    <div class="car-content">
                                        <div class="star">
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star-o orange-color"></i>
                                        </div>
                                        <a href="#" style="font-size: 12px;">Toyota avalon hybrid </a>
                                        <div class="separator"></div>
                                        <div class="price">
                                            <span class="old-price" style="font-size: 10px;">$35,568</span>
                                            <span class="new-price" style="font-size: 10px;">$32,698 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="car-item text-center">
                                    <div class="car-image">
                                        <img class="img-fluid" src="{{ asset('images/car/05.jpg') }}" alt="">
                                        <div class="car-overlay-banner">
                                            <ul>
                                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                                                <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="car-list">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-registered"></i> 2021</li>
                                            <li><i class="fa fa-cog"></i> Manual </li>
                                            <li><i class="fa fa-dashboard"></i> 6,000 mi</li>
                                        </ul>
                                    </div>
                                    <div class="car-content">
                                        <div class="star">
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star-o orange-color"></i>
                                        </div>
                                        <a href="#" style="font-size: 12px;">Hyundai santa fe sport </a>
                                        <div class="separator"></div>
                                        <div class="price">
                                            <span class="old-price" style="font-size: 10px;">$35,568</span>
                                            <span class="new-price" style="font-size: 10px;">$32,698 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!--=================================
                                                                                                                                                                                                     play-video -->


    <!-- =================================
                                                                                                                                                                                                          welcome -->

    {{-- <section class="welcome-block objects-car page-section-ptb white-bg" style="padding-top: 0px ;">
        <div class="objects-left left"><img class="img-fluid objects-1" src="{{ asset('images/objects/01.jpg') }}"
                alt=""></div>
        <div class="objects-right right"><img class="img-fluid objects-2" src="{{ asset('images/objects/02.jpg') }}"
                alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <span>Welcome to our website</span>
                        <h2>Dealeractive</h2>
                        <div class="separator"></div>
                        <p>Car Dealer is the best premium HTML5 Template. We provide everything you need to build an
                            <strong>Amazing dealership website</strong> developed especially for car sellers, dealers or
                            auto motor retailers. You can use this template for creating website based on any framework and
                            any language.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box text-center">
                        <div class="icon">
                            <i class="glyph-icon flaticon-beetle"></i>
                        </div>
                        <div class="content">
                            <h6>All brands</h6>
                            <p>Galley simply dummy text lorem Ipsum is of the printin k a of type and</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box text-center">
                        <div class="icon">
                            <i class="glyph-icon flaticon-interface-1"></i>
                        </div>
                        <div class="content">
                            <h6>Free Support</h6>
                            <p>Text of the printin lorem ipsum the is simply k a type text and galley of</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box text-center">
                        <div class="icon">
                            <i class="glyph-icon flaticon-key"></i>
                        </div>
                        <div class="content">
                            <h6>Dealership</h6>
                            <p>Printin k a of type and lorem Ipsum is simply dummy text of the galley </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box text-center">
                        <div class="icon">
                            <i class="glyph-icon flaticon-wallet"></i>
                        </div>
                        <div class="content">
                            <h6>affordable</h6>
                            <p>The printin k a galley Lorem Ipsum is type and simply dummy text of</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="halp-call text-center">
                        <img class="img-fluid" src="{{ asset('images/team/01.jpg') }}" alt="">
                        <span>Have any question ?</span>
                        <h2 class="text-red">(007) 123 456 7890</h2>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!--=================================
                                                                                                                                                                                                         welcome -->


    <!-- ==================================
                                                                                                                                                                                                         {{-- feature car -->
<!-- @include('components.feature-car') --}} -->

    <!--=================================
                                                                                                                                                                                                         feature car -->



    <!--=================================
                                                                                                                                                                                                         custom block -->

    <section class="bg-7">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 col-md-12">
                </div>
                <div class="col-lg-6 col-md-12 gray-bg text-center">
                    <div class="custom-block-1">
                        <h2>boxster</h2>
                        <span>Get the Porsche You always Wanted </span>
                        <strong class="text-red">$450 </strong>
                        <span>per month </span>
                        <p>Limited time Offer!</p>
                        <a href="#"> read more </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                                                                                                                                                                                         custom block -->


    <!--=================================
                                                                                                                                                                                                         latest news -->

    <section class="latest-blog objects-car white-bg page page-section-ptb">
        <div class="objects-left"><img class="img-fluid objects-1" src="{{ asset('images/objects/03.jpg') }}"
                alt=""></div>
        <div class="objects-right"><img class="img-fluid objects-2" src="{{ asset('images/objects/04.jpg') }}"
                alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <span>Read our latest news</span>
                        <h2>Latest News </h2>
                        <div class="separator"></div>
                    </div>
                </div>
            </div>
            <div class="blog-1">
                <div class="row">
                    <div class="col-md-6">
                        <img class="img-fluid" src="{{ asset('images/blog/01.jpg') }}" alt="">
                    </div>
                    <div class="col-md-6">
                        <div class="blog-content">
                            <a class="link" href="#">Porsche 911 is text of the printin a galley of type and bled
                                it to make a type specimen book. </a>
                            <span class="uppercase">November 29, 2021 | <strong class="text-red">post by john doe
                                </strong></span>
                            <p>Sed do eiusmod tempor lorem ipsum dolor sit amet, consectetur adipisicing elit, incididunt ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa </p>
                            <a class="button border" href="#">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                                                                                                                                                                                         latest news -->


    <!--=================================
                                                                                                                                                                                                         play-video -->

    <section class="play-video popup-gallery">
        <div class="play-video-bg bg-3 bg-overlay-black-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-12 text-center">
                        <h3 class="text-white">Want to know more about us? Play our promotional video now!</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="video-info text-center">
                        <img class="img-fluid center-block" src="{{ asset('images/car/24.jpg') }}" alt="">
                        <a class="popup-youtube" href="https://www.youtube.com/watch?v=Xd0Ok-MkqoE"> <i
                                class="fa fa-play"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                                                                                                                                                                                         play-video -->


    <!--=================================
                                                                                                                                                                                                         Counter -->

    <section class="counter counter-style-1 light page-section-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6 text-center">
                    <div class="counter-block">
                        <i class="glyph-icon flaticon-beetle"></i>
                        <h6 class="text-black">Vehicles In Stock </h6>
                        <b class="timer" data-to="3968" data-speed="10000"></b>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 text-center">
                    <div class="counter-block">
                        <i class="glyph-icon flaticon-interface"></i>
                        <h6 class="text-black">Dealer Reviews</h6>
                        <b class="timer" data-to="5568" data-speed="10000"></b>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 text-center">
                    <div class="counter-block mb-4 mb-sm-0">
                        <i class="glyph-icon flaticon-circle"></i>
                        <h6 class="text-black">Happy Customer</h6>
                        <b class="timer" data-to="8908" data-speed="10000"></b>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 text-center">
                    <div class="counter-block mb-0">
                        <i class="glyph-icon flaticon-cup"></i>
                        <h6 class="text-black">Awards</h6>
                        <b class="timer" data-to="9968" data-speed="10000"></b>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=================================
                                                                                                                                                                                                         Counter -->

    <hr class="gray">

    <!--=================================
                                                                                                                                                                                                         testimonial -->

    @include('components.testimonial')
    <!--=================================
                                                                                                                                                                                                         testimonial -->


    <!-- Modal code goes here -->
    <div id="wizardModal" class="modal-overlay">
        <div class="modal-content">
            <div class="body-div">
                <div class="containerw">
                    <button class="close-modal btn btn-sm btn-danger position-absolute m-2">&times;</button>
                    @include('home.wizard')
                </div>
            </div>
        </div>
    </div>

    <!-- Your JS scripts here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            const $modal = $('#wizardModal');
            const $mainContent = $('#mainContent');
            const savedAnswers = JSON.parse(localStorage.getItem("carSurveyAnswers"));
            let currentStep = 1;
            let filtersAlreadyApplied = false;

            const totalSteps = $(".tab-pane").length;

            function showModal() {
                $modal.addClass('is-open');
                $mainContent.addClass('blurred');
            }

            function hideModal() {
                $modal.removeClass('is-open');
                $mainContent.removeClass('blurred');
            }

            function showStep(step) {
                const targetTab = $(`#step${step}`);
                if (targetTab.length) {
                    const tabTrigger = $(`a[data-bs-target="#step${step}"]`);
                    if (tabTrigger.length) {
                        new bootstrap.Tab(tabTrigger[0]).show();
                    } else {
                        $(".tab-pane").removeClass("active show");
                        targetTab.addClass("active show");
                    }
                    currentStep = step;
                }
            }

            function collectAnswers() {
                const answers = {};
                $(".tab-pane input:checked").each(function() {
                    const name = $(this).attr("name");
                    const value = $(this).val();
                    if (!answers[name]) {
                        answers[name] = [];
                    }
                    answers[name].push(value);
                });
                return answers;
            }

            function renderCarList(cars) {
                const $container = $('#carListContainer');
                $container.empty();

                if (cars.length === 0) {
                    $container.append('<p>No cars found matching your criteria.</p>');
                    return;
                }

                const car_show = "{{ route('car.show', ['id' => '__ID__']) }}";

                cars.forEach(car => {
                    const url = car_show.replace('__ID__', car.id);
                    const carHtml = `
          <div class="col-lg-3 col-sm-4 col-md-5">
            <div class="car-item gray-bg text-center">
              <div class="car-image">
                <img class="img-fluid fixed-img" src="/storage/${car.images[0]}" alt="">
                <div class="car-overlay-banner">
                  <ul>
                    <li><a href="${url}"><i class="fa fa-link"></i></a></li>
                    <li><a href="${url}"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="car-list">
                <ul class="list-inline">
                  <li><i class="fa fa-registered"></i> ${car.year}</li>
                  <li><i class="fa fa-cog"></i> ${car.transmission_type}</li>
                  <li><i class="fa fa-shopping-cart"></i> 50000 mi</li>
                </ul>
              </div>
              <div class="car-content">
                <a href="${url}">${car.make} ${car.model}</a>
                <div class="separator"></div>
                <div class="price">
                  <span class="old-price">$${car.regular_price}</span>
                  <span class="new-price">$${car.regular_price}</span>
                </div>
              </div>
            </div>
          </div>`;
                    $container.append(carHtml);
                });
            }

            // Handle next button (final step submission)
            $(".next").click(function() {
                const nextStep = currentStep + 1;
                if (nextStep <= totalSteps) {
                    showStep(nextStep);
                } else if (!filtersAlreadyApplied) {
                    const answers = collectAnswers();
                    localStorage.setItem("carSurveyAnswers", JSON.stringify(answers));
                    hideModal();

                    filtersAlreadyApplied = true;

                    $.ajax({
                        url: '/home/filter-cars',
                        method: 'POST',
                        contentType: 'application/json',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: JSON.stringify({
                            filters: answers
                        }),
                        success: function(response) {
                            renderCarList(response.cars);
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            alert('Error retrieving cars.');
                        }
                    });
                }
            });

            $(".previous").click(function() {
                const prevStep = currentStep - 1;
                if (prevStep >= 1) {
                    showStep(prevStep);
                }
            });

            // Close modal logic
            $modal.find('.close-modal').on('click', function() {
                hideModal();
            });

            $modal.on('click', function(e) {
                if ($(e.target).is('#wizardModal')) {
                    hideModal();
                }
            });

            // Load filters from localStorage or default
            if (savedAnswers && Object.keys(savedAnswers).length > 0) {
                hideModal(); // ensure hidden if previously answered
                filtersAlreadyApplied = true;
                // console.log(savedAnswers);
                $.ajax({
                    url: '/home/filter-cars',
                    method: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        filters: savedAnswers
                    }),
                    success: function(response) {
                        renderCarList(response.cars);
                    },
                    error: function() {
                        alert('Error loading saved filtered cars.');
                    }
                });
            } else {
                showModal(); // show only if no stored answers
                $.ajax({
                    url: '/default-cars',
                    method: 'GET',
                    success: function(response) {
                        renderCarList(response.cars);
                    },
                    error: function() {
                        alert('Error loading default cars.');
                    }
                });
            }

            // Hero background slider functionality
            let currentSlide = 0;
            const slides = $('.hero-background-slide');
            const indicators = $('.hero-slider-indicators .indicator');
            const totalSlides = slides.length;

            // Function to show a specific slide
            function showSlide(index) {
                // Remove active class from all slides and indicators
                slides.removeClass('active');
                indicators.removeClass('active');

                // Add active class to current slide and indicator
                $(slides[index]).addClass('active');
                $(indicators[index]).addClass('active');

                currentSlide = index;
            }

            // Function to go to next slide
            function nextSlide() {
                let nextSlide = currentSlide + 1;
                if (nextSlide >= totalSlides) {
                    nextSlide = 0;
                }
                showSlide(nextSlide);
            }

            // Auto slide every 3 seconds
            setInterval(nextSlide, 3000);

            // Manual slide selection via indicators
            indicators.on('click', function() {
                const slideIndex = parseInt($(this).data('slide'));
                showSlide(slideIndex);
            });

        });
    </script>



@endsection