<?php

namespace App\Livewire\Admin\Users\Edit;

use App\Models\User;
use App\Models\Garage;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Garages extends Component
{
    public User $user;

    public $garageRoles = [];
    public $primaryGarageId;

    public function mount()
    {
        $this->primaryGarageId = $this->user->tenant_id;

        $currentUser = auth()->user();
        if ($currentUser && $currentUser->hasRole('admin')) {
            $allGarages = Garage::all();
        } else {
            $allGarages = Garage::where('id', $currentUser?->tenant_id)->get();
        }

        foreach ($allGarages as $garage) {
            $this->garageRoles[(int)$garage->id] = [];
        }

        $access = DB::table('model_has_roles')
            ->where('model_id', $this->user->id)
            ->where('model_type', get_class($this->user))
            ->get();

        foreach ($access as $row) {
            $gid = (int)$row->tenant_id;
            if ($gid > 0 && isset($this->garageRoles[$gid])) {
                $this->garageRoles[$gid][] = (string)$row->role_id;
            }
        }
    }

    public function updateAccess()
    {
        $currentUser = auth()->user();

        $selectedIds = collect($this->garageRoles)
            ->filter(fn($roles) => !empty($roles))
            ->keys()
            ->map(fn($id) => (int)$id)
            ->toArray();

        if (empty($selectedIds)) {
            $this->primaryGarageId = null;
        } else {
            if (!$this->primaryGarageId || !in_array((int)$this->primaryGarageId, $selectedIds)) {
                $this->primaryGarageId = $selectedIds[0];
            }
        }

        $editableGarageIds = ($currentUser && $currentUser->hasRole('admin'))
            ? Garage::pluck('id')->toArray()
            : [$currentUser?->tenant_id];

        DB::table('model_has_roles')
            ->where('model_id', $this->user->id)
            ->whereIn('tenant_id', $editableGarageIds)
            ->delete();

        foreach ($this->garageRoles as $garageId => $roleIds) {
            if (!empty($roleIds) && in_array((int)$garageId, $selectedIds)) {
                foreach ($roleIds as $roleId) {
                    DB::table('model_has_roles')->insertOrIgnore([
                        'role_id' => $roleId,
                        'model_id' => $this->user->id,
                        'model_type' => 'App\Models\User',
                        'tenant_id' => (int)$garageId
                    ]);
                }
            }
        }

        if ($currentUser && $currentUser->hasRole('admin')) {
            $this->user->garages()->sync($selectedIds);
        } else {
            if (!empty($selectedIds)) {
                $this->user->garages()->syncWithoutDetaching($selectedIds);
            }
        }

        if ($this->primaryGarageId) {
            $this->user->update(['tenant_id' => $this->primaryGarageId]);
        }

        if (function_exists('app')) {
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        $this->dispatch('toast', message: 'Akseset te Garazhet u ruajtën me sukses!', type: 'success');
    }

    public function render()
    {
        $currentUser = auth()->user();
        if ($currentUser && $currentUser->hasRole('admin')) {
            $allGarages = Garage::all();
        } else {
            $allGarages = Garage::where('id', $currentUser?->tenant_id)->get();
        }

        $rolesQuery = Role::query()->where('name', '!=', 'admin');

        return view('livewire.admin.users.edit.garages', [
            'allGarages' => $allGarages,
            'availableRoles' => $rolesQuery->get()
        ]);
    }
}
