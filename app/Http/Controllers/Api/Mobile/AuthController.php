<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning("Login attempt failed: User not found with email {$request->email}");
            throw ValidationException::withMessages([
                'email' => ['Përdoruesi nuk ekziston.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::warning("Login attempt failed: Password mismatch for user {$request->email}");
            throw ValidationException::withMessages([
                'email' => ['Fjalëkalimi është i gabuar.'],
            ]);
        }

        if (!$user->is_active) {
            Log::warning("Login attempt failed: User account is inactive for {$request->email}");
            throw ValidationException::withMessages([
                'email' => ['Llogaria juaj nuk është aktive. Ju lutem kontaktoni admin-in.'],
            ]);
        }

        Log::info("Login successful for user {$request->email} on device {$request->device_name}");

        // FCM Token Registration on Login
        if ($request->filled('fcm_token')) {
            try {
                \App\Models\DeviceToken::where('fcm_token', $request->fcm_token)->delete();
                \App\Models\DeviceToken::create([
                    'fcm_token' => $request->fcm_token,
                    'user_id' => $user->id,
                    'tenant_id' => $user->tenant_id ?? null,
                    'platform' => $request->input('platform', 'android'),
                    'device_name' => $request->device_name,
                    'last_used_at' => now(),
                ]);
            } catch (\Throwable $e) {
                Log::warning("FCM Token save error during login: " . $e->getMessage());
            }
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tenant_id' => $user->tenant_id ?? null,
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true]);
    }
}
