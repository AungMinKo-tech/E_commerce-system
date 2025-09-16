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
                    @if($orderList)
                        <div class="order-list">
                            @foreach($orderList as $order)
                                <div class="order-item">
                                    <div class="order-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Order #{{ $order->order_code }}</h4>
                                                <p class="order-date">Ordered on {{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <span class="order-status status-{{ $order->status ? 'completed' : 'pending' }}">
                                                    {{ $order->status ? 'Completed' : 'Pending' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-details">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="product-info">
                                                    <div class="product-item">
                                                        <div class="product-image">
                                                            <img src="{{ asset('product_image/' . $order->product_photo) }}"
                                                                 alt="{{ $order->product_name }}"
                                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                                        </div>
                                                        <div class="product-details">
                                                            <h5>{{ $order->product_name }}</h5>
                                                            <p class="product-quantity">Quantity: {{ $order->count }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="order-total">
                                                    @if ($order->voucher_code)
                                                    <p class="voucher-info">
                                                    <h4>{{$order->total_amount}}<br><del>{{ ($order->price * $order->count) }} MMK</del></h4>
                                                        <small>Voucher: {{ $order->voucher_code }}</small>
                                                    </p>
                                                    @else
                                                    <h4>{{ number_format($order->price * $order->count) }} MMK</h4>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-actions">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($order->delivery_man_id)
                                                    <p class="delivery-info">
                                                        <i class="fa fa-truck"></i>
                                                        Assigned to Delivery Man
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pagination-wrapper">
                                    {{-- {{ $orders->links() }} --}}
                                </div>
                            </div>
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
