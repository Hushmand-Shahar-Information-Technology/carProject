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

        /* Auction Badge Styling */
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

        .auction-price {
            background: linear-gradient(45deg, #ff9800, #ff5722);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-left: 8px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .action-buttons .btn {
            flex: 1;
            text-align: center;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-details {
            background:rgb(220, 22, 22);
            color: white;
            border: 1px solid rgb(184, 23, 23);
        }

        .btn-details:hover {
            background:rgb(219, 51, 51);
            border-color:rgb(201, 51, 51);
        }

        .btn-bargain {
            background: #28a745;
            color: white;
            border: 1px solid #28a745;
        }

        .btn-bargain:hover {
            background: #218838;
            border-color: #1e7e34;
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
            .action-buttons {
                flex-direction: column;
            }
        }

        /* Modern Slider Styles */
        .filter-widget {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
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

        #year-range-slider, #price-range-slider {
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

        .noUi-handle:before, .noUi-handle:after {
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
            position: relative;
        }

        .grid-item .car-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 24, 40, 0.10);
        }

        .grid-item .car-image {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            overflow: hidden;
            position: relative;
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

        .list-inline {
            display: flex !important;
            justify-content: space-around !important;
        }

        .list-inline2 li {
            color: black;
            background-color: #e7e7e7;
            padding: 8px 32px !important;
            font-size: 0.8rem !important;
        }

        @media (max-width: 790px) {
            .div-search {
                margin: 24px 0 32px 0;
            }
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
                                            <select class="form-control" id="sort-select" name="sort"
                                                style="width: auto;">
                                                <option value="">Default</option>
                                                <option value="name">Name (A-Z)</option>
                                                <option value="price">Price (Low-High)</option>
                                                <option value="date">Newest First</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-xxl-2 col-md-12 div-search">
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
                <div class="pagination-link" style="display: flex; justify-content: center; margin: 2rem 0 3rem 0;">
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        $("#sort-select").on('change', function() {
            applyFilters();
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
                                            <div class="search-result-price">$${car.regular_price}</div>
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
        const bargain_show = "{{ route('bargains.show', ['id' => '__ID__']) }}";
        const container = document.getElementById('car-results');
        let currentView = 'grid'; // Default view
        let lastQuery = '';

        function setQueryParam(query, key, value) {
            const params = new URLSearchParams(query || '');
            params.set(key, value);
            return params.toString();
        }

        function renderPagination(meta) {
            let pagContainer = document.querySelector('.pagination-link');
            if (!pagContainer) return;

            if (!meta) {
                pagContainer.innerHTML = '';
                return;
            }

            const current = meta.current_page || 1;
            const last = meta.last_page || 1;
            const maxButtons = 5; // how many page numbers to display around current
            const parts = [];

            const makeBtn = (label, page, disabled = false, active = false, isEllipsis = false) => {
                if (isEllipsis) {
                    return `<span class="mx-1">...</span>`;
                }
                const cls = ['btn', 'btn-sm', 'mx-1', 'mb-2', 'px-3', 'py-1'];
                if (active) cls.push('btn-danger');
                else cls.push('btn-light');
                const disabledAttr = disabled ? 'disabled' : '';
                return `<button type="button" class="${cls.join(' ')} pagination" data-page="${page}" ${disabledAttr}>${label}</button>`;
            };

            // Prev button
            parts.push(makeBtn('Prev', current - 1, current === 1));

            // Always show the first page
            parts.push(makeBtn(1, 1, false, current === 1));

            // Show second page only if current is close
            if (current > 3) {
                parts.push(makeBtn('...', null, true, false, true)); // ellipsis
            }

            // Pages around current
            let start = Math.max(2, current - 2);
            let end = Math.min(last - 1, current + 2);

            for (let p = start; p <= end; p++) {
                parts.push(makeBtn(p, p, false, p === current));
            }

            // Show ellipsis before last page
            if (current < last - 2) {
                parts.push(makeBtn('...', null, true, false, true)); // ellipsis
            }

            // Always show last page if > 1
            if (last > 1) {
                parts.push(makeBtn(last, last, false, current === last));
            }

            // Next button
            parts.push(makeBtn('Next', current + 1, current === last));

            // Render
            pagContainer.innerHTML = parts.join('');

            // Attach events
            pagContainer.querySelectorAll('button[data-page]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const page = parseInt(e.currentTarget.getAttribute('data-page'));
                    if (isNaN(page)) return;
                    const q = setQueryParam(lastQuery, 'page', page);
                    fetchFilteredCars(q);
                    pagContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                });
            });
        }

        function setView(view) {
            currentView = view;
            $("#grid-view").toggleClass('active', view === 'grid');
            $("#list-view").toggleClass('active', view === 'list');
            applyFilters();
        }

        function fetchFilteredCars(query = '') {
            lastQuery = query || '';
            const url = query ? (API_URL + '?' + query) : API_URL;
            axios.get(url)
                .then(response => {
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
                        renderPagination(meta);
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
                        const imageSrc = images.length ? `/storage/${images[0]}` : '/images/demo.jpg';
                        const url = car_show.replace('__ID__', car.id);
                        const bargain_url = car.bargain ?
                            bargain_show.replace('__ID__', car.bargain.id) :
                            null;
                        const carDiv = $(`<div style="color: #a0a0a0">`);
                        const title = `<h4>${car.title}</h4>`;
                        const details_button = `
                         <div">
                             <a class="button red float-end py-2 px-4 ml-2" style="font-size: 1rem;" href="${url}">Details</a>
                             <a class="button red float-end py-2 px-4" style="font-size: 1rem;" href="${bargain_url}">Bargain</a>
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
                                    ${car.auction ? '<div class="auction-badge">AUCTION</div>' : ''}
                                    <img class="img-fluid fixed-img" src="${imageSrc}" alt="${car.title}">
                                    <div class="car-overlay-banner">
                                        <ul>
                                            <li><a href="${bargain_url}"><i class="fa fa-link"></i></a></li>
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
                                ? `</div>`
                                : ``
                            }
                                ${currentView == 'list' ? title: ""}
                                ${currentView == 'list' ? description  : ""}
                                ${currentView == 'list' ? details : ""}
                                <div class="price-container">
                                    <div class="price-item">
                                        <div class="price-label">
                                            ${currentView === 'list' ? '<span class="price-icon">💰</span>' : ''}
                                            ${car.auction ? 'Starting Price' : 'Price'}
                                        </div>
                                        <div class="price-value">
                                            <span class="price-currency">$</span>${car.regular_price ?? ''}
                                            ${currentView === 'list' ? '<span class="price-badge">Total</span>' : ''}
                                        </div>
                                    </div>
                                    ${car.auction ? `
                                    <div class="price-item">
                                        <div class="price-label">
                                            ${currentView === 'list' ? '<span class="price-icon">🔨</span>' : ''}
                                            Auction Price
                                        </div>
                                        <div class="price-value">
                                            <span class="price-currency">$</span>${car.auction.current_bid ?? car.auction.starting_bid ?? '0'}
                                            ${currentView === 'list' ? '<span class="auction-price">Current Bid</span>' : ''}
                                        </div>
                                    </div>
                                    ` : ''}
                                    ${currentView === 'list' && car.bargain ? `
                                    ` : ''}
                                </div>
                                ${currentView === 'list' ? `
                                <div class="action-buttons">
                                    <a href="${url}" class="btn btn-details">Details</a>
                                    ${bargain_url ? `<a href="${bargain_url}" class="btn btn-bargain">Bargain</a>` : ''}
                                    
                                </div>
                                ` : ''}
                                <div class="car-list" >
                                    <ul class="${currentView != 'list' ? 'list-inline' : 'list-inline2'}">
                                         ${currentView == 'list' ? `<li style="font-size: 8px;"><i class="fa fa-cog"></i> ${car.transmission_type}</li>` : ""}
                                        <li style="font-size: 8px;"><i class="fa fa-shopping-cart"></i>${car.model}</li>
                                        <li style="font-size: 8px;"><i class="fa fa-registered"></i> ${car.year}</li>
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

                    renderPagination(meta);
                })
                .catch(error => {
                    console.error('Error fetching cars:', error);
                    container.innerHTML = '<p>Failed to load cars.</p>';
                    renderPagination(null);
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
