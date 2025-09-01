@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 50px">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Payment Methods</h3>
                    <p class="text-muted mb-0">Create and manage available payment methods</p>
                </div>
            </div>

            <!-- Create Payment Method -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Add New Payment Method</h5>
                    <form action="{{route('admin#paymentCreate')}}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Name</label>
                            <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror" placeholder="e.g., John Doe">
                            @error('account_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Number</label>
                            <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="e.g., 09123456789">
                            @error('account_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Account Number</label>
                            <input type="text" name="account_type" class="form-control @error('account_type') is-invalid @enderror" placeholder="e.g., KBZ Pay">
                            @error('account_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Method
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Payment Methods Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="paymentsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Account Name</th>
                                    <th>Account Number</th>
                                    <th>Type</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($payments)
                                    @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->account_name }}</td>
                                        <td>{{ $payment->account_number }}</td>
                                        <td>{{ $payment->account_type }}</td>
                                        <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No payment methods to display.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
