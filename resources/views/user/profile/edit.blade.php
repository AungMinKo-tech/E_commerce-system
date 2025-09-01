@extends('user.layouts.master')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style="border-radius: 6px; overflow: hidden;">
                        <div class="panel-heading" style="background:#f8f9fa; padding: 15px 20px; border-bottom:1px solid #eee;">
                            <h3 class="panel-title" style="margin:0; font-weight:600;">Edit Profile</h3>
                        </div>
                        <div class="panel-body" style="padding: 20px;">
                            <form action="{{route('user#updateProfile')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <div style="margin-bottom: 15px;">
                                            @if(Auth::user() && Auth::user()->profile)
                                                <img id="profilePreview" src="{{ asset('profile/' . Auth::user()->profile) }}" alt="Profile" class="img-responsive img-circle" style="width:140px; height:140px; object-fit:cover; margin:0 auto;">
                                            @else
                                                <div id="profilePreviewPlaceholder" class="img-circle" style="width:140px; height:140px; line-height:140px; margin:0 auto; background:#e9ecef; color:#6c757d; text-align:center; font-size:48px;">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <img id="profilePreview" src="" alt="Preview" class="img-responsive img-circle" style="display:none; width:140px; height:140px; object-fit:cover; margin:0 auto;">
                                            @endif
                                        </div>
                                        <label class="btn btn-primary" style="margin-bottom: 0;">
                                            <i class="fa fa-upload"></i> Change Photo
                                            <input type="file" name="image" id="image" accept="image/*" style="display:none;">
                                        </label>
                                        @error('image')
                                            <small class="text-danger" style="display:block; margin-top:6px;">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="form-group @error('name') has-error @enderror">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" placeholder="Enter your name">
                                            @error('name')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('nickname') has-error @enderror">
                                            <label for="nickname">Nickname</label>
                                            <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname', Auth::user()->nickname ?? '') }}" placeholder="Enter your nickname">
                                            @error('nickname')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('email') has-error @enderror">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="Enter your email">
                                            @error('email')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('phone') has-error @enderror">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="Enter your phone number">
                                            @error('phone')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('address') has-error @enderror">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your address">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                                            @error('address')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('city') has-error @enderror">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', Auth::user()->city ?? '') }}" placeholder="Enter your city">
                                            @error('city')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('date_of_birth') has-error @enderror">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth ?? '') }}">
                                            @error('date_of_birth')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('gender') has-error @enderror">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" id="gender" name="gender">
                                                @php($g = old('gender', Auth::user()->gender ?? ''))
                                                <option value="">Select gender</option>
                                                <option value="male" {{ $g === 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ $g === 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ $g === 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right" style="margin-top:10px;">
                                    <a href="{{ route('user#home') }}" class="btn btn-default">Cancel</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var input = document.getElementById('image');
            if (!input) return;
            input.addEventListener('change', function(e) {
                var file = e.target.files && e.target.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function(evt) {
                    var img = document.getElementById('profilePreview');
                    var placeholder = document.getElementById('profilePreviewPlaceholder');
                    if (placeholder) { placeholder.style.display = 'none'; }
                    if (img) {
                        img.src = evt.target.result;
                        img.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            });
        })();
    </script>
@endsection
