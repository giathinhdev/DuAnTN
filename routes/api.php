<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\User\{
    BookingController,
    OrderItemController,
    PaymentController,
    UserController,
    HomeController
};

// Models
use App\Models\{User, Product, Category, OrderItem, Table};
use Illuminate\Support\Facades\{Auth, Validator};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::post('/register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Đăng ký thành công',
        'user' => $user,
    ]);
});

Route::post('/login', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password.',
            'errors' => $validator->errors()
        ], 422);
    }

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
    ], $request->remember)) {
        $request->session()->regenerate();
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Invalid credentials.',
    ], 401);
})->name('login');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Bookings
    Route::prefix('booking')->group(function () {
        Route::post('/store', [BookingController::class, 'store']);
        Route::get('/history', [BookingController::class, 'history']);
        Route::get('/current', [BookingController::class, 'current']);
        Route::get('/{id}', [BookingController::class, 'show']);
        Route::put('/{id}/cancel', [BookingController::class, 'cancelBooking']);
    });

    // User Profile
    Route::prefix('profile')->group(function () {
        Route::put('/update', [UserController::class, 'updateProfile']);
        Route::put('/change-password', [UserController::class, 'changePassword']);
    });
});

// Public Routes
// Products
Route::apiResource('products', ProductController::class);
Route::get('products/category/{category_id}', [ProductController::class, 'showByCategory']);

// Menu & Categories
Route::get('/menu', function () {
    $categories = Category::with('products')->get();
    return response()->json($categories);
});

Route::get('/categories', function () {
    return response()->json(Category::all());
});

Route::get('/categories/with-products', function () {
    return response()->json(Category::with('products')->get());
});

// Tables
Route::get('/tables', function () {
    return response()->json(Table::where('status', 'available')->get());
});

Route::get('/tables/available', function () {
    return response()->json(Table::where('status', 'available')->get());
});

// Payment Routes
Route::prefix('payment')->group(function () {
    Route::get('/{bookingId}', [PaymentController::class, 'getBookingDetails'])
        ->name('api.payment.details');
    Route::post('/{bookingId}/confirm', [PaymentController::class, 'processPayment'])
        ->name('api.payment.confirm');
});

// Best Sellers
Route::get('/best-sellers', [HomeController::class, 'getBestSellers']);

Route::get('/check-auth', function () {
    return response()->json([
        'authenticated' => auth()->check()
    ]);
});

// Thêm route cho sản phẩm khuyến mãi
Route::get('/promotion-products', [ProductController::class, 'getPromotionProducts']);
