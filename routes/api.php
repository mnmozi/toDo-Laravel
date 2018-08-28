<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route :: post('/task', [
    'uses' => 'TaskController@postTask'
]);
Route :: get ('/task',[
    'uses'=> 'TaskController@getTask'
]);
Route :: put ('/task/{id}',[
    'uses' => 'TaskController@putTask'
]);
Route :: put ('/task/checkChange/{id}',[
    'uses' => 'TaskController@checkChangeTask'
]);
Route :: delete ('/task/{id}',[
    'uses' => 'TaskController@deleteTask'
]);

Route:: post ('/user',[
    'uses'=>'UserController@signup'
]);

Route:: post ('/user/signin',[
    'uses'=>'UserController@signin'
]);

Route:: get ('/user/me',[
    'uses'=>'UserController@me'
]);

Route:: get ('/user/logout',[
    'uses'=>'UserController@logout'
]);
