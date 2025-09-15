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
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="order-list">
                            @foreach($orders as $order)
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
                                                            <img src="{{ asset('product_image/' . $order->product->photo) }}"
                                                                 alt="{{ $order->product->name }}"
                                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                                        </div>
                                                        <div class="product-details">
                                                            <h5>{{ $order->product->name }}</h5>
                                                            <p class="product-category">{{ $order->product->category->name ?? 'N/A' }}</p>
                                                            <p class="product-quantity">Quantity: {{ $order->count }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="order-total">
                                                    <h4>{{ number_format($order->product->price * $order->count) }} MMK</h4>
                                                    @if($order->voucher_code)
                                                        <p class="voucher-info">
                                                            <small>Voucher: {{ $order->voucher_code }}</small>
                                                        </p>
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
                                            <div class="col-md-6 text-right">
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#orderDetailsModal">
                                                    <i class="fa fa-eye"></i> View Details
                                                </button>
                                                @if(!$order->status)
                                                    <button class="btn btn-warning btn-sm">
                                                        <i class="fa fa-times"></i> Cancel Order
                                                    </button>
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
                                    {{ $orders->links() }}
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

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="orderDetailsModalLabel">Order Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <!-- Order details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection
