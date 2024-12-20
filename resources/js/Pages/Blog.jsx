import React from "react";

const Blog = () => {
  return (
    <main>
      {/* Banner */}
      <div className="page-banner">
        <div className="container">
          <h1>Về chúng tôi</h1>
          <p>tìm hiểu thêm về nhà hàng của chúng tôi</p>
        </div>
      </div>

      <div className="container">
        <ul className="page-banner-list">
          <li>
            <a href="#">Trang chủ</a>
          </li>
          <i className="fas fa-chevron-right" />
          <li>
            <a href="#">Về chúng tôi</a>
          </li>
        </ul>
      </div>

      <div id="about-content">
        <div className="container">
          <div className="row">
            <div className="col-md-6">
              <section className="img-1">
                <img src="./assets/img/About/dau-bep-viet-nam-6.jpg" alt="About Us" />
              </section>
            </div>
            <div className="col-md-6">
              <div className="ab-1">
                <h1>Câu chuyện của chúng tôi</h1>
                <span>Khám phá câu chuyện của chúng tôi</span>
                <p>
                  Nhà hàng được xây dựng trên tình yêu và niềm đam mê ẩm thực của
                  chúng tôi. Tất cả bắt đầu từ ước mơ của hai người phục vụ nhà
                  hàng trẻ là A và B. Với tình yêu, niềm đam mê và khát vọng mở
                  nhà hàng của riêng mình ngày càng mãnh liệt, cuối cùng chúng tôi
                  đã thực hiện được ước mơ - mở nhà hàng Gr8.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div className="container">
          <h1 className="header-2">Chúng tôi là ai</h1>
          <div className="row">
            <div className="col-lg-4 col-md-6">
              <section className="cheft">
                <img src="./assets/img/About/daubep1.jpg" alt="Chef 1" />
                <br />
                <h5>Đầu bếp: Nguyễn Huỳnh Vi Vương</h5>
                <p className="about-cheft">
                  Có 18 năm kinh nghiệm từng đạt giải nhất cuộc thi Bếp trẻ năm
                  2003, giải nhất Ẩm thực miền biển năm 2005, á quân Chiếc thìa
                  vàng năm 2015.
                </p>
              </section>
            </div>
            <div className="col-lg-4 col-md-6">
              <section className="cheft">
                <img src="./assets/img/About/jack lee.jpg" alt="Chef 2" />
                <br />
                <h5>Đầu bếp: Jack Lee</h5>
                <p className="about-cheft">
                  Có 20 năm kinh nghiệm từng chế biến các món ăn cho sao
                  Hollywood và tham gia nhiều show truyền hình về ẩm thực.
                </p>
              </section>
            </div>
            <div className="col-lg-4 col-md-6">
              <section className="cheft">
                <img src="./assets/img/About/dau bep.jpg" alt="Chef 3" />
                <br />
                <h5>Đầu bếp: Christine Hà</h5>
                <p className="about-cheft">
                  Là quán quân vua đầu bếp MasterChef 2012 tại Mỹ, tham gia Vua
                  đầu bếp Việt Nam 2013-2014, và là giám khảo Vua đầu bếp Việt Nam
                  2015.
                </p>
                <br />
              </section>
            </div>
          </div>
        </div>

        <div className="container">
          <h1 className="header-2">Nhận xét về chúng tôi</h1>
          <p className="p-2">Họ nói về chúng tôi</p>
          <div className="row">
            <div className="col-lg-4 col-md-6">
              <section className="cm">
                <div className="cm-img">
                  <img src="./assets/img/About/cm.jpg" alt="Customer 1" />
                </div>
                <h5>Lê Thu Trang</h5>
                <p className="about-cm">
                  Khi bước vào nhà hàng, bạn sẽ được chào đón bởi khung cảnh tráng
                  lệ, ngồi ở bất kì đâu bạn cũng có một cái nhìn tuyệt vời ra khu
                  bếp - nơi bạn có thể thấy các đầu bếp dang làm việc.
                  <br />
                  Thực đơn nhà hàng vô cùng phong phú, chất lượng món ăn cực kì
                  tốt, trang trí đơn giản nhưng lại đẹp mắt, giá cả hợp lý.
                  <br />
                  Chất lượng phục vụ tốt, nhân viên ở đây rất nhiệt tình.
                </p>
              </section>
            </div>
            <div className="col-lg-4 col-md-6">
              <section className="cm">
                <div className="cm-img">
                  <img src="./assets/img/About/cm.jpg" alt="Customer 2" />
                </div>
                <h5>Trần Xuân Mai</h5>
                <p className="about-cm">
                  Khi bước vào nhà hàng, bạn sẽ được chào đón bởi khung cảnh tráng
                  lệ, ngồi ở bất kì đâu bạn cũng có một cái nhìn tuyệt vời ra khu
                  bếp - nơi bạn có thể thấy các đầu bếp dang làm việc.
                  <br />
                  Thực đơn nhà hàng vô cùng phong phú, chất lượng món ăn cực kì
                  tốt, trang trí đơn giản nhưng lại đẹp mắt, giá cả hợp lý.
                  <br />
                  Chất lượng phục vụ tốt, nhân viên ở đây rất nhiệt tình.
                </p>
              </section>
            </div>
            <div className="col-lg-4 col-md-6">
              <section className="cm">
                <div className="cm-img">
                  <img src="./assets/img/About/cm.jpg" alt="Customer 3" />
                </div>
                <h5>Jack Lee</h5>
                <p className="about-cm">
                  Khi bước vào nhà hàng, bạn sẽ được chào đón bởi khung cảnh tráng
                  lệ, ngồi ở bất kì đâu bạn cũng có một cái nhìn tuyệt vời ra khu
                  bếp - nơi bạn có thể thấy các đầu bếp dang làm việc.
                  <br />
                  Thực đơn nhà hàng vô cùng phong phú, chất lượng món ăn cực kì
                  tốt, trang trí đơn giản nhưng lại đẹp mắt, giá cả hợp lý.
                  <br />
                  Chất lượng phục vụ tốt, nhân viên ở đây rất nhiệt tình.
                </p>
              </section>
            </div>
          </div>
        </div>
      </div>
    </main>
  );
};

export default Blog;
