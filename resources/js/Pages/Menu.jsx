import React, { useState, useEffect } from "react";
import {
    Layout,
    Row,
    Col,
    Card,
    Typography,
    Button,
    Input,
    Slider,
    Menu as AntMenu,
    Spin,
} from "antd";
import { ShoppingCartOutlined, SearchOutlined } from "@ant-design/icons";
import { useGetApi } from "../Hook/useApi";

const { Content, Sider } = Layout;
const { Title, Paragraph } = Typography;
const { Search } = Input;

const Menu = () => {
    const { data: categories, loading } = useGetApi("/api/menu");
    const [selectedCategory, setSelectedCategory] = useState("all");
    const [priceRange, setPriceRange] = useState([0, 1000000]);
    const [searchQuery, setSearchQuery] = useState("");
    const [filteredProducts, setFilteredProducts] = useState([]);

    // Lấy tất cả sản phẩm từ tất cả danh mục
    const getAllProducts = () => {
        if (!categories) return [];
        return categories.flatMap((category) => category.products);
    };

    // Xử lý lọc sản phẩm theo nhiều điều kiện
    useEffect(() => {
        let results = [];

        // Lọc theo danh mục
        if (selectedCategory === "all") {
            results = getAllProducts();
        } else {
            results =
                categories?.find(
                    (cat) => cat.id.toString() === selectedCategory
                )?.products || [];
        }

        // Lọc theo giá
        results = results.filter((product) => {
            const price = parseFloat(product.price);
            return price >= priceRange[0] && price <= priceRange[1];
        });

        // Lọc theo search query
        if (searchQuery) {
            results = results.filter(
                (product) =>
                    product.name
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase()) ||
                    product.description
                        .toLowerCase()
                        .includes(searchQuery.toLowerCase())
            );
        }

        setFilteredProducts(results);
    }, [categories, selectedCategory, priceRange, searchQuery]);

    // Format giá tiền
    const formatPrice = (price) => {
        return new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(price);
    };

    const handleSearch = (value) => {
        setSearchQuery(value);
    };

    const ProductCard = ({ product }) => (
        <Card
            hoverable
            className="menu-card"
            onClick={() => (window.location.href = `/details/${product.id}`)}
            style={{
                borderRadius: "12px",
                overflow: "hidden",
                border: "none",
                boxShadow: "0 4px 12px rgba(0,0,0,0.1)",
                marginBottom: "20px",
                cursor: "pointer",
            }}
            cover={
                <div style={{ overflow: "hidden", height: "180px" }}>
                    <img
                        alt={product.name}
                        src={`/img/${product.img}`}
                        style={{
                            width: "100%",
                            height: "100%",
                            objectFit: "cover",
                            transition: "transform 0.3s ease",
                        }}
                    />
                </div>
            }
        >
            <Title
                level={5}
                style={{ marginBottom: "8px", textAlign: "center" }}
            >
                {product.name}
            </Title>
            <Paragraph
                ellipsis={{ rows: 2 }}
                style={{ color: "#666", fontSize: "14px", textAlign: "center" }}
            >
                {product.description}
            </Paragraph>
            <div style={{ textAlign: "center", marginBottom: "12px" }}>
                <span
                    style={{
                        fontSize: "18px",
                        fontWeight: "bold",
                        color: "#e65100",
                    }}
                >
                    {formatPrice(product.price)}
                </span>
            </div>
            <Button
                type="primary"
                icon={<ShoppingCartOutlined />}
                style={{
                    width: "100%",
                    background: "#e65100",
                    border: "none",
                }}
                href={`/details/${product.id}`}
            >
                Xem chi tiết
            </Button>
        </Card>
    );

    return (
        <Layout style={{ minHeight: "100vh", background: "#fff" }}>
            {/* Banner Section */}
            <div
                className="menu-banner"
                style={{
                    background:
                        'linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url("/assets/img/Banner/menu-banner.jpg")',
                    backgroundSize: "cover",
                    backgroundPosition: "center",
                    padding: "60px 0",
                    textAlign: "center",
                    color: "#fff",
                    marginBottom: "30px",
                }}
            >
                <Title
                    level={1}
                    style={{ color: "#fff", marginBottom: "20px" }}
                >
                    Thực đơn của chúng tôi
                </Title>
                <Paragraph
                    style={{
                        fontSize: "18px",
                        maxWidth: "600px",
                        margin: "0 auto",
                    }}
                >
                    Khám phá những món ăn đặc sắc được chế biến từ những nguyên
                    liệu tươi ngon nhất
                </Paragraph>
            </div>

            <Layout style={{ background: "#fff", padding: "0 50px" }}>
                {/* Left Sidebar */}
                <Sider width={300} style={{ background: "#fff" }}>
                    <div style={{ padding: "20px" }}>
                        <Search
                            placeholder="Tìm kiếm món ăn..."
                            style={{ marginBottom: "20px" }}
                            prefix={<SearchOutlined />}
                            onChange={(e) => handleSearch(e.target.value)}
                            allowClear
                        />

                        <Title level={4} style={{ marginBottom: "15px" }}>
                            Danh mục
                        </Title>
                        <AntMenu
                            mode="vertical"
                            selectedKeys={[selectedCategory]}
                            style={{ border: "none" }}
                            onClick={({ key }) => setSelectedCategory(key)}
                        >
                            <AntMenu.Item key="all">Tất cả món</AntMenu.Item>
                            {categories?.map((cat) => (
                                <AntMenu.Item key={cat.id}>
                                    {cat.name}
                                </AntMenu.Item>
                            ))}
                        </AntMenu>

                        <Title level={4} style={{ margin: "30px 0 15px" }}>
                            Khoảng giá
                        </Title>
                        <Slider
                            range
                            min={0}
                            max={1000000}
                            step={50000}
                            value={priceRange}
                            onChange={setPriceRange}
                            tipFormatter={(value) => formatPrice(value)}
                        />
                        <div
                            style={{
                                marginTop: "10px",
                                textAlign: "center",
                                color: "#666",
                            }}
                        >
                            {formatPrice(priceRange[0])} -{" "}
                            {formatPrice(priceRange[1])}
                        </div>
                    </div>
                </Sider>

                {/* Main Content */}
                <Content style={{ padding: "20px 35px" }}>
                    {loading ? (
                        <div style={{ textAlign: "center", padding: "40px" }}>
                            <Spin size="large" />
                            <p style={{ marginTop: "10px" }}>
                                Đang tải dữ liệu...
                            </p>
                        </div>
                    ) : (
                        <>
                            {searchQuery && (
                                <Title
                                    level={4}
                                    style={{ marginBottom: "20px" }}
                                >
                                    Kết quả tìm kiếm cho "{searchQuery}" (
                                    {filteredProducts.length} món)
                                </Title>
                            )}
                            <Row gutter={[24, 24]}>
                                {filteredProducts.map((product) => (
                                    <Col
                                        xs={24}
                                        sm={12}
                                        lg={8}
                                        key={product.id}
                                    >
                                        <ProductCard product={product} />
                                    </Col>
                                ))}
                            </Row>
                            {filteredProducts.length === 0 && (
                                <div
                                    style={{
                                        textAlign: "center",
                                        padding: "40px",
                                    }}
                                >
                                    <Title level={4}>
                                        Không tìm thấy sản phẩm phù hợp
                                    </Title>
                                </div>
                            )}
                        </>
                    )}
                </Content>
            </Layout>
        </Layout>
    );
};

export default Menu;
