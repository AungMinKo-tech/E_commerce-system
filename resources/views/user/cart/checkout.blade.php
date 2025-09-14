@extends('user.layouts.master')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Billing address</h3>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="first-name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <input class="input" type="email" name="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <input class="input" type="text" name="address" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="city" placeholder="City">
                        </div>

                        <div class="form-group">
                            <input class="input" type="tel" name="tel" placeholder="Phone">
                        </div>
                    </div>
                    <!-- /Billing Details -->

                    <!-- Shiping Details -->
                    <div class="shiping-details">
                        <div class="section-title">
                            <h3 class="title">Shiping address</h3>
                        </div>
                        <div class="input-checkbox">
                            <input type="checkbox" id="shiping-address">
                            <label for="shiping-address">
                                <span></span>
                                Ship to a diffrent address?
                            </label>
                            <div class="caption">
                                <div class="form-group">
                                    <input class="input" type="text" name="first-name" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <input class="input" type="email" name="email" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input class="input" type="text" name="address" placeholder="Address">
                                </div>

                                <div class="form-group">
                                    <input class="input" type="text" name="city" placeholder="City">
                                </div>

                                <div class="form-group">
                                    <input class="input" type="tel" name="phone" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Shiping Details -->

                    <!-- Order notes -->
                    <div class="order-notes">
                        <textarea class="input" placeholder="Order Notes"></textarea>
                    </div>
                    <!-- /Order notes -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Your Order</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>PRODUCT</strong></div>
                            <div><strong>TOTAL</strong></div>
                        </div>
                        <div class="order-products">
                            @foreach ($tmpOrder as $item)
                                <div class="order-col">
                                    <div>{{ $item['qty'] }}x {{ $item['product_name'] }}</div>
                                    <div>{{ $item['price'] * $item['qty'] }} MMK</div>
                                </div>
                            @endforeach

                            <div class="order-col">
                                <div>Shiping</div>
                                <div>3500 MMK</div>
                            </div>

                            <div class="order-col">
                                <div><strong>Order Code</strong></div>
                                <div><strong>{{ $tmpOrder[0]['order_code']}}</strong></div>
                            </div>

                            <div class="order-col">
                                <div class="me-3"><strong>Voucher Code</strong></div>
                                <form action="{{route('user#applyVoucher')}}" class="form-inline" method="POST">
                                    @csrf
                                    <input type="hidden" name="totalAmount" value="{{ $tmpOrder[0]['final_total']}}">
                                    <input type="text" class="form-control" name="voucher" placeholder="Enter Voucher Code">
                                    <button type="submit" class="btn btn-danger">Apply</button>
                                </form>
                            </div>

                            @if (isset($finalAmount))
                                <div class="order-col">
                                    <div><strong>Final Total</strong></div>
                                    <div>
                                        <h5 class="product-price">{{ $tmpOrder[0]['final_total']}} MMK <del class="product-old-price" {{ $finalAmount }}></del></h5>
                                    </div>
                                </div>
                            @else
                                <div class="order-col">
                                    <div><strong>Final Total</strong></div>
                                    <div><h5>{{ $tmpOrder[0]['final_total']}} MMK</h5></div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="payment-method">
                        <div class="text-center">
                            <div><strong>Payment Info</strong></div>
                        </div>

                        <div class="form-group mt-3 mb-2">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name">
                        </div>

                        <div class="form-group mb-2">
                            <label for="transaction_id">Transaction ID</label>
                            <input type="text" id="transaction_id" name="transaction_id" class="form-control"
                                placeholder="Enter Your Name">
                        </div>

                        <div class="form-group mb-2">
                            <label for="amount">Paid Amount</label>
                            <input type="text" id="amount" name="amount" class="form-control"
                                value="{{ $tmpOrder[0]['final_total'] }} MMK" readonly>
                        </div>

                        <select class="form-control mt-2" name="payment" id="payment">
                            <option value="">Choose Payment Method</option>
                            @foreach ($payments as $payment)
                                <option value="{{ $payment->id }}">{{ $payment->account_type }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="input-checkbox">
                        <input type="checkbox" id="terms">
                        <label for="terms">
                            <span></span>
                            I've read and accept the <a href="#">terms & conditions</a>
                        </label>
                    </div>
                    <a href="#" class="primary-btn order-submit">Place order</a>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection
