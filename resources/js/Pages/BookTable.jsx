import React, { useState, useEffect } from 'react';
import { Layout, Form, Input, Select, Button, message, Row, Col, Card, Table, DatePicker, TimePicker, Space, Modal, Badge } from 'antd';
import axios from 'axios';
import dayjs from 'dayjs';
import customParseFormat from 'dayjs/plugin/customParseFormat';
import { PlusOutlined } from '@ant-design/icons';

dayjs.extend(customParseFormat);

const { Content } = Layout;
const { Option } = Select;

const BookTable = () => {
  // Thay vì dùng usePage, chúng ta sẽ kiểm tra auth qua API
  const [isAuthenticated, setIsAuthenticated] = useState(false);

  // Kiểm tra trạng thái đăng nhập khi component mount
  useEffect(() => {
    const checkAuth = async () => {
      try {
        const response = await axios.get('/api/check-auth');
        setIsAuthenticated(response.data.authenticated);
      } catch (error) {
        setIsAuthenticated(false);
      }
    };
    checkAuth();
  }, []);

  // States
  const [tables, setTables] = useState([]);
  const [categories, setCategories] = useState([]);
  const [selectedItems, setSelectedItems] = useState([]);
  const [form] = Form.useForm();
  const [selectedCategory, setSelectedCategory] = useState(categories[0]?.id);
  const [cartItems, setCartItems] = useState([]);

  // Fetch initial data
  useEffect(() => {
    const fetchData = async () => {
      try {
        const [tablesRes, categoriesRes] = await Promise.all([
          axios.get('/api/tables/available'),
          axios.get('/api/categories/with-products')
        ]);
        setTables(tablesRes.data);
        setCategories(categoriesRes.data);
      } catch (error) {
        message.error('Không thể tải dữ liệu');
      }
    };
    fetchData();
  }, []);

  // Thêm useEffect để load giỏ hàng từ sessionStorage
  useEffect(() => {
    const savedCart = JSON.parse(sessionStorage.getItem('bookingCart') || '[]');
    setCartItems(savedCart);
  }, []);

  // Thêm món vào danh sách
  const handleAddItem = (product) => {
    setCartItems(prev => {
      const existing = prev.find(item => item.id === product.id);
      if (existing) {
        return prev.map(item =>
          item.id === product.id
            ? { ...item, quantity: item.quantity + 1 }
            : item
        );
      }
      return [...prev, { ...product, quantity: 1 }];
    });
    sessionStorage.setItem('bookingCart', JSON.stringify(cartItems));
  };

  // Xử lý đặt bàn và món
  const handleSubmit = async (values) => {
    try {
      if (cartItems.length === 0) {
        message.warning('Vui lòng chọn ít nhất một món');
        return;
      }

      // Kiểm tra đăng nhập
      if (!isAuthenticated) {
        Modal.confirm({
          title: 'Bạn cần đăng nhập',
          content: 'Vui lòng đăng nhập để tiếp tục đặt bàn',
          okText: 'Đăng nhập',
          cancelText: 'Hủy',
          onOk() {
            sessionStorage.setItem('redirectAfterLogin', window.location.pathname);
            window.location.href = '/login';
          }
        });
        return;
      }

      const formattedData = {
        ...values,
        booking_date: values.booking_date.format('YYYY-MM-DD'),
        booking_time: values.booking_time.format('HH:mm:ss'),
        items: cartItems.map(item => ({
          product_id: item.id,
          quantity: item.quantity,
          price: item.price
        }))
      };

      const response = await axios.post('/api/booking/store', formattedData);

      if (response.data.success) {
        message.success('Đặt bàn thành công');
        window.location.href = `/payment/${response.data.booking_id}`;
        sessionStorage.removeItem('bookingCart');
        setCartItems([]);
      }
    } catch (error) {
      if (error.response?.status === 401) {
        Modal.confirm({
          title: 'Phiên đăng nhập đã hết hạn',
          content: 'Vui lòng đăng nhập lại để tiếp tục',
          okText: 'Đăng nhập',
          cancelText: 'Hủy',
          onOk() {
            sessionStorage.setItem('redirectAfterLogin', window.location.pathname);
            window.location.href = '/login';
          }
        });
      } else {
        message.error(error.response?.data?.message || 'Đặt bàn thất bại');
      }
    }
  };

  const updateQuantity = (productId, change) => {
    const updatedCart = cartItems.map(item => {
      if (item.id === productId) {
        const newQuantity = Math.max(1, item.quantity + change);
        return { ...item, quantity: newQuantity };
      }
      return item;
    });
    setCartItems(updatedCart);
    sessionStorage.setItem('bookingCart', JSON.stringify(updatedCart));
  };

  const removeItem = (productId) => {
    const updatedCart = cartItems.filter(item => item.id !== productId);
    setCartItems(updatedCart);
    sessionStorage.setItem('bookingCart', JSON.stringify(updatedCart));
  };

  // Tạo các ràng buộc cho ngày giờ
  const disabledDate = (current) => {
    // Không cho phép chọn ngày trong quá khứ
    return current && current < dayjs().startOf('day');
  };

  const disabledTime = () => {
    return {
      disabledHours: () => {
        // Chỉ cho phép từ 8h đến 22h
        const hours = [];
        for (let i = 0; i < 24; i++) {
          if (i < 8 || i > 22) hours.push(i);
        }
        return hours;
      },
    };
  };

  // Validation rules cho form
  const validateMessages = {
    required: '${label} là bắt buộc!',
    types: {
      number: '${label} phải là số!',
    },
    number: {
      min: '${label} không được nhỏ hơn ${min}',
      max: '${label} không được lớn hơn ${max}',
    }
  };

  return (
    <Layout>
      <Content style={{ padding: '50px' }}>
        <Row gutter={[24, 24]}>
          {/* Form đặt bàn */}
          <Col span={8}>
            <Card title="Thông tin đặt bàn">
              <Form
                form={form}
                layout="vertical"
                onFinish={handleSubmit}
                validateMessages={validateMessages}
              >
                <Form.Item
                  name="name"
                  label="Họ tên"
                  rules={[{ required: true, message: 'Vui lòng nhập họ tên' }]}
                >
                  <Input />
                </Form.Item>

                <Form.Item
                  name="phone"
                  label="Số điện thoại"
                  rules={[{ required: true, message: 'Vui lòng nhập số điện thoại' }]}
                >
                  <Input />
                </Form.Item>

                <Form.Item
                  name="booking_date"
                  label="Ngày đặt"
                  rules={[{ required: true, message: 'Vui lòng chọn ngày đặt!' }]}
                >
                  <DatePicker
                    format="DD-MM-YYYY"
                    disabledDate={disabledDate}
                    placeholder="Chọn ngày"
                    style={{ width: '100%' }}
                  />
                </Form.Item>

                <Form.Item
                  name="booking_time"
                  label="Giờ đặt"
                  rules={[{ required: true, message: 'Vui lòng chọn giờ đặt!' }]}
                >
                  <TimePicker
                    format="HH:mm"
                    disabledTime={disabledTime}
                    minuteStep={30}
                    placeholder="Chọn giờ"
                    style={{ width: '100%' }}
                  />
                </Form.Item>

                <Form.Item
                  name="number_of_guests"
                  label="Số người"
                  rules={[
                    { required: true },
                    { type: 'number', min: 1, max: 9 },
                    {
                      validator: (_, value) => {
                        const selectedTableId = form.getFieldValue('table_id');
                        const selectedTable = tables.find(t => t.id === selectedTableId);
                        
                        if (selectedTable && value > selectedTable.capacity) {
                          form.setFieldValue('table_id', undefined); // Clear table selection
                          return Promise.reject('Số người vượt quá sức chứa của bàn đã chọn');
                        }
                        return Promise.resolve();
                      }
                    }
                  ]}
                >
                  <Input 
                    type="number" 
                    min={1} 
                    max={9}
                    onChange={(e) => {
                      const value = Math.max(1, Math.min(9, parseInt(e.target.value) || 1));
                      form.setFieldsValue({ number_of_guests: value });
                      // Clear table selection if number of guests exceeds current table capacity
                      const selectedTableId = form.getFieldValue('table_id');
                      const selectedTable = tables.find(t => t.id === selectedTableId);
                      if (selectedTable && value > selectedTable.capacity) {
                        form.setFieldValue('table_id', undefined);
                      }
                    }}
                  />
                </Form.Item>

                <Form.Item
                  name="table_id"
                  label="Chọn bàn"
                  rules={[{ required: true, message: 'Vui lòng chọn bàn' }]}
                  dependencies={['number_of_guests']}
                >
                  <Select>
                    {tables
                      .filter(table => {
                        const guests = form.getFieldValue('number_of_guests') || 1;
                        return table.capacity >= guests;
                      })
                      .map(table => (
                        <Option key={table.id} value={table.id}>
                          {table.type} - Sức chứa: {table.capacity} người
                        </Option>
                      ))}
                  </Select>
                </Form.Item>

                <Form.Item name="comment" label="Ghi chú">
                  <Input.TextArea />
                </Form.Item>
              </Form>
            </Card>
          </Col>

          {/* Phần chọn món */}
          <Col span={16}>
            <Card title="Thực đơn" style={{ marginBottom: 24 }}>
              <Row gutter={[16, 16]}>
                {/* Danh mục bên trái */}
                <Col span={6}>
                  <Card size="small" title="Danh mục">
                    {categories.map(category => (
                      <div
                        key={category.id}
                        style={{
                          padding: '8px',
                          cursor: 'pointer',
                          backgroundColor: selectedCategory === category.id ? '#f0f0f0' : 'white',
                          marginBottom: '4px',
                          borderRadius: '4px'
                        }}
                        onClick={() => setSelectedCategory(category.id)}
                      >
                        {category.name}
                      </div>
                    ))}
                  </Card>
                </Col>

                {/* Món ăn bên phải */}
                <Col span={18}>
                  <div style={{ height: '400px', overflowY: 'auto' }}>
                    <Row gutter={[8, 8]}>
                      {categories
                        .find(cat => cat.id === selectedCategory)
                        ?.products.map(product => (
                          <Col xs={24} sm={12} md={8} lg={6} key={product.id}>
                            <Card
                              hoverable
                              className={!product.status ? 'out-of-stock' : ''}
                              cover={
                                <img
                                  alt={product.name}
                                  src={`/img/${product.img}`}
                                  style={{ 
                                    height: 200, 
                                    objectFit: "cover",
                                    opacity: product.status ? 1 : 0.5 
                                  }}
                                />
                              }
                            >
                              <Card.Meta
                                title={
                                  <div style={{ fontSize: '14px' }}>
                                    {product.name}
                                    {!product.status && (
                                      <Badge 
                                        count="Hết hàng" 
                                        className="out-of-stock-badge"
                                        style={{marginLeft: '8px'}}
                                      />
                                    )}
                                  </div>
                                }
                                description={
                                  <div style={{ color: '#ff4d4f' }}>
                                    {product.price.toLocaleString()} VND
                                  </div>
                                }
                              />
                              <Button
                                type="primary"
                                icon={<PlusOutlined />}
                                onClick={() => handleAddItem(product)}
                                disabled={!product.status}
                                block
                                style={{ marginTop: '12px' }}
                              >
                                {product.status ? 'Thêm món' : 'Hết hàng'}
                              </Button>
                            </Card>
                          </Col>
                        ))}
                    </Row>
                  </div>
                </Col>
              </Row>
            </Card>

            {/* Danh sách món đã chọn */}
            <Card title="Món đã chọn" size="small">
              <Table
                dataSource={cartItems}
                columns={[
                  {
                    title: 'Tên món',
                    dataIndex: 'name',
                    width: '30%'
                  },
                  {
                    title: 'Hình ảnh',
                    dataIndex: 'img',
                    width: '20%',
                    render: (img) => (
                      <img
                        src={`img/${img}`}
                        alt="Món ăn"
                        style={{ width: '100px', height: '100px', objectFit: 'cover' }}
                      />
                    )
                  },
                  {
                    title: 'Số lượng',
                    dataIndex: 'quantity',
                    width: '20%',
                    render: (quantity, record) => (
                      <Space>
                        <Button
                          size="small"
                          onClick={() => updateQuantity(record.id, -1)}
                          disabled={quantity <= 1}
                        >
                          -
                        </Button>
                        {quantity}
                        <Button
                          size="small"
                          onClick={() => updateQuantity(record.id, 1)}
                        >
                          +
                        </Button>
                      </Space>
                    )
                  },
                  {
                    title: 'Đơn giá',
                    dataIndex: 'price',
                    width: '20%',
                    render: price => `${price.toLocaleString()} VND`
                  },
                  {
                    title: 'Thành tiền',
                    width: '20%',
                    render: (_, record) => `${(record.quantity * record.price).toLocaleString()} VND`
                  },
                  {
                    title: '',
                    width: '10%',
                    render: (_, record) => (
                      <Button
                        type="text"
                        danger
                        size="small"
                        onClick={() => removeItem(record.id)}
                      >
                        Xóa
                      </Button>
                    )
                  }
                ]}
                pagination={false}
                summary={data => {
                  const total = data.reduce((sum, item) => sum + (item.quantity * item.price), 0);
                  return (
                    <Table.Summary.Row>
                      <Table.Summary.Cell colSpan={3}>Tổng cộng:</Table.Summary.Cell>
                      <Table.Summary.Cell>
                        <strong>{total.toLocaleString()} VND</strong>
                      </Table.Summary.Cell>
                    </Table.Summary.Row>
                  );
                }}
              />
            </Card>

            {/* Nút xác nhận */}
            <div style={{ textAlign: 'center', marginTop: 16 }}>
              <Button
                type="primary"
                size="large"
                onClick={() => form.submit()}
              >
                Xác nhận đặt bàn và thanh toán
              </Button>
            </div>
          </Col>
        </Row>
      </Content>
    </Layout>
  );
};

export default BookTable;
