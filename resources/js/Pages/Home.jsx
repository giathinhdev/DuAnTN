import React, { useEffect, useState } from "react";
import { useGetApi } from "../Hook/useApi";
import { Button, Spin, Card, Row, Col, Badge, Tag } from "antd";
import { ShoppingCartOutlined, FireOutlined, PercentageOutlined } from "@ant-design/icons";
import { formatCurrency, formatDateTime } from "../Utils/statusFormat";

const Home = () => {
    const { data: productsData, loading, error } = useGetApi("/api/products");
    const { data: bestSellersData } = useGetApi("/api/best-sellers");
    const { data: promotionData } = useGetApi("/api/promotion-products");
    const [products, setProducts] = useState([]);
    const [bestSellers, setBestSellers] = useState([]);
    const [promotionProducts, setPromotionProducts] = useState([]);

    useEffect(() => {
        if (productsData) {
            setProducts(productsData);
        }
    }, [productsData]);

    useEffect(() => {
        if (bestSellersData?.data) {
            setBestSellers(bestSellersData.data);
        }
    }, [bestSellersData]);

    useEffect(() => {
        if (promotionData?.data) {
            setPromotionProducts(promotionData.data);
        }
    }, [promotionData]);

    const renderProductCard = (product, type = 'normal') => (
        <Col xs={24} sm={12} md={8} lg={6} key={product.id}>
            <Card
                hoverable
                cover={
                    <div style={{ position: 'relative' }}>
                        <img
                            alt={product.name}
                            src={`/img/${product.img}`}
                            style={{ height: 200, objectFit: "cover" }}
                        />
                        {type === 'promotion' && (
                            <div 
                                style={{
                                    position: 'absolute',
                                    top: 10,
                                    right: 10,
                                    background: '#f50',
                                    color: 'white',
                                    padding: '4px 8px',
                                    borderRadius: '4px'
                                }}
                            >
                                <PercentageOutlined /> {product.discount_percent}% Giảm
                            </div>
                        )}
                    </div>
                }
                onClick={() => window.location.href = `/details/${product.id}`}
            >
                <Card.Meta
                    title={
                        <div className="d-flex justify-content-between align-items-center">
                            <span>{product.name}</span>
                            {type === 'bestseller' && (
                                <Badge count="Bán chạy" style={{ backgroundColor: '#f50' }} />
                            )}
                        </div>
                    }
                    description={
                        <>
                            <p className="text-muted mb-2">{product.description}</p>
                            <div className="d-flex justify-content-between align-items-center mb-2">
                                {product.sale_price ? (
                                    <>
                                        <span className="text-decoration-line-through text-muted">
                                            {formatCurrency(product.price)}
                                        </span>
                                        <span className="text-danger fw-bold">
                                            {formatCurrency(product.sale_price)}
                                        </span>
                                    </>
                                ) : (
                                    <span className="fw-bold">{formatCurrency(product.price)}</span>
                                )}
                            </div>
                            {type === 'bestseller' && (
                                <p className="text-success mb-2">
                                    <FireOutlined className="me-1" />
                                    Đã bán: {product.total_sold}
                                </p>
                            )}
                            <Button
                                type="primary"
                                icon={<ShoppingCartOutlined />}
                                block
                            >
                                Xem chi tiết
                            </Button>
                        </>
                    }
                />
            </Card>
        </Col>
    );

    if (loading) return <div className="text-center py-5"><Spin size="large" /></div>;
    if (error) return <div className="text-center py-5 text-danger">Có lỗi xảy ra khi tải dữ liệu</div>;

    return (
        <>
            {/* Banner Section */}
            <section className="hero position-relative">
                <div className="hero-overlay position-absolute w-100 h-100 bg-dark opacity-50"></div>
                <img
                    src="/assets/img/Banner/banner.jpg"
                    alt="Banner"
                    className="w-100"
                    style={{ height: "600px", objectFit: "cover" }}
                />
                <div className="position-absolute top-50 start-50 translate-middle text-center text-white">
                    <h1 className="display-4 fw-bold mb-4">Nhà hàng Việt Nam</h1>
                    <p className="lead mb-4">Khám phá hương vị ẩm thực truyền thống</p>
                    <Button
                        type="primary"
                        size="large"
                        className="px-5"
                        href="/booktable"
                    >
                        Đặt bàn ngay
                    </Button>
                </div>
            </section>

            {/* Promotion Products Section */}
            <section className="py-5 bg-light">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="fw-bold">Khuyến Mãi Hot</h2>
                        <p className="text-muted">Những món ăn đang được giảm giá hấp dẫn</p>
                    </div>
                    <Row gutter={[24, 24]}>
                        {promotionProducts.map(product => renderProductCard(product, 'promotion'))}
                    </Row>
                </div>
            </section>

            {/* Products Section */}
            <section className="py-5">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="fw-bold">Món Ăn Mới Nhất</h2>
                        <p className="text-muted">Khám phá những món ăn mới nhất từ đầu bếp của chúng tôi</p>
                    </div>
                    <Row gutter={[24, 24]}>
                        {products.map(product => renderProductCard(product))}
                    </Row>
                </div>
            </section>

            {/* Best Sellers Section */}
            <section className="py-5 bg-light">
                <div className="container">
                    <div className="text-center mb-5">
                        <h2 className="fw-bold">Món Ăn Bán Chạy</h2>
                        <p className="text-muted">Những món ăn được yêu thích nhất</p>
                    </div>
                    <Row gutter={[24, 24]}>
                        {bestSellers.map(product => renderProductCard(product, true))}
                    </Row>
                </div>
            </section>

            {/* Reservation Section */}
            <section className="py-5">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6">
                            <h2 className="fw-bold mb-4">Đặt bàn ngay</h2>
                            <p className="text-muted mb-4">
                                Đến với nhà hàng, khách hàng sẽ thấy được không gian thoáng đãng,
                                có những phòng riêng biệt cho hội họp hay sinh nhật với màu sắc tươi sáng.
                            </p>
                            <Button type="primary" size="large" href="/booktable">
                                Đặt bàn ngay
                            </Button>
                        </div>
                        <div className="col-lg-6">
                            <img
                                src="/assets/img/Banner/banner.jpg"
                                alt="Restaurant"
                                className="img-fluid rounded shadow"
                            />
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default Home;