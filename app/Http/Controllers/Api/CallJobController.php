<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallJob;
use App\Models\SmsDevice;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallJobController extends Controller
{
    public function store(Request $request, FirebaseService $firebase)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'consent_confirmed' => 'required|accepted',
        ]);

        $job = CallJob::create([
            'phone_number' => $request->phone_number,
            'status' => 'pending',
        ]);

        // Try to notify the active device via Firebase
        $device = SmsDevice::where('is_active', true)->first();
        if ($device) {
            $firebase->sendNotification(
                "New Call Task",
                "Call request for {$job->phone_number}",
                $device->fcm_token,
                [
                    'action' => 'START_CALL',
                    'phone' => $job->phone_number,
                    'job_id' => (string)$job->id,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'job_id' => $job->id,
            'status' => $job->status,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $job = CallJob::findOrFail($id);

        $job->update([
            'status' => $request->status,
            'error_message' => $request->error_message,
        ]);

        return response()->json(['success' => true]);
    }

    public function getNext(Request $request)
    {
        $job = CallJob::where('status', 'pending')->first();

        if ($job) {
            return response()->json($job);
        }

        return response()->json(null, 404);
    }
}
