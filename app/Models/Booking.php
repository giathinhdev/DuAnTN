<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';      // Chờ xác nhận
    const STATUS_CONFIRMED = 'confirmed';  // Đã xác nhận
    const STATUS_PREPARING = 'preparing';  // Đang chuẩn bị món
    const STATUS_COMPLETED = 'completed';  // Hoàn thành
    const STATUS_CANCELLED = 'cancelled';  // Đã hủy

    protected $fillable = [
        'user_id',
        'table_id',
        'name',
        'phone',
        'message',
        'booking_date',
        'booking_time',
        'number_of_guests',
        'payment_method',
        'payment_date',
        'booking_status',
        'order_status',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->booking_status) {
            self::STATUS_PENDING => 'Chờ xác nhận',
            self::STATUS_CONFIRMED => 'Đã xác nhận',
            self::STATUS_PREPARING => 'Đang chuẩn bị món',
            self::STATUS_COMPLETED => 'Hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy',
            default => 'Không xác định'
        };
    }
}

