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
    Route::get('tasks/ordered/filter', ['as' => 'ordered_tasks.filter', 'uses' => 'TasksController@showOrdered']);
    //Route::get('issues/reported', 'IssuesController@showReported');
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        //Route::get('issues/{status?}', 'IssuesController@showAll');
        Route::resource('tags', 'TagsController', ['except'=>['create', 'show']]);
        Route::resource('users', 'UsersController', ['except' => ['show']]);
        Route::get('tasks/filter', ['as' => 'admin.tasks.filter', 'uses' => 'TasksController@filter']);
        Route::get('tasks', ['as' => 'admin.tasks', 'uses' => 'TasksController@filter']);
    });

    //Route::get('tasks/ordered/filter/{status}', 'TasksController@showOrdered');
    //Route::get('issues/reported/filter/{status}', 'IssuesController@showReported');
    //Route::get('tasks/filter/{status}', 'TasksController@index');
    Route::get('tasks/accomplish/{tasks}', 'TasksController@accomplish');
    Route::get('tasks/accept/{tasks}', 'TasksController@accept');
    Route::get('tasks/reject/{tasks}', 'TasksController@reject');
    Route::get('tasks/filter', ['as' => 'my_tasks.filter', 'uses' => 'TasksController@index']);
    Route::resource('tasks', 'TasksController');
    //Route::resource('issues', 'IssuesController');
    Route::resource('comments', 'CommentController', ['only' => [
        'store'
    ]]);
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');