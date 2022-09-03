<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// под resize картинок есть специальная библиотека, использовать для фото профиля и товаров

Auth::routes();

// profile routes
Route::get('/profile/{user}/edit', ProfileController::class . '@edit')->name('profile.edit');
Route::patch('/profile/{user}', ProfileController::class . '@update')->name('profile.update');
Route::get('/profile/{user}', ProfileController::class . '@show')->name('profile.show');
Route::post('/profile', ProfileController::class . '@store')->name('profile.store');

// product routes
Route::get('/product/create', ProductController::class . '@create')->name('product.create');
Route::get('/product/{product}/edit', ProductController::class . '@edit')->name('product.edit');
Route::patch('/product/{product}', ProductController::class . '@update')->name('product.update');
Route::get('/product/{product}', ProductController::class . '@show')->name('product.show');
Route::get('/product', ProductController::class . '@index')->name('product.index');
Route::post('/product', ProductController::class . '@store')->name('product.store');
Route::delete('/product/{product}', ProductController::class . '@destroy')->name('product.destroy');

// rate routes
Route::post('/rate', RatingController::class . '@store')->name('rate.store');
