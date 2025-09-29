$(document).ready(function () {
    // Wizard state
    let currentStep = 1;
    let formData = {};
    let selectedRole = null;

    // DOM Elements
    const $nextBtn = $('#next-step');
    const $prevBtn = $('#prev-step');
    const $submitBtn = $('#submit-registration');
    const $roleCards = $('.role-card');
    const $roleAutoSelected = $('#role-auto-selected');

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const urlType = urlParams.get('type');

    // Initialize wizard
    function initWizard() {
        console.log('Initializing wizard');
        console.log('URL type:', urlType);
        
        // Auto-select role if provided in URL
        if (urlType === 'seller' || urlType === 'seeker') {
            selectedRole = urlType === 'seller' ? 'car_seller' : 'car_seeker';
            $(`[data-role="${selectedRole}"]`).addClass('selected');
            $roleAutoSelected.show().find('.role-name').text(urlType === 'seller' ? 'Car Seller' : 'Car Seeker');
            formData.role = selectedRole;
            console.log('Auto-selected role:', selectedRole);
            
            // If we're on step 1, go to step 2 with the correct form
            if (currentStep === 1) {
                setTimeout(() => {
                    console.log('Auto-navigating to step 2 with role:', selectedRole);
                    goToStep(2);
                }, 100);
            }
        }

        // Role selection
        $roleCards.on('click', function () {
            console.log('Role card clicked');
            $roleCards.removeClass('selected');
            $(this).addClass('selected');
            selectedRole = $(this).data('role');
            formData.role = selectedRole;
            console.log('Selected role:', selectedRole);

            // If we're on step 1, go to step 2 with the correct form
            if (currentStep === 1) {
                console.log('Going to step 2 with selected role:', selectedRole);
                goToStep(2);
            }

            // Update URL immediately when role is selected
            const url = new URL(window.location);
            const roleType = selectedRole === 'car_seller' ? 'seller' : 'seeker';
            url.searchParams.set('type', roleType);
            window.history.pushState({}, '', url);
        });

        // Navigation - using event delegation
        $(document).on('click', '#next-step', function (e) {
            console.log('Next button clicked');
            e.preventDefault();
            nextStep();
        });
        $(document).on('click', '#prev-step', function (e) {
            e.preventDefault();
            prevStep();
        });
        $(document).on('click', '#submit-registration', function (e) {
            console.log('Submit button clicked');
            e.preventDefault();
            submitRegistration();
        });

        // Form input handling - capture data properly
        $(document).on('input change', 'input, select, textarea', function () {
            console.log('=== INPUT CHANGE EVENT ===');
            console.log('Changed element:', $(this));
            console.log('Changed element ID:', $(this).attr('id'));
            console.log('Changed element value:', $(this).val());
            console.log('Selected role:', selectedRole);
            console.log('Current step:', currentStep);

            console.log('Calling captureFormData from input change');
            captureFormData();
            console.log('=== INPUT CHANGE EVENT END ===');
        });

        // File input previews
        $(document).on('change', '.file-input', function () {
            console.log('File input changed');
            const fileName = $(this).attr('name');
            const files = this.files;

            if (fileName === 'profile_image') {
                handleProfileImagePreview(files[0]);
                // Store the file in formData
                formData.profile_image = files[0];
            }
            console.log('Calling captureFormData from file input change');
            captureFormData();
        });

        updateProgress();
        console.log('Wizard initialized');
    }

    // Handle profile image preview
    function handleProfileImagePreview(file) {
        console.log('Handling profile image preview');
        const $previewContainer = $('#profile-image-preview');
        $previewContainer.empty();

        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $previewContainer.html(
                    `<div class="image-preview">
                        <img src="${e.target.result}" class="img-fluid rounded" alt="Profile Image Preview">
                    </div>`
                );
            };
            reader.readAsDataURL(file);
        }
    }

    // Navigation functions
    function nextStep() {
        console.log('Next button clicked. Current step:', currentStep);
        console.log('Selected role:', selectedRole);

        if (currentStep === 1) {
            if (!selectedRole) {
                showError('Please select a role');
                return;
            }
            formData.role = selectedRole;
        }

        // Validate current step before proceeding
        console.log('Calling validateStep for step:', currentStep);
        const isValid = validateStep(currentStep);
        console.log('Validation result:', isValid);

        if (!isValid) {
            console.log('Validation failed, not proceeding to next step');
            // Show a general error message
            showError('Please fix the errors in the form before proceeding.');
            // Scroll to first error
            const $firstError = $('.is-invalid').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 100
                }, 500);
            }
            return;
        }

        if (currentStep < 3) {
            console.log('Going to step:', currentStep + 1);
            goToStep(currentStep + 1);
        }
    }

    function prevStep() {
        console.log('Previous button clicked. Current step:', currentStep);
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    }

    // Validate current step
    function validateStep(step) {
        let isValid = true;

        console.log('Validating step:', step);
        console.log('Selected role:', selectedRole);

        // Make sure we have the latest form data
        captureFormData();

        console.log('Form data after capture:', formData);

        if (step === 2) {
            // Validate step 2 (role-specific form)
            if (selectedRole === 'car_seller') {
                console.log('Validating seller form');
                // Validate seller form
                if (!formData.username) {
                    console.log('Username is missing');
                    isValid = false;
                    $('#step-2-seller #seller-username').addClass('is-invalid');
                    $('#step-2-seller #seller-username').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-username').closest('.form-group').append('<div class="error-message">Username is required</div>');
                } else {
                    $('#step-2-seller #seller-username').removeClass('is-invalid');
                    $('#step-2-seller #seller-username').closest('.form-group').find('.error-message').remove();
                }

                if (!formData.email) {
                    console.log('Email is missing');
                    isValid = false;
                    $('#step-2-seller #seller-email').addClass('is-invalid');
                    $('#step-2-seller #seller-email').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-email').closest('.form-group').append('<div class="error-message">Email is required</div>');
                } else {
                    $('#step-2-seller #seller-email').removeClass('is-invalid');
                    $('#step-2-seller #seller-email').closest('.form-group').find('.error-message').remove();
                }

                if (!formData.password) {
                    console.log('Password is missing');
                    isValid = false;
                    $('#step-2-seller #seller-password').addClass('is-invalid');
                    $('#step-2-seller #seller-password').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-password').closest('.form-group').append('<div class="error-message">Password is required</div>');
                } else {
                    $('#step-2-seller #seller-password').removeClass('is-invalid');
                    $('#step-2-seller #seller-password').closest('.form-group').find('.error-message').remove();
                }

                if (!formData.address) {
                    console.log('Address is missing');
                    isValid = false;
                    $('#step-2-seller #seller-address').addClass('is-invalid');
                    $('#step-2-seller #seller-address').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-address').closest('.form-group').append('<div class="error-message">Address is required</div>');
                } else {
                    $('#step-2-seller #seller-address').removeClass('is-invalid');
                    $('#step-2-seller #seller-address').closest('.form-group').find('.error-message').remove();
                }

                if (!formData.phone) {
                    console.log('Phone is missing');
                    isValid = false;
                    $('#step-2-seller #seller-phone').addClass('is-invalid');
                    $('#step-2-seller #seller-phone').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-phone').closest('.form-group').append('<div class="error-message">Phone is required</div>');
                } else {
                    $('#step-2-seller #seller-phone').removeClass('is-invalid');
                    $('#step-2-seller #seller-phone').closest('.form-group').find('.error-message').remove();
                }

                // Validate password confirmation
                if (formData.password && !formData.password_confirmation) {
                    console.log('Password confirmation is missing');
                    isValid = false;
                    $('#step-2-seller #seller-password-confirmation').addClass('is-invalid');
                    $('#step-2-seller #seller-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-password-confirmation').closest('.form-group').append('<div class="error-message">Please confirm your password</div>');
                } else if (formData.password && formData.password_confirmation && formData.password !== formData.password_confirmation) {
                    console.log('Passwords do not match');
                    isValid = false;
                    $('#step-2-seller #seller-password-confirmation').addClass('is-invalid');
                    $('#step-2-seller #seller-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seller #seller-password-confirmation').closest('.form-group').append('<div class="error-message">Passwords do not match</div>');
                } else {
                    $('#step-2-seller #seller-password-confirmation').removeClass('is-invalid');
                    $('#step-2-seller #seller-password-confirmation').closest('.form-group').find('.error-message').remove();
                }

                console.log('Seller form validation result:', isValid);
            } else if (selectedRole === 'car_seeker') {
                console.log('Validating seeker form');
                console.log('Seeker form data for validation:', {
                    full_name: formData.full_name,
                    email: formData.email,
                    password: formData.password,
                    password_confirmation: formData.password_confirmation
                });

                // Validate seeker form
                if (!formData.full_name) {
                    console.log('Full name is missing');
                    isValid = false;
                    $('#step-2-seeker #seeker-full-name').addClass('is-invalid');
                    $('#step-2-seeker #seeker-full-name').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seeker #seeker-full-name').closest('.form-group').append('<div class="error-message">Full name is required</div>');
                } else {
                    $('#step-2-seeker #seeker-full-name').removeClass('is-invalid');
                    $('#step-2-seeker #seeker-full-name').closest('.form-group').find('.error-message').remove();
                }

                if (!formData.email) {
                    console.log('Email is missing');
                    isValid = false;
                    $('#step-2-seeker #seeker-email').addClass('is-invalid');
                    $('#step-2-seeker #seeker-email').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seeker #seeker-email').closest('.form-group').append('<div class="error-message">Email is required</div>');
                } else {
                    $('#step-2-seeker #seeker-email').removeClass('is-invalid');
                    $('#step-2-seeker #seeker-email').closest('.form-group').find('.error-message').remove();
                }

                if (!formData.password) {
                    console.log('Password is missing');
                    isValid = false;
                    $('#step-2-seeker #seeker-password').addClass('is-invalid');
                    $('#step-2-seeker #seeker-password').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seeker #seeker-password').closest('.form-group').append('<div class="error-message">Password is required</div>');
                } else {
                    $('#step-2-seeker #seeker-password').removeClass('is-invalid');
                    $('#step-2-seeker #seeker-password').closest('.form-group').find('.error-message').remove();
                }

                // Validate password confirmation
                if (formData.password && !formData.password_confirmation) {
                    console.log('Password confirmation is missing');
                    isValid = false;
                    $('#step-2-seeker #seeker-password-confirmation').addClass('is-invalid');
                    $('#step-2-seeker #seeker-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seeker #seeker-password-confirmation').closest('.form-group').append('<div class="error-message">Please confirm your password</div>');
                } else if (formData.password && formData.password_confirmation && formData.password !== formData.password_confirmation) {
                    console.log('Passwords do not match');
                    isValid = false;
                    $('#step-2-seeker #seeker-password-confirmation').addClass('is-invalid');
                    $('#step-2-seeker #seeker-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#step-2-seeker #seeker-password-confirmation').closest('.form-group').append('<div class="error-message">Passwords do not match</div>');
                } else {
                    $('#step-2-seeker #seeker-password-confirmation').removeClass('is-invalid');
                    $('#step-2-seeker #seeker-password-confirmation').closest('.form-group').find('.error-message').remove();
                }

                console.log('Seeker form validation result:', isValid);
            } else {
                // If no role is selected, show error
                console.log('No role selected');
                isValid = false;
                showError('Please select a role first');
            }
        }

        console.log('Validation completed. isValid:', isValid);
        if (!isValid) {
            console.log('Validation failed, showing errors to user');
        }
        return isValid;
    }

    // Capture all form data
    function captureFormData() {
        console.log('=== CAPTURE FORM DATA START ===');
        console.log('Selected role:', selectedRole);
        console.log('Current step:', currentStep);

        // Capture data based on selected role and current step
        if (currentStep === 2) {
            if (selectedRole === 'car_seller') {
                console.log('Capturing seller data from step-2-seller');
                const username = $('#step-2-seller #seller-username').val();
                const phone = $('#step-2-seller #seller-phone').val();
                const email = $('#step-2-seller #seller-email').val();
                const password = $('#step-2-seller #seller-password').val();
                const password_confirmation = $('#step-2-seller #seller-password-confirmation').val();
                const address = $('#step-2-seller #seller-address').val();

                console.log('Raw seller values:', { username, phone, email, password: password ? '[HIDDEN]' : null, password_confirmation: password_confirmation ? '[HIDDEN]' : null, address });

                formData.username = username;
                formData.phone = phone;
                formData.email = email;
                formData.password = password;
                formData.password_confirmation = password_confirmation;
                formData.address = address;

                console.log('Seller form data captured:', {
                    username: formData.username,
                    phone: formData.phone,
                    email: formData.email,
                    password: formData.password ? '[HIDDEN]' : null,
                    password_confirmation: formData.password_confirmation ? '[HIDDEN]' : null,
                    address: formData.address
                });
            } else if (selectedRole === 'car_seeker') {
                console.log('Capturing seeker data from step-2-seeker');
                const full_name = $('#step-2-seeker #seeker-full-name').val();
                const email = $('#step-2-seeker #seeker-email').val();
                const password = $('#step-2-seeker #seeker-password').val();
                const password_confirmation = $('#step-2-seeker #seeker-password-confirmation').val();

                console.log('Raw seeker values:', { full_name, email, password: password ? '[HIDDEN]' : null, password_confirmation: password_confirmation ? '[HIDDEN]' : null });

                formData.full_name = full_name;
                formData.email = email;
                formData.password = password;
                formData.password_confirmation = password_confirmation;

                // Remove seller-specific fields from formData for seeker
                delete formData.username;
                delete formData.phone;
                delete formData.address;

                console.log('Seeker form data captured:', {
                    full_name: formData.full_name,
                    email: formData.email,
                    password: formData.password ? '[HIDDEN]' : null,
                    password_confirmation: formData.password_confirmation ? '[HIDDEN]' : null
                });
            } else {
                console.log('No role selected when capturing form data');
            }
        }

        // Update review step if we're on step 3
        if (currentStep === 3) {
            console.log('Calling updateReviewStep from captureFormData');
            updateReviewStep();
        }

        console.log('=== CAPTURE FORM DATA END ===');
    }

    function goToStep(step) {
        console.log('Going to step:', step);
        console.log('Selected role:', selectedRole);
        currentStep = step;

        // Hide all steps
        $('.wizard-step').removeClass('active');

        // Show current step
        if (step === 1) {
            $('#step-1').addClass('active');
        } else if (step === 2) {
            // Show the correct form based on selected role
            if (selectedRole === 'car_seller') {
                $('#step-2-seller').addClass('active');
                console.log('Showing seller form');
            } else if (selectedRole === 'car_seeker') {
                $('#step-2-seeker').addClass('active');
                console.log('Showing seeker form');
            } else {
                console.error('No role selected when trying to show step 2');
            }
        } else if (step === 3) {
            $('#step-3').addClass('active');
        }

        // Update button visibility
        $prevBtn.toggleClass('d-none', step === 1);
        $nextBtn.toggleClass('d-none', step === 3);
        $submitBtn.toggleClass('d-none', step !== 3);

        // Update progress
        updateProgress();

        // Update URL
        updateUrl();

        // If going to step 3, update review
        if (step === 3) {
            console.log('Calling captureFormData and updateReviewStep from goToStep');
            captureFormData();
            updateReviewStep();
        }
    }

    function updateProgress() {
        console.log('Updating progress. Current step:', currentStep);
        $('.progress-step').removeClass('active completed');
        for (let i = 1; i <= 3; i++) {
            if (i < currentStep) {
                $(`.progress-step[data-step="${i}"]`).addClass('completed');
            } else if (i === currentStep) {
                $(`.progress-step[data-step="${i}"]`).addClass('active');
            }
        }

        // Update progress bar width
        const progressWidth = ((currentStep - 1) / 2) * 100;
        $('.progress-bar').css('width', progressWidth + '%');
    }

    function updateUrl() {
        console.log('Updating URL. Current step:', currentStep, 'Selected role:', selectedRole);
        const url = new URL(window.location);
        url.searchParams.set('step', currentStep);
        if (selectedRole) {
            const roleType = selectedRole === 'car_seller' ? 'seller' : 'seeker';
            url.searchParams.set('type', roleType);
        }
        window.history.pushState({}, '', url);
    }

    // Update review step with current form data
    function updateReviewStep() {
        console.log('Updating review step with data:', formData);
        console.log('Selected role:', selectedRole);
        // Update account information
        $('#review-email').text(formData.email || '');
        $('#review-role').text(selectedRole === 'car_seller' ? 'Car Seller' : 'Car Seeker');

        // Update personal information
        if (selectedRole === 'car_seller') {
            $('#review-name').text(formData.username || '');
            $('#review-address').text(formData.address || '');
            $('#review-phone-seller').text(formData.phone || '');

            // Show seller section, hide seeker section
            $('#review-seller-details').show();
            $('#review-seeker-details').hide();
            $('#review-seller-address').show();
            $('#review-seller-phone').show();
            $('#review-seeker-phone').hide();
        } else {
            $('#review-name').text(formData.full_name || '');
            $('#review-phone-seeker').text(formData.phone || 'Not provided');

            // Show seeker section, hide seller section
            $('#review-seller-details').hide();
            $('#review-seeker-details').show();
            $('#review-seller-address').hide();
            $('#review-seeker-phone').show();
            $('#review-seller-phone').hide();
        }

        // Update profile image preview
        const $imageContainer = $('#review-profile-image');
        $imageContainer.empty();

        if (formData.profile_image) {
            $imageContainer.html('<em>Profile image will be uploaded</em>');
        }
    }

    // Form submission
    function submitRegistration() {
        console.log('Submit registration called');
        // Capture form data before submission
        captureFormData();

        // Create FormData object
        const submitData = new FormData();

        // Add all form data to FormData object
        $.each(formData, function (key, value) {
            if (value !== undefined && value !== null) {
                // Handle file inputs specially
                if (key === 'profile_image' && value instanceof File) {
                    submitData.append(key, value);
                } else if (key !== 'profile_image') {
                    submitData.append(key, value);
                }
            }
        });

        // Ensure role is always included
        if (selectedRole) {
            submitData.append('role', selectedRole);
        }

        // Debug: Log form data
        console.log('Form data to be submitted:');
        for (let pair of submitData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Disable submit button and show spinner
        $submitBtn.prop('disabled', true);
        const originalText = $submitBtn.html();
        $submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...');

        // Clear previous errors
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');

        // Submit via AJAX
        $.ajax({
            url: $('#registration-form').attr('action'),
            method: 'POST',
            data: submitData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Registration response:', response);
                if (response.success) {
                    // Redirect to the home page
                    window.location.href = response.redirect || '/';
                } else {
                    showError(response.message || 'Registration failed');
                    // Re-enable submit button
                    $submitBtn.prop('disabled', false);
                    $submitBtn.html(originalText);
                }
            },
            error: function (xhr) {
                console.log('Registration error:', xhr);
                // Re-enable submit button
                $submitBtn.prop('disabled', false);
                $submitBtn.html(originalText);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    displayValidationErrors(errors);
                } else {
                    showError('An error occurred during registration. Please try again.');
                }
            }
        });
    }

    // Display validation errors
    function displayValidationErrors(errors) {
        console.log('Displaying validation errors:', errors);
        console.log('Selected role for error mapping:', selectedRole);
        // Map field names to their corresponding IDs
        const fieldIdMap = {
            'username': 'seller-username',
            'email': selectedRole === 'car_seller' ? 'seller-email' : 'seeker-email',
            'password': selectedRole === 'car_seller' ? 'seller-password' : 'seeker-password',
            'password_confirmation': selectedRole === 'car_seller' ? 'seller-password-confirmation' : 'seeker-password-confirmation',
            'address': 'seller-address',
            'full_name': 'seeker-full-name',
            'phone': 'seller-phone' // Only for seller
        };

        $.each(errors, function (field, messages) {
            const fieldId = fieldIdMap[field] || field;
            console.log('Setting error for field:', field, 'with ID:', fieldId);
            const $field = $(`#${fieldId}`);
            $field.addClass('is-invalid');

            const $errorContainer = $field.closest('.form-group');
            $errorContainer.find('.error-message').remove();

            $.each(messages, function (index, message) {
                $errorContainer.append(`<div class="error-message">${message}</div>`);
            });
        });

        // Scroll to first error
        const $firstError = $('.is-invalid').first();
        if ($firstError.length) {
            $('html, body').animate({
                scrollTop: $firstError.offset().top - 100
            }, 500);
        }
    }

    // Show error message
    function showError(message) {
        console.log('Showing error message:', message);
        const $alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`);

        $('#wizard-alerts').append($alert);

        // Auto-dismiss after 5 seconds
        setTimeout(function () {
            $alert.fadeOut(function () {
                $alert.remove();
            });
        }, 5000);

        // Scroll to alert
        $('html, body').animate({
            scrollTop: $('#wizard-alerts').offset().top - 100
        }, 500);
    }

    // Initialize the wizard
    initWizard();
});