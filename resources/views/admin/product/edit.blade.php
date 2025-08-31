@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 50px">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="fw-bold mb-0">Edit Product</h3>
                <a href="{{ route('admin#productList') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Products
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Information</h4>
                        </div>
                        <div class="card-body">
                            <form id="editProductForm" action="{{route('admin#updateProduct')}}" method="POST" enctype="multipart/form-data">
                                @csrf


                                <div class="row g-4">
                                    <!-- Product Image Section -->
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="productImage" value="{{ $product->photo }}">

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Product Image</label>
                                        <div class="border rounded d-flex align-items-center justify-content-center mb-2" style="width: 100%; max-width: 260px; aspect-ratio: 1/1; overflow: hidden; background: #f8f9fa;">
                                            <img id="imagePreview" src="{{ asset('product_image/' . $product->photo) }}" alt="Product Image" style="width:100%; height:100%; object-fit:cover;" />
                                        </div>
                                        <input type="file" name="photo" id="productImage" class="form-control" accept="image/*" />
                                    </div>

                                    <!-- Product Details Section -->
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <!-- Product Name -->
                                            <div class="col-md-12">
                                                <label for="productName" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                                                <input type="text" id="productName" class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="Enter product name" name="name" value="{{ old('name', $product->name) }}"/>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Category Selection -->
                                            <div class="col-md-6">
                                                <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                                <select id="category" class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                                                    <option value="" disabled>Select a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Color Selection -->
                                            <div class="col-md-6">
                                                <label for="color" class="form-label fw-semibold">color <span class="text-danger">*</span></label>
                                                <select id="color" class="form-select @error('color_id') is-invalid @enderror" name="color_id">
                                                    <option value="" disabled>Select a color</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}" {{ old('color_id', $product->color_id) == $color->id ? 'selected' : '' }}>
                                                            {{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('color_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-6">
                                                <label for="price" class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">MMK</span>
                                                    <input type="number" id="price" class="form-control @error('price') is-invalid @enderror"
                                                           placeholder="0.00" step="0.01" min="0" name="price"
                                                           value="{{ old('price', $product->price) }}" />
                                                </div>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- stock Section -->
                                            <div class="col-md-6">
                                                <label for="stock" class="form-label fw-semibold">stock <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">MMK</span>
                                                    <input type="number" id="stock" class="form-control @error('stock') is-invalid @enderror"
                                                           placeholder="0.00" step="0.01" min="0" name="stock"
                                                           value="{{ old('stock', $product->stock) }}" />
                                                </div>
                                                @error('stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Description -->
                                            <div class="col-12">
                                                <label for="description" class="form-label fw-semibold">Description</label>
                                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                                          rows="4" placeholder="Write a detailed description of the product..."
                                                          name="description">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Update Product
                                    </button>

                                    <a href="{{ route('admin#productList') }}" class="btn btn-outline-danger">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
