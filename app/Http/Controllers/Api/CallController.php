<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallLog;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallController extends Controller
{
    public function log(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'type' => 'nullable|string',
        ]);

        $phoneNumber = $request->phone_number;
        // Pastrojmë numrin nga hapësirat apo karakteret shtesë
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Kontrollojmë nëse numri i përket një klienti ekzistues
        $client = Client::where('phone', 'like', '%' . substr($phoneNumber, -8) . '%')->first();

        $callLog = CallLog::create([
            'phone_number' => $phoneNumber,
            'caller_name' => $client ? $client->name : 'Unknown',
            'type' => $request->type ?? 'incoming',
            'is_client' => (bool)$client,
        ]);

        // Mund të dërgojmë një njoftim Livewire ose Toast në Dashboard këtu
        // dispatch(new \App\Events\IncomingCall($callLog));

        return response()->json([
            'success' => true,
            'message' => 'Call logged successfully',
            'is_client' => (bool)$client,
            'client_name' => $client ? $client->name : null,
        ]);
    }
}
