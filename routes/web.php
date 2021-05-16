<?php

use Illuminate\Routing\RouteGroup;
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
Route::get('/', 'PageController@index')->name('index');
//Trang contact
Route::get('/contact', 'PageController@contact')->name('contact');
//Cart
Route::get('cart', 'PageController@cart')->name('cart');
Route::get('cart/add/{slug}', 'CartController@addToCart')->name('cart.add');
Route::get('cart/delete/{id}', 'CartController@cartDelete')->name('cart.delete');
Route::post('cart/update', 'CartController@cartUpdate')->name('cart.update');

//Coupon apply
Route::post('/coupon/apply', 'CouponController@couponApply')->name('coupon.apply');

//Checkout
Route::get('checkout', 'PageController@checkout')->name('checkout');
//Place order
Route::post('place-order', 'OrderController@store')->name('order.store');

//--- Begin Blog ---
Route::get('blog', 'PageController@getBlog')->name('blog.all');
Route::get('blog/{slug}', 'PageController@getBlogDetailByID')->name('blog.detail');
Route::get('blog/category/{id}', 'PageController@getBlogCategoryByID')->name('blog.category');
Route::get('blog/search/key', 'PageController@blogSearch')->name('blog.search');
//--- End Blog ---
//--- Begin Shop ---
Route::get('product', 'PageController@ShowProduct')->name('product.all');
Route::get('product/{slug}', 'PageController@getProductBySlug')->name('product.detail');
Route::get('product/{id}', 'PageController@getCategogyBySlug');
Route::get('product/category/{id}', 'PageController@getCategogyProductById')->name('product.category');
Route::get('product/search/key','PageController@productSearch')->name('product.search');
//End - PageController

//Export pdf order detail
Route::get('order/pdf/{id}', 'OrderController@pdfGenerate')->name('order.pdf');

//File manager
Route::group(['prefix' => 'filemanager', 'middleware' => ['web',]], function () {
    Lfm::routes();
});


// Backend (ADMIN) section start
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
    Route::get('/', 'AdminController@index')->name('admin');
    //Post Caterogy :
    Route::resource('blogcategory', 'PostCategoryController');
    //admin profile
    Route::get('profile/', 'PageController@adminProfile')->name('admin.profile');
    Route::post('/profile/{id}', 'UserController@profileUpdate')->name('admin.profile.update');
    Route::get('/changepassword', 'PageController@changePassword')->name('admin.change.password');
    Route::post('/changepassword/save', 'UserController@changPasswordStore')->name('admin.changepass.save');
});
// End backend section

//User section start
Route::group(['prefix' => '/user',], function () {
    Route::get('/profile', 'UserController@userProfile')->name('user.profile');
    Route::get('/changepassword', 'PageController@changeUserPassword')->name('user.change.password');
    Route::post('/changepassword/save', 'UserController@changPasswordStore')->name('user.changepass.save');
    //User Login
    Route::get('/login', 'PageController@userLogin')->name('user.login');
    Route::post('/login', 'PageController@userLoginSubmit')->name('user.login.submit');
    //User Register
    Route::get('/register', 'PageController@userRegister')->name('user.register');
    Route::post('/register', 'PageController@userRegisterSubmit')->name('user.register.submit');
    //User Logout
    Route::get('/logout', 'PageController@userLogout')->name('user.logout');
    //User change password
    Route::get('/changepassword', 'PageController@changeUserPassword')->name('user.change.password');
    Route::post('/changepassword/save', 'UserController@changPasswordStore')->name('user.changepass.save');
    //Xac thuc user
    Route::get('/activation/{token}', 'UserController@activeUser')->name('user.activate');
    //  Order
    Route::get('/order', "UserController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}', "UserController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}', 'UserController@userOrderDelete')->name('user.order.delete');
});

// End user secsion
