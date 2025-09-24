@extends('user.layouts.master')

@section('content')
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->
                <form action="{{route('user#categoryPage')}}" method="GET">
                    <div id="aside" class="col-md-3">
                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Categories</h3>
                            <div class="checkbox-filter">

                                @foreach ($categories as $category)
                                    <div class="input-checkbox">
                                        <input type="checkbox" id="category-{{$category->id}}" name="category[]"
                                            value="{{ $category->id }}" {{ (request('category') && in_array($category->id, request('category'))) ? 'checked' : '' }}>
                                        <label for="category-{{$category->id}}">
                                            <span></span>
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Price</h3>
                            <div class="price-filter">
                                <div class="input-number">
                                    <input id="price-min" type="number" name="price_min" value="{{ request('price_min') }}">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                                <span>-</span>
                                <div class="input-number">
                                    <input id="price-max" type="number" name="price_max" value="{{ request('price_max') }}">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>
                        </div>
                        <!-- /aside Widget -->
                        <div class="aside text-center">
                            <button type="submit" class="btn btn-info">Filter</button>
                        </div>
                    </div>
                </form>
                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-md-9">
                    <!-- store products -->
                    <div class="row">
                        @if($products->count() > 0)
                            @foreach ($products as $product)
                                <!-- product -->
                                <div class="col-md-4 col-xs-6">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="{{ asset('product_image/' . $product->photo) }}" alt=""
                                                style="height: 250px; object-fit: cover;">
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">{{ $product->category->name }}</p>
                                            <h3 class="product-name"><a
                                                    href="{{ route('user#detailProduct', $product->id) }}">{{ $product->name }}</a>
                                            </h3>
                                            <h4 class="product-price">{{ $product->price }} MMK</h4>
                                            <div class="product-rating">

                                            </div>
                                            <div class="product-btns">
                                                <form action="{{route('user#wishList')}}" method="POST" class="wishlist-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    <button type="submit" class="add-to-wishlist" aria-label="Toggle wishlist">
                                                        <i
                                                            class="fa {{ in_array($product->id, $wishlistProductIds ?? []) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <form action="{{route('user#detailProduct', $product->id)}}" method="GET">
                                            @csrf
                                            <div class="add-to-cart">
                                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to
                                                    cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /product -->
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <p class="text-center fs-4 mt-5">There are no products for this filter.</p>
                            </div>
                        @endif
                    </div>
                    <!-- /store products -->
                </div>
                <!-- /STORE -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
@endsection
