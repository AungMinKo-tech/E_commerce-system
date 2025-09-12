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
                        <table class="table" id="productTable">
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
                                            <img src="{{ asset('product_image/' . $item->photo) }}" alt="Product Image"
                                                style="width: 100%;">
                                        </td>
                                        <td>
                                            <a href="#"><strong>{{$item->product_name}}</strong></a>
                                            <p class="small">Color: {{ $item->color_name }}</p>
                                        </td>
                                        <td class="price">{{ $item->price }} MMK</td>
                                        <td>
                                            <div class="input-number" style="width: 120px;">
                                                <input type="number" class="qty" value="{{ $item->qty }}">
                                                <span class="qty-up">+</span>
                                                <span class="qty-down">-</span>
                                            </div>
                                        </td>
                                        <td class="total">{{ $item->price * $item->qty }} MMK</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button>
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
                                    <td id="subtotal">{{ $totalPrice }} MMK</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>3500 MMK</td>
                                </tr>
                                <tr>
                                    <th><strong>Total</strong></th>
                                    <td><strong id="finalTotal">{{ $totalPrice + 3500 }} MMK</strong></td>
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
{{--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        function countCalculation(event) {
            var parentNode = $(event).closest("tr");
            var price = parseFloat(parentNode.find(".price").text().replace(" MMK", ""));
            var qty = parseInt(parentNode.find(".qty").val());

            parentNode.find(".total").text((price * qty) + " MMK");
        }

        function finalTotalCalculation() {
            var total = 0;

            $("#productTable tbody tr").each(function (index, item) {
                total += parseFloat($(item).find(".total").text().replace(" MMK", ""));
            });

            $("#subtotal").html(total + " MMK");
            $("#finalTotal").html((total + 3500) + " MMK");
        }

        $('.qty-down, .qty-up').click(function () {
            countCalculation(this);
            finalTotalCalculation();
        });

        $('.delete-btn').click(function(){

        });
    });
</script>
