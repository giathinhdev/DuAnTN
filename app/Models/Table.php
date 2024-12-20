<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    const STATUS_AVAILABLE = 'available';
    const STATUS_RESERVED = 'reserved';
    const STATUS_CLEANING = 'cleaning';

    protected $fillable = ['type', 'capacity', 'status'];

    /**
     * Quan hệ với model Booking
     * Một bàn có thể có nhiều booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    /**
     * Quan hệ với model OrderItem (nếu cần)
     * Một bàn có thể có nhiều order items
     */
    public function isReserved()
    {
        return $this->status === self::STATUS_RESERVED;
    }

    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isCleaning()
    {
        return $this->status === self::STATUS_CLEANING;
    }
}
