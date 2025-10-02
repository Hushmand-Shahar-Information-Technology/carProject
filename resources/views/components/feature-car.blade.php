<style>
    .container-width {
        width: 65% !important;
         z-index: 333333333 !important;
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
    $latestCars = $latestCars ?? [];
    // If we have promoted cars, use them; otherwise use latest cars
    $hasPromotedCars = count($promotedCars) > 0;
    $carsToShow = $hasPromotedCars ? $promotedCars : $latestCars;
@endphp
{{-- <section class="feature-car bg-2 bg-overlay-black-70 page-section-ptb"> --}}
<div class="container container-width" style="width: 60%; transform: translate(10px, -80px);">
    <div class="row">
        <div class="col-md-12">
            <div class="owl-carousel owl-theme" data-nav-arrow="true" data-items="4" data-md-items="4"
                data-sm-items="2" data-xs-items="1" data-space="20">
                
                @if(count($carsToShow) > 0)
                    {{-- Show promoted cars or latest cars --}}
                    @foreach($carsToShow as $car)
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback message when no cars available --}}
                    <div class="item">
                        <div class="car-item text-center">
                            <div class="car-content">
                                <p>No cars available at the moment.</p>
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