<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
    
        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%"); // Tìm kiếm theo tên hoặc email
        })->paginate(10); // Phân trang với 10 người dùng mỗi trang
    
        return view('admin.user_list', compact('users', 'search')); // Trả về view danh sách người dùng cùng với từ khóa tìm kiếm
    }  

    // Hiển thị form thêm người dùng
    public function create()
    {
        // Chỉ super_admin mới có thể tạo tài khoản super_admin khác
        $roles = auth()->user()->role === 'super_admin' 
            ? ['user', 'admin', 'super_admin']
            : ['user', 'admin'];

        return view('admin.user_add', compact('roles'));
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'role' => 'required|string|in:user,admin,super_admin',
        ]);

        // Kiểm tra quyền tạo super_admin
        if ($request->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Bạn không có quyền tạo tài khoản Super Admin');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thêm Người Dùng Thành Công.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        return view('admin.user_edit', compact('user')); // Trả về view chỉnh sửa người dùng
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'role' => 'nullable|string|in:user,admin',
        ]);

        // Cập nhật thông tin người dùng
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Cập nhật mật khẩu nếu có
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->phone = $request->phone;
        $user->role = $request->role ?? $user->role; // Giữ nguyên nếu không có thay đổi
        $user->save(); // Lưu thay đổi

        return redirect()->route('admin.users.index')->with('success', 'Cập Nhập Thành Công.'); // Quay lại danh sách với thông báo thành công
    }

    // Xóa người dùng
    public function destroy($id)
    {
        // Chỉ super_admin mới có quyền xóa
        if (auth()->user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa người dùng');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa Thành Công.');
    }
}



