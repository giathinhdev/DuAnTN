@extends('layoutAdmin.layout')
@section('title', 'Chi tiết đơn đặt bàn')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Tên:</strong> {{ $booking->name }}</p>
                    <p><strong>Email:</strong> {{ $booking->email }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $booking->phone }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Thông tin đặt bàn</h5>
                    <p><strong>Mã đơn:</strong> #{{ $booking->id }}</p>
                    <p><strong>Số bàn:</strong> {{ $booking->table->type }}</p>
                    <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái đặt bàn:</strong>
                        @if ($booking->booking_status == 'pending')
                            <span class="badge bg-warning">Chờ xác nhận</span>
                        @elseif($booking->booking_status == 'confirmed')
                            <span class="badge bg-success">Đã xác nhận</span>
                        @elseif($booking->booking_status == 'cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
                        @endif
                    </p>
                    <p><strong>Trạng thái thanh toán:</strong>
                        @if ($booking->order_status == 'unpaid')
                            <span class="badge bg-warning">Chưa thanh toán</span>
                        @elseif($booking->order_status == 'paid')
                            <span class="badge bg-success">Đã thanh toán</span>
                        @elseif($booking->order_status == 'cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
                        @endif
                    </p>
                </div>
            </div>

            <h5>Chi tiết món ăn</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Món ăn</th>
                            <th>Hình ảnh</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td><img src="{{ asset('img/' . $item->product->img) }}" alt="{{ $item->product->name }}"
                                        style="object-fit: cover; width: 100px; height: 100px;"></td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng tiền:</strong></td>
                            <td><strong>{{ number_format($totalAmount, 0, ',', '.') }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
@endsection
