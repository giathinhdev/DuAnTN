<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Thông tin demo cho test
    private $validCards = [
        '4532715384629174' => [
            'expiry' => '12/25',
            'cvv' => '123'
        ]
    ];

    private $validWallets = [
        // Tài khoản thành công
        'success' => [
            'momo' => [
                'phone' => '0987654321',
                'name' => 'NGUYEN VAN A',
                'balance' => 10000000 // 10 triệu
            ],
            'zalopay' => [
                'phone' => '0123456789',
                'name' => 'TRAN THI B',
                'balance' => 5000000 // 5 triệu
            ],
            'vnpay' => [
                'account' => '9876543210',
                'name' => 'LE VAN C',
                'bank' => 'NCB',
                'balance' => 20000000 // 20 triệu
            ]
        ],
        // Tài khoản không đủ tiền
        'insufficient' => [
            'momo' => [
                'phone' => '0987654322',
                'name' => 'PHAM THI D',
                'balance' => 10000 // 10 nghìn
            ],
            'zalopay' => [
                'phone' => '0123456788',
                'name' => 'HOANG VAN E',
                'balance' => 20000 // 20 nghìn
            ],
            'vnpay' => [
                'account' => '9876543211',
                'name' => 'TRAN VAN F',
                'bank' => 'NCB',
                'balance' => 5000 // 5 nghìn
            ]
        ],
        // Tài khoản lỗi
        'error' => [
            'momo' => [
                'phone' => '0987654323',
                'name' => 'ERROR ACCOUNT',
                'balance' => 0,
                'status' => 'locked'
            ],
            'zalopay' => [
                'phone' => '0123456787',
                'name' => 'ERROR ACCOUNT',
                'balance' => 0,
                'status' => 'locked'
            ],
            'vnpay' => [
                'account' => '9876543212',
                'name' => 'ERROR ACCOUNT',
                'bank' => 'NCB',
                'balance' => 0,
                'status' => 'locked'
            ]
        ]
    ];

    public function getBookingDetails($bookingId)
    {
        try {
            $booking = Booking::with(['table', 'orderItems.product'])
                ->findOrFail($bookingId);

            $orderItems = $booking->orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->quantity * $item->price
                ];
            });

            $totalAmount = $orderItems->sum('total');

            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'table_number' => $booking->table->type,
                    'booking_date' => $booking->booking_date,
                    'booking_time' => $booking->booking_time,
                    'number_of_guests' => $booking->number_of_guests,
                    'name' => $booking->name,
                    'phone' => $booking->phone,
                    'booking_status' => $booking->booking_status,
                ],
                'orderItems' => $orderItems,
                'totalAmount' => $totalAmount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy thông tin đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    public function processPayment(Request $request, $bookingId)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($bookingId);
            
            // Kiểm tra trạng thái booking
            if (!in_array($booking->booking_status, ['pending', 'confirmed'])) {
                throw new \Exception('Trạng thái đơn hàng không hợp lệ để thanh toán');
            }

            // Chỉ cập nhật order_status thành unpaid (chờ xác nhận)
            $booking->update([
                'order_status' => 'unpaid'  // Sử dụng giá trị enum hợp lệ
            ]);
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Thanh toán đang chờ xác nhận',
                'data' => [
                    'booking_id' => $booking->id
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method để admin xác nhận thanh toán
    public function updateCashPayment($bookingId)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($bookingId);

            // Cập nhật trạng thái thanh toán
            $booking->update([
                'order_status' => 'paid'
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật thanh toán thành công'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi cập nhật thanh toán: ' . $e->getMessage()
            ], 500);
        }
    }
}
