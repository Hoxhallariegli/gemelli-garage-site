<?php

namespace App\Livewire\Admin\Garages;

use App\Models\Garage;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Modifiko Garazhin')]
class Edit extends Component
{
    public Garage $garage;
    public string $name = '';
    public string $slug = '';
    public string $phone = '';
    public string $email = '';
    public string $city = '';
    public string $address = '';
    public bool $sms_enabled = true;
    public bool $whatsapp_enabled = true;
    public int $reminder_hours_before = 2;

    public bool $wa_connected = false;
    public ?string $wa_qr = null;
    public ?string $wa_phone = null;

    public function mount(Garage $garage)
    {
        abort_if_cannot('edit_garages');

        $this->garage = $garage;
        $this->name = $garage->name;
        $this->slug = $garage->slug;
        $this->phone = $garage->phone ?? '';
        $this->email = $garage->email ?? '';
        $this->city = $garage->city ?? '';
        $this->address = $garage->address ?? '';
        $this->sms_enabled = (bool) $garage->sms_enabled;
        $this->whatsapp_enabled = (bool) $garage->whatsapp_enabled;
        $this->reminder_hours_before = (int) ($garage->reminder_hours_before ?? 2);

        $this->checkWhatsAppStatus();
    }

    public function checkWhatsAppStatus()
    {
        try {
            $garageId = $this->garage->id;
            $gatewayUrl = (string) config('services.whatsapp.gateway_url');
            if (empty($gatewayUrl)) return;

            $baseUrl = str_replace('/send', '', $gatewayUrl);

            $res = \Illuminate\Support\Facades\Http::withHeaders([
                'X-API-KEY' => (string) config('services.whatsapp.secret')
            ])->timeout(5)->get("{$baseUrl}/status?session_key=tenant_{$garageId}");

            if ($res->successful()) {
                $this->wa_connected = (bool) $res->json('connected');
                $this->wa_phone = $res->json('phone');
                if ($this->wa_connected) {
                    $this->wa_qr = null;
                }
            }
        } catch (\Throwable $e) {
            $this->wa_connected = false;
        }
    }

    public function generateWhatsAppQr()
    {
        try {
            $garageId = $this->garage->id;
            $gatewayUrl = (string) config('services.whatsapp.gateway_url');
            if (empty($gatewayUrl)) {
                $this->dispatch('toast', message: 'Mungon WHATSAPP_GATEWAY_URL te .env', type: 'error');
                return;
            }

            $baseUrl = str_replace('/send', '', $gatewayUrl);

            for ($i = 0; $i < 3; $i++) {
                $res = \Illuminate\Support\Facades\Http::withHeaders([
                    'X-API-KEY' => (string) config('services.whatsapp.secret')
                ])->timeout(10)->get("{$baseUrl}/qr?session_key=tenant_{$garageId}");

                if ($res->successful()) {
                    $this->wa_connected = (bool) $res->json('connected');
                    $this->wa_qr = $res->json('qr');
                    if ($this->wa_connected || $this->wa_qr) {
                        break;
                    }
                }
                sleep(1);
            }

            if ($this->wa_connected) {
                $this->dispatch('toast', message: 'WhatsApp është tashmë i lidhur!', type: 'success');
            } elseif ($this->wa_qr) {
                $this->dispatch('toast', message: 'QR Code u gjenerua me sukses! Skanojeni me telefon.', type: 'success');
            } else {
                $this->dispatch('toast', message: 'Duke inicializuar QR Code-in... Klikoni përsëri pas disa sekondash.', type: 'info');
            }
        } catch (\Throwable $e) {
            $this->dispatch('toast', message: 'WhatsApp Gateway nuk i përgjigjet në server.', type: 'error');
        }
    }

    public function save()
    {
        abort_if_cannot('edit_garages');

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:garages,slug,' . $this->garage->id,
        ]);

        $this->garage->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'phone' => $this->phone,
            'email' => $this->email,
            'city' => $this->city,
            'address' => $this->address,
            'sms_enabled' => $this->sms_enabled,
            'whatsapp_enabled' => $this->whatsapp_enabled,
            'reminder_hours_before' => $this->reminder_hours_before,
        ]);

        $this->dispatch('toast', message: 'Të dhënat e garazhit u përditësuan.', type: 'success');
        return redirect()->route('admin.garages.index');
    }

    public function render()
    {
        abort_if_cannot('edit_garages');

        return view('livewire.admin.garages.edit')->layout('components.layouts.app');
    }
}
