<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaveForLaterController;
use Gloudemans\Shoppingcart\Facades\Cart;

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

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

// Shop routes
Route::get('/shop', [ProductController::class, 'index'])->name('products.index');
Route::get('/shop/{product}', [ProductController::class, 'show'])->name('products.show');

// Shopping cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/saveForLater/{product}', [CartController::class, 'saveForLater'])->name('cart.saveForLater');
Route::get('/cart/empty', function() {
    Cart::destroy();
    Cart::instance('saved')->destroy();
});

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'charge'])->name('checkout.charge');

// Coupon routes
Route::post('/coupon', [CouponController::class, 'apply'])->name('coupon.apply');
Route::delete('/coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');

// Save for later Cart
Route::delete('/saveForLater/{product}', [SaveForLaterController::class, 'destroy'])->name('saveForLater.destroy');
Route::post('/saveForLater/moveToCart/{product}', [SaveForLaterController::class, 'moveToCart'])->name('saveForLater.moveToCart');
