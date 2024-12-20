@extends('layoutAdmin.layout')
@section('title', 'Danh sách đơn đặt bàn')

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

            <div class="table-responsive">
                <table id="orderTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Tên khách hàng</th>
                            <th>Số bàn</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái đặt bàn</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->table->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @switch($booking->booking_status)
                                        @case('pending')
                                            <span class="badge bg-warning">Chờ xác nhận</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-info">Đã xác nhận</span>
                                            @break
                                        @case('preparing')
                                            <span class="badge bg-primary">Đang chuẩn bị món</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if ($booking->order_status == 'unpaid')
                                        <span class="badge bg-warning">Chưa thanh toán</span>
                                    @elseif($booking->order_status == 'paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @elseif($booking->order_status == 'cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.orders.show', $booking->id) }}" class="btn btn-info btn-sm"
                                            title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($booking->booking_status == 'pending')
                                            <form action="{{ route('admin.orders.updateBookingStatus', $booking->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="btn btn-success btn-sm" title="Xác nhận">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.orders.updateBookingStatus', $booking->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hủy">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @elseif($booking->booking_status == 'confirmed')
                                            <form action="{{ route('admin.orders.updateBookingStatus', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="preparing">
                                                <button type="submit" class="btn btn-primary btn-sm" title="Bắt đầu chuẩn bị">
                                                    <i class="fas fa-utensils"></i>
                                                </button>
                                            </form>
                                        @elseif($booking->booking_status == 'preparing')
                                            <form action="{{ route('admin.orders.updateBookingStatus', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm" title="Hoàn thành">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($booking->order_status == 'unpaid' && $booking->booking_status != 'cancelled')
                                            <form action="{{ route('admin.orders.updateCashPayment', $booking->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm"
                                                    title="Xác nhận thanh toán">
                                                    <i class="fas fa-money-bill"></i>
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
            let table = new DataTable('#orderTable', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                },
                pageLength: 10,
                order: [
                    [3, 'desc']
                ], // Sắp xếp theo ngày đặt
                columnDefs: [{
                    targets: [4, 5, 6], // Cột trạng thái và hành động
                    orderable: false
                }],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                responsive: true
            });
        });
    </script>
@endpush
