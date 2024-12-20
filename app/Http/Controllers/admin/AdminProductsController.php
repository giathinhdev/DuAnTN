<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProductsController extends Controller
{
    public function products(Request $request)
    {
        $products = Product::with(['category', 'user'])->latest()->paginate(10);
        return view('admin.product_list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product_add', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Basic validation
            if (!$request->name || !$request->category_id || !$request->price || !$request->hasFile('img')) {
                return redirect()
                    ->back()
                    ->with('error', 'Vui lòng điền đầy đủ thông tin bắt buộc')
                    ->withInput();
            }

            $product = new Product();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->price = preg_replace('/[^0-9]/', '', $request->price);
            $product->sale_price = $request->sale_price ? preg_replace('/[^0-9]/', '', $request->sale_price) : null;
            $product->description = $request->description;
            $product->user_id = auth()->id();
            $product->status = $request->boolean('status', true);

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $filename);
                $product->img = $filename;
            }

            $product->save();
            DB::commit();

            return redirect()
                ->route('admin.productlist')
                ->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product_edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->price = preg_replace('/[^0-9]/', '', $request->price);
            $product->sale_price = $request->sale_price ? preg_replace('/[^0-9]/', '', $request->sale_price) : null;
            $product->description = $request->description;
            $product->status = $request->boolean('status', true);

            if ($request->hasFile('img')) {
                // Xóa ảnh cũ
                if ($product->img) {
                    $oldImagePath = public_path('img/' . $product->img);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload ảnh mới
                $file = $request->file('img');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $filename);
                $product->img = $filename;
            }

            $product->save();
            DB::commit();

            return redirect()
                ->route('admin.productlist')
                ->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function toggleStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->status = !$product->status;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }
}
