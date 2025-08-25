@extends('admin.layouts.master')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Add New Delivery</h2>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-primary">Add New Delivey</h4>
                            </div>
                            <div class="card-body">

                                <form class="needs-validation" action="{{route('admin#newDelivery')}}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryName" class="form-label">
                                                    <i class="fas fa-user me-2"></i>Full Name <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="deliveryName" name="name" value="{{old('name')}}">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryEmail" class="form-label">
                                                    <i class="fas fa-envelope me-2"></i>Email Address <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="deliveryEmail" name="email" value="{{old('email')}}">
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
                                                <label for="deliveryPhone" class="form-label">
                                                    <i class="fas fa-phone me-2"></i>Phone Number <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                    id="deliveryPhone" name="phone" value="{{old('phone')}}">
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryVehicle" class="form-label">
                                                    <i class="fas fa-motorcycle me-2"></i>Vehicle Type <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('vehicle_type') is-invalid @enderror"
                                                    id="deliveryVehicle" name="vehicle_type">
                                                    <option value="">Select Vehicle</option>
                                                    <option value="motorcycle">Motorcycle</option>
                                                    <option value="bicycle">Bicycle</option>
                                                    <option value="van">Van</option>
                                                </select>
                                                @error('vehicle_type')
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
                                                <label for="deliveryLicense" class="form-label">
                                                    <i class="fas fa-id-card me-2"></i>License Number
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('license_number') is-invalid @enderror"
                                                    id="deliveryLicense" name="license_number"
                                                    value="{{old('license_number')}}">
                                                @error('license_number')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryRole" class="form-label">
                                                    <i class="fas fa-user-tag me-2"></i> Role <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('role') is-invalid @enderror"
                                                    id="deliveryRole" name="role">
                                                    <option value="delivery">delivery</option>
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
                                                <label for="deliveryPassword" class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Password <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="deliveryPassword" name="password">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryConfirmPassword" class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Confirm Password <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    id="deliveryConfirmPassword" name="password_confirmation">
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="deliveryAddress" class="form-label">
                                            <i class="fas fa-map-marker-alt me-2"></i>Address <span
                                                class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('address') is-invalid @enderror"
                                            id="deliveryAddress" name="address" rows="3">{{old('address')}}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="deliveryDocuments" class="form-label">
                                            <i class="fas fa-file-alt me-2"></i>Documents
                                        </label>
                                        <input type="file" class="form-control @error('documents') is-invalid @enderror"
                                            id="deliveryDocuments" name="documents">
                                        @error('documents')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-text">Upload documents (License, ID, etc.)</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryZone" class="form-label">
                                                    <i class="fas fa-map me-2"></i>Delivery Zone
                                                </label>
                                                <select class="form-select @error('delivery_zone') is-invalid @enderror"
                                                    id="deliveryZone" name="delivery_zone">
                                                    <option value="">Select Zone</option>
                                                    <option value="north">North Zone</option>
                                                    <option value="south">South Zone</option>
                                                    <option value="east">East Zone</option>
                                                    <option value="west">West Zone</option>
                                                    <option value="central">Central Zone</option>
                                                </select>
                                                @error('delivery_zone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="deliveryShift" class="form-label">
                                                    <i class="fas fa-clock me-2"></i>Preferred Shift
                                                </label>
                                                <select class="form-select @error('preferred_shift') is-invalid @enderror"
                                                    id="deliveryShift" name="preferred_shift">
                                                    <option value="">Select Shift</option>
                                                    <option value="morning">Morning (6 AM - 2 PM)</option>
                                                    <option value="afternoon">Afternoon (2 PM - 10 PM)</option>
                                                    <option value="flexible">Flexible</option>
                                                </select>
                                                @error('preferred_shift')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-truck me-2"></i>Add Delivery Man
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
@endsection
