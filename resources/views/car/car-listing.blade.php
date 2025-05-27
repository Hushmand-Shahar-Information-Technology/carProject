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
                                        <input type="text" class="form-control"
                                            placeholder="Search your desired car... ">
                                        <a href="#"> <i class="fa fa-search"></i> </a>
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
                                            <select class="form-control" id="sort-select" name="sort"
                                                onchange="applyFilters()">
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


    <style>
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
    </style>
    <script>
        const API_URL = "{{ route('cars.filter') }}"; // Laravel route
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
                        const images = JSON.parse(car.images || '[]');
                        const imageSrc = images.length ? `/${images[0]}` : '/images/no-image.png';
                        const carDiv = $('<div>');

                        // Set dynamic class based on view
                        carDiv.addClass(currentView === 'list' ? 'car-grid mb-3' : 'grid-item p-2');

                        // Build HTML dynamically
                        let html = `
        ${currentView === 'list' ? '<div class="row p-2">' : ''}
            <div class="${currentView === 'list' ? 'col-lg-4 col-md-12' : ''}">
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
                </div>
            </div>

            <div class="${currentView === 'list' ? 'col-lg-8 col-md-12' : ''}">
                <div class="${currentView === 'list' ? 'car-details' : 'car-content'}">
                    ${currentView === 'list' 
                        ? `
                                        <div class="car-title">
                                            <a href="#">${car.title}</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </div>
                                    `
                        : `
                                        <div class="star">
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star orange-color"></i>
                                            <i class="fa fa-star-o orange-color"></i>
                                        </div>
                                        <a href="#">${car.model}</a>
                                        <div class="separator"></div>
                                    `
                    }
                    <div class="price">
                        <span class="old-price">$${car.regular_price}</span>
                        <span class="new-price">$${car.sale_price}</span>
                        ${currentView === 'list' ? '<a class="button red float-end" href="#">Details</a>' : ''}
                    </div>
                    <div class="car-list">
                        <ul class="list-inline">
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
    </script>

@endsection
