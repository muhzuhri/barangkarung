<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (User)
Route::middleware('auth')->group(function () {
    Route::get('/beranda', function () {
        return view('beranda');
    })->name('beranda');

    // Katalog Produk
    Route::get('/katalog', [ProductController::class, 'index'])->name('katalog');
    Route::get('/produk/{id}', [ProductController::class, 'show'])->name('produk.show');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    
    // Cart API Routes
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear-all', [CartController::class, 'clearAll'])->name('cart.clear-all');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/midtrans/notification', [CheckoutController::class, 'midtransNotification'])->name('midtrans.notification');

    // Chatbot endpoint
    Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

    // Pesanan
    Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pesanan.detail');
    Route::post('/pesanan/{id}/selesai', [OrderController::class, 'complete'])->name('pesanan.selesai');
    Route::get('/pesanan-history', [OrderController::class, 'history'])->name('pesanan.history');

    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// Admin Routes
Route::prefix('admin')->group(function () {
    // Redirect admin login to main login page
    Route::get('/login', function () {
        return redirect()->route('login');
    })->name('admin.login');
    
    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.setting.profile');
        Route::post('/profile', [AdminAuthController::class, 'updateProfile'])->name('admin.setting.profile.update');
        
        // Product Management Routes
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
        
        // Order Management Routes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::patch('/admin/orders/{id}/update-payment', [\App\Http\Controllers\Admin\OrderController::class, 'updatePayment'])->name('admin.orders.updatePayment');
        Route::patch('/admin/orders/{id}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateOrderStatus'])->name('admin.orders.updateOrderStatus');

        // Revenue Management
        Route::get('/revenue', [\App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('admin.revenue.index');

        // User Management Routes
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });
});