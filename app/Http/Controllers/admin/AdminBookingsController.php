<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingsController extends Controller
{
    // Hiển thị danh sách đơn đặt bàn
    public function showBookings()
    {
        $bookings = Booking::with(['user', 'table', 'orderItems.product'])->get(); // Load related data
    
        return view('bookings.index', compact('bookings'));
    }
    
}

