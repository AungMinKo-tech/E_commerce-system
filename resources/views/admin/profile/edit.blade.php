@extends('admin.layouts.master')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Edit Profile</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin#dashboard') }}">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Profile</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Edit Profile</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Profile Information</h4>
                            <p class="text-muted">Update your personal information and profile picture</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin#updateProfile')}}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            <div class="row">
                                <!-- Profile Picture Section -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="avatar-upload">
                                                <div class="avatar-preview">
                                                    <div id="imagePreview" class="rounded-circle"
                                                        style="width: 150px; height: 150px; margin: 0 auto 20px; background-size: cover; background-position: center; border: 3px solid #e3e6f0; position: relative;">
                                                        <img id="previewImg"
                                                            src="{{ Auth::user()->profile ? asset('profile/' . Auth::user()->profile) : asset('default/default_profile.jpg') }}"
                                                            alt="Profile Picture" class="rounded-circle"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" id="profile_image" name="profile" accept="image/*"
                                                        class="d-none">
                                                    <label for="profile_image" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-camera"></i> Change Photo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Form Section -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Full Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                                    placeholder="Enter your full name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- nickname -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nickname" class="form-label">Nickame</label>
                                                <input type="text" class="form-control @error('nickname') is-invalid @enderror"
                                                    id="nickname" nickname="nickname" value="{{ old('nickname', Auth::user()->nickname) }}"
                                                    placeholder="Enter your full nickname">
                                                @error('nickname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email Address <span
                                                        class="text-danger">*</span></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', Auth::user()->email) }}"
                                                    placeholder="Enter your email address">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                    id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                                    placeholder="Enter your phone number">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                <input type="date"
                                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                                    id="date_of_birth" name="date_of_birth"
                                                    value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}">
                                                @error('date_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select class="form-control @error('gender') is-invalid @enderror"
                                                    id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="other" {{ old('gender', Auth::user()->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror" id="address"
                                                    name="address" value="{{ old('address', Auth::user()->address) }}"
                                                    placeholder="Enter your address">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- City -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                                    id="city" name="city" value="{{ old('city', Auth::user()->city) }}"
                                                    placeholder="Enter your city">
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card-action">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Profile
                                        </button>
                                        <a href="{{ route('admin#dashboard') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Profile image preview
            $('#profile_image').change(function () {
                const file = this.files[0];

                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            })
        });
    </script>
@endsection
