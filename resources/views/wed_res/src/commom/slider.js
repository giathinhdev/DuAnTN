import React from 'react'

const Slider = () => {
  return (
    <>
  {/* Slider start */}
  <section className="slider">
    <div className="text-content">
      <h2 className="text-heading">Food For Your Soul</h2>
      <p className="text-desc">It's about good food and fresh ingredient.</p>
      <a href="" className="btn slider-btn">
        Let's Start
      </a>
    </div>
  </section>
  {/* Slider end */}
  {/*  Banner start*/}
  <section className="banner-section">
    <div className="banner-content">
      <h3 className="banner-heading">Best Dish Of The Day</h3>
      <h2 className="banner-name">
        Hamburger &amp; <br />
        Sweet Potato Fries
      </h2>
      <p className="banner-price">$19.99</p>
      <br />
      <a href="" className="btn banner-btn">
        View Our Menu
      </a>
    </div>
  </section>
</>

  )
}

export default Slider
