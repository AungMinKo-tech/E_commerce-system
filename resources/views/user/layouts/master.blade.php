<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Electro - HTML Ecommerce Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}" />
    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    --}}

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('user/css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('user/css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('user/css/nouislider.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('user/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('user/css/style.css') }}" />

    <!-- Order List CSS -->
    @if(request()->routeIs('user#orderPage'))
        <link type="text/css" rel="stylesheet" href="{{ asset('user/css/order-list.css') }}" />
    @endif

</head>

<body>
    <!-- HEADER -->
    <header>
        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="#" class="logo">
                                <img src="./img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- ACCOUNT -->
                    <div class="col-md-9">
                        <div class="header-ctn">
                            <!-- Wishlist -->
                            <div class=>
                                <a href="{{route('user#viewWishList')}}">
                                    <i class="fa fa-heart-o"></i>
                                    <span>Your Wishlist</span>
                                    <div class="qty" id="wishlist-count">
                                        {{ isset($sharedWishlistCount) ? $sharedWishlistCount : 0 }}
                                    </div>
                                </a>
                            </div>
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <div class="">
                                <a href="{{route('user#cart')}}">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Your Cart</span>
                                    <div class="qty">{{ isset($sharedCartCount) ? $sharedCartCount : 0 }}</div>
                                </a>
                            </div>
                            <!-- /Cart -->

                            <!-- Profile -->
                            <div class="dropdown header-profile">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::check() && Auth::user()->profile)
                                        <img src="{{ asset('profile/' . Auth::user()->profile) }}" alt="Profile">
                                    @else
                                        <img src="{{ asset('default/default_profile.jpg') }}" alt="Profile">
                                    @endif
                                    <div class="qty" style="visibility: hidden;">0</div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right p-0 border-0 shadow"
                                    style="min-width:220px; background: #f8f9fa;">
                                    <li class="border-bottom">
                                        <a href="{{route('user#editProfile')}}"
                                            class="dropdown-item py-3 px-4 d-flex align-items-center"
                                            style="font-weight: 500;">
                                            <i class="fa fa-user mr-2 text-primary"></i>
                                            Change Profile
                                        </a>
                                    </li>
                                    <li class="border-bottom">
                                        <a href="{{route('user#changePasswordPage')}}"
                                            class="dropdown-item py-3 px-4 d-flex align-items-center"
                                            style="font-weight: 500;">
                                            <i class="fa fa-lock mr-2 text-warning"></i>
                                            Change Password
                                        </a>
                                    </li>
                                    <li class="border-bottom">
                                        <a href="{{route('user#orderPage')}}"
                                            class="dropdown-item py-3 px-4 d-flex align-items-center"
                                            style="font-weight: 500;">
                                            <i class="fa fa-bars mr-2 text-warning"></i>
                                            Order List
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit"
                                                class="dropdown-item py-3 px-4 d-flex align-items-center text-danger"
                                                style="font-weight: 500; background: none; border: none; width: 100%;">
                                                <i class="fa fa-sign-out mr-2"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <!-- /Profile -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="active"><a href="{{ route('user#home') }}">Home</a></li>
                    <li><a href="{{route('user#categoryPage')}}">Categories</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Map</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->

    @yield('content')
    @include('sweetalert::alert')

    <!-- FOOTER -->
    <footer id="footer">
        <!-- top footer -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Cameras</a></li>
                                <li><a href="#">Accessories</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Information</h3>
                            <ul class="footer-links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->

        <!-- bottom footer -->
        <div id="bottom-footer" class="section">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                        </ul>
                        <span class="copyright">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>document.write(new Date().getFullYear());</script> All rights reserved | This
                            template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
                                href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </span>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bottom footer -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{ asset('user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <script src="{{ asset('user/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>

    <script>
        $(document).on('submit', '.wishlist-form', function (e) {
            e.preventDefault();
            const $form = $(this);
            const url = $form.attr('action');
            const data = $form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $form.find('input[name="_token"]').val()
                },
                success: function (res) {
                    if (res && typeof res.count !== 'undefined') {
                        $('#wishlist-count').text(res.count);
                    }
                    // toggle heart icon fill
                    const $icon = $form.find('.add-to-wishlist i');
                    if (res.status === 'added') {
                        $icon.removeClass('fa-heart-o').addClass('fa-heart');
                    } else if (res.status === 'removed') {
                        $icon.removeClass('fa-heart').addClass('fa-heart-o');
                    }
                },
                error: function () {
                    console.log('error');

                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
