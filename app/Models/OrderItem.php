<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    protected $fillable = [
        'user_id',
        'booking_id',
        'product_id',
        'quantity',
        'price',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Mối quan hệ với bảng `products`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Mối quan hệ với bảng `bookings` (nếu cần, giả sử một đơn hàng có thể liên quan đến một đặt chỗ)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
