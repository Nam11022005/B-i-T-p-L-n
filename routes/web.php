<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\WalletController as AdminWalletController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderServiceRequestController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WalletController;


/*
|--------------------------------------------------------------------------
| TRANG CHỦ
|--------------------------------------------------------------------------
*/

Route::get('/', [
    WelcomeController::class,
    'index'
])->name('welcome');


/*
|--------------------------------------------------------------------------
| CHÍNH SÁCH & ĐIỀU KHOẢN
|--------------------------------------------------------------------------
*/

Route::get('/chinh-sach-giao-hang', [
    PolicyController::class,
    'shipping'
])->name('policies.shipping');


Route::get('/chinh-sach-doi-tra', [
    PolicyController::class,
    'returns'
])->name('policies.returns');


Route::get('/chinh-sach-bao-mat', [
    PolicyController::class,
    'privacy'
])->name('policies.privacy');


Route::get('/dieu-khoan-dich-vu', [
    PolicyController::class,
    'terms'
])->name('policies.terms');


Route::get('/chinh-sach-thanh-toan', [
    PolicyController::class,
    'payment'
])->name('policies.payment');


/*
|--------------------------------------------------------------------------
| ĐĂNG KÝ + ĐĂNG NHẬP
|--------------------------------------------------------------------------
*/

Route::middleware('guest')
    ->group(function () {

        Route::get('/forgot-password', [
            ForgotPasswordController::class,
            'showForgotForm'
        ])->name('password.request');


        Route::post('/forgot-password', [
            ForgotPasswordController::class,
            'sendOtp'
        ])->name('password.email');


        Route::get('/forgot-password/verify-otp', [
            ForgotPasswordController::class,
            'showOtpForm'
        ])->name('password.otp.form');


        Route::post('/forgot-password/verify-otp', [
            ForgotPasswordController::class,
            'verifyOtp'
        ])->name('password.otp.verify');


        Route::get('/reset-password', [
            ForgotPasswordController::class,
            'showResetForm'
        ])->name('password.reset.form');


        Route::post('/reset-password', [
            ForgotPasswordController::class,
            'resetPassword'
        ])->name('password.reset');


        Route::get('/register', [
            AuthController::class,
            'showRegistrationForm'
        ])->name('register');


        Route::post('/register', [
            AuthController::class,
            'register'
        ]);


        Route::get('/login', [
            AuthController::class,
            'showLoginForm'
        ])->name('login');


        Route::post('/login', [
            AuthController::class,
            'login'
        ]);
    });


