@extends('layouts.layout')
@section('title', 'Bargain Details')
@section('content')
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Bargian Details</h1>
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
@endsection
