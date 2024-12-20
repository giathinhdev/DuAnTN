<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\OrderItem;
use App\Models\Product;  // Sử dụng model Product nếu có
use App\Models\Category;  // Sử dụng model Product nếu có
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderItemController extends Controller
{
    // Hiển thị form đặt món cho booking
    public function create($bookingId)
    {
        // Lấy thông tin đơn đặt bàn
        $booking = Booking::findOrFail($bookingId);

        // Lấy tất cả danh mục và sản phẩm trong danh mục đó
        $categories = Category::with('products')->get();

        return view('users.order_create', compact('booking', 'categories'));
    }

    public function store(Request $request, $bookingId)
    {
        $user = Auth::user();

        $booking = Booking::findOrFail($bookingId);

        // Lưu các món ăn vào bảng order_items
        foreach ($request->dishes as $productId => $quantity) {
            // Kiểm tra nếu số lượng lớn hơn 0 thì mới thêm vào
            if ($quantity > 0) {
                // Lấy giá món (product)
                $product = Product::findOrFail($productId);
                // Tạo một order item mới
                OrderItem::create([
                    'user_id' => $user->id,
                    'booking_id' => $bookingId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,  // Lấy giá sản phẩm
                ]);
            }
        }

        // Chuyển hướng đến trang thanh toán, truyền thông tin bookingId
        return redirect()->route('payment.page', ['bookingId' => $bookingId])->with('success', 'Đặt món thành công!');
    }
}
