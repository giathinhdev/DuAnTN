<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    public function showRegisterForm()
    {

         return view('admin.register');
      
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lưu mật khẩu đã được mã hóa
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        return redirect()->route('admin.login')->with('success', 'Registration successful. Please login.');
        
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Kiểm tra role của user
            if ($user->role === 'user') {
                return redirect()->route('home');
            } elseif (in_array($user->role, ['admin', 'super_admin'])) {
                // Cho phép cả admin và super_admin truy cập vào trang admin
                return redirect()->route('admin.home');
            }
        }

        return redirect()->back()->with('error', 'Email hoặc mật khẩu không chính xác');
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng
        return redirect()->route('home'); // Chuyển hướng về trang đăng nhập
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật thông tin'
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu mới',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mật khẩu hiện tại không chính xác'
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Đổi mật khẩu thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đổi mật khẩu'
            ], 500);
        }
    }

    public function showProfile()
    {
        try {
            $user = Auth::user();
            return Inertia::render('Profile', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải thông tin người dùng');
        }
    }
}
