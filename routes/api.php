<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Routes group for user guests only
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('license/verify', [LicenseController::class, 'verify']);

Route::middleware(['auth:sanctum'])->group(function () {


    Route::apiResource('license', LicenseController::class);

    Route::get('user', [ProfileController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});
