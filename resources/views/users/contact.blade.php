@extends('layoutUser.layout')

@section('title', 'Liên hệ') <!-- Đặt title cho trang -->

@section('content')
    <!--Back to home-->
		<button onclick="topFunction()" id="myBtn" title="Lên đầu trang"><i class="fas fa-arrow-up"></i></button>
		<!--Main-->
		<div class="page-banner">
			<div class="container">
				<h1>Liên hệ</h1>
				<p>hãy gửi lại lời nhắn cho chúng tôi</p>
			</div>
		</div>
		<div class="container">
			<ul class="page-banner-list">
				<li>
					<a href="home.html">Trang chủ</a>
				</li>
				<i class="fas fa-chevron-right"></i>
				<li>
					<a href="contact.html">Liên hệ</a>
				</li>
			</ul>
		</div>
		<div class="container">
			<div class="contact-box">
				<div class="row">
					<div class="col-md-5">
						<div class="open-info">
							<h5>Giờ mở cửa:</h5>
							<div class="info-line">
								<p>
									<i class="fa fa-clock-o"></i>
									<span><b>Thứ 2 - Thứ 6:</b></span> 8:15 - 22:00 <br>
									<span class="dm"><b>Thứ 7:</b></span> 8:00 - 23:00 <br>
									<span class="dm"><b>Chủ nhật:</b></span> 7:00 - 23:30
								</p>
							</div>
							<div class="info-line">
								<p>
									<i class="fa fa-calendar-check-o"></i>
									<span><b>Thời gian đặt trước:</b></span> 24/7
								</p>
							</div>
						</div>
						<div class="contact-info">
							<h5>Thông tin liên hệ:</h5>
							<p>
								<i class="fas fa-map-marker-alt ttlh"></i>
								<span>Số 3 Cầu Giấy, Đống Đa, Hà Nội</span>
							</p>
							<p>
								<i class="fa fa-phone"></i>
								<span>1900 1900</span>
							</p>
							<p>
								<i class="fa fa-envelope"></i>
								<span>hotro@email.com</span>
							</p>
						</div>
					</div>
					<div class="col-md-7">
						<form id="contact-form">
							<label for="name"><b>Tên:</b></label>
							<input name="name" id="name" type="text" placeholder="Nhập tên" required>
							<label for="mail"><b>Email:</b></label>
							<input name="mail" id="mail" type="email" placeholder="Nhập email" required>
							<label for="comment"><b>Tin nhắn:</b></label>
							<textarea name="comment" id="comment" placeholder="Nhập tin nhắn" required></textarea>
							<input type="submit" id="submit_contact" value="Gửi">
							<div id="msg" class="message"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
@endsection
