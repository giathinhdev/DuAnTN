<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Các thuộc tính có thể gán hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role'
    ];
    /**
     * Các thuộc tính bị ẩn khi chuyển thành mảng hoặc JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Các thuộc tính cần thay đổi kiểu.
     *
     * @var array<string, string>   
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bookings()
{
    return $this->hasMany(Booking::class);
}

    public function isReserved()
    {
        // Kiểm tra xem có booking nào cho bàn này không
        return $this->bookings()->where('booking_status', 'reserved')->exists();
    }
}
