<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and icons -->
    <script src="{{asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="{{ asset('admin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                            class="navbar-brand" height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            @if (Auth::user()->role != 'delivery')
                <div class="sidebar-wrapper scrollbar scrollbar-inner">
                    <div class="sidebar-content">
                        <ul class="nav nav-secondary">
                            <li class="nav-item">
                                <a href="{{ route('admin#dashboard') }}">
                                    <i class="fas fa-home"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin#category')}}">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Category</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin#addColor')}}">
                                    <i class="fas fa-paint-roller"></i>
                                    <p>Add Color</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin#addProductPage') }}">
                                    <i class="fas fa-plus"></i>
                                    <p>Add Product</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin#productList') }}">
                                    <i class="fas fa-list-ol"></i>
                                    <p>Product List</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin#saleInfo')}}">
                                    <i class="fas fa-chart-line"></i>
                                    <p>Sale Information</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin#orderList')}}">
                                    <i class="fas fa-clipboard-list"></i>
                                    <p>Order Board</p>
                                </a>
                            </li>

                            @if (Auth::user()->role == 'owner')
                                <li class="nav-item">
                                    <a href="{{route('admin#listPayment')}}">
                                        <i class="fas fa-credit-card"></i>
                                        <p>Payment Method</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin#voucherList') }}">
                                        <i class="fas fa-ticket-alt"></i>
                                        <p>Manage Voucher</p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('admin#delivered') }}">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Delivered Order</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin#wishListPage') }}">
                                    <i class="fas fa-heart"></i>
                                    <p>Wishlist</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin#changePassword')}}">
                                    <i class="fas fa-key"></i>
                                    <p>Change Password</p>
                                </a>
                            </li>

                        </ul>

                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">Logout</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="sidebar-wrapper scrollbar scrollbar-inner">
                    <div class="sidebar-content">
                        <ul class="nav nav-secondary">
                            <li class="nav-item">
                                <a href="{{ route('delivery#home') }}">
                                    <i class="fas fa-home"></i>
                                    <p>Pending Delivery List</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('delivery#delivered') }}">
                                    <i class="fas fa-layer-group"></i>
                                    <p>My Delivered</p>
                                </a>
                            </li>
                        </ul>
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">Logout</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="{{ asset('admin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                                class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            @if (Auth::user()->role != 'delivery')
                                <li>
                                    <a href="{{ route('admin#message') }}"><i class="fa fa-envelope"></i></a>
                                </li>
                            @endif

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('default/default_profile.jpg')}}"
                                            alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span
                                            class="fw-bold">{{(Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname)}}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="{{Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('default/default_profile.jpg')}}"
                                                        alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>{{(Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname)}}
                                                    </h4>
                                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                                    <a href="{{route('admin#viewProfile')}}"
                                                        class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{route('admin#editProfile')}}">Change
                                                Profile</a>

                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{route('admin#changePassword')}}">Change
                                                Password</a>

                                            @if (Auth::user()->role == 'owner')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{route('admin#newAdminPage')}}">Add New
                                                    Admin</a>

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{route('admin#newDeliveryPage')}}">Add New
                                                    Delivery Man</a>
                                            @endif

                                            @if (Auth::user()->role != 'delivery')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{route('admin#adminList')}}">
                                                    Admin|Delivery|User List</a>
                                            @endif

                                            <div class="dropdown-divider"></div>
                                            <form action="{{route('logout')}}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            @yield('content')

            @include('sweetalert::alert')

        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Logo Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Navbar Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeTopBarColor" data-color="dark"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="green"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange"></button>
                            <button type="button" class="changeTopBarColor" data-color="red"></button>
                            <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="green2"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                            <button type="button" class="changeTopBarColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeSideBarColor" data-color="white"></button>
                            <button type="button" class="selected changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="icon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('admin/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('admin/assets/js/setting-demo.js') }}"></script>

    @yield('script')
</body>

</html>
