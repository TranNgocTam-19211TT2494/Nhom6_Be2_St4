<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use UniSharp\LaravelFilemanager\Lfm;

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
Route::get('/', 'PageController@index')->name('home');
//Trang contact
Route::get('/contact', 'PageController@contact');
//User Login
Route::get('user/login', 'AdminController@userLogin')->name('user.login');
Route::post('user/login', 'AdminController@userLoginSubmit')->name('user.login.submit');
//User Register
Route::get('user/register', 'AdminController@userRegister')->name('user.register');
Route::post('user/register', 'AdminController@userRegisterSubmit')->name('user.register.submit');
//User Logout
Route::get('user/logout', 'AdminController@userLogout')->name('user.logout');
//Cart
Route::get('cart', 'PageController@cart')->name('cart');
Route::get('cart/add/{slug}', 'CartController@addToCart')->name('cart.add');
Route::get('cart/delete/{id}', 'CartController@cartDelete')->name('cart.delete');
Route::post('cart/update', 'CartController@cartUpdate')->name('cart.update');
//Coupon apply
// Coupon
Route::post('/coupon/apply', 'CouponController@couponApply')->name('coupon.apply');
//Checkout
Route::get('checkout', 'PageController@checkout')->name('checkout');
//Place order
Route::post('place-order', 'OrderController@store')->name('order.store');

//--- Begin Blog ---
Route::get('blog', 'PageController@getBlog');
Route::get('blog/{slug}', 'PageController@getBlogDetailByID')->name('blog.detail');
Route::get('blog/category/{id}', 'PageController@getBlogCategoryByID')->name('blog.category');
Route::get('blog/search/key', 'PageController@blogSearch')->name('blog.search');
//--- End Blog ---
//--- Begin Shop ---
Route::get('product', 'PageController@ShowProduct')->name('product.all');

Route::get('product/{slug}', 'PageController@getProductBySlug')->name('product.detail');

Route::get('product/{id}', 'PageController@getCategogyBySlug');
Route::get('product/category/{id}','PageController@getCategogyProductById')->name('product.category');
//End - PageController


//File manager
Route::group(['prefix' => 'filemanager', 'middleware' => ['web',]], function () {
    Lfm::routes();
});


// Backend section start
Route::group(['prefix' => '/admin',], function () {
    //Category
    Route::resource('category', 'CategoryController');
    //Product
    Route::resource('product', 'ProductController');
    //Coupon
    Route::resource('coupon', 'CouponController');
    //Order
    Route::resource('order', 'OrderController');
    //Product Rating
    Route::resource('rate', 'ProductReviewController');
    //Banner
    Route::resource('banner', 'BannerController');
    //Post Tag
    Route::resource('postTag', 'PostTagController');
    //Post
    Route::resource('blog', 'PostController');
    //wishlist
    Route::resource('wishlist', 'WishlistController');
    //Users
    Route::resource('users', 'UserController');
    //User profile
    Route::get('profile', 'AdminController@profile')->name('profile');
    //Admin
    Route::get('/', 'PageController@admin')->name('admin');
    //Post Caterogy :
    Route::resource('blogcategory', 'PostCategoryController');
});
// End backend section
