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
Route::get('/forbidden', ['middleware' => 'auth', 'uses' => 'HomeController@returnForbidden'])->name('forbidden');
Route::get('/users', ['middleware' => 'auth', 'uses' => 'HomeController@users'])->name('users');
Route::get('/other_users', ['middleware' => 'auth', 'uses' => 'UsersController@otherUsers'])->name('other_users');
Route::get('/users/create', ['middleware' => 'auth', 'uses' => 'UsersController@create']);
Route::get('/companies/create', ['middleware' => 'auth', 'uses' => 'CompaniesController@create']);
Route::get('/departments/create', ['middleware' => 'auth', 'uses' => 'DepartmentsController@create']);
Route::get('/priorities/create', ['middleware' => 'auth', 'uses' => 'PrioritiesController@create']);
Route::get('/periods/create', ['middleware' => 'auth', 'uses' => 'PeriodsController@create']);
Route::get('/positions/create', ['middleware' => 'auth', 'uses' => 'PositionsController@create']);
Route::get('/objectives/create', ['middleware' => 'auth', 'uses' => 'ObjectivesController@create']);
Route::get('/education/create', ['middleware' => 'auth', 'uses' => 'EducationLevelController@create']);
Route::get('/measuring_units/create', ['middleware' => 'auth', 'uses' => 'MeasuringUnitController@create']);
Route::get('/tasks/create', ['middleware' => 'auth', 'uses' => 'TasksController@create']);
Route::get('/dreams/create', ['middleware' => 'auth', 'uses' => 'DreamsController@create']);
Route::get('/coaches/create', ['middleware' => 'auth', 'uses' => 'UsersController@createCoach']);
Route::get('/assessments/create', ['middleware' => 'auth', 'uses' => 'AssessmentsController@create']);
Route::get('/virtues/create', ['middleware' => 'auth', 'uses' => 'VirtuesController@create']);

Route::get('/companies', ['middleware' => 'auth', 'uses' => 'HomeController@companies'])->name('companies');
Route::get('/departments', ['middleware' => 'auth', 'uses' => 'HomeController@departments'])->name('departments');
Route::get('/positions', ['middleware' => 'auth', 'uses' => 'HomeController@positions'])->name('positions');
Route::get('/priorities', ['middleware' => 'auth', 'uses' => 'HomeController@priorities'])->name('priorities');
Route::get('/periods', ['middleware' => 'auth', 'uses' => 'HomeController@periods'])->name('periods');
Route::get('/tasks', ['middleware' => 'auth', 'uses' => 'HomeController@tasks'])->name('tasks');
Route::get('/objectives', ['middleware' => 'auth', 'uses' => 'HomeController@objectives'])->name('objectives');
Route::get('/emotions', ['middleware' => 'auth', 'uses' => 'HomeController@emotions'])->name('emotions');
Route::get('/education', ['middleware' => 'auth', 'uses' => 'HomeController@education'])->name('education_levels');
Route::get('/measuring_units', ['middleware' => 'auth', 'uses' => 'HomeController@measuring_units'])->name('measuring_units');
Route::get('/dreams', ['middleware' => 'auth', 'uses' => 'HomeController@dreams'])->name('dreams');
Route::get('/coaches', ['middleware' => 'auth', 'uses' => 'HomeController@coaches'])->name('coaches');
Route::get('/assessments', ['middleware' => 'auth', 'uses' => 'HomeController@assessments'])->name('assessments');
Route::get('/virtues', ['middleware' => 'auth', 'uses' => 'HomeController@virtues'])->name('virtues');

