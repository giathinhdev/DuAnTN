<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orders()
    {
        $order = OrderItem::all();
        return view('admin.order_details', compact('order'));
    }
}
