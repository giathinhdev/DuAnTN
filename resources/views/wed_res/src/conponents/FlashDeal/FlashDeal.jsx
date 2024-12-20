// src/components/FlashDeal/FlashDeal.js
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import FlashCard from './FlashCard';

const FlashDeal = ({ addToCart }) => {
    const [productItems, setProductItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const imageBaseUrl = 'http://localhost:8000'; // Đường dẫn gốc của ứng dụng Laravel

    useEffect(() => {
        const fetchProducts = async () => {
            try {
                const response = await axios.get('http://localhost:8000/api/products');
                const productsWithFullImageUrls = response.data.map(product => ({
                    ...product,
                    cover: `${imageBaseUrl}${product.cover}`, // Thêm đường dẫn cơ sở vào đường dẫn hình ảnh
                }));
                setProductItems(productsWithFullImageUrls);
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchProducts();
    }, []);

    if (loading) return <p>Đang tải...</p>;
    if (error) return <p>Lỗi: {error}</p>;

    return (
        <section className='flash background'>
            <div className="container pagePadding">
                <div className="heading flex">
                    <i className='fa fa-bolt'></i>
                    <h1>Flash Deals</h1>
                </div>
                <FlashCard productItems={productItems} addToCart={addToCart} />
            </div>
        </section>
    );
};

export default FlashDeal;
