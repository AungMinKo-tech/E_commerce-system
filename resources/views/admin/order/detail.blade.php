@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h3 class="fw-bold mb-0">Order Details</h3>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin#orderList') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Orders
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-xl-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-md">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded bg-primary d-flex align-items-center justify-content-center text-white">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Order Code</div>
                                            <div class="fs-5 fw-semibold">
                                                    {{ $order->order_code }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-auto">
                                    <div class="text-muted small">Status</div>
                                    <div>
                                            @if ($order->status == 0)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($order->status == 1)
                                                <span class="badge badge-info">Accept</span>
                                            @elseif ($order->status == 2)
                                                <span class="badge badge-primary">Shipping</span>
                                            @elseif ($order->status == 3)
                                                <span class="badge badge-danger">Reject</span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-6 col-md-auto">
                                    <div class="text-muted small">Order Date</div>
                                    <div class="fw-semibold">
                                            {{ ($order->created_at ?? now())->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Items</h6>
                            <span class="text-muted small">
                                    {{ $order->items_count ?? ($items->count() ?? 0) }} items
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 220px;">Product</th>
                                            <th>Color</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @forelse ($items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <img src="{{ asset('product_image/' . $item->product_photo) }}" alt="{{ $item->product_name }}" class="rounded border" style="width: 64px; height: 64px; object-fit: cover;">
                                                            <div>
                                                                <div class="fw-semibold">{{ $item->product_name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $item->color_name }}</span>
                                                    </td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">{{ $item->price }}</td>
                                                    <td class="text-end">{{ isset($item->subtotal) ? (int) $item->subtotal : ((int) ($item->price ?? 0) * (int) ($item->quantity ?? 0)) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No items found.</td>
                                                </tr>
                                            @endforelse

                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-end mt-3">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-semibold">
                                                {{ (int) ($order->total_amount ?? 0) }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-muted">Voucher Code</span>
                                        <span class="fw-semibold">
                                            @isset($order)
                                                {{ $order->voucher_code ?? '-' }}
                                            @endisset
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span class="text-muted">Shipping</span>
                                        <span class="fw-semibold">
                                            3500 MMK
                                        </span>
                                    </div>
                                    <div class="border-top my-2"></div>
                                    <div class="d-flex justify-content-between py-1 fs-5">
                                        <span class="fw-semibold">Grand Total</span>
                                        <span class="fw-bold text-primary">
                                            @isset($order)
                                                {{ (int) ($order->total_amount ?? 0) + 3500 }} MMK
                                            @endisset
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <form action="" method="POST">
                        <div class="card mb-3">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h6 class="mb-0">Manage Order</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Delivery Man</label>
                                    <select class="form-select">
                                        @isset($deliveryMans)
                                            <option value="">Select delivery man</option>
                                            @foreach ($deliveryMans as $man)
                                                <option value="{{ $man->id }}"
                                                    @isset($order)
                                                        {{ ($order->delivery_man_id ?? null) == $man->id ? 'selected' : '' }}
                                                    @endisset
                                                >
                                                    {{ $man->name ?? ($man->nickname ?? 'Unnamed') }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">Status</label>
                                    <select class="form-select">
                                        @php
                                            $currentStatus = isset($order) ? ($order->status ?? 0) : 0;
                                        @endphp
                                        <option value="0" {{ ($currentStatus === 0) ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ ($currentStatus === 1) ? 'selected' : '' }}>Accept</option>
                                        <option value="2" {{ ($currentStatus === 2) ? 'selected' : '' }}>Shipping</option>
                                        <option value="3" {{ ($currentStatus === 3) ? 'selected' : '' }}>Reject</option>
                                    </select>
                                </div>

                                <div class="mt-3 text-center">
                                    <button type="submit" class="btn-md btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Customer</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">
                                        @isset($order)
                                            {{ $order->name == null ? $order->nickname : $order->name }}
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small">Phone</div>
                                <div class="fw-semibold">
                                    @isset($order)
                                        {{ $order->phone ?? '—' }}
                                    @endisset
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="text-muted small">Address</div>
                                <div class="fw-semibold">
                                    {{ $order->address ?? '—' }}
                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="text-muted small">City</div>
                                <div class="fw-semibold">
                                    {{ $order->city ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Shipping</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Method</span>
                                <span class="fw-semibold">
                                    @isset($order)
                                        Delivery
                                    @endisset
                                </span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Name</span>
                                <span class="fw-semibold">{{ $shipping->name ?? '—' }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Phone</span>
                                <span class="fw-semibold">{{ $shipping->phone ?? '—' }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Address</span>
                                <span class="fw-semibold">{{ $shipping->address}}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping City</span>
                                <span class="fw-semibold">{{ $shipping->city}}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Order Note</span>
                                <span class="fw-semibold">{{ $shipping->order_note ?? '--'}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Method</span>
                                <span class="fw-semibold">
                                    @isset($order)
                                        {{ $order->account_type ?? 'Card' }}
                                    @endisset
                                </span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Transaction ID</span>
                                <span class="fw-semibold">
                                    @isset($order)
                                        {{ $order->transaction_id ?? '—' }}
                                    @endisset
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Payment Status</span>
                                <span class="fw-semibold">
                                    @isset($order)
                                        {{ $order->payment_status ?? 'Paid' }}
                                    @endisset
                                </span>
                            </div>

                            <div class="mt-3">
                                <div class="text-muted small mb-1">Payment Image</div>
                                @isset($order)
                                    @if (!empty($order->payslip_image))
                                        <a href="{{ asset('payslip_image/' . $order->payslip_image) }}" target="_blank">
                                            <img src="{{ asset('payslip_image/' . $order->payslip_image) }}" alt="Payment slip" class="img-fluid rounded border" style="max-height: 300px; width: 100%; object-fit: contain;" />
                                        </a>
                                    @else
                                        <div class="border rounded bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                            <span class="text-muted">No payment image</span>
                                        </div>
                                    @endif
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
