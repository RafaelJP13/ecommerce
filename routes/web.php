<?php

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

Route::get('/', 'HomeController@index')->name('index');
Route::get('/products', 'ProductController@create')->name('product.create')->middleware('auth');
Route::post('/store', 'ProductController@store')->name('product.store');
Route::post('/edit', 'ProductController@edit')->name('product.edit');
Route::post('/editImage', 'ProductController@editImage')->name('product.editImage');
Route::post('/destroy', 'ProductController@destroy')->name('product.destroy');
Route::get('/details/{id}', 'ProductController@details')->name('product.details');
Route::get('/settings', 'ProductController@settings')->name('settings')->middleware('auth');

