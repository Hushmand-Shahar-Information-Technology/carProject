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

        /* Car overlay banner styles */
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
                                            @can('update', $car)
                                                <li>
                                                    <a href="#" class="edit-car-btn" data-car-id="{{ $car->id }}"
                                                        data-car-data="{{ json_encode($car) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('delete', $car)
                                                <li>
                                                    <a href="#" class="delete-car-btn"
                                                        data-car-id="{{ $car->id }}"
                                                        data-car-title="{{ $car->make }} {{ $car->model }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </li>
                                            @endcan
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
                    <div class="row">
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="facebook">
                                <i class="fab fa-facebook-f fa-2x" style="color: #363636;"></i>
                                <div>Facebook</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="twitter">
                                <i class="fab fa-twitter fa-2x" style="color: #363636;"></i>
                                <div>Twitter</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="linkedin">
                                <i class="fab fa-linkedin-in fa-2x" style="color: #363636;"></i>
                                <div>LinkedIn</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="whatsapp">
                                <i class="fab fa-whatsapp fa-2x" style="color: #28a745;"></i>
                                <div>WhatsApp</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="telegram">
                                <i class="fab fa-telegram-plane fa-2x" style="color: #007bff;"></i>
                                <div>Telegram</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="email">
                                <i class="fas fa-envelope fa-2x" style="color: #dc3545;"></i>
                                <div>Email</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="copy">
                                <i class="fas fa-copy fa-2x" style="color: #363636;"></i>
                                <div>Copy Link</div>
                            </a>
                        </div>
                        <div class="col-3 text-center mb-3">
                            <a href="#" class="share-btn" data-platform="sms">
                                <i class="fas fa-sms fa-2x" style="color: #ffc107;"></i>
                                <div>SMS</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="share-link">Or copy the link:</label>
                    <div class="input-group">
                        <input type="text" id="share-link" class="form-control"
                            value="{{ route('profile.showUser', $user->id) }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copy-link-btn"
                            style="background-color: #363636; color: white; border-color: #363636;">Copy</button>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_title">Title *</label>
                                <input type="text" id="edit_title" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
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

                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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

                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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

                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_vin_number">VIN Number</label>
                                <input type="text" id="edit_vin_number" name="VIN_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_location">Location</label>
                                <input type="text" id="edit_location" name="location" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_transmission_type">Transmission Type</label>
                                <select id="edit_transmission_type" name="transmission_type" class="form-control">
                                    <option value="">Select Transmission</option>
                                    <option value="manual">Manual</option>
                                    <option value="automatic">Automatic</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_regular_price">Regular Price</label>
                                <input type="number" id="edit_regular_price" name="regular_price" class="form-control"
                                    min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_rent_price_per_day">Rent Price Per Day</label>
                                <input type="number" id="edit_rent_price_per_day" name="rent_price_per_day"
                                    class="form-control" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_rent_price_per_month">Rent Price Per Month</label>
                                <input type="number" id="edit_rent_price_per_month" name="rent_price_per_month"
                                    class="form-control" min="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_request_price">Request Price</label>
                                <input type="number" id="edit_request_price" name="request_price" class="form-control"
                                    min="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="radio" id="edit_is_for_sale" name="car_purpose"
                                        class="form-check-input" value="sale">
                                    <label for="edit_is_for_sale" class="form-check-label">For Sale</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="radio" id="edit_is_for_rent" name="car_purpose"
                                        class="form-check-input" value="rent">
                                    <label for="edit_is_for_rent" class="form-check-label">For Rent</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden inputs to ensure backend receives correct boolean values -->
                    <input type="hidden" id="edit_is_for_sale_hidden" name="is_for_sale" value="0">
                    <input type="hidden" id="edit_is_for_rent_hidden" name="is_for_rent" value="0">

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
            const shareBtn = document.querySelector('.btn-link.text-decoration-none .fa-share').closest(
                '.btn-link');
            const shareModal = document.getElementById('shareProfileModal');
            const closeShareBtn = document.querySelector('.close-share');
            const cancelShareBtn = document.getElementById('cancelShare');
            const shareButtons = document.querySelectorAll('.share-btn');
            const copyLinkBtn = document.getElementById('copy-link-btn');
            const shareLinkInput = document.getElementById('share-link');

            // Open share modal when share button is clicked
            if (shareBtn) {
                shareBtn.addEventListener('click', function(e) {
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

            // Close share modal when cancel button is clicked
            if (cancelShareBtn) {
                cancelShareBtn.addEventListener('click', function() {
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

                // Populate form fields with car data
                document.getElementById('edit_title').value = carData.title || '';
                document.getElementById('edit_year').value = carData.year || '';
                document.getElementById('edit_make').value = carData.make || '';
                document.getElementById('edit_model').value = carData.model || '';
                document.getElementById('edit_car_color').value = carData.car_color || '';
                document.getElementById('edit_body_type').value = carData.body_type || '';
                document.getElementById('edit_car_condition').value = carData.car_condition || '';
                document.getElementById('edit_car_inside_color').value = carData.car_inside_color || '';
                document.getElementById('edit_vin_number').value = carData.VIN_number || '';
                document.getElementById('edit_location').value = carData.location || '';
                document.getElementById('edit_transmission_type').value = carData.transmission_type || '';
                document.getElementById('edit_currency_type').value = carData.currency_type || '';
                document.getElementById('edit_regular_price').value = carData.regular_price || '';
                document.getElementById('edit_car_documents').value = carData.car_documents || '';
                document.getElementById('edit_rent_price_per_day').value = carData.rent_price_per_day || '';
                document.getElementById('edit_rent_price_per_month').value = carData.rent_price_per_month ||
                    '';
                document.getElementById('edit_request_price').value = carData.request_price || '';
                document.getElementById('edit_description').value = carData.description || '';

                // Set radio buttons for car purpose
                if (carData.is_for_sale) {
                    document.getElementById('edit_is_for_sale').checked = true;
                    document.getElementById('edit_is_for_sale_hidden').value = '1';
                    document.getElementById('edit_is_for_rent_hidden').value = '0';
                } else if (carData.is_for_rent) {
                    document.getElementById('edit_is_for_rent').checked = true;
                    document.getElementById('edit_is_for_sale_hidden').value = '0';
                    document.getElementById('edit_is_for_rent_hidden').value = '1';
                } else {
                    document.getElementById('edit_is_for_sale_hidden').value = '0';
                    document.getElementById('edit_is_for_rent_hidden').value = '0';
                }


                // Set form action URL
                editCarForm.action = `/car/update/${carData.id}`;

                // Show modal
                carEditModal.style.display = 'block';
            });
        });

        // Handle radio button changes for car purpose
        document.addEventListener('DOMContentLoaded', function() {
            const saleRadio = document.getElementById('edit_is_for_sale');
            const rentRadio = document.getElementById('edit_is_for_rent');
            const saleHidden = document.getElementById('edit_is_for_sale_hidden');
            const rentHidden = document.getElementById('edit_is_for_rent_hidden');

            if (saleRadio && rentRadio && saleHidden && rentHidden) {
                // Function to update hidden inputs based on radio selection
                function updateHiddenInputs() {
                    if (saleRadio.checked) {
                        saleHidden.value = '1';
                        rentHidden.value = '0';
                    } else if (rentRadio.checked) {
                        saleHidden.value = '0';
                        rentHidden.value = '1';
                    } else {
                        saleHidden.value = '0';
                        rentHidden.value = '0';
                    }
                }

                // Add event listeners
                saleRadio.addEventListener('change', updateHiddenInputs);
                rentRadio.addEventListener('change', updateHiddenInputs);

                // Initialize hidden inputs
                updateHiddenInputs();
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
                                                '.col-lg-4');
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
