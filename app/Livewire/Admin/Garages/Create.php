<?php

namespace App\Livewire\Admin\Garages;

use App\Models\Garage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Shto Garazh të Ri')]
class Create extends Component
{
    public string $name = '';
    public string $slug = '';
    public string $phone = '';
    public string $email = '';
    public string $city = '';
    public string $address = '';
    public bool $sms_enabled = true;
    public bool $whatsapp_enabled = true;
    public int $reminder_hours_before = 2;

    public function updatedName($val)
    {
        $this->slug = Str::slug($val);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:garages,slug',
        ]);

        $garage = Garage::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'owner_id' => auth()->id(),
            'phone' => $this->phone,
            'email' => $this->email,
            'city' => $this->city,
            'address' => $this->address,
            'sms_enabled' => $this->sms_enabled,
            'whatsapp_enabled' => $this->whatsapp_enabled,
            'reminder_hours_before' => $this->reminder_hours_before,
            'active' => true,
        ]);

        // Attach owner to garage_user pivot
        $garage->users()->attach(auth()->id());

        // Auto-set as active garage for the user if they don't have one
        if (!auth()->user()->tenant_id) {
            auth()->user()->update(['tenant_id' => $garage->id]);
        }

        $this->dispatch('toast', message: 'Garazhi u regjistrua me sukses!', type: 'success');
        return redirect()->route('admin.garages.index');
    }

    public function render()
    {
        return view('livewire.admin.garages.create')->layout('components.layouts.app');
    }
}
