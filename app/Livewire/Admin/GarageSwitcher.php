<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Garage;
use Illuminate\Support\Facades\Auth;

class GarageSwitcher extends Component
{
    public $garages;
    public $activeGarageId;

    public function mount()
    {
        $user = Auth::user();

        if ($user && $user->is_global_admin) {
            $this->garages = Garage::all();
        } elseif ($user) {
            $this->garages = Garage::where('owner_id', $user->id)
                ->orWhereHas('users', function($q) use ($user) {
                    $q->where('users.id', $user->id);
                })->get();
        } else {
            $this->garages = collect([]);
        }

        $this->activeGarageId = $user ? $user->getAttribute('tenant_id') : null;
    }

    public function switchGarage($garageId)
    {
        $user = Auth::user();
        if (!$user) return;

        $hasAccess = false;
        if ($user->is_global_admin) {
            $hasAccess = true;
        } else {
            $hasAccess = Garage::where('id', $garageId)
                ->where(function($q) use ($user) {
                    $q->where('owner_id', $user->id)
                      ->orWhereHas('users', function($qu) use ($user) {
                          $qu->where('users.id', $user->id);
                      });
                })->exists();
        }

        if ($hasAccess) {
            $user->tenant_id = $garageId;
            $user->save();

            if (function_exists('setPermissionsTeamId')) {
                setPermissionsTeamId($garageId);
            }

            $this->dispatch('toast', message: 'Garazhi u ndryshua me sukses!', type: 'success');
            return redirect(request()->header('Referer'));
        }

        $this->dispatch('toast', message: 'Nuk keni akses në këtë garazh.', type: 'error');
    }

    public function render()
    {
        return view('livewire.admin.garage-switcher');
    }
}
