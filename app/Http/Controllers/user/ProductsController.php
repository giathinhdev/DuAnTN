<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    // Phương thức hiển thị trang Menu
    public function showMenu()
    {
        // Logic xử lý menu, ví dụ lấy sản phẩm từ database
        // $menuItems = Product::all(); // Nếu bạn có bảng products

        // Trả về view với dữ liệu menu
        // return view('users.menus'); // Hoặc truyền thêm dữ liệu: ->with('menuItems', $menuItems);
        return Inertia::render('Menu');
        
    }
    // Phương thức hiển thị trang chitiet
    public function chitiet()
    {
        // Logic xử lý menu, ví dụ lấy sản phẩm từ database
        // $menuItems = Product::all(); // Nếu bạn có bảng products

        // Trả về view với dữ liệu menu
        // return view('users.chitiet'); // Hoặc truyền thêm dữ liệu: ->with('menuItems', $menuItems);
        return Inertia::render('Details');

    }
}
