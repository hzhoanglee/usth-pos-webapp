<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/my-role', [App\Http\Controllers\RoleController::class, 'myRole']);
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logOut'])->name('logout');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'logIn'])->name('login');

Route::group(['middleware' => ['auth'], 'prefix' => '/cart', ], function () {
    Route::get('/screen/{screen}', [App\Http\Controllers\CartController::class, 'index'])->name('cart.screen');
    Route::post('/add-to-cart', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add-to-cart');
    Route::get('/clear/{cart_id}', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clear-cart');
    Route::post('/clear', [App\Http\Controllers\CartController::class, 'clearCartRoute'])->name('cart.clear-cart-route');
});

Route::group(['middleware' => ['auth'], 'prefix' => '/pos', ], function () {
    Route::get('/app/{screen}', [App\Http\Controllers\POSController::class, 'index'])->name('pos.app');
});

Route::group(['middleware' => ['auth'], 'prefix' => '/notify', ], function () {
    Route::get('/zalo', [App\Http\Controllers\NotificationController::class, 'sendZalo'])->name('notify.zalo.test');
});
