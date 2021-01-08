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
            return view('public.home');
        }elseif(Auth::user()->role=="Expert ITB"){
            return view('itb.home');
        }elseif(Auth::user()->role=="Expert EWINDO"){
            return view('ewindo.home');
        }elseif(Auth::user()->role=="Expert BALITSA"){
            return view('balitsa.home');
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
Route::get('admin-data/index_all/', 'KelolaDataController@index_all');
Route::get('admin-data/detail_all/{id}', 'KelolaDataController@show_all');
Route::get('admin-data/edit_all/{id}', 'KelolaDataController@edit_all');
Route::post('admin-data/update_all/{id}', 'KelolaDataController@update_all');
Route::get('admin-data/hapus_all/{id}', 'KelolaDataController@destroy_all');
//Fitur Cropping
Route::post('admin-data/upload/{id}','KelolaDataController@upload');
Route::get('admin-data/cropping/{id}','KelolaDataController@cropping');
//Kelola Data Crop
Route::get('admin-data/crop/awal/{id}', 'KelolaDataCropController@awal');
Route::get('admin-data/crop/detail/{id}', 'KelolaDataCropController@show');
Route::get('admin-data/crop/edit/{id}', 'KelolaDataCropController@edit');
Route::post('admin-data/crop/update/{id}', 'KelolaDataCropController@update');
Route::get('admin-data/crop/hapus/{id}', 'KelolaDataCropController@destroy');
//Fitur Cropping ALL
Route::post('admin-data/upload_all/{id}','KelolaDataController@upload_all');
Route::get('admin-data/cropping_all/{id}','KelolaDataController@cropping_all');
//Kelola Data Crop ALL
Route::get('admin-data/crop/awal_all/{id}', 'KelolaDataCropController@awal_all');
Route::get('admin-data/crop/detail_all/{id}', 'KelolaDataCropController@show_all');
Route::get('admin-data/crop/edit_all/{id}', 'KelolaDataCropController@edit_all');
Route::post('admin-data/crop/update_all/{id}', 'KelolaDataCropController@update_all');
Route::get('admin-data/crop/hapus_all/{id}', 'KelolaDataCropController@destroy_all');

//Kelola Data by Public
Route::get('public-data/index/', 'KelolaDataPublicController@index');
Route::get('public-data/create/', 'KelolaDataPublicController@create');
Route::post('public-data/simpan/', 'KelolaDataPublicController@store');
Route::get('public-data/detail/{id}', 'KelolaDataPublicController@show');
Route::get('public-data/edit/{id}', 'KelolaDataPublicController@edit');
Route::post('public-data/update/{id}', 'KelolaDataPublicController@update');
Route::get('public-data/hapus/{id}', 'KelolaDataPublicController@destroy');
//Fitur Cropping
Route::post('public-data/upload/{id}','KelolaDataPublicController@upload');
Route::get('public-data/cropping/{id}','KelolaDataPublicController@cropping');
//Kelola Data Crop
Route::get('public-data/crop/awal/{id}', 'KelolaDataCropPublicController@awal');
Route::get('public-data/crop/edit/{id}', 'KelolaDataCropPublicController@edit');
Route::post('public-data/crop/update/{id}', 'KelolaDataCropPublicController@update');
Route::get('public-data/crop/hapus/{id}', 'KelolaDataCropPublicController@destroy');

//Kelola Data by Ewindo
Route::get('ewindo-data/index/', 'KelolaDataEwindoController@index');
Route::get('ewindo-data/create/', 'KelolaDataEwindoController@create');
Route::post('ewindo-data/simpan/', 'KelolaDataEwindoController@store');
Route::get('ewindo-data/detail/{id}', 'KelolaDataEwindoController@show');
Route::get('ewindo-data/edit/{id}', 'KelolaDataEwindoController@edit');
Route::post('ewindo-data/update/{id}', 'KelolaDataEwindoController@update');
Route::get('ewindo-data/hapus/{id}', 'KelolaDataEwindoController@destroy');
Route::get('ewindo-data/index_all/', 'KelolaDataEwindoController@index_all');
Route::get('ewindo-data/detail_all/{id}', 'KelolaDataEwindoController@show_all');
Route::get('ewindo-data/edit_all/{id}', 'KelolaDataEwindoController@edit_all');
Route::post('ewindo-data/update_all/{id}', 'KelolaDataEwindoController@update_all');
Route::get('ewindo-data/hapus_all/{id}', 'KelolaDataEwindoController@destroy_all');
//Fitur Cropping
Route::post('ewindo-data/upload/{id}','KelolaDataEwindoController@upload');
Route::get('ewindo-data/cropping/{id}','KelolaDataEwindoController@cropping');
//Kelola Data Crop
Route::get('ewindo-data/crop/awal/{id}', 'KelolaDataCropEwindoController@awal');
Route::get('ewindo-data/crop/detail/{id}', 'KelolaDataCropEwindoController@show');
Route::get('ewindo-data/crop/edit/{id}', 'KelolaDataCropEwindoController@edit');
Route::post('ewindo-data/crop/update/{id}', 'KelolaDataCropEwindoController@update');
Route::get('ewindo-data/crop/hapus/{id}', 'KelolaDataCropEwindoController@destroy');
//Fitur Cropping ALL
Route::post('ewindo-data/upload_all/{id}','KelolaDataEwindoController@upload_all');
Route::get('ewindo-data/cropping_all/{id}','KelolaDataEwindoController@cropping_all');
//Kelola Data Crop ALL
Route::get('ewindo-data/crop/awal_all/{id}', 'KelolaDataCropEwindoController@awal_all');
Route::get('ewindo-data/crop/detail_all/{id}', 'KelolaDataCropEwindoController@show_all');
Route::get('ewindo-data/crop/edit_all/{id}', 'KelolaDataCropEwindoController@edit_all');
Route::post('ewindo-data/crop/update_all/{id}', 'KelolaDataCropEwindoController@update_all');
Route::get('ewindo-data/crop/hapus_all/{id}', 'KelolaDataCropEwindoController@destroy_all');

//Kelola Data by Balitsa
Route::get('balitsa-data/index/', 'KelolaDataBalitsaController@index');
Route::get('balitsa-data/create/', 'KelolaDataBalitsaController@create');
Route::post('balitsa-data/simpan/', 'KelolaDataBalitsaController@store');
Route::get('balitsa-data/detail/{id}', 'KelolaDataBalitsaController@show');
Route::get('balitsa-data/edit/{id}', 'KelolaDataBalitsaController@edit');
Route::post('balitsa-data/update/{id}', 'KelolaDataBalitsaController@update');
Route::get('balitsa-data/hapus/{id}', 'KelolaDataBalitsaController@destroy');
Route::get('balitsa-data/index_all/', 'KelolaDataBalitsaController@index_all');
Route::get('balitsa-data/detail_all/{id}', 'KelolaDataBalitsaController@show_all');
Route::get('balitsa-data/edit_all/{id}', 'KelolaDataBalitsaController@edit_all');
Route::post('balitsa-data/update_all/{id}', 'KelolaDataBalitsaController@update_all');
Route::get('balitsa-data/hapus_all/{id}', 'KelolaDataBalitsaController@destroy_all');
//Fitur Cropping
Route::post('balitsa-data/upload/{id}','KelolaDataBalitsaController@upload');
Route::get('balitsa-data/cropping/{id}','KelolaDataBalitsaController@cropping');
//Kelola Data Crop
Route::get('balitsa-data/crop/awal/{id}', 'KelolaDataCropBalitsaController@awal');
Route::get('balitsa-data/crop/detail/{id}', 'KelolaDataCropBalitsaController@show');
Route::get('balitsa-data/crop/edit/{id}', 'KelolaDataCropBalitsaController@edit');
Route::post('balitsa-data/crop/update/{id}', 'KelolaDataCropBalitsaController@update');
Route::get('balitsa-data/crop/hapus/{id}', 'KelolaDataCropBalitsaController@destroy');
//Fitur Cropping ALL
Route::post('balitsa-data/upload_all/{id}','KelolaDataBalitsaController@upload_all');
Route::get('balitsa-data/cropping_all/{id}','KelolaDataBalitsaController@cropping_all');
//Kelola Data Crop ALL
Route::get('balitsa-data/crop/awal_all/{id}', 'KelolaDataCropBalitsaController@awal_all');
Route::get('balitsa-data/crop/detail_all/{id}', 'KelolaDataCropBalitsaController@show_all');
Route::get('balitsa-data/crop/edit_all/{id}', 'KelolaDataCropBalitsaController@edit_all');
Route::post('balitsa-data/crop/update_all/{id}', 'KelolaDataCropBalitsaController@update_all');
Route::get('balitsa-data/crop/hapus_all/{id}', 'KelolaDataCropBalitsaController@destroy_all');

//Kelola Data by ITB
Route::get('itb-data/index/', 'KelolaDataITBController@index');
Route::get('itb-data/create/', 'KelolaDataITBController@create');
Route::post('itb-data/simpan/', 'KelolaDataITBController@store');
Route::get('itb-data/detail/{id}', 'KelolaDataITBController@show');
Route::get('itb-data/edit/{id}', 'KelolaDataITBController@edit');
Route::post('itb-data/update/{id}', 'KelolaDataITBController@update');
Route::get('itb-data/hapus/{id}', 'KelolaDataITBController@destroy');
Route::get('itb-data/index_all/', 'KelolaDataITBController@index_all');
Route::get('itb-data/detail_all/{id}', 'KelolaDataITBController@show_all');
Route::get('itb-data/edit_all/{id}', 'KelolaDataITBController@edit_all');
Route::post('itb-data/update_all/{id}', 'KelolaDataITBController@update_all');
Route::get('itb-data/hapus_all/{id}', 'KelolaDataITBController@destroy_all');
//Fitur Cropping
Route::post('itb-data/upload/{id}','KelolaDataITBController@upload');
Route::get('itb-data/cropping/{id}','KelolaDataITBController@cropping');
//Kelola Data Crop
Route::get('itb-data/crop/awal/{id}', 'KelolaDataCropITBController@awal');
Route::get('itb-data/crop/detail/{id}', 'KelolaDataCropITBController@show');
Route::get('itb-data/crop/edit/{id}', 'KelolaDataCropITBController@edit');
Route::post('itb-data/crop/update/{id}', 'KelolaDataCropITBController@update');
Route::get('itb-data/crop/hapus/{id}', 'KelolaDataCropITBController@destroy');
//Fitur Cropping ALL
Route::post('itb-data/upload_all/{id}','KelolaDataITBController@upload_all');
Route::get('itb-data/cropping_all/{id}','KelolaDataITBController@cropping_all');
//Kelola Data Crop ALL
Route::get('itb-data/crop/awal_all/{id}', 'KelolaDataCropITBController@awal_all');
Route::get('itb-data/crop/detail_all/{id}', 'KelolaDataCropITBController@show_all');
Route::get('itb-data/crop/edit_all/{id}', 'KelolaDataCropITBController@edit_all');
Route::post('itb-data/crop/update_all/{id}', 'KelolaDataCropITBController@update_all');
Route::get('itb-data/crop/hapus_all/{id}', 'KelolaDataCropITBController@destroy_all');
