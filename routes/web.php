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
//Trang index
Route::get('/', 'PageController@index')->name('index');

//Category
Route::resource('category','CategoryController');
//Product
Route::resource('product','ProductController');
//Admin
Route::get('admin',function(){
    return view('backend.index');
});
