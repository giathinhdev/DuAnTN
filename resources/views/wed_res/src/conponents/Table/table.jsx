import React,{useState} from 'react'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import FlashDeal from '../FlashDeal/FlashDeal';
import Data from '../FlashDeal/Data';

const ModalComponent = ({ showModal, handleClose }) => {
  const {productItems} = Data
  

  const [cartItem, setCartItem] = useState([])
  
  const addToCart = (product) => {
    const productExit = cartItem.find((item) => item.id === product.id)

    if(productExit){
      setCartItem(cartItem.map((item) =>
       (item.id === product.id?
        {...productExit, qty:productExit.qty+1} 
        : item )))
    }
    else{
      setCartItem([...cartItem, {...product, qty:1}])
    }
  }


  return (
    <div className={`modal fade ${showModal ? 'show' : ''}`} style={{ display: showModal ? 'block' : 'none' }} tabIndex="-1" aria-labelledby="staticBackdropLabel" aria-hidden={!showModal}>
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h1 className="modal-title fs-5" id="staticBackdropLabel">Món có thể đặt</h1>
            <button type="button" className="btn-close" onClick={handleClose} aria-label="Close"></button>
          </div>
          <div className="modal-dialog modal-dialog-scrollable">
          <FlashDeal productItems={productItems} addToCart ={addToCart} />
          </div>
          <div className="modal-footer">
            <button type="button" className="btn btn-secondary" onClick={handleClose}>Close</button>
            <button type="button" className="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
  );
};
const Table = () => {
  const [showModal, setShowModal] = useState(false);

  const handleOpen = () => setShowModal(true);
  const handleClose = () => setShowModal(false);
  return (
    <main>
    {/*Banner*/}
   
    <div id="menu">
      <div className="menu-list">
        <div className="menu-box">
          <div className="container">
            <div className="menu-title">
              <h1>Đặt Bàn</h1>
              <p>
                Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng,
                có những phòng riêng biệt cho hội họp hay sinh nhật với màu sắc
                tươi sáng.
              </p>
            </div>
            <form action="">
              <div className="row">
                <div className="col-lg-6 col-md-6">
                  <div className="menu-item">
                    <label htmlFor="name">Họ tên:</label>
                    <br />
                    <input
                      name="name"
                      id="name"
                      type="text"
                      placeholder="Nhập tên của bạn"
                      className="form-input"
                      required=""
                    />
                  </div>
                </div>
                <div className="col-lg-6 col-md-6">
                  <div className="menu-item">
                    <label htmlFor="date">Ngày:</label>
                    <br />
                    <input
                      name="date"
                      id="date"
                      type="text"
                      placeholder="11/01/2021"
                      className="form-input"
                      required=""
                    />
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-lg-6 col-md-6">
                  <div className="menu-item">
                    <label htmlFor="time">Giờ:</label>
                    <br />
                    <input
                      name="time"
                      id="time"
                      type="text"
                      placeholder="12:00"
                      className="form-input"
                      required=""
                    />
                  </div>
                </div>
                <div className="col-lg-6 col-md-6">
                  <div className="menu-item">
                    <label htmlFor="guest">Bàn:</label>
                    <br />
                    <input
                      name="guest"
                      id="guest"
                      type="text"
                      placeholder={2}
                      className="form-input"
                      required=""
                    />
                  </div>
                </div>
                <div className="col-lg-6 col-md-6">
                  <div className="menu-item">
                    <label htmlFor="guest">Món:</label>
                    <br />
                   
  {/* Button trigger modal */}
  <button
    type="button"
    className="btn btn-primary"

    onClick={handleOpen}
  >
    Order món bạn muốn
  </button>
  <ModalComponent showModal={showModal} handleClose={handleClose} />


                  </div>
                </div>
              </div>

            </form>
            <div className="row">
              <div className="col-lg-12">
                <label htmlFor="comment">Lời nhắn:</label>
                <br />
                <textarea
                  name="comment"
                  id="comment"
                  placeholder="Gửi lời nhắn cho chúng tôi"
                  className="form-text"
                  defaultValue={""}
                />
              </div>
            </div>
            <div className="reservation-banner">
              <div className="container">
                <div className="reservation-content">
                  <input type="button" id="btn" defaultValue="Đặt Bàn" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  )
}

export default Table
