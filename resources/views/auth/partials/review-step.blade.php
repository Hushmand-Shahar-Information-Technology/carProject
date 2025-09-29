<div class="wizard-step" id="step-3">
    <h2 class="fw-bold mb-4 text-center">Review & Confirm</h2>
    
    <div class="review-section mb-4">
        <h4 class="mb-3">Account Information</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="review-item">
                    <strong>Email:</strong> <span id="review-email"></span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="review-item">
                    <strong>Role:</strong> <span id="review-role"></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Personal Information - Common for both roles -->
    <div class="review-section mb-4">
        <h4 class="mb-3">Personal Information</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="review-item">
                    <strong>Name:</strong> <span id="review-name"></span>
                </div>
            </div>
            <!-- Seller-specific fields -->
            <div class="col-md-6 mb-3" id="review-seller-phone" style="display: none;">
                <div class="review-item">
                    <strong>Phone:</strong> <span id="review-phone-seller"></span>
                </div>
            </div>
            <div class="col-md-6 mb-3" id="review-seller-address" style="display: none;">
                <div class="review-item">
                    <strong>Address:</strong> <span id="review-address"></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Seller details section -->
    <div class="review-section mb-4" id="review-seller-details" style="display: none;">
        <h4 class="mb-3">Additional Seller Information</h4>
        <div class="row">
            <div class="col-12">
                <div class="review-item">
                    <strong>Profile Image:</strong>
                    <div id="review-profile-image" class="mt-2"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Seeker details section - REMOVED since email is already shown above -->
</div>