Route::get('/companies/{id}/users', ['middleware' => 'auth', 'uses' => 'CompaniesController@users']);
Route::get('/set_company/{id}', ['middleware' => 'auth', 'uses' => 'HomeController@setCompany']);
Route::get('/set_department/{id}', ['middleware' => 'auth', 'uses' => 'HomeController@setDepartment']);
Route::get('/set_feeling/{id}', ['middleware' => 'auth', 'uses' => 'HomeController@setFeeling']);
Route::get('/set_lang/{id}', ['middleware' => 'auth', 'uses' => 'HomeController@setLang']);
Route::get('/get_objective_summary_department/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@getDepartmentSummary']);
Route::get('/get_objective_summary_subordinate/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@getSubordinateSummary']);
Route::get('/get_objective_summary_company', ['middleware' => 'auth', 'uses' => 'ObjectivesController@getCompanySummary']);
Route::get('/get_priority_summary_department/{id}', ['middleware' => 'auth', 'uses' => 'PrioritiesController@getDepartmentSummary']);
Route::get('/get_priority_summary_subordinate/{id}', ['middleware' => 'auth', 'uses' => 'PrioritiesController@getSubordinateSummary']);
Route::get('/get_priority_summary_company', ['middleware' => 'auth', 'uses' => 'PrioritiesController@getCompanySummary']);
Route::get('/get_emotion_summary_department/{id}', ['middleware' => 'auth', 'uses' => 'EmotionsController@getDepartmentSummary']);
Route::get('/get_emotion_summary_subordinate/{id}', ['middleware' => 'auth', 'uses' => 'EmotionsController@getSubordinateSummary']);
Route::get('/get_emotion_summary_company', ['middleware' => 'auth', 'uses' => 'EmotionsController@getCompanySummary']);
Route::get('/get_objective_summary/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@getObjectiveSummary']);
Route::get('/companies/{id}/departments', ['middleware' => 'auth', 'uses' => 'CompaniesController@departments']);
Route::get('/companies/{id}/positions', ['middleware' => 'auth', 'uses' => 'CompaniesController@positions']);
Route::get('/users/{id}/edit', ['middleware' => 'auth', 'uses' => 'UsersController@edit']);
Route::get('/companies/{id}/edit', ['middleware' => 'auth', 'uses' => 'CompaniesController@edit']);
Route::get('/departments/{id}/edit', ['middleware' => 'auth', 'uses' => 'DepartmentsController@edit']);
Route::get('/positions/{id}/edit', ['middleware' => 'auth', 'uses' => 'PositionsController@edit']);
Route::get('/priorities/{id}/edit', ['middleware' => 'auth', 'uses' => 'PrioritiesController@edit']);
Route::get('/periods/{id}/edit', ['middleware' => 'auth', 'uses' => 'PeriodsController@edit']);
Route::get('/objectives/{id}/edit', ['middleware' => 'auth', 'uses' => 'ObjectivesController@edit']);
Route::get('/education/{id}/edit', ['middleware' => 'auth', 'uses' => 'EducationLevelController@edit']);
Route::get('/measuring_units/{id}/edit', ['middleware' => 'auth', 'uses' => 'MeasuringUnitController@edit']);
Route::get('/tasks/{id}/edit', ['middleware' => 'auth', 'uses' => 'TasksController@edit']);
Route::get('/dreams/{id}/edit', ['middleware' => 'auth', 'uses' => 'DreamsController@edit']);
Route::get('/coaches/{id}/edit', ['middleware' => 'auth', 'uses' => 'UsersController@editcoach']);
Route::get('/priorities/team', ['middleware' => 'auth', 'uses' => 'PrioritiesController@team'])->name('priorities.team');

Route::get('/objective_category/create', ['middleware' => 'auth', 'uses' => 'ObjectivesController@createCategory']);
Route::get('/objective_subcategory/create', ['middleware' => 'auth', 'uses' => 'ObjectivesController@createSubcategory']);
Route::get('/dream_category/create', ['middleware' => 'auth', 'uses' => 'DreamsController@createCategory']);
Route::get('/dream_subcategory/create', ['middleware' => 'auth', 'uses' => 'DreamsController@createSubcategory']);

Route::get('/objectives/progress', ['middleware' => 'auth', 'uses' => 'ObjectivesController@progress'])->name('objectives.progress');
Route::get('/objectives/progress/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@addProgress'])->name('objectives.addprogress');
Route::get('/objectives/myobjectives', ['middleware' => 'auth', 'uses' => 'ObjectivesController@onlymine'])->name('objectives.onlymine');
Route::post('/objectives/progress/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@updateProgress'])->name('objectives.update_objective_progress');

Route::get('/get_subcategories/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@get_subcategories'])->name('objectives.get_subcategories');
Route::get('/get_dream_subcategories/{id}', ['middleware' => 'auth', 'uses' => 'DreamsController@get_dream_subcategories'])->name('objectives.get_dream_subcategories');

Route::post('/set_feeling_enabled/{id}', ['middleware' => 'auth', 'uses' => 'HomeController@setFeelingEnabled']);
Route::post('/update_coach/{id}', ['middleware' => 'auth', 'uses' => 'UsersController@updateCoach'])->name('update_coach');
Route::post('/store_coach/{id}', ['middleware' => 'auth', 'uses' => 'UsersController@storeCoach'])->name('store_coach');
Route::post('/store_objective_category/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@storeCategory'])->name('store_objective_category');
Route::post('/store_objective_subcategory/{id}', ['middleware' => 'auth', 'uses' => 'ObjectivesController@storeSubcategory'])->name('store_objective_subcategory');
Route::post('/store_dream_category/{id}', ['middleware' => 'auth', 'uses' => 'DreamsController@storeCategory'])->name('store_dream_category');
Route::post('/store_dream_subcategory/{id}', ['middleware' => 'auth', 'uses' => 'DreamsController@storeSubcategory'])->name('store_dream_subcategory');

Route::get('/set_user/{id}', ['middleware' => 'auth', 'uses' => 'UsersController@setUser'])->name('users.set_user');
Route::get('/login_original', ['middleware' => 'auth', 'uses' => 'UsersController@loginOriginal'])->name('users.login_original');

