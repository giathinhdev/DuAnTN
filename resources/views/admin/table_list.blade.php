@extends('layoutAdmin.layout')
@section('title', 'Danh sách bàn')

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

        .badge {
            padding: 0.5em 1em;
            font-size: 0.875em;
        }

        .badge.bg-success {
            background-color: #28a745 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
        }

        .badge.bg-info {
            background-color: #17a2b8 !important;
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
                <a href="{{ route('admin.tables.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm Bàn
                </a>
            </div>

            <div class="table-responsive">
                <table id="tableList" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Loại Bàn</th>
                            <th>Sức Chứa</th>
                            <th>Trạng Thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>{{ $table->id }}</td>
                                <td>{{ $table->type }}</td>
                                <td>{{ $table->capacity }}</td>
                                <td>
                                    @switch($table->status)
                                        @case('available')
                                            <span class="badge bg-success">Trống</span>
                                        @break

                                        @case('reserved')
                                            <span class="badge bg-warning">Đã Đặt</span>
                                        @break

                                        @case('cleaning')
                                            <span class="badge bg-info">Đang Dọn Dẹp</span>
                                        @break

                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.tables.edit', $table->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(auth()->user()->role === 'super_admin')
                                            <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bàn này?')">
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
            let table = new DataTable('#tableList', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                },
                pageLength: 10,
                order: [
                    [0, 'asc']
                ], // Sắp xếp theo ID
                columnDefs: [{
                    targets: [3, 4], // Cột trạng thái và hành động
                    orderable: false
                }],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                responsive: true
            });
        });
    </script>
@endpush
