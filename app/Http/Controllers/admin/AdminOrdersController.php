<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Table;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrdersController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index(Request $request)
    {
        // Lấy danh sách đơn đặt bàn kèm theo thông tin bàn và thanh toán
        $bookings = Booking::with(['table', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.order_list', compact('bookings'));
    }

    /**
     * Hiển thị form tạo đơn hàng mới
     */
    public function create(Request $request)
    {
        // Lấy thông tin booking từ request
        $currentBookingId = $request->query('booking_id');
        $booking = Booking::find($currentBookingId);

        // Lấy thông tin bàn
        $currentTableId = $request->query('table_id');
        $table = Table::find($currentTableId);

        // Lấy danh sách danh mục và sản phẩm
        $categories = Category::all();

        // Lọc sản phẩm theo danh mục nếu có
        if ($request->has('category_id')) {
            $products = Product::where('category_id', $request->category_id)->get();
        } else {
            $products = Product::all();
        }

        return view('admin.order_list', compact(
            'categories',
            'products',
            'table',
            'booking',
            'currentTableId',
            'currentBookingId'
        ));
    }

    /**
     * Lưu đơn hàng mới
     */
    public function store(Request $request, $bookingId)
    {
        // Tìm thông tin đặt bàn
        $booking = Booking::find($bookingId);
        if (!$booking) {
            return redirect()->back()->with('error', 'Không tìm thấy đặt chỗ.');
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Lấy thông tin sản phẩm và số lượng
        $product = Product::find($request->product_id);
        $quantity = $request->quantity;
        $price = $product->price;

        // Kiểm tra xem món đã có trong đơn hàng chưa
        $orderItem = $booking->orderItems()->where('product_id', $product->id)->first();

        if ($orderItem) {
            // Nếu món đã tồn tại, tăng số lượng
            $orderItem->quantity += $quantity;
            $orderItem->price = $price;
            $orderItem->save();
        } else {
            // Nếu món chưa tồn tại, tạo mới
            $booking->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return redirect()->route('table.details', ['id' => $booking->table_id])
            ->with('success', 'Món ăn đã được đặt thành công!');
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show($id)
    {
        try {
            // Lấy thông tin đơn hàng kèm theo các quan hệ
            $booking = Booking::with(['table', 'orderItems.product', 'payment'])
                ->findOrFail($id);

            // Tính tổng tiền đơn hàng
            $totalAmount = $booking->orderItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            return view('admin.order_details', compact('booking', 'totalAmount'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không tìm thấy thông tin đơn đặt bàn');
        }
    }

    /**
     * Cập nhật trạng thái món ăn trong đơn hàng
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = OrderItem::find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Cập nhật trạng thái (1: xác nhận, 2: hủy)
        $status = $request->input('status');
        if ($status == 1 || $status == 2) {
            $order->status = $status;
            $order->save();
            return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
        }

        return redirect()->back()->with('error', 'Trạng thái không hợp lệ.');
    }

    /**
     * Cập nhật trạng thái đặt bàn
     */
    public function updateBookingStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($id);
            $status = $request->status;

            // Validate status
            if (!in_array($status, [
                'pending',
                'confirmed', 
                'preparing',
                'completed',
                'cancelled'
            ])) {
                throw new \Exception('Trạng thái không hợp lệ');
            }

            // Cập nhật trạng thái booking
            $booking->update(['booking_status' => $status]);

            // Cập nhật trạng thái bàn tương ứng
            switch($status) {
                case 'confirmed':
                    $booking->table->update(['status' => 'occupied']);
                    $booking->update(['order_status' => 'confirmed']);
                    break;
                case 'preparing':
                    $booking->update(['order_status' => 'confirmed']);
                    break;
                case 'completed':
                    if ($booking->order_status !== 'paid') {
                        throw new \Exception('Đơn hàng chưa được thanh toán');
                    }
                    $booking->table->update(['status' => 'available']);
                    break;
                case 'cancelled':
                    $booking->table->update(['status' => 'available']);
                    $booking->update(['order_status' => 'cancelled']);
                    if($booking->payment) {
                        $booking->payment->update(['status' => 'cancelled']);
                    }
                    break;
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật trạng thái thanh toán tiền mặt
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::with('payment')->findOrFail($id);

            // Chỉ cho phép cập nhật khi đơn hàng đã được xác nhận và có payment
            if (!in_array($booking->booking_status, ['confirmed', 'preparing'])) {
                throw new \Exception('Trạng thái đơn hàng không hợp lệ để thanh toán');
            }

            if (!$booking->payment) {
                throw new \Exception('Không tìm thấy thông tin thanh toán');
            }

            // Cập nhật trạng thái payment
            $booking->payment->update(['status' => 'completed']);
            
            // Sau khi admin xác nhận thanh toán, mới cập nhật order_status thành paid
            $booking->update(['order_status' => 'paid']);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Xác nhận thanh toán thành công'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xác nhận thanh toán: ' . $e->getMessage()
            ], 500);
        }
    }
}
