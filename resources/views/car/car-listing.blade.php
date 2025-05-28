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

        /* ... your existing styles ... */


        .view-toggle button {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-toggle button.active {
            background: #db2d2e;
            color: white;
            border-color: #db2d2e;
        }

        .view-toggle button:hover:not(.active) {
            background: #f5f5f5;
        }

        .fixed-img {
            width: 100%;
            aspect-ratio: 16 / 11;
            object-fit: cover;
        }

        .car-item {
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .search-page {
            position: relative;
            margin-bottom: 15px;
        }

        .search-results-container {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .search-result-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .search-result-item img {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 3px;
        }

        .search-result-info {
            flex-grow: 1;
        }

        .search-result-title {
            font-weight: 500;
            margin-bottom: 2px;
        }

        .search-result-price {
            color: #db2d2e;
            font-size: 0.9em;
        }

        .show-all-results {
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
            font-weight: 500;
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
                                    <div class="search-page position-relative">
                                        <input type="text" id="general-search" class="form-control"
                                            placeholder="Search your desired car...">
                                        <div id="search-results" class="search-results-container"></div>
                                        <a href="#" class="search-icon">
                                            <i class="fa fa-search"></i>
                                        </a>
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
            <div class="row g-0 p-2">
                <div class="col-md-2 p-2">
                    <div class="listing-sidebar scrollbar" data-sticky_column>
                        <div class="widget">
                            <div class="widget-search">
                                <h5>Advanced Search</h5>
                                <ul class="list-style-none">
                                    <li><i class="fa fa-star"> </i> Results Found <span class="float-end">(39)</span></li>
                                    <li><i class="fa fa-shopping-cart"> </i> Compare Vehicles <span
                                            class="float-end">(10)</span></li>
                                </ul>
                            </div>
                            <div class="clearfix">
                                <ul class="list-group">
                                    {{-- filter --}}
                                    @php
                                        $years = range(1990, now()->year);
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
                <div class="col-md-10 p-2 ">
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
                                    <div class="d-flex align-items-end gap-3">
                                        <div class="view-toggle d-flex align-items-center gap-3 justify-content-center"
                                            style="margin-bottom: 5px">
                                            <button class="btn btn-sm active" id="grid-view">
                                                <i class="fa fa-th"></i>
                                            </button>
                                            <button class="btn btn-sm" id="list-view">
                                                <i class="fa fa-list"></i>
                                            </button>
                                        </div>

                                        <div class="flex-grow-1">
                                            <span>Sort by</span>
                                            <select class="form-control" id="sort-select" name="sort">
                                                <option value="">Sort by Default</option>
                                                <option value="name">Sort by Name</option>
                                                <option value="price">Sort by Price</option>
                                                <option value="date">Sort by Date</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-xxl-2 col-md-12">
                                <div class="price-search">
                                    <span>Search cars</span>
                                    <div class="search">
                                        <i class="fa fa-search"></i>
                                        <input type="search" id="car-search" class="form-control placeholder"
                                            placeholder="Search....">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="car-results" class="isotope column-5">
                        <!-- Car items will be injected here by JS -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="module">
        $("#sort-select").on('change', function() {
            applyFilters();
        });
        $("#general-search").on('input', function() {
            const keyword = $(this).val().trim();
            const resultsContainer = $('#search-results');

            if (keyword.length < 2) {
                resultsContainer.hide().empty();
                return;
            }

            axios.get(`/car/search?keyword=${keyword}&limit=4`)
                .then(response => {
                    const results = response.data.slice(0, 4); // Get first 4 results
                    resultsContainer.empty();

                    if (results.length === 0) {
                        resultsContainer.html('<div class="search-result-item">No results found</div>');
                        resultsContainer.show();
                        return;
                    }

                    results.forEach(car => {
                        const carDiv = $('<div>').addClass('search-result-item');
                        carDiv.html(`
                            <img src="/${JSON.parse(car.images)[0]}" style="object-fit: cover; " alt="${car.title}">
                            <div class="search-result-info">
                                <div class="search-result-title">${car.year} ${car.make} ${car.model}</div>
                                <div class="search-result-vin">VIN: ${car.VIN_number}</div>
                                <div class="search-result-price">$${car.sale_price}</div>
                            </div>
                        `);
                        carDiv.click(() => window.location.href = `/cars/${car.id}`);
                        resultsContainer.append(carDiv);
                    });

                    // Add "Show all" link if there are more results
                    if (response.data.length > 4) {
                        const showAll = $('<div>').addClass('show-all-results');
                        showAll.html(
                            `<a href="/cars/search?q=${keyword}">Show all ${response.data.length} results</a>`
                        );
                        resultsContainer.append(showAll);
                    }

                    resultsContainer.show();
                })
                .catch(error => {
                    console.error('Error fetching cars:', error);
                    resultsContainer.html('<div class="search-result-item">Error loading results</div>').show();
                });
        });

        // Hide results when clicking outside
        $(document).click(function(e) {
            if (!$(e.target).closest('.search-page').length) {
                $('#search-results').hide();
            }
        });

        // Hide results when pressing ESC
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                $('#search-results').hide();
            }
        });

        const API_URL = "{{ route('cars.filter') }}"; // Laravel route
        const container = document.getElementById('car-results');
        let currentView = 'grid'; // Default view

// ===========================
// Fetch & Render Cars
// ===========================

        function fetchFilteredCars(query = '') {
            axios.get(API_URL + '?' + query)
                .then(response => {
                    const cars = response.data;
                    container.innerHTML = '';
                    const error_img = `/images/car/23.png`;

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

                    $.each(cars, function(index, car) {
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
    <section class="car-listing-sidebar product-listing" data-sticky_parent>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="car-listing-sidebar-left">
                    <div class="listing-sidebar scrollbar" data-sticky_column>
                        <div class="widget">
                            <div class="widget-search">
                                <h5>Advanced Search</h5>
                                <ul class="list-style-none">
                                    <li><i class="fa fa-star"> </i> Results Found <span class="float-end">(39)</span></li>
                                    <li><i class="fa fa-shopping-cart"> </i> Compare Vehicles <span
                                            class="float-end">(10)</span></li>
                                </ul>
                            </div>
                            <div class="clearfix">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="#">Year</a>
                                        <ul>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input filter-option" type="checkbox"
                                                        value="*" id="invalidCheck01" required>
                                                    <label class="form-check-label" for="invalidCheck01">
                                                        All Years
                                                    </label>
                                                </div>
                                            </li>
                                            @for ($year = 2000; $year <= now()->year; $year++)
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input filter-option" type="checkbox"
                                                            name="year" value="{{ $year }}"
                                                            id="year{{ $year }}">
                                                        <label class="form-check-label"
                                                            for="year{{ $year }}">{{ $year }}</label>
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
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck09" required>
                                                    <label class="form-check-label" for="invalidCheck09">
                                                        All Conditions
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck10" required>
                                                    <label class="form-check-label" for="invalidCheck10">
                                                        Brand New
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck11" required>
                                                    <label class="form-check-label" for="invalidCheck11">
                                                        Slightly Used
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck12" required>
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
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck13" required>
                                                    <label class="form-check-label" for="invalidCheck13">
                                                        All Body Styles
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck14" required>
                                                    <label class="form-check-label" for="invalidCheck14">
                                                        2dr Car
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck15" required>
                                                    <label class="form-check-label" for="invalidCheck15">
                                                        4dr Car
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck16" required>
                                                    <label class="form-check-label" for="invalidCheck16">
                                                        Convertible
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck17" required>
                                                    <label class="form-check-label" for="invalidCheck17">
                                                        Sedan
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck18" required>
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
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck19" required>
                                                    <label class="form-check-label" for="invalidCheck19">
                                                        All Models
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck20" required>
                                                    <label class="form-check-label" for="invalidCheck20">
                                                        3-Series
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck21" required>
                                                    <label class="form-check-label" for="invalidCheck21">
                                                        Boxster
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck22" required>
                                                    <label class="form-check-label" for="invalidCheck22">
                                                        Carrera
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck23" required>
                                                    <label class="form-check-label" for="invalidCheck23">
                                                        Cayenne
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck24" required>
                                                    <label class="form-check-label" for="invalidCheck24">
                                                        F-type
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck25" required>
                                                    <label class="form-check-label" for="invalidCheck25">
                                                        GT-R
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck26" required>
                                                    <label class="form-check-label" for="invalidCheck26">
                                                        GTS
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck27" required>
                                                    <label class="form-check-label" for="invalidCheck27">
                                                        M6
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck28" required>
                                                    <label class="form-check-label" for="invalidCheck28">
                                                        Macan
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck29" required>
                                                    <label class="form-check-label" for="invalidCheck29">
                                                        Mazda6
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck30" required>
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
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck52" required>
                                                    <label class="form-check-label" for="invalidCheck52">
                                                        All Transmissions
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck31" required>
                                                    <label class="form-check-label" for="invalidCheck31">
                                                        5-Speed Manual
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck32" required>
                                                    <label class="form-check-label" for="invalidCheck32">
                                                        6-Speed Automatic
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck33" required>
                                                    <label class="form-check-label" for="invalidCheck33">
                                                        6-Speed Manual
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck34" required>
                                                    <label class="form-check-label" for="invalidCheck34">
                                                        6-Speed Semi-Auto
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck35" required>
                                                    <label class="form-check-label" for="invalidCheck35">
                                                        7-Speed PDK
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck36" required>
                                                    <label class="form-check-label" for="invalidCheck36">
                                                        8-Speed Automatic
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck37" required>
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
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck38" required>
                                                    <label class="form-check-label" for="invalidCheck38">
                                                        Ruby Red Metallic
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck39" required>
                                                    <label class="form-check-label" for="invalidCheck39">
                                                        Racing Yellow
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck40" required>
                                                    <label class="form-check-label" for="invalidCheck40">
                                                        Guards Red
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck41" required>
                                                    <label class="form-check-label" for="invalidCheck41">
                                                        Aqua Blue Metallic
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck42" required>
                                                    <label class="form-check-label" for="invalidCheck42">
                                                        White
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck43" required>
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
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck44" required>
                                                    <label class="form-check-label" for="invalidCheck44">
                                                        Platinum Grey
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck45" required>
                                                    <label class="form-check-label" for="invalidCheck45">
                                                        Agate Grey
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck46" required>
                                                    <label class="form-check-label" for="invalidCheck46">
                                                        Marsala Red
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck47" required>
                                                    <label class="form-check-label" for="invalidCheck47">
                                                        Alcantara Black
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck48" required>
                                                    <label class="form-check-label" for="invalidCheck48">
                                                        Black
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="invalidCheck49" required>
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
        ${currentView === 'list' ? '</div>' : ''}
    `;

                        carDiv.html(html);
                        $('#car-results').append(carDiv);
                    });

                })
                .catch(error => {
                    console.error('Error fetching cars:', error);
                    container.innerHTML = '<p>Failed to load cars.</p>';
                });
        }

        function applyFilters() {
            const formData = new FormData();
            document.querySelectorAll('.filter-option:checked').forEach(input => {
                if (input.value !== '*') {
                    const name = input.name.replace('[]', '');
                    formData.append(name + '[]', input.value);
                }
            });

            const keyword = document.getElementById('car-search').value;
            if (keyword.trim()) formData.append('keyword', keyword.trim());

            const sortValue = document.getElementById('sort-select').value;
            if (sortValue) formData.append('sort', sortValue);

            fetchFilteredCars(new URLSearchParams(formData).toString());
        }


        // ===========================
        // Sorting Events
        // ===========================

        document.getElementById('sort-select').addEventListener('change', function() {
            console.log("ozair");
            applyFilters();
        });

// ===========================
// DOMContentLoaded Events
// ===========================
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

            filters.forEach(filter => {
                filter.addEventListener('change', function() {
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
    const filters = document.querySelectorAll('.filter-option');
  console.log(filters);
    filters.forEach(function (filter) {
        filter.addEventListener('change', function () {
            applyFilters();
        });
    });

            // Search Input Live
            const searchInput = document.getElementById('car-search');
            searchInput.addEventListener('input', function() {
                applyFilters();
            });

            // Search handler
            // document.getElementById('car-search').addEventListener('input', () => applyFilters());
            $("#car-search").on('input', () => applyFilters());

            // Collapsible filters
            // document.querySelectorAll(".list-group-item > a").forEach(item => {
            //     item.addEventListener("click", function(e) {
            //         e.preventDefault();
            //         const submenu = this.nextElementSibling;
            //         submenu.style.display = submenu.style.display === "block" ? "none" : "block";
            //     });
            // });
            $(".list-group-item > a").on('click', function(e) {
                e.preventDefault();
                const submenu = $(this).next();
                submenu.toggle();
            });
            // Initial load
            fetchFilteredCars();
        });

// ===========================
// Collapsible Filter Section
// ===========================
document.addEventListener("DOMContentLoaded", function () {
  const items = document.querySelectorAll(".list-group-item > a");
            function applyFilters() {
                const params = new URLSearchParams();

                document.querySelectorAll('.filter-option:checked').forEach((input) => {
                    params.append(input.name, input.value);
                });

                fetch(`{{ route('cars.filter') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Clear entire results container
                        const resultsContainer = document.getElementById('car-results');
                        resultsContainer.innerHTML = '';

                        // Create temporary container
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;

                        // Extract only grid items
                        const gridItems = tempDiv.querySelectorAll('.grid-item');

                        // Append only car items to results
                        gridItems.forEach(item => {
                            resultsContainer.appendChild(item);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('car-results').innerHTML = `
            <div class="alert alert-danger">
                Error loading results: ${error.message}
            </div>
        `;
                    });
            }
        });
        // ***************************************************************************
        document.addEventListener("DOMContentLoaded", function() {
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
            items.forEach(function(item) {
                item.addEventListener("click", function(e) {
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
