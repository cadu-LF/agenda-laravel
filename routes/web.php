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

// Login Routes
Route::resource('/login', 'LoginController');

Auth::routes();
// Contacts Routes
Route::resource('/contatos', 'ContactController')->middleware('auth');
#Route::get('/home', 'HomeController@index')->name('home');
