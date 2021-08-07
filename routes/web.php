<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::namespace('App\Http\Controllers')->group(function(){


Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['localeSessionRedirect', 'localizationRedirect']],function () {


    Auth::routes([ 'register' => false]);
    Route::get('/logout','Auth\LoginController@logout');
    Route::resource('reset/athlete-password','AthletesPasswordController');

    Route::resource('reset/user-password', 'BackendPasswordController');


    Route::group(['middleware' => ['auth']], function () {
        Route::get('/','DashboardController@index');
        Route::resource('routines', 'RoutinesController');
        Route::get('routines/{id}/workouts','RoutinesController@workouts');
        Route::patch('routines/{id}/workouts/assign','RoutinesController@assign');
        Route::patch('routines/{id}/workouts/unassign','RoutinesController@unassign');
        Route::patch('routines/{id}/workouts/update_assigned','RoutinesController@update_assigned_workout');
        //Route::resource('routines.workouts', 'RoutineWorkoutsController');
        Route::resource('workouts', 'WorkoutsController');

        Route::get('profile', 'ProfileController@show');
        Route::get('profile/edit', 'ProfileController@edit');
        Route::patch('profile', 'ProfileController@update');

        Route::resource('offices', 'OfficesController',
            ['except' => ['edit', 'update', 'destroy']]);
        Route::patch('offices/{id}/activate', 'OfficesController@activate');
        Route::patch('offices/{id}/deactivate', 'OfficesController@deactivate');

        Route::get('office', 'UserOfficeController@show');
        Route::get('office/edit', 'UserOfficeController@edit');
        Route::patch('office', 'UserOfficeController@update');

        Route::resource('therapists', 'TherapistsController',
            ['except' => ['edit', 'update', 'destroy']]);
        Route::patch('therapists/{id}/activate', 'TherapistsController@activate');
        Route::patch('therapists/{id}/deactivate', 'TherapistsController@deactivate');

        Route::get('athletes/{id}', 'AthletesController@show');
        Route::get('athletes', 'AthletesController@create');
        Route::post('athletes', 'AthletesController@store');
        Route::patch('athletes/{id}/activate', 'AthletesController@activate');
        Route::patch('athletes/{id}/deactivate', 'AthletesController@deactivate');
        Route::get('athletes/{id}/record', 'HealthRecordController@show');
        Route::resource('athletes/{id}/record/entries', 'HealthRecordEntryController', ['except' => [ 'index' ]]);
        //Route::patch('athletes/{id}/assign','RoutineAssignmentController@assign' );

        Route::get('athletes/{id}/routine_assignments','AthletesController@routines' );
        Route::patch('athletes/{id}/routine_assignments/assign','AthletesController@assign_routine' );
        Route::patch('athletes/{id}/routine_assignments/unassign','AthletesController@unassign_routine' );
        Route::patch('athletes/{id}/routine_assignments/update_assigned','AthletesController@update_assigned_routine' );

        Route::patch('groups/{id}/assign_group','RoutineAssignmentController@assign_group' );

        Route::resource('groups', 'AthleteGroupsController', ['except' => [ 'index' ]]);
        Route::get('groups/{id}/athletes','AthleteGroupsController@athletes' );
        Route::patch('groups/{id}/athletes/assign','AthleteGroupsController@assign_athlete' );
        Route::patch('groups/{id}/athletes/unassign','AthleteGroupsController@unassign_athlete' );
        Route::get('groups/{id}/routine_assignments','AthleteGroupsController@routines' );
        Route::patch('groups/{id}/routine_assignments/assign','AthleteGroupsController@assign_routine' );
        Route::patch('groups/{id}/routine_assignments/unassign','AthleteGroupsController@unassign_routine' );
        Route::patch('groups/{id}/routine_assignments/update_assigned','AthleteGroupsController@update_assigned_routine' );

        Route::get('athletes-groups', 'AthletesGroupsOverviewController@index');


    });




    // athletes reset password


});



Route::group([ 'middleware' => 'cors' ], function () {
    Route::post('login', 'JwtAuthController@login');
    Route::post('logout', ['middleware' => 'jwt.auth:jwt', 'uses' =>'JwtAuthController@logout']);

    // TODO: catch token exception in a handler
// TODO: 'throttle:60,1'

    Route::group(['prefix' => 'api'],
        function () {


            // password reset
            Route::post('forgot-password','ApiController@forgotPassword');
            ROute::post('password/recovery','ApiController@submitRecoveryCode');


            Route::group(['middleware' => ['jwt-refresh:jwt']],function(){

            Route::get('user', 'ApiController@user');
            Route::get('routines', 'ApiController@routines');
            Route::get('statistics', 'ApiController@statistics');
            Route::post('events','ApiController@setWorkoutUserEvent');
            Route::get('tenantLogo', 'ApiController@tenantLogo');
            Route::get('video/{name}', 'ApiController@video');
        }

    );
});
});
});


Route::get('/test/email','App\Http\Controllers\TestController@testMail');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
