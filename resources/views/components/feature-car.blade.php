<style>
    .container-width {
        width: 65% !important;
    }

    @media (max-width: 790px) {
        .container-width {
            width: 50% !important;
        }
    }
    
    .car-image {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .car-image .fixed-img {
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    
    .car-image:hover .fixed-img {
        transform: scale(1.05);
    }
</style>


{{-- feature cards --}}
@php
    $promotedCars = $promotedCars ?? [];
    // If we have promoted cars, use them; otherwise use static fallback
    $hasPromotedCars = count($promotedCars) > 0;
@endphp
{{-- <section class="feature-car bg-2 bg-overlay-black-70 page-section-ptb"> --}}
<div class="container container-width" style="width: 60%; transform: translate(10px, -80px);">
    <div class="row">
        <div class="col-md-12">
            <div class="owl-carousel owl-theme" data-nav-arrow="true" data-items="4" data-md-items="4"
                data-sm-items="2" data-xs-items="1" data-space="20">
                
                @if($hasPromotedCars)
                    {{-- Show promoted cars --}}
                    @foreach($promotedCars as $car)
                        <div class="item">
                            <div class="car-item text-center">
                                <div class="car-image">
                                    @if(isset($car->images[0]))
                                        <img class="img-fluid fixed-img" src="{{ asset('storage/' . $car->images[0]) }}" alt="{{ $car->title }}">
                                    @else
                                        <img class="img-fluid fixed-img" src="{{ asset('images/car/01.jpg') }}" alt="Default Car">
                                    @endif
                                    <div class="car-overlay-banner">
                                        <ul>
                                            <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-link"></i></a></li>
                                            <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-dashboard"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="car-list">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-registered"></i> {{ $car->year }}</li>
                                        <li><i class="fa fa-cog"></i> {{ $car->transmission_type ?? 'N/A' }}</li>
                                        <li><i class="fa fa-dashboard"></i> {{ number_format($car->views) }} views</li>
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
                                    <a href="{{ route('car.show', $car->id) }}" style="font-size: 12px;">{{ $car->make }} {{ $car->model }}</a>
                                    <div class="separator"></div>
                                    <div class="price">
                                        <span class="new-price" style="font-size: 10px;">${{ number_format($car->regular_price) }}</span>
                                        @if($car->promotions->first())
                                            <div class="promotion-badge" style="font-size: 8px; color: #28a745;">
                                                <i class="fa fa-fire"></i> Promoted
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback to static cars if no promoted cars --}}
                    <div class="item">
                        <div class="car-item text-center">
                            <div class="car-image">
                                <img class="img-fluid fixed-img" src="{{ asset('images/car/01.jpg') }}" alt="">
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
                                <img class="img-fluid fixed-img" src="{{ asset('images/car/02.jpg') }}" alt="">
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
                                <img class="img-fluid fixed-img" src="{{ asset('images/car/03.jpg') }}" alt="">
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
                                <img class="img-fluid fixed-img" src="{{ asset('images/car/04.jpg') }}" alt="">
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
                                <img class="img-fluid fixed-img" src="{{ asset('images/car/05.jpg') }}" alt="">
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
                @endif
            </div>
        </div>
    </div>
</div>
{{-- </section> --}}

<!-- Feature Car End -->