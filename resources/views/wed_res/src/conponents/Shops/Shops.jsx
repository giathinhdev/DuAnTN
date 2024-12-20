import React, { useEffect, useState } from 'react';
import Categ from './Categ';
import { FcCellPhone } from 'react-icons/fc';
import ShopCart from './ShopCart';
import axios from 'axios';
import './shops.css';

const Shops = ({ addToCart }) => {
    const [shopItems, setShopItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchShopItems = async () => {
            try {
                const response = await axios.get('http://localhost:8000/api/products'); // Thay đổi URL nếu cần
                setShopItems(response.data); // Giả sử API trả về danh sách sản phẩm
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchShopItems();
    }, []);

    if (loading) return <p>Đang tải...</p>;
    if (error) return <p>Lỗi: {error}</p>;

    return (
        <section className='shops background'>
            <div className="container pagePadding flex">
                <div className="sleftContent">
                    <Categ />
                </div>

                <div className="srightContent">
                    <div className="heading flex">
                        <div className="leftContent flex">
                            <FcCellPhone className='icon' />
                            <h2>Thực đơn</h2>
                        </div>
                        <div className="rightContent flex">
                            <span>Xem tất cả</span>
                            <i className="fa fa-caret-right"></i>
                        </div>
                    </div>
                    <div className="shopContent">
                        <ShopCart shopItems={shopItems} addToCart={addToCart} />
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Shops;
