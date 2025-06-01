@extends('layouts.layout')
@section('title', 'Car Directory')
@section('content')



<!--=================================
  loading -->

  <div id="loading">
    <div id="loading-center">
        <img src="images/loader4.gif" alt="">
   </div>
  </div>

  <!--=================================
    loading -->





  <!--=================================
   banner -->

  <section class="slider-parallax car-directory-banner bg-overlay-black-70 bg-17">
    <div class="slider-content-middle">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="slider-content text-center">
              <h2 class="text-white">Find what are you looking for</h2>
              <h4 class="text-white">Over <strong class="text-red">40000</strong>  latest Cars in <strong class="text-red">Cardealer</strong> </h4>
              <div class="search-tab">
                <div id="search-tabs">
                  <div class="tabs-header">
                    <h6>I want to Buy </h6>
                    <ul class="nav nav-tabs text-start" id="myTab01" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-cars-tab" data-bs-toggle="tab" data-bs-target="#all-cars" type="button" role="tab" aria-controls="all-cars" aria-selected="true">All cars</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="new-cars-tab" data-bs-toggle="tab" data-bs-target="#new-cars" type="button" role="tab" aria-controls="new-cars" aria-selected="false">New Cars</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link " id="used-cars-tab" data-bs-toggle="tab" data-bs-target="#used-cars" type="button" role="tab" aria-controls="used-cars" aria-selected="false">Used Cars</button>
                      </li>

                      <li class="nav-item" role="presentation">
                        <button class="nav-link " id="certified-tab" data-bs-toggle="tab" data-bs-target="#certified" type="button" role="tab" aria-controls="certified" aria-selected="false">Certified</button>
                      </li>
                    </ul>

                    <div class="car-total float-end">
                      <h5 class="text-white"><i class="fa fa-caret-right"></i>(50) <span class="text-red">CARS</span></h5>
                    </div>
                  </div>

                  <div class="tab-content" id="myTabContent02">
                    <div class="tab-pane fade show active" id="all-cars" role="tabpanel" aria-labelledby="all-cars-tab">
                      <div class="row">
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Make </option>
                              <option>BMW</option>
                              <option>Honda </option>
                              <option>Hyundai </option>
                              <option>Nissan </option>
                              <option>Mercedes Benz </option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Model</option>
                              <option>3-Series</option>
                              <option>Carrera</option>
                              <option>GT-R</option>
                              <option>Cayenne</option>
                              <option>Mazda6</option>
                              <option>Macan</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Price </option>
                              <option>$5,000</option>
                              <option>$10,000</option>
                              <option>$15,000</option>
                              <option>$20,000</option>
                              <option>$25,000</option>
                              <option>$30,000</option>
                              <option>$35,000</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                          <div class="form-group mb-3">
                            <input id="name01" type="text" placeholder="Location*" class="form-control placeholder" name="name">
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-12">
                          <div class="d-grid">
                            <button class="button red" type="button">Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="new-cars" role="tabpanel" aria-labelledby="new-cars-tab">
                      <div class="row">
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                            <option>Make </option>
                            <option>BMW</option>
                            <option>Honda </option>
                            <option>Hyundai </option>
                            <option>Nissan </option>
                            <option>Mercedes Benz </option>
                           </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Model</option>
                              <option>3-Series</option>
                              <option>Carrera</option>
                              <option>GT-R</option>
                              <option>Cayenne</option>
                              <option>Mazda6</option>
                              <option>Macan</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Price </option>
                              <option>$5,000</option>
                              <option>$10,000</option>
                              <option>$15,000</option>
                              <option>$20,000</option>
                              <option>$25,000</option>
                              <option>$30,000</option>
                              <option>$35,000</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                          <div class="form-group mb-3">
                            <input id="name02" type="text" placeholder="Location*" class="form-control placeholder" name="name">
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-12">
                          <div class="d-grid">
                            <button class="button red" type="button">Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="used-cars" role="tabpanel" aria-labelledby="used-cars-tab">
                      <div class="row">
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Make </option>
                              <option>BMW</option>
                              <option>Honda </option>
                              <option>Hyundai </option>
                              <option>Nissan </option>
                              <option>Mercedes Benz </option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Model</option>
                              <option>3-Series</option>
                              <option>Carrera</option>
                              <option>GT-R</option>
                              <option>Cayenne</option>
                              <option>Mazda6</option>
                              <option>Macan</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Price </option>
                              <option>$5,000</option>
                              <option>$10,000</option>
                              <option>$15,000</option>
                              <option>$20,000</option>
                              <option>$25,000</option>
                              <option>$30,000</option>
                              <option>$35,000</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                          <div class="form-group mb-3">
                            <input id="name03" type="text" placeholder="Location*" class="form-control placeholder" name="name">
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-12">
                          <div class="d-grid">
                            <button class="button red" type="button">Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="certified" role="tabpanel" aria-labelledby="certified-tab">
                      <div class="row">
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Make </option>
                              <option>BMW</option>
                              <option>Honda </option>
                              <option>Hyundai </option>
                              <option>Nissan </option>
                              <option>Mercedes Benz </option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Model</option>
                              <option>3-Series</option>
                              <option>Carrera</option>
                              <option>GT-R</option>
                              <option>Cayenne</option>
                              <option>Mazda6</option>
                              <option>Macan</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                          <div class="selected-box">
                            <select class="selectpicker">
                              <option>Price </option>
                              <option>2010</option>
                              <option>2011</option>
                              <option>2012</option>
                              <option>2013</option>
                              <option>2014</option>
                              <option>2015</option>
                              <option>2016</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                          <div class="form-group mb-3">
                            <input id="name04" type="text" placeholder="Location*" class="form-control placeholder" name="name">
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-12">
                          <div class="d-grid">
                            <button class="button red" type="button">Search</button>
                          </div>
                        </div>
                      </div>
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
   banner -->

  <!--=================================
   section -->

  <section class="page-section-ptb gray-bg position-relative">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="feature-box-5">
            <div class="icon">
              <i class="flaticon-key"></i>
            </div>
            <div class="info">
              <h5> <span class="text-red"> Sell </span> My Car</h5>
              <p>Make more money when you sell your car yourself.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="feature-box-5">
            <div class="icon">
              <i class="flaticon-inspection"></i>
            </div>
            <div class="info">
              <h5> <span class="text-red"> Trade  </span> My Car</h5>
              <p>Get an Instant Cash Offer and trade in or sell your...</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="feature-box-5">
            <div class="icon">
              <i class="flaticon-medal"></i>
            </div>
            <div class="info">
              <h5> <span class="text-red"> Value </span> My Car</h5>
              <p>Find out what your car is worth to an individual buyer or dealer.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="search-logo">
            <div id="search-logo-tabs">
              <div class="tabs-header">
                <h6>I want Search</h6>
                <ul class="nav nav-tabs" id="myTab02" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="browse-make-tab" data-bs-toggle="tab" data-bs-target="#browse-make" type="button" role="tab" aria-controls="browse-make" aria-selected="true">BROWSE MAKE</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="browse-type-tab" data-bs-toggle="tab" data-bs-target="#browse-type" type="button" role="tab" aria-controls="browse-type" aria-selected="false">BROWSE TYPE</button>
                  </li>
                </ul>
              </div>
              <div class="tab-content mb-0" id="myTabContent03">
                <div class="tab-pane fade show active" id="browse-make" role="tabpanel" aria-labelledby="browse-make-tab">
                  <div class="row">
                    @foreach($logos as $logo)
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 car-logo-item" data-make="{{ strtolower($logo['make']) }}">
                            <a href="{{ route('car.index', ['make' => strtolower($logo['make'])]) }}">
                                <div class="search-logo-box">
                                    <img class="img-fluid center-block" src="{{ asset('images/clients/logo/' . $logo['image']) }}" alt="{{ $logo['make'] }}">
                                    <span>{{ $logo['count'] }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>

                <div class="tab-pane fade" id="browse-type" role="tabpanel" aria-labelledby="browse-type-tab">
                  <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'convertible']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/01.png')}}" alt="">
                          <strong>convertible</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'coupe']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/02.png')}}" alt="">
                          <strong>coupe</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'cuv']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/03.png')}}" alt="">
                          <strong>cuv</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'micro']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/04.png')}}" alt="">
                          <strong>micro</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'minivan']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/05.png')}}" alt="">
                          <strong>minivan</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'pick-up']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/06.png')}}" alt="">
                          <strong>pick-up</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'sedan']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/07.png')}}" alt="">
                          <strong>sedan</strong>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                        <a href="{{ route('car.index', ['Body[]' => 'supercar']) }}">
                          <div class="search-logo-box text-center">
                          <img class="img-fluid center-block" src="{{asset('images/clients/body-type/08.png')}}" alt="">
                          <strong>supercar</strong>
                        </div>
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="search-banner text-center">
            <img class="tab-hiiden img-fluid" src="images/banner-2.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--=================================
   section -->

  <!--=================================
   section -->

  <section class="vehicle-tab page-section-ptb white-bg">
    <div class="container">
     <div class="row">
        <div class="col-lg-3 col-md-12">
          <img class="tab-hiiden img-fluid" src="images/banner-3.jpg" alt="">
        </div>
        <div class="col-lg-9 col-md-12">
          <div id="tabs">
            <div class="tabs-header">
              <h6>which vehicle You need<span class="text-red">?</span></h6>
              <ul class="nav nav-tabs" id="myTab03" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="new-cars01-tab" data-bs-toggle="tab" data-bs-target="#new-cars01" type="button" role="tab" aria-controls="new-cars01" aria-selected="true">New Cars</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="used-cars01-tab" data-bs-toggle="tab" data-bs-target="#used-cars01" type="button" role="tab" aria-controls="used-cars01" aria-selected="false">USED CARS</button>
                </li>
              </ul>
            </div>
            <div class="tab-content mb-0" id="myTabContent">
              <div class="tab-pane fade show active" id="new-cars01" role="tabpanel" aria-labelledby="new-cars01-tab">
                <div class="row">
                   <div class="col-md-4 mb-4 mb-md-0">
                     <div class="car-item gray-bg text-center">
                       <div class="car-image">
                         <img class="img-fluid" src="images/car/01.jpg" alt="">
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
                         <a href="#">Acura Rsx</a>
                         <div class="separator"></div>
                         <div class="price">
                           <span class="old-price">$35,568</span>
                           <span class="new-price">$32,698 </span>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-4 mb-4 mb-md-0">
                     <div class="car-item gray-bg text-center">
                       <div class="car-image">
                         <img class="img-fluid" src="images/car/02.jpg" alt="">
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
                         <a href="#">Lexus GS 450h</a>
                         <div class="separator"></div>
                         <div class="price">
                           <span class="old-price">$35,568</span>
                           <span class="new-price">$32,698 </span>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="car-item gray-bg text-center">
                       <div class="car-image">
                         <img class="img-fluid" src="images/car/03.jpg" alt="">
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
                         <a href="#">GTA 5 Lowriders DLC</a>
                         <div class="separator"></div>
                         <div class="price">
                           <span class="old-price">$35,568</span>
                           <span class="new-price">$32,698 </span>
                         </div>
                       </div>
                     </div>
                   </div>
                </div>
              </div>

              <div class="tab-pane fade" id="used-cars01" role="tabpanel" aria-labelledby="used-cars01-tab">
                <div class="row">
                  <div class="col-md-4  mb-4 mb-md-0">
                     <div class="car-item gray-bg text-center">
                       <div class="car-image">
                         <img class="img-fluid" src="images/car/04.jpg" alt="">
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
                         <a href="#">Acura Rsx</a>
                         <div class="separator"></div>
                         <div class="price">
                           <span class="old-price">$35,568</span>
                           <span class="new-price">$32,698 </span>
                         </div>
                       </div>
                     </div>
                  </div>
                  <div class="col-md-4  mb-4 mb-md-0">
                     <div class="car-item gray-bg text-center">
                       <div class="car-image">
                         <img class="img-fluid" src="images/car/05.jpg" alt="">
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
                         <a href="#">Lexus GS 450h</a>
                         <div class="separator"></div>
                         <div class="price">
                           <span class="old-price">$35,568</span>
                           <span class="new-price">$32,698 </span>
                         </div>
                       </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="car-item gray-bg text-center">
                       <div class="car-image">
                         <img class="img-fluid" src="images/car/06.jpg" alt="">
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
                         <a href="#">GTA 5 Lowriders DLC</a>
                         <div class="separator"></div>
                         <div class="price">
                           <span class="old-price">$35,568</span>
                           <span class="new-price">$32,698 </span>
                         </div>
                       </div>
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
   section -->


   <!--=================================
   Counter -->

  <section class="page-section-pb">
    <div class="container">
    <div class="row">
      <div class="col-md-6">
          <div class="dealer-box red-bg">
            <div class="box-content">
              <h5 class="text-white">Ad your New car with Cardealer</h5>
              <p class="text-white">Search Our Inventory With Thousands Of Cars And More Cars Are Adding On Daily Basis</p>
              <a class="button white" href="#">Become a Dealer</a>
            </div>
            <div class="box-icon">
              <i class="flaticon-car-repair"></i>
            </div>
          </div>
       </div>
       <div class="col-md-6">
          <div class="dealer-box dark-bg">
            <div class="box-content">
              <h5 class="text-white">Sell your Car with Cardealer</h5>
              <p class="text-white">Search Our Inventory With Thousands Of Cars And More Cars Are Adding On Daily Basis</p>
              <a class="button white" href="#">Become a Dealer</a>
            </div>
            <div class="box-icon">
              <i class="flaticon-key"></i>
            </div>
          </div>
       </div>
    </div>
     <div class="row counter counter-style-1 light">
       <div class="col-lg-3 col-sm-6 text-center">
         <div class="counter-block">
            <i class="glyph-icon flaticon-beetle"></i>
            <h6 class="text-black">Vehicles In Stock  </h6>
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
        <div class="counter-block mb-sm-0 mb-4">
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


   <!--=================================
   latest news -->

  <section class="latest-blog gray-bg page-section-ptb">
    <div class="container">
     <div class="row">
      <div class="col-sm-6">
        <div class="text-start blog-button">
           <h5>News & Reviews</h5>
        </div>
      </div>
      <div class="col-sm-6 blog-button">
        <div class="text-end">
           <a class="button white" href="#">View all</a>
        </div>
      </div>
     </div>
     <div class="row">
       <div class="col-lg-4 col-md-12">
          <div class="blog-2">
            <div class="blog-image">
              <img class="img-fluid" src="images/blog/05.jpg" alt="">
              <div class="date">
                <span>aug 21</span>
              </div>
            </div>
            <div class="blog-content">
              <div class="blog-admin-main">
               <div class="blog-admin">
                <img class="img-fluid" src="images/team/01.jpg" alt="">
                <span>John Doe</span>
               </div>
               <div class="blog-meta float-end">
                 <ul>
                   <li><a href="#"> <i class="fa fa-comment"></i><br /> 123</a></li>
                   <li class="share"><a href="#"> <i class="fa fa-share-alt"></i><br /> ...</a>
                    <div class="blog-social">
                     <ul>
                      <li> <a href="#"><i class="fa fa-facebook"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-twitter"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-instagram"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-pinterest-p"></i></a> </li>
                     </ul>
                     </div>
                   </li>
                 </ul>
               </div>
              </div>
              <div class="blog-description text-center">
                 <a href="#">Does Your Life Lack Meaning</a>
                 <div class="separator"></div>
                <p>You will begin to realize why this exercise Pattern is called the Dickens with reference to the ghost</p>
              </div>
            </div>
          </div>
       </div>
     <div class="col-lg-4 col-md-12">
          <div class="blog-2">
            <div class="blog-image">
              <img class="img-fluid" src="images/blog/06.jpg" alt="">
              <div class="date">
                <span>aug 21</span>
              </div>
            </div>
            <div class="blog-content">
              <div class="blog-admin-main">
               <div class="blog-admin">
                <img class="img-fluid" src="images/team/02.jpg" alt="">
                <span>Paul Flavius</span>
               </div>
               <div class="blog-meta float-end">
                 <ul>
                   <li><a href="#"> <i class="fa fa-comment"></i><br /> 123</a></li>
                   <li class="share"><a href="#"> <i class="fa fa-share-alt"></i><br /> ...</a>
                    <div class="blog-social">
                     <ul>
                      <li> <a href="#"><i class="fa fa-facebook"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-twitter"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-instagram"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-pinterest-p"></i></a> </li>
                     </ul>
                     </div>
                   </li>
                 </ul>
               </div>
              </div>
              <div class="blog-description text-center">
                 <a href="#">The A Z Of Motivation</a>
                 <div class="separator"></div>
                <p>Exercise is called you will begin to Pattern realize why this the Dickens Pattern with reference to ghost</p>
              </div>
            </div>
          </div>
       </div>
       <div class="col-lg-4 col-md-12">
          <div class="blog-2 mb-0">
            <div class="blog-image">
              <img class="img-fluid" src="images/blog/07.jpg" alt="">
              <div class="date">
                <span>aug 21</span>
              </div>
            </div>
            <div class="blog-content">
              <div class="blog-admin-main">
               <div class="blog-admin">
                <img class="img-fluid" src="images/team/03.jpg" alt="">
                <span>Sara Lisbon</span>
               </div>
               <div class="blog-meta float-end">
                 <ul>
                   <li><a href="#"> <i class="fa fa-comment"></i><br /> 123</a></li>
                   <li class="share"><a href="#"> <i class="fa fa-share-alt"></i><br /> ...</a>
                    <div class="blog-social">
                     <ul>
                      <li> <a href="#"><i class="fa fa-facebook"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-twitter"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-instagram"></i></a> </li>
                      <li> <a href="#"><i class="fa fa-pinterest-p"></i></a> </li>
                     </ul>
                     </div>
                   </li>
                 </ul>
               </div>
              </div>
              <div class="blog-description text-center">
                 <a href="#">Motivation In Life</a>
                 <div class="separator"></div>
                <p>Dickens Pattern you will begin to realize why this Dickens exercise is the with reference to the ghost</p>
              </div>
            </div>
          </div>
       </div>
      </div>
    </div>
  </section>

  <!--=================================
   latest news -->


@endsection
