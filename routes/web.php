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
            \LogActivity::addToLog('Login ke dalam sistem');
            return view('tanaman.home');
        }elseif(Auth::user()->role=="Public"){
            \LogActivity::addToLog('Login ke dalam sistem');
            return view('tanaman.home');
        }elseif(Auth::user()->role=="Expert ITB"){
            \LogActivity::addToLog('Login ke dalam sistem');
            return view('tanaman.home');
        }elseif(Auth::user()->role=="Expert EWINDO"){
            \LogActivity::addToLog('Login ke dalam sistem');
            return view('tanaman.home');
        }elseif(Auth::user()->role=="Expert BALITSA"){
            \LogActivity::addToLog('Login ke dalam sistem');
            return view('tanaman.home');
        }
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

//Dropdown
Route::get('dropdown/plant-type', 'DropDownController@selectPlantType');
Route::get('dropdown/general-ident/{id}', 'DropDownController@selectGeneralIdent');
Route::get('dropdown/symptom-name/{id}', 'DropDownController@selectSymptomName');

//Kelola Data
Route::get('tanaman-data/index/', 'KelolaDataController@index');
Route::get('tanaman-data/create/', 'KelolaDataController@create');
Route::post('tanaman-data/simpan/', 'KelolaDataController@store');
Route::get('tanaman-data/detail/{id}', 'KelolaDataController@show');
Route::get('tanaman-data/edit/{id}', 'KelolaDataController@edit');
Route::post('tanaman-data/update/{id}', 'KelolaDataController@update');
Route::get('tanaman-data/hapus/{id}', 'KelolaDataController@destroy');
Route::get('tanaman-data/index_all/', 'KelolaDataController@index_all');
Route::get('tanaman-data/detail_all/{id}', 'KelolaDataController@show_all');
Route::get('tanaman-data/edit_all/{id}', 'KelolaDataController@edit_all');
Route::post('tanaman-data/update_all/{id}', 'KelolaDataController@update_all');
Route::get('tanaman-data/hapus_all/{id}', 'KelolaDataController@destroy_all');
Route::post('tanaman-data/reject/{id}', 'KelolaDataController@reject');
//Verifikasi Data
Route::get('tanaman-data/verifikasi/{id}', 'KelolaDataController@verifikasi');
Route::get('tanaman-data/unverifikasi/{id}', 'KelolaDataController@unverifikasi');
//Riwayat Data
Route::get('tanaman-data/riwayat/{id}', 'KelolaDataController@riwayat');
Route::get('tanaman-data/riwayat_all/{id}', 'KelolaDataController@riwayat_all');
//Cari Data
Route::get('tanaman-data/cari/', 'KelolaDataController@caridata');
Route::get('tanaman-data/cari_all/', 'KelolaDataController@caridata_all');

//Fitur Cropping
Route::post('tanaman-data/upload/{id}','KelolaDataController@upload');
Route::get('tanaman-data/cropping/{id}','KelolaDataController@cropping');
//Kelola Data Crop
Route::get('tanaman-data/crop/awal/{id}', 'KelolaDataCropController@awal');
Route::get('tanaman-data/crop/detail/{id}', 'KelolaDataCropController@show');
Route::get('tanaman-data/crop/edit/{id}', 'KelolaDataCropController@edit');
Route::post('tanaman-data/crop/update/{id}', 'KelolaDataCropController@update');
Route::get('tanaman-data/crop/hapus/{id}', 'KelolaDataCropController@destroy');
//Fitur Cropping ALL
Route::post('tanaman-data/upload_all/{id}','KelolaDataController@upload_all');
Route::get('tanaman-data/cropping_all/{id}','KelolaDataController@cropping_all');
//Kelola Data Crop ALL
Route::get('tanaman-data/crop/awal_all/{id}', 'KelolaDataCropController@awal_all');
Route::get('tanaman-data/crop/detail_all/{id}', 'KelolaDataCropController@show_all');
Route::get('tanaman-data/crop/edit_all/{id}', 'KelolaDataCropController@edit_all');
Route::post('tanaman-data/crop/update_all/{id}', 'KelolaDataCropController@update_all');
Route::get('tanaman-data/crop/hapus_all/{id}', 'KelolaDataCropController@destroy_all');


//Kelola User
Route::get('admin/user/index/', 'UserController@index');
Route::get('admin/user/create/', 'UserController@create');
Route::post('admin/user/simpan/', 'UserController@store');
Route::get('admin/user/detail/{id}', 'UserController@show');
Route::get('admin/user/edit/{id}', 'UserController@edit');
Route::post('admin/user/update/{id}', 'UserController@update');
Route::get('admin/user/hapus/{id}', 'UserController@destroy');
//Log Activity
Route::get('admin/log_activity/index/', 'UserController@log_activity');

//Kelola Profile
Route::get('profile/index/', 'UserController@profile');
Route::get('profile/edit/{id}', 'UserController@edit_profile');
Route::post('profile/update/{id}', 'UserController@ubah_profile');
Route::get('profile/edit_login/{id}', 'UserController@edit_login');
Route::post('profile/update_login/{id}', 'UserController@ubah_login');

