@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 100px">
            <div class="d-flex align-items-center mb-3">
                <h3 class="fw-bold mb-0">Add Product</h3>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="addProductForm" action="{{ route('admin#createProduct') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Product Image</label>
                                        <div class="border rounded d-flex align-items-center justify-content-center mb-2"
                                            style="width: 100%; max-width: 260px; aspect-ratio: 1/1; overflow: hidden; background: #f8f9fa;">
                                            <img id="imagePreview" src="" alt="Preview"
                                                style="display:none; width:100%; height:100%; object-fit:cover;" />
                                            <div id="imagePlaceholder" class="text-muted text-center"
                                                style="padding: 16px;">
                                                <i class="fas fa-image" style="font-size: 32px;"></i>
                                                <div class="mt-2">No image selected</div>
                                            </div>
                                        </div>
                                        <input type="file" name="photo" id="productImage" class="form-control"
                                            accept="image/*" />
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="productName" class="form-label fw-semibold">Product Name</label>
                                                <input type="text" id="productName" class="form-control"
                                                    placeholder="Enter product name" name="name" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="category" class="form-label fw-semibold">Category</label>
                                                <select id="category" class="form-select" name="category_id">
                                                    <option value="" selected disabled>Select a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="price" class="form-label fw-semibold">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">MMK</span>
                                                    <input type="number" id="price" class="form-control"
                                                        placeholder="0.00" step="0.01" min="0" name="price"
                                                        required />
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Variants (Color + Stock)</label>
                                                <div id="variantContainer" class="d-flex flex-column gap-2">
                                                    <!-- Variant rows will be injected here -->
                                                </div>
                                                <div class="form-text">You can add up to 5 colors.</div>
                                            </div>

                                            <template id="variantRowTemplate">
                                                <div class="row g-2 align-items-center" data-variant-index="{index}">
                                                    <div class="col-md-4">
                                                        <input type="number" class="form-control variant-stock"
                                                            placeholder="Stock" min="0" name="stocks[]" required />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <select class="form-select variant-color" name="colors_id[]"
                                                                style="max-width: 260px;" required>
                                                                <option value="" selected disabled>Select a color
                                                                </option>
                                                                @isset($colors)
                                                                    @foreach ($colors as $color)
                                                                        <option value="{{ $color->id }}">{{ $color->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endisset
                                                            </select>
                                                            <button type="button"
                                                                class="btn btn-outline-primary btn-sm add-variant"
                                                                title="Add color">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm remove-variant"
                                                                title="Remove">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <div class="col-12">
                                                <label for="description" class="form-label fw-semibold">Description</label>
                                                <textarea id="description" class="form-control" rows="5" placeholder="Write a short description..."
                                                    name="description" required></textarea>
                                            </div>

                                            <div class="col-12">
                                                <label for="detail" class="form-label fw-semibold">Detail</label>
                                                <textarea id="detail" class="form-control" rows="5" placeholder="Write Detail Product..." name="detail"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-save me-1"></i>Create</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        id="resetFormBtn">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function() {
            const fileInput = document.getElementById('productImage');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');
            const resetBtn = document.getElementById('resetFormBtn');
            const variantContainer = document.getElementById('variantContainer');

            const MAX_VARIANTS = 5;
            let variantCount = 0;

            function createVariantRow() {
                if (variantCount >= MAX_VARIANTS) {
                    alert('You can choose up to 5 colors only.');
                    return;
                }
                const rowIndex = ++variantCount;
                const tpl = document.getElementById('variantRowTemplate');
                const fragment = tpl.content.cloneNode(true);
                const row = fragment.querySelector('[data-variant-index]');
                row.setAttribute('data-variant-index', String(rowIndex));
                variantContainer.appendChild(fragment);
            }

            // Initialize with one row
            createVariantRow();

            // Delegate add/remove buttons
            variantContainer.addEventListener('click', function(e) {
                const target = e.target;
                if (!(target instanceof Element)) return;
                const button = target.closest('button');
                if (!button) return;
                if (button.classList.contains('add-variant')) {
                    createVariantRow();
                } else if (button.classList.contains('remove-variant')) {
                    const row = button.closest('[data-variant-index]');
                    if (row && variantContainer.children.length > 1) {
                        variantContainer.removeChild(row);
                        variantCount = Math.max(0, variantCount - 1);
                    }
                }
            });

            function previewImage(file) {
                if (!file) return;
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    fileInput.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    imagePlaceholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files && e.target.files[0];
                if (file) {
                    previewImage(file);
                } else {
                    imagePreview.src = '';
                    imagePreview.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                }
            });

            resetBtn.addEventListener('click', function() {
                // Reset image preview
                setTimeout(function() {
                    imagePreview.src = '';
                    imagePreview.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                    updateColorSwatch();
                }, 0);
            });
        })();
    </script>
@endsection
