<x-guest-layout>
    <style>
        body {
            margin: 0;
            overflow-x: hidden;
        }

        .full-page-auth {
            min-height: 100vh;
            /* background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); */
            display: flex;
            align-items: center;
            position: relative;
        }

        .auth-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            min-height: 650px;
        }

        .form-floating {
            position: relative;
        }

        .form-floating>.form-control {
            height: 60px;
            padding: 1rem 0.75rem 0.25rem 55px;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-floating>.form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.15);
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            color: #dc2626;
        }

        .form-floating>label {
            position: absolute;
            top: 0;
            left: 55px;
            padding: 1rem 0.75rem;
            color: #6b7280;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 5;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .form-floating>.form-control:focus~.input-icon {
            color: #dc2626;
        }

        .red-btn {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border: none;
            border-radius: 16px;
            padding: 18px 40px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
        }

        .red-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(220, 38, 38, 0.4);
        }

        .error-message {
            margin-top: 8px;
            padding: 10px 15px;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 12px;
            color: #dc2626;
            font-size: 14px;
        }

        .red-link {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .red-link:hover {
            color: #b91c1c;
            text-decoration: underline;
        }

        .image-section {
            background: url('/images/car/07.jpg') center/cover;
            min-height: 650px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(220, 38, 38, 0.1);
        }

        .form-section {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 650px;
        }

        /* Wizard Styles */
        .wizard-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .wizard-progress::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e5e7eb;
            z-index: 1;
        }

        .progress-bar {
            position: absolute;
            top: 20px;
            left: 0;
            height: 4px;
            background: #dc2626;
            z-index: 2;
            transition: width 0.3s ease;
        }

        .progress-step {
            position: relative;
            z-index: 3;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .progress-step.active {
            background: #dc2626;
            color: white;
        }

        .progress-step.completed {
            background: #10b981;
            color: white;
        }

        .progress-step-label {
            position: absolute;
            top: 45px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            font-size: 14px;
            color: #6b7280;
        }

        .wizard-step {
            display: none;
        }

        .wizard-step.active {
            display: block;
        }

        .role-card {
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
        }

        .role-card:hover {
            border-color: #dc2626;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .role-card.selected {
            border-color: #dc2626;
            background: rgba(220, 38, 38, 0.05);
        }

        .role-icon {
            font-size: 2.5rem;
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .role-card h4 {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .role-card p {
            color: #6b7280;
            margin-bottom: 0;
        }

        .wizard-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .btn-wizard {
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-prev {
            background: #f3f4f6;
            color: #4b5563;
            border: none;
        }

        .btn-prev:hover {
            background: #e5e7eb;
        }

        .btn-next {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            border: none;
        }

        .btn-next:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-2px);
        }

        .review-section {
            background: #f9fafb;
            border-radius: 16px;
            padding: 1.5rem;
        }

        .review-item {
            padding: 0.5rem 0;
        }

        .review-item strong {
            color: #2c3e50;
        }

        .image-preview {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
            border-radius: 8px;
        }

        .image-preview img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-preview {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: #f3f4f6;
            border-radius: 8px;
        }

        .file-preview i {
            font-size: 1.5rem;
            color: #dc2626;
            margin-right: 0.75rem;
        }

        @media (max-width: 768px) {
            .form-section {
                padding: 2rem 1.5rem;
            }

            .auth-card {
                min-height: auto;
            }

            .image-section {
                min-height: 200px;
            }

            .form-floating>.form-control {
                height: 55px;
                padding-left: 50px;
            }

            .form-floating>label {
                left: 50px;
            }

            .input-icon {
                left: 18px;
            }

            .wizard-progress {
                margin-bottom: 1.5rem;
            }

            .progress-step-label {
                font-size: 12px;
                top: 40px;
            }
        }
    </style>

    <div class="full-page-auth">
        <div class="container-fluid auth-container">
            <div class="row g-0 justify-content-center">
                <div class="col-12 col-xl-11">
                    <div class="auth-card">
                        <div class="row g-0 h-100">
                            <div class="col-md-6 col-lg-4 d-none d-md-block">
                                <div class="image-section"></div>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="form-section">
                                    <div class="d-flex align-items-center mb-4">
                                        <i class="fas fa-user-plus fa-2x me-3" style="color: #dc2626;"></i>
                                        <h1 class="fw-bold mb-0" style="color: #2c3e50;">Register</h1>
                                    </div>

                                    <div id="wizard-alerts"></div>

                                    <form id="registration-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Progress Bar -->
                                        <div class="wizard-progress">
                                            <div class="progress-bar" style="width: 33%"></div>
                                            <div class="progress-step active" data-step="1">
                                                1
                                                <div class="progress-step-label">Role</div>
                                            </div>
                                            <div class="progress-step" data-step="2">
                                                2
                                                <div class="progress-step-label">Details</div>
                                            </div>
                                            <div class="progress-step" data-step="3">
                                                3
                                                <div class="progress-step-label">Review</div>
                                            </div>
                                        </div>

                                        <!-- Wizard Steps -->
                                        @include('auth.partials.role-select')
                                        @include('auth.partials.seller-form')
                                        @include('auth.partials.seeker-form')
                                        @include('auth.partials.review-step')

                                        <!-- Navigation -->
                                        <div class="wizard-navigation">
                                            <button type="button" id="prev-step" class="btn btn-prev btn-wizard d-none">
                                                <i class="fas fa-arrow-left me-2"></i>Previous
                                            </button>
                                            <button type="button" id="next-step" class="btn btn-next btn-wizard">
                                                Next<i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                            <button type="button" id="submit-registration" class="btn btn-next btn-wizard d-none">
                                                <i class="fas fa-check-circle me-2"></i>Confirm Registration
                                            </button>
                                        </div>
                                    </form>

                                    <p class="text-center mb-3 mt-4">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="red-link">Sign in here</a>
                                    </p>

                                    <div class="text-center">
                                        <a href="#!" class="text-muted text-decoration-none me-3 small">Terms
                                            of Service</a>
                                        <span class="text-muted">•</span>
                                        <a href="#!" class="text-muted text-decoration-none ms-3 small">Privacy
                                            Policy</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (required for the wizard) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS (required for some components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Registration Wizard JS -->
    <script src="{{ asset('js/register-wizard.js') }}"></script>
</x-guest-layout>