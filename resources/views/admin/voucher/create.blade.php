@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 100px">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="fw-bold mb-0">Create Voucher</h3>
                <a href="{{ route('admin#voucherList') }}" class="btn btn-outline-primary">
                    <i class="fas fa-list me-1"></i>View All Vouchers
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin#voucherCreate') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="voucher_code" class="form-label fw-semibold">Voucher Code <span class="text-danger">*</span></label>
                                        <input type="text" id="voucher_code" class="form-control @error('voucher_code') is-invalid @enderror"
                                               placeholder="Enter voucher code (e.g., SAVE20)" name="voucher_code"
                                               value="{{ old('voucher_code') }}" required>
                                        @error('voucher_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Use uppercase letters and numbers only</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="voucher_price" class="form-label fw-semibold">Discount Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">MMK</span>
                                            <input type="number" id="voucher_price" class="form-control @error('voucher_price') is-invalid @enderror"
                                                   placeholder="0.00" step="0.01" min="0" name="voucher_price"
                                                   value="{{ old('voucher_price') }}" required>
                                        </div>
                                        @error('voucher_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="max_usage" class="form-label fw-semibold">Maximum Usage <span class="text-danger">*</span></label>
                                        <input type="number" id="max_usage" class="form-control @error('max_usage') is-invalid @enderror"
                                               placeholder="Enter maximum usage count" name="max_usage"
                                               value="{{ old('max_usage') }}" min="1" required>
                                        @error('max_usage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">How many times this voucher can be used</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                        <select id="status" class="form-select @error('status') is-invalid @enderror" name="status" required>
                                            <option value="" selected disabled>Select status</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                               name="start_date" value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="end_date" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                                        <input type="date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                                               name="end_date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Create Voucher
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

