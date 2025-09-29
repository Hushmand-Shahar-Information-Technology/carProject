<div class="wizard-step" id="step-2-seeker">
    <h2 class="fw-bold mb-4 text-center">Seeker Information</h2>
    
    <div class="row">
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-user input-icon"></i>
                <input id="seeker-full-name" class="form-control" type="text" name="full_name" value="{{ old('full_name') }}" required placeholder=" " />
                <label for="seeker-full-name">Full Name</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-envelope input-icon"></i>
                <input id="seeker-email" class="form-control" type="email" name="email" value="{{ old('email') }}" required placeholder=" " />
                <label for="seeker-email">Email Address</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-lock input-icon"></i>
                <input id="seeker-password" class="form-control" type="password" name="password" required placeholder=" " />
                <label for="seeker-password">Password</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4 form-group">
            <div class="form-floating">
                <i class="fas fa-lock input-icon"></i>
                <input id="seeker-password-confirmation" class="form-control" type="password" name="password_confirmation" required placeholder=" " />
                <label for="seeker-password-confirmation">Confirm Password</label>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
</div>