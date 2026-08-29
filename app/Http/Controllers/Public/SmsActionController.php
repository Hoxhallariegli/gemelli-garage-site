<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class SmsActionController extends Controller
{
    public function confirm($token)
    {
        $job = Job::where('public_token', $token)->firstOrFail();

        if ($job->status === 'pending') {
            $job->update(['status' => 'in_progress']); // Or a specific 'confirmed' status if you add one
            return view('public.sms-action', ['status' => 'confirmed', 'job' => $job]);
        }

        return view('public.sms-action', ['status' => 'already_processed', 'job' => $job]);
    }

    public function cancel($token)
    {
        $job = Job::where('public_token', $token)->firstOrFail();

        if ($job->status === 'pending') {
            $job->update(['status' => 'cancelled']);
            return view('public.sms-action', ['status' => 'cancelled', 'job' => $job]);
        }

        return view('public.sms-action', ['status' => 'already_processed', 'job' => $job]);
    }
}
