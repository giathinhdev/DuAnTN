@extends('layoutAdmin.layout')
@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Chỉnh sửa sản phẩm</h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá gốc</label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', number_format($product->price)) }}" 
                                       required>
                                <span class="input-group-text">đ</span>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Giá khuyến mãi</label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control @error('sale_price') is-invalid @enderror" 
                                       id="sale_price" 
                                       name="sale_price" 
                                       value="{{ old('sale_price', $product->sale_price ? number_format($product->sale_price) : '') }}">
                                <span class="input-group-text">đ</span>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh</label>
                            <input type="file" 
                                   class="form-control @error('img') is-invalid @enderror" 
                                   id="img" 
                                   name="img" 
                                   accept="image/*" 
                                   onchange="previewImage(this)">
                            @error('img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="preview" 
                                 src="{{ asset('img/' . $product->img) }}" 
                                 alt="{{ $product->name }}" 
                                 class="mt-2" 
                                 style="max-width: 200px;">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                               id="status" name="status" value="1" 
                               {{ old('status', $product->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">
                            Hiện/Ẩn món ăn
                        </label>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.productlist') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Format giá tiền
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        value = new Intl.NumberFormat('vi-VN').format(value);
        input.value = value;
    }

    document.getElementById('price').addEventListener('input', function() {
        formatCurrency(this);
    });

    document.getElementById('sale_price').addEventListener('input', function() {
        formatCurrency(this);
    });
</script>
@endpush