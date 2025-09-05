@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 100px">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="fw-bold mb-0">Voucher Management</h3>
                <a href="{{ route('admin#voucherCreatePage') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Voucher
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title mb-0">All Vouchers</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($vouchers->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped" id="voucherTable">
                                        <thead>
                                            <tr>
                                                <th>Voucher Code</th>
                                                <th>Discount Amount</th>
                                                <th>Usage</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vouchers as $voucher)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-primary me-2">{{ $voucher->voucher_code }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">{{ number_format($voucher->voucher_price) }} MMK</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $voucher->use_count }}</span>
                                                            <span class="text-muted">/</span>
                                                            <span class="ms-2">{{ $voucher->max_usage }}</span>
                                                            <div class="progress ms-2" style="width: 60px; height: 6px;">
                                                                @php
                                                                    $usagePercentage = $voucher->max_usage > 0 ? ($voucher->use_count / $voucher->max_usage) * 100 : 0;
                                                                @endphp
                                                                <div class="progress-bar {{ $usagePercentage >= 100 ? 'bg-danger' : ($usagePercentage >= 80 ? 'bg-warning' : 'bg-success') }}"
                                                                     style="width: {{ min($usagePercentage, 100) }}%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $currentDate = now()->toDateString();
                                                            $isExpired = $voucher->end_date < $currentDate;
                                                            $isActive = $voucher->status === 'active' && !$isExpired;
                                                        @endphp
                                                        @if($isExpired)
                                                            <span class="badge bg-danger">Expired</span>
                                                        @elseif($voucher->status === 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($voucher->start_date)->format('M d, Y') }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($voucher->end_date)->format('M d, Y') }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($voucher->created_at)->format('M d, Y') }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('admin#voucherEdit', $voucher->id) }}"
                                                               class="btn btn-sm btn-outline-warning"
                                                               title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin#voucherDelete', $voucher->id) }}"
                                                                  method="POST"
                                                                  style="display: inline-block;"
                                                                  onsubmit="return confirm('Are you sure you want to delete voucher \'{{ $voucher->voucher_code }}\'? This action cannot be undone.')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($vouchers->hasPages())
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $vouchers->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-ticket-alt" style="font-size: 4rem; color: #dee2e6;"></i>
                                    </div>
                                    <h5 class="text-muted">No vouchers found</h5>
                                    <p class="text-muted">Create your first voucher to get started.</p>
                                    <a href="{{ route('admin#voucherCreatePage') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Create Voucher
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

