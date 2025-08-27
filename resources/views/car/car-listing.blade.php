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

        /* .search-result-item img {
                            width: 60px;
                            height: 40px;
                            object-fit: cover;
                            border-radius: 3px;
                        } */

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

        .link-style {
            display: block;
            border-radius: none !important;
            border: none !important;
        }

        .link-style:hover {
            background-color: none !;
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
                                    {{-- <x-car-filter name="Year" label="All Years" :options="$years" />
                                    <x-car-filter name="Make" label="All Company" :options="$distinctValues['make']" />
                                    <x-car-filter name="Transmission" label="All Transmission" :options="$distinctValues['transmissions']" />
                                    <x-car-filter name="Body" label="All Body Styles" :options="$distinctValues['body_type']" />
                                    <x-car-filter name="Model" label="All Models" :options="$distinctValues['models']" />
                                    <x-car-filter name="Color" label="All Color" :options="$distinctValues['colors']" /> --}}
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
                                        {{-- <label for="amount">Price Range</label> --}}
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
                        const imageSrc = `/storage/${car.images[0]}`;
                        carDiv.html(`
                                        <img src="${imageSrc}" style="object-fit: cover;width: 80px;height: 80px;" alt="${car.title}">
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

        // Search button on the navbar
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const filters = ['Body', 'Make', 'Model', 'Year', 'Transmission', 'Color', 'Condition'];

            filters.forEach(filter => {
                const values = urlParams.getAll(`${filter}[]`);
                values.forEach(val => {
                    $(`input[name="${filter}[]"][value="${val}"]`).prop('checked', true);
                });
            });

            // Optionally trigger filtering after setting checkboxes
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
                            console.log(images);
                        } else {
                            images = car.images ? [car.images] : [];
                        }
                        const imageSrc = images.length ? `/storage/${images[0]}` : '/images/no-image.png';
                        const url = car_show.replace('__ID__', car.id);
                        const carDiv = $(`<a href="${url}" style="color: #a0a0a0">`);
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
        // Block 1: For Body[] (array)
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const hasBody = urlParams.has('Body[]');
            if (!hasBody) return; // Only run if Body[] exists

            const searchInput = document.getElementById('car-search');
            const bodies = urlParams.getAll('Body[]');

            if (bodies.length > 0) {
                searchInput.value = bodies.join(', ');
                fetchFilteredCars(urlParams.toString());
            } else {
                fetchFilteredCars();
            }

            searchInput.addEventListener('input', function() {
                const keyword = searchInput.value.trim();
                if (keyword === '') {
                    fetchFilteredCars();
                } else {
                    const query = new URLSearchParams();
                    query.append('keyword', keyword);
                    fetchFilteredCars(query.toString());
                }
            });
        });

        // Block 2: For make (single value)
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const make = urlParams.get('make');
            if (!make) return; // Only run if 'make' exists

            const searchInput = document.getElementById('car-search');
            searchInput.value = make;

            // 🔁 Trigger search as if user typed it
            const initialQuery = new URLSearchParams();
            initialQuery.append('keyword', make);
            fetchFilteredCars(initialQuery.toString());

            // 🔁 Live input listener for user typing
            searchInput.addEventListener('input', function() {
                const keyword = searchInput.value.trim();
                if (keyword === '') {
                    fetchFilteredCars();
                } else {
                    const query = new URLSearchParams();
                    query.append('keyword', keyword);
                    fetchFilteredCars(query.toString());
                }
            });
        });
    </script>

@endsection
