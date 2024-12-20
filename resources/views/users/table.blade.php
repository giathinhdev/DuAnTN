@extends('layoutUser.layout')

@section('title','Đặt bàn')

@section('content')
<main>
        <!--Banner-->
        <div class="page-banner">
            <div class="container">
                <h1>Đặt bàn</h1>
                <p>đặt bàn cho bạn hoặc cho nhiều người</p>
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
                            <p>Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng, có những phòng riêng biệt cho hội họp hay sinh nhật với màu sắc tươi sáng.</p>
                        </div>
                        <form action="">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="menu-item">
                                      <label for="name">Họ tên:</label>
                                      <br>
                                      <input name="name" id="name" type="text" placeholder="Nhập tên của bạn" class="form-input" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="menu-item">
                                      <label for="date">Ngày:</label>
                                      <br>
                                      <input name="date" id="date" type="text" placeholder="11/01/2021" class="form-input" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="menu-item">
                                      <label for="time">Giờ:</label>
                                      <br>
                                      <input name="time" id="time" type="text" placeholder="12:00" class="form-input" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="menu-item">
                                      <label for="guest">Bàn:</label>
                                      <br>
                                      <input name="guest" id="guest" type="text" placeholder="2" class="form-input" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                         <div class="row">
                             <div class="col-lg-12">
                                <label for="comment">Lời nhắn:</label>
                                <br>
                                <textarea name="comment" id="comment" placeholder="Gửi lời nhắn cho chúng tôi" class="form-text"></textarea>
                            </div>
                        </div>
                        <div class="reservation-banner">
                            <div class="container">
                                <div class="reservation-content">
                                    <input type="button" id="btn" value="Đặt Bàn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
