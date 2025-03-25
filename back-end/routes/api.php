<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserStatusController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get(
        '/user', 
        [AuthController::class, 'getAuthUser']
    )->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum', 'isAdmin'])->group(function() {
    Route::apiResource('/admin/users', UserController::class);
    Route::put('/admin/users/{user}/role', [UserStatusController::class, 'toggleUserStatus']);
});