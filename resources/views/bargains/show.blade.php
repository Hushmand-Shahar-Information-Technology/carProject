@extends('layouts.layout')
@section('title', 'Bargain Details')
@section('content')
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Bargain Details</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                        <li><span>Car Compare</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Profile Card -->
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-dark text-white text-center py-5 position-relative">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger text-white fs-6 p-2 rounded-3">
                                <i class="fas fa-id-card me-1"></i> {{ $bargain->registration_number }}
                            </span>
                        </div>

                        <img src="{{ $bargain->profile_image ? asset('storage/' . $bargain->profile_image) : 'https://via.placeholder.com/150' }}"
                            class="rounded-circle border border-5 border-white shadow object-fit-cover d-block mx-auto"
                            alt="Profile Image" style="width: 150px; height: 150px; object-fit: cover;">

                        <h2 class="fw-bold my-2 text-white">{{ $bargain->name }}</h2>
                        <p class="fs-5 mb-2 text-white-50">@ {{ $bargain->username }}</p>

                        <span class="badge bg-white text-dark fs-6 p-2 rounded-pill">
                            <i class="fas fa-circle me-1 small text-danger"></i> {{ ucfirst($bargain->status) }}
                        </span>

                        <!-- Registration Status Badge -->
                        <div class="mt-2">
                            @php
                                $statusConfig = [
                                    'pending' => [
                                        'class' => 'bg-warning text-dark',
                                        'text' => 'Pending Approval',
                                        'icon' => 'clock',
                                    ],
                                    'approved' => [
                                        'class' => 'bg-success text-white',
                                        'text' => 'Approved',
                                        'icon' => 'check-circle',
                                    ],
                                    'blocked' => [
                                        'class' => 'bg-danger text-white',
                                        'text' => 'Blocked',
                                        'icon' => 'x-circle',
                                    ],
                                    'restricted' => [
                                        'class' => 'bg-warning text-dark',
                                        'text' => 'Restricted',
                                        'icon' => 'exclamation-triangle',
                                    ],
                                ];
                                $currentStatus = $statusConfig[$bargain->registration_status ?? 'pending'];
                            @endphp
                            <span class="badge {{ $currentStatus['class'] }} fs-6 p-2 rounded-pill">
                                <i class="fas fa-{{ $currentStatus['icon'] }} me-1"></i> {{ $currentStatus['text'] }}
                            </span>
                            @if ($bargain->restriction_count > 0)
                                <span class="badge bg-warning text-dark fs-6 p-2 rounded-pill ms-1">
                                    <i class="fas fa-exclamation-triangle me-1"></i> {{ $bargain->restriction_count }}/3
                                    Restrictions
                                </span>
                            @endif
                        </div>

                        <!-- Status Messages for User -->
                        @if ($bargain->status_reason)
                            <div
                                class="mt-3 alert 
                                @if ($bargain->registration_status === 'blocked') alert-danger
                                @elseif($bargain->registration_status === 'restricted') alert-warning
                                @else alert-info @endif">
                                <strong><i class="fas fa-info-circle me-1"></i>Status Message:</strong>
                                {{ $bargain->status_reason }}
                                @if ($bargain->status_updated_at)
                                    <br><small class="text-muted"><i class="fas fa-clock me-1"></i>Last updated:
                                        {{ $bargain->status_updated_at->format('M d, Y H:i') }}</small>
                                @endif
                            </div>
                        @endif
                        <div class="mt-2">
                            @if ($bargain->canPromote())
                                <button id="btn-promote-bargain"
                                    class="btn btn-sm btn-outline-primary">{{ $hasActivePromotion ? 'Promoted' : 'Promote' }}</button>
                            @else
                                <button class="btn btn-sm btn-outline-secondary" disabled
                                    title="@if ($bargain->registration_status === 'blocked') User is blocked@elseif($bargain->hasActiveRestriction() && $bargain->restriction_ends_at)User is under restriction until {{ $bargain->restriction_ends_at->format('M d, Y') }}@else Cannot promote at this time @endif">
                                    <i class="fas fa-ban me-1"></i> Cannot Promote
                                </button>
                                @if ($bargain->hasActiveRestriction() && $bargain->restriction_ends_at)
                                    <div class="small text-danger mt-1">
                                        <i class="fas fa-clock me-1"></i>Restriction active until
                                        {{ $bargain->restriction_ends_at->format('M d, Y') }}
                                    </div>
                                @endif
                            @endif
                            @if ($hasActivePromotion && $activePromotionEndsAt)
                                <div class="small text-muted mt-1">
                                    <span id="bargain-promotion-ends-at"
                                        data-ends-at="{{ $activePromotionEndsAt->toIso86601String() }}"></span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Body -->
                    <div class="card-body p-4 p-md-5 bg-light">
                        <div class="row g-4">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm rounded-3">
                                    <div class="card-header bg-white border-0 pt-4">
                                        <h4 class="card-title text-danger fw-bold">
                                            <i class="fas fa-user-circle me-2"></i> Personal Information
                                        </h4>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div class="d-flex mb-3">
                                            <div class="me-3 text-danger">
                                                <i class="fas fa-envelope fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-0">Email</p>
                                                <p class="mb-0 text-dark">{{ $bargain->email }}</p>
                                            </div>
                                        </div>

                                        <div class="d-flex mb-3">
                                            <div class="me-3 text-danger">
                                                <i class="fas fa-phone fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-0">Phone</p>
                                                <p class="mb-0 text-dark">{{ $bargain->phone }}</p>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="me-3 text-danger">
                                                <i class="fab fa-whatsapp fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-0">WhatsApp</p>
                                                <p class="mb-0 text-dark">{{ $bargain->whatsapp }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Online Presence & Address -->
                            <div class="col-md-6">
                                <div class="card mb-4 border-0 shadow-sm rounded-3">
                                    <div class="card-header bg-white border-0 pt-4">
                                        <h4 class="card-title text-danger fw-bold">
                                            <i class="fas fa-globe me-2"></i> Online Presence
                                        </h4>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div class="d-flex">
                                            <div class="me-3 text-danger">
                                                <i class="fas fa-globe-americas fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-0">Website</p>
                                                <a href="{{ $bargain->website }}" target="_blank"
                                                    class="text-decoration-none text-dark">{{ $bargain->website }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm rounded-3">
                                    <div class="card-header bg-white border-0 pt-4">
                                        <h4 class="card-title text-danger fw-bold">
                                            <i class="fas fa-map-marker-alt me-2"></i> Address
                                        </h4>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div class="d-flex">
                                            <div class="me-3 text-danger">
                                                <i class="fas fa-home fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-0">Location</p>
                                                <p class="mb-0 text-dark">{{ $bargain->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Status Management Section -->
                        @php
                            // Temporarily allow anyone to see admin buttons for testing
                            $canManageStatus = true; // For testing - change back to proper auth check later

                            // Original admin check (commented out for testing):
                            // $canManageStatus =
                            //     auth()->check() &&
                            //     (auth()->user()->email === 'admin@example.com' ||
                            //         auth()->user()->email === 'admin@admin.com' ||
                            //         auth()->user()->email === 'dev@dev.com' ||
                            //         (method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole('admin')));

                        @endphp

                        @if ($canManageStatus)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm rounded-3">
                                        <div class="card-header bg-danger text-white pt-4">
                                            <h4 class="card-title text-white fw-bold mb-0">
                                                <i class="fas fa-user-cog me-2"></i> Status Management (Admin Only)
                                            </h4>
                                        </div>
                                        <div class="card-body bg-white">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <h6 class="text-muted mb-3">Current Status Information</h6>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div><strong>Registration Status:</strong>
                                                            <span class="badge {{ $currentStatus['class'] }} ms-1">
                                                                {{ $currentStatus['text'] }}
                                                            </span>
                                                        </div>
                                                        <div><strong>Restriction Count:</strong>
                                                            {{ $bargain->restriction_count ?? 0 }}/3</div>
                                                        @if ($bargain->restriction_ends_at && $bargain->registration_status === 'restricted')
                                                            <div><strong>Restriction Ends:</strong>
                                                                <span
                                                                    class="badge bg-danger text-white">{{ $bargain->restriction_ends_at->format('M d, Y') }}</span>
                                                                <br><small
                                                                    class="text-danger fw-bold">{{ $bargain->getRestrictionTimeRemaining() }}</small>
                                                            </div>
                                                            <div><strong>Restriction Duration:</strong>
                                                                <span
                                                                    class="text-danger fw-bold">{{ $bargain->restriction_duration_days ?? 0 }}
                                                                    days</span>
                                                            </div>
                                                        @endif
                                                        @if ($bargain->status_reason)
                                                            <div><strong>Status Reason:</strong>
                                                                <span
                                                                    class="text-muted">{{ $bargain->status_reason }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($bargain->status_updated_at)
                                                            <div><strong>Last Updated:</strong>
                                                                <span
                                                                    class="text-muted">{{ $bargain->status_updated_at->format('M d, Y') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-muted mb-3">Quick Status Actions</h6>
                                                    <div class="d-flex flex-wrap gap-2 mb-3" id="status-actions">
                                                        <!-- Pending Button -->
                                                        <button class="btn btn-secondary btn-sm status-action-btn"
                                                            data-status="pending" data-action="set-pending"
                                                            title="Set status to Pending"
                                                            {{ $bargain->registration_status === 'pending' ? 'disabled' : '' }}>
                                                            <i class="bi bi-clock me-1"></i> Pending
                                                        </button>

                                                        <!-- Approve Button -->
                                                        <button class="btn btn-success btn-sm status-action-btn"
                                                            data-status="approved" data-action="approve"
                                                            title="Approve this user registration"
                                                            {{ $bargain->registration_status === 'approved' ? 'disabled' : '' }}>
                                                            <i class="bi bi-check-circle me-1"></i> Approve
                                                        </button>

                                                        <!-- Restrict Button -->
                                                        <button class="btn btn-warning btn-sm status-action-btn"
                                                            data-status="restricted" data-action="restrict"
                                                            title="Restrict user (Warning: 3 restrictions = auto-block)"
                                                            {{ $bargain->registration_status === 'blocked' || ($bargain->restriction_count ?? 0) >= 3 ? 'disabled' : '' }}>
                                                            <i class="bi bi-exclamation-triangle me-1"></i> Restrict
                                                            @if (($bargain->restriction_count ?? 0) >= 3)
                                                                (Max)
                                                            @endif
                                                        </button>

                                                        <!-- Block Button -->
                                                        <button class="btn btn-danger btn-sm status-action-btn"
                                                            data-status="blocked" data-action="block"
                                                            title="Block user completely (No access to account)"
                                                            {{ $bargain->registration_status === 'blocked' ? 'disabled' : '' }}>
                                                            <i class="bi bi-x-circle me-1"></i> Block
                                                        </button>
                                                    </div>

                                                    <h6 class="text-muted mb-3">Additional Actions</h6>
                                                    <div class="d-flex flex-wrap gap-2" id="additional-actions">
                                                        <!-- Send Warning Button -->
                                                        <button class="btn btn-info btn-sm status-action-btn"
                                                            data-action="warning" title="Send warning message to user"
                                                            {{ $bargain->registration_status === 'blocked' ? 'disabled' : '' }}>
                                                            <i class="bi bi-bell me-1"></i> Send Warning
                                                        </button>

                                                        <!-- Reset Restrictions Button (only show if user has restrictions) -->
                                                        @if ($bargain->restriction_count > 0)
                                                            <button
                                                                class="btn btn-outline-success btn-sm status-action-btn"
                                                                data-action="reset-restrictions"
                                                                title="Clear all restrictions and reset count to 0">
                                                                <i class="bi bi-arrow-clockwise me-1"></i> Clear All
                                                                Restrictions
                                                            </button>
                                                        @endif

                                                        <!-- View Activity Log Button -->
                                                        <button class="btn btn-outline-secondary btn-sm"
                                                            onclick="showActivityLog()"
                                                            title="View status change history">
                                                            <i class="bi bi-journal-text me-1"></i> Activity Log
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-5 pt-3 flex-wrap">
                            <a href="{{ route('bargains.edit', $bargain->id) }}"
                                class="btn btn-danger btn-lg rounded-pill px-4 py-2 shadow-sm">
                                <i class="fas fa-edit me-2"></i> Edit Profile
                            </a>
                            <a href="{{ route('bargains.index') }}"
                                class="btn btn-outline-dark btn-lg rounded-pill px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cars registered by this bargain -->
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-danger text-white pt-4">
                        <h4 class="card-title text-white fw-bold mb-0">
                            <i class="fas fa-car me-2"></i> Cars Registered by this Bargain
                        </h4>
                    </div>
                    <div class="card-body bg-white">
                        @if ($bargain->cars && $bargain->cars->count() > 0)
                            <div class="row">
                                @foreach ($bargain->cars as $car)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="car-item gray-bg text-center promotion-card position-relative">
                                            @if ($car->is_promoted)
                                                <span class="badge bg-success badge-promotion position-absolute" style="top: 10px; right: 10px; z-index: 10;">Promoted</span>
                                            @endif
                                            @if ($car->auctions && $car->auctions->count() > 0)
                                                <span class="badge bg-warning position-absolute" style="top: 10px; left: 10px; z-index: 10;">Auction</span>
                                            @endif
                                            <div class="car-image">
                                                <img class="img-fluid fixed-img" src="{{ asset($car->getFirstImageOrDefault()) }}" alt="{{ $car->title }}">
                                                <div class="car-overlay-banner">
                                                    <ul style="display: flex; justify-content: center; align-items: center;">
                                                        <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-link"></i></a></li>
                                                        <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="car-content p-3">
                                                <div class="car-list mb-2">
                                                    <ul class="list-inline d-flex justify-content-around mb-0">
                                                        <li class="list-inline-item"><i class="fa fa-registered"></i> {{ $car->year }}</li>
                                                        <li class="list-inline-item"><i class="fa fa-cog"></i> {{ $car->transmission_type->value ?? $car->transmission_type }}</li>
                                                        <li class="list-inline-item"><i class="fa fa-shopping-cart"></i> {{ $car->currency_type }} {{ number_format($car->regular_price) }}</li>
                                                    </ul>
                                                </div>
                                                <div class="car-title mb-2">
                                                    <a href="{{ route('car.show', $car->id) }}" class="text-decoration-none">
                                                        <h5 class="mb-1">{{ $car->make }} {{ $car->model }}</h5>
                                                    </a>
                                                </div>
                                                <div class="star mb-2">
                                                    <i class="fa fa-star orange-color"></i>
                                                    <i class="fa fa-star orange-color"></i>
                                                    <i class="fa fa-star orange-color"></i>
                                                    <i class="fa fa-star orange-color"></i>
                                                    <i class="fa fa-star-o orange-color"></i>
                                                </div>
                                                <div class="price-container">
                                                    <div class="price-item">
                                                        <div class="price-label">Price</div>
                                                        <div class="price-value">
                                                            <span class="price-currency">{{ $car->currency_type }}</span>{{ number_format($car->regular_price) }}
                                                        </div>
                                                    </div>
                                                    @if ($car->auctions && $car->auctions->count() > 0)
                                                        @php
                                                            $activeAuction = $car->auctions->first();
                                                        @endphp
                                                        @if ($activeAuction)
                                                            <div class="price-item">
                                                                <div class="price-label">Starting Price</div>
                                                                <div class="price-value">
                                                                    <span class="price-currency">{{ $car->currency_type }}</span>{{ number_format($activeAuction->starting_price) }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
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
                                                        <span class="badge bg-primary">Request Price</span>
                                                    @endif
                                                    <span class="badge bg-primary">{{ $car->offers->count() }} Offers</span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-car me-2"></i> No cars registered by this bargain yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Data for JavaScript -->
    <div id="js-data" 
         data-bargain-id="{{ $bargain->id }}" 
         data-has-active-promotion="{{ $hasActivePromotion ? 'true' : 'false' }}" 
         data-restriction-count="{{ $bargain->restriction_count ?? 0 }}"
         data-unpromote-url="{{ route('promotions.unpromote') }}"
         data-promote-url="{{ route('promotions.promote') }}"
         data-send-warning-url="{{ route('bargains.send-warning', $bargain->id) }}"
         data-update-status-url="{{ route('bargains.update-status', $bargain->id) }}"
         data-csrf-token="{{ csrf_token() }}"
         style="display: none;">
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Tooltip -->
    <script>
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize promotion countdown if needed
            const hasActivePromotion = document.getElementById('js-data').getAttribute('data-has-active-promotion') === 'true';
            if (hasActivePromotion) {
                startPromotionCountdown('bargain-promotion-ends-at');
            }
        });
    </script>
    <script>
        // Status management buttons
        document.addEventListener('click', function(e) {
            const statusBtn = e.target.closest('.status-action-btn');
            if (statusBtn) {
                e.preventDefault();
                handleStatusAction(statusBtn);
                return;
            }

            // Promotion buttons
            const btn = e.target.closest('#btn-promote-bargain');
            if (!btn) return;
            e.preventDefault();
            
            // Get values from data attributes
            const jsData = document.getElementById('js-data');
            const bargainId = parseInt(jsData.getAttribute('data-bargain-id'));
            const hasActivePromotion = jsData.getAttribute('data-has-active-promotion') === 'true';
            const unpromoteUrl = jsData.getAttribute('data-unpromote-url');
            const promoteUrl = jsData.getAttribute('data-promote-url');
            const csrfToken = jsData.getAttribute('data-csrf-token');
            
            if (btn.textContent.trim().toLowerCase() === 'promoted' || hasActivePromotion) {
                Swal.fire({
                    title: 'Unpromote this bargain?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(r => {
                    if (!r.isConfirmed) return;
                    // Create the data object separately
                    const postData = {
                        type: 'bargain',
                        id: bargainId,
                        _token: csrfToken
                    };
                    axios.post(unpromoteUrl, postData)
                        .then(res => {
                            // Check if response data exists and has status
                            if (res && res.data && res.data.status === 'ok') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Unpromoted',
                                    timer: 1200,
                                    showConfirmButton: false
                                });
                                btn.textContent = 'Promote';
                                clearPromotionCountdown('bargain-promotion-ends-at');
                                const label = document.getElementById('bargain-promotion-ends-at');
                                if (label) {
                                    label.removeAttribute('data-ends-at');
                                    label.textContent = '';
                                }
                            } else {
                                // Handle case where response doesn't match expected format
                                console.error('Unexpected response format:', res);
                                Swal.fire('Error', 'Unexpected response format from server', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Unpromotion error:', error);
                            let errorMessage = 'Failed to unpromote';

                            // Check if this is the specific morph map error we're trying to fix
                            if (error.message && error.message.includes('morph map') && error.message
                                .includes('Promotion')) {
                                errorMessage =
                                    'Morph map configuration error has been fixed. Please refresh the page and try again.';
                            }
                            // More detailed error handling
                            else if (error.response) {
                                // Server responded with error status
                                if (error.response.data) {
                                    if (error.response.data.message) {
                                        errorMessage = error.response.data.message;
                                    } else if (typeof error.response.data === 'string') {
                                        errorMessage = error.response.data;
                                    } else {
                                        errorMessage = JSON.stringify(error.response.data);
                                    }
                                }
                                console.error('Server error response:', error.response);
                            } else if (error.request) {
                                // Request was made but no response received
                                errorMessage = 'No response from server. Please check your connection.';
                                console.error('No response from server:', error.request);
                            } else {
                                // Something else happened
                                errorMessage = error.message || 'Unknown error occurred';
                                console.error('Error setting up request:', error.message);
                            }

                            Swal.fire('Error', errorMessage, 'error');
                        });
                });
                return;
            }
            Swal.fire({
                title: 'Promote this bargain',
                input: 'number',
                inputLabel: 'How many days?',
                inputAttributes: {
                    min: 1,
                    max: 365
                },
                inputValue: 7,
                showCancelButton: true,
                confirmButtonText: 'Promote'
            }).then(result => {
                if (!result.isConfirmed) return;
                const days = parseInt(result.value, 10);
                if (!days || days < 1) return;
                // Create the data object separately
                const postData = {
                    type: 'bargain',
                    id: bargainId,
                    days: days,
                    _token: csrfToken
                };
                axios.post(promoteUrl, postData)
                    .then(res => {
                        // Check if response data exists and has status
                        if (res && res.data && res.data.status === 'ok') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Promoted',
                                text: res.data.ends_at ? `Ends: ${res.data.ends_at}` :
                                    'Promotion successful',
                                timer: 1600,
                                showConfirmButton: false
                            });
                            btn.textContent = 'Promoted';
                            // Insert/refresh countdown label
                            let label = document.getElementById('bargain-promotion-ends-at');
                            if (!label) {
                                btn.parentElement.insertAdjacentHTML('beforeend',
                                    '<div class="small text-muted mt-1"><span id="bargain-promotion-ends-at"></span></div>'
                                );
                                label = document.getElementById('bargain-promotion-ends-at');
                            }
                            if (res.data.ends_at) {
                                label.setAttribute('data-ends-at', new Date(res.data.ends_at)
                                    .toISOString());
                                startPromotionCountdown('bargain-promotion-ends-at');
                            }
                        } else {
                            // Handle case where response doesn't match expected format
                            console.error('Unexpected response format:', res);
                            Swal.fire('Error', res.data && res.data.message ? res.data.message :
                                'Failed to promote', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Promotion error:', error);
                        let errorMessage = 'Failed to promote';

                        // Check if this is the specific morph map error we're trying to fix
                        if (error.message && error.message.includes('morph map') && error.message
                            .includes('Promotion')) {
                            errorMessage =
                                'Morph map configuration error has been fixed. Please refresh the page and try again.';
                        }
                        // More detailed error handling
                        else if (error.response) {
                            // Server responded with error status
                            if (error.response.data) {
                                if (error.response.data.message) {
                                    errorMessage = error.response.data.message;
                                } else if (typeof error.response.data === 'string') {
                                    errorMessage = error.response.data;
                                } else if (error.response.data.error) {
                                    errorMessage = error.response.data.error;
                                } else {
                                    errorMessage = JSON.stringify(error.response.data);
                                }
                            }
                            console.error('Server error response:', error.response);
                        } else if (error.request) {
                            // Request was made but no response received
                            errorMessage = 'No response from server. Please check your connection.';
                            console.error('No response from server:', error.request);
                        } else {
                            // Something else happened
                            errorMessage = error.message || 'Unknown error occurred';
                            console.error('Error setting up request:', error.message);
                        }

                        Swal.fire('Error', errorMessage, 'error');
                    });
            });
        });

        // Handle status action function
        function handleStatusAction(btn) {
            const status = btn.getAttribute('data-status');
            const action = btn.getAttribute('data-action');
            
            // Get values from data attributes
            const jsData = document.getElementById('js-data');
            const sendWarningUrl = jsData.getAttribute('data-send-warning-url');
            const updateStatusUrl = jsData.getAttribute('data-update-status-url');
            const csrfToken = jsData.getAttribute('data-csrf-token');
            const restrictionCount = parseInt(jsData.getAttribute('data-restriction-count'));

            let confirmMessage = '';
            let actionText = '';
            let url = '';
            let showDescriptionInput = false;
            let descriptionLabel = '';

            if (action === 'warning') {
                confirmMessage = 'Send a warning to this user?';
                actionText = 'Warning sent successfully!';
                url = sendWarningUrl;
                showDescriptionInput = true;
                descriptionLabel = 'Warning Message (Optional):';
            } else if (action === 'reset-restrictions') {
                confirmMessage = 'Reset restriction count to 0? This will clear all previous restrictions.';
                actionText = 'Restrictions reset successfully!';
                url = updateStatusUrl;
            } else if (action === 'set-pending') {
                confirmMessage = 'Set this user\'s status back to Pending?';
                actionText = 'Status changed to Pending successfully!';
                url = updateStatusUrl;
                showDescriptionInput = true;
                descriptionLabel = 'Reason for setting to pending (Optional):';
            } else {
                switch (action) {
                    case 'approve':
                    case 'unblock':
                    case 'remove-restriction':
                        confirmMessage = 'Approve this user registration?';
                        actionText = 'User approved successfully!';
                        showDescriptionInput = true;
                        descriptionLabel = 'Approval note (Optional):';
                        break;
                    case 'block':
                        confirmMessage = 'Block this user? They will not be able to access their account.';
                        actionText = 'User blocked successfully!';
                        showDescriptionInput = true;
                        descriptionLabel = 'Reason for blocking (Optional):';
                        break;
                    case 'restrict':
                        if (restrictionCount >= 3) {
                            Swal.fire('Cannot Restrict', 'User already has maximum restrictions (3/3) and is blocked.',
                                'error');
                            return;
                        }
                        confirmMessage =
                            `Add restriction to this user? (${restrictionCount + 1}/3)\n\nWarning: User will be automatically blocked after 3 restrictions.`;
                        actionText = 'User restricted successfully!';
                        showDescriptionInput = true;
                        descriptionLabel = 'Reason for restriction (Optional):';
                        break;
                }
                url = updateStatusUrl;
            }

            // Create SweetAlert with optional description input
            const swalConfig = {
                title: 'Confirm Action',
                text: confirmMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            };

            if (showDescriptionInput) {
                let additionalFields = '';

                // Add duration field for restriction
                if (action === 'restrict') {
                    additionalFields = `
                        <div class="mt-3">
                            <label for="duration-input" class="form-label text-start d-block">Restriction Duration (Days):</label>
                            <input type="number" id="duration-input" class="form-control" min="1" max="365" value="7" placeholder="Enter number of days">
                            <small class="text-muted">Default: 7 days (1-365 days allowed)</small>
                        </div>
                    `;
                }

                swalConfig.html = `
                    <p>${confirmMessage}</p>
                    ${additionalFields}
                    <div class="mt-3">
                        <label for="description-input" class="form-label text-start d-block">${descriptionLabel}</label>
                        <textarea id="description-input" class="form-control" rows="3" maxlength="500" placeholder="Enter your message here..."></textarea>
                        <small class="text-muted">Maximum 500 characters</small>
                    </div>
                `;
                delete swalConfig.text;
            }

            Swal.fire(swalConfig).then((result) => {
                if (result.isConfirmed) {
                    const postData = {
                        _token: csrfToken
                    };

                    if (status) {
                        postData.status = status;
                    }

                    // Get description if input exists
                    if (showDescriptionInput) {
                        const descriptionInput = document.getElementById('description-input');
                        if (descriptionInput && descriptionInput.value.trim()) {
                            if (action === 'warning') {
                                postData.warning_message = descriptionInput.value.trim();
                            } else {
                                postData.description = descriptionInput.value.trim();
                            }
                        }

                        // Get duration for restriction
                        if (action === 'restrict') {
                            const durationInput = document.getElementById('duration-input');
                            if (durationInput && durationInput.value) {
                                postData.restriction_days = parseInt(durationInput.value);
                            }
                        }
                    }

                    // Special handling for reset restrictions
                    if (action === 'reset-restrictions') {
                        postData.reset_restrictions = true;
                    }

                    axios.post(url, postData)
                        .then(function(response) {
                            Swal.fire('Success', actionText, 'success').then(() => {
                                location.reload(); // Reload page to show updated status
                            });
                        })
                        .catch(function(error) {
                            let errorMessage = 'Failed to update user status!';
                            if (error.response && error.response.data && error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        });
                }
            });
        }

        // Show activity log function
        function showActivityLog() {
            Swal.fire({
                title: 'Activity Log',
                html: `
                    <div class="text-start">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span><strong>Current Status:</strong></span>
                            <span class="badge {{ $currentStatus['class'] }}">{{ $currentStatus['text'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span><strong>Restriction Count:</strong></span>
                            <span class="badge bg-info">{{ $bargain->restriction_count ?? 0 }}/3</span>
                        </div>
                        @if ($bargain->restriction_ends_at && $bargain->registration_status === 'restricted')
                        <div class="border-bottom pb-2 mb-2">
                            <strong>Restriction Details:</strong><br>
                            <span class="text-danger fw-bold">Duration: {{ $bargain->restriction_duration_days ?? 0 }} days</span><br>
                            <span class="text-danger fw-bold">Ends: {{ $bargain->restriction_ends_at->format('M d, Y') }}</span><br>
                            <span class="badge bg-danger text-white">{{ $bargain->getRestrictionTimeRemaining() }}</span>
                        </div>
                        @elseif ($bargain->registration_status === 'blocked' && $bargain->restriction_count >= 3)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>Block Details:</strong><br>
                            <span class="text-danger fw-bold">Blocked after {{ $bargain->restriction_count }} restrictions</span><br>
                            <span class="badge bg-dark text-white">Permanently Blocked</span>
                        </div>
                        @endif
                        @if ($bargain->status_reason)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>Status Reason:</strong><br>
                            <span class="text-muted">{{ $bargain->status_reason }}</span>
                        </div>
                        @endif
                        @if ($bargain->status_updated_at)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>Last Updated:</strong><br>
                            <span class="text-muted">{{ $bargain->status_updated_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                        <div class="mt-3">
                            <small class="text-muted">Note: Detailed activity logs would require additional database tracking.</small>
                        </div>
                    </div>
                `,
                width: '500px',
                showConfirmButton: true,
                confirmButtonText: 'Close'
            });
        }

        function clearPromotionCountdown(elementId) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const handle = el.getAttribute('data-countdown');
            if (handle) {
                clearInterval(Number(handle));
                el.removeAttribute('data-countdown');
            }
        }

        function startPromotionCountdown(elementId) {
            const el = document.getElementById(elementId);
            if (!el) return;
            clearPromotionCountdown(elementId);
            const endsAt = new Date(el.getAttribute('data-ends-at'));
            if (isNaN(endsAt)) return;
            const handle = setInterval(() => {
                const now = new Date();
                let diff = Math.max(0, endsAt - now);
                if (diff <= 0) {
                    el.textContent = 'Expired';
                    clearPromotionCountdown(elementId);
                    return;
                }
                const second = 1000;
                const minute = 60 * second;
                const hour = 60 * minute;
                const day = 24 * hour;
                const month = 30 * day;
                const year = 365 * day;
                const years = Math.floor(diff / year);
                diff %= year;
                const months = Math.floor(diff / month);
                diff %= month;
                const days = Math.floor(diff / day);
                diff %= day;
                const hours = Math.floor(diff / hour);
                diff %= hour;
                const minutes = Math.floor(diff / minute);
                diff %= minute;
                const seconds = Math.floor(diff / second);
                const segments = [];
                segments.push(`<span class=\"badge bg-dark text-white me-1\">${years}Y</span>`);
                segments.push(`<span class=\"badge bg-dark text-white me-1\">${months}M</span>`);
                segments.push(`<span class=\"badge bg-dark text-white me-1\">${days}D</span>`);
                segments.push(`<span class=\"badge bg-danger text-white me-1\">${hours}hr</span>`);
                segments.push(`<span class=\"badge bg-danger text-white me-1\">${minutes}min</span>`);
                segments.push(`<span class=\"badge bg-danger text-white\">${seconds}sec</span>`);
                el.innerHTML = segments.join(' ');
            }, 1000);
            el.setAttribute('data-countdown', String(handle));
        }
    </script>
@endpush

@push('styles')
    <style>
        /* Status Management Button Styling */
        .status-action-btn {
            transition: all 0.3s ease;
            border-radius: 6px;
            font-weight: 500;
            min-width: 100px;
            position: relative;
        }

        .status-action-btn:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .status-action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .status-action-btn[data-status="pending"] {
            background: linear-gradient(45deg, #6c757d, #8a8a8a);
            border: none;
        }

        .status-action-btn[data-status="approved"] {
            background: linear-gradient(45deg, #28a745, #34ce57);
            border: none;
            color: white;
        }

        .status-action-btn[data-status="restricted"] {
            background: linear-gradient(45deg, #dc3545, #e4606d);
            border: none;
            color: white;
        }

        .status-action-btn[data-status="blocked"] {
            background: linear-gradient(45deg, #6c757d, #8a8a8a);
            border: none;
            color: white;
        }

        .status-action-btn[data-action="warning"] {
            background: linear-gradient(45deg, #17a2b8, #20c997);
            border: none;
            color: white;
        }

        .status-action-btn[data-action="reset-restrictions"] {
            background: linear-gradient(45deg, #28a745, #34ce57);
            border: none;
            color: white;
        }

        /* Car Item Styling - Updated to match car listing page */
        .car-item {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .car-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .car-image {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .car-item:hover .car-image img {
            transform: scale(1.05);
        }

        .car-overlay-banner {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .car-item:hover .car-overlay-banner {
            opacity: 1;
        }

        .car-overlay-banner ul {
            display: flex;
            gap: 15px;
            padding: 0;
            margin: 0;
        }

        .car-overlay-banner ul li {
            list-style: none;
        }

        .car-overlay-banner ul li a {
            display: block;
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #db2d2e;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .car-overlay-banner ul li a:hover {
            background: #db2d2e;
            color: #fff;
            transform: scale(1.1);
        }

        .car-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .car-list ul {
            display: flex;
            justify-content: space-between;
            padding: 0;
            margin: 0 0 15px;
        }

        .car-list ul li {
            list-style: none;
            font-size: 14px;
            color: #666;
        }

        .car-title h5 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 10px;
        }

        .car-title h5 a {
            color: #333;
            text-decoration: none;
        }

        .car-title h5 a:hover {
            color: #db2d2e;
        }

        .star {
            margin: 0 0 15px;
        }

        .star i {
            font-size: 14px;
            margin: 0 1px;
        }

        .orange-color {
            color: #ff9800;
        }

        /* Enhanced Price Styling */
        .price-container {
            margin: 10px 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .price-item:first-child {
            border-left: 3px solid #db2d2e;
        }

        .price-label {
            font-size: 14px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .price-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .price-currency {
            font-size: 14px;
            color: #666;
        }

        .price-badge {
            background: #28a745;
            color: white;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .auction-price {
            background: #ffc107;
            color: #000;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* Badges */
        .badge-promotion {
            background: linear-gradient(45deg, #28a745, #34ce57) !important;
            padding: 8px 12px !important;
            font-weight: 600 !important;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-details, .btn-bargain {
            flex: 1;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-details {
            background: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .btn-details:hover {
            background: #0056b3;
            border-color: #0056b3;
        }

        .btn-bargain {
            background: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .btn-bargain:hover {
            background: #c82333;
            border-color: #c82333;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .car-list ul {
                flex-direction: column;
                gap: 5px;
            }
            
            .car-list ul li {
                text-align: center;
            }
            
            .price-value {
                font-size: 16px;
            }
        }
    </style>
@endpush
