<!-- Bootstrap 5.3.3 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Page Background */
    .body-div {
        /* background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%); */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    /*
  .containerw {
    max-width: 700px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    padding: 40px 35px;
  } */

    /* Wizard Tabs Container */
    .wizard {
        width: 100%;
    }

    /* Tab Line */
    .wizard .nav-tabs:after {
        width: 80%;
        border-bottom: 3px solid #5bc0de;
        top: 45%;
    }

    /* Tab Buttons */
    .wizard .nav-tabs .nav-link {
        width: 70px;
        height: 70px;
        margin-bottom: 10%;
        background: #e9f7fa;
        border: 2px solid #5bc0de;
        color: #5bc0de;
        font-weight: 600;
        font-size: 1.5rem;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(91, 192, 222, 0.2);
    }

    /* Circle shape & center icon */
    .wizard .nav-tabs .nav-link svg,
    .wizard .nav-tabs .nav-link i {
        font-size: 30px;
        line-height: 70px;
    }

    /* Hover and Active */
    .wizard .nav-tabs .nav-link:hover {
        background: #5bc0de;
        color: white;
        border-color: #3a9ecb;
        box-shadow: 0 6px 15px rgba(58, 158, 203, 0.4);
    }

    .wizard .nav-tabs .nav-link.active {
        background: #3a9ecb;
        border-color: #2a75a8;
        color: white;
        box-shadow: 0 8px 20px rgba(42, 117, 168, 0.6);
    }

    /* Active tab arrow */
    .wizard .nav-tabs .nav-link:after {
        border-bottom-color: #3a9ecb;
        bottom: -12px;
        opacity: 0;
        transition: opacity 0.15s ease-in-out;
    }

    .wizard .nav-tabs .nav-link.active:after {
        border-bottom-color: #3a9ecb;
        bottom: -12px;
        opacity: 1;
        border-width: 10px;
    }

    /* Tab Content */
    .tab-content {
        padding-top: 30px;
    }

    /* Headers */
    h3 {
        color: #2a75a8;
        font-weight: 700;
        margin-bottom: 25px;
    }

    /* Buttons */
    .btn-info {
        background-color: #5bc0de;
        border-color: #4bb8d8;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(91, 192, 222, 0.4);
        transition: background-color 0.3s ease;
    }

    .btn-info:hover {
        background-color: #3a9ecb;
        border-color: #2a75a8;
    }

    .btn-secondary {
        background-color: #a8b9cc;
        border-color: #8c9fbf;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 30px;
        box-shadow: none;
    }

    .btn-secondary:hover {
        background-color: #889bb8;
        border-color: #677a9a;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #218838;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
    }

    .btn-success:hover {
        background-color: #1e7e34;
        border-color: #155d27;
    }

    /* Inputs & Selects */
    .form-check-label {
        font-weight: 500;
        color: #444;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 10px 15px;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #5bc0de;
        box-shadow: 0 0 8px rgba(91, 192, 222, 0.5);
    }

    /* Responsive tweaks */
    @media (max-width: 576px) {
        .wizard .nav-tabs .nav-link {
            width: 60px;
            height: 60px;
            font-size: 1.25rem;
        }

        .wizard .nav-tabs:after {
            width: 90%;
        }
    }
</style>
<div class="wizard">
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Step 1">
            <a class="nav-link active rounded-circle mx-auto d-flex align-items-center justify-content-center"
                href="#step1" id="step1-tab" data-bs-toggle="tab" role="tab" aria-controls="step1"
                aria-selected="true">
                <i class="fas fa-folder-open"></i>
            </a>
        </li>
        <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Step 2">
            <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step2"
                id="step2-tab" data-bs-toggle="tab" role="tab" aria-controls="step2" aria-selected="false"
                title="Step 2">
                <i class="fas fa-briefcase"></i>
            </a>
        </li>
        <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Step 3">
            <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step3"
                id="step3-tab" data-bs-toggle="tab" role="tab" aria-controls="step3" aria-selected="false"
                title="Step 3">
                <i class="fas fa-star"></i>
            </a>
        </li>
        <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Step 4">
            <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step4"
                id="step4-tab" data-bs-toggle="tab" role="tab" aria-controls="step4" aria-selected="false"
                title="Step 4">
                <i class="fas fa-flag-checkered"></i>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Step 1 -->
        <div class="tab-pane fade show active mt-3" role="tabpanel" id="step1" aria-labelledby="step1-tab">
            <h3>What's your dream car model?</h3>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="model" value="Audi" id="car1" />
                <label class="form-check-label" for="car1">Audi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="model" value="BMW" id="car2" />
                <label class="form-check-label" for="car2">BMW M3</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="model" value="Ford" id="car3" />
                <label class="form-check-label" for="car3">Ford Mustang</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="model" value="Hunda" id="car4" />
                <label class="form-check-label" for="car4">Hunda</label>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <span></span>
                <a class="btn btn-info next">Next <i class="fas fa-angle-right"></i></a>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="tab-pane fade" role="tabpanel" id="step2" aria-labelledby="step2-tab">
            <h3>You looking for which car conditions?</h3>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="car_condition" value="new" id="classic">
                <label class="form-check-label" for="classic">New</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="car_condition" value="used" id="modern">
                <label class="form-check-label" for="modern">Used</label>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                <a class="btn btn-info next">Next <i class="fas fa-angle-right"></i></a>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="tab-pane fade" role="tabpanel" id="step3" aria-labelledby="step3-tab">
            <h3>Which car color do you prefer?</h3>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="colors" value="white" id="daily1">
                <label class="form-check-label" for="daily1">White</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="colors" value="black" id="daily2">
                <label class="form-check-label" for="daily2">Black</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="colors" value="silver" id="daily3">
                <label class="form-check-label" for="daily3">Silver</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="colors" value="Other" id="daily4">
                <label class="form-check-label" for="daily4">Other</label>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                <a class="btn btn-info next">Next <i class="fas fa-angle-right"></i></a>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
            <h3>Which car body style do you like most?</h3>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="body_type" value="SUV" id="style1" />
                <label class="form-check-label" for="style1">SUV</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="body_type" value="Sedan" id="style2" />
                <label class="form-check-label" for="style2">Sedan</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="body_type" value="Coupe" id="style3" />
                <label class="form-check-label" for="style3">Coupe</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="body_type" value="Convertible"
                    id="style4" />
                <label class="form-check-label" for="style4">Convertible</label>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                <a class="btn btn-info next">Submit <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to update active icon indicator
    function updateIconIndicator() {
        // Remove active class from all icons
        $('.nav-link').removeClass('active');

        // Get the currently active tab pane
        var activePane = $('.tab-pane.fade.show.active').attr('id');

        // Map tab pane IDs to their corresponding nav links
        var tabMap = {
            'step1': '#step1-tab',
            'step2': '#step2-tab',
            'step3': '#step3-tab',
            'step4': '#step4-tab'
        };

        // Add active class to the corresponding nav link
        if (tabMap[activePane]) {
            $(tabMap[activePane]).addClass('active');
        }
    }

    // Initialize icon indicator on page load
    $(document).ready(function() {
        updateIconIndicator();

        // Handle next button clicks
        $('.next').on('click', function(e) {
            e.preventDefault();

            // Get the currently active tab
            var currentTab = $('.tab-pane.fade.show.active');
            var currentId = currentTab.attr('id');

            // Determine the next tab
            var nextTabId = '';
            switch (currentId) {
                case 'step1':
                    nextTabId = 'step2';
                    break;
                case 'step2':
                    nextTabId = 'step3';
                    break;
                case 'step3':
                    nextTabId = 'step4';
                    break;
                case 'step4':
                    return; // Already at the last step
            }

            // Hide current tab and show next tab
            currentTab.removeClass('show active');
            $('#' + nextTabId).addClass('show active');

            // Update the active icon indicator
            updateIconIndicator();

            // Activate the corresponding tab link
            $('.nav-link').removeClass('active');
            $('#step' + nextTabId.charAt(nextTabId.length - 1) + '-tab').addClass('active');
        });

        // Handle previous button clicks
        $('.previous').on('click', function(e) {
            e.preventDefault();

            // Get the currently active tab
            var currentTab = $('.tab-pane.fade.show.active');
            var currentId = currentTab.attr('id');

            // Determine the previous tab
            var prevTabId = '';
            switch (currentId) {
                case 'step1':
                    return; // Already at the first step
                case 'step2':
                    prevTabId = 'step1';
                    break;
                case 'step3':
                    prevTabId = 'step2';
                    break;
                case 'step4':
                    prevTabId = 'step3';
                    break;
            }

            // Hide current tab and show previous tab
            currentTab.removeClass('show active');
            $('#' + prevTabId).addClass('show active');

            // Update the active icon indicator
            updateIconIndicator();

            // Activate the corresponding tab link
            $('.nav-link').removeClass('active');
            $('#step' + prevTabId.charAt(prevTabId.length - 1) + '-tab').addClass('active');
        });

        // Handle direct icon clicks (these already work with Bootstrap)
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            updateIconIndicator();
        });
    });
</script>
