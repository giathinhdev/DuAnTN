import React from 'react'
import { Link } from 'react-router-dom'
const Header = ({cartItem}) => {
  return (
    <>

      <header className="header">
        <a href="#" className="logo">
          <i className="fas fa-utensils" />
          Gr8.
        </a>
        <nav className="navbar">
          <Link href to="/" className="active">
            Trang chủ
          </Link>
          <Link href to="/">Thực đơn</Link>
          <Link href to="/table">Đặt bàn</Link>
          <Link href="about.html">Giới thiệu</Link>
          <Link href="contact.html">Liên hệ</Link>
        </nav>
        <div className="icons">
          <i className="fas fa-bars" id="menu-bars" />
          <i className="fas fa-search" />
        </div>

        <button onclick="topFunction()" id="myBtn" title="Lên đầu trang">
          <i className="fas fa-arrow-up" />
        </button>


        <div className="icon flex">
            <Link to ="/user">
              <i className='fa fa-user icon_circle'></i>
            </Link>
          <div className="cart">
            <Link to ="/cart">
                <i className='fa fa-shopping-bag icon-circle'></i>
                  <span>{cartItem.length === 0 ? "0" : cartItem.length}</span>
            </Link>
          </div>
        </div>
      </header>

      <div className="modal-search">
        <div
          className="modal fade"
          id="modelId"
          tabIndex={-1}
          role="dialog"
          aria-labelledby="modelTitleId"
          aria-hidden="true"
        >
          <div className="modal-dialog" role="document">
            <div className="modal-content modal-sch-main">
              <div className="modal-body">
                <div className="input-group mb-3">
                  <input
                    type="text"
                    className="form-control search-box"
                    placeholder="Bạn cần tìm kiếm những gì?"
                    aria-label="Bạn cần tìm kiếm những gì?"
                    aria-describedby="basic-addon2"
                  />
                  <div className="input-group-append">
                    <button
                      className="btn btn-outline-secondary search-btn"
                      type="button"
                      title="Tìm kiếm"
                    >
                      <i className="fas fa-search" />
                    </button>
           
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    

    </>

  )
}

export default Header
