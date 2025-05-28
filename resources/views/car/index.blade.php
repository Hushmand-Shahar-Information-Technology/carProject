@extends('layouts.layout')
@section('title', 'Car list')
@section('content')

<style>
  .fixed-img {
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
  }
</style>
<!--=================================
    inner-intro -->

 <section class="inner-intro bg-1 bg-overlay-black-70">
  <div class="container">
     <div class="row text-center intro-title">
           <div class="col-m                                                                                                                                                                                                                                                                                                                      d-6 text-md-start d-inline-block">
             <h1 class="text-white">product listing </h1>
           </div>
           <div class="col-md-6 text-md-end float-end">
             <ul class="page-breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                <li><a href="#">pages</a> <i class="fa fa-angle-double-right"></i></li>
                <li><span>listing 01</span> </li>
             </ul>
           </div>
     </div>
  </div>
</section>


<!--=================================
product-listing  -->

<section class="product-listing page-section-ptb">
 <div class="container">
  <div class="row">
    {{-- Include advance search --}}
    {{-- @include('car.advance-search') --}}
    <div class="col-lg-3 col-md-4">
      <div class="listing-sidebar">
        <div class="widget">
          <div class="widget-search">
            <h5>Advanced Search</h5>
            <ul class="list-style
             -none">
              <li><i class="fa fa-star"> </i> Results Found <span class="float-end">(39)</span></li>
              <li><i class="fa fa-shopping-cart"> </i> Compare Vehicles <span class="float-end">(10)</span></li>
            </ul>
          </div>
          <div class="clearfix">
            <ul class="list-group">
              <li class="list-group-item">
                <a href="#">Year</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck01" required>
                      <label class="form-check-label" for="invalidCheck01">
                        All Years
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck02" required>
                      <label class="form-check-label" for="invalidCheck02">
                        2009
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck03" required>
                      <label class="form-check-label" for="invalidCheck03">
                        2010
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck04" required>
                      <label class="form-check-label" for="invalidCheck04">
                        2011
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck05" required>
                      <label class="form-check-label" for="invalidCheck05">
                        2012
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck06" required>
                      <label class="form-check-label" for="invalidCheck06">
                        2013
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck51" required>
                      <label class="form-check-label" for="invalidCheck51">
                        2014
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck07" required>
                      <label class="form-check-label" for="invalidCheck07">
                        2015
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck08" required>
                      <label class="form-check-label" for="invalidCheck08">
                        2016
                      </label>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="list-group-item">
                <a href="#">Condition</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck09" required>
                      <label class="form-check-label" for="invalidCheck09">
                        All Conditions
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck10" required>
                      <label class="form-check-label" for="invalidCheck10">
                        Brand New
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck11" required>
                      <label class="form-check-label" for="invalidCheck11">
                        Slightly Used
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck12" required>
                      <label class="form-check-label" for="invalidCheck12">
                        Used
                      </label>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="list-group-item">
                <a href="#">Body</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck13" required>
                      <label class="form-check-label" for="invalidCheck13">
                        All Body Styles
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck14" required>
                      <label class="form-check-label" for="invalidCheck14">
                        2dr Car
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck15" required>
                      <label class="form-check-label" for="invalidCheck15">
                        4dr Car
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck16" required>
                      <label class="form-check-label" for="invalidCheck16">
                        Convertible
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck17" required>
                      <label class="form-check-label" for="invalidCheck17">
                        Sedan
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck18" required>
                      <label class="form-check-label" for="invalidCheck18">
                        Sports Utility Vehicle
                      </label>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="list-group-item">
                <a href="#">Model</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck19" required>
                      <label class="form-check-label" for="invalidCheck19">
                        All Models
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck20" required>
                      <label class="form-check-label" for="invalidCheck20">
                        3-Series
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck21" required>
                      <label class="form-check-label" for="invalidCheck21">
                        Boxster
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck22" required>
                      <label class="form-check-label" for="invalidCheck22">
                        Carrera
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck23" required>
                      <label class="form-check-label" for="invalidCheck23">
                        Cayenne
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck24" required>
                      <label class="form-check-label" for="invalidCheck24">
                        F-type
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck25" required>
                      <label class="form-check-label" for="invalidCheck25">
                        GT-R
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck26" required>
                      <label class="form-check-label" for="invalidCheck26">
                        GTS
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck27" required>
                      <label class="form-check-label" for="invalidCheck27">
                        M6
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck28" required>
                      <label class="form-check-label" for="invalidCheck28">
                        Macan
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck29" required>
                      <label class="form-check-label" for="invalidCheck29">
                        Mazda6
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck30" required>
                      <label class="form-check-label" for="invalidCheck30">
                        RLX
                      </label>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="list-group-item">
                <a href="#">Transmission</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck52" required>
                      <label class="form-check-label" for="invalidCheck52">
                        All Transmissions
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck31" required>
                      <label class="form-check-label" for="invalidCheck31">
                        5-Speed Manual
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck32" required>
                      <label class="form-check-label" for="invalidCheck32">
                        6-Speed Automatic
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck33" required>
                      <label class="form-check-label" for="invalidCheck33">
                        6-Speed Manual
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck34" required>
                      <label class="form-check-label" for="invalidCheck34">
                        6-Speed Semi-Auto
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck35" required>
                      <label class="form-check-label" for="invalidCheck35">
                        7-Speed PDK
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck36" required>
                      <label class="form-check-label" for="invalidCheck36">
                        8-Speed Automatic
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck37" required>
                      <label class="form-check-label" for="invalidCheck37">
                        8-Speed Tiptronic
                      </label>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="list-group-item">
                <a href="#">Exterior Color</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck38" required>
                      <label class="form-check-label" for="invalidCheck38">
                        Ruby Red Metallic
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck39" required>
                      <label class="form-check-label" for="invalidCheck39">
                        Racing Yellow
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck40" required>
                      <label class="form-check-label" for="invalidCheck40">
                        Guards Red
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck41" required>
                      <label class="form-check-label" for="invalidCheck41">
                        Aqua Blue Metallic
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck42" required>
                      <label class="form-check-label" for="invalidCheck42">
                        White
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck43" required>
                      <label class="form-check-label" for="invalidCheck43">
                        Dark Blue Metallic
                      </label>
                    </div>
                  </li>

                </ul>
              </li>
              <li class="list-group-item">
                <a href="#">Interior Color</a>
                <ul>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck44" required>
                      <label class="form-check-label" for="invalidCheck44">
                        Platinum Grey
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck45" required>
                      <label class="form-check-label" for="invalidCheck45">
                        Agate Grey
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck46" required>
                      <label class="form-check-label" for="invalidCheck46">
                        Marsala Red
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck47" required>
                      <label class="form-check-label" for="invalidCheck47">
                        Alcantara Black
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck48" required>
                      <label class="form-check-label" for="invalidCheck48">
                        Black
                      </label>
                    </div>
                  </li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck49" required>
                      <label class="form-check-label" for="invalidCheck49">
                        Luxor Beige
                      </label>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div class="widget-banner">
          <img class="img-fluid center-block" src="{{asset('images/banner.jpg')}}" alt="">
        </div>
      </div>
    </div>
     <div class="col-lg-9 col-md-8">
       <div class="sorting-options-main">
        <div class="row">
        <div class="col-lg-4">
          <div class="price-slide">
           <div class="price">
            <label class="mb-2" for="amount">Price Range</label>
              <input type="text" id="amount" class="amount" value="$50 - $300" />
             <div id="slider-range"></div>
           </div>
          </div>
         </div>
         <div class="col-lg-4">
          <div class="price-slide-2">
           <div class="price">
            <label class="mb-2" for="amount-2">Price Range</label>
              <input type="text" id="amount-2" class="amount" value="$50 - $300" />
             <div id="slider-range-2"></div>
           </div>
          </div>
         </div>
         <div class="col-lg-4">
           <div class="price-search">
            <span class="mb-2">Price search</span>
             <div class="search">
              <i class="fa fa-search"></i>
             <input type="search" class="form-control placeholder" placeholder="Search....">
            </div>
           </div>
         </div>
        </div>
        <div class="row sorting-options">
          <div class="col-lg-5">
           <div class="change-view-button">
             <a class="active" href="#"> <i class="fa fa-th"></i> </a>
             <a href="listing-02.html"> <i class="fa fa-list-ul"></i> </a>
           </div>
          </div>
         <div class="col-lg-3 text-end">
           <div class="selected-box">
            <select>
              <option>Show  </option>
              <option>1</option>
              <option>2 </option>
              <option>3 </option>
              <option>4 </option>
              <option>5 </option>
            </select>
          </div>
         </div>
         <div class="col-lg-4 text-end">
            <div class="selected-box">
             <select>
              <option>Sort by </option>
              <option>Price: Lowest first</option>
              <option>Price: Highest first </option>
              <option>Product Name: A to Z </option>
              <option>Product Name: Z to A </option>
               <option>In stock</option>
             </select>
           </div>
         </div>
        </div>
       </div>
       {{-- list file included here --}}
          {{-- @include('car.car-list') --}}
          <div class="row">
            @foreach ($cars as $car)
                @php
                    $images = json_decode($car->images, true);
                @endphp
                <div class="col-lg-4 col-sm-6">
                    <div class="car-item gray-bg text-center">
                    <div class="car-image">
                       <img class="img-fluid fixed-img" src="{{ asset($images[0]) }}" alt="">
                    <div class="car-overlay-banner">
                        <ul>
                        <li><a href="#"><i class="fa fa-link"></i></a></li>
                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    </div>
                    <div class="car-list">
                    <ul class="list-inline">
                        <li><i class="fa fa-registered"></i>{{$car->year}}</li>
                        <li><i class="fa fa-cog"></i> Manual </li>
                        <li><i class="fa fa-shopping-cart"></i> 6,000 mi</li>
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
                    <a href="#">{{$car->model}}</a>
                    <div class="separator"></div>
                    <div class="price">
                        <span class="old-price">${{$car->regular_price}}</span>
                        <span class="new-price">${{$car->sale_price}}</span>
                    </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
          <div class="pagination-nav d-flex justify-content-center">
               <ul class="pagination">
                 <li><a href="#">«</a></li>
                 <li class="active"><a href="#">1</a></li>
                 <li><a href="#">2</a></li>
                 <li><a href="#">3</a></li>
                 <li><a href="#">4</a></li>
                 <li><a href="#">5</a></li>
                 <li><a href="#">»</a></li>
               </ul>
          </div>
       </div>
     </div>
  </div>
</section>

<!--=================================
product-listing  -->


@endsection
