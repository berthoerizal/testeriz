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

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('profile', 'ProfileController');
Route::put('/update_password/{id}', ['as' => 'update_password', 'uses' => 'ProfileController@update_password']);
Route::resource('user', 'UserController');
Route::get('/reset_password/{id}', ['as' => 'reset_password', 'uses' => 'UserController@reset_password']);
Route::resource('konfigurasi', 'KonfigurasiController');
Route::resource('galeri', 'GaleriController');
Route::post('/store_jenis', 'GaleriController@store_jenis')->name('store_jenis');
Route::post('/update_jenis/{id}', ['as' => 'update_jenis', 'uses' => 'GaleriController@update_jenis']);
Route::resource('soal', 'SoalController');
Route::get('/download_materi/{id}', ['as' => 'download_materi', 'uses' => 'SoalController@download_materi']);
