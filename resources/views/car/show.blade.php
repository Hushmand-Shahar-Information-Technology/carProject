@extends('layouts.layout')
@section('title', 'Car list')
@section('content')

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fancybox for video playback -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>


    {{-- @include('car.slick') --}}
    <link rel="stylesheet" href="{{ asset('css/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick/slick-theme.css') }}">
    <!--=================================
                                                                                                                                                                                                                                                                             inner-intro -->
    <style>
        .fixed-img {
            width: 100%;
            aspect-ratio: 16 / 11;
            object-fit: cover;
        }

        /* Force SweetAlert2 to always appear on top of modals */
        .swal2-container {
            z-index: 200000 !important;
        }

        .video-thumbnail {
            position: relative;
            display: block;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .video-thumbnail:hover {
            transform: scale(1.05);
        }

        .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .watch-video-btn {
            margin-top: 15px;
        }

        .watch-video-btn a {
            background: #db2d2e;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .watch-video-btn a:hover {
            background: #b91c1c;
            color: white;
        }

        /* Auction Timer Styling */
        .auction-timer-container {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .auction-timer {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        .auction-timer.urgent {
            animation: pulse-urgent 1s infinite;
            color: #ffeb3b;
        }

        .auction-timer.expired {
            color: #ff5252;
            animation: none;
        }

        @keyframes pulse-urgent {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.7; }
        }

        .auction-info {
            text-align: center;
        }

        .auction-starting-price {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .ended-auction {
            background: linear-gradient(135deg, #6c757d, #495057) !important;
        }
        
        .ended-auction .auction-timer {
            background: rgba(108, 117, 125, 0.9) !important;
        }
    </style>

    <section class="inner-intro bg-6 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">{{ $car->title }}</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Home</a> <i
                                class="fa fa-angle-double-right"></i>
                        </li>
                        <li><a href="{{ route('car.index') }}">car-list</a> <i class="fa fa-angle-double-right"></i></li>
                        <li><span> details </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="car-details page-section-ptb">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="text-danger mb-3 fw-bold">{{ $car->title }}</h3>
                    <p class="text-dark mb-4 lh-base">{{ $car->description }}</p>
                    @if (!empty($car->rent_price_per_day))
                        <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                            <div class="bg-light rounded p-3 shadow-sm flex-fill">
                                <p class="text-danger mb-1 fs-5 fw-semibold">Rent Price:</p>
                                <p class="text-dark mb-0 fs-5"><strong>{{ $car->rent_price_per_day }} per day</strong></p>
                            </div>
                            <div class="bg-light rounded p-3 shadow-sm flex-fill">
                                <p class="text-danger mb-1 fs-5 fw-semibold">Rent Price:</p>
                                <p class="text-dark mb-0 fs-5"><strong>{{ $car->rent_price_per_month }} per month</strong>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="car-price text-md-end">
                        <div class="d-flex align-items-center justify-content-end mb-2">
                            <i class="fa fa-eye me-1 text-muted"></i>
                            <span class="text-muted">{{ $car->views }}</span>
                        </div>
                        <strong>{{ $car->regular_price }}</strong>
                        <span>Plus Taxes & Licensing</span>
                        <div class="mt-2">
                            <button id="btn-promote-car"
                                class="btn btn-sm btn-outline-primary">{{ $hasActivePromotion ? 'Promoted' : 'Promote' }}</button>
                            @if ($hasActivePromotion && $activePromotionEndsAt)
                                <div class="small text-muted mt-1">
                                    <span id="promotion-ends-at"
                                        data-ends-at="{{ $activePromotionEndsAt->toIso8601String() }}"></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Auction Timer Section --}}
            @if(isset($auction) && $auction)
            <div class="auction-timer-container @if($auction->status === 'ended') ended-auction @endif">
                <div class="auction-info">
                    @if($auction->status === 'active')
                        <h4><i class="fa fa-gavel"></i> AUCTION IN PROGRESS</h4>
                    @else
                        <h4><i class="fa fa-flag-checkered"></i> AUCTION ENDED</h4>
                    @endif
                    <div class="auction-starting-price">
                        Starting Price: ${{ number_format($auction->starting_price, 2) }}
                    </div>
                    @if($auction->status === 'ended')
                        <div class="auction-timer expired">
                            Auction Ended on {{ $auction->end_at ? $auction->end_at->format('M d, Y \\a\\t g:i A') : 'N/A' }}
                        </div>
                    @elseif($auction->end_at)
                        <div class="auction-timer" data-end-time="{{ $auction->end_at->toISOString() }}">
                            Loading...
                        </div>
                    @else
                        <div class="auction-timer">
                            Open Auction - No End Time
                        </div>
                    @endif
                    
                    {{-- End Auction Button - Only show to auction owner for active auctions --}}
                    @if($auction->status === 'active' && auth()->check() && $car->user_id === auth()->id())
                    <div class="mt-3 text-center">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#endAuctionModal">
                            <i class="fa fa-stop-circle"></i> End Auction Early
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <div class="row">
                <div class="col-md-12">
                    <div class="details-nav">
                        <ul>
                            @if(auth()->check() && $car->user_id === auth()->id())
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#auctionModal">
                                    <i class="fa fa-question-circle"></i> Request to Auction
                                </a>

                                <div class="modal fade" id="auctionModal" tabindex="-1" aria-labelledby="auctionModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content rounded-3 shadow">
                                            <div class="modal-header" style="background:#343a40;">
                                                <h5 class="modal-title text-white" id="auctionModalLabel">Start an Auction
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted">Set your car’s starting price and auction duration.
                                                </p>

                                                <form id="auctionForm" action="{{ route('auctions.store') }}"
                                                    method="POST" data-max-price="<?= $car->regular_price ?>">
                                                    @csrf
                                                    <!-- Hidden car_id field -->
                                                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                                                    
                                                    <!-- Starting price -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Price ($)*</label>
                                                        <input type="number" class="form-control" name="starting_price"
                                                            id="starting_price" required>
                                                    </div>

                                                    <!-- Auction duration -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Auction Duration*</label>

                                                        <div class="form-check" style="display: flex; align-items: center;">
                                                            <input class="form-check-input" type="radio"
                                                                name="auction_type" id="fixed_time" value="fixed">
                                                            <label class="form-check-label mt-1" for="fixed_time">Set
                                                                duration</label>
                                                        </div>

                                                        <!-- Hidden by default -->
                                                        <input type="number" class="form-control mt-2" name="duration_days"
                                                            id="duration_days" placeholder="Enter days (e.g. 4)"
                                                            style="display:none;">

                                                        <div class="form-check mt-2"
                                                            style="display: flex; align-items: center;">
                                                            <input class="form-check-input" type="radio"
                                                                name="auction_type" id="open_time" value="open" checked>
                                                            <label class="form-check-label mt-1" for="open_time">Run until
                                                                canceled</label>
                                                        </div>
                                                    </div>

                                                    <!-- Message -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Message (optional)</label>
                                                        <textarea class="form-control" name="message" id="message"></textarea>
                                                    </div>

                                                    <!-- Recaptcha -->
                                                    <div class="mb-3" id="recaptcha1"></div>

                                                    <!-- Submit -->
                                                    <button type="submit" class="btn btn-danger w-100">
                                                        Start Auction
                                                        <i class="fa fa-spinner fa-spin fa-fw btn-loader"
                                                            style="display: none;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>
                            @endif
                            {{-- End Auction Modal - Only show if there's an active auction --}}
                            @if(isset($auction) && $auction && $auction->status === 'active' && auth()->check() && $car->user_id === auth()->id())
                            <div class="modal fade" id="endAuctionModal" tabindex="-1" aria-labelledby="endAuctionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-3 shadow">
                                        <div class="modal-header" style="background: #dc3545;">
                                            <h5 class="modal-title text-white" id="endAuctionModalLabel">
                                                <i class="fa fa-exclamation-triangle"></i> End Auction Confirmation
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <i class="fa fa-gavel fa-3x text-warning mb-3"></i>
                                                <h5>Are you sure you want to end this auction?</h5>
                                                <p class="text-muted">This action cannot be undone. The auction will be permanently ended and no further bids can be placed.</p>
                                            </div>
                                            
                                            <div class="alert alert-warning">
                                                <strong>Auction Details:</strong><br>
                                                Starting Price: ${{ number_format($auction->starting_price, 2) }}<br>
                                                @if($auction->end_at)
                                                    Originally scheduled to end: {{ $auction->end_at->format('M d, Y \\a\\t g:i A') }}
                                                @else
                                                    Type: Open Auction (No scheduled end time)
                                                @endif
                                            </div>
                                            
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                                <button type="button" class="btn btn-danger" id="confirmEndAuction">
                                                    <i class="fa fa-stop-circle"></i> Yes, End Auction
                                                    <i class="fa fa-spinner fa-spin" id="endAuctionSpinner" style="display: none;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!auth()->check() || auth()->id() !== $car->user_id)
                            <li>
                                <a data-bs-toggle="modal" data-bs-target="#exampleModal3" data-whatever="@mdo"
                                    href="#" class="css_btn"><i class="fa fa-tag"></i>Make an Offer</a>
                                <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel3" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel3">Make an Offer</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="mao_notice" class="form-notice" style="display:none;"></div>
                                                <form class="gray-form reset_css"
                                                    action="{{ route('car.offer') }}"
                                                    id="mao_form">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label">Name*</label>
                                                        <input type="text" id="mao_name" name="mao_name"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email address*</label>
                                                        <input type="text" id="mao_email" name="mao_email"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Phone*</label>
                                                        <input type="text" id="mao_phone" name="mao_phone"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Offered Price*</label>
                                                        <input type="text" id="mao_price" name="mao_price"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">additional Comments/Conditions*</label>
                                                        <textarea class="form-control input-message" rows="4" id="mao_comments" name="mao_comments"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div id="recaptcha3"></div>
                                                    </div>
                                                    <div>
                                                        <a class="button red" id="make_an_offer_submit">Submit <i
                                                                class="fa fa-spinner fa-spin fa-fw btn-loader"
                                                                style="display: none;"></i></a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if(auth()->check() && $car->user_id === auth()->id())
                                <li><a href=""  data-bs-toggle="modal" data-bs-target="#offersModal"> <i class="fa fa-handshake me-2"></i>Show Offers Received <span class="badge bg-light text-dark ms-2">{{ $car->offers->count() }}</span></a></li>
                            @endif
                            <li><a href="javascript:window.print()"><i class="fa fa-print"></i>Print this page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="slider-slick">
                        <div class="cars-image-gallery" style="">
                            <div class="slider slider-for detail-big-car-gallery">
                                @foreach ($car->images as $image)
                                    <img class="img-fluid" style="" src="/storage/{{ $image }}"
                                        alt="">
                                @endforeach
                                {{-- <img class="img-fluid" src="{{ asset('images/car/02.jpg') }}" alt="">
                                <img class="img-fluid" src="{{ asset('images/car/03.jpg') }}" alt="">
                                <img class="img-fluid" src="{{ asset('images/car/04.jpg') }}" alt="">
                                <img class="img-fluid" src="{{ asset('images/car/05.jpg') }}" alt="">
                                <img class="img-fluid" src="{{ asset('images/car/06.jpg') }}" alt="">
                                <img class="img-fluid" src="{{ asset('images/car/07.jpg') }}" alt="">
                                <img class="img-fluid" src="{{ asset('images/car/08.jpg') }}" alt=""> --}}
                            </div>
                            @if ($car->videos && count($car->videos) > 0)
                                <div class="watch-video-btn">
                                    <div class="video-info">
                                        <a class="popup-youtube" href="/storage/{{ $car->videos[0] }}"
                                            data-fancybox="video">
                                            <i class="fa fa-play"></i> Watch Video
                                        </a>
                                    </div>
                                </div>

                                <!-- Video Gallery -->
                                @if (count($car->videos) > 1)
                                    <div class="video-gallery mt-3">
                                        <h6>All Videos</h6>
                                        <div class="row">
                                            @foreach ($car->videos as $index => $video)
                                                <div class="col-md-4 mb-2">
                                                    <a href="/storage/{{ $video }}" data-fancybox="video-gallery"
                                                        class="video-thumbnail">
                                                        <video class="img-fluid rounded"
                                                            style="width: 100%; height: 120px; object-fit: cover;">
                                                            <source src="/storage/{{ $video }}" type="video/mp4">
                                                        </video>
                                                        <div class="play-overlay">
                                                            <i class="fa fa-play-circle fa-2x text-white"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="slider slider-nav">
                            @foreach ($car->images as $image)
                                <img class="img-fluid fixed-img" style="" src="/storage/{{ $image }}"
                                    alt="">
                            @endforeach
                            {{-- <img class="img-fluid fixed-img" src="{{ asset('images/car/01.jpg') }}" }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/02.jpg') }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/03.jpg') }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/04.jpg') }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/05.jpg') }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/06.jpg') }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/07.jpg') }}" alt="">
                            <img class="img-fluid fixed-img" src="{{ asset('images/car/08.jpg') }}" alt=""> --}}
                        </div>

                    </div>


                    <div id="tabs">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item icon-diamond" role="presentation">
                                <button class="nav-link active" id="general-information-tab" data-bs-toggle="tab"
                                    data-bs-target="#general-information" type="button" role="tab"
                                    aria-controls="general-information" aria-selected="true">General Information</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="general-information" role="tabpanel"
                                aria-labelledby="general-information-tab">
                                <h6>consectetur adipisicing elit</h6>
                                <p>Temporibus possimus quasi beatae, consectetur adipisicing elit. Obcaecati unde molestias
                                    sunt officiis aliquid sapiente, numquam, porro perspiciatis neque voluptatem sint hic
                                    quam eveniet ad adipisci laudantium corporis ipsam ea!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="feature-car">
                        <h6>Related Vehicle</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="owl-carousel" data-nav-arrow="true" data-nav-dots="true" data-items="3"
                                    data-md-items="3" data-sm-items="2" data-space="15" id="feature-cars">
                                    @foreach ($makes as $car_i)
                                        <div class="item">
                                            <div class="car-item gray-bg text-center">
                                                <div class="car-image">
                                                    <img class="img-fluid" src="/storage/{{ $car_i->images[0] }}"
                                                        alt="">
                                                    <div class="car-overlay-banner">
                                                        <ul>
                                                            <li><a href="{{ route('car.show', $car_i->id) }}"><i
                                                                        class="fa fa-link"></i></a></li>
                                                            <li><a href="{{ route('car.show', $car_i->id) }}"><i
                                                                        class="fa fa-dashboard"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="car-list">
                                                    <ul class="list-inline">
                                                        <li><i class="fa fa-registered"></i>{{ $car_i->year }}</li>
                                                        <li><i class="fa fa-cog"></i>{{ $car_i->ransmission_type }}/li>
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
                                                    <a href="{{ route('car.show', $car_i->id) }}">{{ $car_i->model }}</a>
                                                    <div class="separator"></div>
                                                    <div class="price">
                                                        <span class="old-price">${{ $car_i->regular_price }}</span>
                                                        <span class="new-price">${{ $car->regular_price }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="car-details-sidebar">
                        {{-- Car Owner Information --}}
                        @if($car->user)
                        <div class="details-block details-weight mb-4">
                            <h5>CAR OWNER</h5>
                            <div class="owner-info bg-light p-3 rounded">
                                <a href="{{ route('user.profile') }}">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-user-circle fa-2x text-primary me-3"></i>
                                    <div>
                                            <h6 class="mb-0">{{ $car->user->name }}</h6>
                                            <small class="text-muted">Car Owner</small>
                                        </div>
                                    </div>
                                </a>
                                @if($car->user->email)
                                <div class="contact-info">
                                    <small class="text-muted">
                                        <i class="fa fa-envelope me-1"></i>
                                        {{ $car->user->email }}
                                    </small>
                                </div>
                                @endif
                                @if($car->user->phone)
                                <div class="contact-info mt-1">
                                    <small class="text-muted">
                                        <i class="fa fa-phone me-1"></i>
                                        {{ $car->user->phone }}
                                    </small>
                                </div>
                                @endif
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fa fa-calendar me-1"></i>
                                        Listed {{ $car->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="details-block details-weight">
                            <h5>DESCRIPTION</h5>
                            <ul>
                                <li> <span>Make</span> <strong class="text-end">{{ $car->make }}</strong></li>
                                <li> <span>Model</span> <strong class="text-end"> {{ $car->model }} </strong></li>
                                <li> <span>Registration date </span> <strong class="text-end"> {{ $car->year }}
                                    </strong></li>
                                <li> <span>Mileage</span> <strong class="text-end">25,000 mi</strong></li>
                                <li> <span>Condition</span> <strong class="text-end"> {{ $car->car_condition }} </strong>
                                </li>
                                <li> <span>Exterior Color</span> <strong class="text-end">{{ $car->car_color }}</strong>
                                </li>
                                <li> <span>Interior Color</span> <strong
                                        class="text-end">{{ $car->car_inside_color }}</strong></li>
                                <li> <span>Transmission</span> <strong
                                        class="text-end">{{ $car->transmission_type }}</strong></li>
                                <li> <span>Engine Number</span> <strong class="text-end">{{ $car->VIN_number }}</strong>
                                </li>
                                <li> <span>Body Type</span> <strong class="text-end">{{ $car->body_type }}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                                          @if(auth()->check() && $car->user_id === auth()->id())

            <!-- <div class="row mt-4">
                <div class="col-12">
                    <div class="d-grid gap-2">
                        <button class="btn btn-danger btn-lg" type="button" data-bs-toggle="modal" data-bs-target="#offersModal">
                            <i class="fa fa-handshake me-2"></i>Show Offers Received <span class="badge bg-light text-dark ms-2">{{ $car->offers->count() }}</span>
                        </button>
                    </div>
                </div>
            </div> -->

            <!-- Offers Modal -->
            <div class="modal fade" id="offersModal" tabindex="-1" aria-labelledby="offersModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="offersModalLabel">
                                <i class="fa fa-handshake me-2"></i>Offers Received ({{ $car->offers->count() }})
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($car->offers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th><i class="fa fa-user me-1"></i>Name</th>
                                            <th><i class="fa fa-phone me-1"></i>Phone</th>
                                            <th><i class="fa fa-envelope me-1"></i>Email</th>
                                            <th><i class="fa fa-dollar-sign me-1"></i>Offered Price</th>
                                            <th><i class="fa fa-comment me-1"></i>Comments</th>
                                            <th><i class="fa fa-calendar me-1"></i>Date</th>
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($car->offers->sortByDesc('created_at') as $offer)
                                        <tr>
                                            <td>
                                                <strong>{{ $offer->name }}</strong>
                                            </td>
                                            <td>
                                                <a href="tel:{{ $offer->phone }}" class="text-decoration-none">
                                                    {{ $offer->phone }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $offer->email }}" class="text-decoration-none">
                                                    {{ $offer->email }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-success fs-6">
                                                    ${{ number_format($offer->price) }}
                                                </span>
                                                @if($offer->price > $car->regular_price)
                                                    <small class="text-success d-block">
                                                        <i class="fa fa-arrow-up"></i>
                                                        +${{ number_format($offer->price - $car->regular_price) }} above asking
                                                    </small>
                                                @elseif($offer->price < $car->regular_price)
                                                    <small class="text-warning d-block">
                                                        <i class="fa fa-arrow-down"></i>
                                                        -${{ number_format($car->regular_price - $offer->price) }} below asking
                                                    </small>
                                                @else
                                                    <small class="text-info d-block">
                                                        <i class="fa fa-check"></i> Exact asking price
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($offer->remark)
                                                    <button class="btn btn-sm btn-outline-danger" 
                                                            data-bs-toggle="tooltip" 
                                                            title="{{ $offer->remark }}">
                                                        <i class="fa fa-eye"></i> View
                                                    </button>
                                                @else
                                                    <span class="text-muted">No comments</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $offer->created_at->format('M d, Y') }}<br>
                                                    {{ $offer->created_at->format('g:i A') }}
                                                </small>
                                            </td>
                                            <!-- <td>
                                                <div class="btn-group-vertical btn-group-sm">
                                                    <a href="mailto:{{ $offer->email }}?subject=Re: Car Offer - {{ $car->title }}&body=Hi {{ $offer->name }}, Thank you for your offer of ${{ number_format($offer->price) }} for my {{ $car->title }}." 
                                                       class="btn btn-success btn-sm">
                                                        <i class="fa fa-reply"></i> Reply
                                                    </a>
                                                    <a href="tel:{{ $offer->phone }}" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-phone"></i> Call
                                                    </a>
                                                </div>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            {{-- Summary Stats --}}
                            <div class="row mt-4">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-center">
                                            <h6 class="text-success">Highest Offer</h6>
                                            <h4 class="text-success">
                                                ${{ number_format($car->offers->max('price')) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card border-warning h-100">
                                        <div class="card-body text-center">
                                            <h6 class="text-warning">Average Offer</h6>
                                            <h4 class="text-warning">
                                                ${{ number_format($car->offers->avg('price')) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card border-info h-100">
                                        <div class="card-body text-center">
                                            <h6 class="text-info">Your Asking Price</h6>
                                            <h4 class="text-info">
                                                ${{ number_format($car->regular_price) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No offers received yet</h5>
                                <p class="text-muted">Offers from interested buyers will appear here</p>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" onclick="location.reload()">
                                <i class="fa fa-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Display Laravel session messages with SweetAlert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error!',
                html: '{!! implode('<br>', $errors->all()) !!}',
                confirmButtonText: 'OK'
            });
        @endif
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('#btn-promote-car');
            if (!btn) return;
            e.preventDefault();
            if (btn.textContent.trim().toLowerCase() === 'promoted' ||
                {{ $hasActivePromotion ? 'true' : 'false' }}) {
                Swal.fire({
                    title: 'Unpromote this car?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(r => {
                    if (!r.isConfirmed) return;
                    axios.post('{{ route('promotions.unpromote') }}', {
                            type: 'car',
                            id: {{ $car->id }}
                        })
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Unpromoted',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            btn.textContent = 'Promote';
                            clearPromotionCountdown('promotion-ends-at');
                            const label = document.getElementById('promotion-ends-at');
                            if (label) {
                                label.removeAttribute('data-ends-at');
                                label.textContent = '';
                            }
                        })
                        .catch(() => Swal.fire('Error', 'Failed to unpromote', 'error'));
                });
                return;
            }
            Swal.fire({
                title: 'Promote this car',
                input: 'number',
                inputLabel: 'How many days?',
                inputAttributes: {
                    min: 1,
                    max: 365
                },
                inputValue: 7,
                showCancelButton: true,
                confirmButtonText: 'Promote'
            }).then(result => {
                if (!result.isConfirmed) return;
                const days = parseInt(result.value, 10);
                if (!days || days < 1) return;
                axios.post('{{ route('promotions.promote') }}', {
                        type: 'car',
                        id: {{ $car->id }},
                        days
                    })
                    .then(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Promoted',
                            text: `Ends: ${res.data.ends_at}`,
                            timer: 1600,
                            showConfirmButton: false
                        });
                        btn.textContent = 'Promoted';
                        // Insert/refresh countdown label
                        let label = document.getElementById('promotion-ends-at');
                        if (!label) {
                            label = document.createElement('span');
                            label.id = 'promotion-ends-at';
                            btn.parentElement.insertAdjacentHTML('beforeend',
                                '<div class="small text-muted mt-1"><span id="promotion-ends-at"></span></div>'
                            );
                            label = document.getElementById('promotion-ends-at');
                        }
                        if (res.data.ends_at) {
                            label.setAttribute('data-ends-at', new Date(res.data.ends_at)
                                .toISOString());
                            startPromotionCountdown('promotion-ends-at');
                        }
                    })
                    .catch(() => Swal.fire('Error', 'Failed to promote', 'error'));
            });
        });

        function clearPromotionCountdown(elementId) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const handle = el.getAttribute('data-countdown');
            if (handle) {
                clearInterval(Number(handle));
                el.removeAttribute('data-countdown');
            }
        }

        function startPromotionCountdown(elementId) {
            const el = document.getElementById(elementId);
            if (!el) return;
            clearPromotionCountdown(elementId);
            const endsAt = new Date(el.getAttribute('data-ends-at'));
            if (isNaN(endsAt)) return;
            const handle = setInterval(() => {
                const now = new Date();
                let diff = Math.max(0, endsAt - now);
                if (diff <= 0) {
                    el.textContent = 'Expired';
                    clearPromotionCountdown(elementId);
                    return;
                }
                const second = 1000;
                const minute = 60 * second;
                const hour = 60 * minute;
                const day = 24 * hour;
                const month = 30 * day;
                const year = 365 * day;
                const years = Math.floor(diff / year);
                diff %= year;
                const months = Math.floor(diff / month);
                diff %= month;
                const days = Math.floor(diff / day);
                diff %= day;
                const hours = Math.floor(diff / hour);
                diff %= hour;
                const minutes = Math.floor(diff / minute);
                diff %= minute;
                const seconds = Math.floor(diff / second);
                const segments = [];
                segments.push(`<span class=\"badge bg-dark text-white me-1\">${years}Y</span>`);
                segments.push(`<span class=\"badge bg-dark text-white me-1\">${months}M</span>`);
                segments.push(`<span class=\"badge bg-dark text-white me-1\">${days}D</span>`);
                segments.push(`<span class=\"badge bg-danger text-white me-1\">${hours}hr</span>`);
                segments.push(`<span class=\"badge bg-danger text-white me-1\">${minutes}min</span>`);
                segments.push(`<span class=\"badge bg-danger text-white\">${seconds}sec</span>`);
                el.innerHTML = segments.join(' ');
            }, 1000);
            el.setAttribute('data-countdown', String(handle));
        }
        @if ($hasActivePromotion && $activePromotionEndsAt)
            startPromotionCountdown('promotion-ends-at');
        @endif
        const make = @json($car->make);
        const car_id = @json($car->id);
        // console.log(car_id);
        $(document).ready(function() {
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });

            $('.slider-nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                dots: false,
                centerMode: true,
                focusOnSelect: true
            });
        });
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Reinitialize tooltips when modal is shown
            $('#offersModal').on('shown.bs.modal', function () {
                $('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
            });
            
            $('.popup-youtube').magnificPopup({
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        });

        $(document).ready(function() {
            $('#make_an_offer_submit').on('click', function(e) {
                e.preventDefault();
                $('.btn-loader').show();
                console.log('Car ID:', car_id);
                
                var formData = {
                    mao_name: $('#mao_name').val(),
                    mao_email: $('#mao_email').val(),
                    mao_phone: $('#mao_phone').val(),
                    mao_price: $('#mao_price').val(),
                    mao_comments: $('#mao_comments').val(),
                    mao_car_id: car_id
                };

                console.log('Form data:', formData);

                $.ajax({
                    type: 'POST',
                    url: '/car/offer',
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
                        $('.btn-loader').hide();
                        
                        // Check if the response indicates success
                        if (response && response.success === true) {
                            console.log('Offer submitted successfully');
                            $('#mao_form')[0].reset();
                            $('#exampleModal3').modal('hide');

                            // Show success alert immediately after modal is hidden
                            $('#exampleModal3').on('hidden.bs.modal', function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message || 'Offer submitted successfully!',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    heightAuto: false,
                                    willClose: () => {
                                        $('body').removeClass('modal-open').css('overflow', '');
                                        $('.modal-backdrop').remove();
                                    }
                                });
                                
                                // Auto-refresh offers modal if it's open
                                refreshOffersModal();
                                
                                $('#exampleModal3').off('hidden.bs.modal');
                            });
                        } else {
                            console.log('Server returned success=false');
                            // Handle case where response.success is false
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Something went wrong. Please try again.',
                                heightAuto: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', {
                            xhr: xhr,
                            status: status,
                            error: error,
                            responseText: xhr.responseText
                        });
                        $('.btn-loader').hide();

                        let swalOptions = {
                            icon: 'error',
                            heightAuto: false,
                            willClose: () => {
                                $('body').removeClass('modal-open').css('overflow', '');
                                $('.modal-backdrop').remove();
                            }
                        };

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                            if (errors) {
                                let errorMessages = Object.values(errors).map(msgArray => msgArray[0]).join('<br>');
                                swalOptions.title = 'Validation Error';
                                swalOptions.html = errorMessages;
                            } else {
                                swalOptions.title = 'Validation Error';
                                swalOptions.text = 'Please check your input and try again.';
                            }
                        } else {
                            swalOptions.title = 'Server Error';
                            swalOptions.text = xhr.responseJSON?.message || 'An unexpected error occurred.';
                        }

                        Swal.fire(swalOptions);
                    }
                });
            });
        });

        // Initialize Fancybox for video playback
        Fancybox.bind("[data-fancybox='video']", {
            type: "video",
            options: {
                ratio: 16 / 9,
                autoplay: false
            }
        });

        Fancybox.bind("[data-fancybox='video-gallery']", {
            type: "video",
            options: {
                ratio: 16 / 9,
                autoplay: false
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            const fixedRadio = document.getElementById("fixed_time");
            const openRadio = document.getElementById("open_time");
            const durationInput = document.getElementById("duration_days");
            const auctionForm = document.getElementById("auctionForm");
            
            // Check if auction form exists before adding event listeners
            if (!auctionForm) return;
            
            const maxPrice = parseFloat(auctionForm.dataset.maxPrice);

            function toggleDuration() {
                if (fixedRadio && fixedRadio.checked) {
                    durationInput.style.display = "block";
                    durationInput.required = true;
                } else {
                    durationInput.style.display = "none";
                    durationInput.required = false;
                    durationInput.value = ""; // clear if hidden
                }
            }

            // Event listeners for radio buttons
            if (fixedRadio) {
                fixedRadio.addEventListener("change", toggleDuration);
            }
            if (openRadio) {
                openRadio.addEventListener("change", toggleDuration);
            }
            toggleDuration(); // initial check

            // Validate form before submit
            auctionForm.addEventListener("submit", function(e) {
                const amount = parseFloat(document.getElementById("starting_price").value);

                if (isNaN(amount) || amount <= 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Price',
                        text: 'Please enter a valid starting price.'
                    });
                    return;
                }

                if (amount >= maxPrice) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Price Too High',
                        text: `Starting price must be smaller than $${maxPrice}.`
                    });
                    return;
                }

                // Validate duration if "Set duration" is selected
                if (fixedRadio && fixedRadio.checked) {
                    const duration = parseInt(durationInput.value);
                    if (isNaN(duration) || duration <= 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Duration',
                            text: 'Please enter a valid auction duration in days.'
                        });
                        return;
                    }
                }
            });
            
            // Initialize auction countdown timer
            initializeAuctionTimer();
        });
        
        function initializeAuctionTimer() {
            const $timer = $('.auction-timer[data-end-time]');
            if ($timer.length === 0) return;

            const endTime = new Date($timer.data('end-time')).getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    $timer.text('Auction Ended');
                    $timer.addClass('expired');
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let timeString = '';
                if (days > 0) {
                    timeString = `${days}d ${hours}h ${minutes}m`;
                } else if (hours > 0) {
                    timeString = `${hours}h ${minutes}m ${seconds}s`;
                } else {
                    timeString = `${minutes}m ${seconds}s`;
                }

                $timer.text(timeString);

                // Add urgency styling for last hour
                if (distance < 3600000) { // 1 hour in milliseconds
                    $timer.addClass('urgent');
                }
            }

            // Update immediately and then every second
            updateTimer();
            setInterval(updateTimer, 1000);
        }
        
        // Handle end auction functionality
        document.getElementById('confirmEndAuction')?.addEventListener('click', function() {
            const button = this;
            const spinner = document.getElementById('endAuctionSpinner');
            
            // Show loading state
            button.disabled = true;
            spinner.style.display = 'inline';
            
            // Make AJAX request to end auction
            fetch('{{ route("auctions.end", ["id" => $auction->id ?? 0]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Auction Ended',
                        text: 'Your auction has been successfully ended.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload the page to show updated status
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to end auction. Please try again.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
            })
            .finally(() => {
                // Hide loading state
                button.disabled = false;
                spinner.style.display = 'none';
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('endAuctionModal'));
                modal?.hide();
            });
        });
        
        // Function to refresh offers modal dynamically
        function refreshOffersModal() {
            // Only refresh if user is the car owner and offers modal exists
            if (typeof car_id !== 'undefined' && $('#offersModal').length > 0) {
                // Check if modal is currently open
                if ($('#offersModal').hasClass('show')) {
                    // Show loading state
                    const modalBody = $('#offersModal .modal-body');
                    const originalContent = modalBody.html();
                    modalBody.html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Refreshing offers...</p></div>');
                    
                    // Make AJAX request to get updated offers
                    $.ajax({
                        url: '/car/show/' + car_id + '/offers',
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.offers) {
                                // Update offers count badge
                                $('.offers-count-badge').text(response.count);
                                $('#offersModalLabel').html('<i class="fa fa-handshake me-2"></i>Offers Received (' + response.count + ')');
                                
                                // If there are offers, update the table
                                if (response.count > 0) {
                                    updateOffersTableInModal(response.offers, response.stats);
                                } else {
                                    // Show no offers message
                                    modalBody.html(`
                                        <div class="text-center py-5">
                                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No offers received yet</h5>
                                            <p class="text-muted">Offers from interested buyers will appear here</p>
                                        </div>
                                    `);
                                }
                            }
                        },
                        error: function(xhr) {
                            // Restore original content on error
                            modalBody.html(originalContent);
                            console.log('Failed to refresh offers modal:', xhr);
                        }
                    });
                }
            }
        }

        // Function to update offers table in modal with new data
        function updateOffersTableInModal(offers, stats) {
            let tableHtml = `
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fa fa-user me-1"></i>Name</th>
                                <th><i class="fa fa-phone me-1"></i>Phone</th>
                                <th><i class="fa fa-envelope me-1"></i>Email</th>
                                <th><i class="fa fa-dollar-sign me-1"></i>Offered Price</th>
                                <th><i class="fa fa-comment me-1"></i>Comments</th>
                                <th><i class="fa fa-calendar me-1"></i>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    `;
    
            offers.forEach(function(offer) {
                // Format date
                const offerDate = new Date(offer.created_at);
                const formattedDate = offerDate.toLocaleDateString() + '<br>' + offerDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                // Price comparison
                let priceComparison = '';
                if (offer.price > stats.asking) {
                    priceComparison = `<small class="text-success d-block"><i class="fa fa-arrow-up"></i> +$${(offer.price - stats.asking).toLocaleString()} above asking</small>`;
                } else if (offer.price < stats.asking) {
                    priceComparison = `<small class="text-warning d-block"><i class="fa fa-arrow-down"></i> -$${(stats.asking - offer.price).toLocaleString()} below asking</small>`;
                } else {
                    priceComparison = `<small class="text-info d-block"><i class="fa fa-check"></i> Exact asking price</small>`;
                }
                
                // Comments button
                let commentsHtml = offer.remark ? 
                    `<button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="${offer.remark}"><i class="fa fa-eye"></i> View</button>` :
                    `<span class="text-muted">No comments</span>`;
                
                tableHtml += `
                    <tr>
                        <td><strong>${offer.name}</strong></td>
                        <td><a href="tel:${offer.phone}" class="text-decoration-none">${offer.phone}</a></td>
                        <td><a href="mailto:${offer.email}" class="text-decoration-none">${offer.email}</a></td>
                        <td>
                            <span class="badge bg-success fs-6">$${parseFloat(offer.price).toLocaleString()}</span>
                            ${priceComparison}
                        </td>
                        <td>${commentsHtml}</td>
                        <td><small class="text-muted">${formattedDate}</small></td>
                        <td>
                            <div class="btn-group-vertical btn-group-sm">
                                <a href="mailto:${offer.email}?subject=Re: Car Offer&body=Hi ${offer.name}, Thank you for your offer of $${parseFloat(offer.price).toLocaleString()}." class="btn btn-success btn-sm">
                                    <i class="fa fa-reply"></i> Reply
                                </a>
                                <a href="tel:${offer.phone}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-phone"></i> Call
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });
    
            tableHtml += `
                </tbody>
            </table>
        </div>
    `;
    
    // Summary stats
    tableHtml += `
        <div class="row mt-4">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card border-success h-100">
                    <div class="card-body text-center">
                        <h6 class="text-success">Highest Offer</h6>
                        <h4 class="text-success">$${parseFloat(stats.highest).toLocaleString()}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card border-warning h-100">
                    <div class="card-body text-center">
                        <h6 class="text-warning">Average Offer</h6>
                        <h4 class="text-warning">$${parseFloat(stats.average).toLocaleString()}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card border-info h-100">
                    <div class="card-body text-center">
                        <h6 class="text-info">Your Asking Price</h6>
                        <h4 class="text-info">$${parseFloat(stats.asking).toLocaleString()}</h4>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#offersModal .modal-body').html(tableHtml);
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
}

    </script>


@endsection
