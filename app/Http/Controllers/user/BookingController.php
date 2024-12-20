<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu đơn giản
            $request->validate([
                'table_id' => 'required|exists:tables,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'booking_date' => 'required|date',
                'booking_time' => 'required',
                'number_of_guests' => 'required|integer|min:1',
                'comment' => 'nullable|string',
                'items' => 'required|array|min:1'
            ]);

            // Kiểm tra user đăng nhập
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để đặt bàn'
                ], 401);
            }

            // Kiểm tra trạng thái của các sản phẩm
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy sản phẩm'
                    ], 404);
                }

                // Kiểm tra trạng thái sản phẩm
                if (!$product->status) {
                    return response()->json([
                        'success' => false,
                        'message' => "Sản phẩm '{$product->name}' hiện không còn phục vụ"
                    ], 400);
                }
            }

            // Format lại ngày giờ
            $bookingDate = date('Y-m-d', strtotime($request->booking_date));
            $bookingTime = date('H:i:s', strtotime($request->booking_time));

            DB::beginTransaction();
            try {
                // Tạo booking với trạng thái mặc định
                $booking = Booking::create([
                    'user_id' => auth()->id(),
                    'table_id' => $request->table_id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'booking_date' => $bookingDate,
                    'booking_time' => $bookingTime,
                    'number_of_guests' => $request->number_of_guests,
                    'comment' => $request->comment,
                    'booking_status' => 'pending',    // Chờ xác nhận
                    'order_status' => 'unpaid'      // Chưa thanh toán
                ]);

                // Lưu order items chỉ với sản phẩm còn hoạt động
                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product && $product->status) {
                        OrderItem::create([
                            'booking_id' => $booking->id,
                            'user_id' => auth()->id(),
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price']
                        ]);
                    }
                }

                // Cập nhật trạng thái bàn
                Table::where('id', $request->table_id)
                    ->update(['status' => 'reserved']); // Đã đặt trước

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Đặt bàn thành công',
                    'booking_id' => $booking->id
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function current()
    {
        $user = Auth::user(); // Lấy người dùng hiện tại từ Auth

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$user) {
            return response()->json([
                'message' => 'Người dùng chưa đăng nhập.',
            ], 401);
        }

        $booking = Booking::where('user_id', $user->id)
            ->latest('id')
            ->first();

        if (!$booking) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin đặt bàn.',
            ], 404);
        }

        return response()->json($booking, 200);
    }

    public function history()
    {
        try {
            $bookings = Booking::where('user_id', auth()->id())
                ->with(['table', 'orderItems.product', 'payment'])
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedBookings = $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'name' => $booking->name,
                    'date_time' => [
                        'date' => $booking->booking_date,
                        'time' => $booking->booking_time,
                    ],
                    'table' => $booking->table->type . ' (Sức chứa: ' . $booking->table->capacity . ')',
                    'status' => [
                        'booking' => $booking->booking_status,
                        'order' => $booking->order_status
                    ],
                    'items' => $booking->orderItems->map(function ($item) {
                        return [
                            'name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total' => $item->quantity * $item->price
                        ];
                    }),
                    'payment' => $booking->payment ? [
                        'amount' => $booking->payment->amount,
                        'method' => $booking->payment->payment_method,
                        'status' => $booking->payment->status
                    ] : null,
                    'created_at' => $booking->created_at->format('d/m/Y H:i:s')
                ];
            });

            return response()->json([
                'success' => true,
                'bookings' => $formattedBookings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy lịch sử đặt bàn'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $booking = Booking::with(['table', 'orderItems.product'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

            $formattedBooking = [
                'id' => $booking->id,
                'table' => [
                    'id' => $booking->table->id,
                    'type' => $booking->table->type,
                    'capacity' => $booking->table->capacity
                ],
                'booking_details' => [
                    'name' => $booking->name,
                    'phone' => $booking->phone,
                    'booking_date' => $booking->booking_date,
                    'booking_time' => $booking->booking_time,
                    'number_of_guests' => $booking->number_of_guests,
                    'comment' => $booking->comment,
                    'booking_status' => $booking->booking_status,
                    'order_status' => $booking->order_status,
                    'created_at' => $booking->created_at->format('d/m/Y H:i:s'),
                ],
                'order_items' => $booking->orderItems->map(function ($item) {
                    return [
                        'product_name' => $item->product->name,
                        'img' => $item->product->img,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->quantity * $item->price
                    ];
                }),
                'total_amount' => $booking->orderItems->sum(function ($item) {
                    return $item->quantity * $item->price;
                })
            ];

            return response()->json([
                'success' => true,
                'booking' => $formattedBooking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy thông tin đặt bàn'
            ], 500);
        }
    }

    public function updateStatus($bookingId, $bookingStatus, $orderStatus)
    {
        try {
            $booking = Booking::findOrFail($bookingId);

            DB::beginTransaction();

            // Cập nhật trạng thái booking
            $booking->update([
                'booking_status' => $bookingStatus,
                'order_status' => $orderStatus
            ]);

            // Cập nhật trạng thái bàn nếu cần
            if ($bookingStatus === 'confirmed') {
                $booking->table->update(['status' => 'occupied']); // Đã được sử dụng
            } elseif ($bookingStatus === 'cancelled') {
                $booking->table->update(['status' => 'available']); // Trả lại trạng thái trống
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

    public function cancelBooking($id)
    {
        try {
            // Kiểm tra user đã đăng nhập
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để thực hiện thao tác này'
                ], 401);
            }

            // Tìm booking
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng'
                ], 404);
            }

            // Kiểm tra quyền
            if ($booking->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền hủy đơn hàng này'
                ], 403);
            }

            // Kiểm tra trạng thái
            if (!in_array($booking->booking_status, ['pending', 'confirmed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hàng ở trạng thái này'
                ], 400);
            }

            if ($booking->order_status !== 'unpaid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hàng đã thanh toán'
                ], 400);
            }

            DB::beginTransaction();

            // Cập nhật trạng thái
            $booking->update([
                'booking_status' => 'cancelled',
                'order_status' => 'cancelled'
            ]);

            // Cập nhật các thông tin liên quan
            $booking->orderItems()->update(['status' => 'cancelled']);
            $booking->table->update(['status' => 'available']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Hủy đơn hàng thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Cancel booking error: ' . $e->getMessage(), [
                'booking_id' => $id,
                'user_id' => auth()->id() ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng'
            ], 500);
        }
    }

    public function getBookingHistory()
    {
        try {
            $bookings = Booking::with(['table', 'orderItems.product', 'payment'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'name' => $booking->name,
                        'date_time' => [
                            'date' => $booking->booking_date,
                            'time' => $booking->booking_time
                        ],
                        'table' => $booking->table->type . ' (Bàn ' . $booking->table->id . ')',
                        'items' => $booking->orderItems->map(function ($item) {
                            return [
                                'name' => $item->product->name,
                                'quantity' => $item->quantity,
                                'price' => $item->price
                            ];
                        }),
                        'payment' => $booking->payment ? [
                            'amount' => $booking->payment->amount,
                            'method' => $booking->payment->payment_method
                        ] : null,
                        'status' => [
                            'booking' => $booking->booking_status,
                            'order' => $booking->order_status
                        ],
                        'created_at' => $booking->created_at->format('d/m/Y H:i')
                    ];
                });

            return response()->json([
                'success' => true,
                'bookings' => $bookings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy lịch sử đặt bàn'
            ], 500);
        }
    }
}
