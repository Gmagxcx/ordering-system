<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


/**
 * Home Routes
 */
Route::get('/', function () {
    return redirect()->route('login');
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
    Route::get('/home', function () {
        return view('home'); // Ensure "home" view exists
    })->name('home');
    // Cart and Checkout
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');


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

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});

Route::get('/order-items', [AdminOrderItemController::class, 'index'])->name('admin.orderitems.index');

Route::get('/users', [UserController::class, 'index'])->name('admin.users.index'); // List users
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit'); // Edit user
Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update'); // Update user
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy'); // Delete user


// // Inside the authenticated group if needed
// Route::middleware('auth')->group(function () {
//     Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
// });
Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
Route::delete('/admin/orders/{order_id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('/order-items', [AdminOrderItemController::class, 'index'])->name('order-items.index');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

