@extends('layouts.layout')
@section('title', isset($bargain->id) ? 'Edit Bargain' : 'Create Bargain')

@section('content')
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Compare Cars</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                        <li><span>{{ isset($bargain->id) ? 'Edit Bargain' : 'Create Bargain' }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {{-- Alert messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="validation-alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- @if ($errors->has('edit_error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-times-circle"></i> {{ $errors->first('edit_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h5 mb-0">
                            {{ isset($bargain->id) ? 'Edit Bargain' : 'Create Bargain' }}
                        </h1>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST"
                            action="{{ isset($bargain->id) ? route('bargains.update', $bargain->id) : route('bargains.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($bargain->id))
                                @method('PUT')
                            @endif
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Profile Image</label>

                                    <!-- Image preview container -->
                                    <div class="position-relative mb-2" style="width:150px; height:150px; cursor:pointer;">
                                        <img id="profilePreview"
                                            src="{{ isset($bargain->profile_image) && file_exists(public_path('storage/' . $bargain->profile_image)) ? asset('storage/' . $bargain->profile_image) : 'https://via.placeholder.com/150' }}"
                                            alt="Profile Image"
                                            class="rounded-circle w-100 h-100 object-fit-cover border border-secondary"
                                            style="object-fit: cover;">
                                    </div>

                                    <!-- Hidden file input -->
                                    <input type="file" name="profile_image" id="profileImageInput"
                                        class="form-control d-none @error('profile_image') is-invalid @enderror"
                                        accept="image/*">

                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $bargain->name ?? '') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label>Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username', $bargain->username ?? '') }}">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $bargain->email ?? '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Website</label>
                                    <input type="text" name="website"
                                        class="form-control @error('website') is-invalid @enderror"
                                        value="{{ old('website', $bargain->website ?? '') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Phone</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $bargain->phone ?? '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Whatsapp</label>
                                    <input type="text" name="whatsapp"
                                        class="form-control @error('whatsapp') is-invalid @enderror"
                                        value="{{ old('whatsapp', $bargain->whatsapp ?? '') }}">
                                    @error('whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Contract Start Date</label>
                                    <input type="date" name="contract_start_date"
                                        class="form-control @error('contract_start_date') is-invalid @enderror"
                                        value="{{ old('contract_start_date', optional($bargain->contract_start_date)->format('Y-m-d')) }}">
                                    @error('contract_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Contract End Date</label>
                                    <input type="date" name="contract_end_date"
                                        class="form-control @error('contract_end_date') is-invalid @enderror"
                                        value="{{ old('contract_end_date', optional($bargain->contract_end_date)->format('Y-m-d')) }}">
                                    @error('contract_end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label>Address</label>
                                    <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $bargain->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="one-time"
                                            {{ old('status', $bargain->status) == 'one-time' ? 'selected' : '' }}>One-Time
                                        </option>
                                        <option value="more-time"
                                            {{ old('status', $bargain->status) == 'more-time' ? 'selected' : '' }}>
                                            More-Time</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ isset($bargain->id) ? 'Update' : 'Submit' }}
                                </button>
                                <a href="{{ route('bargains.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@if (session('success'))
    <script>
        Swal.fire('Success', "{{ session('success') }}", 'success');
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePreview = document.getElementById('profilePreview');
        const profileInput = document.getElementById('profileImageInput');

        // Click on image opens file selector
        profilePreview.addEventListener('click', () => profileInput.click());

        // Update preview when new file selected
        profileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
