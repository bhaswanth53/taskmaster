<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TimeController;
use App\Http\Controllers\Api\NoteController;

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
    Route::post('task/list', 'listTasks');
    Route::post('task/create', 'createTask');
    Route::post('task/status/update', 'updateStatus');
    Route::delete('task/{id}', 'deleteTask');
    Route::delete('task/{id}/move', 'moveTask');
});

Route::controller(TimeController::class)->group(function() {
    Route::post('time/list', 'listTimes');
    Route::post('time/create', 'addTime');
    Route::post('time/update', 'updateTime');
    Route::delete('time/{id}', 'deleteTime');
    Route::delete('time/{id}/move', 'moveTime');
});

Route::controller(NoteController::class)->group(function() {
    Route::post('note/list', 'listNotes');
    Route::post('note/create', 'createNote');
    Route::get('note/view/{id}', 'viewContent');
    Route::post('note/update/{id}', 'updateNote');
    Route::delete('note/{id}', 'deleteNote');
    Route::delete('note/{id}/move', 'moveNote');
});
