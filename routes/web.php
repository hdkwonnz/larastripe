<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Product Routes */
Route::get('/boutique', 'ProductController@index')->name('products.index');
Route::get('/boutique/{slug}', 'ProductController@show')->name('products.show');

/* Cart Routes 추후에 수정....*/ 
Route::get('/cart', 'CartController@index')->name('carts.index');
// Route::post('cart/store', 'CartController@store')->name('cart.store');
//Route::delete('cart-destroy/{rowId}', 'CartController@destroy')->name('cart.destroy');
// Route::get('/cart-destroy', function(){
//     Cart::destroy();
// });

// Checkout Route
Route::get('/payment', 'CheckoutController@index')->middleware('auth')->name('checkout.index');
Route::post('/payment', 'CheckoutController@store')->middleware('auth')->name('checkout.store');
// Route::get('/mercy', function(){
//     return view('checkout.thankyou');
// });
Route::get('/mercy', 'CheckoutController@thankyou')->middleware('auth')->name('checkout.thankyou');
