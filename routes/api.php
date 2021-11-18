<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/users', [UserController::class, 'index']);
Route::post('/user/store', [UserController::class, 'store']);
Route::put('/user/update/{id}', [UserController::class, 'update']);
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy']);

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/task/store', [TaskController::class, 'store']);
// Route::resource('/user', UserController::class)->except('index');
