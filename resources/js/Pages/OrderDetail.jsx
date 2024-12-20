import React, { useState, useEffect } from 'react';
import { Card, Descriptions, Table, Tag, Spin, message, Button, Image } from 'antd';
import { formatCurrency, formatDateTime, canCancelBooking, bookingStatus, orderStatus } from '../Utils/statusFormat';
import axios from 'axios';
import { DeleteOutlined } from '@ant-design/icons';

const OrderDetail = ({ id }) => {
    const [loading, setLoading] = useState(true);
    const [orderDetail, setOrderDetail] = useState(null);

    useEffect(() => {
        fetchOrderDetail();
    }, [id]);

    const fetchOrderDetail = async () => {
        try {
            const response = await axios.get(`/api/booking/${id}`);
            if (response.data.success) {
                setOrderDetail(response.data.booking);
            } else {
                message.error('Không thể tải thông tin đơn hàng');
            }
        } catch (error) {
            message.error('Có lỗi xảy ra khi tải thông tin đơn hàng');
        } finally {
            setLoading(false);
        }
    };

    const handleCancelBooking = async (bookingId) => {
        try {
            const response = await axios.put(`/api/booking/${bookingId}/cancel`);
            if (response.data.success) {
                message.success('Hủy đơn hàng thành công');
                fetchOrderDetail();
            }
        } catch (error) {
            message.error('Không thể hủy đơn hàng');
        }
    };

    if (loading) return <Spin size="large" />;
    if (!orderDetail) return <div>Không tìm thấy thông tin đơn hàng</div>;

    const columns = [
        {
            title: 'Hình ảnh',
            dataIndex: 'img',
            key: 'img',
            width: 120,
            render: (_, record) => (
                <Image
                    src={`/img/${record.img}`}
                    alt={record.product_name}
                    width={100}
                    height={100}
                    style={{ objectFit: 'cover', borderRadius: '8px' }}
                    preview={false}
                />
            ),
        },
        {
            title: 'Tên món',
            dataIndex: 'product_name',
            key: 'product_name',
        },
        {
            title: 'Số lượng',
            dataIndex: 'quantity',
            key: 'quantity',
            width: 100,
            align: 'center',
        },
        {
            title: 'Đơn giá',
            dataIndex: 'price',
            key: 'price',
            width: 150,
            align: 'right',
            render: (price) => formatCurrency(price),
        },
        {
            title: 'Thành tiền',
            dataIndex: 'subtotal',
            key: 'subtotal',
            width: 150,
            align: 'right',
            render: (subtotal) => formatCurrency(subtotal),
        },
    ];

    return (
        <div className="p-4">
            <Card title="Chi tiết đơn đặt bàn" className="mb-4">
                <Descriptions bordered column={2}>
                    <Descriptions.Item label="Mã đơn" span={2}>
                        #{orderDetail.id}
                    </Descriptions.Item>
                    <Descriptions.Item label="Thông tin bàn" span={2}>
                        {orderDetail.table.type} - Sức chứa: {orderDetail.table.capacity} người
                    </Descriptions.Item>
                    <Descriptions.Item label="Ngày đặt">
                        {formatDateTime(orderDetail.booking_details.booking_date).date}
                    </Descriptions.Item>
                    <Descriptions.Item label="Giờ đặt">
                        {orderDetail.booking_details.booking_time}
                    </Descriptions.Item>
                    <Descriptions.Item label="Số khách">
                        {orderDetail.booking_details.number_of_guests} người
                    </Descriptions.Item>
                    <Descriptions.Item label="Trạng thái đặt bàn">
                        <Tag color={bookingStatus.getColor(orderDetail.booking_details.booking_status)}>
                            {bookingStatus.getLabel(orderDetail.booking_details.booking_status)}
                        </Tag>
                    </Descriptions.Item>
                    <Descriptions.Item label="Trạng thái thanh toán">
                        <Tag color={orderStatus.getColor(orderDetail.booking_details.order_status)}>
                            {orderStatus.getLabel(orderDetail.booking_details.order_status)}
                        </Tag>
                    </Descriptions.Item>
                    <Descriptions.Item label="Thời gian tạo">
                        {orderDetail.booking_details.created_at}
                    </Descriptions.Item>
                    {orderDetail.booking_details.comment && (
                        <Descriptions.Item label="Ghi chú" span={2}>
                            {orderDetail.booking_details.comment}
                        </Descriptions.Item>
                    )}
                </Descriptions>

                {(orderDetail.booking_details.booking_status === 'pending' || 
                  orderDetail.booking_details.booking_status === 'confirmed') && 
                 orderDetail.booking_details.order_status === 'unpaid' && (
                    <div style={{ marginTop: '16px' }}>
                        <Button
                            type="danger"
                            onClick={() => handleCancelBooking(orderDetail.id)}
                            icon={<DeleteOutlined />}
                            size="large"
                        >
                            Hủy đơn hàng
                        </Button>
                    </div>
                )}
            </Card>

            <Card title="Chi tiết món đã đặt">
                <Table
                    columns={columns}
                    dataSource={orderDetail.order_items}
                    pagination={false}
                    rowKey="product_name"
                    summary={() => (
                        <Table.Summary>
                            <Table.Summary.Row>
                                <Table.Summary.Cell colSpan={4} className="text-right">
                                    <strong>Tổng cộng:</strong>
                                </Table.Summary.Cell>
                                <Table.Summary.Cell align="right">
                                    <strong>{formatCurrency(orderDetail.total_amount)}</strong>
                                </Table.Summary.Cell>
                            </Table.Summary.Row>
                        </Table.Summary>
                    )}
                />
            </Card>
        </div>
    );
};

export default OrderDetail; 