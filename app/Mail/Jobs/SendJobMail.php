<?php

namespace App\Mail\Jobs;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendJobMail extends Mailable
{
    use Queueable, SerializesModels;

    public Job $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function build(): self
    {
        $docType = $this->job->status == 'pending' ? __('jobs.quote') : __('jobs.invoice');

        return $this->to($this->job->car->client->email)
            ->subject($docType . ' - ' . config('app.name'))
            ->markdown('mail.jobs.send-job', [
                'url' => route('public.job.view', [
                    'token' => $this->job->public_token,
                    'lang' => app()->getLocale()
                ])
            ]);
    }
}
