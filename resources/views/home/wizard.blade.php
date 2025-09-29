<!-- Bootstrap 5.3.3 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Page Background - transparent */
    .body-div {
        background: transparent;
        /* No background */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
        /* Reduced padding */
    }

    /* Wizard container - white background with border radius */
    .containerw {
        max-width: 700px;
        background: white;
        /* White background only */
        border-radius: 20px;
        /* Increased border radius */
        box-shadow: none;
        /* Remove box shadow */
        padding: 25px 20px;
        /* Reduced padding */
    }

    /* Selectable cards */
    .card-selectable {
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
        min-height: 120px;
        /* Ensure consistent height */
    }

    .card-selectable.selected {
        border-color: #3a9ecb;
        background-color: rgba(58, 158, 203, 0.1);
        box-shadow: 0 0 0 2px #3a9ecb;
    }

    .card-selectable.selected i {
        color: #3a9ecb !important;
    }

    .card-selectable.selected span {
        color: #3a9ecb;
        font-weight: 600;
    }

    /* Center icons and text */
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .form-check-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .card:hover {
        border-color: #5bc0de;
        box-shadow: 0 8px 16px rgba(91, 192, 222, 0.3);
        transform: translateY(-5px);
    }

    .form-check-input:checked+.form-check-label .card {
        border-color: #3a9ecb;
        box-shadow: 0 8px 16px rgba(58, 158, 203, 0.4);
    }

    .form-check-input:checked+.form-check-label i {
        color: #3a9ecb !important;
    }

    .form-check-input:checked+.form-check-label span {
        color: #3a9ecb;
        font-weight: 600 !important;
    }

    /* Larger checkboxes for better visibility */
    .form-check-input.position-static {
        transform: scale(1.5);
        margin: 10px auto !important;
    }

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
<div class="body-div">
    <div class="containerw">
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
                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                        href="#step2" id="step2-tab" data-bs-toggle="tab" role="tab" aria-controls="step2"
                        aria-selected="false" title="Step 2">
                        <i class="fas fa-briefcase"></i>
                    </a>
                </li>
                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Step 3">
                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                        href="#step3" id="step3-tab" data-bs-toggle="tab" role="tab" aria-controls="step3"
                        aria-selected="false" title="Step 3">
                        <i class="fas fa-star"></i>
                    </a>
                </li>
                <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Step 4">
                    <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                        href="#step4" id="step4-tab" data-bs-toggle="tab" role="tab" aria-controls="step4"
                        aria-selected="false" title="Step 4">
                        <i class="fas fa-flag-checkered"></i>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Step 1 -->
                <div class="tab-pane fade show active mt-2" role="tabpanel" id="step1" aria-labelledby="step1-tab">
                    <h3 class="mb-3">What's your dream car model?</h3>

                    <div class="row">
                        @php
                            $models =
                                $carModels ??
                                collect([
                                    'Audi',
                                    'BMW',
                                    'Ford',
                                    'Honda',
                                    'Mercedes-Benz',
                                    'Nissan',
                                    'Toyota',
                                    'Volkswagen',
                                    'Hyundai',
                                    'Kia',
                                ]);
                            $columns = $models->split(3); // Split into 3 columns max
                        @endphp

                        @foreach ($columns as $column)
                            <div class="col-md-4">
                                @foreach ($column as $model)
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="model[]"
                                            value="{{ $model->make ?? $model }}"
                                            id="car{{ $loop->parent->iteration * 100 + $loop->iteration }}" />
                                        <label class="form-check-label"
                                            for="car{{ $loop->parent->iteration * 100 + $loop->iteration }}">{{ $model->make ?? $model }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <span></span>
                        <a class="btn btn-info next btn-sm">Next <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="tab-pane fade mt-2" role="tabpanel" id="step2" aria-labelledby="step2-tab">
                    <h3 class="mb-3">You looking for which car conditions?</h3>

                    <div class="row">
                        @php
                            $conditions = $carConditions ?? collect(['New', 'Used']);
                            $conditionColumns = $conditions->split(ceil($conditions->count() / 5));
                        @endphp

                        @foreach ($conditionColumns as $column)
                            <div class="col-md-6">
                                @foreach ($column as $condition)
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="car_condition[]"
                                            value="{{ $condition->car_condition ?? $condition }}"
                                            id="condition{{ $loop->parent->iteration * 100 + $loop->iteration }}" />
                                        <label class="form-check-label"
                                            for="condition{{ $loop->parent->iteration * 100 + $loop->iteration }}">{{ $condition->car_condition ?? $condition }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a class="btn btn-secondary previous btn-sm"><i class="fas fa-angle-left"></i> Back</a>
                        <a class="btn btn-info next btn-sm">Next <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="tab-pane fade mt-2" role="tabpanel" id="step3" aria-labelledby="step3-tab">
                    <h3 class="mb-3">Which car color do you prefer?</h3>

                    <div class="row">
                        @php
                            $colors = $carColors ?? collect(['White', 'Black', 'Silver', 'Other']);
                            $colorColumns = $colors->split(ceil($colors->count() / 5));
                        @endphp

                        @foreach ($colorColumns as $column)
                            <div class="col-md-6">
                                @foreach ($column as $color)
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="colors[]"
                                            value="{{ $color->car_color ?? $color }}"
                                            id="color{{ $loop->parent->iteration * 100 + $loop->iteration }}" />
                                        <label class="form-check-label"
                                            for="color{{ $loop->parent->iteration * 100 + $loop->iteration }}">{{ $color->car_color ?? $color }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a class="btn btn-secondary previous"><i class="fas fa-angle-left"></i> Back</a>
                        <a class="btn btn-info next">Next <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="tab-pane fade mt-2" role="tabpanel" id="step4" aria-labelledby="step4-tab">
                    <h3 class="mb-3 text-center">Which car body style do you like most?</h3>

                    <div class="row justify-content-center">
                        @php
                            $types = $bodyTypes ?? collect(['Sedan', 'SUV', 'Coupe', 'Convertible', 'Hatchback']);

                            // Map body types to appropriate icons
                            $iconMap = [
                                'Sedan' => 'fas fa-car-side',
                                'SUV' => 'fas fa-truck-monster',
                                'Coupe' => 'fas fa-car',
                                'Convertible' => 'fas fa-car-crash',
                                'Hatchback' => 'fas fa-shuttle-van',
                                'Truck' => 'fas fa-truck-pickup',
                                'Van' => 'fas fa-shuttle-van',
                                'Wagon' => 'fas fa-caravan',
                            ];
                        @endphp

                        @foreach ($types as $type)
                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="card h-100 text-center card-selectable"
                                    style="cursor: pointer; border-radius: 15px;"
                                    data-value="{{ $type->body_type ?? $type }}">
                                    <div class="card-body p-2">
                                        <div class="form-check" style="display: block;">
                                            <input type="hidden" name="body_type[]"
                                                value="{{ $type->body_type ?? $type }}"
                                                id="type{{ $loop->index + 1 }}" />
                                            <label class="form-check-label" for="type{{ $loop->index + 1 }}"
                                                style="display: block; cursor: pointer; text-align: center;">
                                                <i class="{{ $iconMap[$type->body_type ?? $type] ?? 'fas fa-car' }}"
                                                    style="font-size: 2rem; margin: 5px auto; display: block; color: #5bc0de; text-align: center;"></i>
                                                <span
                                                    style="display: block; margin-top: 5px; font-weight: 500; font-size: 0.9rem; text-align: center;">
                                                    {{ $type->body_type ?? $type }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a class="btn btn-secondary previous btn-sm"><i class="fas fa-angle-left"></i> Back</a>
                        <a class="btn btn-info next btn-sm">Submit <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
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

        // Handle card selection for Step 4 (without checkboxes)
        $('.card-selectable').on('click', function(e) {
            var card = $(this);
            var hiddenInput = card.find('input[type="hidden"]');
            var isSelected = card.hasClass('selected');

            // Toggle selection state
            if (isSelected) {
                card.removeClass('selected');
                // Remove the value from the hidden input
                hiddenInput.remove();
            } else {
                card.addClass('selected');
                // Add hidden input if not already present
                if (hiddenInput.length === 0) {
                    var value = card.data('value');
                    var name = 'body_type[]';
                    card.append('<input type="hidden" name="' + name + '" value="' + value + '">');
                }
            }
        });

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
                    // Handle form submission here if needed
                    console.log('Wizard completed'); // For debugging only
                    return;
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
