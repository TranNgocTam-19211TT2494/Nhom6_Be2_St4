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

Route::get('/','PageController@index');
Route::get('blog','BlogController@hienthi');
Route::get('blog_detail/{id}','BlogController@hienthichitiet');
Route::get('blog_caterogy/{id}','BlogController@showcaterogy');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
