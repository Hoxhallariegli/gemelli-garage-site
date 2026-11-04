<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DeviceTokenController extends Controller
{
    public function saveWebToken(Request $request): JsonResponse
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'platform' => 'nullable|string',
            'device_name' => 'nullable|string',
            'tenant_id' => 'nullable|integer',
        ]);

        $user = $request->user() ?: auth()->user() ?: auth('sanctum')->user();
        if (!$user && $request->filled('user_id')) {
            $user = \App\Models\User::find($request->input('user_id'));
        }

        $fcmToken = $request->input('fcm_token');
        $platform = $request->input('platform', 'android');
        $deviceName = $request->input('device_name', 'Mobile Device');

        if ($user && $user->name && !str_contains($deviceName, $user->name)) {
            $deviceName .= " - " . $user->name;
        }

        $tenantId = $request->input('tenant_id')
            ?: ($user?->tenant_id ?? null);

        try {
            $isGateway = $request->has('is_sms_gateway')
                ? $request->boolean('is_sms_gateway')
                : (DeviceToken::where('fcm_token', $fcmToken)->value('is_sms_gateway') ?? false);

            DeviceToken::where('fcm_token', $fcmToken)->delete();

            $deviceToken = DeviceToken::create([
                'fcm_token' => $fcmToken,
                'tenant_id' => $tenantId,
                'user_id' => $user?->id,
                'platform' => in_array($platform, ['android', 'ios', 'web']) ? $platform : 'android',
                'is_sms_gateway' => (bool) $isGateway,
                'device_name' => $deviceName,
                'last_used_at' => now(),
            ]);

            Log::info('FCM Token successfully saved to DB', ['device_token_id' => $deviceToken->id]);

            return response()->json([
                'success' => true,
                'message' => 'Token-i i pajisjes u regjistrua me sukses!',
                'data' => $deviceToken,
            ]);
        } catch (\Throwable $e) {
            Log::error('FCM saveWebToken DB Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Dështoi ruajtja e token-it: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function setPrimaryGateway(Request $request): JsonResponse
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'is_sms_gateway' => 'required|boolean',
            'device_name' => 'nullable|string',
            'tenant_id' => 'nullable|integer',
        ]);

        $user = $request->user() ?: auth()->user();
        $fcmToken = $request->input('fcm_token');
        $isSmsGateway = $request->boolean('is_sms_gateway');
        $tenantId = $request->input('tenant_id') ?: ($user?->tenant_id ?? null);

        try {
            if ($isSmsGateway) {
                if ($tenantId) {
                    DeviceToken::where('tenant_id', $tenantId)->update(['is_sms_gateway' => false]);
                }

                DeviceToken::where('fcm_token', $fcmToken)->delete();

                $deviceToken = DeviceToken::create([
                    'fcm_token' => $fcmToken,
                    'tenant_id' => $tenantId,
                    'user_id' => $user?->id,
                    'platform' => $request->input('platform', 'android'),
                    'is_sms_gateway' => true,
                    'device_name' => $request->input('device_name', 'Android Device'),
                    'last_used_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'is_sms_gateway' => true,
                    'message' => 'Kjo pajisje u caktua si SMS Gateway kryesor.',
                    'data' => $deviceToken,
                ]);
            } else {
                DeviceToken::where('fcm_token', $fcmToken)->update(['is_sms_gateway' => false]);
                return response()->json([
                    'success' => true,
                    'is_sms_gateway' => false,
                    'message' => 'Pajisja u çaktivizua nga roli SMS Gateway.',
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('FCM setPrimaryGateway DB Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Dështoi ruajtja e SMS Gateway: ' . $e->getMessage(),
            ], 500);
        }
    }
}
