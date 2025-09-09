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
        <div class="bg-white p-6 rounded shadow-md max-w-7xl mx-auto flex flex-col lg:flex-row gap-6"
            style="box-shadow: 0 0 2px black; margin: 1rem 0;">
            <!-- Form Section -->
            <div class="flex-1 lg:w-2/3">
                <h1 class="text-2xl font-bold mb-6">🚗 Car Registration Form</h1>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-300 h-4 rounded mb-6 relative">
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-300"
                            :style="`width: ${progress}%`">
                        </div>
                    </div>
                    <p class="text-sm text-center text-gray-700" x-text="`${progress}% completed`"></p>
                    <!-- Debug info (remove in production) -->
                    <!-- <p class="text-xs text-gray-500 text-center" x-text="`Debug: ${filledFieldsCount}/${totalFieldsCount} fields`"></p> -->

                </div>
                <form action="{{ route('car.store') }}" method="post" enctype="multipart/form-data"
                    @submit="syncSelect2Values()">
                    @csrf
                    <!-- Hidden inputs to ensure all values are submitted -->
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
                    <!-- Step 1 -->
                    <div x-show="step === 1" class="space-y-4">
                        <div>
                            <label class="block font-medium ">Title</label>
                            <input type="text" x-model="form.title"
                                class="w-full border rounded p-2 title-input @error('title') border-red-500 @enderror"
                                placeholder="Title of the car" name="title" value="{{ old('title') }}"
                                @input="watchProgress()" @keyup="watchProgress()" />
                            @error('title')
                                <p class="title-error text-red-500 text-sm mt-1"> عنوان برای پوست تان انتخاب کنید</p>
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
                                <p class="year-error text-red-500 text-sm mt-1"> سال تولید موتر را انتخاب کنید</p>
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
                                <option value="marcedes" {{ old('make') == 'marcedes' ? 'selected' : '' }}>Mercedes</option>
                                <option value="Hyundai" {{ old('make') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                <option value="Nissan" {{ old('make') == 'Nissan' ? 'selected' : '' }}>Nissan</option>
                                <option value="Kia" {{ old('make') == 'Kia' ? 'selected' : '' }}>Kia</option>
                                <option value="ford" {{ old('make') == 'ford' ? 'selected' : '' }}>Ford</option>
                            </select>

                            @error('make')
                                <p class="make-error text-red-500 text-sm mt-1"> کمپنی موتر را انتخاب کنید</p>
                            @enderror

                        </div>

                        {{-- نوع بادی --}}
                        <div>
                            <label class="block font-medium ">نوع یادی</label>
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
                                <p class="body-error text-red-500 text-sm mt-1"> نوع بادی را انتخاب کنید</p>
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
                                    {{ old('car_condition') == 'تصادفی اما تعمیر شده' ? 'selected' : '' }}>
                                    تصادفی اما تعمیر شده</option>
                            </select>

                            @error('car_condition')
                                <p class="car_condition-error text-red-500 text-sm mt-1"> وضعیت موتر را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">VIN Number</label>
                            <input type="text" x-model="form.VIN_number"
                                class="w-full border rounded p-2 vin_number-input @error('VIN_number') border-red-500 @enderror"
                                placeholder="VIN Number" name="VIN_number" @input="watchProgress()"
                                @keyup="watchProgress()" />
                            @error('VIN_number')
                                <p class="vin_number-error text-red-500 text-sm mt-1"> نمبر شاسی را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium">Location (Live)</label>
                            <input type="text" x-model="form.location"
                                class="w-full border rounded p-2 @error('location') border-red-500  @enderror"
                                placeholder="Click to get current location" readonly @click="getLocation" name="location"
                                @input="watchProgress()" @change="watchProgress()" />
                            @error('location')
                                <p class="location-error text-red-500 text-sm mt-1"> موقیعت تان زا انتخاب کنید</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="nextStep"
                                class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Next →</button>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div x-show="step === 2" class="space-y-4">
                        <div>
                            <label class="block font-medium">Model</label>
                            <select x-model="form.model"
                                class="w-full border rounded p-2 select2 @error('model') border-red-500 @enderror"
                                name="model">
                                <option value="">Select Model</option>
                                <option value="corrola" {{ old('model') == 'corrola' ? 'selected' : '' }}>Corolla</option>
                                <option value="focus" {{ old('model') == 'focus' ? 'selected' : '' }}>
                                    Focus</option>
                                <option value="xs" {{ old('model') == 'xs' ? 'selected' : '' }}>X5
                                </option>
                                <option value="civic" {{ old('model') == 'civic' ? 'selected' : '' }}>
                                    Civic</option>
                                <option value="c-class" {{ old('model') == 'c-class' ? 'selected' : '' }}>C-Class</option>
                            </select>

                            @error('model')
                                <p class="model-error text-red-500 text-sm mt-1"> مودل موتر را انتخاب کنید</p>
                            @enderror
                        </div>

                        {{-- رنگ باډی موتر --}}
                        <div>
                            <label class="block font-medium">Car Body Color</label>
                            <select x-model="form.car_color"
                                class="w-full border rounded p-2 select2 text-right @error('car_color') border-red-500 @enderror"
                                name="car_color">
                                <option value="">رنگ بدنه موتر را انتخاب کنید</option>
                                <option value="black" {{ old('car_color') == 'black' ? 'selected' : '' }}>سیاه
                                </option>
                                <option value="white" {{ old('car_color') == 'white' ? 'selected' : '' }}>سفید
                                </option>
                                <option value="gray" {{ old('car_color') == 'gray' ? 'selected' : '' }}>خاکستری
                                </option>
                                <option value="silver" {{ old('car_color') == 'silver' ? 'selected' : '' }}>نقره‌ای
                                </option>
                                <option value="navy" {{ old('car_color') == 'navy' ? 'selected' : '' }}>سرمه‌ای
                                </option>
                                <option value="blue" {{ old('car_color') == 'blue' ? 'selected' : '' }}>آبی</option>
                                <option value="gold" {{ old('car_color') == 'gold' ? 'selected' : '' }}>طلایی
                                </option>
                                <option value="yellow" {{ old('car_color') == 'yellow' ? 'selected' : '' }}>زرد
                                </option>
                                <option value="red" {{ old('car_color') == 'red' ? 'selected' : '' }}>قرمز</option>
                                <option value="green" {{ old('car_color') == 'green' ? 'selected' : '' }}>سبز</option>
                                <option value="brown" {{ old('car_color') == 'brown' ? 'selected' : '' }}>قهوه‌ای
                                </option>
                                <option value="chestnut" {{ old('car_color') == 'chestnut' ? 'selected' : '' }}>قهوه‌ای
                                    سوخته</option>
                                <option value="orange" {{ old('car_color') == 'orange' ? 'selected' : '' }}>نارنجی
                                </option>
                                <option value="purple" {{ old('car_color') == 'purple' ? 'selected' : '' }}>بنفش
                                </option>
                                <option value="coral" {{ old('car_color') == 'coral' ? 'selected' : '' }}>مرجانی
                                </option>
                                <option value="ruby" {{ old('car_color') == 'ruby' ? 'selected' : '' }}>یاقوتی
                                </option>
                                <option value="sky_blue" {{ old('car_color') == 'sky_blue' ? 'selected' : '' }}>آبی
                                    آسمانی</option>
                                <option value="olive" {{ old('car_color') == 'olive' ? 'selected' : '' }}>زیتونی
                                </option>
                                <option value="turquoise" {{ old('car_color') == 'turquoise' ? 'selected' : '' }}>
                                    فیروزه‌ای</option>
                                <option value="ice" {{ old('car_color') == 'ice' ? 'selected' : '' }}>یخی</option>
                            </select>
                            @error('car_color')
                                <p class="car_color-error text-red-500 text-sm mt-1"> رنگ باډی موتر را انتخاب کنید</p>
                            @enderror
                        </div>


                        {{-- رنک داخلي موتر --}}

                        <div>
                            <label class="block font-medium">رنگ داخلي موتر</label>
                            <select x-model="form.car_inside_color"
                                class="w-full border rounded p-2 select2 text-right @error('car_inside_color') border-red-500 @enderror"
                                name="car_inside_color">
                                <option value="">رنگ بادی موتر را انتخاب کنید</option>
                                <option value="سیاه" {{ old('car_inside_color') == 'سیاه' ? 'selected' : '' }}>سیاه
                                </option>
                                <option value="سفید" {{ old('car_inside_color') == 'سفید' ? 'selected' : '' }}>سفید
                                </option>
                                <option value="خاکستری" {{ old('car_inside_color') == 'خاکستری' ? 'selected' : '' }}>
                                    خاکستری</option>
                                <option value="نقره‌ای" {{ old('car_inside_color') == 'نقره‌ای' ? 'selected' : '' }}>
                                    نقره‌ای</option>
                                <option value="سرمه‌ای" {{ old('car_inside_color') == 'سرمه‌ای' ? 'selected' : '' }}>
                                    سرمه‌ای</option>
                                <option value="آبی" {{ old('car_inside_color') == 'آبی' ? 'selected' : '' }}>آبی
                                </option>
                                <option value="زر" {{ old('car_inside_color') == 'زر' ? 'selected' : '' }}>زر</option>
                                <option value="زرد" {{ old('car_inside_color') == 'زرد' ? 'selected' : '' }}>زرد
                                </option>
                                <option value="قرمز" {{ old('car_inside_color') == 'قرمز' ? 'selected' : '' }}>قرمز
                                </option>
                                <option value="سبز" {{ old('car_inside_color') == 'سبز' ? 'selected' : '' }}>سبز
                                </option>
                                <option value="قهوه‌ای" {{ old('car_inside_color') == 'قهوه‌ای' ? 'selected' : '' }}>
                                    قهوه‌ای</option>
                                <option value="خرمایی" {{ old('car_inside_color') == 'خرمایی' ? 'selected' : '' }}>خرمایی
                                </option>
                                <option value="نارنجی" {{ old('car_inside_color') == 'نارنجی' ? 'selected' : '' }}>نارنجی
                                </option>
                                <option value="بنفش" {{ old('car_inside_color') == 'بنفش' ? 'selected' : '' }}>بنفش
                                </option>
                                <option value="مرجانی" {{ old('car_inside_color') == 'مرجانی' ? 'selected' : '' }}>مرجانی
                                </option>
                                <option value="یاقوتی" {{ old('car_inside_color') == 'یاقوتی' ? 'selected' : '' }}>یاقوتی
                                </option>
                                <option value="آبی آسمانی"
                                    {{ old('car_inside_color') == 'آبی آسمانی' ? 'selected' : '' }}>آبی آسمانی</option>
                                <option value="زیتونی" {{ old('car_inside_color') == 'زیتونی' ? 'selected' : '' }}>زیتونی
                                </option>
                                <option value="فیروزه‌ای" {{ old('car_inside_color') == 'فیروزه‌ای' ? 'selected' : '' }}>
                                    فیروزه‌ای</option>
                                <option value="یخی" {{ old('car_inside_color') == 'یخی' ? 'selected' : '' }}>یخی
                                </option>
                            </select>
                            @error('car_inside_color')
                                <p class="car_inside_solor-error text-red-500 text-sm mt-1"> رنگ داخلي موتر را انتخاب کنید</p>
                            @enderror
                        </div>


                        {{-- اسناد موتر  --}}

                        <div>
                            <label class="block font-medium">اسناد موتر</label>
                            <select x-model="form.car_documents" name="car_documents"
                                class="w-full border rounded p-2 select2 text-right @error('car_documents') border-red-500 @enderror">
                                <option value="">نوع سند موتر را انتخاب کنید</option>
                                <option value="سند گمرک" {{ old('car_documents') == 'سند گمرک' ? 'selected' : '' }}>سند
                                    گمرک</option>
                                <option value="سند ثبت موتر"
                                    {{ old('car_documents') == 'سند ثبت موتر' ? 'selected' : '' }}>سند ثبت موتر</option>
                                <option value="سند مالکیت" {{ old('car_documents') == 'سند مالکیت' ? 'selected' : '' }}>
                                    سند مالکیت</option>
                                <option value="سند ترانسپورت"
                                    {{ old('car_documents') == 'سند ترانسپورت' ? 'selected' : '' }}>سند ترانسپورت</option>
                                <option value="سند بیمه" {{ old('car_documents') == 'سند بیمه' ? 'selected' : '' }}>سند
                                    بیمه</option>
                                <option value="سند فابریکه" {{ old('car_documents') == 'سند فابریکه' ? 'selected' : '' }}>
                                    سند فابریکه</option>
                                <option value="سند نمبر پلیت"
                                    {{ old('car_documents') == 'سند نمبر پلیت' ? 'selected' : '' }}>سند نمبر پلیت</option>
                                <option value="سند انتقال ملکیت"
                                    {{ old('car_documents') == 'سند انتقال ملکیت' ? 'selected' : '' }}>سند انتقال ملکیت
                                </option>
                                <option value="سند پاسپورت موتر"
                                    {{ old('car_documents') == 'سند پاسپورت موتر' ? 'selected' : '' }}>سند پاسپورت موتر
                                </option>
                                <option value="سند تخنیکی معاینه"
                                    {{ old('car_documents') == 'سند تخنیکی معاینه' ? 'selected' : '' }}>سند تخنیکی معاینه
                                </option>
                                <option value="سند تصدیق ترانزیت"
                                    {{ old('car_documents') == 'سند تصدیق ترانزیت' ? 'selected' : '' }}>سند تصدیق ترانزیت
                                </option>
                                <option value="سند اجازه تردد"
                                    {{ old('car_documents') == 'سند اجازه تردد' ? 'selected' : '' }}>سند اجازه تردد
                                </option>
                                <option value="سند تصدیق گمرک قبلی"
                                    {{ old('car_documents') == 'سند تصدیق گمرک قبلی' ? 'selected' : '' }}>سند تصدیق گمرک
                                    قبلی</option>
                                <option value="سند تایید انجین"
                                    {{ old('car_documents') == 'سند تایید انجین' ? 'selected' : '' }}>سند تایید انجین
                                </option>
                                <option value="سند تایید شاسی"
                                    {{ old('car_documents') == 'سند تایید شاسی' ? 'selected' : '' }}>سند تایید شاسی
                                </option>
                                <option value="سند ترافیکی" {{ old('car_documents') == 'سند ترافیکی' ? 'selected' : '' }}>
                                    سند ترافیکی</option>
                                <option value="سند موقت" {{ old('car_documents') == 'سند موقت' ? 'selected' : '' }}>سند
                                    موقت</option>
                                <option value="سند نمبر انجن"
                                    {{ old('car_documents') == 'سند نمبر انجن' ? 'selected' : '' }}>سند نمبر انجن</option>
                                <option value="سند نمبر شاسی"
                                    {{ old('car_documents') == 'سند نمبر شاسی' ? 'selected' : '' }}>سند نمبر شاسی</option>
                                <option value="سند نمبرگذاری"
                                    {{ old('car_documents') == 'سند نمبرگذاری' ? 'selected' : '' }}>سند نمبرگذاری</option>
                            </select>

                            @error('car_documents')
                                <p class="car_documents-error text-red-500 text-sm mt-1"> سند موتر را انتخاب کنید</p>
                            @enderror
                        </div>



                        <div>
                            <label class="block font-medium">Transmission Type</label>
                            <select x-model="form.transmission_type"
                                class="w-full border rounded p-2 select2 @error('transmission_type') border-red-500 @enderror"
                                name="transmission_type">
                                <option value="">Select Transmission</option>
                                <option value="automatic" {{ old('transmission_type') == 'automatic' ? 'selected' : '' }}>
                                    Automatic</option>
                                <option value="manual" {{ old('transmission_type') == 'manual' ? 'selected' : '' }}>Manual
                                </option>
                            </select>
                            @error('transmission_type')
                                <p class="transmission_type-error text-red-500 text-sm mt-1"> نوع ترانسپورت را انتخاب کنید</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <!-- Regular Price -->
                            <div class="flex-1">
                                <label class="block font-medium">Regular Price</label>
                                <input type="number" x-model="form.regular_price"
                                    class="w-full border rounded p-2 @error('regular_price') border-red-500  @enderror"
                                    name="regular_price" @input="watchProgress()" @keyup="watchProgress()"
                                    @change="watchProgress()"
                                    x-bind:class="{
                                        'border-red-500': form
                                            .regular_price <=
                                            0 &&
                                            step ===
                                            2
                                    }"
                                    x-bind:placeholder="form.currency_type ?
                                        `Regular price (${form.currency_type})` :
                                        'Regular price'"
                                    placeholder="Regular price" min="0" />
                                @error('regular_price')
                                    <p class="regular_price-error text-red-500 text-sm mt-1"> Regular price is required</p>
                                @enderror
                            </div>

                            <!-- Currency Type -->
                            <div class="flex-1">
                                <label class="block font-medium">Currency Type</label>
                                <select x-model="form.currency_type"
                                    class="w-full border p-3 rounded select2 @error('currency_type') border-red-500 @enderror"
                                    name="currency_type">
                                    <option value="">Select currency</option>
                                    <option value="Afn" {{ old('currency_type') == 'Afn' ? 'selected' : '' }}>Afn
                                    </option>
                                    <option value="$" {{ old('currency_type') == '$' ? 'selected' : '' }}>$</option>
                                    <option value="ERU" {{ old('currency_type') == 'ERU' ? 'selected' : '' }}>ERU
                                    </option>
                                </select>
                                @error('currency_type')
                                    <p class="currency_typy-error text-red-500 text-sm mt-1"> Currency type is required</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Sale Price - separate row -->
                        <div class="mt-4">
                            <label class="block font-medium">Sale Price</label>
                            <input type="number" x-model="form.sale_price"
                                class="w-full border rounded p-2 @error('sale_price') border-red-500 @enderror"
                                placeholder="Sale price" min="0" name="sale_price" @input="watchProgress()"
                                @keyup="watchProgress()" @change="watchProgress()" />
                            @error('sale_price')
                                <p class="sale_price-error text-red-500 text-sm mt-1"> Sale price is required</p>
                            @enderror
                        </div>

                        <!-- Sell / Rent Toggles -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="is_for_sale" x-model="form.is_for_sale" value="1"
                                    class="h-4 w-4"
                                    @change="form.is_for_sale = $event.target.checked; watchProgress(); $nextTick(() => { $dispatch('form-changed'); })" />
                                <span>For Sale</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="is_for_rent" x-model="form.is_for_rent" value="1"
                                    class="h-4 w-4"
                                    @change="form.is_for_rent = $event.target.checked; watchProgress(); $nextTick(() => { $dispatch('form-changed'); })" />
                                <span>For Rent</span>
                            </label>
                        </div>

                        <!-- Rent Fields -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4" x-show="form.is_for_rent">
                            <div>
                                <label class="block font-medium">Rent per Day</label>
                                <input type="number" min="0" step="0.01" name="rent_price_per_day"
                                    x-model="form.rent_price_per_day" class="w-full border rounded p-2"
                                    placeholder="e.g., 100" @input="watchProgress()" @keyup="watchProgress()"
                                    @change="watchProgress()" />
                            </div>
                            <div>
                                <label class="block font-medium">Rent per Month</label>
                                <input type="number" min="0" step="0.01" name="rent_price_per_month"
                                    x-model="form.rent_price_per_month" class="w-full border rounded p-2"
                                    placeholder="e.g., 2000" @input="watchProgress()" @keyup="watchProgress()"
                                    @change="watchProgress()" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <label class="block font-medium">Description</label>
                            <textarea name="description" x-model="form.description" class="w-full border rounded p-2" rows="4"
                                placeholder="Describe the car (condition, features, history, etc.)" @input="watchProgress()"
                                @keyup="watchProgress()"></textarea>
                        </div>


                        <div class="flex justify-between mt-4">
                            <button type="button" @click="step--; watchProgress()"
                                class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                            <button type="button" @click="nextStep"
                                class="bg-blue-600 text-white px-4 py-2 rounded">Next
                                →</button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div x-show="step === 3" class="space-y-4">

                        <div>
                            <label class="block font-medium">Upload Car Images (1–11)</label>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*"
                                @change="handleImages($event)" class="w-full border rounded p-2">
                            @error('images')
                                <p class="image-error text-red-500 text-sm mt-1"> خدآقل یک عکس باید آبلوډ شود</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap gap-2" x-show="imagePreviews.length > 0">
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
                            <label class="block font-medium">Upload Videos (max 2)</label>
                            <input type="file" name="videos[]" id="videoInput" @change="handleVideos($event)"
                                accept="video/*" multiple
                                class="w-full border rounded p-2 @error('videos') border-red-500 @enderror" />
                            @error('videos')
                                <p class="video-error text-red-500 text-sm mt-1"> خدآقل یک ویدیو باید آبلوډ شود</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap gap-2" x-show="videoPreviews.length > 0">
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
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit ✅</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Review Section -->
            <div class="flex-1 lg:w-1/3 lg:ml-6">
                <div class="bg-gray-50 p-6 rounded border max-h-[600px] overflow-auto sticky top-4"
                    x-data="{ formData: {} }" x-init="$watch('$parent.form', (value) => { formData = value; }, { deep: true })">
                    <h2 class="text-xl font-semibold mb-4">Review Your Inputs</h2>
                    <div class="space-y-3 text-sm">
                        <template x-if="form.title">
                            <div><strong>Title:</strong> <span x-text="form.title"></span></div>
                        </template>
                        <template x-if="form.year">
                            <div><strong>Year:</strong> <span x-text="form.year"></span></div>
                        </template>
                        <template x-if="form.make">
                            <div><strong>Make:</strong> <span x-text="form.make"></span></div>
                        </template>
                        <template x-if="form.body_type">
                            <div><strong>Body Type:</strong> <span x-text="form.body_type"></span></div>
                        </template>
                        <template x-if="form.car_condition">
                            <div><strong>Car Condition:</strong> <span x-text="form.car_condition"></span></div>
                        </template>
                        <template x-if="form.VIN_number">
                            <div><strong>VIN Number:</strong> <span x-text="form.VIN_number"></span></div>
                        </template>
                        <template x-if="form.location">
                            <div><strong>Location:</strong> <span x-text="form.location"></span></div>
                        </template>
                        <template x-if="form.model">
                            <div><strong>Model:</strong> <span x-text="form.model"></span></div>
                        </template>
                        <template x-if="form.car_color">
                            <div><strong>Car Color:</strong> <span x-text="form.car_color"></span></div>
                        </template>
                        <template x-if="form.car_inside_color">
                            <div><strong>Interior Color:</strong> <span x-text="form.car_inside_color"></span></div>
                        </template>
                        <template x-if="form.car_documents">
                            <div><strong>Documents:</strong> <span x-text="form.car_documents"></span></div>
                        </template>
                        <template x-if="form.transmission_type">
                            <div><strong>Transmission:</strong> <span x-text="form.transmission_type"></span></div>
                        </template>
                        <div class="flex">
                            <template x-if="form.regular_price">
                                <div><strong>Regular Price:</strong> <span x-text="form.regular_price"></span> &nbsp;
                                </div>
                            </template>
                            <template x-if="form.currency_type">
                                <div> <span x-text="form.currency_type"></span></div>
                            </template>
                        </div>
                        <div class="flex">
                            <template x-if="form.sale_price">
                                <div><strong>Sale Price:</strong> <span x-text="form.sale_price"></span> &nbsp;</div>
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
                        <template x-if="form.description">
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
                    sale_price: '{{ old('sale_price') }}',
                    description: '{{ old('description') }}',
                    is_for_sale: {{ old('is_for_sale') ? 'true' : 'false' }},
                    is_for_rent: {{ old('is_for_rent') ? 'true' : 'false' }},
                    rent_price_per_day: '{{ old('rent_price_per_day') }}',
                    rent_price_per_month: '{{ old('rent_price_per_month') }}',
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

                getLocation() {
                    if (!navigator.geolocation) {
                        Swal.fire('Error', 'Geolocation is not supported by your browser.', 'error');
                        return;
                    }
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.form.location =
                                `${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}`;
                            this.watchProgress();
                        },
                        () => {
                            Swal.fire('Error', 'Unable to retrieve your location.', 'error');
                        }
                    );
                },

                nextStep() {
                    // First sync all Select2 values before validation
                    this.syncSelect2Values();

                    // Small delay to ensure sync is complete
                    this.$nextTick(() => {
                        // Validate current step
                        if (!this.validateStep()) return;

                        if (this.step < 3) {
                            this.step++;
                            this.watchProgress(); // Update progress when moving to next step
                        }
                    });
                },

                validateStep() {
                    let errors = [];

                    if (this.step === 1) {
                        // Debug: Log current form values
                        console.log('Step 1 Validation - Current form values:', {
                            title: this.form.title,
                            year: this.form.year,
                            make: this.form.make,
                            body_type: this.form.body_type,
                            car_condition: this.form.car_condition,
                            VIN_number: this.form.VIN_number
                        });

                        if (!this.form.title || !this.form.title.trim()) errors.push('Title is required.');
                        if (!this.form.year || this.form.year === '') errors.push('Year is required.');
                        if (!this.form.make || this.form.make === '') errors.push('Make is required.');
                        if (!this.form.body_type || this.form.body_type === '') errors.push('Body type is required.');
                        if (!this.form.car_condition || this.form.car_condition === '') errors.push(
                            'Car condition is required.');
                        if (!this.form.VIN_number || !this.form.VIN_number.trim()) errors.push('VIN Number is required.');
                        // Location is optional
                    } else if (this.step === 2) {
                        // Debug: Log step 2 form values
                        console.log('Step 2 Validation - Current form values:', {
                            model: this.form.model,
                            car_color: this.form.car_color,
                            car_inside_color: this.form.car_inside_color,
                            car_documents: this.form.car_documents,
                            transmission_type: this.form.transmission_type,
                            currency_type: this.form.currency_type
                        });

                        if (!this.form.model) errors.push('Model is required.');
                        if (!this.form.car_color) errors.push('Car color is required.');
                        if (!this.form.car_inside_color) errors.push('Car inside color is required.');
                        if (!this.form.car_documents) errors.push('Car documents is required.');
                        if (!this.form.transmission_type) errors.push('Transmission type is required.');
                        if (!this.form.currency_type) errors.push('Currency Type is required.');
                        if (this.form.is_for_sale) {
                            if (!this.form.regular_price || this.form.regular_price <= 0) errors.push(
                                'Regular price must be greater than zero.');
                            if (!this.form.sale_price || this.form.sale_price <= 0) errors.push(
                                'Sale price must be greater than zero.');
                            if (this.form.regular_price && this.form.sale_price &&
                                Number(this.form.sale_price) > Number(this.form.regular_price)) {
                                errors.push('Sale price must be less than or equal to regular price.');
                            }
                        }
                        if (this.form.is_for_rent) {
                            if ((!this.form.rent_price_per_day || Number(this.form.rent_price_per_day) <= 0) && (!this.form
                                    .rent_price_per_month || Number(this.form.rent_price_per_month) <= 0)) {
                                errors.push('Provide rent per day or rent per month.');
                            }
                        }
                    } else if (this.step === 3) {
                        if (this.imageFiles.length < 1) errors.push('At least one image is required.');
                        if (this.imageFiles.length > 11) errors.push('Maximum 11 images allowed.');
                        if (this.videoFiles.length > 2) errors.push('Maximum 2 videos allowed.');
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

                handleImages(event) {
                    const files = Array.from(event.target.files);

                    if (files.length > 11) {
                        Swal.fire('Error', 'You can upload max 11 images.', 'error');
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

                    if (files.length > 2) {
                        Swal.fire('Error', 'You can upload max 2 videos.', 'error');
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
                        sale_price: '',
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
                    // Define all form fields that contribute to progress
                    const requiredFields = [
                        'title', 'year', 'make', 'body_type', 'car_condition', 'VIN_number',
                        'model', 'car_color', 'car_inside_color', 'car_documents', 'transmission_type', 'currency_type'
                    ];

                    const optionalFields = [
                        'location', 'regular_price', 'sale_price', 'description',
                        'rent_price_per_day', 'rent_price_per_month'
                    ];

                    const booleanFields = ['is_for_sale', 'is_for_rent'];

                    let filledFields = 0;
                    // Calculate total possible fields: required + optional + boolean + files
                    let totalFields = requiredFields.length + optionalFields.length + booleanFields.length +
                        2; // +2 for images and videos

                    // Check required fields (12 fields)
                    requiredFields.forEach(field => {
                        if (this.form[field] && this.form[field].toString().trim() !== '') {
                            filledFields++;
                        }
                    });

                    // Check optional fields (6 fields)
                    optionalFields.forEach(field => {
                        if (this.form[field] && this.form[field].toString().trim() !== '') {
                            filledFields++;
                        }
                    });

                    // Check boolean fields individually (2 fields)
                    if (this.form.is_for_sale) {
                        filledFields++;
                    }
                    if (this.form.is_for_rent) {
                        filledFields++;
                    }

                    // Check images (required - at least 1) (1 field)
                    if (this.imageFiles && this.imageFiles.length > 0) {
                        filledFields++;
                    }

                    // Check videos (optional) (1 field)
                    if (this.videoFiles && this.videoFiles.length > 0) {
                        filledFields++;
                    }

                    // Calculate percentage (0-100%)
                    // Total fields: 12 required + 6 optional + 2 boolean + 2 files = 22 fields
                    this.filledFieldsCount = filledFields; // For debugging
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
                'regular_price', 'currency_type', 'sale_price', 'image', 'video'
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
