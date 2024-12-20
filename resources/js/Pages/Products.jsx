import React, { useState, useEffect, useMemo } from "react";
import { Layout, Row, Col, Card, Button, Typography, Select, Slider } from "antd";
import { ShoppingCartOutlined, EyeOutlined, StarOutlined } from '@ant-design/icons';
import { usePage } from '@inertiajs/react';

const { Content } = Layout;
const { Title, Paragraph } = Typography;
const { Option } = Select;

const Products = () => {
  const { props } = usePage(); // Lấy dữ liệu từ Inertia
  const { products: fetchedProducts, categories: fetchedCategories } = props;

  const [filters, setFilters] = useState({ category: "all", maxPrice: null, sortBy: "priceAsc" });
  const [displayProducts, setDisplayProducts] = useState(fetchedProducts || []);
  const [displayCategories, setDisplayCategories] = useState(fetchedCategories || []);

  useEffect(() => {
    if (fetchedProducts?.length > 0) {
      setDisplayProducts(fetchedProducts);
    }
    if (fetchedCategories?.length > 0) {
      setDisplayCategories(fetchedCategories);
    }
  }, [fetchedProducts, fetchedCategories]);

  const handleCategoryChange = (value) => setFilters((prevFilters) => ({ ...prevFilters, category: value }));
  const handlePriceChange = (value) => setFilters((prevFilters) => ({ ...prevFilters, maxPrice: value }));
  const handleSortChange = (value) => setFilters((prevFilters) => ({ ...prevFilters, sortBy: value }));
  const handleReset = () => setFilters({ category: "all", maxPrice: null, sortBy: "priceAsc" });

  const filteredProducts = useMemo(() => {
    return displayProducts.filter((product) => {
      if (filters.category !== "all" && product.category_id !== parseInt(filters.category)) {
        return false;
      }
      if (filters.maxPrice !== null && product.price > filters.maxPrice) {
        return false;
      }
      return true;
    });
  }, [displayProducts, filters]);

  const sortedProducts = useMemo(() => {
    return filteredProducts.sort((a, b) => {
      switch (filters.sortBy) {
        case "priceAsc":
          return a.price - b.price;
        case "priceDesc":
          return b.price - a.price;
        case "mostViewed":
          return b.views - a.views;
        case "bestSeller":
          return b.sales - a.sales;
        default:
          return 0;
      }
    });
  }, [filteredProducts, filters.sortBy]);

  return (
    <Layout>
      <Content style={{ padding: "50px" }}>
        {/* Filter Component */}
        {/* Products List */}
        <Row gutter={[16, 16]}>
          {sortedProducts?.map((product) => (
            <Col key={product.id} span={8}>
              <Card>

                <img src={`img/${product.img}`} alt={product.name} style={{ width: "100%" }} />
                <Title level={4}>{product.name}</Title>
                <Paragraph>{product.description}</Paragraph>
                <Paragraph>{product.price} VND</Paragraph>
              </Card>
            </Col>
          ))}
        </Row>
      </Content>
    </Layout>
  );
};

export default Products;
