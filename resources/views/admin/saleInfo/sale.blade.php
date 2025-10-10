@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Sale Information</h4>
                </div>

                {{-- section --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white p-3">
                            <h5>Total Sales</h5>
                            <h3>{{ $totalSales }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white p-3">
                            <h5>Total Orders</h5>
                            <h3>{{ $totalOrders }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-dark p-3">
                            <h5>Total Customers</h5>
                            <h3>{{ $totalCustomers }}</h3>
                        </div>
                    </div>
                </div>

                {{-- month sale --}}
                <div class="card">
                    <div class="card-header">
                        <h5>Monthly Sales Summary ({{ date('Y') }})</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>

                {{-- top selling --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Top Selling Products</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topSelling as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');

        let month = @json($months);
        let saleData = @json($salesData);

        console.log(month, saleData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: month,

                datasets: [{
                    label: 'Monthly Sales (MMK)',
                    data: saleData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
