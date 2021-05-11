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

Route::resource('home', 'HomeController');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('profile', 'ProfileController');
Route::put('/update_password/{id}', ['as' => 'update_password', 'uses' => 'ProfileController@update_password']);
Route::resource('user', 'UserController');
Route::get('/reset_password/{id}', ['as' => 'reset_password', 'uses' => 'UserController@reset_password']);
Route::resource('konfigurasi', 'KonfigurasiController');
Route::resource('soal', 'SoalController');
Route::get('/download_materi/{id}', ['as' => 'download_materi', 'uses' => 'SoalController@download_materi']);
Route::resource('tanya', 'TanyaController');
Route::resource('ujian', 'UjianController');
Route::post('/daftar_ujian', 'UjianController@daftar_ujian')->name('daftar_ujian');
Route::get('/tunggu_ujian/{id}', ['as' => 'tunggu_ujian', 'uses' => 'UjianController@tunggu_ujian']);
Route::get('/jawab_ujian/{id}', ['as' => 'jawab_ujian', 'uses' => 'UjianController@jawab_ujian']);
Route::put('soal/{id_soal}/tanya/{id_tanya}', ['as' => 'user_jawab_ujian', 'uses' => 'UjianController@user_jawab_ujian']);
Route::get('soal/{id_soal}/selesai_ujian', ['as' => 'selesai_ujian', 'uses' => 'UjianController@selesai_ujian']);
Route::get('/nilai_peserta/{id}', ['as' => 'nilai_peserta', 'uses' => 'NilaiController@nilai_peserta']);
Route::get('soal/{id_soal}/peserta/{id_user}/detail_nilai', ['as' => 'detail_nilai', 'uses' => 'NilaiController@detail_nilai']);

Route::get('/status_nilai/{id}', ['as' => 'status_nilai', 'uses' => 'NilaiController@status_nilai']);
