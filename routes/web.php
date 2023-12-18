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
    Route::get('/search-product', [App\Http\Controllers\CartController::class, 'searchProduct'])->name('cart.search-cart');
    Route::get('/get-password', [App\Http\Controllers\SettingsController::class, 'getPassword'])->name('get-password');
    Route::get('/gen-qr', [App\Http\Controllers\CartController::class, 'generateQr'])->name('cart.generate-qr-code');
    Route::get('/get-coupons-list', [App\Http\Controllers\CartController::class, 'getCouponList'])->name('cart.get-coupon-list');
    Route::get('/apply-coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
    Route::post('/checkout', [App\Http\Controllers\CartController::class, 'generateCheckout'])->name('pos.perform-checkout');
});

Route::group(['middleware' => ['auth'], 'prefix' => '/pos', ], function () {
    Route::get('/app/{screen}', [App\Http\Controllers\POSController::class, 'index'])->name('pos.app');
    Route::get('/load-customer-info/{id?}', [App\Http\Controllers\POSController::class, 'getCustomerInfo'])->name('pos.get-customer-info');
});

Route::group(['middleware' => ['auth'], 'prefix' => '/notify', ], function () {
    Route::get('/zalo', [App\Http\Controllers\NotificationController::class, 'sendZalo'])->name('notify.zalo.test');
});

// Need more work
Route::group(["prefix" => "transaction", "namespace" => "App\Http\Controllers"], function () {
    Route::get("/find", [App\Http\Controllers\TransactionController::class, 'checkCall'])->name('transaction.find');
    Route::post("/makeQr", [App\Http\Controllers\TransactionController::class, 'generateQR'])->name('transaction.makeQr');
    Route::get("/qr/{uuid}", [App\Http\Controllers\TransactionController::class, 'displayQR'])->name('app.qr');
});
