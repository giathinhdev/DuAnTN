<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'img',
        'description',
        'sale_price',
        'price',
        'status'
    ];

    protected $casts = [
        'status' => 'integer',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    // Format giá khi lấy ra
    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }

    public function getSalePriceFormattedAttribute()
    {
        return $this->sale_price ? number_format($this->sale_price, 0, ',', '.') . ' VNĐ' : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? 'Hiện' : 'Ẩn';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status 
            ? '<span class="badge bg-success">Hiện</span>'
            : '<span class="badge bg-danger">Ẩn</span>';
    }

    public function isAvailable()
    {
        return $this->status === 1;
    }
}
