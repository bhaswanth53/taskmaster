<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TimeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TaskController::class)->group(function() {
    Route::get('task/list', 'listTasks');
    Route::post('task/create', 'createTask');
    Route::post('task/status/update', 'updateStatus');
    Route::delete('task/{id}', 'deleteTask');
});

Route::controller(TimeController::class)->group(function() {
    Route::get('time/list', 'listTimes');
    Route::post('time/create', 'addTime');
    Route::post('time/update', 'updateTime');
    Route::delete('time/{id}', 'deleteTime');
});
