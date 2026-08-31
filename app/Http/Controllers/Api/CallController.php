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
        Log::info('Incoming call log attempt', $request->all());

        // Heqim çdo lloj validimi bllokues
        $phoneNumber = $request->phone_number ?? 'Unknown';

        // Pastrojmë numrin
        $phoneNumber = preg_replace('/[^0-9+]/', '', (string)$phoneNumber);

        // Kontrollojmë klientin
        $client = Client::where('phone', 'like', '%' . substr($phoneNumber, -8) . '%')->first();

        CallLog::create([
            'phone_number' => $phoneNumber,
            'caller_name' => $client ? $client->name : 'Unknown',
            'type' => $request->type ?? 'incoming',
            'is_client' => (bool)$client,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Call logged',
        ]);
    }
}
