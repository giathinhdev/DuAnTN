import React, { useEffect, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button, message, Tag, Space } from 'antd';
import axios from 'axios';
import {
    formatCurrency,
    formatDateTime,
    bookingStatus,
    orderStatus,
    paymentMethod,
    StatusBadge,
    orderItem
} from '@/Utils/statusFormat';

// Thêm styles cho các trạng thái
const statusStyles = {
    container: {
        display: 'flex',
        flexDirection: 'column',
        gap: '8px'
    },
    tag: {
        fontSize: '14px',
        padding: '4px 12px',
        borderRadius: '4px',
        fontWeight: '500'
    },
    button: {
        display: 'flex',
        gap: '8px'
    }
};

const getStatusColor = (status) => {
    switch (status) {
        case 'pending':
            return '#faad14';  // warning yellow
        case 'confirmed':
            return '#1890ff';  // primary blue
        case 'preparing':
            return '#722ed1';  // purple
        case 'completed':
            return '#52c41a';  // success green
        case 'cancelled':
            return '#ff4d4f';  // error red
        case 'paid':
            return '#52c41a';  // success green
        case 'unpaid':
            return '#faad14';  // warning yellow
        default:
            return '#d9d9d9';  // default gray
    }
};

const getStatusText = (status) => {
    switch (status) {
        case 'pending':
            return 'Chờ xác nhận';
        case 'confirmed':
            return 'Đã xác nhận';
        case 'preparing':
            return 'Đang chuẩn bị';
        case 'completed':
            return 'Hoàn thành';
        case 'cancelled':
            return 'Đã hủy';
        case 'paid':
            return 'Đã thanh toán';
        case 'unpaid':
            return 'Chưa thanh toán';
        default:
            return 'Không xác định';
    }
};

const HistoryOrder = () => {
    const [bookings, setBookings] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchBookings = async () => {
            try {
                const response = await axios.get('/api/booking/history');
                if (response.data.success) {
                    setBookings(response.data.bookings);
                }
            } catch (error) {
                console.error('Error fetching bookings:', error);
                message.error('Không thể tải danh sách đơn hàng');
            } finally {
                setLoading(false);
            }
        };

        fetchBookings();
    }, []);

    const handleCancelBooking = async (bookingId) => {
        if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
            return;
        }

        try {
            const response = await axios.put(`/api/booking/${bookingId}/cancel`);
            if (response.data.success) {
                message.success('Hủy đơn hàng thành công');
                setBookings(bookings.map(booking => {
                    if (booking.id === bookingId) {
                        return {
                            ...booking,
                            status: {
                                ...booking.status,
                                booking: 'cancelled',
                                order: 'cancelled'
                            }
                        };
                    }
                    return booking;
                }));
            }
        } catch (error) {
            message.error('Không thể hủy đơn hàng');
        }
    };

    if (loading) {
        return (
            <div className="d-flex align-items-center justify-content-center" style={{ height: '64px' }}>
                <p className="text-muted fs-4">Đang tải...</p>
            </div>
        );
    }

    if (!bookings || bookings.length === 0) {
        return (
            <div className="d-flex align-items-center justify-content-center" style={{ height: '64px' }}>
                <p className="text-muted fs-4">Không có đơn hàng nào.</p>
            </div>
        );
    }

    return (
        <>
            <Head title="Lịch sử đơn hàng" />
            <div className="container py-5">
                <h1 className="display-5 fw-bold mb-4">Lịch sử Đơn Hàng</h1>

                <div className="card">
                    <div className="card-body">
                        <div className="table-responsive">
                            <table className="table">
                                <thead className="table-light">
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Bàn</th>
                                        <th>Món đã đặt</th>
                                        <th>Thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {bookings.map((booking) => (
                                        <tr key={booking.id}>
                                            <td>#{booking.id}</td>
                                            <td>{booking.name}</td>
                                            <td>
                                                <div>{formatDateTime(booking.date_time.date, booking.date_time.time).date}</div>
                                                <small className="text-muted">{booking.date_time.time}</small>
                                                <div className="small text-muted mt-1">
                                                    Tạo: {booking.created_at}
                                                </div>
                                            </td>
                                            <td>{booking.table}</td>
                                            <td>
                                                {booking.items?.map((item, index) => (
                                                    <div key={index} className="mb-2">
                                                        {orderItem.formatSummary(item)}
                                                    </div>
                                                ))}
                                            </td>
                                            <td>
                                                {booking.payment ? (
                                                    <>
                                                        <div className="fw-bold text-success">
                                                            {formatCurrency(booking.payment.amount)}
                                                        </div>
                                                        <small className="text-muted">
                                                            <i className={paymentMethod.getIcon(booking.payment.method)}></i>
                                                            {' '}
                                                            {paymentMethod.getLabel(booking.payment.method)}
                                                        </small>
                                                    </>
                                                ) : (
                                                    <span className="text-muted">Chưa thanh toán</span>
                                                )}
                                            </td>
                                            <td>
                                                <div style={statusStyles.container}>
                                                    <Tag
                                                        color={bookingStatus.getColor(booking.status.booking)}
                                                        style={statusStyles.tag}
                                                    >
                                                        {bookingStatus.getLabel(booking.status.booking)}
                                                    </Tag>
                                                    <Tag
                                                        color={orderStatus.getColor(booking.status.order)}
                                                        style={statusStyles.tag}
                                                    >
                                                        {orderStatus.getLabel(booking.status.order)}
                                                    </Tag>
                                                </div>
                                            </td>
                                            <td>
                                                <Space size="middle" style={statusStyles.button}>
                                                    <Button
                                                        type="primary"
                                                        href={`/orders/${booking.id}`}
                                                    >
                                                        Xem chi tiết
                                                    </Button>
                                                    
                                                    {(booking.status.booking === 'pending' || 
                                                      booking.status.booking === 'confirmed') && 
                                                     booking.status.order === 'unpaid' && (
                                                        <Button 
                                                            danger
                                                            onClick={() => handleCancelBooking(booking.id)}
                                                        >
                                                            Hủy đơn
                                                        </Button>
                                                    )}
                                                </Space>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default HistoryOrder;
