@extends('layoutUser.layout')

@section('title','Thực đơn')

@section('content')
<main>
    <!-- Modal -->
    <div class="modal fade" id="food-content" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin món ăn</h5>
                </div>
                <div class="modal-body modal-food">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="modal-thumbnail">
                                    <img src="{{asset('assets/img/Menu/5.jpg')}}" alt="Pizza thịt xông khói">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="modal-food-info">
                                    <h4>Pizza thịt xông khói</h4>
                                    <div class="f-info">
                                        <span class="head-info">Thành phần: </span>
                                        <span class="content-info">Thịt bò xay, ngô, sốt BBQ, pho mai.</span>
                                    </div>
                                    <p>Được chế biến với nguyên liệu tốt nhất.</p>
                                    <p class="item-price">Giá: 110.000đ</p>
                                    <div class="img-food">
                                        <h5>Một số hình ảnh</h5>
                                        <a href="./assets/img/Menu/5.jpg">
                                            <img src="./assets/img/Menu/5.jpg" alt="Pizza">
                                        </a>
                                        <a href="./assets/img/Menu/5.jpg">
                                            <img src="./assets/img/Menu/5.jpg" alt="">
                                        </a>
                                        <a href="./assets/img/Menu/5.jpg">
                                            <img src="./assets/img/Menu/5.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="table.html"><button class="modal-btn">Đặt bàn ngay</button></a>
                    <button class="modal-btn btn-close" type="button" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!--Banner-->
    <div class="page-banner">
        <div class="container">
            <h1>Thực đơn</h1>
            <p>thưởng thức ẩm thực tuyệt vời của chúng tôi</p>
        </div>
    </div>
    <div class="container">
        <ul class="page-banner-list">
            <li>
                <a href="#">Trang chủ</a>
            </li>
            <i class="fas fa-chevron-right"></i>
            <li>
                <a href="#">Thực đơn</a>
            </li>
        </ul>
    </div>

    <div id="menu">
        <!--Menu-->
        <div class="menu-list">
            <div class="container">
                <div class="menu-title menu-pizza">
                    <h2>Pizza</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th1.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Pizza thịt xông khói</a></span>
                                            <span class="item-price">110.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th2.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Pizza thịt bò</a></span>
                                            <span class="item-price">140.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th3.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Pizza hải sản</a></span>
                                            <span class="item-price">120.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th4.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Calzone</a></span>
                                            <span class="item-price">130.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th5.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Pizza xúc xích</a></span>
                                            <span class="item-price">98.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-list">
            <div class="container">
                <div class="menu-title menu-bergers">
                    <h2>Bánh mì kẹp</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th9.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Bánh mì kẹp thịt hai tầng</a></span>
                                            <span class="item-price">110.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th10.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Bánh mì kẹp cổ điển</a></span>
                                            <span class="item-price">140.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th11.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Bánh mì kẹp thịt</a></span>
                                            <span class="item-price">120.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th12.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Bánh mì kẹp đặc biệt</a></span>
                                            <span class="item-price">130.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-list">
            <div class="container">
                <div class="menu-title menu-pasta">
                    <h2>Mì Ý</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th6.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Mì Amatriciana</a></span>
                                            <span class="item-price">110.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th7.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Mì Carbonara</a></span>
                                            <span class="item-price">140.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th8.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Mì Lasagna</a></span>
                                            <span class="item-price">120.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th8.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Mì Spaghetti</a></span>
                                            <span class="item-price">100.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-list">
            <div class="container">
                <div class="menu-title menu-deserts">
                    <h2>Món tráng miệng</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th13.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Bánh</a></span>
                                            <span class="item-price">110.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th14.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Trà</a></span>
                                            <span class="item-price">140.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-box">
                            <ul>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th15.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Kem</a></span>
                                            <span class="item-price">120.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="img-menu">
                                        <img src="./assets/img/Menu/th16.jpg" alt="">
                                    </div>
                                    <div class="menu-content">
                                        <h4>
                                            <span class="item-title"><a href="" data-toggle="modal" data-target="#food-content">Bánh kem</a></span>
                                            <span class="item-price">130.000đ</span>
                                        </h4>
                                        <p>Được chế biến với nguyên liệu tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Pagination-->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center page-nav">
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">Trước</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">Sau</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
    <!--Reservation-->
    <div class="reservation-banner">
        <div class="container">
            <div class="reservation-content">
                <h2>Đặt bàn</h2>
                <p>Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng, có những phòng riêng biệt cho hội họp hay sinh nhật với màu sắc tươi sáng.</p>
                <a href="table.html">Đặt bàn</a>
            </div>
        </div>
    </div>
</main>
@endsection