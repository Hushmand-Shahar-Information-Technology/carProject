@extends('layouts.layout')
@section('title', 'Promotions')
@section('content')
    <section class="inner-intro bg-6 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Promoted Cars & Bargains</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Home</a> <i
                                class="fa fa-angle-double-right"></i>
                        </li>
                        <li><span>Promoted</span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container py-4">
        <h2 class="mb-3">Promotions</h2>
        <div class="bg-white rounded shadow p-3">
            <ul class="nav nav-tabs" id="promoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="cars-tab" data-bs-toggle="tab" data-bs-target="#cars"
                        type="button" role="tab">Cars</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bargains-tab" data-bs-toggle="tab" data-bs-target="#bargains"
                        type="button" role="tab">Bargains</button>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="cars" role="tabpanel">
                    <div class="input-group mb-3" style="max-width: 520px;">
                        <span class="input-group-text bg-white border-2" style="border-color:#db2d2e;color:#db2d2e"><i
                                class="fa fa-search"></i></span>
                        <input type="text" id="cars-q" class="form-control border-2"
                            placeholder="Search promoted cars..." style="border-color:#db2d2e;">
                    </div>
                    <div id="cars-empty" class="text-muted small d-none">No active car promotions.</div>
                    <div id="cars-list" class="row g-3"></div>
                </div>
                <div class="tab-pane fade" id="bargains" role="tabpanel">
                    <div class="input-group mb-3" style="max-width: 520px;">
                        <span class="input-group-text bg-white border-2" style="border-color:#db2d2e;color:#db2d2e"><i
                                class="fa fa-search"></i></span>
                        <input type="text" id="bargains-q" class="form-control border-2"
                            placeholder="Search promoted bargains..." style="border-color:#db2d2e;">
                    </div>
                    <div id="bargains-empty" class="text-muted small d-none">No active bargain promotions.</div>
                    <div id="bargains-list" class="row g-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toLocalDateTimeString(dt) {
            try {
                if (!dt) return '—';
                const d = new Date(dt);
                if (isNaN(d)) return dt;
                return d.toLocaleString(undefined, {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            } catch (_) {
                return dt || '—';
            }
        }

        function renderItems(type, data) {
            const container = document.getElementById(type + '-list');
            const empty = document.getElementById(type + '-empty');
            container.innerHTML = '';
            if (!data || data.length === 0) {
                if (empty) empty.classList.remove('d-none');
                return;
            }
            if (empty) empty.classList.add('d-none');
            const showUrlBaseCar = `{{ url('car/show') }}`;
            const showUrlBaseBargain = `{{ url('bargains/show') }}`;
            data.forEach(item => {
                const promo = item; // promotion
                const p = promo.promotable;
                if (!p) return;
                const card = document.createElement('div');
                card.className = 'col-md-4';
                const isCar = type === 'cars';
                const title = isCar ? (p?.title || p?.model || 'Car') : (p?.name || p?.username || 'Bargain');
                const image = isCar ? (Array.isArray(p?.images) && p.images.length ? `/storage/${p.images[0]}` :
                    '{{ asset('images/demo.jpg') }}') : (p?.profile_image ?
                    `{{ asset('storage') }}/${p.profile_image}` :
                    'https://via.placeholder.com/400x250?text=No+Image');
                const showUrl = isCar ? `${showUrlBaseCar}/${p.id}` : `${showUrlBaseBargain}/${p.id}`;
                const endsAtText = toLocalDateTimeString(promo.ends_at_iso || promo.ends_at);
                card.innerHTML = `
        <div class="card h-100 shadow-sm">
          <a href="${showUrl}" class="text-decoration-none text-dark">
            <img src="${image}" alt="${title}" class="card-img-top" style="object-fit:cover;height:180px;">
          </a>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title mb-0" style="font-size:1rem;">${title}</h5>
              <span class="badge bg-success">Active</span>
            </div>
            <p class="card-text small mb-2">Ends: ${endsAtText} <span class="text-danger fw-bold small" data-countdown="${promo.ends_at_iso || promo.ends_at}"></span></p>
            <div class="d-flex gap-2">
              <a href="${showUrl}" class="btn btn-sm btn-outline-primary">Open</a>
              <button class="btn btn-sm btn-outline-danger" onclick="unpromote('${isCar?'car':'bargain'}', ${p.id})">Unpromote</button>
            </div>
          </div>
        </div>`;
                container.appendChild(card);
            });
        }

        function load(type, q = '') {
            const params = new URLSearchParams();
            params.set('type', type === 'cars' ? 'car' : 'bargain');
            if (q) params.set('q', q);
            axios.get(`{{ route('promotions.list') }}?${params.toString()}`).then(res => {
                renderItems(type, res.data);
            }).catch(() => {
                renderItems(type, []);
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
                    // Immediately reload list and show promote modal
                    const tabType = type === 'car' ? 'cars' : 'bargains';
                    load(tabType);
                    setTimeout(() => {
                        Swal.fire({
                            title: `Promote this ${type}?`,
                            input: 'number',
                            inputLabel: 'How many days?',
                            inputAttributes: {
                                min: 1,
                                max: 365
                            },
                            inputValue: 7,
                            showCancelButton: true,
                            confirmButtonText: 'Promote'
                        }).then(result => {
                            if (!result.isConfirmed) return;
                            const days = parseInt(result.value, 10);
                            if (!days || days < 1) return;
                            axios.post(`{{ route('promotions.promote') }}`, {
                                    type,
                                    id,
                                    days
                                })
                                .then(() => load(tabType));
                        });
                    }, 200);
                }).catch(() => Swal.fire('Error', 'Failed to unpromote', 'error'));
            });
        }

        function debounce(fn, delay = 250) {
            let t;
            return (...args) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...args), delay);
            };
        }
        document.addEventListener('DOMContentLoaded', () => {
            // Preload both tabs so switching doesn't flash empty
            load('cars', document.getElementById('cars-q').value.trim());
            load('bargains', document.getElementById('bargains-q').value.trim());
            const carsInput = document.getElementById('cars-q');
            const bargainsInput = document.getElementById('bargains-q');
            const carsHandler = debounce((e) => load('cars', e.target.value.trim()), 300);
            const bargainsHandler = debounce((e) => load('bargains', e.target.value.trim()), 300);
            carsInput.addEventListener('input', carsHandler);
            bargainsInput.addEventListener('input', bargainsHandler);
            // Live countdowns on cards
            function startCardCountdowns() {
                document.querySelectorAll('[data-countdown]')?.forEach(el => {
                    const iso = el.getAttribute('data-countdown');
                    if (!iso) return;
                    const endsAt = new Date(iso);
                    if (isNaN(endsAt)) return;
                    const timer = setInterval(() => {
                        const now = new Date();
                        let diff = Math.max(0, endsAt - now);
                        if (diff <= 0) {
                            el.textContent = ' (Expired)';
                            clearInterval(timer);
                            return;
                        }
                        const second = 1000;
                        const minute = 60 * second;
                        const hour = 60 * minute;
                        const day = 24 * hour;
                        const month = 30 * day;
                        const year = 365 * day;
                        const years = Math.floor(diff / year);
                        diff %= year;
                        const months = Math.floor(diff / month);
                        diff %= month;
                        const days = Math.floor(diff / day);
                        diff %= day;
                        const hours = Math.floor(diff / hour);
                        diff %= hour;
                        const minutes = Math.floor(diff / minute);
                        diff %= minute;
                        const seconds = Math.floor(diff / second);
                        el.textContent =
                            ` (${years}Y ${months}M ${days}D ${hours}hr:${minutes}min:${seconds}sec)`;
                    }, 1000);
                });
            }
            // Re-run after each load when DOM updates
            const origRender = renderItems;
            renderItems = (type, data) => {
                origRender(type, data);
                // Show only the active tab's content
                const activeId = document.querySelector('.tab-pane.active.show')?.id;
                document.getElementById('cars-empty')?.classList.toggle('d-none', !(activeId === 'cars' &&
                    document.getElementById('cars-list')?.children.length === 0));
                document.getElementById('bargains-empty')?.classList.toggle('d-none', !(activeId ===
                    'bargains' && document.getElementById('bargains-list')?.children.length === 0));
                startCardCountdowns();
            };
            startCardCountdowns();

            // Ensure tab switches don't hide data: show relevant list without flashing empty
            const tabs = document.getElementById('promoTabs');
            if (tabs) {
                tabs.addEventListener('shown.bs.tab', (ev) => {
                    const target = ev.target?.getAttribute('data-bs-target');
                    if (target === '#cars') {
                        document.getElementById('cars').classList.add('show', 'active');
                        document.getElementById('bargains').classList.remove('show', 'active');
                        if (!document.getElementById('cars-list').children.length) {
                            load('cars', document.getElementById('cars-q').value.trim());
                        }
                    } else if (target === '#bargains') {
                        document.getElementById('bargains').classList.add('show', 'active');
                        document.getElementById('cars').classList.remove('show', 'active');
                        if (!document.getElementById('bargains-list').children.length) {
                            load('bargains', document.getElementById('bargains-q').value.trim());
                        }
                    }
                });
            }
        });
    </script>
@endsection
