@extends('layoutAdmin.layout')
@section('title', 'Thêm Danh Mục')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm danh mục mới</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.storecategory') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categorys') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
