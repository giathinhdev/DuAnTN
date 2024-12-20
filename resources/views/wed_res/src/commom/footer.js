import React from 'react'

const Footer = () => {
  return (
    <footer className="footer">
      <div className="bg-footer">
        <div className="grid">
          <div className="grid__row">
            <div className="grid__col-third">
              <div className="footer-contact">
                <h4>Liên hệ</h4>
                <p>
                  <i className="fas fa-map-marker-alt" />
                  Số 3 Cầu Giấy, Đống Đa, HN
                </p>
                <p>
                  <i className="fas fa-phone-alt" />
                  1900 1900
                </p>
                <p>
                  <i className="fas fa-envelope" />
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
            <div className="grid__col-third">
              <div className="footer-newswriter">
                <h4>Bảng tin</h4>
                <span>
                  <i className="fas fa-utensils" />
                  <a href="">@Gr8</a>
                </span>
                <p>
                  Gr8 là một lựa chọn tốt cho những người vừa muốn có không gian ẩm
                  thực sang trọng mà giá cả phải chăng.
                </p>
                <span>8/11/2021</span>
              </div>
              <div className="footer-newswriter">
                <span>
                  <i className="fas fa-utensils" />
                  <a href="">@Gr8</a>
                </span>
                <p>
                  Hãy quay trở lại thưởng thức các món ăn tại Gr8 đi thoai !! blink
                  blink
                </p>
                <span>8/11/2021</span>
              </div>
            </div>
            <div className="grid__col-third">
              <div className="footer-gallery">
                <h4>Thư viện</h4>
                <div className="footer-gallery-img">
                  <a href="./image/gallery/1.jpg">
                    <img src="./img/gallery/1.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/2.jpg">
                    <img src="./img/gallery/2.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/3.jpg">
                    <img src="./img/gallery/3.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/4.jpg">
                    <img src="./img/gallery/4.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/5.jpg">
                    <img src="./img/gallery/5.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/6.jpg">
                    <img src="./img/gallery/6.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/7.jpg">
                    <img src="./img/gallery/7.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/8.jpg">
                    <img src="./img/gallery/8.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/9.jpg">
                    <img src="./img/gallery/9.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/10.jpg">
                    <img src="./img/gallery/10.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/11.jpg">
                    <img src="./img/gallery/11.jpg" alt="" />
                  </a>
                  <a href="./img/gallery/12.jpg">
                    <img src="./img/gallery/12.jpg" alt="" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="end-footer">
        <div className="grid">
          <div className="grid__row">
            <div className="footer-social">
              <i className="fab fa-twitter" />
              <i className="fab fa-facebook-f" />
              <i className="fab fa-instagram" />
            </div>
            <div className="footer-copyright">
              <p>
                Copyright © 2021 All rights reserved | Website này được thiết kế bởi
                <a href="">Nhóm 8</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>

  )
}

export default Footer
