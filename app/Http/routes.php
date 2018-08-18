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
Route::auth();

Route::get('/', function () {
    if(\Illuminate\Support\Facades\Auth::id()){
        return redirect('/project');
    }else{
        return redirect('/login');
    }
});

Route::resource('project', 'ProjectController', ['only' => ['index', 'create', 'store', 'destroy']]);
Route::resource('event', 'EventController', ['except' => ['index']]);
Route::get('event/{event}/delete-cause', ['as' => 'event.delete-cause', 'uses' => 'EventController@deleteCause']);
Route::get('event/{event}/finish', ['as' => 'event.finish', 'uses' => 'EventController@finish']);