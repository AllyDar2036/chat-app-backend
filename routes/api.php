<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(UserController::class)->group(function(){
    Route::post('/login', 'login');
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(ChatController::class)->group(function(){
        Route::get('/chats', 'index');
        Route::post('/chats', 'store');
    });
    Route::controller(UserController::class)->group(function(){
        Route::post('/users', 'store');
        Route::get('/users', 'index');
        Route::get('/user/{id}', 'getUser');
    });
});

