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

        /* Ensure text is visible on dark background */
        .dark-bg-text {
            color: #fff;
        }
    </style>
    <!--================================ -->
    <section class="inner-intro bg-8 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">{{ $profile->name }}</h1>
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
                            alt="Profile Picture">
                        <div class="mt-2">
                            <!-- <span class="badge bg-success">Online</span> -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                {{ $profile->name }}
                                <div>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary" onclick="toggleOffers()"><i
                                            class="fas fa-inbox"></i> see offers</a>
                                </div>
                            </h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-briefcase"></i> {{ $profile->email }}
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt"></i> San Francisco, CA
                                </small>
                            </p>
                            <div class="border-top pt-2">
                                <div class="row text-center">
                                    <div class="col">
                                        <h6>Post</h6>
                                        <strong>{{ $profile->cars_count }}</strong>
                                    </div>
                                    <div class="col border-start">
                                        <h6 style="cursor: pointer;" class="hover-state">Offers</h6>
                                        <strong>{{ $profile->cars->sum(fn($car) => $car->offers->count()) }}</strong>
                                    </div>
                                    <div class="col border-start">
                                        <h6>Bargains</h6>
                                        <strong>{{ $bargains->count() }}</strong>
                                    </div>
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

        <div class="border-top pt-2 " id="offer-section" style="display: none;">
            <h1 class="text-center mt-4">offers</h1>
            <div class="row">
                <div class="col">
                    @foreach ($profile->cars->filter(fn($car) => $car->offers->isNotEmpty()) as $car)
                        <h5 class="text-primary"> {{ $car->title }} ({{ $car->offers->count() }} Offers)</h5>
                        <div class="pt-2 pb-5">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800">
                                            <th>Name</th>
                                            <th>Phone</th>
                                            {{-- <th>Email</th> --}}
                                            <th>Price</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($car->offers as $offer)
                                            <tr>
                                                <td>{{ $offer->name }}</td>
                                                <td>{{ $offer->phone }}</td>
                                                {{-- <td>{{ $offer->email }}</td> --}}
                                                <td>{{ $offer->price }}</td>
                                                <td>{{ $offer->remark }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- New Post Section -->
        <a href="{{ route('car.create') }}">
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
                <a class="nav-link active" data-tab="cars">Cars ({{ $profile->cars->count() }})</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-tab="bargains">Bargains ({{ $bargains->count() }})</a>
            </li>
        </ul>

        <!-- Cars Tab Content -->
        <div id="cars-tab" class="tab-content active">
            <div class="sorting-options-main">
                <div class="row">
                    @forelse ($profile->cars as $car)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="car-item gray-bg text-center promotion-card">
                                @if ($car->is_promoted)
                                    <span class="badge bg-success badge-promotion">Promoted</span>
                                @endif
                                <div class="car-image">
                                    @if (isset($car->images[0]))
                                        <img class="img-fluid" src="{{ asset('storage/' . $car->images[0]) }}"
                                            alt="{{ $car->title }}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('images/car/01.jpg') }}"
                                            alt="Default Car Image">
                                    @endif
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
    <script>
        function toggleOffers() {
            const section = document.getElementById('offer-section');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        }

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
                this.style.transform = 'scale(1)';
            });
        });
    </script>

@endsection
