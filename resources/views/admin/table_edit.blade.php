@extends('layoutAdmin.layout')
@section('title', 'Sửa Thông Tin Bàn')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sửa Thông Tin Bàn</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tables.update', $table->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type" class="form-label fw-bold">Loại Bàn</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="Vip" {{ old('type', $table->type) == 'Vip' ? 'selected' : '' }}>Vip
                                    </option>
                                    <option value="Thường" {{ old('type', $table->type) == 'Thường' ? 'selected' : '' }}>
                                        Thường</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="capacity" class="form-label fw-bold">Sức Chứa</label>
                                <input type="number" class="form-control" id="capacity" name="capacity"
                                    value="{{ old('capacity', $table->capacity) }}" required min="1" max="10">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Trạng Thái</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="{{ App\Models\Table::STATUS_AVAILABLE }}"
                                        {{ $table->status == App\Models\Table::STATUS_AVAILABLE ? 'selected' : '' }}
                                        class="text-success">
                                        Trống
                                    </option>
                                    <option value="{{ App\Models\Table::STATUS_RESERVED }}"
                                        {{ $table->status == App\Models\Table::STATUS_RESERVED ? 'selected' : '' }}
                                        class="text-warning">
                                        Đã Đặt
                                    </option>
                                    <option value="{{ App\Models\Table::STATUS_CLEANING }}"
                                        {{ $table->status == App\Models\Table::STATUS_CLEANING ? 'selected' : '' }}
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
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
