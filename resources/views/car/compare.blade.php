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
    <script>
        let compareList = JSON.parse(localStorage.getItem('compareList') || '[]');
        const slotsContainer = document.getElementById('compare-slots');
        const tableContainer = document.getElementById('compare-table');

        function updateNavbarCompareCount() {
            const countElement = document.getElementById('compare-count');
            if (countElement) countElement.innerText = compareList.length;
        }

        function removeCar(id) {
            compareList = compareList.filter(c => c.id != id);
            localStorage.setItem('compareList', JSON.stringify(compareList));
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

        function renderComparePage() {
            slotsContainer.innerHTML = '';
            tableContainer.innerHTML = '';

            // Top 3 slots
            for (let i = 0; i < 3; i++) {
                const slot = document.createElement('div');
                slot.className = 'compare-slot';

                if (compareList[i]) {
                    const car = compareList[i];
                    slot.innerHTML = `
                    <img src="/storage/${car.images?.[0] || 'images/no-image.png'}" alt="${car.title}">
                    <button class="remove-btn">&times;</button>
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

            // Render table
            const headers = ['Feature', ...compareList.map(c => c.title)];
            const rows = [
                ['Price', ...compareList.map(c => '$' + c.sale_price)],
                ['Year', ...compareList.map(c => c.year || 'N/A')],
                ['Mileage', ...compareList.map(c => c.mileage || 'N/A')],
                ['Engine', ...compareList.map(c => c.engine || 'N/A')],
                ['Fuel Type', ...compareList.map(c => c.fuel || 'N/A')],
                ['Condition', ...compareList.map(c => c.car_condition || 'N/A')]
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
                const prices = compareList.map(c => c.sale_price);
                const sorted = [...prices].sort((a, b) => a - b);
                let evalRow = '<tr><th>Evaluation</th>';
                compareList.forEach(c => {
                    if (c.sale_price === sorted[0]) evalRow += `<td><span class="badge-best">Best</span></td>`;
                    else if (c.sale_price === sorted[sorted.length - 1]) evalRow +=
                        `<td><span class="badge-normal">Normal</span></td>`;
                    else evalRow += `<td><span class="badge-better">Better</span></td>`;
                });
                evalRow += '</tr>';
                table += evalRow;
            }

            table += '</tbody></table>';
            tableContainer.innerHTML = table;
        }

        // Redirect if no cars
        if (compareList.length === 0) {
            Swal.fire('No Cars', 'Please add cars to compare', 'info').then(() => {
                window.location.href = "{{ route('car.index') }}";
            });
        }

        // Clear compare when leaving page
        window.addEventListener('beforeunload', () => localStorage.removeItem('compareList'));

        // Initial render
        renderComparePage();
        updateNavbarCompareCount();
    </script>

@endsection
