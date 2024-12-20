<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Table; // Đảm bảo bạn nhập đúng Model 'Table'

class TableController extends Controller
{
    public function table()
    {
        return view('users.table'); // Trả về view 'users.table'
    }

    public function tableDatban(Request $request)
    {
        
        $type = $request->input('type');
        $status = 'available';
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'phone' => 'required|digits_between:1,10', // Sử dụng 'digits_between' để giới hạn số chữ số
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'capacity' => 'required|integer|max:100',
            'type' => 'required|string|max:255',
            'comment' => 'nullable|string|max:555', // Cho phép trường comment trống
            'status' => 'active',
        ]);

        // Kiểm tra lỗi xác thực
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
     
        // Thêm bản ghi vào bảng 'tables' (nếu không có lỗi)
        Table::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'comment' => $request->comment,
        ]);

        return redirect()->route('users.table')->with('success', 'Bạn đã đặt bàn thành công');
    }

}
