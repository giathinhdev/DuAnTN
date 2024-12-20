@extends('layoutAdmin.layout')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Chi tiết bàn</h1>
    <div class="card">
        <div class="card-header">
            <h5>Thông tin bàn</h5>
        </div>
        <div class="card-body">
            <p><strong>Loại bàn:</strong> {{ $table->type }}</p>
            <p><strong>Số lượng:</strong> {{ $table->capacity }}</p>
            <p><strong>Trạng thái:</strong> {{ $table->status }}</p>
            <p><strong>Thời gian đặt:</strong> {{ $table->created_at->format('H:i:s : d/m/Y ') }}</p>
        </div>
    </div>

    <h2 class="mt-4">Đặt chỗ:</h2>
    @if ($table->bookings->isEmpty())
    <div class="alert alert-warning">
        Không có đặt chỗ nào cho bàn này.
    </div>
    @else
    @foreach ($table->bookings as $booking)
    <div class="card mt-3">
        <div class="card-header">
            <h5>Đặt chỗ ID: {{ $booking->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $booking->id }}</p>
            <p><strong>Đặt bởi:</strong> {{ $booking->user->name }}</p>
            <p><strong>Tên người đặt:</strong> {{ $booking->name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $booking->phone }}</p>
            <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</p>
            <p><strong>Thời gian:</strong> {{ $booking->booking_time }}</p>
            <p><strong>Số lượng khách:</strong> {{ $booking->number_of_guests }}</p>
            <p><strong>Ghi chú:</strong> {{ $booking->comment ?? 'Không có' }}</p>
            <p><strong>Trạng thái đặt bàn:</strong>
                @switch($booking->booking_status)
                    @case('confirmed')
                        Đã xác nhận
                        @break
                    @case('pending')
                        Đang chờ
                        @break
                    @case('cancelled')
                        Đã hủy
                        @break
                    @default
                        {{ $booking->booking_status }}
                @endswitch
            </p>
            <p><strong>Trạng thái đơn hàng:</strong>
                @switch($booking->order_status)
                    @case('paid')
                        Đã thanh toán
                        @break
                    @case('unpaid')
                        Chưa thanh toán
                        @break
                    @case('cancelled')
                        Đã hủy
                        @break
                    @default
                        {{ $booking->order_status }}
                @endswitch
            </p>
            <p><strong>Mã thanh toán:</strong> {{ $booking->payment_id ?? 'Chưa thanh toán' }}</p>
            <p><strong>Thời gian tạo:</strong> {{ $booking->created_at->format('H:i:s d/m/Y') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $booking->updated_at->format('H:i:s d/m/Y') }}</p>

            <h4>Mặt hàng đã đặt:</h4>
            @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @endif

            @if ($booking->orderItems->isEmpty())
            <div class="alert alert-info">Không có mặt hàng nào trong đơn hàng này.</div>
            @else
            <ul class="list-group">
                @php
                $totalAmount = 0; // Khởi tạo biến tổng tiền
                @endphp
                @foreach ($booking->orderItems as $item)
                <li class="list-group-item">
                    <strong>Tên món ăn:</strong> {{ $item->product->name }}<br>
                    <strong>Số lượng:</strong> {{ $item->quantity }}<br>
                    <strong>Giá:</strong> {{ number_format($item->price, 0, ',', '.') }}đ<br>
                    @php
                    $totalAmount += $item->price * $item->quantity; // Cộng dồn giá trị vào tổng tiền
                    @endphp
                </li>
                @endforeach
            </ul>
            <p class="mt-3"><strong>Tổng tiền:</strong> {{ number_format($totalAmount, 0, ',', '.') }}đ</p>
            @endif
        </div>
    </div>
    @endforeach
    @endif

    <!-- Nút gọi thêm món ăn -->
    <a href="{{ route('orders.create', ['table_id' => $table->id, 'booking_id' => $booking->id]) }}" class="btn btn-primary">
        Gọi thêm món ăn
    </a>


</div>
@endsection
