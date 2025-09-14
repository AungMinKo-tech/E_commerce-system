@extends('user.layouts.master')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <form action="{{route('user#orderCreate')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- row -->
                <div class="row">
                    <div class="col-md-7">
                        <!-- Payment Information -->
                        <div>
                            <h3 class="mb-4 title">Payment methods</h3>

                            @foreach ($payments as $payment)
                                <div class="">
                                    <b>{{ $payment->account_type }}</b> ( Name : {{ $payment->account_name }})
                                </div>

                                Account : {{ $payment->account_number }}

                                <hr>
                            @endforeach
                        </div>
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Billing address</h3>
                            </div>

                            <div class="form-group">
                                <input class="input" type="text" name="bill_name" placeholder="Name">
                            </div>

                            <div class="form-group">
                                <input class="input" type="email" name="bill_email" placeholder="Email">
                            </div>

                            <div class="form-group">
                                <input class="input" type="text" name="bill_address" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="bill_city" placeholder="City">
                            </div>

                            <div class="form-group">
                                <input class="input" type="tel" name="bill_phone" placeholder="Phone">
                            </div>
                        </div>
                        <!-- /Billing Details -->

                        <!-- Order notes -->
                        <div class="order-notes">
                            <textarea class="input" name="order_note" placeholder="Order Notes"></textarea>
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

                                <div class="order-col d-flex align-items-center gap-2 flex-nowrap">
                                    <div class="flex-shrink-0"><strong>Voucher Code</strong></div>
                                    <input type="text" class="form-control flex-grow-1" name="voucher"
                                        placeholder="Enter Voucher Code" id="voucherInput" @if ($voucherUsed)
                                        readonly @endif value="{{ $voucherCode ?? old('voucher') }}">
                                    <span id="message"></span><br>
                                    <button type="button" class="btn btn-danger apply" id="applyBtn" @if ($voucherUsed)
                                    disabled @endif>Apply</button>
                                </div>

                                @if (isset($discount))
                                    <div class="order-col">
                                        <div><strong>Final Total</strong></div>
                                        <div>
                                            <h5 class="product-price">{{ $discount }} MMK <del
                                                    class="product-old-price">{{ $tmpOrder[0]['final_total']}} MMK</del></h5>
                                        </div>
                                    </div>
                                @else
                                    <div class="order-col">
                                        <div><strong>Final Total</strong></div>
                                        <div>
                                            <h5>{{ $tmpOrder[0]['final_total']}} MMK</h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="payment-method">
                            <div class="text-center">
                                <div><strong>Payment</strong></div>
                            </div>

                            <div class="form-group mt-3 mb-2">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name">
                            </div>

                            <div class="form-group mb-2">
                                <label for="payslip">Payslip Image</label>
                                <input type="file" id="payslip" name="payslip" class="form-control">
                            </div>

                            <div class="form-group mb-2">
                                <label for="transaction_id">Transaction ID</label>
                                <input type="text" id="transaction_id" name="transaction_id" class="form-control"
                                    placeholder="Enter Your Name">
                            </div>

                            @if (isset($discount))
                                    <div class="form-group mb-2"></div>
                                    <label for="amount">Paid Amount</label>
                                    <input type="text" id="amount" name="amount" class="form-control" value="{{ $discount }} MMK"
                                        readonly>
                                </div>
                            @else
                            <div class="form-group mb-2">
                                <label for="amount">Paid Amount</label>
                                <input type="text" id="amount" name="amount" class="form-control"
                                    value="{{ $tmpOrder[0]['final_total'] }} MMK" readonly>
                            </div>
                        @endif

                        <select class="form-control mt-2" name="payment" id="payment">
                            <option value="">Choose Payment Method</option>
                            @foreach ($payments as $payment)
                                <option value="{{ $payment->id }}">{{ $payment->account_type }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn primary-btn order-submit">Place order</button>
                    </div>
                </div>
                <!-- /Order Details -->
            </form>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.apply').click(function () {
            let voucher = $('input[name="voucher"]').val();
            let totalAmount = {{ $tmpOrder[0]['final_total'] }};

            $.ajax({
                type: 'get',
                url: '{{ route('user#applyVoucher') }}',
                data: {
                    'voucher': voucher,
                    'totalAmount': totalAmount
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        $('#message').text(response.message).css('color', 'green');
                        // Disable voucher input and button after successful application
                        $('#voucherInput').prop('disabled', true);
                        $('#applyBtn').prop('disabled', true);
                        // Reload the page to show updated total with discount
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        $('#message').text(response.message).css('color', 'red');
                    }
                },
                error: function (xhr, status, error) {
                    let errorMessage = 'Server Error';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $('#message').text(errorMessage).css('color', 'red');
                }
            });
        });
    });
</script>
