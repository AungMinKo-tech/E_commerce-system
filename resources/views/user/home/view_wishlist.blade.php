@extends('user.layouts.master')

@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title" style="display:flex;justify-content:space-between;align-items:center;">
                        <h3 class="title">My Wishlist ({{ $wishlistCount ?? 0 }})</h3>
                        <a href="{{ url()->previous() }}" class="primary-btn"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                </div>

                @if(($wishlistItems ?? collect())->isEmpty())
                    <div class="col-md-12">
                        <p>Your wishlist is empty.</p>
                        <a href="{{ route('user#home') }}" class="primary-btn">Continue Shopping</a>
                    </div>
                @else
                    @foreach($wishlistItems as $product)
                        <div class="col-md-3 col-sm-6">
                            <div class="product">
                                <div class="product-img">
                                    <img src="{{ asset('product_image/' . $product->photo) }}">
                                </div>
                                <div class="product-body">
                                    <p class="product-category">{{ optional($product->category)->name }}</p>
                                    <h3 class="product-name"><a href="#">{{ $product->name }}</a></h3>
                                    <h4 class="product-price">MMK {{ $product->price }}</h4>
                                </div>
                                <div class="add-to-cart">
                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection


