<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::get('users', 'UserController@index');

Route::get('items', 'ItemController@index');
Route::post('items/import', 'ItemController@import');
Route::get('items/export', 'ItemController@export');
/*Route::get('items/search/{category}', 'ItemController@search');*/

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/items/search','ItemController@search');