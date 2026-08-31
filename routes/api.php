<?php

declare(strict_types=1);

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

use App\Http\Controllers\Api\CallLogController;
use App\Http\Controllers\Api\CallJobController;
use Illuminate\Support\Facades\Route;

Route::prefix('sms')->group(function () {
    Route::post('/register', [SmsController::class, 'register']);
    Route::post('/status-update', [SmsController::class, 'statusUpdate']);
});

Route::post('/calls/log', [CallLogController::class, 'log']);
Route::apiResource('call-logs', CallLogController::class);

Route::post('/call-jobs', [CallJobController::class, 'store']);
Route::get('/call-jobs/next', [CallJobController::class, 'getNext']);
Route::post('/call-jobs/{id}/status', [CallJobController::class, 'updateStatus']);
