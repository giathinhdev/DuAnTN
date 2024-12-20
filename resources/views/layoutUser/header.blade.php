<header class="header">
    <a href="#" class="logo">
        <i class="fas fa-utensils"></i>
        Gr8.
    </a>
    <nav class="navbar">
        <a href="{{route('home')}}" class="active">Trang chủ</a>
        <a href="{{route('users.menus')}}">Thực đơn</a>
        <a href="{{route('datBan.create')}}">Đặt bàn</a>
        <a href="{{route('users.blog')}}">Giới thiệu</a>
        <a href="{{route('users.contact')}}">Liên hệ</a>
    </nav>
    <!-- Kiểm tra người dùng đã đăng nhập chưa -->
<div class="icons d-flex align-items-center">
    @guest
        <!-- Hiển thị nút đăng nhập và đăng ký khi người dùng chưa đăng nhập -->
        <a href="{{ route('admin.login') }}" class="btn btn-outline-primary me-2"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
        <a href="{{ route('admin.register') }}" class="btn btn-outline-success"><i class="fas fa-user-plus"></i> Đăng ký</a>
    @else
        <!-- Form Đăng Xuất -->
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </button>
        </form>
    @endguest
</div>
    <div class="icons d-flex align-items-center"> <!-- Sử dụng Flexbox để căn chỉnh -->
        <i class="fas fa-bars" id="menu-bars"></i>
        <i class="fas fa-search"></i>

        <!-- Thêm các icon đăng nhập và đăng xuất -->


    </div>

    <!--Back to home-->
    <button onclick="topFunction()" id="myBtn" title="Lên đầu trang"><i class="fas fa-arrow-up"></i></button>
</header>
