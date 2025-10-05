@extends('layouts.layout')
@section('title', 'Cars For Rent')
@section('content')

    <style>
        .fixed-img {
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        .view-toggle button.active {
            background: #db2d2e;
            color: #fff;
            border-color: #db2d2e;
        }

        .red {
            background: #db2d2e;
            color: #fff;
        }

        /* Enhanced Price Styling - Different for Grid and List Views */
        .price-container {
            margin: 10px 0;
        }

        /* Grid View - Simple and Compact Design */
        .grid-item .price-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            border-left: 3px solid #db2d2e;
        }

        .grid-item .price-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 4px 0;
        }

        .grid-item .price-item:last-child {
            margin-bottom: 0;
        }

        .grid-item .price-label {
            font-size: 11px;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
        }

        .grid-item .price-value {
            font-size: 14px;
            font-weight: 600;
            color: #db2d2e;
        }

        .grid-item .price-currency {
            font-size: 12px;
            color: #495057;
        }

        .grid-item .price-badge {
            background: #db2d2e;
            color: white;
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 500;
            margin-left: 5px;
        }

        /* List View - Beautiful and Detailed Design */
        .car-grid .price-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #db2d2e;
        }

        .car-grid .price-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 8px 12px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .car-grid .price-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .car-grid .price-item:last-child {
            margin-bottom: 0;
        }

        .car-grid .price-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .car-grid .price-value {
            font-size: 16px;
            font-weight: 700;
            color: #db2d2e;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .car-grid .price-currency {
            font-size: 14px;
            color: #495057;
        }

        .car-grid .price-icon {
            width: 16px;
            height: 16px;
            background: #db2d2e;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
        }

        .car-grid .price-badge {
            background: linear-gradient(45deg, #db2d2e, #ff4757);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-left: 8px;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .price-container {
                padding: 12px;
            }

            .price-value {
                font-size: 14px;
            }

            .price-label {
                font-size: 11px;
            }
        }

        /* Modern Slider Styles */
        .filter-widget {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); */
            margin-bottom: 20px;
            /* border: 1px solid #eef0f3; */
        }

        .filter-widget h6 {
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-widget h6 button {
            font-size: 12px;
            padding: 4px 8px;
        }

        #year-range-slider,
        #price-range-slider {
            margin: 15px 0;
            height: 6px;
            border-radius: 3px;
            background: #e9ecef;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .noUi-connect {
            background: linear-gradient(90deg, #db2d2e, #ff6b6b);
            border-radius: 3px;
        }

        .noUi-handle {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #db2d2e;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            cursor: grab;
            transition: all 0.2s ease;
            top: -6px;
        }

        .noUi-handle:hover {
            transform: scale(1.1);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        }

        .noUi-handle:before,
        .noUi-handle:after {
            display: none;
        }

        .year-values {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
            color: #db2d2e;
        }

        .year-values span {
            background: #f8f9fa;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid #e9ecef;
        }

        /* Modern Filter Category Styles */
        .filter-category {
            border: none;
            padding: 0;
            margin-bottom: 10px;
        }

        /* .filter-header {
                padding: 12px 15px;
                background: #f8f9fa;
                border-radius: 8px;
                color: #333;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.3s ease;
                border: 1px solid #eef0f3;
            } */

        /* .filter-header:hover {
                background: #e9ecef;
            } */

        /* .filter-header.active {
                background: #db2d2e;
                color: #fff;
                border-color: #db2d2e;
            } */

        .filter-arrow {
            transition: transform 0.3s ease;
        }

        /*
            .filter-header.active .filter-arrow {
                transform: rotate(180deg);
            } */

        .filter-options {
            padding: 15px 10px;
            background: #fff;
            border-radius: 0 0 8px 8px;
            border: 1px solid #eef0f3;
            border-top: none;
        }

        .filter-options li {
            padding: 5px 10px;
        }

        .form-check-input:checked {
            background-color: #db2d2e;
            border-color: #db2d2e;
        }

        .form-check-label {
            font-size: 14px;
            color: #495057;
        }
    </style>

    <section class="slider-parallax bg-overlay-black-50 bg-17">
        <div class="slider-content-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="slider-content text-center">
                            <h2 class="text-white">Find Cars For Rent</h2>
                            <strong class="text-white">White, Black and Red theme.</strong>
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

    <section class="car-listing-sidebar product-listing" data-sticky_parent>
        <div class="container-fluid p-0">
            <div class="row g-0 p-2">
                <div class="col-md-2 p-2">
                    <div class="listing-sidebar scrollbar" data-sticky_column>
                        <div class="widget">
                            <div class="widget-search">
                                <h5>Advanced Search</h5>
                            </div>
                            <div class="clearfix">
                                <ul class="list-group">
                                    @php $years = range(1990, now()->year); @endphp
                                    <div class="filter-widget" style="padding: 10px;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <h6>Year Range</h6>
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
                                            <button class="btn btn-sm active" id="grid-view"><i
                                                    class="fa fa-th"></i></button>
                                            <button class="btn btn-sm" id="list-view"><i class="fa fa-list"></i></button>
                                        </div>
                                        <div class="flex-grow-1">
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
                                    <div class="search">
                                        <i class="fa fa-search"></i>
                                        <input type="search" id="car-search" class="form-control placeholder"
                                            placeholder="Search Cars....">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="car-results" class="isotope column-5"></div>

                    <div class="d-flex justify-content-center mt-3">
                        <nav>
                            <ul id="pagination" class="pagination"></ul>
                        </nav>
                    </div>
                </div>
                <div class="pagination-link" style="display: flex; justify-content: center; margin: 2rem 0 3rem 0;">
                </div>
            </div>
        </div>
    </section>

    <script>
        const API_URL = "{{ route('cars.filter-rent') }}";
        const car_show = "{{ route('car.show', ['id' => '__ID__']) }}";
        const bargain_show = "{{ route('bargains.show', ['id' => '__ID__']) }}";
        const container = document.getElementById('car-results');
        const paginationEl = document.getElementById('pagination');
        let currentView = 'grid';
        let currentPage = 1;
        const perPage = 12;

        // Initialize sliders when DOM is loaded
        document.addEventListener("DOMContentLoaded", function() {
            // Price Range Slider
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
                applyFilters(1);
            });

            // Year Range Slider
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
                applyFilters(1);
            });

            // Reset Year Button
            document.getElementById('reset-year').addEventListener('click', () => {
                yearSlider.noUiSlider.set([1990, new Date().getFullYear()]);
                applyFilters(1);
            });
        });

        function renderPagination(meta) {
            paginationEl.innerHTML = '';
            const {
                current_page,
                last_page
            } = meta;
            if (last_page <= 1) return;

            const createItem = (label, page, disabled = false, active = false) => {
                const li = document.createElement('li');
                li.className = 'page-item ' + (disabled ? 'disabled' : '') + ' ' + (active ? 'active' : '');
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = label;
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!disabled) {
                        applyFilters(page);
                    }
                });
                li.appendChild(a);
                return li;
            };

            paginationEl.appendChild(createItem('«', current_page - 1, current_page === 1));
            for (let i = 1; i <= last_page; i++) {
                paginationEl.appendChild(createItem(i, i, false, i === current_page));
            }
            paginationEl.appendChild(createItem('»', current_page + 1, current_page === last_page));
        }

        function setView(view) {
            currentView = view;
            document.getElementById('grid-view').classList.toggle('active', view === 'grid');
            document.getElementById('list-view').classList.toggle('active', view === 'list');
            applyFilters(1);
        }

        function buildQuery(page = 1) {
            const formData = new FormData();

            // Add checkbox filters
            document.querySelectorAll('.filter-option:checked').forEach(input => {
                if (input.value !== '*') {
                    const name = input.name.replace('[]', '');
                    formData.append(name + '[]', input.value);
                }
            });

            // Add search keyword
            const keyword = document.getElementById('car-search').value.trim();
            if (keyword) formData.append('keyword', keyword);

            // Add sort option
            const sortValue = document.getElementById('sort-select').value;
            if (sortValue) formData.append('sort', sortValue);

            // Add price range
            const priceSlider = document.getElementById('price-range-slider');
            if (priceSlider && priceSlider.noUiSlider) {
                const priceValues = priceSlider.noUiSlider.get();
                const minPrice = Math.round(priceValues[0]);
                const maxPrice = Math.round(priceValues[1]);
                formData.append('price_min', minPrice);
                formData.append('price_max', maxPrice);
            }

            // Add year range
            const yearSlider = document.getElementById('year-range-slider');
            if (yearSlider && yearSlider.noUiSlider) {
                const yearValues = yearSlider.noUiSlider.get();
                const minYear = Math.round(yearValues[0]);
                const maxYear = Math.round(yearValues[1]);

                // Push all years in range to 'Year[]'
                const years = [];
                for (let y = minYear; y <= maxYear; y++) {
                    years.push(y);
                }
                years.forEach(y => formData.append('Year[]', y));
            }

            formData.append('page', page);
            formData.append('per_page', perPage);
            return new URLSearchParams(formData).toString();
        }

        function fetchFilteredCars(query) {
            // Ensure container is available
            if (!container) {
                container = document.getElementById('car-results');
                if (!container) {
                    console.error('Car results container not found');
                    return;
                }
            }

            // Show loading indicator
            container.innerHTML =
                '<div class="text-center py-5"><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading rental cars...</p></div>';

            axios.get(API_URL + '?' + query)
                .then(response => {
                    const res = response.data;
                    const cars = res.data || [];
                    currentPage = res.current_page || 1;
                    container.innerHTML = '';
                    const error_img = `/images/car/23.png`;

                    if (!cars.length) {
                        container.innerHTML = `
                            <section class="error-page page-section-ptb">
                                <div class="container"><div class="row"><div class="col-md-12">
                                    <div class="error-content text-center">
                                        <img class="img-fluid center-block" style="width: 70%;" src="${error_img}" alt="">
                                        <h3 class="text-red">Ooopps:( </h3>
                                        <strong class="text-black">No cars found for rent</strong>
                                    </div>
                                </div></div></div>
                            </section>`;
                        renderPagination({
                            current_page: 1,
                            last_page: 1
                        });
                        return;
                    }

                    cars.forEach(car => {
                        let images = Array.isArray(car.images) ? car.images : (car.images ? [car.images] : []);
                        const imageSrc = images.length ?
                            "{{ asset('storage') }}/" + images[0] :
                            '/images/demo.jpg';
                        const url = car_show.replace('__ID__', car.id);
                        const bargain_url = car.bargain ?
                            bargain_show.replace('__ID__', car.bargain.id) :
                            null;
                        const carDiv = document.createElement('div');
                        carDiv.className = currentView === 'list' ? 'car-grid mb-3' : 'grid-item py-2 gap-1';
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
                                        ${currentView === 'list' ? `<h4>${car.title ?? ''}</h4>` : ''}
                                        <div class="price-container">
                                            <div class="price-item">
                                                <div class="price-label">
                                                    ${currentView === 'list' ? '<span class="price-icon">📅</span>' : ''}
                                                    Daily
                                                </div>
                                                <div class="price-value">
                                                    <span class="price-currency">$</span>${car.rent_price_per_day ?? ''}
                                                    <span class="price-badge">${currentView === 'list' ? 'Per Day' : '/day'}</span>
                                                </div>
                                            </div>
                                            <div class="price-item">
                                                <div class="price-label">
                                                    ${currentView === 'list' ? '<span class="price-icon">📆</span>' : ''}
                                                    Monthly
                                                </div>
                                                <div class="price-value">
                                                    <span class="price-currency">$</span>${car.rent_price_per_month ?? ''}
                                                    <span class="price-badge">${currentView === 'list' ? '30 Days' : '/month'}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="car-list">
                                            <ul class="list-inline" style="font-size: 12px;">
                                                <li><i class="fa fa-registered"></i> ${car.year}</li>
                                                ${currentView == 'list' ? "<li><i class=\"fa fa-cog\"></i> " + (car.transmission_type ?? '') + "</li>" : ''}
                                                <li><i class="fa fa-car"></i> ${car.make ?? ''} ${car.model ?? ''}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            ${currentView === 'list' ? '</div>' : ''}
                        `;
                        carDiv.innerHTML = html;
                        carDiv.addEventListener('click', function(e) {
                            if (e.target.closest('.add-to-compare')) return;
                            window.location.href = url;
                        });
                        container.appendChild(carDiv);
                    });

                    renderPagination(res);
                })
                .catch(error => {
                    console.error('Error fetching cars:', error);
                    // Ensure container is available
                    if (!container) {
                        container = document.getElementById('car-results');
                    }
                    if (container) {
                        container.innerHTML = `
                            <div class="alert alert-danger text-center">
                                <h4>Error Loading Rental Cars</h4>
                                <p>Failed to load rental cars. Please try again later.</p>
                                <button class="btn btn-danger" onclick="applyFilters(1)">Retry</button>
                            </div>`;
                    }
                    renderPagination({
                        current_page: 1,
                        last_page: 1
                    });
                });
        }

        function applyFilters(page = 1) {
            const query = buildQuery(page);
            fetchFilteredCars(query);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize view toggle buttons
            document.getElementById('grid-view').addEventListener('click', () => setView('grid'));
            document.getElementById('list-view').addEventListener('click', () => setView('list'));

            // Initialize filter event listeners
            document.querySelectorAll('.filter-option').forEach(el => el.addEventListener('change', () =>
                applyFilters(1)));
            document.getElementById('car-search').addEventListener('input', () => applyFilters(1));
            document.getElementById('sort-select').addEventListener('change', () => applyFilters(1));

            // Collapsible filters
            document.querySelectorAll('.filter-header').forEach(header => {
                header.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    this.classList.toggle('active');

                    // Simple toggle without animation
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                    } else {
                        submenu.style.display = 'block';
                    }
                });
            });

            // Initial load
            applyFilters(1);
        });
    </script>
@endsection
