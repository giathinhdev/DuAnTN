import React, { createContext, useContext, useState, useEffect } from "react";

const ShoppingContext = createContext();

export const ShoppingProvider = ({ children }) => {
    const [cart, setCart] = useState(JSON.parse(sessionStorage.getItem("cart")) || []);
    const [OrderItems, setOrderItems] = useState(JSON.parse(sessionStorage.getItem("OrderItems")) || []);
    const [Booking, setBooking] = useState(JSON.parse(sessionStorage.getItem("Booking")) || []);
    useEffect(() => {
        sessionStorage.setItem("cart", JSON.stringify(cart));
    }, [cart]);
    useEffect(() => {
        sessionStorage.setItem("OrderItems", JSON.stringify(OrderItems));
    }, [OrderItems]);

    useEffect(() => {
        sessionStorage.setItem("Booking", JSON.stringify(Booking));
    }, [Booking]);

    const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);

    const addToCart = (product) => {
        setCart((prevCart) => {
            const existingProductIndex = prevCart.findIndex(item => item.id === product.id);
            if (existingProductIndex !== -1) {
                const updatedCart = [...prevCart];
                updatedCart[existingProductIndex].quantity += product.quantity;
                return updatedCart;
            } else {
                return [...prevCart, { ...product, quantity: product.quantity }];
            }
        });
    };
    const updateCartQuantity = (productId, quantity) => {
        setCart((prevCart) =>
            prevCart.map(item =>
                item.id === productId
                    ? { ...item, quantity: Math.max(quantity, 1) }
                    : item
            )
        );
    };
    const removeFromCart = (productId) => {
        setCart((prevCart) => prevCart.filter(item => item.id !== productId));
    };
    const clearCart = (menuCode) => {
        setCart((prevCart) => prevCart.filter(item => item.menuCode !== menuCode));  // Xóa các sản phẩm theo menuCode
    };


    const addOrderItem = (product) => {
        setOrderItems((prevOrderItems) => {
            const updatedOrderItems = prevOrderItems.map(item =>
                item.id === product.id ? { ...product } : item
            );

            if (!updatedOrderItems.some(item => item.id === product.id)) {
                updatedOrderItems.push(product);
            }
            return updatedOrderItems;
        });
    };

    const addBooking = (bookingData) => {
        setBooking(bookingData);
        console.log("booking add vào", bookingData);
    };


    return (
        <ShoppingContext.Provider value={{
            cart,
            totalQuantity,
            addToCart,
            removeFromCart,
            updateCartQuantity,
            addOrderItem,
            OrderItems,
            Booking,
            addBooking,
            clearCart,
        }}>
            {children}
        </ShoppingContext.Provider>
    );
};

export const useShopping = () => {
    return useContext(ShoppingContext);
};
