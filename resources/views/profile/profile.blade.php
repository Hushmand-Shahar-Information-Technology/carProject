@extends('layouts.layout')
@section('title', 'Profile')
@section('content')
    @if (session('swal_error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Action Not Allowed',
                    text: "<?php echo e(session('swal_error')); ?>",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <style>
        /* Your existing CSS styles remain exactly the same */
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
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #363636;
            border-bottom: 1px solid #fff;
        }

        .nav-tabs .nav-link:hover {
            color: #fff;
            border: none;
            background-color: #555;
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

        #bargains-tab {
            color: #212529;
        }

        .car-content a {
            color: #212529;
        }

        .car-content a:hover {
            color: #000;
        }

        .car-content {
            color: #212529;
        }

        .car-item {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

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

        .profile-dropdown:hover .dropdown-content,
        .profile-dropdown:focus-within .dropdown-content {
            display: block;
        }

        .profile-dropdown:hover .dropdown-btn {
            background-color: #555;
        }

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

        .bargain-profile-view {
            display: none;
        }

        .user-profile-view {
            display: block;
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

        .car-type-badge {
            margin-right: 5px;
            font-size: 0.75rem;
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
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
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
            color: black;
            text-decoration: none;
        }

        .modal-header {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
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
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-save {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-save:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #545b62;
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

            .modern-tab {
                padding: 10px 16px;
                font-size: 0.9rem;
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

    <div class="container">
        <div class="my-5">
            <div class="card shadow-sm" style="margin: 0 auto;">
                <div class="row g-0">
                    <div class="col-md-4 p-3 text-center">
                        <div class="position-relative d-inline-block">
                            <img src="{{ $user->avatar && $user->avatar !== 'avatar.png' ? asset('storage/' . $user->avatar) : asset('images/demo.jpg') }}"
                                class="rounded-circle img-thumbnail profile-img" alt="Profile Picture" id="profile-image"
                                style="width: 150px; height: 150px; object-fit: cover;">
                            @if (auth()->check() && $user->id === auth()->id())
                                <div class="position-absolute bottom-0 end-0">
                                    <button type="button" class="btn btn-primary rounded-circle p-2 shadow"
                                        id="edit-profile-image-btn" style="width: 40px; height: 40px;">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                    <!-- Hidden file input for direct upload -->
                                    <input type="file" id="avatar-input" name="avatar" accept="image/*"
                                        style="display: none;">
                                </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <!-- <span class="badge bg-success">Online</span> -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <span id="profile-name">{{ $activeBargain ? $activeBargain->username : $user->name }}</span>
                                @if (auth()->check() && $user->id === auth()->id())
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="edit-profile-btn">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                @endif
                            </h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-briefcase"></i> <span id="profile-email">{{ $user->email }}</span>
                            </p>
                            @if ($user->phone)
                                <p class="card-text text-muted">
                                    <i class="fas fa-phone"></i> <span id="profile-phone">{{ $user->phone }}</span>
                                </p>
                            @endif
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt"></i> <span
                                        id="profile-location">{{ $activeBargain ? $activeBargain->address ?? 'N/A' : 'Location not set' }}</span>
                                </small>
                            </p>
                            <div class="border-top pt-2">
                                <div class="row text-center">
                                    <div class="col">
                                        <h6>Post</h6>
                                        <strong id="post-count">{{ $user->cars->count() }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-around">
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
        @if (auth()->check() && $user->id === auth()->id())
            <a href="{{ route('car.create') }}" id="new-car-link">
                <div class="new-post">
                    <div class="new-post-circle">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="new-post-label">New Car</div>
                </div>
            </a>
        @endif

        <!-- Modern Tab Navigation -->
        <div class="modern-tabs">
            <div class="modern-tab active" data-tab="cars">
                Cars ({{ $user->cars->count() }})
            </div>
            @if (auth()->check() && $user->id === auth()->id())
                <div class="modern-tab" data-tab="notifications">
                    Notifications <span class="notification-count-badge"
                        id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                </div>
            @endif
        </div>

        <!-- Cars Tab Content - Only show user cars -->
        <div id="cars-tab" class="tab-content active">
            <div class="sorting-options-main">
                <div class="row" id="user-cars-container">
                    @forelse ($user->cars as $car)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="car-item gray-bg text-center promotion-card">
                                @if ($car->is_promoted)
                                    <span class="badge bg-success badge-promotion">Promoted</span>
                                @endif
                                <div class="car-image">
                                    <img class="fixed-img" src="{{ asset($car->getFirstImageOrDefault()) }}"
                                        alt="{{ $car->title }}">
                                    <div class="car-overlay-banner">
                                        <ul>
                                            <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-link"></i></a>
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
                                            {{ number_format($car->regular_price) }}
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
                                    <a href="{{ route('car.show', $car->id) }}">{{ $car->make }}
                                        {{ $car->model }}</a>
                                    <div class="separator"></div>
                                    <div class="price">
                                        <span class="new-price">{{ $car->currency_type }}
                                            {{ number_format($car->regular_price) }}</span>
                                    </div>
                                    <div class="mt-2">
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
            </div>
        </div>

        <!-- Notifications Tab Content -->
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
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
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
                        <button type="submit" class="btn-save">Save Changes</button>
                        <button type="button" class="btn-cancel" id="cancelEdit">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                document.getElementById('profile-email').textContent = document
                                    .getElementById('email').value;

                                // Update phone if provided
                                const phoneInput = document.getElementById('phone');
                                if (phoneInput) {
                                    const phoneElement = document.getElementById('profile-phone');
                                    if (phoneElement) {
                                        phoneElement.textContent = phoneInput.value;
                                    } else if (phoneInput.value) {
                                        // Create phone element if it doesn't exist but has a value
                                        const phoneContainer = document.createElement('p');
                                        phoneContainer.className = 'card-text text-muted';
                                        phoneContainer.innerHTML =
                                            '<i class="fas fa-phone"></i> <span id="profile-phone">' +
                                            phoneInput.value + '</span>';
                                        document.querySelector('.card-body').insertBefore(
                                            phoneContainer, document.querySelector('.card-text')
                                            .nextSibling);
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
                document.querySelectorAll('.modern-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove(
                    'active'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
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
    </script>
    <!-- <script>
        // Emergency dropdown fix for profile page
        document.addEventListener('DOMContentLoaded', function() {
            // Force initialize all Bootstrap dropdowns
            setTimeout(function() {
                var dropdowns = document.querySelectorAll('.dropdown-toggle');
                dropdowns.forEach(function(dropdown) {
                    dropdown.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        var menu = this.nextElementSibling;
                        if (menu && menu.classList.contains('dropdown-menu')) {
                            var isVisible = menu.style.display === 'block';
                            // Hide all other dropdowns
                            document.querySelectorAll('.dropdown-menu').forEach(function(
                                m) {
                                m.style.display = 'none';
                            });
                            // Toggle current dropdown
                            menu.style.display = isVisible ? 'none' : 'block';
                        }
                    });
                });

                // Close dropdowns when clicking outside
                document.addEventListener('click', function() {
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.style.display = 'none';
                    });
                });
            }, 500);
        });
    </script> -->
@endsection
