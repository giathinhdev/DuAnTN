@extends('layoutAdmin.layout')
@section('title', 'Thêm Bàn Mới')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h3 class="card-title">Thêm Bàn Mới</h3>
                </div>
                <form action="{{ route('admin.tables.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type" class="form-label fw-bold">Loại Bàn</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type"
                                    name="type" required>
                                    <option value="">-- Chọn loại bàn --</option>
                                    <option value="Vip" {{ old('type') == 'Vip' ? 'selected' : '' }}>Vip</option>
                                    <option value="Thường" {{ old('type') == 'Thường' ? 'selected' : '' }}>Thường</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="capacity" class="form-label fw-bold">Sức Chứa</label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                    id="capacity" name="capacity" value="{{ old('capacity') }}" min="1"
                                    max="10" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Trạng Thái</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="{{ App\Models\Table::STATUS_AVAILABLE }}"
                                        {{ old('status') == App\Models\Table::STATUS_AVAILABLE ? 'selected' : '' }}
                                        class="text-success">
                                        Trống
                                    </option>
                                    <option value="{{ App\Models\Table::STATUS_RESERVED }}"
                                        {{ old('status') == App\Models\Table::STATUS_RESERVED ? 'selected' : '' }}
                                        class="text-warning">
                                        Đã Đặt
                                    </option>
                                    <option value="{{ App\Models\Table::STATUS_CLEANING }}"
                                        {{ old('status') == App\Models\Table::STATUS_CLEANING ? 'selected' : '' }}
                                        class="text-info">
                                        Đang Dọn Dẹp
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">Thêm Bàn</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xác nhận trước khi submit form
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!confirm('Bạn có chắc chắn muốn thêm bàn mới này?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
