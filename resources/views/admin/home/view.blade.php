@extends('admin.layouts.master')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">User Management Dashboard</h4>
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
                    <a href="#">User Management</a>
                </li>
            </ul>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $users->count() }}</h4>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $admins->count() }}</h4>
                                <p class="mb-0">Total Admins</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-user-shield fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $deliverys->count() }}</h4>
                                <p class="mb-0">Delivery Personnel</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-truck fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabbed Interface -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="admin-tab" data-bs-toggle="tab" href="#admin" role="tab"
                                    aria-controls="admin" aria-selected="true">
                                    <i class="fa fa-user-shield"></i> Admin List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="delivery-tab" data-bs-toggle="tab" href="#delivery" role="tab"
                                    aria-controls="delivery" aria-selected="false">
                                    <i class="fa fa-truck"></i> Delivery List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user" role="tab"
                                    aria-controls="user" aria-selected="false">
                                    <i class="fa fa-users"></i> User List
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="userTabsContent">

                            <!-- Admin List Tab -->
                            <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title">Admin Management</h5>
                                    <a href="{{ route('admin#newAdminPage') }}" class="btn btn-primary btn-round">
                                        <i class="fa fa-plus"></i> Add New Admin
                                    </a>
                                </div>

                                <!-- Admin Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="adminTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Created Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($admins as $admin)
                                                <tr>
                                                    <td>{{ $admin->id }}</td>
                                                    <td>
                                                        <img src="{{ asset('default/default_profile.jpg') }}"
                                                            alt="Admin Profile" class="rounded-circle" width="40" height="40">
                                                    </td>
                                                    <td>{{ $admin->name }}</td>
                                                    <td>{{ $admin->email }}</td>
                                                    <td><span class="badge badge-primary">{{ $admin->role }}</span></td>
                                                    <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                                                    @if (Auth::user()->role == "owner")
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <form action="{{ route('admin#adminDetails', $admin->id) }}"
                                                                    method="GET">
                                                                    <button type="submit" class="btn btn-sm btn-info" title="View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </form>

                                                                <form action="{{ route('admin#delete') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $admin->id }}">
                                                                    <input type="hidden" name="role" value="{{ $admin->role }}">
                                                                    <input type="hidden" name="document_cv"
                                                                        value="{{ $admin->document_cv }}">
                                                                    <input type="hidden" name="profile"
                                                                        value="{{ $admin->profile }}">
                                                                    <button type="submit" class="btn btn-sm btn-danger ms-2"
                                                                        title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="text-center">
                                                            <form action="{{ route('admin#adminDetails', $admin->id) }}"
                                                                method="GET">
                                                                <button type="sumbit" class="btn btn-sm btn-info" title="View">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Delivery List Tab -->
                            <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title">Delivery Personnel Management</h5>
                                    <a href="{{ route('admin#newDeliveryPage') }}" class="btn btn-primary btn-round">
                                        <i class="fa fa-plus"></i> Add New Delivery Man
                                    </a>
                                </div>

                                <!-- Delivery Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="deliveryTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Vehicle</th>
                                                <th>Zone</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($deliverys as $delivery)
                                                <tr>
                                                    <td>{{ $delivery->id }}</td>
                                                    <td>
                                                        <img src="{{ asset('default/default_profile.jpg') }}"
                                                            alt="Delivery Profile" class="rounded-circle" width="40"
                                                            height="40">
                                                    </td>
                                                    <td>{{ $delivery->name }}</td>
                                                    <td>{{ $delivery->phone }}</td>
                                                    <td><span class="badge badge-info">{{ $delivery->vehicle }}</span></td>
                                                    <td>{{ $delivery->delivery_zone }}</td>
                                                    @if (Auth::user()->role == "owner")
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <form action="{{ route('admin#deliveryDetails', $delivery->id) }}"
                                                                    method="GET">
                                                                    <button type="submit" class="btn btn-sm btn-info" title="View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </form>

                                                                <form action="{{ route('admin#delete') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $delivery->id }}">
                                                                    <input type="hidden" name="role" value="{{ $delivery->role }}">
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $delivery->user_id }}">
                                                                    <input type="hidden" name="document_cv"
                                                                        value="{{ $delivery->document_cv }}">
                                                                    <input type="hidden" name="profile"
                                                                        value="{{ $delivery->profile }}">
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <form action="{{ route('admin#deliveryDetails', $delivery->id) }}"
                                                            method="GET">
                                                            <button type="submit" class="btn btn-sm btn-info" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- User List Tab -->
                            <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title">Regular User Management</h5>
                                </div>

                                <!-- User Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="userTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Join Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>
                                                        <img src="{{ asset('default/default_profile.jpg') }}" alt="User Profile"
                                                            class="rounded-circle" width="40" height="40">
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                                    @if (Auth::user()->role == "owner")
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <form action="{{ route('admin#adminDetails', $user->id) }}"
                                                                    method="GET">
                                                                    <button type="submit" class="btn btn-sm btn-info" title="View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </form>

                                                                <form action="{{ route('admin#delete') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                                                    <input type="hidden" name="profile"
                                                                        value="{{ $user->profile }}">
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <form action="{{ route('admin#adminDetails', $user->id) }}" method="GET">
                                                            <button type="submit" class="btn btn-sm btn-info" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </tr>
                                            @endforeach
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
