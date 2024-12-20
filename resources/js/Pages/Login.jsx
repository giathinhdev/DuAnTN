import React, { useState, useEffect } from "react";
import { Layout, Button, Input, Form, notification } from "antd";
import { MailOutlined, LockOutlined } from "@ant-design/icons";
import { usePostApi } from "../Hook/useApi";
import { Link, usePage } from "@inertiajs/react";
import { Inertia } from "@inertiajs/inertia";

const { Header, Content, Footer } = Layout;

const Login = () => {
  const [loading, setLoading] = useState(false);
  const { data, error, postData } = usePostApi("/api/login");
  const { props } = usePage();
  const auth = props.auth.user;

  useEffect(() => {
    if (auth) {
      Inertia.visit(route('home'));
    }
  }, [auth]);

  const onFinish = async (values) => {
    setLoading(true);
    await postData(values);
    setLoading(false);
  };
  useEffect(() => {
    if (data) {
      if (data.status === "success") {
        notification.success({
          message: "Login Success",
          description: data.message,
        });
        
        // Kiểm tra và xử lý redirect
        const redirectUrl = sessionStorage.getItem('redirectAfterLogin');
        if (redirectUrl) {
          sessionStorage.removeItem('redirectAfterLogin');
          setTimeout(() => {
            window.location.href = redirectUrl;
          }, 1000);
        } else {
          setTimeout(() => {
            Inertia.visit(route('home'));
          }, 1000);
        }
      } else {
        notification.error({
          message: "Login Failed",
          description: data.message,
        });
      }
    }
  }, [data]);

  useEffect(() => {
    if (error) {
      notification.error({
        message: "An error occurred",
        description: error.message || "Please try again later.",
      });
    }
  }, [error]);

  const handleLoginSuccess = () => {
    const redirectUrl = sessionStorage.getItem('redirectAfterLogin');
    if (redirectUrl) {
        sessionStorage.removeItem('redirectAfterLogin');
        window.location.href = redirectUrl;
    } else {
        window.location.href = '/'; // Hoặc trang mặc định khác
    }
  };

  return (
    <Layout style={{ minHeight: "100vh" }}>
      <Header style={{ backgroundColor: "#001529", padding: "10px 20px" }}>
        <h1 style={{ color: "#fff", textAlign: "center", margin: 0 }}>
          Đăng nhập
        </h1>
      </Header>
      <Content
        style={{
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          backgroundColor: "#f1f2f6",
          padding: "50px 15px",
        }}
      >
        <div
          className="login-container"
          style={{
            width: 400,
            backgroundColor: "#fff",
            padding: 30,
            borderRadius: 10,
            boxShadow: "0px 0px 15px rgba(0, 0, 0, 0.2)",
          }}
        >
          <h3
            style={{
              textAlign: "center",
              fontWeight: 600,
              color: "#343a40",
              marginBottom: 20,
            }}
          >
            Đăng nhập
          </h3>
          <Form onFinish={onFinish} layout="vertical">
            <Form.Item
              label="Email"
              name="email"
              rules={[
                { required: true, message: "Vui lòng nhập email của bạn!", type: "email" },
              ]}
            >
              <Input
                prefix={<MailOutlined />}
                placeholder="Nhập email của bạn"
              />
            </Form.Item>

            <Form.Item
              label="Mật khẩu"
              name="password"
              rules={[{ required: true, message: "Vui lòng nhập mật khẩu của bạn!" }]}
            >
              <Input.Password
                prefix={<LockOutlined />}
                placeholder="Nhập mật khẩu của bạn"
              />
            </Form.Item>

            <Button
              type="primary"
              htmlType="submit"
              block
              loading={loading}
              style={{ marginTop: 10 }}
            >
              Đăng nhập
            </Button>
            <p className="text-center" style={{ marginTop: 10 }}>
              Chưa có tài khoản? <Link href="/register">Đăng ký tại đây</Link>
            </p>
          </Form>
        </div>
      </Content>
      <Footer style={{ textAlign: "center" }}>
        Dev NguyenAnhQuoc
      </Footer>
    </Layout>
  );
};
export default Login;
