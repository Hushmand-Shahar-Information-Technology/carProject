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
            <div class="row">
                <div class="col-md-12">
                    <div class="details-nav">
                        <ul>
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
                                                    <!-- Starting price -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Price ($)*</label>
                                                        <input type="number" class="form-control" name="amount"
                                                            id="amount" required>
                                                    </div>

                                                    <!-- Auction duration -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Auction Duration*</label>

                                                        <div class="form-check" style="display: flex; align-items: center;">
                                                            <input class="form-check-input" type="radio"
                                                                name="auction_time" id="fixed_time" value="fixed">
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
                                                                name="auction_time" id="open_time" value="open" checked>
                                                            <label class="form-check-label mt-1" for="open_time">Run until
                                                                canceled</label>
                                                        </div>
                                                    </div>

                                                    <!-- Message -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Message (optional)</label>
                                                        <textarea class="form-control" name="rmi_message" id="rmi_message"></textarea>
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
                                                    action="https://themes.potenzaglobalsolutions.com/html/cardealer/post"
                                                    id="mao_form">
                                                    <input type="hidden" name="action" value="make_an_offer" />
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
                                    <br /><br />
                                    Consectetur adipisicing elit. Dicta, amet quia ad debitis fugiat voluptatem neque
                                    dolores tempora iste saepe cupiditate, molestiae iure voluptatibus est beatae? Culpa,
                                    illo a You will begin to realize why, consectetur adipisicing elit. Commodi, doloribus,
                                    earum modi consectetur molestias asperiores sequi ipsam neque error itaque veniam culpa
                                    eligendi similique ducimus nulla, blanditiis, perspiciatis atque saepe! veritatis.

                                    <br /><br />
                                    Adipisicing consectetur elit. Dicta, amet quia ad debitis fugiat voluptatem neque
                                    dolores tempora iste saepe cupiditate, molestiae iure voluptatibus est beatae? Culpa,
                                    illo a You will begin to realize why, consectetur adipisicing elit. Commodi, doloribus,
                                    earum modi consectetur molestias asperiores.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="feature-car">
                        <h6>Recently Vehicle</h6>
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
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                console.log(car_id);
                var formData = {
                    mao_name: $('#mao_name').val(),
                    mao_email: $('#mao_email').val(),
                    mao_phone: $('#mao_phone').val(),
                    mao_price: $('#mao_price').val(),
                    mao_comments: $('#mao_comments').val(),
                    mao_car_id: car_id
                };

                $.ajax({
                    type: 'POST',
                    url: '/car/offer', // Replace with your actual route
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('.btn-loader').hide();
                        $('#mao_form')[0].reset();

                        // Hide the modal
                        $('#exampleModal3').modal('hide');

                        // Show alert after modal is fully hidden
                        $('#exampleModal3').on('hidden.bs.modal', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                heightAuto: false, // prevents body scrollbar shift
                                willClose: () => {
                                    // Remove modal-related classes and reset overflow to re-enable scrolling
                                    $('body').removeClass('modal-open').css(
                                        'overflow', '');
                                    $('.modal-backdrop').remove();
                                }
                            });

                            $('#exampleModal3').off('hidden.bs.modal');
                        });
                    },
                    error: function(xhr) {
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
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = Object.values(errors).map(msgArray => msgArray[
                                0]).join('<br>');
                            swalOptions.title = 'Validation Error';
                            swalOptions.html = errorMessages;
                        } else {
                            swalOptions.title = 'Server Error';
                            swalOptions.text = xhr.responseJSON?.message ||
                                'An unexpected error occurred.';
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
            const auctionForm = document.getElementById("auctionForm"); // <-- Add this
            const maxPrice = parseFloat(auctionForm.dataset.maxPrice);

            function toggleDuration() {
                if (fixedRadio.checked) {
                    durationInput.style.display = "block";
                } else {
                    durationInput.style.display = "none";
                    durationInput.value = ""; // clear if hidden
                }
            }

            // Event listeners for radio buttons
            fixedRadio.addEventListener("change", toggleDuration);
            openRadio.addEventListener("change", toggleDuration);
            toggleDuration(); // initial check

            // Validate form before submit
            auctionForm.addEventListener("submit", function(e) {
                const amount = parseFloat(document.getElementById("amount").value);

                if (isNaN(amount) || amount <= 0) {
                    e.preventDefault();
                    alert("Please enter a valid starting price.");
                    return;
                }

                if (amount >= maxPrice) {
                    e.preventDefault();
                    alert(`Starting price must be smaller than $${maxPrice}.`);
                    return;
                }

                // Validate duration if "Set duration" is selected
                if (fixedRadio.checked) {
                    const duration = parseInt(durationInput.value);
                    if (isNaN(duration) || duration <= 0) {
                        e.preventDefault();
                        alert("Please enter a valid auction duration in days.");
                        return;
                    }
                }
            });
        });
    </script>


@endsection
