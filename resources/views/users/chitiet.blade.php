@extends('layoutUser.layout')

@section('title', 'chitiet Page') <!-- Đặt title cho trang -->

@section('content')
    <h2>Welcome to the Home Page</h2>
    <p>This is the content of the home page.</p>
@endsection
<main>
    <article>

      <!-- 
        - #Phần Giới Thiệu Chính
      -->

      <section class="hero text-center" aria-label="home" id="home">

        <ul class="hero-slider" data-hero-slider>

          <li class="slider-item active" data-hero-slider-item>

            <div class="slider-bg">
              <img src="{{asset('users/assets/images/hero-slider-1.jpg')}}" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">MENUS</p>

            <h1 class="display-1 hero-title slider-reveal">
                Vì tình yêu dành cho <br>
                ẩm thực ngon lành
            </h1>

            <p class="body-2 hero-text slider-reveal">
                Hãy đến cùng gia đình và tận hưởng niềm vui từ những món ăn ngon tuyệt hảo
            </p>

         

          </li>
        </ul>

        <button class="slider-btn prev" >
         
        </button>

        <button class="slider-btn next" >
          
        </button>

        <a href="#" class="hero-btn has-after">
          <img src="{{asset('users/assets/images/hero-icon.png')}}" width="48" height="48" alt="booking icon">

          <span class="label-2 text-center span">Đặt Bàn Ngay</span>
        </a>

      </section>





      <!-- 
        - #Thực Đơn
      -->

      
        <div class="container menu2 section-menu"> 
            <!-- lọc -->
            <section id="spdetail" >
                <form action="" method="post">   
                    <div class="big-img">
                        <img src="{{asset('users/assets/images/2024-03-18.png')}}" width="100%" id="hinhto" alt="">
                        
                            <div class="small-img">
                                <div class="smallimg-col">
                                    <img src="{{asset('users/assets/images/2024-03-18.png')}}" width="100%" class="small" alt="">
                                </div>
                                <div class="smallimg-col">
                                    <img src="{{asset('users/assets/images/2024-03-18.png')}}" width="100%" class="small" alt="">
                                </div>
                                <div class="smallimg-col">
                                    <img src="{{asset('users/assets/images/2024-03-18.png')}}" width="100%" class="small" alt="">
                                </div>
                                <div class="smallimg-col">
                                    <img src="{{asset('users/assets/images/2024-03-18.png')}}" width="100%" class="small" alt="">
                                </div>
                            </div> 
                       
                    </div>
                    <div class="detail-text">
                        <h2 class="headline-1 section-title">Mì tortellini tôm hùm</h2>  
                        <h4>Giá:2525.25 VNĐ</h4>
                        <h5 class="section-text">Thời Gian:6 phút</h5> <h5 class="section-text">calo:100</h5>
                        <input type="number" name="quantity" value="1" >
                        <button class="btn btn-secondary" type="submit">
                        <span class="text text-1 text-center">
                            Thêm Vào Giỏ Hàng
                        </span>
                        <span class="text text-2">
                            Thêm Vào Giỏ Hàng
                        </span>
                        </button>
                        <h4>Mô Tả Sản Phẩm</h4>
                        <span class="section-text">Với camera chất lượng cao, chiếc điện thoại này làm cho việc chụp ảnh trở nên một trải nghiệm sáng tạo. Chức năng chụp ảnh ban đêm được cải thiện đáng kể, giúp bắt được mọi khoảnh khắc quý giá dù trong điều kiện ánh sáng thấp</span>
                    </div>
                </form>
            </section>

           
            <!-- ảnh nền -->
          <img src="{{asset('users/assets/images/shape-5.png')}}" width="921" height="1036" loading="lazy" alt="shape"
            class="shape shape-2 move-anim">
          <img src="{{asset('users/assets/images/shape-6.png')}}" width="343" height="345" loading="lazy" alt="shape"
            class="shape shape-3 move-anim">

        </div>
    


      <!-- 
        - #Thế Mạnh
      -->

      <section class="section features text-center" aria-label="features">
        <div class="container">

          <p class="section-subtitle label-2">Tại Sao Nên Chọn Chúng Tôi</p>

          <h2 class="headline-1 section-title">Thế Mạnh</h2>

          <ul class="grid-list">

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="{{asset('users/assets/images/features-icon-1.png')}}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Thực phẩm an toàn</h3>

                <p class="label-1 card-text">Thực phẩm an toàn giúp bảo vệ sức khỏe và dinh dưỡng.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="{{asset('users/assets/images/features-icon-2.png')}}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Môi trường dễ chịu</h3>

                <p class="label-1 card-text">Môi trường trong lành tạo cảm giác thư giãn và dễ chịu</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="{{asset('users/assets/images/features-icon-3.png')}}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Đầu bếp có tay nghề</h3>

                <p class="label-1 card-text">Đầu bếp tài năng mang đến những món ăn tuyệt vời</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="{{asset('users/assets/images/features-icon-4.png')}}" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Sự kiện & Tiệc</h3>

                <p class="label-1 card-text">Sự kiện và tiệc tùng mang đến niềm vui cho mọi người.</p>

              </div>
            </li>

          </ul>

        </div>
      </section>





    </article>
  </main>