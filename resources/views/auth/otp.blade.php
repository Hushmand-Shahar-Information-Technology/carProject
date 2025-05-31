<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themes.potenzaglobalsolutions.com/html/cardealer/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 May 2025 11:17:54 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Car Dealer - The Best Car Dealer Automotive Responsive HTML5 Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title')</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  
    <!-- revolution -->
    <link rel="stylesheet" href="{{ asset('revolution/css/settings.css') }}" />

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

<style>

    .height-100 {
        height: 100vh
    }

    .card {
        width: 400px;
        border: none;
        height: 300px;
        box-shadow: 0px 5px 20px 0px #d2dae3;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .card h6 {
        color: blue;
        font-size: 20px
    }

    .inputs input {
        width: 45px;
        height: 45px
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        }

    #validateBtn:disabled {
        background-color: #ccc !important;
        border-color: #ccc !important;
        cursor: not-allowed;
        opacity: 0.7;
    }
</style>


</head>

<body>
<div class="container height-100 d-flex justify-content-center align-items-center">
    <div class="position-relative">
        <div class="card p-2 text-center">
            <form action="">
                <h6>Verify</h6>
                <div> <span>A code has been sent to</span> <small id="maskedNumber">*******9897</small> </div>
                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                    <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
                </div>
                <div class="mt-4" > 
                    <button id="validateBtn" type="submit" class="btn btn-primary px-4 validate" disabled>Validate</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            const validateBtn = document.getElementById('validateBtn');

            function checkInputsFilled() {
                const allFilled = Array.from(inputs).every(input => input.value.trim().length === 1);
                validateBtn.disabled = !allFilled;
            }

            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0];
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus();
                    }
                    checkInputsFilled();
                });

                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();
                        }
                        checkInputsFilled();
                    }
                });
            }
        }

        OTPInput();

        const validateBtn = document.getElementById('validateBtn');
        validateBtn.addEventListener('click', function() {
            let otp = '';
            document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
            alert(`Entered OTP: ${otp}`);
        });
    });
</script>


</body>
</html>