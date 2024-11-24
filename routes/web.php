<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;


/**
 * Home Routes
 */
Route::get('/', function () {
    return view('home');
});

/**
 * Static Pages Routes
 */
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/contact', function () {
    return view('contact');
});

/**
 * Authentication Routes
 */
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/**
 * Registration Routes
 */
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

/**
 * Authenticated Routes
 */
Route::middleware(['auth'])->group(function () {
    // Cart and Checkout
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/checkout', [OrderController::class, 'store'])->name('cart.store');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');



    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Admin - Add Product
    Route::get('/products/add', function () {
        if (Auth::user()->access !== 'admin' && Auth::user()->access !== 'employee') {
            abort(404);
        }
        return view('admin_add_products');
    })->name('admin.products.create');
    Route::post('/products/add', [AdminProductController::class, 'store'])->name('admin.products.store');
});

/**
 * Admin Product Management
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/products/{product_id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product_id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::put('/admin/products/{product_id}/update-quantity', [AdminProductController::class, 'updateQuantity'])->name('admin.products.update_quantity');
    Route::delete('/admin/products/{product_id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
});


// Inside the authenticated group if needed
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});
