@extends('layoutAdmin.layout')

@section('title', 'Thêm người dùng')
@section('content')
<div class="main-content">
    <h3 class="title-page">Thêm người dùng</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="form-group">
            <label for="role">Vai trò</label>
            <select name="role" class="form-control">
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                @if(auth()->user()->role === 'super_admin')
                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                @endif
            </select>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <button type="submit" class="btn btn-primary">Thêm người dùng</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
