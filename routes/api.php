<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::get('todos', 'TodoController@index');

Route::resource('productsCategories', 'ProductsCategoryAPIController');     

Route::get('productsByCategory/{id}','ProductsCategoryAPIController@productsByCategory');

Route::resource('products', 'productAPIController');


Route::post('users', 'UserAPIController@signup');

Route::post('signin', 'UserAPIController@signin');


Route::resource('inventories', 'inventoryAPIController');

//Route::resource('products', 'productAPIController');

//Route::resource('products_categories', 'ProductsCategoryAPIController');