import React, { useState } from "react";
import { Form, Input, Button, notification } from "antd";
import { FaUser, FaEnvelope, FaLock } from "react-icons/fa";
import axios from "axios";
import { Link } from "@inertiajs/react";
const Register = () => {
  const [loading, setLoading] = useState(false);

  const onFinish = async (formData) => {
    setLoading(true);
    try {
      const response = await axios.post("/api/register", formData);
      if (response.data.success) {
        notification.success({
          message: "Registration Successful",
          description: response.data.message,
        });
        setTimeout(() => {
          window.location.href = "/login";
        }, 3000);
      } else {
        notification.error({
          message: "Registration Failed",
          description: response.data.message,
        });
      }
    } catch (error) {
      if (error.response && error.response.data.errors) {
        const errorMessages = Object.values(error.response.data.errors)
          .flat()
          .join("\n");
        notification.error({
          message: "Registration Failed",
          description: errorMessages,
        });
      } else {
        notification.error({
          message: "An unexpected error occurred",
          description: "Please try again.",
        });
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div
      style={{
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        height: "100vh",
        backgroundColor: "#f1f2f6",
      }}
    >
      <div
        style={{
          width: 350,
          background: "#fff",
          padding: 30,
          borderRadius: 10,
          boxShadow: "0px 4px 20px rgba(0, 0, 0, 0.1)",
        }}
      >
        <h3
          style={{
            fontWeight: 600,
            color: "#343a40",
            marginBottom: 20,
            textAlign: "center",
            textTransform: "uppercase",
          }}
        >
          Register
        </h3>
        <Form
          name="register"
          layout="vertical"
          onFinish={onFinish}
          autoComplete="off"
        >
          {/* Name Field */}
          <Form.Item
            name="name"
            label="Name"
            rules={[{ required: true, message: "Please enter your name!" }]}
          >
            <Input
              prefix={<FaUser />}
              placeholder="Enter your name"
              allowClear
            />
          </Form.Item>

          {/* Email Field */}
          <Form.Item
            name="email"
            label="Email"
            rules={[
              { required: true, message: "Please enter your email!" },
              { type: "email", message: "Please enter a valid email address!" },
            ]}
          >
            <Input
              prefix={<FaEnvelope />}
              placeholder="Enter your email"
              allowClear
            />
          </Form.Item>

          {/* Password Field */}
          <Form.Item
            name="password"
            label="Password"
            rules={[
              { required: true, message: "Please enter your password!" },
              { min: 6, message: "Password must be at least 6 characters long!" },
            ]}
          >
            <Input.Password
              prefix={<FaLock />}
              placeholder="Enter your password"
              allowClear
            />
          </Form.Item>

          {/* Password Confirmation Field */}
          <Form.Item
            name="password_confirmation"
            label="Confirm Password"
            dependencies={["password"]}
            rules={[
              { required: true, message: "Please confirm your password!" },
              ({ getFieldValue }) => ({
                validator(_, value) {
                  if (!value || getFieldValue("password") === value) {
                    return Promise.resolve();
                  }
                  return Promise.reject(
                    new Error("Passwords do not match!")
                  );
                },
              }),
            ]}
          >
            <Input.Password
              prefix={<FaLock />}
              placeholder="Confirm your password"
              allowClear
            />
          </Form.Item>

          {/* Submit Button */}
          <Form.Item>
            <Button
              type="primary"
              htmlType="submit"
              block
              loading={loading}
            >
              {loading ? "Registering..." : "Register"}
            </Button>
          </Form.Item>

          <p className="text-center">
            Already have an account? <Link href="/login">Register here</Link>
          </p>
        </Form>
      </div>
    </div>
  );
};

export default Register;
