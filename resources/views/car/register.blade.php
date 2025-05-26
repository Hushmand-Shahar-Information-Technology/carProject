    <!DOCTYPE html>
    <html lang="en" >
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Car Registration</title>

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
    </head>
    <body class="bg-gray-100">
    <div class="container mx-auto py-10" x-data="carForm()" x-init="initSelect2()">
        <div class="bg-white p-6 rounded shadow-md max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h1 class="text-2xl font-bold mb-6">🚗 Car Registration Form</h1>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-300 h-4 rounded mb-6 relative">
            <div class="bg-blue-600 h-4 rounded transition-all duration-300" :style="'width:' + progress + '%'"></div>
            <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-white">
                <span x-text="progress + '%'"></span>
            </div>
            </div>

            <form action="{{ route('car.store') }}" method="post" enctype="multipart/form-data">
                @csrf
            <!-- Step 1 -->
            <div x-show="step === 1" class="space-y-4">
                <div>
                <label class="block font-medium">Title</label>
                <input type="text" x-model="form.title" class="w-full border rounded p-2" placeholder="Title of the car" name="title" />
                </div>

                <div>
                <label class="block font-medium">Year</label>
                <select x-model="form.year" class="w-full border rounded p-2 select2"  name="year">
                    <option value="">Select Year</option>
                    <template x-for="y in years" :key="y">
                    <option :value="y" x-text="y"></option>
                    </template>
                </select>
                </div>

                <div>
                <label class="block font-medium">Make (Company)</label>
                <select x-model="form.make" class="w-full border rounded p-2 select2" name="make">
                    <option value="">Select Make</option>
                    <option value="toyota">Toyota</option>
                    <option value="ford">Ford</option>
                    <option value="bmw">BMW</option>
                    <option value="honda">Honda</option>
                    <option value="marcedes">Mercedes</option>
                </select>
                </div>

                <div>
                <label class="block font-medium">VIN Number</label>
                <input type="text" x-model="form.vin_number" class="w-full border rounded p-2" placeholder="Title of the car" name="VIN_number" />
                </div>

                <div>
                <label class="block font-medium">Location (Live)</label>
                <input type="text" x-model="form.location" class="w-full border rounded p-2" placeholder="Click to get current location" readonly
                        @click="getLocation" name="location" />
                </div>

                <div class="flex justify-end">
                <button type="button" @click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Next →</button>
                </div>
            </div>

            <!-- Step 2 -->
            <div x-show="step === 2" class="space-y-4">
                <div>
                <label class="block font-medium">Model</label>
                <select x-model="form.model" class="w-full border rounded p-2 select2" name="model">
                    <option value="">Select Model</option>
                    <option value="corrola">Corolla</option>
                    <option value="focus">Focus</option>
                    <option value="xs">X5</option>
                    <option value="civic">Civic</option>
                    <option value="c-class">C-Class</option>
                </select>
                </div>

                <div>
                <label class="block font-medium">Color</label>
                <input type="text" x-model="form.color" class="w-full border rounded p-2" placeholder="Color of the car" name="color"/>
                </div>

                <div>
                <label class="block font-medium">Transmission Type</label>
                <select x-model="form.transmission_type" class="w-full border rounded p-2 select2" name="transmission_type">
                    <option value="">Select Transmission</option>
                    <option value="automatic">Automatic</option>
                    <option value="manual">Manual</option>
                </select>
                </div>

                <div class="flex gap-4">
                <div>
                    <label class="block font-medium">Regular Price</label>
                    <input type="number" x-model="form.regular_price" class="w-full border rounded p-2" placeholder="Regular price" min="0" />
                </div>
                <div>
                <label class="block font-medium">currency type</label>
                <select x-model="form.currency_type" class="w-full border p-3 rounded p-2 select2" name="currency_type">
                    <option value="">Select currency</option>
                    <option value="Afn">Afn</option>
                    <option value="$"> $</option>
                    <option value="ERU">ERU</option>
                </select>
                </div>
                </div>

                <div>
                <label class="block font-medium">Sale Price</label>
                <input type="number" x-model="form.sale_price" class="w-full border rounded p-2" placeholder="Sale price" min="0" name="sale_price" />
                </div>

                <div class="flex justify-between mt-4">
                <button type="button" @click="step--, progress=50" class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                <button type="button" @click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded">Next →</button>
                </div>
            </div>

            <!-- Step 3 -->
            <div x-show="step === 3" class="space-y-4">

                <div>
                <label class="block font-medium">Upload Car Images (1–11)</label>
                <input
                    type="file"
                    id="imageInput"
                    @change="handleImages($event)"
                    accept="image/*"
                    multiple
                    class="w-full border rounded p-2" name="images[]"
                />
                </div>

                <div class="flex flex-wrap gap-2">
                <template x-for="(img, index) in imagePreviews" :key="index">
                    <div class="relative w-24 h-24">
                    <img :src="img" class="w-full h-full object-cover rounded border" />
                    <div class="preview-controls">
                        <button
                        type="button"
                        @click="removeImage(index)"
                        class="text-red-600 bg-white px-1 rounded"
                        >
                        ✖
                        </button>

                        <input
                        type="file"
                        class="hidden"
                        :ref="'imageEditInput' + index"
                        @change="replaceImage($event, index)"
                        accept="image/*"
                        />
                    </div>
                    </div>
                </template>
                </div>

                <div>
                <label class="block font-medium">Upload Videos (max 2)</label>
                <input
                    type="file"
                    id="videoInput"
                    @change="handleVideos($event)"
                    accept="video/*"
                    multiple
                    class="w-full border rounded p-2"
                    name="videos[]"
                />
                </div>

                <div class="flex flex-wrap gap-2">
                <template x-for="(video, index) in videoPreviews" :key="index">
                    <div class="relative w-32 h-24">
                    <video :src="video" controls class="w-full h-full object-cover rounded border"></video>
                    <div class="preview-controls">
                        <button
                        type="button"
                        @click="removeVideo(index)"
                        class="text-red-600 bg-white px-1 rounded"
                        >
                        ✖
                        </button>

                        <input
                        type="file"
                        class="hidden"
                        :ref="'videoEditInput' + index"
                        @change="replaceVideo($event, index)"
                        accept="video/*"
                        />
                    </div>
                    </div>
                </template>
                </div>

                <div class="flex justify-between mt-4">
                <button type="button" @click="step--, progress=75" class="bg-gray-400 text-white px-4 py-2 rounded">← Back</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit ✅</button>
                </div>
            </div>
            </form>
        </div>

        <!-- Review column -->
        <div class="bg-gray-50 p-6 rounded border max-h-[600px] overflow-auto">
            <h2 class="text-xl font-semibold mb-4">Review Your Inputs</h2>
            <div class="space-y-3 text-sm">
            <template x-if="form.title"><div><strong>Title:</strong> <span x-text="form.title"></span></div></template>
            <template x-if="form.year"><div><strong>Year:</strong> <span x-text="form.year"></span></div></template>
            <template x-if="form.make"><div><strong>Make:</strong> <span x-text="form.make"></span></div></template>
            <template x-if="form.vin_number"><div><strong>VIN Number:</strong> <span x-text="form.vin_number"></span></div></template>
            <template x-if="form.location"><div><strong>Location:</strong> <span x-text="form.location"></span></div></template>
            <template x-if="form.model"><div><strong>Model:</strong> <span x-text="form.model"></span></div></template>
            <template x-if="form.color"><div><strong>Color:</strong> <span x-text="form.color"></span></div></template>
            <template x-if="form.transmission_type"><div><strong>Transmission:</strong> <span x-text="form.transmission_type"></span></div></template>
            <div class="flex">
                <template x-if="form.regular_price"><div><strong>Regular Price:</strong> <span x-text="form.regular_price"> </span> &nbsp; </div></template>
                <template x-if="form.currency_type"><div> <span x-text="form.currency_type"></span></div></template>
            </div>
            <div class="flex">
                <template x-if="form.sale_price"><div><strong>Sale Price:</strong> <span x-text="form.sale_price"></span> &nbsp;</div></template>
                <template x-if="form.currency_type"><div>  <span x-text="form.currency_type"></span></div></template>
            </div>
            <template x-if="imagePreviews.length">
                <div>
                <strong>Images:</strong>
                <div class="flex flex-wrap gap-2 mt-2">
                    <template x-for="(img, index) in imagePreviews" :key="'revimg'+index">
                    <img :src="img" class="w-16 h-16 object-cover rounded border" />
                    </template>
                </div>
                </div>
            </template>

            <template x-if="videoPreviews.length">
                <div>
                <strong>Videos:</strong>
                <div class="flex flex-wrap gap-2 mt-2">
                    <template x-for="(video, index) in videoPreviews" :key="'revvid'+index">
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
        progress: 33,
        years: Array.from({length: 31}, (_, i) => 1995 + i),

        form: {
            title: '',
            year: '',
            make: '',
            vin_number: '',
            location: '',
            model: '',
            color: '',
            transmission_type: '',
            currency_type: '',
            regular_price: '',
            sale_price: '',
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
                this.form.location = `${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}`;
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
            this.progress = this.step * 33;
            if (this.step === 3) this.progress = 100;
            }
        },

        validateStep() {
            let errors = [];

            if (this.step === 1) {
            if (!this.form.title.trim()) errors.push('Title is required.');
            if (!this.form.year) errors.push('Year is required.');
            if (!this.form.make) errors.push('Make is required.');
            if (!this.form.vin_number.trim()) errors.push('VIN Number is required.');
            if (!this.form.location) errors.push('Location is required.');
            }
            else if (this.step === 2) {
            if (!this.form.model) errors.push('Model is required.');
            if (!this.form.color.trim()) errors.push('Color is required.');
            if (!this.form.transmission_type) errors.push('Transmission type is required.');
            if (!this.form.currency_type) errors.push('Currency Type is required.');
            if (!this.form.regular_price || this.form.regular_price <= 0) errors.push('Regular price must be greater than zero.');
            if (!this.form.sale_price || this.form.sale_price <= 0) errors.push('Sale price must be greater than zero.');
            }
            else if (this.step === 3) {
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

            event.target.value = null;
        },

        removeImage(index) {
            this.imageFiles.splice(index, 1);
            this.imagePreviews.splice(index, 1);
        },

        replaceImage(event, index) {
            const file = event.target.files[0];
            if (!file || !file.type.startsWith('image/')) {
            Swal.fire('Error', 'Invalid image file.', 'error');
            return;
            }

            this.imageFiles.splice(index, 1, file);
            const reader = new FileReader();
            reader.onload = e => {
            this.imagePreviews.splice(index, 1, e.target.result);
            };
            reader.readAsDataURL(file);
            event.target.value = null;
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
        },

        removeVideo(index) {
            this.videoFiles.splice(index, 1);
            this.videoPreviews.splice(index, 1);
        },

        replaceVideo(event, index) {
            const file = event.target.files[0];
            if (!file || !file.type.startsWith('video/')) {
            Swal.fire('Error', 'Invalid video file.', 'error');
            return;
            }

            this.videoFiles.splice(index, 1, file);
            const reader = new FileReader();
            reader.onload = e => {
            this.videoPreviews.splice(index, 1, e.target.result);
            };
            reader.readAsDataURL(file);
            event.target.value = null;
        },

        submitForm() {
            if (!this.validateStep()) return;

            // You can send form data with AJAX or normal submit here
            // For demo, show SweetAlert success message:

            Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your car registration form has been submitted.',
            }).then(() => {
            // Reset form on success
            this.resetForm();
            });
        },

        resetForm() {
            this.step = 1;
            this.progress = 33;

            this.form = {
            title: '',
            year: '',
            make: '',
            location: '',
            model: '',
            color: '',
            transmission_type: '',
            regular_price: '',
            sale_price: '',
            };

            this.imageFiles = [];
            this.imagePreviews = [];

            this.videoFiles = [];
            this.videoPreviews = [];

            // Reset Select2 fields
            $('.select2').val(null).trigger('change');
        },
        };
    }
    </script>
    </body>
    </html>
