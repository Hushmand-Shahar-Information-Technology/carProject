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
              {{-- Year filter --}}
             @php
                $years = range(2000, now()->year);
            @endphp
            <x-car-filter name="Year" label="All Years" :options="$years" />
            <x-car-filter name="Condition" label="All Conditions" :options="['Brand New', 'Slightly Used', 'Used']" />
            <x-car-filter name="Body" label="All Body Styles" :options="['2dr Car', '4dr Car', 'Convertible']" />
            <x-car-filter name="Model" label="All Models" :options="['Carrera', 'Boxster', 'GTS']" />
            <x-car-filter name="Color" label="All Color" :options="['Black', 'White', 'Red', 'Yello', 'Green']" />
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