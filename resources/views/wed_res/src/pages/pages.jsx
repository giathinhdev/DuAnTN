import React from 'react'

import Home from '../conponents/Mainpages/home'
import FlashDeal from '../conponents/FlashDeal/FlashDeal'
import Shops from '../conponents/Shops/Shops'
const Pages = ({productItems, cartItem, addToCart, shopItems}) => {
  return (
    <div>
        <Home cartItem={cartItem} />
        <FlashDeal productItems={productItems} addToCart ={addToCart} />
        <Shops shopItems={shopItems} addToCart={addToCart}/>
      
    </div>
  )
}

export default Pages ;