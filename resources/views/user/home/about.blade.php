@extends('user.layouts.master')

@section('content')

    <!-- About Start -->
    <div class="container-fluid pt-5 mt-3" style="margin-top: 20px;">
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-6" style="min-height: 400px;">
                    <div class="h-100">
                        <img class="w-50 h-50" src="{{ asset('default/about.jpg') }}"
                            style="width: 500px; height: 450px;" alt="About Us Image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h3 class="mb-3">Welcome To Our E-Commerce Store</h3>
                        <h4 class="text-primary">Our Story</h4>
                    </div>
                    <p class="mb-4">We started our journey with a simple idea: to make high-quality products accessible to
                        everyone. Our passion for excellence and commitment to our customers has been the driving force
                        behind our growth. From a small startup, we have grown into a trusted online destination for
                        shoppers worldwide.</p>
                    <div class="mb-4">
                        <h4 class="text-primary">Our Mission</h4>
                    </div>
                    <p class="mb-4">Our mission is to provide an unparalleled shopping experience by offering a curated
                        selection of top-tier products, exceptional customer service, and a seamless and secure checkout
                        process. We believe in building lasting relationships with our customers based on trust and
                        satisfaction.</p>
                    <a href="{{ route('user#home') }}" class="btn btn-primary py-3 px-5 mt-3">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Services Start -->
    <div class="container-fluid py-5" style="margin-top: 20px">
        <div class="container">
            <div class="text-center mb-5 mt-3">
                <h1 class="mb-3">Why Choose Us</h1>
            </div>
            <div class="row g-4" style="margin-top: 50px">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-award text-white"></i>
                        </div>
                        <h4 class="mb-3">Quality Products</h4>
                        <p class="m-0">We offer a curated selection of high-quality products from trusted brands.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fas fa-2x fa-exchange-alt text-white"></i>
                        </div>
                        <h4 class="mb-3">14-Day Return</h4>
                        <p class="m-0">Not satisfied? We offer a 14-day return policy for a hassle-free exchange or refund.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-phone-alt text-white"></i>
                        </div>
                        <h4 class="mb-3">24/7 Support</h4>
                        <p class="m-0">Our dedicated support team is here to help you with any questions or issues.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Team Start -->
    <div class="container-fluid py-5" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="container">
            <div class="text-center mx-auto mb-5">
                <h1 class="mb-3">Meet Our Team</h1>
                <p>The dedicated individuals who work tirelessly to bring you the best products and services.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('user/img/team-1.jpg') }}" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href=""><i class="fa fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">John Doe</h5>
                            <small>Founder & CEO</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('user/img/team-2.jpg') }}" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href=""><i class="fa fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Jane Smith</h5>
                            <small>Chief Operating Officer</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('user/img/team-3.jpg') }}" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href=""><i class="fa fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Peter Jones</h5>
                            <small>Head of Marketing</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('user/img/team-4.jpg') }}" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href=""><i class="fa fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fa fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Mary Brown</h5>
                            <small>Customer Support Lead</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
@endsection
