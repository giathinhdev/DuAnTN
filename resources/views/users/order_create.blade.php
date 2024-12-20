@extends('layoutUser.layout')

@section('title','Đặt Món')

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
            <li><a href="#">Trang chủ</a></li>
            <i class="fas fa-chevron-right"></i>
            <li><a href="#">Đặt Món</a></li>
        </ul>
    </div>

    <div id="menu">
        <div class="menu-list">
            <div class="menu-box">
                <div class="container">
                    <div class="menu-title">
                        <h1>Chọn Món</h1>
                        <p>Chọn món ăn yêu thích của bạn từ thực đơn.</p>
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

                    <!-- Form chọn món -->
                    <form action="{{ route('datMon.store', $booking->id) }}" method="POST">
                        @csrf
                        <div class="accordion" id="menuAccordion">
                            @foreach($categories as $category)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $category->id }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="true" aria-controls="collapse{{ $category->id }}">
                                            {{ $category->name }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $category->id }}" data-bs-parent="#menuAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                @foreach($category->products as $product)
                                                    <div class="col-md-4 col-sm-6 mb-4">
                                                        <div class="card shadow-sm border-light">
                                                            <img src="{{ asset('img/' . $product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                                <p class="card-text">{{ number_format($product->price, 0) }} VND</p>

                                                                <!-- Input số lượng món -->
                                                                <label for="dish_{{ $product->id }}" class="form-label">Số lượng:</label>
                                                                <input type="number" name="dishes[{{ $product->id }}]" id="dish_{{ $product->id }}" class="form-control" value="0" min="0" max="10" placeholder="Chọn số lượng">

                                                                <!-- Checkbox để chọn món -->
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input" type="checkbox" value="1" id="dish_checkbox_{{ $product->id }}" name="selected_dishes[{{ $product->id }}]">
                                                                    <label class="form-check-label" for="dish_checkbox_{{ $product->id }}">
                                                                        Chọn món này
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Nút đặt món -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Đặt Món</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
