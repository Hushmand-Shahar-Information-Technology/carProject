@extends('layouts.layout')
@section('title', 'Profile')
@section('content')


    <style>
        .new-post {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .new-post-circle {
            width: 60px;
            height: 50px;
            border: 2px dashed #363636;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .new-post-circle:hover {
            border-color: #555;
        }

        .new-post-circle i {
            font-size: 24px;
            color: #a8a8a8;
        }

        .new-post-label {
            font-size: 12px;
            color: #a8a8a8;
            font-weight: 600;
        }

        .nav-tabs {
            border-bottom: 1px solid #867272;
            margin-bottom: 30px;
        }

        .nav-tabs .nav-link {
            color: #a8a8a8;
            border: none;
            padding: 15px 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            background-color: #f8f9fa;
            /* Light background for inactive tabs */
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #363636;
            /* Dark background for active tab */
            border-bottom: 1px solid #fff;
        }

        .nav-tabs .nav-link:hover {
            color: #fff;
            border: none;
            background-color: #555;
            /* Hover effect */
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3px;
        }

        .post-item {
            aspect-ratio: 1;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .post-item img {
            width: 70%;
            height: 70%;
            object-fit: cover;
        }

        .post-overlay {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 4px;
            padding: 4px;
        }

        .post-overlay i {
            color: #fff;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .profile-img {
                width: 40%;
            }

            .stats {
                justify-content: center;
            }
        }

        .hover-state:hover {
            color: blue;
            text-decoration: underline;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
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

        /* Fix for tab content text visibility */
        #bargains-tab {
            color: #212529;
            /* Dark text for better visibility */
        }

        /* Ensure all text is visible on all backgrounds */
        .car-content a {
            color: #212529;
            /* Dark text for links */
        }

        .car-content a:hover {
            color: #000;
            /* Darker text on hover */
        }

        .car-content {
            color: #212529;
            /* Dark text for all content */
        }

        /* Improve card styling */
        .car-item {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Notification styles - Modern Redesign */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Dropdown menu styles */
        .profile-dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .dropdown-btn {
            background-color: #363636;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            min-width: 160px;
            text-align: left;
            width: 100%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
            left: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .profile-dropdown:hover .dropdown-content {
            display: block;
        }

        .profile-dropdown:hover .dropdown-btn {
            background-color: #555;
        }

        /* Status indicator styles */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-approved {
            background-color: #28a745;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-blocked {
            background-color: #dc3545;
        }

        .status-restricted {
            background-color: #fd7e14;
        }

        /* Bargain profile view */
        .bargain-profile-view {
            display: none;
        }

        .user-profile-view {
            display: block;
        }

        /* Notification styles - Modern Redesign */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .notifications-container {
            max-width: 100%;
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

        .notification-header {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .notification-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            background-color: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 20px;
        }

        .notification-info {
            flex: 1;
        }

        .notification-sender {
            font-weight: 600;
            color: #212529;
            margin-bottom: 3px;
        }

        .notification-car-title {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .notification-body {
            padding: 15px;
        }

        .notification-details {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .detail-item {
            flex: 1 1 50%;
            min-width: 200px;
            margin-bottom: 10px;
        }

        .detail-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 3px;
        }

        .detail-value {
            font-weight: 500;
            color: #212529;
        }

        .notification-actions {
            display: flex;
            justify-content: flex-end;
        }

        .mark-as-read-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .mark-as-read-btn:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }

        .read-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #28a745;
            margin-left: 10px;
        }

        .unread-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #007bff;
            margin-left: 10px;
        }

        .no-notifications {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .no-notifications i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ced4da;
        }

        /* Car image styling - consistent dimensions */
        .fixed-img {
            aspect-ratio: 16 / 9;
            object-fit: cover;
            width: 100%;
            border-radius: 8px 8px 0 0;
        }

        /* Modern Tab Navigation */
        .modern-tabs {
            display: flex;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 30px;
            padding: 0;
        }

        .modern-tab {
            padding: 12px 24px;
            cursor: pointer;
            font-weight: 500;
            color: #718096;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 8px 8px 0 0;
            margin-bottom: -2px;
        }

        .modern-tab:hover {
            color: #4a5568;
            background-color: #f7fafc;
        }

        .modern-tab.active {
            color: #2d3748;
            background-color: #ffffff;
            border-bottom: 2px solid #3182ce;
        }

        .notification-count-badge {
            background-color: #e53e3e;
            color: white;
            border-radius: 9999px;
            padding: 2px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 8px;
        }

        /* Car image styling - consistent dimensions */
        .fixed-img {
            aspect-ratio: 3 / 2;
            /* Adjusted for shorter height */
            object-fit: cover;
            width: 100%;
            border-radius: 8px 8px 0 0;
            height: auto;
            transition: transform 0.3s ease;
        }

        /* Improve car item styling */
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
            height: 30px;
            /* Further reduced height for shorter images */
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

        /* Responsive adjustments */
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

            .modern-tab {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
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

            .modern-tabs {
                flex-wrap: wrap;
            }

            .modern-tab {
                flex: 1 0 auto;
                text-align: center;
                margin-bottom: 0;
            }
        }

        .notification-header,
        .notification-body {
            padding: 12px;
        }
        }

        /* Car type badge styling */
        .car-type-badge {
            margin-right: 5px;
            font-size: 0.75rem;
        }
    </style>
    <!--================================ -->
    <section class="inner-intro bg-8 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white" id="profile-title">
                        {{ $user->name }}{{ isset($activeBargain) ? ' - ' . $activeBargain->name : '' }}</h1>
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


    <div class="container">

        <div class="my-5">
            <div class="card shadow-sm" style="margin: 0 auto;">
                <div class="row g-0">
                    <div class="col-md-4 p-3 text-center">
                        <img src="{{ isset($activeBargain) && $activeBargain->profile_image ? asset('storage/' . $activeBargain->profile_image) : asset('images/02.png') }}"
                            class="rounded-circle img-thumbnail profile-img" alt="Profile Picture" id="profile-image">
                        <div class="mt-2">
                            <!-- <span class="badge bg-success">Online</span> -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <span
                                    id="profile-name">{{ isset($activeBargain) ? $activeBargain->name : $user->name }}</span>
                                <div>
                                    @if (isset($activeBargain))
                                        <a href="{{ route('bargains.edit', $activeBargain->id) }}"
                                            class="btn btn-sm btn-outline-primary" id="edit-profile-btn">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @else
                                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary"
                                            id="edit-profile-btn">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endif
                                </div>
                            </h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-briefcase"></i> <span
                                    id="profile-email">{{ isset($activeBargain) ? $activeBargain->email : $user->email }}</span>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt"></i> <span
                                        id="profile-location">{{ isset($activeBargain) ? $activeBargain->address ?? 'N/A' : 'San Francisco, CA' }}</span>
                                </small>
                            </p>
                            <div class="border-top pt-2">
                                <div class="row text-center">
                                    <div class="col">
                                        <h6>Post</h6>
                                        <strong
                                            id="post-count">{{ isset($activeBargain) ? $activeBargain->cars->count() : $user->cars->count() }}</strong>
                                    </div>
                                    <!-- Only show bargains count when in user profile mode -->
                                    @if (!isset($activeBargain))
                                        <div class="col border-start" id="bargains-count-container">
                                            <h6>Bargains</h6>
                                            <strong id="bargains-count">{{ $bargains->count() }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Dropdown for Profile/Bargain Switch -->
                            <div class="border-top pt-2 mt-2">
                                <div class="row text-center">
                                    <!-- Dropdown for Profile/Bargain Switch -->
                                    <div class="col">
                                        <h6>Registration Mode</h6>
                                        <div class="profile-dropdown">
                                            <button class="dropdown-btn" id="registration-mode-btn">
                                                <i class="fas fa-user"></i>
                                                {{ isset($activeBargain) ? $activeBargain->name : 'User Profile' }}
                                            </button>
                                            <div class="dropdown-content">
                                                <a href="javascript:void(0)" onclick="switchToProfile()"><i
                                                        class="fas fa-user"></i> User Profile</a>
                                                @foreach ($bargains as $bargain)
                                                    <a href="javascript:void(0)"
                                                        onclick="switchToBargain({{ $bargain->id }}, '{{ addslashes($bargain->name) }}')"><i
                                                            class="fas fa-handshake"></i> {{ $bargain->name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bargain Status Display (only shown when in bargain mode) -->
                                    @if (isset($activeBargain))
                                        <div class="col border-start" id="bargain-status-container">
                                            <h6>Bargain Status</h6>
                                            <span
                                                class="badge {{ $activeBargain->status === 'approved' ? 'bg-success' : ($activeBargain->status === 'pending' ? 'bg-warning' : 'bg-danger') }}"
                                                id="bargain-status-badge">
                                                <span
                                                    class="status-indicator {{ 'status-' . $activeBargain->status }}"></span>
                                                {{ ucfirst($activeBargain->status) }}
                                            </span>
                                            <div id="bargain-restriction-info"></div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Show restriction message if bargain is restricted or blocked -->
                                @if (isset($activeBargain) && in_array($activeBargain->status, ['blocked', 'restricted']))
                                    <div class="alert alert-warning mt-2 mb-0" id="restriction-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span id="restriction-message-text">
                                            @if ($activeBargain->status === 'blocked')
                                                This bargain profile is currently blocked. Please contact support for
                                                assistance.
                                            @elseif ($activeBargain->status === 'restricted')
                                                This bargain profile has restrictions until
                                                {{ $activeBargain->restriction_until ? $activeBargain->restriction_until->format('M d, Y') : 'further notice' }}.
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-around">
                        <!-- <button class="btn btn-link text-decoration-none"> -->
                        <!-- <i class="fas fa-user-plus"></i> Follow -->
                        <!-- </button> -->
                        <button class="btn btn-link text-decoration-none">
                            <i class="fas fa-envelope"></i> Message
                        </button>
                        <button class="btn btn-link text-decoration-none">
                            <i class="fas fa-share"></i> Share
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Post Section -->
        <a href="{{ route('car.create') }}{{ isset($activeBargain) ? '?bargain_id=' . $activeBargain->id : '' }}"
            id="new-car-link">
            <div class="new-post">
                <div class="new-post-circle">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="new-post-label">New Car</div>
            </div>
        </a>

        <!-- Modern Tab Navigation -->
        <div class="modern-tabs">
            <div class="modern-tab active" data-tab="cars">
                Cars ({{ isset($activeBargain) ? $activeBargain->cars->count() : $user->cars->count() }})
            </div>
            <div class="modern-tab" data-tab="notifications">
                Notifications <span class="notification-count-badge"
                    id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
            </div>
            <div class="modern-tab" data-tab="bargains">
                Bargains ({{ $bargains->count() }})
            </div>
        </div>
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-tab="cars">Cars (<span
                        id="cars-tab-count">{{ isset($activeBargain) ? $activeBargain->cars->count() : $user->cars->count() }}</span>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="notifications">Notifications (<span
                        id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>)</a>
            </li>
            <!-- Only show bargains tab when in user profile mode -->
            @if (!isset($activeBargain))
                <li class="nav-item">
                    <a class="nav-link" data-tab="bargains">Bargains ({{ $bargains->count() }})</a>
                </li>
            @endif
        </ul>

        <!-- Cars Tab Content - Consistent Image Dimensions -->
        <div id="cars-tab" class="tab-content active">
            <div class="sorting-options-main">
                <div class="row" id="user-cars-container"
                    style="{{ isset($activeBargain) ? 'display: none;' : 'display: flex;' }}">
                    @forelse ($user->cars as $car)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="car-item gray-bg text-center promotion-card">
                                @if ($car->is_promoted)
                                    <span class="badge bg-success badge-promotion">Promoted</span>
                                @endif
                                <div class="car-image">
                                    @if (isset($car->images[0]))
                                        <img class="fixed-img" src="{{ asset('storage/' . $car->images[0]) }}"
                                            alt="{{ $car->title }}">
                                    @else
                                        <img class="fixed-img" src="{{ asset('images/car/01.jpg') }}"
                                            alt="Default Car Image">
                                    @endif
                                    <div class="car-overlay-banner">
                                        <ul>
                                            <li><a href="{{ route('car.show', $car->id) }}"><i
                                                        class="fa fa-link"></i></a>
                                            </li>
                                            <li><a href="{{ route('car.show', $car->id) }}"><i
                                                        class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="car-list">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-registered"></i> {{ $car->year }}</li>
                                        <li><i class="fa fa-cog"></i> {{ $car->transmission_type }} </li>
                                        <li><i class="fa fa-shopping-cart"></i> {{ $car->currency_type }}
                                            {{ number_format($car->regular_price) }}</li>
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
                                    <a href="{{ route('car.show', $car->id) }}">{{ $car->make }}
                                        {{ $car->model }}</a>
                                    <div class="separator"></div>
                                    <div class="price">
                                        <span class="new-price">{{ $car->currency_type }}
                                            {{ number_format($car->regular_price) }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <!-- Car type badges -->
                                        @if ($car->is_for_sale)
                                            <span class="badge bg-success">For Sale</span>
                                        @endif
                                        @if ($car->is_for_rent)
                                            <span class="badge bg-info">For Rent</span>
                                        @endif
                                        @if ($car->auctions && $car->auctions->count() > 0)
                                            <span class="badge bg-warning">Auction</span>
                                        @endif
                                        @if ($car->request_price_status)
                                            <span class="badge bg-primary">Request Price: {{ $car->currency_type }}
                                                {{ number_format($car->request_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-car me-2"></i> No cars posted yet.
                            </div>
                        </div>
                    @endforelse
                </div>
                <!-- Bargain cars container (hidden by default) -->
                <div class="row" id="bargain-cars-container"
                    style="{{ isset($activeBargain) ? 'display: flex;' : 'display: none;' }}">
                    @if (isset($activeBargain))
                        @forelse ($activeBargain->cars as $car)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="car-item gray-bg text-center promotion-card">
                                    @if ($car->is_promoted)
                                        <span class="badge bg-success badge-promotion">Promoted</span>
                                    @endif
                                    <div class="car-image">
                                        @if (isset($car->images[0]))
                                            <img class="fixed-img" src="{{ asset('storage/' . $car->images[0]) }}"
                                                alt="{{ $car->title }}">
                                        @else
                                            <img class="fixed-img" src="{{ asset('images/car/01.jpg') }}"
                                                alt="Default Car Image">
                                        @endif
                                        <div class="car-overlay-banner">
                                            <ul>
                                                <li><a href="{{ route('car.show', $car->id) }}"><i
                                                            class="fa fa-link"></i></a>
                                                </li>
                                                <li><a href="{{ route('car.show', $car->id) }}"><i
                                                            class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="car-list">
                                        <ul class="list-inline">
                                            <li><i class="fa fa-registered"></i> {{ $car->year }}</li>
                                            <li><i class="fa fa-cog"></i> {{ $car->transmission_type }} </li>
                                            <li><i class="fa fa-shopping-cart"></i> {{ $car->currency_type }}
                                                {{ number_format($car->regular_price) }}</li>
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
                                        <a href="{{ route('car.show', $car->id) }}">{{ $car->make }}
                                            {{ $car->model }}</a>
                                        <div class="separator"></div>
                                        <div class="price">
                                            <span class="new-price">{{ $car->currency_type }}
                                                {{ number_format($car->regular_price) }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <!-- Car type badges -->
                                            @if ($car->is_for_sale)
                                                <span class="badge bg-success">For Sale</span>
                                            @endif
                                            @if ($car->is_for_rent)
                                                <span class="badge bg-info">For Rent</span>
                                            @endif
                                            @if ($car->auctions && $car->auctions->count() > 0)
                                                <span class="badge bg-warning">Auction</span>
                                            @endif
                                            @if ($car->request_price_status)
                                                <span class="badge bg-primary">Request Price: {{ $car->currency_type }}
                                                    {{ number_format($car->request_price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-car me-2"></i> No cars posted for this bargain yet.
                                </div>
                            </div>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>

        <!-- Notifications Tab Content - With Links to Cars -->
        <div id="notifications-tab" class="tab-content">
            <div class="notifications-container">
                @if (auth()->user()->notifications->count() > 0)
                    @foreach (auth()->user()->notifications as $notification)
                        <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}"
                            data-notification-id="{{ $notification->id }}"
                            data-car-url="{{ route('car.show', $notification->data['car_id']) }}">
                            <div class="notification-header">
                                <div class="notification-image">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div class="notification-info">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="notification-sender">{{ $notification->data['sender_name'] }}
                                            </div>
                                            <div class="notification-car-title">
                                                <a href="{{ route('car.show', $notification->data['car_id']) }}"
                                                    class="text-decoration-none">
                                                    {{ $notification->data['car_title'] }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="notification-time">
                                                {{ $notification->created_at->diffForHumans() }}</div>
                                            @if (!$notification->read_at)
                                                <div class="unread-indicator" title="Unread"></div>
                                            @else
                                                <div class="read-indicator" title="Read"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-body">
                                <div class="notification-details">
                                    <div class="detail-item">
                                        <div class="detail-label">Offer Price</div>
                                        <div class="detail-value">${{ number_format($notification->data['offer_price']) }}
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Contact</div>
                                        <div class="detail-value">{{ $notification->data['sender_email'] }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Phone</div>
                                        <div class="detail-value">{{ $notification->data['sender_phone'] ?? 'N/A' }}</div>
                                    </div>
                                    @if ($notification->data['remark'])
                                        <div class="detail-item">
                                            <div class="detail-label">Message</div>
                                            <div class="detail-value">{{ $notification->data['remark'] }}</div>
                                        </div>
                                    @endif
                                </div>
                                @if (!$notification->read_at)
                                    <div class="notification-actions">
                                        <button class="mark-as-read-btn" data-notification-id="{{ $notification->id }}">
                                            Mark as Read
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-notifications">
                        <i class="fas fa-bell-slash"></i>
                        <h4>No Notifications</h4>
                        <p>You don't have any offer notifications yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bargains Tab Content (only shown when in user profile mode) -->
    @if (!isset($activeBargain))
        <div id="bargains-tab" class="tab-content">
            <div class="sorting-options-main">
                <div class="row">
                    @forelse ($bargains as $bargain)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="car-item gray-bg text-center promotion-card">
                                @if ($bargain->promotions->isNotEmpty())
                                    <span class="badge bg-success badge-promotion">Promoted</span>
                                @endif
                                <div class="car-image">
                                    @if ($bargain->profile_image)
                                        <img class="img-fluid" src="{{ asset('storage/' . $bargain->profile_image) }}"
                                            alt="{{ $bargain->name }}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('images/02.png') }}" alt="Default Profile">
                                    @endif
                                    <div class="car-overlay-banner">
                                        <ul>
                                            <li><a href="{{ route('bargains.show', $bargain->id) }}"><i
                                                        class="fa fa-link"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="car-list">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-user"></i> {{ $bargain->username }}</li>
                                        <li><i class="fa fa-globe"></i> {{ $bargain->website ?? 'N/A' }}</li>
                                        <li><i class="fa fa-file-contract"></i> {{ ucfirst($bargain->status) }}
                                        </li>
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
                                    <a href="{{ route('bargains.show', $bargain->id) }}">{{ $bargain->name }}</a>
                                    <div class="separator"></div>
                                    <div class="price">
                                        <span class="new-price">Bargain Registration</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge bg-info">Bargain</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-handshake me-2"></i> No bargains registered yet.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Get the current registration mode from localStorage or default to 'user'
        let currentRegistrationMode = localStorage.getItem('registrationMode') || 'user';
        let currentBargainId = localStorage.getItem('currentBargainId') || null;
        let currentBargainName = localStorage.getItem('currentBargainName') || null;
        let currentBargainData = null;

        // Store bargains data for easy access
        const bargainsData = @json($bargains);

        // Store bargains data in localStorage for navbar switcher
        localStorage.setItem('bargainsData', JSON.stringify(bargainsData));

        // Initialize the registration mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set the initial state of the dropdown based on localStorage or URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const bargainIdFromUrl = urlParams.get('bargain_id');

            if (bargainIdFromUrl) {
                // If there's a bargain_id in the URL, find the corresponding bargain
                const selectedBargain = bargainsData.find(b => b.id == bargainIdFromUrl);
                if (selectedBargain) {
                    switchToBargain(selectedBargain.id, selectedBargain.name);
                }
            } else if (currentRegistrationMode === 'bargain' && currentBargainId && currentBargainName) {
                const selectedBargain = bargainsData.find(b => b.id == currentBargainId);
                if (selectedBargain) {
                    switchToBargain(selectedBargain.id, selectedBargain.name);
                }
            } else {
                // Default to user profile
                switchToProfile();
            }
        });

        function toggleOffers() {
            const section = document.getElementById('offer-section');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        }

        // Tab switching functionality
        document.querySelectorAll('.nav-link').forEach(link => {
                    link.addEventListener('click', function(e) {

                                // Modern Tab switching functionality
                                document.querySelectorAll('.modern-tab').forEach(tab => {
                                    tab.addEventListener('click', function(e) {
                                        e.preventDefault();

                                        // Remove active class from all tabs
                                        document.querySelectorAll('.modern-tab').forEach(t => t.classList
                                            .remove('active'));
                                        document.querySelectorAll('.tab-content').forEach(content => content
                                            .classList.remove('active'));

                                        // Add active class to clicked tab
                                        this.classList.add('active');

                                        // Show corresponding content
                                        const tabId = this.getAttribute('data-tab');
                                        document.getElementById(tabId + '-tab').classList.add('active');
                                    });
                                });

                                // Add hover effects to post items
                                document.querySelectorAll('.post-item').forEach(item => {
                                    item.addEventListener('mouseenter', function() {
                                        this.style.transform = 'scale(1.02)';
                                        this.style.transition = 'transform 0.2s ease';
                                    });

                                    item.addEventListener('mouseleave', function() {
                                        this.style.transform = 'scale(1';
                                    });
                                });

                                // Make entire notification card clickable
                                document.querySelectorAll('.notification-card').forEach(card => {
                                    card.addEventListener('click', function(e) {
                                        // Prevent click if the user clicked on the "Mark as Read" button
                                        if (e.target.classList.contains('mark-as-read-btn')) {
                                            return;
                                        }

                                        // Get the car URL from the data attribute
                                        const carUrl = this.getAttribute('data-car-url');

                                        // Redirect to the car page
                                        if (carUrl) {
                                            window.location.href = carUrl;
                                        }
                                    });
                                });

                                // Mark notification as read
                                document.querySelectorAll('.mark-as-read-btn').forEach(button => {
                                    button.addEventListener('click', function(e) {
                                        e.stopPropagation(); // Prevent triggering the card click event

                                        const notificationId = this.getAttribute('data-notification-id');
                                        const notificationElement = document.querySelector(
                                            `[data-notification-id="${notificationId}"]`);

                                        fetch(`/mark-notification-as-read/${notificationId}`, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector(
                                                            'meta[name="csrf-token"]')
                                                        .getAttribute('content')
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    // Remove the button
                                                    this.closest('.notification-actions').remove();

                                                    // Remove unread class and indicator
                                                    notificationElement.classList.remove('unread');
                                                    const indicator = notificationElement.querySelector(
                                                        '.unread-indicator');
                                                    if (indicator) {
                                                        indicator.classList.remove('unread-indicator');
                                                        indicator.classList.add('read-indicator');
                                                        indicator.title = 'Read';
                                                    }

                                                    // Update notification count
                                                    const countElement = document
                                                        .getElementById('notification-count');
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


                                // Profile/Bargain switching functions
                                function switchToProfile() {
                                    // Clear the bargain_id from session via AJAX first
                                    fetch('/set-profile-mode', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                .getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            mode: 'user'
                                        })
                                    }).then(() => {
                                        // After session is cleared, reload the page without bargain_id parameter
                                        // Add explicit mode parameter to ensure we're in user mode
                                        window.location.href = '{{ route('user.profile') }}?mode=user';
                                    }).catch(error => {
                                        console.error('Error setting profile mode:', error);
                                        // Even if AJAX fails, still redirect to ensure we're in user mode
                                        window.location.href = '{{ route('user.profile') }}?mode=user';
                                    });
                                }

                                function switchToBargain(bargainId, bargainName) {
                                    // Store the registration mode in localStorage
                                    localStorage.setItem('registrationMode', 'user');
                                    localStorage.removeItem('currentBargainId');
                                    localStorage.removeItem('currentBargainName');
                                    currentBargainData = null;

                                    // Update URL to remove bargain_id parameter
                                    const url = new URL(window.location);
                                    url.searchParams.delete('bargain_id');
                                    window.history.replaceState({}, '', url);
                                }

                                function switchToBargain(bargainId, bargainName) {
                                    // Find the bargain data
                                    const selectedBargain = bargainsData.find(b => b.id == bargainId);

                                    if (selectedBargain) {
                                        // Check if the bargain is blocked or restricted
                                        if (selectedBargain.registration_status === 'blocked') {
                                            alert('Your bargain is currently blocked. You cannot post cars at this time.');
                                            return;
                                        }

                                        if (selectedBargain.registration_status === 'restricted' && selectedBargain
                                            .restriction_ends_at) {
                                            const restrictionEndDate = new Date(selectedBargain.restriction_ends_at);
                                            const today = new Date();
                                            if (restrictionEndDate > today) {
                                                alert('Your bargain is currently restricted until ' + restrictionEndDate
                                                    .toLocaleDateString() +
                                                    '. You cannot post cars during this period.');
                                                return;
                                            }
                                        }

                                        // Update the new car link to point to bargain registration
                                        document.getElementById('new-car-link').href =
                                            "{{ route('car.create') }}?bargain_id=" + bargainId;

                                        // Update dropdown button text
                                        updateRegistrationModeButton('bargain', bargainName);

                                        // Update profile information to show bargain details
                                        document.getElementById('profile-title').textContent = selectedBargain.name;
                                        document.getElementById('profile-name').textContent = selectedBargain.name;
                                        document.getElementById('profile-email').textContent = selectedBargain.email ||
                                            'N/A';
                                        document.getElementById('profile-location').textContent = selectedBargain.address ||
                                            'N/A';
                                        document.getElementById('post-count').textContent = selectedBargain.cars_count || 0;
                                        document.getElementById('offers-count').textContent = selectedBargain
                                            .total_offers || 0;
                                        // Hide bargains count for bargain profile
                                        document.getElementById('bargains-count-container').style.display = 'none';
                                        document.getElementById('cars-tab-count').textContent = selectedBargain
                                            .cars_count || 0;
                                        document.getElementById('bargains-tab-count').textContent = '0';

                                        // Show bargain status display
                                        updateBargainStatusDisplay(selectedBargain);

                                        // Hide edit profile button for bargain view
                                        document.getElementById('edit-profile-btn').style.display = 'none';

                                        // Load and display bargain cars via AJAX
                                        loadBargainCars(bargainId);

                                        // Store the registration mode and bargain info in localStorage
                                        localStorage.setItem('registrationMode', 'bargain');
                                        localStorage.setItem('currentBargainId', bargainId.toString());
                                        localStorage.setItem('currentBargainName', bargainName);
                                        currentBargainData = selectedBargain;

                                        // Update URL to include bargain_id parameter
                                        const url = new URL(window.location);
                                        url.searchParams.set('bargain_id', bargainId);
                                        window.history.replaceState({}, '', url);
                                    }
                                }

                                function updateRegistrationModeButton(mode, name) {
                                    const button = document.getElementById('registration-mode-btn');
                                    if (button) {
                                        if (mode === 'user') {
                                            button.innerHTML = '<i class="fas fa-user"></i> ' + name;
                                        } else {
                                            button.innerHTML = '<i class="fas fa-handshake"></i> ' + name;
                                        }
                                    }
                                }

                                function updateBargainStatusDisplay(bargain) {
                                    const statusContainer = document.getElementById('bargain-status-container');
                                    const statusBadge = document.getElementById('bargain-status-badge');
                                    const restrictionInfo = document.getElementById('bargain-restriction-info');
                                    const restrictionMessage = document.getElementById('restriction-message');
                                    const restrictionMessageText = document.getElementById('restriction-message-text');

                                    if (!statusContainer || !statusBadge) return;

                                    // Show the status container
                                    statusContainer.style.display = 'block';

                                    // Update status badge
                                    statusBadge.className = 'badge';
                                    statusBadge.innerHTML = '';

                                    let statusText = '';
                                    let statusClass = '';
                                    let statusIndicatorClass = '';

                                    switch (bargain.registration_status) {
                                        case 'approved':
                                            statusText = 'Approved';
                                            statusClass = 'bg-success';
                                            statusIndicatorClass = 'status-approved';
                                            break;
                                        case 'blocked':
                                            statusText = 'Blocked';
                                            statusClass = 'bg-danger';
                                            statusIndicatorClass = 'status-blocked';
                                            break;
                                        case 'restricted':
                                            statusText = 'Restricted';
                                            statusClass = 'bg-warning text-dark';
                                            statusIndicatorClass = 'status-restricted';
                                            break;
                                        default: // pending
                                            statusText = 'Pending';
                                            statusClass = 'bg-secondary';
                                            statusIndicatorClass = 'status-pending';
                                    }

                                    statusBadge.classList.add(statusClass);
                                    statusBadge.innerHTML =
                                        `<span class="status-indicator ${statusIndicatorClass}"></span> ${statusText}`;

                                    // Handle restriction info
                                    restrictionInfo.innerHTML = '';
                                    if (bargain.registration_status === 'restricted' && bargain.restriction_ends_at) {
                                        restrictionInfo.innerHTML =
                                            `<small class="d-block">Ends: ${new Date(bargain.restriction_ends_at).toLocaleDateString()}</small>`;
                                    }

                                    // Handle restriction message
                                    if (bargain.registration_status === 'restricted' || bargain.registration_status ===
                                        'blocked') {
                                        restrictionMessage.style.display = 'block';
                                        if (bargain.registration_status === 'blocked') {
                                            restrictionMessageText.textContent =
                                                'Your bargain is currently blocked. You cannot post cars at this time.';
                                        } else {
                                            restrictionMessageText.textContent =
                                                `Your bargain is currently restricted until ${new Date(bargain.restriction_ends_at).toLocaleDateString()}. You cannot post cars during this period.`;
                                        }
                                    } else {
                                        restrictionMessage.style.display = 'none';
                                    }
                                }

                                function loadBargainCars(bargainId) {
                                    // Show bargain cars container and hide user cars
                                    document.getElementById('user-cars-container').style.display = 'none';
                                    document.getElementById('bargain-cars-container').style.display = 'flex';

                                    // Clear existing content and show loading indicator
                                    document.getElementById('bargain-cars-container').innerHTML =
                                        '<div class="col-12"><div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div></div>';

                                    // Fetch bargain cars via AJAX
                                    fetch(`/user/profile/bargain/${bargainId}/cars`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.error) {
                                                document.getElementById('bargain-cars-container').innerHTML = `
                            <div class="col-12">
                                <div class="alert alert-danger text-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Error loading cars: ${data.error}
                                </div>
                            </div>
                        `;
                                            } else {
                                                displayBargainCars(data.cars);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error loading bargain cars:', error);
                                            document.getElementById('bargain-cars-container').innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i> Error loading cars. Please try again.
                            </div>
                        </div>
                    `;
                                        });
                                }

                                function displayBargainCars(cars) {
                                    const container = document.getElementById('bargain-cars-container');
                                    if (!cars || cars.length === 0) {
                                        container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-car me-2"></i> No cars registered by this bargain yet.
                        </div>
                    </div>
                `;
                                        return;
                                    }

                                    let carsHtml = '';
                                    cars.forEach(car => {
                                        // Format price with commas
                                        const formattedPrice = car.regular_price ? Number(car.regular_price)
                                            .toLocaleString() : 'N/A';

                                        carsHtml += `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="car-item gray-bg text-center promotion-card">
                            ${car.is_promoted ? '<span class="badge bg-success badge-promotion">Promoted</span>' : ''}
                            <div class="car-image">
                                ${car.images && car.images.length > 0 ? 
                                    `<img class="img-fluid" src="/storage/${car.images[0]}" alt="${car.title}">` :
                                    `<img class="img-fluid" src="/images/car/01.jpg" alt="Default Car Image">`
                                }
                                <div class="car-overlay-banner">
                                    <ul>
                                        <li><a href="/car/show/${car.id}"><i class="fa fa-link"></i></a></li>
                                        <li><a href="/car/show/${car.id}"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="car-list">
                                <ul class="list-inline">
                                    <li><i class="fa fa-registered"></i> ${car.year || 'N/A'}</li>
                                    <li><i class="fa fa-cog"></i> ${car.transmission_type || 'N/A'}</li>
                                    <li><i class="fa fa-shopping-cart"></i> ${car.currency_type || 'USD'} ${formattedPrice}</li>
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
                                <a href="/car/show/${car.id}">${car.make || 'N/A'} ${car.model || 'N/A'}</a>
                                <div class="separator"></div>
                                <div class="price">
                                    <span class="new-price">${car.currency_type || 'USD'} ${formattedPrice}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-primary">${car.offers_count || 0} Offers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                                    });

                                    container.innerHTML = carsHtml;
                                }
                                // Set the session to bargain mode via AJAX first
                                fetch('/set-profile-mode', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        mode: 'bargain',
                                        bargain_id: bargainId
                                    })
                                }).then(() => {
                                    // After session is set, reload the page with bargain_id parameter
                                    window.location.href = '{{ route('user.profile') }}?bargain_id=' + bargainId;
                                }).catch(error => {
                                    console.error('Error setting profile mode:', error);
                                    // Even if AJAX fails, still redirect to ensure we're in bargain mode
                                    window.location.href = '{{ route('user.profile') }}?bargain_id=' + bargainId;
                                });

                                // Store the current mode in localStorage
                                localStorage.setItem('registrationMode', 'bargain_' + bargainId);
                                localStorage.setItem('registrationModeName', bargainName);
                            }

                            // Set the registration mode button text based on current mode
                            document.addEventListener('DOMContentLoaded', function() {
                                // Add SweetAlert for bargain registration prevention
                                const newCarLink = document.getElementById('new-car-link');
                                if (newCarLink) {
                                    newCarLink.addEventListener('click', function(e) {
                                        // Check if we're in bargain mode
                                        const urlParams = new URLSearchParams(window.location.search);
                                        const bargainId = urlParams.get('bargain_id');

                                        // If in bargain mode, show SweetAlert
                                        if (bargainId) {
                                            e.preventDefault();
                                            Swal.fire({
                                                title: 'Switch to User Profile?',
                                                text: 'You are currently in bargain mode. To register a new bargain, please switch to user profile mode first.',
                                                icon: 'info',
                                                showCancelButton: true,
                                                confirmButtonText: 'Switch to User Profile',
                                                cancelButtonText: 'Cancel'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    switchToProfile();
                                                }
                                            });
                                        }
                                    });
                                }

                                const modeButton = document.getElementById('registration-mode-btn');
                                const urlParams = new URLSearchParams(window.location.search);
                                const bargainId = urlParams.get('bargain_id');

                                if (bargainId) {
                                    // We're in bargain mode, find the bargain name
                                    const bargainLinks = document.querySelectorAll('.dropdown-content a');
                                    for (let i = 0; i < bargainLinks.length; i++) {
                                        const onclickAttr = bargainLinks[i].getAttribute('onclick');
                                        if (onclickAttr && onclickAttr.includes(bargainId)) {
                                            const bargainName = bargainLinks[i].textContent.trim();
                                            modeButton.innerHTML = '<i class="fas fa-handshake"></i> ' + bargainName;
                                            break;
                                        }
                                    }
                                } else {
                                    // We're in user profile mode
                                    modeButton.innerHTML = '<i class="fas fa-user"></i> User Profile';
                                }

                                // Store bargains data in localStorage for navbar switcher
                                const bargainsData = [
                                    @foreach ($bargains as $bargain)
                                        {
                                            id: {{ $bargain->id }},
                                            name: "{{ addslashes($bargain->name) }}"
                                        },
                                    @endforeach
                                ];
                                localStorage.setItem('bargainsData', JSON.stringify(bargainsData));

                                // Also store current mode in localStorage for navbar
                                if (bargainId) {
                                    localStorage.setItem('currentProfileMode', 'bargain');
                                    localStorage.setItem('currentBargainId', bargainId);

                                    // Update the navbar switcher text to show current bargain name
                                    const switcherButton = document.querySelector('#navbar-switcher .dropdown-toggle');
                                    if (switcherButton) {
                                        // Find the bargain name
                                        const bargain = bargainsData.find(b => b.id == bargainId);
                                        if (bargain) {
                                            switcherButton.innerHTML = '<i class="fas fa-exchange-alt"></i> ' + bargain
                                                .name;
                                        }
                                    }
                                } else {
                                    localStorage.setItem('currentProfileMode', 'user');

                                    // Update the navbar switcher text to show user profile
                                    const switcherButton = document.querySelector('#navbar-switcher .dropdown-toggle');
                                    if (switcherButton) {
                                        switcherButton.innerHTML = '<i class="fas fa-exchange-alt"></i> User Profile';
                                    }
                                }

                                // Initialize navbar switcher
                                initializeNavbarSwitcher();
                            });

                            // Profile/Bargain switcher for navbar (copied from layout)
                            function initializeNavbarSwitcher() {
                                const switcher = document.getElementById('navbar-switcher');
                                const switcherContent = document.getElementById('navbar-switcher-content');

                                if (!switcher || !switcherContent) {
                                    return;
                                }

                                // Get bargains data from localStorage (set by profile page)
                                try {
                                    const bargainsData = JSON.parse(localStorage.getItem('bargainsData') || '[]');
                                    const currentMode = localStorage.getItem('currentProfileMode') || 'user';
                                    const currentBargainId = localStorage.getItem('currentBargainId') || null;

                                    // Clear existing content
                                    switcherContent.innerHTML = '';

                                    // Add user profile option
                                    const userItem = document.createElement('li');
                                    userItem.innerHTML =
                                        '<a class="dropdown-item" href="javascript:void(0)" onclick="switchToProfileFromNavbar()"><i class="fas fa-user"></i> User Profile</a>';
                                    switcherContent.appendChild(userItem);

                                    // Add bargain options
                                    bargainsData.forEach(bargain => {
                                        const item = document.createElement('li');
                                        item.innerHTML =
                                            `<a class="dropdown-item" href="javascript:void(0)" onclick="switchToBargainFromNavbar(${bargain.id}, '${bargain.name.replace(/'/g, "\\'")}')"><i class="fas fa-handshake"></i> ${bargain.name}</a>`;
                                        switcherContent.appendChild(item);
                                    });

                                    // Show the switcher
                                    switcher.style.display = 'block';

                                    // Highlight the current mode
                                    setTimeout(() => {
                                        highlightCurrentModeInNavbar(currentMode, currentBargainId);
                                    }, 100);
                                } catch (e) {
                                    console.error('Error initializing navbar switcher:', e);
                                }
                            }

                            function switchToProfileFromNavbar() {
                                // Clear the bargain_id from session via AJAX first
                                fetch('/set-profile-mode', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        mode: 'user'
                                    })
                                }).then(() => {
                                    // After session is cleared, reload the page without bargain_id parameter
                                    // Add explicit mode parameter to ensure we're in user mode
                                    window.location.href = '{{ route('user.profile') }}?mode=user';
                                }).catch(error => {
                                    console.error('Error setting profile mode:', error);
                                    // Even if AJAX fails, still redirect to ensure we're in user mode
                                    window.location.href = '{{ route('user.profile') }}?mode=user';
                                });
                            }

                            function switchToBargainFromNavbar(bargainId, bargainName) {
                                // Set the session to bargain mode via AJAX first
                                fetch('/set-profile-mode', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        mode: 'bargain',
                                        bargain_id: bargainId
                                    })
                                }).then(() => {
                                    // After session is set, reload the page with bargain_id parameter
                                    window.location.href = '{{ route('user.profile') }}?bargain_id=' + bargainId;
                                }).catch(error => {
                                    console.error('Error setting profile mode:', error);
                                    // Even if AJAX fails, still redirect to ensure we're in bargain mode
                                    window.location.href = '{{ route('user.profile') }}?bargain_id=' + bargainId;
                                });
                            }

                            function highlightCurrentModeInNavbar(currentMode, bargainId) {
                                // Get all dropdown items
                                const items = document.querySelectorAll('#navbar-switcher-content .dropdown-item');

                                // Remove any existing highlights
                                items.forEach(item => {
                                    item.classList.remove('bg-primary', 'text-white');
                                });

                                // Highlight the current mode
                                if (currentMode === 'user') {
                                    // Highlight user profile item (first item)
                                    if (items.length > 0) {
                                        items[0].classList.add('bg-primary', 'text-white');
                                    }
                                } else if (currentMode === 'bargain' && bargainId) {
                                    // Find and highlight the matching bargain item
                                    for (let i = 1; i < items.length; i++) { // Start from 1 to skip user profile item
                                        const onclickAttr = items[i].getAttribute('onclick');
                                        if (onclickAttr && onclickAttr.includes(bargainId)) {
                                            items[i].classList.add('bg-primary', 'text-white');
                                            break;
                                        }
                                    }
                                }

                                // Update the navbar switcher text to show current mode
                                const switcherButton = document.querySelector('#navbar-switcher .dropdown-toggle');
                                if (switcherButton) {
                                    if (currentMode === 'user') {
                                        switcherButton.innerHTML = '<i class="fas fa-exchange-alt"></i> User Profile';
                                    } else if (currentMode === 'bargain' && bargainId) {
                                        // Find the bargain name from localStorage
                                        try {
                                            const bargainsData = JSON.parse(localStorage.getItem('bargainsData') || '[]');
                                            const bargain = bargainsData.find(b => b.id == bargainId);
                                            if (bargain) {
                                                switcherButton.innerHTML = '<i class="fas fa-exchange-alt"></i> ' + bargain
                                                    .name;
                                            }
                                        } catch (e) {
                                            console.error('Error updating navbar switcher text:', e);
                                        }
                                    }
                                }
                            } <
                            /div>
    </script>

@endsection
