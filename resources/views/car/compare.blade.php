@extends('layouts.layout')
@section('title', 'Compare Cars')
@section('content')

<style>
    .compare-top {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px auto;
    }
    .compare-slot {
        width: 250px;
        height: 180px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #f8f9fa;
        cursor: pointer;
        position: relative;
    }
    .compare-slot img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 14px;
        cursor: pointer;
    }
    .compare-table {
        margin-top: 30px;
        overflow-x: auto;
    }
    .compare-table table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    .compare-table th, .compare-table td {
        border: 1px solid #ddd;
        padding: 10px;
    }
    .badge-best { background: #28a745; color: white; padding: 3px 8px; border-radius: 5px; }
    .badge-better { background: #ffc107; color: black; padding: 3px 8px; border-radius: 5px; }
    .badge-normal { background: #6c757d; color: white; padding: 3px 8px; border-radius: 5px; }
</style>

<div class="container">
    <h2 class="text-center mt-4">Compare Cars</h2>

    <!-- Top Compare Slots -->
    <div class="compare-top" id="compare-slots"></div>

    <!-- Comparison Table -->
    <div class="compare-table" id="compare-table"></div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let compareList = JSON.parse(localStorage.getItem('compareList') || '[]');
    const slotsContainer = document.getElementById('compare-slots');
    const tableContainer = document.getElementById('compare-table');

    function updateCompareCount() {
        document.getElementById('compare-count').innerText = compareList.length;
    }

    function removeCar(id) {
        compareList = compareList.filter(c => c.id !== id);
        localStorage.setItem('compareList', JSON.stringify(compareList));
        updateComparePage();
        updateCompareCount();

        Swal.fire({
            icon: 'success',
            title: 'Removed',
            text: 'Car removed from compare list',
            timer: 1500,
            showConfirmButton: false
        });
    }

    function updateComparePage() {
        slotsContainer.innerHTML = "";
        tableContainer.innerHTML = "";

        // --- Render Slots ---
        for (let i = 0; i < 3; i++) {
            if (compareList[i]) {
                let car = compareList[i];
                let slot = document.createElement('div');
                slot.className = "compare-slot";
                slot.innerHTML = `
                    <img src="/storage/${car.images?.[0] || 'images/no-image.png'}" alt="${car.title}">
                    <button class="remove-btn">&times;</button>
                `;
                slot.querySelector('.remove-btn').addEventListener('click', () => removeCar(car.id));
                slotsContainer.appendChild(slot);
            } else {
                let slot = document.createElement('div');
                slot.className = "compare-slot";
                slot.innerHTML = `<span>+ Add Car</span>`;
                slot.addEventListener('click', () => {
                    window.location.href = "{{ route('car.index') }}";
                });
                slotsContainer.appendChild(slot);
            }
        }

        // --- Render Table ---
        if (compareList.length === 0) {
            tableContainer.innerHTML = "<p class='text-center mt-4'>No cars selected. Please add cars to compare.</p>";
            return;
        }

        let headers = ["Feature", ...compareList.map(c => c.title)];
        let rows = [
            ["Price", ...compareList.map(c => "$" + c.sale_price)],
            ["Year", ...compareList.map(c => c.year || "N/A")],
            ["Mileage", ...compareList.map(c => c.mileage || "N/A")],
            ["Engine", ...compareList.map(c => c.engine || "N/A")],
            ["Fuel Type", ...compareList.map(c => c.fuel || "N/A")],
        ];

        let table = "<table><thead><tr>";
        headers.forEach(h => table += `<th>${h}</th>`);
        table += "</tr></thead><tbody>";

        rows.forEach(row => {
            table += "<tr>";
            row.forEach((cell, i) => {
                if (i === 0) {
                    table += `<th>${cell}</th>`;
                } else {
                    table += `<td>${cell}</td>`;
                }
            });
            table += "</tr>";
        });

        // Add Evaluation Row (based on price: lowest = best)
        if (compareList.length > 1) {
            let prices = compareList.map(c => c.sale_price);
            let sorted = [...prices].sort((a,b)=>a-b);
            let evalRow = "<tr><th>Evaluation</th>";
            compareList.forEach(c => {
                if (c.sale_price === sorted[0]) {
                    evalRow += `<td><span class="badge-best">Best</span></td>`;
                } else if (c.sale_price === sorted[sorted.length-1]) {
                    evalRow += `<td><span class="badge-normal">Normal</span></td>`;
                } else {
                    evalRow += `<td><span class="badge-better">Better</span></td>`;
                }
            });
            evalRow += "</tr>";
            table += evalRow;
        }

        table += "</tbody></table>";
        tableContainer.innerHTML = table;
    }

    // Initial Load
    updateComparePage();
    updateCompareCount();
</script>
@endsection
