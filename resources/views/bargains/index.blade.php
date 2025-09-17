@extends('layouts.layout')

@section('content')
    <section class="inner-intro bg-1 bg-overlay-black-70">
        <div class="container">
            <div class="row text-center intro-title">
                <div class="col-md-6 text-md-start d-inline-block">
                    <h1 class="text-white">Bargain List</h1>
                </div>
                <div class="col-md-6 text-md-end float-end">
                    <ul class="page-breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
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
        <div class="row mb-3">
            <div class="col-md-8">
                <input type="text" id="search" class="form-control" placeholder="Search bargains...">
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('bargains.create') }}" class="btn btn-primary" id="add-bargain-btn">
                    <i class="bi bi-plus-circle me-2"></i>Add New Bargain
                </a>
            </div>
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
                        <th>Contract Status</th>
                        <th>Registration Status</th>
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
        // Function to check if we're in bargain mode and show alert for bargain registration
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on the bargain registration page link
            const addBargainBtn = document.getElementById('add-bargain-btn');

            if (addBargainBtn) {
                addBargainBtn.addEventListener('click', function(e) {
                    // Check if we're in bargain mode by looking at localStorage or URL parameters
                    const currentProfileMode = localStorage.getItem('currentProfileMode');
                    const urlParams = new URLSearchParams(window.location.search);
                    const bargainId = urlParams.get('bargain_id');

                    // If in bargain mode, show SweetAlert
                    if (currentProfileMode === 'bargain' || bargainId) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Switch to User Profile?',
                            text: 'You are currently in bargain mode. To register a new bargain, please switch to user profile mode first.',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Switch to User Profile',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to user profile mode
                                window.location.href = '{{ route('user.profile') }}';
                            }
                        });
                    }
                });
            }
        });

        function getStatusBadge(status) {
            const statusConfig = {
                'pending': {
                    class: 'bg-warning text-dark',
                    text: 'Pending Approval'
                },
                'approved': {
                    class: 'bg-success text-white',
                    text: 'Approved'
                },
                'blocked': {
                    class: 'bg-danger text-white',
                    text: 'Blocked'
                },
                'restricted': {
                    class: 'bg-warning text-dark',
                    text: 'Restricted'
                }
            };
            const config = statusConfig[status] || {
                class: 'bg-secondary text-white',
                text: 'Unknown'
            };
            return `<span class="badge ${config.class}">${config.text}</span>`;
        }

        function formatDate(date) {
            if (!date) return '-';
            const d = new Date(date);
            return d.toLocaleDateString('en-GB'); // DD/MM/YYYY
        }

        function loadData(search = '') {
            $.get("{{ route('bargains.data') }}", {
                search: search
            }, function(res) {
                console.log('Data received:', res.data.length, 'records');
                let html = '';
                res.data.forEach((row, index) => {
                    console.log(`Processing row ${index + 1}:`, row.tenant_name, 'Can manage:', row
                        .can_manage_status, 'Status:', row.registration_status);
                    const contractStatusClass = row.contract_purpose === 'one-time' ?
                        'bg-danger text-white' :
                        'bg-success text-white';

                    // Always show basic CRUD actions (for all users)
                    let actionButtons = '';

                    // Basic CRUD actions - show for everyone
                    actionButtons +=
                        `<button class="btn btn-sm btn-info view-btn" data-url="${row.showUrl}" title="View Details" style="margin:2px; display: inline-block;"><i class="bi bi-eye"></i></button>`;
                    actionButtons +=
                        `<button class="btn btn-sm btn-primary edit-btn" data-url="${row.editUrl}" title="Edit" style="margin:2px; display: inline-block;"><i class="bi bi-pencil-square"></i></button>`;
                    actionButtons +=
                        `<button class="btn btn-sm btn-warning toggle-btn" data-url="${row.toggleUrl}" title="Toggle Status" style="margin:2px; display: inline-block;"><i class="bi bi-toggle-on"></i></button>`;
                    actionButtons +=
                        `<button class="btn btn-sm btn-danger delete-btn" data-url="${row.deleteUrl}" title="Delete" style="margin:2px; display: inline-block;"><i class="bi bi-trash"></i></button>`;

                    // Add status management actions for admins only
                    if (row.can_manage_status) {
                        console.log('Adding admin status buttons for row:', index + 1);

                        // Approval button (for pending)
                        if (row.registration_status === 'pending') {
                            actionButtons +=
                                `<button class="btn btn-sm btn-success status-btn" data-url="${row.statusUrl}" data-status="approved" title="Approve" style="margin:2px; display: inline-block;"><i class="bi bi-check-circle"></i></button>`;
                        }

                        // Block button (for approved/restricted)
                        if (['approved', 'restricted'].includes(row.registration_status)) {
                            actionButtons +=
                                `<button class="btn btn-sm btn-danger status-btn" data-url="${row.statusUrl}" data-status="blocked" title="Block User" style="margin:2px; display: inline-block;"><i class="bi bi-x-circle"></i></button>`;
                        }

                        // Restrict button (for approved only)
                        if (row.registration_status === 'approved') {
                            actionButtons +=
                                `<button class="btn btn-sm btn-warning status-btn" data-url="${row.statusUrl}" data-status="restricted" title="Restrict User" style="margin:2px; display: inline-block;"><i class="bi bi-exclamation-triangle"></i></button>`;
                        }

                        // Warning button (for approved/restricted)
                        if (['approved', 'restricted'].includes(row.registration_status)) {
                            actionButtons +=
                                `<button class="btn btn-sm btn-info status-btn" data-url="${row.warningUrl}" data-action="warning" title="Send Warning" style="margin:2px; display: inline-block;"><i class="bi bi-bell"></i></button>`;
                        }

                        // Unblock button (for blocked)
                        if (row.registration_status === 'blocked') {
                            actionButtons +=
                                `<button class="btn btn-sm btn-primary status-btn" data-url="${row.statusUrl}" data-status="approved" title="Unblock User" style="margin:2px; display: inline-block;"><i class="bi bi-unlock"></i></button>`;
                        }

                        // Remove restriction button (for restricted)
                        if (row.registration_status === 'restricted') {
                            actionButtons +=
                                `<button class="btn btn-sm btn-success status-btn" data-url="${row.statusUrl}" data-status="approved" title="Remove Restriction" style="margin:2px; display: inline-block;"><i class="bi bi-shield-check"></i></button>`;
                        }
                    }

                    console.log(`Row ${index + 1} total buttons:`, actionButtons.includes('btn') ?
                        'Has buttons' : 'No buttons');

                    html += `<tr ${row.registration_status === 'blocked' ? 'class="table-danger"' : ''}>
                        <td>${index + 1}</td>
                        <td>${row.tenant_name}</td>
                        <td>${row.tenant_father_name}</td>
                        <td>${row.contract_company_name}</td>
                        <td>${row.contract_purpose}</td>
                        <td>${row.contract_location}</td>
                        <td>${formatDate(row.contract_from_date)}</td>
                        <td>${formatDate(row.contract_to_date)}</td>
                        <td>${row.written_contract_number}</td>
                        <td><span class="badge ${contractStatusClass}">${row.contract_purpose}</span></td>
                        <td>${getStatusBadge(row.registration_status)}</td>
                        <td>
                            ${actionButtons}
                        </td>
                    </tr>`;
                });
                $('#bargains-table tbody').html(html);
                console.log('Table updated, attaching events...');
                attachEvents();
            }).fail(function(error) {
                console.error('Error loading data:', error);
            });
        }

        function attachEvents() {
            console.log('Attaching events to buttons...');

            // Count buttons for debugging
            const viewBtns = $('.view-btn');
            const editBtns = $('.edit-btn');
            const deleteBtns = $('.delete-btn');
            const toggleBtns = $('.toggle-btn');
            const statusBtns = $('.status-btn');

            console.log('Found buttons:', {
                view: viewBtns.length,
                edit: editBtns.length,
                delete: deleteBtns.length,
                toggle: toggleBtns.length,
                status: statusBtns.length
            });

            $('.view-btn').off().on('click', function() {
                console.log('View button clicked');
                window.location.href = $(this).data('url');
            });

            $('.edit-btn').off().on('click', function() {
                console.log('Edit button clicked');
                window.location.href = $(this).data('url');
            });

            $('.delete-btn').off().on('click', function() {
                console.log('Delete button clicked');
                const url = $(this).data('url');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
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
                                Swal.fire('Deleted!', res.message ||
                                    'Record deleted successfully!', 'success');
                                loadData($('#search').val());
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Failed to delete record.', 'error');
                            }
                        });
                    }
                });
            });

            // Status toggle button
            $('.toggle-btn').off().on('click', function() {
                console.log('Toggle button clicked');
                const url = $(this).data('url');
                $.post(url, {
                    _token: '{{ csrf_token() }}'
                }, function(res) {
                    Swal.fire('Success', res.message || 'Status toggled successfully!', 'success').then(
                        () => {
                            loadData($('#search').val()); // Reload table data instead of full page
                        });
                }).fail(function() {
                    Swal.fire('Error', 'Failed to toggle status!', 'error');
                });
            });

            // Status management buttons
            $('.status-btn').off().on('click', function() {
                console.log('Status button clicked');
                const url = $(this).data('url');
                const status = $(this).data('status');
                const action = $(this).data('action');

                let confirmMessage = '';
                let actionText = '';

                if (action === 'warning') {
                    confirmMessage = 'Send a warning to this user?';
                    actionText = 'Warning sent successfully!';
                } else {
                    switch (status) {
                        case 'approved':
                            confirmMessage = 'Approve this user registration?';
                            actionText = 'User approved successfully!';
                            break;
                        case 'blocked':
                            confirmMessage = 'Block this user? They will not be able to access their account.';
                            actionText = 'User blocked successfully!';
                            break;
                        case 'restricted':
                            confirmMessage =
                                'Restrict this user? They will receive a warning about potential permanent blocking.';
                            actionText = 'User restricted successfully!';
                            break;
                    }
                }

                Swal.fire({
                    title: 'Confirm Action',
                    text: confirmMessage,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const postData = {
                            _token: '{{ csrf_token() }}'
                        };

                        if (status) {
                            postData.status = status;
                        }

                        $.post(url, postData, function(res) {
                            Swal.fire('Success', actionText, 'success').then(() => {
                                loadData($('#search').val()); // Reload table data
                            });
                        }).fail(function(xhr) {
                            let errorMessage = 'Failed to update user status!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        });
                    }
                });
            });

            console.log('Event attachment completed');
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

        .table-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        /* Force all buttons to display inline */
        .btn {
            display: inline-block !important;
            margin: 2px !important;
            white-space: nowrap;
        }

        .status-btn {
            min-width: 32px;
        }

        .badge {
            font-size: 0.8em;
        }

        /* Ensure action buttons stay inline */
        .actions-container {
            white-space: nowrap;
            min-width: 300px;
        }

        /* Specific targeting for action column */
        td:last-child {
            white-space: nowrap !important;
            min-width: 350px !important;
        }

        td:last-child .btn {
            display: inline-block !important;
            margin: 1px 2px !important;
            vertical-align: middle;
        }

        @media (max-width: 768px) {

            .table td,
            .table th {
                font-size: 0.85rem;
            }

            .btn-sm {
                padding: 0.15rem 0.3rem;
                font-size: 0.75rem;
            }

            td:last-child {
                white-space: normal !important;
                min-width: auto !important;
            }
        }
    </style>
@endsection
