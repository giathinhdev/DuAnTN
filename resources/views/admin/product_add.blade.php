@extends('layoutAdmin.layout')
@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm sản phẩm mới</h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.storeproduct') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá gốc <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" required min="0">
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Giá khuyến mãi (nếu có)</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price" min="0">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="img" name="img" accept="image/*" required onchange="previewImage(this)">
                            <img id="preview" src="#" alt="Preview" class="mt-2" style="max-width: 200px; display: none;">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Hiện/Ẩn món ăn</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.productlist') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Thêm sản phẩm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Form submission handling
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const name = document.getElementById('name').value;
        const category = document.getElementById('category_id').value;
        const price = document.getElementById('price').value;
        const img = document.getElementById('img').files[0];

        if (!name || !category || !price || !img) {
            alert('Vui lòng điền đầy đủ thông tin bắt buộc');
            return;
        }

        // Submit form
        this.submit();
    });
</script>
@endpush
