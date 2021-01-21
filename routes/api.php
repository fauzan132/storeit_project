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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'API\AuthController@login');
    Route::post('signup', 'API\AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'API\AuthController@logout');
        Route::get('user', 'API\AuthController@user');
    });
});

//API
Route::get('kelola-data/lihat/', 'API\KelolaDataController@index');
Route::get('kelola-data/simpan/', 'API\KelolaDataController@store');
