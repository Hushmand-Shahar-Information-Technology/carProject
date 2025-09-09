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
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: none;
            border-bottom: 1px solid #fff;
        }

        .nav-tabs .nav-link:hover {
            color: #fff;
            border: none;
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
    </section>`


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

        {{-- <div class="col-lg-9 col-md-8"> --}}
        <div class="sorting-options-main">
            <div class="row">
                @foreach ($profile->cars as $car)
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="car-item gray-bg text-center">
                            <div class="car-image">
                                <img class="img-fluid" src="{{ asset('storage/' . $car->images[0]) }}" alt="">
                                <div class="car-overlay-banner">
                                    <ul>
                                        <li><a href="{{ route('car.show', $car->id) }}"><i class="fa fa-link"></i></a></li>
                                        <li><a href="{{ route('car.show', $car->id) }}"><i
                                                    class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="car-list">
                                <ul class="list-inline">
                                    <li><i class="fa fa-registered"></i>{{ $car->year }}</li>
                                    <li><i class="fa fa-cog"></i> {{ $car->transmission_type }} </li>
                                    <li><i class="fa fa-shopping-cart"></i>{{ $car->currency }}</li>
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
                                <a href="#">Acura Rsx</a>
                                <div class="separator"></div>
                                <div class="price">
                                    <span class="old-price">${{ $car->regular_price }}</span>
                                    <span class="new-price">${{ $car->sale_price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleOffers() {
            const section = document.getElementById('offer-section');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        }
        // Add click functionality to tabs
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
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
