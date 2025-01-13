<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Public accessible API
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated only API
// We use auth api here as a middleware so only authenticated user who can access the endpoint
// We use group so we can apply middleware auth api to all the routes within the group
Route::middleware('auth:api')->group(function() {
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


//Route::middleware('auth.token')->get('/me', function (Request $request) {
//    return $request->user();
//});
//
//Route::controller(AuthController::class)->group(function ($router) {
//    Route::post('login', 'login')->name('login');
//    Route::post('logout', 'logout')->name('logout')->middleware('auth.token');
//    Route::post('refresh', 'refresh')->name('refresh');
//});
