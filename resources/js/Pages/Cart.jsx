import React, { useState, useEffect, useCallback } from "react";
import {
  Layout,
  Table,
  Button,
  Typography,
  Checkbox,
  Col,
  Row,
  Space,
  message,
  Card,
} from "antd";
import { useShopping } from "../Hook/useContentShoping";
import { ShoppingCartOutlined, DeleteOutlined, PlusOutlined, MinusOutlined } from "@ant-design/icons";
import { usePostApi } from "../Hook/useApi";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

const { Title } = Typography;
const { Content } = Layout;

const Cart = () => {
  const { cart, removeFromCart, updateCartQuantity } = useShopping();
  const [selectedItems, setSelectedItems] = useState([]);
  const [booking, setBooking] = useState(null);
  const { postData } = usePostApi("/api/cart/confirm");

  // Fetch booking information
  useEffect(() => {
    const fetchBookingData = async () => {
      try {
        const response = await axios.get('/api/booking/current');
        if (response.data) {
          setBooking(response.data);
        }
      } catch (error) {
        console.error('Error fetching current booking:', error);
      }
    };
    fetchBookingData();
  }, []);

  // Select or deselect an item
  const handleSelectItem = useCallback(
    (id) => {
      setSelectedItems((prev) =>
        prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
      );
    },
    []
  );

  // Select or deselect all items
  const handleSelectAll = useCallback(
    (e) => {
      setSelectedItems(e.target.checked ? cart.map((item) => item.id) : []);
    },
    [cart]
  );

  // Generate a random menu code
  const generateRandomCode = useCallback(() => {
    const characters =
      "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    return Array.from({ length: 8 }, () =>
      characters.charAt(Math.floor(Math.random() * characters.length))
    ).join("");
  }, []);

  const handleAddCheckOut = useCallback(async () => {
    if (selectedItems.length === 0) {
      message.error("Vui lòng chọn ít nhất một món ăn để thanh toán.");
      return;
    }

    const menuCode = generateRandomCode();
    const itemsToCheckout = selectedItems.map((id) =>
      cart.find((item) => item.id === id)
    );
    const totalCartPrice = itemsToCheckout.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );

    const checkout = {
      items: itemsToCheckout,
      menuCode,
      price: totalCartPrice,
      status: "completed", // Keep it as pending for now
      created_at: new Date(),
      updated_at: new Date(),
    };

    // Instead of posting data immediately, just store the checkout info in sessionStorage
    sessionStorage.setItem("checkout", JSON.stringify(checkout));

    // Redirect to the checkout page
    Inertia.visit(route("checkout"));
    message.success("Chuyển đến trang thanh toán.");
  }, [selectedItems, cart, generateRandomCode]);


  // Remove selected items
  const handleRemoveSelectedItems = useCallback(() => {
    selectedItems.forEach(removeFromCart);
    setSelectedItems([]);
  }, [selectedItems, removeFromCart]);

  const columns = [
    {
      title: (
        <Checkbox
          onChange={handleSelectAll}
          checked={selectedItems.length === cart.length}
        />
      ),
      key: "select-all",
      render: (_, record) => (
        <Checkbox
          checked={selectedItems.includes(record.id)}
          onChange={() => handleSelectItem(record.id)}
        />
      ),
    },
    {
      title: "Tên sản phẩm",
      dataIndex: "name",
      key: "name",
      render: (name) => <span style={{ fontWeight: "bold" }}>{name}</span>,
    },
    {
      title: "Số lượng",
      dataIndex: "quantity",
      key: "quantity",
      render: (quantity, record) => (
        <div>
          <Button
            onClick={() => updateCartQuantity(record.id, record.quantity - 1)}
            disabled={record.quantity <= 1}
            icon={<MinusOutlined />}
          />
          <span style={{ margin: "0 10px" }}>{quantity}</span>
          <Button
            onClick={() => updateCartQuantity(record.id, record.quantity + 1)}
            icon={<PlusOutlined />}
          />
        </div>
      ),
    },
    {
      title: "Giá",
      dataIndex: "price",
      key: "price",
      render: (price) => `${price} VNĐ`,
    },
    {
      title: "Thao tác",
      key: "action",
      render: (_, record) => (
        <Button
          danger
          onClick={() => removeFromCart(record.id)}
          icon={<DeleteOutlined />}
        >
          Xóa
        </Button>
      ),
    },
  ];

  const totalPrice = cart.reduce(
    (total, item) =>
      selectedItems.includes(item.id)
        ? total + item.price * item.quantity
        : total,
    0
  );

  return (
    <Layout style={{ minHeight: "100vh" }}>
      <Content style={{ padding: "20px", backgroundColor: "#f9f9f9" }}>
        <Title level={2} style={{ textAlign: "center", fontWeight: "bold" }}>
          Món ăn đã chọn
        </Title>

        {cart.length === 0 ? (
          <p style={{ textAlign: "center", fontSize: "16px", color: "#888" }}>
            Hiện tại bạn chưa lựa chọn món ăn nào.
          </p>
        ) : (
          <Row gutter={20}>
            <Col span={16}>
              <Card>
                <Table
                  dataSource={cart}
                  columns={columns}
                  rowKey="id"
                  pagination={false}
                />
                <div style={{ textAlign: "right", marginTop: "20px" }}>
                  <Title level={3}>Tổng cộng: {totalPrice} VNĐ</Title>
                  <Space>
                    <Button
                      type="primary"
                      danger
                      onClick={handleRemoveSelectedItems}
                      disabled={selectedItems.length === 0}
                    >
                      Xóa các món đã chọn
                    </Button>
                    <Button type="primary" onClick={handleAddCheckOut}>
                      Tiến hành đặt bàn
                    </Button>
                  </Space>
                </div>
              </Card>
            </Col>

            <Col span={8}>
              {booking ? (
                <Card>
                  <Title level={4}>Thông tin đặt bàn</Title>
                  <p>
                    <strong>Số điện thoại:</strong> {booking.phone}
                  </p>
                  <p>
                    <strong>Ngày đặt:</strong> {booking.booking_date}
                  </p>
                  <p>
                    <strong>Thời gian:</strong> {booking.booking_time}
                  </p>
                  <p>
                    <strong>Số lượng khách:</strong> {booking.number_of_guests}
                  </p>
                </Card>
              ) : (
                <p>Đang tải thông tin đặt bàn...</p>
              )}
            </Col>
          </Row>
        )}
      </Content>
    </Layout>
  );
};

export default Cart;
