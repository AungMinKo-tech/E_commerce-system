@extends('admin.layouts.master')

@section('title', 'Delivery Dashboard')

@section('content')
<div class="container">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Delivery Dashboard</h4>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-delivery-truck text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Today's Deliveries</p>
                                        <h4 class="card-title">{{ $todayDeliveries ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-check text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Completed</p>
                                        <h4 class="card-title">{{ $completedDeliveries->counts() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="row">
                <!-- Assigned Deliveries -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Assigned Deliveries</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Assigned Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($todayDeliveries ?? [] as $delivery)
                                        <tr>
                                            <td>#{{ $delivery->order->order_code ?? 'N/A' }}</td>
                                            <td>{{ $delivery->user->name ?? 'N/A' }}</td>
                                            <td>{{ $delivery->order->shipping_address ?? 'N/A' }}</td>
                                            <td>
                                                @switch($delivery->status)
                                                    @case('pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                        @break
                                                    @case('in_progress')
                                                        <span class="badge badge-info">In Progress</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge badge-success">Delivered</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge badge-danger">Failed</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-secondary">Unknown</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $delivery->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    @if($delivery->status == 'pending')
                                                    <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Start Delivery" onclick="startDelivery({{ $delivery->id }})">
                                                        <i class="fa fa-play"></i>
                                                    </button>
                                                    @elseif($delivery->status == 'in_progress')
                                                    <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Mark as Delivered" onclick="completeDelivery({{ $delivery->id }})">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    @endif
                                                    <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-info btn-lg" data-original-title="View Details" onclick="viewDelivery({{ $delivery->id }})">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No deliveries assigned</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Profile -->
                <div class="col-md-4">
                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Quick Actions</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Update Status</h5>
                                        <small><i class="fa fa-clock"></i></small>
                                    </div>
                                    <p class="mb-1">Mark deliveries as completed</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">View Map</h5>
                                        <small><i class="fa fa-map"></i></small>
                                    </div>
                                    <p class="mb-1">Check delivery routes</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Report Issue</h5>
                                        <small><i class="fa fa-exclamation-triangle"></i></small>
                                    </div>
                                    <p class="mb-1">Report delivery problems</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{ asset('default/default_profile.jpg') }}" alt="Profile" class="img-fluid rounded-circle" style="width: 80px; height: 80px;">
                                <h5 class="mt-3">{{ Auth::user()->name }}</h5>
                                <p class="text-muted">Delivery Person</p>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-6">
                                    <h6 class="text-primary">{{ $totalDeliveries ?? 0 }}</h6>
                                    <small class="text-muted">Total Deliveries</small>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-success">{{ $thisMonthDeliveries ?? 0 }}</h6>
                                    <small class="text-muted">This Month</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Recent Activity</h4>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @forelse($recentActivities ?? [] as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">{{ $activity->title }}</h6>
                                        <p class="timeline-text">{{ $activity->description }}</p>
                                        <span class="timeline-date">{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                @empty
                                <p class="text-muted text-center">No recent activity</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Details Modal -->
<div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="deliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryModalLabel">Delivery Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="deliveryModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function startDelivery(deliveryId) {
        if (confirm('Are you sure you want to start this delivery?')) {
            // AJAX call to start delivery
            fetch(`/delivery/start/${deliveryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    }

    function completeDelivery(deliveryId) {
        if (confirm('Are you sure you want to mark this delivery as completed?')) {
            // AJAX call to complete delivery
            fetch(`/delivery/complete/${deliveryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    }

    function viewDelivery(deliveryId) {
        // Load delivery details in modal
        fetch(`/delivery/details/${deliveryId}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('deliveryModalBody').innerHTML = html;
                $('#deliveryModal').modal('show');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while loading delivery details');
            });
    }

    // Auto-refresh every 30 seconds
    setInterval(function() {
        location.reload();
    }, 30000);
</script>
@endsection
