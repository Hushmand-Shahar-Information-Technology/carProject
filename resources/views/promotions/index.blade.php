@extends('layouts.layout')
@section('title', 'Promotions')
@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Promotions</h2>
        <div class="bg-white rounded shadow p-3">
            <ul class="nav nav-tabs" id="promoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="cars-tab" data-bs-toggle="tab" data-bs-target="#cars" type="button"
                        role="tab">Cars</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bargains-tab" data-bs-toggle="tab" data-bs-target="#bargains"
                        type="button" role="tab">Bargains</button>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="cars" role="tabpanel">
                    <div id="cars-list" class="row g-3"></div>
                </div>
                <div class="tab-pane fade" id="bargains" role="tabpanel">
                    <div id="bargains-list" class="row g-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function renderItems(type, data) {
            const container = document.getElementById(type + '-list');
            container.innerHTML = '';
            data.forEach(item => {
                const promo = item; // promotion
                const p = promo.promotable;
                const card = document.createElement('div');
                card.className = 'col-md-4';
                card.innerHTML = `
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <h5 class="card-title">${type==='cars' ? (p?.title || p?.model || 'Car') : (p?.name || p?.username || 'Bargain')}</h5>
              <span class="badge bg-success">Active</span>
            </div>
            <p class="card-text small mb-1">Ends: ${promo.ends_at ?? '—'}</p>
            <button class="btn btn-sm btn-outline-danger" onclick="unpromote('${type==='cars'?'car':'bargain'}', ${p.id})">Unpromote</button>
          </div>
        </div>`;
                container.appendChild(card);
            });
        }

        function load(type) {
            axios.get(`{{ route('promotions.list') }}?type=${type==='cars'?'car':'bargain'}`).then(res => {
                renderItems(type, res.data);
            });
        }

        function unpromote(type, id) {
            Swal.fire({
                title: 'Unpromote?',
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if (!r.isConfirmed) return;
                axios.post(`{{ route('promotions.unpromote') }}`, {
                    type,
                    id
                }).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Unpromoted',
                        timer: 1200,
                        showConfirmButton: false
                    });
                    load(type === 'car' ? 'cars' : 'bargains');
                }).catch(() => Swal.fire('Error', 'Failed to unpromote', 'error'));
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            load('cars');
            document.getElementById('cars-tab').addEventListener('click', () => load('cars'));
            document.getElementById('bargains-tab').addEventListener('click', () => load('bargains'));
        });
    </script>
@endsection
