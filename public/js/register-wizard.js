$(document).ready(function() {
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
        // Auto-select role if provided in URL
        if (urlType === 'seller' || urlType === 'seeker') {
            selectedRole = urlType === 'seller' ? 'car_seller' : 'car_seeker';
            $(`[data-role="${selectedRole}"]`).addClass('selected');
            $roleAutoSelected.show().find('.role-name').text(urlType === 'seller' ? 'Car Seller' : 'Car Seeker');
            formData.role = selectedRole; // Also store in formData
            setTimeout(() => goToStep(2), 100); // Small delay to ensure DOM is ready
        }
        
        // Role selection
        $roleCards.on('click', function() {
            $roleCards.removeClass('selected');
            $(this).addClass('selected');
            selectedRole = $(this).data('role');
            formData.role = selectedRole; // Store role in formData immediately
            
            // Update URL immediately when role is selected
            const url = new URL(window.location);
            const roleType = selectedRole === 'car_seller' ? 'seller' : 'seeker';
            url.searchParams.set('type', roleType);
            window.history.pushState({}, '', url);
        });
        
        // Navigation - using event delegation
        $(document).on('click', '#next-step', function(e) {
            e.preventDefault();
            nextStep();
        });
        $(document).on('click', '#prev-step', function(e) {
            e.preventDefault();
            prevStep();
        });
        $(document).on('click', '#submit-registration', function(e) {
            e.preventDefault();
            submitRegistration();
        });
        
        // Form input handling - capture data properly
        $(document).on('input change', 'input, select, textarea', function() {
            captureFormData();
        });
        
        // File input previews
        $(document).on('change', '.file-input', function() {
            const fileName = $(this).attr('name');
            const files = this.files;
            
            if (fileName === 'profile_image') {
                handleProfileImagePreview(files[0]);
                // Store the file in formData
                formData.profile_image = files[0];
            }
            captureFormData();
        });
        
        updateProgress();
    }
    
    // Handle profile image preview
    function handleProfileImagePreview(file) {
        const $previewContainer = $('#profile-image-preview');
        $previewContainer.empty();
        
        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(e) {
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
        if (currentStep === 1) {
            if (!selectedRole) {
                showError('Please select a role');
                return;
            }
            formData.role = selectedRole;
        }
        
        // Validate current step before proceeding
        if (!validateStep(currentStep)) {
            return;
        }
        
        if (currentStep < 3) {
            goToStep(currentStep + 1);
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    }
    
    // Validate current step
    function validateStep(step) {
        let isValid = true;
        
        if (step === 2) {
            // Validate step 2 (role-specific form)
            if (selectedRole === 'car_seller') {
                // Validate seller form
                if (!$('#seller-username').val()) {
                    isValid = false;
                    $('#seller-username').addClass('is-invalid');
                    $('#seller-username').closest('.form-group').find('.error-message').remove();
                    $('#seller-username').closest('.form-group').append('<div class="error-message">Username is required</div>');
                } else {
                    $('#seller-username').removeClass('is-invalid');
                    $('#seller-username').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seller-email').val()) {
                    isValid = false;
                    $('#seller-email').addClass('is-invalid');
                    $('#seller-email').closest('.form-group').find('.error-message').remove();
                    $('#seller-email').closest('.form-group').append('<div class="error-message">Email is required</div>');
                } else {
                    $('#seller-email').removeClass('is-invalid');
                    $('#seller-email').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seller-password').val()) {
                    isValid = false;
                    $('#seller-password').addClass('is-invalid');
                    $('#seller-password').closest('.form-group').find('.error-message').remove();
                    $('#seller-password').closest('.form-group').append('<div class="error-message">Password is required</div>');
                } else {
                    $('#seller-password').removeClass('is-invalid');
                    $('#seller-password').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seller-address').val()) {
                    isValid = false;
                    $('#seller-address').addClass('is-invalid');
                    $('#seller-address').closest('.form-group').find('.error-message').remove();
                    $('#seller-address').closest('.form-group').append('<div class="error-message">Address is required</div>');
                } else {
                    $('#seller-address').removeClass('is-invalid');
                    $('#seller-address').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seller-phone').val()) {
                    isValid = false;
                    $('#seller-phone').addClass('is-invalid');
                    $('#seller-phone').closest('.form-group').find('.error-message').remove();
                    $('#seller-phone').closest('.form-group').append('<div class="error-message">Phone is required</div>');
                } else {
                    $('#seller-phone').removeClass('is-invalid');
                    $('#seller-phone').closest('.form-group').find('.error-message').remove();
                }
                
                // Validate password confirmation
                const password = $('#seller-password').val();
                const passwordConfirmation = $('#seller-password-confirmation').val();
                
                if (password && !passwordConfirmation) {
                    isValid = false;
                    $('#seller-password-confirmation').addClass('is-invalid');
                    $('#seller-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#seller-password-confirmation').closest('.form-group').append('<div class="error-message">Please confirm your password</div>');
                } else if (password && passwordConfirmation && password !== passwordConfirmation) {
                    isValid = false;
                    $('#seller-password-confirmation').addClass('is-invalid');
                    $('#seller-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#seller-password-confirmation').closest('.form-group').append('<div class="error-message">Passwords do not match</div>');
                } else if (passwordConfirmation) {
                    $('#seller-password-confirmation').removeClass('is-invalid');
                    $('#seller-password-confirmation').closest('.form-group').find('.error-message').remove();
                }
            } else if (selectedRole === 'car_seeker') {
                // Validate seeker form
                if (!$('#seeker-full-name').val()) {
                    isValid = false;
                    $('#seeker-full-name').addClass('is-invalid');
                    $('#seeker-full-name').closest('.form-group').find('.error-message').remove();
                    $('#seeker-full-name').closest('.form-group').append('<div class="error-message">Full name is required</div>');
                } else {
                    $('#seeker-full-name').removeClass('is-invalid');
                    $('#seeker-full-name').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seeker-phone').val()) {
                    isValid = false;
                    $('#seeker-phone').addClass('is-invalid');
                    $('#seeker-phone').closest('.form-group').find('.error-message').remove();
                    $('#seeker-phone').closest('.form-group').append('<div class="error-message">Phone is required</div>');
                } else {
                    $('#seeker-phone').removeClass('is-invalid');
                    $('#seeker-phone').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seeker-email').val()) {
                    isValid = false;
                    $('#seeker-email').addClass('is-invalid');
                    $('#seeker-email').closest('.form-group').find('.error-message').remove();
                    $('#seeker-email').closest('.form-group').append('<div class="error-message">Email is required</div>');
                } else {
                    $('#seeker-email').removeClass('is-invalid');
                    $('#seeker-email').closest('.form-group').find('.error-message').remove();
                }
                
                if (!$('#seeker-password').val()) {
                    isValid = false;
                    $('#seeker-password').addClass('is-invalid');
                    $('#seeker-password').closest('.form-group').find('.error-message').remove();
                    $('#seeker-password').closest('.form-group').append('<div class="error-message">Password is required</div>');
                } else {
                    $('#seeker-password').removeClass('is-invalid');
                    $('#seeker-password').closest('.form-group').find('.error-message').remove();
                }
                
                // Validate password confirmation
                const password = $('#seeker-password').val();
                const passwordConfirmation = $('#seeker-password-confirmation').val();
                
                if (password && !passwordConfirmation) {
                    isValid = false;
                    $('#seeker-password-confirmation').addClass('is-invalid');
                    $('#seeker-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#seeker-password-confirmation').closest('.form-group').append('<div class="error-message">Please confirm your password</div>');
                } else if (password && passwordConfirmation && password !== passwordConfirmation) {
                    isValid = false;
                    $('#seeker-password-confirmation').addClass('is-invalid');
                    $('#seeker-password-confirmation').closest('.form-group').find('.error-message').remove();
                    $('#seeker-password-confirmation').closest('.form-group').append('<div class="error-message">Passwords do not match</div>');
                } else if (passwordConfirmation) {
                    $('#seeker-password-confirmation').removeClass('is-invalid');
                    $('#seeker-password-confirmation').closest('.form-group').find('.error-message').remove();
                }
            } else {
                // If no role is selected, show error
                isValid = false;
                showError('Please select a role first');
            }
        }
        
        return isValid;
    }
    
    // Capture all form data
    function captureFormData() {
        // Capture data based on selected role
        if (selectedRole === 'car_seller') {
            formData.username = $('#seller-username').val();
            formData.phone = $('#seller-phone').val();
            formData.email = $('#seller-email').val();
            formData.password = $('#seller-password').val();
            formData.password_confirmation = $('#seller-password-confirmation').val();
            formData.address = $('#seller-address').val();
            // profile_image is handled separately in file input change event
        } else if (selectedRole === 'car_seeker') {
            formData.full_name = $('#seeker-full-name').val();
            formData.phone = $('#seeker-phone').val();
            formData.email = $('#seeker-email').val();
            formData.password = $('#seeker-password').val();
            formData.password_confirmation = $('#seeker-password-confirmation').val();
        }
        
        // Update review step if we're on step 3
        if (currentStep === 3) {
            updateReviewStep();
        }
    }
    
    function goToStep(step) {
        currentStep = step;
        
        // Hide all steps
        $('.wizard-step').removeClass('active');
        
        // Show current step
        $(`#step-${step}`).addClass('active');
        
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
            captureFormData();
            updateReviewStep();
        }
    }
    
    function updateProgress() {
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
            $('#review-phone').text(formData.phone || '');
            $('#review-phone-seeker').text(formData.phone || '');
            
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
        // Capture form data before submission
        captureFormData();
        
        // Create FormData object
        const submitData = new FormData();
        
        // Add all form data to FormData object
        $.each(formData, function(key, value) {
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
            success: function(response) {
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
            error: function(xhr) {
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
        // Map field names to their corresponding IDs
        const fieldIdMap = {
            'username': 'seller-username',
            'email': selectedRole === 'car_seller' ? 'seller-email' : 'seeker-email',
            'password': selectedRole === 'car_seller' ? 'seller-password' : 'seeker-password',
            'password_confirmation': selectedRole === 'car_seller' ? 'seller-password-confirmation' : 'seeker-password-confirmation',
            'address': 'seller-address',
            'full_name': 'seeker-full-name',
            'phone': selectedRole === 'car_seller' ? 'seller-phone' : 'seeker-phone'
        };
        
        $.each(errors, function(field, messages) {
            const fieldId = fieldIdMap[field] || field;
            const $field = $(`#${fieldId}`);
            $field.addClass('is-invalid');
            
            const $errorContainer = $field.closest('.form-group');
            $errorContainer.find('.error-message').remove();
            
            $.each(messages, function(index, message) {
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
        const $alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`);
        
        $('#wizard-alerts').append($alert);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $alert.fadeOut(function() {
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