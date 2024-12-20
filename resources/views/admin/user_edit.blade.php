@extends('layoutAdmin.layout')

@section('title', 'Sửa người dùng')
@section('content')
<div class="main-content">
    <h3 class="title-page">Sửa người dùng</h3>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu (để trống nếu không muốn thay đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>
        <div class="form-group">
            <label for="role">Vai trò</label>
            <select name="role" class="form-control">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Người dùng</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                @if(auth()->user()->role === 'super_admin')
                    <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật người dùng</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
