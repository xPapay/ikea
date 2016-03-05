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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'DashboardController@index');
    Route::get('tasks/ordered', 'TasksController@showOrdered');
    Route::get('issues/reported', 'IssuesController@showReported');
    Route::group(['prefix' => 'admin'], function () {
        Route::get('tasks/{status?}', 'TasksController@showAll');
        Route::get('issues/{status?}', 'IssuesController@showAll');
    });

    Route::get('tasks/ordered/filter/{status}', 'TasksController@showOrdered');
    Route::get('issues/reported/filter/{status}', 'IssuesController@showReported');
    Route::get('tasks/filter/{status}', 'TasksController@index');
    Route::get('tasks/accomplish/{tasks}', 'TasksController@accomplish');
    Route::get('tasks/accept/{tasks}', 'TasksController@accept');
    Route::get('tasks/reject/{tasks}', 'TasksController@reject');
    Route::resource('tasks', 'TasksController');
    Route::resource('issues', 'IssuesController');
    Route::resource('comments', 'CommentController', ['only' => [
        'store'
    ]]);
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');