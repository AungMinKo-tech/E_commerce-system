@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <div class="page-inner">
            <!-- Page Header -->
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Color Management</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Add Color</div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin#createColor')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color Name</label>
                                    <input type="text" id="color" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter color name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Add Color
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">Color List</div>
                            <span class="badge bg-secondary">{{ $colors->count() }}</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Created</th>
                                            <th class="text-end"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($colors as $color)
                                            <tr>
                                                <td>{{ $color->id }}</td>
                                                <td>{{ $color->name }}</td>
                                                <td>{{ $color->created_at->format('d/m/Y') }}</td>
                                                <td class="text-end">
                                                    <form action="" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="deleteProcess({{$color->id}})">
                                                            <i class="fas fa-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No color found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <span class="d-flex justify-content-end mt-3">{{ $colors->links() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteProcess($id) {
            const deleteUrl = "{{ route('admin#deleteColor', ['id' => '__ID__']) }}".replace('__ID__', $id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setTimeout(() => {
                        location.href = deleteUrl;
                    }, 800);
                }
            });
        }
    </script>
@endsection
