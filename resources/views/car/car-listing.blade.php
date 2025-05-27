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
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <button type="button" onclick="this.parentElement.parentElement.remove();" class="text-green-700">
                    &times;
                </button>
            </span>
        </div>
    @endif

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
     <div class="row g-0" style="height:100vh">
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
              {{-- filter --}}
             @php
                $years = range(2000, now()->year);
            @endphp
            <x-car-filter name="Year" label="All Years" :options="$years" />
            <x-car-filter name="Transmission" label="All Transmission" :options="['Brand New', 'Slightly Used', 'Used']" />
            <x-car-filter name="Body" label="All Body Styles" :options="['2dr Car', '4dr Car', 'Convertible']" />
            <x-car-filter name="Model" label="All Models" :options="['Carrera', 'Boxster', 'GTS']" />
            <x-car-filter name="Color" label="All Color" :options="['Black', 'White', 'Red', 'Yello', 'Green']" />
          </ul>
          </div>
         </div>
      </div>
      </div>
      <div class="col-md-10">
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
             <select id="sort-select" class="form-control">
                <option value="">Sort by Default</option>
                <option value="name">Sort by Name</option>
                <option value="price">Sort by Price</option>
                <option value="date">Sort by Date</option>
             </select>
           </div>
         </div>
         <div class="col-xl-3 col-xxl-2 col-md-12">
           <div class="price-search">
            <span>Search cars</span>
             <div class="search">
              <i class="fa fa-search"></i>
             <input type="search" id="car-search" class="form-control placeholder" placeholder="Search....">
            </div>
          </div>
         </div>
        </div>
       </div>
     {{-- <div class="isotope column-5" id="car-results">
             @include('car.car-results', ['filteredCars' => $cars])
          </div> --}}
          <div id="car-results" class="isotope column-5" style="height:100vh; overflow-y:auto">
              <!-- Car items will be injected here by JS -->
          </div>
      </div>
   </div>
  </div>
</section>


<style>
  .fixed-img {
    width: 100%;
    aspect-ratio: 16 / 11;
    object-fit: cover;
  }
  .car-item {
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    background-color: #f9f9f9;
  }
</style>

<script>
const API_URL = "{{ route('cars.filter') }}"; // Laravel route
const container = document.getElementById('car-results');


