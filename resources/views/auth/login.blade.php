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
            background: url('{{ asset('images/car/07.jpg') }}') center/cover;
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

        .remember-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #dc2626;
            margin-right: 8px;
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
        }
    </style>

    <div class="full-page-auth">
        <div class="container-fluid auth-container">
            <div class="row g-0 justify-content-center">
                <div class="col-12 col-xl-11">
                    <div class="auth-card">
                        <div class="row g-0 h-100">
                            <div class="col-md-6 col-lg-6 d-none d-md-block">
                                <div class="image-section"></div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-section">
                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="d-flex align-items-center mb-4">
                                            <i class="fas fa-sign-in-alt fa-2x me-3" style="color: #dc2626;"></i>
                                            <h1 class="fw-bold mb-0" style="color: #2c3e50;">Login</h1>
                                        </div>

                                        <h5 class="fw-normal mb-4 text-muted">Welcome back! Please sign in to your
                                            account</h5>

                                        <!-- Email Address -->
                                        <div class="mb-4">
                                            <div class="form-floating mb-1 position-relative">
                                                <i class="fas fa-envelope input-icon"></i>
                                                <x-text-input id="email" type="email" name="email"
                                                    :value="old('email')" required autofocus autocomplete="username"
                                                    placeholder=" "
                                                    class="form-control @error('email') is-invalid @enderror" />
                                                <label for="email">{{ __('Email Address') }}</label>
                                            </div>
                                            <x-input-error :messages="$errors->get('email')" />
                                        </div>


                                        <!-- Password -->
                                        <div class="form-floating mb-4">
                                            <i class="fas fa-lock input-icon"></i>
                                            <x-text-input id="password" class="form-control" type="password"
                                                name="password" required autocomplete="current-password"
                                                placeholder=" " />
                                            <label for="password">{{ __('Password') }}</label>
                                        </div>
                                        <x-input-error :messages="$errors->get('password')" class="" />

                                        <!-- Remember Me -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="d-flex align-items-center">
                                                <input id="remember_me" type="checkbox" class="remember-checkbox"
                                                    name="remember">
                                                <label for="remember_me"
                                                    class="text-muted small">{{ __('Remember me') }}</label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a class="text-muted text-decoration-none small"
                                                    href="{{ route('password.request') }}">
                                                    {{ __('Forgot password?') }}
                                                </a>
                                            @endif
                                        </div>

                                        <button class="btn red-btn w-100 mb-4" type="submit">
                                            <i class="fas fa-sign-in-alt me-2"></i>{{ __('Sign In') }}
                                        </button>

                                        <p class="text-center mb-0">
                                            Don't have an account?
                                            <a href="{{ route('register') }}" class="red-link">Create one here</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
