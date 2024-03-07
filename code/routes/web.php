<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('login');
})->name('home');

Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/store', [LoginRegisterController::class, 'store'])->name('store');
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

// Middleware 'auth' akan memastikan bahwa hanya pengguna yang telah login yang dapat mengakses rute-rute ini

// Rute untuk manajemen produk
Route::middleware('auth')->group( function() {
Route::get('/product', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Rute untuk manajemen akun
Route::get('/account', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::get('/users', 'UserController@index')->name('users.index');
Route::post('/user', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Rute untuk POS (Point of Sale)
Route::get('/pos', [PosController::class, 'index']);
Route::post('/pos', [PosController::class, 'store']);
Route::delete('/pos/{cart_item}', [PosController::class, 'destroy'])->name('cart_items.destroy');
});