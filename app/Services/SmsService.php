<?php

namespace App\Services;

use App\Models\SmsDevice;
use App\Models\SmsLog;
use App\Models\SmsTemplate;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function send(string $phone, string $body, string $type = 'promotional', ?int $jobId = null)
    {
        $smsLog = SmsLog::create([
            'phone_number' => $phone,
            'body' => $body,
            'status' => 'pending',
            'template_type' => $type,
            'job_id' => $jobId,
        ]);

        return $this->dispatchToGateway($smsLog);
    }

    public function dispatchToGateway(SmsLog $smsLog)
    {
        $device = SmsDevice::where('is_active', true)->first();

        if (!$device) {
            Log::warning('No active SMS Gateway device found.');
            return false;
        }

        $data = [
            'action' => 'SEND_SMS',
            'phone' => $smsLog->phone_number,
            'body' => $smsLog->body,
            'sms_id' => $smsLog->id,
        ];

        // We use the existing sendNotification but we'll need to make sure it handles data correctly
        // For now, I'll update FirebaseService to support pure data messages
        $messageId = $this->firebase->sendData($device->fcm_token, $data);

        if ($messageId) {
            $smsLog->update([
                'status' => 'queued',
                'fcm_message_id' => $messageId
            ]);
        }

        return (bool) $messageId;
    }
}
