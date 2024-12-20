import React, { useState } from 'react';
import { Layout, Card, Row, Col, Avatar, Typography, Tabs, Button, Form, Input, Tag, message } from 'antd';
import { UserOutlined, LockOutlined, MailOutlined, PhoneOutlined } from '@ant-design/icons';
import { usePage } from '@inertiajs/react';
import axios from 'axios';

const { Content } = Layout;
const { Title, Text } = Typography;
const { TabPane } = Tabs;

const Profile = () => {
    const { auth } = usePage().props;
    const [loading, setLoading] = useState(false);
    const [form] = Form.useForm();

    // Xử lý cập nhật thông tin
    const handleUpdateProfile = async (values) => {
        setLoading(true);
        try {
            const response = await axios.put('/api/profile/update', values);
            if (response.data.success) {
                message.success('Cập nhật thông tin thành công!');
                window.location.reload();
            }
        } catch (error) {
            if (error.response?.data?.errors) {
                Object.values(error.response.data.errors).forEach(err => 
                    message.error(err[0])
                );
            } else {
                message.error('Có lỗi xảy ra khi cập nhật thông tin!');
            }
        } finally {
            setLoading(false);
        }
    };

    // Xử lý đổi mật khẩu
    const handleChangePassword = async (values) => {
        setLoading(true);
        try {
            const response = await axios.put('/api/profile/change-password', values);
            if (response.data.success) {
                message.success('Đổi mật khẩu thành công!');
                form.resetFields();
            }
        } catch (error) {
            if (error.response?.data?.message) {
                message.error(error.response.data.message);
            } else {
                message.error('Có lỗi xảy ra khi đổi mật khẩu!');
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <Layout>
            <Content style={{ padding: '24px', background: '#f0f2f5', minHeight: '100vh' }}>
                <Row gutter={[24, 24]}>
                    {/* Card thông tin cá nhân */}
                    <Col xs={24} md={8}>
                        <Card hoverable>
                            <div style={{ textAlign: 'center' }}>
                                <Avatar 
                                    size={120} 
                                    icon={<UserOutlined />}
                                    style={{ backgroundColor: '#1890ff' }}
                                />
                                <Title level={3} style={{ marginTop: 16, marginBottom: 4 }}>
                                    {auth.user.name}
                                </Title>
                                <Tag color={auth.user.role === 'admin' ? 'blue' : 'green'}>
                                    {auth.user.role?.toUpperCase() || 'USER'}
                                </Tag>
                                
                                <div style={{ marginTop: 20, textAlign: 'left' }}>
                                    <p>
                                        <MailOutlined /> Email: {auth.user.email}
                                    </p>
                                    <p>
                                        <PhoneOutlined /> SĐT: {auth.user.phone || 'Chưa cập nhật'}
                                    </p>
                                </div>
                            </div>
                        </Card>
                    </Col>

                    {/* Card cập nhật thông tin */}
                    <Col xs={24} md={16}>
                        <Card>
                            <Tabs defaultActiveKey="1">
                                {/* Tab cập nhật thông tin */}
                                <TabPane tab="Cập nhật thông tin" key="1">
                                    <Form
                                        layout="vertical"
                                        initialValues={{
                                            name: auth.user.name,
                                            phone: auth.user.phone,
                                        }}
                                        onFinish={handleUpdateProfile}
                                    >
                                        <Form.Item
                                            name="name"
                                            label="Họ và tên"
                                            rules={[
                                                { required: true, message: 'Vui lòng nhập họ tên!' }
                                            ]}
                                        >
                                            <Input prefix={<UserOutlined />} />
                                        </Form.Item>

                                        <Form.Item
                                            name="phone"
                                            label="Số điện thoại"
                                            rules={[
                                                { required: true, message: 'Vui lòng nhập số điện thoại!' },
                                                { pattern: /^[0-9]{10}$/, message: 'Số điện thoại không hợp lệ!' }
                                            ]}
                                        >
                                            <Input 
                                                prefix={<PhoneOutlined />}
                                                placeholder="Nhập số điện thoại của bạn"
                                            />
                                        </Form.Item>

                                        <Form.Item>
                                            <Button type="primary" htmlType="submit" loading={loading}>
                                                Cập nhật thông tin
                                            </Button>
                                        </Form.Item>
                                    </Form>
                                </TabPane>

                                {/* Tab đổi mật khẩu */}
                                <TabPane tab="Đổi mật khẩu" key="2">
                                    <Form
                                        form={form}
                                        layout="vertical"
                                        onFinish={handleChangePassword}
                                    >
                                        <Form.Item
                                            name="current_password"
                                            label="Mật khẩu hiện tại"
                                            rules={[
                                                { required: true, message: 'Vui lòng nhập mật khẩu hiện tại!' }
                                            ]}
                                        >
                                            <Input.Password prefix={<LockOutlined />} />
                                        </Form.Item>

                                        <Form.Item
                                            name="new_password"
                                            label="Mật khẩu mới"
                                            rules={[
                                                { required: true, message: 'Vui lòng nhập mật khẩu mới!' },
                                                { min: 8, message: 'Mật khẩu phải có ít nhất 8 ký tự!' }
                                            ]}
                                        >
                                            <Input.Password prefix={<LockOutlined />} />
                                        </Form.Item>

                                        <Form.Item
                                            name="confirm_password"
                                            label="Xác nhận mật khẩu mới"
                                            dependencies={['new_password']}
                                            rules={[
                                                { required: true, message: 'Vui lòng xác nhận mật khẩu mới!' },
                                                ({ getFieldValue }) => ({
                                                    validator(_, value) {
                                                        if (!value || getFieldValue('new_password') === value) {
                                                            return Promise.resolve();
                                                        }
                                                        return Promise.reject(new Error('Mật khẩu xác nhận không khớp!'));
                                                    },
                                                }),
                                            ]}
                                        >
                                            <Input.Password prefix={<LockOutlined />} />
                                        </Form.Item>

                                        <Form.Item>
                                            <Button type="primary" htmlType="submit" loading={loading}>
                                                Đổi mật khẩu
                                            </Button>
                                        </Form.Item>
                                    </Form>
                                </TabPane>
                            </Tabs>
                        </Card>
                    </Col>
                </Row>
            </Content>
        </Layout>
    );
};

export default Profile; 