@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Add New Admin</h2>
                        </div>
                    </div>
                </div>

                <!-- New Admin  -->
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-primary">Add New Admin</h4>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="userTabsContent">

                                    <form class="needs-validation" action="{{route('admin#newAdmin')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="adminName" class="form-label">
                                                        <i class="fas fa-user me-2"></i>Full Name <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="adminName" name="name" value="{{old('name')}}">
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="adminEmail" class="form-label">
                                                        <i class="fas fa-envelope me-2"></i>Email Address <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="adminEmail" name="email" value="{{old('email')}}">
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="adminPhone" class="form-label">
                                                        <i class="fas fa-phone me-2"></i>Phone Number <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="tel"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        id="adminPhone" name="phone" value="{{old('phone')}}">
                                                    @error('phone')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="adminRole" class="form-label">
                                                        <i class="fas fa-user-tag me-2"></i>Admin Role <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select @error('role') is-invalid @enderror"
                                                        id="adminRole" name="role">
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="adminPassword" class="form-label">
                                                        <i class="fas fa-lock me-2"></i>Password <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="adminPassword" name="password">
                                                    @error('password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="adminConfirmPassword" class="form-label">
                                                        <i class="fas fa-lock me-2"></i>Confirm Password <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="password"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        id="adminConfirmPassword" name="password_confirmation">
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="adminAddress" class="form-label">
                                                <i class="fas fa-map-marker-alt me-2"></i>Address
                                            </label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                id="adminAddress" name="address" rows="3">{{old('address')}}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="adminDocuments" class="form-label">
                                                <i class="fas fa-file-alt me-2"></i>Admin Documents
                                            </label>
                                            <input type="file" class="form-control @error('documents') is-invalid @enderror"
                                                id="adminDocuments" name="documents">
                                            @error('documents')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">Upload admin documents (ID, certificates, etc.)</div>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Add Admin
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
