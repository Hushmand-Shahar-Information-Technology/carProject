@extends('layouts.layout')
@section('title', 'Car list')
@section('content')

<style>
  .fixed-img {
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
  }
  .list-group-item ul {
    display: none;
    padding-left: 20px;
  }
</style>
<!--=================================
 banner -->

<section class="slider-parallax bg-overlay-black-50 bg-17">
  <div class="slider-content-middle">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <div class="slider-content text-center">
           <h2 class="text-white">Let's Find Your Perfect Car</h2>
           <strong class="text-white">Quality cars. Better prices. Test drives brought to you.</strong>
              <div class="row justify-content-center">
               <div class="col-lg-6 col-md-12">
                 <div class="search-page">
                  <input type="text" class="form-control" placeholder="Search your desired car... ">
                  <a href="#">  <i class="fa fa-search"></i> </a>
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
car-listing-sidebar -->

<section class="car-listing-sidebar product-listing" data-sticky_parent>
  <div class="container-fluid p-0">
     <div class="row g-0">
      <div class="car-listing-sidebar-left" >
       <div class="listing-sidebar scrollbar" data-sticky_column>
      <div class="widget">
         <div class="widget-search">
           <h5>Advanced Search</h5>
           <ul class="list-style-none">
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
                      <input class="form-check-input filter-option" type="checkbox" value="*" id="invalidCheck01" required>
                      <label class="form-check-label" for="invalidCheck01">
                        All Years
                      </label>
                    </div>
                  </li>
                  @for ($year = 2000; $year <= now()->year; $year++)
                    <li>
                        <div class="form-check">
                            <input class="form-check-input filter-option" type="checkbox" value="{{ $year }}" id="year{{ $year }}">
                            <label class="form-check-label" for="year{{ $year }}">{{ $year }}</label>
                        </div>
                    </li>
                  @endfor
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
      </div>
      </div>
      <div class="car-listing-sidebar-right">
       <div class="sorting-options-main">
        <div class="row justify-content-between">
        <div class="col-xl-3 col-md-12">
          <div class="price-slide">
           <div class="price">
            <label for="amount">Price Range</label>
              <input type="text" id="amount" class="amount" value="$50 - $300" />
             <div id="slider-range"></div>
           </div>
          </div>
         </div>
         <div class="col-xl-3 col-xxl-2 col-md-12 ms-auto">
            <div class="selected-box">
           <span>Sort by</span>
             <select>
              <option>Sort by Default </option>
              <option>Sort by Name</option>
              <option>Sort by Price </option>
              <option>Sort by Date </option>
             </select>
           </div>
         </div>
         <div class="col-xl-3 col-xxl-2 col-md-12">
           <div class="price-search">
            <span>Search cars</span>
             <div class="search">
              <i class="fa fa-search"></i>
             <input type="search" class="form-control placeholder" placeholder="Search....">
            </div>
          </div>
         </div>
        </div>
       </div>
     <div class="isotope column-5" id="car-results">
            {{-- @foreach ($cars as $car)
            @php
                    $images = json_decode($car->images, true);
            @endphp
            <div class="grid-item">
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
                    <li><i class="fa fa-cog"></i> {{$car->transmission_type}} </li>
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
            @endforeach    --}}
             @include('car.car-results', ['filteredCars' => $cars])
          </div>
      </div>
   </div>
  </div>
</section>

<script>

  
document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('.filter-option');
  console.log(filters); 
    filters.forEach(function (filter) {
        filter.addEventListener('change', function () {
            applyFilters();
        });
    });

    function applyFilters() {
        const formData = new FormData();

        document.querySelectorAll('.filter-option:checked').forEach((input) => {
            formData.append(input.name, input.value);
        });

        fetch('{{ route('cars.filter') }}?' + new URLSearchParams(formData), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('car-results').innerHTML = html;
        });
    }
});
// ***************************************************************************
  document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".list-group-item > a");

    items.forEach(function (item) {
      item.addEventListener("click", function (e) {
        e.preventDefault();
        const submenu = this.nextElementSibling;
        if (submenu.style.display === "block") {
          submenu.style.display = "none";
        } else {
          submenu.style.display = "block";
        }
      });
    });
  });
</script>

 @endsection