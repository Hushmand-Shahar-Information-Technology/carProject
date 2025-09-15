@extends('layouts.layout')

@section('title', 'Car Registration')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .preview-controls {
            position: absolute;
            top: 4px;
            right: 4px;
            display: flex;
            gap: 4px;
        }

        .highlight {
            background-color: #d1fae5;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Axios (used by optional submitForm) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
    <div class="r p-auto m-auto"
        style="height: 400px; width: 100%; background-image: url('{{ asset('images/bg/01.jpg') }}'); background-size: cover; background-position:center; background-blend-mode: darken; background-color: rgba(0, 0, 0, 0.5);">
    </div>


    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 12000)" x-show="show" class="max-w-6xl mx-auto mb-4">
            <div class="flex items-start justify-between bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                <div class="pr-4">{{ session('error') }}</div>
                <button type="button" @click="show = false" class="ml-4 text-red-700 font-bold">✖</button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" class="max-w-6xl mx-auto mb-4">
            <div class="flex items-start justify-between bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                <div class="pr-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" @click="show = false" class="ml-4 text-red-700 font-bold">✖</button>
            </div>
        </div>
    @endif

    <div class="container mx-auto py-10" x-data="carForm()" x-init="$nextTick(() => {
        initSelect2();
        // Check if we're registering as a bargain
        const urlParams = new URLSearchParams(window.location.search);
        const bargainId = urlParams.get('bargain_id');
        if (bargainId) {
            this.form.bargain_id = bargainId;
        }
        $nextTick(() => {
            // Sync Select2 values and calculate initial progress
            syncSelect2Values();
            watchProgress();
            // Watch for form changes with deep watching for live updates
            $watch('form', () => {
                watchProgress();
                // Trigger reactivity for review section
                $dispatch('form-changed');
            }, { deep: true });
            // Watch for step changes to trigger sync
            $watch('step', () => {
                $nextTick(() => {
                    syncSelect2Values();
                });
            });
            // Periodic sync to ensure live updates (every 500ms when form is active)
            setInterval(() => {
                if (document.hasFocus()) {
                    syncSelect2Values();
                }
            }, 500);
        });
    })" x-cloak>
        <div class="bg-white p-6 rounded shadow-md max-w-7xl mx-auto flex flex-row gap-6"
            style="box-shadow: 0 0 2px black; margin: 1rem 0;">
            <!-- Form Section -->
            <div class="w-1/2">
                <h1 class="text-2xl font-bold mb-6">🚗 Car Registration Form</h1>

                <!-- Purpose Selection - Always Visible -->
                <div class="border-2 border-blue-200 rounded-lg p-4 bg-blue-50 mb-6">
                    <h3 class="text-lg font-semibold mb-4 text-blue-800">Select Car Purpose</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_for_sale" x-model="form.is_for_sale" value="1"
                                class="h-4 w-4"
                                @change="form.is_for_sale = $event.target.checked; step = 1; watchProgress(); $nextTick(() => { $dispatch('form-changed'); })" />
                            <span class="font-medium">For Sale</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_for_rent" x-model="form.is_for_rent" value="1"
                                class="h-4 w-4"
                                @change="form.is_for_rent = $event.target.checked; step = 1; watchProgress(); $nextTick(() => { $dispatch('form-changed'); })" />
                            <span class="font-medium">For Rent</span>
                        </label>
                    </div>
                </div>

                <!-- Progress Bar (Only show when purpose is selected) -->
                <div x-show="form.is_for_sale || form.is_for_rent" class="w-full bg-gray-300 h-4 rounded mb-6 relative">
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-300"
                            :style="`width: ${progress}%`">
                        </div>
                    </div>
                    <p class="text-sm text-center text-gray-700" x-text="`${progress}% completed`"></p>
                </div>
                <form action="{{ route('car.store') }}" method="post" enctype="multipart/form-data"
                    @submit="syncSelect2Values()">
                    @csrf
                    <!-- Hidden inputs to ensure all values are submitted -->
                    <input type="hidden" name="is_for_sale" :value="form.is_for_sale ? '1' : '0'">
                    <input type="hidden" name="is_for_rent" :value="form.is_for_rent ? '1' : '0'">
                    <input type="hidden" name="year" :value="form.year">
                    <input type="hidden" name="make" :value="form.make">
                    <input type="hidden" name="body_type" :value="form.body_type">
                    <input type="hidden" name="car_condition" :value="form.car_condition">
                    <input type="hidden" name="model" :value="form.model">
                    <input type="hidden" name="car_color" :value="form.car_color">
                    <input type="hidden" name="car_inside_color" :value="form.car_inside_color">
                    <input type="hidden" name="car_documents" :value="form.car_documents">
                    <input type="hidden" name="transmission_type" :value="form.transmission_type">
                    <input type="hidden" name="currency_type" :value="form.currency_type">
                    <input type="hidden" name="regular_price" :value="form.regular_price">
                    <input type="hidden" name="rent_price_per_day" :value="form.rent_price_per_day">
                    <input type="hidden" name="rent_price_per_month" :value="form.rent_price_per_month">
                    <input type="hidden" name="description" :value="form.description">
                    <input type="hidden" name="VIN_number" :value="form.VIN_number">
                    <input type="hidden" name="location" :value="form.location">
                    <input type="hidden" name="title" :value="form.title">
                    <!-- Hidden input for bargain_id -->
                    <input type="hidden" name="bargain_id" :value="form.bargain_id">

                    <!-- Step 1: Basic Information -->
                    <div x-show="(form.is_for_sale || form.is_for_rent) && step === 1" class="space-y-4">
                        <h2 class="text-lg font-semibold mb-4 text-blue-800">Step 1: Basic Information</h2>

                        <div>
                            <label class="block font-medium">Title</label>
                            <input type="text" x-model="form.title"
                                class="w-full border rounded p-2 title-input @error('title') border-red-500 @enderror"
                                placeholder="Title of the car" name="title" value="{{ old('title') }}"
                                @input="watchProgress()" @keyup="watchProgress()" />
                            @error('title')
                                <p class="title-error text-red-500 text-sm mt-1">عنوان برای پوست تان انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Year</label>
                            <select x-model="form.year"
                                class="w-full border rounded p-2 select2 year-input @error('year') border-red-500 @enderror"
                                name="year">
                                <option value="">Select Year</option>
                                <template x-for="y in years" :key="y">
                                    <option :value="y" x-text="y" :selected="y == form.year"></option>
                                </template>
                            </select>
                            @error('year')
                                <p class="year-error text-red-500 text-sm mt-1">سال تولید موتر را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Make (Company)</label>
                            <select x-model="form.make"
                                class="w-full border rounded p-2 select2 make-select @error('make') border-red-500 @enderror"
                                name="make">
                                <option value="">Select Make</option>
                                <option value="toyota" {{ old('make') == 'toyota' ? 'selected' : '' }}>Toyota</option>
                                <option value="bmw" {{ old('make') == 'bmw' ? 'selected' : '' }}>BMW</option>
                                <option value="honda" {{ old('make') == 'honda' ? 'selected' : '' }}>Honda</option>
                                <option value="marcedes" {{ old('make') == 'marcedes' ? 'selected' : '' }}>Mercedes
                                </option>
                                <option value="Hyundai" {{ old('make') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                <option value="Nissan" {{ old('make') == 'Nissan' ? 'selected' : '' }}>Nissan</option>
                                <option value="Kia" {{ old('make') == 'Kia' ? 'selected' : '' }}>Kia</option>
                                <option value="ford" {{ old('make') == 'ford' ? 'selected' : '' }}>Ford</option>
                            </select>
                            @error('make')
                                <p class="make-error text-red-500 text-sm mt-1">کمپنی موتر را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Car Color</label>
                            <select x-model="form.car_color"
                                class="w-full border rounded p-2 select2 @error('car_color') border-red-500 @enderror"
                                name="car_color">
                                <option value="">Select Color</option>
                                <option value="white" {{ old('car_color') == 'white' ? 'selected' : '' }}>White</option>
                                <option value="black" {{ old('car_color') == 'black' ? 'selected' : '' }}>Black</option>
                                <option value="silver" {{ old('car_color') == 'silver' ? 'selected' : '' }}>Silver
                                </option>
                                <option value="red" {{ old('car_color') == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="blue" {{ old('car_color') == 'blue' ? 'selected' : '' }}>Blue</option>
                                <option value="green" {{ old('car_color') == 'green' ? 'selected' : '' }}>Green</option>
                                <option value="yellow" {{ old('car_color') == 'yellow' ? 'selected' : '' }}>Yellow
                                </option>
                            </select>
                            @error('car_color')
                                <p class="car_color-error text-red-500 text-sm mt-1">Car color is required</p>
                            @enderror
                        </div>

                        <!-- Rent Price Fields (Show for rent only or both) -->
                        <div x-show="form.is_for_rent">
                            <div class="mb-4">
                                <label class="block font-medium">Daily Rent Price</label>
                                <input type="number" x-model="form.rent_price_per_day"
                                    class="w-full border rounded p-2 @error('rent_price_per_day') border-red-500 @enderror"
                                    placeholder="Daily Rent Price" name="rent_price_per_day" @input="watchProgress()" />
                                @error('rent_price_per_day')
                                    <p class="text-red-500 text-sm mt-1">Daily rent price is required</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block font-medium">Monthly Rent Price</label>
                                <input type="number" x-model="form.rent_price_per_month"
                                    class="w-full border rounded p-2 @error('rent_price_per_month') border-red-500 @enderror"
                                    placeholder="Monthly Rent Price" name="rent_price_per_month"
                                    @input="watchProgress()" />
                                @error('rent_price_per_month')
                                    <p class="text-red-500 text-sm mt-1">Monthly rent price is required</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="nextStep"
                                class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Next →</button>
                        </div>
                    </div>

                    <!-- Step 2: Additional Details (Show for sale or both, hidden for rent-only) -->
                    <div x-show="form.is_for_sale && step === 2" class="space-y-4">
                        <h2 class="text-lg font-semibold mb-4 text-blue-800">Step 2: Additional Details</h2>

                        {{-- نوع بادی --}}
                        <div>
                            <label class="block font-medium">نوع یادی</label>
                            <select x-model="form.body_type"
                                class="w-full border rounded p-2 select2 @error('body_type') border-red-500 @enderror"
                                name="body_type">
                                <option value="">نوع بادی موتر</option>
                                <option value="convertible" {{ old('body_type') == 'convertible' ? 'selected' : '' }}>
                                    Convertible</option>
                                <option value="coupe" {{ old('body_type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="CUV" {{ old('body_type') == 'CUV' ? 'selected' : '' }}>CUV</option>
                                <option value="micro" {{ old('body_type') == 'micro' ? 'selected' : '' }}>Micro</option>
                                <option value="supercar" {{ old('body_type') == 'supercar' ? 'selected' : '' }}>Supercar
                                </option>
                                <option value="sedan" {{ old('body_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="pick-up" {{ old('body_type') == 'pick-up' ? 'selected' : '' }}>Pick-up
                                </option>
                                <option value="minivan" {{ old('body_type') == 'minivan' ? 'selected' : '' }}>Minivan
                                </option>
                            </select>
                            @error('body_type')
                                <p class="body-error text-red-500 text-sm mt-1">نوع بادی را انتخاب کنید</p>
                            @enderror
                        </div>

                        {{-- وضعیت ټکر --}}
                        <div>
                            <label class="block font-medium">وضعیت ټکر</label>
                            <select x-model="form.car_condition"
                                class="w-full border rounded p-2 select2 text-right @error('car_condition') border-red-500 @enderror"
                                name="car_condition">
                                <option value="">وضعیت موتر</option>
                                <option value="تصادفی" {{ old('car_condition') == 'تصادفی' ? 'selected' : '' }}>تصادفی
                                </option>
                                <option value="سالم" {{ old('car_condition') == 'سالم' ? 'selected' : '' }}>سالم
                                </option>
                                <option value="تصادفی اما تعمیر شده"
                                    {{ old('car_condition') == 'تصادفی اما تعمیر شده' ? 'selected' : '' }}>تصادفی اما تعمیر
                                    شده</option>
                            </select>
                            @error('car_condition')
                                <p class="car_condition-error text-red-500 text-sm mt-1">وضعیت موتر را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">VIN Number</label>
                            <input type="text" x-model="form.VIN_number"
                                class="w-full border rounded p-2 vin_number-input @error('VIN_number') border-red-500 @enderror"
                                placeholder="VIN Number" name="VIN_number" @input="watchProgress()"
                                @keyup="watchProgress()" />
                            @error('VIN_number')
                                <p class="vin_number-error text-red-500 text-sm mt-1">نمبر شاسی را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Model</label>
                            <select x-model="form.model"
                                class="w-full border rounded p-2 select2 @error('model') border-red-500 @enderror"
                                name="model">
                                <option value="">Select Model</option>
                                <option value="Camry" {{ old('model') == 'Camry' ? 'selected' : '' }}>Camry</option>
                                <option value="Corolla" {{ old('model') == 'Corolla' ? 'selected' : '' }}>Corolla</option>
                                <option value="Prius" {{ old('model') == 'Prius' ? 'selected' : '' }}>Prius</option>
                                <option value="RAV4" {{ old('model') == 'RAV4' ? 'selected' : '' }}>RAV4</option>
                                <option value="Highlander" {{ old('model') == 'Highlander' ? 'selected' : '' }}>Highlander
                                </option>
                                <option value="X3" {{ old('model') == 'X3' ? 'selected' : '' }}>X3</option>
                                <option value="X5" {{ old('model') == 'X5' ? 'selected' : '' }}>X5</option>
                                <option value="3 Series" {{ old('model') == '3 Series' ? 'selected' : '' }}>3 Series
                                </option>
                                <option value="5 Series" {{ old('model') == '5 Series' ? 'selected' : '' }}>5 Series
                                </option>
                                <option value="Civic" {{ old('model') == 'Civic' ? 'selected' : '' }}>Civic</option>
                                <option value="Accord" {{ old('model') == 'Accord' ? 'selected' : '' }}>Accord</option>
                                <option value="CR-V" {{ old('model') == 'CR-V' ? 'selected' : '' }}>CR-V</option>
                                <option value="Pilot" {{ old('model') == 'Pilot' ? 'selected' : '' }}>Pilot</option>
                                <option value="C-Class" {{ old('model') == 'C-Class' ? 'selected' : '' }}>C-Class</option>
                                <option value="E-Class" {{ old('model') == 'E-Class' ? 'selected' : '' }}>E-Class</option>
                                <option value="GLE" {{ old('model') == 'GLE' ? 'selected' : '' }}>GLE</option>
                                <option value="Elantra" {{ old('model') == 'Elantra' ? 'selected' : '' }}>Elantra</option>
                                <option value="Sonata" {{ old('model') == 'Sonata' ? 'selected' : '' }}>Sonata</option>
                                <option value="Tucson" {{ old('model') == 'Tucson' ? 'selected' : '' }}>Tucson</option>
                                <option value="Santa Fe" {{ old('model') == 'Santa Fe' ? 'selected' : '' }}>Santa Fe
                                </option>
                                <option value="Altima" {{ old('model') == 'Altima' ? 'selected' : '' }}>Altima</option>
                                <option value="Sentra" {{ old('model') == 'Sentra' ? 'selected' : '' }}>Sentra</option>
                                <option value="Rogue" {{ old('model') == 'Rogue' ? 'selected' : '' }}>Rogue</option>
                                <option value="Murano" {{ old('model') == 'Murano' ? 'selected' : '' }}>Murano</option>
                                <option value="Optima" {{ old('model') == 'Optima' ? 'selected' : '' }}>Optima</option>
                                <option value="Sorento" {{ old('model') == 'Sorento' ? 'selected' : '' }}>Sorento</option>
                                <option value="Sportage" {{ old('model') == 'Sportage' ? 'selected' : '' }}>Sportage
                                </option>
                                <option value="Focus" {{ old('model') == 'Focus' ? 'selected' : '' }}>Focus</option>
                                <option value="Escape" {{ old('model') == 'Escape' ? 'selected' : '' }}>Escape</option>
                                <option value="Explorer" {{ old('model') == 'Explorer' ? 'selected' : '' }}>Explorer
                                </option>
                                <option value="F-150" {{ old('model') == 'F-150' ? 'selected' : '' }}>F-150</option>
                            </select>
                            @error('model')
                                <p class="text-red-500 text-sm mt-1">Model is required</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Interior Color</label>
                            <select x-model="form.car_inside_color"
                                class="w-full border rounded p-2 select2 @error('car_inside_color') border-red-500 @enderror"
                                name="car_inside_color">
                                <option value="">Select Interior Color</option>
                                <option value="black" {{ old('car_inside_color') == 'black' ? 'selected' : '' }}>Black
                                </option>
                                <option value="gray" {{ old('car_inside_color') == 'gray' ? 'selected' : '' }}>Gray
                                </option>
                                <option value="beige" {{ old('car_inside_color') == 'beige' ? 'selected' : '' }}>Beige
                                </option>
                                <option value="brown" {{ old('car_inside_color') == 'brown' ? 'selected' : '' }}>Brown
                                </option>
                                <option value="white" {{ old('car_inside_color') == 'white' ? 'selected' : '' }}>White
                                </option>
                                <option value="red" {{ old('car_inside_color') == 'red' ? 'selected' : '' }}>Red
                                </option>
                                <option value="blue" {{ old('car_inside_color') == 'blue' ? 'selected' : '' }}>Blue
                                </option>
                            </select>
                            @error('car_inside_color')
                                <p class="text-red-500 text-sm mt-1">Interior color is required</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Car Documents</label>
                            <select x-model="form.car_documents"
                                class="w-full border rounded p-2 select2 @error('car_documents') border-red-500 @enderror"
                                name="car_documents">
                                <option value="">Select Document Status</option>
                                <option value="complete" {{ old('car_documents') == 'complete' ? 'selected' : '' }}>
                                    Complete</option>
                                <option value="incomplete" {{ old('car_documents') == 'incomplete' ? 'selected' : '' }}>
                                    Incomplete</option>
                                <option value="pending" {{ old('car_documents') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                            @error('car_documents')
                                <p class="text-red-500 text-sm mt-1">Car documents status is required</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Transmission Type</label>
                            <select x-model="form.transmission_type"
                                class="w-full border rounded p-2 select2 @error('transmission_type') border-red-500 @enderror"
                                name="transmission_type">
                                <option value="">Select Transmission</option>
                                <option value="manual" {{ old('transmission_type') == 'manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="automatic" {{ old('transmission_type') == 'automatic' ? 'selected' : '' }}>
                                    Automatic</option>
                            </select>
                            @error('transmission_type')
                                <p class="text-red-500 text-sm mt-1">Transmission type is required</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <button type="button" @click="step--; watchProgress()"
                                class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                            <button type="button" @click="nextStep"
                                class="bg-blue-600 text-white px-4 py-2 rounded">Next →</button>
                        </div>
                    </div>

                    <!-- Step 3: Sale Details (Only for sale) -->
                    <div x-show="form.is_for_sale && step === 3" class="space-y-4">
                        <h2 class="text-lg font-semibold mb-4 text-blue-800">Step 3: Sale Information</h2>

                        <div>
                            <label class="block font-medium">Regular Price</label>
                            <input type="number" x-model="form.regular_price"
                                class="w-full border rounded p-2 @error('regular_price') border-red-500 @enderror"
                                placeholder="Regular Price" name="regular_price" @input="watchProgress()" />
                            @error('regular_price')
                                <p class="text-red-500 text-sm mt-1">Regular price is required</p>
                            @enderror
                        </div>



                        <div>
                            <label class="block font-medium">Currency Type</label>
                            <select x-model="form.currency_type"
                                class="w-full border rounded p-2 select2 @error('currency_type') border-red-500 @enderror"
                                name="currency_type">
                                <option value="">Select Currency</option>
                                <option value="USD" {{ old('currency_type') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="AFN" {{ old('currency_type') == 'AFN' ? 'selected' : '' }}>AFN</option>
                                <option value="EUR" {{ old('currency_type') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            </select>
                            @error('currency_type')
                                <p class="text-red-500 text-sm mt-1">Currency type is required</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Location</label>
                            <input type="text" x-model="form.location"
                                class="w-full border rounded p-2 @error('location') border-red-500 @enderror"
                                placeholder="Car Location" name="location" @input="watchProgress()"
                                @keyup="watchProgress()" />
                            <button type="button" @click="getCurrentLocation()"
                                class="mt-2 bg-gray-500 text-white px-3 py-1 rounded text-sm">Get Current Location</button>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">Location is required</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Description</label>
                            <textarea x-model="form.description" class="w-full border rounded p-2 @error('description') border-red-500 @enderror"
                                placeholder="Describe the car (condition, features, history, etc.)" rows="4" name="description"
                                @input="watchProgress()" @keyup="watchProgress()"></textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">Description is required</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <button type="button" @click="step--; watchProgress()"
                                class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                            <button type="button" @click="nextStep"
                                class="bg-blue-600 text-white px-4 py-2 rounded">Next →</button>
                        </div>
                    </div>

                    <!-- Final Step: Media Upload -->
                    <div x-show="(form.is_for_sale || form.is_for_rent) && step === getMaxSteps()" class="space-y-4">
                        <h2 class="text-lg font-semibold mb-4 text-blue-800">Final Step: Upload Media</h2>

                        <div>
                            <label class="block font-medium">Upload Car Images (1–60)</label>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*"
                                @change="handleImages($event)" class="w-full border rounded p-2">
                            @error('images')
                                <p class="image-error text-red-500 text-sm mt-1">خدآقل یک عکس باید آبلوډ شود</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4" x-show="imagePreviews.length > 0">
                            <template x-for="(img, index) in imagePreviews" :key="index">
                                <div class="relative w-24 h-24">
                                    <img :src="img" class="w-full h-full object-cover rounded border" />
                                    <div class="preview-controls">
                                        <button type="button" @click="removeImage(index)"
                                            class="text-red-600 bg-white px-1 rounded">
                                            ✖
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div>
                            <label class="block font-medium">Upload Videos (max 60)</label>
                            <input type="file" name="videos[]" id="videoInput" @change="handleVideos($event)"
                                accept="video/*" multiple
                                class="w-full border rounded p-2 @error('videos') border-red-500 @enderror" />
                            @error('videos')
                                <p class="video-error text-red-500 text-sm mt-1">خدآقل یک ویدیو باید آبلوډ شود</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4" x-show="videoPreviews.length > 0">
                            <template x-for="(video, index) in videoPreviews" :key="index">
                                <div class="relative w-32 h-24">
                                    <video :src="video" controls
                                        class="w-full h-full object-cover rounded border"></video>
                                    <div class="preview-controls">
                                        <button type="button" @click="removeVideo(index)"
                                            class="text-red-600 bg-white px-1 rounded">
                                            ✖
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-between mt-4">
                            <button type="button" @click="step--; watchProgress()"
                                class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-3 rounded text-lg font-semibold">Submit Car
                                Registration ✅</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Review Section -->
            <div class="w-1/2 pl-4">
                <div class="bg-gray-50 p-6 rounded border max-h-[600px] overflow-auto sticky top-4"
                    x-data="{ formData: {} }" x-init="$watch('$parent.form', (value) => { formData = value; }, { deep: true })">
                    <h2 class="text-xl font-semibold mb-4">Review Your Inputs</h2>
                    <div class="space-y-3 text-sm" x-show="form.is_for_sale || form.is_for_rent">
                        <template x-if="form.title">
                            <div><strong>Title:</strong> <span x-text="form.title"></span></div>
                        </template>
                        <template x-if="form.year">
                            <div><strong>Year:</strong> <span x-text="form.year"></span></div>
                        </template>
                        <template x-if="form.make">
                            <div><strong>Make:</strong> <span x-text="form.make"></span></div>
                        </template>
                        <template x-if="form.body_type && form.is_for_sale">
                            <div><strong>Body Type:</strong> <span x-text="form.body_type"></span></div>
                        </template>
                        <template x-if="form.car_condition && form.is_for_sale">
                            <div><strong>Car Condition:</strong> <span x-text="form.car_condition"></span></div>
                        </template>
                        <template x-if="form.VIN_number && form.is_for_sale">
                            <div><strong>VIN Number:</strong> <span x-text="form.VIN_number"></span></div>
                        </template>
                        <template x-if="form.location && form.is_for_sale">
                            <div><strong>Location:</strong> <span x-text="form.location"></span></div>
                        </template>
                        <template x-if="form.model && form.is_for_sale">
                            <div><strong>Model:</strong> <span x-text="form.model"></span></div>
                        </template>
                        <template x-if="form.car_color">
                            <div><strong>Car Color:</strong> <span x-text="form.car_color"></span></div>
                        </template>
                        <template x-if="form.car_inside_color && form.is_for_sale">
                            <div><strong>Interior Color:</strong> <span x-text="form.car_inside_color"></span></div>
                        </template>
                        <template x-if="form.car_documents && form.is_for_sale">
                            <div><strong>Documents:</strong> <span x-text="form.car_documents"></span></div>
                        </template>
                        <template x-if="form.transmission_type && form.is_for_sale">
                            <div><strong>Transmission:</strong> <span x-text="form.transmission_type"></span></div>
                        </template>
                        <div class="flex" x-show="form.is_for_sale">
                            <template x-if="form.regular_price">
                                <div><strong>Regular Price:</strong> <span x-text="form.regular_price"></span> &nbsp;
                                </div>
                            </template>
                            <template x-if="form.currency_type">
                                <div> <span x-text="form.currency_type"></span></div>
                            </template>
                        </div>

                        <template x-if="form.is_for_sale">
                            <div><strong>For Sale:</strong> Yes</div>
                        </template>
                        <template x-if="form.is_for_rent">
                            <div>
                                <strong>For Rent:</strong> Yes
                                <div class="ml-2">
                                    <template x-if="form.rent_price_per_day">
                                        <div>Per Day: <span x-text="form.rent_price_per_day"></span> <span
                                                x-text="form.currency_type"></span></div>
                                    </template>
                                    <template x-if="form.rent_price_per_month">
                                        <div>Per Month: <span x-text="form.rent_price_per_month"></span> <span
                                                x-text="form.currency_type"></span></div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        <template x-if="form.description && form.is_for_sale">
                            <div><strong>Description:</strong> <span x-text="form.description"></span></div>
                        </template>
                        <template x-if="imagePreviews.length">
                            <div>
                                <strong>Images:</strong>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <template x-for="(img, index) in imagePreviews" :key="'revimg' + index">
                                        <img :src="img" class="w-16 h-16 object-cover rounded border" />
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="videoPreviews.length">
                            <div>
                                <strong>Videos:</strong>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <template x-for="(video, index) in videoPreviews" :key="'revvid' + index">
                                        <video :src="video" controls class="w-32 h-20 rounded border"></video>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="!form.is_for_sale && !form.is_for_rent" class="text-gray-500 text-center py-8">
                        Please select if the car is for sale or rent to see the review.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function carForm() {
            return {
                step: 1,
                progress: 0,
                filledFieldsCount: 0, // For debugging
                totalFieldsCount: 22, // For debugging
                years: Array.from({
                    length: 31
                }, (_, i) => 1995 + i),

                errors: {},

                form: {
                    title: '{{ old('title') }}',
                    year: '{{ old('year') }}',
                    make: '{{ old('make') }}',
                    body_type: '{{ old('body_type') }}',
                    car_condition: '{{ old('car_condition') }}',
                    car_color: '{{ old('car_color') }}',
                    car_documents: '{{ old('car_documents') }}',
                    car_inside_color: '{{ old('car_inside_color') }}',
                    VIN_number: '{{ old('VIN_number') }}',
                    location: '{{ old('location') }}',
                    model: '{{ old('model') }}',
                    transmission_type: '{{ old('transmission_type') }}',
                    currency_type: '{{ old('currency_type') }}',
                    regular_price: '{{ old('regular_price') }}',
                    description: '{{ old('description') }}',
                    is_for_sale: {{ old('is_for_sale') ? 'true' : 'false' }},
                    is_for_rent: {{ old('is_for_rent') ? 'true' : 'false' }},
                    rent_price_per_day: '{{ old('rent_price_per_day') }}',
                    rent_price_per_month: '{{ old('rent_price_per_month') }}',
                    bargain_id: null, // Will be set from URL params
                },

                imagePreviews: [],
                imageFiles: [],

                videoPreviews: [],
                videoFiles: [],


                initSelect2() {
                    // Initialize Select2 for all selects with class .select2
                    this.$nextTick(() => {
                        const selects = document.querySelectorAll('.select2');
                        selects.forEach((select) => {
                            // Destroy existing Select2 instance if it exists
                            if ($(select).hasClass('select2-hidden-accessible')) {
                                $(select).select2('destroy');
                            }

                            $(select).select2({
                                placeholder: select.options[0]?.text || 'Select an option',
                                allowClear: true
                            }).on('change', (e) => {
                                const modelName = select.getAttribute('x-model');
                                if (modelName) {
                                    const fieldName = modelName.replace('form.', '');
                                    const selectedValue = $(select).val() || '';

                                    // Update Alpine.js form object immediately for live updates
                                    this.form[fieldName] = selectedValue;

                                    // Force immediate reactivity update for live review
                                    this.$nextTick(() => {
                                        this.watchProgress();
                                        // Force Alpine.js to detect changes immediately
                                        this.$forceUpdate && this.$forceUpdate();
                                    });
                                }
                            });

                            // Set initial values from Alpine.js form and old() values
                            const modelName = select.getAttribute('x-model');
                            if (modelName) {
                                const fieldName = modelName.replace('form.', '');
                                const formValue = this.form[fieldName];
                                const selectedOption = select.querySelector('option[selected]');

                                // Priority: old() value (selected attribute) > Alpine.js form value
                                if (selectedOption && selectedOption.value) {
                                    this.form[fieldName] = selectedOption.value;
                                    $(select).val(selectedOption.value).trigger('change.select2');
                                } else if (formValue) {
                                    $(select).val(formValue).trigger('change.select2');
                                }
                            }
                        });
                    });
                },

                // Function to manually sync all Select2 values with Alpine.js form
                syncSelect2Values() {
                    console.log('Syncing Select2 values...');
                    const selects = document.querySelectorAll('.select2');
                    selects.forEach((select) => {
                        const modelName = select.getAttribute('x-model');
                        if (modelName) {
                            const fieldName = modelName.replace('form.', '');
                            const selectedValue = $(select).val() || '';
                            console.log(`Syncing ${fieldName}: ${selectedValue}`);
                            this.form[fieldName] = selectedValue;
                        }
                    });
                    console.log('Form after sync:', this.form);
                    this.watchProgress();
                },

                getMaxSteps() {
                    // For rent only: 2 steps (basic info + media)
                    if (this.form.is_for_rent && !this.form.is_for_sale) {
                        return 2;
                    }
                    // For sale only or both: 4 steps (basic + details + sale + media)
                    return 4;
                },

                nextStep() {
                    // First sync all Select2 values before validation
                    this.syncSelect2Values();

                    // Small delay to ensure sync is complete
                    this.$nextTick(() => {
                        // Validate current step
                        if (!this.validateStep()) return;

                        if (this.step < this.getMaxSteps()) {
                            this.step++;
                            this.watchProgress(); // Update progress when moving to next step
                        }
                    });
                },

                validateStep() {
                    let errors = [];

                    if (this.step === 1) {
                        // Check if at least one purpose is selected
                        if (!this.form.is_for_sale && !this.form.is_for_rent) {
                            errors.push('Please select if the car is for sale or rent.');
                        }

                        // Basic required fields for all
                        if (!this.form.title || !this.form.title.trim()) errors.push('Title is required.');
                        if (!this.form.year || this.form.year === '') errors.push('Year is required.');
                        if (!this.form.make || this.form.make === '') errors.push('Make is required.');
                        if (!this.form.car_color || this.form.car_color === '') errors.push('Car color is required.');

                        // Rent fields validation (when rent is selected)
                        if (this.form.is_for_rent) {
                            if ((!this.form.rent_price_per_day || Number(this.form.rent_price_per_day) <= 0) &&
                                (!this.form.rent_price_per_month || Number(this.form.rent_price_per_month) <= 0)) {
                                errors.push('Provide rent per day or rent per month.');
                            }
                        }
                    } else if (this.step === 2 && this.form.is_for_sale) {
                        // Additional fields for sale
                        if (!this.form.body_type || this.form.body_type === '') errors.push('Body type is required.');
                        if (!this.form.car_condition || this.form.car_condition === '') errors.push(
                            'Car condition is required.');
                        if (!this.form.VIN_number || !this.form.VIN_number.trim()) errors.push('VIN Number is required.');
                    } else if (this.step === 3 && this.form.is_for_sale) {
                        // Sale fields validation (only validate if sale is selected)
                        // Regular price and sale price are now OPTIONAL
                        if (this.form.regular_price && this.form.regular_price <= 0) {
                            errors.push('Regular price must be greater than zero if provided.');
                        }

                        if (!this.form.currency_type) errors.push('Currency Type is required.');


                    } else if (this.step === this.getMaxSteps()) {
                        // Media upload validation
                        if (this.imageFiles.length < 1) errors.push('At least one image is required.');
                        if (this.imageFiles.length > 60) errors.push('Maximum 60 images allowed.');
                        if (this.videoFiles.length > 60) errors.push('Maximum 60 videos allowed.');
                    }

                    if (errors.length > 0) {
                        console.log('Validation errors:', errors);
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errors.join('<br>'),
                        });
                        return false;
                    }
                    return true;
                },
                getCurrentLocation() {
                    if (!navigator.geolocation) {
                        Swal.fire('Error', 'Geolocation is not supported by your browser.', 'error');
                        return;
                    }

                    // Show loading message
                    Swal.fire({
                        title: 'Getting Location...',
                        text: 'Please wait while we get your current location.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            // Success callback
                            this.form.location =
                                `${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}`;
                            this.watchProgress();
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Location Retrieved!',
                                text: 'Your current location has been added to the form.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        (error) => {
                            // Error callback
                            Swal.close();
                            let errorMessage = 'Unable to retrieve your location.';

                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage =
                                        'Location access denied by user. Please enable location access and try again.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = 'Location information is unavailable. Please try again later.';
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = 'Location request timed out. Please try again.';
                                    break;
                                default:
                                    errorMessage = 'An unknown error occurred while retrieving location.';
                                    break;
                            }

                            Swal.fire('Error', errorMessage, 'error');
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                },

                handleImages(event) {
                    const files = Array.from(event.target.files);

                    if (files.length > 60) {
                        Swal.fire('Error', 'You can upload max 60 images.', 'error');
                        event.target.value = ''; // Clear the input
                        return;
                    }

                    // Clear previous previews
                    this.imagePreviews = [];
                    this.imageFiles = [];

                    files.forEach(file => {
                        if (!file.type.startsWith('image/')) return;

                        this.imageFiles.push(file);
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.imagePreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });

                    this.watchProgress();
                },


                removeImage(index) {
                    this.imageFiles.splice(index, 1);
                    this.imagePreviews.splice(index, 1);

                    // Update the file input
                    const input = document.getElementById('imageInput');
                    const dt = new DataTransfer();
                    this.imageFiles.forEach(file => dt.items.add(file));
                    input.files = dt.files;

                    this.watchProgress();
                },



                handleVideos(event) {
                    const files = Array.from(event.target.files);

                    if (files.length > 60) {
                        Swal.fire('Error', 'You can upload max 60 videos.', 'error');
                        event.target.value = ''; // Clear the input
                        return;
                    }

                    // Clear previous previews
                    this.videoPreviews = [];
                    this.videoFiles = [];

                    files.forEach(file => {
                        if (!file.type.startsWith('video/')) return;

                        this.videoFiles.push(file);
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.videoPreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });

                    this.watchProgress();
                },

                removeVideo(index) {
                    this.videoFiles.splice(index, 1);
                    this.videoPreviews.splice(index, 1);

                    // Update the file input
                    const input = document.getElementById('videoInput');
                    const dt = new DataTransfer();
                    this.videoFiles.forEach(file => dt.items.add(file));
                    input.files = dt.files;

                    this.watchProgress();
                },
                clearError(field) {
                    delete this.errors[field];
                },


                resetForm() {
                    this.step = 1;

                    this.form = {
                        title: '',
                        year: '',
                        make: '',
                        body_type: '',
                        car_condition: '',
                        car_color: '',
                        car_documents: '',
                        car_inside_color: '',
                        VIN_number: '',
                        location: '',
                        model: '',
                        transmission_type: '',
                        currency_type: '',
                        regular_price: '',

                        description: '',
                        is_for_sale: false,
                        is_for_rent: false,
                        rent_price_per_day: '',
                        rent_price_per_month: '',
                    };

                    this.imageFiles = [];
                    this.imagePreviews = [];

                    this.videoFiles = [];
                    this.videoPreviews = [];
                    this.errors = {};

                    // Reset Select2 fields
                    $('.select2').val(null).trigger('change');
                    this.watchProgress();
                },

                watchProgress() {
                    // Define fields based on purpose selection
                    let requiredFields = ['title', 'year', 'make', 'car_color'];
                    let conditionalFields = [];

                    // Add conditional fields based on purpose
                    if (this.form.is_for_sale) {
                        conditionalFields = conditionalFields.concat([
                            'body_type', 'car_condition', 'VIN_number', 'location', 'model',
                            'car_inside_color', 'car_documents', 'transmission_type',
                            'currency_type', 'regular_price', 'description'
                        ]);
                    }

                    // Add rent fields if rent is selected
                    if (this.form.is_for_rent) {
                        conditionalFields = conditionalFields.concat(['rent_price_per_day', 'rent_price_per_month']);
                    }

                    // Boolean fields
                    const booleanFields = ['is_for_sale', 'is_for_rent'];

                    let filledFields = 0;
                    let totalFields = requiredFields.length + conditionalFields.length + booleanFields.length +
                        2; // +2 for images and videos

                    // Check required fields
                    requiredFields.forEach(field => {
                        if (this.form[field] && this.form[field].toString().trim() !== '') {
                            filledFields++;
                        }
                    });

                    // Check conditional fields
                    conditionalFields.forEach(field => {
                        if (this.form[field] && this.form[field].toString().trim() !== '') {
                            filledFields++;
                        }
                    });

                    // Check boolean fields
                    if (this.form.is_for_sale) {
                        filledFields++;
                    }
                    if (this.form.is_for_rent) {
                        filledFields++;
                    }

                    // Check images (required - at least 1)
                    if (this.imageFiles && this.imageFiles.length > 0) {
                        filledFields++;
                    }

                    // Check videos (optional)
                    if (this.videoFiles && this.videoFiles.length > 0) {
                        filledFields++;
                    }

                    // Calculate percentage (0-100%)
                    this.filledFieldsCount = filledFields;
                    this.progress = Math.min(100, Math.round((filledFields / totalFields) * 100));
                }
            };
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Set CSRF token for axios and jQuery AJAX
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (window.axios) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            }
            if (window.$) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
            }

            const errorElements = document.querySelectorAll(".border-red-500");
            if (errorElements.length > 0) {
                errorElements[0].scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }

            document.querySelectorAll("input, select, textarea").forEach(el => {
                el.addEventListener("input", () => {
                    el.classList.remove("border-red-500");
                });

                // For select2 fields
                $(el).on('change', function() {
                    el.classList.remove("border-red-500");
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const fields = [
                'title', 'year', 'make', 'body_type', 'car_condition', 'vin_number', 'location',
                'model', 'car_color', 'car_inside_color', 'car_documents', 'transmission_type',
                'regular_price', 'currency_type', 'image', 'video'
            ];


            fields.forEach(field => {
                const input = document.querySelector(`.${field}-input`);
                const error = document.querySelector(`.${field}-error`);

                if (input && error) {
                    const removeError = () => error.style.display = 'none';
                    input.addEventListener('input', removeError);
                    input.addEventListener('change', removeError);
                }
            });
        });
    </script>

@endsection
