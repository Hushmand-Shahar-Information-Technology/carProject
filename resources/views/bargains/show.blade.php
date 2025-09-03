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
                        <div class="mt-2">
                            <button id="btn-promote-bargain"
                                class="btn btn-sm btn-outline-primary">{{ $hasActivePromotion ? 'Promoted' : 'Promote' }}</button>
                            @if ($hasActivePromotion && $activePromotionEndsAt)
                                <div class="small text-muted mt-1">
                                    <span id="bargain-promotion-ends-at"
                                        data-ends-at="{{ $activePromotionEndsAt->toIso8601String() }}"></span>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('#btn-promote-bargain');
            if (!btn) return;
            e.preventDefault();
            if (btn.textContent.trim().toLowerCase() === 'promoted' ||
                {{ $hasActivePromotion ? 'true' : 'false' }}) {
                Swal.fire({
                    title: 'Unpromote this bargain?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(r => {
                    if (!r.isConfirmed) return;
                    axios.post('{{ route('promotions.unpromote') }}', {
                            type: 'bargain',
                            id: {{ $bargain->id }}
                        })
                        .then(() => {
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
                        })
                        .catch(() => Swal.fire('Error', 'Failed to unpromote', 'error'));
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
                axios.post('{{ route('promotions.promote') }}', {
                        type: 'bargain',
                        id: {{ $bargain->id }},
                        days
                    })
                    .then(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Promoted',
                            text: `Ends: ${res.data.ends_at}`,
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
                    })
                    .catch(() => Swal.fire('Error', 'Failed to promote', 'error'));
            });
        });

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
        @if ($hasActivePromotion && $activePromotionEndsAt)
            startPromotionCountdown('bargain-promotion-ends-at');
        @endif
    </script>
@endpush
