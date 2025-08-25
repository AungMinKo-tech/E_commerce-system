@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <!-- Page Header -->
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Edit Category</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin#dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin#category') }}" class="text-decoration-none">
                                    <i class="fas fa-layer-group me-1"></i> Categories
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-edit me-1"></i> Edit Category
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-edit me-2"></i> Edit Category Information
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin#categoryUpdate', $category->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="category_name" class="form-label fw-bold">
                                                <i class="fas fa-tag me-1"></i> Category Name
                                            </label>
                                            <input type="text"
                                                   id="category_name"
                                                   name="name"
                                                   value="{{ old('name', $category->name) }}"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Enter category name"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Category name should be between 3 and 30 characters.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('admin#category') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Categories
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Update Category
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Category Information Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-info-circle me-2"></i> Category Information
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <span class="text-muted">ID:</span>
                                </div>
                                <div class="col-8">
                                    <span class="fw-bold">{{ $category->id }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <span class="text-muted">Name:</span>
                                </div>
                                <div class="col-8">
                                    <span class="fw-bold">{{ $category->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <span class="text-muted">Created:</span>
                                </div>
                                <div class="col-8">
                                    <span class="fw-bold">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <span class="text-muted">Updated:</span>
                                </div>
                                <div class="col-8">
                                    <span class="fw-bold">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <span class="text-muted">Products:</span>
                                </div>
                                <div class="col-8">
                                    <span class="badge bg-info">{{ $category->products->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-question-circle me-2"></i> Help
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger mb-0">
                                <h6 class="alert-heading">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    အကြံပေးချက်များ:
                                </h6>
                                <ul class="mb-0 small">
                                    <li>ထပ်နေသော အမျိုးအစားများကို စစ်ဆေးပါ။</li>
                                    <li>သုံးစွဲသူများ နားလည်နိုင်စေမည့် ရှင်းလင်းပြတ်သားသော အမည်များကို အသုံးပြုပါ။</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
