<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;


// =====================================================
// TRANG CHỦ
// =====================================================

Route::get('/', [
    WelcomeController::class,
    'index'
])->name('welcome');


// =====================================================
// ĐĂNG KÝ + ĐĂNG NHẬP
// Chỉ dành cho người chưa đăng nhập
// =====================================================

Route::middleware('guest')->group(function () {

    // =================================================
    // QUÊN MẬT KHẨU BẰNG OTP
    // =================================================

    // Bước 1: Nhập email
    Route::get('/forgot-password', [
        ForgotPasswordController::class,
        'showForgotForm'
    ])->name('password.request');

    Route::post('/forgot-password', [
        ForgotPasswordController::class,
        'sendOtp'
    ])->name('password.email');


    // Bước 2: Xác nhận OTP
    Route::get('/forgot-password/verify-otp', [
        ForgotPasswordController::class,
        'showOtpForm'
    ])->name('password.otp.form');

    Route::post('/forgot-password/verify-otp', [
        ForgotPasswordController::class,
        'verifyOtp'
    ])->name('password.otp.verify');


    // Bước 3: Đặt mật khẩu mới
    Route::get('/reset-password', [
        ForgotPasswordController::class,
        'showResetForm'
    ])->name('password.reset.form');

    Route::post('/reset-password', [
        ForgotPasswordController::class,
        'resetPassword'
    ])->name('password.reset');


    // Đăng ký
    Route::get('/register', [
        AuthController::class,
        'showRegistrationForm'
    ])->name('register');

    Route::post('/register', [
        AuthController::class,
        'register'
    ]);


    // Đăng nhập
    Route::get('/login', [
        AuthController::class,
        'showLoginForm'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ]);
});


// =====================================================
// ĐĂNG XUẤT
// =====================================================

Route::post('/logout', [
    AuthController::class,
    'logout'
])
    ->middleware('auth')
    ->name('logout');


// =====================================================
// USER ĐÃ ĐĂNG NHẬP
// =====================================================
// =====================================================
// 🛍️ SẢN PHẨM CÔNG KHAI
// Guest / Customer / Admin đều có thể xem
// =====================================================

Route::get('/products-search-suggestions', [
    ProductController::class,
    'searchSuggestions'
])->name('products.searchSuggestions');


Route::get('/products', [
    ProductController::class,
    'userIndex'
])->name('products.index');


Route::get('/products/{product}', [
    ProductController::class,
    'show_normal'
])->name('products.show');


Route::get('/khuyen-mai', [
    ProductController::class,
    'promotions'
])->name('products.promotions');
Route::middleware('auth')->group(function () {

    // =================================================
    // DASHBOARD USER
    // =================================================

    Route::get('/dashboard', [
        AuthController::class,
        'dashboard'
    ])->name('dashboard');


    // =================================================
    // PROFILE USER
    // =================================================

    Route::get('/profile', [
        AuthController::class,
        'profile'
    ])->name('profile');


    Route::patch('/profile', [
        AuthController::class,
        'updateProfile'
    ])->name('profile.update');

    Route::post('/profile/avatar', [
        AuthController::class,
        'updateAvatar'
    ])->name('profile.avatar.update');

    Route::delete('/profile/avatar', [
        AuthController::class,
        'deleteAvatar'
    ])->name('profile.avatar.delete');

    Route::patch('/profile/password', [
        AuthController::class,
        'updatePassword'
    ])->name('profile.password.update');


    // =================================================
    // XÁC THỰC EMAIL BẰNG MÃ OTP
    // =================================================

    Route::get('/email/verify', [
        AuthController::class,
        'showVerifyEmail'
    ])->name('verification.notice');


    Route::post('/email/verify', [
        AuthController::class,
        'verifyEmailCode'
    ])->name('verification.verify.code');


    Route::post('/email/resend-code', [
        AuthController::class,
        'resendVerificationCode'
    ])
        ->middleware('throttle:3,1')
        ->name('verification.resend');


    // =================================================
    // DANH MỤC USER
    // =================================================

    Route::get('/categories', [
        CategoryController::class,
        'indexUser'
    ])->name('categories.index');


    Route::get('/categories/{category}', [
        CategoryController::class,
        'showNormal'
    ])->name('categories.show');
});


// =====================================================
// ADMIN
// =====================================================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        // =================================================
        // DASHBOARD ADMIN
        // =================================================

        Route::get('/dashboard', [
            AdminController::class,
            'dashboard'
        ])->name('dashboard');



        // =================================================
        // 👥 QUẢN LÝ KHÁCH HÀNG
        // =================================================

        Route::get('/customers', [
            AdminController::class,
            'customers'
        ])->name('customers.index');

        Route::get('/customers/{customer}', [
            AdminController::class,
            'customerShow'
        ])->name('customers.show');


        // =================================================
        // PROFILE ADMIN
        // =================================================

        Route::get('/profile', [
            AuthController::class,
            'adminProfile'
        ])->name('profile');


        // =================================================
        // 🔔 THÔNG BÁO ADMIN
        // =================================================

        Route::get('/notifications/{notification}', [
            AdminController::class,
            'readNotification'
        ])->name('notifications.read');


        Route::patch('/notifications/read-all', [
            AdminController::class,
            'readAllNotifications'
        ])->name('notifications.readAll');


        // =================================================
        // ⭐ QUẢN LÝ ĐÁNH GIÁ
        // =================================================

        Route::delete('/reviews/{review}', [
            ReviewController::class,
            'destroy'
        ])->name('reviews.destroy');


        // =================================================
        // 📦 QUẢN LÝ SẢN PHẨM
        // =================================================

        // ⭐ Ghim / bỏ ghim sản phẩm nổi bật
        Route::patch('/products/{product}/featured', [
            ProductController::class,
            'toggleFeatured'
        ])->name('products.toggleFeatured');


        // =================================================
        // 🔥 KHUYẾN MÃI SẢN PHẨM
        // =================================================

        // Admin đưa sản phẩm lên sale / chỉnh sửa sale
        Route::patch('/products/{product}/promotion', [
            ProductController::class,
            'setPromotion'
        ])->name('products.setPromotion');


        // Admin gỡ sản phẩm khỏi sale
        Route::delete('/products/{product}/promotion', [
            ProductController::class,
            'removePromotion'
        ])->name('products.removePromotion');


        // CRUD sản phẩm
        Route::resource(
            'products',
            ProductController::class
        );


        // =================================================
        // 📂 QUẢN LÝ DANH MỤC
        // =================================================

        Route::resource(
            'categories',
            CategoryController::class
        );


        // =================================================
        // 🎟️ QUẢN LÝ VOUCHER
        // =================================================

        Route::resource(
            'vouchers',
            VoucherController::class
        )->except(['show']);


        // =================================================
        // 📋 QUẢN LÝ ĐƠN HÀNG
        // =================================================

        // Danh sách đơn hàng
        Route::get('/orders', [
            OrderController::class,
            'adminIndex'
        ])->name('orders.index');


        // Chi tiết đơn hàng
        Route::get('/orders/{order}', [
            OrderController::class,
            'show'
        ])->name('orders.show');
        // Cập nhật trạng thái đơn hàng
        Route::patch('/orders/{order}/status', [
            OrderController::class,
            'updateStatus'
        ])->name('orders.updateStatus');


        // Xác nhận thanh toán
        Route::patch('/orders/{order}/payment', [
            OrderController::class,
            'confirmPayment'
        ])->name('orders.confirmPayment');
    });


// =====================================================
// USER ĐÃ ĐĂNG NHẬP + XÁC THỰC EMAIL
// =====================================================

Route::middleware(['auth', 'verified'])
    ->group(function () {


        // =================================================
        // 🔔 THÔNG BÁO CUSTOMER
        // =================================================

        Route::get('/notifications/{notification}', [
            NotificationController::class,
            'read'
        ])->name('notifications.read');


        Route::patch('/notifications/read-all', [
            NotificationController::class,
            'readAll'
        ])->name('notifications.readAll');


        // =================================================
        // ⭐ ĐÁNH GIÁ SẢN PHẨM
        // =================================================

        Route::post('/products/{product}/reviews', [
            ReviewController::class,
            'store'
        ])->name('reviews.store');


        // =================================================
        // 🛍️ SẢN PHẨM
        // Route xem/tìm kiếm sản phẩm đã đặt ở khu vực public phía trên.
        // Guest / Customer / Admin đều có thể xem.
        // =================================================

        // =================================================
        // 📍 ĐỊA CHỈ KHÁCH HÀNG
        // =================================================

        // Danh sách địa chỉ
        Route::get('/addresses', [
            AddressController::class,
            'index'
        ])->name('addresses.index');

        // Thêm địa chỉ mới
        Route::post('/addresses', [
            AddressController::class,
            'store'
        ])->name('addresses.store');

        // Cập nhật địa chỉ
        Route::put('/addresses/{address}', [
            AddressController::class,
            'update'
        ])->name('addresses.update');

        // Đặt làm địa chỉ mặc định
        Route::patch('/addresses/{address}/default', [
            AddressController::class,
            'setDefault'
        ])->name('addresses.default');

        // Xóa địa chỉ
        Route::delete('/addresses/{address}', [
            AddressController::class,
            'destroy'
        ])->name('addresses.destroy');


        // =================================================
        // 🛒 GIỎ HÀNG
        // =================================================

        // Thêm sản phẩm vào giỏ
        Route::post('/cart/add/{product}', [
            CartController::class,
            'add'
        ])->name('cart.add');


        // Xem giỏ hàng
        Route::get('/cart', [
            CartController::class,
            'index'
        ])->name('cart.index');


        // Cập nhật số lượng giỏ hàng
        Route::patch('/cart/{id}', [
            CartController::class,
            'update'
        ])->name('cart.update');


        // Xóa sản phẩm khỏi giỏ
        Route::delete('/cart/{product}', [
            CartController::class,
            'destroy'
        ])->name('cart.destroy');


        // =================================================
        // 💳 THANH TOÁN
        // =================================================

        // Trang checkout
        Route::get('/checkout', [
            CartController::class,
            'checkout'
        ])->name('checkout');


        // Xử lý đặt hàng
        Route::post('/checkout', [
            CartController::class,
            'processCheckout'
        ])->name('checkout.process');


        // =================================================
        // 📦 ĐƠN HÀNG USER
        // =================================================

        Route::get('/orders', [
            OrderController::class,
            'index'
        ])->name('orders.index');

        // Kiểm tra trạng thái thanh toán tự động
        // PHẢI đặt trước /orders/{order}
        Route::get('/orders/{order}/payment-status', [
            OrderController::class,
            'paymentStatus'
        ])->name('orders.paymentStatus');


        // Xem chi tiết một đơn hàng của User
        Route::get('/orders/{order}', [
            OrderController::class,
            'showCustomer'
        ])->name('orders.show');
    });


// =====================================================
// 💳 SEPAY WEBHOOK - XÁC NHẬN CHUYỂN KHOẢN TỰ ĐỘNG
// =====================================================

Route::post('/webhooks/sepay', [
    PaymentWebhookController::class,
    'sepay'
])
->withoutMiddleware([
    \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class
])
->name('webhooks.sepay');
