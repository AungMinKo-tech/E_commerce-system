<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{asset('authentication/css/style.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container @if($registerActive) right-panel-active @endif" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ url('register') }}" method="POST">
                @csrf
                <h1>Create Account</h1>

                <div class="form-control my-2">
                    <input type="text" name="name" placeholder="Name" class="mb-2" value="{{old('name')}}">
                    @error('name')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror


                    <input type="text" name="phone" placeholder="Phone" class="mb-2" value="{{old('phone')}}">
                    @error('phone')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror


                    <input type="email" name="email" placeholder="Email" class="mb-2" value="{{old('email')}}">
                    @error('email')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror

                    <input type="password" name="password" placeholder="Password" class="mb-2">
                    @error('password')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror

                    <input type="password" name="password_confirm" placeholder="Confirm Password" class="mb-2">
                    @error('password_confirm')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror

                    <button class="mt-3">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="{{url('login')}}" method="POST">
                @csrf
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{route('socialLogin', 'google')}}" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="{{route('socialLogin', 'github')}}" class="social"><i class="fab fa-github"></i></a>
                </div>
                <span>or use your account</span>
                <div class="form-control my-2">
                    <input type="email" name="email" placeholder="Email" class="my-2" value="{{old('email')}}"/>
                    @error('email')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror

                    <input type="password" name="password" placeholder="Password" class="mb-2" />
                    @error('password')
                        <small class="text-danger float-start">{{ $message }}</small>
                    @enderror

                    <br>

                    <a href="#">Forgot your password?</a><br>

                    <button type="submit" class="mt-3">Sign In</button>
                </div>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="{{asset('authentication/js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
