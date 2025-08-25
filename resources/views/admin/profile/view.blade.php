@extends('admin.layouts.master')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Profile View</h4>
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
                    <a href="#">View Profile</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Profile Information</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('admin#editProfile') }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                            <a href="{{ route('admin#changePassword') }}" class="btn btn-warning mr-2">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Picture Section -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="profile-picture">
                                            <img src="{{ Auth::user()->profile ? asset('profile/' . Auth::user()->profile) : asset('default/default_profile.jpg') }}"
                                                alt="Profile Picture" class="rounded-circle"
                                                style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #e3e6f0;">
                                        </div>
                                        <div class="mt-3">
                                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                            <p class="text-muted mb-2">{{ Auth::user()->role}}</p>
                                            <span class="badge badge-success">
                                                <i class="fas fa-circle"></i> Active
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Information Section -->
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-md-12">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-user"></i> Basic Information
                                        </h5>
                                    </div>

                                    <!-- Full Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Full Name</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->name ?? 'Unknown' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nickname -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Nickname</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->nickname ?? 'Unknown' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Email Address</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->email }}</strong>
                                                @if(Auth::user()->email_verified_at)
                                                    <span class="badge badge-success ml-2">
                                                        <i class="fas fa-check"></i> Verified
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning ml-2">
                                                        <i class="fas fa-exclamation-triangle"></i> Not Verified
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Phone Number</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->phone ?? 'N/A' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Gender</label>
                                            <div class="form-control-plaintext">
                                                <strong>
                                                    @if(Auth::user()->gender)
                                                        {{ ucfirst(Auth::user()->gender) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Date of Birth</label>
                                            <div class="form-control-plaintext">
                                                <strong>
                                                    @if(Auth::user()->date_of_birth)
                                                        {{ \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('F j, Y') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address Information -->
                                    <div class="col-md-12 mt-4">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-map-marker-alt"></i> Address Information
                                        </h5>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Address</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->address ?? 'N/A' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">City</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->city ?? 'N/A' }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Information -->
                                    <div class="col-md-12 mt-4">
                                        <h5 class="mb-3 text-primary">
                                            <i class="fas fa-shield-alt"></i> Account Information
                                        </h5>
                                    </div>

                                    <!-- Role -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Role</label>
                                            <div class="form-control-plaintext">
                                                <span class="badge badge-info">
                                                    {{ ucfirst(Auth::user()->role) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Created -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-muted">Account Created</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ Auth::user()->created_at->format('F j, Y \a\t g:i A') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .page-inner {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .form-control-plaintext {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            padding: 0.75rem;
            min-height: 45px;
            display: flex;
            align-items: center;
        }

        .profile-picture img {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-picture img:hover {
            transform: scale(1.05);
        }

        .card-action {
            display: flex;
            align-items: center;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }

        .text-primary {
            color: #007bff !important;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
        }
    </style>
@endpush
