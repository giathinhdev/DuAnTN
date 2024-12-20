
import { useState } from "react";

export const useShopping = () => {
    const [cart, setCart] = useState([]);

    const clearCart = (menuCode) => {
        // Xóa các sản phẩm trong giỏ hàng theo menuCode
        const updatedCart = cart.filter(item => item.menuCode !== menuCode);
        setCart(updatedCart);  // Cập nhật lại giỏ hàng
    };

    return { clearCart };
};
