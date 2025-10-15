@extends('layouts.layout')

@section('title', 'Car Listings')

@section('content')
<!-- Hero section with search -->
<div class="relative">
    <div class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center p-4"
        style='background-image: linear-gradient(rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuC6axOUEhDD1UQ_hNyo74-blep0Jygg3yfSZo9-X4OCawjY4eSxPeGJ5lMc9_MX_FxmmnOB4a22ZeWBJ9BM-BnBeLQcKoEvfADtNolyOLQ9ySzebWnS0VqdcIu9x5cFDqHwR4gVK08_KPMxwTJyvkaMqTprK-UMyzYsaljUUmyazIPiQTyS6-yhKsdZwoAtLQzgTkfbYVxNOGMhgjiypJYeClWF7ZV34hUKJk84AkehGly-QD4Saub1nR4lfIgNG4zaeKyyMt-VETc");'>
        <div class="flex flex-col gap-2 text-center text-white">
            <h1 class="text-4xl font-black leading-tight tracking-[-0.033em] md:text-5xl">Find Your Dream Car Today</h1>
            <h2 class="text-base font-normal leading-normal md:text-lg">Search by make, model, or keyword</h2>
        </div>
        <label class="flex flex-col min-w-40 h-14 w-full max-w-[480px] md:h-16">
            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                <div
                    class="text-[#617589] flex border border-[#dbe0e6] bg-white dark:bg-gray-800 dark:border-gray-600 items-center justify-center pl-[15px] rounded-l-lg border-r-0">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input id="general-search"
                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-0 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-[#dbe0e6] dark:focus:border-primary h-full placeholder:text-[#617589] dark:placeholder:text-gray-400 px-[15px] rounded-r-none border-r-0 pr-2 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal md:text-base"
                    placeholder="Search by make, model, or keyword" value="" />
                <div
                    class="flex items-center justify-center rounded-r-lg border-l-0 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 pr-[7px]">
                    <button id="search-button"
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 md:h-12 md:px-5 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] md:text-base">
                        <span class="truncate">Search</span>
                    </button>
                </div>
            </div>
        </label>
    </div>
</div>

<!-- Main content with filters and car listings -->
<div class="flex flex-1">
    <!-- Filters sidebar -->
    <aside class="w-1/4 min-w-[280px] p-6 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-700">
        <div class="flex flex-col gap-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Filter Your Search</h3>

            <!-- Year Range Filter -->
            <div class="flex flex-col gap-4">
                <h4 class="font-semibold text-gray-800 dark:text-gray-200">Year</h4>
                <div class="relative">
                    <input id="year-slider" class="w-full custom-slider" type="range" min="1990" max="{{ now()->year }}" value="{{ (1990 + now()->year) / 2 }}" />
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <span id="year-min">1990</span>
                        <span id="year-max">{{ now()->year }}</span>
                    </div>
                </div>
            </div>

            <!-- Price Range Filter -->
            <div class="flex flex-col gap-4">
                <h4 class="font-semibold text-gray-800 dark:text-gray-200">Price Range</h4>
                <div class="relative">
                    <input id="price-slider" class="w-full custom-slider" type="range" min="300" max="50000" value="25000" />
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <span id="price-min">$300</span>
                        <span id="price-max">$50,000</span>
                    </div>
                </div>
            </div>

            <!-- Other Filters -->
            <x-car-filter name="Make" label="All Company" :options="$distinctValues['make']" />
            <x-car-filter name="Transmission" label="All Transmission" :options="$distinctValues['transmissions']" />
            <x-car-filter name="Body" label="All Body Styles" :options="$distinctValues['body_type']" />
            <x-car-filter name="Model" label="All Models" :options="$distinctValues['models']" />
            <x-car-filter name="Color" label="All Color" :options="$distinctValues['colors']" />

            <div class="flex flex-col gap-2 mt-4">
                <button id="apply-filters"
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] w-full">
                    <span class="truncate">Apply Filters</span>
                </button>
                <button id="reset-filters"
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-bold leading-normal tracking-[0.015em] w-full">
                    <span class="truncate">Reset</span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main content area -->
    <main class="flex-1 p-6">
        <!-- Top bar with results count and sorting options -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-600 dark:text-gray-400">Showing <span id="results-count">0</span> results</p>
            <div class="flex items-center gap-4">
                <button id="compare-button"
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] gap-2">
                    <span class="material-symbols-outlined">compare_arrows</span>
                    <span class="truncate">Compare (<span id="compare-count">0</span>)</span>
                </button>
                <label class="flex items-center gap-2">
                    <span class="text-sm font-medium">Sort by:</span>
                    <select id="sort-select"
                        class="form-select flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-0 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:border-primary h-10 p-2 text-sm font-normal">
                        <option value="">Default</option>
                        <option value="name">Name (A-Z)</option>
                        <option value="price">Price (Low-High)</option>
                        <option value="date">Newest First</option>
                    </select>
                </label>
            </div>
        </div>

        <!-- Search bar -->
        <div class="mb-6">
            <input type="search" id="car-search" class="form-control w-full p-2 border border-gray-300 rounded"
                placeholder="Search Cars....">
        </div>

        <!-- Car listings container -->
        <div id="car-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Car items will be injected here by JS -->
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center p-4 mt-8" id="pagination-container">
            <!-- Pagination will be injected here by JS -->
        </div>
    </main>
