@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="fw-bold mb-0">Shipping Management</h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin#shippingList') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-truck text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Deliveries</p>
                                        <h4 class="card-title">{{ $deliveries->total() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-clock text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Pending</p>
                                        <h4 class="card-title">{{ $deliveries->where('status', 'pending')->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Delivered</p>
                                        <h4 class="card-title">{{ $deliveries->where('status', 'delivered')->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-users text-info"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Delivery Men</p>
                                        <h4 class="card-title">{{ $deliveryMans->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Simple Filter Section -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <form method="GET" action="{{ route('admin#shippingList') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="Search by customer, delivery man..." value="{{ request('search') }}" />
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="shippingTable" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Order Code</th>
                                    <th>Delivery Man</th>
                                    <th>Status</th>
                                    <th>Delivery Date</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deliveries as $delivery)
                                    <tr>
                                        <td><strong>#{{ $delivery->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <img src="{{ $delivery->user->profile ? asset('profile/' . $delivery->user->profile) : asset('default/default_profile.jpg') }}"
                                                         alt="User Avatar" class="avatar-img rounded-circle" width="32" height="32">
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $delivery->user->name ?? $delivery->user->nickname ?? 'Unknown User' }}</div>
                                                    <small class="text-muted">{{ $delivery->user->email ?? 'No email' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $delivery->order->order_code ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @if($delivery->deliveryMan && $delivery->deliveryMan->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <img src="{{ $delivery->deliveryMan->user->profile ? asset('profile/' . $delivery->deliveryMan->user->profile) : asset('default/default_profile.jpg') }}"
                                                             alt="Delivery Man Avatar" class="avatar-img rounded-circle" width="24" height="24">
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $delivery->deliveryMan->user->name ?? $delivery->deliveryMan->user->nickname ?? 'Unknown' }}</div>
                                                        <small class="text-muted">{{ $delivery->deliveryMan->vehicle ?? 'No vehicle' }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($delivery->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($delivery->status == 'assigned')
                                                <span class="badge badge-info">Assigned</span>
                                            @elseif($delivery->status == 'in_transit')
                                                <span class="badge badge-primary">In Transit</span>
                                            @elseif($delivery->status == 'delivered')
                                                <span class="badge badge-success">Delivered</span>
                                            @elseif($delivery->status == 'failed')
                                                <span class="badge badge-danger">Failed</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($delivery->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($delivery->delivery_at)
                                                {{ \Carbon\Carbon::parse($delivery->delivery_at)->format('M d, Y H:i') }}
                                            @else
                                                <span class="text-muted">Not delivered</span>
                                            @endif
                                        </td>
                                        <td>{{ $delivery->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $delivery->id }}" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Update Status Modal -->
                                    <div class="modal fade" id="updateStatusModal{{ $delivery->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $delivery->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateStatusModalLabel{{ $delivery->id }}">Update Delivery Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin#updateDeliveryStatus') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="delivery_id" value="{{ $delivery->id }}">

                                                        <div class="form-group">
                                                            <label for="status{{ $delivery->id }}">Status</label>
                                                            <select class="form-control" id="status{{ $delivery->id }}" name="status" required>
                                                                <option value="pending" {{ $delivery->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="assigned" {{ $delivery->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                                                <option value="in_transit" {{ $delivery->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                                                <option value="delivered" {{ $delivery->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                                <option value="failed" {{ $delivery->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="delivery_man_id{{ $delivery->id }}">Delivery Man</label>
                                                            <select class="form-control" id="delivery_man_id{{ $delivery->id }}" name="delivery_man_id">
                                                                <option value="">Select Delivery Man</option>
                                                                @foreach($deliveryMans as $deliveryMan)
                                                                    <option value="{{ $deliveryMan->id }}" {{ $delivery->delivery_man_id == $deliveryMan->id ? 'selected' : '' }}>
                                                                        {{ $deliveryMan->user->name ?? $deliveryMan->user->nickname ?? 'Unknown' }} - {{ $deliveryMan->vehicle ?? 'No vehicle' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-truck fa-2x mb-2"></i>
                                            <div>No deliveries found.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($deliveries->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $deliveries->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-stats .icon-big {
            font-size: 2em;
        }

        .avatar-img {
            object-fit: cover;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }

        .badge {
            font-size: 0.75em;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
        }
    </style>
@endsection
