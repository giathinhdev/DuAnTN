import React, { useState, useEffect } from "react";
import axios from "axios";
import { Card, Form, Input, Select, Button, message, Table, Descriptions, Layout, Alert, Modal, Row, Col } from "antd";
import { Head } from '@inertiajs/react';

const { Option } = Select;
const { Content } = Layout;

const Payment = ({ bookingId }) => {
  const [loading, setLoading] = useState(true);
  const [bookingData, setBookingData] = useState(null);
  const [form] = Form.useForm();
  const [submitting, setSubmitting] = useState(false);

  useEffect(() => {
    if (bookingId) {
      fetchBookingData();
    }
  }, [bookingId]);

  const fetchBookingData = async () => {
    try {
      const response = await axios.get(`/api/payment/${bookingId}`);
      if (response.data.success) {
        setBookingData(response.data);
      } else {
        message.error('Không thể tải thông tin đơn hàng');
      }
    } catch (error) {
      console.error('Error:', error);
      message.error('Không thể tải thông tin đơn hàng');
    } finally {
      setLoading(false);
    }
  };

  const handlePayment = async (values) => {
    try {
      setSubmitting(true);
      const response = await axios.post(`/api/payment/${bookingId}/confirm`, values);
      
      if (response.data.success) {
        message.success(response.data.message);
        
        // Redirect sau khi thanh toán thành công
        window.location.href = '/orders/history';
      }
    } catch (error) {
      message.error(error.response?.data?.message || 'Có lỗi xảy ra khi thanh toán');
    } finally {
      setSubmitting(false);
    }
  };

  if (loading) return <div>Loading...</div>;
  if (!bookingData) return <div>Không tìm thấy thông tin đơn hàng</div>;

  const columns = [
    {
      title: 'STT',
      dataIndex: 'id',
      width: '10%',
      render: (text, record, index) => index + 1,
    },
    {
      title: 'Tên món',
      dataIndex: 'product_name',
      width: '40%',
    },
    {
      title: 'Số lượng',
      dataIndex: 'quantity',
      width: '15%',
      align: 'center',
    },
    {
      title: 'Đơn giá',
      dataIndex: 'price',
      width: '15%',
      align: 'right',
      render: (price) => `${price.toLocaleString()} đ`,
    },
    {
      title: 'Thành tiền',
      dataIndex: 'total',
      width: '20%',
      align: 'right',
      render: (total) => `${total.toLocaleString()} đ`,
    },
  ];

  const DEMO_ACCOUNTS = {
    credit_card: {
      number: '4532715384629174',
      cvv: '123',
      expiry: '12/25'
    },
    e_wallet: {
      momo: '0987654321',
      zalopay: '0123456789',
      vnpay: '9876543210'
    }
  };

  const renderPaymentFields = (paymentMethod) => {
    switch (paymentMethod) {
      case 'credit_card':
        return (
          <>
            <Form.Item
              name="card_number"
              label="Số thẻ"
              rules={[{ required: true, message: 'Vui lòng nhập số thẻ' }]}
            >
              <Input placeholder="Thẻ test: 4532715384629174" />
            </Form.Item>
            <Row gutter={16}>
              <Col span={12}>
                <Form.Item
                  name="expiry_date"
                  label="Ngày hết hạn"
                  rules={[{ required: true, message: 'Vui lòng nhập ngày hết hạn' }]}
                >
                  <Input placeholder="MM/YY (Test: 12/25)" />
                </Form.Item>
              </Col>
              <Col span={12}>
                <Form.Item
                  name="cvv"
                  label="CVV"
                  rules={[{ required: true, message: 'Vui lòng nhập CVV' }]}
                >
                  <Input placeholder="Test: 123" />
                </Form.Item>
              </Col>
            </Row>
            <Alert
              message="Thông tin thẻ test"
              description={
                <ul>
                  <li>Số thẻ: 4532715384629174</li>
                  <li>CVV: 123</li>
                  <li>Hết hạn: 12/25</li>
                </ul>
              }
              type="info"
              showIcon
            />
          </>
        );
      case 'e_wallet':
        return (
          <>
            <Form.Item
              name="wallet_type"
              label="Loại ví"
              rules={[{ required: true, message: 'Vui lòng chọn loại ví' }]}
            >
              <Select>
                <Option value="momo">MoMo</Option>
                <Option value="zalopay">ZaloPay</Option>
                <Option value="vnpay">VNPay</Option>
              </Select>
            </Form.Item>
            <Form.Item
              noStyle
              shouldUpdate={(prevValues, currentValues) =>
                prevValues.wallet_type !== currentValues.wallet_type
              }
            >
              {({ getFieldValue }) => {
                const walletType = getFieldValue('wallet_type');
                const demoAccounts = {
                  momo: {
                    success: '0987654321',
                    error: '0987654322'
                  },
                  zalopay: {
                    success: '0123456789',
                    error: '0123456788'
                  },
                  vnpay: {
                    success: '9876543210',
                    error: '9876543211'
                  }
                };

                let placeholder = walletType
                  ? `Số tài khoản test thành công: ${demoAccounts[walletType].success}`
                  : 'Vui lòng chọn loại ví';

                return (
                  <Form.Item
                    name="wallet_number"
                    label="Số tài khoản"
                    rules={[{ required: true, message: 'Vui lòng nhập số tài khoản' }]}
                  >
                    <Input placeholder={placeholder} />
                  </Form.Item>
                );
              }}
            </Form.Item>
            <Alert
              message="Thông tin tài khoản test"
              description={
                <ul>
                  <li>Nhập đúng số tài khoản test: Thanh toán thành công</li>
                  <li>Nhập sai số tài khoản: Báo lỗi thanh toán</li>
                </ul>
              }
              type="info"
              showIcon
              style={{ marginTop: 16 }}
            />
          </>
        );
      default:
        return null;
    }
  };

  return (
    <Layout>
      <Head title="Thanh toán" />
      <Content style={{ padding: '24px', maxWidth: '1200px', margin: '0 auto' }}>
        <Card className="shadow-sm">
          <h1 style={{
            textAlign: 'center',
            fontSize: '24px',
            marginBottom: '24px',
            color: '#1890ff'
          }}>
            Chi tiết đơn hàng và thanh toán
          </h1>

          {loading ? (
            <div style={{ textAlign: 'center', padding: '50px' }}>
              <span>Đang tải thông tin...</span>
            </div>
          ) : !bookingData ? (
            <div style={{ textAlign: 'center', padding: '50px' }}>
              <span>Không tìm thấy thông tin đơn hàng</span>
            </div>
          ) : (
            <>
              <Card
                title={<span style={{ color: '#1890ff' }}>Thông tin đặt bàn</span>}
                className="mb-4"
              >
                <Descriptions bordered column={{ xs: 1, sm: 2, md: 3 }}>
                  <Descriptions.Item label={<strong>Số bàn</strong>}>
                    Bàn số {bookingData.booking.table_number}
                  </Descriptions.Item>
                  <Descriptions.Item label={<strong>Ngày đặt</strong>}>
                    {new Date(bookingData.booking.booking_date).toLocaleDateString('vi-VN')}
                  </Descriptions.Item>
                  <Descriptions.Item label={<strong>Giờ đặt</strong>}>
                    {bookingData.booking.booking_time}
                  </Descriptions.Item>
                  <Descriptions.Item label={<strong>Số khách</strong>}>
                    {bookingData.booking.number_of_guests} người
                  </Descriptions.Item>
                  <Descriptions.Item label={<strong>Số điện thoại</strong>}>
                    {bookingData.booking.phone}
                  </Descriptions.Item>
                  <Descriptions.Item label={<strong>Trạng thái</strong>}>
                    <span style={{
                      color: bookingData.booking.booking_status === 'confirmed' ? '#52c41a' : '#1890ff'
                    }}>
                      {bookingData.booking.booking_status === 'confirmed' ? 'Đã xác nhận' : 'Chờ xác nhận'}
                    </span>
                  </Descriptions.Item>
                </Descriptions>
              </Card>

              <Card
                title={<span style={{ color: '#1890ff' }}>Chi tiết món ăn</span>}
                className="mb-4"
              >
                <Table
                  dataSource={bookingData.orderItems}
                  columns={columns}
                  pagination={false}
                  rowKey="id"
                  bordered
                  summary={() => (
                    <Table.Summary>
                      <Table.Summary.Row>
                        <Table.Summary.Cell colSpan={4} align="right">
                          <strong>Tổng cộng:</strong>
                        </Table.Summary.Cell>
                        <Table.Summary.Cell align="right">
                          <strong style={{ color: '#f5222d', fontSize: '16px' }}>
                            {bookingData.totalAmount.toLocaleString()} đ
                          </strong>
                        </Table.Summary.Cell>
                      </Table.Summary.Row>
                    </Table.Summary>
                  )}
                />
              </Card>

              <Card
                title={<span style={{ color: '#1890ff' }}>Phương thức thanh toán</span>}
              >
                <Form
                  form={form}
                  layout="vertical"
                  onFinish={handlePayment}
                >
                  <Form.Item
                    name="payment_method"
                    label={<strong>Chọn phương thức thanh toán</strong>}
                    rules={[{ required: true, message: 'Vui lòng chọn phương thức thanh toán' }]}
                  >
                    <Select size="large">
                      <Option value="credit_card">💳 Thẻ tín dụng</Option>
                      <Option value="e_wallet">📱 Ví điện tử</Option>
                      <Option value="cash_on_delivery">💵 Thanh toán khi đến nhà hàng</Option>
                    </Select>
                  </Form.Item>

                  <Form.Item noStyle shouldUpdate>
                    {({ getFieldValue }) => {
                      const paymentMethod = getFieldValue('payment_method');
                      return renderPaymentFields(paymentMethod);
                    }}
                  </Form.Item>

                  <Form.Item style={{ marginTop: 24 }}>
                    <Button
                      type="primary"
                      htmlType="submit"
                      size="large"
                      block
                      style={{ height: '48px', fontSize: '16px' }}
                      loading={submitting}
                    >
                      Xác nhận thanh toán
                    </Button>
                  </Form.Item>
                </Form>
              </Card>
            </>
          )}
        </Card>
      </Content>
    </Layout>
  );
};

export default Payment;
