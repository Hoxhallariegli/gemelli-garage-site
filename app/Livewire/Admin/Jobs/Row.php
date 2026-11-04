<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\Job;
use Livewire\Component;

class Row extends Component
{
    public Job $item;

    public function sendEmail($id)
    {
        $job = Job::with('car.client')->find($id);
        if (!$job) {
            $this->dispatch('toast', message: 'Puna nuk u gjet.', type: 'error');
            return;
        }

        if (!$job->car?->client?->email) {
            $this->dispatch('toast', message: 'Klienti nuk ka një adresë email të regjistruar.', type: 'error');
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::send(new \App\Mail\Jobs\SendJobMail($job));
            $job->update(['email_sent_at' => now()]);
            $this->item->email_sent_at = now();
            $this->dispatch('toast', message: 'Emaili u dërgua me sukses!', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gabim gjatë dërgimit: ' . $e->getMessage(), type: 'error');
        }
    }

    public function sendWhatsApp($id)
    {
        $job = Job::with('car.client')->find($id);
        if (!$job) {
            $this->dispatch('toast', message: 'Puna nuk u gjet.', type: 'error');
            return;
        }

        $sent = $job->sendWhatsAppNotification();

        if ($sent) {
            $this->item->whatsapp_sent_at = now();
            $this->dispatch('toast', message: 'Mesazhi u dërgua me sukses në WhatsApp!', type: 'success');
        } else {
            $this->dispatch('open-url', url: $job->whatsapp_url);
            $job->update(['whatsapp_sent_at' => now()]);
            $this->item->whatsapp_sent_at = now();
            $this->dispatch('toast', message: 'WhatsApp Gateway offline. Po hapet lidhja direkte...', type: 'warning');
        }
    }

    public function markWhatsAppSent($id)
    {
        $job = Job::find($id);
        if ($job) {
            $job->update(['whatsapp_sent_at' => now()]);
            $this->item->whatsapp_sent_at = now();
        }
    }

    public function render()
    {
        $this->item->loadMissing(['car.client', 'car.brand', 'car.model', 'services.service', 'materials.material', 'parts.part', 'payments']);
        return view('livewire.admin.jobs.row');
    }
}
