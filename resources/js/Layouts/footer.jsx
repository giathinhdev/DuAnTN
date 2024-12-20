import React from 'react';

const Footer = () => {
  return (
    <footer className="footer">
      <div className="bg-footer py-5">
        <div className="container">
          <div className="row">
            {/* Contact Info */}
            <div className="col-lg-4 col-md-6 mb-4">
              <div className="footer-contact">
                <h4>Liên hệ</h4>
                <p>
                  <i className="fas fa-map-marker-alt"></i>
                  Số 3 Cầu Giấy, Đống Đa, HN
                </p>
                <p>
                  <i className="fas fa-phone-alt"></i>
                  1900 1900
                </p>
                <p>
                  <i className="fas fa-envelope"></i>
                  hotro@email.com
                </p>
              </div>

              <div className="footer-contact">
                <h4>Thời gian mở cửa</h4>
                <p>Thứ 2 - Thứ 6: Từ 8:15 đến 22:00</p>
                <p>Thứ 7: Từ 8:00 - 23:00</p>
                <p>Chủ nhật: Từ 7:00 - 23:30</p>
              </div>
            </div>

            {/* Newsletters */}
            <div className="col-lg-4 col-md-6 mb-4">
              <div className="footer-newswriter">
                <h4>Bảng tin</h4>
                <span>
                  <i className="fas fa-utensils"></i>
                  <a href="#">@Gr8</a>
                </span>
                <p>
                  Gr8 là một lựa chọn tốt cho những người vừa muốn có không gian ẩm thực sang trọng mà giá cả phải chăng.
                </p>
                <span>8/11/2021</span>
              </div>

              <div className="footer-newswriter">
                <span>
                  <i className="fas fa-utensils"></i>
                  <a href="#">@Gr8</a>
                </span>
                <p>
                  Hãy quay trở lại thưởng thức các món ăn tại Gr8 đi thoai !! blink blink
                </p>
                <span>8/11/2021</span>
              </div>
            </div>

            {/* Gallery */}
            <div className="col-lg-4 col-md-12 mb-4">
              <div className="footer-gallery">
                <h4>Thư viện</h4>
                <div className="row g-2">
                  <div className="col-4">
                    <a href="./assets/img/gallery/1.jpg">
                      <img src="/assets/img/gallery/1.jpg" alt="" className="img-fluid" />
                    </a>
                  </div>
                  <div className="col-4">
                    <a href="./assets/img/gallery/2.jpg">
                      <img src="./assets/img/gallery/2.jpg" alt="" className="img-fluid" />
                    </a>
                  </div>
                  <div className="col-4">
                    <a href="./assets/img/gallery/3.jpg">
                      <img src="./assets/img/gallery/3.jpg" alt="" className="img-fluid" />
                    </a>
                  </div>
                  {/* Add other gallery images similarly */}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Footer Bottom */}
      <div className="end-footer py-3 bg-dark text-white">
        <div className="container">
          <div className="row align-items-center">
            <div className="col-md-6">
              <div className="footer-social">
                <i className="fab fa-twitter me-3"></i>
                <i className="fab fa-facebook-f me-3"></i>
                <i className="fab fa-instagram"></i>
              </div>
            </div>
            <div className="col-md-6 text-md-end">
              <p>
                Copyright © 2021 All rights reserved | Website này được thiết kế bởi
                <a href="#" className="text-white"> Nhóm 8</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
