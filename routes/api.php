<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CallLogController;
use App\Http\Controllers\Api\CallJobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('sms')->group(function () {
    Route::post('/register', [App\Http\Controllers\Api\SmsController::class, 'register']);
    Route::post('/status-update', [App\Http\Controllers\Api\SmsController::class, 'statusUpdate']);
});

Route::post('/calls/log', [CallLogController::class, 'log']);
Route::apiResource('call-logs', CallLogController::class);

Route::post('/call-jobs', [CallJobController::class, 'store']);
Route::get('/call-jobs/next', [CallJobController::class, 'getNext']);
Route::post('/call-jobs/{id}/status', [CallJobController::class, 'updateStatus']);

// Mobile Auth
Route::post('/mobile/login', [App\Http\Controllers\Api\Mobile\AuthController::class, 'login']);

// Mobile PRO Group
Route::middleware('auth:sanctum')->prefix('mobile')->group(function () {
    Route::apiResource('sms-templates', \App\Http\Controllers\Api\Mobile\SmsTemplateController::class);
    Route::post('/logout', [App\Http\Controllers\Api\Mobile\AuthController::class, 'logout']);
    Route::get('/dashboard', [App\Http\Controllers\Api\Mobile\MobileDashboardController::class, 'dashboard']);

    // Domain Resources (Auto-added by make:mobile-pro)
    Route::apiResource('body-types', \App\Http\Controllers\Api\Mobile\BodyTypeController::class);
    Route::apiResource('cars', \App\Http\Controllers\Api\Mobile\CarController::class);
    Route::apiResource('clients', \App\Http\Controllers\Api\Mobile\ClientController::class);
    Route::apiResource('expenses', \App\Http\Controllers\Api\Mobile\ExpenseController::class);
    Route::apiResource('jobs', \App\Http\Controllers\Api\Mobile\JobController::class);
    Route::apiResource('job-requests', \App\Http\Controllers\Api\Mobile\JobRequestController::class);
    Route::apiResource('materials', \App\Http\Controllers\Api\Mobile\MaterialController::class);
    Route::apiResource('material-brands', \App\Http\Controllers\Api\Mobile\MaterialBrandController::class);
    Route::apiResource('parts', \App\Http\Controllers\Api\Mobile\PartController::class);
    Route::apiResource('payments', \App\Http\Controllers\Api\Mobile\PaymentController::class);
    Route::apiResource('purchases', \App\Http\Controllers\Api\Mobile\PurchaseController::class);
    Route::apiResource('services', \App\Http\Controllers\Api\Mobile\ServiceController::class);
    Route::apiResource('suppliers', \App\Http\Controllers\Api\Mobile\SupplierController::class);
    Route::apiResource('vehicle-brands', \App\Http\Controllers\Api\Mobile\VehicleBrandController::class);
    Route::apiResource('vehicle-models', \App\Http\Controllers\Api\Mobile\VehicleModelController::class);
});
