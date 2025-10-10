@extends('user.layouts.master')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                @foreach ($categories as $category)
                                    <li class=""><a data-toggle="tab" href="#tab1">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">

                                    @foreach ($products as $product)
                                        <!-- product -->
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="{{ asset('product_image/' . $product->photo) }}">
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">{{$product->category_name}}</p>
                                                <h3 class="product-name"><a href="#">{{ $product->name }}</a></h3>
                                                <h4 class="product-price">MMK {{ $product->price }}</h4>
                                                <div class="product-btns">
                                                    <form action="{{route('user#wishList')}}" method="POST"
                                                        class="wishlist-form">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                        <button type="submit" class="add-to-wishlist"
                                                            aria-label="Toggle wishlist">
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
                                        <!-- /product -->
                                    @endforeach

                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Banner SECTION -->
    <div id="hot-deal" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="hot-deal">
                        <h2 class="text-uppercase">Upgrade Your Life with Lastest Electronic</h2>
                        <p>New Collection Up to 30% OFF</p>
                        <a class="primary-btn cta-btn" href="#">Shop now</a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOT DEAL SECTION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">

                        <!-- section title -->
                        <div class="col-md-12">
                            <div class="section-title">
                                <h3 class="title">🔥 Top Selling Products</h3>
                                <div class="section-nav">
                                    <ul class="section-tab-nav tab-nav">
                                        @foreach ($categories as $category)
                                            <li class=""><a data-toggle="tab" href="#tab1">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /section title -->

                        <div class="col-md-12">
                            <div class="row">
                                <div class="products-tabs">
                                    <!-- tab -->
                                    <div id="tab1" class="tab-pane active">
                                        <div class="products-slick" data-nav="#slick-nav-1">

                                            @foreach ($topSellings as $top)
                                                <!-- product -->
                                                <div class="product">
                                                    <div class="product-img">
                                                        <img src="{{ asset('product_image/' . $top->photo) }}">
                                                    </div>
                                                    <div class="product-body">
                                                        <p class="product-category">{{$top->category_name}}</p>
                                                        <h3 class="product-name"><a href="#">{{ $top->name }}</a></h3>
                                                        <h4 class="product-price">MMK {{ $top->price }}</h4>
                                                    </div>
                                                    <form action="{{route('user#detailProduct', $top->id)}}" method="GET">
                                                        @csrf
                                                        <div class="add-to-cart">
                                                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>
                                                                add to
                                                                cart</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /product -->
                                            @endforeach

                                        </div>
                                        <div id="slick-nav-1" class="products-slick-nav"></div>
                                    </div>
                                    <!-- /tab -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection
