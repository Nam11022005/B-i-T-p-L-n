<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


// =====================================================
// TRANG CHỦ
// =====================================================

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');


// =====================================================
// ĐĂNG KÝ + ĐĂNG NHẬP
// Chỉ dành cho người chưa đăng nhập
// =====================================================

Route::middleware('guest')->group(function () {

    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);


    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});


// =====================================================
// ĐĂNG XUẤT
// =====================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// =====================================================
// USER ĐÃ ĐĂNG NHẬP
// =====================================================

Route::middleware('auth')->group(function () {

    // Dashboard User
    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard');


    // Profile User
    Route::get('/profile', [AuthController::class, 'profile'])
        ->name('profile');


    // =================================================
    // XÁC THỰC EMAIL
    // =================================================

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
    // DANH MỤC
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

        // Dashboard Admin
        Route::get('/dashboard', [
            AdminController::class,
            'dashboard'
        ])->name('dashboard');


        // Profile Admin
        Route::get('/profile', [
            AuthController::class,
            'adminProfile'
        ])->name('profile');


        // =================================================
        // QUẢN LÝ SẢN PHẨM
        // =================================================

        Route::resource('products', ProductController::class);


        // =================================================
        // QUẢN LÝ DANH MỤC
        // =================================================

        Route::resource('categories', CategoryController::class);


        // =================================================
        // QUẢN LÝ ĐƠN HÀNG
        // =================================================

        Route::get('/orders', [
            OrderController::class,
            'adminIndex'
        ])->name('orders.index');


        Route::get('/orders/{order}', [
            OrderController::class,
            'show'
        ])->name('orders.show');


        Route::patch('/orders/{order}/status', [
            OrderController::class,
            'updateStatus'
        ])->name('orders.updateStatus');
        Route::patch('/orders/{order}/payment', [
    OrderController::class,
    'confirmPayment'
])->name('orders.confirmPayment');
    });


// =====================================================
// USER ĐÃ ĐĂNG NHẬP + XÁC THỰC EMAIL
// =====================================================

Route::middleware(['auth', 'verified'])->group(function () {

    // =================================================
    // SẢN PHẨM
    // =================================================

    Route::get('/products', [
        ProductController::class,
        'userIndex'
    ])->name('products.index');


    Route::get('/products/{product}', [
        ProductController::class,
        'show_normal'
    ])->name('products.show');


    // =================================================
// GIỎ HÀNG
// =================================================

Route::post('/cart/add/{product}', [
    CartController::class,
    'add'
])->name('cart.add');


Route::get('/cart', [
    CartController::class,
    'index'
])->name('cart.index');


Route::patch('/cart/{id}', [
    CartController::class,
    'update'
])->name('cart.update');


Route::delete('/cart/{product}', [
    CartController::class,
    'destroy'
])->name('cart.destroy');


// =================================================
// THANH TOÁN
// =================================================

Route::get('/checkout', [
    CartController::class,
    'checkout'
])->name('checkout');


Route::post('/checkout', [
    CartController::class,
    'processCheckout'
])->name('checkout.process');


    // =================================================
    // ĐƠN HÀNG USER
    // =================================================

    Route::get('/orders', [
        OrderController::class,
        'index'
    ])->name('orders.index');
});