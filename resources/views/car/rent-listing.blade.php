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
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const API_URL = "{{ route('cars.filter-rent') }}";
        const car_show = "{{ route('car.show', ['id' => '__ID__']) }}";
        const container = document.getElementById('car-results');
        const paginationEl = document.getElementById('pagination');
        let currentView = 'grid';
        let currentPage = 1;
        const perPage = 12;

        function setView(view) {
            currentView = view;
            document.getElementById('grid-view').classList.toggle('active', view === 'grid');
            document.getElementById('list-view').classList.toggle('active', view === 'list');
            applyFilters(1);
        }

        function buildQuery(page = 1) {
            const formData = new FormData();
            document.querySelectorAll('.filter-option:checked').forEach(input => {
                if (input.value !== '*') {
                    const name = input.name.replace('[]', '');
                    formData.append(name + '[]', input.value);
                }
            });

            const keyword = document.getElementById('car-search').value.trim();
            if (keyword) formData.append('keyword', keyword);

            const sortValue = document.getElementById('sort-select').value;
            if (sortValue) formData.append('sort', sortValue);

            formData.append('page', page);
            formData.append('per_page', perPage);
            return new URLSearchParams(formData).toString();
        }

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

        function fetchFilteredCars(query) {
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
                        const imageSrc = images.length ? `/storage/${images[0]}` : '/images/no-image.png';
                        const url = car_show.replace('__ID__', car.id);
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
                                        <div class="price d-flex align-items-center gap-2">
                                            <span class="old-price">Daily $${car.rent_price_per_day ?? ''}</span>
                                            <span class="new-price">30Days $${car.rent_price_per_month ??  ''}</span>
                                        </div>
                                        <div class="car-list">
                                            <ul class="list-inline" style="font-size: 12px;">
                                                <li><i class="fa fa-registered"></i> ${car.year}</li>
                                                <li><i class="fa fa-cog"></i> ${car.transmission_type ?? ''}</li>
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
                    container.innerHTML = '<p>Failed to load cars.</p>';
                });
        }

        function applyFilters(page = 1) {
            const query = buildQuery(page);
            fetchFilteredCars(query);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('grid-view').addEventListener('click', () => setView('grid'));
            document.getElementById('list-view').addEventListener('click', () => setView('list'));
            document.querySelectorAll('.filter-option').forEach(el => el.addEventListener('change', () =>
                applyFilters(1)));
            document.getElementById('car-search').addEventListener('input', () => applyFilters(1));
            document.getElementById('sort-select').addEventListener('change', () => applyFilters(1));
            applyFilters(1);
        });
    </script>
@endsection
