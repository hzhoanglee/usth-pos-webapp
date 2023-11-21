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

Route::group(['middleware' => [], 'prefix' => '/call', ], function () {
    Route::post('/add-by-code', [App\Http\Controllers\CartController::class, 'addToCartByCode'])->name('cart.add-by-code');
});

Route::get('/my-role', [App\Http\Controllers\RoleController::class, 'myRole']);
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logOut'])->name('logout');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'logIn'])->name('login');

Route::group(['middleware' => ['auth'], 'prefix' => '/cart', ], function () {
    Route::get('/screen/{screen}', [App\Http\Controllers\CartController::class, 'index'])->name('cart.screen');
    Route::get('/screen-data/{screen?}', [App\Http\Controllers\CartController::class, 'loadScreen'])->name('cart.screen-data');
    Route::get('/load/{cart_id?}', [App\Http\Controllers\CartController::class, 'loadCart'])->name('cart.load-cart');
    Route::get('/load-total/{cart_id?}', [App\Http\Controllers\CartController::class, 'loadTotal'])->name('cart.load-total');
    Route::post('/add-to-cart', [App\Http\Controllers\CartController::class, 'addToCartRoute'])->name('cart.add-to-cart');
    Route::post('/remove-from-cart', [App\Http\Controllers\CartController::class, 'removeCartItem'])->name('cart.remove-from-cart');
    Route::get('/clear', [App\Http\Controllers\CartController::class, 'clearCartRoute'])->name('cart.clear-cart-route');
    Route::get('/playground', [App\Http\Controllers\CartController::class, 'playground']);
});

Route::group(['middleware' => ['auth'], 'prefix' => '/pos', ], function () {
    Route::get('/app/{screen}', [App\Http\Controllers\POSController::class, 'index'])->name('pos.app');
});

Route::group(['middleware' => ['auth'], 'prefix' => '/notify', ], function () {
    Route::get('/zalo', [App\Http\Controllers\NotificationController::class, 'sendZalo'])->name('notify.zalo.test');
});

// Need more work
//Route::group(["prefix" => "transaction", "namespace" => "App\Http\Controllers"], function () {
//    Route::get("/find", "TransactionController@checkCall")->name('transaction.find');
//    Route::post("/makeQr", "TransactionController@generateQR")->name('transaction.makeQr');
//});
//
//Route::group(["prefix" => "app", "namespace" => "App\Http\Controllers"], function () {
//    Route::get("/qr/{uuid}", "TransactionController@displayQR")->name('app.qr');
//});
