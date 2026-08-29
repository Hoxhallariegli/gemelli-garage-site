<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\SmsLog;
use App\Models\SmsTemplate;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SmsRemindersCommand extends Command
{
    protected $signature = 'sms:reminders';
    protected $description = 'Send SMS reminders for upcoming jobs';

    public function handle(SmsService $smsService)
    {
        $upcomingTime = Carbon::now()->addMinutes(30);
        $bufferTime = Carbon::now()->addMinutes(35);

        // Find jobs starting in the next 30-35 minutes
        $jobs = Job::where('job_date', '>=', Carbon::now())
            ->where('job_date', '<=', $bufferTime)
            ->where('status', 'pending')
            ->get();

        foreach ($jobs as $job) {
            $client = $job->car?->client;
            if (!$client || !$client->phone) continue;

            // Check if reminder already sent for this job
            $exists = SmsLog::where('job_id', $job->id)
                ->where('template_type', 'reminder')
                ->exists();

            if ($exists) continue;

            $template = SmsTemplate::getTemplate('reminder') ?? "Pershendetje {name}, keni nje takim ne oren {time}. Konfirmo: {link_confirm} ose Anulo: {link_cancel}";

            $linkConfirm = route('sms.confirm', ['token' => $job->public_token]);
            $linkCancel = route('sms.cancel', ['token' => $job->public_token]);

            $message = str_replace(
                ['{name}', '{time}', '{link_confirm}', '{link_cancel}'],
                [$client->name, $job->job_date->format('H:i'), $linkConfirm, $linkCancel],
                $template
            );

            $smsService->send($client->phone, $message, 'reminder', $job->id);
            $this->info("Reminder sent for job #{$job->id} to {$client->phone}");
        }
    }
}
