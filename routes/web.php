<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressLookupController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/danh-muc/{slug}', [ProductController::class, 'index'])->name('categories.show');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');

// ---- Giỏ hàng (khách chưa đăng nhập vẫn dùng được) ----
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/gio-hang/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/{product}', [CartController::class, 'remove'])->name('cart.remove');

// ---- Thanh toán + đơn hàng của tôi (cần đăng nhập) ----
Route::middleware('auth')->group(function () {
    // Chỉ tải dữ liệu địa phương; không gửi thông tin người nhận ra dịch vụ ngoài.
    Route::get('/dia-chi/tinh-thanh', [AddressLookupController::class, 'provinces'])
        ->middleware('throttle:60,1')->name('address.provinces');
    Route::get('/dia-chi/tinh-thanh/{province}/phuong-xa', [AddressLookupController::class, 'wards'])
        ->where('province', '[1-9][0-9]?')->middleware('throttle:60,1')->name('address.wards');
    Route::get('/thanh-toan', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/don-hang', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/don-hang/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/don-hang/{order}/huy', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// ---- Đăng nhập / đăng ký / đăng xuất ----
Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'login']);
    Route::get('/dang-ky', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/dang-ky', [AuthController::class, 'register']);
});
Route::post('/dang-xuat', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---- Khu vực quản trị (chỉ Admin) ----
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD danh mục: admin.categories.index/create/store/edit/update/destroy
    Route::resource('categories', AdminCategoryController::class)->except('show');

    // CRUD sản phẩm (có upload ảnh): admin.products.*
    Route::resource('products', AdminProductController::class)->except('show');

    // Quản lý đơn hàng: xem, đổi trạng thái
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});
