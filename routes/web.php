<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

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

Route::get('/profile/{user}/edit', ProfileController::class . '@edit')->name('profile.edit');
Route::get('/profile/{user}', ProfileController::class . '@show')->name('profile.show');
Route::post('/profile', ProfileController::class . '@store')->name('profile.store');


Route::get('/product/create', ProductController::class . '@create')->name('product.create');
Route::get('/product/{id}', ProductController::class . '@show')->name('product.show');
Route::post('/product', ProductController::class . '@store')->name('product.store');

