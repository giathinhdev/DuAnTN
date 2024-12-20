import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import axios from 'axios';
import Header from './commom/header';
import Pages from './pages/pages';
import Cart from './commom/cart/Cart';
import SData from './conponents/Shops/SData';
import Table from './conponents/Table/table';
import Footer from './commom/footer';
import Slider from './commom/slider';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

function App() {
  const [productItems, setProductItems] = useState([]);
  const { shopItems } = SData; // Dữ liệu shopItems tĩnh

  const [cartItem, setCartItem] = useState([]);

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/products');
        setProductItems(response.data); // Cập nhật productItems từ API
      } catch (error) {
        console.error("Lỗi khi lấy dữ liệu sản phẩm:", error);
      }
    };

    fetchProducts();
  }, []);

  const addToCart = (product) => {
    const productExit = cartItem.find((item) => item.id === product.id);

    if (productExit) {
      setCartItem(cartItem.map((item) =>
        (item.id === product.id ? { ...productExit, qty: productExit.qty + 1 } : item)
      ));
    } else {
      setCartItem([...cartItem, { ...product, qty: 1 }]);
    }
  };

  const decreaseQty = (product) => {
    const productExit = cartItem.find((item) => item.id === product.id);
    if (productExit.qty === 1) {
      setCartItem(cartItem.filter((item) => item.id !== product.id));
    } else {
      setCartItem(cartItem.map((item) =>
        (item.id === product.id ? { ...productExit, qty: productExit.qty - 1 } : item)
      ));
    }
  };

  const removeItem = (product) => {
    setCartItem(cartItem.filter((item) => item.id !== product.id));
  };

  return (
    <div className="">
      <Router>
        <Header cartItem={cartItem} />
        <Slider />

        <Routes>
          <Route path='/' element={<Pages productItems={productItems} addToCart={addToCart} shopItems={shopItems} />} />
          <Route path='/table' element={<Table />} />
          <Route path="/cart" element={
            <Cart
              cartItem={cartItem}
              addToCart={addToCart}
              decreaseQty={decreaseQty}
              removeItem={removeItem}
            />}
          />
        </Routes>
        <Footer />
      </Router>
    </div>
  );
}

export default App;
