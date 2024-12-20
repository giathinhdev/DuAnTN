import React from "react";
import { Button } from "antd";
import {
    PhoneOutlined,
    ClockCircleOutlined,
    EnvironmentOutlined,
    MenuOutlined,
} from "@ant-design/icons";
import { Link } from "@inertiajs/react";

const Contact = () => {
    return (
        <>
            <div className="page-banner position-relative">
                <div className="overlay w-100 h-100 bg-dark opacity-50"></div>
                <div className="container position-relative text-white py-5">
                    <h1 className="display-4 fw-bold text-center mb-3">
                        Liên hệ
                    </h1>
                    <p className="lead text-center">
                        Hãy liên hệ với chúng tôi để được phục vụ tốt nhất
                    </p>
                </div>
            </div>

            <div className="container py-5">
                <div className="row">
                    <div className="col-lg-5 mb-4 mb-lg-0">
                        <div className="bg-light p-4 rounded shadow-sm mb-4">
                            <h5 className="fw-bold mb-4">
                                <ClockCircleOutlined className="me-2" /> Giờ mở
                                cửa:
                            </h5>
                            <div className="mb-3">
                                <p className="mb-2">
                                    <strong>Thứ 2 - Thứ 6:</strong> 8:15 - 22:00
                                </p>
                                <p className="mb-2">
                                    <strong>Thứ 7:</strong> 8:00 - 23:00
                                </p>
                                <p className="mb-0">
                                    <strong>Chủ nhật:</strong> 7:00 - 23:30
                                </p>
                            </div>
                            <p className="mb-0">
                                <strong>Thời gian đặt bàn:</strong> 24/7
                            </p>
                        </div>

                        <div className="bg-light p-4 rounded shadow-sm">
                            <h5 className="fw-bold mb-4">Thông tin liên hệ:</h5>
                            <p className="mb-3">
                                <EnvironmentOutlined className="me-2" />
                                Số 3 Cầu Giấy, Đống Đa, Hà Nội
                            </p>
                            <p className="mb-3">
                                <PhoneOutlined className="me-2" />
                                <a
                                    href="tel:0987654332"
                                    className="text-decoration-none"
                                >
                                    0987654332
                                </a>
                            </p>
                        </div>
                    </div>

                    <div className="col-lg-7">
                        <div className="bg-light p-4 rounded shadow-sm">
                            <div className="d-flex justify-content-center gap-3 mb-4">
                                <Link href="/menu">
                                    <Button
                                        type="primary"
                                        size="large"
                                        icon={<MenuOutlined />}
                                    >
                                        Xem Thực đơn
                                    </Button>
                                </Link>
                                <Link href="/booktable">
                                    <Button type="primary" size="large">
                                        Đặt bàn ngay
                                    </Button>
                                </Link>
                            </div>

                            <form
                                id="contact-form"
                                className="needs-validation"
                            >
                                <div className="mb-3">
                                    <label
                                        htmlFor="name"
                                        className="form-label fw-bold"
                                    >
                                        Họ và tên:
                                    </label>
                                    <input
                                        type="text"
                                        className="form-control"
                                        id="name"
                                        placeholder="Nhập họ và tên"
                                        required
                                    />
                                </div>

                                <div className="mb-3">
                                    <label
                                        htmlFor="phone"
                                        className="form-label fw-bold"
                                    >
                                        Số điện thoại:
                                    </label>
                                    <input
                                        type="tel"
                                        className="form-control"
                                        id="phone"
                                        placeholder="Nhập số điện thoại"
                                        required
                                    />
                                </div>

                                <div className="mb-3">
                                    <label
                                        htmlFor="message"
                                        className="form-label fw-bold"
                                    >
                                        Tin nhắn:
                                    </label>
                                    <textarea
                                        className="form-control"
                                        id="message"
                                        rows="4"
                                        placeholder="Nhập tin nhắn"
                                        required
                                    ></textarea>
                                </div>

                                <Button
                                    type="primary"
                                    size="large"
                                    htmlType="submit"
                                    block
                                >
                                    Gửi tin nhắn
                                </Button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Contact;
