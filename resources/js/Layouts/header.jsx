import React, { useState } from "react";
import {
    Layout,
    Button,
    Row,
    Col,
    Menu,
    Space,
    Avatar,
    Dropdown,
    Input,
    AutoComplete,
} from "antd";
import {
    HomeOutlined,
    AppstoreOutlined,
    BookOutlined,
    PhoneOutlined,
    LoginOutlined,
    UserOutlined,
    LogoutOutlined,
    ShoppingCartOutlined,
    SearchOutlined,
} from "@ant-design/icons";
import { Link, usePage } from "@inertiajs/react";

const { Header } = Layout;

const CustomHeader = () => {
    const { props } = usePage();
    const isGuest = !props.auth.user;
    const [searchOptions, setSearchOptions] = useState([]);
    const [loading, setLoading] = useState(false);

    const menuItems = [
        {
            key: "home",
            icon: <HomeOutlined style={{ color: "#333" }} />,
            label: (
                <Link href={route("home")} style={{ color: "#333" }}>
                    Trang chủ
                </Link>
            ),
        },
        {
            key: "menu",
            icon: <AppstoreOutlined style={{ color: "#333" }} />,
            label: (
                <Link href={route("menu")} style={{ color: "#333" }}>
                    Thực đơn
                </Link>
            ),
        },
        {
            key: "booktable",
            icon: <BookOutlined style={{ color: "#333" }} />,
            label: (
                <Link href={route("booktable")} style={{ color: "#333" }}>
                    Đặt bàn
                </Link>
            ),
        },
        {
            key: "contact",
            icon: <PhoneOutlined style={{ color: "#333" }} />,
            label: (
                <Link href={route("contact")} style={{ color: "#333" }}>
                    Liên hệ
                </Link>
            ),
        },
    ];

    const userMenuItems = [
        {
            key: "profile",
            icon: <UserOutlined />,
            label: <Link href={route("profile")}>Thông tin cá nhân</Link>
        },
        {
            key: "orders",
            label: <Link href={route("orders.history")}>Lịch sử đơn hàng</Link>,
            icon: <AppstoreOutlined style={{ color: "#2196F3" }} />,
        },
        {
            type: "divider",
        },
        {
            key: "logout",
            label: <Link href={route("logout")}>Đăng xuất</Link>,
            icon: <LogoutOutlined style={{ color: "#F44336" }} />,
            danger: true,
        },
    ];

    const handleSearch = async (value) => {
        if (!value) {
            setSearchOptions([]);
            return;
        }

        setLoading(true);
        try {
            const response = await fetch(`/api/search?query=${value}`);
            const data = await response.json();

            const options = data.map((item) => ({
                value: item.id,
                label: (
                    <div
                        style={{
                            display: "flex",
                            alignItems: "center",
                            padding: "5px",
                        }}
                    >
                        <img
                            src={`/img/${item.img}`}
                            alt={item.name}
                            style={{
                                width: "40px",
                                height: "40px",
                                objectFit: "cover",
                                marginRight: "10px",
                                borderRadius: "4px",
                            }}
                        />
                        <div>
                            <div style={{ color: "#1a1a1a" }}>{item.name}</div>
                            <div style={{ fontSize: "12px", color: "#666" }}>
                                {new Intl.NumberFormat("vi-VN", {
                                    style: "currency",
                                    currency: "VND",
                                }).format(item.price)}
                            </div>
                        </div>
                    </div>
                ),
            }));

            setSearchOptions(options);
        } catch (error) {
            console.error("Search error:", error);
        } finally {
            setLoading(false);
        }
    };

    const onSelect = (value) => {
        window.location.href = `/details/${value}`;
    };

    return (
        <Header
            style={{
                background: "#e8e8e8",
                boxShadow: "0 2px 15px rgba(0,0,0,0.1)",
                padding: "0 20px",
                position: "sticky",
                top: 0,
                zIndex: 1000,
                borderBottom: "1px solid #d9d9d9",
            }}
        >
            <Row align="middle" justify="space-between">
                <Col>
                    <Space size={24}>
                        <div
                            className="logo"
                            style={{ fontSize: "24px", fontWeight: "bold" }}
                        >
                            <Link
                                href={route("home")}
                                style={{ color: "#595959" }}
                            >
                                Gr8.
                            </Link>
                        </div>
                        <Menu
                            mode="horizontal"
                            items={menuItems}
                            style={{
                                border: "none",
                                background: "transparent",
                                color: "#595959",
                            }}
                            theme="light"
                        />
                    </Space>
                </Col>

                <Col
                    flex="auto"
                    style={{ maxWidth: "400px", margin: "0 20px" }}
                >
                    <AutoComplete
                        dropdownMatchSelectWidth={400}
                        style={{ width: "100%" }}
                        options={searchOptions}
                        onSelect={onSelect}
                        onSearch={handleSearch}
                    >
                        <Input.Search
                            size="middle"
                            placeholder="Tìm kiếm món ăn..."
                            loading={loading}
                            enterButton={
                                <SearchOutlined style={{ color: "#595959" }} />
                            }
                        />
                    </AutoComplete>
                </Col>

                <Col>
                    <Space size={16} align="center">
                        <Button
                            type="text"
                            icon={
                                <BookOutlined
                                    style={{
                                        fontSize: "20px",
                                        color: "#595959",
                                    }}
                                />
                            }
                            href={route("booktable")}
                        />

                        {isGuest ? (
                            <Space>
                                <Button
                                    type="primary"
                                    style={{
                                        backgroundColor: "#595959",
                                        borderColor: "#595959",
                                    }}
                                    icon={
                                        <LoginOutlined
                                            style={{ color: "#fff" }}
                                        />
                                    }
                                    href={route("admin.login")}
                                >
                                    Đăng nhập
                                </Button>
                            </Space>
                        ) : (
                            <Dropdown
                                overlayStyle={{
                                    backgroundColor: "#fff",
                                    color: "#595959",
                                }}
                                menu={{ items: userMenuItems }}
                                placement="bottomRight"
                            >
                                <Space className="cursor-pointer">
                                    <Avatar
                                        icon={
                                            <UserOutlined
                                                style={{ color: "#595959" }}
                                            />
                                        }
                                    />
                                    <span style={{ color: "#595959" }}>
                                        {props.auth.user.name}
                                    </span>
                                </Space>
                            </Dropdown>
                        )}
                    </Space>
                </Col>
            </Row>
        </Header>
    );
};

export default CustomHeader;
