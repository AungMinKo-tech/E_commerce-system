@extends('user.layouts.master')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-items">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $item)
                                    <tr>
                                        <td style="width: 100px;">
                                            <img src="{{ asset('product_image/'. $item->photo) }}" alt="Product Image" style="width: 100%;">
                                        </td>
                                        <td>
                                            <a href="#"><strong>{{$item->product_name}}</strong></a>
                                            <p class="small">Color: {{ $item->color_name }}</p>
                                        </td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <div class="input-number" style="width: 120px;">
                                                <input type="number" value="{{ $item->qty }}">
                                                <span class="qty-up">+</span>
                                                <span class="qty-down">-</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->price * $item->qty }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="cart-summary">
                        <a href="{{ url('/') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Continue
                            Shopping</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="cart-summary">
                        <h3>Cart Totals</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>$1880.00</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>Free Shipping</td>
                                </tr>
                                <tr>
                                    <th><strong>Total</strong></th>
                                    <td><strong>$1880.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-success btn-block">Proceed to Checkout <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection
