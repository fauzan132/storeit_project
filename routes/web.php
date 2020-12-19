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
    return view('auth/login');
});
Route::group(['middleware' => ['web','auth']], function(){
    //redirect to login
    Route::get('/home','HomeController@index');
    Route::get('/', function(){
        if(Auth::user()->role=="Admin"){
            return view('admin.home');
        }elseif(Auth::user()->role=="Public"){
            return view('publik.home');
        }elseif(Auth::user()->role=="Expert ITB"){
            return view('expert_itb.home');
        }elseif(Auth::user()->role=="Expert EDWINDO"){
            return view('expert_ewindo.home');
        }elseif(Auth::user()->role=="Expert BALITSA"){
            return view('expert_balista.home');
        }
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

//Kelola Data by Admin
Route::get('admin-data/index/', 'KelolaDataController@index');
Route::get('admin-data/create/', 'KelolaDataController@create');
Route::post('admin-data/simpan/', 'KelolaDataController@store');
Route::get('admin-data/detail/{id}', 'KelolaDataController@show');
Route::get('admin-data/edit/{id}', 'KelolaDataController@edit');
Route::post('admin-data/update/{id}', 'KelolaDataController@update');
Route::get('admin-data/hapus/{id}', 'KelolaDataController@destroy');

//Fitur Cropping
Route::post('admin-data/upload/{id}','KelolaDataController@upload');
Route::get('admin-data/cropping/{id}','KelolaDataController@cropping');
