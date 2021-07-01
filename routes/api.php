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
Route::post('/AddTask', [App\Http\Controllers\TasksController::class, 'store'])->name('AddTask');
Route::get('/tasks', [App\Http\Controllers\TasksController::class, 'create'])->name('Tasks');
Route::delete('task/{id}', [App\Http\Controllers\TasksController::class,'destroy'])->name('DeleteTasks');
Route::put('/task', [App\Http\Controllers\TasksController::class, 'store'])->name('EditTask');;

