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

        .filter-widget {
            margin-bottom: 20px;
            padding: 10px 0;
        }

        #year-range-slider {
            margin: 10px 5px;
        }

        .link-style {
            display: block;
            border-radius: none !important;
            border: none !important;
        }

        .link-style:hover {
            background-color: none !;
        }

        .filter-widget {
            margin-bottom: 20px;
            padding: 10px 0;
        }

        .link-style {
            display: block;
            border-radius: none !important;
            border: none !important;
        }

        .link-style:hover {
            background-color: none !;
        }

        /* Year Range Filter Styling */
        .filter-widget h6 {
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 15px;
            color: #333;
        }

        #year-range-slider {
            margin: 15px 10px;
            height: 8px;
        }

        #price-range-slider {
            margin: 15px 10px;
            height: 8px;
        }

        .noUi-target {
            background: #e9ecef;
            border-radius: 6px;
            border: none;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .noUi-connect {
            background: #db2d2e;
            border-radius: 6px;
        }

        /* NoUiSlider custom handles */
        .noUi-handle {
            width: 10px;
            /* smaller handle */
            height: 10px;
            /* smaller handle */
            border-radius: 50%;
            /* circle shape */
            background: #fff;
            border: 2px solid #db2d2e;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            cursor: grab;
            transition: all 0.2s ease;
        }

        .noUi-handle:hover {
            background: #db2d2e;
            border-color: #db2d2e;
        }

        /* Hide default pseudo-elements */
        .noUi-handle:before,
        .noUi-handle:after {
            display: none;
        }

        /* Min & Max year labels */
        .year-values {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 500;
            margin-top: 8px;
            color: #444;
        }

        /* ===== Grid view (first style) enhancements - no HTML changes ===== */
        .grid-item .car-item {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.06);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .grid-item .car-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 24, 40, 0.10);
        }

        .grid-item .car-image {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            overflow: hidden;
        }

        .grid-item .car-image img {
            transition: transform .3s ease;
        }

        .grid-item .car-item:hover .car-image img {
            transform: scale(1.03);
        }

        .grid-item .car-content {
            position: relative;
            padding-bottom: 38px;
        }

        .grid-item .price {
            position: absolute;
            right: 10px;
            bottom: 10px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .grid-item .price .old-price {
            color: #9aa3ad;
            text-decoration: line-through;
            font-weight: 600;
            font-size: 12px;
        }

        .grid-item .price .new-price {
            background: linear-gradient(90deg, #e43a3c 0%, #db2d2e 100%);
            color: #fff;
            font-weight: 800;
            border-radius: 10px;
            padding: 5px 12px;
            letter-spacing: .2px;
        }

        /* Pills for small specs within grid cards */
        .grid-item .car-list ul {
            margin-top: 6px;
        }

        .grid-item .car-list ul li {
            display: inline-block;
            background: #f6f7f9;
            border: 1px solid #eef0f3;
            color: #4b5563;
            border-radius: 999px;
            padding: 4px 10px;
            margin-right: 6px;
            margin-bottom: 6px;
            font-size: 12px;
        }

        .grid-item .car-list ul li i {
            color: #9aa3ad;
        }

        /* ================= Modernize GRID view (first style) ================= */
        .grid-item .car-item {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }

        .grid-item .car-item:hover {
            box-shadow: 0 10px 24px rgba(17, 24, 39, 0.10);
            transform: translateY(-1px);
        }

        .grid-item .car-image {
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }

        .grid-item .car-image img {
            transition: transform .35s ease;
        }

        .grid-item .car-item:hover .car-image img {
            transform: scale(1.035);
        }

        /* Move price to top-right and make a neat pill */
        .grid-item .car-content {
            position: relative;
            padding: 12px 14px 16px 14px;
        }

        .grid-item .price {
            position: absolute;
            top: 12px;
            right: 12px;
            margin: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .grid-item .price .old-price {
            font-size: 12px;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 600;
        }

        .grid-item .price .new-price {
            background: linear-gradient(90deg, #ef4444 0%, #db2d2e 100%);
            color: #ffffff;
            border-radius: 999px;
            padding: 6px 12px;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: .2px;
            box-shadow: 0 6px 16px rgba(219, 45, 46, 0.22);
        }

        /* Cleaner chips */
        .grid-item .car-list ul {
            margin-top: 8px;
        }

        .grid-item .car-list ul li {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            color: #374151;
            border-radius: 999px;
            padding: 4px 10px;
            margin: 0 6px 6px 0;
            font-size: 12px;
        }

        .grid-item .car-list ul li i {
            color: #9ca3af;
        }

        /* ================= Final corrective overrides for GRID view ================= */
        /* Softer elevation */
        .grid-item .car-item {
            box-shadow: 0 1px 6px rgba(17, 24, 39, 0.08) !important;
        }

        .grid-item .car-item:hover {
            box-shadow: 0 8px 18px rgba(17, 24, 39, 0.12) !important;
        }

        /* Put price pill under content at bottom-left */
        .grid-item .car-content {
            position: relative !important;
            padding: 12px 14px 12px 14px !important;
        }

        .grid-item .price {
            position: static !important;
            margin-top: 8px !important;
            gap: 8px !important;
        }

        .grid-item .price .new-price {
            border-radius: 999px !important;
            padding: 6px 12px !important;
        }

        .grid-item .price .old-price {
            font-size: 12px !important;
            color: #9aa3af !important;
            text-decoration: line-through !important;
        }

        /* Subtle gray chips */
        .grid-item .car-list ul {
            margin-top: 8px !important;
        }

        .grid-item .car-list ul li {
            background: #f3f4f6 !important;
            border: 1px solid #eceff3 !important;
            color: #4b5563 !important;
            border-radius: 999px !important;
            padding: 2px 6px !important;
            margin: 0 3px 3px 0 !important;
            font-size: 12px !important;
        }

        .grid-item .car-list ul li i {
            color: #9aa3ad !important;
        }

        /* Make cards look clickable */
        .car-item {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .car-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Ensure compare button doesn't inherit cursor */
        .add-to-compare {
            cursor: pointer !important;
            z-index: 10;
            position: relative;
        }

        .add-to-compare:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
    </style>
    <!--=================================banner -->


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

    <div id="car-list">
        <!-- Filtered cars will be loaded here -->
        {{-- @include('components.feature-car') --}}
    </div>

    <!--=================================
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
                                {{-- <ul class="list-style-none">
                                    <li><i class="fa fa-star"> </i> Results Found <span class="float-end">(39)</span></li>
                                    <li><i class="fa fa-shopping-cart"> </i> Compare Vehicles <span
                                            class="float-end">(10)</span></li>
                                </ul> --}}
                            </div>
                            <div class="clearfix">
                                <ul class="list-group">
                                    {{-- filter --}}
                                    @php
                                        $years = range(1990, now()->year);
                                    @endphp
                                    <div class="filter-widget" style="padding: 10px;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <h6>Year Range</h6>
                                            <button type="button" id="reset-year" class="btn btn-sm btn-light mt-2">All
                                                Years</button>
                                        </div>
                                        <div id="year-range-slider"></div>
                                        <div class="year-values">
                                            <span id="year-min"></span>
                                            <span id="year-max"></span>
                                        </div>
                                    </div>


                                    <x-car-filter name="Make" label="All Company" :options="$distinctValues['make']" />
                                    <x-car-filter name="Transmission" label="All Transmission" :options="$distinctValues['transmissions']" />
                                    <x-car-filter name="Body" label="All Body Styles" :options="$distinctValues['body_type']" />
                                    <x-car-filter name="Model" label="All Models" :options="$distinctValues['models']" />
                                    <x-car-filter name="Color" label="All Color" :options="$distinctValues['colors']" />
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 p-2 ">
                    <div class="sorting-options-main">
                        <div class="row justify-content-between">
                            <div class="col-xl-3 col-md-12">
                                <div class="price-slide filter-widget" style="padding: 10px;">
                                    <label>Price Range</label>
                                    <div id="price-range-slider"></div>
                                    <div class="year-values">
                                        <span id="price-min"></span>
                                        <span id="price-max"></span>
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
                                            {{-- <span>Sort by</span> --}}
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
                                    {{-- <span>Search cars</span> --}}
                                    <div class="search">
                                        <i class="fa fa-search"></i>
                                        <input type="search" id="car-search" class="form-control placeholder"
                                            placeholder="Search Cars....">
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

    <!--===============
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Scripts
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ===============-->

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        $("#sort-select").on('change', function() {
            applyFilters();
        });

        document.getElementById('reset-year').addEventListener('click', () => {
            yearSlider.noUiSlider.set([1990, new Date().getFullYear()]); // reset slider
            fetchFilteredCars(); // reload all cars
        });
        document.addEventListener("DOMContentLoaded", function() {
            const priceSlider = document.getElementById('price-range-slider');
            const priceMin = document.getElementById('price-min');
            const priceMax = document.getElementById('price-max');

            noUiSlider.create(priceSlider, {
                start: [300, 50000],
                connect: true,
                step: 1,
                range: {
                    'min': 300,
                    'max': 50000
                }
            });

            priceSlider.noUiSlider.on('update', function(values) {
                priceMin.innerHTML = Math.round(values[0]);
                priceMax.innerHTML = Math.round(values[1]);
            });

            priceSlider.noUiSlider.on('change', function(values) {
                const minPrice = Math.round(values[0]);
                const maxPrice = Math.round(values[1]);

                const formData = new FormData();

                // Add other selected filters
                document.querySelectorAll('.filter-option:checked').forEach(input => {
                    if (input.value !== '*') {
                        const name = input.name.replace('[]', '');
                        formData.append(name + '[]', input.value);
                    }
                });

                // ✅ send price_min and price_max
                formData.append('price_min', minPrice);
                formData.append('price_max', maxPrice);

                fetchFilteredCars(new URLSearchParams(formData).toString());
            });


        });

        document.addEventListener("DOMContentLoaded", function() {
            const yearSlider = document.getElementById('year-range-slider');
            const yearMin = document.getElementById('year-min');
            const yearMax = document.getElementById('year-max');

            noUiSlider.create(yearSlider, {
                start: [1990, new Date().getFullYear()],
                connect: true,
                step: 1,
                range: {
                    'min': 1990,
                    'max': new Date().getFullYear()
                }
            });

            yearSlider.noUiSlider.on('update', function(values) {
                yearMin.innerHTML = Math.round(values[0]);
                yearMax.innerHTML = Math.round(values[1]);
            });

            yearSlider.noUiSlider.on('change', function(values) {
                const minYear = Math.round(values[0]);
                const maxYear = Math.round(values[1]);

                const formData = new FormData();

                // Add other selected filters
                document.querySelectorAll('.filter-option:checked').forEach(input => {
                    if (input.value !== '*') {
                        const name = input.name.replace('[]', '');
                        formData.append(name + '[]', input.value);
                    }
                });

                // Push all years in range to 'Year[]'
                const years = [];
                for (let y = minYear; y <= maxYear; y++) {
                    years.push(y);
                }
                years.forEach(y => formData.append('Year[]', y));

                fetchFilteredCars(new URLSearchParams(formData).toString());
            });

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
                        const imageSrc = `/storage/${car.images[0]}`;
                        carDiv.html(`
                                        <img src="${imageSrc}" style="object-fit: cover;width: 80px;height: 80px;" alt="${car.title}">
                                        <div class="search-result-info">
                                            <div class="search-result-title">${car.year} ${car.make} ${car.model}</div>
                                            <div class="search-result-vin">VIN: ${car.VIN_number}</div>
                                            <div class="search-result-price">$${car.sale_price}</div>
                                        </div>
                                    `);
                        carDiv.click(() => window.location.href = `/car/show/${car.id}`);
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

        // Search button on the navbar
        document.addEventListener('DOMContentLoaded', function() {
            // Get query string from current page
            const urlParams = new URLSearchParams(window.location.search);

            // Pre-check the filters in the sidebar if needed
            const filters = ['Body', 'Make', 'Model', 'Year', 'Transmission', 'Color', 'Condition'];
            filters.forEach(filter => {
                const values = urlParams.getAll(`${filter}[]`);
                values.forEach(val => {
                    $(`input[name="${filter}[]"][value="${val}"]`).prop('checked', true);
                });
            });
            // 🔥 This is the missing part:
            fetchFilteredCars(urlParams.toString());
        });



        // Hide results when pressing ESC
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                $('#search-results').hide();
            }
        });

        const API_URL = "{{ route('cars.filter') }}"; // Laravel route
        const car_show = "{{ route('car.show', ['id' => '__ID__']) }}";
        const container = document.getElementById('car-results');
        let currentView = 'grid'; // Default view

        function setView(view) {
            currentView = view;
            $("#grid-view").toggleClass('active', view === 'grid');
            $("#list-view").toggleClass('active', view === 'list');
            applyFilters();
        }

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
                        let images;
                        // try {
                        //     images = JSON.parse(car.images || '[]');
                        // } catch (e) {
                        //     console.log('second')
                        //     // If parsing fails, treat it as a single string
                        //     images = car.images ? [car.images] : [];
                        // }
                        // if images are json
                        if (typeof car.images === 'object') {
                            images = car.images;

                        } else {
                            images = car.images ? [car.images] : [];
                        }
                        const imageSrc = images.length ? `/storage/${images[0]}` : '/images/no-image.png';
                        const url = car_show.replace('__ID__', car.id);
                        const carDiv = $(`<div style="color: #a0a0a0">`);
                        const title = `<h4>${car.title}</h4>`;
                        const details_button = `
                        <div>
                            <a class="button red float-end" href="${url}">Details</a>
                        </div>`;
                        const description =
                            `${ car.description == null ? "<p style='line-height: 1.3'>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia itaque modi aperiam sequi ea expedita eius minus!</p>" : car.description}`
                        const details = `
                                <div class="row" style="margin-bottom: 6px;">
                            <div class="col-lg-2 col-sm-4">
                                <ul class="list-style-1">
                                    <li><i class="fa fa-check"></i> ${car.make}</li>
                                    <li><i class="fa fa-check"></i> ${car.model}</li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <ul class="list-style-1">
                                    <li><i class="fa fa-check"></i> ${car.car_condition}</li>
                                    <li><i class="fa fa-check"></i> ${car.VIN_number}</li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <ul class="list-style-1">
                                    <li><i class="fa fa-check"></i> ${car.currency_type} </li>
                                     <li><i class="fa fa-check"></i>inside color - ${car.car_inside_color}</li>
                                </ul>
                            </div>
                        </div>`

                        // Set dynamic class based on view
                        carDiv.addClass(currentView === 'list' ? 'car-grid mb-3' : 'grid-item py-2 gap-1');
                        // Build HTML dynamically
                        let html = `
                    ${currentView === 'list' ? '<div class="row p-2">' : ''}

                        <div class="${currentView === 'list' ? 'col-lg-4 col-md-12' : ''}">

                            <div class="car-item gray-bg text-center">
                                <div class="car-image">
                                    <img class="img-fluid fixed-img" src="${imageSrc}" alt="${car.title}">
                                    <div class="car-overlay-banner">
                                        <ul>
                                            <li><a href="${url}"><i class="fa fa-link"></i></a></li>
                                            <li><a href="${url}"><i class="fa fa-shopping-cart"></i></a></li>
                                              <li class="add-to-compare btn btn-danger rounded-circle p-2 shadow-sm" data-car-id="${car.id}" style="list-style: none; cursor: pointer; z-index: 100; position: relative;">
    <i class="fa fa-exchange-alt" style="font-size: 1rem;"></i>
</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="${currentView === 'list' ? 'col-lg-8 col-md-12' : ''}">
                            <div class="${currentView === 'list' ? 'car-details' : 'car-content'}">
                                ${currentView === 'list'
                                ? `                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `
                                : `                                                                                                                                                                                                                                                                                  `
                            }
                                ${currentView == 'list' ? title: ""}
                                ${currentView == 'list' ? description  : ""}
                                ${currentView == 'list' ? details : ""}
                                <div class="price">
                                     ${currentView === 'list' ? details_button : ''}
                                    <span class="old-price">$${car.regular_price}</span>
                                    <span class="new-price">$${car.sale_price}</span>
                                </div>
                                <div class="car-list">
                                    <ul class="list-inline" style="font-size: 12px;">
                                        <li><i class="fa fa-registered"></i> ${car.year}</li>
                                        <li><i class="fa fa-cog"></i> ${car.transmission_type}</li>
                                        <li><i class="fa fa-shopping-cart"></i> 6,000 mi</li>
                                    </ul>
                               <div class="compare-btn">
</div>

                                </div>
                            </div>
                        </div>
                    ${currentView === 'list' ? '</div>' : ''}
                `;

                        carDiv.html(html);

                        // Add click handler to make the card clickable (excluding compare button)
                        carDiv.on('click', function(e) {
                            // Don't redirect if clicking on compare button or its children
                            if (e.target.closest('.add-to-compare')) {
                                return;
                            }
                            window.location.href = url;
                        });

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

        document.addEventListener('DOMContentLoaded', function() {
            // View toggle handlers
            $("#grid-view").click(function() {
                setView('grid');
            });
            $("#list-view").click(function() {
                setView('list');
            });

            // Filter handlers
            $(".filter-option").change(function() {
                const name = $(this).attr('name').replace('[]', '');
                const group = $(`input[name="${name}[]"]`);
                const allCheckbox = $(`#all-${name.toLowerCase()}`);

                if ($(this).val() === '*') {
                    if ($(this).is(':checked')) {
                        group.not(this).prop('checked', false);
                    }
                    applyFilters();
                    return;
                }
                if ($(this).is(':checked') && allCheckbox.length) {
                    allCheckbox.prop('checked', false);
                }
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


        // code fo getting the body type filters from the URL and making an API call
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchInput = document.getElementById('car-search');
            const container = document.getElementById('car-results');

            // If Body[] is present, show it in the search bar as a comma separated string
            const bodies = urlParams.getAll('Body[]');
            if (bodies.length > 0) {
                searchInput.value = bodies.join(', ');
                fetchFilteredCars(urlParams.toString());
            } else {
                // Load all cars initially if no filters
                fetchFilteredCars();
            }

            // Listen for input changes on search bar
            searchInput.addEventListener('input', function() {
                const keyword = searchInput.value.trim();

                if (keyword === '') {
                    // If search input is empty, show all cars
                    fetchFilteredCars();
                } else {
                    // Use keyword as filter param, assuming backend supports 'keyword' param for searching Body or other fields
                    // Note: you may want to adapt backend to search body types by keyword or modify this to fit your needs
                    const query = new URLSearchParams();
                    query.append('keyword', keyword);
                    fetchFilteredCars(query.toString());
                }
            });
        });


        // search for make car company code
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchInput = document.getElementById('car-search');
            const container = document.getElementById('car-results');

            // If Body[] is present, show it in the search bar as a comma separated string
            const bodies = urlParams.getAll('make');
            if (bodies.length > 0) {
                searchInput.value = bodies.join(', ');
                fetchFilteredCars(urlParams.toString());
            } else {
                // Load all cars initially if no filters
                fetchFilteredCars();
            }

            // Listen for input changes on search bar
            searchInput.addEventListener('input', function() {
                const keyword = searchInput.value.trim();

                if (keyword === '') {
                    // If search input is empty, show all cars
                    fetchFilteredCars();
                } else {
                    // Use keyword as filter param, assuming backend supports 'keyword' param for searching Body or other fields
                    // Note: you may want to adapt backend to search body types by keyword or modify this to fit your needs
                    const query = new URLSearchParams();
                    query.append('keyword', keyword);
                    fetchFilteredCars(query.toString());
                }
            });
        });


        // storing the count value in local storage
        function getCompareCars() {
            const stored = localStorage.getItem('compareCars');
            if (!stored) return [];

            try {
                const data = JSON.parse(stored);
                // Check if data has expired (5 minutes)
                if (data.timestamp && (Date.now() - data.timestamp) > 5 * 60 * 1000) {
                    localStorage.removeItem('compareCars');
                    return [];
                }
                return data.cars || [];
            } catch (e) {
                return [];
            }
        }

        function setCompareCars(cars) {
            const data = {
                cars: cars,
                timestamp: Date.now()
            };
            localStorage.setItem('compareCars', JSON.stringify(data));
        }

        // Update compare icon count in navbar
        function updateCompareIcon() {
            const count = getCompareCars().length;
            const icon = document.querySelector('#compare-count');
            if (icon) {
                icon.textContent = count;
            }
        }

        // Use event delegation for compare buttons
        document.addEventListener('click', function(e) {


            const compareBtn = e.target.closest('.add-to-compare');


            if (compareBtn) {
                e.preventDefault();
                e.stopPropagation();

                const carId = compareBtn.dataset.carId;

                let compareCars = getCompareCars();

                if (compareCars.includes(carId)) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Already Added',
                            text: 'This car is already in the compare list.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        alert('This car is already in the compare list.');
                    }
                    return;
                }

                if (compareCars.length >= 3) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Limit Reached',
                            text: 'Maximum 3 cars allowed to compare.',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    } else {
                        alert('Maximum 3 cars allowed to compare.');
                    }
                    return;
                }

                compareCars.push(carId);
                setCompareCars(compareCars);


                updateCompareIcon();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: 'Car added to compare list.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Car added to compare list!');
                }
            }
        });

        // Initialize count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCompareIcon();
        });
    </script>

@endsection
