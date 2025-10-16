@extends('admin.layouts.master')

@section('title', 'Delivery Dashboard')

@section('content')
    <div class="container">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Pending Delivery List</h4>
                </div>

                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-truck text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Today's Deliveries</p>
                                            <h4 class="card-title">{{ $shippingList->count() ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Row -->
                <div class="row">
                    <!-- Assigned Deliveries -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Assigned Deliveries</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Phone</th>
                                                <th>Order Note</th>
                                                <th>Assignment Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($shippingList as $delivery)
                                                <tr>
                                                    <td>{{ $delivery->order_code }}</td>
                                                    <td>{{ $delivery->shipping_name }}</td>
                                                    <td>{{ $delivery->shipping_address }}</td>
                                                    <td>{{ $delivery->shipping_city }}</td>
                                                    <td>{{ $delivery->shipping_phone }}</td>
                                                    <td>{{ $delivery->order_note }}</td>
                                                    <td>{{ $delivery->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <form action="{{route('delivery#complete')}}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="order_code"
                                                                value="{{ $delivery->order_code }}">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">Delivered</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center">No deliveries assigned</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
