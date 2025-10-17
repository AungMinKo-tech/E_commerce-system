@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="fw-bold mb-0">Wishlist Management</h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin#wishListPage') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-heart text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Wishlist Items</p>
                                        <h4 class="card-title">{{ $wishlists->total() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-users text-info"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Unique Users</p>
                                        <h4 class="card-title">{{ $wishlists->unique('user_id')->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-box text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Unique Products</p>
                                        <h4 class="card-title">{{ $wishlists->unique('product_id')->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Simple Filter Section -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <form method="GET" action="{{ route('admin#wishListPage') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="Search by user, product..." value="{{ request('search') }}" />
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="wishlistTable" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Product Image</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Added Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wishlists as $wishlist)
                                    <tr>
                                        <td><strong>{{ $wishlist->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <img src="{{ $wishlist->user->profile ? asset('profile/' . $wishlist->user->profile) : asset('default/default_profile.jpg') }}"
                                                         alt="User Avatar" class="avatar-img rounded-circle" width="32" height="32">
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $wishlist->user->name ?? $wishlist->user->nickname ?? 'Unknown User' }}</div>
                                                    <small class="text-muted">{{ $wishlist->user->email ?? 'No email' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $wishlist->product->name ?? 'Unknown Product' }}</div>
                                            <small class="text-muted">{{ $wishlist->product->category->name ?? 'No category' }}</small>
                                        </td>
                                        <td>
                                            @if($wishlist->product && $wishlist->product->photo)
                                                <img src="{{ asset('product_image/' . $wishlist->product->photo) }}"
                                                     alt="Product Image" class="img-thumbnail" width="50" height="50" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($wishlist->product)
                                                <span class="fw-bold text-success">${{ number_format($wishlist->product->price, 2) }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $wishlist->count ?? 1 }}</span>
                                        </td>
                                        <td>{{ $wishlist->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-heart-broken fa-2x mb-2"></i>
                                            <div>No wishlist items found.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($wishlists->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $wishlists->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <style>
        .card-stats .icon-big {
            font-size: 2em;
        }

        .avatar-img {
            object-fit: cover;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }

        .badge {
            font-size: 0.75em;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .img-thumbnail {
            border: 1px solid #dee2e6;
        }
    </style>

@endsection
