@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 50px">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Product Details</h3>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin#productList') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                    <a href="{{ route('admin#editProduct', $product->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>
                </div>
            </div>

            <!-- Product Details Card -->
            <div class="row">
                <!-- Product Image and Basic Info -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-md-5">
                                    <div class="product-image-container text-center">
                                        <img src="{{ asset('product_image/' . $product->photo) }}"
                                            alt="{{ $product->name }}" class="img-fluid rounded shadow-sm"
                                            style="max-width: 100%; height: 300px; object-fit: cover;">
                                    </div>
                                </div>

                                <!-- Product Basic Info -->
                                <div class="col-md-7">
                                    <div class="product-info">
                                        <h2 class="fw-bold text-dark mb-3">{{ $product->name }}</h2>

                                        <div class="mb-3">
                                            <span
                                                class="badge bg-primary fs-6 px-3 py-2">{{ $product->category_name }}</span>
                                        </div>

                                        <div class="price-section mb-4">
                                            <h3 class="text-primary fw-bold mb-1">MMK {{ number_format($product->price) }}
                                            </h3>
                                        </div>

                                        <div class="stock-section mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <h6 class="fw-semibold mb-0 me-3">Stock Status:</h6>
                                                @if($product->stock == 0)
                                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                                        <i class="fas fa-times-circle me-1"></i>Out of Stock
                                                    </span>
                                                @elseif($product->stock <= 3)
                                                    <span class="badge bg-warning fs-6 px-3 py-2">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>Low Stock
                                                        ({{ $product->stock }})
                                                    </span>
                                                @else
                                                    <span class="badge bg-success fs-6 px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>In Stock ({{ $product->stock }})
                                                    </span>
                                                @endif
                                            </div>

                                            @if($product->color_name)
                                                <div class="d-flex align-items-center">
                                                    <h6 class="fw-semibold mb-0 me-3">Color:</h6>
                                                    <span
                                                        class="badge bg-secondary fs-6 px-3 py-2">{{ $product->color_name }}</span>
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Statistics -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>Product Statistics
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Orders</span>
                                    <span class="fw-bold">89</span>
                                </div>
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 60%"></div>
                                </div>
                            </div>

                            <div class="stat-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Revenue</span>
                                    <span class="fw-bold">MMK 2.5M</span>
                                </div>
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: 85%"></div>
                                </div>
                            </div>

                            <div class="stat-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Rating</span>
                                    <span class="fw-bold">4.5 ⭐</span>
                                </div>
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt me-2"></i>Product Description
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="description-content">
                                <p class="text-dark lh-lg">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Product Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold text-muted" style="width: 200px;">Product ID</td>
                                            <td class="fw-bold">{{ $product->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-muted">Product Name</td>
                                            <td class="fw-bold">{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-muted">Category</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $product->category_name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-muted">Price</td>
                                            <td class="fw-bold text-primary">MMK {{ number_format($product->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-muted">Current Stock</td>
                                            <td>
                                                @if($product->stock == 0)
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @elseif($product->stock <= 3)
                                                    <span class="badge bg-warning">Low Stock ({{ $product->stock }})</span>
                                                @else
                                                    <span class="badge bg-success">In Stock ({{ $product->stock }})</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($product->color_name)
                                            <tr>
                                                <td class="fw-semibold text-muted">Color</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $product->color_name }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="fw-semibold text-muted">Created Date</td>
                                            <td>{{ $product->created_at->format('F j, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-muted">Last Updated</td>
                                            <td>{{ $product->updated_at->format('F j, Y \a\t g:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <style>
        .product-image-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .stat-item {
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .description-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
    </style>
@endsection
