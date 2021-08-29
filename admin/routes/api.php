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

Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers\v1',
    'prefix'     => 'v1'

], function ($router) {

    Route::get('/categories'    , 'CategoryController@getCategories');

    Route::get('/menu-items'    , 'MenuItemController@getMenuItems');
  
    Route::get('/cities'        , 'CityController@getAllCities');

    Route::post('/new-order'    , 'OrderController@createOrder');
      
    Route::post('/online-payment', 'PaymentController@doTransaction')->name('stripe.payment');

});
