@extends('admin.layouts.master')

@if (Auth::user()->role == 'delivery')
    @section('title', 'Deliverey Dashboard')
@endif

@section('content')
    <div class="container">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Delivered List</h4>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-check text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Completed</p>
                                            <h4 class="card-title">{{ $deliveredList->count() }}</h4>
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
                                    <h4 class="card-title">Completed Deliveries</h4>
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
                                                <th>Assigned Time</th>
                                                <th>Delivery Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($deliveredList as $delivery)
                                                <tr>
                                                    <td>{{ $delivery->order_code }}</td>
                                                    <td>{{ $delivery->shipping_name }}</td>
                                                    <td>{{ $delivery->shipping_address }}</td>
                                                    <td>{{ $delivery->shipping_city }}</td>
                                                    <td>{{ $delivery->shipping_phone }}</td>
                                                    <td>{{ $delivery->order_note }}</td>
                                                    <td>{{ $delivery->updated_at->format('M d, Y H:i') }}</td>
                                                    <td>{{ $delivery->delivery_name }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center">No deliveries completed</td>
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
