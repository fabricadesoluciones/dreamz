<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* HOME */

Route::get('/', function(){return Redirect::route('home'); } );
Route::get('/home', ['middleware' => 'auth', 'uses' => 'HomeController@index'])->name('home');
Route::get('/users', ['middleware' => 'auth', 'uses' => 'HomeController@users'])->name('users');
Route::get('/companies', ['middleware' => 'auth', 'uses' => 'HomeController@companies'])->name('companies');

/* HOME */

/* API */

Route::group(['middleware' => 'auth','prefix' => 'api/v0.1'], function ()
{
	Route::resource('users', 'UsersController');
	Route::resource('companies', 'CompaniesController');
});

/* API */

/* LOGIN ROUTES */

// Authentication
Route::get('login', 'Auth\AuthController@getLogin')->name('login');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');	

/* LOGIN ROUTES */