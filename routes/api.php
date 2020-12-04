<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:api')->get('/user', function(Request $request){
    return auth()->user();
});

Route::post('/login','AuthController@login');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

Route::resource('users', 'User\UserController',['except'=>['edit','create']]);
Route::resource('users.jobs', 'User\UserJobController',['except'=>['edit','create','show']]);
Route::resource('users.jobApplications', 'User\UserJobApplicationController',['except'=>['edit','create','show']]);
Route::resource('jobApplications', 'JobApplication\JobApplicationController',['only'=>['index','show']]);


Route::resource('jobs', 'Job\JobController',['only'=>['index','show']]);

Route::post('saveToken/{id}', 'FcmController@saveToken');
Route::delete('deleteToken/{id}', 'FcmController@deleteToken');
Route::get('getAllTokens', 'FcmController@getAllTokens');
Route::get('sendNotification', 'FcmController@sendNotificationToAll');
