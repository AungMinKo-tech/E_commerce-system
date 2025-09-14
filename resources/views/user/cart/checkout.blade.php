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
                                <div><strong>Final Total</strong></div>
                                <div><strong>{{ $tmpOrder[0]['final_total']}} MMK</strong></div>
                            </div>
                        </div>


                    </div>
                    <div class="payment-method">
                        <select class="form-control" name="payment" id="payment">
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
