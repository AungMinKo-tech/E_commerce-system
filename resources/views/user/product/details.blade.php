@extends('user.layouts.master')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title" style="display:flex;justify-content:space-between;align-items:center;">
                        <a href="{{ route('user#home') }}" class="primary-btn"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                </div>
                <!-- Product main img -->
                <div class="col-md-5">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <img src="{{ asset('product_image/' . $product->photo) }}" alt="">
                        </div>
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <div>
                            <div class="product-rating">
                                <div class="rating-stars">
                                    @if ($avgRating == 0)
                                        <i class="fa fa-star-o empty"></i>
                                        <i class="fa fa-star-o empty"></i>
                                        <i class="fa fa-star-o empty"></i>
                                        <i class="fa fa-star-o empty"></i>
                                        <i class="fa fa-star-o empty"></i>
                                    @else
                                        @for ($i = 0; $i < $avgRating; $i++)
                                            <i class="fa fa-star text-danger"></i>
                                        @endfor
                                        @for ($j = $avgRating; $j < 5; $j++)
                                            <i class="fa fa-star-o empty"></i>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <a class="review-link" href="#" aria-disabled="">{{$comments->count()}} Review(s)</a>
                        </div>
                        <div>
                            @if ($product->discount)
                                <h3 class="product-price">{{ $product->price - ($product->price * $product->discount) / 100 }}
                                    MMK
                                    <del class="product-old-price">{{ $product->price }} MMK</del>
                                </h3>
                                <span class="product-available">Stock |</span>
                                @foreach ($colors as $item)
                                    <span class="badge bg-secondary">{{ $item->color_name }} - {{ $item->stock }}</span>
                                    <span></span>
                                @endforeach
                            @else
                                <h3 class="product-price">{{ $product->price }} MMK</h3>
                                <span class="product-available">Stock |</span>
                                @foreach ($colors as $item)
                                    <span class="badge bg-secondary">{{ $item->color_name }} - {{ $item->stock }}</span>
                                    <span></span>
                                @endforeach
                            @endif

                        </div>
                        <p>{{ $product->description }}</p>

                        <form action="{{route('user#addToCart')}}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="product-options">
                                <label>
                                    Color
                                    <select class="input-select" name="color_id">
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->color_id }}">{{ $color->color_name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="add-to-cart">
                                <div class="qty-label">
                                    Qty
                                    <div class="input-number">
                                        <input type="number" value="1" name="qty">
                                        <span class="qty-up">+</span>
                                        <span class="qty-down">-</span>
                                    </div>
                                </div>
                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                            </div>
                        </form>

                        <ul class="product-links">
                            <li>Category:</li>
                            <li>
                                <h5>{{$product->category_name}}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                            <li><a data-toggle="tab" href="#tab2">Details</a></li>
                            <li><a data-toggle="tab" href="#tab3">Reviews ({{$comments->count()}})</a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- tab1  -->
                            <div id="tab1" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab1  -->

                            <!-- tab2  -->
                            <div id="tab2" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach (explode("\n", $product->detail) as $line)
                                            <li>{{ $line }}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /tab2  -->

                            <!-- tab3  -->
                            <div id="tab3" class="tab-pane fade in">
                                <div class="row">
                                    <!-- Rating -->
                                    <div class="col-md-3">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span>{{ $avgRating }}</span>
                                                <div class="rating-stars">
                                                    @if ($avgRating == 0)
                                                        <i class="fa fa-star-o empty"></i>
                                                        <i class="fa fa-star-o empty"></i>
                                                        <i class="fa fa-star-o empty"></i>
                                                        <i class="fa fa-star-o empty"></i>
                                                        <i class="fa fa-star-o empty"></i>
                                                    @else
                                                        @for ($i = 0; $i < $avgRating; $i++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                        @for ($j = $avgRating; $j < 5; $j++)
                                                            <i class="fa fa-star-o empty"></i>
                                                        @endfor
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Rating -->

                                    <!-- Reviews -->
                                    <div class="col-md-6">
                                        <div id="reviews">
                                            <ul class="reviews">
                                                @foreach ($comments as $comment)
                                                    <li>
                                                        <div class="review-heading">
                                                            <h5 class="name">{{ $comment->name }}</h5>
                                                            <p class="date">{{$comment->created_at->format('d-m-Y')}}</p>
                                                            <div class="review-rating">
                                                                @if ($comment->rating_count == 0)
                                                                    <i class="fa fa-star-o empty"></i>
                                                                    <i class="fa fa-star-o empty"></i>
                                                                    <i class="fa fa-star-o empty"></i>
                                                                    <i class="fa fa-star-o empty"></i>
                                                                    <i class="fa fa-star-o empty"></i>
                                                                @else
                                                                    @for ($i = 0; $i < $comment->rating_count; $i++)
                                                                        <i class="fa fa-star"></i>
                                                                    @endfor
                                                                    @for ($j = $comment->rating_count; $j < 5; $j++)
                                                                        <i class="fa fa-star-o empty"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="review-body">
                                                            <p>{{$comment->message}}</p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Reviews -->

                                    <!-- Review Form -->
                                    <div class="col-md-3">
                                        <div id="review-form">
                                            <form class="review-form" action="{{route('user#addComment')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                <input class="input" type="text" placeholder="{{Auth::user()->name}}"
                                                    disabled>
                                                <input class="input" type="email" placeholder="Your Email" required>
                                                <textarea class="input" placeholder="Your Review" name="message"
                                                    required></textarea>
                                                <div class="input-rating">
                                                    <span>Your Rating: </span>
                                                    <div class="stars">
                                                        <input id="star5" name="rating" value="5" type="radio"><label
                                                            for="star5"></label>
                                                        <input id="star4" name="rating" value="4" type="radio"><label
                                                            for="star4"></label>
                                                        <input id="star3" name="rating" value="3" type="radio"><label
                                                            for="star3"></label>
                                                        <input id="star2" name="rating" value="2" type="radio"><label
                                                            for="star2"></label>
                                                        <input id="star1" name="rating" value="1" type="radio"><label
                                                            for="star1"></label>
                                                    </div>
                                                </div>
                                                <button class="primary-btn" type="submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /Review Form -->
                                </div>
                            </div>
                            <!-- /tab3  -->
                        </div>
                        <!-- /product tab content  -->
                    </div>
                </div>
                <!-- /product tab -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3 class="title">Related Products</h3>
                    </div>
                </div>

                @foreach ($relatedProducts as $item)
                    <!-- product -->
                    <div class="col-md-3 col-xs-6">
                        <div class="product">
                            <div class="product-img">
                                <img src="{{ asset('product_image/' . $item->photo) }}" alt="">
                                @if ($item->discount)
                                    <div class="product-label">
                                        <span class="sale">-30%</span>
                                    </div>
                                @endif
                            </div>
                            <div class="product-body">
                                <p class="product-category">{{ $item->category_name }}</p>
                                <h3 class="product-name"><a
                                        href="{{route('user#detailProduct', $item->id)}}">{{ $item->name }}</a></h3>
                                @if ($item->discount)
                                    <h4 class="product-price">{{ $item->price - ($item->price * $item->discount) / 100 }} MMK <del
                                            class="product-old-price">{{ $item->price }} MMK</del></h4>
                                @else
                                    <h4 class="product-price">{{ $item->price }} MMK</h4>
                                @endif
                                <div class="product-rating">
                                </div>
                                <div class="product-btns d-flex justify-content-center">
                                    <form action="{{route('user#wishList')}}" method="POST" class="wishlist-form d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$item->id}}">
                                        <button type="submit" class="add-to-wishlist" aria-label="Toggle wishlist">
                                            <i
                                                class="fa {{ in_array($item->id, $wishlistProductIds ?? []) ? 'fa-heart' : 'fa-heart-o' }}"></i><span
                                                class="tooltipp"></span>
                                        </button>
                                    </form>
                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to
                                            compare</span></button>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <a href="{{route('user#detailProduct', $item->id)}}">
                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /product -->
                @endforeach

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Section -->
@endsection
