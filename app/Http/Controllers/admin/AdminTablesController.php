<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Table;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminTablesController extends Controller
{
    // Hiển thị danh sách bàn
    public function index()
    {
        $tables = Table::all();
        return view('admin.table_list', compact('tables'));
    }

    // Hiển thị form thêm bàn mới
    public function create()
    {
        return view('admin.table_add');
    }

    // Lưu thông tin bàn mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'status' => 'required|string',
        ]);

        Table::create($request->all());
        return redirect()->route('admin.tables.index')->with('success', 'Bàn mới đã được thêm.');
    }

    public function showDetails($id)
    {
        $table = Table::with('bookings.orderItems.product', 'bookings.user')->findOrFail($id);
        $products = Product::all();
        return view('admin.table_show', compact('table', 'products'));
    }


    // Hiển thị form chỉnh sửa thông tin bàn
    public function edit($id)
    {
        $table = Table::findOrFail($id);
        return view('admin.table_edit', compact('table'));
    }

    // Cập nhật thông tin bàn
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'status' => 'required|in:' . implode(',', [
                Table::STATUS_AVAILABLE,
                Table::STATUS_RESERVED,
                Table::STATUS_CLEANING,
            ]),
        ]);

        try {
            $table = Table::findOrFail($id);
            $table->update($request->only(['type', 'capacity', 'status']));

            return redirect()
                ->route('admin.tables.index')
                ->with('success', 'Thông tin bàn đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin bàn: ' . $e->getMessage())
                ->withInput();
        }
    }


    // Xóa bàn
    public function destroy($id)
    {
        // Kiểm tra quyền super_admin
        if (auth()->user()->role !== 'super_admin') {
            return redirect()->route('admin.tables.index')->with('error', 'Chỉ Super Admin mới có quyền xóa bàn.');
        }

        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Bàn đã được xóa.');
    }
}
