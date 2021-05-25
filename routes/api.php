<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('register/check', 'Auth\RegisterController@check')->name('api-register-check');
Route::get('provinces', 'API\LocationController@provinces')->name('api-provinces');
Route::get('regencies/{province_id}', 'API\LocationController@regencies')->name('api-regencies');

Route::get('topcategories', 'API\CategoryController@topCategories')->name('api-topcategories');
Route::get('categories/{top_categories_id}', 'API\CategoryController@categories')->name('api-categories');

Route::get('banks', 'API\BankController@banks')->name('api-banks');
Route::get('users', 'API\UserController@index')->name('api-users');

