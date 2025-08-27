@extends('layouts.layout')
@section('title', 'Car list')
@section('content')

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

    <!--=================================
                                                                                 inner-intro -->



    <!--=================================
                                                                                car-details -->

    <section class="car-details page-section-ptb">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h3> {{ $car->title }} </h3>
                    <p> {{ $car->description }} </p>
                </div>
                <div class="col-md-3">
                    <div class="car-price text-md-end">
                        <strong>{{ $car->sale_price }}</strong>
                        <span>Plus Taxes & Licensing</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="details-nav">
                        <ul>
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fa fa-question-circle"></i>Request More Info
                                </a>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Request More Info</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="rmi_notice" class="form-notice" style="display:none;"></div>
                                                <p class="sub-title">Please fill out the information below and one of our
                                                    representatives will contact you regarding your more information
                                                    request. </p>
                                                <form class="gray-form reset_css" id="rmi_form"
                                                    action="https://themes.potenzaglobalsolutions.com/html/cardealer/post">
                                                    <input type="hidden" name="action" value="request_more_info" />
                                                    <div class="alrt">
                                                        <span class="alrt"></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Name*</label>
                                                        <input type="text" class="form-control" name="rmi_name"
                                                            id="rmi_name" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email address*</label>
                                                        <input type="text" class="form-control" name="rmi_email"
                                                            id="rmi_email" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Phone*</label>
                                                        <input type="text" class="form-control" id="rmi_phone"
                                                            name="rmi_phone">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Message</label>
                                                        <textarea class="form-control" name="rmi_message" id="rmi_message"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label pe-3">Preferred Contact*</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="flexRadioDefault" id="flexRadioDefault1">
                                                            <label class="form-check-label p-0 text-uppercase"
                                                                for="flexRadioDefault1">
                                                                Email
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                            <label class="form-check-label p-0 text-uppercase"
                                                                for="flexRadioDefault2">
                                                                Phone
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div id="recaptcha1"></div>
                                                    </div>
                                                    <div>
                                                        <a class="button red" id="request_more_info_submit">Submit <i
                                                                class="fa fa-spinner fa-spin fa-fw btn-loader"
                                                                style="display: none;"></i></a>
                                                    </div>
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
                                                        <label class="form-label">Financing Required*</label>
                                                        <div class="selected-box">
                                                            <select class="selectpicker" id="mao_financing"
                                                                name="mao_financing">
                                                                <option value="Yes">Yes </option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">additional Comments/Conditions*</label>
                                                        <textarea class="form-control input-message" rows="4" id="mao_comments" name="mao_comments"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label pe-3">Preferred Contact*</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="flexRadioDefault" id="flexRadioDefault001">
                                                            <label class="form-check-label p-0 text-uppercase"
                                                                for="flexRadioDefault001">
                                                                Email
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="flexRadioDefault" id="flexRadioDefault002" checked>
                                                            <label class="form-check-label p-0 text-uppercase"
                                                                for="flexRadioDefault002">
                                                                Phone
                                                            </label>
                                                        </div>
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
                            @if (!empty($car->video) && count($car->video) > 0)
                                <h6 class="mt-4">Vehicle Videos</h6>
                                <div class="row">
                                    @foreach ($car->video as $vid)
                                        <div class="col-md-4 mb-3">
                                            <video class="w-100" controls>
                                                <source src="{{ asset('storage/' . $vid) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                        <div class="slider slider-nav">
                            @foreach ($car->images as $image)
                                <img class="img-fluid fixed-img" style="" src="/storage/{{ $image }}"
                                    alt="">
                            @endforeach
                            {{-- <img class="img-fluid fixed-img" src="{{ asset('images/car/01.jpg') }}" alt="">
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
                                    aria-controls="general-information" aria-selected="true">
                                    General Information
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="general-information" role="tabpanel"
                                aria-labelledby="general-information-tab">
                                <h6>Welcome to Top Motors</h6>
                                <p>
                                    <strong>Top Motors</strong> is your trusted destination for buying and selling quality
                                    cars.
                                    We specialize in connecting car buyers with the best deals, offering a wide range of
                                    vehicles
                                    from brand-new models to well-maintained used cars.
                                    <br /><br />
                                    At Top Motors, our mission is to make car ownership simple, affordable, and reliable.
                                    Whether you are looking for a luxury vehicle, a family car, or a budget-friendly ride,
                                    we provide complete details, transparent pricing, and expert guidance to help you make
                                    the right choice.
                                    <br /><br />
                                    Our platform is designed to ensure a smooth process, offering:
                                <ul>
                                    <li>✔ Wide selection of cars from trusted sellers</li>
                                    <li>✔ Secure and transparent transactions</li>
                                    <li>✔ Car financing and installment options</li>
                                    <li>✔ Reliable after-sales support and services</li>
                                </ul>
                                <br />
                                With <strong>Top Motors</strong>, you are not just buying a car—you are investing in
                                quality, safety, and peace of mind. Join us today and drive your dream car with confidence!
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-car">
                        <h6>Recently Vehicles</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="owl-carousel" data-nav-arrow="true" data-nav-dots="true" data-items="3"
                                    data-md-items="3" data-sm-items="2" data-space="15">

                                    @foreach ($recentCars as $recent)
                                        <div class="item">
                                            <div class="car-item gray-bg text-center">
                                                <div class="car-image">
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/' . ($recent->images[0] ?? 'no-image.png')) }}"
                                                        alt="{{ $recent->title }}"
                                                        style="max-height: 150px; overflow: hidden;">
                                                    <div class="car-overlay-banner">
                                                        <ul>
                                                            <li><a href="{{ route('car.show', $recent->id) }}"><i
                                                                        class="fa fa-link"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="car-content">
                                                    <a
                                                        href="{{ route('car.show', $recent->id) }}">{{ $recent->title }}</a>
                                                    <div class="price"><span
                                                            class="new-price">${{ $recent->sale_price }}</span></div>
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
                        <div class="details-social details-weight">
                            <h5>Share now</h5>
                            <ul>
                                <li><a href="#"> <i class="fa fa-facebook"></i> facebook</a></li>
                                <li><a href="#"> <i class="fa fa-twitter"></i> twitter</a></li>
                                <li><a href="#"> <i class="fa fa-pinterest-p"></i> pinterest</a></li>
                                <li><a href="#"> <i class="fa fa-dribbble"></i> dribbble</a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i> google plus </a></li>
                                <li><a href="#"> <i class="fa fa-behance"></i> behance</a></li>
                            </ul>
                        </div>
                        <div class="details-form contact-2 details-weight">
                            <form class="gray-form" action="https://themes.potenzaglobalsolutions.com/html/cardealer/post"
                                id="send_enquiry_form">
                                <h5>SEND ENQUIRY</h5>
                                <div id="send_enquiry_notice" class="form-notice" style="display:none;"></div>
                                <input type="hidden" name="action" value="send_enquiry" />
                                <div class="mb-3">
                                    <label class="form-label">Name*</label>
                                    <input type="text" class="form-control" placeholder="Name"
                                        name="send_enquiry_name" id="send_enquiry_name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email address*</label>
                                    <input type="text" class="form-control" placeholder="Email"
                                        name="send_enquiry_email" id="send_enquiry_email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message* </label>
                                    <textarea class="form-control" rows="4" placeholder="Message" name="send_enquiry_message"
                                        id="send_enquiry_message"></textarea>
                                </div>
                                <div class="mb-3">
                                    <div id="recaptcha6"></div>
                                </div>
                                <div>
                                    <a class="button red" id="send_enquiry_submit" href="javascript:void(0)">Submit <i
                                            class="fa fa-spinner fa-spin fa-fw btn-loader" style="display: none;"></i></a>
                                </div>
                            </form>
                        </div>
                        <div class="details-phone details-weight">
                            <div class="feature-box-3 grey-border">
                                <div class="icon">
                                    <i class="fa fa-headphones"></i>
                                </div>
                                <div class="content">
                                    <h4>1-888-345-888 </h4>
                                    <p>Call our seller to get the best price </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <!--=================================
                                                                                car-details  -->

    <script>
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
        // Define the dynamic route (replace '__ID__' later in JS)
        const car_show = "{{ route('car.show', ['id' => '__ID__']) }}";
        const API_URL = "{{ route('cars.feature') }}"; // Laravel API route
        const container = $('#feature-cars');

        // function fetchFilteredCars(query = '') {
        //     axios.get(API_URL + '?' + query)
        //         .then(response => {
        //             const cars = response.data;
        //             container.trigger('destroy.owl.carousel'); // Remove previous Owl
        //             container.html('').removeClass('owl-loaded'); // Clear container

        //             $.each(cars, function(index, car) {
        //                 const images = JSON.parse(car.images || '[]');
        //                 const imageSrc = images.length ? `/storage/${images[0]}` : '/images/no-image.png';
        //                 const url = car_show.replace('__ID__', car.id);

        //                 let html = `
    //                     <div class="item">
    //                         <div class="car-item gray-bg text-center">
    //                             <div class="car-image">
    //                                 <img class="img-fluid" src="${imageSrc}" alt="">
    //                                 <div class="car-overlay-banner">
    //                                     <ul>
    //                                         <li><a href="${url}"><i class="fa fa-link"></i></a></li>
    //                                         <li><a href="${url}"><i class="fa fa-dashboard"></i></a></li>
    //                                     </ul>
    //                                 </div>
    //                             </div>
    //                             <div class="car-list">
    //                                 <ul class="list-inline">
    //                                     <li><i class="fa fa-registered"></i> ${car.year}</li>
    //                                     <li><i class="fa fa-cog"></i> ${car.transmission_type}</li>
    //                                     <li><i class="fa fa-dashboard"></i> 6,000 mi</li>
    //                                 </ul>
    //                             </div>
    //                             <div class="car-content">
    //                                 <div class="star">
    //                                     <i class="fa fa-star orange-color"></i>
    //                                     <i class="fa fa-star orange-color"></i>
    //                                     <i class="fa fa-star orange-color"></i>
    //                                     <i class="fa fa-star orange-color"></i>
    //                                     <i class="fa fa-star-o orange-color"></i>
    //                                 </div>
    //                                 <a href="#">${car.name || 'Unknown Car'}</a>
    //                                 <div class="separator"></div>
    //                                 <div class="price">
    //                                     <span class="old-price">$${car.regular_price}</span>
    //                                     <span class="new-price">$${car.sale_price}</span>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 `;

        //                 container.append(html);
        //             });
        //         })
        //         .catch(error => {
        //             console.error('Error fetching cars:', error);
        //             container.html('<p>Failed to load cars.</p>');
        //         });
        // }

        // $(document).ready(function () {
        //     fetchFilteredCars();
        // });
    </script>


@endsection
