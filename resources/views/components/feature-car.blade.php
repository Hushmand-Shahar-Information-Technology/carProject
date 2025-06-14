
<style>
    .container-width{
        width: 65% !important; 
    }
    @media (max-width: 790px){
        .container-width{
            width: 50% !important; 
        }
    }    
</style>


{{-- feature cards --}}
{{-- <section class="feature-car bg-2 bg-overlay-black-70 page-section-ptb"> --}}
    <div class="container container-width" style="width: 60%; transform: translate(10px, -80px);">
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <span class="text-white mt-5">Check out our recent cars</span>
                    <h2 class="text-white">Feature Car </h2>
                    <div class="separator"></div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme" data-nav-arrow="true" data-items="4" data-md-items="4"
                    data-sm-items="2" data-xs-items="1" data-space="20">
                    <div class="item">
                        <div class="car-item text-center">
                            <div class="car-image">
                                <img class="img-fluid" src="{{ asset('images/car/01.jpg') }}" alt="">
                                <div class="car-overlay-banner">
                                    <ul>s how 
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
                                <div class="price" > 
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
{{-- </section> --}}

<!-- Feature Car End -->
