<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Lấy danh sách sản phẩm
    public function index()
    {
        try {
            $products = Product::with('category')
                ->where('status', 1)
                ->latest()
                ->take(8)
                ->get();

            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Lấy chi tiết một sản phẩm
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    // Tạo mới sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'image' => 'nullable|string',
        ]);

        $product->update($request->all());
        return response()->json($product, 200);
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(null, 204);
    }

    public function getPromotionProducts()
    {
        try {
            $promotionProducts = Product::whereNotNull('sale_price')
                ->where('status', true)
                ->orderByRaw('(price - sale_price) DESC')  // Sắp xếp theo mức giảm giá từ cao xuống thấp
                ->take(4)  // Lấy 4 sản phẩm
                ->get()
                ->map(function ($product) {
                    $discountPercent = round((($product->price - $product->sale_price) / $product->price) * 100);
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'img' => $product->img,
                        'description' => $product->description,
                        'discount_percent' => $discountPercent,
                        'created_at' => $product->created_at
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $promotionProducts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách sản phẩm khuyến mãi'
            ], 500);
        }
    }
}
