@extends('layouts.layout')
@section('title', 'Profile')
@section('content')
    @if (session('swal_error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Action Not Allowed',
                    text: "{{ session('swal_error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#dc2626",
                        "background-light": "#f5f6f8",
                        "background-dark": "#0f1623",
                    },
                    fontFamily: {
                        display: ["Inter"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                        lg: "1rem",
                        xl: "1.5rem",
                        full: "9999px",
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }

        /* Preserve existing functionality styles */
        .new-post-circle {
            cursor: pointer;
        }

        .car-overlay-banner {
            position: absolute;
            top: 10px;
            right: 0px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 4px;
            padding: 5px;
            display: flex;
            flex-direction: row;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
            justify-content: center;
            align-items: center;
            width: fit-content;
            height: fit-content;
        }

        .car-overlay-banner ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: row;
            gap: 5px;
            justify-content: center;
            align-items: center;
        }

        .car-overlay-banner li {
            margin: 0;
        }

        .car-overlay-banner a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 5px;
        }

        .car-overlay-banner a:hover {
            color: #ff6b6b;
        }

        .car-image:hover .car-overlay-banner {
            opacity: 1;
        }

        .promotion-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .promotion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .badge-promotion {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .notification-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            margin-bottom: 15px;
            background: #fff;
            cursor: pointer;
        }

        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .notification-card.unread {
            border-left: 4px solid #007bff;
            background-color: #f8f9ff;
        }

        .fixed-img {
            aspect-ratio: 3 / 2;
            object-fit: cover;
            width: 100%;
            border-radius: 8px 8px 0 0;
            height: auto;
            transition: transform 0.3s ease;
        }

        .car-item {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .car-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .car-item:hover .fixed-img {
            transform: scale(1.05);
        }

        .car-image {
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .car-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding: 15px;
        }

        .car-content .price {
            margin-top: auto;
        }

        /* Profile Edit Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #363636;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close {
            color: #363636;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 10px;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }

        .modal-header {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 20px;
            color: #363636;
        }

        .modal-body {
            padding: 10px 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #363636;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #363636;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #363636;
            box-shadow: 0 0 0 0.2rem rgba(54, 54, 54, 0.25);
        }

        .btn-save {
            background-color: #363636;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-save:hover {
            background-color: #555;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: 1px solid #363636;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #545b62;
        }

        /* Share Modal Styles */
        .share-buttons .col-3 {
            padding: 5px;
        }

        .share-btn {
            display: block;
            text-decoration: none;
            color: #363636;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .share-btn:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            border-color: #363636;
        }

        .share-btn i {
            margin-bottom: 5px;
        }

        .share-btn div {
            font-size: 12px;
            margin-top: 5px;
        }

        #share-link {
            border-radius: 4px 0 0 4px;
            border: 1px solid #363636;
        }

        #copy-link-btn {
            border-radius: 0 4px 4px 0;
        }

        .close-share {
            color: #363636;
        }

        @media (max-width: 768px) {
            .notification-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .notification-image {
                margin-bottom: 10px;
            }

            .detail-item {
                flex: 1 1 100%;
            }

            .notification-actions {
                justify-content: center;
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .notification-card {
                margin-bottom: 10px;
            }

            .notification-header,
            .notification-body {
                padding: 12px;
            }
        }
    </style>

    <!--================================ -->
    <section class="inner-intro bg-8 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white" id="profile-title">
                        {{ $user->name }}{{ $activeBargain ? ' - ' . $activeBargain->username : '' }}
                    </h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Home</a> <i
                                class="fa fa-angle-double-right"></i>
                        </li>
                        <li><span> profile </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header with Gradient Background -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl p-6 mb-8 shadow-lg text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="relative inline-block">
                        <img src="{{ $user->avatar && $user->avatar !== 'avatar.png' ? asset('storage/' . $user->avatar) : asset('images/demo.jpg') }}"
                            class="rounded-full w-24 h-24 border-4 border-white/50 object-cover" alt="Profile Picture" id="profile-image">
                        @if (auth()->check() && $user->id === auth()->id())
                            <div class="absolute bottom-0 right-0">
                                <button type="button" class="bg-white/20 hover:bg-white/30 text-white rounded-full p-2 shadow"
                                    id="edit-profile-image-btn">
                                    <i class="fas fa-camera"></i>
                                </button>
                                <!-- Hidden file input for direct upload -->
                                <input type="file" id="avatar-input" name="avatar" accept="image/*"
                                    style="display: none;">
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold" id="profile-name">
                            {{ $activeBargain ? $activeBargain->username : $user->name }}
                        </h1>
                        <p class="text-white/80 text-lg">User</p>
                    </div>
                </div>
                @if (auth()->check() && $user->id === auth()->id())
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="button" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-4 rounded-lg transition-colors flex-1" id="share-profile-btn">
                            <i class="fas fa-share-alt mr-2"></i> Share
                        </button>
                        <button type="button" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-4 rounded-lg transition-colors flex-1" id="edit-profile-btn">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile Information Card -->
        {{-- <div class="bg-background-light dark:bg-gray-800/20 rounded-xl p-4 mb-6 shadow-sm">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                Profile Information
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-gray-700 dark:text-gray-300">
                <div class="flex justify-between py-2">
                    <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Name:</span>
                    <span id="profile-display-name" class="font-medium">{{ $activeBargain ? $activeBargain->username : $user->name }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Email:</span>
                    <span id="profile-email" class="font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Phone:</span>
                    <span id="profile-phone" class="font-medium">{{ $user->phone ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Location:</span>
                    <span id="profile-location" class="font-medium">{{ $activeBargain ? $activeBargain->address ?? 'N/A' : 'Location not set' }}</span>
                </div>
                <div class="flex justify-between py-2 sm:col-span-2">
                    <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Posts:</span>
                    <span id="post-count" class="font-medium">{{ $user->cars->count() }}</span>
                </div>
            </div>
        </div> --}}
        <div class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
            <!-- Enhanced Profile Card -->
                <div class="profile-card rounded-2xl p-6 mb-6 shadow-lg border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                Profile Information
                            </h2>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="info-item flex justify-between py-3 px-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-tag text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Name:</span>
                            </div>
                            <span id="profile-display-name" class="font-medium text-gray-900 dark:text-white">{{ $activeBargain ? $activeBargain->username : $user->name }}</span>
                        </div>

                        <div class="info-item flex justify-between py-3 px-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-envelope text-green-600 dark:text-green-400 text-sm"></i>
                                </div>
                                <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Email:</span>
                            </div>
                            <span id="profile-email" class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
                        </div>

                        <div class="info-item flex justify-between py-3 px-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-purple-600 dark:text-purple-400 text-sm"></i>
                                </div>
                                <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Phone:</span>
                            </div>
                            <span id="profile-phone" class="font-medium text-gray-900 dark:text-white">{{ $user->phone ?? 'N/A' }}</span>
                        </div>

                        <div class="info-item flex justify-between py-3 px-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-amber-600 dark:text-amber-400 text-sm"></i>
                                </div>
                                <span class="font-medium text-gray-500 dark:text-gray-400 text-sm">Location:</span>
                            </div>
                            <span id="profile-location" class="font-medium text-gray-900 dark:text-white">{{ $activeBargain ? $activeBargain->address ?? 'N/A' : 'Location not set' }}</span>
                        </div>

                    </div>
                </div>
        </div>

        <!-- Statistics Section -->
        <div class="mb-6">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                Statistics
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="bg-background-light dark:bg-gray-800/20 rounded-lg p-4 shadow-sm flex flex-col items-center text-center">
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                        Total Cars
                    </p>
                    <p class="text-2xl font-bold text-primary mt-1" id="total-cars-count">
                        {{ $user->cars->count() }}
                    </p>
                </div>
                <div class="bg-background-light dark:bg-gray-800/20 rounded-lg p-4 shadow-sm flex flex-col items-center text-center">
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                        For Sale
                    </p>
                    <p class="text-2xl font-bold text-primary mt-1" id="for-sale-count">
                        {{ $user->cars->where('is_for_sale', true)->count() }}
                    </p>
                </div>
                <div class="bg-background-light dark:bg-gray-800/20 rounded-lg p-4 shadow-sm flex flex-col items-center text-center">
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                        For Rent
                    </p>
                    <p class="text-2xl font-bold text-primary mt-1" id="for-rent-count">
                        {{ $user->cars->where('is_for_rent', true)->count() }}
                    </p>
                </div>
            </div>
        </div>

        <!-- New Post Section -->
        @if (auth()->check() && $user->id === auth()->id())
            <a href="{{ route('car.create') }}" id="new-car-link" class="block mb-6">
                <div class="new-post flex flex-col items-center">
                    <div class="new-post-circle w-12 h-12 border-2 border-dashed border-gray-400 rounded-full flex items-center justify-center hover:border-gray-600">
                        <i class="fas fa-plus text-lg text-gray-500"></i>
                    </div>
                    <div class="new-post-label text-xs text-gray-500 font-medium mt-1">New Car</div>
                </div>
            </a>
        @endif

        <!-- Modern Tab Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
            <nav class="flex space-x-6">
                <button class="modern-tab py-3 px-1 border-b-2 font-medium text-sm active border-primary text-primary" data-tab="cars">
                    Cars ({{ $user->cars->count() }})
                </button>
                @if (auth()->check() && $user->id === auth()->id())
                    <button class="modern-tab py-3 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="notifications">
                        Notifications <span class="notification-count-badge bg-red-500 text-white rounded-full px-2 py-1 text-xs ml-2" id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </button>
                    <button class="modern-tab py-3 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="newsletter">
                        Newsletter
                    </button>
                @endif
            </nav>
        </div>

        <!-- Cars Tab Content -->
        <div id="cars-tab" class="tab-content active">
            <div class="sorting-options-main">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="user-cars-container">
                    @forelse ($user->cars as $car)
                        <div class="car-item bg-background-light dark:bg-gray-800/20 rounded-xl shadow-md overflow-hidden group promotion-card">
                            @if ($car->is_promoted)
                                <span class="badge bg-success badge-promotion bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">Promoted</span>
                            @endif
                            <div class="car-image relative">
                                <img class="fixed-img w-full object-cover transition-transform duration-300 group-hover:scale-105" src="{{ asset($car->getFirstImageOrDefault()) }}" alt="{{ $car->title }}">
                                <div class="car-overlay-banner">
                                    <ul>
                                        <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-link"></i></a></li>
                                        <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                                        @can('update', $car)
                                            <li>
                                                <a href="#" class="edit-car-btn" data-car-id="{{ $car->id }}" data-car-data="{{ json_encode($car) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('delete', $car)
                                            <li>
                                                <a href="#" class="delete-car-btn" data-car-id="{{ $car->id }}" data-car-title="{{ $car->make }} {{ $car->model }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                            <div class="car-list p-2">
                                <ul class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                                    <li><i class="fa fa-registered"></i> {{ $car->year }}</li>
                                    <li><i class="fa fa-cog"></i> {{ $car->transmission_type }} </li>
                                    <li><i class="fa fa-shopping-cart"></i> {{ $car->currency_type }} {{ number_format($car->regular_price) }}</li>
                                </ul>
                            </div>
                            <div class="car-content p-4">
                                <div class="star mb-2">
                                    <i class="fa fa-star text-yellow-400"></i>
                                    <i class="fa fa-star text-yellow-400"></i>
                                    <i class="fa fa-star text-yellow-400"></i>
                                    <i class="fa fa-star text-yellow-400"></i>
                                    <i class="fa fa-star-o text-yellow-400"></i>
                                </div>
                                <a href="{{ route('car.show', $car->id) }}" class="text-lg font-bold text-gray-900 dark:text-white">{{ $car->make }} {{ $car->model }}</a>
                                <div class="separator my-2 border-t border-gray-200 dark:border-gray-700"></div>
                                <div class="price">
                                    <span class="new-price text-primary font-semibold">{{ $car->currency_type }} {{ number_format($car->regular_price) }}</span>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @if ($car->is_for_sale)
                                        <span class="badge bg-success bg-green-500 text-white text-xs px-2 py-1 rounded">For Sale</span>
                                    @endif
                                    @if ($car->is_for_rent)
                                        <span class="badge bg-info bg-red-500 text-white text-xs px-2 py-1 rounded">For Rent</span>
                                    @endif
                                    @if ($car->auctions && $car->auctions->count() > 0)
                                        <span class="badge bg-warning bg-yellow-500 text-white text-xs px-2 py-1 rounded">Auction</span>
                                    @endif
                                    @if ($car->request_price_status)
                                        <span class="badge bg-primary text-white text-xs px-2 py-1 rounded">Request Price: {{ $car->currency_type }} {{ number_format($car->request_price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="alert alert-info text-center bg-red-100 text-red-800 p-6 rounded-lg">
                                <i class="fas fa-car mr-2"></i> No cars posted yet.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Notifications Tab Content -->
        <div id="notifications-tab" class="tab-content hidden">
            <div class="notifications-container">
                @if (auth()->user()->notifications->count() > 0)
                    @foreach (auth()->user()->notifications as $notification)
                        <div class="notification-card {{ $notification->read_at ? '' : 'unread' }} bg-white dark:bg-gray-800"
                            data-notification-id="{{ $notification->id }}"
                            data-car-url="{{ route('car.show', $notification->data['car_id']) }}">
                            <div class="notification-header p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <div class="notification-image w-12 h-12 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div class="notification-info ml-4 flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <div class="notification-sender font-bold text-gray-900 dark:text-white">
                                                    {{ $notification->data['sender_name'] }}
                                                </div>
                                                <div class="notification-car-title text-sm text-gray-600 dark:text-gray-400">
                                                    <a href="{{ route('car.show', $notification->data['car_id']) }}"
                                                        class="text-decoration-none hover:underline">
                                                        {{ $notification->data['car_title'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="notification-time text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                                @if (!$notification->read_at)
                                                    <div class="unread-indicator w-2 h-2 rounded-full bg-red-500 ml-2" title="Unread"></div>
                                                @else
                                                    <div class="read-indicator w-2 h-2 rounded-full bg-green-500 ml-2" title="Read"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-body p-4">
                                <div class="notification-details grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="detail-item">
                                        <div class="detail-label text-xs text-gray-500 dark:text-gray-400">Offer Price</div>
                                        <div class="detail-value font-medium text-gray-900 dark:text-white">${{ number_format($notification->data['offer_price']) }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label text-xs text-gray-500 dark:text-gray-400">Contact</div>
                                        <div class="detail-value font-medium text-gray-900 dark:text-white">{{ $notification->data['sender_email'] }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label text-xs text-gray-500 dark:text-gray-400">Phone</div>
                                        <div class="detail-value font-medium text-gray-900 dark:text-white">{{ $notification->data['sender_phone'] ?? 'N/A' }}</div>
                                    </div>
                                    @if ($notification->data['remark'])
                                        <div class="detail-item">
                                            <div class="detail-label text-xs text-gray-500 dark:text-gray-400">Message</div>
                                            <div class="detail-value font-medium text-gray-900 dark:text-white">{{ $notification->data['remark'] }}</div>
                                        </div>
                                    @endif
                                </div>
                                @if (!$notification->read_at)
                                    <div class="notification-actions flex justify-end">
                                        <button class="mark-as-read-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm transition-colors" data-notification-id="{{ $notification->id }}">
                                            Mark as Read
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-notifications text-center py-12">
                        <i class="fas fa-bell-slash text-5xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Notifications</h4>
                        <p class="text-gray-600 dark:text-gray-400">You don't have any offer notifications yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Newsletter Tab Content -->
        <div id="newsletter-tab" class="tab-content hidden">
            <div class="max-w-4xl mx-auto">
                <!-- Newsletter Header Card -->
                <div class="bg-gradient-to-r from-red-500 to-red-700 rounded-xl p-8 mb-6 text-white text-center shadow-lg">
                    <div class="mb-4">
                        <i class="fas fa-envelope-open-text text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Newsletter Subscription</h2>
                    <p class="text-red-100">Stay updated with the latest car listings and exclusive offers</p>
                </div>

                <!-- Subscription Form Card -->
                <div class="bg-background-light dark:bg-gray-800/20 rounded-xl shadow-md mb-6">
                    <div class="bg-primary text-white p-4 rounded-t-xl">
                        <h5 class="text-lg font-bold mb-0">
                            <i class="fas fa-envelope mr-2"></i>
                            Newsletter Subscription
                        </h5>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Enter your email to subscribe or unsubscribe from our newsletter</p>

                        <form id="profile-newsletter-form" class="mb-6">
                            @csrf
                            <div class="mb-6">
                                <label for="profile-email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" id="profile-email-input" name="email"
                                        class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-lg border border-gray-300 focus:ring-red-500 focus:border-red-500"
                                        value="{{ auth()->user()->email }}" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">We'll use this email to send you newsletter updates</p>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                @if (auth()->user()->newsletter_subscribed)
                                    <button type="button" class="btn btn-danger bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition-colors" id="unsubscribe-btn">
                                        <i class="fas fa-times mr-2"></i>
                                        Unsubscribe from Newsletter
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-colors" id="subscribe-btn">
                                        <i class="fas fa-check mr-2"></i>
                                        Subscribe to Newsletter
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Current Status Card -->
                <div class="bg-background-light dark:bg-gray-800/20 rounded-xl shadow-md p-6 mb-6">
                    @if (auth()->user()->newsletter_subscribed)
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-check-circle text-3xl text-green-500"></i>
                            </div>
                            <div>
                                <h5 class="text-lg font-bold text-green-600 mb-1">Currently Subscribed</h5>
                                <p class="text-gray-600 dark:text-gray-400 mb-0">You're receiving newsletter notifications</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-times-circle text-3xl text-red-500"></i>
                            </div>
                            <div>
                                <h5 class="text-lg font-bold text-red-600 mb-1">Not Subscribed</h5>
                                <p class="text-gray-600 dark:text-gray-400 mb-0">Subscribe to receive newsletter notifications</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Benefits Card -->
                <div class="bg-background-light dark:bg-gray-800/20 rounded-xl shadow-md">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-t-xl">
                        <h5 class="text-lg font-bold mb-0 text-gray-900 dark:text-white">
                            <i class="fas fa-gift mr-2 text-primary"></i>
                            What you'll receive:
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="mb-3">
                                    <i class="fas fa-car text-2xl text-primary"></i>
                                </div>
                                <h6 class="font-bold text-gray-900 dark:text-white mb-2">New Car Listings</h6>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Get notified about new car posts</p>
                            </div>
                            <div class="text-center p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="mb-3">
                                    <i class="fas fa-percentage text-2xl text-green-500"></i>
                                </div>
                                <h6 class="font-bold text-gray-900 dark:text-white mb-2">Exclusive Deals</h6>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Special promotions and offers</p>
                            </div>
                            <div class="text-center p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="mb-3">
                                    <i class="fas fa-info-circle text-2xl text-red-500"></i>
                                </div>
                                <h6 class="font-bold text-gray-900 dark:text-white mb-2">Updates</h6>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Important announcements</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Edit Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h2>Edit Profile</h2>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ $user->name }}" required autocomplete="name" autocapitalize="off">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ $user->email }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="{{ $user->phone }}" placeholder="Enter phone number">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control"
                            value="{{ $activeBargain ? $activeBargain->address : '' }}" placeholder="Enter address">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-save">Save Changes</button>
                        <button type="button" class="btn-cancel" id="cancelEdit">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Share Profile Modal -->
    <div id="shareProfileModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <span class="close-share">&times;</span>
            <div class="modal-header">
                <h2>Share Profile</h2>
            </div>
            <div class="modal-body">
                <p>Share {{ $user->name }}'s profile on:</p>
                <div class="share-buttons">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="facebook">
                                <i class="fab fa-facebook-f text-2xl" style="color: #363636;"></i>
                                <div class="text-xs mt-1">Facebook</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="twitter">
                                <i class="fab fa-twitter text-2xl" style="color: #363636;"></i>
                                <div class="text-xs mt-1">Twitter</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="linkedin">
                                <i class="fab fa-linkedin-in text-2xl" style="color: #363636;"></i>
                                <div class="text-xs mt-1">LinkedIn</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="whatsapp">
                                <i class="fab fa-whatsapp text-2xl" style="color: #28a745;"></i>
                                <div class="text-xs mt-1">WhatsApp</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="telegram">
                                <i class="fab fa-telegram-plane text-2xl" style="color: #007bff;"></i>
                                <div class="text-xs mt-1">Telegram</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="email">
                                <i class="fas fa-envelope text-2xl" style="color: #dc3545;"></i>
                                <div class="text-xs mt-1">Email</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="copy">
                                <i class="fas fa-copy text-2xl" style="color: #363636;"></i>
                                <div class="text-xs mt-1">Copy Link</div>
                            </a>
                        </div>
                        <div class="text-center mb-3">
                            <a href="#" class="share-btn" data-platform="sms">
                                <i class="fas fa-sms text-2xl" style="color: #ffc107;"></i>
                                <div class="text-xs mt-1">SMS</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="share-link" class="block text-sm font-medium text-gray-700 mb-2">Or copy the link:</label>
                    <div class="flex">
                        <input type="text" id="share-link" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-l-lg border border-gray-300"
                            value="{{ route('profile.showUser', $user->id) }}" readonly>
                        <button class="btn btn-outline-secondary bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-r-lg" type="button" id="copy-link-btn">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Car Edit Modal -->
    <div id="editCarModal" class="modal">
        <div class="modal-content" style="max-width: 800px;">
            <span class="close" id="closeCarEdit">&times;</span>
            <div class="modal-header">
                <h2>Edit Car</h2>
            </div>
            <div class="modal-body">
                <form id="editCarForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="form-group">
                                <label for="edit_title">Title *</label>
                                <input type="text" id="edit_title" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="edit_year">Year *</label>
                                <select id="edit_year" name="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    @for ($year = date('Y'); $year >= 1995; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="form-group">
                                <label for="edit_make">Make *</label>
                                <select id="edit_make" name="make" class="form-control" required>
                                    <option value="">Select Make</option>
                                    <option value="toyota">Toyota</option>
                                    <option value="bmw">BMW</option>
                                    <option value="honda">Honda</option>
                                    <option value="marcedes">Mercedes</option>
                                    <option value="Hyundai">Hyundai</option>
                                    <option value="Nissan">Nissan</option>
                                    <option value="Kia">Kia</option>
                                    <option value="ford">Ford</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="edit_model">Model</label>
                                <select id="edit_model" name="model" class="form-control">
                                    <option value="">Select Model</option>
                                    <option value="Camry">Camry</option>
                                    <option value="Corolla">Corolla</option>
                                    <option value="Prius">Prius</option>
                                    <option value="RAV4">RAV4</option>
                                    <option value="Highlander">Highlander</option>
                                    <option value="X3">X3</option>
                                    <option value="X5">X5</option>
                                    <option value="3 Series">3 Series</option>
                                    <option value="5 Series">5 Series</option>
                                    <option value="Civic">Civic</option>
                                    <option value="Accord">Accord</option>
                                    <option value="CR-V">CR-V</option>
                                    <option value="Pilot">Pilot</option>
                                    <option value="C-Class">C-Class</option>
                                    <option value="E-Class">E-Class</option>
                                    <option value="GLE">GLE</option>
                                    <option value="Elantra">Elantra</option>
                                    <option value="Sonata">Sonata</option>
                                    <option value="Tucson">Tucson</option>
                                    <option value="Santa Fe">Santa Fe</option>
                                    <option value="Altima">Altima</option>
                                    <option value="Sentra">Sentra</option>
                                    <option value="Rogue">Rogue</option>
                                    <option value="Murano">Murano</option>
                                    <option value="Optima">Optima</option>
                                    <option value="Sorento">Sorento</option>
                                    <option value="Sportage">Sportage</option>
                                    <option value="Focus">Focus</option>
                                    <option value="Escape">Escape</option>
                                    <option value="Explorer">Explorer</option>
                                    <option value="F-150">F-150</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="form-group">
                                <label for="edit_car_color">Car Color *</label>
                                <select id="edit_car_color" name="car_color" class="form-control" required>
                                    <option value="">Select Color</option>
                                    <option value="white">White</option>
                                    <option value="black">Black</option>
                                    <option value="silver">Silver</option>
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="yellow">Yellow</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="edit_body_type">Body Type</label>
                                <select id="edit_body_type" name="body_type" class="form-control">
                                    <option value="">Select Body Type</option>
                                    <option value="convertible">Convertible</option>
                                    <option value="coupe">Coupe</option>
                                    <option value="CUV">CUV</option>
                                    <option value="micro">Micro</option>
                                    <option value="supercar">Supercar</option>
                                    <option value="sedan">Sedan</option>
                                    <option value="pick-up">Pick-up</option>
                                    <option value="minivan">Minivan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="form-group">
                                <label for="edit_car_condition">Car Condition</label>
                                <select id="edit_car_condition" name="car_condition" class="form-control">
                                    <option value="">Select Accident Condition</option>
                                    <option value="تصادفی">Crashed</option>
                                    <option value="سالم">UnDamaged</option>
                                    <option value="تصادفی اما تعمیر شده">Repaired</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="edit_car_inside_color">Inside Color</label>
                                <select id="edit_car_inside_color" name="car_inside_color" class="form-control">
                                    <option value="">Select Interior Color</option>
                                    <option value="black">Black</option>
                                    <option value="gray">Gray</option>
                                    <option value="beige">Beige</option>
                                    <option value="brown">Brown</option>
                                    <option value="white">White</option>
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="form-group">
                                <label for="edit_vin_number">VIN Number</label>
                                <input type="text" id="edit_vin_number" name="VIN_number" class="form-control">
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="edit_transmission_type">Transmission Type</label>
                                <select id="edit_transmission_type" name="transmission_type" class="form-control">
                                    <option value="">Select Transmission</option>
                                    <option value="manual">Manual</option>
                                    <option value="automatic">Automatic</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="form-group">
                                <label for="edit_currency_type">Currency Type</label>
                                <select id="edit_currency_type" name="currency_type" class="form-control">
                                    <option value="">Select Currency</option>
                                    <option value="USD">USD</option>
                                    <option value="AFN">AFN</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sale-related fields (show only when For Sale is checked) -->
                    <div id="sale-fields" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="form-group">
                                    <label for="edit_regular_price">Regular Price</label>
                                    <input type="number" id="edit_regular_price" name="regular_price"
                                        class="form-control" min="0" step="0.01">
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label for="edit_car_documents">Car Documents</label>
                                    <select id="edit_car_documents" name="car_documents" class="form-control">
                                        <option value="">Select Document Status</option>
                                        <option value="complete">Complete</option>
                                        <option value="incomplete">Incomplete</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rent-related fields (show only when For Rent is checked) -->
                    <div id="rent-fields" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="form-group">
                                    <label for="edit_rent_price_per_day">Rent Price Per Day</label>
                                    <input type="number" id="edit_rent_price_per_day" name="rent_price_per_day"
                                        class="form-control" min="0" step="0.01">
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label for="edit_rent_price_per_month">Rent Price Per Month</label>
                                    <input type="number" id="edit_rent_price_per_month" name="rent_price_per_month"
                                        class="form-control" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Purpose Selection - Matching Registration Form -->
                    <div class="border-2 border-red-200 rounded-lg p-4 bg-red-50 mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-red-800">Select Car Purpose</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- For Sale -->
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" id="edit_is_for_sale" name="is_for_sale" value="1"
                                    class="h-4 w-4">
                                <span class="font-medium">For Sale</span>
                            </label>

                            <!-- For Rent -->
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" id="edit_is_for_rent" name="is_for_rent" value="1"
                                    class="h-4 w-4">
                                <span class="font-medium">For Rent</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-save">Update Car</button>
                        <button type="button" class="btn-cancel" id="cancelCarEdit">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');

            // Initialize Bootstrap dropdowns to ensure they work properly
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            })

            // Add click handlers to dropdown items for debugging
            const dropdownLinks = document.querySelectorAll('.dropdown-content a');
            dropdownLinks.forEach((link, index) => {
                console.log('Dropdown link ' + index + ':', link.textContent);
                link.addEventListener('click', function(e) {
                    console.log('Dropdown link clicked:', e.target.textContent);
                });
            });

            // Profile Edit Modal Functionality
            const modal = document.getElementById('editProfileModal');
            const editBtn = document.getElementById('edit-profile-btn');
            const closeBtn = document.querySelector('.close');
            const cancelBtn = document.getElementById('cancelEdit');
            const editForm = document.getElementById('editProfileForm');

            // Profile Image Direct Upload Functionality
            const editImageBtn = document.getElementById('edit-profile-image-btn');
            const avatarInput = document.getElementById('avatar-input');
            const profileImage = document.getElementById('profile-image');

            // Share Profile Functionality
            const shareBtn = document.querySelector('#shareProfileModal').previousElementSibling;
            const shareModal = document.getElementById('shareProfileModal');
            const closeShareBtn = document.querySelector('.close-share');
            const cancelShareBtn = document.getElementById('cancelShare');
            const shareButtons = document.querySelectorAll('.share-btn');
            const copyLinkBtn = document.getElementById('copy-link-btn');
            const shareLinkInput = document.getElementById('share-link');

            // Open share modal when edit button is clicked (assuming there's a share button)
            const profileShareBtn = document.querySelector('.fa-share');
            if (profileShareBtn) {
                profileShareBtn.closest('button').addEventListener('click', function(e) {
                    e.preventDefault();
                    shareModal.style.display = 'block';
                });
            }

            // NEW: Open share modal when the share profile button is clicked
            const shareProfileBtn = document.getElementById('share-profile-btn');
            if (shareProfileBtn) {
                shareProfileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    shareModal.style.display = 'block';
                });
            }

            // Close share modal when X is clicked
            if (closeShareBtn) {
                closeShareBtn.addEventListener('click', function() {
                    shareModal.style.display = 'none';
                });
            }

            // Close share modal when clicking outside of modal content
            window.addEventListener('click', function(event) {
                if (event.target === shareModal) {
                    shareModal.style.display = 'none';
                }
            });

            // Handle share button clicks
            shareButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const platform = this.getAttribute('data-platform');
                    const profileUrl = shareLinkInput.value;
                    const profileName = document.getElementById('profile-name').textContent;

                    let shareUrl = '';

                    switch (platform) {
                        case 'facebook':
                            shareUrl =
                                `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(profileUrl)}`;
                            break;
                        case 'twitter':
                            shareUrl =
                                `https://twitter.com/intent/tweet?url=${encodeURIComponent(profileUrl)}&text=Check out ${encodeURIComponent(profileName)}'s profile`;
                            break;
                        case 'linkedin':
                            shareUrl =
                                `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(profileUrl)}`;
                            break;
                        case 'whatsapp':
                            shareUrl =
                                `https://wa.me/?text=Check out this profile: ${encodeURIComponent(profileUrl)}`;
                            break;
                        case 'telegram':
                            shareUrl =
                                `https://t.me/share/url?url=${encodeURIComponent(profileUrl)}&text=Check out this profile`;
                            break;
                        case 'email':
                            shareUrl =
                                `mailto:?subject=Check out this profile&body=I thought you might be interested in this profile: ${encodeURIComponent(profileUrl)}`;
                            break;
                        case 'sms':
                            shareUrl =
                                `sms:?body=Check out this profile: ${encodeURIComponent(profileUrl)}`;
                            break;
                        case 'copy':
                            // Copy to clipboard functionality
                            shareLinkInput.select();
                            document.execCommand('copy');

                            // Show feedback
                            const originalText = copyLinkBtn.textContent;
                            copyLinkBtn.textContent = 'Copied!';
                            setTimeout(() => {
                                copyLinkBtn.textContent = originalText;
                            }, 2000);
                            return;
                    }

                    // Open the share URL in a new window
                    if (shareUrl) {
                        window.open(shareUrl, '_blank', 'width=600,height=400');
                    }
                });
            });

            // Copy link button functionality
            if (copyLinkBtn) {
                copyLinkBtn.addEventListener('click', function() {
                    shareLinkInput.select();
                    document.execCommand('copy');

                    // Show feedback
                    const originalText = this.textContent;
                    const originalBgColor = this.style.backgroundColor;
                    this.textContent = 'Copied!';
                    this.style.backgroundColor = '#28a745'; // Success color from system
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.backgroundColor = originalBgColor;
                    }, 2000);
                });
            }

            // Trigger file input when camera button is clicked
            if (editImageBtn && avatarInput) {
                editImageBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    avatarInput.click();
                });

                // Handle file selection
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Show loading indicator
                        editImageBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        editImageBtn.disabled = true;

                        // Create FormData object
                        const formData = new FormData();
                        formData.append('avatar', file);
                        formData.append('_method', 'PATCH');
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'));

                        // Submit via AJAX
                        fetch("{{ route('profile.update') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update profile image on page
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        profileImage.src = e.target.result;
                                    }
                                    reader.readAsDataURL(file);

                                    // Show success message
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message ||
                                            'Profile image updated successfully!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    // Show error message
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message ||
                                            'Failed to update profile image. Please try again.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update profile image. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            })
                            .finally(() => {
                                // Reset button
                                editImageBtn.innerHTML = '<i class="fas fa-camera"></i>';
                                editImageBtn.disabled = false;
                                // Clear file input
                                avatarInput.value = '';
                            });
                    }
                });
            }

            // Open modal when edit button is clicked
            if (editBtn) {
                editBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    modal.style.display = 'block';
                });
            }

            // Close modal when X is clicked
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            // Close modal when cancel button is clicked
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            // Close modal when clicking outside of modal content
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Handle form submission
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form data
                    const formData = new FormData(editForm);

                    // Submit form via AJAX
                    fetch(editForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update profile information on page
                                const newName = document.getElementById('name').value;
                                document.getElementById('profile-name').textContent = newName;
                                document.getElementById('profile-display-name').textContent = newName;
                                document.getElementById('profile-email').textContent = document
                                    .getElementById('email').value;

                                // Update phone if provided
                                const phoneInput = document.getElementById('phone');
                                if (phoneInput) {
                                    const phoneElement = document.getElementById('profile-phone');
                                    if (phoneElement) {
                                        phoneElement.textContent = phoneInput.value || 'N/A';
                                    }
                                }

                                // Update address if provided
                                const addressInput = document.getElementById('address');
                                if (addressInput) {
                                    const addressElement = document.getElementById('profile-location');
                                    if (addressElement) {
                                        addressElement.textContent = addressInput.value ||
                                            'Location not set';
                                    }
                                }

                                // Update profile title as well
                                const profileTitle = document.getElementById('profile-title');
                                const bargainPart = profileTitle.textContent.split(' - ')[1];
                                if (bargainPart) {
                                    profileTitle.textContent = newName + ' - ' + bargainPart;
                                } else {
                                    profileTitle.textContent = newName;
                                }

                                // Close modal
                                modal.style.display = 'none';

                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message || 'Profile updated successfully!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Reload the page to reflect changes
                                    location.reload();
                                });
                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message ||
                                        'Failed to update profile. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update profile. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                });
            }
        });

        // Store bargains data for easy access
        const bargainsData = <?php echo json_encode($user->bargains); ?>;

        function switchToProfile() {
            // Update profile display
            document.getElementById('profile-title').textContent = '{{ $user->name }}';
            document.getElementById('profile-name').textContent = '{{ $user->name }}';
            document.getElementById('profile-location').textContent = 'Location not set';

            // Update registration mode button
            document.getElementById('registration-mode-btn').innerHTML = '<i class="fas fa-user"></i> {{ $user->name }}';

            // Show user cars (they are already visible by default)
            console.log('Switched to user profile');
        }

        function switchToBargain(bargainId, username, address) {
            // Update profile display
            document.getElementById('profile-title').textContent = '{{ $user->name }} - ' + username;
            document.getElementById('profile-name').textContent = username;
            document.getElementById('profile-location').textContent = address || 'N/A';

            // Update registration mode button
            document.getElementById('registration-mode-btn').innerHTML = '<i class="fas fa-handshake"></i> ' + username;

            console.log('Switched to bargain profile:', username);

            // Note: Since all cars belong to the user, we don't need to switch car containers
            // All user cars are displayed regardless of bargain selection
        }

        // Tab switching functionality
        document.querySelectorAll('.modern-tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                document.querySelectorAll('.modern-tab').forEach(t => t.classList.remove('active', 'border-primary', 'text-primary'));
                document.querySelectorAll('.modern-tab').forEach(t => t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab
                this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                this.classList.add('active', 'border-primary', 'text-primary');

                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId + '-tab').classList.remove('hidden');
                document.getElementById(tabId + '-tab').classList.add('active');
            });
        });

        // Make entire notification card clickable
        document.querySelectorAll('.notification-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.classList.contains('mark-as-read-btn')) {
                    return;
                }

                const carUrl = this.getAttribute('data-car-url');
                if (carUrl) {
                    window.location.href = carUrl;
                }
            });
        });

        // Mark notification as read
        document.querySelectorAll('.mark-as-read-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();

                const notificationId = this.getAttribute('data-notification-id');
                const notificationElement = document.querySelector(
                    `[data-notification-id="${notificationId}"]`);

                fetch(`/mark-notification-as-read/${notificationId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.notification-actions').remove();
                            notificationElement.classList.remove('unread');
                            notificationElement.classList.remove('unread');
                            const indicator = notificationElement.querySelector('.unread-indicator');
                            if (indicator) {
                                indicator.classList.remove('unread-indicator');
                                indicator.classList.add('read-indicator');
                                indicator.title = 'Read';
                            }

                            const countElement = document.getElementById('notification-count');
                            let count = parseInt(countElement.textContent);
                            if (count > 0) {
                                countElement.textContent = count - 1;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Car Edit Modal Functionality
        const carEditModal = document.getElementById('editCarModal');
        const closeCarEditBtn = document.getElementById('closeCarEdit');
        const cancelCarEditBtn = document.getElementById('cancelCarEdit');
        const editCarForm = document.getElementById('editCarForm');

        // Open car edit modal when edit button is clicked
        document.querySelectorAll('.edit-car-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const carData = JSON.parse(this.getAttribute('data-car-data'));

                // Debug: Log the car data to see what we're working with
                console.log('Full car data:', carData);
                console.log('Car make:', carData.make);
                console.log('Car model:', carData.model);
                console.log('Car color:', carData.car_color);

                // Function to add current value as first option if not exists
                function addCurrentValueAsFirstOption(selectId, currentValue, displayText) {
                    const select = document.getElementById(selectId);
                    if (!select || !currentValue) return;

                    // Check if current value already exists in options
                    const existingOption = Array.from(select.options).find(opt =>
                        opt.value === currentValue || opt.text === currentValue
                    );

                    if (!existingOption) {
                        // Add current value as first option
                        const newOption = document.createElement('option');
                        newOption.value = currentValue;
                        newOption.text = displayText || currentValue;
                        newOption.selected = true;
                        select.insertBefore(newOption, select.firstChild);
                    }
                }

                // Populate form fields with car data
                document.getElementById('edit_title').value = carData.title || '';

                // Function to set select value with comprehensive fallback
                function setSelectValue(selectId, value, fieldName) {
                    const select = document.getElementById(selectId);
                    if (!select || !value) {
                        console.log(`No value provided for ${fieldName}`);
                        return;
                    }

                    console.log(`Setting ${fieldName} to:`, value, typeof value);

                    // Convert value to string for comparison
                    const stringValue = String(value).trim();

                    // First try exact value match
                    select.value = stringValue;
                    if (select.value === stringValue) {
                        console.log(`Exact match found for ${fieldName}:`, stringValue);
                        return;
                    }

                    // Try case-insensitive value match
                    const options = select.options;
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value.toLowerCase() === stringValue.toLowerCase()) {
                            select.value = options[i].value;
                            console.log(`Case-insensitive value match for ${fieldName}:`, options[i].value);
                            return;
                        }
                    }

                    // Try case-insensitive text match
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].text.toLowerCase() === stringValue.toLowerCase()) {
                            select.value = options[i].value;
                            console.log(`Case-insensitive text match for ${fieldName}:`, options[i].value);
                            return;
                        }
                    }

                    // Try partial text match
                    for (let i = 0; i < options.length; i++) {
                        const optionText = options[i].text.toLowerCase();
                        const optionValue = options[i].value.toLowerCase();
                        if (optionText.includes(stringValue.toLowerCase()) ||
                            optionValue.includes(stringValue.toLowerCase()) ||
                            stringValue.toLowerCase().includes(optionText) ||
                            stringValue.toLowerCase().includes(optionValue)) {
                            select.value = options[i].value;
                            console.log(`Partial match for ${fieldName}:`, options[i].value);
                            return;
                        }
                    }

                    // If still no match, log all available options for debugging
                    console.log(`No match found for ${fieldName}. Available options:`,
                        Array.from(options).map(opt => ({
                            value: opt.value,
                            text: opt.text
                        })));
                    console.log(`Final ${fieldName} value:`, select.value);
                }

                // Add current values as first options and set them
                addCurrentValueAsFirstOption('edit_year', carData.year, carData.year);
                addCurrentValueAsFirstOption('edit_make', carData.make, carData.make);
                addCurrentValueAsFirstOption('edit_model', carData.model, carData.model);
                addCurrentValueAsFirstOption('edit_car_color', carData.car_color, carData.car_color);
                addCurrentValueAsFirstOption('edit_body_type', carData.body_type, carData.body_type);
                addCurrentValueAsFirstOption('edit_car_condition', carData.car_condition, carData
                    .car_condition);
                addCurrentValueAsFirstOption('edit_car_inside_color', carData.car_inside_color, carData
                    .car_inside_color);
                addCurrentValueAsFirstOption('edit_transmission_type', carData.transmission_type, carData
                    .transmission_type);
                addCurrentValueAsFirstOption('edit_currency_type', carData.currency_type, carData
                    .currency_type);
                addCurrentValueAsFirstOption('edit_car_documents', carData.car_documents, carData
                    .car_documents);

                // Set select values with proper handling
                setSelectValue('edit_year', carData.year, 'year');
                setSelectValue('edit_make', carData.make, 'make');
                setSelectValue('edit_model', carData.model, 'model');
                setSelectValue('edit_car_color', carData.car_color, 'car_color');
                setSelectValue('edit_body_type', carData.body_type, 'body_type');
                setSelectValue('edit_car_condition', carData.car_condition, 'car_condition');
                setSelectValue('edit_car_inside_color', carData.car_inside_color, 'car_inside_color');
                setSelectValue('edit_transmission_type', carData.transmission_type, 'transmission_type');
                setSelectValue('edit_currency_type', carData.currency_type, 'currency_type');
                setSelectValue('edit_car_documents', carData.car_documents, 'car_documents');

                // Set text inputs
                document.getElementById('edit_vin_number').value = carData.VIN_number || '';
                document.getElementById('edit_regular_price').value = carData.regular_price || '';

                document.getElementById('edit_rent_price_per_day').value = carData.rent_price_per_day || '';
                document.getElementById('edit_rent_price_per_month').value = carData.rent_price_per_month ||
                    '';
                document.getElementById('edit_description').value = carData.description || '';

                // Set checkboxes for car purpose
                document.getElementById('edit_is_for_sale').checked = carData.is_for_sale || false;
                document.getElementById('edit_is_for_rent').checked = carData.is_for_rent || false;

                // Set initial field visibility based on car purpose
                const saleFields = document.getElementById('sale-fields');
                const rentFields = document.getElementById('rent-fields');

                if (carData.is_for_sale) {
                    if (saleFields) saleFields.classList.remove('hidden');
                    if (rentFields) rentFields.classList.add('hidden');
                } else if (carData.is_for_rent) {
                    if (rentFields) rentFields.classList.remove('hidden');
                    if (saleFields) saleFields.classList.add('hidden');
                } else {
                    if (saleFields) saleFields.classList.add('hidden');
                    if (rentFields) rentFields.classList.add('hidden');
                }


                // Set form action URL
                editCarForm.action = `/car/update/${carData.id}`;

                // Show modal
                carEditModal.style.display = 'block';
            });
        });

        // Handle checkbox changes for car purpose (mutual exclusivity and field visibility)
        document.addEventListener('DOMContentLoaded', function() {
            const saleCheckbox = document.getElementById('edit_is_for_sale');
            const rentCheckbox = document.getElementById('edit_is_for_rent');
            const saleFields = document.getElementById('sale-fields');
            const rentFields = document.getElementById('rent-fields');

            if (saleCheckbox && rentCheckbox) {
                // Function to toggle field visibility and clear fields
                function toggleFields() {
                    if (saleCheckbox.checked) {
                        // Show sale fields, hide rent fields
                        if (saleFields) saleFields.classList.remove('hidden');
                        if (rentFields) rentFields.classList.add('hidden');

                        // Clear rent fields
                        document.getElementById('edit_rent_price_per_day').value = '';
                        document.getElementById('edit_rent_price_per_month').value = '';
                    } else if (rentCheckbox.checked) {
                        // Show rent fields, hide sale fields
                        if (rentFields) rentFields.classList.remove('hidden');
                        if (saleFields) saleFields.classList.add('hidden');

                        // Clear sale fields
                        document.getElementById('edit_regular_price').value = '';
                        document.getElementById('edit_car_documents').selectedIndex = 0;
                    } else {
                        // Hide both field groups
                        if (saleFields) saleFields.classList.add('hidden');
                        if (rentFields) rentFields.classList.add('hidden');
                    }
                }

                // Add event listeners for mutual exclusivity and field visibility
                saleCheckbox.addEventListener('change', function() {
                    if (this.checked && rentCheckbox.checked) {
                        rentCheckbox.checked = false;
                    }
                    toggleFields();
                });

                rentCheckbox.addEventListener('change', function() {
                    if (this.checked && saleCheckbox.checked) {
                        saleCheckbox.checked = false;
                    }
                    toggleFields();
                });

                // Initialize field visibility based on current state
                toggleFields();
            }
        });

        // Close car edit modal when X is clicked
        if (closeCarEditBtn) {
            closeCarEditBtn.addEventListener('click', function() {
                carEditModal.style.display = 'none';
            });
        }

        // Close car edit modal when cancel button is clicked
        if (cancelCarEditBtn) {
            cancelCarEditBtn.addEventListener('click', function() {
                carEditModal.style.display = 'none';
            });
        }

        // Close car edit modal when clicking outside of modal content
        window.addEventListener('click', function(event) {
            if (event.target === carEditModal) {
                carEditModal.style.display = 'none';
            }
        });

        // Handle car edit form submission
        if (editCarForm) {
            editCarForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get form data
                const formData = new FormData(editCarForm);

                // Submit form via AJAX
                fetch(editCarForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            carEditModal.style.display = 'none';

                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Car updated successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Reload the page to reflect changes
                                location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to update car. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update car. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            });
        }

        // Add delete functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete button clicks
            document.querySelectorAll('.delete-car-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const carId = this.getAttribute('data-car-id');
                    const carTitle = this.getAttribute('data-car-title');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Do you really want to delete "${carTitle}"? This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit delete request via AJAX
                            fetch(`/car/delete/${carId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => {
                                    // Check if the response is HTML (error page) or JSON
                                    const contentType = response.headers.get(
                                        'content-type');
                                    if (contentType && contentType.indexOf(
                                            'application/json') !== -1) {
                                        return response.json();
                                    } else {
                                        // If it's not JSON, it's probably an error page
                                        throw new Error(
                                            'Server returned an error page instead of JSON response'
                                        );
                                    }
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: 'The car has been deleted successfully.',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            // Remove the car element from the DOM instead of reloading
                                            const carElement = this.closest(
                                                '.car-item');
                                            if (carElement) {
                                                carElement.remove();
                                            }
                                            // Update car count
                                            const carCountElement = document
                                                .querySelector(
                                                    '.modern-tab.active');
                                            if (carCountElement) {
                                                const countText =
                                                    carCountElement.textContent;
                                                const countMatch = countText
                                                    .match(/\((\d+)\)/);
                                                if (countMatch) {
                                                    const currentCount =
                                                        parseInt(countMatch[1]);
                                                    if (currentCount > 0) {
                                                        carCountElement
                                                            .innerHTML =
                                                            carCountElement
                                                            .innerHTML.replace(
                                                                `(${currentCount})`,
                                                                `(${currentCount - 1})`
                                                            );
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        throw new Error(data.message ||
                                            'Failed to delete car');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to delete the car. Please try again. (Server Error)',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection
