<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\OrderController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/beranda', function () {
        return view('beranda');
    })->name('beranda');

    // Katalog Produk
    Route::get('/katalog', [ProductController::class, 'index'])->name('katalog');
    Route::get('/produk/{id}', [ProductController::class, 'show'])->name('produk.show'); // ⬅️ Tambahkan ini

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

    // Pesanan
    Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pesanan.detail');

    // Profil
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
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
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [AdminAuthController::class, 'updateProfile'])->name('admin.profile.update');
        
        // Product Management Routes
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
        
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