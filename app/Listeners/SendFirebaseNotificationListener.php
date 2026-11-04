<?php

namespace App\Listeners;

use App\Services\FirebaseService;
use App\Services\WhatsAppService;
use App\Models\DeviceToken;
use Illuminate\Support\Facades\Log;

class SendFirebaseNotificationListener
{
    protected FirebaseService $firebaseService;
    protected WhatsAppService $whatsAppService;

    public function __construct(FirebaseService $firebaseService, WhatsAppService $whatsAppService)
    {
        $this->firebaseService = $firebaseService;
        $this->whatsAppService = $whatsAppService;
    }

    public function handle(object $event): void
    {
        try {
            $action = $event->action ?? 'created';
            $eventName = $event->event ?? 'notification';
            $modelClass = $event->modelClass ?? '';
            $modelId = $event->modelId ?? 0;

            $title = "Njoftim Gemelli Garage";
            $body = "Ka një përditësim të ri [{$action}] në sistem për modelin {$modelClass} #{$modelId}.";

            // Push Notification to all company devices / tokens
            $customData = [
                'event' => $eventName,
                'action' => $action,
                'model' => $modelClass,
                'model_id' => (string) $modelId,
            ];

            $sentCount = $this->firebaseService->sendToCompany(null, $title, $body, $customData);
            Log::info("🔔 [SendFirebaseNotificationListener] FCM Push sent to {$sentCount} devices for event [{$eventName}].");
        } catch (\Throwable $e) {
            Log::error("❌ [SendFirebaseNotificationListener Error]: " . $e->getMessage());
        }
    }
}
