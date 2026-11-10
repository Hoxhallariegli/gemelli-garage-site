<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $gatewayUrl;
    protected string $secretKey;

    public function __construct()
    {
        $this->gatewayUrl = (string) config('services.whatsapp.gateway_url');
        $this->secretKey = (string) config('services.whatsapp.secret');
    }

    /**
     * Send a WhatsApp message via the Baileys Gateway microservice (Multi-Tenant Aware).
     */
    public function send(string $phone, string $message, int|string|null $tenantId = null, int|string|null $clientId = null, ?string $templateType = null): bool
    {
        if (empty($phone) || empty($message) || empty($this->gatewayUrl)) {
            Log::warning("WhatsApp send aborted: missing phone, message or gatewayUrl.");
            return false;
        }

        try {
            $payload = [
                'phone' => $phone,
                'message' => $message,
                'tenant_id' => (string) ($tenantId ?: '1'),
            ];

            $response = Http::withHeaders([
                'X-API-KEY' => $this->secretKey,
            ])->retry(2, 500)->timeout(20)->post($this->gatewayUrl, $payload);

            $isSuccess = $response->successful() && $response->json('success') === true;

            // Log message in SmsLog / MessageLog database table for audit & analytics
            try {
                if (class_exists('\App\Models\SmsLog')) {
                    \App\Models\SmsLog::create([
                        'tenant_id' => $tenantId ?: 1,
                        'client_id' => $clientId ?: null,
                        'phone' => $phone,
                        'phone_number' => $phone,
                        'message' => $message,
                        'body' => $message,
                        'status' => $isSuccess ? 'sent' : 'failed',
                        'type' => 'whatsapp',
                        'template_type' => $templateType ?: 'whatsapp',
                        'sent_at' => now(),
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning("Could not create SmsLog audit record: " . $e->getMessage());
            }

            if ($isSuccess) {
                Log::info("WhatsApp message sent successfully to {$phone} for Tenant #{$tenantId}");
                return true;
            }

            Log::warning("WhatsApp send failed for {$phone} (Tenant #{$tenantId}): " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("WhatsApp Gateway connection error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if WhatsApp Gateway is online and connected for a given tenant.
     */
    public function isConnected(int|string|null $tenantId = null): bool
    {
        if (empty($this->gatewayUrl)) return false;

        try {
            $key = "tenant_" . ($tenantId ?: '1');
            $statusUrl = str_replace('/send', '/status', $this->gatewayUrl) . '?session_key=' . $key;
            $response = Http::withHeaders([
                'X-API-KEY' => $this->secretKey,
            ])->retry(2, 300)->timeout(10)->get($statusUrl);

            return $response->successful() && $response->json('connected') === true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
