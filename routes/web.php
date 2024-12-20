<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\User\{
    HomeController,
    UserController,
    CartController,
    BookingController,
    ContactController,
    PaymentController,
    ProductsController,
    OrderItemController,
    TableController,
    BlogController
};

use App\Http\Controllers\Admin\{
    AdminController,
    AdminUsersController,
    AdminOrdersController,
    AdminTablesController,
    AdminBookingsController,
    AdminProductsController,
    AdminCategoriesController
};

// Models
use App\Models\{Product, Category, Booking, OrderItem};
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/register', function () {
    return Inertia::render('Register');
})->name('admin.register');

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('admin.login');

Route::post('register', [UserController::class, 'register'])->name('admin.register.submit');
Route::post('/login', [UserController::class, 'login'])->name('admin.login.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/menu', function () {
    return Inertia::render('Menu');
})->name('menu');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/blog', function () {
    return Inertia::render('Blog');
})->name('blog');

Route::get('/cart', function () {
    return Inertia::render('Cart');
})->name('cart');

// Product Routes
Route::get('/products', function () {
    $products = Product::all();
    $categories = Category::all();
    return Inertia::render('Products', compact('products', 'categories'));
})->name('products');

Route::get('/details/{id}', function ($id) {
    $product = Product::with('category.products')->findOrFail($id);
    return Inertia::render('Details', [
        'product' => $product,
        'relatedProducts' => $product->category->products->where('id', '!=', $id)->take(4),
    ]);
})->name('details');

// Booking Routes
Route::get('/booktable', function () {
    return Inertia::render('BookTable');
})->name('booktable');

// Payment Routes
Route::get('/payment/{bookingId}', function ($bookingId) {
    return Inertia::render('Payment', ['bookingId' => $bookingId]);
})->name('payment.show');

Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment'])
    ->name('payment.confirm');

// User Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('orders/history', function () {
        $orders = OrderItem::where('user_id', Auth::id())->get();
        return Inertia::render('HistoryOrder', compact('orders'));
    })->name('orders.history');
});

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin.check'], function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');

    // Orders Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrdersController::class, 'index'])->name('admin.orders.index');
        Route::get('/{id}', [AdminOrdersController::class, 'show'])->name('admin.orders.show');
        Route::put('/{id}/booking-status', [AdminOrdersController::class, 'updateBookingStatus'])
            ->name('admin.orders.updateBookingStatus');
        Route::post('/{id}/cash-payment', [AdminOrdersController::class, 'updateCashPayment'])
            ->name('admin.orders.updateCashPayment');
    });

    // Products Management
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductsController::class, 'products'])->name('admin.productlist');
        Route::get('/create', [AdminProductsController::class, 'create'])->name('admin.addproduct');
        Route::post('/store', [AdminProductsController::class, 'store'])->name('admin.storeproduct');
        Route::get('/{id}/edit', [AdminProductsController::class, 'edit'])->name('admin.edit');
        Route::put('/{id}', [AdminProductsController::class, 'update'])->name('admin.update');
        Route::post('/{id}/toggle-status', [AdminProductsController::class, 'toggleStatus'])->name('admin.products.toggleStatus');
    });

    // Categories Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminCategoriesController::class, 'index'])->name('admin.categorys');
        Route::get('/create', [AdminCategoriesController::class, 'create'])->name('admin.addcategory');
        Route::post('/', [AdminCategoriesController::class, 'store'])->name('admin.storecategory');
        Route::get('/{id}/edit', [AdminCategoriesController::class, 'edit'])->name('admin.editcategory');
        Route::put('/{id}', [AdminCategoriesController::class, 'update'])->name('admin.updatecategory');
        Route::delete('/{id}', [AdminCategoriesController::class, 'destroy'])->name('admin.destroycategory');
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUsersController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [AdminUsersController::class, 'create'])->name('admin.users.create');
        Route::post('/', [AdminUsersController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}/edit', [AdminUsersController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [AdminUsersController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Tables Management
    Route::prefix('tables')->group(function () {
        Route::get('/', [AdminTablesController::class, 'index'])->name('admin.tables.index');
        Route::get('/create', [AdminTablesController::class, 'create'])->name('admin.tables.create');
        Route::post('/', [AdminTablesController::class, 'store'])->name('admin.tables.store');
        Route::get('/{id}/edit', [AdminTablesController::class, 'edit'])->name('admin.tables.edit');
        Route::put('/{id}', [AdminTablesController::class, 'update'])->name('admin.tables.update');
        Route::delete('/{id}', [AdminTablesController::class, 'destroy'])->name('admin.tables.destroy');
        Route::get('/{id}/details', [AdminTablesController::class, 'showDetails'])->name('table.details');
    });
});

// API Routes
Route::get('/api/search', [HomeController::class, 'search']);
Route::get('api/menu', function () {
    return response()->json(Category::with('products')->get());
});

Route::post('/admin/products/{id}/toggle-status', [AdminProductsController::class, 'toggleStatus'])
    ->name('admin.products.toggleStatus');

// Thêm route cho trang chi tiết đơn hàng
Route::get('/orders/{id}', function($id) {
    return Inertia::render('OrderDetail', [
        'id' => $id
    ]);
})->name('orders.detail');

// Thêm route cho trang lịch sử đơn hàng
Route::get('/orders/history', function () {
    return Inertia::render('HistoryOrder');
})->middleware('auth')->name('orders.history');
