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

Route::group(['prefix' => '/cart'], function () {
    Route::get('/{id}/add', 'ProductsController@addToCart')->name('product.addToCart');
    Route::get('/{id}/reduce', 'ProductsController@reduceItemByOne')->name('product.reduceByOne');
    Route::get('/empty', 'ProductsController@emptyCart');
    Route::get('/', 'ProductsController@getCart');
    Route::get('/{id}/remove', 'ProductsController@removeItem')->name('product.removeItem');

});

Route::resource('/services', 'ServiceController');

Route::resource('/directors', 'DirectorsController');

Route::resource('/events', 'EventController');

Route::resource('/gallery', 'ImageGalleryController');

Route::resource('/speakers', 'SpeakerController');
Route::post('/contact', 'ContactsController@postContact');