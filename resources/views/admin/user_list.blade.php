@extends('layoutAdmin.layout')

@section('title', 'Danh sách người dùng')

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
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm người dùng
                </a>
            </div>

            <div class="table-responsive">
                <table id="userTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Vai trò</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(auth()->user()->role === 'super_admin')
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">
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
            let table = new DataTable('#userTable', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                },
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: [5], // Cột hành động
                    orderable: false
                }],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                responsive: true
            });
        });
    </script>
@endpush
