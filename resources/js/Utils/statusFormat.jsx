import React from 'react';

/**
 * Format trạng thái và nhãn cho toàn bộ ứng dụng
 */

// Format tiền tệ
export const formatCurrency = (amount) => {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
};

// Format ngày giờ
export const formatDateTime = (date, time) => {
    const dateObj = new Date(date);
    const formattedDate = dateObj.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
    return {
        date: formattedDate,
        time: time
    };
};

// Trạng thái đặt bàn
export const bookingStatus = {
    getColor: (status) => {
        switch (status) {
            case 'pending':
                return '#faad14';  // warning yellow - chờ xác nhận
            case 'confirmed':
                return '#1890ff';  // primary blue - đã xác nhận
            case 'preparing':
                return '#722ed1';  // purple - đang chuẩn bị
            case 'completed':
                return '#52c41a';  // success green - hoàn thành
            case 'cancelled':
                return '#ff4d4f';  // error red - đã hủy
            default:
                return '#d9d9d9';  // default gray
        }
    },
    getLabel: (status) => {
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
            default:
                return 'Không xác định';
        }
    }
};

// Trạng thái thanh toán
export const orderStatus = {
    getColor: (status) => {
        switch (status) {
            case 'unpaid':
                return '#faad14';  // warning yellow - chưa thanh toán
            case 'confirmed':
                return '#1890ff';  // primary blue - đã xác nhận
            case 'paid':
                return '#52c41a';  // success green - đã thanh toán
            case 'cancelled':
                return '#ff4d4f';  // error red - đã hủy
            default:
                return '#d9d9d9';  // default gray
        }
    },
    getLabel: (status) => {
        switch (status) {
            case 'unpaid':
                return 'Chờ thanh toán';
            case 'confirmed':
                return 'Đã xác nhận';
            case 'paid':
                return 'Đã thanh toán';
            case 'cancelled':
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }
};

// Phương thức thanh toán
export const paymentMethod = {
    getLabel: (method) => {
        const labels = {
            'credit_card': 'Thẻ tín dụng',
            'e_wallet': 'Ví điện tử',
            'cash_on_delivery': 'Tiền mặt',
            default: 'Không xác định'
        };
        return labels[method] || labels.default;
    },
    getIcon: (method) => {
        const icons = {
            'credit_card': 'fa-credit-card',
            'e_wallet': 'fa-wallet',
            'cash_on_delivery': 'fa-money-bill',
            default: 'fa-question-circle'
        };
        return `fas ${icons[method] || icons.default}`;
    }
};

// Component Badge cho trạng thái
export const StatusBadge = ({ status, type = 'booking' }) => {
    const statusObj = type === 'booking' ? bookingStatus : orderStatus;
    return (
        <span className={`badge ${statusObj.getColor(status)}`}>
            {statusObj.getLabel(status)}
        </span>
    );
};

// Trạng thái bàn
export const tableStatus = {
    getLabel: (status) => {
        const labels = {
            'available': 'Trống',
            'occupied': 'Đã đặt',
            'reserved': 'Đã đặt trước',
            'maintenance': 'Bảo trì',
            default: 'Không xác định'
        };
        return labels[status] || labels.default;
    },
    getColor: (status) => {
        const colors = {
            'available': 'bg-success text-white',
            'occupied': 'bg-danger text-white',
            'reserved': 'bg-warning text-dark',
            'maintenance': 'bg-secondary text-white',
            default: 'bg-secondary text-white'
        };
        return colors[status] || colors.default;
    }
};

// Format cho order items
export const orderItem = {
    formatSummary: (item) => {
        return `${item.name} x ${item.quantity} (${formatCurrency(item.price)})`;
    },
    calculateTotal: (items) => {
        return items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }
};

export const canCancelBooking = (booking) => {
    return (
        // Chỉ cho phép hủy khi:
        (booking.booking_status === 'pending' || booking.booking_status === 'confirmed') && // Đang chờ hoặc đã xác nhận
        booking.order_status !== 'paid' // Chưa thanh toán
    );
};
