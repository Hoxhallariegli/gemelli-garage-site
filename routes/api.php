<?php

declare(strict_types=1);

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

// WhatsApp Gateway Cloud Session Persistence & Webhook Endpoints
Route::middleware(['throttle:120,1'])->group(function () {
    Route::post('whatsapp-cloud-sessions/save', [\App\Http\Controllers\Api\WhatsappSessionCloudController::class, 'saveSession']);
    Route::get('whatsapp-cloud-sessions/load', [\App\Http\Controllers\Api\WhatsappSessionCloudController::class, 'loadSessions']);
    Route::post('whatsapp-cloud-sessions/delete', [\App\Http\Controllers\Api\WhatsappSessionCloudController::class, 'deleteSession']);
    Route::post('whatsapp-cloud-sessions/webhook', [\App\Http\Controllers\Api\WhatsappWebhookController::class, 'handle']);
    Route::post('whatsapp/webhook', [\App\Http\Controllers\Api\WhatsappWebhookController::class, 'handle']);
});

// Mobile Auth & Device Token Registration
Route::post('/mobile/login', [App\Http\Controllers\Api\Mobile\AuthController::class, 'login']);
Route::post('/mobile/device-tokens/save-web-token', [App\Http\Controllers\Api\Mobile\DeviceTokenController::class, 'saveWebToken']);
Route::post('/mobile/device-tokens/set-primary-gateway', [App\Http\Controllers\Api\Mobile\DeviceTokenController::class, 'setPrimaryGateway']);

// Mobile PRO Group
Route::middleware('auth:sanctum')->prefix('mobile')->group(function () {
    Route::post('/device-tokens/save-token', [App\Http\Controllers\Api\Mobile\DeviceTokenController::class, 'saveWebToken']);
    Route::post('/device-tokens/set-gateway', [App\Http\Controllers\Api\Mobile\DeviceTokenController::class, 'setPrimaryGateway']);
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
    Route::get('/subscription/current', [\App\Http\Controllers\Api\Mobile\SubscriptionController::class, 'current']);
    Route::get('/plans', [\App\Http\Controllers\Api\Mobile\PlanController::class, 'index']);
    Route::apiResource('subscription-renewals', \App\Http\Controllers\Api\Mobile\SubscriptionRenewalController::class);
    Route::apiResource('vehicle-brands', \App\Http\Controllers\Api\Mobile\VehicleBrandController::class);
    Route::apiResource('vehicle-models', \App\Http\Controllers\Api\Mobile\VehicleModelController::class);
});
