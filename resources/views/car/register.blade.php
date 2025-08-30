@extends('layouts.layout')

{{-- @section('title', ['title' => 'Car Registration']) --}}
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

@section('content')
    <div class="r p-auto m-auto"
        style="height: 400px; width: 100%; background-image: url('{{ asset('images/bg/01.jpg') }}'); background-size: cover; background-position:center; background-blend-mode: darken; background-color: rgba(0, 0, 0, 0.5);">
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mx-auto py-10" x-data="carForm()" x-init="initSelect2();
    watchProgress()" x-effect="watchProgress()">
        <div class="bg-white p-6 rounded shadow-md max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6"
            style="box-shadow: 0 0 2px black; margin: 1rem 0;">
            <div>

                <h1 class="text-2xl font-bold mb-6">🚗 Car Registration Form</h1>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-300 h-4 rounded mb-6 relative">
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-300"
                            :style="`width: ${progress}%`">
                        </div>
                    </div>
                    <p class="text-sm text-center text-gray-700" x-text="`${progress}% completed`"></p>

                </div>
                <form action="{{ route('car.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Step 1 -->
                    <div x-show="step === 1" class="space-y-4">
                        <div>
                            <label class="block font-medium ">Title</label>
                            <input type="text" x-model="form.title"
                                class="w-full border rounded p-2 title-input @error('title') border-red-500 @enderror"
                                placeholder="Title of the car" name="title" " />
                                    @error('title')
        <p class="title-error text-red-500 text-sm mt-1"> عنوان برای پوست تان انتخاب کنید</p>
    @enderror

                                </div>

                                <div>
                                <label class="block font-medium">Year</label>
                               <select x-model="form.year" class="w-full border rounded p-2 select2 year-input @error('year') border-red-500 @enderror" name="year">
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
                                <select x-model="form.make" class="w-full border rounded p-2 select2 make-select @error('make') border-red-500 @enderror" name="make">
                                    <option value="">Select Make</option>
                                    <option value="toyota" {{ old('make', $car->make ?? '') == 'toyota' ? 'selected' : '' }}>Toyota</option>
                                    <option value="bmw" {{ old('make', $car->make ?? '') == 'bmw' ? 'selected' : '' }}>BMW</option>
                                    <option value="honda" {{ old('make', $car->make ?? '') == 'honda' ? 'selected' : '' }}>Honda</option>
                                    <option value="marcedes" {{ old('make', $car->make ?? '') == 'marcedes' ? 'selected' : '' }}>Mercedes</option>
                                    <option value="Hyundai" {{ old('make', $car->make ?? '') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                    <option value="Nissan" {{ old('make', $car->make ?? '') == 'Nissan' ? 'selected' : '' }}>Nissan</option>
                                    <option value="Kia" {{ old('make', $car->make ?? '') == 'Kia' ? 'selected' : '' }}>Kia</option>
                                    <option value="ford" {{ old('make', $car->make ?? '') == 'ford' ? 'selected' : '' }}>Ford</option>
                                </select>

                                @error('make')
        <p class="make-error text-red-500 text-sm mt-1"> کمپنی موتر را انتخاب کنید</p>
    @enderror

                                </div>

                                {{-- نوع بادی --}}
                                <div>
                                <label class="block font-medium ">نوع یادی</label>
                                <select x-model="form.body_type" class="w-full border rounded p-2 select2 @error('body_type') border-red-500 @enderror" name="body_type">
                                    <option value="">نوع بادی موتر</option>
                                    <option value="convertible" {{ old('body_type', $car->body_type ?? '') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                                    <option value="coupe" {{ old('body_type', $car->body_type ?? '') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                                    <option value="CUV" {{ old('body_type', $car->body_type ?? '') == 'CUV' ? 'selected' : '' }}>CUV</option>
                                    <option value="micro" {{ old('body_type', $car->body_type ?? '') == 'micro' ? 'selected' : '' }}>Micro</option>
                                    <option value="supercar" {{ old('body_type', $car->body_type ?? '') == 'supercar' ? 'selected' : '' }}>Supercar</option>
                                    <option value="sedan" {{ old('body_type', $car->body_type ?? '') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="pick-up" {{ old('body_type', $car->body_type ?? '') == 'pick-up' ? 'selected' : '' }}>Pick-up</option>
                                    <option value="minivan" {{ old('body_type', $car->body_type ?? '') == 'minivan' ? 'selected' : '' }}>Minivan</option>
                                </select>

                               @error('body_type')
        <p class="body-error text-red-500 text-sm mt-1"> نوع بادی را انتخاب کنید</p>
    @enderror
                                </div>


                                {{-- وضعیت ټکر --}}
                                <div>
                                <label class="block font-medium">وضعیت ټکر</label>
                               <select x-model="form.car_condition" class="w-full border rounded p-2 select2 text-right @error('car_condition') border-red-500 @enderror" name="car_condition">
                                    <option value="">وضعیت موتر</option>
                                    <option value="تصادفی" {{ old('car_condition', $car->car_condition ?? '') == 'تصادفی' ? 'selected' : '' }}>تصادفی</option>
                                    <option value="سالم" {{ old('car_condition', $car->car_condition ?? '') == 'سالم' ? 'selected' : '' }}>سالم</option>
                                    <option value="تصادفی اما تعمیر شده" {{ old('car_condition', $car->car_condition ?? '') == 'تصادفی اما تعمیر شده' ? 'selected' : '' }}>تصادفی اما تعمیر شده</option>
                                </select>

                                @error('caar_condition')
        <p class="car_condition-error text-red-500 text-sm mt-1"> وضعیت موتر را انتخاب کنید</p>
    @enderror
                                </div>

                                <div>
                                <label class="block font-medium">VIN Number</label>
                                <input type="text" x-model="form.vin_number" class="w-full border rounded p-2 @error('VIN_number') border-red-500 @enderror" placeholder="Title of the car" name="VIN_number" />
                                @error('VIN_number')
        <p class="vin_number-error text-red-500 text-sm mt-1"> نمبر شاسی را انتخاب کنید</p>
    @enderror
                                </div>

                                <div>
                                <label class="block font-medium">Location (Live)</label>
                                <input type="text" x-model="form.location" class="w-full border rounded p-2 @error('location') border-red-500  @enderror"  placeholder="Click to get current location" readonly
                                        @click="getLocation" name="location" />
                                @error('location')
        <p class="location-error text-red-500 text-sm mt-1"> موقیعت تان زا انتخاب کنید</p>
    @enderror
                                </div>

                                <div class="flex justify-end">
                                <button type="button" @click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Next →</button>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div x-show="step === 2" class="space-y-4">
                                <div>
                                <label class="block font-medium">Model</label>
                               <select x-model="form.model" class="w-full border rounded p-2 select2 @error('model') border-red-500 @enderror" name="model">
                                    <option value="">Select Model</option>
                                    <option value="corrola" {{ old('model', $car->model ?? '') == 'corrola' ? 'selected' : '' }}>Corolla</option>
                                    <option value="focus" {{ old('model', $car->model ?? '') == 'focus' ? 'selected' : '' }}>Focus</option>
                                    <option value="xs" {{ old('model', $car->model ?? '') == 'xs' ? 'selected' : '' }}>X5</option>
                                    <option value="civic" {{ old('model', $car->model ?? '') == 'civic' ? 'selected' : '' }}>Civic</option>
                                    <option value="c-class" {{ old('model', $car->model ?? '') == 'c-class' ? 'selected' : '' }}>C-Class</option>
                                </select>

                                @error('model')
        <p class="model-error text-red-500 text-sm mt-1">  مودل موتر را انتخاب کنید</p>
    @enderror
                                </div>

                                {{-- رنګ باډی موتر --}}
                               <div>
                                    <label class="block font-medium">Car Body Color</label>
                                    <select x-model="form.car_color" class="w-full border rounded p-2 select2 text-right @error('car_color') border-red-500 @enderror" name="car_color">
                                        <option value="">رنگ بدنه خودرو را انتخاب کنید</option>
                                        <option value="black" {{ old('car_color', $car->car_color ?? '') == 'black' ? 'selected' : '' }}>سیاه</option>
                                        <option value="white" {{ old('car_color', $car->car_color ?? '') == 'white' ? 'selected' : '' }}>سفید</option>
                                        <option value="gray" {{ old('car_color', $car->car_color ?? '') == 'gray' ? 'selected' : '' }}>خاکستری</option>
                                        <option value="silver" {{ old('car_color', $car->car_color ?? '') == 'silver' ? 'selected' : '' }}>نقره‌ای</option>
                                        <option value="navy" {{ old('car_color', $car->car_color ?? '') == 'navy' ? 'selected' : '' }}>سرمه‌ای</option>
                                        <option value="blue" {{ old('car_color', $car->car_color ?? '') == 'blue' ? 'selected' : '' }}>آبی</option>
                                        <option value="gold" {{ old('car_color', $car->car_color ?? '') == 'gold' ? 'selected' : '' }}>طلایی</option>
                                        <option value="yellow" {{ old('car_color', $car->car_color ?? '') == 'yellow' ? 'selected' : '' }}>زرد</option>
                                        <option value="red" {{ old('car_color', $car->car_color ?? '') == 'red' ? 'selected' : '' }}>قرمز</option>
                                        <option value="green" {{ old('car_color', $car->car_color ?? '') == 'green' ? 'selected' : '' }}>سبز</option>
                                        <option value="brown" {{ old('car_color', $car->car_color ?? '') == 'brown' ? 'selected' : '' }}>قهوه‌ای</option>
                                        <option value="chestnut" {{ old('car_color', $car->car_color ?? '') == 'chestnut' ? 'selected' : '' }}>قهوه‌ای سوخته</option>
                                        <option value="orange" {{ old('car_color', $car->car_color ?? '') == 'orange' ? 'selected' : '' }}>نارنجی</option>
                                        <option value="purple" {{ old('car_color', $car->car_color ?? '') == 'purple' ? 'selected' : '' }}>بنفش</option>
                                        <option value="coral" {{ old('car_color', $car->car_color ?? '') == 'coral' ? 'selected' : '' }}>مرجانی</option>
                                        <option value="ruby" {{ old('car_color', $car->car_color ?? '') == 'ruby' ? 'selected' : '' }}>یاقوتی</option>
                                        <option value="sky_blue" {{ old('car_color', $car->car_color ?? '') == 'sky_blue' ? 'selected' : '' }}>آبی آسمانی</option>
                                        <option value="olive" {{ old('car_color', $car->car_color ?? '') == 'olive' ? 'selected' : '' }}>زیتونی</option>
                                        <option value="turquoise" {{ old('car_color', $car->car_color ?? '') == 'turquoise' ? 'selected' : '' }}>فیروزه‌ای</option>
                                        <option value="ice" {{ old('car_color', $car->car_color ?? '') == 'ice' ? 'selected' : '' }}>یخی</option>
                                    </select>

                                    @error('car_color')
        <p class="car_color-error text-red-500 text-sm mt-1"> رنګ باډی موتر را انتخاب کنید</p>
    @enderror
                                </div>


                                {{-- رنک داخلي موتر --}}

                                <div>
                                    <label class="block font-medium">رنګ داخلي موتر</label>
                                    <select x-model="form.car_inside_color" class="w-full border rounded p-2 select2 text-right @error('car_inside_color') border-red-500 @enderror" name="car_inside_color">
                                        <option value="">رنګ بادی موتر را انتخاب کنید</option>
                                        <option value="سیاه">سیاه</option>
                                        <option value="سفید">سفید</option>
                                        <option value="خاکستری">خاکستری</option>
                                        <option value="نقره‌ای">نقره‌ای</option>
                                        <option value="سرمه‌ای">سرمه‌ای</option>
                                        <option value="آبی">آبی</option>
                                        <option value="زر">زر</option>
                                        <option value="زرد">زرد</option>
                                        <option value="قرمز">قرمز</option>
                                        <option value="سبز">سبز</option>
                                        <option value="قهوه‌ای">قهوه‌ای</option>
                                        <option value="خرمایی">خرمایی</option>
                                        <option value="نارنجی">نارنجی</option>
                                        <option value="بنفش">بنفش</option>
                                        <option value="مرجانی">مرجانی</option>
                                        <option value="یاقوتی">یاقوتی</option>
                                        <option value="آبی آسمانی">آبی آسمانی</option>
                                        <option value="زیتونی">زیتونی</option>
                                        <option value="فیروزه‌ای">فیروزه‌ای</option>
                                        <option value="یخی">یخی</option>
                                    </select>
                                    @error('car_inside_color')
        <p class="car_inside_solor-error text-red-500 text-sm mt-1"> رنګ داخلي موتر را انتخاب کنید</p>
    @enderror
                                </div>


                                {{-- اسناد موتر  --}}

                                <div>
                                    <label class="block font-medium">اسناد موتر</label>
                                    <select x-model="form.car_documents"
                                        name="car_documents"
                                        class="w-full border rounded p-2 select2 text-right @error('car_documents') border-red-500 @enderror">
                                    <option value="">نوع سند موتر را انتخاب کنید</option>
                                    <option value="سند گمرک">سند گمرک</option>
                                    <option value="سند ثبت موتر">سند ثبت موتر</option>
                                    <option value="سند مالکیت">سند مالکیت</option>
                                    <option value="سند ترانسپورت">سند ترانسپورت</option>
                                    <option value="سند بیمه">سند بیمه</option>
                                    <option value="سند فابریکه">سند فابریکه</option>
                                    <option value="سند نمبر پلیت">سند نمبر پلیت</option>
                                    <option value="سند انتقال ملکیت">سند انتقال ملکیت</option>
                                    <option value="سند پاسپورت موتر">سند پاسپورت موتر</option>
                                    <option value="سند تخنیکی معاینه">سند تخنیکی معاینه</option>
                                    <option value="سند تصدیق ترانزیت">سند تصدیق ترانزیت</option>
                                    <option value="سند اجازه تردد">سند اجازه تردد</option>
                                    <option value="سند تصدیق گمرک قبلی">سند تصدیق گمرک قبلی</option>
                                    <option value="سند تایید انجین">سند تایید انجین</option>
                                    <option value="سند تایید شاسی">سند تایید شاسی</option>
                                    <option value="سند ترافیکی">سند ترافیکی</option>
                                    <option value="سند موقت">سند موقت</option>
                                    <option value="سند نمبر انجن">سند نمبر انجن</option>
                                    <option value="سند نمبر شاسی">سند نمبر شاسی</option>
                                    <option value="سند نمبرگذاری">سند نمبرگذاری</option>
                                </select>

                                    @error('car_documents')
        <p class="car_documents-error text-red-500 text-sm mt-1"> سند موتر را انتخاب کنید</p>
    @enderror
                                </div>



                                <div>
                                <label class="block font-medium">Transmission Type</label>
                                <select x-model="form.transmission_type" class="w-full border rounded p-2 select2 @error('transmission_type') border-red-500 @enderror" name="transmission_type">
                                    <option value="">Select Transmission</option>
                                    <option value="automatic">Automatic</option>
                                    <option value="manual">Manual</option>
                                </select>
                                @error('transmission_type')
        <p class="transmission_type-error text-red-500 text-sm mt-1"> نوع ترانسپورت را انتخاب کنید</p>
    @enderror
                                </div>

                                <div class="flex gap-4">
                                    <!-- Regular Price -->
                                    <div class="flex-1">
                                        <label class="block font-medium">Regular Price</label>
                                        <input type="number" x-model="form.regular_price" class="w-full border rounded p-2 @error('regular_price') border-red-500  @enderror" name="regular_price"
                                               @input="watchProgress()"
                                               x-bind:class="{ 'border-red-500': form.regular_price <= 0 && step === 2 }"
                                               x-bind:placeholder="form.currency_type ? `Regular price (${form.currency_type})` :
                                                   'Regular price'"
                                               @error('regular_price') border-red-500 @enderror"
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
                                <option value="Afn">Afn</option>
                                <option value="$">$</option>
                                <option value="ERU">ERU</option>
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
                            placeholder="Sale price" min="0" name="sale_price" />
                        @error('sale_price')
                            <p class="sale_price-error text-red-500 text-sm mt-1"> Sale price is required</p>
                        @enderror
                    </div>


                    <div class="flex justify-between mt-4">
                        <button type="button" @click="step--, progress=50"
                            class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                        <button type="button" @click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded">Next
                            →</button>
                    </div>
            </div>

            <!-- Step 3 -->
            <div x-show="step === 3" class="space-y-4">

                <div>
                    <label class="block font-medium">Upload Car Images (1–11)</label>


                    <input type="file" name="images[]" id="imageInput" multiple @change="handleImages($event)">

                    @error('images')
                        <p class="image-error text-red-500 text-sm mt-1"> خدآقل یک عکس باید آبلوډ شود</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-2">
                    <template x-for="(img, index) in imagePreviews" :key="index">
                        <div class="relative w-24 h-24">
                            <img :src="img" class="w-full h-full object-cover rounded border" />
                            <div class="preview-controls">
                                <button type="button" @click="removeImage(index)"
                                    class="text-red-600 bg-white px-1 rounded">
                                    ✖
                                </button>

                                <input type="file" class="hidden" :ref="'imageEditInput' + index"
                                    @change="replaceImage($event, index)" accept="image/*" />
                            </div>
                        </div>
                    </template>
                </div>

                <div>
                    <label class="block font-medium">Upload Videos (max 2)</label>
                    <input type="file" id="videoInput" @change="handleVideos($event)" accept="video/*" multiple
                        class="w-full border rounded p- @error('videos') border-red-500  @enderror" name="videos[]"
                        x-model="form.videos" />
                    @error('videos')
                        <p class="video-error text-red-500 text-sm mt-1"> خدآقل یک ویدیو باید آبلوډ شود</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-2">
                    <template x-for="(video, index) in videoPreviews" :key="index">
                        <div class="relative w-32 h-24">
                            <video :src="video" controls
                                class="w-full h-full object-cover rounded border"></video>
                            <div class="preview-controls">
                                <button type="button" @click="removeVideo(index)"
                                    class="text-red-600 bg-white px-1 rounded">
                                    ✖
                                </button>

                                <input type="file" class="hidden" :ref="'videoEditInput' + index"
                                    @change="replaceVideo($event, index)" accept="video/*" />
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" @click="step--, progress=75"
                        class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit ✅</button>
                </div>
            </div>
            </form>
        </div>

        <!-- Review column -->
        <div class="bg-gray-50 p-6 rounded border max-h-[600px] overflow-auto">
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
                    <div><strong>body_type:</strong> <span x-text="form.body_type"></span></div>
                </template>
                <template x-if="form.car_condition">
                    <div><strong>car_condition:</strong> <span x-text="form.car_condition"></span></div>
                </template>
                <template x-if="form.vin_number">
                    <div><strong>VIN Number:</strong> <span x-text="form.vin_number"></span></div>
                </template>
                <template x-if="form.location">
                    <div><strong>Location:</strong> <span x-text="form.location"></span></div>
                </template>
                <template x-if="form.model">
                    <div><strong>Model:</strong> <span x-text="form.model"></span></div>
                </template>
                <template x-if="form.car_color">
                    <div><strong>car_color:</strong> <span x-text="form.car_color"></span></div>
                </template>
                <template x-if="form.car_inside_color">
                    <div><strong>car_inside_color:</strong> <span x-text="form.car_inside_color"></span></div>
                </template>
                <template x-if="form.car_documents">
                    <div><strong>car_documents:</strong> <span x-text="form.car_documents"></span></div>
                </template>
                <template x-if="form.transmission_type">
                    <div><strong>Transmission:</strong> <span x-text="form.transmission_type"></span></div>
                </template>
                <div class="flex">
                    <template x-if="form.regular_price">
                        <div><strong>Regular Price:</strong> <span x-text="form.regular_price"> </span> &nbsp; </div>
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

    <script>
        function carForm() {
            return {
                step: 1,
                progress: 0,
                years: Array.from({
                    length: 31
                }, (_, i) => 1995 + i),

                errors: {},

                form: {
                    title: '{{ old('title') }}',
                    year: '{{ old('year', $car->year ?? '') }}',
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
                },


                imagePreviews: [],
                imageFiles: [],

                videoPreviews: [],
                videoFiles: [],


                initSelect2() {
                    // Initialize Select2 for all selects with class .select2
                    const selects = document.querySelectorAll('.select2');
                    selects.forEach((select) => {
                        $(select).select2().on('change', (e) => {
                            const name = select.getAttribute('x-model').replace('form.', '');
                            this.form[name] = $(select).val();
                        });
                    });
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
                        },
                        () => {
                            Swal.fire('Error', 'Unable to retrieve your location.', 'error');
                        }
                    );
                },

                nextStep() {
                    // Validate current step
                    if (!this.validateStep()) return;

                    if (this.step < 3) {
                        this.step++;
                        // this.progress = this.step * 33;
                        // if (this.step === 3) this.progress = 100;
                    }
                },

                validateStep() {
                    let errors = [];

                    if (this.step === 1) {
                        if (!this.form.title.trim()) errors.push('Title is required.');
                        if (!this.form.year) errors.push('Year is required.');
                        if (!this.form.make) errors.push('Make is required.');
                        if (!this.form.body_type) errors.push('Body type is required.');
                        if (!this.form.car_condition) errors.push('Car condition is required.');
                        if (!this.form.VIN_number.trim()) errors.push('VIN Number is required.');
                        if (!this.form.location) errors.push('Location is required.');
                    } else if (this.step === 2) {
                        if (!this.form.model) errors.push('Model is required.');
                        if (!this.form.car_color) errors.push('Car color is required.');
                        if (!this.form.car_inside_color) errors.push('Car inside color is required.');
                        if (!this.form.transmission_type) errors.push('Transmission type is required.');
                        if (!this.form.currency_type) errors.push('Currency Type is required.');
                        if (!this.form.regular_price || this.form.regular_price <= 0) errors.push(
                            'Regular price must be greater than zero.');
                        if (!this.form.sale_price || this.form.sale_price <= 0) errors.push(
                            'Sale price must be greater than zero.');
                        if (this.form.regular_price < this.form.sale_price) errors.push(
                            'Sale price must be less than or equal to regular price.');
                    } else if (this.step === 3) {
                        if (this.imageFiles.length < 1) errors.push('At least one image is required.');
                        if (this.imageFiles.length > 11) errors.push('Maximum 11 images allowed.');
                        if (this.videoFiles.length > 2) errors.push('Maximum 2 videos allowed.');
                    }

                    if (errors.length > 0) {
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
                    const totalImages = this.imageFiles.length + files.length;

                    if (totalImages > 11) {
                        Swal.fire('Error', 'You can upload max 11 images.', 'error');
                        return;
                    }

                    files.forEach(file => {
                        if (!file.type.startsWith('image/')) return;

                        this.imageFiles.push(file);
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.imagePreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });

                    // event.target.value = null;
                    this.watchProgress(); // Track image update
                },


                removeImage(index) {
                    this.imageFiles.splice(index, 1);
                    this.imagePreviews.splice(index, 1);
                },



                handleVideos(event) {
                    const files = Array.from(event.target.files);
                    const totalVideos = this.videoFiles.length + files.length;

                    if (totalVideos > 2) {
                        Swal.fire('Error', 'You can upload max 2 videos.', 'error');
                        return;
                    }

                    files.forEach(file => {
                        if (!file.type.startsWith('video/')) return;

                        this.videoFiles.push(file);
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.videoPreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });

                    event.target.value = null;
                    this.watchProgress(); // Track video update
                },

                removeVideo(index) {
                    this.videoFiles.splice(index, 1);
                    this.videoPreviews.splice(index, 1);
                },
                clearError(field) {
                    delete this.errors[field];
                },

                submitForm() {
                    if (!this.validateStep()) return;

                    const formData = new FormData();

                    // Append form fields
                    Object.entries(this.form).forEach(([key, value]) => {
                        formData.append(key, value);
                    });

                    // Append images
                    this.imageFiles.forEach(file => {
                        formData.append('images[]', file);
                    });

                    // Append videos
                    this.videoFiles.forEach(file => {
                        formData.append('videos[]', file);
                    });

                    // Debug: Log what's being sent
                    console.log('Form data being sent:', this.form);
                    console.log('Image files:', this.imageFiles);
                    console.log('Video files:', this.videoFiles);

                    axios.post('/car/store', formData)
                        .then(response => {
                            console.log('Success response:', response);
                            Swal.fire('موفقانه', response.data.message, 'success');
                            this.resetForm();
                        })
                        .catch(error => {
                            console.error('Error response:', error);
                            if (error.response && error.response.status === 422) {
                                this.errors = error.response.data.errors;
                                console.log('Validation errors:', this.errors);
                                Swal.fire('خطا', 'لطفاً فورم را درست خانه پری کنید.', 'error');
                            } else {
                                Swal.fire('خطا', 'An error occurred while submitting the form.', 'error');
                            }
                        });
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
                        },




                        this.imageFiles = [];
                    this.imagePreviews = [];

                    this.videoFiles = [];
                    this.videoPreviews = [];
                    this.errors = {};


                    // Reset Select2 fields
                    $('.select2').val(null).trigger('change');
                },

                watchProgress() {
                    const totalFields = 17;
                    let filledFields = 0;

                    // Text/select/number fields (15)
                    const fields = [
                        this.form.title,
                        this.form.year,
                        this.form.make,
                        this.form.body_type,
                        this.form.car_condition,
                        this.form.car_color,
                        this.form.car_documents,
                        this.form.car_inside_color,
                        this.form.vin_number,
                        this.form.location,
                        this.form.model,
                        this.form.transmission_type,
                        this.form.currency_type,
                        this.form.regular_price,
                        this.form.sale_price
                    ];

                    fields.forEach(value => {
                        if (value !== '' && value !== null && value !== undefined) {
                            filledFields++;
                        }
                    });

                    // Image files (1 point if at least 1 image)
                    if (this.imageFiles.length > 0) filledFields++;

                    // Video files (1 point if at least 1 video)
                    if (this.videoFiles.length > 0) filledFields++;

                    // Calculate percentage
                    if (filledFields > totalFields) filledFields = totalFields;
                    this.progress = Math.floor((filledFields / totalFields) * 100);
                }
            };
        }

        document.addEventListener("DOMContentLoaded", () => {
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
