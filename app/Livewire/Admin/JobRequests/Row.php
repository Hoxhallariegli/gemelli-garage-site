<?php

namespace App\Livewire\Admin\JobRequests;

use App\Models\JobRequest;
use Livewire\Component;

class Row extends Component
{
    public JobRequest $item;

    public function sendWhatsApp()
    {
        if (!$this->item->phone) {
            $this->dispatch('toast', message: 'Kjo kërkesë nuk ka numër telefoni.', type: 'error');
            return;
        }

        try {
            $whatsapp = app(\App\Services\WhatsAppService::class);
            $brandStr = $this->item->brand ?? '';
            $modelStr = $this->item->model ?? '';
            $vehicleStr = trim("$brandStr $modelStr");
            $garageName = mb_strtoupper($this->item->garage?->name ?? 'GEMELLI GARAGE');

            $templateBody = \App\Models\SmsTemplate::getTemplate('job_request_reply');

            if ($templateBody) {
                $msg = str_replace(
                    ['{name}', '{vehicle}', '{garage}'],
                    [$this->item->name, $vehicleStr, $garageName],
                    $templateBody
                );
            } else {
                $msg = "--- {$garageName} ---\n\n" .
                       "Përshëndetje *" . $this->item->name . "*,\n\n" .
                       "Po ju kontaktojmë në lidhje me kërkesën tuaj për servis mjeti (" . $vehicleStr . ").";
            }

            $sent = $whatsapp->send(
                phone: $this->item->phone,
                message: $msg,
                tenantId: $this->item->tenant_id ?? 1
            );

            if ($sent) {
                $this->dispatch('toast', message: 'Mesazhi u dërgua me sukses në WhatsApp!', type: 'success');
            } else {
                $phone = preg_replace('/[^0-9]/', '', $this->item->phone);
                if (str_starts_with($phone, '0')) $phone = '355' . substr($phone, 1);
                $url = 'https://wa.me/' . $phone . '?' . http_build_query(['text' => $msg]);
                $this->dispatch('open-url', url: $url);
                $this->dispatch('toast', message: 'Po hapet WhatsApp...', type: 'warning');
            }
        } catch (\Throwable $e) {
            $this->dispatch('toast', message: 'Gabim: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.admin.job-requests.row');
    }
}