/*
|--------------------------------------------------------------------------
| ĐĂNG XUẤT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [
    AuthController::class,
    'logout'
])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| SẢN PHẨM CÔNG KHAI
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| USER ĐÃ ĐĂNG NHẬP
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [
            AuthController::class,
            'dashboard'
        ])->name('dashboard');


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


        Route::post('/wallet/top-up', [
            WalletController::class,
            'createTopUp'
        ])->name('wallet.topup');


        Route::post('/orders/{order}/service-requests', [
            OrderServiceRequestController::class,
            'store'
        ])->name('orders.service-requests.store');


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


        Route::get('/categories', [
            CategoryController::class,
            'indexUser'
        ])->name('categories.index');


        Route::get('/categories/{category}', [
            CategoryController::class,
            'showNormal'
        ])->name('categories.show');
    });


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'admin'
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            AdminController::class,
            'dashboard'
        ])->name('dashboard');


        Route::get('/customers', [
            AdminController::class,
            'customers'
        ])->name('customers.index');


        Route::get('/customers/{customer}', [
            AdminController::class,
            'customerShow'
        ])->name('customers.show');


        Route::post('/customers/{customer}/wallet/adjustment', [
            AdminWalletController::class,
            'adjust'
        ])->name('customers.wallet.adjust');
        Route::post('/customers/{customer}/wallet/{transaction}/review', [AdminWalletController::class, 'review'])
            ->name('customers.wallet.review');


        Route::get('/profile', [
            AuthController::class,
            'adminProfile'
        ])->name('profile');


        Route::get('/notifications/{notification}', [
            AdminController::class,
            'readNotification'
        ])->name('notifications.read');


        Route::patch('/notifications/read-all', [
            AdminController::class,
            'readAllNotifications'
        ])->name('notifications.readAll');


        Route::delete('/reviews/{review}', [
            ReviewController::class,
            'destroy'
        ])->name('reviews.destroy');


        Route::patch('/products/{product}/featured', [
            ProductController::class,
            'toggleFeatured'
        ])->name('products.toggleFeatured');


        Route::get('/promotions', [
            ProductController::class,
            'adminPromotions'
        ])->name('promotions.index');


        Route::patch('/products/{product}/promotion', [
            ProductController::class,
            'setPromotion'
        ])->name('products.setPromotion');


        Route::delete('/products/{product}/promotion', [
            ProductController::class,
            'removePromotion'
        ])->name('products.removePromotion');


        Route::delete('/products/{product}/gallery/{image}', [
            ProductController::class,
            'destroyGalleryImage'
        ])
            ->whereNumber('image')
            ->name('products.gallery.destroy');


        Route::resource(
            'products',
            ProductController::class
        );


        Route::resource(
            'categories',
            CategoryController::class
        );


        Route::resource(
            'vouchers',
            VoucherController::class
        )->except(['show']);


        Route::get('/orders', [
            OrderController::class,
            'adminIndex'
        ])->name('orders.index');


        Route::get('/orders/{order}', [
            OrderController::class,
            'show'
        ])->name('orders.show');


        Route::patch('/orders/{order}/shipment', [\App\Http\Controllers\ShipmentController::class, 'update'])
            ->name('orders.shipment.update');

        Route::patch('/orders/{order}/status', [
            OrderController::class,
            'updateStatus'
        ])->name('orders.updateStatus');


        Route::patch('/orders/{order}/payment', [
            OrderController::class,
            'confirmPayment'
        ])->name('orders.confirmPayment');


        Route::patch('/service-requests/{orderServiceRequest}', [
            OrderServiceRequestController::class,
            'process'
        ])->name('service-requests.process');
    });


/*
|--------------------------------------------------------------------------
| USER ĐÃ ĐĂNG NHẬP + XÁC THỰC EMAIL
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified'
])
    ->group(function () {

        Route::get('/notifications/{notification}', [
            NotificationController::class,
            'read'
        ])->name('notifications.read');


        Route::patch('/notifications/read-all', [
            NotificationController::class,
            'readAll'
        ])->name('notifications.readAll');


        Route::post('/products/{product}/reviews', [
            ReviewController::class,
            'store'
        ])->name('reviews.store');


        Route::get('/addresses', [
            AddressController::class,
            'index'
        ])->name('addresses.index');


        Route::post('/addresses', [
            AddressController::class,
            'store'
        ])->name('addresses.store');


        Route::put('/addresses/{address}', [
            AddressController::class,
            'update'
        ])->name('addresses.update');


        Route::patch('/addresses/{address}/default', [
            AddressController::class,
            'setDefault'
        ])->name('addresses.default');


        Route::delete('/addresses/{address}', [
            AddressController::class,
            'destroy'
        ])->name('addresses.destroy');


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


        Route::get('/checkout', [
            CartController::class,
            'checkout'
        ])->name('checkout');


        Route::post('/checkout', [
            CartController::class,
            'processCheckout'
        ])->name('checkout.process');


        Route::get('/orders', [
            OrderController::class,
            'index'
        ])->name('orders.index');


        Route::get('/orders/{order}/payment-status', [
            OrderController::class,
            'paymentStatus'
        ])->name('orders.paymentStatus');


        Route::get('/orders/{order}', [
            OrderController::class,
            'showCustomer'
        ])->name('orders.show');
    });


/*
|--------------------------------------------------------------------------
| SEPAY WEBHOOK
|--------------------------------------------------------------------------
*/

Route::post('/webhooks/sepay', [
    PaymentWebhookController::class,
    'sepay'
])
    ->withoutMiddleware([
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class
    ])
    ->name('webhooks.sepay');   
