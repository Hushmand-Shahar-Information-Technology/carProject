@extends('layouts.layout')
@section('title', 'Compare Cars')
@section('content')

    <style>
        .compare-top {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px auto;
            flex-wrap: wrap;
        }

        .compare-slot {
            width: 250px;
            height: 180px;
            border: 2px dashed #ccc;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: #f1f1f1;
            cursor: pointer;
            position: relative;
            transition: transform 0.2s;
        }

        .compare-slot:hover {
            transform: scale(1.05);
            border-color: #007bff;
        }

        .compare-slot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10;
        }

        .compare-table {
            margin-top: 40px;
            overflow-x: auto;
        }

        .compare-table table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .compare-table th,
        .compare-table td {
            border: 1px solid #ddd;
            padding: 12px 8px;
        }

        .compare-table th {
            background: #007bff;
            color: white;
            font-size: 16px;
        }

        .compare-table td {
            font-size: 15px;
        }

        .badge-best {
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .badge-better {
            background: #ffc107;
            color: black;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .badge-normal {
            background: #6c757d;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            position: relative;
            z-index: 1;
        }

        .car-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
            color: #333;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px;
            border-radius: 5px;
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .loading {
            text-align: center;
            padding: 40px;
            font-size: 18px;
            color: #666;
        }
    </style>

    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Compare Cars</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                        <li><span>Car Compare</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="compare-top" id="compare-slots"></div>
        <div class="compare-table" id="compare-table"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let compareList = [];
        const slotsContainer = document.getElementById('compare-slots');
        const tableContainer = document.getElementById('compare-table');

        function updateNavbarCompareCount() {
            const countElement = document.getElementById('compare-count');
            if (countElement) countElement.innerText = compareList.length;
        }

        function getCompareCars() {
            const stored = localStorage.getItem('compareCars');
            if (!stored) return [];

            try {
                const data = JSON.parse(stored);
                // Check if data has expired (5 minutes)
                if (data.timestamp && (Date.now() - data.timestamp) > 5 * 60 * 1000) {
                    localStorage.removeItem('compareCars');
                    return [];
                }
                return data.cars || [];
            } catch (e) {
                return [];
            }
        }

        function removeCar(id) {
            compareList = compareList.filter(c => c.id != id);

            // Update localStorage
            const stored = localStorage.getItem('compareCars');
            if (stored) {
                try {
                    const data = JSON.parse(stored);
                    data.cars = compareList;
                    localStorage.setItem('compareCars', JSON.stringify(data));
                } catch (e) {
                    console.error('Error updating localStorage:', e);
                }
            }

            renderComparePage();
            updateNavbarCompareCount();

            Swal.fire({
                icon: 'success',
                title: 'Removed',
                text: 'Car removed from compare list',
                timer: 1200,
                showConfirmButton: false
            });
        }

        async function fetchCarDetails(carIds) {
            try {
                const response = await axios.get(`/api/cars/details?ids=${carIds.join(',')}`);
                return response.data;
            } catch (error) {
                console.error('Error fetching car details:', error);
                return [];
            }
        }

        function renderComparePage() {
            slotsContainer.innerHTML = '';
            tableContainer.innerHTML = '';

            // Top 3 slots
            for (let i = 0; i < 3; i++) {
                const slot = document.createElement('div');
                slot.className = 'compare-slot';

                if (compareList[i]) {
                    const car = compareList[i];
                    const imageSrc = car.images && car.images.length > 0 ?
                        `/storage/${car.images[0]}` : '/images/demo.jpg';

                    slot.innerHTML = `
                        <img src="${imageSrc}" alt="${car.title}" class="car-image">
                        <button class="remove-btn">&times;</button>
                        <div class="car-title">${car.title}</div>
                    `;
                    slot.querySelector('.remove-btn').addEventListener('click', () => removeCar(car.id));
                } else {
                    slot.innerHTML = '<span>+ Add Car</span>';
                    slot.addEventListener('click', () => window.location.href = "{{ route('car.index') }}");
                }

                slotsContainer.appendChild(slot);
            }

            if (compareList.length === 0) {
                tableContainer.innerHTML = '<p class="text-center mt-4">No cars selected. Add cars to compare.</p>';
                return;
            }

            // Render comparison table
            const headers = ['Feature', ...compareList.map(c => c.title)];
            const rows = [
                ['Price', ...compareList.map(c => '$' + (c.regular_price || 'N/A'))],
                ['Regular Price', ...compareList.map(c => '$' + (c.regular_price || 'N/A'))],
                ['Year', ...compareList.map(c => c.year || 'N/A')],
                ['Make', ...compareList.map(c => c.make || 'N/A')],
                ['Model', ...compareList.map(c => c.model || 'N/A')],
                ['Body Type', ...compareList.map(c => c.body_type || 'N/A')],
                ['Transmission', ...compareList.map(c => c.transmission_type || 'N/A')],
                ['Color', ...compareList.map(c => c.car_color || 'N/A')],
                ['Inside Color', ...compareList.map(c => c.car_inside_color || 'N/A')],
                ['Condition', ...compareList.map(c => c.car_condition || 'N/A')],
                ['VIN Number', ...compareList.map(c => c.VIN_number || 'N/A')],
                ['Mileage', ...compareList.map(c => c.mileage || 'N/A')],
                ['Engine', ...compareList.map(c => c.engine || 'N/A')],
                ['Fuel Type', ...compareList.map(c => c.fuel_type || 'N/A')]
            ];

            let table = '<table><thead><tr>';
            headers.forEach(h => table += `<th>${h}</th>`);
            table += '</tr></thead><tbody>';

            rows.forEach(row => {
                table += '<tr>';
                row.forEach((cell, i) => table += i === 0 ? `<th>${cell}</th>` : `<td>${cell}</td>`);
                table += '</tr>';
            });

            // Evaluation Row based on Price
            if (compareList.length > 1) {
                const prices = compareList.map(c => c.regular_price).filter(p => p && !isNaN(p));
                if (prices.length > 1) {
                    const sorted = [...prices].sort((a, b) => a - b);
                    let evalRow = '<tr><th>Price Evaluation</th>';
                    compareList.forEach(c => {
                        if (c.regular_price === sorted[0]) {
                            evalRow += `<td><span class="badge-best">Best Value</span></td>`;
                        } else if (c.regular_price === sorted[sorted.length - 1]) {
                            evalRow += `<td><span class="badge-normal">Highest Price</span></td>`;
                        } else {
                            evalRow += `<td><span class="badge-better">Good Value</span></td>`;
                        }
                    });
                    evalRow += '</tr>';
                    table += evalRow;
                }
            }

            table += '</tbody></table>';
            tableContainer.innerHTML = table;
        }

        async function initializeComparePage() {
            const carIds = getCompareCars();

            if (carIds.length === 0) {
                // Don't redirect automatically, just show empty state
                slotsContainer.innerHTML = `
                    <div class="text-center w-100">
                        <h4 class="text-muted">No cars added to compare</h4>
                        <p class="text-muted">Add cars from the car listing page to start comparing</p>
                        <a href="{{ route('car.index') }}" class="btn btn-primary">Go to Car Listing</a>
                    </div>
                `;
                tableContainer.innerHTML = '';
                return;
            }

            // Show loading
            tableContainer.innerHTML = '<div class="loading">Loading car details...</div>';

            // Fetch car details from database
            const cars = await fetchCarDetails(carIds);
            compareList = cars;

            if (cars.length === 0) {
                Swal.fire('Error', 'Failed to load car details', 'error').then(() => {
                    window.location.href = "{{ route('car.index') }}";
                });
                return;
            }

            renderComparePage();
            updateNavbarCompareCount();
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', initializeComparePage);

        // Update navbar count when page loads
        updateNavbarCompareCount();
    </script>

@endsection
