<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return Inertia::render('Home', [
            "products" => $products
        ]);
    }

    // API endpoint cho search
    public function search(Request $request)
    {
        $search = $request->input('query');

        $products = Product::with('category')
            ->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->take(5)
            ->get();

        return response()->json($products);
    }

    // API endpoint cho sản phẩm bán chạy
    public function getBestSellers()
    {
        try {
            $bestSellers = DB::table('products')
                ->select(
                    'products.id',
                    'products.name',
                    'products.img',
                    'products.description',
                    'products.price',
                    'products.sale_price',
                    'products.status',
                    DB::raw('SUM(order_items.quantity) as total_sold')
                )
                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->join('bookings', 'order_items.booking_id', '=', 'bookings.id')
                ->where('bookings.order_status', '=', 'paid')
                ->where('products.status', '=', 1)
                ->groupBy('products.id', 'products.name', 'products.img', 'products.description', 'products.price', 'products.sale_price', 'products.status')
                ->orderBy('total_sold', 'desc')
                ->limit(4)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $bestSellers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi lấy sản phẩm bán chạy'
            ], 500);
        }
    }
}
