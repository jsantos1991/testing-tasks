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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // /api/v1
    Route::prefix('tasklists')->group(function () {
        // Tasklists -> /api/v1/tasklists
        Route::get('/', 'TasklistController@all');
        Route::get('/{id}', 'TasklistController@show');
        Route::post('/', 'TasklistController@create');
        Route::put('/{id}', 'TasklistController@update');
        Route::delete('/{id}', 'TasklistController@delete');

        Route::get('/{tasklist}/tasks', 'TasklistController@tasks');
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/{id}', 'TaskController@show');
        Route::post('/', 'TaskController@create');
        Route::put('/{id}', 'TaskController@update');
        Route::delete('/{id}', 'TaskController@delete');
    });
});
