@extends('layoutUser.layout')

@section('title', 'Đặt bàn')

@section('content')
    <main>
        <!-- Banner -->
        <div class="page-banner">
            <div class="container">
                <h1>Đặt bàn</h1>
                <p>Đặt bàn cho bạn hoặc cho nhiều người</p>
            </div>
        </div>

        <div class="container">
            <ul class="page-banner-list">
                <li>
                    <a href="#">Trang chủ</a>
                </li>
                <i class="fas fa-chevron-right"></i>
                <li>
                    <a href="#">Đặt bàn</a>
                </li>
            </ul>
        </div>

        <div id="menu">
            <div class="menu-list">
                <div class="menu-box">
                    <div class="container">
                        <div class="menu-title">
                            <h1>Đặt Bàn</h1>
                            <p>Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng, có những phòng riêng biệt
                                cho hội họp hay sinh nhật với màu sắc tươi sáng.</p>
                        </div>

                        <!-- Thông báo lỗi -->
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Thông báo thành công -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Form đặt bàn -->
                        <form action="{{ route('datBan.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Họ tên -->
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="name">Họ tên:</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Nhập tên người nhận bàn" required>
                                    </div>
                                </div>
                                <!-- Số điện thoại -->
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại:</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            min="10" placeholder="Nhập số điện thoại người nhận bàn" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <!-- Ngày đặt -->
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="booking_date">Ngày đặt:</label>
                                        <input type="date" name="booking_date" id="booking_date" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <!-- Giờ đặt -->
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="booking_time">Giờ đặt:</label>
                                        <input type="time" name="booking_time" id="booking_time" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <!-- Số lượng khách -->
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label for="number_of_guests">Số lượng khách:</label>
                                        <input type="number" name="number_of_guests" id="number_of_guests"
                                            class="form-control" min="1" max="20" required>
                                    </div>
                                </div>
                                <!-- Chọn bàn -->
                                <div class="col-lg-6 mb-3">
                                    <label for="table_id">Chọn bàn:</label>
                                    <select name="table_id" id="table_id" class="form-control" required>
                                        <option value="">-- Chọn bàn --</option>
                                        @if ($tables->isEmpty())
                                            <!-- Nếu không có bàn nào -->
                                            <option value="" disabled>Không có bàn trống hiện tại</option>
                                        @else
                                            @foreach ($tables as $table)
                                                <option value="{{ $table->id }}">
                                                    Bàn {{ $table->id }} - {{ $table->type }}
                                                    (Sức chứa: {{ $table->capacity }} khách)
                                                    - Trạng thái: {{ $table->status }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- Lời nhắn -->
                            <div class="form-group mb-3">
                                <label for="message">Lời nhắn:</label>
                                <textarea name="message" id="message" class="form-control" rows="3"
                                    placeholder="Nhập lời nhắn của bạn (nếu có)"></textarea>
                            </div>

                            <!-- Nút đặt bàn -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Đặt bàn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
