@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="fw-bold mb-0">Order Board</h3>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" id="btn-export-csv">
                        <i class="fas fa-file-csv me-1"></i>Export CSV
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row g-2 mb-3">

                        <div class="col-12 col-md-8 mt-2 text-md-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm quick-status" data-value="pending">Pending</button>
                                <button type="button" class="btn btn-outline-primary btn-sm quick-status" data-value="accept">Accept</button>
                                <button type="button" class="btn btn-outline-primary btn-sm quick-status" data-value="shipped">Shipped</button>
                                <button type="button" class="btn btn-outline-primary btn-sm quick-status" data-value="delivered">Delivered</button>
                                <button type="button" class="btn btn-outline-primary btn-sm quick-status" data-value="">All</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>Order Code</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($orders)
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td><strong>{{ $order->order_code }}</strong></td>
                                            <td>{{ $order->name == null ? $order->nickname : $order->name }}</td>
                                            <td>{{ $order->items_count ?? 0 }}</td>
                                            <td>{{ $order->total_amount }}</td>
                                            <td>
                                                <span class="badge bg-danger">{{ $order->account_type }}</span>
                                            </td>
                                            <td>
                                                @if ($order->status == 0)
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($order->status == 1)
                                                    <span class="badge badge-info">Accept</span>
                                                @elseif ($order->status == 2)
                                                    <span class="badge badge-primary">Shipping</span>
                                                @elseif ($order->status == 3)
                                                    <span class="badge badge-danger">Reject</span>
                                                @elseif ($order->status == 4)
                                                    <span class="badge badge-success">Delivered</span>
                                                @endif
                                            </td>
                                            <td>{{ ($order->created_at ?? now())->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{route('admin#orderDetail', $order->order_code)}}" class="btn btn-outline-secondary" title="View Details"><i class="fas fa-eye"></i></a>

                                                    <!-- Accept Button (show for pending orders) -->
                                                    @if($order->status == 0)
                                                        <button type="button" class="btn btn-success btn-sm" onclick="updateOrderStatus('{{ $order->order_code }}', 1)" title="Accept Order" style="display: inline-block !important; visibility: visible !important;">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif

                                                    <!-- Reject Button (show for pending orders) -->
                                                    @if($order->status == 0)
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="updateOrderStatus('{{ $order->order_code }}', 3)" title="Reject Order" style="display: inline-block !important; visibility: visible !important;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif

                                                    <!-- Ship Button (show for accepted orders) -->
                                                    @if($order->status == 1)
                                                        <button type="button" class="btn btn-primary btn-sm" onclick="updateOrderStatus('{{ $order->order_code }}', 2)" title="Mark as Shipped" style="display: inline-block !important; visibility: visible !important;">
                                                            <i class="fas fa-shipping-fast"></i>
                                                        </button>
                                                    @endif

                                                    <!-- Deliver Button (show for shipped orders) -->
                                                    @if($order->status == 2)
                                                        <button type="button" class="btn btn-info btn-sm" onclick="updateOrderStatus('{{ $order->order_code }}', 4)" title="Mark as Delivered" style="display: inline-block !important; visibility: visible !important;">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">No orders found.</td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No orders found.</td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .quick-status.active {
            background-color: #007bff !important;
            color: white !important;
            border-color: #007bff !important;
        }

        /* Ensure buttons are visible */
        .btn-group .btn {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Button group styling */
        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        /* Action buttons styling */
        .btn-group .btn-sm {
            margin: 0 2px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing order list functionality');

            const quickStatusButtons = document.querySelectorAll('.quick-status');
            const ordersTable = document.getElementById('ordersTable');
            const tableRows = ordersTable.querySelectorAll('tbody tr');

            // Debug: Check if buttons are present
            const actionButtons = document.querySelectorAll('.btn-group .btn');
            console.log('Found action buttons:', actionButtons.length);

            // Debug: Check if updateOrderStatus function is defined
            console.log('updateOrderStatus function defined:', typeof updateOrderStatus);

            quickStatusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const statusValue = this.getAttribute('data-value');

                    // Remove active class from all buttons
                    quickStatusButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    // Filter table rows
                    tableRows.forEach(row => {
                        const statusCell = row.querySelector('td:nth-child(6)'); // Status column
                        if (statusCell) {
                            const statusBadge = statusCell.querySelector('.badge');
                            if (statusBadge) {
                                const statusText = statusBadge.textContent.trim().toLowerCase();
                                let shouldShow = false;

                                if (statusValue === '') {
                                    shouldShow = true; // Show all
                                } else if (statusValue === 'pending' && statusText === 'pending') {
                                    shouldShow = true;
                                } else if (statusValue === 'accept' && statusText === 'accept') {
                                    shouldShow = true;
                                } else if (statusValue === 'shipped' && statusText === 'shipping') {
                                    shouldShow = true;
                                } else if (statusValue === 'delivered' && statusText === 'delivered') {
                                    shouldShow = true;
                                }

                                row.style.display = shouldShow ? '' : 'none';
                            }
                        }
                    });
                });
            });
        });

        // Update order status function
        function updateOrderStatus(orderCode, status) {
            console.log('updateOrderStatus called with:', orderCode, status);

            const statusTexts = {
                1: 'Accept',
                2: 'Mark as Shipped',
                3: 'Reject',
                4: 'Mark as Delivered'
            };

            const statusText = statusTexts[status] || 'Update Status';

            // Check if SweetAlert is available
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert is not loaded');
                alert(`Are you sure you want to ${statusText.toLowerCase()} this order?`);
                // Proceed with form submission
                submitStatusUpdate(orderCode, status);
                return;
            }

            Swal.fire({
                title: 'Update Order Status',
                text: `Are you sure you want to ${statusText.toLowerCase()} this order?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we update the order status.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the status update
                    submitStatusUpdate(orderCode, status);
                }
            });
        }

        // Helper function to submit status update
        function submitStatusUpdate(orderCode, status) {
            // Create a form to submit the status update
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin#confirmOrder") }}';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add order code
            const orderCodeInput = document.createElement('input');
            orderCodeInput.type = 'hidden';
            orderCodeInput.name = 'order_code';
            orderCodeInput.value = orderCode;
            form.appendChild(orderCodeInput);

            // Add status
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = status;
            form.appendChild(statusInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
