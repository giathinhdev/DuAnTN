import React, {useState} from 'react'

const ShopCart = ({shopItems, addToCart}) => {
  const [count, setCount] = useState(0)
  
  const [isActive, setIsActive] = useState(false);

  const handleClick = (e)=>{
    setIsActive((current)=> !current)
    setCount(count+1);
  }
  const handleMinusClick = (e)=>{
    setIsActive((current)=> !current)
    setCount(count-1);
  }
  return (
    <div className='shopCart'>
    {
      shopItems.map((shopItems, index) =>{
        return(
          <div className="box">
          <div className="products">
            <div className="imgContent">
              <span className="discount">{shopItems.discount}%OFF</span>
              <div className="imgDiv">
                <img src={`/img/${shopItems.img}`} alt={shopItems.name} />
              </div>
              <div className="products-like">
                <label>{count}</label>
                <br />
                {
                isActive ? 
                <i className= {`fa fa-heart ${isActive ? 'isred' : ''}`}
                 onClick={handleMinusClick}
                ></i>
                :
                <i className= {`fa-regular fa-heart ${isActive ? 'isred' : ''}`}
                 onClick={handleClick}
                ></i> 
                } 
              </div>
            </div>
            <div className="products-details">
              <h3>{shopItems.name}</h3>
              <div className="rate">
                <i className="fa fa-star"></i>
                <i className="fa fa-star"></i>
                <i className="fa fa-star"></i>
                <i className="fa fa-star"></i>
                <i className="fa fa-star"></i>
              </div>
              <div className="price">
                <h4>{shopItems.price}.00</h4>
                <button onClick={ () => addToCart(shopItems) }>
                  <i className="fa fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        )
      })
    }
    </div>
  )
}

export default ShopCart