<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/products', function () {
    return view('products');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/orders', function () {
    return view('orders');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/login', function () {
    return view('login');
}); 

Route::get('/register', function () {
    return view('register');
});

// Route::get('/login', [ProductController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [ProductController::class, 'login']);
// Route::get('/register', [ProductController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [ProductController::class, 'register']);
// Route::post('/logout', [ProductController::class, 'logout'])->name('logout');

Route::get('/profile', [ProductController::class, 'showForm'])->name('form.show');
Route::post('/', [ProductController::class, 'submitForm'])->name('form.submit');
