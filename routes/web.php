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

use App\Mail\Welcome;

Route::resource('/login', 'LoginController');

Auth::routes();
// Contacts Routes
Route::resource('/contatos', 'ContactController')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/export/pdf', 'ContactController@mostraPdf')->middleware('auth')->name('contatos.pdf');
Route::get('/export/excel', 'ContactController@downExcel')->middleware('auth')->name('contatos.excel');

Route::get('/import/contacts', 'PeopleApiController@import')->middleware('auth')->name('import.contacts');
Route::get('/import', 'PeopleApiController@importCode')->middleware('auth');

Route::get('/', 'WelcomeController@index');

Route::get('/email', function () {
    return new Welcome();
});

Route::post('/autocomplete', 'AutocompleteController@autocomplete')->middleware('auth')->name('autocomplete');
