<?php

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


Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('main');


// Route::get('{any}','HomeController@index')->where('path', '([A-z\d=\/_.]+)?');
Route::get('/{any?}', 'HomeController@index')->where('any', '.*');
// Route::middleware('auth:api', function () {
//      Route::get('report-menu', 'ShowMenuController@index')->name('report-menu');
//      Route::get('main-menu', 'ShowMenuController@showMenu')->name('main-menu');
// });
