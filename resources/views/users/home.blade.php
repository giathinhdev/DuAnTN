@extends('layoutUser.layout')

@section('title', 'Trang chủ')

@section('content')

<!-- Slider -->
<section class="slider">
    <div class="text-content">
        <h2 class="text-heading">Thực phẩm cho tâm hồn bạn</h2>
        <p class="text-desc">Đây là những món ăn ngon với nguyên liệu tươi mới.</p>
        <a href="#" class="btn btn-primary slider-btn">Bắt đầu ngay</a>
    </div>
</section>
<!-- Kết thúc slider -->

<!-- Banner -->
<section class="banner-section">
    <div class="banner-content">
        <h3 class="banner-heading">Món ngon nhất trong ngày</h3>
        <h2 class="banner-name">Hamburger & <br>Khoai tây chiên ngọt</h2>
        <p class="banner-price">$19.99</p><br>
        <a href="#" class="btn btn-primary banner-btn">Xem thực đơn của chúng tôi</a>
    </div>
</section>
<!-- Kết thúc Banner -->

<!-- Thực đơn phổ biến --> 
<section class="popular-menu-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Món ăn phổ biến</h2>
        <p class="text-center mb-5">Trải nghiệm những món ăn mới hấp dẫn từ đầu bếp của chúng tôi.</p>
        
        <!-- Menu Items -->
        <div class="row g-4">
            @foreach($product as $pro)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card shadow-sm border-light rounded-3 h-100 d-flex flex-column">
                    <img src="{{ asset('img/' . $pro->img) }}" class="card-img-top" alt="{{$pro->name}}">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title mb-3 text-center">{{ $pro->name }}</h5>
                            <p class="card-text mb-3 text-center">{{ $pro->description }}</p>
                            <span class="d-block mb-3 fw-bold text-center">{{ $pro->price }}đ</span>
                        </div>
                        <a href="#" class="btn btn-primary w-100 mt-auto">Đặt món ngay</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-secondary">Xem tất cả</a>
        </div>
    </div>
</section>




<!-- Tìm kiếm theo món ăn -->
<section class="search-food">
    <div class="container">
        <div class="row search-food-title">
            <div class="col">
                <h5>Tìm kiếm theo món ăn</h5>
            </div>
            <div class="col text-end">
                <a href="#" class="btn btn-link">
                    Xem tất cả
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-6 search-food-items">
                <img src="{{ asset('Web_Restaurant/assets/img/search/pizza.png') }}" alt="Pizza" class="img-fluid">
                <h5>Pizza</h5>
            </div>
            <div class="col-6 search-food-items">
                <img src="{{ asset('Web_Restaurant/assets/img/search/burger.png') }}" alt="Burger" class="img-fluid">
                <h5>Burger</h5>
            </div>
            <div class="col-6 search-food-items">
                <img src="{{ asset('Web_Restaurant/assets/img/search/noodles.png') }}" alt="Mỳ" class="img-fluid">
                <h5>Mỳ</h5>
            </div>
            <div class="col-6 search-food-items">
                <img src="{{ asset('Web_Restaurant/assets/img/search/sub-sandwich.png') }}" alt="Bánh mì kẹp" class="img-fluid">
                <h5>Bánh mì kẹp</h5>
            </div>
            <div class="col-6 search-food-items">
                <img src="{{ asset('Web_Restaurant/assets/img/search/chowmein.png') }}" alt="Chowmein" class="img-fluid">
                <h5>Chowmein</h5>
            </div>
            <div class="col-6 search-food-items">
                <img src="{{ asset('Web_Restaurant/assets/img/search/steak.png') }}" alt="Bít tết" class="img-fluid">
                <h5>Bít tết</h5>
            </div>
        </div>
    </div>
</section>

<!-- Dịch vụ -->
<section class="service-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="service-post text-center">
                    <img src="{{ asset('Web_Restaurant/assets/img/search/icon1.png') }}" alt="Nguyên liệu tươi mới" class="img-fluid mb-3">
                    <h3>Nguyên liệu tươi mới</h3>
                    <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="service-post text-center">
                    <img src="{{ asset('Web_Restaurant/assets/img/search/icon2.png') }}" alt="Công thức ngon nhất" class="img-fluid mb-3">
                    <h3>Công thức ngon nhất</h3>
                    <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="service-post text-center">
                    <img src="{{ asset('Web_Restaurant/assets/img/search/icon3.png') }}" alt="Khách hàng hài lòng" class="img-fluid mb-3">
                    <h3>Khách hàng hài lòng</h3>
                    <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="service-post text-center">
                    <img src="{{ asset('Web_Restaurant/assets/img/search/icon4.png') }}" alt="Thực đơn thuần chay" class="img-fluid mb-3">
                    <h3>Thực đơn thuần chay</h3>
                    <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Đặt bàn ngay -->
<section class="banner-section2">
    <div class="banner-box text-center">
        <h2>Đặt bàn ngay</h2>
        <p>Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng, có những phòng riêng biệt cho hội họp hay sinh nhật với màu sắc tươi sáng.</p>
        <a href="#" class="btn btn-primary">Đặt bàn ngay</a>
    </div>
</section>

@endsection