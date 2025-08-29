@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="page-inner" style="margin-top: 50px">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Product List</h3>
                    <p class="text-muted mb-0">Manage all products in your store</p>
                </div>
                <a href="{{ route('admin#addProductPage') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
            </div>

            <!-- Search and Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Search Products</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="searchInput"
                                    placeholder="Search by name, category...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Category Filter</label>
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-md-3">
                                    <label class="form-label fw-semibold">Status Filter</label>
                                    <select class="form-select" id="statusFilter">
                                        <option value="">All Status</option>
                                        <option value="Stock">Stock</option>
                                        <option value="Low Stock">Low Stock</option>
                                        <option value="Out of Stock">Out of Stock</option>
                                    </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="productsTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Color</th>
                                    <th>Created Date</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($products as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('product_image/' . $item->photo) }}" alt="Product"
                                                class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $item->product_name }}</div>
                                                {{-- <small class="text-muted">SKU: IP15PM-001</small> --}}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{$item->category_name}}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-primary">MMK {{ $item->price }}</div>
                                            {{-- <small class="text-muted text-decoration-line-through">MMK 2,800,000</small>
                                            --}}
                                        </td>
                                        <td>
                                            <div class="position-relative d-inline-block" style="width: 80px; height: 40px;">
                                                <span class="d-block text-center fs-5 fw-semibold" style="line-height:40px;">
                                                    {{ $item->stock }}
                                                </span>
                                                @if ($item->stock == 0)
                                                    <span class="position-absolute badge rounded-pill bg-danger shadow text-white"
                                                        style="top: -12px; right: -18px; font-size: 0.75rem; padding: 0.35em 0.7em; z-index:1;">
                                                        Out of Stock
                                                    </span>
                                                @elseif ($item->stock <= 3)
                                                    <span class="position-absolute badge rounded-pill bg-warning shadow text-white"
                                                        style="top: -12px; right: -18px; font-size: 0.75rem; padding: 0.35em 0.7em; z-index:1;">
                                                        Low Stock
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="">{{ $item->color_name }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <span class="d-flex justify-content-end mt-3">{{ $products->links() }}</span>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Total Products</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Search functionality
            $('#searchInput').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#productsTable tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Category filter
            $('#categoryFilter').on('change', function () {
                var category = $(this).val().toLowerCase();
                $('#productsTable tbody tr').each(function () {
                    if (!category) {
                        $(this).show();
                        return;
                    }
                    var rowCategory = $(this).find('td').eq(2).text().trim().toLowerCase();
                    $(this).toggle(rowCategory === category);
                });
            });

            // Status filter (computed from stock column)
            $('#statusFilter').on('change', function () {
                var status = $(this).val();
                $('#productsTable tbody tr').each(function () {
                    if (!status) {
                        $(this).show();
                        return;
                    }
                    var stockText = $(this).find('td').eq(4).text().trim();
                    var stock = parseInt(stockText, 10);
                    var rowStatus = 'Stock';
                    if (!isNaN(stock)) {
                        if (stock === 0) {
                            rowStatus = 'Out of Stock';
                        } else if (stock <= 3) {
                            rowStatus = 'Low Stock';
                        } else {
                            rowStatus = 'Stock';
                        }
                    }
                    $(this).toggle(rowStatus === status);
                });
            });
        });

        let productLabels = @json($products->pluck('product_name'));
        let colorName = @json($products->pluck('color_name'));
        let data = @json($products->pluck('stock'));

        var myBarChart = new Chart(barChart, {
            type: "bar",
            data: {
                labels:  productLabels,

                datasets: [
                    {
                        label: "Stocks",
                        backgroundColor: "rgb(23, 125, 255)",
                        borderColor: "rgb(23, 125, 255)",
                        data: data,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                stepSize: 5,
                                suggestedMax: 30
                            },
                        },
                    ],
                },
            },
        });
    </script>
@endsection
