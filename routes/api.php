<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BloodSampleController;
use App\Http\Controllers\BloodRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Blood Sample routes
    Route::get('/blood-samples', [BloodSampleController::class, 'index']);
    Route::post('/blood-samples', [BloodSampleController::class, 'store']);
    Route::put('/blood-samples/{bloodSample}', [BloodSampleController::class, 'update']);
    Route::delete('/blood-samples/{bloodSample}', [BloodSampleController::class, 'destroy']);
    
    // Blood Request routes
    Route::get('/blood-requests/hospital', [BloodRequestController::class, 'index']);
    Route::post('/blood-requests', [BloodRequestController::class, 'store']);
    Route::patch('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'update']);
});