</div>

<!-- Search results container -->
<div id="search-results" class="search-results-container"></div>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<script>
    // Tailwind config
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#1173d4",
                    "background-light": "#f6f7f8",
                    "background-dark": "#101922",
                },
                fontFamily: {
                    "display": ["Inter", "sans-serif"]
                },
                borderRadius: {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
                },
            },
        },
    }
</script>

<style>
    .material-symbols-outlined {
        font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
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

    /* Slider styles with circular handles and end circles */
    .custom-slider {
        -webkit-appearance: none;
        width: 100%;
        height: 6px;
        border-radius: 3px;
        background: #e9ecef;
        outline: none;
        margin: 15px 0;
        position: relative;
    }

    .custom-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #1173d4;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 2;
    }

    .custom-slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #1173d4;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    /* Add circles at both ends of the slider track */
    .custom-slider::before,
    .custom-slider::after {
        content: "";
        position: absolute;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #1173d4;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }

    .custom-slider::before {
        left: 0;
        margin-left: -6px; /* Half of the width to center on edge */
    }

    .custom-slider::after {
        right: 0;
        margin-right: -6px; /* Half of the width to center on edge */
    }

    /* Car item styles */
    .fixed-img {
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
    }

    .car-item {
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .car-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Auction badge */
    .auction-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(45deg, #ff9800, #ff5722);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    /* Compare button */
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

<script>
    const API_URL = "{{ route('cars.filter') }}"; // Laravel route
    const car_show = "{{ route('car.show', ['id' => '__ID__']) }}";
    const bargain_show = "{{ route('bargains.show', ['id' => '__ID__']) }}";
    let container = null;
    let lastQuery = '';
    let currentPage = 1;
    const perPage = 12;

    // Initialize container after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        container = document.getElementById('car-results');
        if (!container) {
            console.error('Car results container not found');
            return;
        }

        // Initialize sliders
        initSliders();

        // Initialize event listeners
        initEventListeners();

        // Initial load
        fetchFilteredCars();
    });

    function initSliders() {
        // Price Range Slider
        const priceSlider = document.getElementById('price-slider');
        const priceMin = document.getElementById('price-min');
        const priceMax = document.getElementById('price-max');

        // Ensure min/max attributes are set correctly
        if (priceSlider) {
            // Make sure min/max are properly set as numbers
            const min = parseInt(priceSlider.min) || 300;
            const max = parseInt(priceSlider.max) || 50000;
            const value = parseInt(priceSlider.value) || 25000;

            priceSlider.min = min;
            priceSlider.max = max;
            priceSlider.value = value;

            priceSlider.addEventListener('input', function() {
                const currentValue = parseInt(this.value);
                priceMin.textContent = '$' + currentValue.toLocaleString();
            });

            // Set initial value display
            priceMin.textContent = '$' + value.toLocaleString();
            priceMax.textContent = '$' + max.toLocaleString();
            console.log('Price slider initialized:', {min, max, value}); // Debug line
        }

        // Year Range Slider
        const yearSlider = document.getElementById('year-slider');
        const yearMin = document.getElementById('year-min');
        const yearMax = document.getElementById('year-max');

        // Ensure min/max attributes are set correctly
        if (yearSlider) {
            // Make sure min/max are properly set as numbers
            const min = parseInt(yearSlider.min) || 1990;
            const max = parseInt(yearSlider.max) || new Date().getFullYear();
            const value = parseInt(yearSlider.value) || Math.floor((1990 + new Date().getFullYear()) / 2);

            yearSlider.min = min;
            yearSlider.max = max;
            yearSlider.value = value;

            yearSlider.addEventListener('input', function() {
                yearMin.textContent = this.value;
            });

            // Set initial value display
            yearMin.textContent = value;
            yearMax.textContent = max;
            console.log('Year slider initialized:', {min, max, value}); // Debug line
        }
    }

    function initEventListeners() {
        // Filter handlers
        document.querySelectorAll('.filter-option').forEach(input => {
            input.addEventListener('change', function() {
                const name = this.name.replace('[]', '');
                const group = document.querySelectorAll(`input[name="${name}[]"]`);
                const allCheckbox = document.getElementById(`all-${name.toLowerCase()}`);

                if (this.value === '*') {
                    if (this.checked) {
                        group.forEach(el => {
                            if (el !== this) el.checked = false;
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

        // Search handlers
        document.getElementById('car-search').addEventListener('input', applyFilters);
        document.getElementById('general-search').addEventListener('input', handleGeneralSearch);
        document.getElementById('search-button').addEventListener('click', function(e) {
            e.preventDefault();
            const keyword = document.getElementById('general-search').value.trim();
            if (keyword) {
                document.getElementById('car-search').value = keyword;
                applyFilters();
            }
        });

        // Sort handler
        document.getElementById('sort-select').addEventListener('change', applyFilters);

        // Compare button
        document.getElementById('compare-button').addEventListener('click', function() {
            window.location.href = "{{ route('car.compare') }}";
        });

        // Apply and reset filter buttons
        document.getElementById('apply-filters').addEventListener('click', applyFilters);
        document.getElementById('reset-filters').addEventListener('click', resetFilters);

        // Slider change handlers for real-time filtering (only attach once)
        const priceSlider = document.getElementById('price-slider');
        if (priceSlider && !priceSlider.dataset.listenerAttached) {
            priceSlider.addEventListener('change', applyFilters);
            priceSlider.dataset.listenerAttached = 'true';
        }

        const yearSlider = document.getElementById('year-slider');
        if (yearSlider && !yearSlider.dataset.listenerAttached) {
            yearSlider.addEventListener('change', applyFilters);
            yearSlider.dataset.listenerAttached = 'true';
        }

        // Collapsible filters
        document.querySelectorAll('.list-group-item > a').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            });
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-page')) {
                document.getElementById('search-results').style.display = 'none';
            }
        });

        // Hide search results when pressing ESC
        document.addEventListener('keyup', function(e) {
            if (e.key === "Escape") {
                document.getElementById('search-results').style.display = 'none';
            }
        });
    }

    function handleGeneralSearch() {
        const keyword = this.value.trim();
        const resultsContainer = document.getElementById('search-results');

        if (keyword.length < 2) {
            resultsContainer.style.display = 'none';
            resultsContainer.innerHTML = '';
            return;
        }

        axios.get(`/car/search?keyword=${keyword}&limit=4`)
            .then(response => {
                const results = response.data.slice(0, 4); // Get first 4 results
                resultsContainer.innerHTML = '';

                if (results.length === 0) {
                    resultsContainer.innerHTML = '<div class="search-result-item">No results found</div>';
                    resultsContainer.style.display = 'block';
                    return;
                }

                results.forEach(car => {
                    const carDiv = document.createElement('div');
                    carDiv.className = 'search-result-item';

                    // Handle images
                    let images = Array.isArray(car.images) ? car.images : (car.images ? [car.images] : []);
                    const imageSrc = images.length ?
                        (images[0].startsWith('http') ? images[0] : `/storage/${images[0]}`) :
                        '/images/demo.jpg';

                    carDiv.innerHTML = `
                        <img src="${imageSrc}" style="object-fit: cover;width: 80px;height: 80px;" alt="${car.title}">
                        <div class="search-result-info">
                            <div class="search-result-title">${car.year} ${car.make} ${car.model}</div>
                            <div class="search-result-vin">VIN: ${car.VIN_number}</div>
                            <div class="search-result-price">$${car.regular_price}</div>
                        </div>
                    `;

                    carDiv.addEventListener('click', () => {
                        window.location.href = `/car/show/${car.id}`;
                    });

                    resultsContainer.appendChild(carDiv);
                });

                // Add "Show all" link if there are more results
                if (response.data.length > 4) {
                    const showAll = document.createElement('div');
                    showAll.className = 'show-all-results';
                    showAll.innerHTML = `<a href="/cars/search?q=${keyword}">Show all ${response.data.length} results</a>`;
                    resultsContainer.appendChild(showAll);
                }

                resultsContainer.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching cars:', error);
                resultsContainer.innerHTML = '<div class="search-result-item">Error loading results</div>';
                resultsContainer.style.display = 'block';
            });
    }

    function setQueryParam(query, key, value) {
        const params = new URLSearchParams(query || '');
        params.set(key, value);
        return params.toString();
    }

    function renderPagination(meta) {
        const pagContainer = document.getElementById('pagination-container');
        if (!pagContainer) return;

        if (!meta) {
            pagContainer.innerHTML = '';
            return;
        }

        const current = meta.current_page || 1;
        const last = meta.last_page || 1;
        const total = meta.total || 0;

        // Update results count
        document.getElementById('results-count').textContent = `${(current - 1) * perPage + 1}-${Math.min(current * perPage, total)} of ${total}`;

        const parts = [];

        // Prev button
        if (current > 1) {
            parts.push(`<a href="#" class="pagination-link" data-page="${current - 1}">Prev</a>`);
        }

        // Page numbers
        for (let i = 1; i <= last; i++) {
            if (i === current) {
                parts.push(`<a href="#" class="pagination-link active" data-page="${i}">${i}</a>`);
            } else if (i <= 3 || i >= last - 2 || (i >= current - 1 && i <= current + 1)) {
                parts.push(`<a href="#" class="pagination-link" data-page="${i}">${i}</a>`);
            } else if (i === 4 || i === last - 3) {
                parts.push(`<span>...</span>`);
            }
        }

        // Next button
        if (current < last) {
            parts.push(`<a href="#" class="pagination-link" data-page="${current + 1}">Next</a>`);
        }

        pagContainer.innerHTML = parts.join('');

        // Attach events
        pagContainer.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (!isNaN(page)) {
                    applyFilters(page);
                    pagContainer.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
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
        const priceSlider = document.getElementById('price-slider');
        if (priceSlider) {
            const priceMinValue = parseInt(priceSlider.min);
            const priceMaxValue = parseInt(priceSlider.value);
            if (!isNaN(priceMinValue) && !isNaN(priceMaxValue)) {
                formData.append('price_min', priceMinValue);
                formData.append('price_max', priceMaxValue);
                console.log('Price range:', priceMinValue, 'to', priceMaxValue); // Debug line
            }
        }

        // Add year range
        const yearSlider = document.getElementById('year-slider');
        if (yearSlider) {
            const yearMinValue = parseInt(yearSlider.min);
            const yearMaxValue = parseInt(yearSlider.value);
            if (!isNaN(yearMinValue) && !isNaN(yearMaxValue)) {
                formData.append('year_min', yearMinValue);
                formData.append('year_max', yearMaxValue);
                console.log('Year range:', yearMinValue, 'to', yearMaxValue); // Debug line
            }
        }

        formData.append('page', page);
        formData.append('per_page', perPage);

        const queryString = new URLSearchParams(formData).toString();
        console.log('Query string:', queryString); // Debug line
        return queryString;
    }

    function fetchFilteredCars(query = '') {
        // Ensure container is available
        if (!container) {
            container = document.getElementById('car-results');
            if (!container) {
                console.error('Car results container not found');
                return;
            }
        }

        lastQuery = query || '';
        const url = query ? (API_URL + '?' + query) : API_URL;
        console.log('Fetching cars from URL:', url); // Debug line

        // Show loading indicator
        container.innerHTML =
            '<div class="text-center py-5"><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading cars...</p></div>';

        axios.get(url)
            .then(response => {
                console.log('Received response:', response.data); // Debug line
                const payload = response.data;
                const cars = Array.isArray(payload) ? payload : (payload.data || []);
                let meta = null;
                if (!Array.isArray(payload)) {
                    if (payload.meta && payload.meta.current_page) {
                        meta = payload.meta;
                    } else if (typeof payload.current_page !== 'undefined') {
                        meta = {
                            current_page: payload.current_page,
                            last_page: payload.last_page,
                            per_page: payload.per_page,
                            total: payload.total
                        };
                    }
                }
                container.innerHTML = '';
                const error_img = `/images/car/23.png`;

                if (!cars.length) {
                    container.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <img class="mx-auto w-64 h-64 object-contain" src="${error_img}" alt="No cars found">
                            <h3 class="text-2xl font-bold text-gray-800 mt-4">No Cars Found</h3>
                            <p class="text-gray-600 mt-2">Try adjusting your filters or search terms</p>
                            <button class="mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition" onclick="resetFilters()">Reset Filters</button>
                        </div>`;
                    renderPagination(meta);
                    return;
                }

                cars.forEach(car => {
                    let images;
                    // Handle both array and string image formats
                    if (Array.isArray(car.images)) {
                        images = car.images;
                    } else if (typeof car.images === 'string') {
                        try {
                            // Try to parse as JSON array
                            images = JSON.parse(car.images);
                        } catch (e) {
                            // If parsing fails, treat as single string
                            images = [car.images];
                        }
                    } else {
                        images = car.images ? [car.images] : [];
                    }

                    // Ensure we have a valid image path
                    const imageSrc = images && images.length > 0 ?
                        (images[0].startsWith('http') ? images[0] : "{{ asset('storage') }}/" + images[0]) :
                        '/images/demo.jpg';

                    const url = car_show.replace('__ID__', car.id);
                    const bargain_url = car.bargain && car.bargain.id ?
                        bargain_show.replace('__ID__', car.bargain.id) :
                        null;

                    // Create car element
                    const carElement = document.createElement('div');
                    carElement.className = 'flex flex-col gap-3 pb-3 rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow-md hover:shadow-xl transition-shadow duration-300';

                    // Build HTML dynamically
                    let html = `
                        <div class="relative">
                            <div class="w-full bg-center bg-no-repeat aspect-video bg-cover"
                                style='background-image: url("${imageSrc}");'>
                            </div>
                            ${car.auction ? '<div class="auction-badge">AUCTION</div>' : ''}
                            <div class="absolute top-2 right-2 flex gap-2">
                                <button class="bg-white/70 dark:bg-gray-900/70 p-1.5 rounded-full text-gray-700 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-500 add-to-compare" data-car-id="${car.id}">
                                    <span class="material-symbols-outlined">favorite_border</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <p class="text-lg font-bold text-gray-900 dark:text-white">${car.make} ${car.model}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Year: ${car.year || 'N/A'}, Mileage: ${car.mileage || 'N/A'}, Engine: ${car.engine || 'N/A'}</p>
                            <p class="text-xl font-bold text-primary mt-2">$${car.regular_price || '0'}</p>
                            <div class="mt-4 flex gap-2">
                                <a href="${url}" class="flex-grow flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
                                    <span class="truncate">View Details</span>
                                </a>
                                <label class="flex items-center gap-2 px-4 rounded-lg bg-gray-100 dark:bg-gray-700 cursor-pointer">
                                    <input class="form-checkbox rounded text-primary focus:ring-primary/50 compare-checkbox" type="checkbox" data-car-id="${car.id}" />
                                    <span class="text-sm font-medium">Compare</span>
                                </label>
                            </div>
                        </div>
                    `;

                    carElement.innerHTML = html;
                    container.appendChild(carElement);
                });

                renderPagination(meta);

                // Initialize compare functionality
                initCompareFunctionality();
            })
            .catch(error => {
                console.error('Error fetching cars:', error); // Debug line
                // Ensure container is available
                if (!container) {
                    container = document.getElementById('car-results');
                }
                if (container) {
                    container.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <div class="text-red-500 text-5xl mb-4">⚠️</div>
                            <h3 class="text-2xl font-bold text-gray-800">Error Loading Cars</h3>
                            <p class="text-gray-600 mt-2">Failed to load cars. Please try again later.</p>
                            <button class="mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition" onclick="fetchFilteredCars()">Retry</button>
                        </div>`;
                }
                renderPagination(null);
            });
    }

    function initCompareFunctionality() {
        // Add to compare buttons
        document.querySelectorAll('.add-to-compare').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const carId = this.dataset.carId;
                addToCompare(carId);
            });
        });

        // Compare checkboxes
        document.querySelectorAll('.compare-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const carId = this.dataset.carId;
                if (this.checked) {
                    addToCompare(carId);
                } else {
                    removeFromCompare(carId);
                }
            });
        });

        // Update compare count
        updateCompareIcon();
    }

    function applyFilters(page = 1) {
        const query = buildQuery(page);
        console.log('Applying filters with query:', query); // Debug line
        fetchFilteredCars(query);
    }

    function resetFilters() {
        // Reset all filters
        document.querySelectorAll('.filter-option').forEach(input => {
            input.checked = input.value === '*';
        });

        // Reset search
        document.getElementById('car-search').value = '';
        document.getElementById('general-search').value = '';

        // Reset sort
        document.getElementById('sort-select').value = '';

        // Reset sliders
        const yearSlider = document.getElementById('year-slider');
        if (yearSlider) {
            yearSlider.value = Math.floor((parseInt(yearSlider.min) + parseInt(yearSlider.max)) / 2);
            document.getElementById('year-min').textContent = yearSlider.value;
        }

        const priceSlider = document.getElementById('price-slider');
        if (priceSlider) {
            priceSlider.value = Math.floor((parseInt(priceSlider.min) + parseInt(priceSlider.max)) / 2);
            document.getElementById('price-min').textContent = '$' + parseInt(priceSlider.value).toLocaleString();
        }

        // Apply filters
        applyFilters();
    }

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

    function addToCompare(carId) {
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

    function removeFromCompare(carId) {
        let compareCars = getCompareCars();
        const index = compareCars.indexOf(carId);
        if (index > -1) {
            compareCars.splice(index, 1);
            setCompareCars(compareCars);
            updateCompareIcon();
        }
    }

    // Update compare icon count in navbar
    function updateCompareIcon() {
        const count = getCompareCars().length;
        const icon = document.querySelector('#compare-count');
        if (icon) {
            icon.textContent = count;
        }

        // Update checkboxes
        const compareCars = getCompareCars();
        document.querySelectorAll('.compare-checkbox').forEach(checkbox => {
            const carId = checkbox.dataset.carId;
            checkbox.checked = compareCars.includes(carId);
        });
    }

    // Initialize count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCompareIcon();
    });
</script>
@endsection
