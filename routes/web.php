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
Route::get('/cart', function () {
    return view('cart');
});
Route::get('/orders', function () {
    return view('orders');
});
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


Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('cart.store');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
});


//ADD PRODUCT
Route::middleware('auth')->group(function () {
    Route::get('/products/add', function () {
        if (Auth::user()->access !== 'admin' && Auth::user()->access !== 'employee') {
            abort(404); 
        }

        return view('admin_add_products');
    })->name('admin.products.create');

    Route::post('/products/add', [AdminProductController::class, 'store'])->name('admin.products.store');
});


// EDIT AND DELETE PRODUCT
Route::get('/admin/products/{product_id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{product_id}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product_id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');


