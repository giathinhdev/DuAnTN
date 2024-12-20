import React from 'react'
import "./cart.css"
const Cart = ({cartItem, addToCart, decreaseQty, removeItem}) => {


  const totalPrice = cartItem.reduce((price, item) => price + item.qty * item.price,0 )
  return (
   <>
    <section className='cart-items'>
      <div className="container pagePadding flex">
        <div className="cart-details">
          {/* {cartItem.length === 0 && <h1 className='no-items product'>No Items are add in Cart </h1>} */}
       
          {cartItem.map((item)=>{
            const productQty = item.price * item.qty
            return(
              <div className="cartlist products flex">
                <div className="imgDiv">
                <img src={`/img/${item.img}`} alt={item.name} />
                </div>

                <div className="cart-content">
                  <h3>{item.name}</h3>
                  <h4>Price: ${item.price}.00</h4>
                  <h4>Quantity: {item.qty}</h4>
                </div>

                <div className="cart-items-funtion">
                  
                  <div className="cartControl flex">
                      <div className="addingCart">
                        <button className='increaseCart' onClick={() => addToCart(item)}>
                          <i className="fa fa-plus"></i>
                        </button>
                      </div>

                      <div className="decsCart">
                        <button className='decreaseCart' onClick={() => decreaseQty(item)}>
                          <i className="fa fa-minus"></i>
                        </button>
                      </div>
                  </div>

                  <div className="removeCart">
                    <button onClick={() => removeItem(item)}>
                      <i className="fa-solid fa-xmark"></i>
                    </button>
                  </div>
                </div>

                <div className="cart-item-price">Total: ${productQty}.00</div>
              </div>

              
            )
          })}
        </div>
        <div className="cart-total products">
          <h2>Cart Sumary</h2>
          <div className="totalContent flex">
            <h4>Total Price : </h4>
            <h3>${totalPrice}</h3>
          </div>
        </div>
      </div>
    </section>

   </>
  )
}

export default Cart