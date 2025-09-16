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
            height: 60px;
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
            border-bottom: 1px solid #363636;
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
            min-width: 180px;
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
                    <h1 class="text-white" id="profile-title">{{ $profile->name }}</h1>
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
                        <img src="{{ asset('images/02.png') }}" class="rounded-circle img-thumbnail profile-img"
                            alt="Profile Picture" id="profile-image">
                        <div class="mt-2">
                            <!-- <span class="badge bg-success">Online</span> -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <span id="profile-name">{{ $profile->name }}</span>
                                <div>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary"
                                        id="edit-profile-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-briefcase"></i> <span id="profile-email">{{ $profile->email }}</span>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt"></i> <span id="profile-location">San Francisco,
                                        CA</span>
                                </small>
                            </p>
                            <div class="border-top pt-2">
                                <div class="row text-center">
                                    <div class="col">
                                        <h6>Post</h6>
                                        <strong id="post-count">{{ $profile->cars_count }}</strong>
                                    </div>
                                    <div class="col border-start">
                                        <h6 style="cursor: pointer;" class="hover-state">Offers</h6>
                                        <strong
                                            id="offers-count">{{ $profile->cars->sum(fn($car) => $car->offers->count()) }}</strong>
                                    </div>
                                    <div class="col border-start" id="bargains-count-container">
                                        <h6>Bargains</h6>
                                        <strong id="bargains-count">{{ $bargains->count() }}</strong>
                                    </div>
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
                                                <i class="fas fa-user"></i> User Profile
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

                                    <!-- Bargain Status Display -->
                                    @if ($bargains->count() > 0)
                                        @php
                                            // We'll determine the active bargain in JavaScript
                                            $activeBargain = $bargains->first();
                                        @endphp

                                        <div class="col border-start" id="bargain-status-container" style="display: none;">
                                            <h6>Bargain Status</h6>
                                            <span class="badge bg-secondary" id="bargain-status-badge">
                                                <span class="status-indicator status-pending"></span>
                                                Pending
                                            </span>
                                            <div id="bargain-restriction-info"></div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Show restriction message if bargain is restricted or blocked -->
                                <div class="alert alert-warning mt-2 mb-0" id="restriction-message" style="display: none;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span id="restriction-message-text"></span>
                                </div>
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
        <a href="{{ route('car.create') }}" id="new-car-link">
            <div class="new-post">
                <div class="new-post-circle">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="new-post-label">New Car</div>
            </div>
        </a>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-tab="cars">Cars (<span
                        id="cars-tab-count">{{ $profile->cars->count() }}</span>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="notifications">Notifications (<span
                        id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="bargains">Bargains ({{ $bargains->count() }})</a>
            </li>
        </ul>

        <!-- Cars Tab Content - Consistent Image Dimensions -->
        <div id="cars-tab" class="tab-content active">
            <div class="sorting-options-main">
                <div class="row" id="user-cars-container">
                    @forelse ($profile->cars as $car)
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
                                        <span class="badge bg-primary">{{ $car->offers->count() }} Offers</span>
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
                <div class="row" id="bargain-cars-container" style="display: none;">
                    <!-- Bargain cars will be loaded here dynamically -->
                </div>
            </div>
        </div>

        <!-- Notifications Tab Content - With Links to Cars -->
        <div id="notifications-tab" class="tab-content">
            <div class="notifications-container">
                @if (auth()->user()->notifications->count() > 0)
                    @foreach (auth()->user()->notifications as $notification)
                        <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}"
                            data-notification-id="{{ $notification->id }}">
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

        <!-- Bargains Tab Content -->
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
                                        <li><i class="fa fa-file-contract"></i> {{ ucfirst($bargain->status) }}</li>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Tab switching functionality
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove(
                    'active'));

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

        // Mark notification as read
        document.querySelectorAll('.mark-as-read-btn').forEach(button => {
            button.addEventListener('click', function() {
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
                            // Remove the button
                            this.closest('.notification-actions').remove();

                            // Remove unread class and indicator
                            notificationElement.classList.remove('unread');
                            const indicator = notificationElement.querySelector('.unread-indicator');
                            if (indicator) {
                                indicator.classList.remove('unread-indicator');
                                indicator.classList.add('read-indicator');
                                indicator.title = 'Read';
                            }

                            // Update notification count
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
    </script>

@endsection
