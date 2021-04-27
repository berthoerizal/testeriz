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
