import React, { useState, useEffect } from 'react';
import { Button, notification, Card, Row, Col, Badge } from 'antd';
import { ShoppingCartOutlined, HeartOutlined, ShareAltOutlined, FireOutlined } from '@ant-design/icons';
import { useShopping } from "../Hook/useContentShoping";
import axios from 'axios';
import { Link } from '@inertiajs/react';

const ProductDetail = ({ product: initialProduct, relatedProducts }) => {
    const [product] = useState(initialProduct);
    const [quantity, setQuantity] = useState(1);
    const { addToCart } = useShopping();
    const [selectedImage, setSelectedImage] = useState(product?.img);
    const [bestSellers, setBestSellers] = useState([]);

    useEffect(() => {
        const fetchBestSellers = async () => {
            try {
                const response = await axios.get('/api/best-sellers');
                if (response.data.status === 'success') {
                    setBestSellers(response.data.data);
                }
            } catch (error) {
                console.error('Error fetching best sellers:', error);
            }
        };

        fetchBestSellers();
    }, []);

    const handleAddToCart = () => {
        if (!product) return;
        const itemToAdd = {
            id: product.id,
            name: product.name,
            price: product.price,
            img: product.img,
            quantity,
        };

        // Lấy giỏ hàng hiện tại từ sessionStorage
        const currentCart = JSON.parse(sessionStorage.getItem('bookingCart') || '[]');

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        const existingItemIndex = currentCart.findIndex(item => item.id === itemToAdd.id);

        if (existingItemIndex > -1) {
            // Nếu sản phẩm đã có, cập nhật số lượng
            currentCart[existingItemIndex].quantity += quantity;
        } else {
            // Nếu sản phẩm chưa có, thêm mới
            currentCart.push(itemToAdd);
        }

        // Lưu lại vào sessionStorage
        sessionStorage.setItem('bookingCart', JSON.stringify(currentCart));
        notification.success({
            message: 'Thêm vào giỏ hàng thành công',
            description: `${product.name} x${quantity} đã được thêm vào giỏ hàng.`,
            placement: 'topRight',
        });
    };

    // Kiểm tra sản phẩm còn hàng không (status = 1)
    const isProductAvailable = product?.status === 1;

    if (!product) {
        return <div>Loading...</div>;
    }

    return (
        <div className="container py-5">
            {/* Breadcrumb */}
            <nav aria-label="breadcrumb" className="mb-4">
                <ol className="breadcrumb">
                    <li className="breadcrumb-item"><a href="/">Trang chủ</a></li>
                    <li className="breadcrumb-item"><a href="/menu">Thực đơn</a></li>
                    <li className="breadcrumb-item active" aria-current="page">{product.name}</li>
                </ol>
            </nav>

            <div className="row">
                {/* Phần hình ảnh */}
                <div className="col-md-6 mb-4">
                    <div className="position-sticky" style={{ top: '100px' }}>
                        <div className="main-image mb-3">
                            <img
                                src={`/img/${selectedImage || product.img}`}
                                alt={product.name}
                                className="img-fluid rounded"
                                style={{ width: '100%', height: '400px', objectFit: 'cover' }}
                            />
                        </div>
                        <div className="d-flex gap-2 thumbnail-images">
                            {[product.img, ...(product.miniImages || [])].map((img, index) => (
                                <div
                                    key={index}
                                    onClick={() => setSelectedImage(img)}
                                    className={`thumbnail-image ${selectedImage === img ? 'active' : ''}`}
                                    style={{
                                        width: '80px',
                                        height: '80px',
                                        cursor: 'pointer',
                                        border: selectedImage === img ? '2px solid #e65100' : '1px solid #dee2e6',
                                        borderRadius: '4px',
                                        overflow: 'hidden'
                                    }}
                                >
                                    <img
                                        src={`/img/${img}`}
                                        alt={`${product.name} ${index + 1}`}
                                        className="img-fluid"
                                        style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                                    />
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Phần thông tin */}
                <div className="col-md-6">
                    <h1 className="h2 mb-3">{product.name}</h1>

                    <div className="d-flex align-items-center gap-3 mb-4 text-muted">
                        <span>Danh mục: {product.category?.name}</span>
                        <div className="vr"></div>
                        <span>Mã SP: #{product.id}</span>
                    </div>

                    <h2 className="h3 text-primary mb-4" style={{ color: '#e65100' }}>
                        {new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(product.price)}
                    </h2>

                    <div className="mb-4">
                        <ul className="nav nav-tabs" id="productTabs" role="tablist">
                            <li className="nav-item">
                                <a className="nav-link active" data-bs-toggle="tab" href="#description">Mô tả</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" data-bs-toggle="tab" href="#additional">Thông tin thêm</a>
                            </li>
                        </ul>
                        <div className="tab-content py-3">
                            <div className="tab-pane fade show active" id="description">
                                <p className="fs-6">{product.description}</p>
                            </div>
                            <div className="tab-pane fade" id="additional">
                                <p>Thông tin chi tiết về nguyên liệu, cách chế biến...</p>
                            </div>
                        </div>
                    </div>

                    <div className="quantity-selector mb-4">
                        <label className="form-label">Số lượng:</label>
                        <div className="input-group" style={{ width: '150px' }}>
                            <Button 
                                onClick={() => setQuantity(Math.max(1, quantity - 1))}
                                disabled={!isProductAvailable}
                            >
                                -
                            </Button>
                            <input
                                type="number"
                                className="form-control text-center"
                                value={quantity}
                                readOnly
                            />
                            <Button 
                                onClick={() => setQuantity(quantity + 1)}
                                disabled={!isProductAvailable}
                            >
                                +
                            </Button>
                        </div>
                    </div>

                    <div className="d-flex gap-3 mb-4">
                        <Button
                            type="primary"
                            size="large"
                            icon={<ShoppingCartOutlined />}
                            onClick={handleAddToCart}
                            className="flex-grow-1"
                            style={{ 
                                background: isProductAvailable ? '#e65100' : '#d9d9d9',
                                border: 'none', 
                                height: '48px'
                            }}
                            disabled={!isProductAvailable}
                        >
                            {isProductAvailable ? 'Thêm vào giỏ hàng' : 'Hết hàng'}
                        </Button>
                    </div>
                </div>
            </div>

            {/* Sản phẩm liên quan */}
            {relatedProducts && relatedProducts.length > 0 && (
                <div className="related-products mt-5">
                    <h3 className="text-center mb-4">Sản phẩm liên quan</h3>
                    <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        {relatedProducts.map((item) => (
                            <div className="col" key={item.id}>
                                <div className="card h-100 position-relative">
                                    {console.log('Related product status:', item.status)}
                                    {item.status === 0 && (
                                        <div 
                                            className="position-absolute w-100 h-100" 
                                            style={{
                                                background: 'rgba(0,0,0,0.5)',
                                                zIndex: 1,
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center'
                                            }}
                                        >
                                            <Badge 
                                                count="Hết hàng" 
                                                style={{ 
                                                    backgroundColor: '#ff4d4f',
                                                    fontSize: '14px'
                                                }}
                                            />
                                        </div>
                                    )}
                                    <img
                                        src={`/img/${item.img}`}
                                        className="card-img-top"
                                        alt={item.name}
                                        style={{ 
                                            height: '200px', 
                                            objectFit: 'cover',
                                            opacity: item.status === 1 ? 1 : 0.5
                                        }}
                                    />
                                    <div className="card-body">
                                        <h5 className="card-title">{item.name}</h5>
                                        <p className="card-text fw-bold" style={{ color: '#e65100' }}>
                                            {new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(item.price)}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )}

            {bestSellers.length > 0 && (
                <div className="best-sellers mt-5">
                    <h3 className="text-center mb-4">
                        <FireOutlined className="me-2" style={{ color: '#f50' }} />
                        Sản Phẩm Bán Chạy
                    </h3>
                    <Row gutter={[24, 24]}>
                        {bestSellers.map((item) => (
                            <Col xs={24} sm={12} md={6} key={item.id}>
                                <Link href={`/details/${item.id}`}>
                                    <Card
                                        hoverable
                                        cover={
                                            <img
                                                src={`/img/${item.img}`}
                                                alt={item.name}
                                                style={{ height: '200px', objectFit: 'cover' }}
                                            />
                                        }
                                    >
                                        <Card.Meta
                                            title={
                                                <div className="d-flex justify-content-between align-items-center">
                                                    <span>{item.name}</span>
                                                    <Badge 
                                                        count="Bán chạy" 
                                                        style={{ backgroundColor: '#f50' }}
                                                    />
                                                </div>
                                            }
                                            description={
                                                <>
                                                    <p className="text-muted mb-2">{item.description}</p>
                                                    <div className="d-flex justify-content-between align-items-center">
                                                        <span className="fw-bold">
                                                            {new Intl.NumberFormat('vi-VN', {
                                                                style: 'currency',
                                                                currency: 'VND'
                                                            }).format(item.price)}
                                                        </span>
                                                        {item.sale_price && (
                                                            <span className="text-danger">
                                                                {new Intl.NumberFormat('vi-VN', {
                                                                    style: 'currency',
                                                                    currency: 'VND'
                                                                }).format(item.sale_price)}
                                                            </span>
                                                        )}
                                                    </div>
                                                    <p className="text-success mt-2 mb-0">
                                                        <FireOutlined className="me-1" />
                                                        Đã bán: {item.total_sold}
                                                    </p>
                                                </>
                                            }
                                        />
                                    </Card>
                                </Link>
                            </Col>
                        ))}
                    </Row>
                </div>
            )}
        </div>
    );
};

export default ProductDetail;
