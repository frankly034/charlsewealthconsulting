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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/products', 'ProductsController');
Route::get('/reduce/{id}', 'ProductsController@reduceItemByOne')->name('product.reduceByOne');
Route::group(['prefix' => '/cart'], function () {
    Route::get('add_to_cart/{id}', 'ProductsController@AddToCart')->name('product.addToCart');
    //Route::get('/clean', 'ProductsController@resetSession');
    Route::get('get_cart', 'ProductsController@getCart');
    Route::get('/remove_all/{id}', 'ProductsController@removeAllItem')->name('product.removeItem');

});



