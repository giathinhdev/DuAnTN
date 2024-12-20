@extends('layoutAdmin.layout')
@section('title', 'Danh Mục')

@push('styles')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div id="successMessage" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.addcategory') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm Danh Mục
                </a>
            </div>

            <div class="table-responsive">
                <table id="categoryTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.editcategory', $item->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(auth()->user()->role === 'super_admin')
                                            <form action="{{ route('admin.destroycategory', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ẩn thông báo sau 3 giây
            setTimeout(function() {
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 3000);

            // Khởi tạo DataTable
            let table = new DataTable('#categoryTable', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                },
                pageLength: 10,
                order: [
                    [0, 'asc']
                ], // Sắp xếp theo ID
                columnDefs: [{
                    targets: [3], // Cột hành động
                    orderable: false
                }],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                responsive: true
            });
        });
    </script>
@endpush
