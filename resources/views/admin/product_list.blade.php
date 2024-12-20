@extends('layoutAdmin.layout')
@section('title', 'Danh sách sản phẩm')

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

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
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
                <a href="{{ route('admin.addproduct') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </a>
            </div>

            <div class="table-responsive">
                <table id="productTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Hình ảnh</th>
                            <th>Giá gốc</th>
                            <th>Giá KM</th>
                            <th>Danh mục</th>
                            <th>Người tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <img src="{{ asset('img/' . $item->img) }}" 
                                         alt="{{ $item->name }}"
                                         class="product-image">
                                </td>
                                <td>{{ $item->price_formatted }}</td>
                                <td>{{ $item->sale_price_formatted ?? 'Không có' }}</td>
                                <td>{{ $item->category->name ?? 'Không xác định' }}</td>
                                <td>{{ $item->user->name ?? 'Không xác định' }}</td>
                                <td>{!! $item->status_badge !!}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-{{ $item->status ? 'danger' : 'success' }} btn-sm"
                                                onclick="toggleStatus({{ $item->id }})"
                                                title="{{ $item->status ? 'Ẩn' : 'Hiện' }}">
                                            <i class="fas fa-{{ $item->status ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
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
            let table = new DataTable('#productTable', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                },
                pageLength: 10,
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: [2, 8], // Cột hình ảnh và hành động
                    orderable: false
                }],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                responsive: true
            });
        });

        function toggleStatus(id) {
            if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái món ăn này?')) {
                fetch(`/admin/products/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }
    </script>
@endpush
