<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();
//Start - PageController
//Trang index
Route::get('/', 'PageController@index')->name('index');
//Trang contact
Route::get('/contact', 'PageController@contact');

//End - PageController
//Category
Route::resource('category', 'CategoryController');
//Product
Route::resource('product', 'ProductController');
//Coupon
Route::resource('coupon', 'CouponController');
//Order
Route::resource('order', 'OrderController');
//Admin
Route::get('admin', function () {
    return view('backend.index');
});
