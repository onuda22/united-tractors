<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['token'])->group(function () {
    Route::get('/category-products', [CategoryController::class, 'index'])->name('get.all.category');
    Route::post('/category-products', [CategoryController::class, 'store'])->name('create.category');
    Route::get('/category-products/{id}', [CategoryController::class, 'show'])->name('get.one.category');
    Route::put('/category-products/{id}', [CategoryController::class, 'update'])->name('update.category');
    Route::delete('/category-products/{id}', [CategoryController::class, 'destroy'])->name('delete.category');
});

Route::middleware(['token'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('get.all.product');
    Route::post('/products', [ProductController::class, 'store'])->name('create.product');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('get.one.product');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update.product');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('delete.product');
});