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
                                <button type="button" class="btn btn-outline-primary btn-sm quick-status" data-value="paid">Paid</button>
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
                                                @endif

                                                @if ($order->status == 1)
                                                    <span class="badge badge-info">Accept</span>
                                                @endif

                                                @if ($order->status == 2)
                                                    <span class="badge badge-primary">Shipping</span>
                                                @endif

                                                @if ($order->status == 3)
                                                    <span class="badge badge-danger">Reject</span>
                                                @endif
                                            </td>
                                            <td>{{ ($order->created_at ?? now())->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{route('admin#orderDetail', $order->order_code)}}" class="btn btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                                    <button type="button" class="btn btn-outline-secondary"><i class="fas fa-ellipsis-h"></i></button>
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
@endsection
