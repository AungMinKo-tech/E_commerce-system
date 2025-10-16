@extends('user.layouts.master')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">My Orders</h3>
                    </div>
                </div>
            </div>
            <!-- /row -->

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    @if($orderList && count($orderList) > 0)
                        <div class="order-list">
                            @foreach($orderList as $orderCode => $orders)
                                @php
                                    $firstOrder = $orders->first();
                                    $totalAmount = 0;
                                    foreach($orders as $order) {
                                        $totalAmount += $order->price * $order->count;
                                    }
                                @endphp
                                <div class="order-item mb-4 p-4 border rounded shadow-sm bg-white">
                                    <div class="order-header mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h4 class="text-primary font-weight-bold mb-1">Order #{{ $orderCode }}</h4>
                                                <p class="order-date text-muted mb-0">
                                                    <i class="fa fa-calendar mr-1"></i>
                                                    Ordered on {{ $firstOrder->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                @if ($firstOrder->status == 0)
                                                    <span class="badge badge-warning badge-lg px-3 py-2">
                                                        <i class="fa fa-clock mr-1"></i>Pending
                                                    </span>
                                                @endif

                                                @if ($firstOrder->status == 1)
                                                    <span class="badge badge-success badge-lg px-3 py-2">
                                                        <i class="fa fa-check mr-1"></i>Accepted
                                                    </span>
                                                @endif

                                                @if ($firstOrder->status == 2)
                                                    <span class="badge badge-success badge-lg px-3 py-2">
                                                        <i class="fa fa-automobile mr-1"></i>Shipping
                                                    </span>
                                                @endif

                                                @if ($firstOrder->status == 4)
                                                    <span class="badge badge-info badge-lg px-3 py-2">
                                                        <i class="fa fa-truck mr-1"></i>Delivery
                                                    </span>
                                                @endif

                                                @if ($firstOrder->status == 3)
                                                    <span class="badge badge-danger badge-lg px-3 py-2">
                                                        <i class="fa fa-times mr-1"></i>Rejected
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-summary mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <div class="order-info">
                                                    <h6 class="mb-1">
                                                        <i class="fa fa-shopping-bag text-primary mr-2"></i>
                                                        {{ count($orders) }} item(s) in this order
                                                    </h6>
                                                    <p class="text-muted mb-0">
                                                        <i class="fa fa-calendar mr-1"></i>
                                                        {{ $firstOrder->created_at->format('M d, Y \a\t h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <button class="btn btn-outline-primary btn-sm" type="button" data-toggle="collapse" data-target="#orderDetails{{ $orderCode }}" aria-expanded="false" aria-controls="orderDetails{{ $orderCode }}">
                                                    <i class="fa fa-eye mr-1"></i>View Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse" id="orderDetails{{ $orderCode }}">
                                        <div class="order-details">
                                            <div class="products-list">
                                                @foreach($orders as $order)
                                                    <div class="product-item mb-3 p-3 border rounded bg-light">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-2">
                                                                <div class="product-image">
                                                                    <img src="{{ asset('product_image/' . $order->product_photo) }}"
                                                                        alt="{{ $order->product_name }}"
                                                                        class="img-fluid rounded"
                                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="product-details">
                                                                    <h5 class="mb-2 text-dark font-weight-bold">{{ $order->product_name }}</h5>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <span class="badge badge-info">Qty: {{ $order->count }}</span>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <span class="text-muted">Unit Price: {{ number_format($order->price) }} MMK</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 text-right">
                                                                <div class="product-total">
                                                                    <h5 class="text-success font-weight-bold">{{ number_format($order->price * $order->count) }} MMK</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                        <div class="order-summary mt-4 p-3 bg-white border rounded">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="order-info">
                                                        @if($firstOrder->delivery_man_id)
                                                            <p class="delivery-info mb-2">
                                                                <i class="fa fa-truck text-primary"></i>
                                                                <span class="ml-2">Assigned to Delivery Man</span>
                                                            </p>
                                                        @endif
                                                        @if($firstOrder->voucher_code)
                                                            <p class="voucher-info mb-2">
                                                                <i class="fa fa-ticket text-success"></i>
                                                                <span class="ml-2">Voucher Applied: <strong>{{ $firstOrder->voucher_code }}</strong></span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <div class="order-total">
                                                        @if ($firstOrder->voucher_code)
                                                            <h4 class="text-success font-weight-bold">{{ $firstOrder->total_amount }}</h4>
                                                            <small class="text-muted">Original: {{ number_format($totalAmount) }} MMK</small>
                                                        @else
                                                            <h4 class="text-primary font-weight-bold">{{ number_format($totalAmount) }} MMK</h4>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-orders">
                            <div class="text-center">
                                <i class="fa fa-shopping-bag" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                                <h3>No Orders Found</h3>
                                <p>You haven't placed any orders yet.</p>
                                <a href="{{ route('user#home') }}" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i> Start Shopping
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection

<style>
.order-item {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef !important;
}

.order-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    transform: translateY(-2px);
}

.product-item {
    transition: all 0.2s ease;
    border: 1px solid #dee2e6 !important;
}

.product-item:hover {
    background-color: #f8f9fa !important;
    border-color: #007bff !important;
}

.badge-lg {
    font-size: 0.9rem;
    font-weight: 600;
}

.order-header h4 {
    color: #007bff;
    font-size: 1.4rem;
}

.product-details h5 {
    color: #333;
    font-size: 1.1rem;
    line-height: 1.3;
}

.product-total h5 {
    font-size: 1.2rem;
    margin-bottom: 0;
}

.order-total h4 {
    font-size: 1.3rem;
    margin-bottom: 0;
}

.delivery-info, .voucher-info {
    font-size: 0.9rem;
}

.delivery-info i, .voucher-info i {
    font-size: 1rem;
}

.order-date {
    font-size: 0.9rem;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.8rem;
}

/* Badge color fixes */
.badge-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.badge-success {
    background-color: #28a745 !important;
    color: #ffffff !important;
}

.badge-info {
    background-color: #17a2b8 !important;
    color: #ffffff !important;
}

.badge-danger {
    background-color: #dc3545 !important;
    color: #ffffff !important;
}

.order-summary {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 0.375rem;
    padding: 1rem;
}

.order-summary h6 {
    color: #495057;
    font-weight: 600;
}

.collapse {
    transition: all 0.3s ease;
}

.btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.btn-outline-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

@media (max-width: 768px) {
    .order-item {
        padding: 1rem !important;
    }

    .product-item {
        padding: 1rem !important;
    }

    .col-md-2, .col-md-6, .col-md-4 {
        margin-bottom: 0.5rem;
    }

    .order-summary {
        padding: 0.75rem !important;
    }

    .btn-outline-primary {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
    }
}
</style>
