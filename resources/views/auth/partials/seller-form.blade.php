<div class="wizard-step" id="step-2">
    <h2 class="fw-bold mb-4 text-center">Seller Information</h2>
    
    <div class="row">
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-user input-icon"></i>
                <input id="seller-username" class="form-control" type="text" name="username" value="{{ old('username') }}" required placeholder=" " />
                <label for="seller-username">Username</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-envelope input-icon"></i>
                <input id="seller-email" class="form-control" type="email" name="email" value="{{ old('email') }}" required placeholder=" " />
                <label for="seller-email">Email Address</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-lock input-icon"></i>
                <input id="seller-password" class="form-control" type="password" name="password" required placeholder=" " />
                <label for="seller-password">Password</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-lock input-icon"></i>
                <input id="seller-password-confirmation" class="form-control" type="password" name="password_confirmation" required placeholder=" " />
                <label for="seller-password-confirmation">Confirm Password</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-12 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-map-marker-alt input-icon"></i>
                <input id="seller-address" class="form-control" type="text" name="address" value="{{ old('address') }}" required placeholder=" " />
                <label for="seller-address">Address</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <label class="form-label">Profile Image (Optional)</label>
            <input type="file" class="form-control file-input" name="profile_image" accept="image/*" />
            <div class="form-text">Upload your profile image (max 5MB)</div>
            <div class="invalid-feedback"></div>
            <div id="profile-image-preview" class="mt-3"></div>
        </div>
    </div>
</div>