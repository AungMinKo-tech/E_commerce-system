@extends('admin.layouts.master')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Account Details</h4>
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
                    <a href="{{ route('admin#adminList') }}">Accounts</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Details</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">
                                Delivery Profile
                            </h4>
                            <small class="text-muted">ID: {{ $delivery->delivery_man_id }}</small>
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="text-center mb-4">
                                    <img src="{{ $delivery->profile != null ? asset('profile/' . $delivery->profile) : asset('default/default_profile.jpg')}}"
                                        class="rounded-circle" width="140" height="140" alt="Profile">
                                    <h5 class="mt-3 mb-1">
                                        {{ $delivery->name != null ? $delivery->name : $delivery->nickname }}</h5>
                                    <span class="badge badge-danger">
                                        {{ $delivery->role }}
                                    </span>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Email</span>
                                        <strong>{{ $delivery->email }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Phone</span>
                                        <strong>{{ $delivery->phone }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Address</span>
                                        <strong class="text-end" style="max-width: 60%">{{ $delivery->address }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Joined</span>
                                        <strong>{{ $delivery->created_at->format('d/m/Y') }}</strong>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Additional Information</h5>
                                            </div>
                                            <div class="card-body">


                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-muted mb-1">Vehicle</label>
                                                        <div><strong>{{ $delivery->vehicle }}</strong></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-muted mb-1">License No.</label>
                                                        <div><strong>{{ $delivery->license }}</strong></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-muted mb-1">Delivery Zone</label>
                                                        <div><strong>{{ $delivery->delivery_zone }}</strong></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-muted mb-1">Work Time</label>
                                                        <div><strong>{{ $delivery->work_time }}</strong></div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="text-muted mb-1">CV/Document</label>
                                                        <div>
                                                            @if(!empty($delivery->document_cv))
                                                                <a href="{{ asset('cv_form/' . $delivery->document_cv) }}"
                                                                    target="_blank" class="btn btn-outline-primary btn-sm">
                                                                    <i class="fa fa-file"></i> View Document
                                                                </a>
                                                            @else
                                                                <span>-</span>
                                                            @endif
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
            </div>
        </div>
    </div>

@endsection
