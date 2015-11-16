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
Route::get('/companies/{id}/users', ['middleware' => 'auth', 'uses' => 'CompaniesController@users']);
Route::get('/users/{id}/edit', ['middleware' => 'auth', 'uses' => 'UsersController@edit']);

/* HOME */

/* API */

Route::group(['middleware' => 'auth','prefix' => 'api/v1.0'], function ()
{
	Route::get('/companies/{id}/users', ['middleware' => 'auth', 'uses' => 'CompaniesController@users']);
	Route::resource('users', 'UsersController', ['names' => [

'store' => 'users.store',
'index' => 'users.index',
'create' => 'users.create',
'destroy' => 'users.destroy',
'update' => 'users.update',
'show' => 'users.show',
'edit' => 'users.edit',
        
    ]]);
	Route::resource('companies', 'CompaniesController', ['names' => [

'store' => 'companies.store',
'index' => 'companies.index',
'create' => 'companies.create',
'destroy' => 'companies.destroy',
'update' => 'companies.update',
'show' => 'companies.show',
'edit' => 'companies.edit',
        
    ]]);
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

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

/* LOGIN ROUTES */