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
    Route::get('tasks/supported', 'TasksController@showSupported');
    Route::get('tasks/ordered/filter', ['as' => 'ordered_tasks.filter', 'uses' => 'TasksController@showOrdered']);
    //Route::get('issues/reported', 'IssuesController@showReported');
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        //Route::get('issues/{status?}', 'IssuesController@showAll');
        Route::resource('tags', 'TagsController', ['except'=>['create', 'show']]);
        Route::resource('users', 'UsersController', ['except' => ['show', 'destroy']]);
        Route::put('users/{users}/change_status', ['as' => 'admin.users.change_status', 'uses' => 
            'UsersController@changeStatus']);
        Route::patch('users/{users}/reset_password', ['as' => 'admin.users.reset_password', 'uses' => 'UsersController@resetPassword']);
        Route::get('tasks/filter', ['as' => 'admin.tasks.filter', 'uses' => 'TasksController@filter']);
        Route::get('tasks', ['as' => 'admin.tasks', 'uses' => 'TasksController@filter']);
        Route::get('comments/{comments}/{tasks}/edit', 'TasksController@editComment');
        Route::patch('comments/{comments}', 'TasksController@updateComment');
    });

    //Route::get('tasks/ordered/filter/{status}', 'TasksController@showOrdered');
    //Route::get('issues/reported/filter/{status}', 'IssuesController@showReported');
    //Route::get('tasks/filter/{status}', 'TasksController@index');
    
    Route::get('tasks/accomplish/{tasks}/{users}', 'TasksController@accomplish');
    Route::get('tasks/accept/{tasks}/{users}', 'TasksController@accept');
    Route::get('tasks/reject/{tasks}/{users}', 'TasksController@reject');
    Route::get('tasks/filter', ['as' => 'my_tasks.filter', 'uses' => 'TasksController@index']);
    Route::get('tasks/supported/filter', ['as' => 'my_supported_tasks.filter', 'uses' => 'TasksController@showSupported']);
    Route::get('tasks/filter/reset', ['as' => 'reset_filter', 'uses' => 'TasksController@resetFilter']);
    Route::delete('tasks/{tasks}/{users}', 'TasksController@destroy');
    Route::resource('tasks', 'TasksController');
    //Route::resource('issues', 'IssuesController');
    Route::resource('comments', 'CommentController', ['only' => [
        'store'
    ]]);
    Route::get('download/{$file}', 'FileController@download');
    Route::get('users/settings', 'UsersController@showSettings');
    Route::get('users/edit/password', 'UsersController@editPassword');
    Route::patch('users/edit/password', 'UsersController@updatePassword');
    Route::get('users/edit/notifications', 'UsersController@editNotifications');
    Route::patch('users/edit/notifications', 'UsersController@updateNotifications');
    Route::get('users/change/photo', 'UsersController@changePhoto');
    Route::post('users/change/photo', 'UsersController@uploadPhoto');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');