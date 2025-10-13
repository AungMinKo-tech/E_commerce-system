@extends('user.layouts.master')

@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Contact</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <form action="{{ route('user#contactForm') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="col-md-6" style="max-width: 600px">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control mb-3 @error('name') is-invalid @enderror" id="name" placeholder="Name" name="name">
                            @error('name')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3" style="margin-top: 30px;">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" name="email">
                            @error('email')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3" style="margin-top: 30px;">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" rows="5" name="message"></textarea>
                            @error('message')
                                <div class="invalid-feedback text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3" style="margin-top: 30px;">
                            <button type="submit" class="btn primary-btn order-submit">Send</button>
                        </div>
                    </div>
                </form>
                <div class="col-md-6" style="margin-top: 30px;">
                    <img src="{{ asset('default/contact.jpg') }}" alt="" style="width: 600px">
                </div>
            </div>
        </div>
    </div>
@endsection
