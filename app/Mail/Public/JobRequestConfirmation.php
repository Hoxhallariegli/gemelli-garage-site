<?php

namespace App\Mail\Public;

use App\Models\JobRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobRequest $jobRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Conferma Ricezione Richiesta - Gemelli Car Garage',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.public.job-request-confirmation',
        );
    }
}
