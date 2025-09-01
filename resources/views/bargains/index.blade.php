@extends('layouts.layout')

@section('content')
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Bargains</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i>
                        </li>
                        <li><span>Bargain List</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {{-- Alert messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="validation-alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid py-3">
        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Search...">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="bargains-table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tenant Name</th>
                        <th>Tenant Father Name</th>
                        <th>Company Name</th>
                        <th>Property Type</th>
                        <th>Property Location</th>
                        <th>Contract Start</th>
                        <th>Contract End</th>
                        <th>Contract Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function formatDate(date) {
            if (!date) return '-';
            const d = new Date(date);
            return d.toLocaleDateString('en-GB'); // DD/MM/YYYY
        }

        function loadData(search = '') {
            $.get("{{ route('bargains.data') }}", {
                search: search
            }, function(res) {
                let html = '';
                res.data.forEach((row, index) => {
                    const statusClass = row.contract_purpose === 'one-time' ? 'bg-danger text-white' :
                        'bg-success text-white';
                    html += `<tr>
                <td>${index + 1}</td>
                <td>${row.tenant_name}</td>
                <td>${row.tenant_father_name}</td>
                <td>${row.contract_company_name}</td>
                <td>${row.contract_purpose}</td>
                <td>${row.contract_location}</td>
                <td>${formatDate(row.contract_from_date)}</td>
                <td>${formatDate(row.contract_to_date)}</td>
                <td>${row.written_contract_number}</td>
                <td><span class="badge ${statusClass}">${row.contract_purpose}</span></td>
                <td class="d-flex justify-content-center gap-1">
                    <button class="btn btn-sm btn-primary edit-btn" data-url="${row.editUrl}" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-url="${row.deleteUrl}" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button class="btn btn-sm btn-warning toggle-btn" data-url="${row.toggleUrl}" title="Toggle Status">
                        <i class="bi bi-toggle-on"></i>
                    </button>
                </td>
            </tr>`;
                });
                $('#bargains-table tbody').html(html);

                // Button actions
                $('.edit-btn').click(function() {
                    window.location.href = $(this).data('url');
                });

                $('.delete-btn').click(function() {
                    const url = $(this).data('url');
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    Swal.fire('Deleted!', res.message, 'success');
                                    loadData($('#search').val());
                                }
                            });
                        }
                    });
                });

                $('.toggle-btn').click(function() {
                    const url = $(this).data('url');
                    $.post(url, {
                        _token: '{{ csrf_token() }}'
                    }, function(res) {
                        Swal.fire('Success', res.message, 'success');
                        loadData($('#search').val());
                    });
                });
            });
        }

        $(document).ready(function() {
            loadData();

            $('#search').on('keyup', function() {
                loadData($(this).val());
            });
        });
    </script>

    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        @media (max-width: 768px) {

            .table td,
            .table th {
                font-size: 0.85rem;
            }
        }
    </style>
@endsection