document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('.filter-option');
  console.log(filters);
    filters.forEach(function (filter) {
        filter.addEventListener('change', function () {
            applyFilters();
        });
    });

      if (!cars.length) {
        container.innerHTML = `
            <section class="error-page page-section-ptb">
              <div class="container">
                <div class="row">
                <div class="col-md-12">
                    <div class="error-content text-center">
                      <img class="img-fluid center-block" style="width: 70%;" src="${error_img}" alt="">
                      <h3 class="text-red">Ooopps:( </h3>
                      <strong class="text-black"> The Car you were looking for, couldn't be found</strong>
                      <p>Can't find what you looking for? Take a moment and do a search again!</p>
                    </div>
                  </div>
                </div>
              </div>
            </section>`;
        return;
      }
    
      cars.forEach(car => {
        const images = JSON.parse(car.images || '[]');
        const imageSrc = images.length ? `/${images[0]}` : '/images/no-image.png';

        const carDiv = document.createElement('div');

        if (isFiltered) {
          // === LIST STYLE ===
          carDiv.className = 'car-grid'

          carDiv.innerHTML = `
           <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="car-item gray-bg text-center">
               <div class="car-image">
                 <img class="img-fluid fixed-img " src="${imageSrc}" alt="">
                 <div class="car-overlay-banner">
                  <ul>
                    <li><a href="#"><i class="fa fa-link"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                   </ul>
                 </div>
               </div>
              </div>
             </div>
              <div class="col-lg-8 col-md-12">
                <div class="car-details">
                <div class="car-title">
                 <a href="#">${car.title}</a>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero numquam repellendus non voluptate. Harum blanditiis ullam deleniti.</p>
                  </div>
                  <div class="price">
                        <span class="old-price">$${car.regular_price}</span>
                        <span class="new-price">$${car.sale_price}</span>
                       <a class="button red float-end" href="#">Details</a>
                     </div>
                   <div class="car-list">
                     <ul class="list-inline">
                       <li><i class="fa fa-registered"></i>${car.year}</li>
                       <li><i class="fa fa-cog"></i> ${car.transmission_type} </li>
                       <li><i class="fa fa-shopping-cart"></i> 6,000 mi</li>
                     </ul>
                   </div>
                  </div>
                </div>
               </div>
          `;
        } else {
          // === DEFAULT GRID STYLE ===
          carDiv.className = 'grid-item';

          carDiv.innerHTML = `
            <div class="car-item gray-bg text-center">
              <div class="car-image">
                <img class="img-fluid fixed-img" src="${imageSrc}" alt="">
                <div class="car-overlay-banner">
                  <ul>
                    <li><a href="#"><i class="fa fa-link"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="car-list">
                <ul class="list-inline">
                  <li><i class="fa fa-registered"></i> ${car.year}</li>
                  <li><i class="fa fa-cog"></i> ${car.transmission_type}</li>
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
                <a href="#">${car.model}</a>
                <div class="separator"></div>
                <div class="price">
                  <span class="old-price">$${car.regular_price}</span>
                  <span class="new-price">$${car.sale_price}</span>
                </div>
              </div>
            </div>
          `;
        }

        container.appendChild(carDiv);
      });
    })
    .catch(error => {
      console.error('Error fetching cars:', error);
      container.innerHTML = '<p>Failed to load cars.</p>';
    });
}



// ===========================
// Apply Filters
// ===========================
function applyFilters() {
  const formData = new FormData();

  document.querySelectorAll('.filter-option:checked').forEach(input => {
    if (input.value !== '*') {
      const name = input.name.replace('[]', '');
      formData.append(name + '[]', input.value);
    }
  });

  const keyword = document.getElementById('car-search').value;
  if (keyword.trim()) {
    formData.append('keyword', keyword.trim());
  }

  // Add sort option
  const sortValue = document.getElementById('sort-select').value;
  if (sortValue) {
    formData.append('sort', sortValue);
  }

  const queryString = new URLSearchParams(formData).toString();
  fetchFilteredCars(queryString);
}


// ===========================
// Sorting Events
// ===========================

document.getElementById('sort-select').addEventListener('change', function () {
  console.log("ozair"); 
  applyFilters();
});

// ===========================
// DOMContentLoaded Events
// ===========================
      </div>
   </div>
  </div>
</section>

<script>


document.addEventListener('DOMContentLoaded', function () {
  const filters = document.querySelectorAll('.filter-option');

  filters.forEach(filter => {
    filter.addEventListener('change', function () {
      const name = this.name.replace('[]', '');
      const group = document.querySelectorAll(`input[name="${name}[]"]`);
      const allCheckbox = document.querySelector(`#all-${name.toLowerCase()}`);

      if (this.value === '*') {
        if (this.checked) {
          group.forEach(box => {
            if (box !== this) box.checked = false;
          });
        }
        applyFilters();
        return;
      }

      if (this.checked && allCheckbox) {
        allCheckbox.checked = false;
      }

      applyFilters();
    });
  });

  // Search Input Live
  const searchInput = document.getElementById('car-search');
  searchInput.addEventListener('input', function () {
    applyFilters();
  });

  // Initial Load
  fetchFilteredCars();
});

// ===========================
// Collapsible Filter Section
// ===========================
document.addEventListener("DOMContentLoaded", function () {
  const items = document.querySelectorAll(".list-group-item > a");

  items.forEach(function (item) {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const submenu = this.nextElementSibling;
      submenu.style.display = submenu.style.display === "block" ? "none" : "block";
    });
  });
});
</script>

 @endsection