Route::get('/save', ['middleware' => 'auth', 'uses' => 'UsersController@save'])->name('users.save');

Route::get('/download/{id}', ['middleware' => 'auth', 'uses' => 'FileController@downloadFile'])->name('download');

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

    Route::resource('departments', 'DepartmentsController', ['names' => [

'store' => 'departments.store',
'index' => 'departments.index',
'create' => 'departments.create',
'destroy' => 'departments.destroy',
'update' => 'departments.update',
'show' => 'departments.show',
'edit' => 'departments.edit',
        
    ]]);

	Route::resource('positions', 'PositionsController', ['names' => [

'store' => 'positions.store',
'index' => 'positions.index',
'create' => 'positions.create',
'destroy' => 'positions.destroy',
'update' => 'positions.update',
'show' => 'positions.show',
'edit' => 'positions.edit',
        
    ]]);

    Route::resource('priorities', 'PrioritiesController', ['names' => [

'store' => 'priorities.store',
'index' => 'priorities.index',
'create' => 'priorities.create',
'destroy' => 'priorities.destroy',
'update' => 'priorities.update',
'show' => 'priorities.show',
'edit' => 'priorities.edit',
        
    ]]);

    Route::resource('periods', 'PeriodsController', ['names' => [

'store' => 'periods.store',
'index' => 'periods.index',
'create' => 'periods.create',
'destroy' => 'periods.destroy',
'update' => 'periods.update',
'show' => 'periods.show',
'edit' => 'periods.edit',
        
    ]]);

    Route::resource('objectives', 'ObjectivesController', ['names' => [

'store' => 'objectives.store',
'index' => 'objectives.index',
'create' => 'objectives.create',
'destroy' => 'objectives.destroy',
'update' => 'objectives.update',
'show' => 'objectives.show',
'edit' => 'objectives.edit',
        
    ]]);

    Route::resource('education_level', 'EducationLevelController', ['names' => [

'store' => 'education_level.store',
'index' => 'education_level.index',
'create' => 'education_level.create',
'destroy' => 'education_level.destroy',
'update' => 'education_level.update',
'show' => 'education_level.show',
'edit' => 'education_level.edit',
        
    ]]);

    Route::resource('measuring_unit', 'MeasuringUnitController', ['names' => [

'store' => 'measuring_unit.store',
'index' => 'measuring_unit.index',
'create' => 'measuring_unit.create',
'destroy' => 'measuring_unit.destroy',
'update' => 'measuring_unit.update',
'show' => 'measuring_unit.show',
'edit' => 'measuring_unit.edit',
        
    ]]);

    Route::resource('emotion', 'EmotionsController', ['names' => [

'store' => 'emotion.store',
'index' => 'emotion.index',
'create' => 'emotion.create',
'destroy' => 'emotion.destroy',
'update' => 'emotion.update',
'show' => 'emotion.show',
'edit' => 'emotion.edit',
        
    ]]);

    Route::resource('task', 'TasksController', ['names' => [

'store' => 'task.store',
'index' => 'task.index',
'create' => 'task.create',
'destroy' => 'task.destroy',
'update' => 'task.update',
'show' => 'task.show',
'edit' => 'task.edit',
        
    ]]);

    Route::resource('dreams', 'DreamsController', ['names' => [

'store' => 'dreams.store',
'index' => 'dreams.index',
'create' => 'dreams.create',
'destroy' => 'dreams.destroy',
'update' => 'dreams.update',
'show' => 'dreams.show',
'edit' => 'dreams.edit',
        
    ]]);

    Route::resource('assessments', 'AssessmentsController', ['names' => [

'store' => 'assessments.store',
'index' => 'assessments.index',
'create' => 'assessments.create',
'destroy' => 'assessments.destroy',
'update' => 'assessments.update',
'show' => 'assessments.show',
'edit' => 'assessments.edit',
        
    ]]);

    Route::resource('files', 'FileController', ['names' => [

'store' => 'files.store',
'index' => 'files.index',
'create' => 'files.create',
'destroy' => 'files.destroy',
'update' => 'files.update',
'show' => 'files.show',
'edit' => 'files.edit',
        
    ]]);

    Route::resource('virtues', 'VirtuesController', ['names' => [

'store' => 'virtues.store',
'index' => 'virtues.index',
'create' => 'virtues.create',
'destroy' => 'virtues.destroy',
'update' => 'virtues.update',
'show' => 'virtues.show',
'edit' => 'virtues.edit',
        
    ]]);



    /* API ROUTES END */
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
Route::post('password/email', 'Auth\PasswordController@postEmail')->name('password.email');

// Password reset
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

/* LOGIN ROUTES */



// ARTISAN

Route::get('/regenerate', function () {
    $exitCode = Artisan::call('db:seed', []);
    return redirect('/logout');

    //
});

