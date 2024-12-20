import React from 'react'
import './home.css'
import Slider from '../../commom/slider'
const Home = () => {
  return (
    <>

  
  <section className="search-food">
    <div className="grid">
      <div className="grid__row search-food-title">
        <h5>Search by Food</h5>
        <a href="" className="btn">
          View all
          <i className="fas fa-angle-right" />
        </a>
      </div>
      <div className="grid__row">
        <div className="grid__col-6 search-food-items">
          <img src="./img/search/pizza.png" alt="" />
          <h5>Pizza</h5>
        </div>
        <div className="grid__col-6 search-food-items">
          <img src="./img/search/burger.png" alt="" />
          <h5>Burger</h5>
        </div>
        <div className="grid__col-6 search-food-items">
          <img src="./img/search/noodles.png" alt="" />
          <h5>Noodles</h5>
        </div>
        <div className="grid__col-6 search-food-items">
          <img src="./img/search/sub-sandwich.png" alt="" />
          <h5>Sub-sandwich</h5>
        </div>
        <div className="grid__col-6 search-food-items">
          <img src="./img/search/chowmein.png" alt="" />
          <h5>Chowmein</h5>
        </div>
        <div className="grid__col-6 search-food-items">
          <img src="./img/search/steak.png" alt="" />
          <h5>Steak</h5>
        </div>
      </div>
    </div>
  </section>
  <section className="service-section">
    <div className=".grid service-box">
      <div className="grid__row">
        <div className="grid__col-4">
          <div className="service-post">
            <img src="./img/Service/icon1.png" alt="" />
            <h3>Fresh Ingredient</h3>
            <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
          </div>
        </div>
        <div className="grid__col-4">
          <div className="service-post">
            <img src="./img/Service/icon2.png" alt="" />
            <h3>Best Recipe</h3>
            <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
          </div>
        </div>
        <div className="grid__col-4">
          <div className="service-post">
            <img src="./img/Service/icon3.png" alt="" />
            <h3>Happy Clients</h3>
            <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
          </div>
        </div>
        <div className="grid__col-4">
          <div className="service-post">
            <img src="./img/Service/icon4.png" alt="" />
            <h3>Vegan Menu</h3>
            <p>Sed egestas, ante vulputa eros pede vitae luctus metus augue.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section className="banner-section2">
    <div className="banner-box">
      <h2>Book a Table</h2>
      <p>
        Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng, có
        những phòng riêng biệt cho hội họp hay sinh nhật với màu sắc tươi sáng.
      </p>
      <a href="" className="btn">
        Đặt bàn ngay
      </a>
    </div>
  </section>
</>

  )
}

export default Home
