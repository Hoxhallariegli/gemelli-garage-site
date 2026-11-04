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

    public function mount(Garage $garage)
    {
        $this->garage = $garage;
        $this->name = $garage->name;
        $this->slug = $garage->slug;
        $this->phone = $garage->phone ?? '';
        $this->email = $garage->email ?? '';
        $this->city = $garage->city ?? '';
        $this->address = $garage->address ?? '';
        $this->sms_enabled = $garage->sms_enabled;
        $this->whatsapp_enabled = $garage->whatsapp_enabled;
        $this->reminder_hours_before = $garage->reminder_hours_before;
    }

    public function save()
    {
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
        return view('livewire.admin.garages.edit')->layout('components.layouts.app');
    }
}
